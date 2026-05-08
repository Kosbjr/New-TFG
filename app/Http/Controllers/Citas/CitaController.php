<?php
namespace App\Http\Controllers\Citas;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Centro;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->rol === 'centro') {
            $centro = Centro::where('usuario_id', $user->id)->firstOrFail();
            $citas  = Cita::where('centro_id', $centro->id)
                          ->with(['usuario', 'servicio'])
                          ->orderBy('fecha')->orderBy('hora')
                          ->get();
        } else {
            $citas = Cita::where('usuario_id', $user->id)
                         ->with(['centro', 'servicio'])
                         ->orderBy('fecha')->orderBy('hora')
                         ->get();
        }

        return view('citas.index', compact('citas', 'user'));
    }

    public function create($id)
    {
        $centro = Centro::with(['servicios', 'horarios'])->findOrFail($id);
        $huecos = $this->generarHuecos($centro);
        return view('citas.create', compact('centro', 'huecos'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'servicio_id' => 'required|exists:servicios,id',
            'fecha'       => 'required|date|after_or_equal:today',
            'hora'        => 'required',
            'notas'       => 'nullable|string|max:500',
        ]);

        $ocupado = Cita::where('centro_id', $id)
                       ->where('fecha', $request->fecha)
                       ->where('hora', $request->hora)
                       ->whereIn('estado', ['pendiente', 'confirmada'])
                       ->exists();

        if ($ocupado) {
            return back()->withErrors(['hora' => 'Este horario ya está reservado.']);
        }

        Cita::create([
            'usuario_id'  => Auth::id(),
            'centro_id'   => $id,
            'servicio_id' => $request->servicio_id,
            'fecha'       => $request->fecha,
            'hora'        => $request->hora,
            'estado'      => 'pendiente',
            'notas'       => $request->notas,
        ]);

        return redirect()->route('citas')->with('success', 'Cita solicitada correctamente.');
    }

    public function updateEstado(Request $request, $id)
    {
        $cita   = Cita::findOrFail($id);
        $centro = Centro::where('usuario_id', Auth::id())->firstOrFail();
        abort_if($cita->centro_id !== $centro->id, 403);

        $request->validate(['estado' => 'required|in:confirmada,cancelada']);
        $cita->update(['estado' => $request->estado]);

        return back()->with('success', 'Estado actualizado.');
    }

    private function generarHuecos(Centro $centro): array
    {
        $huecos = [];
        $dias   = collect($centro->horarios)->groupBy('dia_semana');

        for ($i = 0; $i < 14; $i++) {
            $fecha     = Carbon::today()->addDays($i);
            $diaSemana = $fecha->dayOfWeek === 0 ? 6 : $fecha->dayOfWeek - 1;

            if (!$dias->has($diaSemana)) continue;

            foreach ($dias[$diaSemana] as $horario) {
                $inicio = Carbon::parse($horario->hora_inicio);
                $fin    = Carbon::parse($horario->hora_fin);

                while ($inicio < $fin) {
                    $ocupado = Cita::where('centro_id', $centro->id)
                                   ->where('fecha', $fecha->toDateString())
                                   ->where('hora', $inicio->format('H:i'))
                                   ->whereIn('estado', ['pendiente', 'confirmada'])
                                   ->exists();

                    if (!$ocupado) {
                        $huecos[$fecha->toDateString()][] = $inicio->format('H:i');
                    }

                    $inicio->addMinutes($horario->intervalo_minutos);
                }
            }
        }

        return $huecos;
    }
}

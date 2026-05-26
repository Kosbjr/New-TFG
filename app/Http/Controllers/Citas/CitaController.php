<?php

namespace App\Http\Controllers\Citas;

use App\Actions\Citas\ObtenerCitasAction;
use App\Actions\Citas\GenerarHuecosAction;
use App\Actions\Citas\CrearCitaAction;
use App\Actions\Citas\ActualizarEstadoCitaAction;
use App\DTOs\Citas\CrearCitaDTO;
use App\DTOs\Citas\ActualizarEstadoCitaDTO;
use App\Http\Controllers\Controller;
use App\Models\Centro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    public function __construct(
        protected ObtenerCitasAction         $obtenerCitasAction,
        protected GenerarHuecosAction        $generarHuecosAction,
        protected CrearCitaAction            $crearCitaAction,
        protected ActualizarEstadoCitaAction $actualizarEstadoCitaAction,
    ) {}

    public function index()
    {
        $user  = Auth::user();
        $citas = $this->obtenerCitasAction->execute($user->id, $user->rol);

        return view('citas.index', compact('citas', 'user'));
    }

    public function create(int $id)
    {
        $centro = Centro::with(['servicios', 'horarios'])->findOrFail($id);
        $huecos = $this->generarHuecosAction->execute($centro);

        return view('citas.create', compact('centro', 'huecos'));
    }

    public function store(Request $request, int $id)
    {
        $request->validate([
            'servicio_id' => 'required|exists:servicios,id',
            'fecha'       => 'required|date|after_or_equal:today',
            'hora'        => 'required',
            'notas'       => 'nullable|string|max:500',
        ]);

        $dto = CrearCitaDTO::fromArray(Auth::id(), $id, $request->only([
            'servicio_id', 'fecha', 'hora', 'notas'
        ]));

        $creada = $this->crearCitaAction->execute($dto);

        if (!$creada) {
            return back()->withErrors([
                'hora' => 'Este horario o parte de él ya se encuentra ocupado por otro servicio.'
            ]);
        }

        return redirect()->route('citas')->with('success', 'Cita solicitada correctamente.');
    }

    public function updateEstado(Request $request, int $id)
    {
        $request->validate([
            'estado' => 'required|in:confirmada,cancelada'
        ]);

        $dto = ActualizarEstadoCitaDTO::fromArray([
            'cita_id'    => $id,
            'usuario_id' => Auth::id(),
            'estado'     => $request->estado,
        ]);

        $this->actualizarEstadoCitaAction->execute($dto);

        return back()->with('success', 'Estado actualizado.');
    }
}

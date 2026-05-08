<?php
namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use App\Models\Centro;
use App\Models\HorarioDisponible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller
{
    public function index()
{
    $centro = Centro::where('usuario_id', Auth::id())
                    ->with(['servicios', 'horarios', 'categorias'])
                    ->firstOrFail();

    $categorias = \App\Models\Categoria::all();

    return view('centros.servicios', compact('centro', 'categorias'));
}

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'precio'      => 'required|numeric|min:0',
            'duracion'    => 'required|integer|min:15',
        ]);

        $centro = Centro::where('usuario_id', Auth::id())->firstOrFail();
        $centro->servicios()->create($request->only(['nombre', 'descripcion', 'precio', 'duracion']));

        return back()->with('success', 'Servicio añadido.');
    }

    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);
        abort_if($servicio->centro->usuario_id !== Auth::id(), 403);
        $servicio->delete();
        return back()->with('success', 'Servicio eliminado.');
    }

    public function storeHorario(Request $request)
    {
        $request->validate([
            'dia_semana'        => 'required|integer|between:0,6',
            'hora_inicio'       => 'required|date_format:H:i',
            'hora_fin'          => 'required|date_format:H:i|after:hora_inicio',
            'intervalo_minutos' => 'required|integer|min:15',
        ]);

        $centro = Centro::where('usuario_id', Auth::id())->firstOrFail();
        $centro->horarios()->create($request->all());

        return back()->with('success', 'Horario añadido.');
    }

    public function destroyHorario($id)
    {
        $horario = HorarioDisponible::findOrFail($id);
        abort_if($horario->centro->usuario_id !== Auth::id(), 403);
        $horario->delete();
        return back()->with('success', 'Horario eliminado.');
    }
}

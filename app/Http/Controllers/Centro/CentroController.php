<?php

namespace App\Http\Controllers\Centro;

use App\Actions\Admin\Categoria\ObtenerCategoriaAction;
use App\Actions\Centro\ActualizarCentroAction;
use App\Actions\Centro\EliminarFotoCentroAction;
use App\Actions\Centro\MostrarCentroAction;
use App\Actions\Centro\ObtenerCentroEditableAction;
use App\DTOs\Centro\ActualizarCentroDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Centro\UpdateCentroRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CentroController extends Controller
{
    public function __construct(
        protected ObtenerCentroEditableAction $obtenerCentroEditableAction,
        protected ActualizarCentroAction $actualizarCentroAction,
        protected MostrarCentroAction $mostrarCentroAction,
        protected EliminarFotoCentroAction $eliminarFotoCentroAction,
        protected ObtenerCategoriaAction $obtenerCategoriaAction,
    ) {}

    public function edit()
    {
        $centro = $this
            ->obtenerCentroEditableAction
            ->execute(Auth::id());

        $categorias = $this
            ->obtenerCategoriaAction
            ->execute();

        return view(
            'centros.editar',
            compact(
                'centro',
                'categorias'
            )
        );
    }

    public function update(UpdateCentroRequest $request)
{
    $data = $request->validated();

    $data['fotos'] = $request->file('fotos', []);

    $dto = ActualizarCentroDTO::fromArray($data);

    $this->actualizarCentroAction->execute(
        Auth::id(),
        $dto
    );

    return redirect()->route('home')
        ->with('success', 'Información actualizada correctamente.');
}

    public function show(int $id)
    {
        $centro = $this
            ->mostrarCentroAction
            ->execute($id);

        return view(
            'centros.show',
            compact('centro')
        );
    }

    public function eliminarFoto(int $id)
    {
        $this
            ->eliminarFotoCentroAction
            ->execute(
                $id,
                Auth::id()
            );

        return back()->with(
            'success',
            'Foto eliminada.'
        );
    }
    public function updateCategorias(Request $request)
    {
        $request->validate([
            'categorias'   => 'nullable|array',
            'categorias.*' => 'exists:categorias,id',
        ]);

        $centro = \App\Models\Centro::where('usuario_id', Auth::id())
            ->firstOrFail();

        $centro->categorias()->sync($request->categorias ?? []);

        return back()->with('success', 'Categorías actualizadas.');
    }
}

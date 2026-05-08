<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Categoria\CrearCategoriaAction;
use App\Actions\Admin\Categoria\EliminarCategoriaAction;
use App\Actions\Admin\Categoria\ObtenerCategoriaAction;
use App\DTOs\Categoria\CategoriaDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoriaRequest;

class CategoriaController extends Controller
{
    public function __construct(
        protected ObtenerCategoriaAction $obtenerCategoriaAction,
        protected CrearCategoriaAction $crearCategoriaAction,
        protected EliminarCategoriaAction $eliminarCategoriaAction,
    ) {}

    public function categorias()
    {
        $categorias = $this
            ->obtenerCategoriaAction
            ->execute();

        return view(
            'admin.categorias',
            compact('categorias')
        );
    }

    public function storeCategoria(
        StoreCategoriaRequest $request
    )
    {
        $dto = CategoriaDTO::fromArray(
            $request->validated()
        );

        $this
            ->crearCategoriaAction
            ->execute($dto);

        return back()->with(
            'success',
            'Categoría creada.'
        );
    }

    public function destroyCategoria(int $id)
    {
        $this
            ->eliminarCategoriaAction
            ->execute($id);

        return back()->with(
            'success',
            'Categoría eliminada.'
        );
    }
}

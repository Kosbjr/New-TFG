<?php

namespace App\Actions\Admin\Categoria;

use App\Services\CategoriaService;

class ObtenerCategoriaAction
{
    public function __construct(
        protected CategoriaService $service
    ) {}

    public function execute()
    {
        return $this->service->obtenerCategorias();
    }
}

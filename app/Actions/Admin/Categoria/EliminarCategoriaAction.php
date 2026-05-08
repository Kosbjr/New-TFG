<?php

namespace App\Actions\Admin\Categoria;

use App\Services\CategoriaService;

class EliminarCategoriaAction
{
    public function __construct(
        protected CategoriaService $service
    ) {}

    public function execute(int $id): void
    {
        $this->service->eliminarCategoria($id);
    }
}

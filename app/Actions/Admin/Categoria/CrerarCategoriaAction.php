<?php

namespace App\Actions\Admin\Categoria;

use App\DTOs\Categoria\CategoriaDTO;
use App\Services\CategoriaService;

class CrearCategoriaAction
{
    public function __construct(
        protected CategoriaService $service
    ) {}

    public function execute(CategoriaDTO $dto)
    {
        return $this->service->crearCategoria($dto);
    }
}

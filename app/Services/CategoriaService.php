<?php

namespace App\Services;

use App\DTOs\Categoria\CategoriaDTO;
use App\Repositories\CategoriaRepository;

class CategoriaService
{
    public function __construct(
        protected CategoriaRepository $repository
    ) {}

    public function obtenerCategorias()
    {
        return $this->repository->obtenerTodas();
    }

    public function crearCategoria(CategoriaDTO $dto)
    {
        return $this->repository->crear($dto);
    }

    public function eliminarCategoria(int $id): void
    {
        $this->repository->eliminar($id);
    }
}

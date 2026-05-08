<?php

namespace App\Repositories;

use App\DTOs\Categoria\CategoriaDTO;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Collection;

class CategoriaRepository
{
    public function obtenerTodas(): Collection
    {
        return Categoria::withCount('centros')->get();
    }

    public function crear(CategoriaDTO $dto): Categoria
    {
        return Categoria::create([
            'nombre' => $dto->nombre,
            'icono' => $dto->icono,
            'slug' => $dto->slug,
        ]);
    }

    public function eliminar(int $id): void
    {
        Categoria::findOrFail($id)->delete();
    }
}

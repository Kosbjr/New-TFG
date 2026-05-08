<?php

namespace App\Repositories;

use App\Models\FotoCentro;

class FotoCentroRepository
{
    public function obtenerPorId(int $id): FotoCentro
    {
        return FotoCentro::with('centro')
            ->findOrFail($id);
    }
}

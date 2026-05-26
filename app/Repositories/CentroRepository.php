<?php

namespace App\Repositories;

use App\Models\Centro;

class CentroRepository
{
    public function obtenerPorUsuario(
        int $usuarioId
    ): ?Centro {

        return Centro::where(
            'usuario_id',
            $usuarioId
        )
            ->with('fotos')
            ->first();
    }

    public function obtenerPorId(int $id): Centro
    {
        return Centro::with(['fotos', 'categorias', 'favoritoDe'])
            ->findOrFail($id);
    }

    public function actualizarOCrear(
        int $usuarioId,
        array $data
    ): Centro {

        return Centro::updateOrCreate(
            [
                'usuario_id' => $usuarioId
            ],
            $data
        );
    }

    public function sincronizarCategorias(
        Centro $centro,
        array $categorias
    ): void {

        $centro->categorias()
            ->sync($categorias);
    }
}

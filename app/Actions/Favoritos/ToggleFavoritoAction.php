<?php

namespace App\Actions\Favoritos;

use App\Models\Favorito;

class ToggleFavoritoAction
{
    public function execute(int $usuarioId, int $centroId): bool
    {
        $existe = Favorito::where('usuario_id', $usuarioId)
            ->where('centro_id', $centroId)
            ->first();

        if ($existe) {
            $existe->delete();
            return false;
        }

        Favorito::create([
            'usuario_id' => $usuarioId,
            'centro_id'  => $centroId,
        ]);

        return true;
    }
}

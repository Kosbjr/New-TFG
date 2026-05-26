<?php

namespace App\Actions\Home;

use App\Models\Centro;

class ObtenerCentroDelUsuarioAction
{
    public function execute(int $usuarioId): ?Centro
    {
        return Centro::where('usuario_id', $usuarioId)
            ->with(['fotos', 'categorias'])
            ->first();
    }
}

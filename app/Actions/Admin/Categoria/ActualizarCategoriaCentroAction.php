<?php

namespace App\Actions\Centro;

use App\Models\Centro;
use Illuminate\Support\Facades\Auth;

class ActualizarCategoriaCentroAction
{
    public function execute(int $usuarioId, array $categorias): void
    {
        $centro = Centro::where('usuario_id', $usuarioId)->firstOrFail();

        $centro->categorias()->sync($categorias);
    }
}

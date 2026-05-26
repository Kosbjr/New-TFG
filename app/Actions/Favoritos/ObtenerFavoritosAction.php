<?php

namespace App\Actions\Favoritos;

use App\Models\Favorito;
use Illuminate\Support\Collection;

class ObtenerFavoritosAction
{
    public function execute(int $usuarioId): Collection
    {
        return Favorito::where('usuario_id', $usuarioId)
            ->with(['centro.fotos', 'centro.categorias'])
            ->get();
    }
}

<?php

namespace App\Actions\Home;

use App\Models\Centro;
use Illuminate\Support\Collection;

class ObtenerCentrosClienteAction
{
    public function execute(?string $categoria, ?string $buscar): Collection
    {
        return Centro::latest()
            ->with(['fotos', 'categorias'])
            ->when($categoria, function ($q) use ($categoria) {
                $q->whereHas('categorias', function ($q) use ($categoria) {
                    $q->where('slug', $categoria);
                });
            })
            ->when($buscar, function ($q) use ($buscar) {
                $q->where(function ($subquery) use ($buscar) {
                    $subquery->where('nombre', 'like', '%' . $buscar . '%')
                             ->orWhere('descripcion', 'like', '%' . $buscar . '%');
                });
            })
            ->take(12)
            ->get();
    }
}

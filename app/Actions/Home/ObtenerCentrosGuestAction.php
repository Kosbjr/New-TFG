<?php

namespace App\Actions\Home;

use App\Models\Centro;
use Illuminate\Support\Collection;

class ObtenerCentrosGuestAction
{
    public function execute(?string $buscar): Collection
    {
        return Centro::latest()
            ->with('fotos')
            ->when($buscar, function ($q) use ($buscar) {
                $q->where('nombre', 'like', '%' . $buscar . '%')
                  ->orWhere('descripcion', 'like', '%' . $buscar . '%');
            })
            ->take(6)
            ->get();
    }
}

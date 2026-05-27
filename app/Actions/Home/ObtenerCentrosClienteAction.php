<?php

namespace App\Actions\Home;

use App\Models\Centro;
use Illuminate\Support\Collection;

class ObtenerCentrosClienteAction
{
    /**
     * Ejecuta la filtración estricta de centros para el cliente.
     * * @param array $categorias Slugs de las categorías obligatorias combinadas
     * @param string|null $buscar Término de búsqueda por texto
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function execute(array $categorias, ?string $buscar, ?string $ciudad)
    {
        $query = Centro::query();

        // Filtro por Comunidad Autónoma usando la nueva columna
        if ($ciudad) {
            $query->where('comunidad_autonoma', $ciudad);
        }

        // Filtro Combinado Estricto de Categorías
        if (!empty($categorias)) {
            foreach ($categorias as $slug) {
                $query->whereHas('categorias', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                });
            }
        }

        // Filtro de búsqueda por texto
        if ($buscar) {
            $query->where('nombre', 'LIKE', "%{$buscar}%");
        }

        return $query->with(['fotos', 'categorias'])->get();
    }
}

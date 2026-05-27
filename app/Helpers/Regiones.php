<?php

namespace App\Helpers;

class Regiones
{
    /**
     * Devuelve el listado completo de Comunidades Autónomas de España.
     *
     * @return array<string, string>
     */
    public static function comunidades(): array
    {
        return [
            'andalucia'            => 'Andalucía',
            'aragon'               => 'Aragón',
            'asturias'             => 'Principado de Asturias',
            'baleares'             => 'Islas Baleares',
            'canarias'             => 'Canarias',
            'cantabria'            => 'Cantabria',
            'castilla-la-mancha'   => 'Castilla-La Mancha',
            'castilla-y-leon'      => 'Castilla y León',
            'cataluna'             => 'Cataluña',
            'comunidad-valenciana' => 'Comunidad Valenciana',
            'extremadura'          => 'Extremadura',
            'galicia'              => 'Galicia',
            'madrid'               => 'Comunidad de Madrid',
            'murcia'               => 'Región de Murcia',
            'navarra'              => 'Comunidad Foral de Navarra',
            'pais-vasco'           => 'País Vasco',
            'la-rioja'             => 'La Rioja',
            'ceuta'                => 'Ceuta',
            'melilla'              => 'Melilla',
        ];
    }
}

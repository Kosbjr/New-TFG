<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
    ['nombre' => 'Peluquería',   'icono' => 'bi-scissors',        'slug' => 'peluqueria'],
    ['nombre' => 'Estética',     'icono' => 'bi-stars',           'slug' => 'estetica'],
    ['nombre' => 'Fisioterapia', 'icono' => 'bi-heart-pulse',     'slug' => 'fisioterapia'],
    ['nombre' => 'Masajes',      'icono' => 'bi-hand-index',      'slug' => 'masajes'],
    ['nombre' => 'Barbería',     'icono' => 'bi-person-badge',    'slug' => 'barberia'],
    ['nombre' => 'Uñas',         'icono' => 'bi-gem',             'slug' => 'unas'],
    ['nombre' => 'Maquillaje',   'icono' => 'bi-palette',         'slug' => 'maquillaje'],
];

        foreach ($categorias as $categoria) {
            DB::table('categorias')->insertOrIgnore($categoria);
        }
    }
}

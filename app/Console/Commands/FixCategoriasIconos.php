<?php

namespace App\Console\Commands;

use App\Models\Categoria;
use Illuminate\Console\Command;

class FixCategoriasIconos extends Command
{
    protected $signature   = 'categorias:fix-iconos';
    protected $description = 'Reemplaza emojis por clases de Bootstrap Icons';

    public function handle()
    {
        $mapa = [
            '✂️'  => 'bi-scissors',
            '💅'  => 'bi-stars',
            '🏋️' => 'bi-heart-pulse',
            '💆'  => 'bi-hand-index',
            '💈'  => 'bi-person-badge',
            '💎'  => 'bi-gem',
            '💄'  => 'bi-palette',
        ];

        foreach ($mapa as $emoji => $clase) {
            $updated = Categoria::where('icono', $emoji)->update(['icono' => $clase]);
            $this->info("$emoji → $clase ($updated filas)");
        }

        $this->info('¡Listo!');
    }
}

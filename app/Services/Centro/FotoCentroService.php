<?php

namespace App\Services\Centro;

use App\Models\Centro;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FotoCentroService
{
    public function guardarFotos(
        Centro $centro,
        array $fotos
    ): void {
        $orden = $centro->fotos()->count();

        foreach ($fotos as $foto) {

            $ruta = $foto->store(
                'centros',
                'public'
            );

            $centro->fotos()->create([
                'ruta' => $ruta,
                'orden' => $orden++,
            ]);
        }
    }

    public function eliminarFoto($foto): void
    {
        Storage::disk('public')->delete(
            $foto->ruta
        );

        $foto->delete();
    }
}

<?php

namespace App\Actions\Centro;

use App\DTOs\Centro\ActualizarCentroDTO;
use App\Repositories\CentroRepository;
use App\Services\Centro\FotoCentroService;

class ActualizarCentroAction
{
    public function __construct(
        protected CentroRepository $repository,
        protected FotoCentroService $fotoService,
    ) {}

    public function execute(
        int $usuarioId,
        ActualizarCentroDTO $dto,

    ) {
        $centro = $this->repository
            ->actualizarOCrear(
                $usuarioId,
                [
                    'nombre' => $dto->nombre,
                    'direccion' => $dto->direccion,
                    'ubicacion' => $dto->ubicacion,
                    'telefono' => $dto->telefono,
                    'descripcion' => $dto->descripcion,
                    'comunidad_autonoma' => $dto->comunidad_autonoma,
                ]
            );

        if (!empty($dto->fotos)) {

            $this->fotoService
                ->guardarFotos(
                    $centro,
                    $dto->fotos
                );
        }

        return $centro;
    }
}

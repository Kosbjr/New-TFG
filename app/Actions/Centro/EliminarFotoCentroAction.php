<?php

namespace App\Actions\Centro;

use App\Repositories\FotoCentroRepository;
use App\Services\Centro\FotoCentroService;

class EliminarFotoCentroAction
{
    public function __construct(
        protected FotoCentroRepository $repository,
        protected FotoCentroService $service,
    ) {}

    public function execute(
        int $fotoId,
        int $usuarioId
    ): void {

        $foto = $this->repository
            ->obtenerPorId($fotoId);

        abort_if(
            $foto->centro->usuario_id !== $usuarioId,
            403
        );

        $this->service
            ->eliminarFoto($foto);
    }
}

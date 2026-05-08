<?php

namespace App\Actions\Centro;

use App\Repositories\CentroRepository;

class ObtenerCentroEditableAction
{
    public function __construct(
        protected CentroRepository $repository
    ) {}

    public function execute(int $usuarioId)
    {
        return $this->repository
            ->obtenerPorUsuario($usuarioId);
    }
}

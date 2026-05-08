<?php

namespace App\Actions\Centro;

use App\Repositories\CentroRepository;

class MostrarCentroAction
{
    public function __construct(
        protected CentroRepository $repository
    ) {}

    public function execute(int $id)
    {
        return $this->repository
            ->obtenerPorId($id);
    }
}

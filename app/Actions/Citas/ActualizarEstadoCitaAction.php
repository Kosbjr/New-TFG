<?php

namespace App\Actions\Citas;

use App\DTOs\Citas\ActualizarEstadoCitaDTO;
use App\Services\Citas\CitaService;

class ActualizarEstadoCitaAction
{
    public function __construct(
        protected CitaService $citaService
    ) {}

    public function execute(ActualizarEstadoCitaDTO $dto): void
    {
        $this->citaService->actualizarEstado($dto);
    }
}

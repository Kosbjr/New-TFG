<?php

namespace App\Actions\Citas;

use App\DTOs\Citas\CrearCitaDTO;
use App\Services\Citas\CitaService;

class CrearCitaAction
{
    public function __construct(
        protected CitaService $citaService
    ) {}

    public function execute(CrearCitaDTO $dto): bool
    {
        return $this->citaService->crear($dto);
    }
}

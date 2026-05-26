<?php

namespace App\Actions\Citas;

use App\Services\Citas\CitaService;
use Illuminate\Support\Collection;

class ObtenerCitasAction
{
    public function __construct(
        protected CitaService $citaService
    ) {}

    public function execute(int $userId, string $rol): Collection
    {
        return $this->citaService->obtenerCitas($userId, $rol);
    }
}

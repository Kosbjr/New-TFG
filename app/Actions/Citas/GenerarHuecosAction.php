<?php

namespace App\Actions\Citas;

use App\Models\Centro;
use App\Services\Citas\CitaService;

class GenerarHuecosAction
{
    public function __construct(
        protected CitaService $citaService
    ) {}

    public function execute(Centro $centro): array
    {
        return $this->citaService->generarHuecos($centro);
    }
}

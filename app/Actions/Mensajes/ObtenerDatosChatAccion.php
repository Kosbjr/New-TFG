<?php

namespace App\Actions\Mensajes;

use App\DTOs\Mensajes\CargarChatDTO;
use App\Repositories\MensajeRepository;
use App\Models\Centro;

class ObtenerDatosChatAccion
{
    /**
     * @param \App\Repositories\MensajeRepository $mensajeRepository
     */
    public function __construct(
        protected MensajeRepository $mensajeRepository
    ) {}

    /**
     * Ejecuta el caso de uso para obtener la información básica requerida en el chat.
     *
     * @param \App\DTOs\Mensajes\CargarChatDTO $dto
     * @return \App\Models\Centro
     */
    public function ejecutar(CargarChatDTO $dto): Centro
    {
        return $this->mensajeRepository->buscarCentroPorId($dto->centroId);
    }
}

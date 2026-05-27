<?php
namespace App\DTOs\Mensajes;

class CargarChatDTO
{
    /**
     * @param int $centroId
     * @param int $usuarioId
     */
    public function __construct(
        public readonly int $centroId,
        public readonly int $usuarioId
    ) {}

    /**
     * Crea una instancia del DTO a partir de los parámetros de la ruta.
     *
     * @param mixed $centroId
     * @param mixed $usuarioId
     * @return self
     */
    public static function fromRoute(mixed $centroId, mixed $usuarioId): self
    {
        return new self(
            centroId: (int) $centroId,
            usuarioId: (int) $usuarioId
        );
    }
}

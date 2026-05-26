<?php

namespace App\DTOs\Citas;

class ActualizarEstadoCitaDTO
{
    public function __construct(
        public readonly int    $citaId,
        public readonly int    $usuarioId,
        public readonly string $estado,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            citaId:    $data['cita_id'],
            usuarioId: $data['usuario_id'],
            estado:    $data['estado'],
        );
    }
}

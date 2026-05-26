<?php

namespace App\DTOs\Citas;

class CrearCitaDTO
{
    public function __construct(
        public readonly int     $usuarioId,
        public readonly int     $centroId,
        public readonly int     $servicioId,
        public readonly string  $fecha,
        public readonly string  $hora,
        public readonly ?string $notas = null,
    ) {}

    public static function fromArray(int $usuarioId, int $centroId, array $data): self
    {
        return new self(
            usuarioId:  $usuarioId,
            centroId:   $centroId,
            servicioId: $data['servicio_id'],
            fecha:      $data['fecha'],
            hora:       $data['hora'],
            notas:      $data['notas'] ?? null,
        );
    }
}

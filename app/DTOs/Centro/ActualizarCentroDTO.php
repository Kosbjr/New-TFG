<?php

namespace App\DTOs\Centro;

class ActualizarCentroDTO
{
    public function __construct(
        public readonly string $nombre,
        public readonly ?string $direccion,
        public readonly ?string $ubicacion,
        public readonly ?string $telefono,
        public readonly ?string $descripcion,
        public readonly array $fotos = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            nombre: $data['nombre'],
            direccion: $data['direccion'] ?? null,
            ubicacion: $data['ubicacion'] ?? null,
            telefono: $data['telefono'] ?? null,
            descripcion: $data['descripcion'] ?? null,
            fotos: $data['fotos'] ?? [],
        );
    }
}

<?php

namespace App\DTOs\Centro;

class ActualizarCentroDTO
{
    public function __construct(
        public string $nombre,
        public ?string $direccion,
        public ?string $ubicacion,
        public ?string $telefono,
        public ?string $descripcion,
        public string $comunidad_autonoma,
        public array $fotos = []
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            nombre: $data['nombre'],
            direccion: $data['direccion'] ?? null,
            ubicacion: $data['ubicacion'] ?? null,
            telefono: $data['telefono'] ?? null,
            descripcion: $data['descripcion'] ?? null,
            comunidad_autonoma: $data['comunidad_autonoma'],
            fotos: $data['fotos'] ?? []
        );
    }
}

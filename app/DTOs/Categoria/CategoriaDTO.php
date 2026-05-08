<?php

namespace App\DTOs\Categoria;

class CategoriaDTO
{
    public function __construct(
        public readonly string $nombre,
        public readonly ?string $icono,
        public readonly string $slug,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            nombre: $data['nombre'],
            icono: $data['icono'] ?? null,
            slug: $data['slug'],
        );
    }
}

<?php

namespace App\DTOs\Centro;

class ActualizarCategoriasCentroDTO
{
    public function __construct(
        public readonly array $categorias,
    ) {}

    public static function fromArray(
        array $data
    ): self {

        return new self(
            categorias: $data['categorias'] ?? [],
        );
    }
}

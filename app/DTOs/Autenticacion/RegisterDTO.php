<?php
namespace App\DTOs\Autenticacion;

class RegisterDTO
{
    public function __construct(
        public string $nombre,
        public string $email,
        public ?string $telefono,
        public string $password,
        public string $rol
    ) {}
    public static function fromArray(array $data): self
    {
        return new self(
            nombre: $data['nombre'],
            email: $data['email'],
            telefono: $data['telefono'] ?? null,
            password: $data['password'],
            rol: $data['rol']
        );
    }
}

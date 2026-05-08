<?php

namespace App\Actions\Centro;

use App\Repositories\CentroRepository;

class ActualizarCategoriasCentroAction
{
    public function __construct(
        protected CentroRepository $repository
    ) {}

    public function execute(
        int $usuarioId,
        array $categorias
    ): void {

        $centro = $this->repository
            ->obtenerPorUsuario($usuarioId);

        abort_if(!$centro, 404);

        $this->repository
            ->sincronizarCategorias(
                $centro,
                $categorias
            );
    }
}

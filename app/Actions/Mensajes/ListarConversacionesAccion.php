<?php
namespace App\Actions\Mensajes;

use App\Models\User;
use App\Repositories\MensajeRepository;
use Illuminate\Support\Collection;



class ListarConversacionesAccion
{
    /**
     * @param \App\Repositories\MensajeRepository $mensajeRepository
     */
    public function __construct(
        protected MensajeRepository $mensajeRepository
    ) {}

    /**
     * Ejecuta el caso de uso para listar las conversaciones del usuario autenticado.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Support\Collection
     */
    public function ejecutar(User $user): Collection
    {
        if ($user->rol === 'centro') {
            $centro = $this->mensajeRepository->obtenerCentroPorUsuario($user->id);
            $conversaciones = $this->mensajeRepository->obtenerConversacionesParaCentro($centro->id);
        } else {
            $conversaciones = $this->mensajeRepository->obtenerConversacionesParaUsuario($user->id);
        }

        return $conversaciones->map(function ($conv) {
            $conv->mensaje = $this->mensajeRepository->obtenerUltimoTextoMensaje(
                $conv->centro_id,
                $conv->usuario_id
            );
            return $conv;
        });
    }
}

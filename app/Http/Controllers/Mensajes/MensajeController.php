<?php
namespace App\Http\Controllers\Mensajes;

use App\Http\Controllers\Controller;
use App\Actions\Mensajes\ListarConversacionesAccion;
use App\Actions\Mensajes\ObtenerDatosChatAccion;
use App\DTOs\Mensajes\CargarChatDTO;
use Illuminate\Support\Facades\Auth;

class MensajeController extends Controller
{
    /**
     * Muestra la bandeja de entrada con el listado de conversaciones.
     *
     * @param \App\Actions\Mensajes\ListarConversacionesAccion $listarConversacionesAccion
     * @return \Illuminate\Contracts\View\View
     */
    public function index(ListarConversacionesAccion $listarConversacionesAccion)
    {
        $conversaciones = $listarConversacionesAccion->ejecutar(Auth::user());

        return view('mensajes.index', compact('conversaciones'));
    }

    /**
     * Carga la pantalla de la sala de chat entre un centro y un usuario.
     *
     * @param mixed $centroId
     * @param mixed $usuarioId
     * @param \App\Actions\Mensajes\ObtenerDatosChatAccion $obtenerDatosChatAccion
     * @return \Illuminate\Contracts\View\View
     */
    public function chat($centroId, $usuarioId, ObtenerDatosChatAccion $obtenerDatosChatAccion)
    {
        $dto = CargarChatDTO::fromRoute($centroId, $usuarioId);

        $centro = $obtenerDatosChatAccion->ejecutar($dto);
        $usuarioId = $dto->usuarioId;

        return view('mensajes.chat', compact('centro', 'usuarioId'));
    }
}

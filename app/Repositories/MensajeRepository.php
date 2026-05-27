<?php
namespace App\Repositories;

use App\Models\Mensaje;
use App\Models\Centro;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MensajeRepository
{
    /**
     * Obtiene las conversaciones agrupadas para un centro específico.
     *
     * @param int $centroId
     * @return \Illuminate\Support\Collection
     */
    public function obtenerConversacionesParaCentro(int $centroId): Collection
    {
        return Mensaje::where('centro_id', $centroId)
            ->with(['usuario', 'centro'])
            ->select('usuario_id', 'centro_id',
                DB::raw('MAX(id) as id'),
                DB::raw('MAX(created_at) as created_at'),
                DB::raw('SUM(leido = 0 AND remitente = "usuario") as no_leidos'))
            ->groupBy('usuario_id', 'centro_id')
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Obtiene las conversaciones agrupadas para un usuario específico.
     *
     * @param int $usuarioId
     * @return \Illuminate\Support\Collection
     */
    public function obtenerConversacionesParaUsuario(int $usuarioId): Collection
    {
        return Mensaje::where('usuario_id', $usuarioId)
            ->with(['usuario', 'centro'])
            ->select('usuario_id', 'centro_id',
                DB::raw('MAX(id) as id'),
                DB::raw('MAX(created_at) as created_at'),
                DB::raw('SUM(leido = 0 AND remitente = "centro") as no_leidos'))
            ->groupBy('usuario_id', 'centro_id')
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Obtiene el texto del último mensaje entre un centro y un usuario.
     *
     * @param int $centroId
     * @param int $usuarioId
     * @return string|null
     */
    public function obtenerUltimoTextoMensaje(int $centroId, int $usuarioId): ?string
    {
        return Mensaje::where('centro_id', $centroId)
            ->where('usuario_id', $usuarioId)
            ->latest()
            ->value('mensaje');
    }

    /**
     * Busca un centro por su ID o lanza una excepción si no lo encuentra.
     *
     * @param int $centroId
     * @return \App\Models\Centro
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function buscarCentroPorId(int $centroId): Centro
    {
        return Centro::findOrFail($centroId);
    }

    /**
     * Obtiene el centro asociado al ID de un usuario de tipo centro.
     *
     * @param int $usuarioId
     * @return \App\Models\Centro
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function obtenerCentroPorUsuario(int $usuarioId): Centro
    {
        return Centro::where('usuario_id', $usuarioId)->firstOrFail();
    }
}

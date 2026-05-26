<?php

namespace App\Repositories;

use App\Models\Cita;
use App\Models\Centro;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CitaRepository
{
    public function obtenerPorCentro(int $centroId): Collection
    {
        return Cita::where('centro_id', $centroId)
            ->with(['usuario', 'servicio'])
            ->orderBy('fecha')->orderBy('hora')
            ->get();
    }

    public function obtenerPorUsuario(int $usuarioId): Collection
    {
        return Cita::where('usuario_id', $usuarioId)
            ->with(['centro', 'servicio'])
            ->orderBy('fecha')->orderBy('hora')
            ->get();
    }

    public function obtenerActivasPorCentroYFecha(int $centroId, string $fecha): Collection
    {
        return Cita::where('centro_id', $centroId)
            ->where('fecha', $fecha)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->with('servicio')
            ->get();
    }

    public function obtenerFuturasPorCentro(int $centroId): Collection
    {
        return Cita::where('centro_id', $centroId)
            ->where('fecha', '>=', Carbon::today()->toDateString())
            ->where('fecha', '<=', Carbon::today()->addDays(14)->toDateString())
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->with('servicio')
            ->get()
            ->groupBy('fecha');
    }

    public function crear(array $data): Cita
    {
        return Cita::create($data);
    }

    public function buscarPorId(int $id): Cita
    {
        return Cita::findOrFail($id);
    }

    public function actualizarEstado(Cita $cita, string $estado): void
    {
        $cita->update(['estado' => $estado]);
    }

    public function obtenerCentroPorUsuario(int $usuarioId): Centro
    {
        return Centro::where('usuario_id', $usuarioId)->firstOrFail();
    }
}

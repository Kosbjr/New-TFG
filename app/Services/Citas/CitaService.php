<?php

namespace App\Services\Citas;

use App\DTOs\Citas\CrearCitaDTO;
use App\DTOs\Citas\ActualizarEstadoCitaDTO;
use App\Models\Servicio;
use App\Models\Centro;
use App\Repositories\CitaRepository;
use Carbon\Carbon;

class CitaService
{
    public function __construct(
        protected CitaRepository $repository
    ) {}

    public function obtenerCitas(int $userId, string $rol)
    {
        if ($rol === 'centro') {
            $centro = $this->repository->obtenerCentroPorUsuario($userId);
            return $this->repository->obtenerPorCentro($centro->id);
        }

        return $this->repository->obtenerPorUsuario($userId);
    }

    public function generarHuecos(Centro $centro): array
    {
        $huecos      = [];
        $dias        = collect($centro->horarios)->groupBy('dia_semana');
        $citasFuturas = $this->repository->obtenerFuturasPorCentro($centro->id);

        for ($i = 0; $i < 14; $i++) {
            $fecha     = Carbon::today()->addDays($i);
            $fechaStr  = $fecha->toDateString();
            $diaSemana = $fecha->dayOfWeek === 0 ? 6 : $fecha->dayOfWeek - 1;

            if (!$dias->has($diaSemana)) continue;

            $citasDelDia = $citasFuturas->get($fechaStr, collect());

            foreach ($dias[$diaSemana] as $horario) {
                $inicio = Carbon::parse($horario->hora_inicio);
                $fin    = Carbon::parse($horario->hora_fin);

                while ($inicio < $fin) {
                    $horaActualStr    = $inicio->format('H:i');
                    $horaActualCarbon = Carbon::parse($fechaStr . ' ' . $horaActualStr);
                    $colisiona        = false;

                    foreach ($citasDelDia as $cita) {
                        $citaInicio = Carbon::parse($cita->fecha . ' ' . $cita->hora);
                        $citaFin    = (clone $citaInicio)->addMinutes($cita->servicio->duracion);

                        if ($horaActualCarbon->greaterThanOrEqualTo($citaInicio) &&
                            $horaActualCarbon->lessThan($citaFin)) {
                            $colisiona = true;
                            break;
                        }
                    }

                    if (!$colisiona) {
                        $huecos[$fechaStr][] = $horaActualStr;
                    }

                    $inicio->addMinutes($horario->intervalo_minutos);
                }
            }
        }

        return $huecos;
    }

    public function crear(CrearCitaDTO $dto): bool
    {
        $servicio   = Servicio::findOrFail($dto->servicioId);
        $horaInicio = Carbon::parse($dto->fecha . ' ' . $dto->hora);
        $horaFin    = (clone $horaInicio)->addMinutes($servicio->duracion);

        $citasExistentes = $this->repository
            ->obtenerActivasPorCentroYFecha($dto->centroId, $dto->fecha);

        foreach ($citasExistentes as $cita) {
            $citaInicio = Carbon::parse($cita->fecha . ' ' . $cita->hora);
            $citaFin    = (clone $citaInicio)->addMinutes($cita->servicio->duracion);

            if ($horaInicio->lessThan($citaFin) && $horaFin->greaterThan($citaInicio)) {
                return false;
            }
        }

        $this->repository->crear([
            'usuario_id'  => $dto->usuarioId,
            'centro_id'   => $dto->centroId,
            'servicio_id' => $dto->servicioId,
            'fecha'       => $dto->fecha,
            'hora'        => $dto->hora,
            'estado'      => 'pendiente',
            'notas'       => $dto->notas,
        ]);

        return true;
    }

    public function actualizarEstado(ActualizarEstadoCitaDTO $dto): void
    {
        $cita   = $this->repository->buscarPorId($dto->citaId);
        $centro = $this->repository->obtenerCentroPorUsuario($dto->usuarioId);

        abort_if($cita->centro_id !== $centro->id, 403);

        $this->repository->actualizarEstado($cita, $dto->estado);
    }
}

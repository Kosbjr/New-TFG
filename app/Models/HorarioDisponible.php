<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioDisponible extends Model
{
    protected $fillable = ['centro_id', 'dia_semana', 'hora_inicio', 'hora_fin', 'intervalo_minutos'];

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }
}

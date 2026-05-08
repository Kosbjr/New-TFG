<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'centro_id',
        'servicio_id',
        'fecha',
        'hora',
        'estado',
        'notas',
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function centro()
    {
        return $this->belongsTo(Centro::class, 'centro_id');
    }
}

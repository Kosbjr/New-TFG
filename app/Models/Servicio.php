<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'duracion',
        'centro_id'
    ];

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }
    public function citas()
{
    return $this->hasMany(Cita::class);
}
}

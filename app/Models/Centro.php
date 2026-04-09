<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'nombre',
        'direccion',
        'telefono',
        'descripcion',
        'latitud',
        'longitud',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function mensajesRecibidos()
    {
        return $this->hasMany(Mensaje::class);
    }
}

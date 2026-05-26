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
        'ubicacion',
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
    public function servicios()
    {
        return $this->hasMany(Servicio::class);
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }
    public function fotos()
    {
        return $this->hasMany(FotoCentro::class)->orderBy('orden');
    }
    public function fotosCentro()
    {
        return $this->fotos();
    }
    public function horarios()
    {
        return $this->hasMany(HorarioDisponible::class);
    }
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_centro');
    }
    public function favoritoDe()
    {
        return $this->hasMany(Favorito::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['nombre', 'icono', 'slug'];

    public function centros()
    {
        return $this->belongsToMany(Centro::class, 'categoria_centro');
    }
}

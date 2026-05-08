<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoCentro extends Model
{
    protected $fillable = ['centro_id', 'ruta', 'orden'];

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }
}

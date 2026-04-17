<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    protected $fillable = [
        'puntuacion',
        'comentario',
        'usuario_id',
        'centro_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }
}

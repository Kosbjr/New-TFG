<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'centro_id',
        'mensaje',
        'remitente',
        'leido',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function centro()
    {
        return $this->belongsTo(Centro::class, 'centro_id');
    }
}

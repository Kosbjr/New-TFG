<?php

namespace App\Livewire;

use App\Models\Mensaje;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chat extends Component
{
    public $centroId;
    public $usuarioId; // siempre el id del cliente
    public string $texto = '';

    public function mount($centroId, $usuarioId)
    {
        $this->centroId  = (int) $centroId;
        $this->usuarioId = (int) $usuarioId;
    }

    public function enviar()
    {
        if (trim($this->texto) === '') return;

        $user = Auth::user();


        Mensaje::create([
            'usuario_id' => $this->usuarioId,
            'centro_id'  => $this->centroId,
            'mensaje'    => $this->texto,
            'remitente'  => $user->rol === 'centro' ? 'centro' : 'usuario',
            'leido'      => false,
        ]);

        $this->texto = '';
    }

    public function render()
    {
        $user = Auth::user();

        $mensajes = Mensaje::where('centro_id', $this->centroId)
            ->where('usuario_id', $this->usuarioId)
            ->orderBy('created_at')
            ->get();

        Mensaje::where('centro_id', $this->centroId)
            ->where('usuario_id', $this->usuarioId)
            ->where('leido', false)
            ->where('remitente', $user->rol === 'centro' ? 'usuario' : 'centro')
            ->update(['leido' => true]);

        return view('livewire.chat', compact('mensajes'));
    }
}

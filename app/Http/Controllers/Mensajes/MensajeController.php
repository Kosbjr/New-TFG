<?php

namespace App\Http\Controllers\Mensajes;

use App\Http\Controllers\Controller;
use App\Models\Mensaje;
use App\Models\Centro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MensajeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->rol === 'centro') {
            $centro = Centro::where('usuario_id', $user->id)->firstOrFail();

            $conversaciones = Mensaje::where('centro_id', $centro->id)
                ->with(['usuario', 'centro'])
                ->select('usuario_id', 'centro_id',
                    DB::raw('MAX(id) as id'),
                    DB::raw('MAX(created_at) as created_at'),
                    DB::raw('SUM(leido = 0 AND remitente = "usuario") as no_leidos'))
                ->groupBy('usuario_id', 'centro_id')
                ->orderByDesc('created_at')
                ->get()
                ->map(function ($conv) {
                    $conv->mensaje = Mensaje::where('centro_id', $conv->centro_id)
                        ->where('usuario_id', $conv->usuario_id)
                        ->latest()->value('mensaje');
                    return $conv;
                });
        } else {
            $conversaciones = Mensaje::where('usuario_id', $user->id)
                ->with(['usuario', 'centro'])
                ->select('usuario_id', 'centro_id',
                    DB::raw('MAX(id) as id'),
                    DB::raw('MAX(created_at) as created_at'),
                    DB::raw('SUM(leido = 0 AND remitente = "centro") as no_leidos'))
                ->groupBy('usuario_id', 'centro_id')
                ->orderByDesc('created_at')
                ->get()
                ->map(function ($conv) {
                    $conv->mensaje = Mensaje::where('centro_id', $conv->centro_id)
                        ->where('usuario_id', $conv->usuario_id)
                        ->latest()->value('mensaje');
                    return $conv;
                });
        }

        return view('mensajes.index', compact('conversaciones'));
    }

    public function chat($centroId, $usuarioId)
    {

        $centro = Centro::findOrFail($centroId);
        return view('mensajes.chat', compact('centro', 'usuarioId'));
    }
}

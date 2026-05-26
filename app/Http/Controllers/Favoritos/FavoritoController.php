<?php

namespace App\Http\Controllers\Favoritos;

use App\Http\Controllers\Controller;
use App\Models\Favorito;
use App\Models\Centro;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{
    public function index()
    {
        $favoritos = Favorito::where('usuario_id', Auth::id())
                             ->with(['centro.fotos', 'centro.categorias'])
                             ->get();

        return view('favoritos.index', compact('favoritos'));
    }

    public function toggle($centroId)
    {
        $existe = Favorito::where('usuario_id', Auth::id())
                          ->where('centro_id', $centroId)
                          ->first();

        if ($existe) {
            $existe->delete();
            $esFavorito = false;
        } else {
            Favorito::create([
                'usuario_id' => Auth::id(),
                'centro_id'  => $centroId,
            ]);
            $esFavorito = true;
        }

        if (request()->ajax()) {
            return response()->json(['favorito' => $esFavorito]);
        }

        return back();
    }
}

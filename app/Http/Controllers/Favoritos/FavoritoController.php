<?php

namespace App\Http\Controllers\Favoritos;

use App\Actions\Favoritos\ObtenerFavoritosAction;
use App\Actions\Favoritos\ToggleFavoritoAction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{
    public function __construct(
        protected ObtenerFavoritosAction $obtenerFavoritosAction,
        protected ToggleFavoritoAction   $toggleFavoritoAction,
    ) {}

    public function index()
    {
        $favoritos = $this->obtenerFavoritosAction
            ->execute(Auth::id());

        return view('favoritos.index', compact('favoritos'));
    }

    public function toggle(int $centroId)
    {
        $esFavorito = $this->toggleFavoritoAction
            ->execute(Auth::id(), $centroId);

        if (request()->ajax()) {
            return response()->json(['favorito' => $esFavorito]);
        }

        return back();
    }
}

<?php

namespace App\Http\Controllers\Home;

use App\Actions\Home\ObtenerCentrosGuestAction;
use App\Actions\Home\ObtenerCentrosClienteAction;
use App\Actions\Home\ObtenerCentroDelUsuarioAction;
use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct(
        protected ObtenerCentrosGuestAction   $obtenerCentrosGuestAction,
        protected ObtenerCentrosClienteAction $obtenerCentrosClienteAction,
        protected ObtenerCentroDelUsuarioAction $obtenerCentroDelUsuarioAction,
    ) {}

    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return view('home', [
                'modo'    => 'guest',
                'centros' => $this->obtenerCentrosGuestAction
                    ->execute($request->buscar),
            ]);
        }

        return match ($user->rol) {

            'centro' => view('home', [
                'modo'   => 'centro',
                'centro' => $this->obtenerCentroDelUsuarioAction
                    ->execute(Auth::id()),
            ]),

            default => view('home', [
                'modo'       => 'cliente',
                'centros'    => $this->obtenerCentrosClienteAction
                    ->execute($request->categoria, $request->buscar),
                'categorias' => Categoria::all(),
            ]),
        };
    }
}

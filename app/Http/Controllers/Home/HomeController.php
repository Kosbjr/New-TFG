<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Centro;
use App\Models\Categoria;
use Illuminate\Http\Request; // Importamos la clase Request
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // Añadimos el Request $request como parámetro
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return view('home', [
                'modo' => 'guest',
                'centros' => Centro::latest()
                    ->with('fotos')
                    // Filtro de búsqueda para invitados
                    ->when($request->filled('buscar'), function ($q) use ($request) {
                        $q->where('nombre', 'like', '%' . $request->buscar . '%')
                          ->orWhere('descripcion', 'like', '%' . $request->buscar . '%');
                    })
                    ->take(6)
                    ->get(),
            ]);
        }

        return match ($user->rol) {

            'centro' => view('home', [
                'modo'   => 'centro',
                'centro' => Centro::where('usuario_id', Auth::id())->first(), // puede ser null
            ]),

            default => view('home', [
                'modo'       => 'cliente',
                'centros'    => Centro::latest()
                    ->with(['fotos', 'categorias'])
                    // Filtro de categorías existente
                    ->when($request->categoria, function ($q) use ($request) {
                        $q->whereHas('categorias', function ($q) use ($request) {
                            $q->where('slug', $request->categoria);
                        });
                    })
                    // NUEVO: Filtro de búsqueda por nombre o descripción
                    ->when($request->filled('buscar'), function ($q) use ($request) {
                        $q->where(function ($subquery) use ($request) {
                            $subquery->where('nombre', 'like', '%' . $request->buscar . '%')
                                     ->orWhere('descripcion', 'like', '%' . $request->buscar . '%');
                        });
                    })
                    ->take(12)
                    ->get(),
                'categorias' => Categoria::all(),
            ]),
        };
    }
}

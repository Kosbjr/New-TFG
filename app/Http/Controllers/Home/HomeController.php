<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Centro;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return view('home', [
                'modo' => 'guest',
                'centros' => Centro::latest()->with('fotos')->take(6)->get(),
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
                    ->when(request('categoria'), function ($q) {
                        $q->whereHas('categorias', function ($q) {
                            $q->where('slug', request('categoria'));
                        });
                    })
                    ->take(12)->get(),
                'categorias' => \App\Models\Categoria::all(),
            ]),
        };
    }
}

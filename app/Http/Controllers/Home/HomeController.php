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
            'centros' => Centro::latest()->take(6)->get(),
        ]);
    }

    return match ($user->rol) {

        'centro' => view('home', ['modo' => 'centro']),

        default => view('home', [
            'modo' => 'cliente',
            'centros' => Centro::latest()->take(6)->get(),
        ]),
    };
}
}

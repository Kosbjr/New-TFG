<?php

namespace App\Http\Controllers\Autenticacion;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegistroController extends Controller
{
    public function show()
    {
        return view('autenticacion.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'telefono' => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
            'rol' => 'required|in:cliente,centro,admin',
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        Auth::login($user);

        return redirect('/home');
    }
    public function destroy(Request $request)
{
    $request->validate([
        'password' => 'required|current_password',
    ]);

    $user = Auth::user();
    Auth::logout();
    $user->delete();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Cuenta eliminada correctamente.');
}
}

<?php

namespace App\Http\Controllers\Autenticacion;

use App\Http\Controllers\Controller;
use App\Actions\Autenticacion\LoginAction;
use Illuminate\Http\Request;
 use App\DTOs\Autenticacion\LoginDTO;
class LoginController extends Controller
{
    public function __construct(
        protected LoginAction $loginAction
    ) {}

    public function show()
    {
        return view('autenticacion.login');
    }



    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $dto = LoginDTO::fromArray($data);

        if ($this->loginAction->execute($dto)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas',
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

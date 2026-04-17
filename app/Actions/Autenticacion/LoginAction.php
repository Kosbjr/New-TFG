<?php

namespace App\Actions\Autenticacion;

use Illuminate\Support\Facades\Auth;
use App\DTOs\Autenticacion\LoginDTO;

class LoginAction
{
    public function execute(LoginDTO $data): bool
    {
        return Auth::attempt([
            'email' => $data->email,
            'password' => $data->password,
        ]);
    }
}

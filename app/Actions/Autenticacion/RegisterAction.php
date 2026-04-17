<?php
namespace App\Actions\Autenticacion;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class RegistroAction
{
    public function __construct(
        protected UserRepository $users
    ) {}

    public function execute(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        return $this->users->create($data);
    }
}

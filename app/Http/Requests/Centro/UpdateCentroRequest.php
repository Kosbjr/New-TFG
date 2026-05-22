<?php

namespace App\Http\Requests\Centro;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCentroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'      => 'required|string|max:255',
            'direccion'   => 'nullable|string|max:255',
            'ubicacion'   => 'nullable|string|max:255',
            'telefono'    => 'nullable|string|max:20',
            'descripcion' => 'nullable|string|max:1000',
            'fotos.*'     => 'nullable|image|max:2048',
        ];
    }
}

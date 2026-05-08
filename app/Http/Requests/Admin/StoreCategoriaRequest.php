<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'icono'  => 'nullable|string|max:10',
            'slug'   => 'required|string|max:100|unique:categorias,slug',
        ];
    }
}

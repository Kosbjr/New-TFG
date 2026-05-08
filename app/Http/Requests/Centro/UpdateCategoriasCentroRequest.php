<?php

namespace App\Http\Requests\Centro;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoriasCentroRequest
    extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categorias'   => 'nullable|array',
            'categorias.*' => 'exists:categorias,id',
        ];
    }
}

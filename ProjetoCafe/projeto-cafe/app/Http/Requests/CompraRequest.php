<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'usuario_id' => ['required', 'integer', 'exists:usuario,id'],
            'cafe_qnd' => ['required', 'integer', 'min:1'],
            'filtro_qnd' => ['integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'usuario_id.required' => 'O usuário é obrigatório.',
            'usuario_id.exists' => 'O usuário não existe.',
            'cafe_qnd.required' => 'A quantidade de café é obrigatória.',
            'cafe_qnd.min' => 'Deve ser comprado no mínimo 1 café.',
            'filtro_qnd.min' => 'A quantidade de filtro não pode ser negativa.',
        ];
    }
}

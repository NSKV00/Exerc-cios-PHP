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
            'usuario_id' => ['required', 'integer', 'exists:usuario,id', 'gt:0'],
            'cafe_qnd' => ['required', 'integer', 'min:1', 'max:100'],
            'filtro_qnd' => ['nullable', 'integer', 'min:0', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'usuario_id.required' => 'O usuário é obrigatório.',
            'usuario_id.integer' => 'O usuário deve ser um número inteiro.',
            'usuario_id.exists' => 'O usuário não existe no sistema.',
            'usuario_id.gt' => 'O ID do usuário deve ser válido.',
            'cafe_qnd.required' => 'A quantidade de café é obrigatória.',
            'cafe_qnd.integer' => 'A quantidade de café deve ser um número inteiro.',
            'cafe_qnd.min' => 'Deve ser comprado no mínimo 1 café.',
            'cafe_qnd.max' => 'A quantidade de café não pode exceder 999 unidades.',
            'filtro_qnd.integer' => 'A quantidade de filtro deve ser um número inteiro.',
            'filtro_qnd.min' => 'A quantidade de filtro não pode ser negativa.',
            'filtro_qnd.max' => 'A quantidade de filtro não pode exceder 999 unidades.',
        ];
    }
}

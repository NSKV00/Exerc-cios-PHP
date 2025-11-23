<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'usuario_id' => ['required', 'integer', 'exists:usuario,id',
                Rule::unique('fila_compra', 'usuario_id')
                    ->whereNull('deleted_at'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'usuario_id.required' => 'O usuário é obrigatório.',
            'usuario_id.integer' => 'O usuário deve ser um número inteiro.',
            'usuario_id.exists' => 'O usuário não existe no sistema.',
            'usuario_id.unique' => 'Este usuário já está na fila.',
        ];
    }
}

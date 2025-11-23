<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'min:3', 'max:100', 'regex:/^[\p{L}\s\'-]+$/u'],
            'email' => ['required', 'email:rfc,dns', 'unique:usuario,email', 'max:100'],
            'senha' => ['required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'acesso' => [ 'nullable', 'string', 'in:usuario,admin'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'nome.string' => 'O nome deve ser um texto.',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max' => 'O nome não pode exceder 100 caracteres.',
            'nome.regex' => 'O nome pode conter apenas letras, espaços, hífens e apóstrofos.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ser um endereço válido.',
            'email.unique' => 'Este email já está registrado no sistema.',
            'email.max' => 'O email não pode exceder 100 caracteres.',
            'senha.required' => 'A senha é obrigatória.',
            'senha.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'senha.letters' => 'A senha deve conter pelo menos uma letra.',
            'senha.mixed_case' => 'A senha deve conter letras maiúsculas e minúsculas.',
            'senha.numbers' => 'A senha deve conter pelo menos um número.',
            'senha.symbols' => 'A senha deve conter pelo menos um caractere especial (!@#$%^&*).',
            'acesso.in' => 'O acesso deve ser "usuario" ou "admin".',
        ];
    }
}

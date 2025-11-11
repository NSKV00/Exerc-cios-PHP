<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;
use Mockery\Generator\StringManipulation\Pass\Pass;

class UsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string'],
            'email' => ['required', 'string', 'unique:usuario,email'],
            'senha' => ['required', 'string', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%&*]).{8,}$/'],
            'acesso' => ['string', 'in:usuario,admin'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.unique' => 'O email já está em uso.',
            'senha.required' => 'O campo senha é obrigatório.',
            'senha.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'senha.regex' => 'A senha deve conter no mínimo 8 caracteres, incluindo letras maiúsculas, minúsculas, números e caracteres especiais.',
            'senha.mixedCase' => 'A senha deve conter letras maiúsculas e minúsculas.',
            'senha.letters' => 'A senha deve conter pelo menos uma letra.',
            'senha.numbers' => 'A senha deve conter pelo menos um número.',
            'senha.symbols' => 'A senha deve conter pelo menos um caracter especial.',
            'acesso.in' => 'O valor do campo acesso deve ser "usuario" ou "admin".',
        ];
    }
}

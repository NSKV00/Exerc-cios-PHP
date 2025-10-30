<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendaRequest extends FormRequest
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
            'ingresso_id' => ['required', 'integer', 'exists:ingressos,id'],
            'valor' => ['required', 'decimal:0,2'],
            'evento_id' => ['required', 'integer', 'exists:eventos,id'],
            'documento' => ['required', 'string', 'size:11'],
        ];
    }
}

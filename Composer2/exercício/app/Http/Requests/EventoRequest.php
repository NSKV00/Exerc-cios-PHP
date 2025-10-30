<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Models\Evento;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Validation\Rule;

class EventoRequest extends FormRequest
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
            'nome' => ['required', 'min:5', 'string'],
            'data_inicio' => [
                'required',
                Rule::date() -> format('Y-m-d H:i:s')
            ],
            'data_fim' => [
                'required',
                Rule::date() -> format('Y-m-d H:i:s'),
                'after:data_inicio'
            ],
        ];
    }
}

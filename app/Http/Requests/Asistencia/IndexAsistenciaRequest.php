<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexAsistenciaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // la autorización real la hace la Policy en el controlador
    }

    public function rules(): array
    {
        return [
            'sesion_id'    => ['sometimes', 'integer', 'exists:sesiones,id'],
            'matricula_id' => ['sometimes', 'integer', 'exists:matriculas,id'],
            'fecha'        => ['sometimes', 'date'],
            'estado'       => ['sometimes', Rule::in(['presente', 'falta', 'justificada', 'retraso'])],
            'page'         => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
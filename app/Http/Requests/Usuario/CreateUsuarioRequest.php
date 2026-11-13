<?php

namespace App\Http\Requests;

use App\Models\Usuario;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Usuario::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre'                => 'required|string|max:255',
            'apellidos'             => 'required|string|max:255',
            'username'              => 'required|string|max:50',
            'email'                 => 'required|email',
            'telefono'              => 'nullable',
            'password'              => 'required|password|max:255',
            'rol'                   => 'required',
            'tipo_documento'        => '',
            'documento_identidad'   => '',
            'activo'                => '',
        ];
    }
}

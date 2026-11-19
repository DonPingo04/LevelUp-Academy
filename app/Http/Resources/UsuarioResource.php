<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'nombre'                => $this->nombre,
            'apellidos'             => $this->apellidos,
            'username'              => $this->username,
            'email'                 => $this->email,
            'telefono'              => $this->telefono,
            'password'              => $this->password,
            'rol'                   => $this->rol,
            'tipo_documento'        => $this->tipo_documento,
            'documento_identidad'   => $this->documento_identidad,
            'activo'                => $this->activo
        ];
    }
}

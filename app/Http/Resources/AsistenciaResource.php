<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AsistenciaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'estado'      => $this->estado,
            'observacion' => $this->observacion,
            'sesion'      => [
                'id'    => $this->sesion?->id,
                'fecha' => $this->sesion?->fecha,
            ],
            'matricula_id' => $this->matricula_id,
            'alumno'      => $this->matricula?->alumno?->usuario
                ? $this->matricula->alumno->usuario->nombre . ' ' . $this->matricula->alumno->usuario->apellidos
                : null,
        ];
    }
}

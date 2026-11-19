<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatriculaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'alumno_id'         => $this->alumno->id,
            'grupo_id'          => $this->grupo->id,
            'fecha_matricula'   => $this->fecha_matricula,
            'estado'            => $this->estado,
            
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SesionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'grupo_id'      => $this->grupo->id,
            'aula_id'       => $this->aula->id,
            'fecha'         => $this->fecha,
            'hora_inicio'   => $this->hora_inicio,
            'hora_fin'      => $this->hora_fin
        ];
    }
}

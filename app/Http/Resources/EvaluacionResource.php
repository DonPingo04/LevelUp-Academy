<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EvaluacionResource extends JsonResource
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
            'nombre'        => $this->nombre,
            'fecha'         => $this->fecha,
            'publicada'     => $this->publicada
        ];
    }
}

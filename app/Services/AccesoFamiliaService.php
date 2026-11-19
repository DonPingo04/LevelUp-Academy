<?php

namespace App\Services;

use App\Models\Alumno;
use App\Models\Familiar;
use Illuminate\Database\Eloquent\Builder;

class AccesoFamiliaService
{
    public function puedeVer(Familiar $familiar, Alumno $alumno) : bool
    {
        return Alumno::visiblesParaFamiliar($familiar)
            ->whereKey($alumno->id)
            ->exists();
    }

    public function alumnosVisibles(Familiar $familiar) : Builder
    {
        return Alumno::visiblesParaFamiliar($familiar);
    }
}
<?php
namespace App\Services;

use App\Models\Alumno;
use Ramsey\Collection\Collection;

class MatriculaService
{
    public function matricular(Alumno $alumno, array $grupoIds): Collection
    {
        return new Collection('');
    }
}
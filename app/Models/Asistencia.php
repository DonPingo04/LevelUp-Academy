<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Rol;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'sesion_id',
        'matricula_id',
        'estado',
        'observacion'
    ];

    public function sesion()
    {
        return $this->belongsTo(Sesion::class, 'sesion_id');
    }

    public function matricula()
    {
        return $this->belongsTo(Matricula::class, 'matricula_id');
    }

    public function scopeVisiblesPara(Builder $q, Usuario $u): Builder
    {
        return match ($u->rol) {
            Rol::Secretaria => $q,
            Rol::Profesor   => $q->whereHas('matricula.grupo',
                                fn ($g) => $g->where('profesor_id', $u->profesor?->id)),
            Rol::Alumno     => $q->whereHas('matricula',
                                fn ($m) => $m->where('alumno_id', $u->alumno?->id)),
            Rol::Familiar   => $q->whereHas('matricula.alumno',
                                fn ($a) => $a->visiblesPara($u)),   // reutiliza la regla de edad y autorización
            default         => $q->whereRaw('1 = 0'),
        };
    }
}
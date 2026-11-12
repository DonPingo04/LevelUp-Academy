<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'curso_id',
        'periodo_id',
        'nivel_id',
        'profesor_id',
        'nombre',
        'capacidad',
        'activo'
    ];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function sesiones()
    {
        return $this->hasMany(Sesion::class);
    }

    public function franjasHorarias() 
    {
        return $this->hasMany(FranjaHoraria::class);
    }
}
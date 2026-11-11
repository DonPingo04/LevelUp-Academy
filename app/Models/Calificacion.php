<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluacion_id',
        'matricula_id',
        'nota',
        'comentario'
    ];

    public function evalucion()
    {
        return $this->belongsTo(Evaluacion::class, 'evaluacion_id');
    }

    public function matricula()
    {
        return $this->belongsTo(Matricula::class, 'matricula_id');
    }
}

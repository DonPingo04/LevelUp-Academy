<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranjaHoraria extends Model
{
    use HasFactory;

    protected $fillable = [
        'grupo_id',
        'aula_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin'
    ];

    public function aula()
    {
        return $this->belongsTo(Aula::class, 'aula_id');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
}

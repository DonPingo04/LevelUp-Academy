<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    use HasFactory;

    protected $fillable = [
        'grupo_id',
        'aula_id',
        'fecha',
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

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}

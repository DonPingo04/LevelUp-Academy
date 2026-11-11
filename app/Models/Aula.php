<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'capacidad',
        'activo'
    ];

    public function sesiones()
    {
        return $this->hasMany(Sesion::class);
    }

    public function franjas_horarias()
    {
        return $this->hasMany(FranjaHoraria::class);
    }
}

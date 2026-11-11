<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'grupo_id',
        'nombre',
        'fecha',
        'publicada'
    ];

    public function notas()
    {
        return $this->hasMany(Calificacion::class);
    }
    
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'fecha_nacimiento'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function familiares()
    {
        return $this->belongsToMany(Familiar::class, 'alumno_familiar', 'alumno_id', 'familiar_id')
                    ->withPivot('parentesco', 'autoriza_acceso', 'fecha_autorizacion');
    }
}

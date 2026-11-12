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

    public function scopeDeProfesor($query, $profesorId)
    {
        return $query->whereIn('grupo_id', function ($q) use ($profesorId){
            $q -> select('id')
               ->from('grupos')
               ->where('profesor_id', $profesorId);
        });
    }

    public function scopeDeFamiliar($query, $familiarId)
    {
        return $query->whereIn('id', function ($q) use ($familiarId){
            $q->select('alumno_id')
              ->from('alumno_familiar')
              ->where('familiar_id', $familiarId);
        });
    }
}

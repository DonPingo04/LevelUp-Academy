<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Familiar;
use Illuminate\Database\Eloquent\Builder;

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
        return $query->whereIn('grupo_id', function ($q) use ($profesorId) {
            $q->select('id')
                ->from('grupos')
                ->where('profesor_id', $profesorId);
        });
    }

    public function scopeDeFamiliar($query, $familiarId)
    {
        return $query->whereIn('id', function ($q) use ($familiarId) {
            $q->select('alumno_id')
                ->from('alumno_familiar')
                ->where('familiar_id', $familiarId);
        });
    }

    public function scopeVisiblesParaFamiliar(Builder $q, Familiar $familiar): Builder
    {
        return $q
            // 1. Está vinculado a este familiar
            ->whereHas('familiares', fn($v) => $v->where('familiares.id', $familiar->id))
            // 2. Es menor de edad, o es mayor y este familiar está autorizado
            ->where(function ($w) use ($familiar) {
                $w->where('fecha_nacimiento', '>', now()->subYears(18)->toDateString())
                    ->orWhereHas('familiares', fn($v) => $v
                        ->where('familiares.id', $familiar->id)
                        ->where('alumno_familiar.autoriza_acceso', true));
            });
    }
}

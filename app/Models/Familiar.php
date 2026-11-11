<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familiar extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'odoo_partner_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumno_familiar', 'familiar_id', 'alumno_id')
                    ->withPivot('parentesco', 'autoriza_acceso', 'fecha_acceso');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumno_id',
        'grupo_id',
        'fecha_matricula',
        'estado',
        'familiar_pagador_id',
        'odoo_invoice_id',
        'estado_sincronizacion'
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    public function pagador()
    {
        return $this->morphTo();
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }
}

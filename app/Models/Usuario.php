<?php

namespace App\Models;

use Illuminate\Console\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellidos',
        'username',
        'email',
        'telefono',
        'password',
        'rol',
        'tipo_documento',
        'documento_identidad',
        'activo',
    ];

    protected $hidden = [
        'password'
    ];

    public function alumnos()
    {
        return $this->hasOne(Alumno::class, 'usuario_id');
    }

    public function familiares()
    {
        return $this->hasOne(Familiar::class, 'usuario_id');
    }

    public function profesores()
    {
        return $this->hasOne(Profesor::class, 'usuario_id');
    }
    
    
}

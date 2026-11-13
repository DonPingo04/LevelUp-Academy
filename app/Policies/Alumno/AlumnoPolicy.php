<?php

namespace App\Policies;

use App\Models\Alumno;
use App\Models\Usuario;
use App\Rol;
use Illuminate\Auth\Access\Response;

class AlumnoPolicy
{

    public function before(Usuario $user, string $ability) : ?bool
    {
        if($user->hasRole(Rol::Secretaria))
        {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Usuario $user): bool
    {
        return $user->hasAnyRole([Rol::Profesor, Rol::Familiar]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Usuario $user, Alumno $alumno): bool
    {
        if($user->hasRole(Rol::Profesor))
        {
            return $alumno->grupos->contains('profesor_id', $user->id);
        }
        
        if ($user->hasRole(Rol::Familiar)) {
            return $alumno->familiares->contains('familiar_id', $user->id);
        }
    
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Usuario $user): bool
    {
        return $user->hasRole(Rol::Secretaria);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Usuario $user, Alumno $alumno): bool
    {
        if($user->hasRole(Rol::Secretaria)) return true;

        if($user->hasRole(Rol::Familiar)) return $alumno->familiares()->where('familiar_id', $user->id)->exists();

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $user, Alumno $alumno): bool
    {
        return $user->hasRole(Rol::Secretaria);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Usuario $user, Alumno $alumno): bool
    {
        return $user->hasRole(Rol::Secretaria);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Usuario $user, Alumno $alumno): bool
    {
        return $user->hasRole(Rol::Secretaria);
    }
}

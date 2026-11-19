<?php

namespace App\Policies;

use App\Models\Asistencia;
use App\Models\User;
use App\Rol;
use Illuminate\Auth\Access\Response;

class AsistenciaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Rol::Secretaria);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Asistencia $asistencia): bool
    {
        if($user->hasRole(Rol::Profesor))
        {
            return $user->grupo?->profesor_id == $user->id;
        }

        if($user->hasRole(Rol::Alumno))
        {
            return $user->alumno->matricula->asistencia->matricula_id == $user->alumno->matricula->id;
        }
       
        return $user->hasRole(Rol::Secretaria);
        
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole([Rol::Profesor, Rol::Secretaria]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Asistencia $asistencia): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Asistencia $asistencia): bool
    {
        return $user->hasRole([Rol::Secretaria, Rol::Profesor]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Asistencia $asistencia): bool
    {
        return $user->hasRole(Rol::Secretaria);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Asistencia $asistencia): bool
    {
        return $user->hasRole(Rol::Secretaria);
    }
}
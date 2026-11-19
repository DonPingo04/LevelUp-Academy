<?php

namespace App\Providers;

use App\Models\Alumno;
use App\Models\Asistencia;
use App\Models\Calificacion;
use App\Models\Familiar;
use App\Models\Matricula;
use App\Models\Usuario;
use App\Policies\AlumnoPolicy;
use App\Policies\AsistenciaPolicy;
use App\Policies\CalificacionPolicy;
use App\Policies\UsuarioPolicy;
use App\Policies\MatriculaPolicy;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'Alumno' => Alumno::class,
            'Familiar' => Familiar::class
        ]);

        Gate::policy(Alumno::class, AlumnoPolicy::class);
        Gate::policy(Asistencia::class, AsistenciaPolicy::class);
        Gate::policy(Calificacion::class, CalificacionPolicy::class);
        Gate::policy(Usuario::class, UsuarioPolicy::class);
        Gate::policy(Matricula::class, MatriculaPolicy::class);    
    }
}

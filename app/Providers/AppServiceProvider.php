<?php

namespace App\Providers;

use App\Models\Alumno;
use App\Models\Familiar;
use Illuminate\Database\Eloquent\Relations\Relation;
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
    }
}

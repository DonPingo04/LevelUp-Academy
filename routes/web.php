<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('/alumnos', AlumnoController::class);

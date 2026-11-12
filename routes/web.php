<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\FamiliarController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\SesionController;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('alumnos', AlumnoController::class);
    Route::apiResource('profesores', ProfesorController::class)->parameters(['profesores' => 'profesor']);
    Route::apiResource('grupos', GrupoController::class);
    Route::apiResource('familiares', FamiliarController::class)->parameters(['familiares' => 'familiar']);
    Route::apiResource('aulas', AulaController::class);
    Route::apiResource('matriculas', MatriculaController::class);
    Route::apiResource('cursos', CursoController::class);
    Route::apiResource('sesiones', SesionController::class);
    Route::apiResource('usuarios', UsuarioController::class);
    Route::apiResource('evaluaciones', EvaluacionController::class)->parameters(['evaluaciones' => 'evaluacion']);
    Route::apiResource('calificaciones', CalificacionController::class)->parameters(['calificaciones' => 'calificacion']);
    Route::apiResource('asistencias', AsistenciaController::class);
    Route::patch('grupos/{grupo}/profesor', [GrupoController::class, 'reasignarProfesor']);
    Route::post('grupos/{grupo}/generar-sesiones', [GrupoController::class, 'generarSessiones']);
    Route::put('alumos/{alumno}/familiares/{familiar}/autorizacion'); // TODO hacer funcion para añadir autorización.
    Route::get('alumnos/{alumno}/familiares'); // TODO hacer la funcion para filtar los familiares del alumno
});
    

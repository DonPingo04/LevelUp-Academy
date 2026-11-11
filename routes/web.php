<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('aut:sanctum')->group(function(){
    Route::apiResource('/alumnos', AlumnoController::class);
});
    

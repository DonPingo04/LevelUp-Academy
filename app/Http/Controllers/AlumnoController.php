<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Usuario;
use App\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Alumno::class);

        $user = $request->user();

        $alumnos = match ($user->rol)
        {
            Rol::Secretaria => Alumno::with('usuario')->get(),
            Rol::Profesor   => Alumno::with('usuario')->deProfesor($user->id)->get(),
            Rol::Familiar   => Alumno::with('usuario')->deFamiliar($user->id)->get(),
        };

        return response()-> json([
            'success' => true,
            'data' => $alumnos
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Alumno::class);

        $validated = $request->validate([
            'nombre'              => 'required|string',
            'apellidos'           => 'required|string',
            'username'            => 'required|string|unique:usuarios,username',
            'email'               => 'required|email|unique:usuarios,email',
            'telefono'            => 'nullable|string',
            'password'            => 'required|string|min:8',
            'rol'                 => 'required|in:alumno,profesor,admin',
            'tipo_documento'      => 'required|string',
            'documento_identidad' => 'required|string',
            'fecha_nacimiento'    => 'required|date|before:2017-01-01',
        ]);

        $alumno = DB::transaction(function() use ($validated){
            $usuario = Usuario::create([
                'nombre'              => $validated['nombre'],
                'apellidos'           => $validated['apellidos'],
                'username'            => $validated['username'],
                'email'               => $validated['email'],
                'telefono'            => $validated['telefono'] ?? null,
                'password'            => bcrypt($validated['password']),
                'rol'                 => 'alumno',
                'tipo_documento'      => $validated['tipo_documento'],
                'documento_identidad' => $validated['documento_identidad'],
            ]);

            return Alumno::create([
                'usuario_id'       => $usuario->id,
                'fecha_nacimiento' => $validated['fecha_naciemiento'],
            ]);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumno $alumno)
    {
        $this->authorize('view', $alumno);    

        $alumno->load('usuario');

        return response()->json([
            'success' => true,
            'data'    => $alumno
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumno $alumno)
    {
        $this->authorize('update', $alumno);

        $validated = $request->validate([
            'nombre'              => 'required|string',
            'apellidos'           => 'required|string',
            'username'            => 'required|string|unique:usuarios,username',
            'email'               => 'required|email|unique:usuarios,email',
            'telefono'            => 'nullable|string',
            'password'            => 'required|string|min:8',
            'rol'                 => 'required|in:alumno,profesor,admin',
            'tipo_documento'      => 'required|string',
            'documento_identidad' => 'required|string',
            'fecha_nacimiento'    => 'required|date|before:2017-01-01',
        ]);

        if(isset($validated['password']))
        {
            $validated['pasword'] = bcrypt($validated['password']);
        }

        $alumno->usuario->update($validated);

        if(isset($validated['password']))
        {
            $alumno->update(['fecha_nacimiento' => $validated['fecha_nacimiento']]);
        }

        return response()->json([
            'success' => true, 
            'data'    => $alumno->load('usuario')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumno $alumno)
    {
        $this->authorize('delete', $alumno);

        DB::transaction(function () use ($alumno){
            $alumno->usuario->delete();
            $alumno->delete();
        });

        return response()->json([
            'success' => true,
            'mensaje' => 'Alumno eliminado correctamente.' 
        ]);
    }
}
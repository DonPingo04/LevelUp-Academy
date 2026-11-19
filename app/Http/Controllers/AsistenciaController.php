<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Http\Requests\IndexAsistenciaRequest;
use App\Http\Resources\AsistenciaResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexAsistenciaRequest $request)
    {
        Gate::authorize('viewAny', Asistencia::class);

        $asistencias = Asistencia::visiblesPara($request->user())
            ->with(['sesion', 'matricula.alumno.usuario'])
            ->when($request->sesion_id,    fn($q, $v) => $q->where('sesion_id', $v))
            ->when($request->matricula_id, fn($q, $v) => $q->where('matricula_id', $v))
            ->when($request->estado,       fn($q, $v) => $q->where('estado', $v))
            ->when($request->fecha,        fn($q, $v) => $q->whereHas(
                'sesion',
                fn($s) => $s->whereDate('fecha', $v)
            ))
            ->paginate(25);

        return AsistenciaResource::collection($asistencias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Asistencia::class);

        $validatedData = $request->validate([
            "sesion_id"     => ['required', 'integer', 'exists:sesiones,id'],
            "matricula"     => ['required', 'integer', 'exists:matriculas,id'],
            "estado"        => ['required', 'enum'],
            "observacion"   => ['required', 'string', 'max:255']
        ]);

        $asistencia = Asistencia::create($validatedData);

        return $request->json([
            'data' => $asistencia
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Asistencia $asistencia)
    {
        $this->authorize('view', $asistencia);

        $asistencia->load('usuario');

        return response()->json([
            'success' => true,
            'data'    => $asistencia
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        $this->authorize('update', Asistencia::class);

        $validatedData = $request->validate([
            "sesion_id"     => ['required', 'integer', 'exists:sesiones,id'],
            "matricula"     => ['required', 'integer', 'exists:matriculas,id'],
            "estado"        => ['required', 'enum'],
            "observacion"   => ['required', 'string', 'max:255']
        ]);


        $asistencia->update($validatedData);

        return $request->json([
            'data'  => $asistencia
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asistencia $asistencia)
    {
        $this->authorize('delete');

        $asistencia->delete();
    }
}

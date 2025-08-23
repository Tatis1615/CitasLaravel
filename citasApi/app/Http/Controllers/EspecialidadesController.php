<?php

namespace App\Http\Controllers;
use App\Models\Especialidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EspecialidadesController extends Controller
{
    public function index(){
        $especialidades = Especialidades::all();

        return response()->json($especialidades);
    }

    public function store(Request $request){
        $validador = Validator::make($request->all(),[
            'nombre_e' => 'required|string|max:255',
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors(), 422);
        }

        $especialidad = Especialidades::create($request->all());
        return response()->json($especialidad, 201);
    }

    public function show(string $id){
        $especialidad = Especialidades::find($id);
        
        if (!$especialidad) {
            return response()->json(['message' => 'Especialidad no encontrado'], 404);
        }

        return response()->json($especialidad);
    }

    public function update(Request $request, string $id){

        $especialidad = Especialidades::find($id);

        if (!$especialidad) {
            return response()->json(['message' => 'Especialidad no encontrado'], 404);
        }

        $validador = Validator::make($request->all(), [
            'nombre_e' => 'string|max:255',
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors(), 422);
        }

        $especialidad->update($request->all());
        return response()->json($especialidad);
    }



    public function destroy(string $id){
        $especialidades = Especialidades::find($id);

        if (!$especialidades) {
            return response()->json(['message' => 'Especialidad no encontrado'], 404);
        }

        $especialidades->delete();
        return response()->json(['message' => 'Especialidad eliminado']);
    }

    public function listarEspecialidadesPorLetraP() {
        $especialidades = Especialidades::where('nombre_e', 'LIKE', 'P%')->get();
        return response()->json($especialidades);
    }

    public function listarEspecialidadesConMasDe2Medicos() {
        $especialidades = Especialidades::has('medicos', '>=', 2)->get();
        return response()->json($especialidades);
    }
}


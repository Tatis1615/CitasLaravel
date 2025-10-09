<?php

namespace App\Http\Controllers;

use App\Models\Medicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicosController extends Controller
{
    public function index(){
        $medicos = Medicos::all();

        return response()->json($medicos);
    }




    public function store(Request $request){
        $validador = Validator::make($request->all(),[
            'especialidad_id' => 'required|integer|exists:especialidades,id',
            'nombre_m' => 'required|string|max:255',
            'apellido_m' => 'required|string|max:255',
            'edad' => 'required|string|min:0',
            'telefono' => 'required|string|max:255',
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors(), 422);
        }

        $medico = Medicos::create($request->all());
        return response()->json($medico, 201);
    }




    public function show(string $id){
        $medico = Medicos::find($id);
        
        if (!$medico) {
            return response()->json(['message' => 'Medico no encontrado'], 404);
        }

        return response()->json($medico);
    }




    public function update(Request $request, string $id){

        $medico = Medicos::find($id);

        if (!$medico) {
            return response()->json(['message' => 'Medico no encontrada'], 404);
        }

        $validador = Validator::make($request->all(), [
            'especialidad_id' => 'string|exists:especialidades,id',
            'nombre_m' => 'string|max:255',
            'apellido_m' => 'string|max:255',
            'edad' => 'string|min:0',
            'telefono' => 'string|max:255',
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors(), 422);
        }

        $medico->update($request->all());
        return response()->json($medico);
    }




    public function destroy(string $id){

        $medico = Medicos::find($id);

        if (!$medico) {
            return response()->json(['message' => 'Medico no encontrado'], 404);
        }

        $medico->delete();
        return response()->json(['message' => 'Medico eliminado correctamente']);
    }

    

    public function listarMedicosSinCitas() {
        $medicos = Medicos::doesntHave('citas')->get();
        return response()->json($medicos);
    }

    public function listarMedicosPediatria() {
        $medicos = Medicos::whereHas('especialidades', function($query) {
            $query->where('nombre_e', 'Pediatria');
        })->get();

        return response()->json($medicos);
    }


}

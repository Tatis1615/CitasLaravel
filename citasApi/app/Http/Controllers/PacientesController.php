<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PacientesController extends Controller
{
    public function index(){
        $pacientes = Pacientes::all();

        return response()->json($pacientes);
    }




    public function store(Request $request){
        $validador = Validator::make($request->all(),[
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'documento' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'required|string|max:255',
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors(), 422);
        }

        $paciente = Pacientes::create($request->all());
        return response()->json($paciente, 201);
    }




    public function show(string $id){
        $paciente = Pacientes::find($id);
        
        if (!$paciente) {
            return response()->json(['message' => 'Paciente no encontrada'], 404);
        }

        return response()->json($paciente);
    }




    public function update(Request $request, string $id){

        $paciente = Pacientes::find($id);

        if (!$paciente) {
            return response()->json(['message' => 'Paciente no encontrada'], 404);
        }

        $validador = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'apellido' => 'string|max:255',
            'documento' => 'string|max:255',
            'telefono' => 'string|max:255',
            'email' => 'string|max:255',
            'fecha_nacimiento' => 'date',
            'direccion' => 'string|max:255',
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors(), 422);
        }

        $paciente->update($request->all());
        return response()->json($paciente);
    }




    public function destroy(string $id){

        $paciente = Pacientes::find($id);

        if (!$paciente) {
            return response()->json(['message' => 'Paciente no encontrado'], 404);
        }

        $paciente->delete();
        return response()->json(['message' => 'Paciente eliminado correctamente']);
    }

 

    public function buscarPorEmail($email)
    {
        $paciente = \App\Models\Pacientes::where('email', $email)->first();

        if (!$paciente) {
            return response()->json([
                'success' => false,
                'message' => 'Paciente no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $paciente
        ]);
    }






    public function listarPacientesConCitasConfirmadas() {
        $pacientes = Pacientes::whereHas('citas', function($q) {
            $q->where('estado', 'confirmada');
        })->get();
        return response()->json($pacientes);
    }

    public function listarPacientesMayores60() {
        $pacientes = Pacientes::whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) > 60')->get();
        return response()->json($pacientes);
    }

    public function listarPacientesSinCitas() {
        $pacientes = Pacientes::doesntHave('citas')->get();
        return response()->json($pacientes);
    }


    public function listarPacientesPorLetraC() {
        $pacientes = Pacientes::where('nombre', 'LIKE', 'C%')->get();
        return response()->json($pacientes);
    }


    

}


    
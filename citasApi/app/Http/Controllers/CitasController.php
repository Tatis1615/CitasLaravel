<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitasController extends Controller
{
    public function index(){
        $citas = Citas::all();

        return response()->json($citas);
    }

    public function store(Request $request){
        $validador = Validator::make($request->all(),[
            'paciente_id' => 'required|exists:pacientes,id',
            'medico_id' => 'required|exists:medicos,id',
            'consultorio_id' => 'required|exists:consultorios,id',
            'fecha_hora' => 'required|date',
            'estado' => 'required',
            'motivo' => 'required|string|max:255',
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors(), 422);
        }

        $cita = Citas::create($request->all());
        return response()->json($cita, 201);
    }

    public function show(string $id){
        $cita = Citas::find($id);
        
        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        return response()->json($cita);
    }

    public function update(Request $request, string $id){

        $cita = Citas::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $validador = Validator::make($request->all(), [
            'paciente_id' => 'exists:pacientes,id',
            'medico_id' => 'exists:medicos,id',
            'consultorio_id' => 'exists:consultorios,id',
            'fecha_hora' => 'date',
            'estado' => 'string|max:255',
            'motivo' => 'string|max:255',
        ]);

        if ($validador->fails()) {
            return response()->json($validador->errors(), 422);
        }

        $cita->update($request->all());
        return response()->json($cita);
    }

    public function destroy(string $id){
        $cita = Citas::find($id);

        if (!$cita) {
            return response()->json(['message' => 'Cita no encontrada'], 404);
        }

        $cita->delete();
        return response()->json(['message' => 'Cita eliminada']);
    }

    public function listarCitasPendientes() {
        $citas = Citas::where('estado', 'pendiente')->get();
        return response()->json($citas);
    }

    public function listarCitasDeHoy() {
        $hoy = now()->toDateString(); 
        $citas = Citas::whereDate('fecha_hora', $hoy)->get();
        return response()->json($citas);
    }


}


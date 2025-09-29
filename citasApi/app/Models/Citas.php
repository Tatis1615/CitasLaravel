<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citas extends Model{
    protected $fillable = [
        'paciente_id',
        'medico_id',
        'consultorio_id',
        'fecha_hora',
        'estado',
        'motivo',
    ];


    public function pacientes(){
        return $this->belongsTo(Pacientes::class, 'paciente_id');
    }
    public function medicos(){
        return $this->belongsTo(Medicos::class, 'medico_id');
    }
    public function consultorios(){
        return $this->belongsTo(Consultorios::class, 'consultorio_id'); 
    }

}

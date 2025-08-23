<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicos extends Model{
    protected $fillable = [
        'especialidad_id',
        'nombre_m',
        'apellido_m',
        'edad', 
        'telefono',
    ];

    public function especialidades(){
        return $this->belongsTo(Especialidades::class, 'especialidad_id');
    }

    public function citas(){
        return $this->hasMany(Citas::class, 'medico_id');
    }
}

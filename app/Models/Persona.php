<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    
    protected $table = 'personas';
    
    public $timestamps = false;
    
    protected $fillable = [
        'rut',
        'nombre',
        'apellido',
        'correo',
        'estado'
    ];
    
    /**
     * Relación con acciones
     */
    public function acciones()
    {
        return $this->hasMany(Accion::class, 'persona_id');
    }
    
    /**
     * Accessor para obtener el nombre completo
     */
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }
    
    // TODO: Implementar métodos para futuras funcionalidades
    // - Método para validar RUT chileno
    // - Método para buscar por RUT
    // - Método para obtener personas activas
    // - Método para asociar con acciones de rendiciones
}

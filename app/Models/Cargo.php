<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;
    
    protected $table = 'cargos';
    
    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
        'estado'
    ];
    
    /**
     * Relación con acciones
     */
    public function acciones()
    {
        return $this->hasMany(Accion::class, 'cargo_id');
    }
    
    // TODO: Implementar métodos para futuras funcionalidades
    // - Método para obtener cargos activos
    // - Método para buscar por nombre
    // - Método para validar jerarquías de cargos
    // - Método para asociar con acciones de rendiciones
}

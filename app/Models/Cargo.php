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
}

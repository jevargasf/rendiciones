<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subvencion extends Model
{
    use HasFactory;
    
    protected $table = 'subvenciones';
    
    public $timestamps = false;
    
    protected $fillable = [
        'decreto',
        'monto',
        'fecha_asignacion',
        'destino',
        'rut',
        'organizacion',
        'estado'
    ];
    
    protected $casts = [
        'fecha_asignacion' => 'datetime',
        'monto' => 'integer'
    ];
    
    /**
     * Relación con rendiciones
     */
    public function rendiciones()
    {
        return $this->hasMany(Rendicion::class, 'subvencion_id');
    }
}

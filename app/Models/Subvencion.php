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
        'nombre_organizacion',
        'estado',
        'motivo_eliminacion'
    ];
    
    protected $casts = [
        'fecha_asignacion' => 'datetime',
        'monto' => 'integer'
    ];
    
    /**
     * Accessor para formatear el RUT
     */
    public function getRutFormateadoAttribute()
    {
        $rut = $this->rut;
        if (empty($rut)) {
            return '';
        }
        
        // Remover puntos y guiones existentes
        $rut = str_replace(['.', '-'], '', $rut);
        
        // Separar número y dígito verificador
        $numero = substr($rut, 0, -1);
        $dv = substr($rut, -1);
        
        // Formatear número con puntos
        $numeroFormateado = number_format($numero, 0, ',', '.');
        
        return $numeroFormateado . '-' . strtoupper($dv);
    }
    
    /**
     * Relación con rendiciones
     */
    public function rendiciones()
    {
        return $this->hasMany(Rendicion::class, 'subvencion_id');
    }
}

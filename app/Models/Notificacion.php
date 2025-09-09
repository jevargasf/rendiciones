<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;
    
    protected $table = 'notificaciones';
    
    public $timestamps = false;
    
    protected $fillable = [
        'fecha_envio',
        'fecha_lectura',
        'estado_notificacion',
        'accion_id',
        'estado'
    ];
    
    protected $casts = [
        'fecha_envio' => 'datetime',
        'fecha_lectura' => 'datetime',
        'estado_notificacion' => 'boolean'
    ];
    
    
    /**
     * Relación con acción
     */
    public function accion()
    {
        return $this->belongsTo(Accion::class, 'accion_id');
    }
    
    /**
     * Relación con rendición a través de acción
     */
    public function rendicion()
    {
        return $this->accion->rendicion();
    }
}

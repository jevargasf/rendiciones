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
        'tipo_notificacion',
        'fecha_envio',
        'fecha_lectura',
        'estado_notificacion_id',
        'rendicion_id',
        'estado'
    ];
    
    protected $casts = [
        'fecha_envio' => 'datetime',
        'fecha_lectura' => 'datetime',
        'estado_notificacion_id' => 'boolean'
    ];
    
    /**
     * Relación con tipo de notificación
     */
    public function tipoNotificacion()
    {
        return $this->belongsTo(TipoNotificacion::class, 'tipo_notificacion');
    }
    
    /**
     * Relación con rendición
     */
    public function rendicion()
    {
        return $this->belongsTo(Rendicion::class, 'rendicion_id');
    }
}

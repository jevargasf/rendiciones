<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rendicion extends Model
{
    use HasFactory;
    
    protected $table = 'rendiciones';
    
    public $timestamps = false;
    
    protected $fillable = [
        'subvencion_id',
        'estado_rendicion_id',
        'estado'
    ];
    
    /**
     * Relación con subvención
     */
    public function subvencion()
    {
        return $this->belongsTo(Subvencion::class, 'subvencion_id');
    }
    
    /**
     * Relación con estado de rendición
     */
    public function estadoRendicion()
    {
        return $this->belongsTo(EstadoRendicion::class, 'estado_rendicion_id');
    }
    
    /**
     * Relación con acciones
     */
    public function acciones()
    {
        return $this->hasMany(Accion::class, 'rendicion_id');
    }
    
    /**
     * Relación con notificaciones a través de acciones
     */
    // public function notificaciones()
    // {
    //     return $this->hasManyThrough(Notificacion::class, Accion::class, 'rendicion_id', 'accion_id');
    // }
}


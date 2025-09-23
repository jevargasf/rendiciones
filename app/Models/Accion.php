<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accion extends Model
{
    use HasFactory;
    
    protected $table = 'acciones';
    
    public $timestamps = false;
    
    protected $fillable = [
        'fecha',
        'comentario',
        'estado_rendicion',
        'km_rut',
        'km_nombre',
        'rendicion_id',
        'persona_id',
        'cargo_id',
        'estado'
    ];
    
    protected $casts = [
        'fecha' => 'datetime'
    ];
    
    /**
     * Relación con rendición
     */
    public function rendicion()
    {
        return $this->belongsTo(Rendicion::class, 'rendicion_id');
    }
    
    /**
     * Relación con persona
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    
    /**
     * Relación con cargo
     */
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }

    public function notificacion()
    {
        return $this->hasOne(Notificacion::class, 'accion_id');
    }
}

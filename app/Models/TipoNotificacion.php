<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoNotificacion extends Model
{
    use HasFactory;
    
    protected $table = 'tipos_notificaciones';
    
    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
        'mensaje',
        'estado'
    ];
    
    /**
     * Relación con notificaciones
     */
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'tipo_notificacion');
    }
}

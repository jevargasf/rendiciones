<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoRendicion extends Model
{
    use HasFactory;
    
    protected $table = 'estados_rendiciones';
    
    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
        'estado'
    ];
    
    /**
     * Relación con rendiciones
     */
    public function rendiciones()
    {
        return $this->hasMany(Rendicion::class, 'estado_rendicion_id');
    }
}

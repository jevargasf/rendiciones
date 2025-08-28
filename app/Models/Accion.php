<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accion extends Model
{
    use HasFactory;
    
    protected $table = 'acciones';

    public $timestamps = false;

    protected $guarded = ['token'];

    protected $attributes = [
        'estado' => '1',
    ];
}

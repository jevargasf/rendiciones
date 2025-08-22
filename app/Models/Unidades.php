<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidades extends Model
{
    use HasFactory;

    protected $table = 'unidades';
    
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $attributes = [
        'estado' => '1',
    ];
}

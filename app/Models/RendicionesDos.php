<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendicionesDos extends Model
{
    use HasFactory;
    
    protected $table = 'rendiciones';

    public $timestamps = false;

    protected $guarded = ['token'];

    protected $attributes = [
        'estado' => '1',
    ];
}

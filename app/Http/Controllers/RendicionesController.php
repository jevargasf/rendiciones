<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rendiciones;

class RendicionesController extends Controller
{


    public function index(Request $request)
    {
        $rendiciones = Rendiciones::leftjoin('subvenciones', 'rendiciones.subvencion_id', 'subvenciones.id')
        ->leftJoin('organizaciones', 'subvenciones.organizacion_id', 'organizaciones.id')
        ->select(
            'rendiciones.*',
            'subvenciones.fecha AS fechaSubvencion',
            'subvenciones.decreto',
            'subvenciones.monto AS montoSubvencion',
            'organizaciones.nombre AS nombreOrganizacion',
            'organizaciones.rut AS rutOrganizacion',

        )
        ->where('rendiciones.estado', 1)->get();

       // dd($subvenciones);
       
        return view(
            
            'rendiciones.index',

            compact('rendiciones')
        
        );

            
    }
}





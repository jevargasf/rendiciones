<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subvenciones;

class SubvencionesController extends Controller
{


    public function index()
    {
        $subvenciones = Subvenciones::leftjoin('organizaciones', 'subvenciones.organizacion_id', 'organizaciones.id')
            ->select(
                'subvenciones.*',
                'organizaciones.nombre AS nombreOrganizacion',
                'organizaciones.rut AS rutOrganizacion',
            )
            ->where('subvenciones.estado', 1)->get();

        // dd($subvenciones);

        return view(

            'subvenciones.index',

            compact('subvenciones')

        );
    }

    public function crear(Request $request)
    {
        //dd($request);
        if ($request->isMethod('post')) {

            $request->validate([

                'fecha_decreto' => 'required',
                'numero_decreto' => 'required'

            ]);
            $subvenciones = Subvenciones::create([
            'organizacion_id'=>'1',
            'decreto'=>$request->numero_decreto,
            'monto'=>'1',
            'destino'=>'1',
            'fecha'=>$request->fecha_decreto,
            
            ]);

            return response()->json(['success'=>true,'message'=>'Subvención registrada con exito']);
        }
    }
}

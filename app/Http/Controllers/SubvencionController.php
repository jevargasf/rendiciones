<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subvencion;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class SubvencionController extends Controller
{


    public function index()
    {
        $subvenciones = Subvencion::leftjoin('organizaciones', 'subvenciones.organizacion_id', 'organizaciones.id')
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
        //dd('prueba');
        try{
            // validar formulario
            $request->validate([

                'fecha_decreto' => 'required',
                'numero_decreto' => 'required'

            ]);
            // validar xls
            $file = File::types(['xls', 'xlsx']);
            if($file){
                // almacenar xls
                Storage::disk('local')->put('xls', $request->seleccionar_archivo);

                // leer xls
                
                
                // crear registros de subvenciones
                $subvenciones = Subvencion::create([
                'organizacion_id'=>'1',
                'decreto'=>$request->numero_decreto,
                'monto'=>'1',
                'destino'=>'1',
                'fecha'=>$request->fecha_decreto,
                
                ]);

                // retornar repsuesta
                return response()->json(['success'=>true,'message'=>'Subvenciones registradas con exito']);

            } else {
                return response()->json([
                    'success'=>false,
                    'message'=>'La extensión del archivo es inválida'
                ]);
            }

        } catch (Exception $e){
            return response()-> json([
                'success'=>false,
                'message'=>$e->getMessage()
            ]);
        }
    }
}

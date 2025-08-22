<?php

namespace App\Http\Controllers;

use App\Models\Rendiciones;
use App\Models\Acciones;
use Illuminate\Http\Request;
use App\Models\Subvenciones;

class RendicionesDosController extends Controller
{


    public function index()
    {
        $rendiciones = Rendiciones::leftjoin('subvenciones', 'rendiciones.subvencion_id', 'subvenciones.id')
            ->leftjoin('organizaciones', 'subvenciones.organizacion_id', 'organizaciones.id')
            ->leftjoin('personas', 'rendiciones.persona_id', 'personas.id')
            ->leftjoin('cargos', 'rendiciones.cargo_id', 'cargos.id')
            ->select(
                'rendiciones.*',
                'subvenciones.decreto AS decretoSubvenciones',
                'subvenciones.monto AS montoSubvenciones',
                'organizaciones.nombre AS nombreOrganizaciones',
                'organizaciones.rut AS rutOrganizaciones',
            )
            ->where('rendiciones.estado', 1)->get();

        $pendientes = Rendiciones::leftjoin('subvenciones', 'rendiciones.subvencion_id', 'subvenciones.id')
            ->leftjoin('organizaciones', 'subvenciones.organizacion_id', 'organizaciones.id')
            ->leftjoin('personas', 'rendiciones.persona_id', 'personas.id')
            ->leftjoin('cargos', 'rendiciones.cargo_id', 'cargos.id')
            ->select(
                'rendiciones.*',
                'subvenciones.decreto AS decretoSubvenciones',
                'subvenciones.monto AS montoSubvenciones',
                'organizaciones.nombre AS nombreOrganizaciones',
                'organizaciones.rut AS rutOrganizaciones',
            )
            ->where('rendiciones.estado', 2)->get();


        $observadas = Rendiciones::leftjoin('subvenciones', 'rendiciones.subvencion_id', 'subvenciones.id')
            ->leftjoin('organizaciones', 'subvenciones.organizacion_id', 'organizaciones.id')
            ->leftjoin('personas', 'rendiciones.persona_id', 'personas.id')
            ->leftjoin('cargos', 'rendiciones.cargo_id', 'cargos.id')
            ->select(
                'rendiciones.*',
                'subvenciones.decreto AS decretoSubvenciones',
                'subvenciones.monto AS montoSubvenciones',
                'organizaciones.nombre AS nombreOrganizaciones',
                'organizaciones.rut AS rutOrganizaciones',
            )
            ->where('rendiciones.estado', 3)->get();

        $rechazadas = Rendiciones::leftjoin('subvenciones', 'rendiciones.subvencion_id', 'subvenciones.id')
            ->leftjoin('organizaciones', 'subvenciones.organizacion_id', 'organizaciones.id')
            ->leftjoin('personas', 'rendiciones.persona_id', 'personas.id')
            ->leftjoin('cargos', 'rendiciones.cargo_id', 'cargos.id')
            ->select(
                'rendiciones.*',
                'subvenciones.decreto AS decretoSubvenciones',
                'subvenciones.monto AS montoSubvenciones',
                'organizaciones.nombre AS nombreOrganizaciones',
                'organizaciones.rut AS rutOrganizaciones',
            )
            ->where('rendiciones.estado', 4)->get();




        // dd($rendiciones);

        return view(

            'rendicionesDos.index',

            compact('rendiciones', 'pendientes', 'observadas', 'rechazadas')

        );
    }

    public function detalleRendicion(Request $request, Acciones $idAccion) /** detalleRendicion es el mismo nombre de la ruta, Así Laravel sabe qué método ejecutar cuando llega una petición a esa ruta*/
    {
        $acciones = Acciones:: leftjoin ('tipos_acciones', 'acciones.tipo_accion_id', 'tipos_acciones.id')
            ->leftjoin ('usuarios', 'acciones.usuario_id', 'usuarios.id')
        
        
        -> select( /**Referido al modal acciones al ingresar a Detalle de rendición*/
                'acciones.*',
                'tipos_acciones.descripcion AS descripcion',
                'usuarios.nombre AS usuario',

        /**Se crea una consulta de Base de Datos, guardando el resultado en la variable $acciones */
            )       
            ->where('acciones.estado', 1)           /**Traer solo los registros de la tabla acciones donde la columna estado sea igual a 1*/
            ->where('acciones.rendicion_id', $request->id) /**“Además, solo quiero las acciones que tengan en la columna rendicion_id el mismo valor que el id que recibí en la petición*/
            ->get();

        return response() ->json([ /**Devuelve todas las acciones que encontró la consulta en formato JSON */
            'acciones'=>$acciones,





        ]);
        

    }
    
    
}



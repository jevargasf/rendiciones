<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subvencion;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\Routing\Controller as BaseController;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class SubvencionController extends BaseController
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
            $file_extension = File::types(['xls', 'xlsx']);
            // se almacena si es válido
            if($file_extension){
                // almacenar el archivo en storage de la aplicación
                $xls_saved = Storage::disk('local')->put('xls', $request->seleccionar_archivo);
                
                // mejora: identificar extensión para crear el lector xls o xlsx
                
                // leer archivo subido
                $file = $request->seleccionar_archivo;
                $xls_reader = new Xlsx();
                $xls_reader->setReadDataOnly(true);
                $spreadsheet = $xls_reader->load($file);

                // mejora: 1) ver si vienen varias hojas y 2) cargar la data por cada hoja
                $worksheet_collection = $spreadsheet->getAllSheets();
                // contar la cantidad de hojas que trae el archivo
                count($worksheet_collection);
                $hoja = $worksheet_collection[0];
                // dimensiones de columna y fila del archivo
                $columna_max = $hoja->getHighestDataColumn();
                $fila_max = $hoja->getHighestDataRow();
                // mejora ¿y si alguien sube un archivo con la data en otra fila o columna?
                // colección de celdas (la data certera)
                $xls_headers = $hoja->rangeToArray("A1:$columna_max".'1');
                $xls_data = $hoja->rangeToArray("A2:$columna_max$fila_max", null, true, true, true);

                // crear registros de subvenciones
                foreach($xls_data as $data){
                    //dd($data);
                    // validar data para cada fila


                    // buscar o crear registro de rut organización
                    

                    // crear registro
                    Subvencion::create([
                        'organizacion_id'=>$data['A'],
                        'decreto'=>$request->numero_decreto,
                        'monto'=>$data['C'],
                        'destino'=>$data['D'],
                        'fecha'=>$data['E']
                    ]);
                }

                // retornar repsuesta
                return response()->json(['success'=>true,'message'=>'Subvenciones registradas con éxito']);

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

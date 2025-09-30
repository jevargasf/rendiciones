<?php

use Illuminate\Support\Facades\File as FileReader;

if (!function_exists('formatear_fecha')) {
    function conseguirDetalleOrganizacion($subvencion_objeto, $endpoint){
        $data_organizacion = FileReader::get(base_path($endpoint));
        // Adjunta data organización al objeto, rellena con S/D en caso de que no encuentre datos
            $json_organizacion = json_decode($data_organizacion, associative: true);
            $rut_json = $json_organizacion[0]['rut'];
            if ($rut_json == $subvencion_objeto['rut']){
                $subvencion_objeto->data_organizacion = $json_organizacion[0];
            } else {
                $subvencion_objeto->data_organizacion = ['nombre_organizacion' => 'S/D'];
            }
        return $subvencion_objeto;
    }
}

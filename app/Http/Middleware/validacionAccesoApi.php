<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class validacionAccesoApi
{
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');
        $apiToken = str_replace('Bearer ', '', $authHeader);
        $tokenEnv = config('app.km_token_verify');

        // verificar si el token de API es correcto
        if ($apiToken !== $tokenEnv) {
            return response()->json(['errors' => 'Token de API inválido'], 401);
        }

        $curl = curl_init();

        $postData = array(
            "aplicacion_id" => $request['aplicacion_id'],
            "aplicacion_token" => $request['aplicacion_token']
        );

        // Convertir el array a formato JSON
        $jsonData = json_encode($postData);

        curl_setopt_array($curl, array(
            CURLOPT_URL => config('app.api').'api/permiso-mail',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonData, // Usar la variable con los datos JSON
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $tokenEnv
            ),
        ));

        $response = curl_exec($curl);

        $data = json_decode($response, JSON_UNESCAPED_UNICODE);

        if (empty($data)) {
            return response()->json(['error' => 'Error de validación, la aplicacion no tiene acceso'], 403);
        }

        return $next($request);
    }
}

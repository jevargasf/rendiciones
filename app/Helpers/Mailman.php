<?php
namespace App\Helpers;

use Exception;

class Mailman
{
    private $endpoint;
    private $tokenAuthorization;
    private $atributos = [];
    public function __construct(array $data, $tipoEndpoint = 'send')
    {
        $baseUrl = config('app.mailman') . 'api/';
        $this->endpoint = $tipoEndpoint === 'scheduled' ? $baseUrl . 'scheduled' : $baseUrl . 'send';
        $this->tokenAuthorization = config('app.km_token_verify');

        $this->atributos = array_merge([
            'aplicacion_id' => config('app.app_km_id'),
            'aplicacion_token' => config('app.app_km_token'),
            'aplicacion_nombre' => config('app.app_nombre'),
        ], $data['email']);

        $this->atributos['datos'] = $data['contenido'] ?? [];
    }

    public function enviarEmail()
    {
        $curlHandle = curl_init($this->endpoint);

        if ($curlHandle === false) {
            throw new Exception('Error al inicializar la sesión cURL.');
        }

        $jsonDatos = json_encode($this->atributos, JSON_UNESCAPED_UNICODE);

        if ($jsonDatos === false) {
            throw new Exception('Error al codificar los datos de la solicitud como JSON.');
        }

        curl_setopt_array($curlHandle, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $jsonDatos,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->tokenAuthorization,
            ],
        ]);

        $response = curl_exec($curlHandle);

        $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);

        if ($response === false) {
            $error = curl_error($curlHandle);
            curl_close($curlHandle);
            throw new Exception("Error de cURL: $error");
        }

        curl_close($curlHandle);

        $decodedResponse = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Error al decodificar la respuesta JSON: ' . json_last_error_msg());
        }

        return [
            'http_code' => $httpCode,
            'response' => $decodedResponse,
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    public function index(Request $request)
    {

        if ($request->isMethod('POST') || $request->isMethod('GET')) {


            $token = $request->token_auth ?? $request->query('token_auth');

            try {

                $isValidToken = JWTAuth::setToken($token)->check();

                if ($isValidToken) {

                    $payload = JWTAuth::setToken($token)->getPayload();
                    $dataPayload = $payload->toArray();

                    $curl = curl_init();

                    $postData = [
                        "usuario_token" => $dataPayload['data']['usuario_token'],
                        "aplicacion_token" => $dataPayload['data']['aplicacion_token'],
                    ];

                    $jsonData = json_encode($postData);

                    // dd($jsonData);

                    curl_setopt_array($curl, [
                        CURLOPT_URL => config('app.api') . 'api/validar-acceso',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => $jsonData,
                        CURLOPT_HTTPHEADER => [
                            'Content-Type: application/json',
                            'Authorization: Bearer ' . $token
                        ],
                    ]);

                    // RESPUESTA DE VALIDAR KM
                    $response = curl_exec($curl);

                    // dd($response);

                    $data = json_decode($response, true);
                    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                    curl_close($curl);
                    if ($data && $httpCode == 200) {

                        // /* ----------------------------------------------*/
                        // ///////////////////////////////////////////////////////
                        // // LOGICA PROPIA DE LA APLICACIÓN
                        // ///////////////////////////////////////////////////////
                        $userApp = Usuarios::where('id_km', $data['usuario']['usuario_id'])->first();
                    
                        $usuario = $data["usuario"];
                        
                        if (!$userApp) {

                            $id_perfil_km = null;

                            foreach ($data["aplicacion"]["perfiles"] as $perfil) {
                                if ($perfil["perfil_id_km"] == 1) {
                                    $id_perfil_km = $perfil["perfil_id_km"];
                                    break; // Si encuentra el 1, tiene perfil de admin
                                }
                                if ($id_perfil_km === null) {
                                    $id_perfil_km = $perfil["perfil_id_km"]; // Guarda el primer perfil encontrado
                                }
                            }    

                            $usuarioCreate = Usuarios::create([
                                'run' => $data['usuario']['run'],
                                'nombres' => $data['usuario']['nombres'],
                                'apellido_paterno' => $data['usuario']['apellido_paterno'],
                                'apellido_materno' => $data['usuario']['apellido_materno'],
                                'telefono' => $data['usuario']['telefono'],
                                'email' => $data['usuario']['email'],
                                'fk_unidad_id' => 1, // valor por defecto
                                'id_km' => $data['usuario']['usuario_id'],
                                'id_perfil_km' => $id_perfil_km,
                            ]);

                            $usuario = $usuarioCreate->toArray();

                        } else
                            $usuario = $userApp->toArray();

                        $data["usuario"] = $usuario;

                        ///////////////////////////////////////////////////////
                        // INICIAR SESIÓN Y REDIRECCIONAR AL PERFIL POR DEFECTO
                        //////////////////////////////////////////////////////
                        $data["token_api"] = $token;
                        $this->iniciarLogin($data);
                        return $this->redireccionarPerfil($data);
                    } else {
                        echo "Error en la solicitud. Código de estado: " . $httpCode;
                    }
                }
            } catch (Exception $e) {
                // Manejar excepción
            }
        }

        if (session()->has("token_api")) {
            $token = session()->get("token_api");
            try {
                $isValidToken = JWTAuth::setToken($token)->check();

                if ($isValidToken) {
                    return $this->redireccionarPerfil(session()->get("aplicacion"));
                } else {
                    return redirect('logout');
                }
            } catch (Exception $e) {

                return redirect('logout');
            }
        } else {
            return redirect(config('app.auth') . '?redirect_uri=' . urlencode(config('app.url')));
        }
    }

    public function seleccionarPerfil(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->has('btnSeleccionarPerfiles')) {
                $cookie = Cookie::forget(config('app.name') . "_config-km");
                return redirect('perfiles')->withCookie($cookie);
            }
        }

        if (!$request->session()->isStarted()) {
            $request->session()->start();
        }
        Session::forget('perfil');
        Session::forget('modules');



        if ($request->session()->has('perfiles')) {

            $alertas = [];
            $perfiles = $request->session()->get('perfiles', []);

            if ($request->isMethod('post')) {
                if ($request->has('btnIngresar')) {
                    $request->validate([
                        'perfil' => 'required',
                    ]);

                    $perfilSeleccionadoId = $request['perfil'];

                    foreach ($perfiles as $perfil) {
                        if ($perfil['perfil_id_km'] == $perfilSeleccionadoId) {
                            session()->put('perfil', $perfil);

                            if (isset($perfil["credenciales"]["modules"])) {
                                $modulo = $perfil["credenciales"]["modules"];
                                $defaultRoute = $modulo['default'];

                                $cookie = Cookie::make(
                                    config('app.name') . "_config-km", // Nombre de la cookie
                                    json_encode(["credencial_token" => $perfil["credenciales"]["token"]], JSON_UNESCAPED_UNICODE), // Valor de la cookie
                                    60, // Duración en minutos (opcional)
                                    '/', // Ruta (opcional)
                                    '', // Dominio (opcional)
                                    false, // Secure (opcional, true si solo se debe enviar sobre HTTPS)
                                    false // HttpOnly (opcional, true para deshabilitar la lectura por JavaScript)
                                );
                                return redirect($defaultRoute)
                                    ->withCookie($cookie);
                            } else {
                                $alertas[] = "Error: No se pudo encontrar la configuración de módulos para el perfil seleccionado.";
                            }
                            break;
                        }
                    }
                }
            }

            return view('auth.perfilSelector', [
                'titulo' => 'Perfiles',
                'perfiles' => $perfiles,
                'alertas' => $alertas
            ]);
        } else {
            return redirect(config('app.auth'));
        }
    }


    public function logout(Request $request)
    {
        //Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Cookie::queue(Cookie::forget(config('app.name') . "_config-km"));
        return redirect(config('app.auth'));
    }

    private function iniciarLogin($data)
    {
        session()->put('usuario', $data["usuario"]);
        session()->put('aplicacion', $data["aplicacion"]);
        session()->put('token_api', $data["token_api"]);
    }
    private function redireccionarPerfil($aplicacion)
    {
        if (count($aplicacion["perfiles"]) === 1) {
            session()->put('perfil', $aplicacion["perfiles"][0]);
            $default = $aplicacion["perfiles"][0]["credenciales"]["modules"]["default"];

            $cookie = Cookie::make(
                config('app.name') . "_config-km", // Nombre de la cookie
                json_encode(["credencial_token" => $aplicacion["perfiles"][0]["credenciales"]["token"]], JSON_UNESCAPED_UNICODE), // Valor de la cookie
                60, // Duración en minutos (opcional)
                '/', // Ruta (opcional)
                '', // Dominio (opcional)
                false, // Secure (opcional, true si solo se debe enviar sobre HTTPS)
                false // HttpOnly (opcional, true para deshabilitar la lectura por JavaScript)
            );

            return redirect($default)
                ->withCookie($cookie);
        } else {
            if (session()->has('perfil')) {
                return redirect(session()->get('perfil.credenciales.modules.default'));
            } else {
                $cookie = Cookie::forget(config('app.name') . "_config-km");
                session()->put('perfiles', $aplicacion["perfiles"]);
                return redirect('perfiles')->withCookie($cookie);
            }
        }
    }
}
//
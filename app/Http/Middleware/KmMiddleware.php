<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KmMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (!session()->has('perfil')) {
            return redirect(config('app.auth'));
        }

        $permissionsArray = session('perfil.credenciales.modules');

        // Toma la ruta actual
        $uri = $request->route()->uri();
        $currentPath = $uri === '/' ? $uri : '/' . $uri;

        // dd($currentPath);

        if ($permissionsArray) {
            $resource = collect($permissionsArray['resources'])->firstWhere('path', $currentPath);

            if ($resource) {
                // Permisos según el método HTTP de la solicitud
                $methodPermissionsMap = [
                    'get' => 'read',
                    'post' => 'create',
                    'put' => 'update',
                    'patch' => 'update',
                    'delete' => 'delete',
                ];

                // toma el mtodo HTTP para convertir en minuscula
                $method = strtolower($request->method());

                // Ve si el permiso de la peticion actual esta disponible y es true
                $permissionGranted = $resource['permissions'][$methodPermissionsMap[$method]]['can'] ?? false;

                if (!$permissionGranted) {
                    if (isset($permissionsArray['default'])) {
                        $permissionDefault = collect($permissionsArray['resources'])->firstWhere('path', $permissionsArray['default']);
                        if ($permissionDefault["permissions"]["read"]['can']) {
                            return redirect($permissionsArray['default'])->with('error', 'No dispone de acceso para esta funcionalidad');
                        } else
                            return back();
                    }
                }

                return $next($request);
            }
            if (isset($permissionsArray['default'])) {
                $permissionDefault = collect($permissionsArray['resources'])->firstWhere('path', $permissionsArray['default']);
                if ($permissionDefault["permissions"]["read"]['can']) {
                    return redirect($permissionsArray['default'])->with('error', 'No dispone de acceso para esta funcionalidad');
                } else
                    return back();
            }
        }
        ;

        return redirect(config('app.auth'));
    }
}
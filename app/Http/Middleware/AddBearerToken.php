<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddBearerToken
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // $token = $request->header('Authorization');
        // $token = str_replace('Bearer ', '', $token);

        // // verificar si el token se envió en la petición
        // if (!$token) {
        //     return response()->json(['message' => 'Token no enviado'], 401);
        // }

        // // verificar si el token es válido
        // if ($token !== env('APP_API_TOKEN')) {
        //     return response()->json(['message' => 'Token inválido'], 401);
        // }

        return $next($request);
    }
}

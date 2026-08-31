<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarTokenPanel
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('X-Panel-Token');

        if (!$token || $token !== env('PANEL_API_TOKEN')) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        return $next($request);
    }
}
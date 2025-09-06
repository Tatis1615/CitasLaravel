<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user(); 

        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        if (!in_array($user->role, $roles)) {
            return response()->json(['error' => 'Rol no autorizado'], 403);
        }

        return $next($request);
    }

}

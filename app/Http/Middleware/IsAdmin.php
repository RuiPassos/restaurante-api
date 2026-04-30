<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Se o utilizador não for admin (proprietário), bloqueia o acesso
        if (!$request->user()?->isAdmin()) {
            return response()->json(['message' => 'Acesso reservado ao proprietário.'], 403);
        }

        // Se for admin, deixa passar
        return $next($request);
    }
}

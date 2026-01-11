<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsOrganizer
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar se o user está autenticado
        if (!Auth::check()) {
            abort(401, 'Precisas de fazer login.');
        }

        // Verificar se é admin ou organizer
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'organizer') {
            return $next($request);
        }

        // Se não for, bloquear acesso
        abort(403, 'Não tens permissão para aceder a esta área. Apenas Organizadores e Administradores.');
    }
}
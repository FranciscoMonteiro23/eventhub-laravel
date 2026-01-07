<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se está autenticado
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Verifica se é admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acesso negado. Apenas administradores.');
        }

        return $next($request);
    }
}
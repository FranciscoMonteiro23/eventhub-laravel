<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsOrganizer
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se está autenticado
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Verifica se é organizador OU admin
        $userRole = Auth::user()->role;
        if ($userRole !== 'organizer' && $userRole !== 'admin') {
            abort(403, 'Acesso negado. Apenas organizadores.');
        }

        return $next($request);
    }
}
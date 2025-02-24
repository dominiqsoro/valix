<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckActiveUser
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifie si l'utilisateur est authentifié et si son statut est "actif"
        if (Auth::check() && Auth::user()->status !== 'active') {
            return redirect()->route('Welcome');  // Redirige vers la page d'accueil si l'utilisateur n'est pas actif
        }

        return $next($request);
    }
}

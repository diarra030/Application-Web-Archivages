<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
                // Vérifier si la licence est valide
        if (AUth::user()->role->nom === "Utilisateur") {
            // Rediriger vers une page d'erreur ou afficher un message si la licence n'est pas valide
            return redirect()->back();
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Licence;

class CheckLicence
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si la licence est valide
        if (!Licence::isValid()) {
            // Rediriger vers une page d'erreur ou afficher un message si la licence n'est pas valide
            return redirect()->route('login')->with('error', 'Licence expirée.');
        }

        // Vérifier si la licence est verifié
        if (!Licence::isVerified()) {
            // Rediriger vers une page d'erreur ou afficher un message si la licence n'est pas valide
            return redirect()->route('login')->with('error', 'Verifier la licence.');
        }

        return $next($request);
    }
}

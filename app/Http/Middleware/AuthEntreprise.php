<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthEntreprise
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('entreprise_id')) {
            return redirect()->route('entreprise.login')
                ->with('error', 'Connectez-vous pour accéder à cette page.');
        }
        return $next($request);
    }
}
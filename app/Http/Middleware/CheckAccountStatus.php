<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guards = ['candidat', 'entreprise', 'admin'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Admins don't have a statut_compte column in the DB specification, so check if attribute exists
                if (isset($user->statut_compte) && $user->statut_compte !== 'actif') {
                    Auth::guard($guard)->logout();
                    
                    $message = $user->statut_compte === 'suspendu' 
                        ? 'Votre compte a été suspendu. Veuillez contacter le support.' 
                        : 'Ce compte n\'existe plus.';

                    $redirectRoute = match($guard) {
                        'entreprise' => 'entreprise.login',
                        'admin' => 'admin.login',
                        default => 'login',
                    };

                    return redirect()->route($redirectRoute)->withErrors(['email' => $message]);
                }
            }
        }

        return $next($request);
    }
}

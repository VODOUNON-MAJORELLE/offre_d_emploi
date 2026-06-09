<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuestEntreprise
{
    public function handle(Request $request, Closure $next)
    {
        if (session('entreprise_id')) {
            return redirect()->route('entreprise.dashboard');
        }
        return $next($request);
    }
}
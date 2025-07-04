<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AutenticacionRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            $rolClave = $user->clave;
            switch ($rolClave){
                case 'admin': // admin procede a todos lados
                    return $next($request);
                    break;
                case 'estudiante':
                    return redirect()->route('dashboard.estudiante');
                    break;
                case 'tutor':
                    return redirect()->route('dashboard.tutor');
                    break;
                    case 'profesorsustituto':
                        return redirect()->route('dashboard.profesor');
                        break;
                case 'profesortitular':
                        return redirect()->route('dashboard.profesor');
                        break;
            }
        }


        return $next($request);
    }
}

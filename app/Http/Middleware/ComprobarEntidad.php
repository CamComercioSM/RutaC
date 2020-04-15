<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class ComprobarEntidad
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $usuario = User::where('usuarioID', Auth::user()->usuarioID)->with('empresas', 'emprendimientos')->first();

        if ($usuario->perfilCompleto == 'No') {
            return redirect('user.completar-perfil');
        }

        if ($usuario->empresas->count() > 0) {
            $request->session()->put('tiene_entidad', '1');
            return $next($request);
        }

        if ($usuario->emprendimientos->count() > 0) {
            $request->session()->put('tiene_entidad', '1');
            return $next($request);
        }

        $request->session()->put('tiene_entidad', '0');
        return redirect('user.home');
    }
}

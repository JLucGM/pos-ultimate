<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserLogin
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
        $user = $request->user();
        if (! $user) {
            return $next($request);
        }

        if (($user->user_type != 'user' || $user->allow_login != 1) && request()->segment(1) != 'home') {
            abort(403, 'Unauthorized action.');
        }

        // Control de Sesión Única (Single Device Login):
        // Si el usuario tiene una sesión activa registrada y la sesión actual no coincide,
        // significa que inició sesión en otro dispositivo.
        if (! empty($user->active_session_id) && $request->session()->getId() !== $user->active_session_id) {
            Auth::logout();
            $request->session()->flush();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => 0,
                    'msg' => __('lang_v1.session_expired_logged_in_another_device'),
                ], 401);
            }

            return redirect('/login')->with('status', [
                'success' => 0,
                'msg' => __('lang_v1.session_expired_logged_in_another_device'),
            ]);
        }

        return $next($request);
    }
}


<?php

namespace App\Http\Middleware;

use App\Business;
use App\Utils\BusinessUtil;
use Closure;
use Illuminate\Support\Facades\Auth;

class SetSessionData
{
    /**
     * Checks if session data is set or not for a user. If data is not set then set it.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Verificación de Sesión Única: Cierra sesión si la cuenta fue abierta en otro dispositivo
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
            } elseif (empty($user->active_session_id)) {
                $user->active_session_id = $request->session()->getId();
                $user->save();
            }
        }

        if (! $request->session()->has('user')) {
            $business_util = new BusinessUtil;

            $user = Auth::user();
            $session_data = ['id' => $user->id,
                'surname' => $user->surname,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'business_id' => $user->business_id,
                'language' => $user->language,
            ];
            $business = Business::findOrFail($user->business_id);

            $currency = $business->currency;
            $currency_data = ['id' => $currency->id,
                'code' => $currency->code,
                'symbol' => $currency->symbol,
                'thousand_separator' => $currency->thousand_separator,
                'decimal_separator' => $currency->decimal_separator,
            ];

            $request->session()->put('user', $session_data);
            $request->session()->put('business', $business);
            $request->session()->put('currency', $currency_data);

            //set current financial year to session
            $financial_year = $business_util->getCurrentFinancialYear($business->id);
            $request->session()->put('financial_year', $financial_year);
        }

        return $next($request);
    }
}

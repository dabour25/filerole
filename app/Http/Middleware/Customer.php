<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class Customer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('customers')->check()) {
            if (Auth::guard('customers')->check()) {
                if (Auth::guard('customers')->user()->active) {
                    if (Session::has('locale')) {
                        App::setLocale(Session::get('locale'));
                    }else { // This is optional as Laravel will automatically set the fallback language if there is none specified
                        App::setLocale(\App\org::where(['id' => Auth::guard('customers')->user()->org_id])->value('disp_language'));
                        //App::setLocale(Config::get('app.fallback_locale'));
                    }
                    return $next($request);
                } else {
                    return redirect('/login');
                }
            } else {
                return redirect('/dashboard');
            }
        } else {
            return redirect('/login');
        }
    }
}
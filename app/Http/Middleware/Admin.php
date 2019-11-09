<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class Admin
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
if (Auth::guard('web')->check()) {
            if (Auth::guard('web')->check()) {
                if (Auth::guard('web')->user()->is_active) {
                    if (Session::has('locale')) {
                        App::setLocale(Session::get('locale'));
                    }else { // This is optional as Laravel will automatically set the fallback language if there is none specified
                        App::setLocale(\App\org::where(['id' => Auth::user()->org_id])->value('disp_language'));
                        //App::setLocale(Config::get('app.fallback_locale'));
                    }
                    return $next($request);
                } else {
                    return redirect('/admin/login');
                }
            } else {
                Session::forget('isadmin');
                return redirect('/admin/dashboard');
            }
        } else {
            Session::forget('isadmin');
            return redirect('/admin/login');
        }
    }
}
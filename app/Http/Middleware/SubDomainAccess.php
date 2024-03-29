<?php
namespace App\Http\Middleware;

use Closure;

use App\org;
use Redirect;

class SubDomainAccess
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
        $server = explode('.', $request->server('HTTP_HOST'));
        $subdomain = $server[0].'.filerolesys.com';

        // check if sub domain exists, replace with your own conditional check
        if (! org::where('owner_url', $subdomain)->first()) {
            return Redirect::to('http://master.filerolesys.com/register/view'); // or redirect to your homepage route.
        }
        // elseif(org::where('owner_url',$subdomain)->first()->activity_id==null){
        //   return Redirect::to('http://'.$subdomain.'/register/first_setting/');
        // }
        else{
            return $next($request);
        }

        
    }
}

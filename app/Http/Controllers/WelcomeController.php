<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\org;
use App\User;
use Auth;
use App;
use Session;
use DB;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        $server = explode('.', $request->server('HTTP_HOST'));
        $owner_url = $server[0] . '.filerolesys.com';

        $org = org::where('owner_url', $owner_url)->first();
        if ($org != null) {
            $user = User::where('org_id', $org->id)->first();
        }
        return view('welcomeClient', compact('user', 'owner_url'));

    }

    public function masterAutoLogin($token, $lang)
    {
        $user = User::where('auto_login_token', $token)->first();
        if ($user != null) {
            Auth::guard('web')->loginUsingId($user->id);
          
           $user_id = $user->id;
           $funcs = DB::table('functions_user')->where('funcparent_id','0')->where('user_id' ,$user_id)->where('org_id',Auth::user()->org_id)->where('appear','1')->orderBy('porder')->get();
           $sub_funcs = DB::table('functions_user')->where('funcparent_id','>','0')->where('user_id' ,$user_id)->where('org_id',Auth::user()->org_id)->where('appear','1')->orderBy('porder')->get();
           $func_links = DB::table('function_new')->orderBy('porder')->get();

            $partents=Session::put('partents', $funcs);
            $childs=Session::put('childs',  $sub_funcs);
            $links=Session::put('links',  $func_links);
            Session::put('locale', $lang);
            $user->auto_login_token = null;
            $user->save();
            return redirect(url('admin/register/first_setting'));
        } else {
            return redirect()->back();
        }
    }
}

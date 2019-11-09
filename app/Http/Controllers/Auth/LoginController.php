<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
// a.nabiil
use App\loginHistory as logActivity;
use App\Events\Notifications as notifyEvent;
use App\Organization;

// a.nabiil
use Carbon\Carbon;
use App\org;
use Redirect;
use Hash;
use App\Customers;
use Mail;
use App\Mail\SendMailable;
use DB;
use Illuminate\Support\Facades\Session;


use App\loginHistoryCustomer;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function dologin(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        if (Auth::guard('customers')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('http://' . org::where('id', Auth::guard('customers')->user()->org_id)->value('owner_url') . '/dashboard');
        } else {
            return redirect()->back()->withErrors([__('strings.alertError')]);
        }
    }

    public function admin_login(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'email_phone' => 'required',
            'password' => 'required'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
        if(!empty(Organization::where('custom_domain', explode('/', url()->current())[2])->value('custom_domain'))){
            $org_id=Organization::where('custom_domain', explode('/', url()->current())[2])->value('org_id');
        }
        else{
            $org_id=org::where('owner_url',explode('/', url()->current())[2])->first()->id;
        }

        if (Auth::guard('web')->attempt(['email' => $request->email_phone, 'password' => $request->password,'org_id'=>$org_id]) || Auth::guard('web')->attempt(['phone_number' => $request->email_phone, 'password' => $request->password,'org_id'=>$org_id])) {

            // if (org::where('id', Auth::user()->org_id)->value('owner_url') != explode('/', url()->current())[2] || !empty(Organization::where('custom_domain', explode('/', url()->current())[2])->value('custom_domain')) && Organization::where('custom_domain', explode('/', url()->current())[2])->value('custom_domain') != explode('/', url()->current())[2]) {
            //     return redirect()->back()->withErrors([__('strings.alertError')])->withInput();
            // }

            if (org::where('id', Auth::user()->org_id)->value('plan_id') != 1) {
                if (org::where('id', Auth::user()->org_id)->value('due_date') < date('Y-m-d')) {
                    return redirect()->back()->withErrors([trans('strings.errorPlan')])->withInput();
                }
            }
            // a.nabiil
            $user = Auth::user();
            $user_id = $user->id;
            $funcs = DB::table('functions_user')->where('funcparent_id', '0')->where('user_id', $user_id)->where('org_id', Auth::user()->org_id)->where('appear', '1')->orderBy('porder')->get();
            $sub_funcs = DB::table('functions_user')->where('funcparent_id', '>', '0')->where('user_id', $user_id)->where('org_id', Auth::user()->org_id)->where('appear', '1')->orderBy('porder')->get();
            $func_links = DB::table('function_new')->orderBy('porder')->get();
            $partents = Session::put('partents', $funcs);
            $childs = Session::put('childs', $sub_funcs);
            $links = Session::put('links', $func_links);
            $addloginActivity = new logActivity();
            $addloginActivity->user_id = Auth::user()->id;
            $addloginActivity->org_id = Auth::user()->org_id;
            $addloginActivity->status = "login";
            $addloginActivity->save();
            $user = Auth::user();
            event(new notifyEvent($user, $addloginActivity, 'login'));
            // a.nabiil


            if(DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->exists()){
                return redirect('http://' . org::where('id', Auth::user()->org_id)->value('owner_url') . '/admin/dashboard');
            }
            if(App\Organization::where('custom_domain', explode('/',url()->current())[2])->exists()){
                return redirect('http://' . App\Organization::where('custom_domain', explode('/',url()->current())[2])->value('custom_domain') . '/admin/dashboard');
            }

        } else {
            return redirect()->back()->withErrors([__('strings.alertError')])->withInput();
        }
    }


    // customer logout
    public function logout(Request $request)
    {
        $my_url = url()->current();
        $last = explode('/', $my_url);
        $org_id = org::where('customer_url', $last[2])->first();
        $addloginActivity = new loginHistoryCustomer;
        $addloginActivity->cust_id = Auth::guard('customers')->user()->id;
        $addloginActivity->org_id = $org_id->id;
        $addloginActivity->status = "logoutCust";
        $addloginActivity->save();
        $user = Auth::guard('customers')->user();
        event(new notifyEvent($user, $addloginActivity, 'logoutCust'));
        Auth::guard('customers')->logout();

        $final_url = url('/');
        return Redirect::to($final_url);
    }


    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();
        Session::forget('partents');
        Session::forget('childs');
        Session::forget('links');
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('admin/login');
    }

    public function Getlogin()
    {
        return view('auth.login');
    }


    public function frontlogin(Request $request)
    {
        if (session('locale')) {
            \App::setLocale(session('locale'));
        }

        $v = \Validator::make($request->all(), [
            'login_email' => 'required|email',
            'login_password' => 'required'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        $my_url = url()->current();
        $last = explode('/', $my_url);
        $org_id = org::where('customer_url', $last[2])->first();
        if (Auth::guard('customers')->attempt(['email' => $request->login_email, 'password' => $request->login_password, 'active' => 1, 'org_id' => $org_id->id]) || Auth::guard('customers')->attempt(['phone_number' => $request->login_email, 'password' => $request->login_passowrd])) {
            $user = Auth::guard('customers')->user();
            $my_url = url()->current();
            $last = explode('/', $my_url);
            $org_id = org::where('customer_url', $last[2])->first();
            $addloginActivity = new loginHistoryCustomer;
            $addloginActivity->cust_id = Auth::guard('customers')->user()->id;
            $addloginActivity->org_id = $org_id->id;
            $addloginActivity->status = "loginCust";
            $addloginActivity->save();
            return back();
        } else {
            return redirect()->back()->with('message', trans('strings.alertError'));
        }
    }

    public function create_customer(Request $request){
        $valarr=[
            'name' => 'required|string|max:255',
            'name_en'=>'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|min:6',
            'confirm_passowrd' => 'required|min:6|same:password',
        ];
        $this->validate($request,$valarr);

        $my_url = url()->current();
        $last = explode('/', $my_url);
        $org_id = org::where('customer_url', $last[2])->first();
        $customer = new Customers;
        $customer->name = $request->name;
        $customer->name_en = $request->name_en;
        $customer->email = $request->email;
        $customer->password = bcrypt($request->password);
        $customer->active = 1;
        $customer->org_id = $org_id->id;
        $customer->phone_number = $request->phone_number;
        $customer->gender = $request->gender;
        $customer->customer_type = 1;
        $customer->save();
        Auth::guard('customers')->attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1, 'org_id' => $org_id->id, 'customer_type' => 1]);
        $addloginActivity = new loginHistoryCustomer;
        $addloginActivity->cust_id = Auth::guard('customers')->user()->id;
        $addloginActivity->org_id = $org_id->id;
        $addloginActivity->status = "login_cust";
        $addloginActivity->save();
        $user = Auth::guard('customers')->user();
        //event(new notifyEvent($user,$addloginActivity,'login_cust'));

        Mail::to($customer->email)->send(new SendMailable(['customer_name' => $customer->name, 'org' => $org_id]));

        $final_url = url('/');
        return Redirect::to($final_url)->with('message', trans('strings.addClient'));
        //return back()->with('message', 'User created successfully.');


    }

    public function test(Request $request)
    {
       $my_url=url()->current();
       $last = explode('/', $my_url);
       $org=org::where('customer_url',$last[2])->first();
       $org_id_login=$org->id;
       if(empty($org)){
      $org=Organization::where('custom_domain',$last[2]);
      $org_id_login=$org->org_id;
      $org_login=org::where('id',$org_id_login);
       }
 
       $check_customer=Customers::where(['email' =>$request->email,'org_id' =>$org_id_login])->first();

    if (!empty($check_customer)) {
            return 'false';
        } else {
            return 'true';
        }

    }


    public function sessionTimeOutLogin(Request $request)
    {
        $password = $request->password;
        if (Hash::check($password, Auth::user()->password)) {
            return 'true';
        } else {
            return 'false';
        }
    }

}

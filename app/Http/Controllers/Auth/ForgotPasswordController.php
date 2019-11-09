<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\org;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use App\Customers;
use Mail;
use Auth;
use DB;
use Redirect;
use App\Mail\forgetpasswordMail;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    //Customer forget password and confirm
    public function PasswordRequest(){
        return view('auth.passwords.email');
    }
    public function PasswordSendmail(Request $request){
        $my_url=url()->current();
        $last = explode('/', $my_url);
        $org=org::where('customer_url',$last[2])->first();
       if(empty($org)){
      $org=Organization::where('custom_domain',$last[2]);
       $org_login=$org->id;
      $org_id_login=$org->org_id;
      $org_login=org::where('id',$org_id_login);
       }
    $check_exits_email=Customers::where(['email' =>$request->email,'org_id' =>$org_id_login])->first();
    if (empty($check_exits_email)) {

        return redirect()->back()->with('message', 'لبريد الالكترونى غير صحيح.');
    }

    $org = org::where('customer_url', explode('/',url()->current())[2])->first();
    $user = Customers::where(['email' => request()->input('email'), 'active' => 1,'org_id'=>$org->id])->first();

    if($org->customer_url == explode('/',url()->current())[2] && !empty($user)){
        $token = Password::getRepository()->create($user);
            DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => date('Y-m-d h:i:s'),
            ]);

       /* Mail::send('vendor.emails.password', ['token' => $token, 'link' => 'password/reset'], function (Message $message) use ($user) {
            $message->subject(org::where('id', $user->org_id)->value('name_en') . ' Password Reset Link');
            $message->to($user->email);
        });*/
        
          Mail::to($user->email)->send(new forgetpasswordMail(['org'=> $org ,'token' => $token, 'link' => 'password/resetcustomer']));
        return redirect()->back()->with('message', 'تم إرسال تفاصيل استعادة كلمة المرور الخاصة بك إلى بريدك الإلكتروني');

    }else{
        return redirect()->back()->with(['reset' => 'البريد الالكترونى غير مسجل لدينا']);
    }
}
   public function PasswordReset($token){
      if(DB::table('password_resets')->where('token', $token)->exists()){
            return view('auth.passwords.reset', compact('token'));
        }else{
            $final_url= url('/') ;
          return Redirect::to($final_url);
        }  
      
   
}
public function PasswordConfirm(Request $request){

    $v = \Validator::make($request->all(), [
        'email' => 'required|email|exists:customers',
        'password' => 'required|string|confirmed'
    ]);

    if ($v->fails()) {

        return redirect()->back()->withErrors($v->errors());
    }

    $customer = Customers::where(['email' => $request->email]);


    $customer->update([
        'password' => bcrypt($request->password)
    ]);
    DB::table('password_resets')->where('email', $request->email)->delete();

    if (Auth::guard('customers')->attempt(['email' => $request->email, 'password' => $request->password])) {

      $final_url= url('/') ;
      return Redirect::to($final_url);
    }
}

    //Admin forget password and confirm
    public function PasswordAdminRequest(){
        return view('auth.passwords.email');
    }
    public function PasswordAdminSendmail(Request $request){

        $v = \Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        $org = org::where('owner_url', explode('/',url()->current())[2])->first();
        $user = User::where(['org_id' => $org->id, 'email' => request()->input('email'), 'is_active' => 1 ])->first();

        if($org->owner_url == explode('/',url()->current())[2] && !empty($user) ){
            
            $token = Password::getRepository()->create($user);
            DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => date('Y-m-d h:i:s'),
            ]);
            Mail::send('vendor.emails.password', ['token' => $token, 'link' => 'admin/password/reset'], function (Message $message) use ($user) {
                $message->subject(org::where('id', $user->org_id)->value('name_en') . ' Password Reset Link');
                $message->to($user->email);
            });
            return redirect('admin/password/reset')->withErrors(['reset' => 'تم إرسال تفاصيل استعادة كلمة المرور الخاصة بك إلى بريدك الإلكتروني']);
        }else{
            return redirect('admin/password/reset')->withErrors(['reset' => 'البريد الالكترونى غير مسجل لدينا']);
        }


    }

    public function PasswordAdminConfirm(Request $request){
        $v = \Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|confirmed'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        $customer = User::where(['email' => $request->email]);
        $customer->update([
            'password' => bcrypt($request->password)
        ]);
        DB::table('password_resets')->where('email', $request->email)->delete();

        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
           $user =Auth::user();
           $user_id = $user->id;
           $funcs = DB::table('functions_user')->where('funcparent_id','0')->where('user_id' ,$user_id)->where('org_id',Auth::user()->org_id)->where('appear','1')->orderBy('porder')->get();
           $sub_funcs = DB::table('functions_user')->where('funcparent_id','>','0')->where('user_id' ,$user_id)->where('org_id',Auth::user()->org_id)->where('appear','1')->orderBy('porder')->get();
           $func_links = DB::table('function_new')->orderBy('porder')->get();

            $partents=Session::put('partents', $funcs);
            $childs=Session::put('childs',  $sub_funcs);
            $links=Session::put('links',  $func_links);
            
            if(org::where('id', Auth::user()->org_id)->value('plan_id') != 1){
               if(org::where('id', Auth::user()->org_id)->value('due_date') < date('Y-m-d')){
                   return redirect('login')->withErrors(['لقد انتهت فترة الاشتراك الرجاء تجديد الخطة.'])->withInput();
               }
            }
            return redirect('admin/dashboard');
        }
    }

    public function PasswordAdminReset($token){
        if(DB::table('password_resets')->where('token', $token)->exists()){
            return view('auth.passwords.reset', compact('token'));
        }else{
            return redirect('admin/login');
        }
        
    }

}

<?php

namespace App\Http\Controllers;

//use App\Http\Requests\UserPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Redirect;
use Illuminate\Http\Request;
use App\Customers;
use Hash;

class UserPasswordController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | User Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for password change during login session.
    |
    */


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if(session('locale')){
            \App::setLocale(session('locale'));
        }

        return view('password_change.index');
    }


    /**
     * @param UserPasswordRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
         $input = $request->all();
        
        if (Auth::guard('web')->check()) {
            if(Auth::user()->id == $id)
            {
                $new_password = bcrypt($input['password_new']);

                $user = Auth::user();

                $user->update([
                    'password' => $new_password
                ]);

                Session::flash('password_changed', __('strings.password_changed_msg_1') );
                return redirect()->route('changePassword');
            }
            else
            {
                Session::flash('password_error', __('strings.password_changed_msg_2') );
                return redirect()->route('changePassword');
            }
        }else{
            if(Auth::guard('customers')->user()->id == $id)
            {
                  $new_password = bcrypt($input['password_new']);

                $user = Auth::guard('customers')->user();

                $user->update([
                    'password' => $new_password
                ]);
             
                Session::flash('password_changed', __('strings.password_changed_msg_1') );
               $final_url= url('/') ;
              return Redirect::to($final_url);
            }
            else
            {
                Session::flash('password_error', __('strings.password_changed_msg_2') );
                return redirect()->route('changePassword');
            }
        }

    }
    
    function  check_password(Request $request){

     $oldpassword=Customers::where('id',Auth::guard('customers')->user()->id)->first();
    return Hash::check($request->old_password,$oldpassword->password)?'true':'false';


     }

}

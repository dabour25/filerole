<?php

namespace App\Http\Controllers;

use App\CaptinAvailable;
use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Http\Requests\CustomersPasswordRequest;
use App\Role;
use App\User;
use App\Photo;
Use App\Sections;
use App\Plans;
use App\org;
use App\WeeklyVacations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use App\UsersType;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\FunctionsUser;
use App\functions_role;
use App\Shift;
use App\UserShift;

class AdminUsersController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Users Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing users views to
    | admin, to show all users, provide ability to edit and delete
    | specific user.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (permissions('users_view') == 0 || permissions('employees_view') == 0) {
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $users = User::where('org_id', Auth::user()->org_id)->paginate(20);
        $roles = Role::where('org_id', Auth::user()->org_id)->get();
        $sections = Sections::where('org_id', Auth::user()->org_id)->get();

        return view('users.index', compact('users', 'roles', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (permissions('users_add') == 0 || permissions('employees_add') == 0) {
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        //maximum plan verification by hossam
        $current_created_users = User::where('org_id', Auth::user()->org_id)->get()->count();

        $plan = org::where('id', Auth::user()->org_id)->first();
        if ($plan != null) {
            $plan_id = $plan->plan_id;
        }

        $maxmimum_users_number = Plans::where('id', $plan_id)->first()->emp_value + $plan->extra_emp;
        if ($current_created_users >= $maxmimum_users_number) {
            Session::flash('danger', __('strings.exeeds maximum number of users'));

            //redirect back to users.index
            return redirect('admin/users');
        }
        //end maximum plan verification by hossam


        $roles = Role::where('org_id', Auth::user()->org_id)->get();
        $sections = Sections::where('org_id', Auth::user()->org_id)->get();
        $vacations = WeeklyVacations::where(['org_id' => Auth::user()->org_id, 'active' => 1])->get();
        $shifts=Shift::where('org_id',Auth::user()->org_id)->where('active',1)->get();

        return view('users.create', compact('roles', 'sections', 'vacations','shifts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $email = $request->email;
        $phone = $request->phone_number;
        $code = $request->code;

        $v = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            //'password' => 'required|string|confirmed|min:6',
            'address' => 'required|string|max:255',
            //'birthday' => 'required|date',
            'is_active' => 'required',
            'type' => 'required',
            'role_id' => 'required|not_in:0',
            'using' => 'required|not_in:0',
            'section_id' => 'required|not_in:0',
            'photo_id' => 'mimes:jpeg,png',
            'email' => [
                'required',
                Rule::unique('users')->where(function ($query) use ($email) {
                    return $query->where(['email' => $email,'org_id' => Auth::user()->org_id]);
                }),
            ],

            'phone_number' => [
                'required',
                Rule::unique('users')->where(function ($query) use ($phone) {
                    return $query->where(['phone_number' => $phone, 'org_id' => Auth::user()->org_id]);
                }),
            ],

            /*'code' => [
                Rule::unique('users')->where(function ($query) use($code) {
                    return $query->where(['code' => $code ,'org_id' => Auth::user()->org_id]);
                }),
            ],*/
        ]);


        /*$code = rand(11111, 99999);

        if(User::where(['code' => $code, 'org_id' => Auth::user()->org_id])->exists()){
            $input['code'] = rand(11111, 99999);
        }else{
            $input['code'] = $code;
        }*/

        /*if($request->using == 2){
            $v = \Validator::make($request->all(), [
                'password' => 'required|string|confirmed|min:6'
            ]);
        }*/
        $input['used_type'] = $request->using;

        if ($v->fails()) {
            return back()->withErrors($v->errors())->withInput();
        }

        //check if an image is selected
        if ($image = $request->file('photo_id')) {
            //give a name to image and move it to public directory
            $image_name = time() . $image->getClientOriginalName();
            $image->move('images', $image_name);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_name]);

            //save photo_id to user $input
            $input['photo_id'] = $photo->id;
        }


        if ($request->using == 2) {
            $password = Str::random(8);

            //encrypt password and persist data into users table
            $input['password'] = bcrypt($password);
            $from = DB::table('organizations')->where('id', Auth::user()->org_id)->value('email');
            $subject = "مرحبا بك";

            \Mail::send('vendor.emails.welcome', ['email' => $email, 'password' => $password, 'url' => url('admin/login')], function ($message) use ($from, $subject, $email) {
                $message->from($from);
                $message->to($email)->subject($subject);
            });
        } else {
            $password = Str::random(8);
            //encrypt password and persist data into users table
            $input['password'] = bcrypt($password);
        }
        $input['org_id'] = Auth::user()->org_id;


        //ghada change 27/06/2019
        $user = User::create($input);

        if(!empty($request->days) && !empty($request->time)) {
            foreach ($request->days as $key => $value) {
                if(CaptinAvailable::where(['captin_id' => $user->id, 'day' => $value, 'time' => $request->time[$key], 'active' => 1, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id])->doesntExist()){
                    CaptinAvailable::create(['captin_id' => $user->id, 'day' => $value, 'time' => $request->time[$key], 'active' => 1, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
                }
            }
        }
        $role_auths = functions_role::where(['org_id' => Auth::user()->org_id, 'role_id' => $user->role_id])->get();
       foreach ($role_auths as $role_auth) {
            
            $user_auth = new FunctionsUser;
            $user_auth->funcname = $role_auth->funcname;
            $user_auth->funcname_en = $role_auth->funcname_en;
            $user_auth->technical_name = $role_auth->technical_name;
            $user_auth->funcparent_id = $role_auth->funcparent_id;
            $user_auth->functions_id = $role_auth->functions_id;
            $user_auth->user_id = $user->id;
            $user_auth->org_id = Auth::user()->org_id;
            $user_auth->func_name =$role_auth->func_name;
            $user_auth->font =$role_auth->font;
            $user_auth->porder =$role_auth->porder;
            $user_auth->appear=$role_auth->appear;
            $user_auth->save();

        }
        
        foreach($input['shift_id'] as $shift){
             $user_shift=new UserShift();
             $user_shift->captin_id=$user->id;
             $user_shift->shift_id=$shift;
             $user_shift->org_id=Auth::user()->org_id;
             $user_shift->user_id=Auth::user()->id;
             $user_shift->save();
             }

        //set session message
        Session::flash('user_created', __('strings.message_success'));
        
        if ($request->using == 1) {
            //redirect back to users.index
            return redirect('admin/employees');
        } else {
            //redirect back to users.index
            return redirect('admin/users');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(permissions('users_edit') == 0 || permissions('employees_edit') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        $user = User::findOrFail($id);
        $roles = Role::where('org_id', Auth::user()->org_id)->get();
        $sections = Sections::where('org_id', Auth::user()->org_id)->get();
        $selected_shifts=UserShift::where('captin_id',$id)->where('org_id',Auth::user()->org_id)->get();

        $shifts=Shift::where('org_id',Auth::user()->org_id)->where('active',1)->get();
        
        foreach($shifts as $shift){
          foreach($selected_shifts as $selected_shift){
            if($selected_shift->shift_id==$shift->id){
              $shift->selected=1;
            }

          }
        }
        

        return view('users.edit', compact('user', 'roles', 'sections','shifts'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getProfile($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::where('org_id', Auth::user()->org_id)->get();
        $sections = Sections::where('org_id', Auth::user()->org_id)->get();

        return view('users.profile', compact('user', 'roles', 'sections'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersUpdateRequest $request, $id)
    {
        $input = $request->all();


        //check if image is selected
        if ($image = $request->file('photo_id')) {
            //give a name to image and move it to public directory
            $image_name = time() . $image->getClientOriginalName();
            $image->move('images', $image_name);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_name]);

            //save photo_id to user $input
            $input['photo_id'] = $photo->id;

            //find user
            $user = User::findOrFail($id);

            //unlink old photo if set
            if ($user->photo != NULL) {
                unlink(public_path() . $user->photo->file);
            }

            //delete data from photos table
            Photo::destroy($user->photo_id);
        }

        //update data into users table
        User::findOrFail($id)->update($input);

        // ghada change 27/06/2019
        $user = User::findOrFail($id);
       $all_user_auths = FunctionsUser::where(['org_id' => Auth::user()->org_id, 'user_id' => $id])->get();

        foreach ($all_user_auths as $all_user_auth) {
            $all_user_auth->delete();
            // code...
        }

        $role_auths = functions_role::where(['org_id' => Auth::user()->org_id,'role_id' => $user->role_id])->get(); 
       
        foreach ($role_auths as $role_auth) {
           
            $user_auth = new FunctionsUser;
            $user_auth->funcname = $role_auth->funcname;
            $user_auth->funcname_en = $role_auth->funcname_en;
            $user_auth->technical_name = $role_auth->technical_name;
            $user_auth->funcparent_id = $role_auth->funcparent_id;
            $user_auth->functions_id = $role_auth->functions_id;
            $user_auth->user_id = $id;
            $user_auth->org_id = Auth::user()->org_id;
            $user_auth->func_name =$role_auth->func_name;
            $user_auth->font =$role_auth->font;
            $user_auth->appear=$role_auth->appear;
            $user_auth->porder =$role_auth->porder; 
            $user_auth->save();
            }
              UserShift::where('captin_id',$id)->where('org_id',Auth::user()->org_id)->delete();
          foreach($input['shift_id'] as $shift){
               $user_shift=new UserShift();
               $user_shift->captin_id=$id;
               $user_shift->shift_id=$shift;
               $user_shift->org_id=Auth::user()->org_id;
               $user_shift->user_id=Auth::user()->id;
               $user_shift->save();
               }


        //set session message and redirect back users.index
        Session::flash('user_updated', __('strings.message_success_updated'));

        if ($request->using == 1) {
            //redirect back to users.index
            return redirect('admin/employees');
        } else {
            //redirect back to users.index
            return redirect('admin/users');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find specific user
        $user = User::findOrFail($id);

        if ($user->photo) {
            //unlink image
            unlink(public_path() . $user->photo->file);

            //delete from photo table
            Photo::destroy($user->photo_id);

        }

        //delete user
        User::destroy($user->id);

        //set session message and redirect back to users.index
        Session::flash('user_deleted', __('strings.users_msg_3'));
        return redirect('admin/users');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getPassword($id)
    {
        return view('users.change_password', compact('id'));
    }

    public function change_password(CustomersPasswordRequest $request)
    {

        $input['password'] = bcrypt($request->password);

        //update data into users table
        User::findOrFail($request->id)->update($input);


        //set session message and redirect back to customers.index
        Session::flash('user_change_password', __('strings.users_msg_4'));
        return redirect('admin/users');
    }


    public function Validator(Request $request, $type)
    {
        $valid = false;

        switch ($type) {
            case 'name':
                // Check the value existence ...
                $valid = User::where(['name' => $request->name, 'org_id' => Auth::user()->org_id])->doesntExist();
                break;
            case 'name_en':
                // Check the value existence ...
                $valid = User::where(['name_en' => $request->name_en, 'org_id' => Auth::user()->org_id])->doesntExist();
                break;
            case 'code':
                // Check the value existence ...
                $valid = User::where(['code' => $request->code, 'org_id' => Auth::user()->org_id])->doesntExist();
                break;
            case 'email':
                // Check the value existence ...
                $valid = User::where(['email' => $request->email])->doesntExist();
                break;
            case 'phone_number':
                // Check the value existence ...
                $valid = User::where(['phone_number' => $request->phone_number, 'org_id' => Auth::user()->org_id])->doesntExist();
                break;
            case 'birthday':
                // Check the value existence ...
                $valid = User::where(['phone_number' => $request->phone_number, 'org_id' => Auth::user()->org_id])->doesntExist();
                break;
            case 'address':
                // Check the value existence ...
                $valid = User::where(['phone_number' => $request->phone_number, 'org_id' => Auth::user()->org_id])->doesntExist();
                break;
            default:
                $valid = false;
                break;
        }

        // Finally, return a JSON
        return json_encode(array(
            'valid' => $valid,
        ));
    }

    public function SendPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $password = Str::random(8);

        //encrypt password and persist data into users table
        User::where('id', $id)->update(['password' => bcrypt($password)]);

        $from = DB::table('organizations')->where('id', Auth::user()->org_id)->value('email');
        $subject = "بيانات دخولك";
        $email = $user->email;
        \Mail::send('vendor.emails.welcome', ['email' => $user->email, 'password' => $password, 'url' => url('admin/login')], function ($message) use ($from, $subject, $email) {
            $message->from($from);
            $message->to($email)->subject($subject);
        });

        return back();

    }

}

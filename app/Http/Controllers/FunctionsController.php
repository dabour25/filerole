<?php

namespace App\Http\Controllers;

use App\Functions;
use App\Http\Requests\UsersTypeRequest;
use App\Customers;
use App\ReturnItems;
use App\Role;
use App\UsersType;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use DB;
use Auth;

class FunctionsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*if(permissions('functions') == false){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }*/

        $functions = Functions::paginate(20); $roles = Role::where('org_id', Auth::user()->org_id)->paginate(20);
        return view('functions.index', compact('functions', 'roles'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*if(permissions('functions') == false){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }*/

        $roles = Role::where('org_id', Auth::user()->org_id)->get(); $functions = Functions::all();

        return view('functions.create', compact('roles', 'functions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersTypeRequest $request)
    {
        $input = $request->all();

        foreach (Functions::all() as $value){

            if(isset($request['function_'.$value->id])){
                $input['function_id'] = $value->id;
                $input['org_id'] = Auth::user()->org_id;
                UsersType::create($input);
            }
        }

        //set session message
        Session::flash('user_type_created', "تم اضافة صلاحيه مستخدم");


        //redirect back to functions.index
        return redirect('/admin/functions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*if(permissions('functions') == false){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }*/
        $function = Role::findOrFail($id);
        return view('functions.edit', compact('function'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        //delete from roles
        //UsersType::where('role_id', $id)->delete();
        //ReturnItems::where('role_id', $id)->delete();

        foreach (Functions::/*where('parent_id', '!=', '0')->get()*/all() as $value){

            //return $input['function_'.$value->id];

            if(isset($input['function_'.$value->id]) && UsersType::where(['role_id' => $request->role_id, 'org_id' => $request->org_id, 'function_id' => $value->id])->exists()){
                UsersType::where(['role_id' => $request->role_id, 'org_id' => $request->org_id, 'function_id' => $value->id])->update(['updated_user' => Auth::user()->id,'active' => $input['function_'.$value->id]]);
            }else{
                UsersType::create([ 'role_id' => $request->role_id, 'org_id' => $request->org_id, 'user_id' => $request->user_id, 'function_id' => $value->id, 'active' => $input['function_'.$value->id]]);

            }


            /*if(isset($input['function_'.$value->id]) && $input['function_'.$value->id] == 1){
                UsersType::insert([ 'role_id' => $request->role_id, 'org_id' => $request->org_id, 'user_id' => $request->user_id, 'function_id' => $value->id]);
                //DB::table('roles_functions')->insert([ 'role_id' => $request->role_id, 'org_id' => $request->org_id, 'user_id' => $request->user_id, 'function_id' => $value->id]);
            }*/
            if($value->technical_name == 'return_items' && $input['function_'.Functions::where('technical_name', 'return_items')->value('id')] == 1){
                ReturnItems::insert(['role_id' => $request->role_id, 'org_id' => $request->org_id, 'user_id' => $request->user_id, 'return_item_flag' => 1]);
            }
        }
        //set session message
        Session::flash('user_type_created', __('strings.functions_msg_2'));

        //redirect back to functions.index
        return redirect('/admin/functions');
    }


}

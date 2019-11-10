<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolesRequest;
use App\Http\Requests\RolesUpdateRequest;
use App\Role;
Use App\Sections;
use Illuminate\Support\Facades\Session;
use Auth;
use App\org_function;
use App\functions_role;

class RolesController extends Controller
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
        /*if (permissions('roles_view') == 0) {
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }*/

        $roles = Role::where('org_id', Auth::user()->org_id)->paginate(20);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*if (permissions('roles_add') == 0) {
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }*/

        $roles = Role::where('org_id', Auth::user()->org_id)->get();
        $sections = Sections::where('org_id', Auth::user()->org_id)->get();
        $authentications = org_function::where('org_id', Auth::user()->org_id)->where('funcparent_id', '>', '0')->get();
        //$parent_auths = org_function::where('org_id', Auth::user()->org_id)->where('funcparent_id', '=', '0')->get();
       
        $parent_auths = org_function::where('org_id', Auth::user()->org_id)->where('funcparent_id', '=', '0')->orderby('porder')->get();
        return view('roles.create', compact('roles', 'sections', 'authentications', 'parent_auths'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolesRequest $request)
    {
        $input = $request->all();
        $input['org_id'] = Auth::user()->org_id;
        $role = Role::create($input);

        //set session message
        Session::flash('role_created', __('strings.message_success'));
        $authentications = org_function::where('org_id', Auth::user()->org_id)->get();
        $auths = $request->acs;

        if (count($auths)) {
            foreach ($auths as $authf) {
                $auth = org_function::where('org_id', $input['org_id'])->where('id', $authf)->first();
                $role_auth = new functions_role;
                $role_auth->funcname = $auth->funcname;
                $role_auth->funcname_en = $auth->funcname_en;
                $role_auth->technical_name = $auth->technical_name;
                $role_auth->funcparent_id = $auth->funcparent_id;
                $role_auth->functions_id = $auth->function_id;
                $role_auth->role_id = $role->id;
                $role_auth->org_id = Auth::user()->org_id;
                $role_auth->font = $auth->font;
                $role_auth->appear = $auth->appear;
                $role_auth->porder = $auth->porder;
                $role_auth->func_name = $auth->func_name;
                $role_auth->save();
            }
        }
        //  22/6/2019 chang ghada (Error Here // detect by Ahmed Magdy)
        //$all_auth=  org_function::where('org_id', Auth::user()->org_id)->where('id',$auth)->get();
        /*if (count($auths)) {
            $all_auth = org_function::where('org_id', Auth::user()->org_id)->wherein('id', $auths)->select('funcparent_id')->distinct()->get();
        } else
            $all_auth = org_function::where('org_id', 0)->select('funcparent_id')->distinct()->get();
        if (count($all_auth)) {
            foreach ($all_auth as $value) {
                $parent_auth = org_function::where('org_id', Auth::user()->org_id)->wherein('function_id', $value)->first();
                $role_partent = new functions_role;
                $role_partent->funcname = $parent_auth->funcname;
                $role_partent->funcname_en = $parent_auth->funcname_en;
                $role_partent->technical_name = $parent_auth->technical_name;
                $role_partent->funcparent_id = $parent_auth->funcparent_id;
                $role_partent->functions_id = $parent_auth->function_id;
                $role_partent->role_id = $role->id;
                $role_partent->org_id = Auth::user()->org_id;
                $role_partent->font = $parent_auth->font;
                $role_partent->appear = $parent_auth->appear;
                $role_partent->porder = $parent_auth->porder;
                $role_partent->func_name =$parent_auth->func_name;
                $role_partent->save();

            }
        }*/


        //redirect back to roles.index
        return redirect('admin/roles');
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
        /*if(permissions('roles_edit') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }*/
        $role = Role::findOrFail($id);
       
        $authentications = org_function::where('org_id', Auth::user()->org_id)->where('funcparent_id', '>', '0')->get();
        $parent_auths = org_function::where('org_id', Auth::user()->org_id)->where('funcparent_id', '=', '0')->orderby('porder')->get();
        return view('roles.edit', compact('role', 'authentications', 'parent_auths'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolesUpdateRequest $request, $id)
    {
        $input = $request->all();
        $role_auths = $request->acs;

        //update data into roles table
        Role::findOrFail($id)->update($input);
        $all_role_auths = functions_role::where(['org_id' => Auth::user()->org_id, 'role_id' => $id])->get();
        foreach ($all_role_auths as $all_role_auth) {
            $all_role_auth->delete();
            // code...
        }

        foreach ($role_auths as $role_auth) {
            $authentication = org_function::where(['org_id' => Auth::user()->org_id, 'id' => $role_auth])->first();
            $role_authentication = new functions_role;
            $role_authentication->funcname = $authentication->funcname;
            $role_authentication->funcname_en = $authentication->funcname_en;
            $role_authentication->technical_name = $authentication->technical_name;
            $role_authentication->funcparent_id = $authentication->funcparent_id;
            $role_authentication->functions_id = $authentication->function_id;
            $role_authentication->role_id = $id;
            $role_authentication->org_id = Auth::user()->org_id;
            $role_authentication->font = $authentication->font;
            $role_authentication->appear = $authentication->appear;
            $role_authentication->porder = $authentication->porder;
            $role_authentication->func_name = $authentication->func_name;
            $role_authentication->save();
            // code...
        }


        //  22/6/2019 chang ghada
        // $all_auth=  org_function::where('org_id',Auth::user()->org_id)->where('id',$role_auths)->get();
        /*$all_auth = org_function::where('org_id', Auth::user()->org_id)->wherein('id', $role_auths)->select('funcparent_id')->distinct()->get();


        foreach ($all_auth as $value) {
            $parent_auth = org_function::where('org_id', Auth::user()->org_id)->wherein('function_id', $value)->first();

            $role_partent = new functions_role;
            $role_partent->funcname = $parent_auth->funcname;
            $role_partent->funcname_en = $parent_auth->funcname_en;
            $role_partent->technical_name = $parent_auth->technical_name;
            $role_partent->funcparent_id = $parent_auth->funcparent_id;
            $role_partent->functions_id = $parent_auth->function_id;
            $role_partent->font = $parent_auth->font;
            $role_partent->appear = $parent_auth->appear;
            $role_partent->porder = $parent_auth->porder;
            $role_partent->func_name = $parent_auth->func_name;
            $role_partent->role_id = $id;
            $role_partent->org_id = Auth::user()->org_id;
            
            $role_partent->save();

        }*/


        //set session message and redirect back roles.index
        Session::flash('role_updated', __('strings.message_success_updated'));
        return redirect('admin/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete role
        Role::destroy($id);

        //set session message and redirect back to roles.index
        Session::flash('role_deleted', __('strings.roles_msg_3'));
        return redirect('admin/roles');

    }
}

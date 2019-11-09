<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionsUpdateRequest;
use App\Http\Requests\SectionsRequest;
use App\User;
Use App\Sections;
use Illuminate\Support\Facades\Session;
use Auth;

class AdminSectionsController extends Controller
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
        if(permissions('sections_view') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $sections = Sections::where('org_id', Auth::user()->org_id)->paginate(20);
        return view('sections.index', compact('sections'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(permissions('sections_add') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        return view('sections.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionsRequest $request)
    {
        $input = $request->all();
        $input['org_id'] = Auth::user()->org_id;

        Sections::create($input);

        //set session message
        Session::flash('section_created', __('strings.message_success') );

        //redirect back to sections.index
        return redirect('/admin/sections');
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
        if(permissions('sections_edit') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        $section = Sections::findOrFail($id);
        return view('sections.edit',compact('section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SectionsUpdateRequest $request, $id)
    {
        $input = $request->all();

        $input['updated_at'] = date('Y-m-d h:i:s');

        //update data into sections table
        Sections::findOrFail($id)->update($input);

        //set session message and redirect back sections.index
        Session::flash('section_updated', __('strings.message_success_updated'));
        return redirect('admin/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        //delete section
        Sections::destroy($id);

        //set session message and redirect back to sections.index
        Session::flash('section_deleted', __('strings.section_msg_3'));
        return redirect('admin/sections');

    }
}

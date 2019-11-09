<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoresRequest;
use App\Http\Requests\StoresUpdateRequest;
use App\Companies;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Auth;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(permissions('companies_view') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $companies = Companies::where('org_id', Auth::user()->org_id)->paginate(20);
        return view('companies.index', compact('companies'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(permissions('companies_add') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission') );
            return view('permissions');
        }
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $v = \Validator::make($request->all(), [
            'phone' => 'required', 'address' => 'required' , 'name' => 'required' , 'name_en' => 'required', 'active' => 'required', 'address' => 'required'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;

        Companies::create($input);

        //set session message
        Session::flash('created', __('strings.message_success') );

        //redirect back to index
        return redirect('admin/companies');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(permissions('companies_edit') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        $company = Companies::findOrFail($id);
        return view('companies.edit',compact('company'));
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

        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;

        //update data into table
        Companies::findOrFail($id)->update($input);

        //set session message and redirect back index
        Session::flash('updated', __('strings.message_success_updated'));
        return redirect('admin/companies');
    }

}

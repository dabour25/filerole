<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocatorsRequest;
use App\Http\Requests\LocatorsUpdateRequest;
use App\Locators;
use App\Stores;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Auth;

class LocatorsController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(permissions('locators_view') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $locators = Locators::where('org_id', Auth::user()->org_id)->paginate(20);
        return view('locators.index', compact('locators'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(permissions('locators_add') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $stores = Stores::where(['active' => 1, 'org_id' => Auth::user()->org_id])->get();
        return view('locators.create', compact('stores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocatorsRequest $request)
    {
        $input = $request->all();

        $input['store_id'] = $request->store;
        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;

        Locators::create($input);

        //set session message
        Session::flash('created', __('strings.message_success') );

        //redirect back to locators.index
        return redirect('admin/locators');
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
        if(permissions('locators_edit') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        $locator = Locators::findOrFail($id);  $stores = Stores::where(['active' => 1, 'org_id' => Auth::user()->org_id])->get();
        return view('locators.edit',compact('locator', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LocatorsUpdateRequest $request, $id)
    {
        $input = $request->all();
        $input['store_id'] = $request->store;

        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;

        //update data into suppliers table
        Locators::findOrFail($id)->update($input);

        //set session message and redirect back suppliers.index
        Session::flash('updated', __('strings.message_success_updated'));
        return redirect('admin/locators');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete customer
        Locators::destroy($id);

        //set session message and redirect back to customers.index
        Session::flash('deleted', __('strings.locators_msg_3'));
        return redirect('admin/locators');

    }



}

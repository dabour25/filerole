<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoresRequest;
use App\Http\Requests\StoresUpdateRequest;
use App\Locators;
use App\Stores;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Auth;

class StoresController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(permissions('stores_view') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $stores = Stores::where('org_id', Auth::user()->org_id)->paginate(20);
        return view('stores.index', compact('stores'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(permissions('stores_add') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission') );
            return view('permissions');
        }
        return view('stores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoresRequest $request)
    {
        $input = $request->all();

        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;

        Stores::create($input);

        //set session message
        Session::flash('created', __('strings.message_success') );

        //redirect back to suppliers.index
        return redirect('admin/stores');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetLocators($id)
    {
        $locators = Locators::where('store_id',$id)->get();
        return view('stores.locators',compact('locators'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(permissions('stores_edit') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        $store = Stores::findOrFail($id);
        return view('stores.edit',compact('store'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoresUpdateRequest $request, $id)
    {
        $input = $request->all();

        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;

        //update data into suppliers table
        Stores::findOrFail($id)->update($input);

        //set session message and redirect back suppliers.index
        Session::flash('updated', __('strings.message_success_updated'));
        return redirect('admin/stores');
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
        Stores::destroy($id);

        //set session message and redirect back to customers.index
        Session::flash('deleted', __('strings.stores_msg_3') );
        return redirect('admin/stores');

    }

    public function DefaultStore($id, $value)
    {
        if (Stores::where('id', $id)->value('active') == 1) {
            $value = $value == 'true' ? 1 : 0;
            foreach (Stores::where('org_id', Auth::user()->org_id)->get() as $v) {
                Stores::where('id', $v->id)->update(['default' => 0]);
            }
            Stores::where('id', $id)->update(['default' => $value]);

            //set session message and redirect back to settings.index
            Session::flash('created', __('strings.settings_msg_9') );
        }else{
            //set session message and redirect back to settings.index
            Session::flash('created', __('strings.settings_msg_10') );
        }

        return redirect('admin/stores');
    }

}

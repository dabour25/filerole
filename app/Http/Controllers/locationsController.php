<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\Rule;
use App\Currency;
use App\Destinations;
use App\Locations;

class locationsController extends Controller
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
        if(permissions('locations_show') == false){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $currencies=Currency::get();
        $destinations=Destinations::where('org_id',Auth::user()->org_id)->where('active',1)->get();
        $locations=Locations::where('org_id',Auth::user()->org_id)->get();
        return view('locations.index',compact('locations','destinations','currencies'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*if(permissions('categories_type') == false){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }*/
          $currencies=Currency::get();
          $destinations=Destinations::where('org_id',Auth::user()->org_id)->where('active',1)->get();
        return view('locations.create', compact('destinations','currencies'));
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
            'name' => 'required',
            'name_en' => 'required',
            'destination_id' => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }
        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;
        Locations::create($input);
        //set session message
        Session::flash('created', __('strings.create_message'));


        //redirect back to functions.index
        return redirect('/admin/locations');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_destination($id)
    {
        /*if(permissions('destinations_edit') == false){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }*/

        $destination_locations = Locations::where('destination_id',$id)->get();
        return $destination_locations;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         $input = $request->all();
         $id=$request->id;
         if($id==null){
           $input['user_id'] = Auth::user()->id;
           $input['org_id'] = Auth::user()->org_id;
          
           $insert_locations=Locations::create($input);
           $mylocation=$insert_locations->id;
           //set session message
           Session::flash('created', __('strings.create_message'));

           $test=  str_replace(url('/'), '', url()->previous());
           if($test=='/admin/locations'){
          return redirect('/admin/locations');

           }
           //redirect back to functions.index
           else{
             return redirect('admin/property/add')->with(['mylocation' =>$mylocation]);

           }
         }else{
        $v = \Validator::make($request->all(), [
             'name' => 'required' , 'name_en' => 'required',

        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        //update data into categories type table
        Locations::findOrFail($id)->update($input);

        //set session message
        Session::flash('updated', __('strings.update_message'));

        //redirect back to functions.index
        return redirect('/admin/locations');
}


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
      if(permissions('location_delete') == false){
          //set session message
          Session::flash('message', __('strings.do_not_have_permission'));
          return view('permissions');
      }
        $hotel_loacations=DB::table('property')->where('location_id',$id)->where('org_id',Auth::user()->org_id)->where('active',1)->get();
        if(count($hotel_loacations !=0)){
          Session::flash('deleted', __('strings.delete_location_message'));
          return redirect('admin/destinations');

        }else {
          Locations::destroy($id);
          Session::flash('deleted', __('strings.sew_status_3'));
          return redirect('admin/destinations');
        }


    }



    public function search(Request $request) {
   $serach = $request->input('destination_name');
    if(app()->getLocale() =='ar'){
      $destinations = Destinations::where('name', 'LIKE', '%' . $serach .
'%')->where('org_id',Auth::user()->org_id)->get();

    }else {
      $destinations = Destinations::where('name_en', 'LIKE', '%' . $serach .
'%')->where('org_id',Auth::user()->org_id)->get();

    }

    return view('destinations.index',compact('destinations'));

  }

}

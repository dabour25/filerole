<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\Rule;
use App\Property;
use App\cleaning_setup;
class CleaningPriorityController extends Controller
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
    public function index(Request $request)
    { 
        // if(permissions('show_clean_priority') == false){
        //     //set session message
        //     Session::flash('message', __('strings.do_not_have_permission'));
        //     return view('permissions');
        // }
        $properties=Property::where('org_id',Auth::user()->org_id)->get();
        $cleaning_priority=cleaning_setup::where('org_id',Auth::user()->org_id)->where('property_id',$request->property_id)->get();

         $hotel_id=$request->property_id ;
        return view('cleaning.index',compact('properties','cleaning_priority','hotel_id'));
    }
    public function get_property_cleaning_priority(Request $request)
    {
        // if(permissions('destinations_edit') == false){
        //     //set session message
        //     Session::flash('message', __('strings.do_not_have_permission'));
        //     return view('permissions');
        // }
     
     $portity_clean=cleaning_setup::where('org_id',Auth::user()->org_id)->where('property_id',$request->property_id)->get();
     if(count($portity_clean)==0){
    for($i=4;$i>=1;$i--){

      $property_clean= new cleaning_setup;
      $property_clean->clean_type=$i;
      $property_clean->rank=$request->rank[$i-1];
      $property_clean->property_id=$request->property_id;
      $property_clean->org_id=Auth::user()->org_id;
      $property_clean->user_id=Auth::user()->id;
      $property_clean->save();
    }
    $cleaning_priority =cleaning_setup::where('org_id',Auth::user()->org_id)->where('property_id',$property_clean->property_id)->get();
    //dd($cleaning_priority);
    $properties=Property::where('org_id',Auth::user()->org_id)->get();
    $hotel_id=$request->property_id;
    Session::flash('created', __('strings.create_message'));
    return view('cleaning.index',compact('cleaning_priority','properties','hotel_id'));

  }else{
  foreach( $portity_clean as $value){
    $value->delete();
  }

    for($i=4;$i>=1;$i--){
   
      $property_clean= new cleaning_setup;
      $property_clean->clean_type=$i;
      $property_clean->rank=$request->rank[$i-1];
      $property_clean->property_id=$request->property_id;
      $property_clean->org_id=Auth::user()->org_id;
      $property_clean->user_id=Auth::user()->id;
      $property_clean->save();
    }

      $cleaning_priority =cleaning_setup::where('org_id',Auth::user()->org_id)->where('property_id',$property_clean->property_id)->get();
      //dd($cleaning_priority);
      $properties=Property::where('org_id',Auth::user()->org_id)->get();
      $hotel_id=$request->property_id;
       Session::flash('updated', __('strings.update_message'));
      return view('cleaning.index',compact('cleaning_priority','properties','hotel_id'));
  }





    }

   





}

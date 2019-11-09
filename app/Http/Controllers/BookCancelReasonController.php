<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\Rule;
use App\Property;
use App\book_cancel_reason;
use App\Booking;
class BookCancelReasonController extends Controller
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
       if(permissions('show_book_cancel_reason') == false){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $properties=Property::where('org_id',Auth::user()->org_id)->get();

        return view('book_cancel_reasons.index',compact('properties'));
    }
    public function get_property_cancel_reason(Request $request)
    {
        /*if(permissions('destinations_edit') == false){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }*/

        if(session()->get('hotel_id'))
        $reasons = book_cancel_reason::where('org_id',Auth::user()->org_id)->where('property_id',session()->get('hotel_id'))->get();
        else
        $reasons = book_cancel_reason::where('org_id',Auth::user()->org_id)->where('property_id',$request->property_id)->get();

        $properties=Property::where('org_id',Auth::user()->org_id)->get();
        return view('book_cancel_reasons.index',compact('reasons','properties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   $input = $request->all();

      if($input['id']==null){
        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;

       book_cancel_reason::create($input);
        //set session message
        Session::flash('created', __('strings.create_message'));
        //redirect back to functions.index
        return redirect('/admin/get_book_cancel_reasons')->with(['hotel_id'=>$request->property_id]);

    }
       else{
         $id=$request->id;
         book_cancel_reason::findOrFail($id)->update($input);

         //set session message
         Session::flash('updated', __('strings.update_message'));

         //redirect back to functions.index

            return redirect('/admin/get_book_cancel_reasons')->with(['hotel_id'=>$request->property_id]);
       }


    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
      if(permissions('delete_reason') == false){
          //set session message
          Session::flash('message', __('strings.do_not_have_permission'));
          return view('permissions');
      }

        $reasons_book=Booking::where('cancel_reason_id',$id)->get();
        if(count($reasons_book)!=0){
          Session::flash('deleted', __('strings.message_delete_cat'));
        }else{
          book_cancel_reason::destroy($id);
          Session::flash('deleted', __('strings.sew_status_3'));
        }
     return redirect()->back();


    }





}

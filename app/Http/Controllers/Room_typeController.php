<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\Rule;
use App\CategoriesType;
use App\Category;


class Room_typeController extends Controller
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
        if(permissions('rooms_type_show') == false){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $rooms_types=CategoriesType::where('org_id',Auth::user()->org_id)->where('type',7)->get();

        return view('rooms_type.index',compact('rooms_types'));
    }
    public function edit($id)
    {
        /*if(permissions('destinations_edit') == false){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }*/
        $type_room = CategoriesType::findOrFail($id);
        return $type_room ;
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
    { $input = $request->all();

      if($input['id']==null){
        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;
        $input['type'] = 7;
        CategoriesType::create($input);
        //set session message
        Session::flash('created', __('strings.create_message'));
        //redirect back to functions.index
        return redirect('/admin/rooms_type');

    }
       else{
         $id=$request->id;
         CategoriesType::findOrFail($id)->update($input);

         //set session message
         Session::flash('updated', __('strings.update_message'));

         //redirect back to functions.index

           return redirect('/admin/rooms_type');
       }


    }
    public function search(Request $request) {
   $serach = $request->input('rooms_types_name');
  if($serach>0){
  $rooms_types = CategoriesType::where('id',$serach)->where('org_id',Auth::user()->org_id)->where('active',1)->get();

}else{
  $rooms_types = CategoriesType::where('type',7)->where('org_id',Auth::user()->org_id)->where('active',1)->get();

}

     return view('rooms_type.index',compact('rooms_types'));

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
      if(permissions('rooms_type_delete') == false){
          //set session message
          Session::flash('message', __('strings.do_not_have_permission'));
          return view('permissions');
      }

        $rooms_type_cats=Category::where('category_type_id',$id)->get();
        if(count($rooms_type_cats)!=0){
          Session::flash('deleted', __('strings.message_delete_cat'));
        }else{
          CategoriesType::destroy($id);
          Session::flash('deleted', __('strings.sew_status_3'));
        }
     return redirect('/admin/rooms_type');


    }





}

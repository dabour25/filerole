<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\Rule;
use App\Photo;
use App\CategoriesType;
use App\Category;

class FacilitiesController extends Controller
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
        if(permissions('facilities_show') == false){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $cat_type_ids=CategoriesType::where(['active' =>1,'org_id'=>Auth::user()->org_id ])->whereIn('type',[5,6])->get();
        foreach ($cat_type_ids as $value) {
        $value->categories=Category::where(['category_type_id'=>$value->id,'active'=>1,'org_id'=> Auth::user()->org_id])->get();
        }
        return view('Facilities.index',compact('cat_type_ids'));
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
    {
        $input = $request->all();

        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;

        if ($image = $request->file('photo_id')) {
            //give a name to image and move it to public directory
            $image_name = time() . $image->getClientOriginalName();
            $image->move('images', $image_name);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_name]);
            //save photo_id to user $input
            $input['photo_id'] = $photo->id;
        }

        Category::create($input);
        //set session message
        Session::flash('created', __('strings.create_message'));


        //redirect back to functions.index
        return redirect('/admin/Facilities');

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
    public function edit($id)
    {
        if(permissions('facility_edit') == false){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $Facility = Category::findOrFail($id);
        $cat_type=CategoriesType::where('id',$Facility->category_type_id)->first();
        $types=CategoriesType::where(['type'=>$cat_type->type,'active'=>1, 'org_id'=> Auth::user()->org_id])->first();
        return view('Facilities.edit', compact('Facility','types'));
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
        $v = \Validator::make($request->all(), [
             'name' => 'required' , 'name_en' => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }
        if ($image = $request->file('photo_id')) {
            //give a name to image and move it to public directory
            $image_name = time() . $image->getClientOriginalName();
            $image->move('images', $image_name);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_name]);
            //save photo_id to user $input
            $input['photo_id'] = $photo->id;

        }

        //update data into categories type table
        Category::findOrFail($id)->update($input);

        //set session message
        Session::flash('updated', __('strings.update_message'));
          return redirect('/admin/Facilities');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
      if(permissions('facility_delete') == false){
          //set session message
          Session::flash('message', __('strings.do_not_have_permission'));
          return view('permissions');
      }

        $cat_facility=DB::table('facility_list')->where('cat_id',$id)->get();
        if(count($cat_facility)!=0){
          Session::flash('deleted', __('strings.message_delete_facility'));
          return redirect('admin/Facilities');
        }else{
          Category::destroy($id);
          Session::flash('deleted', __('strings.sew_status_3'));
          return redirect('admin/Facilities');
        }


    }



    public function search(Request $request) {
   $serach = $request->input('categorey_name');
    if(app()->getLocale() =='ar'){
      $categories = Category::where('name', 'LIKE', '%' . $serach .
'%')->where('org_id',Auth::user()->org_id)->get();

    }else {
      $categories = Category::where('name_en', 'LIKE', '%' . $serach .
'%')->where('org_id',Auth::user()->org_id)->get();

    }
     return view('Facilities.index',compact('categories'));

  }

}

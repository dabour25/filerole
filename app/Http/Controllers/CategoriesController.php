<?php

namespace App\Http\Controllers;

use App\CategoriesType;
use App\Category;
use App\externalTrans;
use App\PriceList;
use App\Reservation;
use App\ReserveDetails;
use App\Tax;
use App\Transactions;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Photo;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;

class CategoriesController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Categories Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing booking categories views
    | to admin, to show all categories, provide ability to edit and delete
    | specific category.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = null)
    {
        if(permissions('categories_view') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        if($type == null){
            $list = Category::join('categories_type', function ($join) use ($type) { $join->on('categories_type.id', '=', 'categories.category_type_id')->whereBetween('categories_type.type', [1,2])->where(['categories.org_id' => Auth::user()->org_id]); })->select('categories.*', 'categories_type.type')->paginate(20);
        }else{
            $list = Category::join('categories_type', function ($join) use ($type) { $join->on('categories_type.id', '=', 'categories.category_type_id')->where(['categories_type.type' => $type, 'categories.org_id' => Auth::user()->org_id]); })->select('categories.*')->paginate(20);
        }

        return view('categories.index', compact('list', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        if(permissions('categories_add') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        return view('categories.create', compact('type'));

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
            'type' => 'required|not_in:0',
            'categories_type' => 'required',
            'name' => 'required',
            'name_en' => 'required',
            //'photo_id' => 'mimes:jpeg,png',
            'active' => 'required',
        ]);
        if($request->type == 1){
            $v = \Validator::make($request->all(), [
                'unit' => 'required|not_in:0',
            ]);
        }

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        $input['category_type_id'] = $request->categories_type;
        $input['cat_unit'] = $request->unit;
        $input['d_limit'] = $request->limit;
        $input['cloth_id'] = $request->cloths;
        $input['req_days'] = $request->preparation;
        $input['store_id'] = $request->stores;
        $input['required_time'] = $request->time;
        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;
        $input['expected_price	'] = $request->expected;

        //check if an image is selected
        if($image = $request->file('photo_id'))
        {

            //give a name to image and move it to public directory
            $image_name = trim(time().$image->getClientOriginalName());
            $image->move('images',$image_name);

            //persist data into photos table
            $photo = Photo::create(['file'=>$image_name]);

            //save photo_id to category $input
            $input['photo_id'] = $photo->id;
        }

        $insert = Category::create($input);

        if(!empty($request->selling) && $request->selling != ''){

            $input2['cat_id'] = $insert->id;
            $input2['price'] = $request->selling;

            if(!empty($request->tax)){
                $tax = Tax::findOrFail($request->tax);
                $input2['tax'] = $request->tax;

                if($tax->percent != null){
                    $tax_value = !empty($tax->percent) ? $tax->percent : 0;
                    $final_price = (($tax_value / 100) * $request->selling) + $request->selling;
                }elseif ($tax->value != null){
                    $tax_value = !empty($tax->value)? $tax->value : 0;
                    $final_price = $request->selling + $tax_value;
                }else{
                    $tax_value = 0;
                }

                $input2['tax_value'] = $tax_value;
                $input2['final_price'] = $final_price;
            }else{
                $input2['final_price'] = $request->selling;
            }
            $input2['date'] = date('Y-m-d');
            $input2['active'] = 1;

            $input2['user_id'] = Auth::user()->id;
            $input2['org_id'] = Auth::user()->org_id;

            PriceList::create($input2);
        }

        //set session message
        Session::flash('created', __('strings.message_success'));

        //redirect back to categories.index
        return redirect('/admin/categories');
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
    public function edit($type, $id)
    {
        if(permissions('categories_edit') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        $category = Category::findOrFail($id);
        $categorietypes = CategoriesType::where(['type' => $type, 'org_id' => Auth::user()->org_id])->get();

        $cloths = DB::table('categories_type')
            ->join('categories', function ($join) {
                $join->on('categories_type.id', '=', 'categories.category_type_id')
                    ->where('categories_type.type', 4);
            })->get();
        return view('categories.edit', compact('category', 'type', 'categorietypes', 'cloths'));
    }

    public function delPhoto($id = 0)
    {
        $category= Category::find($id);
        
        if(!empty($category) && $category->org_id == Auth()->user()->org_id)
        {
            
            $category->photo_id =null;
            if($category->save())
            {
                 Session::flash('deleted', __('strings.delete_message') );
                  return redirect()->back(); 
            }
          
          // not del 
           Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

        return redirect()->back();
          
        }
        
        // access dien or Not Found 
         Session::flash('danger', __('OoPs..! Not Found OR access deniedr'));

        return redirect()->back();
        
      
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
            'categories_type' => 'required',
            'name' => 'required',
            'name_en' => 'required',
            'photo_id' => 'mimes:jpeg,png,jpg',
            'active' => 'required',
        ]);
        if($request->type == 1){
            $v = \Validator::make($request->all(), [
                'unit' => 'required|not_in:0'
            ]);
        }else if($request->type == 2){

        }else if($request->type == 3){

        }else if($request->type == 4){
            $v = \Validator::make($request->all(), [
                'color' => 'required|not_in:0'
            ]);
        }

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        $input['category_type_id'] = $request->categories_type;
        $input['cat_unit'] = $request->unit;
        $input['d_limit'] = $request->limit;
        $input['cloth_id'] = $request->cloths;
        $input['req_days'] = $request->preparation;
        $input['store_id'] = $request->stores;
        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;
        $input['expected_price	'] = $request->expected;
        $input['required_time'] = $request->time;
        //check if image is selected
        if($image = $request->file('photo_id'))
        {
            //give a name to image and move it to public directory
            $image_name = trim(time().$image->getClientOriginalName());
            $image->move('images',$image_name);

            //persist data into photos table
            $photo = Photo::create(['file'=>$image_name]);

            //save photo_id to category $input
            $input['photo_id'] = $photo->id;

            //find category
            $category = Category::findOrFail($id);

            //unlink old photo if set
            if($category->photo != NULL)
            {
                unlink(public_path().$category->photo->file);
            }

            //delete data from photos table
            Photo::destroy($category->photo_id);
        }

        //update data into categories table
        Category::findOrFail($id)->update($input);

        //set session message and redirect back categories.index
        Session::flash('updated', __('strings.message_success_updated'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Transactions::where(['cat_id' => $id, 'org_id' => Auth::user()->org_id])->exists() || ReserveDetails::where(['cat_id' => $id, 'org_id' => Auth::user()->org_id])->exists() || externalTrans::where(['cat_id' => $id, 'org_id' => Auth::user()->org_id])->exists()){
            //set session message and redirect back to categories_type.index
            Session::flash('deleted', __('strings.delete_message_failed2'));

            return redirect('admin/categories_type');
        }else {
            //find specific category
            $category = Category::findOrFail($id);

            if($category->photo)
            {
                //unlink image
                unlink(public_path().$category->photo->file);

                //delete from photo table
                Photo::destroy($category->photo_id);
            }

            //delete category
            Category::destroy($category->id);

            //set session message and redirect back to categories.index
            Session::flash('deleted', __('strings.delete_message') );
            return redirect('admin/categories_type');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetType($id)
    {
        return CategoriesType::where(['type' => $id, 'active' => 1,'org_id' => Auth::user()->org_id])->orderBy('name', 'ASC')->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetCategories($id)
    {

        return DB::table('categories_type')
            ->join('categories', function ($join) {
                $join->on('categories_type.id', '=', 'categories.category_type_id')
                    ->where('categories_type.type', 4);
            })->get();
    }


    public function search(Request $request){
        $type = $request->type;
        if($request->type != null) {
            if ($request->categories_type == 0) {
                $list = Category::join('categories_type', function ($join) use ($type) {
                    $join->on('categories_type.id', '=', 'categories.category_type_id')->where(['categories_type.type' => $type, 'categories.org_id' => Auth::user()->org_id]);
                })->select('categories.*')->where(['categories.org_id' => Auth::user()->org_id])->paginate(20);
            } else {
                $list = Category::where(['category_type_id' => $request->categories_type, 'org_id' => Auth::user()->org_id])->paginate(20);
            }
        }else{
            if ($request->categories_type == 0) {
                $list = Category::join('categories_type', function ($join) use ($type) {
                    $join->on('categories_type.id', '=', 'categories.category_type_id')->whereBetween('categories_type.type', [1,2])->where(['categories.org_id' => Auth::user()->org_id]);
                })->select('categories.*')->where(['categories.org_id' => Auth::user()->org_id])->paginate(20);
            } else {
                $list = Category::where(['category_type_id' => $request->categories_type, 'org_id' => Auth::user()->org_id])->paginate(20);
            }
        }

        if(!empty($request->keyword)){
            $list = Category::where(['org_id' => Auth::user()->org_id])->where('name', 'like', '%'. $request->keyword .'%')->orWhere('barcode', 'like', '%'. $request->keyword .'%')->paginate(20);
        }

        return view('categories.index', compact('list', 'type'));
    }
}

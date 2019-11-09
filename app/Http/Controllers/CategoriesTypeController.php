<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use App\Offers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\CaptinAvailable;
use App\CategoriesType;
use App\CategoryDetails;
use Auth;
use Illuminate\Validation\Rule;


class CategoriesTypeController extends Controller
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
    public function index($type = null)
    {
        if(permissions('categories_type_view') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        if(request()->is('admin/categories_type')){
            $types = CategoriesType::where(['type' => 2 ,'org_id' => Auth::user()->org_id])->paginate(20);
        }
        if(request()->is('admin/categories_type/offers')){
            $ids = [];
            $list =  CategoriesType::join('categories', function ($join) {
                $join->on('categories_type.id', '=', 'categories.category_type_id')
                    ->where([ 'categories_type.type' => 2, 'categories_type.org_id' => Auth::user()->org_id]);
            })->get();

            foreach ($list as $value){
                $ids[] = $value->id;
            }
            $types =  Offers::whereIn('cat_id', $ids)->paginate(20);

        }
        if(request()->is('admin/categories_type/items')){
            $types = CategoriesType::where(['type' => 1 ,'org_id' => Auth::user()->org_id])->paginate(20);
        }
        if(request()->is('admin/categories_type/items/offers')){
            $ids = [];
            $list =  CategoriesType::join('categories', function ($join) {
                $join->on('categories_type.id', '=', 'categories.category_type_id')
                    ->where([ 'categories_type.type' => 1, 'categories_type.org_id' => Auth::user()->org_id]);
            })->get();

            foreach ($list as $value){
                $ids[] = $value->id;
            }
            $types =  Offers::whereIn('cat_id', $ids)->paginate(20);
        }
        
        if(request()->is('admin/categories_type/suggestion')){
            $types = Category::where(['grouped' => 2, 'org_id' => Auth::user()->org_id])->paginate(20);
        }

        if(request()->is('admin/categories_type/suggest_product')){
            $list =  CategoriesType::join('categories', function ($join) {
                $join->on('categories_type.id', '=', 'categories.category_type_id')
                    ->where([ 'categories_type.type' => 1, 'categories_type.org_id' => Auth::user()->org_id, 'categories.grouped' => null]);
            })->get();
            return view('categories_type.index', compact( 'types', 'type', 'list'));
        }
        return view('categories_type.index', compact( 'types', 'type'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        if(permissions('categories_type_add') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        return view('categories_type.create', compact('type'));
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
            'type' => 'required', 'active' => 'required' , 'name' => 'required' , 'name_en' => 'required'

        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;

        CategoriesType::create($input);


        //set session message
        Session::flash('created', __('strings.message_success'));
        if($request->type == 1){
            //redirect back to functions.index
            return redirect('/admin/categories_type/items');
        }else{
            //redirect back to functions.index
            return redirect('/admin/categories_type');
        }
        

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
        if(permissions('categories_type_edit') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $data = CategoriesType::findOrFail($id);
        return view('categories_type.edit', compact('type', 'data'));
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
        $id= $request->id;
        $v = \Validator::make($request->all(), [
            'type' => 'required', 'active' => 'required' , 'name' => 'required' , 'name_en' => 'required'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;

        //update data into categories type table
        CategoriesType::findOrFail($id)->update($input);

        //set session message
        Session::flash('updated', __('strings.message_success_updated'));

        //redirect back to functions.index
       
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        if(Category::where(['category_type_id' => $id, 'org_id' => Auth::user()->org_id])->exists()){
            //set session message and redirect back to categories_type.index
            Session::flash('deleted', __('strings.delete_message_failed'));

               return redirect()->back();
        }else {
            //delete categories type
            CategoriesType::destroy($id);

            //set session message and redirect back to categories_type.index
            Session::flash('deleted', __('strings.delete_message'));
            
            return redirect()->back();
        }
    }
    
    public function AddSuggestProduct(Request $request){

        $id = Category::insertGetId([ 'name' => $request->name, 'name_en' => $request->name_en, 'category_type_id' => $request->classification, 'barcode' => $request->barcode, 'grouped' => 2, 'active' => 1, 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);

        if(!empty($request->categories) && $request->categories != 0){
            CategoryDetails::create(['cat_id' => $id, 'catsub_id' => $request->categories, 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
        }

        if(!empty($request->suggest_product) && $request->suggest_product !== [null]){
            foreach ($request->suggest_product as $key => $value) {
                if($value != 0) {
                    CategoryDetails::create(['cat_id' => $id, 'catsub_id' => $value, 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
                }
            }
        }
        //set session message
        Session::flash('created', __('strings.message_success'));

        //redirect back
        return redirect('admin/categories_type/suggestion');
    }

    public function ViewSuggestProduct($id){
        $data = Category::where('id', $id)->first();
        $list =  CategoriesType::join('categories', function ($join) {
            $join->on('categories_type.id', '=', 'categories.category_type_id')
                ->where([ 'categories_type.type' => 1, 'categories_type.org_id' => Auth::user()->org_id, 'categories.grouped' => null]);
        })->get();
        return view('categories_type.index', compact( 'types', 'type', 'list', 'data'));
    }

    public function EditSuggestProduct(Request $request, $id){

        Category::where('id', $id)->update([ 'name' => $request->name, 'name_en' => $request->name_en, 'category_type_id' => $request->classification, 'barcode' => $request->barcode, 'grouped' => 2, 'active' => 1, 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
        CategoryDetails::where('cat_id', $id)->delete();

        if(!empty($request->categories) && $request->categories != 0){
            CategoryDetails::create(['cat_id' => $id, 'catsub_id' => $request->categories, 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
        }

        if(!empty($request->suggest_product) && $request->suggest_product !== [null]){
            foreach ($request->suggest_product as $key => $value) {
                if($value != 0) {
                    CategoryDetails::create(['cat_id' => $id, 'catsub_id' => $value, 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
                }
            }
        }

        //set session message
        Session::flash('created', __('strings.message_success_updated'));

        //redirect back
        return redirect('admin/categories_type/suggestion');
    }

    public function SuggestionDetails(Request $request, $id){

        foreach ($data = CategoryDetails::where('cat_id', $id)->get() as $value){
            $value->type = Category::where('id', $value->catsub_id)->first()->type->type == 1 ? __('strings.categories') : __('strings.services');
            $value->name = app()->getLocale() == 'ar' ? Category::where('id', $value->catsub_id)->value('name') : Category::where('id', $value->catsub_id)->value('name_en');
        }

        return $data;
    }

}

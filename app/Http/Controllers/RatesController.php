<?php

namespace App\Http\Controllers;

use App\CategoriesType;
use App\Category;
use App\CategoryDetails;
use App\PriceList;
use App\Tax;
use App\Transactions;
use App\Property;
use App\Bookings;
use App\CategoryNum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Auth;
use DB;

class RatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        if(permissions('rates_view') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        $list = Property::where(['org_id' => Auth::user()->org_id]);
        if(!empty($request->hotels)){
            $list = $list->where('id', $request->hotels);
        }
        $list = $list->paginate(20);

        return view('rates.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(permissions('rates_add') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        $id = $request->id;
        $taxs = Tax::where(['org_id' => Auth::user()->org_id, 'active' => 1])->get();

        return view('rates.create', compact('taxs', 'id'));

    }




    public function SmartPricing(Request $request, $id){
        if(permissions('rates_smart_pricing') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        if($request->usage == 0 || $request->usage != ''){
            foreach (Category::where([ 'org_id' => Auth::user()->org_id, 'property_id' => $id  ])->get() as $value){
                $reserved = Bookings::whereMonth('book_from', date('m'))->join('booking_detail', 'bookings.id', '=', 'booking_detail.book_id')->where(['booking_detail.cat_id' => $value->id, 'bookings.book_status' => 'y', 'bookings.org_id' => Auth::user()->org_id])->select('bookings.*')->count();
                $cat_num =  CategoryNum::where('cat_id', $value->id)->count();
                if(($reserved / $cat_num * 100) == $request->usage){
                    $ids[] = $value->id;
                }
            }
            $list = Category::WhereIn('id', $ids)->get();
            return view('rates.smart', compact('list', 'id'));
        }

        foreach ($ids = Property::join('categories', 'property.id', '=', 'categories.property_id')->where(['property.prop_type' => 'hotel','property.org_id' => Auth::user()->org_id, 'categories.property_id' => $id])->select('categories.id as cat_id')->get() as $value){
            if(PriceList::where(['cat_id' => $value->cat_id])->exists()){
                $value->cat_id = $value->cat_id;
            }else{
                $value->cat_id = null;
            }
        }

        $list = Category::WhereIn('id', $ids)->get();
        return view('rates.smart', compact( 'list', 'id'));
    }

    public function SmartPricingPost(Request $request){

        foreach ($list = PriceList::/*where('date', '!=' , date('Y-m-d'))->*/WhereIn('cat_id', $request->rooms)->get() as $value){

            if($request->price_type == 1){
                if (isset($request->type) && $request->type != 0) {
                    if ($request->type == 1) {
                        $discount_price = ($value->price + ($request->discount_value / 100 * $value->price));
                    } elseif ($request->type == 2) {
                        $discount_price = $value->price + $request->discount_value;
                    }
                }
            }else{
                if (isset($request->type) && $request->type != 0) {
                    if ($request->type == 1) {
                        $discount_price = ($value->price - ($request->discount_value / 100 * $value->price));
                    } elseif ($request->type == 2) {
                        $discount_price = $value->price - $request->discount_value;
                    }
                }
            }

            if(!empty($value->tax) && $value->tax != '') {
                $tax = Tax::findOrFail($value->tax);

                if ($tax->percent != null) {
                    $tax_value = !empty($tax->percent) ? $tax->percent : 0;
                    $final_price = (($tax_value / 100) * $discount_price) + $discount_price;
                } elseif ($tax->value != null) {
                    $tax_value = !empty($tax->value) ? $tax->value : 0;
                    $final_price = $discount_price + $tax_value;
                }
            }else{
                $tax_value = 0;
                $final_price = $discount_price;
            }

            if(PriceList::where(['cat_id' => $value->cat_id,'date' => $request->date, 'org_id' => Auth::user()->org_id ])->doesntExist()){
                PriceList::create([ 'cat_id' => $value->cat_id, 'date' => $request->date, 'price' => $discount_price, 'tax' => $value->tax, 'tax_value' => $value->tax_value, 'final_price' => $final_price, 'active' => 1, 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
            }
        }

        //set session message
        Session::flash('created', __('strings.message_success'));

        //redirect back
        return redirect('admin/rates');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $categories = $request->categories;

        $input['cat_id'] = $categories;
        if(PriceList::where(['cat_id' => $categories, 'date' => $request->date])->exists()){
            PriceList::where(['cat_id' => $categories, 'date' => $request->date])->delete();
            //CategoryDetails::where(['cat_id' => $categories])->delete();
        }

        $input['date'] = $request->date;

        $input['price'] = $request->room_price;
        if (isset($request->tax_type) && $request->tax_type != 0) {
            $tax = Tax::findOrFail($request->tax_type);
            $input['tax'] = $request->tax_type;

            if ($tax->percent != null) {
                $tax_value = !empty($tax->percent) ? $tax->percent : 0;
                $final_price = (($tax_value / 100) * $request->room_price) + $request->room_price;
            } elseif ($tax->value != null) {
                $tax_value = !empty($tax->value) ? $tax->value : 0;
                $final_price = $request->room_price + $tax_value;
            } else {
                $tax_value = 0;
            }
            $input['tax_value'] = $tax_value;
            $input['final_price'] = $final_price;
        } else {
            $input['final_price'] = $request->room_price;
        }
        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;
        PriceList::create($input);

        if(!empty($request->childrens) && $request->childrens !== [null]){
            foreach ($request->childrens as $key => $value) {
                if(CategoryDetails::where([ 'cat_id' => $categories, 'catsub_id' => $value, 'org_id' => Auth::user()->org_id])->exists()) {
                    CategoryDetails::where([ 'cat_id' => $categories, 'catsub_id' => $value, 'org_id' => Auth::user()->org_id])->update(['cat_id' => $categories, 'catsub_id' => $value, 'age_from' => null, 'age_to' => null, 'price' => $request->price[$key], 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
                }else{
                    CategoryDetails::create(['cat_id' => $categories, 'catsub_id' => $value, 'age_from' => null, 'age_to' => null, 'price' => $request->price[$key], 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
                }
            }
        }

        if(!empty($request->types) && $request->types !== [null]){
            foreach ($request->types as $key => $value) {
                if($value != 0) {
                    if(CategoryDetails::where([ 'cat_id' => $categories, 'catsub_id' => $value, 'org_id' => Auth::user()->org_id])->exists()) {
                        CategoryDetails::where([ 'cat_id' => $categories, 'catsub_id' => $value, 'org_id' => Auth::user()->org_id])->update(['cat_id' => $categories, 'catsub_id' => $value, 'price' => $request->other_price[$key], 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
                    }else{
                        CategoryDetails::create(['cat_id' => $categories, 'catsub_id' => $value, 'price' => $request->other_price[$key], 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
                    }
                }
            }
        }

        //set session message
        Session::flash('created', __('strings.message_success'));

        //redirect back
        return redirect('admin/rates');
    }


    public function check($id, $price){
        $tax = Tax::where('id',$id)->first();

        if ($tax->percent != null) {
            $tax_value = !empty($tax->percent) ? $tax->percent : 0;
            $final_price = (($tax_value / 100) * $price) + $price;
        } elseif ($tax->value != null) {
            $tax_value = !empty($tax->value) ? $tax->value : 0;
            $final_price = $price + $tax_value;
        } else {
            $tax_value = 0;
        }

        return empty($final_price) ? $price : $final_price;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PriceList::where(['cat_id' => $id])->delete();
        CategoryDetails::where(['cat_id' => $id])->delete();

        //set session message and redirect back
        Session::flash('deleted', __('strings.delete_message'));
        return redirect('admin/rates');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function GetRoom($id)
    {
        foreach ($rooms = Category::where(['property_id' => $id, 'org_id' => Auth::user()->org_id])->get() as $value){
            $value->type = app()->getLocale() == 'ar' ? CategoriesType::where('id', $value->category_type_id)->value('name') : CategoriesType::where('id', $value->category_type_id)->value('name_en');
        }
        return $rooms;
    }

    public function GetFees($id){
        foreach ($list = CategoryDetails::where('cat_id', $id)->get() as $value){
            if(!empty($value->age_from) && !empty($value->age_to)){
                $value->name = Category::where('id', $value->catsub_id)->value('name') .'   '. __('strings.age_from').'  '. $value->age_from. '  ' .__('strings.age_to').'  '.$value->age_to;
            }else{
                $value->name = Category::where('id', $value->catsub_id)->value('name');
            }
            $value->price = Decimalplace($value->price);
        }
        return $list;
    }

    public function search(Request $request){
        if(permissions('rates_search') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        //return $request->all();
        $list = Category::join('price_list', 'categories.id', '=', 'price_list.cat_id')->whereNotNull('property_id');

        if(!empty($request->hotels)){
            $list = $list->where('property_id', $request->hotels);
        }
        if(!empty($request->room_type)){
            $list = $list->join('categories_type','categories_type.id', '=', 'categories.category_type_id')->where('category_type_id', $request->room_type);
        }
        if(!empty($request->date_from) && !empty($request->date_to)){
            $list = $list->whereBetween('date', [$request->date_from, $request->date_to]);
        }
        $list =  $list->where('price_list.org_id', Auth::user()->org_id)->select('price_list.*')->orderBy('price_list.date', 'DESC')->paginate(20);
        //$list =  $list->select('price_list.*')->paginate(20);

        return view('rates.search', compact('list'));
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function GetDetails($id){
        $list = [PriceList::where('cat_id', $id)->orderBy('date', 'DESC')->where('date', '<=' , date('Y-m-d'))->first()];

        return view('rates.details', compact('list', 'id'));
    }

    public function SmartPrice(Request $request){
        if(permissions('rates_smart_pricing') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        $id = $request->property != '' ? $request->property : null;
        $property = Property::where(['org_id' => Auth::user()->org_id])->get();

        if(($request->usage == 0 || $request->usage != '') && $request->property != ''){
            foreach (Category::where(['org_id' => Auth::user()->org_id, 'property_id' => $id])->get() as $value){
                
                if(!empty($request->usage)){
                    if(round(AvailableRooms($id, date('Y-m-d'))['reserved'] / AvailableRooms($id, date('Y-m-d'))['available'] * 100) == $request->usage){
                        $ids[] = $value->id;
                    }
                }else{
                    $ids[] = $value->id;
                }
            }
            $list = Category::WhereIn('id', $ids)->get();
            return view('rates.smart', compact('list', 'id', 'property'));
        }

        foreach ($ids = Property::join('categories', 'property.id', '=', 'categories.property_id')->where(['property.prop_type' => 'hotel','property.org_id' => Auth::user()->org_id, 'categories.property_id' => $id])->select('categories.id as cat_id')->get() as $value){
            if(PriceList::where(['cat_id' => $value->cat_id])->exists()){
                $value->cat_id = $value->cat_id;
            }else{
                $value->cat_id = null;
            }
        }


        $list = Category::WhereIn('id', $ids)->get();
        return view('rates.smart', compact( 'list', 'id', 'property'));
    }


    public function SmartPriceGetRoom(Request $request, $id){
        foreach ($rooms = Category::where(['property_id' => $id, 'org_id' => Auth::user()->org_id])->get() as $value){
            $value->name = app()->getLocale() == 'ar' ? $value->name.' - '.PriceList::where([ 'cat_id' => $value->id])->orderBy('date', 'desc')->value('date') : $value->name_en.' - '.PriceList::where([ 'cat_id' => $value->id])->orderBy('date', 'desc')->value('date');
            $value->type = app()->getLocale() == 'ar' ? CategoriesType::where('id', $value->category_type_id)->value('name') : CategoriesType::where('id', $value->category_type_id)->value('name_en');
        }
        return $rooms;
    }
}

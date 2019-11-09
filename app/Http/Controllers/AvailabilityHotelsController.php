<?php

namespace App\Http\Controllers;

use App\CategoriesType;
use App\Category;
use App\PriceList;
use App\Property;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Auth;

class AvailabilityHotelsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*if(permissions('availability_matrix') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }*/
        if(!empty($request->hotels) && $request->hotels != 0){
            $property_id = $request->hotels;
            $rooms = Category::join('categories_type', function ($join) use ($property_id){
                $join->on('categories_type.id', '=', 'categories.category_type_id')->where(['categories.property_id' => $property_id,'categories.org_id' => Auth::user()->org_id]);
            })->select('categories_type.*', 'categories.id as cat_id')->get();
        }else {
            $rooms = Category::join('categories_type', function ($join) {
                $join->on('categories_type.id', '=', 'categories.category_type_id')->where(['categories.org_id' => Auth::user()->org_id])->whereNotNull('categories.property_id');
            })->select('categories_type.*', 'categories.id as cat_id')->get();
        }

        foreach ($rooms as $value){
            $value->category_name = app()->getLocale() == 'ar' ? Property::where('id', Category::where('id', $value->cat_id)->value('property_id'))->value('name')  :Property::where('id', Category::where('id', $value->cat_id)->value('property_id'))->value('name_en');
            $value->property_id = Property::where('id', Category::where('id', $value->cat_id)->value('property_id'))->value('id');
        }
        return view('availability.index', compact('rooms'));
    }

}

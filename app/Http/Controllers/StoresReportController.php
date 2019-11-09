<?php

namespace App\Http\Controllers;

use App\Banking;
use App\CategoriesType;
use App\Category;
use App\Customers;
use App\Functions;
use App\Stores;
use App\Offers;
use App\PermissionReceivingPayments;
use App\PermissionReceiving;
use App\PriceList;
use App\CustomerHead;
use App\Transactions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use Illuminate\Validation\Rule;
use Input;
use App\Charts\Purchases;
use App\Suppliers;
use Excel;
use App\Exports\PurchasesBySupplierExport;

class StoresReportController extends Controller
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

    public function Stores(Request $request){
        //return $request->all();
        $types = $request->types == 0 ? $types = [1,4] : $request->types;
        $request->search_date_from == null ? $date_from = null : $date_from = date('Y-m-d', strtotime($request->search_date_from));
        $request->search_date_to == null ? $date_to = null : $date_to = date('Y-m-d', strtotime($request->search_date_to));
        $categories_type = $request->categories_type;
        $stores = $request->stores; $categories = $request->categories;
        if(!empty($request->search_date_from) && !empty($request->search_date_to)){
            if($date_from > $date_to){
                return redirect()->back()->with('message', __('strings.valid_date'));
            }
        }

        return view('StoresReport.report', compact('date_from', 'date_to', 'types', 'stores', 'categories_type', 'categories' ));

    }

    public function Store_value(Request $request){

        if(empty($request->stores) && $request->stores == 0){
            $stores = Stores::where(['org_id' => Auth::user()->org_id, 'active' => 1])->get();
        }else{
            $stores = Stores::where('id', $request->stores)->get();
        }

        return view('StoresReport.store_value', compact('stores'));
    }




}

<?php

namespace App\Http\Controllers;

use App\CategoriesType;
use App\Category;
use App\PriceList;
use App\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use Illuminate\Validation\Rule;

class PriceListController extends Controller
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
        if(permissions('price_list_view') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        $list = PriceList::join('categories', function ($join) use ($type) {
            $join->on('price_list.cat_id', '=', 'categories.id')->where(['categories.org_id' => Auth::user()->org_id]);
        })->join('categories_type', function ($join) use ($type) {
            $join->on('categories_type.id', '=', 'categories.category_type_id')->whereIn('categories_type.type', [1,2]);
        })->select('categories.name', 'categories.name_en','categories.category_type_id', 'price_list.*')->where('date', '<=' , date('Y-m-d'))->paginate(20);
        
        return view('price_list.index', compact('list', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        if(permissions('price_list_add') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $taxs = Tax::where(['org_id' => Auth::user()->org_id, 'active' => 1])->get();

        return view('price_list.create', compact('taxs', 'type'));

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
        $id = $request->categories;
        $day = $request->date;
        $v = \Validator::make($request->all(), [
            'type' => 'required|not_in:0',
            'categories_type' => 'required|not_in:0',
            'categories' => 'required',
            'price' => 'required',
            'date' => [
                'required',
                Rule::unique('price_list')->where(function ($query) use ($day, $id) {
                    return $query->where(['cat_id' => $id, 'date' => $day]);
                }),
            ],
            'active' => 'required'
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        $input['cat_id'] = $request->categories;
        $input['price'] = $request->price;
        if (isset($request->tax_type) && $request->tax_type != 0) {
            $tax = Tax::findOrFail($request->tax_type);
            $input['tax'] = $request->tax_type;

            if ($tax->percent != null) {
                $tax_value = !empty($tax->percent) ? $tax->percent : 0;
                $final_price = (($tax_value / 100) * $request->price) + $request->price;
            } elseif ($tax->value != null) {
                $tax_value = !empty($tax->value) ? $tax->value : 0;
                $final_price = $request->price + $tax_value;
            } else {
                $tax_value = 0;
            }

            $input['tax_value'] = $tax_value;
            $input['final_price'] = $final_price;
        } else {
            $input['final_price'] = $request->price;

        }
        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;

        PriceList::create($input);

        //set session message
        Session::flash('created', __('strings.message_success'));

        //redirect back to price_list.index
        return redirect('/admin/price_list');
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
    public function edit($type, $id)
    {
        if(permissions('price_list_edit') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        $list = PriceList::findOrFail($id);
        $taxs = Tax::where(['org_id' => Auth::user()->org_id, 'active' => 1])->get();
        return view('price_list.edit', compact('list', 'taxs', 'type'));
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
        $input = $request->all();
        $categories = $request->categories;
        $day = $request->date;

        $v = \Validator::make($request->all(), [
            'price' => 'required|numeric',
            'active' => 'required',
            /*'date' => [
                'required',
                Rule::unique('price_list')->where(function ($query) use($day, $categories) {
                    return $query->where(['cat_id' => $categories ,'date' => $day, 'active' => 1]);
                }),
            ],*/

        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        if (isset($request->tax_type) && $request->tax_type != 0) {
            $tax = Tax::findOrFail($request->tax_type);
            $input['tax'] = $request->tax_type;

            if ($tax->percent != null) {
                $tax_value = $tax->percent;
                $final_price = (($tax_value / 100) * $request->price) + $request->price;
            } elseif ($tax->value != null) {
                $tax_value = $tax->value;
                $final_price = $request->price + $tax_value;
            } else {
                $tax_value = 0;
            }

            $input['tax_value'] = $tax_value;

            $input['final_price'] = $final_price;
        } else {
            $input['tax'] = null;
            $input['tax_value'] = null;
            //$input['final_price'] = null;
        }

        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;

        //update data into price_list table
        PriceList::findOrFail($id)->update($input);

        //set session message and redirect back price_list.index
        Session::flash('updated', __('strings.message_success_updated'));
        return redirect('admin/price_list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        //delete price
        PriceList::destroy($id);

        //set session message and redirect back to price_list.index
        Session::flash('deleted', __('strings.price_list_msg_3'));
        return redirect('admin/price_list');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function GetType($id)
    {
        return CategoriesType::where(['type' => $id, 'org_id' => Auth::user()->org_id, 'active' => 1])->get();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function GetCategories($id)
    {
        $list = Category::where(['category_type_id' => $id, 'org_id' => Auth::user()->org_id, 'active' => 1])->get();
        return $list;

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function GetTax($id)
    {

        return Tax::where(['id' => $id, 'org_id' => Auth::user()->org_id])->get();

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function CheckPrice($id, $date)
    {
        return PriceList::where(['cat_id' => $id, 'date' => $date, 'org_id' => Auth::user()->org_id])->exists() == true ? 1 : 0;
    }

    public function CheckPurchasingPrice($id, $value){
        if(Transactions::where(['org_id' => Auth::user()->org_id, 'cat_id' => $id])->whereNotNull('supplier_id')->orderBy('date', 'desc')->value('price') > $value){
            return 1;
        }else{
            return 0;
        }
    }
}

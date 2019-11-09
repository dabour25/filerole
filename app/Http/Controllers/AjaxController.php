<?php

namespace App\Http\Controllers;

use App\CategoriesType;
use App\Category;
use App\Customers;
use App\Photo;
use App\PriceList;
use App\Stores;
use App\Tax;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\CaptinAvailable;
use App\WeeklyVacations;
use App\Sections;
use Auth;
use Illuminate\Validation\Rule;
use App\CustomerMeasure;
use App\Measures;
use DB;
use App\Companies;
use App\Suppliers;
use App\SuppliersItems;
use App\org;
class AjaxController extends Controller
{
    public function Tax(Request $request)
    {
        $input = $request->all();
        if ($request->ajax()) {
            $input['org_id'] = Auth::user()->org_id;
            $input['user_id'] = Auth::user()->id;

            $data = Tax::create($input);

            return ['status' => 200, 'data' => $data];
        }
    }

    public function CategoriesType(Request $request)
    {
        $input = $request->all();
        if ($request->ajax()) {
            $input['org_id'] = Auth::user()->org_id;
            $input['user_id'] = Auth::user()->id;

            $data = CategoriesType::create($input);

            return ['status' => 200, 'data' => $data];
        }
    }


    public function AddCustomer(Request $request)
    {
        $input = $request->all();

        if ($request->ajax()) {
            $input['country_id'] = $request->country_id;
            $input['city'] = $request->city;
            $input['org_id'] = Auth::user()->org_id;

            $data = Customers::create($input);

            return ['status' => 200, 'data' => $data];
        }
    }

    public function AddCategories(Request $request)
    {
        $input = $request->all();
        $input2 = $request->all();

        if ($request->ajax()) {

            $input['category_type_id'] = $request->categories_type;
            $input['cat_unit'] = $request->unit;
            $input['user_id'] = Auth::user()->id;
            $input['org_id'] = Auth::user()->org_id;
            $input['expected_price	'] = $request->expected;
            $input['store_id'] = $request->stores;
            $input['required_time'] = $request->time;
            
            //check if an image is selected
            if($image = $request->file('photo_id'))
            {
                //give a name to image and move it to public directory
                $image_name = trim(time().$image->getClientOriginalName());
                $image->move('images',$image_name);
                //persist data into photos table
                $photo = Photo::create(['file' => $image_name]);
                //save photo_id to category $input
                $input['photo_id'] = $photo->id;
            }
            
            $insert = Category::create($input);

            if (!empty($request->selling) && $request->selling != '') {

                $input2['cat_id'] = $insert->id;
                $input2['price'] = $request->selling;

                if (!empty($request->tax)) {
                    $tax = Tax::findOrFail($request->tax);
                    $input2['tax'] = $request->tax;

                    if ($tax->percent != null) {
                        $tax_value = !empty($tax->percent) ? $tax->percent : 0;
                        $final_price = (($tax_value / 100) * $request->selling) + $request->selling;
                    } elseif ($tax->value != null) {
                        $tax_value = !empty($tax->value) ? $tax->value : 0;
                        $final_price = $request->selling + $tax_value;
                    } else {
                        $tax_value = 0;
                    }

                    $input2['tax_value'] = $tax_value;
                    $input2['final_price'] = $final_price;
                } else {
                    $input2['final_price'] = $request->selling;
                }
                $input2['date'] = date('Y-m-d');
                $input2['active'] = 1;

                $input2['user_id'] = Auth::user()->id;
                $input2['org_id'] = Auth::user()->org_id;

                PriceList::create($input2);
            }

            return ['status' => 200, 'data' => $insert];
        }

    }


    public function CategoriesModal($type)
    {

        return view('modals.categories', compact('type'));
    }

    public function PriceModal(Request $request)
    {
        if(!empty($request->cat_id)){
            $cat_id = $request->cat_id;
        }else{
            $cat_id = null;
        }
        return view('modals.price', compact('cat_id'));
    }

    public function AddPrice(Request $request)
    {
        $input = $request->all();

        if ($request->ajax()) {
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

            $data = PriceList::create($input);

            return ['status' => 200, 'data' => $data];
        }
    }

    public function login(Request $request)
    {
        if (Auth::guard('web')->attempt(['email' => $request->mail, 'password' => $request->password]) || Auth::guard('web')->attempt(['phone_number' => $request->mail, 'password' => $request->password])) {
            $user = Auth::user();
            $user_id = $user->id;
            if(org::where('id', Auth::user()->org_id)->value('owner_url') != explode('/',url()->current())[2]){
               return 'false';
            }

            $funcs = DB::table('functions_user')->where('funcparent_id', '0')->where('user_id', $user_id)->where('org_id', Auth::user()->org_id)->where('appear', '1')->orderBy('porder')->get();
            $sub_funcs = DB::table('functions_user')->where('funcparent_id', '>', '0')->where('user_id', $user_id)->where('org_id', Auth::user()->org_id)->where('appear', '1')->orderBy('porder')->get();
            $func_links = DB::table('function_new')->orderBy('porder')->get();

            $partents = Session::put('partents', $funcs);
            $childs = Session::put('childs', $sub_funcs);
            $links = Session::put('links', $func_links);
            return 'true';
        } else {
            return 'false';
        }

    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        Session::forget('partents');
        Session::forget('childs');
        Session::forget('links');


        $request->session()->flush();
        $request->session()->regenerate();
        return "Done";

    }

    public function addSection(Request $request)
    {
        $input = $request->all();

        if ($request->ajax()) {
            $input['org_id'] = Auth::user()->org_id;

            $data = Sections::create($input);

            return ['status' => 200, 'data' => $data];
        }
    }

    public function addMeasure(Request $request)
    {
        $input = $request->all();

        if ($request->ajax()) {

            $input['active'] = 1;
            $input['org_id'] = Auth::user()->org_id;
            $input['user_id'] = Auth::user()->id;

            $data = Measures::create($input);

            return ['status' => 200, 'data' => $data];
        }
    }

    public function updateMeasures(Request $request)
    {
        if ($request->ajax()) {
            CustomerMeasure::where('cust_id', $request->customer_id)->delete();
            foreach ($request->ids as $key => $value) {
                CustomerMeasure::create(['cust_id' => $request->customer_id, 'active' => 1, 'measure_id' => $value, 'measure_val' => $request->values[$key], 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
            }
            return ['status' => 200];
        }
    }

    public function MeasureList(Request $request, $customer_id)
    {

        foreach ($data = Measures::where(['org_id' => Auth::user()->org_id, 'active' => 1])->get() as $value) {
            $v = CustomerMeasure::where(['measure_id' => $value->id, 'cust_id' => $customer_id])->first();
            $value->measure_val = $v->measure_val;
            $value->name = app()->getLocale() == 'ar' ? $value->name : $value->name_en;
        }
        return ['status' => 200, 'data' => $data];
    }

    public function AddCompanies(Request $request)
    {
        $input = $request->all();

        if ($request->ajax()) {

            $input['active'] = 1;
            $input['org_id'] = Auth::user()->org_id;
            $input['user_id'] = Auth::user()->id;

            $data = Companies::create($input);

            return ['status' => 200, 'data' => $data];
        }
    }


    public function AddSupplier(Request $request)
    {
        $input = $request->all();
        $email = $request->email;
        $phone = $request->phone_number;

        $v = \Validator::make($request->all(), [
            'email' => [
                'required',
                Rule::unique('suppliers')->where(function ($query) use ($email) {
                    return $query->where(['email' => $email, 'org_id' => Auth::user()->org_id]);
                }),
            ],

            'phone_number' => [
                'required',
                Rule::unique('suppliers')->where(function ($query) use ($phone) {
                    return $query->where(['phone_number' => $phone, 'org_id' => Auth::user()->org_id]);
                }),
            ],
        ]);

        if ($v->fails()) {
            return ['status' => 400, 'data' => $v->errors()];
        }

        if ($request->ajax()) {

            $input['active'] = 1;
            $input['org_id'] = Auth::user()->org_id;
            $input['user_id'] = Auth::user()->id;

            $data = Suppliers::create($input);

            return ['status' => 200, 'data' => $data];
        }
    }

    public function AddSupplierItems(Request $request)
    {
        if ($request->ajax()) {
            if ($request->products && $request->products !== [null]) {
                foreach ($request->products as $key => $value) {
                    if ($value != 0) {
                        if (SuppliersItems::where(['cat_id' => $value, 'active' => 1, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id])->doesntExist()) {
                            SuppliersItems::Insert(['supplier_id' => $request->supplierid, 'cat_id' => $value, 'active' => 1, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
                        }
                    }
                }
            }
            return ['status' => 200];
        }
    }

    public function AddStore(Request $request)
    {
        $input = $request->all();
        if ($request->ajax()) {
            $input['org_id'] = Auth::user()->org_id;

            $data = Stores::create($input);

            return ['status' => 200, 'data' => $data];
        }
    }
    
    public function CategoryModal($id,$type)
    {
        $data = Category::where(['id' => $id, 'org_id' => Auth::user()->org_id])->first();
        return view('modals.category', compact('data','type'));
    }

    public function EditCategories(Request $request){
        //return $request->all();

        if ($request->ajax()) {
            $category = Category::where('id', $request->id)->first();
            //check if an image is selected
            if($image = $request->file('photo_id'))
            {
                //give a name to image and move it to public directory
                $image_name = trim(time().$image->getClientOriginalName());
                $image->move('images',$image_name);
                //persist data into photos table
                $photo = Photo::create(['file' => $image_name]);
                $photoo = $photo->id;
            }else{
                $photoo = $category->photo_id;
            }

            Category::where('id', $request->id)->update(['name' => $request->name, 'name_en' => $request->name_en, 'description' => $request->description, 'description_en' => $request->description_en,'photo_id' => $photoo, 'cat_unit' => $request->unit,'d_limit' => $request->limit,'brand' => $request->brand, 'volume' => $request->volume, 'required_time' => $request->time, 'barcode' => $request->barcode,'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);

            return ['status' => 200, 'message' => 'تم التعديل بنجاح'];
        }


    }
    
    
    public function UpdatePrice(Request $request){
        if ($request->ajax()) {
            $input = $request->all();
            if(PriceList::where(['cat_id' => $request->cat_id, 'date' => $request->date])->exists()){
                PriceList::where(['cat_id' => $request->cat_id, 'date' => $request->date])->delete();
            }
            $input['cat_id'] = $request->cat_id;
            $input['date'] = $request->date;
    
            $input['price'] = $request->value;
            if (isset($request->tax) && $request->tax != 0) {
                $tax = Tax::findOrFail($request->tax);
                $input['tax'] = $request->tax;
    
                if ($tax->percent != null) {
                    $tax_value = !empty($tax->percent) ? $tax->percent : 0;
                    $final_price = (($tax_value / 100) * $request->value) + $request->value;
                } elseif ($tax->value != null) {
                    $tax_value = !empty($tax->value) ? $tax->value : 0;
                    $final_price = $request->value + $tax_value;
                } else {
                    $tax_value = 0;
                }
                $input['tax_value'] = $tax_value;
                $input['final_price'] = $final_price;
            } else {
                $input['final_price'] = $request->value;
            }
            $input['user_id'] = Auth::user()->id;
            $input['org_id'] = Auth::user()->org_id;
            $data = PriceList::create($input);
            
            return ['status' => 200, 'data' => $data];
        
        }
        
        
        
    }
    

}

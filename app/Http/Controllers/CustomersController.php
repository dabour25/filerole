<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomersRequest;
use App\Http\Requests\CustomersUpdateRequest;
use App\Http\Requests\CustomersPasswordRequest;
use App\Customers;
use App\Photo;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\Rule;
use DB;
use App\org;
use App\Plans;
use Illuminate\Support\Str;
use App\externalReq;
use App\CustomerHead;
use App\Transactions;
use App\externalTrans;
use App\CustomerMeasure;
use App\CustomerPayment;
use App\CustomerPaymentDetail;
use App\loginHistoryCustomer;
use App\SystemLogs;
use App\PermissionReceivingPayments;
use App\Reservation;
use App\SewingRequest;
use App\Countries;


class CustomersController extends Controller
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
        if (permissions('customers_view') == 0) {
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $customers = Customers::where('org_id', Auth::user()->org_id)->paginate(20);
        return view('customers.index', compact('customers'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (permissions('customers_add') == 0) {
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        //maximum plan verification by hossam
        $current_created_customers = Customers::where('org_id', Auth::user()->org_id)->get()->count();
        $plan = org::where('id', Auth::user()->org_id)->first();
        if ($plan != null) {
            $plan_id = $plan->plan_id;
        }

        $maxmimum_customers_number = Plans::where('id', $plan_id)->first()->customer_value;
        if ($current_created_customers >= $maxmimum_customers_number) {
            Session::flash('danger', __('strings.exeeds maximum number of customers'));

            //redirect back to users.index
            return redirect('admin/customers');
        }
          $countries = Countries::all();
        //end maximum plan verification by hossam
        return view('customers.create',compact('countries'));
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
        $email = $request->email;
        $phone = $request->phone_number; //$code = $request->cust_code;

        $v = \Validator::make($request->all(), [
           'name' => 'required',
            'name_en' => 'required',
            //'password' => 'required|string|confirmed|min:6',
          'address' => 'required|string|max:255',
          'gender' => 'required',
            'photo_id' => 'mimes:jpeg,png|dimensions:min_width=300,min_height=300',
            'person_image' => 'mimes:jpeg,png|dimensions:min_width=300,min_height=200',
            'email' => [
                'required',
                Rule::unique('customers')->where(function ($query) use ($email) {
                    return $query->where(['email' => $email, 'org_id' => Auth::user()->org_id]);
                }),
                'email'
            ],

            'phone_number' => [
                'required',
                Rule::unique('customers')->where(function ($query) use ($phone) {
                    return $query->where(['phone_number' => $phone, 'org_id' => Auth::user()->org_id]);
                }),
            ],

            /*'cust_code' => [
                'required',
                Rule::unique('customers')->where(function ($query) use($code) {
                    return $query->where(['cust_code' => $code ,'org_id' => Auth::user()->org_id]);
                }),
            ],*/
        ]);

        if ($v->fails()) {
            return back()->withErrors($v->errors())->withInput();
        }

        // if ($request->from_date > $request->to_date) {
        //     return redirect()->back()->with('message', __('strings.customers_date'))->withInput();
        // }

        /*$code = rand(11111, 99999);

        if(Customers::where(['cust_code' => $code, 'org_id' => Auth::user()->org_id])->exists()){
            $input['cust_code'] = rand(11111, 99999);
        }else{
            $input['cust_code'] = $code;
        }*/

        //check if an image is selected
        if ($image = $request->file('photo_id')) {
            //give a name to image and move it to public directory
            $image_name = time() . $image->getClientOriginalName();
            $image->move('images', $image_name);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_name]);

            //save photo_id to user $input
            $input['photo_id'] = $photo->id;
        }
         if ($image = $request->file('person_image')) {
            //give a name to image and move it to public directory
            $image_person = time() . $image->getClientOriginalName();
            $image->move('images', $image_person);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_person]);

            //save photo_id to user $input
            $input['person_image'] = $photo->id;
        }

        $password = Str::random(8);

        $input['share_code'] = Str::random(6);
        $input['password'] = bcrypt($password);
        $input['org_id'] = Auth::user()->org_id;
        $input['active'] = 1;
        if($input['Notifications_phone']=='on') 
        $input['Notifications_phone']=1;  else $input['Notifications_phone']=0;
        if($input['Notifications_email']=='on') 
        $input['Notifications_email']=1; else $input['Notifications_email']=0;


        Customers::create($input);

        $content = DB::table('organizations')->where('id', Auth::user()->org_id)->value('name') . "مرحبا بعضويتك فى ";
        $from = DB::table('organizations')->where('id', Auth::user()->org_id)->value('email');
        $subject = "مرحبا بك";
        \Mail::send('vendor.emails.welcome', ['email' => $email, 'password' => $password, 'url' => url('/')], function ($message) use ($from, $subject, $email) {
            $message->from($from);
            $message->to($email)->subject($subject);
        });

        //set session message
        Session::flash('customer_created', __('strings.message_success'));

        //redirect back to customers.index
        return redirect('admin/customers');
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
        if (permissions('customers_edit') == 0) {
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $countries = Countries::all();

        $customer = Customers::findOrFail($id);
        return view('customers.edit', compact('customer','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomersUpdateRequest $request, $id)
    {   
        
     
        
         $input = $request->all();
     
        //check if image is selected
        if ($image = $request->file('photo_id')) {
            //give a name to image and move it to public directory
            $image_name = time() . $image->getClientOriginalName();
            $image->move('images', $image_name);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_name]);

            //save photo_id to user $input
            $input['photo_id'] = $photo->id;

            //find user
            $user = Customers::findOrFail($id);

            //unlink old photo if set
            if ($user->photo != NULL) {
                unlink(public_path() . $user->photo->file);
            }

            //delete data from photos table
            Photo::destroy($user->photo_id);
        }
        
            if ($image1 = $request->file('person_image')) {
            //give a name to image and move it to public directory
            $image_customer = time() . $image1->getClientOriginalName();
            $image1->move('images', $image_customer);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_customer]);

            //save photo_id to user $input
            $input['person_image'] = $photo->id;

            //find user
            $user1 = Customers::findOrFail($id);

            //unlink old photo if set
            if ($user1->person_image != NULL) {
                unlink(public_path() . $user1->photo->file);
            }

            //delete data from photos table
            Photo::destroy($user1->person_image);
        }


        $input['password'] = Customers::findOrFail($id)->password;
        $input['org_id'] = Auth::user()->org_id;

        //update data into customers table
        Customers::findOrFail($id)->update($input);

        //set session message and redirect back customers.index
        Session::flash('customer_updated', __('strings.message_success_updated'));
        return redirect('admin/customers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find specific customer
        $customer = Customers::findOrFail($id);
        
        if ($customer->photo) {
            //unlink image
            unlink(public_path() . $customer->photo->file);
            //delete from photo table
            Photo::destroy($customer->photo_id);
        }
        
        CustomerHead::where(['cust_id' => $id, 'org_id' => Auth::user()->org_id])->delete();
        Transactions::where(['cust_id' => $id, 'org_id' => Auth::user()->org_id])->delete();
        externalReq::where(['cust_id' => $id, 'org_id' => Auth::user()->org_id])->delete();
        externalTrans::where(['cust_id' => $id, 'org_id' => Auth::user()->org_id])->delete();
        CustomerMeasure::where(['cust_id' => $id, 'org_id' => Auth::user()->org_id])->delete();
        
        foreach (CustomerPayment::where(['customer_id' => $id, 'org_id' => Auth::user()->org_id])->get() as $value){
            CustomerPaymentDetail::where('customer_payid', $value->id)->delete();
        }
        
        CustomerPayment::where(['customer_id' => $id, 'org_id' => Auth::user()->org_id])->delete();
        loginHistoryCustomer::where(['cust_id' => $id, 'org_id' => Auth::user()->org_id])->delete();
        PermissionReceivingPayments::where(['customer_id' => $id, 'org_id' => Auth::user()->org_id])->delete();
        Reservation::where(['cust_id' => $id, 'org_id' => Auth::user()->org_id])->delete();
        SewingRequest::where(['cust_id' => $id, 'org_id' => Auth::user()->org_id])->delete();
        
        SystemLogs::create(['screen_name' => \Request::route()->getName(), 'action' => 'delete', 'description' => 'Customer '. app()->getLocale() == 'ar' ? $customer->name : $customer->name_en.' has deleted by user ' . app()->getLocale() == 'ar' ? Auth::user()->name : Auth::user()->name_en, 'table_name' => 'customers', 'record_id' => $id, 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
        
        //delete customer
        Customers::destroy($id);
        
        //set session message and redirect back to customers.index
        Session::flash('customer_deleted', __('strings.customers__msg_3'));
        return redirect('admin/customers');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getPrint($id)
    {

        $customer = Customers::findOrFail($id);
        return view('print', compact('customer'));

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function search($type, Request $request)
    {

        return json_encode(Customers::Where('name', 'like', '%' . $request->name . '%')->get());
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getPassword($id)
    {
        return view('customers.change_password', compact('id'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function GetSearch(Request $request)
    {

        $customers = Customers::where(['org_id' => Auth::user()->org_id]);

        if (!empty($request->search_name) && $request->search_name != '0') {
            $customers = $customers->where(['id' => $request->search_name]);
        } else {
            $customers = $customers;
        }

        if (!empty($request->search_phone) && $request->search_phone != '0') {
            $customers = $customers->where(['id' => $request->search_phone]);
        } else {
            $customers = $customers;
        }

        if (!empty($request->search_email) && $request->search_email != '0') {
            $customers = $customers->where(['id' => $request->search_email]);
        } else {
            $customers = $customers;
        }

        if (!empty($request->search_code) && $request->search_code != '0') {
            $customers = $customers->where(['id' => $request->search_code]);
        } else {
            $customers = $customers;
        }

        $customers = $customers->paginate(20);

      /** return view('customers.search', compact('customers'));
       *  Mohamed 17/10
       * */
       
       return view('customers.index', compact('customers'));
      
    }


    public function change_password(CustomersPasswordRequest $request)
    {

        $input['password'] = bcrypt($request->password);

        //update data into customers table
        Customers::findOrFail($request->id)->update($input);


        //set session message and redirect back to customers.index
        Session::flash('customer_deleted', __('strings.users_msg_4'));
        return redirect('admin/customers');
    }


}

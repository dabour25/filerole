<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Category;
use App\CustomerHead;
use App\Customers;
use App\Reservation;
use App\Invoice;
use App\CategoriesType;
use App\Offers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Charts\MontlyViews;
use App\Charts\reportchart;
 use Redirect;
 use App\externalReq;
 use App\externalTrans;


class CustomerHomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing dashboard views to
    | admin and customer.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware(['customer']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
     {
         if (session('locale')) {
             \App::setLocale(session('locale'));
         }
         //if Auth user role is customer
         if (Auth::guard('customers')->check()) {
             //find all orders
             $orders = CustomerHead::where(['cust_id' => Auth::guard('customers')->user()->id, 'org_id' => Auth::guard('customers')->user()->org_id])->with('customer',
'transactions')->whereNotNull('cust_id')->paginate(20);
             $extranal_orders=externalReq::where(['cust_id' => Auth::guard('customers')->user()->id, 'org_id' => Auth::guard('customers')->user()->org_id])->orderBy('invoice_date',desc)->paginate(20);
             foreach ($extranal_orders as $extranal_order) { $extranal_order->trans=externalTrans::where(['cust_id' => Auth::guard('customers')->user()->id, 'org_id' => Auth::guard('customers')->user()->org_id,'external_req_id'=>
$extranal_order->id])->paginate(20);
                $extranal_order->total=0;
                foreach($extranal_order->trans as $extranal_order->tran){
                  $extranal_order->total+= $extranal_order->tran->quantity * $extranal_order->tran->final_price;
                }

             }

             foreach ($orders as $value) {
                 foreach ($value->transactions as $key => $v) {
                     $v->price = $v->price * $v->quantity * $v->req_flag;
                 }
             }
             //return view('dashboard.customer', compact('orders'));

             //Mostafa Reservations
            
           return view('dashboard.customer')->with('orders',$orders)->with('extranal_orders',$extranal_orders);

         }else{
             return redirect('admin/dashboard');
         }
     }


    public function reservations()
    {
        $reservationInstance = new Reservation;
        $reservations = $reservationInstance->getReservationTable();

        return view('dashboard.reservations', compact('reservations'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function Print(Request $request, $id)
    {
        if (session('locale')) {
            \App::setLocale(session('locale'));
        }

        $list = CustomerHead::where(['id' => $id, 'org_id' => Auth::guard('customers')->user()->org_id])->with('customer', 'transactions')->whereNotNull('cust_id')->get();

        foreach ($list as $value) {
            foreach ($value->transactions as $key => $v) {
                $v->price = $v->price * $v->quantity * $v->req_flag;
                $v->tax_val = $v->tax_val * $v->quantity;
                $v->cat_type = CategoriesType::findOrFail(Category::findOrFail($v->cat_id)->category_type_id)->type;
            }

        }
        return view('transactions.print', compact('list'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function Charts(Request $request)
    {
        $chart = new MontlyViews;
        $chart->labels(['One', 'Two', 'Three', 'Four']);
        $chart->dataset('My dataset', 'bar', [1, 2, 3, 4]);
        $chart->dataset('My dataset 2', 'bar', [4, 3, 2, 1]);

        return view('welcome', compact('chart'));
    }
    public function customerProfile($id){
     $customer=Customers::findOrFail($id);
     return view('dashboard.customerprofile',compact('customer'));
   }
   public function customerProfileUpdata( Request $request){
       $input = $request->all();
       $id= $request->id;
       Customers::findOrFail($id)->update($input);
       $final_url= url('/') ;
       return Redirect::to($final_url);
   }
    
    
}

<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Category;
use App\CategoryNum;
use App\CustomerHead;
use App\Customers;
use App\Reservation;
use App\Invoice;
use App\CategoriesType;
use App\Offers;
use Carbon\Carbon;
use App\User;
use App\Functions;
use App\functions_role;
use App\Role;
use App\Property;
use App\Locations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Charts\MontlyViews;
use App\Charts\reportchart;
use App\Charts\PropertyChart;
use App\FunctionsUser;

class HomeController extends Controller
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
          $this->middleware(['admin', 'auth']);

     }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (permissions('dashboard_view') == 0 ) {
            //set session message
            
            return view('dashboard.permission');
        }
        if (session('locale')) {
            \App::setLocale(session('locale'));
        }

        //find all customers
        $customers = Customers::where(['active' => 1, 'org_id' => Auth::user()->org_id])->get();
        //find all orders
        $orders = CustomerHead::where(['org_id' => Auth::user()->org_id])->get();

        //items
        $items = Category::where(['active' => 1, 'org_id' => Auth::user()->org_id])->get();

        $offers = Offers::where(['org_id' => Auth::user()->org_id, 'active' => 1])->where('date_from', '<=', date('Y-m-d'))->where('date_to', '>=', date('Y-m-d'))->count();
        $users = User::where(['org_id' => Auth::user()->org_id, 'is_active' => 1])->count();
        $invoices = CustomerHead::where(['org_id' => Auth::user()->org_id])->whereNotNull('invoice_no')->count();
        // start charts
        /* $requests = [];
        $payments = [];
        $remainder = [];
        $name = []; */
        
        if ($request->chart == 'pie') {

          if (!empty($request->report_date_from) && !empty($request->report_date_to)) {
              foreach (DB::select('select  sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id and `org_id` = ' . Auth::user()->org_id . ') requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id and `org_id` = ' . Auth::user()->org_id . ') payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = ' . Auth::user()->org_id . ' AND c.active=1 AND c.id = R.cust_id  AND R.date >=  "' . $request->report_date_from . '" AND   R.date <=  "' . $request->report_date_to . '"   order by R.cust_id,R.id) As main ') as $v) {
                  $requests = abs(round($v->requests, 2)) == '' ? 0 : abs(round($v->requests, 2));
                  $payments = abs(round($v->payments, 2)) == '' ? 0 : abs(round($v->payments, 2));
                  $remainder = round(abs(round($v->requests, 2)) - abs(round($v->payments, 2)), 2);
              }
          } else {
              $pre_year = date('Y-m-d', strtotime('-1 year'));
              foreach (DB::select('select  sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id and `org_id` = ' . Auth::user()->org_id . ') requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id and `org_id` = ' . Auth::user()->org_id . ') payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = ' . Auth::user()->org_id . ' AND c.active=1 AND c.id = R.cust_id  and R.date<=CURRENT_DATE  and R.date>="' . $pre_year . '"  order by R.cust_id,R.id) As main ') as $v) {
                  $requests = abs(round($v->requests, 2)) == '' ? 0 : abs(round($v->requests, 2));
                  $payments = abs(round($v->payments, 2)) == '' ? 0 : abs(round($v->payments, 2));
                  $remainder = round(abs(round($v->requests, 2)) - abs(round($v->payments, 2)), 2);
              }

          }
          $chart = new reportchart;
          if (app()->getLocale() == 'ar') {
              $name = ['الاجمالى ', 'المدفوع', 'المتبقى'];
              $chart->title('الرسم البيانى لطلبات العملاء');
          } else {
              $name = ['Total ', 'Paid', 'Remaining'];
              $chart->title('Graphic Drawing for customers Request');
          }


          $chart->labels($name);
          $pre_year = date('Y-m-d', strtotime('-1 year'));
          //pie chart
          $chart->dataset('My dataset', 'pie', [$requests, $payments, $remainder]);




        } else {
            $requests1 = [];
            $payments1 = [];
            $remainder1 = [];
            $name_bar = [];
            
            if (!empty($request->report_date_from) && !empty($request->report_date_to)) {
                foreach (DB::select('select  sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id and `org_id` = ' . Auth::user()->org_id . ') requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id and `org_id` = ' . Auth::user()->org_id . ' ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = ' . Auth::user()->org_id . ' AND c.active=1 AND c.id = R.cust_id  AND R.date >=  "' . $request->report_date_from . '" AND   R.date <=  "' . $request->report_date_to . '"   order by R.cust_id,R.id) As main ') as $v) {
                    $requests1[] = abs(round($v->requests)) == '' ? 0 : abs(round($v->requests));
                    $payments1[] = abs(round($v->payments)) == '' ? 0 : abs(round($v->payments));
                    $remainder1[] = round(abs(round($v->requests)) - abs(round($v->payments)));

                }

            } else {
                $pre_year = date('Y-m-d', strtotime('-1 year'));
                foreach (DB::select('select  sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id and `org_id` = ' . Auth::user()->org_id . ') requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id and `org_id` = ' . Auth::user()->org_id . ' ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = ' . Auth::user()->org_id . ' AND c.active=1 AND c.id = R.cust_id  and R.date<=CURRENT_DATE  and R.date>="' . $pre_year . '"  order by R.cust_id,R.id) As main ') as $v) {
                    $requests1[] = abs(round($v->requests)) == '' ? 0 : abs(round($v->requests));
                    $payments1[] = abs(round($v->payments)) == '' ? 0 : abs(round($v->payments));
                    $remainder1[] = round(abs(round($v->requests)) - abs(round($v->payments)));

                }

            }
            
            $chart = new reportchart;
            if (app()->getLocale() == 'ar') {
                $name_bar = ['اجمالى طلبات العملاء'];
                $chart->title('الرسم البيانى لطلبات العملاء');
            } else {
                $name_bar = ['Total Customers Requests'];
                $chart->title('Graphic Drawing for customers Request');
            }

            $chart->labels($name_bar);
            //bar chart
            $pre_year = date('Y-m-d', strtotime('-1 year'));
            
            //return $remainder1 .'  - '.$payments1. ' - '.$remainder1;
            
            $chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى' : 'Total', 'bar', $requests1)->color('#e6270c');
            $chart->dataset(app()->getLocale() == 'ar' ? 'المدفوع' : 'Paid', 'bar', $payments1)->color('#1dad1f');
            $chart->dataset(app()->getLocale() == 'ar' ? 'الباقى' : 'Remaining', 'bar', $remainder1)->color('#04c');
        }

        //end chart

        //get  user functions
        $user = Auth::user();
        $role_id = $user->role_id;
        $user_id=$user->id;
        
        /*$funcs = functions_role::where('funcparent_id', '0')->where('role_id', $role_id)->where('org_id', Auth::user()->org_id)->orderBy('porder')->get();

        $sub_funcs = functions_role::where('funcparent_id', '>', '0')->where('role_id', $role_id)->where('org_id', Auth::user()->org_id)->orderBy('porder')->get();
        $func_links = DB::table('function_new')->orderBy('porder')->get();*/


        //return view('dashboard.admin', compact('chart', 'funcs','sub_funcs','func_links'));



        if(!empty($request->date)){
            $date = $request->date;
        }else{
            $date = date('Y-m-d');
        }
$available =[]; $count =[]; $reserved =[];
        foreach ($properties = Property::where(['org_id' => Auth::user()->org_id])->get() as $v){
            
            $labels[] = app()->getLocale() == 'ar' ? $v->name .' - '.Locations::where(['id' => $v->location_id])->value('name'): $v->name_en .' - '.Locations::where(['id' => $v->location_id])->value('name_en');
            
            if(!empty(AvailableRooms($v->id, $date)['reserved']) && !empty(AvailableRooms($v->id, $date)['available'])){
                $count[] = round(AvailableRooms($v->id, $date)['reserved'] / AvailableRooms($v->id, $date)['available'] * 100);
                $v->percentage = round(AvailableRooms($v->id, $date)['reserved'] / AvailableRooms($v->id, $date)['available'] * 100);
                $reserved[] = AvailableRooms($v->id, $date)['reserved'];
                $available[] = AvailableRooms($v->id, $date)['available'];
            }else{
                $count[] = 0;
                $reserved[] = empty(AvailableRooms($v->id, $date)['reserved']) ? 0 : AvailableRooms($v->id, $date)['reserved'];
                $available[] = empty(AvailableRooms($v->id, $date)['available']) ? 0 : AvailableRooms($v->id, $date)['available'];
                $v->percentage = 0;
            }
        }
        
        $properties_chart = new PropertyChart();
        $properties_chart->labels($labels);
        $properties_chart->dataset(__('strings.usage_present'), 'bar', $count)->color('yellow');
        $properties_chart->dataset(__('strings.usage_reserved'), 'bar', $reserved)->color('red');
        $properties_chart->dataset(__('strings.usage_available'), 'bar', $available)->color('green');

        return view('dashboard.admin', compact('customers','properties_chart', 'properties', 'orders', 'items', 'offers', 'pre_year', 'chart', 'users', 'invoices'));


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
    
    public function PropertyRooms($id){
        
        foreach(Category::where([ 'org_id' => Auth::user()->org_id, 'property_id' => $id  ])->get() as $value){
            $ids[] = $value->id;
        }
        
        $buildings = CategoryNum::whereIn('cat_id', $ids)->groupBy('building')->get();
        $rooms = CategoryNum::whereIn('cat_id', $ids)->get();
        return view('dashboard.rooms', compact('rooms', 'buildings', 'id'));
    }
    public function PropertyStatistics($id){

        return view('dashboard.statistics', compact( 'id'));
    }
}

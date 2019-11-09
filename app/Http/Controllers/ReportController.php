<?php

namespace App\Http\Controllers;

use App\Banking;
use App\CategoriesType;
use App\Category;
use App\Customers;
use App\Functions;
use App\Offers;
use App\PermissionReceivingPayments;
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
use\App\externalReq;
use\App\externalTrans;
use App\Charts\reportchart;
use Carbon\Carbon;

class ReportController extends Controller
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

   public function index(){

	      $requests = [];
		  $payments = [];
		  $remainder = [];
		  $name=[];
 $date = Carbon::now()->format('Y-m-d');
$interal_head=DB::select('select main.cust_id, main.name,main.name_en, sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.' AND c.active=1 AND c.id = R.cust_id  and R.date=CURRENT_DATE order by R.cust_id,R.id) As main group by main.cust_id, main.name');

$customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
foreach ($customers as $customer) {
 $customer->deliver_fees=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereDate('request_dt',date(Y-m-d))->sum('delivery_fees');
 $customer->extra_head=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereNotIn('confirm', ['c'])->whereDate('request_dt',date(Y-m-d))->get();
 $total_paid=0;
 $total_request=0;
 foreach ( $customer->extra_head as  $value) {
   $customer->test=0;
  $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();

   foreach ($reuest_details  as  $reuest_detail) {
    $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
     if($value->confirm =='d' || $value->confirm =='x' || $value->confirm =='yx' ){
       $total_paid +=$reuest_detail->final_price * $reuest_detail->quantity* $reuest_detail->reg_flag;
     }
   }

 }
  $customer->test=1;
  $customer->total=Decimalpoint($total_request);
  $customer->paid=Decimalpoint($total_paid);
}
  
$requests = [];
$payments = [];
$remainder = [];
$name=[];
if(!empty($getsearch) && !empty($customers)){

 foreach($customers as $value1){
      
      
    $all_total= abs(customer_requests($value1->id)['all_requests']);
    $all_pay=  abs(customer_requests($value1->id)['all_pay']); 
    
    if($all_total){
        
      if(app()->getLocale() == 'ar'){
     $name[] = $value1->name;
   }else{ $name[] = $value1->name_en;}  
        
    $requests[] = abs(Decimalpoint($all_total)) == '' ? 0: abs(Decimalpoint($all_total));
    $payments[] = abs(Decimalpoint($all_pay)) == '' ? 0: abs(Decimalpoint($all_pay));
    $remainder[] = Decimalpoint(abs($all_total)- abs($all_pay));    
        
    }
  


}


}elseif(empty($getsearch)){
foreach($customers as $value ){

if(app()->getLocale() == 'ar'){
 $name[] =$value->name;
}else{ $name[] = $value->name_en;}

$all_total=$value->total;
$all_pay=$value->paid ;
$requests[] = abs(Decimalpoint($all_total)) == '' ? 0: abs(Decimalpoint($all_total));
$payments[] = abs(Decimalpoint($all_pay)) == '' ? 0: abs(Decimalpoint($all_pay));
$remainder[] = Decimalpoint(abs(($all_total))- abs(($all_pay)));
}

}elseif(empty($customers)){
foreach($getsearch as $result){
if(app()->getLocale() == 'ar'){
$name[] = $result->name;
}else{ $name[] = $result->name_en;}

 $all_total=abs($result->requests);
 $all_pay=abs($result->payments);
 $requests[] = abs(Decimalpoint($all_total)) == '' ? 0: abs(Decimalpoint($all_total));
 $payments[] = abs(Decimalpoint($all_pay)) == '' ? 0: abs(Decimalpoint($all_pay));
 $remainder[] = Decimalpoint(abs(($all_total))- abs(($all_pay)));
}
}


$report=$getsearch;
$chart = new reportchart;

  $chart->title('My nice chart');
  $chart->labels($name);

  $chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى': 'Total', 'bar', $requests)->color('#e6270c');
  $chart->dataset(app()->getLocale() == 'ar' ? 'المدفوع': 'Paid', 'bar', $payments)->color('#1dad1f');
  $chart->dataset(app()->getLocale() == 'ar' ? 'المتبقى': 'Remaining', 'bar', $remainder)->color('#04c');


        return view('reports.index',compact('chart','report','customers'));
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

 }
    public function index_user(){

	    $requests = [];
		  $payments = [];
		  $remainder = [];
		  $name=[];
		foreach(DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1 and cast(R.invoice_date as date) = CURRENT_DATE   order by R.invoice_user,R.id) As main group by main.invoice_user, main.name')
 as $v){
			if(app()->getLocale() == 'ar'){
			 $name[] = $v->name;
		    }else{ $name[] = $v->name_en;}
			$requests[] = abs(Decimalpoint($v->requests)) == '' ? 0: abs(Decimalpoint($v->requests));
			$payments[] = abs(Decimalpoint($v->payments)) == '' ? 0: abs(Decimalpoint($v->payments));
		    $remainder[] = Decimalpoint(abs(($v->requests))- abs(($v->payments)));
		}
	$report=DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1 and cast(R.invoice_date as date)=CURRENT_DATE  order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');
	  $chart = new reportchart;

				$chart->title('My nice chart');
				$chart->labels($name);

		    $chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى': 'Total', 'bar', $requests)->color('#e6270c');
        $chart->dataset(app()->getLocale() == 'ar' ? 'المدفوع': 'Paid', 'bar', $payments)->color('#1dad1f');
        $chart->dataset(app()->getLocale() == 'ar' ? 'المتبقى': 'Remaining', 'bar', $remainder)->color('#04c');
        return view('reports.reportuser',compact('chart','report'));
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   }
    public function search_user(Request $request){


	if(empty($request->report_date_from) && empty($request->report_date_to)){
		if($request->search_name){
 $getsearch = DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1 and cast(R.invoice_date as date)=CURRENT_DATE and s.id='.$request->search_name.' order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');

		}else{

 $getsearch = DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1 and cast(R.invoice_date as date)=CURRENT_DATE  order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');
		}
       }else{

		if (!empty($request->report_date_from) && !empty($request->report_date_to)){
		if($request->search_name){
	 $getsearch = DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1  AND cast(R.invoice_date as date) >=  "'.$request->report_date_from.'" AND cast(R.invoice_date as date) <= "'.$request->report_date_to.'"    and s.id='.$request->search_name.' order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');

		}
		else{
	 $getsearch = DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1  AND cast(R.invoice_date as date) >=  "'.$request->report_date_from.'" AND cast(R.invoice_date as date) <= "'.$request->report_date_to.'"   order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');
		}
	}
   if (!empty($request->report_date_from) && empty($request->report_date_to)) {
		if($request->search_name){
	 $getsearch = DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1  AND cast(R.invoice_date as date) >=  "'.$request->report_date_from.'"  and s.id='.$request->search_name.' order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');

		}
		else{
	 $getsearch = DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1  AND cast(R.invoice_date as date) >=  "'.$request->report_date_from.'"   order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');
		 }
		   }
		  if (empty($request->report_date_from) && !empty($request->report_date_to)) {
		if($request->search_name){
	 $getsearch = DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1   AND  cast(R.invoice_date as date) <= "'.$request->report_date_to.'"    and s.id='.$request->search_name.' order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');

		}
		else{
	 $getsearch = DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1   AND  cast(R.invoice_date as date) <= "'.$request->report_date_to.'"    order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');

		}
		   }

        }

		  $requests = [];
		  $payments = [];
		  $remainder = [];
		  $name=[];
		   foreach($getsearch as $result){

			if(app()->getLocale() == 'ar'){
			 $name[] = $result->name;
		    }else{ $name[] = $result->name_en;}

			$requests[] = abs(Decimalpoint($result->requests)) == '' ? 0: abs(Decimalpoint($result->requests));
			$payments[] = abs(Decimalpoint($result->payments)) == '' ? 0: abs(Decimalpoint($result->payments));
		  $remainder[] = Decimalpoint(abs(($result->requests))- abs(($result->payments)));
		}
	  $report=$getsearch;
	  $chart = new reportchart;

				$chart->title('My nice chart');
				$chart->labels($name);

				$chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى': 'Total', 'bar', $requests)->color('#e6270c');
        $chart->dataset(app()->getLocale() == 'ar' ? 'المدفوع': 'Paid', 'bar', $payments)->color('#1dad1f');
        $chart->dataset(app()->getLocale() == 'ar' ? 'المتبقى': 'Remaining', 'bar', $remainder)->color('#04c');

        return view('reports.reportuser',compact('chart','report'));
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   }

  public function search_report(Request $request){

	if(empty($request->report_date_from) && empty($request->report_date_to)){
		if($request->search_name){
  $getsearch = DB::select('select main.cust_id, main.name,main.name_en, sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.' AND c.active=1 AND R.cust_id = '.$request->search_name.' and R.date=CURRENT_DATE  AND c.id = R.cust_id   order by R.cust_id,R.id) As main group by main.cust_id, main.name');
  $customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
  foreach ($customers as $customer) {
   $customer->deliver_fees=externalReq::where(['cust_id'=>$request->search_name,'org_id'=> Auth::User()->org_id])->sum('delivery_fees');
   $customer->extra_head=externalReq::where(['cust_id'=>$request->search_name,'org_id'=> Auth::User()->org_id])->whereIn('confirm', ['n','y'])->get();
   $customer->extra_head_paid=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereIn('confirm', ['d','yx','x'])->get();
    $customer->test=1;
   $total_paid=0;
   $total_request=0;
   foreach ( $customer->extra_head as  $value) {
    
    $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
     foreach ($reuest_details  as  $reuest_detail) {
      $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
      
     }
      $customer->total=Decimalpoint($total_request);

   }
    foreach (  $customer->extra_head_paid as $value2 ){
     $reuest_details_paid=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value2->id])->get(); 
     foreach ($reuest_details_paid  as  $reuest_details_paid1) {
     $total_paid +=$reuest_details_paid1->final_price * $reuest_details_paid1->quantity* $reuest_details_paid1->reg_flag;    
     }
     
     }
     
    $customer->paid=Decimalpoint($total_paid); 
  }

    }else{
        
	$getsearch = DB::select('select main.cust_id, main.name,main.name_en, sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.' AND c.active=1 AND c.id = R.cust_id and R.date=CURRENT_DATE  order by R.cust_id,R.id) As main group by main.cust_id, main.name');
    $customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
    foreach ($customers as $customer) {
     $customer->deliver_fees=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->sum('delivery_fees');
     $customer->extra_head=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereIn('confirm', ['n','y'])->get();
     $customer->extra_head_paid=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereIn('confirm', ['d','yx','x'])->get();
     $customer->test=1;
     $total_paid=0;
     $total_request=0;
     foreach ( $customer->extra_head as  $value) {
       $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
       foreach ($reuest_details  as  $reuest_detail) {
        $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
       }
         $customer->total=Decimalpoint($total_request);

     }
      foreach (  $customer->extra_head_paid as $value2 ){
     $reuest_details_paid=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value2->id])->get(); 
     foreach ($reuest_details_paid  as  $reuest_details_paid1) {
     $total_paid +=$reuest_details_paid1->final_price * $reuest_details_paid1->quantity* $reuest_details_paid1->reg_flag;    
     }
     
     }
     
     $customer->paid=Decimalpoint($total_paid); 
    
     
    }

    }
    
   
       }else{

		if (!empty($request->report_date_from) && !empty($request->report_date_to)){
		if($request->search_name){
$getsearch =DB::select('select main.cust_id, main.name,main.name_en, sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.' AND c.active=1 AND R.date >=  "'.$request->report_date_from.'" AND   R.date <=  "'.$request->report_date_to.'" AND R.cust_id ='.$request->search_name.' AND c.id = R.cust_id   order by R.cust_id,R.id) As main group by main.cust_id, main.name');

$customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
foreach ($customers as $customer) {
 $customer->deliver_fees=externalReq::where(['cust_id'=>$request->search_name,'org_id'=> Auth::User()->org_id])->whereBetween('request_dt', [$request->report_date_from, $request->report_date_to])->sum('delivery_fees');
 $customer->extra_head=externalReq::where(['cust_id'=>$request->search_name,'org_id'=> Auth::User()->org_id])->whereBetween('request_dt', [$request->report_date_from, $request->report_date_to])->whereIn('confirm', ['n','y'])->get();
 $customer->extra_head_paid=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereBetween('request_dt', [$request->report_date_from, $request->report_date_to])->whereIn('confirm', ['d','yx','x'])->get();
 $total_paid=0;
 $total_request=0;
 $customer->test=1;
 foreach ( $customer->extra_head as  $value) {
   
  $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
  foreach ($reuest_details  as  $reuest_detail) {
      $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
       
     }
    $customer->total=Decimalpoint($total_request);
        foreach (  $customer->extra_head_paid as $value2 ){
     $reuest_details_paid=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value2->id])->get(); 
     foreach ($reuest_details_paid  as  $reuest_details_paid1) {
     $total_paid +=$reuest_details_paid1->final_price * $reuest_details_paid1->quantity* $reuest_details_paid1->reg_flag;    
     }
         
     }
     $customer->paid=Decimalpoint($total_paid);
 
 }
  
}

    }
		else{
  $getsearch =DB::select('select main.cust_id, main.name,main.name_en, sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.'  AND c.active=1 AND R.date >=  "'.$request->report_date_from.'" AND  R.date <= "'.$request->report_date_to.'" AND c.id = R.cust_id   order by R.cust_id,R.id) As main group by main.cust_id, main.name');
  $customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
  foreach ($customers as $customer) {
     $total_paid=0;
     $total_request=0;  
    $customer->deliver_fees=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereBetween('request_dt', [$request->report_date_from, $request->report_date_to])->sum('delivery_fees');
    $customer->extra_head=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereBetween('request_dt', [$request->report_date_from, $request->report_date_to])->whereIn('confirm', ['n','y'])->get();
    $customer->extra_head_paid=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereBetween('request_dt', [$request->report_date_from, $request->report_date_to])->whereIn('confirm', ['d','yx','x'])->get();
   $customer->test=1;
   foreach ( $customer->extra_head as  $value) {
    $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
     foreach ($reuest_details  as  $reuest_detail) {
      $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
       
     }
     $customer->total=Decimalpoint($total_request);
     foreach (  $customer->extra_head_paid as $value2 ){
     $reuest_details_paid=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value2->id])->get(); 
     foreach ($reuest_details_paid  as  $reuest_details_paid1) {
     $total_paid +=$reuest_details_paid1->final_price * $reuest_details_paid1->quantity* $reuest_details_paid1->reg_flag;    
     }
         
     }
     $customer->paid=Decimalpoint($total_paid);
 
   }
   
    
    
  }



      }
	}
	  
		if (!empty($request->report_date_from) && empty($request->report_date_to)) {
		if($request->search_name){
		$getsearch =DB::select('select main.cust_id, main.name,main.name_en, sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.' AND c.active=1 AND R.date >= "'.$request->report_date_from.'"AND R.cust_id ='.$request->search_name.'  AND c.id = R.cust_id   order by R.cust_id,R.id) As main group by main.cust_id, main.name');
    $customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
    foreach ($customers as $customer) {
     $customer->deliver_fees=externalReq::where(['cust_id'=>$request->search_name,'org_id'=> Auth::User()->org_id])->whereDate('request_dt','>=',$request->report_date_from )->sum('delivery_fees');
     $customer->extra_head=externalReq::where(['cust_id'=>$request->search_name,'org_id'=> Auth::User()->org_id])->whereDate('request_dt','>=',$request->report_date_from)->whereNotIn('confirm', ['c'])->get();
     $total_paid=0;
     $total_request=0;
     foreach ( $customer->extra_head as  $value) {
       $customer->test=0;
      $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
       foreach ($reuest_details  as  $reuest_detail) {
        $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
         if($value->confirm =='d' || $value->confirm =='x' || $value->confirm =='yx' ){
           $total_paid +=$reuest_detail->final_price * $reuest_detail->quantity* $reuest_detail->reg_flag;
         }
       }

     }
      $customer->test=1;
      $customer->total=Decimalpoint($total_request);
      $customer->paid=Decimalpoint($total_paid);
    }



		}
		else{
	$getsearch =DB::select('select main.cust_id, main.name,main.name_en, sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.' AND c.active=1 AND R.date >= "'.$request->report_date_from.'"  AND c.id = R.cust_id   order by R.cust_id,R.id) As main group by main.cust_id, main.name');

  $customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
  foreach ($customers as $customer) {
   $customer->deliver_fees=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereDate('request_dt','>=',$request->report_date_from )->sum('delivery_fees');
   $customer->extra_head=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereDate('request_dt','>=',$request->report_date_from)->whereNotIn('confirm', ['c'])->get();
   $total_paid=0;
   $total_request=0;
   foreach ( $customer->extra_head as  $value) {
     $customer->test=0;
    $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
     foreach ($reuest_details  as  $reuest_detail) {
      $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
       if($value->confirm =='d' || $value->confirm =='x' || $value->confirm =='yx' ){
         $total_paid +=$reuest_detail->final_price * $reuest_detail->quantity* $reuest_detail->reg_flag;
       }
     }

   }
    $customer->total=Decimalpoint($total_request);
    $customer->paid=Decimalpoint($total_paid);
    $customer->test=1;
  }

     }
		   }
		  if (empty($request->report_date_from) && !empty($request->report_date_to)) {
		if($request->search_name){
	$getsearch =DB::select('select main.cust_id, main.name,main.name_en sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.' AND c.active=1 AND R.date <= "'.$request->report_date_to.'"  AND R.cust_id ='.$request->search_name.' AND c.id = R.cust_id   order by R.cust_id,R.id) As main group by main.cust_id, main.name');

  $customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
  foreach ($customers as $customer) {
   $customer->deliver_fees=externalReq::where(['cust_id'=>$request->search_name,'org_id'=> Auth::User()->org_id])->whereDate('request_dt','<=',$request->report_date_to )->sum('delivery_fees');
   $customer->extra_head=externalReq::where(['cust_id'=>$request->search_name,'org_id'=> Auth::User()->org_id])->whereDate('request_dt','<=',$request->report_date_to)->whereNotIn('confirm', ['c'])->get();
  
   $total_paid=0;
   $total_request=0;
   foreach ( $customer->extra_head as  $value) {
     $customer->test=0;
    $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
     foreach ($reuest_details  as  $reuest_detail) {
      $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
       if($value->confirm =='d' || $value->confirm =='x' || $value->confirm =='yx' ){
         $total_paid +=$reuest_detail->final_price * $reuest_detail->quantity* $reuest_detail->reg_flag;
       }
     }

   }
    $customer->total=Decimalpoint($total_request);
    $customer->paid=Decimalpoint($total_paid);
    $customer->test=1;
  }



  }
  else{
  $getsearch = DB::select('select main.cust_id, main.name,main.name_en, sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.'  AND c.active=1 AND R.date <= "'.$request->report_date_to.'"  AND c.id = R.cust_id   order by R.cust_id,R.id) As main group by main.cust_id, main.name');
  $customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
  foreach ($customers as $customer) {
   $customer->deliver_fees=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereDate('request_dt','<=',$request->report_date_to )->sum('delivery_fees');
   $customer->extra_head=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereDate('request_dt','<=',$request->report_date_to)->whereNotIn('confirm', ['c'])->get();
   $total_paid=0;
   $total_request=0;
   foreach ( $customer->extra_head as  $value) {
     $customer->test=0;
    $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
     foreach ($reuest_details  as  $reuest_detail) {
      $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
       if($value->confirm =='d' || $value->confirm =='x' || $value->confirm =='yx' ){
         $total_request +=$reuest_detail->final_price * $reuest_detail->quantity* $reuest_detail->reg_flag;
       }
     }

   }
    $customer->total=Decimalpoint($total_request);
    $customer->paid=Decimalpoint($total_paid);
    $customer->test=1;
  }
  	}

		}
		
		   }


		  $requests = [];
		  $payments = [];
		  $remainder = [];
		  $name=[];
		  
		  
		  
if(!empty($getsearch) && !empty($customers)){
  foreach($customers as $value1){
    $all_total= abs(customer_requests($value1->id,$request->report_date_from,$request->report_date_to)['all_requests']);
    $all_pay=  abs(customer_requests($value1->id,$request->report_date_from,$request->report_date_to)['all_pay']); 
    
    if($all_total){
        
      if(app()->getLocale() == 'ar'){
     $name[] = $value1->name;
   }else{ $name[] = $value1->name_en;}  
        
     $requests[] = abs(Decimalpoint($all_total)) == '' ? 0: abs(Decimalpoint($all_total));
    $payments[] = abs(Decimalpoint($all_pay)) == '' ? 0: abs(Decimalpoint($all_pay));
    $remainder[] = Decimalpoint(abs($all_total)- abs($all_pay));    
        
    }
  


}


 
}elseif(empty($getsearch)){
   foreach($customers as $value ){
      
       $all_total=$value->total;
      $all_pay=$value->paid ;
      if($all_total){
          
        if(app()->getLocale() == 'ar'){
       $name[] =$value->name;
     }else{ $name[] = $value->name_en;}

     
      $requests[] = abs(Decimalpoint($all_total)) == '' ? 0: abs(Decimalpoint($all_total));
      $payments[] = abs(Decimalpoint($all_pay)) == '' ? 0: abs(Decimalpoint($all_pay));
      $remainder[] = Decimalpoint(abs(($all_total))- abs(($all_pay)));   
          
      }
    
    }

}elseif(empty($customers)){
 foreach($getsearch as $result){
  if(app()->getLocale() == 'ar'){
    $name[] = $result->name;
     }else{ $name[] = $result->name_en;}

       $all_total=abs($result->requests);
       $all_pay=abs($result->payments);
       $requests[] = abs(Decimalpoint($all_total)) == '' ? 0: abs(Decimalpoint($all_total));
       $payments[] = abs(Decimalpoint($all_pay)) == '' ? 0: abs(Decimalpoint($all_pay));
       $remainder[] = Decimalpoint(abs(($all_total))- abs(($all_pay)));
  }
}


	   $report=$getsearch;
	   $chart = new reportchart;

				$chart->title('My nice chart');
				$chart->labels($name);

		$chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى': 'Total', 'bar', $requests)->color('#e6270c');
        $chart->dataset(app()->getLocale() == 'ar' ? 'المدفوع': 'Paid', 'bar', $payments)->color('#1dad1f');
        $chart->dataset(app()->getLocale() == 'ar' ? 'المتبقى': 'Remaining', 'bar', $remainder)->color('#04c');
         return view('reports.index',compact('chart','report','customers'));
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   }
    public function searchWithDetails(Request $request)
    {
		if(empty($request->report_date_from) && empty($request->report_date_to)){
		if($request->search_name){
  $getsearch = DB::select('select main.cust_id, main.name,main.name_en, sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.' AND c.active=1 AND R.cust_id = '.$request->search_name.' and R.date=CURRENT_DATE  AND c.id = R.cust_id   order by R.cust_id,R.id) As main group by main.cust_id, main.name');
  $customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
  foreach ($customers as $customer) {
   $customer->deliver_fees=externalReq::where(['cust_id'=>$request->search_name,'org_id'=> Auth::User()->org_id])->sum('delivery_fees');
   $customer->extra_head=externalReq::where(['cust_id'=>$request->search_name,'org_id'=> Auth::User()->org_id])->whereIn('confirm', ['n','y'])->get();
   $customer->extra_head_paid=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereIn('confirm', ['d','yx','x'])->get();
    $customer->test=1;
   $total_paid=0;
   $total_request=0;
   foreach ( $customer->extra_head as  $value) {
    
    $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
     foreach ($reuest_details  as  $reuest_detail) {
      $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
      
     }
      $customer->total=Decimalpoint($total_request);

   }
    foreach (  $customer->extra_head_paid as $value2 ){
     $reuest_details_paid=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value2->id])->get(); 
     foreach ($reuest_details_paid  as  $reuest_details_paid1) {
     $total_paid +=$reuest_details_paid1->final_price * $reuest_details_paid1->quantity* $reuest_details_paid1->reg_flag;    
     }
     
     }
     
    $customer->paid=Decimalpoint($total_paid); 
  }

    }else{
	$getsearch = DB::select('select main.cust_id, main.name,main.name_en, sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.' AND c.active=1 AND c.id = R.cust_id and R.date=CURRENT_DATE  order by R.cust_id,R.id) As main group by main.cust_id, main.name');
    $customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
    foreach ($customers as $customer) {
     $customer->deliver_fees=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->sum('delivery_fees');
     $customer->extra_head=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereIn('confirm', ['n','y'])->get();
     $customer->extra_head_paid=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereIn('confirm', ['d','yx','x'])->get();
    $customer->test=1;
     $total_paid=0;
     $total_request=0;
     foreach ( $customer->extra_head as  $value) {
      
      $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
       foreach ($reuest_details  as  $reuest_detail) {
        $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
       }
         $customer->total=Decimalpoint($total_request);

     }
      foreach (  $customer->extra_head_paid as $value2 ){
     $reuest_details_paid=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value2->id])->get(); 
     foreach ($reuest_details_paid  as  $reuest_details_paid1) {
     $total_paid +=$reuest_details_paid1->final_price * $reuest_details_paid1->quantity* $reuest_details_paid1->reg_flag;    
     }
     
     }
     
     $customer->paid=Decimalpoint($total_paid); 
    
     
    }

    }
    
   
       }else{

		if (!empty($request->report_date_from) && !empty($request->report_date_to)){
		if($request->search_name){
$getsearch =DB::select('select main.cust_id, main.name,main.name_en, sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.' AND c.active=1 AND R.date >=  "'.$request->report_date_from.'" AND   R.date <=  "'.$request->report_date_to.'" AND R.cust_id ='.$request->search_name.' AND c.id = R.cust_id   order by R.cust_id,R.id) As main group by main.cust_id, main.name');

$customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
foreach ($customers as $customer) {
 $customer->deliver_fees=externalReq::where(['cust_id'=>$request->search_name,'org_id'=> Auth::User()->org_id])->whereBetween('request_dt', [$request->report_date_from, $request->report_date_to])->sum('delivery_fees');
 $customer->extra_head=externalReq::where(['cust_id'=>$request->search_name,'org_id'=> Auth::User()->org_id])->whereBetween('request_dt', [$request->report_date_from, $request->report_date_to])->whereIn('confirm', ['n','y'])->get();
 $customer->extra_head_paid=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereBetween('request_dt', [$request->report_date_from, $request->report_date_to])->whereIn('confirm', ['d','yx','x'])->get();
 $total_paid=0;
 $total_request=0;
 $customer->test=1;
 foreach ( $customer->extra_head as  $value) {
   
  $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
  foreach ($reuest_details  as  $reuest_detail) {
      $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
       
     }
    $customer->total=Decimalpoint($total_request);
        foreach (  $customer->extra_head_paid as $value2 ){
     $reuest_details_paid=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value2->id])->get(); 
     foreach ($reuest_details_paid  as  $reuest_details_paid1) {
     $total_paid +=$reuest_details_paid1->final_price * $reuest_details_paid1->quantity* $reuest_details_paid1->reg_flag;    
     }
         
     }
     $customer->paid=Decimalpoint($total_paid);
 
 }
  
}

    }
		else{
  $getsearch =DB::select('select main.cust_id, main.name,main.name_en, sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.'  AND c.active=1 AND R.date >=  "'.$request->report_date_from.'" AND  R.date <= "'.$request->report_date_to.'" AND c.id = R.cust_id   order by R.cust_id,R.id) As main group by main.cust_id, main.name');
  $customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
  foreach ($customers as $customer) {
     $total_paid=0;
     $total_request=0;  
    $customer->deliver_fees=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereBetween('request_dt', [$request->report_date_from, $request->report_date_to])->sum('delivery_fees');
    $customer->extra_head=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereBetween('request_dt', [$request->report_date_from, $request->report_date_to])->whereIn('confirm', ['n','y'])->get();
    $customer->extra_head_paid=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereBetween('request_dt', [$request->report_date_from, $request->report_date_to])->whereIn('confirm', ['d','yx','x'])->get();
   $customer->test=1;
   foreach ( $customer->extra_head as  $value) {
    $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
     foreach ($reuest_details  as  $reuest_detail) {
      $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
       
     }
     $customer->total=Decimalpoint($total_request);
     foreach (  $customer->extra_head_paid as $value2 ){
     $reuest_details_paid=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value2->id])->get(); 
     foreach ($reuest_details_paid  as  $reuest_details_paid1) {
     $total_paid +=$reuest_details_paid1->final_price * $reuest_details_paid1->quantity* $reuest_details_paid1->reg_flag;    
     }
         
     }
     $customer->paid=Decimalpoint($total_paid);
 
   }
   
    
    
  }



      }
	}
	  
		if (!empty($request->report_date_from) && empty($request->report_date_to)) {
		if($request->search_name){
		$getsearch =DB::select('select main.cust_id, main.name,main.name_en, sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.' AND c.active=1 AND R.date >= "'.$request->report_date_from.'"AND R.cust_id ='.$request->search_name.'  AND c.id = R.cust_id   order by R.cust_id,R.id) As main group by main.cust_id, main.name');
    $customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
    foreach ($customers as $customer) {
     $customer->deliver_fees=externalReq::where(['cust_id'=>$request->search_name,'org_id'=> Auth::User()->org_id])->whereDate('request_dt','>=',$request->report_date_from )->sum('delivery_fees');
     $customer->extra_head=externalReq::where(['cust_id'=>$request->search_name,'org_id'=> Auth::User()->org_id])->whereDate('request_dt','>=',$request->report_date_from)->whereNotIn('confirm', ['c'])->get();
     $total_paid=0;
     $total_request=0;
     foreach ( $customer->extra_head as  $value) {
       $customer->test=0;
       $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
       foreach ($reuest_details  as  $reuest_detail) {
        $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
         if($value->confirm =='d' || $value->confirm =='x' || $value->confirm =='yx' ){
           $total_paid +=$reuest_detail->final_price * $reuest_detail->quantity* $reuest_detail->reg_flag;
         }
       }

     }
      $customer->test=1;
      $customer->total=Decimalpoint($total_request);
      $customer->paid=Decimalpoint($total_paid);
    }



		}
		else{
	$getsearch =DB::select('select main.cust_id, main.name,main.name_en, sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.' AND c.active=1 AND R.date >= "'.$request->report_date_from.'"  AND c.id = R.cust_id   order by R.cust_id,R.id) As main group by main.cust_id, main.name');

  $customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
  foreach ($customers as $customer) {
   $customer->deliver_fees=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereDate('request_dt','>=',$request->report_date_from )->sum('delivery_fees');
   $customer->extra_head=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereDate('request_dt','>=',$request->report_date_from)->whereNotIn('confirm', ['c'])->get();
   $total_paid=0;
   $total_request=0;
   foreach ( $customer->extra_head as  $value) {
     $customer->test=0;
    $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
     foreach ($reuest_details  as  $reuest_detail) {
      $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
       if($value->confirm =='d' || $value->confirm =='x' || $value->confirm =='yx' ){
         $total_paid +=$reuest_detail->final_price * $reuest_detail->quantity* $reuest_detail->reg_flag;
       }
     }

   }
    $customer->total=Decimalpoint($total_request);
    $customer->paid=Decimalpoint($total_paid);
    $customer->test=1;
  }

     }
		   }
		  if (empty($request->report_date_from) && !empty($request->report_date_to)) {
		if($request->search_name){
	$getsearch =DB::select('select main.cust_id, main.name,main.name_en sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.' AND c.active=1 AND R.date <= "'.$request->report_date_to.'"  AND R.cust_id ='.$request->search_name.' AND c.id = R.cust_id   order by R.cust_id,R.id) As main group by main.cust_id, main.name');

  $customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
  foreach ($customers as $customer) {
   $customer->deliver_fees=externalReq::where(['cust_id'=>$request->search_name,'org_id'=> Auth::User()->org_id])->whereDate('request_dt','<=',$request->report_date_to )->sum('delivery_fees');
   $customer->extra_head=externalReq::where(['cust_id'=>$request->search_name,'org_id'=> Auth::User()->org_id])->whereDate('request_dt','<=',$request->report_date_to)->whereNotIn('confirm', ['c'])->get();
  
   $total_paid=0;
   $total_request=0;
   foreach ( $customer->extra_head as  $value) {
     $customer->test=0;
    $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
     foreach ($reuest_details  as  $reuest_detail) {
      $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
       if($value->confirm =='d' || $value->confirm =='x' || $value->confirm =='yx' ){
         $total_paid +=$reuest_detail->final_price * $reuest_detail->quantity* $reuest_detail->reg_flag;
       }
     }

   }
    $customer->total=Decimalpoint($total_request);
    $customer->paid=Decimalpoint($total_paid);
    $customer->test=1;
  }



  }
  else{
	$getsearch =DB::select('select main.cust_id, main.name,main.name_en, sum(main.requests) as requests, sum(main.payments) as payments from (SELECT R.cust_id, c.name,c.name_en, ( SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id) requests , ( SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM customers c, `customer_req_head` as R WHERE c.`org_id` = '.Auth::user()->org_id.'  AND c.active=1 AND R.date <= "'.$request->report_date_to.'"  AND c.id = R.cust_id   order by R.cust_id,R.id) As main group by main.cust_id, main.name');

  $customers=Customers::where(['org_id'=>Auth::User()->org_id,'active'=>1])->get();
  foreach ($customers as $customer) {
   $customer->deliver_fees=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereDate('request_dt','<=',$request->report_date_to )->sum('delivery_fees');
   $customer->extra_head=externalReq::where(['cust_id'=>$customer->id,'org_id'=> Auth::User()->org_id])->whereDate('request_dt','<=',$request->report_date_to)->whereIn('confirm', ['n','y'])->get();
   $total_paid=0;
   $total_request=0;
   foreach ( $customer->extra_head as  $value) {
     $customer->test=0;
    $reuest_details=externalTrans::where(['org_id'=> Auth::User()->org_id,'external_req_id'=>$value->id])->get();
     foreach ($reuest_details  as  $reuest_detail) {
      $total_request +=$reuest_detail->final_price * $reuest_detail->quantity * $reuest_detail->reg_flag;
       if($value->confirm =='d' || $value->confirm =='x' || $value->confirm =='yx' ){
         $total_paid +=$reuest_detail->final_price * $reuest_detail->quantity* $reuest_detail->reg_flag;
       }
     }

   }
    $customer->total=Decimalpoint($total_request);
    $customer->paid=Decimalpoint($total_paid);
    $customer->test=1;
  }
  	}

		}
		
		   }


		  $requests = [];
		  $payments = [];
		  $remainder = [];
		  $name=[];
if(!empty($getsearch) && !empty($customers)){

  foreach($customers as $value1){
    $all_total= abs(customer_requests($value1->id,$request->report_date_from,$request->report_date_to)['all_requests']);
    $all_pay=  abs(customer_requests($value1->id,$request->report_date_from,$request->report_date_to)['all_pay']); 
    
    if($all_total){
        
      if(app()->getLocale() == 'ar'){
     $name[] = $value1->name;
   }else{ $name[] = $value1->name_en;}  
        
     $requests[] = abs(Decimalpoint($all_total)) == '' ? 0: abs(Decimalpoint($all_total));
    $payments[] = abs(Decimalpoint($all_pay)) == '' ? 0: abs(Decimalpoint($all_pay));
    $remainder[] = Decimalpoint(abs($all_total)- abs($all_pay));    
        
    }
  


}
  
}elseif(empty($getsearch)){
   foreach($customers as $value ){
       $all_total=$value->total;
      $all_pay=$value->paid ;
    if($all_total){
        
     if(app()->getLocale() == 'ar'){
       $name[] =$value->name;
     }else{ $name[] = $value->name_en;}

    
      $requests[] = abs(Decimalpoint($all_total)) == '' ? 0: abs(Decimalpoint($all_total));
      $payments[] = abs(Decimalpoint($all_pay)) == '' ? 0: abs(Decimalpoint($all_pay));
      $remainder[] = Decimalpoint(abs(($all_total))- abs(($all_pay)));   
        
    }

     
    }

}elseif(empty($customers)){
 foreach($getsearch as $result){
  if(app()->getLocale() == 'ar'){
    $name[] = $result->name;
     }else{ $name[] = $result->name_en;}

       $all_total=abs($result->requests);
       $all_pay=abs($result->payments);
       $requests[] = abs(Decimalpoint($all_total)) == '' ? 0: abs(Decimalpoint($all_total));
       $payments[] = abs(Decimalpoint($all_pay)) == '' ? 0: abs(Decimalpoint($all_pay));
       $remainder[] = Decimalpoint(abs(($all_total))- abs(($all_pay)));
  }
}


	             $report=$getsearch;
	             $chart = new reportchart;
				$chart->title('My nice chart');
				$chart->labels($name);

		$chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى': 'Total', 'bar', $requests)->color('#e6270c');
        $chart->dataset(app()->getLocale() == 'ar' ? 'المدفوع': 'Paid', 'bar', $payments)->color('#1dad1f');
        $chart->dataset(app()->getLocale() == 'ar' ? 'المتبقى': 'Remaining', 'bar', $remainder)->color('#04c');
         
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



       return view('reports.serach',compact('chart'));
    }

	    public function searchWithUserDetails(Request $request){
   if(empty($request->report_date_from) && empty($request->report_date_to)){
		if($request->search_name){
 $getsearch = DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1 and s.id='.$request->search_name.' and cast(R.invoice_date as date)=CURRENT_DATE   order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');

		}else{
 $getsearch = DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1 and cast(R.invoice_date as date)=CURRENT_DATE  order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');


	}
       }else{

		if (!empty($request->report_date_from) && !empty($request->report_date_to)){
		if($request->search_name){
	 $getsearch = DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1  AND cast(R.invoice_date as date) >=  "'.$request->report_date_from.'" AND cast(R.invoice_date as date) <= "'.$request->report_date_to.'"    and s.id='.$request->search_name.' order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');
		}
		else{
		$getsearch = DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1  AND cast(R.invoice_date as date) >=  "'.$request->report_date_from.'" AND  cast(R.invoice_date as date) <= "'.$request->report_date_to.'"   order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');


	}
	}
   if (!empty($request->report_date_from) && empty($request->report_date_to)) {
		if($request->search_name){
	 $getsearch = DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1  AND cast(R.invoice_date as date) >=  "'.$request->report_date_from.'"  and s.id='.$request->search_name.' order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');

		}
		else{
	 $getsearch = DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1  AND cast(R.invoice_date as date) >=  "'.$request->report_date_from.'"   order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');


		}
		   }
		  if (empty($request->report_date_from) && !empty($request->report_date_to)) {
		if($request->search_name){
	 $getsearch = DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1   AND cast(R.invoice_date as date) <= "'.$request->report_date_to.'"    and s.id='.$request->search_name.' order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');

		}
		else{
	 $getsearch = DB::select('select main.invoice_user, main.name,main.name_en, sum(main.requests) requests, sum(main.payments)payments from (SELECT R.invoice_user, R.id, s.name,R.date,s.name_en, (SELECT SUM(t.price*t.quantity*t.req_flag) FROM transactions AS t WHERE R.id = t.cust_req_id ) requests, (SELECT SUM(p.pay_amount*p.pay_flag) FROM permission_receiving_payments as p WHERE R.id = p.customer_req_id ) payments FROM users s,`customer_req_head` as R where s.id = R.invoice_user and s.org_id= '.Auth::user()->org_id.' and s.is_active=1   AND  cast(R.invoice_date as date) <= "'.$request->report_date_to.'"    order by R.invoice_user,R.id) As main group by main.invoice_user, main.name');
		}
		   }

        }

		  $requests = [];
		  $payments = [];
		  $remainder = [];
		    $name=[];
		   foreach($getsearch as $result){
		  if(app()->getLocale() == 'ar'){
			 $name[] = $result->name;
		    }else{ $name[] = $result->name_en;}


			$requests[] = abs(Decimalpoint($result->requests)) == '' ? 0: abs(Decimalpoint($result->requests));
			$payments[] = abs(Decimalpoint($result->payments)) == '' ? 0: abs(Decimalpoint($result->payments));
		   $remainder[] = Decimalpoint(abs(($result->requests))- abs(($result->payments)));
		}
		 $chart = new reportchart;

				$chart->title('My nice chart');
				$chart->labels($name);

		    $chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى': 'Total', 'bar', $requests)->color('#e6270c');
        $chart->dataset(app()->getLocale() == 'ar' ? 'المدفوع': 'Paid', 'bar', $payments)->color('#1dad1f');
        $chart->dataset(app()->getLocale() == 'ar' ? 'المتبقى': 'Remaining', 'bar', $remainder)->color('#04c');

       return view('reports.userdetails',compact('chart'));
    }



}

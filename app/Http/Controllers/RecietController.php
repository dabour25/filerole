<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\externalTrans as external_trans;
use App\Category  as CategoriesModel;
use App\Customers  as CustomersModel;
use App\CategoriesType;
use App\CustomerHead;
use App\externalReq;
use App\PermissionReceivingPayments;
use App\Banking;
use Auth;
use App\org;
use App\InvoiceSetup;
use App\Transactions;
use Response;
use Session;
use DB;



class RecietController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          if (permissions('add_reciet') == 0 ) {
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        $category_services=CategoriesType::where('org_id',Auth::user()->org_id)->where('type',2)->where('active',1)->pluck('id');
        $services=CategoriesModel::whereIn('category_type_id',$category_services)->get();
        $customers=CustomersModel::where('org_id',Auth::user()->org_id)->where('active',1)->get();

        return view('recites.index',compact('services','customers'));
    }
    public function serviceReport()
    {
         if (permissions('service_report') == 0 ) {
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        
      $customer_heads =  CustomerHead::where([['org_id', Auth::user()->org_id],['date',date('Y-m-d')]])->orderBy('id','desc')->get();
      foreach($customer_heads as $customer_head){
        $customer_head->expected_date=date('Y-m-d',strtotime($customer_head->date) + (86400 *$customer_head->due_date));

        $customer_head->total=Decimalplace(abs(DB::select('SELECT sum(quantity * req_flag * price)    AS price  FROM `transactions` WHERE  org_id = '.Auth::user()->org_id.' AND cust_req_id = '.$customer_head->id)[0]->price)) ;

      }
      $cust = DB::table('customers')->where('org_id',Auth::user()->org_id)->get();

      $emp = DB::table('users')->where(['org_id'=>Auth::user()->org_id,'is_active'=>1])->get();
      return view('recites.report',['customer_heads'=>$customer_heads,'emp'=>$emp,'customersSelect'=>$cust]);
    }
    public function searchService(Request $Request)
    {
          if (permissions('service_report') == 0 ) {
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        
      $cust = DB::table('customers')->where('org_id',Auth::user()->org_id)->get();
      $emp = DB::table('users')->where(['org_id'=>Auth::user()->org_id,'is_active'=>1])->get();
      $org_id = Auth::user()->org_id;
      $from = $Request->date_from;
      $cust_id = $Request->cust_id;
      $to = $Request->date_to;
      $status = $Request->status;
     
      $invoice_no = $Request->invoice_no;
      $invoice_date= $Request->invoice_date;
      $type=$Request->type;

        $result = CustomerHead::when($org_id, function ($q) use ($org_id) {
            return $q->where('org_id' , $org_id);
        })

        ->when($from,function ($q) use ($from) {
          return $q->whereDate('date','>=' ,$from);
        })
        ->when($to,function ($q) use ($to) {
          return $q->whereDate('date' ,'<=' ,$to);
        })

        ->when($invoice_no,function ($q) use ($invoice_no) {
          return $q->where('invoice_no', 'like', '%' . $invoice_no . '%');
        })
        ->when($cust_id,function ($q) use ($cust_id) {
          return $q->where('cust_id', $cust_id);
        })
        ->when( $status ,function ($q) use ( $status) {
            if($status==5){
                return  $q->where('invoice_status', 0 );
            }
          return  $q->where('invoice_status', $status );
        })
         ->when($type ,function ($q) use ($type) {
             if($type==1){
                 return  $q->where('received_by','!=',null );
             }
             else{
                 return  $q->where('received_by','=',null );
             }
          
        })

        ->orderBy('id','desc')->get();
         foreach($result as $customer_head){
        $customer_head->expected_date=date('Y-m-d',strtotime($customer_head->date) + (86400 *$customer_head->due_date));

        $customer_head->total=Decimalplace(abs(DB::select('SELECT sum(quantity * req_flag * price)    AS price  FROM `transactions` WHERE  org_id = '.Auth::user()->org_id.' AND cust_req_id = '.$customer_head->id)[0]->price)) ;

      }
    

    return view('recites.report',['customer_heads'=>$result,'oldData'=>$Request->all(),'emp'=>$emp,'customersSelect'=>$cust]);
    }

    public function addNewServiceRequest(Request $request)
    {

if($request->action==1){
    
        $customer_req_head=new CustomerHead();
        $customer_req_head->cust_id=$request->cust_id;
        $customer_req_head->date=$request->delivery_date;
        $customer_req_head->due_date=$request->due_date;
        $customer_req_head->paid=0;
        $customer_req_head->description=$request->description;

 if($request->due_date==0){
        $customer_req_head->invoice_status=4;

      }
        $customer_req_head->org_id=Auth::user()->org_id;
        $customer_req_head->internal=1;
        $customer_req_head->user_id=Auth::user()->id;
        $customer_req_head->type='reciet';
        $customer_req_head->save();
        $customer_head=$customer_req_head->id;
      }
      if($request->action==2 || $request->action==3){

        Transactions::where('cust_req_id',$request->customer_req_head)->delete();
        $customer_head=$request->customer_req_head;
      }
       $services=array();
       $service=array();
       $total=0;

       foreach ($request['cat_id'] as $index => $value) {

         $newTrans = new Transactions();

         $newTrans->cust_req_id =$customer_head;
         $newTrans->cust_id=$request->cust_id;
         $newTrans->cat_id = $value;
         $newTrans->quantity = $request['qny'][$index] ;
         $newTrans->req_flag = $request['reqFlag'][$index] ;
         if($request['reqFlag'][$index]==1){
              $newTrans->description='صرف عميل';
         }
         else{
             $newTrans->description='ارتجاع عميل';
         }
        
         $newTrans->tax_id = $request['taxId'][$index] ;
         $newTrans->tax_val = $request['tax_val'][$index] ;
         $newTrans->price = $request['cat_price'][$index] ;
         $newTrans->user_id = Auth::user()->id ;
         $newTrans->org_id = Auth::user()->org_id ;
         $newTrans->save();
         $service['cat_id']=$value;
         $service['taxId']=$request['taxId'][$index];
         $service['cat_name']=app()->getLocale() == 'ar' ? CategoriesModel::find($value)->name:CategoriesModel::find($value)->name_en;
         $service['quantity']=$request['qny'][$index];
         $service['price']=$request['cat_price'][$index];
         $service['total_price']=Decimalpoint($request['cat_price'][$index]*$request['qny'][$index]);
         $service['tax_val']=$request['tax_val'][$index];
         $service['motion_type']=$request['reqFlag'][$index];
         $total+=$service['total_price'];

         array_push($services,$service);


       }
       if($request->action==2 || $request->action==3){
         $paid_value=PermissionReceivingPayments::where('customer_req_id',$request->customer_head)->where('pay_flag',1)->sum('pay_amount');
         $return_value=PermissionReceivingPayments::where('customer_req_id',$request->customer_head)->where('pay_flag',-1)->sum('pay_amount');
         $paid_amount=$paid_value-$return_value;

         $edit_customer_head=CustomerHead::find($customer_head);
         if($total==$paid_amount){

           $edit_customer_head->invoice_status=1;
           $edit_customer_head->save();
         }
         elseif($total>$paid_amount && $paid_amount!=0){
           if($request->due_date==0){
             $customer_req_head->invoice_status=4;
             $edit_customer_head->save();
           }
           else{
             $customer_req_head->invoice_status=2;
             $edit_customer_head->save();
           }

         }
         elseif($paid_amount==0){
           $edit_customer_head->invoice_status=0;
           $edit_customer_head->save();
         }
         else{
           $edit_customer_head->invoice_status=3;
           $edit_customer_head->save();
         }
       }
       $org=org::find(Auth::user()->org_id);
       $id=$customer_head;
       $delivery_date=$request->delivery_date;

       $due_date=$request->end_date1;
    
   
       if($request->redirect==1){
         return redirect('/admin/servicereport')->with('successMsg','تمت الاضافة بنجاح');
       }
       if($request->action==2){
         return view('recites.print_reciet',compact('org','services','total','id','delivery_date','due_date'));
       }
       else{
        $customer= CustomersModel::find($request->cust_id);

        $customer_req_head=$customer_req_head->id;
         $category_services=CategoriesType::where('org_id',Auth::user()->org_id)->where('type',2)->where('active',1)->pluck('id');
         $services2=CategoriesModel::whereIn('category_type_id',$category_services)->get();
         return view('recites.edit_reciet',compact('services','services2','total','id','delivery_date','due_date','customer','customer_req_head'));
       }



      // return back()->with('successMsg','تمت الاضافة بنجاح');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getServiceDetails(Request $Request)
    {

      $getCat = CategoriesModel::where('org_id',Auth::user()->org_id)->where('id',$Request->cat_id)->first();
      $offer = DB::table('offers')->where('cat_id',$getCat->id)->whereDate('date_from','<=',date("Y-m-d"))->whereDate('date_to','>=',date("Y-m-d"))->where('org_id',Auth::user()->org_id)->first();
      $price = DB::table('price_list')->where('cat_id',$getCat->id)->where('org_id',Auth::user()->org_id)->where('date', '<=',date("Y-m-d") )->orderBy('date','desc')->where('active',1)->first();
      // dd($price);
      $flag = DB::select("SELECT SUM(quantity * reg_flag)  AS flag FROM `external_trans` WHERE org_id = " .Auth::user()->org_id." AND  cat_id = $Request->cat_id");
      // flag_req
      $invoice_no = $getCat->invoice_no;
      $invoice_date = $getCat->invoice_date;

      if ($Request->flag_req == 1) {
        $getCat = CategoriesModel::where('org_id',Auth::user()->org_id)->where('id',$Request->cat_id)->first();
        $ex_cat = external_trans::where('cat_id',$getCat->id)->where('org_id',Auth::user()->org_id)->where('external_req_id',$Request->req_id)->orderBy('created_at','desc')->first();
        return Response::json(
          array(
                  'data'   => 'successGetPice',
                  'catPrice'   => Decimalpoint($ex_cat->final_price),
                  'catTax'   => Decimalpoint($ex_cat->tax_val),
                  'taxId'   => $ex_cat->tax_id,
                  'flag'   => abs($flag[0]->flag),
                ));
      }else{
        // dd($Request->all());
        $cat_details=cat_price($Request->cat_id);
        if(!empty($cat_details)){
          $cat_details['data']='successGetPice';
        }else{
          $cat_details['data']='noPrice';
        }
        return Response::json($cat_details);
    }
    }
    public function getServiceReturn(Request $Request)
    {
      $cats = [];
      $gettransReq = external_trans::where(['org_id'=>Auth::user()->org_id,'external_req_id'=>$Request->req_id])->groupBy('cat_id')->get();

      foreach ($gettransReq as $key) {
        $cat_id = DB::table('categories')->where(['org_id'=>Auth::user()->org_id,'id'=>$key->cat_id])->get(['id','name','name_en']);
        $cats[] = $cat_id  ;
      }
      // dd($cats[0][0]->id);
      return Response::json(
        array(
                'data'   => $cats,
                'returnMsg'   => 'successGitCats',
              ));
    }
    public function getPaymentdata(Request $request){

      //save transactions

     

       // check invoice_number
       
       $invoice_no_check=CustomerHead::where('org_id',Auth::user()->org_id)->where('id',$request->customer_req_head)->first()->invoice_no;
      
       if($invoice_no_check==null){


      $invoice_no_internal=CustomerHead::where('org_id',Auth::user()->org_id)->orderBy('invoice_no','desc')->first()->invoice_no;
      $invoice_no_extranal=externalReq::where('org_id',Auth::user()->org_id)->orderBy('invoice_no','desc')->first()->invoice_no;
      if($invoice_no_internal==null && $invoice_no_extranal==null) {
        $sart_invoice_no=InvoiceSetup::where('type',4)->where('org_id',Auth::user()->org_id)->value('value');

        if($sart_invoice_no==null){
          $sart_invoice_no=1;
        }
        $invoice_no=$sart_invoice_no;
      }
      elseif($invoice_no_internal!=null && $invoice_no_extranal!=null) {
        if($invoice_no_internal > $invoice_no_extranal){
          $invoice_no=$invoice_no_internal+1;

        }
         else {
           $invoice_no=$invoice_no_extranal+1;
         }
      }
      elseif($invoice_no_internal!=null && $invoice_no_extranal==null){
         $invoice_no=$invoice_no_internal+1;
      }
      else{
        $invoice_no=$invoice_no_extranal+1;
      }


    }
    else{
      $invoice_no=$invoice_no_check;
    }
     Transactions::where('cust_req_id',$request->customer_req_head)->delete();

      foreach ($request['cat_id'] as $index => $value) {
        $newTrans = new Transactions();

        $newTrans->cust_req_id =$request->customer_req_head;
        $newTrans->cust_id=$request->cust_id;
        $newTrans->cat_id = $value;
        $newTrans->quantity = $request['qny'][$index] ;
        $newTrans->req_flag = $request['reqFlag'][$index] ;
         if($request['reqFlag'][$index]==1){
              $newTrans->description='صرف عميل';
         }
         else{
             $newTrans->description='ارتجاع عميل';
         }
        $newTrans->tax_id = $request['taxId'][$index] ;
        $newTrans->tax_val = $request['tax_val'][$index] ;
        $newTrans->price = $request['cat_price'][$index] ;
        $newTrans->user_id = Auth::user()->id ;
        $newTrans->org_id = Auth::user()->org_id ;
        $newTrans->save();

      }
    $paid_value=PermissionReceivingPayments::where('customer_req_id',$request->customer_req_head)->where('pay_flag',1)->sum('pay_amount');
    $return_value=PermissionReceivingPayments::where('customer_req_id',$request->customer_req_head)->where('pay_flag',-1)->sum('pay_amount');
    $paid_amount=$paid_value-$return_value;

 $payment_method=app()->getLocale() == 'ar' ?Banking::where('org_id',Auth::user()->org_id)->pluck('name','id'):Banking::where('org_id',Auth::user()->org_id)->pluck('name_en','id');

 return Response::json(
   array(
           'invoice_no'   => $invoice_no,
           'paid_amount' =>Decimalpoint($paid_amount),
           'payment_method'=>$payment_method,
           'customer_head'=>$request->customer_req_head,
           'cust_id'=>$request->cust_id
         ));
  }
  public function payServiceamount(Request $request)
  {
    $total=$request->total_amount;

    $edit_customer_head=CustomerHead::find($request->customer_head);

    $edit_customer_head->invoice_no=$request->invoice_no;
    $edit_customer_head->invoice_code=$sart_invoice_code=InvoiceSetup::where('type',3)->where('org_id')->value('value').$request->invoice_no;
    $edit_customer_head->invoice_date=date("Y-m-d H:i:s");
    $edit_customer_head->invoice_user=Auth::user()->id;
    $edit_customer_head->invoice_user=Auth::user()->id;
    $permessionrecievingPayments=new PermissionReceivingPayments();
    $permessionrecievingPayments->pay_amount=$request->amount;
    $permessionrecievingPayments->pay_date=date('Y-m-d');
    $permessionrecievingPayments->bank_treasur_id=$request->payment_method;
    $permessionrecievingPayments->pay_method=Banking::find($request->payment_method)->type;
    $permessionrecievingPayments->pay_flag=$request->payment_type;
    $permessionrecievingPayments->description=$request->payment_type==1?'قبض من عميل':'ارتجاع من عميل';
    $permessionrecievingPayments->customer_req_id=$request->customer_head;
    $permessionrecievingPayments->customer_id=$request->customer_id;
    $permessionrecievingPayments->customer_invoice_no=$request->invoice_no;
    $permessionrecievingPayments->org_id=Auth::user()->org_id;
    $permessionrecievingPayments->user_id=Auth::user()->id;
    $permessionrecievingPayments->save();
    $paid_value=PermissionReceivingPayments::where('customer_req_id',$request->customer_head)->where('pay_flag',1)->sum('pay_amount');
    $return_value=PermissionReceivingPayments::where('customer_req_id',$request->customer_head)->where('pay_flag',-1)->sum('pay_amount');
    $paid_amount=$paid_value-$return_value;

    if($total==$paid_amount){
      $edit_customer_head->invoice_status=1;

    }
    elseif($total>$paid_amount && $paid_amount!=0){
      if($request->due_date==0){
        $customer_req_head->invoice_status=4;

      }
      else{
        $customer_req_head->invoice_status=2;

      }

    }
    elseif($paid_amount==0){
      $edit_customer_head->invoice_status=0;

    }
    else{
      $edit_customer_head->invoice_status=3;

    }

$edit_customer_head->save();


    // return back()->with('successMsg',__('strings.payment_succseded'));
      return Response::json(
      array(

        'customer_head'=>$request->customer_head,
            ));

}

public function getDeliverydata(Request $request)
{
    
  $total=$request->total_amount;

  $paid_value=PermissionReceivingPayments::where('org_id',Auth::user()->org_id)->where('customer_req_id',$request->customer_req_head)->where('pay_flag',1)->sum('pay_amount');
  $return_value=PermissionReceivingPayments::where('org_id',Auth::user()->org_id)->where('customer_req_id',$request->customer_req_head)->where('pay_flag',-1)->sum('pay_amount');
  $paid_amount=$paid_value-$return_value;


  if($total>$paid_amount){
    return Response::json(
    array(
           'msg'   => 'notpaid',
         ));
  }
  else{
    Transactions::where('cust_req_id',$request->customer_req_head)->delete();

    foreach ($request['cat_id'] as $index => $value) {
      $newTrans = new Transactions();

      $newTrans->cust_req_id =$request->customer_req_head;
      $newTrans->cust_id=$request->cust_id;
      $newTrans->cat_id = $value;
      $newTrans->quantity = $request['qny'][$index] ;
      $newTrans->req_flag = $request['reqFlag'][$index] ;
       if($request['reqFlag'][$index]==1){
              $newTrans->description='صرف عميل';
         }
         else{
             $newTrans->description='ارتجاع عميل';
         }
      $newTrans->tax_id = $request['taxId'][$index] ;
      $newTrans->tax_val = $request['tax_val'][$index] ;
      $newTrans->price = $request['cat_price'][$index];
      $newTrans->user_id = Auth::user()->id ;
      $newTrans->org_id = Auth::user()->org_id ;
      $newTrans->save();

    }

     // check invoice_number
     $invoice_no_check=CustomerHead::where('org_id',Auth::user()->org_id)->where('id',$request->customer_req_head)->first()->invoice_no;
     if($invoice_no_check==null){


    $invoice_no_internal=CustomerHead::where('org_id',Auth::user()->org_id)->orderBy('invoice_no','desc')->first()->invoice_no;
    $invoice_no_extranal=externalReq::where('org_id',Auth::user()->org_id)->orderBy('invoice_no','desc')->first()->invoice_no;
    if($invoice_no_internal==null && $invoice_no_extranal==null) {
      $sart_invoice_no=InvoiceSetup::where('type',4)->where('org_id',Auth::user()->org_id)->value('value');

      if($sart_invoice_no==null){
        $sart_invoice_no=1;
      }
      $invoice_no=$sart_invoice_no;
    }
    elseif($invoice_no_internal!=null && $invoice_no_extranal!=null) {
      if($invoice_no_internal > $invoice_no_extranal){
        $invoice_no=$invoice_no_internal+1;

      }
       else {
         $invoice_no=$invoice_no_extranal+1;
       }
    }
    elseif($invoice_no_internal!=null && $invoice_no_extranal==null){
       $invoice_no=$invoice_no_internal+1;
    }
    else{
      $invoice_no=$invoice_no_extranal+1;
    }


  }
  else{
    $invoice_no=$invoice_no_check;
  }


  return Response::json(
  array(
         'invoice_no'   => $invoice_no,
         'customer_head'=>$request->customer_req_head,
         'cust_id'=>$request->cust_id,
         'msg'=>'paid'
       ));
  }

}
public function deliverService(Request $request)
{

  $edit_customer_head=CustomerHead::find($request->customer_head);
  $edit_customer_head->invoice_no=$request->invoice_no;
  $edit_customer_head->invoice_code=$sart_invoice_code=InvoiceSetup::where('type',3)->where('org_id')->value('value').$request->invoice_no;
  $edit_customer_head->invoice_date=date("Y-m-d H:i:s");
  $edit_customer_head->invoice_user=Auth::user()->id;

  $edit_customer_head->invoice_status=1;
  $edit_customer_head->receiving_date=date("Y-m-d H:i:s");
  $edit_customer_head->received_by=$request->delivered_name==null?'delivered':$request->delivered_name;
  $edit_customer_head->save();
}
public function showReciet(Request $request,$id)
{
       if (permissions('reciet_show') == 0 ) {
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
  $services=Transactions::where('cust_req_id',$id)
  ->where('org_id',Auth::user()->org_id)
  ->get();
  $total=0;
  foreach($services as $service){
    $service->total_price=$service->price*$service->quantity;
    $total+=$service->price*$service->quantity;
  }

  $customer_head=CustomerHead::where('id',$id)
  ->where('org_id',Auth::user()->org_id)
  ->first();
  
  $show_buttons=$customer_head->received_by!=null?0:1;
  

   $delivery_date=$customer_head->date;
   $due_date=date('Y-m-d',strtotime($customer_head->date) + (86400 *$customer_head->due_date));

   $customer= CustomersModel::find($customer_head->cust_id);

   $customer_req_head=$id;
   $category_services=CategoriesType::where('org_id',Auth::user()->org_id)->where('type',2)->where('active',1)->pluck('id');
  $services2=CategoriesModel::where('org_id',Auth::user()->org_id)->whereIn('category_type_id',$category_services)->get();
  // $total=(DB::select('SELECT sum(quantity * req_flag * price)    AS price  FROM `transactions` WHERE  org_id = '.Auth::user()->org_id.' AND cust_req_id = '.$id)[0]->price);
  return view('recites.show',compact('services','services2','total','id','delivery_date','due_date','customer','customer_req_head','show_buttons'));
}
public function printReciet(Request $request,$id){
    
    if (permissions('reciet_print') == 0 ) {
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        
  $services=Transactions::where('cust_req_id',$id)
  ->where('org_id',Auth::user()->org_id)
  ->get();
  $total=0;
  foreach($services as $service){
    $service->total_price=$service->price*$service->quantity;
    $service->cat_name=app()->getLocale() == 'ar' ? CategoriesModel::where('org_id',Auth::user()->org_id)->where('id',$service->cat_id)->first()->name:CategoriesModel::where('org_id',Auth::user()->org_id)->where('id',$service->cat_id)->first()->name_en;
    $total+=$service->price*$service->quantity;
  }

  $customer_head=CustomerHead::where('id',$id)
  ->where('org_id',Auth::user()->org_id)
  ->first();
  $status=$customer_head->received_by==null?__('strings.not_delivered'):__('strings.delivered');

   $delivery_date=$customer_head->date;
   $due_date= date('Y-m-d',strtotime($customer_head->date) + (86400 *$customer_head->due_date));

   $org=org::find(Auth::user()->org_id);
   $id=$customer_head->id;




  return view('recites.report_print_reciet',compact('org','services','total','id','delivery_date','due_date','status'));

}
public function getReportPaymentdata(Request $request){


   // check invoice_number
   $invoice_no_check=CustomerHead::where('org_id',Auth::user()->org_id)->where('id',$request->customer_req_head)->first()->invoice_no;
   if($invoice_no_check==null){


  $invoice_no_internal=CustomerHead::where('org_id',Auth::user()->org_id)->orderBy('invoice_no','desc')->first()->invoice_no;
  $invoice_no_extranal=externalReq::where('org_id',Auth::user()->org_id)->orderBy('invoice_no','desc')->first()->invoice_no;
  if($invoice_no_internal==null && $invoice_no_extranal==null) {
    $sart_invoice_no=InvoiceSetup::where('type',4)->where('org_id',Auth::user()->org_id)->value('value');

    if($sart_invoice_no==null){
      $sart_invoice_no=1;
    }
    $invoice_no=$sart_invoice_no;
  }
  elseif($invoice_no_internal!=null && $invoice_no_extranal!=null) {
    if($invoice_no_internal > $invoice_no_extranal){
      $invoice_no=$invoice_no_internal+1;

    }
     else {
       $invoice_no=$invoice_no_extranal+1;
     }
  }
  elseif($invoice_no_internal!=null && $invoice_no_extranal==null){
     $invoice_no=$invoice_no_internal+1;
  }
  else{
    $invoice_no=$invoice_no_extranal+1;
  }


}
else{
  $invoice_no=$invoice_no_check;
}
$paid_value=PermissionReceivingPayments::where('customer_req_id',$request->customer_req_head)->where('pay_flag',1)->sum('pay_amount');
$return_value=PermissionReceivingPayments::where('customer_req_id',$request->customer_req_head)->where('pay_flag',-1)->sum('pay_amount');
$paid_amount=$paid_value-$return_value;

$payment_method=app()->getLocale() == 'ar' ?Banking::where('org_id',Auth::user()->org_id)->pluck('name','id'):Banking::where('org_id',Auth::user()->org_id)->pluck('name_en','id');

return Response::json(
array(
       'invoice_no'   => $invoice_no,
       'paid_amount' =>Decimalpoint($paid_amount),
       'payment_method'=>$payment_method,
       'customer_head'=>$request->customer_req_head,
       'cust_id'=>$request->cust_id
     ));

}
public function payReportserviceamount(Request $request){

  $total=(DB::select('SELECT sum(quantity * req_flag * price)    AS price  FROM `transactions` WHERE  org_id = '.Auth::user()->org_id.' AND cust_req_id = '.$request->customer_head)[0]->price);

  $edit_customer_head=CustomerHead::find($request->customer_head);

  $edit_customer_head->invoice_no=$request->invoice_no;
  $edit_customer_head->invoice_code=$sart_invoice_code=InvoiceSetup::where('type',3)->where('org_id')->value('value').$request->invoice_no;
  $edit_customer_head->invoice_date=date("Y-m-d H:i:s");
  $edit_customer_head->invoice_user=Auth::user()->id;
  $edit_customer_head->invoice_user=Auth::user()->id;
  $permessionrecievingPayments=new PermissionReceivingPayments();
  $permessionrecievingPayments->pay_amount=$request->amount;
  $permessionrecievingPayments->pay_date=date('Y-m-d');
  $permessionrecievingPayments->bank_treasur_id=$request->payment_method;
  $permessionrecievingPayments->pay_method=Banking::find($request->payment_method)->type;
  $permessionrecievingPayments->pay_flag=$request->payment_type;
  $permessionrecievingPayments->description=$request->payment_type==1?'قبض من عميل':'ارتجاع من عميل';
  $permessionrecievingPayments->customer_req_id=$request->customer_head;
  $permessionrecievingPayments->customer_id=$request->customer_id;
  $permessionrecievingPayments->customer_invoice_no=$request->invoice_no;
  $permessionrecievingPayments->org_id=Auth::user()->org_id;
  $permessionrecievingPayments->user_id=Auth::user()->id;
  $permessionrecievingPayments->save();
  $paid_value=PermissionReceivingPayments::where('customer_req_id',$request->customer_head)->where('pay_flag',1)->sum('pay_amount');
  $return_value=PermissionReceivingPayments::where('customer_req_id',$request->customer_head)->where('pay_flag',-1)->sum('pay_amount');
  $paid_amount=$paid_value-$return_value;

  if($total==$paid_amount){
    $edit_customer_head->invoice_status=1;

  }
  elseif($total>$paid_amount && $paid_amount!=0){
    if($request->due_date==0){
      $customer_req_head->invoice_status=4;

    }
    else{
      $customer_req_head->invoice_status=2;

    }

  }
  elseif($paid_amount==0){
    $edit_customer_head->invoice_status=0;

  }
  else{
    $edit_customer_head->invoice_status=3;

  }

  $edit_customer_head->save();


  // return back()->with('successMsg',__('strings.payment_succseded'));
  return 'done';
}
public function getReportdeliverydata(Request $request){

     // check invoice_number
     $invoice_no_check=CustomerHead::where('org_id',Auth::user()->org_id)->where('id',$request->customer_req_head)->first()->invoice_no;
     if($invoice_no_check==null){


    $invoice_no_internal=CustomerHead::where('org_id',Auth::user()->org_id)->orderBy('invoice_no','desc')->first()->invoice_no;
    $invoice_no_extranal=externalReq::where('org_id',Auth::user()->org_id)->orderBy('invoice_no','desc')->first()->invoice_no;
    if($invoice_no_internal==null && $invoice_no_extranal==null) {
      $sart_invoice_no=InvoiceSetup::where('type',4)->where('org_id',Auth::user()->org_id)->value('value');

      if($sart_invoice_no==null){
        $sart_invoice_no=1;
      }
      $invoice_no=$sart_invoice_no;
    }
    elseif($invoice_no_internal!=null && $invoice_no_extranal!=null) {
      if($invoice_no_internal > $invoice_no_extranal){
        $invoice_no=$invoice_no_internal+1;

      }
       else {
         $invoice_no=$invoice_no_extranal+1;
       }
    }
    elseif($invoice_no_internal!=null && $invoice_no_extranal==null){
       $invoice_no=$invoice_no_internal+1;
    }
    else{
      $invoice_no=$invoice_no_extranal+1;
    }


  }
  else{
    $invoice_no=$invoice_no_check;
  }


  return Response::json(
  array(
         'invoice_no'   => $invoice_no,
         'customer_head'=>$request->customer_req_head,
         'cust_id'=>$request->cust_id,
         'msg'=>'paid'
       ));
  }

  public function deliverReportservice(Request $request){

    $edit_customer_head=CustomerHead::find($request->customer_head);
    $edit_customer_head->invoice_no=$request->invoice_no;
    $edit_customer_head->invoice_code=$sart_invoice_code=InvoiceSetup::where('type',3)->where('org_id')->value('value').$request->invoice_no;
    $edit_customer_head->invoice_date=date("Y-m-d H:i:s");
    $edit_customer_head->invoice_user=Auth::user()->id;

    $edit_customer_head->invoice_status=1;
    $edit_customer_head->receiving_date=date("Y-m-d H:i:s");
    $edit_customer_head->received_by=$request->delivered_name==null?'delivered':$request->delivered_name;
    $edit_customer_head->save();
  }
  
    public function getServices(){
    $category_services=CategoriesType::where('org_id',Auth::user()->org_id)->where('type',2)->where('active',1)->pluck('id');
    if(app()->getLocale() == 'ar'){
      $services=CategoriesModel::whereIn('category_type_id',$category_services)->pluck('name','id');
    }
    else{
      $services=CategoriesModel::whereIn('category_type_id',$category_services)->pluck('name_en','id');
    }

    // return json_encode($services);
    return Response::json($services);
  }
  public function invoiceReciet(Request $request,$id)
  {
      if (permissions('reciet_invoice') == 0 ) {
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
      $list = CustomerHead::where(['id' => $id, 'org_id' => Auth::user()->org_id])->with('customer', 'transactions')->whereNotNull('cust_id')->get();
        foreach ($list as $value) {
            foreach ($value->transactions as $key => $v) {
                $v->price = $v->price * $v->quantity * $v->req_flag;

                $v->tax_val = $v->tax_val * $v->quantity * $v->req_flag;
                $v->cat_type = CategoriesType::findOrFail(CategoriesModel::findOrFail($v->cat_id)->category_type_id)->type;
            }
            return view('recites.invoice', compact('list'));

        }
  }
  
  public function getItems()
  {
      $category_services=CategoriesType::where('org_id',Auth::user()->org_id)->where('active',1)->pluck('id');
    if(app()->getLocale() == 'ar'){
      $services=CategoriesModel::whereIn('category_type_id',$category_services)->pluck('name','id');
    }
    else{
      $services=CategoriesModel::whereIn('category_type_id',$category_services)->pluck('name_en','id');
    }

    // return json_encode($services);
    return Response::json($services);
  }

}

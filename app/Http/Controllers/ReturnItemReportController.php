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
use App\externalReq;
use App\externalTrans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use Illuminate\Validation\Rule;
use Input;
use App\Charts\reportchart;
class ReturnItemReportController extends Controller
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


	 $name=[];
      $total=[];
      $category_items=CategoriesType::where('org_id',Auth::user()->org_id)->where('type',1)->where('active',1)->pluck('id');

    //   $external_req=externalReq::where('org_id',Auth::user()->org_id)->pluck('id');
    //   $customer_head=CustomerHead::where('org_id',Auth::user()->org_id)->pluck('id');
      $transaction_category= Transactions::where('date',date('Y-m-d'))->where('org_id',Auth::user()->org_id)->whereNotNull('cust_id')->where('req_flag',1)->pluck('cat_id');
    
      $external_trans_category=externalTrans::where('request_dt',date('Y-m-d'))->where('org_id',Auth::user()->org_id)->where('reg_flag',1)->pluck('cat_id');
      
      
     $items_ids =$transaction_category->merge($external_trans_category);
    
      $items=Category::whereIn('id',$items_ids)->whereIn('category_type_id',$category_items)->where('org_id',Auth::user()->org_id)->get();
      $i=0;

      foreach($items as $item){
        $name[]=app()->getLocale() == 'ar'?$item->name:$item->name_en;
         $total_value=Decimalpoint(externalTrans::where('request_dt',date('Y-m-d'))->where('cat_id',$item->id)->where('org_id',Auth::user()->org_id)->where('reg_flag',1)->sum('quantity') + Transactions::where('date',date('Y-m-d'))->where('cat_id',$item->id)->where('org_id',Auth::user()->org_id)->whereNotNull('cust_id')->where('req_flag',1)->sum('quantity'));
         if($total_value!=0){
             $total[]=$total_value;
             $item->total=$total[$i];
         }


        $i++;
      }


	  $chart = new reportchart;

				$chart->title('My nice chart');
				$chart->labels($name);
        $chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى': 'Total', 'bar', $total)->color('#e6270c');



        return view('returnitemreport.index',compact('chart','items'));
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   }



  public function search_report(Request $request){
    $org_id = Auth::user()->org_id;
    $from = $request->report_date_from!=null?$request->report_date_from:date('Y-m-d');
    $cat_id = $request->search_name;
    $to = $request->report_date_to!=null?$request->report_date_to:date('Y-m-d');
    
    $name=[];
    $total=[];

    $customer_head = CustomerHead::when($org_id, function ($q) use ($org_id) {
        return $q->where('org_id' , $org_id);
    })

    ->when($from,function ($q) use ($from) {
        return $q->whereDate('date','>=' ,$from);
       
    })
    ->when($to,function ($q) use ($to) {
        return $q->whereDate('date' ,'<=' ,$to);
        
    })
->pluck('id');
$external_req = externalReq::when($org_id, function ($q) use ($org_id) {
    return $q->where('org_id' , $org_id);
})

->when($from,function ($q) use ($from) {
    return $q->whereDate('request_dt','>=' ,$from);
        
})
->when($to,function ($q) use ($to) {
    return $q->whereDate('request_dt' ,'<=' ,$to);
})
->pluck('id');
$category_items=CategoriesType::where('org_id',Auth::user()->org_id)->where('type',1)->where('active',1)->pluck('id');

if(!empty($cat_id)){
  $items=Category::where('id',$cat_id)->where('org_id',Auth::user()->org_id)->get();
}
else{
    $transaction_category= Transactions::whereIn('cust_req_id',$customer_head)->where('org_id',Auth::user()->org_id)->whereNotNull('cust_id')->where('req_flag',1)->pluck('cat_id');
    
      $external_trans_category=externalTrans::whereIn('external_req_id',$external_req)->where('org_id',Auth::user()->org_id)->where('reg_flag',1)->pluck('cat_id');
      
      
     $items_ids =$transaction_category->merge($external_trans_category);
    
      $items=Category::whereIn('id',$items_ids)->whereIn('category_type_id',$category_items)->where('org_id',Auth::user()->org_id)->get();
  

}
$i=0;
foreach($items as $item){
  $name[]=app()->getLocale() == 'ar'?$item->name:$item->name_en;

  $total[]=Decimalpoint(externalTrans::where('cat_id',$item->id)->whereIn('external_req_id',$external_req)->where('org_id',Auth::user()->org_id)->where('reg_flag',1)->sum('quantity') + Transactions::where('cat_id',$item->id)->whereIn('cust_req_id',$customer_head)->where('org_id',Auth::user()->org_id)->whereNotNull('cust_id')->where('req_flag',1)->sum('quantity'));
  $item->total=$total[$i];
  $i++;
}
$chart = new reportchart;

    $chart->title('My nice chart');
    $chart->labels($name);
    $chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى': 'Total', 'bar', $total)->color('#e6270c');

      return view('returnitemreport.index',compact('chart','items'));
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   }
    public function searchWithDetails(Request $request)
    {
      $org_id = Auth::user()->org_id;
      $from = $request->report_date_from!=null?$request->report_date_from:date('Y-m-d');
      $cat_id = $request->search_name;
      $to = $request->report_date_to!=null?$request->report_date_to:date('Y-m-d');
      $name=[];
      $total_quantity=[];
      $total_price=[];
      $category_items=CategoriesType::where('org_id',Auth::user()->org_id)->where('type',1)->where('active',1)->pluck('id');

      $customer_heads = CustomerHead::when($org_id, function ($q) use ($org_id) {
          return $q->where('org_id' , $org_id);
      })

      ->when($from,function ($q) use ($from) {
          
              return $q->whereDate('date','>=' ,$from);
       
        
      })
      ->when($to,function ($q) use ($to) {
        
              return $q->whereDate('date' ,'<=' ,$to);
         
        
      })
  ->get();
  $external_reqs = externalReq::when($org_id, function ($q) use ($org_id) {
      return $q->where('org_id' , $org_id);
  })

  ->when($from,function ($q) use ($from) {
      return $q->whereDate('request_dt','>=' ,$from);
          
  })
  ->when($to,function ($q) use ($to) {
        return $q->whereDate('request_dt' ,'<=' ,$to);
         })
  ->get();
  if(!empty($cat_id)){
    $items=Category::where('id',$cat_id)->where('org_id',Auth::user()->org_id)->pluck('id');
  }
  else{
      
      
    $items=Category::whereIn('category_type_id',$category_items)->where('org_id',Auth::user()->org_id)->pluck('id');
    

  }
  $all_requests=$customer_heads->merge($external_reqs);
 

  $total_value=0;
  $total_price_value=0;

  foreach($all_requests as $all_request){



  if($all_request->get_table_name()=="customer_req_head"){

    $item_id=Transactions::where('cust_req_id',$all_request->id)->where('org_id',Auth::user()->org_id)->whereIn('cat_id',$items)->whereNotNull('cust_id')->where('req_flag',1)->first();
   
    if($item_id!=null){
      $all_request->req_date=Dateformat($all_request->date);
      $all_request->req_id=$all_request->id;
      $all_request->req_invoice_no=$all_request->invoice_no;
      $all_request->req_type=app()->getLocale() == 'ar'?'داخلي':'internal';
      $all_request->cust_name=app()->getLocale() == 'ar'?Customers::where('id',$all_request->cust_id)->where('org_id',Auth::user()->org_id)->first()->name:Customers::where('id',$all_request->cust_id)->where('org_id',Auth::user()->org_id)->first()->name_en;
      $all_request->item_name=app()->getLocale() == 'ar'?Category::where('id',$item_id->cat_id)->where('org_id',Auth::user()->org_id)->first()->name:Category::where('id',$item_id->cat_id)->where('org_id',Auth::user()->org_id)->first()->name_en;
      $all_request->item_quantity=Decimalpoint($item_id->quantity);
      $all_request->item_price=Decimalplace($item_id->price);
    //   $name[]=$all_request->item_name;
    //   $total_quantity[]=Decimalpoint($item_id->quantity);
    //   $total_price[]=Decimalpoint($item_id->price);


    }
  }
  else{
    $item_id=externalTrans::where('external_req_id',$all_request->id)->where('org_id',Auth::user()->org_id)->whereIn('cat_id',$items)->whereNotNull('cust_id')->where('reg_flag',1)->first();
    if($item_id!=null){
      $all_request->req_date=Dateformat($all_request->date);
      $all_request->req_id=$all_request->id;
      $all_request->req_invoice_no=$all_request->invoice_no;
      $all_request->req_type=app()->getLocale() == 'ar'?'خارجي':'external';
      $all_request->cust_name=app()->getLocale() == 'ar'?Customers::where('id',$all_request->cust_id)->where('org_id',Auth::user()->org_id)->first()->name:Customers::where('id',$all_request->cust_id)->where('org_id',Auth::user()->org_id)->first()->name_en;
      $all_request->item_name=app()->getLocale() == 'ar'?Category::where('id',$item_id->cat_id)->where('org_id',Auth::user()->org_id)->first()->name:Category::where('id',$item_id->cat_id)->where('org_id',Auth::user()->org_id)->first()->name_en;
      $all_request->item_quantity=Decimalpoint($item_id->quantity);
      $all_request->item_price=Decimalplace($item_id->final_price);
    //   $name[]=$all_request->item_name;
    //   $total_quantity[]=Decimalpoint($item_id->quantity);
    //   $total_price[]=Decimalpoint($item_id->final_price);

    }

  }
  $total_value+=$all_request->item_quantity;
  $total_price_value+=$all_request->item_price;
  }
    $customer_heads = CustomerHead::when($org_id, function ($q) use ($org_id) {
          return $q->where('org_id' , $org_id);
      })

      ->when($from,function ($q) use ($from) {
          
        return $q->whereDate('date','>=' ,$from);
      })
      ->when($to,function ($q) use ($to) {
        return $q->whereDate('date' ,'<=' ,$to);
      })
  ->pluck('id');
  $external_reqs = externalReq::when($org_id, function ($q) use ($org_id) {
      return $q->where('org_id' , $org_id);
  })

  ->when($from,function ($q) use ($from) {
    return $q->whereDate('request_dt','>=' ,$from);
  })
  ->when($to,function ($q) use ($to) {
    return $q->whereDate('request_dt' ,'<=' ,$to);
  })
  ->pluck('id');
  if(!empty($cat_id)){
    $chart_items=Category::where('id',$cat_id)->where('org_id',Auth::user()->org_id)->get();
  }
  else{
      $transaction_category= Transactions::whereIn('cust_req_id',$customer_heads)->where('org_id',Auth::user()->org_id)->whereNotNull('cust_id')->where('req_flag',1)->pluck('cat_id');
    
      $external_trans_category=externalTrans::whereIn('external_req_id',$external_reqs)->where('org_id',Auth::user()->org_id)->where('reg_flag',1)->pluck('cat_id');
      
      
     $items_ids =$transaction_category->merge($external_trans_category);
      
    $chart_items=Category::whereIn('id',$items_ids)->whereIn('category_type_id',$category_items)->where('org_id',Auth::user()->org_id)->get();
   

  }
  
  
foreach($chart_items as $item){
  $name[]=app()->getLocale() == 'ar'?$item->name:$item->name_en;

  $total_quantity[]=Decimalpoint(externalTrans::where('cat_id',$item->id)->whereIn('external_req_id',$external_reqs)->where('org_id',Auth::user()->org_id)->where('reg_flag',1)->sum('quantity') + Transactions::where('cat_id',$item->id)->whereIn('cust_req_id',$customer_heads)->where('org_id',Auth::user()->org_id)->whereNotNull('cust_id')->where('req_flag',1)->sum('quantity'));
  $total_price[]=Decimalpoint(externalTrans::where('cat_id',$item->id)->whereIn('external_req_id',$external_reqs)->where('org_id',Auth::user()->org_id)->where('reg_flag',1)->sum('final_price') + Transactions::where('cat_id',$item->id)->whereIn('cust_req_id',$customer_heads)->where('org_id',Auth::user()->org_id)->whereNotNull('cust_id')->where('req_flag',1)->sum('price'));
  
}

		        $chart = new reportchart;
				$chart->title('My nice chart');
				$chart->labels($name);

		    $chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى': 'Total', 'bar', $total_quantity)->color('#e6270c');
        $chart->dataset(app()->getLocale() == 'ar' ? 'المدفوع': 'Paid', 'bar',$total_price)->color('#1dad1f');



       return view('returnitemreport.search',compact('chart','all_requests','total_value','total_price_value'));
    }





}

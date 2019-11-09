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
use Carbon\Carbon;
use App\Charts\reportchart;
use App\externalReq;
use App\externalTrans;
class CashController extends Controller
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
	    $date = Carbon::now()->format('Y-m-d');

	 $payments = PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id, 'pay_date' => $date  ])->groupBy('user_id')->get();
   $userss = User::where('org_id', Auth::user()->org_id)->get();
   $paids= [];
   foreach ($userss as  $value) {
      $value->has_external = 0;
      if(externalReq::where(['user_id' => $value->id,'request_dt' => $date])->exists()){
          $total_pay = 0;
         foreach (externalReq::where(['user_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
         foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
            $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
          }
          $value->extra_paid= Decimalpoint($total_pay);
          $paids []=   $value->extra_paid;
        }
        $value->has_external = 1;
      }
   }

        $requests=[];
		$name=[];


		// foreach( $payments as $v){
		// 	$total_paid =0;
		// 	foreach(PermissionReceivingPayments::where([ 'user_id' => $v->user_id,'org_id' => Auth::user()->org_id,'pay_date' => $date ])->get() as $tt){
		// 	 $total_paid += ($tt->pay_amount * $tt->pay_flag);
		// 	}
    //
		// 	 $v->request = Decimalpoint($total_paid)  ;
		// 	 $requests[] = $v->request  ;
		// 	 $name[] = app()->getLocale() == 'ar' ? User::findOrFail($v->user_id)->name : User::findOrFail($v->user_id)->name_en;
    //
		// }



    $userss = User::where('org_id', Auth::user()->org_id)->get();
    $paids= [];
    foreach ($userss as  $value) {
       $value->has_external = 0;
       $total_paid =0;
     	foreach(PermissionReceivingPayments::where([ 'user_id' => $value->id,'org_id' => Auth::user()->org_id,'pay_date' => $date ])->get() as $tt){
     	 $total_paid += ($tt->pay_amount * $tt->pay_flag);
     	}
       if(externalReq::where(['user_id' => $value->id,'request_dt' => $date])->exists()){
           $total_pay = 0;
          foreach (externalReq::where(['user_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
          foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
             $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
           }
           $value->extra_paid= Decimalpoint($total_pay);
           $paids []=   $value->extra_paid;
         }
         $value->has_external = 1;
       }

       $requests[] = Decimalpoint(abs($total_pay) + abs($total_paid) );
       $name[] = app()->getLocale() == 'ar' ? $value->name : $value->name_en;
    }


		$chart = new reportchart;
		$chart->title('My nice chart');
		$chart->labels($name);
		$chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى': 'Total', 'bar', $requests)->color('#e6270c');



        return view('reports.cash',compact('payments','chart','requests','paids','userss'));
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   }

   public function index_bank(){
	  $date = Carbon::now()->format('Y-m-d');
		$payments = PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id, 'pay_date' => $date   ])->groupBy('bank_treasur_id')->get();

    $banks = Banking::where('org_id', Auth::user()->org_id)->get();
    $paids= [];
    foreach ($banks as  $value) {
       $value->has_external = 0;
       if(externalReq::where(['bank_treasur_id' => $value->id,'request_dt' => $date])->exists()){
           $total_pay = 0;
          foreach (externalReq::where(['bank_treasur_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
          foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
             $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
           }
           $value->extra_paid= Decimalpoint($total_pay);
           $paids []=   $value->extra_paid;
         }
         $value->has_external = 1;
       }
    }


    $requests=[];
		$name=[];
    $banks = Banking::where('org_id', Auth::user()->org_id)->get();
    $paids= [];
    foreach ($banks as  $value) {
       $value->has_external = 0;
       $total_paid =0;
   			foreach(PermissionReceivingPayments::where([ 'bank_treasur_id' => $value->id,'org_id' => Auth::user()->org_id, 'pay_date' => $date ])->get() as $tt){
   			 $total_paid += ($tt->pay_amount * $tt->pay_flag);
   			}
       if(externalReq::where(['bank_treasur_id' => $value->id,'request_dt' => $date])->exists()){
           $total_pay = 0;
          foreach (externalReq::where(['bank_treasur_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
          foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
             $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
           }
           $value->extra_paid= Decimalpoint($total_pay);
           $paids []=   $value->extra_paid;
         }
         $value->has_external = 1;
       }


      	 $requests[] =Decimalpoint(abs($total_pay)+abs($total_paid))  ;
      	 $banks= $value->bank_treasur_id;

      	 if($banks ==0 ) $name[] = app()->getLocale() == 'ar' ? 'كرديت كارد' : 'crdit card';

      	else
      	$name[] = app()->getLocale() == 'ar' ? $value->name : $value->name_en;



    }


		$chart = new reportchart;

		$chart->title('My nice chart');
		$chart->labels($name);



		$chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى': 'Total', 'bar', $requests)->color('#e6270c');



        return view('reports.cash_bank',compact('payments','chart','requests','banks'));
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   }


    public function search_cash(Request $request){
	 $date_from = date('Y-m-d', strtotime($request->report_date_from));
     $date_to = date('Y-m-d', strtotime($request->report_date_to));
	   $date = Carbon::now()->format('Y-m-d');
	 if(empty($request->report_date_from) && empty($request->report_date_to)){
		if($request->user_name){
	$payments = PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'user_id'=>$request->user_name])->groupBy('user_id')->get();
    $userss = User::where('org_id', Auth::user()->org_id)->where('id',$request->user_name)->get();
    $paids= [];
    foreach ($userss as  $value) {
    $value->has_external = 0;
    if(externalReq::where(['user_id' => $value->id,'request_dt' => $date])->exists()){
        $total_pay = 0;
       foreach (externalReq::where(['user_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
        foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
          $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
        }
        $value->extra_paid= Decimalpoint($total_pay);
        $paids []=   $value->extra_paid;
      }
      $value->has_external = 1;
    }
 }

    }else{
 $payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->where('pay_date','=',$date)->groupBy('user_id')->get();
 $userss = User::where('org_id', Auth::user()->org_id)->get();
 $paids= [];
 foreach ($userss as  $value) {
   $value->has_external = 0;
   if(externalReq::where(['user_id' => $value->id,'request_dt' => $date])->exists()){
       $total_pay = 0;
      foreach (externalReq::where(['user_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
       foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
         $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
       }
       $value->extra_paid= Decimalpoint($total_pay);
       $paids []=   $value->extra_paid;
     }
     $value->has_external = 1;
   }

 }

    }
       }elseif(!empty($request->report_date_to) && !empty($request->report_date_from)){
		if($request->user_name){
$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('user_id','=',$request->user_name)->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->groupBy('user_id')->get();
$userss = User::where('org_id', Auth::user()->org_id)->where('id',$request->user_name)->get();
$paids= [];
foreach ($userss as  $value) {
  $value->has_external = 0;
  if(externalReq::where(['user_id' => $value->id])->where('request_dt','<=',$date_to)->where('request_dt','>=',$date_from)->exists()){
      $total_pay = 0;
     foreach (externalReq::where(['user_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
      foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid= Decimalpoint($total_pay);
      $paids []=   $value->extra_paid;
    }
    $value->has_external = 1;
  }
}

    }
		else{
 $payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->groupBy('user_id')->get();
 $userss = User::where('org_id', Auth::user()->org_id)->get();
$paids= [];
foreach ($userss as  $value) {
  $value->has_external = 0;
  if(externalReq::where(['user_id' => $value->id])->where('request_dt','<=',$date_to)->where('request_dt','>=',$date_from)->exists()){
      $total_pay = 0;
     foreach (externalReq::where(['user_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
      foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid= Decimalpoint($total_pay);
      $paids []=   $value->extra_paid;
    }
    $value->has_external = 1;
  }
}

		   }
	}
    elseif(!empty($request->report_date_from) && empty($request->report_date_to)) {
		if($request->user_name){

$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->Where('user_id','=',$request->user_name)->where('pay_date','>=',$request->report_date_from)->groupBy('user_id')->get();

$userss = User::where('org_id', Auth::user()->org_id)->where('id',$request->user_name)->get();
$paids= [];
foreach ($userss as  $value) {
  $value->has_external = 0;
  if(externalReq::where(['user_id' => $value->id])->where('request_dt','>=',$date_from)->exists()){
      $total_pay = 0;
     foreach (externalReq::where(['user_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
      foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid= Decimalpoint($total_pay);
      $paids []=   $value->extra_paid;
    }
    $value->has_external = 1;
  }
}
		}
		else{
$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->where('pay_date','>=',$request->report_date_from)->groupBy('user_id')->get();

$userss = User::where('org_id', Auth::user()->org_id)->get();
$paids= [];
foreach ($userss as  $value) {
  $value->has_external = 0;
  if(externalReq::where(['user_id' => $value->id])->where('request_dt','>=',$date_from)->exists()){
      $total_pay = 0;
     foreach (externalReq::where(['user_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
      foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid= Decimalpoint($total_pay);
      $paids []=   $value->extra_paid;
    }
    $value->has_external = 1;
  }
}

		 }
		   }
	elseif(empty($request->report_date_from) && !empty($request->report_date_to)) {
		if($request->user_name){
	$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->Where('user_id','=',$request->user_name)->where('pay_date','<=',$request->report_date_to)->groupBy('user_id')->get();
  $userss = User::where('org_id', Auth::user()->org_id)->where('id',$request->user_name)->get();
  $paids= [];
  foreach ($userss as  $value) {
    $value->has_external = 0;
    if(externalReq::where(['user_id' => $value->id])->where('request_dt','<=','report_date_to')->exists()){
        $total_pay = 0;
       foreach (externalReq::where(['user_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
        foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
          $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
        }
        $value->extra_paid= Decimalpoint($total_pay);
        $paids []=   $value->extra_paid;
      }
      $value->has_external = 1;
    }
  }
		}
		else{
	$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->where('pay_date','<=',$request->report_date_to)->groupBy('user_id')->get();
  $userss = User::where('org_id', Auth::user()->org_id)->get();
  $paids= [];
  foreach ($userss as  $value) {
    $value->has_external = 0;
    if(externalReq::where(['user_id' => $value->id])->where('request_dt','<=','report_date_to')->exists()){
        $total_pay = 0;
       foreach (externalReq::where(['user_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
        foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
          $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
        }
        $value->extra_paid= Decimalpoint($total_pay);
        $paids []=   $value->extra_paid;
      }
      $value->has_external = 1;
    }
  }
      }


        }
	else { $payments = PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->where('pay_date','=',$date)->groupBy('user_id')->get();
    $userss = User::where('org_id', Auth::user()->org_id)->get();
    $paids= [];
    foreach ($userss as  $value) {
      $value->has_external = 0;
      if(externalReq::where(['user_id' => $value->id])->where('request_dt','=',$date)->exists()){
          $total_pay = 0;
          foreach (externalReq::where(['user_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
          foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
            $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
          }
          $value->extra_paid= Decimalpoint($total_pay);
          $paids []=   $value->extra_paid;
        }
        $value->has_external = 1;
      }
    }
	   }

////////////////////////chart
		$requests=[];
		$name=[];

  $total_paid=[];
  $users = User::where('org_id', Auth::user()->org_id)->get();
  foreach ($users as $user) {
if(empty($request->report_date_to) && empty($request->report_date_from)){
  if($request->user_name){
  $internal_pay = PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'user_id'=>$request->user_name])->get();
    if(externalReq::where(['user_id' => $request->user_name])->exists()){
      $total_pay = 0;
      foreach (externalReq::where(['user_id' => $request->user_name,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
      foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid= Decimalpoint($total_pay);
      $paids []=   $value->extra_paid;
    }

  }else $paids=0;
  }else{
    $internal_pay = PermissionReceivingPayments::where(['user_id' => $user->user_id,'org_id' => Auth::user()->org_id,'pay_date' =>$date])->get();
    if(externalReq::where(['user_id' => $user->id,'request_dt'=>$date])->exists()){
        $total_pay = 0;
        foreach (externalReq::where(['user_id' => $user->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
        foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
          $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
        }
        $value->extra_paid= Decimalpoint($total_pay);
        $paids []=   $value->extra_paid;
      }

    }else $paids=0;

  }

}elseif (!empty($request->report_date_to) && !empty($request->report_date_from)) {
if($request->user_name){
 $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('user_id','=',$request->user_name)->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->get();
  if(externalReq::where(['user_id' => $request->user_name])->where('request_dt','<=',$date_to)->where('request_dt','>=',$date_from)->exists()){
     $total_pay = 0;
     foreach (externalReq::where(['user_id' => $request->user_name,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
     foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
       $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
     }
     $value->extra_paid= Decimalpoint($total_pay);
     $paids []=   $value->extra_paid;
   }

 }else $paids=0;




}else{
   $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('user_id','=',$user->id)->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->get();
  if(externalReq::where(['user_id' => $user->id])->where('request_dt','<=',$date_to)->where('request_dt','>=',$date_from)->exists()){
      $total_pay = 0;
      foreach (externalReq::where(['user_id' => $user->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $value2) {
      foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid= Decimalpoint($total_pay);
      $paids []=   $value->extra_paid;
    }

  }else $paids=0;

}



}elseif (!empty($request->report_date_to) && empty($request->report_date_from)){
if($request->user_name){
  $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('user_id','=',$request->user_name)->where('pay_date','<=',$date_to)->get();
  if(externalReq::where(['user_id' => $request->user_name])->where('request_dt','<=',$date_to)->exists()){
      $total_pay = 0;
      foreach (externalReq::where(['user_id' => $request->user_name,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
      foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid= Decimalpoint($total_pay);
      $paids []=   $value->extra_paid;
    }

  }else $paids=0;



}else{
  $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('user_id','=',$user->id)->where('pay_date','<=',$date_to)->get();
  if(externalReq::where(['user_id' => $user->id])->where('request_dt','<=',$date_to)->exists()){
      $total_pay = 0;
      foreach (externalReq::where(['user_id' => $user->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
      foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid= Decimalpoint($total_pay);
      $paids []=   $value->extra_paid;
    }

  }else $paids=0;



}
}elseif (empty($request->report_date_to) && !empty($request->report_date_from)){
if($request->user_name){
  $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('user_id','=',$request->user_name)->where('pay_date','>=',$date_from)->get();
  if(externalReq::where(['user_id' => $request->user_name])->where('request_dt','>=',$date_from)->exists()){
      $total_pay = 0;
      foreach (externalReq::where(['user_id' => $request->user_name,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
      foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid= Decimalpoint($total_pay);
      $paids []=   $value->extra_paid;
    }

  }else $paids=0;



}else{
  $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('user_id','=',$user->id)->where('pay_date','>=',$date_from)->get();
  if(externalReq::where(['user_id' => $user->id])->where('request_dt','>=',$date_from)->exists()){
      $total_pay = 0;
      foreach (externalReq::where(['user_id' => $user->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
      foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid= Decimalpoint($total_pay);
      $paids []=   $value->extra_paid;
    }

  }else $paids=0;





}



}
   $total_value =0;

	foreach($internal_pay  as $tt){
    $total_value+= ($tt->pay_amount * $tt->pay_flag);

			
           $total_paid[]= $total_value;
		   $requests[] = abs(Decimalpoint( abs($total_value)) + abs($value->extra_paid));
		   

		      $name[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;

}   if(empty($internal_pay)){
    
    		   $requests[] = abs($value->extra_paid);
		   
		      $name[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;

}

  }

  $total_internal=0;
  $i=0;

foreach($total_paid as  $value){
  $total_internal+=$value;

}



		 $chart = new reportchart;
		 $chart->title('My nice chart');
		 $chart->labels($name);
		 $chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى': 'Total', 'bar', $requests)->color('#e6270c');


        return view('reports.cash',compact('chart','payments','requests','userss','total_internal'));
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   }
    public function search_cash_bank(Request $request){

	$date_from = date('Y-m-d', strtotime($request->report_date_from));
	$date_to = date('Y-m-d', strtotime($request->report_date_to));
	$date = Carbon::now()->format('Y-m-d');
	if(empty($request->report_date_from) && empty($request->report_date_to)){
		if((!empty($request->bank_name) && $request->bank_name != -1)){
		$payments = PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'bank_treasur_id'=>$request->bank_name])->groupBy('bank_treasur_id')->get();
    $banks = Banking::where('org_id', Auth::user()->org_id)->Where('bank_treasur_id','=',$request->bank_name)->get();
    $paids= [];
    foreach ($banks as  $value) {
       $value->has_external = 0;
       if(externalReq::where(['bank_treasur_id' => $value->id])->exists()){
           $total_pay = 0;
          foreach (externalReq::where(['bank_treasur_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
          foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
             $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
           }
           $value->extra_paid= Decimalpoint($total_pay);
           $paids []=   $value->extra_paid;
         }
         $value->has_external = 1;
       }
    }
		}elseif(!empty($request->bank_name) && $request->bank_name == 0){
		$payments = PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'bank_treasur_id'=>$request->bank_name])->groupBy('bank_treasur_id')->get();
    $banks = Banking::where('org_id', Auth::user()->org_id)->Where('bank_treasur_id','=',$request->bank_name)->get();
    $paids= [];
    foreach ($banks as  $value) {
       $value->has_external = 0;
       if(externalReq::where(['bank_treasur_id' => $value->id])->exists()){
           $total_pay = 0;
          foreach (externalReq::where(['bank_treasur_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
          foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
             $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
           }
           $value->extra_paid= Decimalpoint($total_pay);
           $paids []=   $value->extra_paid;
         }
         $value->has_external = 1;
       }
    }
    }else{
	   $payments = PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'pay_date' => $date ])->groupBy('bank_treasur_id')->get();
     $banks = Banking::where('org_id', Auth::user()->org_id)->get();
     $paids= [];
     foreach ($banks as  $value) {
        $value->has_external = 0;
        if(externalReq::where(['bank_treasur_id' => $value->id,'request_dt' =>$date])->exists()){
            $total_pay = 0;
           foreach (externalReq::where(['bank_treasur_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
           foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
              $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
            }
            $value->extra_paid= Decimalpoint($total_pay);
            $paids []=   $value->extra_paid;
          }
          $value->has_external = 1;
        }
     }

    }
	}elseif(!empty($request->report_date_to) && !empty($request->report_date_from)){
		if(($request->bank_name && $request->bank_name!=-1) || $request->bank_name==0  ){
			$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$request->bank_name)->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->groupBy('bank_treasur_id')->get();
      $banks = Banking::where('org_id', Auth::user()->org_id)->Where('bank_treasur_id','=',$request->bank_name)->get();
      $paids= [];
      foreach ($banks as  $value) {
         $value->has_external = 0;
         if(externalReq::where(['bank_treasur_id' => $value->id])->where('request_dt','<=',$date_to)->where('request_dt','>=',$date_from)->exists()){
             $total_pay = 0;
            foreach (externalReq::where(['bank_treasur_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
            foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
               $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
             }
             $value->extra_paid= Decimalpoint($total_pay);
             $paids []=   $value->extra_paid;
           }
           $value->has_external = 1;
         }
      }


    }else{
			$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->groupBy('bank_treasur_id')->get();
      $banks = Banking::where('org_id', Auth::user()->org_id)->get();
      $paids= [];
      foreach ($banks as  $value) {
         $value->has_external = 0;
         if(externalReq::where(['bank_treasur_id' => $value->id])->where('request_dt','<=',$date_to)->where('request_dt','>=',$date_from)->exists()){
             $total_pay = 0;
            foreach (externalReq::where(['bank_treasur_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
            foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
                $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
             }
             $value->extra_paid= Decimalpoint($total_pay);
             $paids []=   $value->extra_paid;
           }
           $value->has_external = 1;
         }
      }


		}
	}elseif(!empty($request->report_date_from) && empty($request->report_date_to)) {
		if($request->bank_name || $request->bank_name==0){
			$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->Where('bank_treasur_id','=',$request->bank_name)->where('pay_date','>=',$request->report_date_from)->groupBy('bank_treasur_id')->get();
      $banks = Banking::where('org_id', Auth::user()->org_id)->Where('bank_treasur_id','=',$request->bank_name)->get();
      $paids= [];
      foreach ($banks as  $value) {
         $value->has_external = 0;
         if(externalReq::where(['bank_treasur_id' => $value->id])->where('request_dt','>=',$date_from)->exists()){
             $total_pay = 0;
            foreach (externalReq::where(['bank_treasur_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
            foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
               $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
             }
             $value->extra_paid= Decimalpoint($total_pay);
             $paids []=   $value->extra_paid;
           }
           $value->has_external = 1;
         }
      }

    }else{
			$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->where('pay_date','>=',$request->report_date_from)->groupBy('bank_treasur_id')->get();
      $banks = Banking::where('org_id', Auth::user()->org_id)->get();
      $paids= [];
      foreach ($banks as  $value) {
         $value->has_external = 0;
         if(externalReq::where(['bank_treasur_id' => $value->id])->where('request_dt','>=',$date_from)->exists()){
             $total_pay = 0;
            foreach (externalReq::where(['bank_treasur_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
            foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
               $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
             }
             $value->extra_paid= Decimalpoint($total_pay);
             $paids []=   $value->extra_paid;
           }
           $value->has_external = 1;
         }
      }


    }
	} elseif (empty($request->report_date_from) && !empty($request->report_date_to)) {
		if($request->bank_name || $request->bank_name==0){
			$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->Where('bank_treasur_id','=',$request->bank_name)->where('pay_date','<=',$request->report_date_to)->groupBy('bank_treasur_id')->get();
      $banks = Banking::where('org_id', Auth::user()->org_id)->Where('bank_treasur_id','=',$request->bank_name)->get();
      $paids= [];
      foreach ($banks as  $value) {
         $value->has_external = 0;
         if(externalReq::where(['bank_treasur_id' => $value->id])->where('request_dt','<=',$date_to)->exists()){
             $total_pay = 0;
            foreach (externalReq::where(['bank_treasur_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
            foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
               $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
             }
             $value->extra_paid= Decimalpoint($total_pay);
             $paids []=   $value->extra_paid;
           }
           $value->has_external = 1;
         }
      }

        }else{
			$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->where('pay_date','<=',$request->report_date_to)->groupBy('bank_treasur_id')->get();
      $banks = Banking::where('org_id', Auth::user()->org_id)->get();
      $paids= [];
      foreach ($banks as  $value) {
         $value->has_external = 0;
         if(externalReq::where(['bank_treasur_id' => $value->id])->where('request_dt','<=',$date_to)->exists()){
             $total_pay = 0;
            foreach (externalReq::where(['bank_treasur_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
            foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
               $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
             }
             $value->extra_paid= Decimalpoint($total_pay);
             $paids []=   $value->extra_paid;
           }
           $value->has_external = 1;
         }
      }

    }
	} else{
		$payments = PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id, 'pay_date' => $date ])->groupBy('bank_treasur_id')->get();
    $banks = Banking::where('org_id', Auth::user()->org_id)->get();
    $paids= [];
    foreach ($banks as  $value) {
       $value->has_external = 0;
       if(externalReq::where(['bank_treasur_id' => $value->id])->where('request_dt','=',$date)->exists()){
           $total_pay = 0;
          foreach (externalReq::where(['bank_treasur_id' => $value->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
          foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
             $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
           }
           $value->extra_paid= Decimalpoint($total_pay);
           $paids []=   $value->extra_paid;
         }
         $value->has_external = 1;
       }
    }


	}


  /////////////////////////////////////////////////////////chart
		$requests=[];
		$name=[];

    $total_paid=[];
    $all_banks = Banking::where('org_id', Auth::user()->org_id)->get();
    foreach ($all_banks as $value3) {
   if(empty($request->report_date_to) && empty($request->report_date_from)){
    if($request->bank_name && $request->bank_name != -1){
    $internal_pay = PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'bank_treasur_id'=>$request->bank_name])->get();
      if(externalReq::where(['bank_treasur_id' => $request->bank_name])->exists()){
        $total_pay = 0;
        foreach (externalReq::where(['bank_treasur_id' => $request->bank_name,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
        foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
          $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
        }
        $value->extra_paid= Decimalpoint($total_pay);
        $paids []=   $value->extra_paid;
      }

    }else $paids=0;
    }else{
      $internal_pay = PermissionReceivingPayments::where(['bank_treasur_id' => $value3->id,'org_id' => Auth::user()->org_id,'pay_date' =>$date])->get();
      if(externalReq::where(['bank_treasur_id' => $value3->id,'request_dt' =>$date])->exists()){
          $total_pay = 0;
          foreach (externalReq::where(['bank_treasur_id' => $value3->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
          foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
            $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
          }
          $value->extra_paid= Decimalpoint($total_pay);
          $paids []=   $value->extra_paid;
        }

      }else $paids=0;

    }

  }elseif (!empty($request->report_date_to) && !empty($request->report_date_from)) {
  if($request->bank_name && $request->bank_name != -1){
   $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$request->bank_name)->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->get();
    if(externalReq::where(['bank_treasur_id' => $request->bank_name])->where('request_dt','<=',$date_to)->where('request_dt','>=',$date_from)->exists()){
       $total_pay = 0;
       foreach (externalReq::where(['bank_treasur_id' => $request->bank_name,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
       foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
         $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
       }
       $value->extra_paid= Decimalpoint($total_pay);
       $paids []=   $value->extra_paid;
     }

   }else $paids=0;




  }else{
     $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$value3->id)->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->get();
    if(externalReq::where(['bank_treasur_id' => $value3->id])->where('request_dt','<=',$date_to)->where('request_dt','>=',$date_from)->exists()){
        $total_pay = 0;
        foreach (externalReq::where(['bank_treasur_id' => $value3->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
        foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
          $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
        }
        $value->extra_paid= Decimalpoint($total_pay);
        $paids []=   $value->extra_paid;
      }

    }else $paids=0;

  }



  }elseif (!empty($request->report_date_to) && empty($request->report_date_from)){
  if($request->bank_name && $request->bank_name != -1){
    $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$request->bank_name)->where('pay_date','<=',$date_to)->get();
    if(externalReq::where(['bank_treasur_id' => $request->bank_name])->where('request_dt','<=',$date_to)->exists()){
        $total_pay = 0;
        foreach (externalReq::where(['bank_treasur_id' => $request->bank_name,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
        foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
          $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
        }
        $value->extra_paid= Decimalpoint($total_pay);
        $paids []=   $value->extra_paid;
      }

    }else $paids=0;



  }else{
    $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$value3->id)->where('pay_date','<=',$date_to)->get();
    if(externalReq::where(['bank_treasur_id' => $value3->id])->where('request_dt','<=',$date_to)->exists()){
        $total_pay = 0;
        foreach (externalReq::where(['bank_treasur_id' => $value3->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
        foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
          $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
        }
        $value->extra_paid= Decimalpoint($total_pay);
        $paids []=   $value->extra_paid;
      }

    }else $paids=0;



  }
  }elseif (empty($request->report_date_to) && !empty($request->report_date_from)){
  if($request->bank_name && $request->bank_name != -1){
    $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$request->bank_name)->where('pay_date','>=',$date_from)->get();
    if(externalReq::where(['bank_treasur_id' => $request->bank_name])->where('request_dt','>=',$date_from)->exists()){
        $total_pay = 0;
        foreach (externalReq::where(['bank_treasur_id' => $request->bank_name,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
        foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
          $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
        }
        $value->extra_paid= Decimalpoint($total_pay);
        $paids []=   $value->extra_paid;
      }

    }else $paids=0;



  }else{
    $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$value3->id)->where('pay_date','>=',$date_from)->get();
    if(externalReq::where(['bank_treasur_id' => $value3->id])->where('request_dt','>=',$date_from)->exists()){
        $total_pay = 0;
        foreach (externalReq::where(['bank_treasur_id' => $value3->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
        foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
          $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
        }
        $value->extra_paid= Decimalpoint($total_pay);
        $paids []=   $value->extra_paid;
      }

    }else $paids=0;





  }



  }
     $total_value =0;
    foreach($internal_pay  as $tt){
      $total_value+= ($tt->pay_amount * $tt->pay_flag);

        

       $total_paid[]= $total_value;
       $requests[] = abs(Decimalpoint( abs($total_value)) + abs($value->extra_paid));

       $name[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;

}
        if(empty($internal_pay)){
    
    		   $requests[] = abs($value->extra_paid);
		   
		      $name[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;

}

    }

    $total_internal=0;
    $i=0;
  foreach($total_paid as $key=> $value){
    $total_internal+=$value;

  }


       $chart = new reportchart;
       $chart->title('My nice chart');
       $chart->labels($name);
       $chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى': 'Total', 'bar', $requests)->color('#e6270c');


//return $total_internal;



        return view('reports.cash_bank',compact('chart','payments','requests','banks','total_internal'));
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   }

    public function search_cash_WithDetails(Request $request){
		    $date_from = date('Y-m-d', strtotime($request->report_date_from));
        $date_to = date('Y-m-d', strtotime($request->report_date_to));
	      $date = Carbon::now()->format('Y-m-d');
	 if(empty($request->report_date_from) && empty($request->report_date_to)){
		if($request->user_name){
	$payments = PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'user_id'=>$request->user_name  ])->groupBy('user_id')->get();
  $users2=User::where(['org_id' => Auth::user()->org_id, 'id'=> $request->user_name])->get();
  $paids = [];
  foreach($users2 as $user){
  if(externalReq::where(['user_id' => $user->id ,'request_dt' => $date])->exists()){
    $user->test=0;

    foreach ($user->deails=externalReq::where(['user_id' => $user->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
      $total_pay=0;
      foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid1= Decimalpoint($total_pay);
      $paids []=   $user->extra_paid1;
    }

  }
else  $user->test=1;
  }
  	}else{
 $payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->where('pay_date','=',$date)->groupBy('user_id')->get();
 $users2=User::where(['org_id' => Auth::user()->org_id])->get();
 $paids = [];
 foreach($users2 as $user){
 if(externalReq::where(['user_id' => $user->id ,'request_dt' => $date])->exists()){
   $user->test=0;
   foreach ($user->deails=externalReq::where(['user_id' => $user->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
      $total_pay=0;
     foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
       $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
     }
     $value->extra_paid1= Decimalpoint($total_pay);
     $paids []=   $user->extra_paid1;
   }

 }
 else  $user->test=1;
 }
		}
  }elseif(!empty($request->report_date_to) && !empty($request->report_date_from)){
		if($request->user_name){
$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('user_id','=',$request->user_name)->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->groupBy('user_id')->get();
$users2=User::where(['org_id' => Auth::user()->org_id,'id' =>$request->user_name   ])->get();
$paids = [];
foreach($users2 as $user){
if(externalReq::where(['user_id' => $user->id])->where('request_dt','>=',$request->report_date_from)->where('request_dt','<=',$request->report_date_to)->exists()){
  $user->test=0;

  foreach ($user->deails=externalReq::where(['user_id' => $user->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
    $total_pay=0;
    foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
      $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
    }
    $value->extra_paid1= Decimalpoint($total_pay);
    $paids []=   $user->extra_paid1;
  }

}
else  $user->test=1;
}

    }
		else{

	$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->groupBy('user_id')->get();
  $users2=User::where(['org_id' => Auth::user()->org_id])->get();
  $paids = [];
  foreach($users2 as $user){
  if(externalReq::where(['user_id' => $user->id])->where('request_dt','>=',$request->report_date_from)->where('request_dt','<=',$request->report_date_to)->exists()){
     $user->test=0;
     $user->deails=externalReq::where(['user_id' => $user->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get();

      foreach ($user->deails as $value){
      $total_pay=0;
      foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
      $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;

      }

      $value->extra_paid1= Decimalpoint($total_pay);
      $paids []=   $user->extra_paid1;

    }

  }
    else  $user->test=1;
  }


		   }

	}
    elseif(!empty($request->report_date_from) && empty($request->report_date_to)) {
		if($request->user_name){

$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->Where('user_id','=',$request->user_name)->where('pay_date','>=',$request->report_date_from)->groupBy('user_id')->get();
$users2=User::where(['org_id' => Auth::user()->org_id,'id' =>$request->user_name   ])->get();
$paids = [];
foreach($users2 as $user){
if(externalReq::where(['user_id' => $user->id])->where('request_dt','>=',$request->report_date_from)->exists()){
  $user->test=0;
  foreach ($user->deails=externalReq::where(['user_id' => $user->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
    $total_pay=0;
    foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
      $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
    }
    $value->extra_paid1= Decimalpoint($total_pay);
    $paids []=   $user->extra_paid1;
  }

}
else  $user->test=1;
}

		}
		else{
$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->where('pay_date','>=',$request->report_date_from)->groupBy('user_id')->get();
$users2=User::where(['org_id' => Auth::user()->org_id])->get();
$paids = [];
foreach($users2 as $user){
if(externalReq::where(['user_id' => $user->id])->where('request_dt','>=',$request->report_date_from)->exists()){
  $user->test=0;
  foreach ($user->deails=externalReq::where(['user_id' => $user->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
   $total_pay=0;
    foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
      $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
    }
    $value->extra_paid1= Decimalpoint($total_pay);
    $paids []=   $user->extra_paid1;
  }

}
else  $user->test=1;
}
		 }
		   }
	elseif (empty($request->report_date_from) && !empty($request->report_date_to)) {
		if($request->user_name){
	$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->Where('user_id','=',$request->user_name)->where('pay_date','<=',$request->report_date_to)->groupBy('user_id')->get();
  $users2=User::where(['org_id' => Auth::user()->org_id,'id' =>$request->user_name   ])->get();
  $paids = [];
  foreach($users2 as $user){
  if(externalReq::where(['user_id' => $user->id])->where('request_dt','<=',$request->report_date_to)->exists()){
    $user->test=0;
    foreach ($user->deails=externalReq::where(['user_id' => $user->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
      $total_pay=0;
      foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid1= Decimalpoint($total_pay);
      $paids []=   $user->extra_paid1;
    }

  }else {
    $user->test=1;
  }
  }

		}
		else{
	$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->where('pay_date','<=',$request->report_date_to)->groupBy('user_id')->get();
  $users2=User::where(['org_id' => Auth::user()->org_id])->get();
  $paids = [];
  foreach($users2 as $user){
  if(externalReq::where(['user_id' => $user->id])->where('request_dt','<=',$request->report_date_to)->exists()){
    $user->test=0;
    foreach ($user->deails=externalReq::where(['user_id' => $user->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
    $total_pay=0;
    foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid1= Decimalpoint($total_pay);
      $paids []=   $user->extra_paid1;
    }

  }
  else  $user->test=1;
  }
      }


        }
//////////////////////////////////////////////////////////chart
		$requests=[];
		$name=[];
    $total_paid=[];
    $users = User::where('org_id', Auth::user()->org_id)->get();
    foreach ($users as $user) {
  if(empty($request->report_date_to) && empty($request->report_date_from)){
    if($request->user_name){
    $internal_pay = PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'user_id'=>$request->user_name])->get();
      if(externalReq::where(['user_id' => $request->user_name])->exists()){
        $total_pay = 0;
        foreach (externalReq::where(['user_id' => $request->user_name,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
        foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
          $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
        }
        $value->extra_paid= Decimalpoint($total_pay);
        $paids []=   $value->extra_paid;
      }

    }else $paids=0;
    }else{
      $internal_pay = PermissionReceivingPayments::where(['user_id' => $user->user_id,'org_id' => Auth::user()->org_id,'pay_date' =>$date])->get();
      if(externalReq::where(['user_id' => $user->user_id,'request_dt' =>$date])->exists()){
          $total_pay = 0;
          foreach (externalReq::where(['user_id' => $user->user_id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
          foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
            $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
          }
          $value->extra_paid= Decimalpoint($total_pay);
          $paids []=   $value->extra_paid;
        }

      }else $paids=0;

    }

  }elseif (!empty($request->report_date_to) && !empty($request->report_date_from)) {
  if($request->user_name){
   $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('user_id','=',$request->user_name)->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->get();
    if(externalReq::where(['user_id' => $request->user_name])->where('request_dt','<=',$date_to)->where('request_dt','>=',$date_from)->exists()){
       $total_pay = 0;
       foreach (externalReq::where(['user_id' => $request->user_name,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
       foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
         $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
       }
       $value->extra_paid= Decimalpoint($total_pay);
       $paids []=   $value->extra_paid;
     }

   }else $paids=0;




  }else{
     $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('user_id','=',$user->id)->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->get();
    if(externalReq::where(['user_id' => $user->id])->where('request_dt','<=',$date_to)->where('request_dt','>=',$date_from)->exists()){
        $total_pay = 0;
        foreach (externalReq::where(['user_id' => $user->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
        foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
          $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
        }
        $value->extra_paid= Decimalpoint($total_pay);
        $paids []=   $value->extra_paid;
      }

    }else $paids=0;

  }



  }elseif (!empty($request->report_date_to) && empty($request->report_date_from)){
  if($request->user_name){
    $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('user_id','=',$request->user_name)->where('pay_date','<=',$date_to)->get();
    if(externalReq::where(['user_id' => $request->user_name])->where('request_dt','<=',$date_to)->exists()){
        $total_pay = 0;
        foreach (externalReq::where(['user_id' => $request->user_name,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
        foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
          $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
        }
        $value->extra_paid= Decimalpoint($total_pay);
        $paids []=   $value->extra_paid;
      }

    }else $paids=0;



  }else{
    $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('user_id','=',$user->id)->where('pay_date','<=',$date_to)->get();
    if(externalReq::where(['user_id' => $user->id])->where('request_dt','<=',$date_to)->exists()){
        $total_pay = 0;
        foreach (externalReq::where(['user_id' => $user->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
        foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
          $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
        }
        $value->extra_paid= Decimalpoint($total_pay);
        $paids []=   $value->extra_paid;
      }

    }else $paids=0;



  }
  }elseif (empty($request->report_date_to) && !empty($request->report_date_from)){
  if($request->user_name){
    $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('user_id','=',$request->user_name)->where('pay_date','>=',$date_from)->get();
    if(externalReq::where(['user_id' => $request->user_name])->where('request_dt','>=',$date_from)->exists()){
        $total_pay = 0;
        foreach (externalReq::where(['user_id' => $request->user_name,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
        foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
          $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
        }
        $value->extra_paid= Decimalpoint($total_pay);
        $paids []=   $value->extra_paid;
      }

    }else $paids=0;



  }else{
    $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('user_id','=',$user->id)->where('pay_date','>=',$date_from)->get();
    if(externalReq::where(['user_id' => $user->id])->where('request_dt','>=',$date_from)->exists()){
        $total_pay = 0;
        foreach (externalReq::where(['user_id' => $user->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
        foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
          $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
        }
        $value->extra_paid= Decimalpoint($total_pay);
        $paids []=   $value->extra_paid;
      }

    }else $paids=0;

  }



  }
     $total_value =0;
  	foreach($internal_pay  as $tt){
      $total_value+= ($tt->pay_amount * $tt->pay_flag);

  			
       $total_paid[]= $total_value;
  		 $requests[] = abs(Decimalpoint( abs($total_value)) + abs($value->extra_paid));
  		 $name[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
}
            if(empty($internal_pay)){
    
    		   $requests[] = abs($value->extra_paid);
		   
		      $name[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;

}


    }

    $total_internal=0;
    $i=0;

  foreach($total_paid as $key=> $value){
    $total_internal+=$value;

  }




  		 $chart = new reportchart;
  		 $chart->title('My nice chart');
  		 $chart->labels($name);
  		 $chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى': 'Total', 'bar', $requests)->color('#e6270c');

        return view('reports.cashdetails',compact('chart','payments','requests','users2'));
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   }
  public function search_bank_WithDetails(Request $request){
		     $date_from = date('Y-m-d', strtotime($request->report_date_from));
         $date_to = date('Y-m-d', strtotime($request->report_date_to));
	       $date = Carbon::now()->format('Y-m-d');
	 if(empty($request->report_date_from) && empty($request->report_date_to)){
		if($request->bank_name && $request->bank_name!=-1 ){

$payments = PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'bank_treasur_id'=>$request->bank_name])->groupBy('bank_treasur_id')->get();
$allbanks=Banking::where(['org_id' => Auth::user()->org_id, 'id'=> $request->bank_name])->get();
$paids = [];
foreach($allbanks as $bank){
if(externalReq::where(['bank_treasur_id' => $bank->id ,'request_dt' => $date])->exists()){
  $bank->test=0;
  foreach ($bank->deails=externalReq::where(['bank_treasur_id' => $bank->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
    $total_pay=0;
    foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
      $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
    }
    $value->extra_paid= Decimalpoint($total_pay);
    $paids []=   $user->extra_paid;
  }

}
else  $user->test=1;
}



}elseif($request->bank_name && $request->bank_name==0){
	$payments = PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'bank_treasur_id'=>$request->bank_name])->groupBy('bank_treasur_id')->get();
  $allbanks=Banking::where(['org_id' => Auth::user()->org_id, 'id'=> $request->bank_name])->get();
  $paids = [];
  foreach($allbanks as $bank){
  if(externalReq::where(['bank_treasur_id' => $bank->id ,'request_dt' => $date])->exists()){
    $bank->test=0;
    foreach ($bank->deails=externalReq::where(['bank_treasur_id' => $bank->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
      $total_pay=0;
      foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid= Decimalpoint($total_pay);
      $paids []=   $user->extra_paid;
    }

  }
  else  $user->test=1;
  }

}
		else{
 $payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id, 'pay_date' =>$date ])->groupBy('bank_treasur_id')->get();
 $allbanks=Banking::where(['org_id' => Auth::user()->org_id])->get();
 $paids = [];
 foreach($allbanks as $bank){
 if(externalReq::where(['bank_treasur_id' => $bank->id ,'request_dt' => $date])->exists()){
   $bank->test=0;
   foreach ($bank->deails=externalReq::where(['bank_treasur_id' => $bank->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
     $total_pay=0;
     foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
       $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
     }
     $value->extra_paid= Decimalpoint($total_pay);
     $paids []=   $user->extra_paid;
   }

 }
 else  $user->test=1;
 }


    }
       }elseif(!empty($request->report_date_to) && !empty($request->report_date_from)){
		if($request->bank_name && $request->bank_name!=-1 ){
$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$request->bank_name)->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->groupBy('bank_treasur_id')->get();
$allbanks=Banking::where(['org_id' => Auth::user()->org_id, 'id'=> $request->bank_name])->get();
$paids = [];
foreach($allbanks as $bank){
if(externalReq::where(['bank_treasur_id' => $bank->id])->where('request_dt','<=',$date_to)->where('request_dt','>=',$date_from)->exists()){
  $bank->test=0;
  foreach ($bank->deails=externalReq::where(['bank_treasur_id' => $bank->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
    $total_pay=0;
    foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
      $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
    }
    $value->extra_paid= Decimalpoint($total_pay);
    $paids []=   $user->extra_paid;
  }

}
else  $user->test=1;
}


}elseif($request->bank_name && $request->bank_name==0){
	$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$request->bank_name)->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->groupBy('bank_treasur_id')->get();
  $allbanks=Banking::where(['org_id' => Auth::user()->org_id, 'id'=> $request->bank_name])->get();
  $paids = [];
  foreach($allbanks as $bank){
  if(externalReq::where(['bank_treasur_id' => $bank->id])->where('request_dt','<=',$date_to)->where('request_dt','>=',$date_from)->exists()){
    $bank->test=0;
    foreach ($bank->deails=externalReq::where(['bank_treasur_id' => $bank->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
      $total_pay=0;
      foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid= Decimalpoint($total_pay);
      $paids []=   $user->extra_paid;
    }

  }
  else  $user->test=1;
  }


}
		else{

	$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->groupBy('bank_treasur_id')->get();
  $allbanks=Banking::where(['org_id' => Auth::user()->org_id])->get();
  $paids = [];
  foreach($allbanks as $bank){
  //  return externalReq::where(['bank_treasur_id' => $bank->id])->where('request_dt','<=',$date_to)->where('request_dt','>=',$date_from)->get();
  if(externalReq::where(['bank_treasur_id' => $bank->id])->where('request_dt','<=',$date_to)->where('request_dt','>=',$date_from)->exists()){
    $bank->test=0;
    foreach ($bank->deails=externalReq::where(['bank_treasur_id' => $bank->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
      $total_pay=0;
      foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid= Decimalpoint($total_pay);
      $paids []=   $user->extra_paid;
    }

  }
  else  $user->test=1;
  }
		   }


	}
    elseif(!empty($request->report_date_from) && empty($request->report_date_to)) {
		if($request->bank_name || $request->bank_name==0){

$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->Where('bank_treasur_id','=',$request->bank_name)->where('pay_date','>=',$request->report_date_from)->groupBy('bank_treasur_id')->get();
$allbanks=Banking::where(['org_id' => Auth::user()->org_id, 'id'=> $request->bank_name])->get();
$paids = [];
foreach($allbanks as $bank){
if(externalReq::where(['bank_treasur_id' => $bank->id])->where('request_dt','>=',$date_from)->exists()){
  $bank->test=0;
  foreach ($bank->deails=externalReq::where(['bank_treasur_id' => $bank->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
    $total_pay=0;
    foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
      $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
    }
    $value->extra_paid= Decimalpoint($total_pay);
    $paids []=   $user->extra_paid;
  }

}
else  $user->test=1;
}
		}
		else{
$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->where('pay_date','>=',$request->report_date_from)->groupBy('bank_treasur_id')->get();

$allbanks=Banking::where(['org_id' => Auth::user()->org_id])->get();
$paids = [];
foreach($allbanks as $bank){
if(externalReq::where(['bank_treasur_id' => $bank->id])->where('request_dt','>=',$date_from)->exists()){
  $bank->test=0;
  foreach ($bank->deails=externalReq::where(['bank_treasur_id' => $bank->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
    $total_pay=0;
    foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
      $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
    }
    $value->extra_paid= Decimalpoint($total_pay);
    $paids []=   $user->extra_paid;
  }

}
else  $user->test=1;
}
		 }
		   }
	elseif (empty($request->report_date_from) && !empty($request->report_date_to)) {
		if($request->bank_name || $request->bank_name==0){
	$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->Where('bank_treasur_id','=',$request->bank_name)->where('pay_date','<=',$request->report_date_to)->groupBy('bank_treasur_id')->get();
  $allbanks=Banking::where(['org_id' => Auth::user()->org_id, 'id'=> $request->bank_name])->get();
  $paids = [];
  foreach($allbanks as $bank){
  if(externalReq::where(['bank_treasur_id' => $bank->id])->where('request_dt','<=',$date_to)->exists()){
    $bank->test=0;
    foreach ($bank->deails=externalReq::where(['bank_treasur_id' => $bank->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
      $total_pay=0;
      foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid= Decimalpoint($total_pay);
      $paids []=   $user->extra_paid;
    }

  }
  else  $user->test=1;
  }
		}
		else{
	$payments=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->where('pay_date','<=',$request->report_date_to)->groupBy('bank_treasur_id')->get();
  $allbanks=Banking::where(['org_id' => Auth::user()->org_id])->get();
  $paids = [];
  foreach($allbanks as $bank){
  if(externalReq::where(['bank_treasur_id' => $bank->id])->where('request_dt','<=',$date_to)->exists()){
    $bank->test=0;
    foreach ($bank->deails=externalReq::where(['bank_treasur_id' => $bank->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
      $total_pay=0;
      foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value->extra_paid= Decimalpoint($total_pay);
      $paids []=   $user->extra_paid;
    }

  }
  else  $user->test=1;
  }
      }


        }
	   else {
$payments = PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id, 'pay_date' => $date ])->groupBy('bank_treasur_id')->get();
$allbanks=Banking::where(['org_id' => Auth::user()->org_id])->get();
$paids = [];
foreach($allbanks as $bank){
if(externalReq::where(['bank_treasur_id' => $bank->id])->where('request_dt','=',$date)->exists()){
  $bank->test=0;
  foreach ($bank->deails=externalReq::where(['bank_treasur_id' => $bank->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'])->get() as $value){
    $total_pay=0;
    foreach (externalTrans::where('external_req_id',$value->id)->get() as  $extranal_pay_detail) {
      $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
    }
    $value->extra_paid= Decimalpoint($total_pay);
    $paids []=   $user->extra_paid;
  }

}
else  $user->test=1;
}
 }

 //////////////////////////////////////// chart
		$requests=[];
		$name=[];

// 	foreach($payments as $v){
//
// if(!empty($request->report_date_to) && !empty($request->report_date_from)){
// 		if(($request->bank_name && $request->bank_name!=-1)) {
//
// $test=PermissionReceivingPayments::where(['bank_treasur_id' => $v->bank_treasur_id,'org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$request->bank_name)->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->get();
// 		}elseif($request->bank_name && $request->bank_name ==0)
// 		$test=PermissionReceivingPayments::where(['bank_treasur_id' => $v->bank_treasur_id,'org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$request->bank_name)->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->get();
//
// 		else{
// 	$test=PermissionReceivingPayments::where(['bank_treasur_id' => $v->bank_treasur_id,'org_id' => Auth::user()->org_id ])->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->get();
//
// 		   }
// 	}elseif(empty($request->report_date_from) && empty($request->report_date_to)){
// 		if(($request->bank_name && $request->bank_name!=-1 )){
//
// 	$test = PermissionReceivingPayments::where(['bank_treasur_id' => $v->bank_treasur_id,'org_id' => Auth::user()->org_id,'bank_treasur_id'=>$request->bank_name  ])->get();
// 		}elseif($request->bank_name && $request->bank_name ==0)
// 	$test = PermissionReceivingPayments::where(['bank_treasur_id' => $v->bank_treasur_id,'org_id' => Auth::user()->org_id,'bank_treasur_id'=>$request->bank_name  ])->get();
//
// 		else{
//
//  $test=PermissionReceivingPayments::where(['bank_treasur_id' => $v->bank_treasur_id,'org_id' => Auth::user()->org_id , 'pay_date' => $date ])->get();
//
// 		}
//        }
//
// 	$total_paid =0;
// 	foreach($test  as $tt){
// 		$total_paid += ($tt->pay_amount * $tt->pay_flag);
// 			}
//
// 		 $v->request = Decimalpoint($total_paid)  ;
// 		 $requests[] =Decimalpoint( $v->request ) ;
//         $banks= $v->bank_treasur_id;
//
// 		if($banks ==0 ) $name[] = app()->getLocale() == 'ar' ? 'كرديت كارد' : 'crdit card';
//
// 			else
// 		 $name[] = app()->getLocale() == 'ar' ? Banking::findOrFail($v->bank_treasur_id)->name : Banking::findOrFail($v->bank_treasur_id)->name_en;
// 		}

$total_paid=[];
$all_banks1 = Banking::where('org_id', Auth::user()->org_id)->get();
foreach ($all_banks1 as $value3) {
if(empty($request->report_date_to) && empty($request->report_date_from)){
if($request->bank_name && $request->bank_name != -1){
$internal_pay = PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'bank_treasur_id'=>$request->bank_name])->get();
  if(externalReq::where(['bank_treasur_id' => $request->bank_name])->exists()){
    $total_pay = 0;
    foreach (externalReq::where(['bank_treasur_id' => $request->bank_name,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
    foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
      $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
    }
    $value2->extra_paid= Decimalpoint($total_pay);
    $paids []=   $value->extra_paid;
  }

}else $paids=0;
}else{
  $internal_pay = PermissionReceivingPayments::where(['bank_treasur_id' => $value3->id,'org_id' => Auth::user()->org_id,'pay_date' =>$date])->get();
  if(externalReq::where(['bank_treasur_id' => $value3->id,'request_dt' =>$date])->exists()){
      $total_pay = 0;
      foreach (externalReq::where(['bank_treasur_id' => $value3->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
      foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
        $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
      }
      $value2->extra_paid= Decimalpoint($total_pay);
      $paids []=   $value->extra_paid;
    }

  }else $paids=0;

}

}elseif (!empty($request->report_date_to) && !empty($request->report_date_from)) {
if($request->bank_name && $request->bank_name != -1){
$internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$request->bank_name)->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->get();
if(externalReq::where(['bank_treasur_id' => $request->bank_name])->where('request_dt','<=',$date_to)->where('request_dt','>=',$date_from)->exists()){
   $total_pay = 0;
   foreach (externalReq::where(['bank_treasur_id' => $request->bank_name,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
   foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
     $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
   }
   $value2->extra_paid= Decimalpoint($total_pay);
   $paids []=   $value->extra_paid;
 }

}else $paids=0;




}else{
 $internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$value3->id)->where('pay_date','<=',$date_to)->where('pay_date','>=',$date_from)->get();
if(externalReq::where(['bank_treasur_id' => $value3->id])->where('request_dt','<=',$date_to)->where('request_dt','>=',$date_from)->exists()){
    $total_pay = 0;
    foreach (externalReq::where(['bank_treasur_id' => $value3->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
    foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
      $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
    }
    $value2->extra_paid= Decimalpoint($total_pay);
    $paids []=   $value->extra_paid;
  }

}else $paids=0;

}



}elseif (!empty($request->report_date_to) && empty($request->report_date_from)){
if($request->bank_name && $request->bank_name != -1){
$internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$request->bank_name)->where('pay_date','<=',$date_to)->get();
if(externalReq::where(['bank_treasur_id' => $request->bank_name])->where('request_dt','<=',$date_to)->exists()){
    $total_pay = 0;
    foreach (externalReq::where(['bank_treasur_id' => $request->bank_name,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
    foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
      $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
    }
    $value->extra_paid= Decimalpoint($total_pay);
    $paids []=   $value->extra_paid;
  }

}else $paids=0;



}else{
$internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$value3->id)->where('pay_date','<=',$date_to)->get();
if(externalReq::where(['bank_treasur_id' => $value3->id])->where('request_dt','<=',$date_to)->exists()){
    $total_pay = 0;
    foreach (externalReq::where(['bank_treasur_id' => $value3->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
    foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
      $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
    }
    $value2->extra_paid= Decimalpoint($total_pay);
    $paids []=   $value->extra_paid;
  }

}else $paids=0;



}
}elseif (empty($request->report_date_to) && !empty($request->report_date_from)){
if($request->bank_name && $request->bank_name != -1){
$internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$request->bank_name)->where('pay_date','>=',$date_from)->get();
if(externalReq::where(['bank_treasur_id' => $request->bank_name])->where('request_dt','>=',$date_from)->exists()){
    $total_pay = 0;
    foreach (externalReq::where(['bank_treasur_id' => $request->bank_name,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
    foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
      $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
    }
    $value2->extra_paid= Decimalpoint($total_pay);
    $paids []=   $value->extra_paid;
  }

}else $paids=0;



}else{
$internal_pay=PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->Where('bank_treasur_id','=',$value3->id)->where('pay_date','>=',$date_from)->get();
if(externalReq::where(['bank_treasur_id' => $value3->id])->where('request_dt','>=',$date_from)->exists()){
    $total_pay = 0;
    foreach (externalReq::where(['bank_treasur_id' => $value3->id,'org_id' => Auth::user()->org_id,'confirm'=>'d','pay_gateway'=>'1'  ])->get() as $key => $value2) {
    foreach ($extranal_pay_details = externalTrans::where('external_req_id',$value2->id)->get() as  $extranal_pay_detail) {
      $total_pay += $extranal_pay_detail->quantity * $extranal_pay_detail->final_price *  $extranal_pay_detail->reg_flag;
    }
    $value2->extra_paid= Decimalpoint($total_pay);
    $paids []=   $value->extra_paid;
  }

}else $paids=0;





}



}
 $total_value =0;
foreach($internal_pay  as $tt){
  $total_value+= ($tt->pay_amount * $tt->pay_flag);

    

   $total_paid[]= $total_value;
   $requests[] = abs(Decimalpoint( abs($total_value)) + abs($value2->extra_paid));

   $name[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
   

}
                 if(empty($internal_pay)){
    
    		   $requests[] = abs($value2->extra_paid);
		   
		      $name[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;

}

}

$total_internal=0;
$i=0;
foreach($total_paid as $key=> $value){
$total_internal+=$value;

}










		 $chart = new reportchart;

		 $chart->title('My nice chart');
		 $chart->labels($name);
		 $chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى': 'Total', 'bar', $requests)->color('#e6270c');



        return view('reports.bankdetails',compact('chart','payments','requests','allbanks'));
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   }









}

<?php


namespace App\Http\Controllers;
use App\CategoriesType;
use App\Category;
use App\PropertySilder;
use App\FacilityList;
use App\CategoryDetails;
use App\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use Session;
use App\propertyPaymethod;
use App\property_policy;

class property_pay_methodControllers extends Controller
{
    public function index()
    {
          if(permissions('show_property_pay') == false){

          //set session message
          Session::flash('message', __('strings.do_not_have_permission'));
          return view('permissions');
      }
          $org_id = Auth()->user()->org_id;
          $propertys=Property::join('property_payment_setup','property.id','=','property_payment_setup.property_id')
            ->select('property.*','gateway','default')
            ->where('property.org_id','=',$org_id)
            ->where('property_payment_setup.default','=',1)
            ->get();

        return view('hotel_payment.index')->with('propertys', $propertys);
    }




    public function edit($id)
    {
        
        if(permissions('edit_property_pay') == false){

          //set session message
          Session::flash('message', __('strings.do_not_have_permission'));
          return view('permissions');
      }
          $property = Property::find($id);
          $paymethods = propertyPaymethod::where(['org_id'=>Auth()->user()->org_id,'property_id'=>$id])->get();
            return view('hotel_payment.edit')
                ->with('property',$property);
    }

    public function update(Request $request)
    {
        $data = $request->all();


        $paymethods=propertyPaymethod::where(['org_id'=>Auth()->user()->org_id,'property_id'=>$request->property_id])->get();
      //  dd($data);
        foreach ($paymethods as $paymethod) {
        if($paymethod->gateway=='paypal'){
        $paymethod->acc_name=$request->paypal_user_name;
        $paymethod->acc_password= bcrypt($request->paypal_password);
        $paymethod->acc_signature=$request->paypal_signature;
        $paymethod->active=$request->paypal_active;
        if($request->default=='paypal'){
        $paymethod->default=1;
        }else{
        $paymethod->default=0;
        }
        $paymethod->save();
        }
        elseif($paymethod->gateway=='cash'){
        $paymethod->active=$request->cash_active;
        if($request->default=='cash'){
        $paymethod->default=1;
        }else{
        $paymethod->default=0;
        }
        $paymethod->save();
        }
        elseif($paymethod->gateway =='stripe'){
        $paymethod->acc_name=$request->stripe_user_name;
        $paymethod->acc_password= bcrypt($request->stripe_password);
        $paymethod->active=$request->stripe_active;
        if($request->default=='stripe'){
        $paymethod->default=1;
        }else{
        $paymethod->default=0;
        }
        $paymethod->save();
        }
        elseif($paymethod->gateway =='authorize'){
        $paymethod->acc_name=$request->authorize_user_name;
        $paymethod->acc_password=$request->authorize_login_id;
        $paymethod->acc_signature=bcrypt($request->authorize_transaction_key);
        $paymethod->active=$request->authorize_active;
        if($request->default=='authorize'){
        $paymethod->default=1;
        }else{
        $paymethod->default=0;
        }
        $paymethod->save();
        }
        elseif($paymethod->gateway =='google'){
        $paymethod->acc_name=$request->google_user_name;
        $paymethod->acc_password= bcrypt($request->google_password);
        $paymethod->active=$request->google_active;
        if($request->default=='google'){
        $paymethod->default=1;
      }else{
      $paymethod->default=0;
      }
        $paymethod->save();
         Session::flash('deleted', __('strings.message_success_updated'));
        }


}

        return redirect()->back();



    }


    public function search(Request $request)
    {

        $org_id = Auth()->user()->org_id;
        if($request->hotel_name>0){
        $propertys=Property::join('property_payment_setup','property.id','=','property_payment_setup.property_id')
          ->select('property.*','gateway','default')
          ->where('property.org_id','=',$org_id)
          ->where('property_payment_setup.default','=',1)
          ->where('property.id', '=', $request->hotel_name)
          ->get();
            return view('property.index')->with('propertys',$propertys);
}else{
  $propertys=Property::join('property_payment_setup','property.id','=','property_payment_setup.property_id')
    ->select('property.*','gateway','default')
    ->where('property.org_id','=',$org_id)
    ->where('property_payment_setup.default','=',1)
    ->get();
  return view('property.index')->with('propertys',$propertys);

}

    }

     function delete($id){
         
        if(permissions('delete_property_pay') == false){

           //set session message
           Session::flash('message', __('strings.do_not_have_permission'));
           return view('permissions');
       } 
       $cat_ids=Category::where('property_id',$id)->where('org_id',Auth()->user()->org_id)->get();
       foreach($cat_ids as $cat_id){
       $cat_details_id=CategoryDetails::where('cat_id',$cat_id->id)->where('org_id',Auth()->user()->org_id)->get();
       }
       $faclity_id=FacilityList::where('property_id',$id)->where('org_id',Auth()->user()->org_id)->get();
       $slider_id=PropertySilder::where('property_id',$id)->where('org_id',Auth()->user()->org_id)->get();

       if(count($cat_id) !=0 && count($faclity_id) !=0 && count($slider_id) !=0 && count($cat_details_id) !=0){
         Session::flash('deleted', __('strings.delete_hotel'));
         return redirect('admin/property_payment');
       }else{
         $payment_types=propertyPaymethod::where('property_id',$id)->where('org_id',Auth()->user()->org_id)->get();
         foreach($payment_types as $payment_type){
          propertyPaymethod::destroy($payment_type->id);
         }
         Property::destroy($id);
         Session::flash('deleted', __('strings.sew_status_3'));
         
         $test=  str_replace(url('/'), '', url()->previous());
         if($test=='admin/property_payment'){
         return redirect('admin/property_payment');

       }else{
         return redirect('admin/property');
       }
         
         
        
       }

     }





}

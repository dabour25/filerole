<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PayPalController;
use Omnipay\Omnipay;
use App\org;
use App\CustomerPayment;
use App\CustomerPaymentDetail;
use App\Currency;
use Mail;
use App\Customers;
use App\Mail\CompletePayment;
use App\Mail\CompleteCashePayment;


use App\externalReq ;
class PaymentController extends Controller
{
    //
    public function index(Request $request){

     $total_amount=$request->total;
     $external_req_id=$request->id;

     $invoice_number_raw=externalReq::find($external_req_id);
     if($invoice_number_raw!=null){
       $invoice_number=$invoice_number_raw->invoice_no;
     }else{
       $invoice_number=0;
     }
      return view('front.payment',compact('total_amount','external_req_id','invoice_number'));
    }
    public function executePayment(Request $request){
      //dd($request->all());
      $total_amount=$request->total_amount;
      $invoice_number=$request->invoice_number;
      $external_req_id=$request->external_req_id;
      $payment_type=$request->payment_type;
      if($payment_type==1){
        //delivery on cashe payment
        $update_request=externalReq::find($external_req_id);
        $update_request->confirm='n';
        $update_request->save();
        $org_id=$update_request->org_id;

        $customer_name=Customers::find($update_request->cust_id)->name;

        $customer_email=Customers::find($update_request->cust_id)->email;
        
        $org_name=org::find($org_id);
        Mail::to($customer_email)->send(new CompleteCashePayment(['org_name'=>$org_name,'customer_name'=>$customer_name,'invoice_no'=>$invoice_number,'total_amount'=>$total_amount]));
  return view('front.completecashepayment',compact('invoice_number'));
      }
      elseif($payment_type==2){
        //credit card and stripe payment
        $input = $request->all();

        $data = \Validator::make($request->all(), [
             'name'=>'required',
             'last_name'=>'required',
             'email'=>'email|required',
             'address'=>'required',
             'city'=>'required',
             'governement'=>'required',
             'postal_code'=>'required',
             'state'=>'required',
             'phone'=>'required',
             'card_name'=>'required',
             'number'=>'required',
             'exp_date'=>'required',
             'cvc'=>'required'
           ]);
         if ($data->fails()) {

             return redirect()->back()->withErrors($data->errors())->withInput();
         }
         $token=$request->token1;

         $org_id=externalReq::find($external_req_id)->org_id;
         $currency_id=org::where('id',$org_id)->first()->currency;
         $currency=Currency::find($currency_id)->name_en;

         if($currency != "usd") {
             $curl = curl_init();
             curl_setopt_array($curl, array(
                 CURLOPT_URL => "https://api.exchangerate-api.com/v4/latest/$currency",
                 CURLOPT_RETURNTRANSFER => 1,
                 CURLOPT_ENCODING => "",
                 CURLOPT_MAXREDIRS => 10,
                 CURLOPT_TIMEOUT => 30,
                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                 CURLOPT_CUSTOMREQUEST => "GET",
             ));
             $response = json_decode(curl_exec($curl), true);
             curl_close($curl);
             if (!empty($response)) {
                 //dd($request->total * $response['rates']['USD']);
                 $price = round(($total_amount * $response['rates']['USD']),2);
             }
         }else{
             $price = round($total_amount,2);
         }

        $gateway = Omnipay::create('Stripe');
        $gateway->setApiKey('sk_test_kpTOcj7ZpsGKVZ5hwNWSTjWp001nzqQtpf');

// Example form data



// Send purchase request
$response = $gateway->purchase([
        'amount' => $price,
        'currency' => 'USD',
        'token' => $token,
    ])->send();


// Process response
if ($response->isSuccessful()) {
  $transaction_id = $response->getTransactionReference();

    // Payment was successful
    //update transaction
    $update_request=externalReq::find($external_req_id);
    $update_request->confirm='x';
    $update_request->save();
    //create new customer payment
    $customer_payment=new CustomerPayment();
    $customer_payment->external_req_id=$update_request->id;
    $customer_payment->customer_id=$update_request->cust_id;
    $customer_payment->org_id=$update_request->org_id;
    $customer_payment->payment_date=date('Y-m-d');
    $customer_payment->payment_tot=$total_amount;
    $customer_payment->currency_id=$currency_id;
    $customer_payment->pay_gateway='Credit Card';
    $customer_payment->card_owner_name=$request->card_name;
    $customer_payment->card_no=$request->number;
    $customer_payment->check_code=$request->cvc;
    $customer_payment->card_exp_date=$request->exp_date;
    $customer_payment->transaction_id=$transaction_id;
    $customer_payment->save();

    //create new customer payment details
    $customer_payment_detail=new CustomerPaymentDetail();
    $customer_payment_detail->customer_payid=$customer_payment->id;
    $customer_payment_detail->customer_id=$update_request->cust_id;
    $customer_payment_detail->first_name=$request->name;
    $customer_payment_detail->last_name=$request->last_name;
    $customer_payment_detail->email=$request->email;
    $customer_payment_detail->address=$request->address;
    $customer_payment_detail->city=$request->city;
    $customer_payment_detail->governorate=$request->governorate;
    $customer_payment_detail->country=$request->state;
    $customer_payment_detail->mobile=$request->phone;
    $customer_payment_detail->zip=$request->postal_code;
    $customer_payment_detail->save();
    //send email
    $org_name=org::find($org_id);
    Mail::to($request->email)->send(new CompletePayment(['org_name'=>$org_name,'customer_name'=>$request->name,'invoice_no'=>$invoice_number,'total_amount'=>$total_amount]));
    return view('front.completepayment',compact('invoice_number'));
} elseif ($response->isRedirect()) {

    // Redirect to offsite payment gateway
    $response->redirect();

} else {

    // Payment failed
    $error=$response->getMessage();
    return redirect("payment/failed/$error");

}
      }
      else{
        //paypal payment
        $input=$request->all();

        $data = \Validator::make($request->all(), [
             'name'=>'required',
             'last_name'=>'required',
             'email'=>'email|required',
             'address'=>'required',
             'city'=>'required',
             'governement'=>'required',
             'postal_code'=>'required',
             'state'=>'required',
             'phone'=>'required',
             ]);
         if ($data->fails()) {

             return redirect()->back()->withErrors($data->errors())->withInput();
         }
         $org_id=externalReq::find($external_req_id)->org_id;
         $currency_id=org::where('id',$org_id)->first()->currency;
         $currency=Currency::find($currency_id)->name_en;

         if($currency != "usd") {

             $curl = curl_init();
             curl_setopt_array($curl, array(
                 CURLOPT_URL => "https://api.exchangerate-api.com/v4/latest/$currency",
                 CURLOPT_RETURNTRANSFER => 1,
                 CURLOPT_ENCODING => "",
                 CURLOPT_MAXREDIRS => 10,
                 CURLOPT_TIMEOUT => 30,
                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                 CURLOPT_CUSTOMREQUEST => "GET",
             ));
             $response = json_decode(curl_exec($curl), true);
             curl_close($curl);
             if (!empty($response)) {
                 //dd($request->total * $response['rates']['USD']);
                 $price = round(($total_amount * $response['rates']['USD']),2);

             }
         }else{
             $price = round($total_amount,2);

         }
         $update_request=externalReq::find($external_req_id);
         //create new customer payment
         $customer_payment=CustomerPayment::where('external_req_id',$update_request->id)->first();
         if($customer_payment==null){
           $customer_payment=new CustomerPayment();
           $customer_payment->external_req_id=$update_request->id;
           $customer_payment->customer_id=$update_request->cust_id;
           $customer_payment->org_id=$update_request->org_id;
           $customer_payment->payment_date=date('Y-m-d');
           $customer_payment->payment_tot=$total_amount;
           $customer_payment->currency_id=$currency_id;
           $customer_payment->pay_gateway='Pay Pal';
           // $customer_payment->transaction_id=$transaction_id;
           $customer_payment->save();

           //create new customer payment details
           $customer_payment_detail=new CustomerPaymentDetail();
           $customer_payment_detail->customer_payid=$customer_payment->id;
           $customer_payment_detail->customer_id=$update_request->cust_id;
           $customer_payment_detail->first_name=$request->name;
           $customer_payment_detail->last_name=$request->last_name;
           $customer_payment_detail->email=$request->email;
           $customer_payment_detail->address=$request->address;
           $customer_payment_detail->city=$request->city;
           $customer_payment_detail->governorate=$request->governorate;
           $customer_payment_detail->country=$request->state;
           $customer_payment_detail->mobile=$request->phone;
           $customer_payment_detail->zip=$request->postal_code;
           $customer_payment_detail->save();
         }

        $paypalobject = new PayPalController();

      $error= $paypalobject->checkout($external_req_id,$price,$request->name,$request->email,$org_id);
      return view('front.paymentfailed',compact('error'));

      }

    }

    public function paymentCompleted(Request $request){

      $update_request=externalReq::find($request->external_req_id);
      $update_request->confirm='x';
      $update_request->save();

      return view('payment_completed');
    }
    public function paymentfailed($error){
      return view('front.paymentfailed',compact('error'));
    }


}

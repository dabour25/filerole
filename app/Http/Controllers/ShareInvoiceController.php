<?php

namespace App\Http\Controllers;

use App\CustomerHead;
use App\CategoriesType;
use App\Category;
use App\Customers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Auth;
use DB;

class ShareInvoiceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        if(CustomerHead::where(['id' => $request->id])->doesntExist()){
            return "404";
        }elseif (Session::get('share_code') && CustomerHead::where(['id' => $request->id, 'share_code' => Session::get('share_code')[0]])->doesntExist()){
            return "404";
        }

        if (Session::get('share_submit') && Session::get('share_submit')[0] == 1) {

            $list = CustomerHead::where(['id' => $id])->with('customer', 'transactions')->whereNotNull('cust_id')->get();

            foreach ($list as $value) {
                foreach ($value->transactions as $key => $v) {
                    $v->price = $v->price * $v->quantity * $v->req_flag;
                    $v->tax_val = $v->tax_val * $v->quantity;
                    $v->cat_type = CategoriesType::findOrFail(Category::findOrFail($v->cat_id)->category_type_id)->type;
                }

            }
            return view('transactions.print', compact('list'));
        }else {
            return view('share', compact('id'));
        }
    }
    
    public function hotel_reservation(Request $request,$id){
      if(Booking::where(['id' => $request->id])->doesntExist()){
          return "404";
      }elseif (Session::get('share_code') && Booking::where(['id' => $request->id, 'share_code' => Session::get('share_code')[0]])->doesntExist()){
          return "404";
      }

      if (Session::get('share_submit') && Session::get('share_submit')[0] == 1) {
        $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$id)->first();
        $booking->hotel=Property::where('id',$booking->property_id)->where('org_id',Auth::user()->org_id)->first();
        $booking->no_rooms=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$booking->id)->where('type',0)->where('room_status','y')->get()->count();
        $rooms_tax_val=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$booking->id)->where('type',0)->where('room_status','y')->sum('tax_val');
        $additional_tax_val=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$booking->id)->where('type','!=',0)->sum('tax_val');
        $booking->tax_val=$rooms_tax_val+$additional_tax_val;
        $booking->confirmed_rooms=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$booking->id)->where('type',0)->where('room_status','y');
        $booking->canceled_rooms=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$booking->id)->where('type',0)->where('room_status','c');
        $booking->additonal_categories=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$booking->id)->where('type',1);
        $booking->services=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$booking->id)->where('type',2);
        return view('bookings.invoice',compact('booking'));




      }else {
          return view('hotel_invoice_share', compact('id'));
      }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function share_submit(Request $request)
    {
        $request->session()->forget('share_submit'); $request->session()->forget('share_code');
        if(CustomerHead::where(['id' => $request['id'], 'share_code' => $request->password])->exists()){
            $request->session()->push('share_submit', 1);
            $request->session()->push('share_code', $request->password);
        }else{
            $request->session()->push('share_submit', 0);
            Session::flash('message', 'Please check your share code!');
        }
        //return Session::get('share_submit')[0];
        return redirect('invoice/'.$request->id);
    }
    
    public function hotel_share_submit(Request $request)
    {
        $request->session()->forget('share_submit'); $request->session()->forget('share_code');

        if(Booking::where(['id' => $request->id, 'share_code' => $request->password])->exists()){
            $request->session()->push('share_submit', 1);
            $request->session()->push('share_code', $request->password);
        }else{
            $request->session()->push('share_submit', 0);
            Session::flash('message', 'Please check your share code!');
        }
        //return Session::get('share_submit')[0];
        return redirect('hotel/invoice/'.$request->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function share(Request $request, $id, $type)
    {
        $code = str_random(6);
        CustomerHead::where(['id' => $request->id])->update([ 'share_code' => $code]);
        if($type == 'twitter'){
            return redirect(\Share::load(url('invoice/'. $id), 'Invoice code is '. $code)->twitter());
        }elseif ($type == 'facebook'){
            return redirect(\Share::load(url('invoice/'. $id), 'Invoice code is '. $code)->facebook());
        }elseif ($type == 'telegram'){
            return redirect(\Share::load(url('invoice/'. $id), 'Invoice code is '. $code)->telegramMe());
        }
    }

    public function share_invoice(Request $request){
        $phone = $request->code .''. $request->number;
        $url = url('invoice',$request->invoice_no);
        $code = CustomerHead::where(['id' => $request->invoice_no])->value('share_code');

        $message = "مرحبا بك معانا رابط الفاتورة:$url ";
        $message.= "وكود الدخول:$code ";
        return redirect("https://web.whatsapp.com/send?phone=$phone&text=$message");

    }
    
    public function share_print(Request $request){
        $phone = $request->code .''. $request->number;
        $url = url('membership',$request->id);
        $code = Customers::where(['id' => $request->id])->value('share_code');

        $message = "مرحبا بك معانا رابط عضويتك:$url ";
        $message.= "وكود الدخول:$code ";
        return redirect("https://web.whatsapp.com/send?phone=$phone&text=$message");
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Membership(Request $request, $id)
    {
        if(Customers::where(['id' => $id])->doesntExist()){
            return "404";
        }elseif (Session::get('share_code_2') && Customers::where(['share_code' => Session::get('share_code_2')[0]])->doesntExist()){
            return "404";
        }

        if (Session::get('share_submit_2') && Session::get('share_submit_2')[0] == 1) {

            $customer = Customers::findOrFail($id);
            return view('print', compact('customer'));
        }else {
            return view('share', compact('id'));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function card_submit(Request $request)
    {
        $request->session()->forget('share_submit_2'); $request->session()->forget('share_code_2');
        if(Customers::where(['id' => $request->id, 'share_code' => $request->password])->exists()){
            $request->session()->push('share_submit_2', 1);
            $request->session()->push('share_code_2', $request->password);
        }else{
            $request->session()->push('share_submit_2', 0);
            Session::flash('message', 'Please check your share code!');
        }
        return back();
    }

}

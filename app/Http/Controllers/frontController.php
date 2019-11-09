<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Photo;
use App\org_news;
use Auth;
use View;

use App\org;
use App\Subscribers;
use App\FrontMessages;
use App\CategoriesType;
use App\Category;
use App\Offers;
use\App\PriceList;
use\App\CustomerHead;
use\App\externalReq;
use\App\externalTrans;
use App\Currency;
use Session;
use App\Organization;
use\App\InvoiceSetup;
use App\Reservation;
use App\OfferDays;
use App\Activities;
use App\Locations;
class frontController extends Controller
{

  public function __construct(){
    $currency=Currency::all();
    View::share('currency',$currency);
  }

  public function index(){

    if (session('locale')) {
        \App::setLocale(session('locale'));
    }
      $my_url=url()->current();
      $last = explode('/', $my_url);
      $org_id=org::where('customer_url',$last[2])->first();
      $org_id_login=$org_id->id;
      if(empty($org_id)){
        $org_master=Organization::where('custom_domain',$last[2]);
        $org_id=org::where('id',$org_master->org_id);
        $org_id_login=$org_master->org_id;
      }

      $news=org_news::join('photos','org_news.image_id', '=', 'photos.id')->where(['active' => 1,'org_id' => $org_id_login])->select('photos.file', 'org_news.*')->orderBy('news_date', 'DESC')->LIMIT('6')->get();

   /*$data_form=date('Y m d ', strtotime('- 2 month'));
  Return $data_to=date('Y m d ');*/
   //$best_selers=DB::select('select * from categories, photos WHERE categories.photo_id = photos.id and categories.org_id ='.$org_id_login.' and categories.id in (select id from categories a inner join (select cat_id, date, sum(quantity) q from transactions where org_id = '.$org_id_login.' and cust_id >0 and cancel_flag = 0 and `date` BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL 2 month) and CURRENT_DATE group by cat_id ORDER by q DESC LIMIT 8) b on a.id = b.cat_id ) ');
  //$best_selers=DB::select('select * from categories,price_list,offers, photos WHERE price_list.cat_id=categories.id and offers.cat_id=categories.id and offers.id in ( select a.id from offers a inner join (select cat_id, max(date_to) date_to, max(date_from) date_from from offers where date_from <= CURRENT_DATE and date_to >= CURRENT_DATE and active = 1 and org_id =  '.$org_id_login.' group by cat_id) b on a.cat_id = b.cat_id and a.date_to = b.date_to)and price_list.id in (select a.id from price_list a inner join (select cat_id, max(date) date from price_list where date<=CURRENT_DATE and active = 1 and org_id = '.$org_id_login.' group by cat_id) b on a.cat_id = b.cat_id and a.date = b.date ) and categories.photo_id = photos.id and categories.org_id = '.$org_id_login.' and categories.id in (select id from categories a inner join (select cat_id, date, sum(quantity) q from transactions where org_id = '.$org_id_login.' and cust_id >0 and cancel_flag = 0 and `date` BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL 2 month) and CURRENT_DATE group by cat_id ORDER by q DESC LIMIT 8) b on a.id = b.cat_id )');
   
   
  $best_selers=DB::select('select name,name_en, photo_id, file , categories.id,description,description_en  from categories, photos WHERE categories.photo_id = photos.id and categories.org_id ='.$org_id_login.' and categories.id in (select id from categories a inner join (select cat_id, date, sum(quantity) q from transactions where org_id = '.$org_id_login.' and cust_id >0 and cancel_flag = 0 and `date` BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL 2 month) and CURRENT_DATE group by cat_id ORDER by q DESC LIMIT 8) b on a.id = b.cat_id )'); 

  $offers=DB::select('select * from categories, photos,price_list,offers WHERE categories.photo_id = photos.id and categories.org_id ='.$org_id_login.' and offers.cat_id=categories.id and categories.active=1 and offers.id in( select a.id from offers a inner join (select cat_id, max(date_to) date_to, max(date_from) date_from from offers where date_from <= CURRENT_DATE and date_to >= CURRENT_DATE and active = 1 and org_id = '.$org_id_login.' group by cat_id) b on a.cat_id = b.cat_id and a.date_to = b.date_to) and price_list .cat_id = categories.id AND price_list.id in (select a.id from price_list a inner join (select cat_id, max(date) date from price_list where date<=CURRENT_DATE and org_id = '.$org_id_login.' group by cat_id) b on a.cat_id = b.cat_id and a.date = b.date ) and infrontpage=1 GROUP BY categories.id ORDER BY categories.created_at DESC LIMIT 10');
  

  
  $last_prodcts=Category::join('photos', function ($join) use($org_id_login) {
$join->on('categories.photo_id', '=', 'photos.id')->where(['active' => 1,'org_id'=>$org_id_login]);
})->select('photos.file', 'categories.*')->orderBy('created_at', 'DESC')->LIMIT('9')->get();

  //Get Master activity id
  $activity=Activities::where('id',$org_id->activity_id)->first();
    if($activity->dashboard_type=="Hotels"){
    //$popular_destinations=DB::table('destinations')->where(['org_id' =>$org_id_login])->LIMIT('8')->get();
    $destinatons=DB::table('destinations')->where(['org_id' =>$org_id_login])->get();
    $offers=Offers::join('offer_details','offer_details.offer_id','=','offers.id')
    ->join('categories','categories.id','=','offer_details.cat_id')
    ->join('categories_type','categories.category_type_id','=','categories_type.id')
    ->where('offers.date_to','>=',Date('Y-m-d'))
    ->where('offers.org_id',$org_id->id)->where('offers.active',1)
    ->where('categories_type.type',7)
    ->orderBy('offers.id','DESC')->LIMIT('9')->get();
    foreach ($offers as $k => $v) {
      $days[$k]=OfferDays::where('offer_id',$v->id)->get();
    }
   return  view('front_hotel_last.index',compact('destinatons','news','org_id','best_selers','offers','days'));
 }else{
   return  view('front.index',compact('news','best_selers','last_prodcts','org_id','offers')); 

 }
  }


  public function subscribers(Request $request){
    $message_sub=new Subscribers;
    $message_sub->sub_email=$request->email;
    $my_url=$_SERVER['HTTP_HOST'];
    $org=org::where('customer_url',$my_url)->first();
    $org_id_login=$org->id;
    if(empty($org)){
        $org_id=Organization::where('custom_domain',$last[2]);
        $org_id_login=$org->org_id;
    }
    $message_sub->org_id=$org_id_login;
    $message_sub->url=$_SERVER['HTTP_REFERER'];
    $message_sub->save();
    return back();

  }
    public function about_us(){
        if (session('locale')) {
            \App::setLocale(session('locale'));
        }
        $my_url=$_SERVER['HTTP_HOST'];
        $last = explode('/', $my_url);
        $org=org::where('customer_url',$last[0])->first();
        $org_id=$org;
        if(empty($org)){
            $org_id=Organization::where('custom_domain',$last[2]);
            $org_id=org::where('id',$org_id->org_id);
            $org=org::where('id',$org_id->org_id);
            $org_id_login=$org->id;
        }
        $activity=Activities::where('id',$org_id->activity_id)->first();
        if($activity->dashboard_type=="Hotels"){
            return  view('front_hotel_last.about',compact('org_id'));
        }else{
            return  view('front.aboutus',compact('org'));
        }
    }
  public function contact(){
        if (session('locale')) {
            \App::setLocale(session('locale'));
        }
        $my_url=$_SERVER['HTTP_HOST'];
        $last = explode('/', $my_url);
        $org=org::where('customer_url',$my_url)->first();
        $org_id=$org;
        if(empty($org)){
            $org_id=Organization::where('custom_domain',$last[2]);
            $org=org::where('id',$org_id->org_id);
        }
        $activity=Activities::where('id',$org_id->activity_id)->first();
        if($activity->dashboard_type=="Hotels"){
          $location=Locations::where('id',$org_id->location_map)->first();
            return view('front_hotel_last.contact',compact('org_id','location'));
        }else{
            return  view('front.contact',compact('org'));
        }
  }
  public function front_message(Request $request){
    $message=new FrontMessages;
    $message->name=$request->name;
    $message->email=$request->email;
    $message->message=$request->message;
    $message->subject=$request->subject;
    $message->date=date('Y-m-d ');
    $my_url=$_SERVER['HTTP_HOST'];
    $org=org::where('customer_url',$my_url)->first();
    $org_id_login=$org->id;
    if(empty($org)){
      $org_master=Organization::where('custom_domain',$last[2]);
      $org=org::where('id',$org_master->org_id);
      $org_id_login=$org_master->org_id;
    }
    $message->org_id=$org_id_login;
    $message->url=$_SERVER['HTTP_HOST'];
    $message->save();
    return back();

  }


public function get_categorys(){

        if (session('locale')) {
            \App::setLocale(session('locale'));
        }
        $my_url=$_SERVER['HTTP_HOST'];
        $org=org::where('customer_url',$my_url)->first();
        $org_id_login=$org->id;
        if(empty($org)){
       $org=Organization::where('custom_domain',$last[2]);
       $org_id_login=$org->org_id;
        }
        $products=CategoriesType::where(['active'=>1,'type'=>1,'org_id'=>$org_id_login])->get();
        $services=CategoriesType::where(['active'=>1,'type'=>2,'org_id'=>$org_id_login])->get();
        $categoryid_ids = DB::table('price_list as a')
     ->join(DB::raw('(select cat_id, max(date) date from price_list where date <= CURRENT_DATE and active = 1 and org_id = '.$org_id_login.'  group by cat_id) b'),
         function ($join) {
             $join->on('a.cat_id', '=', 'b.cat_id')
                 ->on('a.date', '=', 'b.date');
         })
     ->select('a.id','b.cat_id')
     ->get();


     $categoryids = [];
     foreach ($categoryid_ids as $categoryid_id) {

         array_push($categoryids, $categoryid_id->id);
     }

  foreach ($products as $product) {
        $product->product_types=Category::join('price_list', 'price_list.cat_id', '=', 'categories.id')
        ->join('photos', 'photos.id', '=', 'categories.photo_id')
        ->where([ 'categories.active' => 1,'categories.category_type_id' =>$product->id ,'categories.org_id'=>$org_id_login])
        ->whereIn('price_list.id', $categoryids)
        ->select('categories.*', 'final_price')
        ->get();

}


  foreach ($services as $service) {

     $service->service_types=Category::join('price_list', 'price_list.cat_id', '=', 'categories.id')
       ->join('photos', 'photos.id', '=', 'categories.photo_id')
      ->where([ 'categories.active' => 1,'categories.category_type_id' =>$service->id ,'categories.org_id'=>$org_id_login])
      ->whereIn('price_list.id', $categoryids)
      ->select('categories.*', 'final_price')
      ->get();



  }

  // dd($products);
    return  view('front.categorys',compact('org','products','services'));
  }




  public function get_offers(){

        if (session('locale')) {
            \App::setLocale(session('locale'));
        }
  $my_url=$_SERVER['HTTP_HOST'];
  $org=org::where('customer_url',$my_url)->first();
  $org_id_login=$org->id;
  if(empty($org)){
 $org_master=Organization::where('custom_domain',$last[2]);
 $org=org::where('id',$org_master->org_id);
 $org_id_login=$org_master->org_id;
  }
  $products=CategoriesType::where(['active'=>1,'type'=>1,'org_id'=>$org_id_login])->get();
  $services=CategoriesType::where(['active'=>1,'type'=>2,'org_id'=>$org_id_login])->get();
    $offersid_ids =  DB::table('offers as a')
      ->join(DB::raw('(select cat_id, max(date_to) date_to from offers where date_from <= CURRENT_DATE and date_to >= CURRENT_DATE and active = 1 and org_id = '.$org_id_login.' group by cat_id) b'),
          function ($join) {
              $join->on('a.cat_id', '=', 'b.cat_id')
                  ->on('a.date_to', '=', 'b.date_to');
          })
      ->select('a.id')
      ->get();

     $offersids = [];
     foreach ($offersid_ids as $offersid_id) {
         array_push($offersids, $offersid_id->id);
     }

     $categoryid_ids = DB::table('price_list as a')
  ->join(DB::raw('(select cat_id, max(date) date from price_list where date <= CURRENT_DATE and active = 1 and org_id = '.$org_id_login.'  group by cat_id) b'),
      function ($join) {
          $join->on('a.cat_id', '=', 'b.cat_id')
              ->on('a.date', '=', 'b.date');
      })
  ->select('a.id','b.cat_id')
  ->get();


  $categoryids = [];
  foreach ($categoryid_ids as $categoryid_id) {

      array_push($categoryids, $categoryid_id->id);
  }

  foreach ($products as $product) {

      $product->product_types=Category::join('offers', 'offers.cat_id', '=', 'categories.id')
      ->join('price_list', 'price_list.cat_id', '=', 'categories.id')
      ->join('photos', 'photos.id', '=', 'categories.photo_id')
      ->where([ 'categories.active' => 1,'categories.category_type_id' =>$product->id ,'categories.org_id'=>$org_id_login])
      ->whereIn('offers.id', $offersids)
      ->whereIn('price_list.id', $categoryids)
      ->select('categories.*','offer_price', 'final_price')
      ->get();


  }
  foreach ($services as $service) {
    $service->service_types=Category::join('offers', 'offers.cat_id', '=', 'categories.id')
    ->join('price_list', 'price_list.cat_id', '=', 'categories.id')
    ->join('photos', 'photos.id', '=', 'categories.photo_id')
    ->where([ 'categories.active' => 1,'categories.category_type_id' =>$service->id ,'categories.org_id'=>$org_id_login])
    ->whereIn('offers.id', $offersids)
    ->whereIn('price_list.id', $categoryids)
    ->select('categories.*', 'offer_price','final_price')
    ->get();

  }

    return  view('front.offers',compact('org','products','services'));
  }
    public function cart_check_out(){
     $my_url=url()->current();
     $last = explode('/', $my_url);
     $org=org::where('customer_url',$last[2])->first();
     $org_id_login=$org->id;
     if(empty($org)){
    $org_master=Organization::where('custom_domain',$last[2]);
    $org=org::where('id',$org_master->org_id);
    $org_id_login=$org_master->org_id;
     }
     $currency= Currency::where('id', $org->currency)->first();
     return view('front.cart',compact('currency'));

   }

 public function storeCart(Request $request){

        $my_url=url()->current();
        $last = explode('/', $my_url);
        $org=org::where('customer_url',$last[2])->first();
        $org_id_login=$org->id;
        if(empty($org)){
       $org_master=Organization::where('custom_domain',$last[2]);
       $org=org::where('id',$org_master->org_id);
       $org_id_login=$org_master->org_id;
        }
        $invoice_no_internal=CustomerHead::where('org_id',$org_id_login)->orderBy('invoice_no','desc')->value('invoice_no');
        $invoice_no_extranal=externalReq::where('org_id',$org_id_login)->orderBy('invoice_no','desc')->value('invoice_no');

        $cart= json_decode($request->data);

       if(Auth::guard('customers')->check()){
        if(!empty($cart)){
          $old_head=externalReq::where(['org_id'=>$org_id_login,'cust_id'=>Auth::guard('customers')->user()->id,'confirm'=>'p'])->first();
          if($old_head){

          }
          else{
       $extra_head=new externalReq;
       $extra_head->cust_id=Auth::guard('customers')->user()->id;
       $extra_head->org_id=$org_id_login;
       $extra_head->request_dt=date("Y-m-d");
       $extra_head->invoice_date=date("Y-m-d h:i:s", time());
       if(empty($invoice_no_internal) && empty($invoice_no_extranal) ){
         $sart_invoice_no=InvoiceSetup::where('type',4)->where('org_id',$org_id_login)->value('value');
         if($sart_invoice_no== null){
           $sart_invoice_no= 1;

       }
         $extra_head->invoice_no=$sart_invoice_no;
       }if(!empty($invoice_no_internal) && !empty($invoice_no_extranal) ){
         if($invoice_no_internal > $invoice_no_extranal){
           $extra_head->invoice_no=$invoice_no_internal+1;


         }
          else {
            $extra_head->invoice_no=$invoice_no_extranal+1;
          }
       }elseif($invoice_no_internal){
          $extra_head->invoice_no=$invoice_no_internal+1;
       }elseif($invoice_no_extranal){
         $extra_head->invoice_no=$invoice_no_extranal+1;
       }
       $sart_invoice_code=InvoiceSetup::where('type',3)->where('org_id',$org_id_login)->value('value');

       $extra_head->invoice_code=$sart_invoice_code.$extra_head->invoice_no;
       $extra_head->confirm='p';
       $total_amount=0;
       $count=0;
       $extra_head->save();
     }
     $old_etra_trans=externalTrans::where(['org_id'=>$org_id_login,'cust_id'=> Auth::guard('customers')->user()->id,'external_req_id'=>$old_head->id])->get();
         foreach ($old_etra_trans as $value) {
           $value->delete();
         }
       foreach ($cart as  $value) {
         $extra_trans = new externalTrans();
         $i=0;
         foreach ($value as $key) {
           if ($i == 3) {
            $extra_trans->cat_id=$key;
            $cat_store_id=Category::where('id',$key)->where('org_id',$org_id_login)->first();
            if($cat_store_id->store_id){
            $extra_trans->store_id=$cat_store_id->store_id;
          }else{
            $extra_trans->store_id=0;
             }

             $offers_price=Offers::where('cat_id',$key)->where('org_id',$org_id_login)->whereDate('date_from','<=',date('Y-m-d'))->whereDate('date_to','>=',date('Y-m-d'))->orderBy('created_at','desc')->first();

             $cat_price_list=PriceList::where('cat_id',$key)->where('org_id',$org_id_login)->whereDate('date','<=' , date('Y-m-d'))->orderBy('date','desc')->first();

             if(!empty($offers_price)){

              $extra_trans->final_price=$offers_price->offer_price;
              $extra_trans->tax_val= $offers_price->offer_price - $offers_price->discount_price;
              $extra_trans->tax_id=$cat_price_list->tax;
            }else{
              $extra_trans->final_price=$cat_price_list->final_price;
              $extra_trans->tax_val=$cat_price_list->final_price - $cat_price_list->price;
              $extra_trans->tax_id=$cat_price_list->tax;

            }

           }if ($i == 2) {
             $extra_trans->quantity=$key;
           }

           $extra_trans->cust_id=Auth::guard('customers')->user()->id;
           if($old_head){
             $extra_trans->external_req_id=$old_head->id;
             Session::put('id', $old_head->id);
           }else{
             $extra_trans->external_req_id=$extra_head->id;
             Session::put('id', $extra_head->id);
           }
           $extra_trans->reg_flag=-1;
           $extra_trans->org_id=$org_id_login;

           $i++;

         }
          $extra_trans->request_dt=date("Y-m-d");
          $extra_trans->save();
          $total_amount+= $extra_trans->quantity*$extra_trans->final_price;
          $count+=$extra_trans->quantity;

            Session::put('total', $total_amount);
            Session::put('count', $count);

       }

      return response()->json(['success'=>'1']);
     }
return response()->json(['success'=>'your shoppingCart is empty']);
}
return response()->json(['success'=>'2']);        //return  view('front.checkout');
}

  public  function view_invoice(){

       $my_url=url()->current();
       $last = explode('/', $my_url);
       $org_id=org::where('customer_url',$last[2])->first();
       $org_id_login=$org_id->id;
       if(empty($org_id)){
      $org_master=Organization::where('custom_domain',$last[2]);
      $org_id=org::where('id',$org_master->org_id);
      $org_id_login=$org_master->org_id;
       }
       $head_id= Session::get('id');
       $org_id_login;
       $extra_head=externalReq::where(['org_id' =>$org_id_login,'cust_id'=>Auth::guard('customers')->user()->id,'id'=>$head_id])->first();
       $count_number=Session::get('count');
       $total= Session::get('total');
       $extra_trans=externalTrans::where(['org_id'=>$org_id_login,'cust_id'=>Auth::guard('customers')->user()->id,'external_req_id'=>$extra_head->id])->get();

        $currency = Currency::where(['id' =>$org_id->currency])->first();



   return view('front.checkout',compact('extra_trans','extra_head','org_id','total','currency','count_number'));

   }

     public function search(Request $request) {
      $my_url=url()->current();
      $last = explode('/', $my_url);
      $org=org::where('customer_url',$last[2])->first();
      $org_id_login=$org->id;
      if(empty($org)){
     $org_master=Organization::where('custom_domain',$last[2]);
     $org=org::where('id',$org_master->org_id);
     $org_id_login=$org_master->org_id;
      }
      $serach = $request->input('serach');
     if(app()->getLocale() =='ar'){
       $categorys = Category::where('name', 'LIKE', '%' . $serach .
'%')->where('org_id',$org_id_login)->get();

     }else {
       $categorys = Category::where('name_en', 'LIKE', '%' . $serach .
'%')->where('org_id',$org_id_login)->get();

     }
      foreach ($categorys as $category) { $offers=Offers::where('active',1)->where('org_id',$org_id_login)->where('cat_id',$category->id)->whereDate('date_from','<='
, date('Y-m-d'))->whereDate('date_to','>=' , date('Y-m-d'))->orderBy('created_at','desc')->first();
$prices=PriceList::where('active',1)->where('org_id',$org_id_login)->whereDate('date','<=',date('Y-m-d'))->where('cat_id',$category->id)->orderBy('date','desc')->first();

       if($offers){
           $category->cat=1;
         $category->price=Category::join('offers', 'offers.cat_id', '=',
'categories.id')
         ->join('price_list', 'price_list.cat_id', '=', 'categories.id')
         ->where([ 'categories.active' =>1,'categories.org_id'=>$org_id_login])
         ->where('offers.id', $offers->id)
         ->where('price_list.id', $prices->id)
         ->select('categories.*','offer_price', 'final_price')
         ->first();
       }else{
         $category->cat=0;
         $category->price=Category::join('price_list','price_list.cat_id', '=', 'categories.id')
         ->where([ 'categories.active' => 1,'categories.org_id'=>$org_id_login])
         ->where('price_list.id', $prices->id)
         ->select('categories.*', 'final_price')
         ->first();
       }
      }
   return view('front.serach',compact('categorys'));
}
   function product_details($id){
     $my_url=url()->current();
     $last = explode('/', $my_url);
     $org=org::where('customer_url',$last[2])->first();
     $org_id_login=$org->id;
     if(empty($org)){
    $org_master=Organization::where('custom_domain',$last[2]);
    $org=org::where('id',$org_master->org_id);
    $org_id_login=$org_master->org_id;
     }

  $category_price=Category::find($id);


    return view('front.product',compact('category_price'));
  }


  function fetch(Request $request)
     {
       $my_url=url()->current();
       $last = explode('/', $my_url);
       $org=org::where('customer_url',$last[2])->first();
       $org_id_login=$org->id;
       if(empty($org)){
      $org_master=Organization::where('custom_domain',$last[2]);
      $org=org::where('id',$org_master->org_id);
      $org_id_login=$org_master->org_id;
       }
      if($request->get('query'))
      {
       $query = $request->get('query');
       $data = Category::where('name', 'LIKE', "%{$query}%")->where('org_id',$org_id_login)->get();


       $output = '<ul class="dropdown-menu" style="display:block;
position:relative">';
       foreach($data as $row)
       {
                $output .= '<li><a href=http://'.$last[2].'/details/'. $row->id.'>'.$row->name.'<img src='.asset(str_replace(' ', '%20', \App\Photo::find($row->photo_id)->file)).' /></a></li>';




       }
       $output .= '</ul>';
       return $output;
      }
     }

 public function cart_list()
     {
       if (session('locale')) {
           \App::setLocale(session('locale'));
       }
       $list = [];
       $my_url=url()->current();
       $last = explode('/', $my_url);
       $org=org::where('customer_url',$last[2])->first();
       $org_login=$org->id;
       $org_id_login=$org->id;
       if(empty($org)){
      $org_master=Organization::where('custom_domain',$last[2]);
      $org=org::where('id',$org_master->org_id);
      $org_id_login=$org_master->org_id;
       }
       $extra_head=externalReq::where(['org_id' =>$org_id_login,'cust_id'=>Auth::guard('customers')->user()->id,'confirm'=>'p'])->first();
       $total= Session::get('total');
       $count_number=Session::get('count');
       $extra_trans=externalTrans::where(['org_id'=>$org_id_login,'cust_id'=>Auth::guard('customers')->user()->id,'external_req_id'=>$extra_head->id])->get();
       foreach ($extra_trans as $key) {
         $list[] = ['name'=> app()->getLocale() =='ar' ? Category::where('id',$key->cat_id)->value('name') : Category::where('id',$key->cat_id)->value('name_en')  ,'price' => $key->final_price, 'count' => $key->quantity  ,'id' => $key->cat_id , 'description'=>"$key->description"  ];
       }
       return json_encode($list);
     }
     
     
     public function reservations(){
         
       $reservationInstance = new Reservation;
     $reservations = $reservationInstance->getReservationTable();  
    return view('front.reservations')->with('reservations', $reservations);     
         
     }


}

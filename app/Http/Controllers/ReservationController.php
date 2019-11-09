<?php

namespace App\Http\Controllers;

use App\CaptinAvailable;
use App\CategoriesType;
use App\Category;
use App\Customers;
use App\Http\Middleware\Customer;
use App\Photo;
use App\Reservation;
use App\UserShift;
// a.nabiil
use App\Notification as nofifyModel;
use App\NotificationsUser as notifyActivity;
use App\Events\Notifications as notifyEvent;
use App\Customers as customersModel;
// a.nabiil
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Jenssegers\Date\Date;
use Response;
use App\Countries;
use App\ReserveDetails;
use App\Settings;

// <!-- Last Modified  02/06/2019 16:40:17  -->

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *

     */
    public function index()
    {
      if (permissions('show_reservation') == 0 ) {

            //set session message

            Session::flash('message', __('strings.do_not_have_permission'));

            return view('permissions');

        }
        $date = Carbon::now()->format('Y-m-d');
        $reservationInstance = new Reservation;
        $reservations = $reservationInstance->getAllReservationsTableByDate($date,$date);

        return view('reservation.admin.index')->with('reservations',$reservations);
    }

    public function test()
    {
        $date = Carbon::now()->format('Y-m-d');
        $reservationInstance = new Reservation;
        $reservations = $reservationInstance->getAllReservationsTableByDate($date,$date);
        return $reservations;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reservationInstance = new Reservation;
        $services = CategoriesType::where(['org_id'=>Auth::guard('customers')->user()->org_id,'type'=>2,'active'=>1])->get();
        $categories = $reservationInstance->getCategoriesServices();
        $shift_captins=UserShift::where('org_id',Auth::guard('customers')->user()->org_id)->pluck('captin_id');
        $captins=User::whereIn('id',$shift_captins)->where('org_id',Auth::guard('customers')->user()->org_id)->where('is_active',1)->get();
        if(Settings::where(['key' => 'reservation_type', 'org_id' => Auth::guard('customers')->user()->org_id])->value('value') == 1){
             return view('reservation.create_no_time')->with('category_types',$services)->with('categories',$categories)->with('captins',$captins);
           }
      
        return view('reservation.create')->with('category_types',$services)->with('categories',$categories)->with('captins',$captins);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $day_name = Carbon::parse($data['date'])->format('l');
        $day = getDayNumber($day_name);
        $reservation = new Reservation;
        $reservation->cust_id=Auth::guard('customers')->user()->id;
        $reservation->captain_id=$data['captain'];
        $reservation->reservation_date=$data['date'];
        $reservation->comment=$data['description'];
        if(Settings::where(['key' => 'reservation_type', 'org_id' => Auth::guard('customers')->user()->org_id])->value('value') == 1){
          $reservation->type=1;
          $reservation->confirm='y';
        }
        else{
          $reservation->type=0;
        }
        $reservation->user_id = Auth::guard('customers')->user()->id;
        $reservation->org_id = Auth::guard('customers')->user()->org_id;
        $reservation->active=1;
        $reservation->save();
          if(Settings::where(['key' => 'reservation_type', 'org_id' => Auth::guard('customers')->user()->org_id])->value('value') == 1){
          foreach($data['cat_id'] as $key=>$value){
            $reservation_details=new ReserveDetails();
            $reservation_details->reserve_id=$reservation->id;
            $reservation_details->reservation_dt=$data['date'];
            $reservation_details->cat_id=$value;
            $reservation_details->av_day=$day;
            $reservation_details->av_time_from=0;
            $reservation_details->av_time_to=0;
            $reservation_details->av_time_from=0;
            $reservation_details->org_id=Auth::guard('customers')->user()->org_id;
            $reservation_details->user_id=Auth::guard('customers')->user()->id;
            $reservation_details->save();
          }
      Session::flash('message',__('strings.finish_reservation and will_contact'));
          //return redirect('/customerdashboard');
          return redirect('/CustomerReservations')->withInput(['tab'=>'tabelres3'])->with('store_status','success');
        }
        $time_from=$data['time2'];
        foreach($data['cat_id'] as $key=>$value){

          $required_time= DB::table('categories')->where(['org_id'=>Auth::guard('customers')->user()->org_id,'active'=>1])->where('id',$value)->first()->required_time;
          $reservation_details=new ReserveDetails();
          $reservation_details->reserve_id=$reservation->id;
          $reservation_details->reservation_dt=$data['date'];
          $reservation_details->cat_id=$value;
          $reservation_details->av_day=$day;
          $reservation_details->av_time_from=$time_from;
          $reservation_details->av_time_to=$time_from +$required_time;
          $reservation_details->av_time_from=$time_from;
          $reservation_details->org_id=Auth::guard('customers')->user()->org_id;
          $reservation_details->user_id=Auth::guard('customers')->user()->id;
          $reservation_details->save();
          $time_from+=$required_time;

            }




       // return redirect('/admin/reservations')->with('store_status','success');
        Session::flash('message',__('strings.finish_reservation and will_contact'));
        //return redirect('/customerdashboard');
        return redirect('/CustomerReservations')->withInput(['tab'=>'tabelres3'])->with('store_status','success');
    }

    public function storeadmin(Request $request)
    {
       $data = $request->all();
        $day_name = Carbon::parse($data['date'])->format('l');
        $day = getDayNumber($day_name);
        $reservation = new Reservation;
        $reservation->cust_id=$data['customer'];
        $reservation->captain_id=$data['captin_id'];
        $reservation->reservation_date=$data['date'];
        $reservation->comment=$data['description'];
        if(Settings::where(['key' => 'reservation_type', 'org_id' => Auth::user()->org_id])->value('value') == 1){
          $reservation->type=1;
          $reservation->confirm='y';
        }
        else{
          $reservation->type=0;
        }
        $reservation->user_id = Auth::user()->id;
        $reservation->org_id = Auth::user()->org_id;
        $reservation->active=1;
        $reservation->save();
          if(Settings::where(['key' => 'reservation_type', 'org_id' => Auth::user()->org_id])->value('value') == 1){
          foreach($data['cat_id'] as $key=>$value){
            $reservation_details=new ReserveDetails();
            $reservation_details->reserve_id=$reservation->id;
            $reservation_details->reservation_dt=$data['date'];
            $reservation_details->cat_id=$value;
            $reservation_details->av_day=$day;
            $reservation_details->av_time_from=0;
            $reservation_details->av_time_to=0;
            $reservation_details->org_id=Auth::user()->org_id;
            $reservation_details->user_id=Auth::user()->id;
            $reservation_details->save();
          }
          $user = customersModel::where('org_id',$reservation->org_id)->where('id',$reservation->cust_id)->first();
          event(new notifyEvent($user,$reservation,'reservations'));
          return redirect('/admin/reservations')->with('store_status','success');
        }
        $time_from=$data['start_time'];
        foreach($data['cat_id'] as $key=>$value){

          $required_time= DB::table('categories')->where(['org_id'=>Auth::user()->org_id,'active'=>1])->where('id',$value)->first()->required_time;
          $reservation_details=new ReserveDetails();
          $reservation_details->reserve_id=$reservation->id;
          $reservation_details->reservation_dt=$data['date'];
          $reservation_details->cat_id=$value;
          $reservation_details->av_day=$day;
          $reservation_details->av_time_from=$time_from;
          $reservation_details->av_time_to=$time_from +$required_time;
          $reservation_details->av_time_from=$time_from;
          $reservation_details->org_id=Auth::user()->org_id;
          $reservation_details->user_id=Auth::user()->id;
          $reservation_details->save();
          $time_from+=$required_time;

            }

                    $user = customersModel::where('org_id',$reservation->org_id)->where('id',$reservation->cust_id)->first();
                    event(new notifyEvent($user,$reservation,'reservations'));




       return redirect('/admin/reservations')->with('store_status','success');
       //return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          $reservation=Reservation::where('org_id',Auth::user()->org_id)->where('id',$id)->first();

    $reservation->name= app()->getLocale() == 'ar' ? Customers::where('id', $reservation->cust_id)->value('name') : Customers::where('id', $reservation->cust_id)->value('name_en');

    $reservation_details=ReserveDetails::where('org_id',Auth::user()->org_id)->where('reserve_id',$reservation->id)->get();
    $start_time=ReserveDetails::where('org_id',Auth::user()->org_id)->where('reserve_id',$reservation->id)->first()->av_time_from;
    $total=0;

    foreach($reservation_details as $reservation_detail){
      $required_time=Category::where('id', $reservation_detail->cat_id)->value('required_time')*30;
      $reservation_detail->name=app()->getLocale() == 'ar' ? Category::where('id', $reservation_detail->cat_id)->value('name') : Category::where('id', $reservation->cat_id)->value('name_en');
      $reservation_detail->required_time=$required_time;

      $total+=$required_time;
    }

        return view('reservation.admin.show',compact('reservation','reservation_details','total','start_time'));
    }

    /**
     * Edit reservation
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if (permissions('edit_reservation') == 0 ) {

              //set session message
              Session::flash('message', __('strings.do_not_have_permission'));
              return view('permissions');
            }
        $reservation = Reservation::findOrFail($id);
        $reserved_captin=User::where('id',$reservation->captain_id)->first();
        $reserved_services=ReserveDetails::where('reserve_id',$reservation->id)->where('org_id',Auth::user()->org_id)->get();
        $services = CategoriesType::where(['org_id'=>Auth::user()->org_id,'type'=>2,'active'=>1])->orderBy('name','name_en')->get();
         foreach($services as $service){
             $service->categories=DB::table('categories')->where(['org_id'=>Auth::user()->org_id,'active'=>1])->where('category_type_id',$service->id)->whereNotNull('required_time')->get();
              foreach($service->categories as $category){
           $category->time=$category->required_time *30;

           $price=cat_price($category->id)['catPrice'];
           if($price==null){
               $category->price=0;
           }
           else{
                $category->price=$price;
           }

         }
         }

     $start_id=$reserved_services->min('av_time_from');
     $end_id=$reserved_services->min('av_time_to');

      $shift_captins=UserShift::where('org_id',Auth::user()->org_id)->pluck('captin_id');
      $captins=User::whereIn('id',$shift_captins)->where('org_id',Auth::user()->org_id)->where('is_active',1)->get();
      $countries = Countries::all();
      $customers = Customers::where(['org_id'=>Auth::user()->org_id,'active'=>1])->select('id','name','name_en')->get();
      return view('reservation.admin.edit')->with('services',$services)
          ->with('categories',$categories)
          ->with('captins',$captins)
          ->with('countries',$countries)
          ->with('customers',$customers)
          ->with('reserved_categories',$reserved_categories)
          ->with('check_array',json_encode($check_array))
          ->with('currency',$currency)
          ->with('reserved_captin',$reserved_captin)
          ->with('reservation',$reservation)
          ->with('start_id',$start_id)
          ->with('end_id',$end_id);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservation  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
      ReserveDetails::where('reserve_id',$data['reservation_id'])->where('org_id',Auth::user()->org_id)->delete();
      Reservation::where('id',$data['reservation_id'])->where('org_id',Auth::user()->org_id)->delete();

      $day_name = Carbon::parse($data['date'])->format('l');
      $day = getDayNumber($day_name);
      $reservation = new Reservation;
      $reservation->cust_id=$data['customer'];
      $reservation->captain_id=$data['captin_id'];
      $reservation->reservation_date=$data['date'];
      $reservation->comment=$data['description'];
      $reservation->user_id = Auth::user()->id;
      $reservation->org_id = Auth::user()->org_id;
      $reservation->active=1;
      $reservation->save();
      $time_from=$data['start_time'];
      foreach($data['cat_id'] as $key=>$value){

        $required_time= DB::table('categories')->where(['org_id'=>Auth::user()->org_id,'active'=>1])->where('id',$value)->first()->required_time;
        $reservation_details=new ReserveDetails();
        $reservation_details->reserve_id=$reservation->id;
        $reservation_details->reservation_dt=$data['date'];
        $reservation_details->cat_id=$value;
        $reservation_details->av_day=$day;
        $reservation_details->av_time_from=$time_from;
        $reservation_details->av_time_to=$time_from +$required_time;
        $reservation_details->av_time_from=$time_from;
        $reservation_details->org_id=Auth::user()->org_id;
        $reservation_details->user_id=Auth::user()->id;
        $reservation_details->save();
        $time_from+=$required_time;

          }
        return redirect('/admin/reservations')->with('store_status','success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }

    /**
     * Get Categories that have a specific category type id
     *
     * @param  $category_type_id
     * @return \Illuminate\Http\Response
     *////////////
    public function getCategoriesByTypeID($category_type_id){
        if(Auth::guard('customers')->user() != null){
            return Category::where(['category_type_id' => $category_type_id,'active'=>1,'org_id' => Auth::guard('customers')->user()->org_id])->select('id','name','name_en')->get();
        }
        else{
            return Category::where(['category_type_id' => $category_type_id,'active'=>1,'org_id' => Auth::user()->org_id])->select('id','name','name_en')->get();
        }
    }


    /**
     * Get The available captains in certain day
     *
     * @param  $dates
     * @return \Illuminate\Http\Response
     */
     public function getAvailableCaptainsInDay_customer($date){
        $dayName = Carbon::parse($date)->format('l');
        $day = getDayNumber($dayName);
        $reservation = new Reservation;
        $captainsAvailableInDay = $reservation->captainsAvailableInDay_customer($day);
        return $captainsAvailableInDay;
    }
     public function getAvailableCaptainsInDay_admin($date){
        $dayName = Carbon::parse($date)->format('l');
        $day = getDayNumber($dayName);
        $reservation = new Reservation;
        $captainsAvailableInDay = $reservation->captainsAvailableInDay_admin($day);
        return $captainsAvailableInDay;
    }

    /**
     * Get captain available times
     *
     * @param  $captain_id , $date
     * @return \Illuminate\Http\Response
     */
    public function getCaptainAvTimes($captain_id,$date)
    {
      $captin_id=$request->staff_id;
      $date=$request->date;
      $duration=$request->duration/30;
      $reservation = new Reservation;
      $dayName = Carbon::parse($date)->format('l');
      $day = getDayNumber($dayName);

      $times = $reservation->captainAvailableTimes($captin_id,$day,$date,$duration);
      // $nonReservedAvailableTimes = $reservation->nonReservedAvailableTimes2($captain_id,$date,$times);
      // $availableTimes = availableTimes($nonReservedAvailableTimes);
      return $times;
    }
    
      public function getReservedCaptainAvTimes($captain_id,$date,$reservation_id){
      $dayName = Carbon::parse($date)->format('l');
      $day = getDayNumber($dayName);
      $reservation = new Reservation;
      $reserved=Reservation::where([
          'id'=>$reservation_id,
          'org_id'=>Auth::user()->org_id,
          'active' => 1
      ])->pluck('av_time');

    $times = $reservation->captainAvailableTimes($captain_id,$day,$date);
      return Response::json(
          array(
              'times' => $times,
              'reserved'=>$reserved


          ));

    }
     public function getCaptainAvTimesCustomer($captain_id,$date)
    {
         $reservation = new Reservation;
       $dayName = Carbon::parse($date)->format('l');
       $day = getDayNumber($dayName);
       $duration=$duration/30;
       $times = $reservation->CustomerAvailableTimes($captain_id,$day,$date,$duration);
       // $nonReservedAvailableTimes = $reservation->nonReservedAvailableTimes2($captain_id,$date,$times);
       // $availableTimes = availableTimes($nonReservedAvailableTimes);
       return $times;
    }

    /**
     * Get The type of the category
     *
     * @param  $category_id
     * @return \Illuminate\Http\Response
     */
    public function getCategoryType($category_id)
    {
        $category_type_id = Category::where('id',$category_id)->value('category_type_id');
        $category_type = CategoriesType::where('id',$category_type_id)->select('id','name','name_en')->get();
        return $category_type;
    }

    /**
     * confirm a certain reservation
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm($id)
    {   if (permissions('confirm_reservation') == 0 ) {

            //set session message
 return Response::json(array(
                            'msg' =>'nopermisson' ,
                            ));
                       
                        
        }
        $today_date=date('Y-m-d');
        $missed_id=missed_time_id(strtotime(date("g:i a")));
        
          $reservation = Reservation::findOrFail($id);
          $reservation_time_from= ReserveDetails::where([
            'reserve_id' => $reservation->id,
            'org_id'=>Auth::user()->org_id
        ])->first()->av_time_from;
        $reservation_time_to= ReserveDetails::where([
            'reserve_id' => $reservation->id,
            'org_id'=>Auth::user()->org_id
        ])->first()->av_time_to;
        if($today_date>$reservation->reservation_date){
             return Response::json(array(
                            'msg' =>'missed' ,
                            ));
        }
        if($today_date==$reservation->reservation_date){
            if($missed_id > $reservation_time_from){
                return Response::json(array(
                            'msg' =>'missed' ,
                            ));
            }
        } 
          
           
        
        $confirmed_reservation=Reservation::where('org_id',Auth::user()->org_id)->where('confirm','y')->pluck('id');
        
        $minimum_confirmed_time_from = ReserveDetails::where([
            'reservation_dt' => $reservation->reservation_date,
            
        ])->whereIn('reserve_id',$confirmed_reservation)->min('av_time_from');
         $maximum_confirmed_time_to = ReserveDetails::where([
            'reservation_dt' => $reservation->reservation_date,
            
        ])->whereIn('reserve_id',$confirmed_reservation)->max('av_time_to');
        $confirmed=0;
        for($i=$minimum_confirmed_time_from;$i< $maximum_confirmed_time_to;$i++){
            if($reservation_time_from==$i){
                $confirmed=1;
            }
            if($reservation_time_from==$i){
                $confirmed=1;
            }
        }
        if($confirmed==1){
           return Response::json(array(
                            'msg' =>'pre_confirmed' ,
                            ));
            
        }
        
        $reservation = Reservation::findOrFail($id);
            $reservation->confirm = 'y';
            $reservation->save();
     return Response::json(array(
                            'msg' =>'confirmed' ,
                            ));
        

    }

    /**
     * confirm a certain reservation
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {  if (permissions('cancel_reservation') == 0 ) {

            //set session message

            Session::flash('message', __('strings.do_not_have_permission'));

            return view('permissions');

        }
        $reservation = Reservation::findOrFail($id);
        $reservation->confirm = 'c';
        $reservation->save();
        return redirect()->back();
    }

    /**
     * Get The categories that belong to a specific service type
     *
     * @param  $service_type
     * @return mixed
     */
    public function getCategoriesOfServiceType($service_type){
        $reservationInstance = new Reservation;
        $services = CategoriesType::where(['org_id'=>Auth::guard('customers')->user()->org_id,'type'=>2,'id'=>$service_type,'active'=>1])->get();
        $categories = DB::table('categories')->where(['org_id'=>Auth::guard('customers')->user()->org_id,'active'=>1])->whereIn('category_type_id',$services)->select('id','name','name_en')->get();
        $categoryPrices = $reservationInstance->getLastPriceList(Auth::guard('customers')->user()->org_id);
        $todayOffers = $reservationInstance->getLatestOffers(Auth::guard('customers')->user()->org_id);
        $categoriesObject = [];

        foreach ($categories as $i => $category){
            $photoID = Category::where('id',$category->id)->value('photo_id');
            $photo = Photo::where('id',$photoID)->value('file');
            $categoriesObject[$i]['category'] = $category;
            $categoriesObject[$i]['duration'] = Category::where('id', $category->id)->value('required_time')*30;
            $categoriesObject[$i]['photo'] = $photo;
            foreach ($categoryPrices as $categoryPrice){
                if($categoryPrice->id == $category->id){
                    $categoriesObject[$i]['final_price'] = $categoryPrice->final_price;
                }
            }
            foreach ($todayOffers as $offer){
                if($offer->id == $category->id){
                    $categoriesObject[$i]['offer_price'] = $offer->offer_price;
                }
            }
        }

        $categoriesObject = $reservationInstance->paginateCategoriesObject($categoriesObject,9,"s");
        return view('reservation.categories')->with('categories',$categoriesObject)->render();
    }

    public function getAdminReservation(){
       
     if (permissions('add_reservation') == 0 ) {

            //set session message

            Session::flash('message', __('strings.do_not_have_permission'));

            return view('permissions');

        }
      
        $services = CategoriesType::where(['org_id'=>Auth::user()->org_id,'type'=>2,'active'=>1])->orderBy('name','name_en')->get();
        foreach($services as $service){
            $service->categories=DB::table('categories')->where(['org_id'=>Auth::user()->org_id,'active'=>1])->where('category_type_id',$service->id)->whereNotNull('required_time')->get();
             foreach($service->categories as $category){
          $category->time=$category->required_time *30;
          
          $price=cat_price($category->id)['catPrice'];
          if($price==null){
              $category->price=0;
          }
          else{
               $category->price=$price;
          }
         
        }
        }
   
    
       

        $shift_captins=UserShift::where('org_id',Auth::user()->org_id)->pluck('captin_id');
        $captins=User::whereIn('id',$shift_captins)->where('org_id',Auth::user()->org_id)->where('is_active',1)->get();

$countries = Countries::all();
        // $captains = CaptinAvailable::where(['org_id'=>Auth::user()->org_id,'active'=>1])->select('captin_id')->distinct();
        // $captainsAvailable = User::where('is_active',1)->whereIn('id',$captains)->select('id','name','name_en')->get();
        $customers = Customers::where(['org_id'=>Auth::user()->org_id,'active'=>1])->select('id','name','name_en')->get();
          if(Settings::where(['key' => 'reservation_type', 'org_id' => Auth::user()->org_id])->value('value') == 1){
          $status="no time reservation";
          return view('reservation.admin.create_no_time')->with('services',$services)
          ->with('status',$status)
              ->with('services',$services)
              ->with('captins',$captins)
              ->with('countries',$countries)
              ->with('customers',$customers);
        }
        return view('reservation.admin.create')->with('services',$services)
            ->with('captins',$captins)
            ->with('countries',$countries)
            ->with('customers',$customers);
    }

    public function getReservationsWithFilters(Request $request){
      if (permissions('reservation_search') == 0 ) {

            //set session message

            Session::flash('message', __('strings.do_not_have_permission'));

            return view('permissions');

        }
        $reservationInstance = new Reservation;
        $shift_captins=UserShift::where('org_id',Auth::user()->org_id)->pluck('captin_id');
        $captins=User::whereIn('id',$shift_captins)->where('org_id',Auth::user()->org_id)->where('is_active',1)->get();
		$customers = Customers::where(['org_id'=>Auth::user()->org_id,'active'=>1])->select('id','name','cust_code','phone_number','name_en')->get();
        if(empty($request->all())){
            $date = Carbon::now()->format('Y-m-d');
            $reservations = $reservationInstance->getAllReservationsTableByDate($date,$date);
            return view('reservation.admin.search')->with('reservations',$reservations)->with('captains',$captins)->with('customers',$customers);
        }
        $conditions = collect([]);
        $conditions->push($request->only(['captain', 'customer', 'cust_code','phone_number','date_from', 'date_to']));

        $reservationsObject = Reservation::where(function($query) use ($conditions){

            if (!empty($conditions[0]['captain'])) {
                $query->where('captain_id', $conditions[0]['captain']);
            }
            if (!empty($conditions[0]['customer'])) {
                $query->where('cust_id', $conditions[0]['customer']);
            }
            if (!empty($conditions[0]['cust_code'])) {
                $customers = Customers::where('cust_code',$conditions[0]['cust_code'])->select('id')->get();
                $query->whereIn('cust_id',$customers);
            }
            if (!empty($conditions[0]['phone_number'])) {
                $customers = Customers::where('phone_number',$conditions[0]['phone_number'])->select('id')->get();
                $query->whereIn('cust_id',$customers);
            }
            if (!empty($conditions[0]['date_from'])) {
                $query->where('reservation_date','>=',$conditions[0]['date_from']);
            }
            if (!empty($conditions[0]['date_to'])) {
                $query->where('reservation_date','<=',$conditions[0]['date_to']);
            }

            return $query;
        })->where('org_id' , Auth::user()->org_id)->orderBy('reservation_date','desc')->paginate(20)->appends(request()->query());
        $reservations = $reservationInstance->getReservationsTableFiltered($reservationsObject);
        return view('reservation.admin.search')->with('reservations',$reservations)->with('captains',$captains)->with('customers',$customers);
    }
    
    public function getCaptainTimes(Request $request){

      $captin_id=$request->staff_id;
      $date=$request->date;
      $duration=$request->duration/30;
      $reservation = new Reservation;
      $dayName = Carbon::parse($date)->format('l');
      $day = getDayNumber($dayName);

      $times = $reservation->captainAvailableTimes($captin_id,$day,$date,$duration);
      // $nonReservedAvailableTimes = $reservation->nonReservedAvailableTimes2($captain_id,$date,$times);
      // $availableTimes = availableTimes($nonReservedAvailableTimes);
      return $times;
    }
    public function get_details($id){
           $reservation=Reservation::where('org_id',Auth::guard('customers')->user()->org_id)->where('id',$id)->first();

    $reservation->name= app()->getLocale() == 'ar' ? Customers::where('id', $reservation->cust_id)->value('name') : Customers::where('id', $reservation->cust_id)->value('name_en');

    $reservation_details=ReserveDetails::where('org_id',Auth::guard('customers')->user()->org_id)->where('reserve_id',$reservation->id)->get();
    $start_time=ReserveDetails::where('org_id',Auth::guard('customers')->user()->org_id)->where('reserve_id',$reservation->id)->first()->av_time_from;
    $total=0;

    foreach($reservation_details as $reservation_detail){
      $required_time=Category::where('id', $reservation_detail->cat_id)->value('required_time')*30;
      $reservation_detail->name=app()->getLocale() == 'ar' ? Category::where('id', $reservation_detail->cat_id)->value('name') : Category::where('id', $reservation->cat_id)->value('name_en');
      $reservation_detail->required_time=$required_time;

      $total+=$required_time;
    }
    return Response::json(
                        array(
                            'reservation' => $reservation,
                            'reservation_details'=>$reservation_details,
                            'total'=>$total,
                            'start_time'=>$start_time
                        ));

        
    }
    
       public function getReservedData($id){

     $check_array=ReserveDetails::where('reserve_id',$id)->where('org_id',Auth::user()->org_id)->pluck('cat_id')->toArray();
     $reservation = Reservation::findOrFail($id);
     return Response::json(
         array(
             'data' => $check_array,
             'cust_id'=>$reservation->cust_id,
             'captin_id'=>$reservation->captain_id
           ));


   }
   
    public function settings(){
     return view('reservation.admin.settings');
   }
   public function updatesettings(Request $request){
     if(Settings::where(['key' => 'reservation_type' , 'org_id' => Auth::user()->org_id])->doesntExist()) {
       Settings::create(['key' => 'reservation_type', 'value' => $request->reservation_type, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
     }
     else{
         Settings::where(['key' => 'reservation_type' , 'org_id' => Auth::user()->org_id])->update(['value' => $request->reservation_type, 'user_id' => Auth::user()->id]);
     }

  Session::flash('created', __('strings.settings_msg_8'));
  return redirect('admin/reservations/settings');
}



}

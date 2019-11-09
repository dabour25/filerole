<?php

namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use App\Locations;
  use App\Property;
  use App\CategoryNum;
  use App\Booking;
  use App\BookingDetails;
  use App\ClosingDateList;
  use App\Category;
  use DateTime;
  use App\Destinations;
  use DateInterval;
  use App\Customers;
  use App\Countries;
  use Auth;
  use App\CategoriesType;
  use App\CategoryDetails;
  use Mail;
  use App\Mail\BookingConfirmed;
  use App\propertyPaymethod;
  use App\Currency;
  use App\FacilityList;
  use Response;
  use App\property_policy;


class HotelReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hotel_reservations.index');
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
    public function search(Request $request){





      $date1 = new DateTime($request->date_from);
      $date2 = new DateTime($request->date_to);
      $numberOfNights= $date2->diff($date1)->format("%a");
      $location_ids=Locations::where('destination_id',$request->destination)->where('org_id',Auth::user()->org_id)->where('active',1)->pluck('id');
      
      if($request->hotel_id!=null){
        $hotels=Property::where('id',$request->hotel_id)->where('org_id',Auth::user()->org_id)->where('active',1)->whereIn('location_id',$location_ids)->get();
      }
      else{
          $hotels=Property::where('org_id',Auth::user()->org_id)->where('active',1)->whereIn('location_id',$location_ids)->get();
      }
      
      $start_date=$request->date_from;
      $end_date=$request->date_to;
      $org_id=Auth::user()->org_id;
      $booking_ids=Booking::where(function ($query) use ($org_id) {
            return $query->where('org_id', $org_id);
        })->where(function ($query) use ($start_date, $end_date) {
            $query->where(function ($query) use ($start_date, $end_date) {
                $query->where('book_from', '<=', $start_date)->where('book_to', '>=', $start_date);
            })->orWhere(function ($query) use ($start_date, $end_date) {
                $query->where('book_from', '<=', $end_date)->where('book_to', '>=', $end_date);
            })->orWhere(function ($query) use ($start_date, $end_date) {
                $query->where('book_from', '>=', $start_date)->where('book_to', '<=', $end_date);
            });
        })->pluck('id');
      

      $child_ages=$request->child_age;

$i=0;
$j=0;
$room_numbers_count=0;

      foreach($hotels as $hotel){
        $adult_no=$request->adult_no;
        $child_no=$request->child_no;

        foreach($request->child_age as $key=>$value){

          if($value > $hotel->max_kidage){
            $adult_no++;
            $child_no--;
          }
        }

          $people_no=$adult_no + $child_no;
          $room_types=CategoriesType::where('org_id',Auth::user()->org_id)->where('type',7)->where('active',1)->where('max_adult','>=',$adult_no)
          ->where('max_kids','>=',$child_no)->where('max_people','>=',$people_no)->pluck('id');
          $meal_plan_types=CategoriesType::where('org_id',Auth::user()->org_id)->where('type',8)->where('active',1)->pluck('id');
          $meal_plan_categories=Category::where('org_id',Auth::user()->org_id)->whereIn('category_type_id',$meal_plan_types)->pluck('id');

        $hotel->dest=app()->getLocale() == 'ar'?Destinations::where('id',$request->destination)->where('org_id',Auth::user()->org_id)->first()->name:Destinations::where('id',$request->destination)->where('org_id',Auth::user()->org_id)->first()->name_en;
        $hotel->rooms=Category::where('org_id',Auth::user()->org_id)->whereIn('category_type_id',$room_types)->where('property_id',$hotel->id)->get();


        if(count($hotel->rooms)==0){

          unset($hotels[$i]);
        }
        else{

          foreach($hotel->rooms as $hotel_room){



            $reserved_rooms=BookingDetails::where('org_id',Auth::user()->org_id)->whereIn('book_id',$booking_ids)->where('cat_id',$hotel_room->id)->where('room_status','y')->get()->count();
            
            $rooms_ids=CategoryNum::where('org_id',Auth::user()->org_id)->where('cat_id',$hotel_room->id)->pluck('id');



            $closed_rooms=  ClosingDateList::where(function($query) use ($org_id){
                             return $query->where('org_id',$org_id);
                             })->where(function($query) use ($rooms_ids){
                             return $query->whereIn('category_num_id',$rooms_ids);
                             })->where(function ($query) use ($start_date,$end_date ) {
                             $query->where(function ($query) use ($start_date, $end_date) {
                    $query->where('date_from', '<=', $start_date)->where('date_to', '>=', $start_date);
                })->orWhere(function ($query) use ($start_date,$end_date) {
                    $query->where('date_from', '<=',$end_date)->where('date_to', '>=', $end_date);
                })->orWhere(function ($query) use ($start_date,$end_date) {
                    $query->where('date_from','>=',$start_date )->where('date_to', '<=',$end_date);
                });
            })->get()->count();
                
                
                


            $availablerooms=CategoryNum::where('org_id',Auth::user()->org_id)->where('cat_id',$hotel_room->id)->get()->count();

           
            if($request->action=="waiting" || $request->action2=="waiting"){
              $hotel_room->numbers=$reserved_rooms-$closed_rooms;

            }
            else{
              $hotel_room->numbers=$availablerooms-($reserved_rooms+$closed_rooms);
            }
            if($hotel_room->numbers<=0){
              unset($hotel->rooms[$j]);
            }
            $hotel_room->meal_plans=CategoryDetails::where('cat_id',$hotel_room->id)->whereIn('catsub_id',$meal_plan_categories)->where('org_id',Auth::user()->org_id)->get();

            $room_only=Category::where('id',$hotel_room->id)->where('org_id',Auth::user()->org_id)->first();
            $room_only->id=0;

      $hotel_room->meal_plans->push($room_only);
            foreach($hotel_room->meal_plans as $meal_plan){
              if($meal_plan->id==0){
                $meal_plan->id=$hotel_room->id;
                $meal_plan->catsub_id=0;
                $meal_plan->name=app()->getLocale() == 'ar'?'غرفة فقط':'Room Only';

                $meal_plan->price=cat_price($hotel_room->id)['catPrice']*$numberOfNights;
                $meal_plan->tax_id=cat_price($hotel_room->id)['taxId'];
                $meal_plan->tax_val=cat_price($hotel_room->id)['catTax']*$numberOfNights;


              }
              else{
                $meal_plan->id=$hotel_room->id;
                $meal_plan->name=app()->getLocale() == 'ar'?Category::where('id',$meal_plan->catsub_id)->where('org_id',Auth::user()->org_id)->first()->name:Category::where('id',$meal_plan->catsub_id)->where('org_id',Auth::user()->org_id)->first()->name_en;
                $meal_plan->price=(cat_price($hotel_room->id)['catPrice']+$meal_plan->price)*$numberOfNights;
                $meal_plan->tax_id=cat_price($hotel_room->id)['taxId'];
                $meal_plan->tax_val=cat_price($hotel_room->id)['catTax'];

              }


              if($hotel_room->cancel_policy=='Free Cancellation'){
                $cancel_date = new DateTime($request->date_from);
              $cancel_date->sub(new DateInterval('P'.$hotel_room->cancel_days.'D'));

                $meal_plan->message=__('strings.cancel_reservation') .$cancel_date->format('Y-m-d');
              }
              else{
                $meal_plan->message=$hotel_room->cancel_policy;
              }
            }
            $room_numbers_count+=$hotel_room->numbers;
$j++;
          }

        }
        if($room_numbers_count==0){

          unset($hotels[$i]);

}

$i++;
      }

$action=$request->action;

if($request->hotel_id!=null){
  $hotel_id=$request->hotel_id;
  $date_from=$request->date_from;
  $date_to=$request->date_to;
  $action=$request->action2;
  return view('hotel_reservations.rooms',compact('hotels','numberOfNights','child_ages','hotel_id','date_from','date_to','adult_no','child_no','action'));
}


    return view('hotel_reservations.index',compact('hotels','numberOfNights','child_ages','action'));
    }

    public function reserve_hotel(Request $request){

      $cat_id=$request->cat_id[0];
      $tax_ids=$request->tax_ids[0];
      $tax_vals=$request->tax_vals[0];
      $child_ages=$request->child_ages1[0];
      $numbers=$request->numbers[0];
      $prices=$request->prices[0];
      $destination=$request->destination_id;
      $date_from=$request->date_from1;
      $date_to=$request->date_to1;
      $no_childs=$request->no_childs1;
      $no_adults=$request->no_adults1;
      $total_value=$request->total_value;
      $action=$request->action;
      $cat_ids=explode(',', $request->cat_id[0]);
      $rooms=Category::where(['org_id'=>Auth::user()->org_id,'active'=>1,])->whereIn('id',$cat_ids)->get();

      $sub_ids=$request->sub_ids[0];
      $hotel_id=$request->hotel_id;
      $customers = Customers::where(['org_id'=>Auth::user()->org_id,'active'=>1])->get();
      $countries = Countries::all();
      $additional_categories_types=CategoriesType::where(['org_id'=>Auth::user()->org_id,'active'=>1,'type'=>9])->pluck('id');
      $additional_categories=Category::where(['org_id'=>Auth::user()->org_id,'active'=>1,])->whereIn('category_type_id',$additional_categories_types)->get();
      $additional_services_types=CategoriesType::where(['org_id'=>Auth::user()->org_id,'active'=>1,'type'=>2])->pluck('id');
      $additional_services=Category::where(['org_id'=>Auth::user()->org_id,'active'=>1])->whereIn('category_type_id',$additional_services_types)->get();
      


       return view('hotel_reservations.complete_reservation',compact('customers','additional_categories','additional_services','countries','cat_id','child_ages','destination','date_from','date_to','no_childs','no_adults','tax_ids','tax_vals','total_value','sub_ids','hotel_id','numbers','prices','rooms','action'));
    }
    public function customer_detail($id){

      return Customers::where(['org_id'=>Auth::user()->org_id,'active'=>1,'id'=>$id])->first();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $date1 = new DateTime($request->date_from);
      $date2 = new DateTime($request->date_to);
      $numberOfNights= $date2->diff($date1)->format("%a");


      $hotel_id=$request->hotel_id;
   
      $previous_confirmation_number=Booking::where('property_id',$hotel_id)->where('org_id',Auth::user()->org_id)->latest()->first()->confirmation_no;
      if($previous_confirmation_number!=null){
        $confirmation_no=$previous_confirmation_number+1;
      }
      else{
        $confirmation_no=1;
      }
      $booking=new Booking();
      $booking->property_id=$hotel_id;
      $booking->confirmation_no=$confirmation_no;
      $booking->cust_id=$request->customer;
      $booking->book_from=$request->date_from;
      $booking->book_to=$request->date_to;
      $booking->mobile=$request->phone_number;
      $booking->email=$request->email;
      $booking->adult_no=$request->no_adults;
      $booking->chiled_no=$request->no_childs;
      $booking->source_type=$request->source;
      $booking->source_name=$request->source_name;
      $booking->remarks=$request->additional_requirements;
      $booking->nights=$numberOfNights;
      $booking->book_status=$request->status;
      $booking->payment_status	=0;
      $booking->final_price=$request->total_amount;
      $booking->org_id=Auth::user()->org_id;
      $booking->user_id=Auth::user()->id;
      $booking->save();
      $cat_ids = explode(',', $request->cat_id);
     
      $sub_ids=explode(',', $request->sub_ids);
      $tax_vals=explode(',', $request->tax_vals);
      $tax_ids=explode(',',$request->tax_ids);
      $numbers=explode(',',$request->numbers);
     
      $prices=explode(',',$request->prices);
$j=0;
      foreach($cat_ids as $key => $value){
       
        for($i=0;$i<$numbers[$key];$i++){
          $booking_details=new BookingDetails();
          $booking_details->book_id=$booking->id;
          $booking_details->cat_id=$value;
          $booking_details->catsub_id=$sub_ids[$key];
          $booking_details->type=0;
          $booking_details->cat_price=$prices[$key];
          $booking_details->number=1;
          $booking_details->cat_final_price=$prices[$key];
          $booking_details->tax=$tax_ids[$key];
          $booking_details->tax_val=$tax_vals[$key];
          $booking_details->room_status=$request->status;
          if($request->status=='y'){
              $start_date=$request->date_from;
              $end_date=$request->date_to;
              $org_id=Auth::user()->org_id;
              $booking_details->room_status='y';
              $rooms_ids = CategoryNum::where('org_id', Auth::user()->org_id)->where('cat_id', $value)->pluck('id');
              
            $bookings_the_same_date=Booking::where(function ($query) use ($org_id) {
                        return $query->where('org_id', $org_id);
                    })->where(function ($query) use ($start_date, $end_date) {
                        $query->where(function ($query) use ($start_date, $end_date) {
                            $query->where('book_from', '<=', $start_date)->where('book_to', '>=', $start_date);
                        })->orWhere(function ($query) use ($start_date, $end_date) {
                            $query->where('book_from', '<=', $end_date)->where('book_to', '>=', $end_date);
                        })->orWhere(function ($query) use ($start_date, $end_date) {
                            $query->where('book_from', '>=', $start_date)->where('book_to', '<=', $end_date);
                        });
                    })->pluck('id');
            $reserved_rooms=BookingDetails::whereIn('book_id',$bookings_the_same_date)->where('org_id',Auth::user()->org_id)->where('cat_id',$value)->where('room_status','y')->pluck('category_num_id');
            $closed_rooms=$closed_rooms = ClosingDateList::where(function ($query) use ($org_id) {
                        return $query->where('org_id', $org_id);
                    })->where(function ($query) use ($rooms_ids) {
                        return $query->whereIn('category_num_id', $rooms_ids);
                    })->where(function ($query) use ($start_date, $end_date) {
                        $query->where(function ($query) use ($start_date, $end_date) {
                            $query->where('date_from', '<=', $start_date)->where('date_to', '>=', $start_date);
                        })->orWhere(function ($query) use ($start_date, $end_date) {
                            $query->where('date_from', '<=', $end_date)->where('date_to', '>=', $end_date);
                        })->orWhere(function ($query) use ($start_date, $end_date) {
                            $query->where('date_from', '>=', $start_date)->where('date_to', '<=', $end_date);
                        });
                    })->pluck('category_num_id');

            $available_cat_num=CategoryNum::where('cat_id',$value)->where('org_id',Auth::user()->org_id)->whereNotIn('id',$reserved_rooms)->whereNotIn('id',$closed_rooms)->first()->id;
            $booking_details->category_num_id=$available_cat_num;
          }
          $booking_details->org_id=Auth::user()->org_id;
          $booking_details->user_id=Auth::user()->id;
          $booking_details->save();
          $j++;
        }

    }



if($request->room_id[0]!=0 &&$request->additional_category[0]!=0 && $request['additional_number'][0]!=null){
  foreach($request->room_id as $key => $value){

    $booking_details1=new BookingDetails();
    $booking_details1->book_id=$booking->id;
    $booking_details1->cat_id=$value;
    $booking_details1->catsub_id=$request->additional_category[$key];
    $booking_details1->type=1;
    $booking_details1->cat_price= $request['add_cat_price'][$key];

    $booking_details1->number=$request['additional_number'][$key];
    $booking_details1->cat_final_price=$request['add_cat_price'][$key];
    $booking_details1->tax=0;
    $booking_details1->tax_val=0;
    $booking_details1->org_id=Auth::user()->org_id;
    $booking_details1->user_id=Auth::user()->id;
    $booking_details1->save();
  }
}

if($request->services[0]!=0 && $request['services_number'][0]!=null){
  foreach($request->services as $key => $value){
    $booking_details2=new BookingDetails();
    $booking_details2->book_id=$booking->id;
    $booking_details2->cat_id=$value;
    $booking_details2->catsub_id=$value;
    $booking_details2->type=2;
    $booking_details2->cat_price=$request['service_cat_price'][$key];
    $booking_details2->number=$request['services_number'][$key];
    $booking_details2->cat_final_price=$request['service_cat_price'][$key]+$request['service_tax_val'][$key];
    $booking_details2->tax=$request['service_taxId'][$key];
    $booking_details2->tax_val=$request['service_tax_val'][$key];
    $booking_details2->org_id=Auth::user()->org_id;
    $booking_details2->user_id=Auth::user()->id;
    $booking_details2->save();
  }
}

//ghada change 

  $property_curency=Property::where('id',$hotel_id)->value('currency');
  $hotel_curency=Currency::where('id',$property_curency)->first();
  $rooms_bookings=BookingDetails::where('book_id',$booking->id)->get();
 // dd($rooms_bookings);
 // $rooms_bookings_details=BookingDetails::where('book_id',$booking->id)->where('type',0)->get();
 
  foreach($rooms_bookings as $rooms_booking ){
    $rooms_booking->facility=FacilityList::where('category_id',$rooms_booking->cat_id)->get();
  }
  $hotel_information=property_policy::join('policy_type','policy_type.id','=','property_policy.policy_type_id')->where('type',2)->where('property_policy.org_id',Auth::user()->org_id)->where('property_id',$hotel_id)->get();
  $prperty_payment_methods=propertyPaymethod::where(['org_id'=>Auth::user()->org_id,'property_id'=>$hotel_id,'active'=>1])->get();
  Mail::to($request->email)->send(new BookingConfirmed(['customer_id' => $request->customer, 'booking_number' => $confirmation_no,'hotel_id'=>$hotel_id,'no_nights' =>$numberOfNights,'no_rooms'=>$j,'date_from'=>$request->date_from,'date_to'=>$request->date_to,'total_price'=>$request->total_amount,'payment_methods'=>$prperty_payment_methods,'room_booked'=>$rooms_bookings,'hotel_curency'=>$hotel_curency,'number_days'=>$numberOfNights,'informations'=>$hotel_information]));



    return redirect('admin/hotel_bookings');



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
    
    public function get_additional_categories(Request $request){
      $cat_id=$request->cat_id;
      $additional_categories_types=CategoriesType::where(['org_id'=>Auth::user()->org_id,'active'=>1,'type'=>9])->pluck('id');
      $additional_categories_sub_ids=CategoryDetails::where('cat_id',$cat_id)->where('org_id',Auth::user()->org_id)->pluck('catsub_id');

      $additional_categories=app()->getLocale() == 'ar'?Category::where(['org_id'=>Auth::user()->org_id,'active'=>1,])->whereIn('category_type_id',$additional_categories_types)->whereIn('id',$additional_categories_sub_ids)->pluck('id','name'):Category::where(['org_id'=>Auth::user()->org_id,'active'=>1,])->whereIn('category_type_id',$additional_categories_types)->whereIn('id',$additional_categories_sub_ids)->pluck('id','name_en');

      return Response::json(
        array(
                'data'   =>$additional_categories ,
              ));

    }
    
    public function getcategoryprice(Request $request){
       $cat_id=$request->cat_id;
       $catsub_id=$request->catsub_id;
       $price=CategoryDetails::where('cat_id',$cat_id)->where('catsub_id',$catsub_id)->where('org_id',Auth::user()->org_id)->first();
       if($price!=null){

         return Response::json(
             array(
                 'data' => 'successGetPice',
                 'catPrice' =>$price->price ,
                 'catTax' => 0,
                 'taxId' => 0,
                 'flag' => 0,
             ));
       }
       else{
         return Response::json(
             array(
                 'data' => 'noPrice',
             ));
       }




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
}

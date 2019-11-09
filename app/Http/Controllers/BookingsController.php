<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\Customers;
use App\Property;
use App\Destinations;
use App\CategoriesType;
use App\Category;
use App\BookingDetails;
use App\Locations;
use App\ClosingDateList;
use App\CategoryNum;
use App\CategoryDetails;
use DateTime;
use Response;
use Session;
use App\Settings;
use Auth;
use App\Countries;
use App\FacilityList;
use App\Banking;
use App\book_cancel_reason;
use App\Photo;
use App\CustomerHead;
use App\Transactions;
use App\PermissionReceivingPayments;
use DB;




class BookingsController extends Controller
{

    public function index(){


      $booking_fields=Booking::where('org_id',Auth::user()->org_id)->get();
      $hotels=Property::where('org_id',Auth::user()->org_id)->get();
      $destinations=Destinations::where('org_id',Auth::user()->org_id)->get();
      $room_types=CategoriesType::where('org_id',Auth::user()->org_id)->where('type',7)->get();
      $customers=Customers::where('org_id',Auth::user()->org_id)->get();




      $bookings=Booking::where('org_id',Auth::user()->org_id)->orderBy('id', 'DESC')->get();
      foreach($bookings as $booking){
        $booking->hotel=app()->getLocale() == 'ar'?Property::where('id',$booking->property_id)->where('org_id',Auth::user()->org_id)->first()->name:Property::where('id',$booking->property_id)->where('org_id',Auth::user()->org_id)->first()->name_en;
        $booking->customer=app()->getLocale() == 'ar'?Customers::where('id',$booking->cust_id)->where('org_id',Auth::user()->org_id)->first()->name:Customers::where('id',$booking->cust_id)->where('org_id',Auth::user()->org_id)->first()->name_en;
        $booking->number_of_nights=(new DateTime($booking->book_to))->diff(new DateTime($booking->book_from))->format("%a");
      }
      return view('bookings.index',compact('bookings','booking_fields','hotels','destinations','room_types','customers'));
    }


    public function search(Request $request){

      $org_id=Auth::user()->org_id;
      $destination=$request->destination;
      $room_type=$request->room_type;
      $hotel=$request->hotel;
      $cust_id=$request->cust_id;
      $phone_number=$request->phone_number;
      $email=$request->email;
      $status=$request->status;
      $confirmation_no=$request->confirmation_no;
      $date_from=$request->date_from;
      $date_to=$request->date_to;

      $bookings =Booking::when($org_id, function ($q) use ($org_id) {
          return $q->where('org_id', $org_id);
      })
      ->when($date_from, function ($q) use ($from) {
          return $q->whereDate('book_from', '>=', $date_from);
      })
      ->when($date_to, function ($q) use ($to) {
          return $q->whereDate('book_to', '<=', $date_to);
      })
      ->when($hotel, function ($q) use ($hotel) {
          return $q->where('property_id',$hotel);
      })
      ->when($cust_id, function ($q) use ($cust_id) {
        if($cust->id==0){
          return $q;
        }
        else{
          return $q->where('cust_id', $cust_id);
        }

      })
      ->when($phone_number, function ($q) use ($phone_number) {
          return $q->where('mobile',$phone_number);
      })
      ->when($email, function ($q) use ($email) {
            return $q->where('email',$email);
      })
      ->when($status, function ($q) use ($status) {
            return $q->where('book_status',$status);
      })
      ->when($destination, function ($q) use ($destination) {
        $locations=Locations::where('destination_id',$destination)->where('org_id',Auth::user()->org_id)->pluck('id');
        $hotels=Property::where('org_id',Auth::user()->org_id)->whereIn('location_id',$locations)->pluck('id');

            return $q->whereIn('property_id',$hotels);
      })
      ->when($room_type, function ($q) use ($room_type) {
          $categories=Category::where('category_type_id',$room_type)->where('org_id',Auth::user()->org_id)->pluck('id');
          $booking_details=BookingDetails::where('org_id',Auth::user()->org_id)->whereIn('cat_id',$categories)->pluck('book_id');

            return $q->whereIn('id',$booking_details);
      })
      ->when($confirmation_no, function ($q) use ($confirmation_no) {
                return $q->where('confirmation_no',$confirmation_no);
      })->orderBy('id', 'DESC')->get();
      $booking_fields=Booking::where('org_id',Auth::user()->org_id)->get();
      $hotels=Property::where('org_id',Auth::user()->org_id)->get();
      $destinations=Destinations::where('org_id',Auth::user()->org_id)->get();
      $room_types=CategoriesType::where('org_id',Auth::user()->org_id)->where('type',7)->get();
      $customers=Customers::where('org_id',Auth::user()->org_id)->get();
      foreach($bookings as $booking){
        $booking->hotel=app()->getLocale() == 'ar'?Property::where('id',$booking->property_id)->where('org_id',Auth::user()->org_id)->first()->name:Property::where('id',$booking->property_id)->where('org_id',Auth::user()->org_id)->first()->name_en;
        $booking->customer=app()->getLocale() == 'ar'?Customers::where('id',$booking->cust_id)->where('org_id',Auth::user()->org_id)->first()->name:Customers::where('id',$booking->cust_id)->where('org_id',Auth::user()->org_id)->first()->name_en;
        $booking->number_of_nights=(new DateTime($booking->book_to))->diff(new DateTime($booking->book_from))->format("%a");
      }
      return view('bookings.index',compact('bookings','booking_fields','hotels','destinations','room_types'));

    }

    public function check_new_date(Request $request){

       $book_id=$request->id;
       $from_date=$request->from_date;
       $to_date=$request->to_date;
       $date1 = new DateTime($from_date);
       $date2 = new DateTime($to_date);
       $org_id=Auth::user()->org_id;
       $flag=0;
       $numberOfNights= $date2->diff($date1)->format("%a");

       $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$book_id)->first();
       $today = new DateTime(date('Y-m-d'));
       $difference = $today->diff(new DateTime($booking->book_from))->format("%a");
       $bookings_the_same_date=Booking::where(function ($query) use ($org_id) {
                        return $query->where('org_id', $org_id);
                    })->where(function ($query) use ($from_date, $to_date) {
                        $query->where(function ($query) use ($from_date, $to_date) {
                            $query->where('book_from', '<=', $from_date)->where('book_to', '>=', $to_date);
                        })->orWhere(function ($query) use ($from_date, $to_date) {
                            $query->where('book_from', '<=', $to_date)->where('book_to', '>=', $to_date);
                        })->orWhere(function ($query) use ($from_date, $to_date) {
                            $query->where('book_from', '>=', $from_date)->where('book_to', '<=', $to_date);
                        });
                    })->where('book_status','y')->pluck('id');


       $booked_rooms=BookingDetails::where('book_id',$book_id)->where('type',0)->where('org_id',Auth::user()->org_id)->get();
       $old_price=$booking->final_price;
         $new_rooms_price=0;
       foreach($booked_rooms as $booked_room){
         $room_policy=Category::where('org_id',Auth::user()->org_id)->where('id',$booked_room->cat_id)->first()->cancel_policy;


         if($room_policy!='free cancellation'){
           if($difference>=$room_policy->cancel_days){

           }
           else{
             return Response::json(
               array(
                       'data'   => 'cancel_policy',
                     ));
           }

         }
       $reserved_rooms=BookingDetails::whereIn('book_id',$bookings_the_same_date)->where('org_id',Auth::user()->org_id)->where('cat_id',$booked_room->cat_id)->get();
       $closed_rooms=ClosingDateList::where(function ($query) use ($org_id) {
                        return $query->where('org_id', $org_id);
                    })->where(function ($query) use ($from_date, $to_date) {
                        $query->where(function ($query) use ($from_date, $to_date) {
                            $query->where('date_from', '<=', $from_date)->where('date_to', '>=', $from_date);
                        })->orWhere(function ($query) use ($from_date, $to_date) {
                            $query->where('date_from', '<=', $to_date)->where('date_to', '>=', $to_date);
                        })->orWhere(function ($query) use ($from_date, $to_date) {
                            $query->where('date_from', '>=', $from_date)->where('date_to', '<=', $to_date);
                        });
                    })->where('cat_id',$booked_room->cat_id)->get();
       $available_rooms=CategoryNum::where('org_id',Auth::user()->org_id)->where('cat_id',$booked_room->cat_id)->get();
       $remaining_rooms=count($available_rooms)-(count($reserved_rooms)+count($closed_rooms));
       $booked_room_count=count(BookingDetails::where('book_id',$book_id)->where('type',0)->where('cat_id',$booked_room->cat_id)->where('org_id',Auth::user()->org_id)->get());
       if($booked_room->catsub_id==0){
         $new_rooms_price+=cat_price($booked_room->cat_id)['catPrice']*$numberOfNights;



       }
       else{
         $new_rooms_price+=(cat_price($booked_room->cat_id)['catPrice']+CategoryDetails::where('org_id',Auth::user()->org_id)->where('cat_id',$booked_room->cat_id)->where('catsub_id',$booked_room->catsub_id)->first()->price)*$numberOfNights;

       }

       if($remaining_rooms<$booked_room_count){
         $flag=1;
       }

       }

       if($flag==0){
         $new_price=$new_rooms_price+BookingDetails::where('book_id',$book_id)->where('type','!=',0)->where('org_id',Auth::user()->org_id)->sum('cat_final_price');
         return Response::json(
           array(
                   'data'   => 'available',
                   'old_date_from'   => date("D, Md, Y ", strtotime($booking->book_from)),
                   'date_from'=>$from_date,
                   'date_to'=>$to_date,
                   'old_date_to'   => date("D, Md, Y ", strtotime($booking->book_to)),
                   'new_date_from'   => date("D, Md, Y ", strtotime($from_date)),
                   'new_date_to'   => date("D, Md, Y ", strtotime($to_date)),
                   'new_nights'=>$numberOfNights,
                   'book_id'=>$booking->id,
                   'nights'=>$booking->nights,
                   'old_price'=>$old_price,
                   'new_price'=>$new_price
                 ));
       }
       else{
         return Response::json(
           array(
                   'data'   => 'not_available',
                   'old_date_from'   =>date("D, Md, Y ", strtotime($booking->book_from)),
                   'old_date_to'   => date("D, Md, Y ", strtotime($booking->book_to)),
                   'new_date_from'   => date("D, Md, Y ", strtotime($from_date)),
                   'new_date_to'   => date("D, Md, Y ", strtotime($to_date)),
                   'old_price'=>$old_price,

                 ));
       }






    }

    public function change_booking_date(Request $request){

      $book_id=$request->id;
      $from_date=$request->from_date;
      $to_date=$request->to_date;
      $nights=$request->nights;
      $price=$request->price;
      $booked_rooms=BookingDetails::where('book_id',$book_id)->where('type',0)->where('org_id',Auth::user()->org_id)->get();
      foreach($booked_rooms as $booked_room){
        if($booked_room->catsub_id==0){
          $booked_room->cat_price=cat_price($booked_room->cat_id)['catPrice']*$nights;
          $booked_room->cat_final_price=cat_price($booked_room->cat_id)['catPrice']*$nights;



        }
        else{
          $booked_room->cat_price=(cat_price($booked_room->cat_id)['catPrice']+CategoryDetails::where('org_id',Auth::user()->org_id)->where('cat_id',$booked_room->cat_id)->where('catsub_id',$booked_room->catsub_id)->first()->price)*$nights;
          $booked_room->cat_final_price=(cat_price($booked_room->cat_id)['catPrice']+CategoryDetails::where('org_id',Auth::user()->org_id)->where('cat_id',$booked_room->cat_id)->where('catsub_id',$booked_room->catsub_id)->first()->price)*$nights;
        }

        $booked_room->save();

      }
      $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$book_id)->first();
      $booking->book_from=$from_date;
      $booking->book_to=$to_date;
      $booking->nights=$nights;
      $booking->final_price=$price;

      $booking->save();
      return Response::json(
        array(
                'data'   => 'succesded',

              ));

    }
    public function available_rooms(Request $request){

      $people_no=$request->people;

      $book_id=$request->id;
      $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$book_id)->first();
      $book_from=$booking->book_from;
      $book_to=$booking->book_to;
      $org_id=Auth::user()->org_id;
      $booking_ids=Booking::where(function ($query) use ($org_id) {
                        return $query->where('org_id', $org_id);
                    })->where(function ($query) use ($book_from, $book_to) {
                        $query->where(function ($query) use ($book_from, $book_to) {
                            $query->where('book_from', '<=', $book_from)->where('book_to', '>=', $book_to);
                        })->orWhere(function ($query) use ($book_from, $book_to) {
                            $query->where('book_from', '<=', $book_to)->where('book_to', '>=', $book_to);
                        })->orWhere(function ($query) use ($book_from, $book_to) {
                            $query->where('book_from', '>=', $book_from)->where('book_to', '<=', $book_to);
                        });
                    })->pluck('id');
      $reserved_rooms=BookingDetails::where('org_id',Auth::user()->org_id)->whereIn('book_id',$booking_ids)->where('room_status','y')->pluck('category_num_id');
      $closed_rooms=ClosingDateList::where(function ($query) use ($org_id) {
                        return $query->where('org_id', $org_id);
                    })->where(function ($query) use ($book_from, $book_to) {
                        $query->where(function ($query) use ($book_from, $book_to) {
                            $query->where('date_from', '<=', $book_from)->where('date_to', '>=', $book_to);
                        })->orWhere(function ($query) use ($book_from, $book_to) {
                            $query->where('date_from', '<=', $book_to)->where('date_to', '>=', $book_to);
                        })->orWhere(function ($query) use ($book_from, $book_to) {
                            $query->where('date_from', '>=', $book_from)->where('date_to', '<=', $book_to);
                        });
                    })->pluck('category_num_id');

      $hotel_id=$booking->property_id;
      $numberOfNights=$booking->nights;
      $previous_price=$booking->final_price;
      $room_types=CategoriesType::where('org_id',Auth::user()->org_id)->where('type',7)->where('active',1)->where('max_people','>=',$people_no)->pluck('id');
      $meal_plan_types=CategoriesType::where('org_id',Auth::user()->org_id)->where('type',8)->where('active',1)->pluck('id');
      $meal_plan_categories=Category::where('org_id',Auth::user()->org_id)->whereIn('category_type_id',$meal_plan_types)->pluck('id');
      $rooms=Category::where('org_id',Auth::user()->org_id)->whereIn('category_type_id',$room_types)->where('property_id',$hotel_id)->get();


      if(count($rooms)==0){
        return Response::json(
          array(
                  'data'   => 'no_rooms',

                ));

        }
        $i=0;
          foreach($rooms as $room){
            $reserved_rooms=BookingDetails::where('org_id',Auth::user()->org_id)->whereIn('book_id',$booking_ids)->where('cat_id',$room->id)->where('room_status','y')->get()->count();
            $rooms_ids=CategoryNum::where('org_id',Auth::user()->org_id)->where('cat_id',$room->id)->pluck('id');

            $closed_rooms=ClosingDateList::where(function ($query) use ($org_id) {
                        return $query->where('org_id', $org_id);
                    })->where(function ($query) use ($book_from, $book_to) {
                        $query->where(function ($query) use ($book_from, $book_to) {
                            $query->where('date_from', '<=', $book_from)->where('date_to', '>=', $book_to);
                        })->orWhere(function ($query) use ($book_from, $book_to) {
                            $query->where('date_from', '<=', $book_to)->where('date_to', '>=', $book_to);
                        })->orWhere(function ($query) use ($book_from, $book_to) {
                            $query->where('date_from', '>=', $book_from)->where('date_to', '<=', $book_to);
                        });
                    })->whereIn('category_num_id',$rooms_ids)->get()->count();



            $booked_rooms=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$book_id)->where('cat_id',$room->id)->where('room_status','n')->get()->count();
            $availablerooms=CategoryNum::where('org_id',Auth::user()->org_id)->where('cat_id',$room->id)->get()->count();
            $room->numbers=$availablerooms-($reserved_rooms+$closed_rooms+$booked_rooms);

            if($room->numbers<=0){
              unset($rooms[$i]);
            }
            else{
              $room->meal_plans=CategoryDetails::where('cat_id',$room->id)->whereIn('catsub_id',$meal_plan_categories)->where('org_id',Auth::user()->org_id)->get();

            $room_only=Category::where('id',$room->id)->where('org_id',Auth::user()->org_id)->first();
            $room_only->id=0;
             $room->meal_plans->push($room_only);

              foreach($room->meal_plans as $meal_plan){
                if($meal_plan->id==0){
                  $meal_plan->id=$room->id;
                  $meal_plan->cat_id=$room->id;
                  $meal_plan->catsub_id=0;
                  $meal_plan->room_name=app()->getLocale() == 'ar'?$room->name:$room->name_en;
                  $meal_plan->name=app()->getLocale() == 'ar'?'غرفة فقط':'Room Only';

                  $meal_plan->price=cat_price($room->id)['catPrice']*$numberOfNights;
                  $meal_plan->total_price=$previous_price + $meal_plan->price;
                  $meal_plan->tax_id=cat_price($room->id)['taxId'];
                  $meal_plan->tax_val=cat_price($room->id)['catTax'];


                }
                else{
                  $meal_plan->id=$room->id;
                $meal_plan->room_name= app()->getLocale() == 'ar'?$room->name:$room->name_en;
                  $meal_plan->name=app()->getLocale() == 'ar'?Category::where('id',$meal_plan->catsub_id)->where('org_id',Auth::user()->org_id)->first()->name:Category::where('id',$meal_plan->catsub_id)->where('org_id',Auth::user()->org_id)->first()->name_en;
                  $meal_plan->price=(cat_price($room->id)['catPrice']+$meal_plan->price)*$numberOfNights;
                  $meal_plan->total_price=$previous_price + $meal_plan->price;
                  $meal_plan->tax_id=cat_price($room->id)['taxId'];
                  $meal_plan->tax_val=cat_price($room->id)['catTax'];

                }


                if($room->cancel_policy=='free cancellation'){
                  $cancel_date = new DateTime($request->date_from);
                $cancel_date->sub(new DateInterval('P'.$room->cancel_days.'D'));

                  $meal_plan->message=__('strings.cancel_reservation') .$cancel_date->format('Y-m-d');
                }
                else{
                  $meal_plan->message=$hotel_room->cancel_policy;
                }
              }
              $room_numbers_count+=$room->numbers;

            }
          $i++;
          }


        if($room_numbers_count==0){
          return Response::json(
            array(
                    'data'   => 'no_rooms',

                  ));
                }

                return Response::json(
                  array(
                          'data'   => 'rooms_available',
                          'rooms'=>$rooms

                        ));


      }

      public function add_rooms(Request $request){
        $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$request->id)->first();
        $booking->final_price=$request->total_price;
        $booking->save();

        $booking_details=new BookingDetails();
        $booking_details->book_id=$request->id;
        $booking_details->cat_id=$request->cat_id;
        $booking_details->catsub_id=$request->catsub_id;
        $booking_details->type=0;
        $booking_details->cat_price=$request->price;
        $booking_details->cat_final_price=$request->price;
        $booking_details->tax=$request->tax_id;
        $booking_details->tax_val=$request->tax_val;
        $booking_details->number=1;
        $booking_details->org_id=Auth::user()->org_id;
        $booking_details->user_id=Auth::user()->id;
        $booking_details->save();
        return Response::json(
          array(
                  'data'   => 'succesded',

                ));

      }

      public function get_booked_rooms(Request $request){
        $book_id=$request->id;

        $reservation_date = new DateTime(Booking::where('org_id',Auth::user()->org_id)->where('id',$book_id)->first()->book_from);
        $today = new DateTime(date('Y-m-d'));
        $difference = $today->diff($reservation_date )->format("%a");
        $rooms = BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$book_id)->where('type',0)->where('room_status','!=','c')->get();
        foreach($rooms as $room){
          $category=Category::where('org_id',Auth::user()->org_id)->where('id',$room->cat_id)->first();
          $room->name=app()->getLocale() == 'ar'?$category->name:$category->name_en;
          if($category->cancel_policy=='free cancellation'){
            $room->policy=app()->getLocale() == 'ar'?'مجانا':'Free';
            $room->charge=0;

          }
          else{
            if($difference>=$category->cancel_days){
              $room->policy=app()->getLocale() == 'ar'?'مجانا':'Free';
              $room->charge=0;
            }
            else{
              $room->policy=($category->cancel_charge*cat_price($room->cat_id)['catPrice'])/100;
              $room->charge=($category->cancel_charge*cat_price($room->cat_id)['catPrice'])/100;
            }
          }
          if($room->catsub_id==0){

            $room->meal_plan=app()->getLocale() == 'ar'?'غرفة فقط':'Room Only';

          }
          else{
              $room->meal_plan=app()->getLocale() == 'ar'?Category::where('id',$room->catsub_id)->where('org_id',Auth::user()->org_id)->first()->name:Category::where('id',$room->catsub_id)->where('org_id',Auth::user()->org_id)->first()->name_en;

          }

        }

        return Response::json(
          array(
                  'data'   => 'succesded',
                  'rooms'=>$rooms

                ));


      }

    public function cancel_room(Request $request){
      $book_id=$request->id;
      $cat_id=$request->cat_id;
      $catsub_id=$request->catsub_id;
      $charge=$request->charge;
      $canceled_room=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$book_id)->where('cat_id',$cat_id)->where('catsub_id',$catsub_id)->where('type',0)->first();
      $canceled_room->room_status='c';
      $canceled_room->cancel_dt=date("Y-m-d H:i:s"); ;
      $canceled_room->cancel_charge=$charge;
      $canceled_room->save();
      $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$book_id)->first();
      $booking->final_price=($booking->final_price+$charge)-$canceled_room->cat_final_price;
      $remaining_rooms=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$book_id)->where('type',0)->where('room_status','!=','c')->get()->count();
      if($remaining_rooms==0){
        $booking->book_status='c';
      }
      $booking->save();

      return Response::json(
        array(
                'data'   => 'succesded',
              ));

    }

    public function edit($book_id){
      $customers = Customers::where(['org_id'=>Auth::user()->org_id,'active'=>1])->get();
      $countries = Countries::all();

      $additional_categories=Category::where(['org_id'=>Auth::user()->org_id,'active'=>1,])->whereIn('category_type_id',$additional_categories_types)->get();
      $additional_services_types=CategoriesType::where(['org_id'=>Auth::user()->org_id,'active'=>1,'type'=>2])->pluck('id');
      $additional_services=Category::where(['org_id'=>Auth::user()->org_id,'active'=>1])->whereIn('category_type_id',$additional_services_types)->get();
      $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$book_id)->first();
      $booking_additional_categories=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$book_id)->where('type',1)->get();

      $booked_rooms=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$book_id)->where('type',0)->groupBy('cat_id')->get();

      foreach($booked_rooms as $booked_room){
        $booked_room->name=app()->getLocale() == 'ar'?Category::where(['org_id'=>Auth::user()->org_id,'active'=>1,])->where('id',$booked_room->cat_id)->first()->name:Category::where(['org_id'=>Auth::user()->org_id,'active'=>1,])->where('id',$booked_room->cat_id)->first()->name_en;
      }
      $additional_categories_types=CategoriesType::where(['org_id'=>Auth::user()->org_id,'active'=>1,'type'=>9])->pluck('id');
      foreach($booking_additional_categories as $booking_additional_category){
        $additional_categories_sub_ids=CategoryDetails::where('cat_id',$booking_additional_category->cat_id)->where('org_id',Auth::user()->org_id)->pluck('catsub_id');
        $booking_additional_category->additional_categories=Category::where(['org_id'=>Auth::user()->org_id,'active'=>1,])->whereIn('category_type_id',$additional_categories_types)->whereIn('id',$additional_categories_sub_ids)->get();
      }

      $booking_additional_services=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$book_id)->where('type',2)->get();
      $room_price=  BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$book_id)->where('type',0)->sum('cat_final_price');


      return view('bookings.edit',compact('customers','countries','additional_categories','additional_services','booking','booking_additional_services','booking_additional_categories','room_price','booked_rooms'));
    }

    public function update(Request $request){


      $booking=Booking::where('id',$request->book_id)->where('org_id',Auth::user()->org_id)->first();
      $booking->cust_id=$request->customer;
      $booking->mobile=$request->phone_number;
      $booking->email=$request->email;
      $booking->source_type=$request->source;
      $booking->book_status=$request->status;
      $booking->final_price=$request->total_amount;
      $booking->remarks=$request->additional_requirements;
      $booking->source_name=$request->source_name;
      $booking->save();
      BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$request->book_id)->where('type','!=',0)->delete();


      if($request->room_id[0]!=0 && $request->additional_category[0]!=0 &&$request['additional_number'][0]!=null){
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

      if($request->additional_requirements[0]!=0 && $request['services_number'][0]!=null){
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


      Session::flash('updated', __('strings.update_message'));

      return redirect('admin/hotel_bookings');

    }

    //ghada change
    //ghada change
 function show_resrvation($id){
     if(permissions('show_booking') == false){

         //set session message
         Session::flash('message', __('strings.do_not_have_permission'));
        return view('permissions');
     }
 $book=Booking::find($id);
 $date1 = new DateTime($book->book_from);
 $date2 = new DateTime($book->book_to);
 $numberOfNights= $date2->diff($date1)->format("%a");

 $book_details=BookingDetails::where('book_id',$id)->get();
$book_details_services1=BookingDetails::where('book_id',$id)->where('type',1)->get();
$book_details_services2=BookingDetails::where('book_id',$id)->where('type',2)->get();
 foreach( $book_details as $book_detail){
  $book_detail->room=Category::where('id',$book_detail->cat_id)->first();
  $book_detail->facility=FacilityList::where('category_id',$book_detail->cat_id)->get();
  foreach($book_detail->facility as $value){
    $value->cat=Category::where('id',$value->cat_id)->first();
  }

 }

return view('bookings.show',compact('book','book_details','numberOfNights','book_details_services1','book_details_services2'));
}

public function get_invoice_no(Request $request){

      $book_amount=Booking::where('org_id',Auth::user()->org_id)->where('id',$request->book_id)->first()->final_price;
      $invoice=get_invoice_number();
      return Response::json(
          array(
              'data' => 'succesded',
              'invoice_no' => $invoice['invoice_no'],
              'invoice_code'=>$invoice['invoice_code'],
              'amount_value'=>$book_amount

          ));

    }

    public function pay_confirm_booking(Request $request){
      $org_id=Auth::user()->org_id;

      $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$request->book_id)->first();
      $book_from=$booking->book_from;
      $book_to=$booking->book_to;
      $booking_rooms=BookingDetails::where('org_id', Auth::user()->org_id)->where('book_id', $booking->id)->where('type', 0)->where('room_status','n')->get();
      $booking_ids=Booking::where(function ($query) use ($org_id) {
                  return $query->where('org_id', $org_id);
              })->where(function ($query) use ($book_from, $book_to) {
                  $query->where(function ($query) use ($book_from, $book_to) {
                      $query->where('book_from', '<=', $book_from)->where('book_to', '>=', $book_from);
                  })->orWhere(function ($query) use ($book_from, $book_to) {
                      $query->where('book_from', '<=', $book_to)->where('book_to', '>=', $book_to);
                  })->orWhere(function ($query) use ($book_from, $book_to) {
                      $query->where('book_from', '>=', $book_from)->where('book_to', '<=', $book_to);
                  });
              })->pluck('id');

       foreach($booking_rooms as $booking_room){

        $reserved_rooms=BookingDetails::where('org_id',Auth::user()->org_id)->whereIn('book_id',$booking_ids)->where('cat_id',$booking_room->cat_id)->where('room_status','y')->get()->count();
        $rooms_ids=CategoryNum::where('org_id',Auth::user()->org_id)->where('cat_id',$booking_room->cat_id)->pluck('id');
        $closed_rooms=  ClosingDateList::where(function($query) use ($org_id){
                         return $query->where('org_id',$org_id);
                         })->where(function($query) use ($rooms_ids){
                         return $query->whereIn('category_num_id',$rooms_ids);
                         })->where(function ($query) use ($book_from,$book_to ) {
                         $query->where(function ($query) use ($book_from, $book_to) {
                $query->where('date_from', '<=', $book_from)->where('date_to', '>=', $book_from);
            })->orWhere(function ($query) use ($book_from,$book_to) {
                $query->where('date_from', '<=',$book_to)->where('date_to', '>=', $book_to);
            })->orWhere(function ($query) use ($book_from,$book_to) {
                $query->where('date_from','>=',$book_from)->where('date_to', '<=',$book_to);
            });
        })->get()->count();
        $availablerooms=CategoryNum::where('org_id',Auth::user()->org_id)->where('cat_id',$booking_room->cat_id)->get()->count();

        $numbers=$availablerooms-($reserved_rooms+$closed_rooms);
        if($numbers<=0){
          return Response::json(
              array(
                  'data' => 'failed',

              ));
        }
      }
        foreach($booking_rooms as $booking_room){
          $reserved_rooms=BookingDetails::whereIn('book_id',$booking_ids)->where('org_id',Auth::user()->org_id)->where('cat_id',$booking_room->cat_id)->where('room_status','y')->pluck('category_num_id');
          $rooms_ids=CategoryNum::where('org_id',Auth::user()->org_id)->where('cat_id',$booking_room->cat_id)->pluck('id');

          $closed_rooms=  ClosingDateList::where(function($query) use ($org_id){
                           return $query->where('org_id',$org_id);
                           })->where(function($query) use ($rooms_ids){
                           return $query->whereIn('category_num_id',$rooms_ids);
                           })->where(function ($query) use ($book_from,$book_to ) {
                           $query->where(function ($query) use ($book_from, $book_to) {
                  $query->where('date_from', '<=', $book_from)->where('date_to', '>=', $book_from);
              })->orWhere(function ($query) use ($book_from,$book_to) {
                  $query->where('date_from', '<=',$book_to)->where('date_to', '>=', $book_to);
              })->orWhere(function ($query) use ($book_from,$book_to) {
                  $query->where('date_from','>=',$book_from)->where('date_to', '<=',$book_to);
              });
          })->pluck('category_num_id');

          $available_cat_num=CategoryNum::where('cat_id',$booking_room->cat_id)->where('org_id',Auth::user()->org_id)->whereNotIn('id',$reserved_rooms)->whereNotIn('id',$closed_rooms)->first()->id;
          $updated_room=BookingDetails::where('org_id',Auth::user()->org_id)->where('cat_id',$booking_room->cat_id)->where('catsub_id',$booking_room->catsub_id)->where('book_id',$booking->id)->where('room_status','!=','y')->where('room_status','!=','c')->first();
          $updated_room->category_num_id=$available_cat_num;
          $updated_room->room_status='y';
          $updated_room->save();
          }

          $booking->book_status='y';
          $booking->invoice_no=$request->invoice_no;
          $booking->invoice_code=$request->invoice_no . $request->invoice_code;
          $booking->invoice_user=Auth::user()->id;
          $booking->invoice_date=date('Y-m-d h:i:s');
          $booking->invoice_template=Settings::where(['key' => 'invoice_template', 'org_id' => Auth::user()->org_id])->value('value');
          $booking->share_code=str_random(6);
          $booking->bank_treasure_id=$request->pay_method;
          $booking->pay_method=Banking::where('org_id',Auth::user()->org_id)->where('id',$request->pay_method)->first()->type;
          $booking->pay_gateway=1;
          $booking->pay_amount=$request->amount;
          $booking->save();






      return Response::json(
          array(
              'data' => 'succeede',

          ));


    }


    public function print_invoice($book_id){

      $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$book_id)->first();
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

    }

    public function cancel_booking_data(Request $request){

         $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$request->book_id)->first();
         $reservation_date = new DateTime($booking->book_from);
         $today = new DateTime(date('Y-m-d'));
         $booked_rooms=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$booking->id)->where('type',0)->get();
         $total_charge=0;
         foreach($booked_rooms as $booked_room){
           $category=Category::where('org_id',Auth::user()->org_id)->where('id',$booked_room->cat_id)->first();
           $booked_room->name=app()->getLocale() == 'ar'?$category->name:$category->name_en;
           if($category->cancel_policy=='free cancellation'){
             $booked_room->policy=app()->getLocale() == 'ar'?'مجانا':'Free';
             $booked_room->charge=0;

           }
           else{
             if($difference>=$category->cancel_days){
               $booked_room->policy=app()->getLocale() == 'ar'?'مجانا':'Free';
               $booked_room->charge=0;
             }
             else{
               $booked_room->policy=($category->cancel_charge*cat_price($booked_room->cat_id)['catPrice'])/100;
               $booked_room->charge=($category->cancel_charge*cat_price($booked_room->cat_id)['catPrice'])/100;
               $total_charge+=$booked_room->charge;
             }
           }
           if($booked_room->catsub_id==0){

             $booked_room->meal_plan=app()->getLocale() == 'ar'?'غرفة فقط':'Room Only';

           }
           else{
               $booked_room->meal_plan=app()->getLocale() == 'ar'?Category::where('id',$booked_room->catsub_id)->where('org_id',Auth::user()->org_id)->first()->name:Category::where('id',$booked_room->catsub_id)->where('org_id',Auth::user()->org_id)->first()->name_en;

           }

         }
         if($total_charge==0){
           $charge=app()->getLocale() == 'ar'?'مجانا':'Free';
          $pay_method=0;
         }
         else{
           $charge=$total_charge;
          $pay_method=1;
         }

         $cancel_reasons=app()->getLocale() == 'ar'?book_cancel_reason::where('org_id',Auth::user()->org_id)->where('property_id',$booking->property_id)->orderBy('rank')->pluck('id','name'):book_cancel_reason::where('org_id',Auth::user()->org_id)->where('property_id',$booking->property_id)->orderBy('rank')->pluck('id','name_en');


         return Response::json(
             array(
                 'data' => 'succeede',
                 'rooms'=>$booked_rooms,
                 'total_charge'=>$charge,
                 'cancel_reasons'=>$cancel_reasons,
                 'pay_method'=>$pay_method,
                 'nights'=>$booking->nights,
                 'book_from'=>$booking->book_from,
                 'book_to'=>$booking->book_to

             ));

    }

    public function confirm_cancel(Request $request){
     $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$request->book_id)->first();
     $booked_rooms=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$booking->id)->where('type',0)->get();
     $canceled_services=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$booking->id)->where('type','!=',0)->delete();
     $total_charge=0;
     $today = new DateTime(date('Y-m-d'));
     $difference = $today->diff(new DateTime($booking->book_from))->format("%a");
     foreach($booked_rooms as $booked_room){
       $category=Category::where('org_id',Auth::user()->org_id)->where('id',$booked_room->cat_id)->first();
       $canceled_room=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$booking->id)->where('type',0)->where('cat_id',$booked_room->cat_id)->where('catsub_id',$booked_room->catsub_id)->where('room_status','!=','c')->first();
       $canceled_room->room_status='c';
       $canceled_room->cancel_dt=date('Y-m-d h:i:s');

       if($category->cancel_policy=='free cancellation'){
      $canceled_room->cancel_charge=0;

       }
       else{
         if($difference>=$category->cancel_days){
             $canceled_room->cancel_charge=0;
         }
         else{

           $canceled_room->cancel_charge=($category->cancel_charge*cat_price($booked_room->cat_id)['catPrice'])/100;
           $total_charge+=$canceled_room->cancel_charge;
         }
       }
       $canceled_room->save();

     }
     $booking->book_status='c';
     $booking->cancel_dt=date('Y-m-d h:i:s');
     $booking->cancel_reason_id	=$request->cancel_reason_id;
     if($total_charge!=0){
       $booking->bank_treasure_id=$request->payment_method;
       $booking->pay_method=Banking::where('org_id',Auth::user()->org_id)->where('id',$request->payment_method)->first()->type;
       $booking->cancel_charge=$total_charge;
       $booking->pay_gateway=1;
     }

     $booking->save();
     return Response::json(
         array(
             'data' => 'succeede',
         ));

    }

    public function check_in_data(Request $request){
      $book_id=$request->book_id;
      $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$book_id)->first();
      $customer=Customers::where('org_id',Auth::user()->org_id)->where('id',$booking->cust_id)->first();
      $booking->cust_name=app()->getLocale() == 'ar'?$customer->name:$customer->name_en;
      $room_numbers=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$book_id)->where('type',0)->where('room_status','y')->pluck('category_num_id');

      if($customer->person_id==null && $customer->person_image==null){
        $code=0;
        $message=__('strings.notice that customer does not have averification');
      }
      else{
        $message='';
        $code=1;
      }
      return Response::json(
          array(
              'data' => 'succeede',
              'booking'=>$booking,
              'room_numbers'=>$room_numbers,
              'message'=>$message,
              'code'=>$code
          ));

    }

    public function check_in_customer_data(Request $request){

      $customer=Customers::where('org_id',Auth::user()->org_id)->where('id',$request->cust_id)->first();
      $customer->image_verify=$customer->person_image ? asset(Photo::find($customer->person_image)->file) : asset('images/profile-placeholder.png');

      return Response::json(
          array(
              'data' => 'succeede',
              'customer'=>$customer,
          ));


    }

    public function save_customer_id_data(Request $request){

      $customer=Customers::where('org_id',Auth::user()->org_id)->where('id',$request->verify_cust_id)->first();
      $customer->person_idtype=$request->person_type_id;
      $customer->person_id=$request->personal_id;
      if ($image = $request->file('person_image')) {
         //give a name to image and move it to public directory
         $image_person = time() . $image->getClientOriginalName();
         $image->move('images', $image_person);

         //persist data into photos table
         $photo = Photo::create(['file' => $image_person]);

         //save photo_id to user $input
         $input['person_image'] = $photo->id;
     }
     $customer->person_image= $input['person_image'];
     $customer->save();



    }


    public function check_in_booking(Request $request){
      $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$request->book_id)->first();
      $booking->checkin_dt=date('Y-m-d h:i:s');
      $booking->save();
      $booking_rooms=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$request->book_id)->where('room_status','y')->where('type',0)->get();
      $category_nums=explode(',', $request->room_numbers[0]);
      foreach($booking_rooms as $booking_room){
        foreach($category_nums as $key=>$value){
          $checked_id_room=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$request->book_id)->where('type',0)->where('room_status','y')->where('category_num_id',$value)->first();
          $checked_id_room->checkin_dt=date('Y-m-d h:i:s');
          $checked_id_room->save();
          $room=CategoryNum::where('org_id',Auth::user()->org_id)->where('id',$value)->first();
          $room->room_status='Occupied';
          $room->checkin_bookid=$request->book_id;
          $room->save();
        }

      }
      
      return Response::json(
          array(
              'data' => 'succeede',
            
          ));
    }
    
    
public function checkout_check_invoice(Request $request){
      $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$request->book_id)->first();
      $customer_id=$booking->cust_id;
      $customer_name=app()->getLocale() == 'ar'?Customers::where('org_id',Auth::user()->org_id)->where('id',$customer_id)->first()->name:Customers::where('org_id',Auth::user()->org_id)->where('id',$customer_id)->first()->name_en;
      $invoice_status=array(0,2,4);
      $unpaid_requests=CustomerHead::where('org_id',Auth::user()->org_id)->where('cust_id',$customer_id)->whereIn('invoice_status',$invoice_status)->get();
        $total_amount=0;
      foreach($unpaid_requests as $unpaid_request){
        if($unpaid_request->invoice_no==null){
          $unpaid_request->invoice_no=app()->getLocale() == 'ar'?'لم تصدر فاتورة':'invoice has not exported yet';
          $unpaid_request->invoice=null;
        }
        else{
          $unpaid_request->invoice=$unpaid_request->invoice_no;
        }

        $unpaid_request->required_amount=Decimalpoint(abs(DB::select('SELECT sum(quantity * req_flag * price)    AS price  FROM `transactions` WHERE  org_id = '.Auth::user()->org_id.' AND cust_req_id = '.$unpaid_request->id)[0]->price)) ;
        if($unpaid_request->invoice_status==0){
          $unpaid_request->paid_amount=0;
          $unpaid_request->remaining=$unpaid_request->required_amount;
        }
        else{
          $paid_value=PermissionReceivingPayments::where('customer_req_id',$unpaid_request->id)->where('pay_flag',1)->where('org_id',Auth::user()->org_id)->sum('pay_amount');
          $return_value=PermissionReceivingPayments::where('customer_req_id',$unpaid_request->id)->where('pay_flag',-1)->where('org_id',Auth::user()->org_id)->sum('pay_amount');
          $unpaid_request->paid_amount=$paid_amount=$paid_value-$return_value;
          $unpaid_request->remaining=$unpaid_request->required_amount-$unpaid_request->paid_amount;
        }

        $total_amount+=$unpaid_request->remaining;

      }
      if($unpaid_requests->count()==0){
        return Response::json(
            array(
                'data' => 'no_invoices',

            ));
      }

      return Response::json(
          array(
              'data' => 'succeede',
              'customer'=>$customer_name,
              'invoices'=>$unpaid_requests,
              'customer_id'=>$customer_id,
              'total'=>Decimalpoint($total_amount)

          ));

    }
    
      public function checkout_pay_invoice(Request $request){


      if($request->type==0){
        $remaining_amount=$request->remaining-$request->amount;

        $customer_req_head=CustomerHead::where('org_id',Auth::user()->org_id)->where('cust_id',$request->customer)->where('id',$request->request_id)->first();
        if($customer_req_head->invoice_no==null){
          $customer_req_head->invoice_no=get_invoice_number()['invoice_no'];
          $customer_req_head->invoice_code=get_invoice_number()['invoice_code'];
          $customer_req_head->invoice_date=date('Y-m-d h:i:s');
          $customer_req_head->invoice_user=Auth::user()->id;
          $customer_req_head->invoice_template=Settings::where(['key' => 'invoice_template', 'org_id' => Auth::user()->org_id])->value('value');

          }
          $customer_req_head->invoice_status=1;
          $customer_req_head->save();
          $PermissionReceivingPayments=new PermissionReceivingPayments();
          $PermissionReceivingPayments->pay_amount=$request->amount;
          $PermissionReceivingPayments->pay_date=date('Y-m-d');
          $PermissionReceivingPayments->bank_treasur_id=$request->bank_id;
          $PermissionReceivingPayments->pay_method=Banking::where('org_id',Auth::user()->org_id)->where('id',$request->bank_id)->first()->type;;
          $PermissionReceivingPayments->pay_flag=1;
          $PermissionReceivingPayments->customer_req_id=$request->request_id;
          $PermissionReceivingPayments->customer_id=$request->customer;
          $PermissionReceivingPayments->booking_id=$request->book_id;
          $PermissionReceivingPayments->org_id=Auth::user()->org_id;
          $PermissionReceivingPayments->user_id=Auth::user()->id;
          $PermissionReceivingPayments->save();

          if($remaining_amount<=0){
            $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$request->book_id)->first();
            $booking->checkout_dt=date('Y-m-d h:i:s');
            $booking->save();
            $booking_rooms=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$request->book_id)->where('room_status','y')->where('type',0)->get();

            foreach($booking_rooms as $booking_room){

                $checked_id_room=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$request->book_id)->where('type',0)->where('room_status','y')->where('category_num_id',$booking_room->category_num_id)->first();
                $checked_id_room->checkout_dt=date('Y-m-d h:i:s');
                $checked_id_room->room_status='n';
                $checked_id_room->save();
                $room=CategoryNum::where('org_id',Auth::user()->org_id)->where('id',$booking_room->category_num_id)->first();
                $room->room_status='vacant';
                $room->clean_status='dirty';
                $room->dont_disturb='no';
                $room->save();


            }
            return Response::json(
                array(
                    'data' => 'checked_out',

                ));
          }
          else{
            return Response::json(
                array(
                    'data' => 'not_checked_out',
                    'book_id'=>$request->book_id

                ));

          }

          }
          else{
            $requests_ids=explode(',', $request->request_ids);
            $remaining_amounts=explode(',', $request->remaining_amounts);
            $customer_req_head_ids=CustomerHead::where('org_id',Auth::user()->org_id)->where('cust_id',$request->customer)->whereIn('id',$requests_ids)->get();
            $i=0;
            foreach($customer_req_head_ids as $customer_req_head_id){
              $customer_req_head=CustomerHead::where('org_id',Auth::user()->org_id)->where('cust_id',$customer_req_head_id->cust_id)->where('id',$customer_req_head_id->id)->first();
              if($customer_req_head_id->invoice_no==null){

                $customer_req_head->invoice_no	=get_invoice_number()['invoice_no'];
                $customer_req_head->invoice_code=get_invoice_number()['invoice_code'];
                $customer_req_head->invoice_date=date('Y-m-d h:i:s');
                $customer_req_head->invoice_user=Auth::user()->id;
                $customer_req_head->invoice_template=Settings::where(['key' => 'invoice_template', 'org_id' => Auth::user()->org_id])->value('value');

                }
                $customer_req_head->invoice_status=1;
                $customer_req_head->save();
                $PermissionReceivingPayments=new PermissionReceivingPayments();
                $PermissionReceivingPayments->pay_amount=$remaining_amounts[$i];
                $PermissionReceivingPayments->pay_date=date('Y-m-d');
                $PermissionReceivingPayments->bank_treasur_id=$request->bank_id;
                $PermissionReceivingPayments->pay_method=Banking::where('org_id',Auth::user()->org_id)->where('id',$request->bank_id)->first()->type;;
                $PermissionReceivingPayments->pay_flag=1;
                $PermissionReceivingPayments->customer_req_id=$customer_req_head_id->id;
                $PermissionReceivingPayments->customer_id=$request->customer;
                $PermissionReceivingPayments->booking_id=$request->book_id;
                $PermissionReceivingPayments->org_id=Auth::user()->org_id;
                $PermissionReceivingPayments->user_id=Auth::user()->id;
                $PermissionReceivingPayments->save();
                $i++;
              }
              $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$request->book_id)->first();
              $booking->checkout_dt=date('Y-m-d h:i:s');
              $booking->save();
              $booking_rooms=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$request->book_id)->where('room_status','y')->where('type',0)->get();

              foreach($booking_rooms as $booking_room){

                  $checked_id_room=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$request->book_id)->where('type',0)->where('room_status','y')->where('category_num_id',$booking_room->category_num_id)->first();
                  $checked_id_room->checkout_dt=date('Y-m-d h:i:s');
                  $checked_id_room->save();
                  $room=CategoryNum::where('org_id',Auth::user()->org_id)->where('id',$booking_room->category_num_id)->first();
                  $room->room_status='vacant';
                  $room->clean_status='dirty';
                  $room->dont_disturb='no';
                  $room->save();


          }
          return Response::json(
              array(
                  'data' => 'checked_out',

              ));


    }



}

public function checkout_booking(Request $request){
  $booking=Booking::where('org_id',Auth::user()->org_id)->where('id',$request->book_id)->first();
  $booking->checkout_dt=date('Y-m-d h:i:s');
  $booking->save();
  $booking_rooms=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$request->book_id)->where('room_status','y')->where('type',0)->get();

  foreach($booking_rooms as $booking_room){

      $checked_id_room=BookingDetails::where('org_id',Auth::user()->org_id)->where('book_id',$request->book_id)->where('type',0)->where('room_status','y')->where('category_num_id',$booking_room->category_num_id)->first();
      $checked_id_room->checkout_dt=date('Y-m-d h:i:s');
      $checked_id_room->save();
      $room=CategoryNum::where('org_id',Auth::user()->org_id)->where('id',$booking_room->category_num_id)->first();
      $room->room_status='vacant';
      $room->clean_status='dirty';
      $room->dont_disturb='no';
      $room->save();


}
return Response::json(
  array(
      'data' => 'succeeded',

  ));

}




}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


// <!-- Last Modified  02/06/2019 16:40:17  -->

class Reservation extends Model
{
    public function captainsAvailableInDay_customer($day)
    {
        $captainsids = CaptinAvailable::where([
            'day' => $day,
            'active' => 1,
            'org_id' => Auth::guard('customers')->user()->org_id
        ])->select('captin_id')->get();

        $captains = User::whereIn('id', $captainsids)->orderBy('name')->select('id', 'name', 'name_en', 'photo_id')->get();
        foreach ($captains as $captain) {
            $captain['photo'] = Photo::where('id', $captain->photo_id)->value('file');
        }
        return $captains;
    }

    public function captainsAvailableInDay_admin($day)
    {


        $captainsids = CaptinAvailable::
        where([
            'day' => $day,
            'active' => 1,
            'org_id' => Auth::user()->org_id
        ])->select('captin_id')->get();
        $captains = User::whereIn('id', $captainsids)->orderBy('name')->select('id', 'name', 'name_en', 'photo_id')->get();
        foreach ($captains as $captain) {
            $captain['photo'] = Photo::where('id', $captain->photo_id)->value('file');
        }
        return $captains;
    }

    public function captainAvailableTimes($captain_id, $day, $date,$duration)
    {
        
      $available_shift_times=[];
      $captin_shifts=UserShift::where('captin_id',$captain_id)->where('org_id',Auth::user()->org_id)->pluck('shift_id');

      $minimum_shift_time=ShiftDay::where('org_id',Auth::user()->org_id)->where('shift_day',$day)->whereIn('shift_id',$captin_shifts)->min('time_from');
      $maximum_shift_time=ShiftDay::where('org_id',Auth::user()->org_id)->where('shift_day',$day)->whereIn('shift_id',$captin_shifts)->max('time_to');
      for($i=$minimum_shift_time;$i<=$maximum_shift_time;$i++){
        $available_shift_times[$i]=$i;
      }

        $confirmed_reservation = Reservation::where([
            'captain_id' => $captain_id,
            'reservation_date' => $date,
            'org_id'=>Auth::user()->org_id,
            'confirm' => 'y',
            'active' => 1
        ])->pluck('id');

        $check_from=ReserveDetails::whereIn('reserve_id',$confirmed_reservation)
        ->where('org_id',Auth::user()->org_id)
        ->where('av_day', $day)
        ->min('av_time_from');

        $check_to=ReserveDetails::whereIn('reserve_id',$confirmed_reservation)
        ->where('org_id',Auth::user()->org_id)
        ->max('av_time_to');
        for($i=$check_from;$i<=$check_to;$i++){
          unset($available_shift_times[$i]);
        }



 if(date('Y/m/d')==$date){
   $missed_id=missed_time_id(strtotime(date("g:i a")));


       $start_shift=min($available_shift_times);
       $end_shift=max($available_shift_times);

         if($end_shift<$missed_id){
           return [];
         }
         else{
           for($i=$start_shift;$i<=$end_shift;$i++){
             if($i<=$missed_id){
                 unset($available_shift_times[$i]);
             }
           }
         }
 }

      if(count($available_shift_times)<=1){
        return [];
      }

      for($i=0;$i<=48;$i++){


        if(($available_shift_times[$i]+$duration)!=$available_shift_times[$i+$duration]){
          unset($available_shift_times[$i]);
        }
      }


$times=availableTimes2($available_shift_times);




        return $times;
            
    }
 public function CustomerAvailableTimes($captain_id, $day, $date,$duration)
    {
       $available_shift_times=[];
            $captin_shifts=UserShift::where('captin_id',$captain_id)->where('org_id',Auth::guard('customers')->user()->org_id)->pluck('shift_id');

            $minimum_shift_time=ShiftDay::where('org_id',Auth::guard('customers')->user()->org_id)->where('shift_day',$day)->whereIn('shift_id',$captin_shifts)->min('time_from');
            $maximum_shift_time=ShiftDay::where('org_id',Auth::guard('customers')->user()->org_id)->where('shift_day',$day)->whereIn('shift_id',$captin_shifts)->max('time_to');
            for($i=$minimum_shift_time;$i<=$maximum_shift_time;$i++){
              $available_shift_times[$i]=$i;
            }

              $confirmed_reservation = Reservation::where([
                  'captain_id' => $captain_id,
                  'reservation_date' => $date,
                  'org_id'=>Auth::guard('customers')->user()->org_id,
                  'confirm' => 'y',
                  'active' => 1
              ])->pluck('id');

              $check_from=ReserveDetails::whereIn('reserve_id',$confirmed_reservation)
              ->where('org_id',Auth::guard('customers')->user()->org_id)
              ->where('av_day', $day)
              ->min('av_time_from');

              $check_to=ReserveDetails::whereIn('reserve_id',$confirmed_reservation)
              ->where('org_id',Auth::guard('customers')->user()->org_id)
              ->max('av_time_to');
              for($i=$check_from;$i<=$check_to;$i++){
                unset($available_shift_times[$i]);
              }



       if(date('Y-m-d')==$date){
         $missed_id=missed_time_id(strtotime(date("g:i a")));


             $start_shift=min($available_shift_times);
             $end_shift=max($available_shift_times);

               if($end_shift<$missed_id){
                 return [];
               }
               else{
                 for($i=$start_shift;$i<=$end_shift;$i++){
                   if($i<=$missed_id){
                       unset($available_shift_times[$i]);
                   }
                 }
               }
       }

            if(count($available_shift_times)<=1){
              return [];
            }

            for($i=0;$i<=48;$i++){


              if(($available_shift_times[$i]+$duration)!=$available_shift_times[$i+$duration]){
                unset($available_shift_times[$i]);
              }
            }


      $times=availableTimes2($available_shift_times);




              return $times;
    }
    public function checkIfTimeReserved($captain_id, $date, $time)
    {
        $check = Reservation::where([
            'captain_id' => $captain_id,
            'reservation_date' => $date,
            'av_time' => $time,
            'active' => 1
        ])->get();
        return $check;
    }

    public function nonReservedAvailableTimes($captain_id, $date, $availableTimes)
    {

        $reservedAvailableTimes = Reservation::where([
            'captain_id' => $captain_id,
            'reservation_date' => $date,
        ])->pluck('av_time');
        if ($reservedAvailableTimes->isEmpty()) {
            return $availableTimes;
        } else {
            $nonReservedAvailableTimes = [];
            for ($i = 0; $i < count($availableTimes); $i++) {
                for ($j = 0; $j < count($reservedAvailableTimes); $j++) {
                    if ($availableTimes[$i] != $reservedAvailableTimes[$j]) {
                        array_push($nonReservedAvailableTimes, $availableTimes[$i]);
                    } else {
                        break;
                    }
                }
            }
        }
        return $nonReservedAvailableTimes;
    }

    public function nonReservedAvailableTimes2($captain_id, $date, $availableTimes)
    {

        $reservedAvailableTimes = Reservation::where([
            'captain_id' => $captain_id,
            'reservation_date' => $date,
            'confirm' => 'y',

        ])->pluck('av_time');

        if ($reservedAvailableTimes->isEmpty()) {
            return $availableTimes;
        } else {
            $nonReservedAvailableTimes = [];
            for ($i = 0; $i < count($availableTimes); $i++) {
                $z = 0;
                for ($j = 0; $j < count($reservedAvailableTimes); $j++) {
                    if ($availableTimes[$i] != $reservedAvailableTimes[$j]) {
                        $z++;
                        if ($z == count($reservedAvailableTimes)) {
                            array_push($nonReservedAvailableTimes, $availableTimes[$i]);
                        }
                    }
                }
            }
        }
        return $nonReservedAvailableTimes;
    }

    public function paginateCategoriesObject($categoriesObject, $perpage, $pageName)
    {
        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage($pageName);

        // Create a new Laravel collection from the array data
        $itemCollection = collect($categoriesObject);

        // Define how many items we want to be visible in each page
        $perPage = $perpage;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage, $currentPage);
        $paginatedItems->setPageName($pageName);
        // set url path for generted links
        $paginatedItems->setPath(asset('/reservation'));
        return $paginatedItems;
    }

    /**
     * Get The categories services with photos
     *
     * @param  $service_type
     * @return mixed
     */
    public function getCategoriesServices()
    {
        $reservationInstance = new Reservation;
        $services = CategoriesType::where(['org_id' => Auth::guard('customers')->user()->org_id, 'type' => 2, 'active' => 1])->get();
        $serviceIds = [];
        foreach ($services as $service) {
            array_push($serviceIds, $service['id']);
        }
        $categories = DB::table('categories')->where(['org_id' => Auth::guard('customers')->user()->org_id, 'active' => 1])->whereIn('category_type_id', $serviceIds)->select('id', 'name', 'name_en')
            ->get();

        $categoryPrices = $reservationInstance->getLastPriceList(Auth::guard('customers')->user()->org_id);
        $todayOffers = $reservationInstance->getLatestOffers(Auth::guard('customers')->user()->org_id);
        $categoriesObject = [];

        foreach ($categories as $i => $category) {
            $photoID = Category::where('id', $category->id)->value('photo_id');
            $photo = Photo::where('id', $photoID)->value('file');
            $categoriesObject[$i]['category'] = $category;
            $categoriesObject[$i]['duration'] = Category::where('id', $category->id)->value('required_time')*30;
            $categoriesObject[$i]['photo'] = $photo;
            foreach ($categoryPrices as $categoryPrice) {
                if ($categoryPrice->id == $category->id) {
                    $categoriesObject[$i]['final_price'] = $categoryPrice->final_price;
                }
            }
            foreach ($todayOffers as $offer) {
                if ($offer->id == $category->id) {
                    $categoriesObject[$i]['offer_price'] = $offer->offer_price;
                }
            }
        }

        $categoriesObject = $this->paginateCategoriesObject($categoriesObject, 9, "c");
        return $categoriesObject;
    }

    /**
     * Get The The reservation table for all users
     *
     * @param
     * @return mixed
     */
    public function getAllReservationsTable()
    {
        $reservations = Reservation::select('id', 'cat_id', 'av_day', 'av_time', 'comment', 'captain_id', 'reservation_date', 'confirm')->paginate(20);
        foreach ($reservations as $reservation) {
            $reservations->category = Category::where('id', $reservation->cat_id)->value('name');
            $reservations->day = app()->getLocale() == 'ar' ? getDayNameArabic($reservation->av_day) : getDayName($reservation->av_day);
            $reservations->time = availableTimes($reservation->av_time, false);
            $reservations->captain = User::where('id', $reservation->captain_id)->value('name');
        }
        return $reservations;
    }

    /**
     * Get The The reservation table according to filters
     *
     * @param
     * @return mixed
     */
    public function getReservationsTableFiltered($reservations)
    {
        //$reservationsObject = [];
        foreach ($reservations as $i => $reservation) {

            if (app()->getLocale() == 'ar')
                $reservation->category = Category::where('id', $reservation->cat_id)->value('name');
            else
                $reservation->category = Category::where('id', $reservation->cat_id)->value('name_en');

            $reservation->day = app()->getLocale() == 'ar' ? getDayNameArabic($reservation->av_day) : getDayName($reservation->av_day);
            $reservation->time = availableTimes($reservation->av_time, false);
            if (app()->getLocale() == 'ar')
                $reservation->captain = User::where('id', $reservation->captain_id)->value('name');
            else
                $reservation->captain = User::where('id', $reservation->captain_id)->value('name_en');
            //$reservationsObject[$i]['comment'] = $reservation->comment;
            //$reservationsObject[$i]['reservation_date'] = $reservation->reservation_date;
            //$reservationsObject[$i]['confirm'] = $reservation->confirm;
            if (app()->getLocale() == 'ar')
                $reservation->customer = Customers::where('id', $reservation->cust_id)->value('name');
            else
                $reservation->customer = Customers::where('id', $reservation->cust_id)->value('name_en');
            $reservation->customer_phone = Customers::where('id', $reservation->cust_id)->value('phone_number');
        }
        return $reservations;
    }

    /**
     * Get The The reservation table for all users according to date
     *
     * @param
     * @return mixed
     */
    public function getAllReservationsTableByDate($date_from, $date_to)
    {
        $reservations = Reservation::where([
            ['reservation_date', '>=', $date_from],
            ['org_id', '=', Auth::user()->org_id],
            ['reservation_date', '<=', $date_to]
        ])->select('id', 'comment', 'captain_id', 'reservation_date', 'confirm', 'cust_id')->orderBy('reservation_date', 'desc')->paginate(20);

        //$reservationsObject = [];
        foreach ($reservations as $reservation) {
            $reservation->category = app()->getLocale() == 'ar' ? Category::where('id', $reservation->cat_id)->value('name') : Category::where('id', $reservation->cat_id)->value('name_en');
            $reservation->day = app()->getLocale() == 'ar' ? getDayNameArabic($reservation->av_day) : getDayName($reservation->av_day);
            $reservation->time = availableTimes($reservation->av_time, false);
            $reservation->captain = app()->getLocale() == 'ar' ? User::where('id', $reservation->captain_id)->value('name') : User::where('id', $reservation->captain_id)->value('name_en');
            $reservation->customer = app()->getLocale() == 'ar' ? Customers::where('id', $reservation->cust_id)->value('name') : Customers::where('id', $reservation->cust_id)->value('name_en');
            $reservation->customer_phone = Customers::where('id', $reservation->cust_id)->value('phone_number');
        }
        return $reservations;
    }

    /**
     * Get The The reservation table to a specific user
     *
     * @param
     * @return mixed
     */
    public function getReservationTable()
    {
        $reservations = Reservation::where([
            'cust_id' => Auth::guard('customers')->user()->id,
            'org_id' => Auth::guard('customers')->user()->org_id,
            'active' => 1
        ])->orderBy('reservation_date', 'desc')->paginate(20);
        foreach ($reservations as $reservation) {
            $reservations->category = app()->getLocale() == 'ar' ? Category::where('id', $reservation->cat_id)->value('name') : Category::where('id', $reservation->cat_id)->value('name_en');
            $reservations->day = app()->getLocale() == 'ar' ? getDayNameArabic($reservation->av_day) : getDayName($reservation->av_day);
            $reservations->time = availableTimes($reservation->av_time, false);
            $reservations->captain = app()->getLocale() == 'ar' ? User::where('id', $reservation->captain_id)->value('name') : User::where('id', $reservation->captain_id)->value('name_en');
        }
        return $reservations;
    }

    public function getLastPriceList($org_id)
    {
        $categoryidsObjects = DB::table('price_list as a')
            ->join(DB::raw('(select cat_id, max(date) date from price_list where date <= CURRENT_DATE and active = 1 and org_id = 1 group by cat_id) b'),
                function ($join) {
                    $join->on('a.cat_id', '=', 'b.cat_id')
                        ->on('a.date', '=', 'b.date');
                })
            ->select('a.id')
            ->get();
        $categoryids = [];
        foreach ($categoryidsObjects as $categoryidsObject) {
            array_push($categoryids, $categoryidsObject->id);
        }
        return DB::table('categories')
            ->join('photos', 'categories.photo_id', '=', 'photos.id')
            ->join('price_list', 'price_list.cat_id', '=', 'categories.id')
            ->where(['categories.org_id' => $org_id, 'categories.active' => 1])
            ->whereIn('price_list.id', $categoryids)
            ->select('categories.id', 'final_price')
            ->get();
    }

    public function getLatestOffers($org_id)
    {
        $categoryidsObjects = DB::table('offers as a')
            ->join(DB::raw('(select cat_id, max(date_to) date_to from offers where date_from <= CURRENT_DATE and date_to >= CURRENT_DATE and active = 1 and org_id = 1 group by cat_id) b'),
                function ($join) {
                    $join->on('a.cat_id', '=', 'b.cat_id')
                        ->on('a.date_to', '=', 'b.date_to');
                })
            ->select('a.id')
            ->get();
        $categoryids = [];
        foreach ($categoryidsObjects as $categoryidsObject) {
            array_push($categoryids, $categoryidsObject->id);
        }
        return DB::table('categories')
            ->join('photos', 'categories.photo_id', '=', 'photos.id')
            ->join('offers', 'offers.cat_id', '=', 'categories.id')
            ->where(['categories.org_id' => $org_id, 'categories.active' => 1])
            ->whereIn('offers.id', $categoryids)
            ->select('categories.id', 'offer_price')
            ->get();
    }


}



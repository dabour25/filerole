@extends('layouts.admin', ['title' =>__('strings.dashboard')])
<!-- Last Modified  02/05/2019 15:14:17  -->
@section('content')


  <div class="panel panel-white">
    <div class="panel-heading clearfix">
        <h4 class="panel-title">@lang('strings.mail_text6') {{$book->confirmation_no}} @lang('strings.in') {{app()->getLocale() =='ar'? \App\Property::find($book->property_id)->name : \App\Property::find($book->property_id)->name_en}} </h4>
    </div>
      <div class="panel-heading clearfix">
          <h4 class="panel-title">@lang('strings.mail_text5')</h4>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
         <div class="need-help">

            <p> @lang('strings.Units') @lang('strings.nights') {{$numberOfNights}} </p>
  			    <p>@lang('strings.number_rooms') {{ $book_details->where("type",0)->count() }} </p>
            <p>@lang('strings.check_in')  {{$book->book_from}} </p>
      	    <p>@lang('strings.check_out') {{$book->book_to}}</p>
      		  <p>@lang('strings.total_price') {{$book->final_price *$numberOfNights}} </p>

            <div class="panel-heading clearfix">
              <h4 class="panel-title">@lang('strings.rooms_details')</h4>
            </div>
             @foreach($book_details as $value)
             @if($value->type==0)
             @if($value->room_status=='y')
           <p class="old_price wow fadeIn" >{{app()->getLocale()=='ar'? \App\Category::find ($value->cat_id)->name : \App\Category::find ($value->cat_id)->name_en}}</p>
             @else
            <h4 class="panel-title"> {{app()->getLocale()=='ar'? \App\Category::find ($value->cat_id)->name : \App\Category::find ($value->cat_id)->name_en}}</h4>
            @endif
          <h4 class="panel-title">@lang('strings.Client_name'): {{app()->getLocale()=='ar'? \App\Customers::find ($book->cust_id)->name : \App\Customers::find ($book->cust_id)->name_en}}</h4>
          <table id="xtreme-table3" class="display table" style="width: 100%; cellspacing: 0;">
                      <thead>
                                                <tr>
                                                  <th>{{__('strings.furniture')}}</th>
                                                  <th>{{__('strings.Machines')}}</th>
                                                  <th>{{__('strings.meal_plan')}}</th>
                                                  <th>{{__('strings.cancelation_policy')}}</th>
                                                  <th>{{__('strings.room_price')}}</th>
                                                  <th>{{__('strings.services')}}</th>
                                                  <th>{{__('strings.services')}}</th>
                                                </tr>
                                            </thead>

                      <tr>
                      <td>
                     @foreach($value->facility as $catogtey)
                      @php
                      $cat_type=\App\CategoriesType::find($catogtey->cat->category_type_id)->type;
                      @endphp
                      @if($cat_type==6)
                      {{app()->getLocale()=='ar' ? $catogtey->cat->name : $catogtey->cat->name_en}}
                      @endif
                      @endforeach
                      </td>
                      <td>
                        @foreach($value->facility as $catogtey)
                         @php
                         $cat_type=\App\CategoriesType::find($catogtey->cat->category_type_id)->type;
                         @endphp
                         @if($cat_type==5)
                         {{app()->getLocale()=='ar' ? $catogtey->cat->name : $catogtey->cat->name_en}}
                         @endif
                         @endforeach
                      </td>
                         @if($value->catsub_id==0)
                         <td>@lang('strings.room_only')</td>
                         @else
                         <td>{{app()->getLocale() =='ar' ? \App\Category::find($value->catsub_id)->name : \App\Category::find($value->catsub_id)->name_en}}</td>
                         @endif
                         @if($value->room->cancel_policy=='free cancelation')
                         <td>@lang('strings.free_cancelation')</td>
                         @else
                         @php
                        $date=date_create($book->book_from);
                        date_sub($date,date_interval_create_from_date_string(" $value->room->cancel_days days"));
                        $cancel_date= date_format($date,"Y-m-d");
                        $charge=$value->room->cancel_charge/100;
                        @endphp
                         <td>free cancelation before{{$cancel_date}}after that you coast{{$value->cat_final_price*$charge}}</td>
                         @endif
                         @if($value->room_status=='y')
                         <td>{{$value->cancel_charge}}</td>
                         @else
                         <td>{{$value->cat_final_price*$numberOfNights}} @lang('strings.include_tax') {{$value->tax_val*$numberOfNights}}</td>
                          @endif
                          <td>
                            @foreach($book_details_services1 as $v1)
                        {{app()->getLocale()=='ar'? \App\Category::find ($v1->catsub_id)->name : \App\Category::find ($v1->catsub_id)->name_en}}
                          @endforeach
                        </td>
                          <td>
                          @foreach($book_details_services2 as $v2)
                          {{app()->getLocale()=='ar'? \App\Category::find ($v2->catsub_id)->name : \App\Category::find ($v2->catsub_id)->name_en}}
                          @endforeach
                          </td>

                          @endif

                      </tr>
                    </table>

                @endforeach

  				</div>



              </div>
        </div>
      </div>
    </div>
@endsection

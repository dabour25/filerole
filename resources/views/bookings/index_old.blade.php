@extends('layouts.admin', ['title' => __('strings.rooms') ])
@section('content')
    <style>
    .modal {
            display: none;

        }
        .badge{
          display:block !important;
        }
        td.details-control {
            background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
        }
    </style>
    <div class="modal newModal" id="PayandConfirm">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" onclick="close_pay_and_confirm()">&times;</button>
          </div>
          <div class="modal-body">
            <div class="row">
              {{-- <form  action="{{ Route('payServiceamount') }}" method="post" enctype="multipart/form-data"> --}}

                <div class="col-xs-12">
                  <br><br>
                  <label>{{__('strings.invoice_no')}} </label>
                  <input type="text"  name="invoice_no1" disabled>
                  <input type="hidden" name="invoice_no" >
                  <input type="hidden" name="invoice_code">
                  <input type="hidden" name="pay_book_id">
                </div>
                <br><br>


                <div class="col-xs-12">
                  <br><br>
                  <label> {{__('strings.payment_method')}} </label>
                    <select name="payment_method" class="form-control">
                      @foreach(\App\Banking::where('org_id',Auth::user()->org_id)->get() as $bank)
                        <option value="{{$bank->id}}">{{app()->getLocale() == 'ar' ? $bank->name:$bank->name_en}}</option>
                      @endforeach
                    </select>
                </div>
                <br><br>
                <div class="col-xs-12">
                  <br><br>
                  <label> {{__('strings.total_amount')}} </label>
                  <input type="text" class="form-control" placeholder="" name="amount" disabled>
                </div>
                <br><br>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="pay_confirm_booking()"><i class="fas fa-plus"></i>{{__('strings.save')}} </button>
            <button type="button" class="btn btn-danger" onclick="close_pay_and_confirm()"><i class="fas fa-times"></i>{{__('strings.close')}} </button>
          {{-- </form> --}}
          </div>
        </div>

      </div>
    </div>
    <div class="modal newModal" id="ConfirmCancelRoom" role="dialog">
            <div class="modal-dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="close_confirm_cancel_room()">&times;</button>
                </div>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body" style="overflow: hidden">

                      <h1>{{__('strings.cancel_rooms')}}</h1>
                      <br><br>
                     <h4 id="charge_hint"></h4>
                     <br><br>
                     <h4>{{__('strings.are_you_sure_delete_room')}}</h4>
                     <br><br>
                     <button class="btn btn-primary" onclick="confirm_cancel_room()">{{__('strings.confirm__room')}}</button>
                     <button class="btn btn-danger" onclick="confirmation__cancel_room_return_back()">{{__('strings.return_back')}}</button>
          <input type="hidden" name="confirm_cancel_room_book_id">
          <input type="hidden" name="confirm_cancel_room_cat_id">
          <input type="hidden" name="confirm_cancel_room_catsub_id">
          <input type="hidden" name="confirm_cancel_room_charge">


                </div>
            </div>
        </div>
      </div>
    <div class="modal newModal" id="CancelRoomSelect" role="dialog">
            <div class="modal-dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="close_cancel_room()">&times;</button>
                </div>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body" style="overflow: hidden">

                      <h1>{{__('strings.cancel_rooms')}}</h1>
                      <br><br>
                      <div class="table-responsive">
                            <table id="xtreme-table3" class="display table" style="width: 100%; cellspacing: 0;">
                                  <thead>
                                      <tr>
                                        <th>{{__('strings.room_name')}}</th>
                                        <th>{{__('strings.meal_plan')}}</th>
                                        <th>{{__('strings.tax')}}</th>
                                        <th>{{__('strings.room_price')}}</th>
                                        <th>{{__('strings.cancelation_policy')}}</th>
                                        <th> {{__('strings.Cancel')}}</th>
                                      </tr>

                                  </thead>
                                  <tbody></tbody>
                                      </table>


          </div>
          <input type="hidden" name="cancel_room_book_id">

                </div>
            </div>
        </div>
      </div>
    <div class="modal newModal" id="SelectRoomConfirmation" role="dialog">
            <div class="modal-dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="close_room_confirmation()">&times;</button>
                </div>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body" style="overflow: hidden">

                      <h1>{{__('strings.add_rooms')}}</h1>
                      <br><br>
                      <h4>{{__('strings.confirm_add_room')}}</h4>
                      <br><br>
                      <div class="col-md-12">
                        <div class="col-md-6">
                          <h4>{{__('strings.current_reservation')}}</h4>
                        </div>
                        <div class="col-md-6">
                          <h4 id="confirm_current_reservation"></h4>
                        </div>
                      </div>
                      <br><br>
                      <div class="col-md-12">
                        <div class="col-md-6">
                          <h4>{{__('strings.additional_room')}}</h4>
                        </div>
                        <div class="col-md-6">
                          <h4 id="confirm_additional_room"></h4>
                        </div>
                      </div>
                      <br><br>
                      <div class="col-md-12">
                        <div class="col-md-6">
                         <h4>{{__('strings.total_price_stay')}}</h4>
                        </div>
                        <div class="col-md-6">

                          <h4 id="confirm_total_room"></h4>
                        </div>
                      </div>

          <input type="hidden" name="confirm_book_id">
          <input type="hidden" name="confirm_cat_id">
          <input type="hidden" name="confirm_catsub_id">
          <input type="hidden" name="confirm_price">
          <input type="hidden" name="confirm_tax_id">
          <input type="hidden" name="confirm_tax_val">
          <input type="hidden" name="confirm_total_price">
         <br><br>
         <button class="btn btn-primary" onclick="confirm_add_room()">{{__('strings.confirm__room')}}</button>
         <button class="btn btn-danger" onclick="confirmation_return_back()">{{__('strings.return_back')}}</button>



                </div>
            </div>
        </div>
      </div>
    <div class="modal newModal" id="SelectRoomAvailable" role="dialog">
            <div class="modal-dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="close_select_room_available()">&times;</button>
                </div>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body" style="overflow: hidden">

                      <h1>{{__('strings.add_rooms')}}</h1>
                      <br><br>
                      <div class="table-responsive">
                            <table id="xtreme-table2" class="display table" style="width: 100%; cellspacing: 0;">
                                  <thead>
                                      <tr>
                                        <th>{{__('strings.room_name')}}</th>
                                        <th>{{__('strings.meal_plan')}}</th>
                                        <th>{{__('strings.room_price')}}</th>
                                        <th>{{__('strings.reservation_price')}}</th>
                                        <th> {{__('strings.select')}}</th>
                                      </tr>

                                  </thead>
                                  <tbody></tbody>
                                      </table>


          </div>
          <input type="hidden" name="select_room_book_id">

                </div>
            </div>
        </div>
      </div>
    <div class="modal newModal" id="NoRoomAvailable" role="dialog">
            <div class="modal-dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="close_no_room_available()">&times;</button>
                </div>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body" style="overflow: hidden">

                      <h1>{{__('strings.add_rooms')}}</h1>
                      <br><br>
                       <h4>{{__('strings.no_rooms_available')}}</h4>
                      <br><br><br>
                      <button class="btn btn-primary" onclick="close_no_room_available()">{{__('strings.ok')}}</button>

                </div>
            </div>
        </div>
      </div>
    <div class="modal newModal" id="AddRoomForm" role="dialog">
            <div class="modal-dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="close_add_room_form()">&times;</button>
                </div>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body" style="overflow: hidden">

                      <h1>{{__('strings.add_rooms')}}</h1>
                      <br><br>
                      <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                          <div class="input-group text">
                              <label>@lang('strings.numberofguests')</label>
                              <input name="guests" id="guests" type="number" min="0" class="form-control">
                              <input type="hidden" name="add_room_book_id">
                          </div>
                      </div>
                      <br><br><br>
                      <button class="btn btn-primary" onclick="get_rooms_to_add()">{{__('strings.continue')}}</button>
                      <button class="btn btn-danger" onclick="close_add_room_form()">{{__('strings.Cancel')}}</button>
                </div>
            </div>
        </div>
      </div>
    <div class="modal newModal" id="DatesCancelPolicy" role="dialog">
            <div class="modal-dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="dates_cancel_policy()">&times;</button>
                </div>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body" style="overflow: hidden">

                      <h1>{{__('strings.edit_dates')}}</h1>
                      <br><br>
                     <h4>{{__('strings.the rooms arent fully refundable')}}</h4>
<button class="btn btn-primary" onclick="dates_cancel_policy()">{{__('strings.ok')}}</button>
                </div>
            </div>
        </div>
      </div>
    <div class="modal newModal" id="DatesChangedModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="dates_changed_successfully()">&times;</button>
                </div>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body" style="overflow: hidden">

                      <h1>{{__('strings.edit_dates')}}</h1>
                      <br><br>
                     <h4>{{__('strings.dates changed successfully')}}</h4>
<button class="btn btn-primary" onclick="dates_changed_successfully()">{{__('strings.ok')}}</button>
                </div>
            </div>
        </div>
      </div>
    <div class="modal newModal" id="DatesAvailableModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="close_dates_available()">&times;</button>
                </div>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body" style="overflow: hidden">

                      <h1>{{__('strings.edit_dates')}}</h1>
                      <br><br>

                            <div class="row">
                          <div class="col-lg-12">
                            <div class="col-lg-10">
                              <h3>{{__('strings.old_details')}}</h3>
                              <br><br>
                              <div class="col-lg-5">
                                <h3>{{__('strings.chekin_date')}}</h3>
                                <br><br>
                                <h3 id="available_old_date_from"><h3>

                              </div>
                              <div class="col-lg-5">
                                <h3>{{__('strings.chekout_date')}}</h3>
                                <br><br>
                                <h3 id="available_old_date_to"><h3>

                              </div>
                            </div>
                            <div class="col-lg-2">
                              <h3 id="available_old_price"></h3>
                            </div>


                          </div>
                          <br><br>
                          <div class="col-lg-12">
                            <div class="col-lg-10">
                                <br><br>
                              <h3>{{__('strings.new_details')}}</h3>
                              <br><br>
                              <div class="col-lg-5">
                                <h3>{{__('strings.chekin_date')}}</h3>
                                <br><br>
                                <h3 id="available_new_date_from"><h3>

                              </div>
                              <div class="col-lg-5">
                                <h3>{{__('strings.chekout_date')}}</h3>
                                <br><br>
                                <h3 id="available_new_date_to"><h3>

                              </div>
                            </div>
                            <div class="col-lg-2">
                              <br><br>
                              <h3 id="available_new_price"></h3>
                            </div>


                          </div>
                          <br><br><br><br>

                            <input type="hidden" name="available_book_id">
                            <input type="hidden" name="available_new_date_from">
                            <input type="hidden" name="available_new_date_to">
                            <input type="hidden" name="available_new_price">
                            <input type="hidden" name="available_nights">
                             <div class="col-md-12">
                               <br><br><br>
                            <button class="btn btn-primary" onclick="submit_change_date()">{{__('strings.save')}}</button>
                            <button class="btn btn-primary" onclick="try_new_dates()">{{__('strings.return_back')}}</button>
                          </div>

                    </div>
                </div>
            </div>
        </div>
      </div>
    <div class="modal newModal" id="DatesNotAvailableModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="close_dates_not_available()">&times;</button>
                </div>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body" style="overflow: hidden">

                      <h1>{{__('strings.edit_dates')}}</h1>
                      <br><br>

                            <div class="row" >

                            <div class="col-lg-12">
                              <div class="">
                              <h4><span style="color:#8a2727">  {{__('strings.you_cant_change_dates')}}</span></h4>
                              </div>
                            </div>
                            <br><br><br><br><br>
                          <div class="col-lg-12">
                            <div class="col-lg-10">
                              <h3>{{__('strings.old_details')}}</h3>
                              <br><br>
                              <div class="col-lg-5">
                                <h3>{{__('strings.chekin_date')}}</h3>
                                <br><br>
                                <h3 id="old_date_from"><h3>

                              </div>
                              <div class="col-lg-5">
                                <h3>{{__('strings.chekout_date')}}</h3>
                                <br><br>
                                <h3 id="old_date_to"><h3>

                              </div>
                            </div>
                            <div class="col-lg-2">
                              <h3 id="old_price"></h3>
                            </div>


                          </div>
                          <br><br>
                          <div class="col-lg-12">
                            <div class="col-lg-10">
                                <br><br>
                              <h3>{{__('strings.new_details')}}</h3>
                              <br><br>
                              <div class="col-lg-5">
                                <h3>{{__('strings.chekin_date')}}</h3>
                                <br><br>
                                <h3 id="new_date_from"><h3>

                              </div>
                              <div class="col-lg-5">
                                <h3>{{__('strings.chekout_date')}}</h3>
                                <br><br>
                                <h3 id="new_date_to"><h3>

                              </div>
                            </div>
                            <div class="col-lg-2">
                              <br><br>
                              <h3 id="new_price"></h3>
                            </div>


                          </div>
                          <br><br><br><br>


                             <div class="col-md-12">
                               <br><br><br>
                            <button class="btn btn-primary" onclick="try_new_dates()">{{__('strings.try_dates')}}</button>
                          </div>

                    </div>
                </div>
            </div>
        </div>
      </div>

    <div class="modal newModal" id="ChangeDatesModal2" role="dialog">
            <div class="modal-dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="close_change_date_modal()">&times;</button>
                </div>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body" style="overflow: hidden">

                      <h4>{{__('strings.edit_dates')}}</h4>

                            <div class="row">

                              <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                  <div class="input-group text">
                                      <label>@lang('strings.Date_fromm')</label>
                                      <input name="date_from" class="form-control datepicker_reservation_change" id="date_from" type="text" value="{{date('Y-m-d')}}" class="form-control" required>
                                  </div>
                              </div>
                              <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                              </div>
                              <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                  <div class="input-group text">
                                      <label>@lang('strings.Date_too')</label>
                                      <input name="date_to" id="date_to" class="form-control datepicker_reservation2_change" type="text" value="{{date('Y-m-d')}}" class="form-control" required>
                                  </div>
                              </div>

                            </div>
                            <input type="hidden" name="change_date_book_id">

                            <button  class="btn btn-primary" onclick="check_availability()">{{__('strings.check_availability')}}</button>
                            <button class="btn btn-danger" onclick="close_change_date_modal()">{{__('strings.Cancel')}}</button>

                    </div>
                </div>
            </div>
        </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div id="booking_alerts">
              </div>
              @include('alerts.index')


                      <style>
                          .btn-primary:hover {
                              background: #2c9d6f !important;
                          }
                      </style>

                      <div class="alert_new">
                          <span class="alertIcon">
                              <i class="fas fa-exclamation-circle"></i>
                           </span>
                          <p>
                              @if (app()->getLocale() == 'ar')
            {{ DB::table('function_new')->where('id',257)->value('description') }}
            @else
            {{ DB::table('function_new')->where('id',257)->value('description_en') }}
            @endif
                          </p>
                          <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                          </a>
                      </div>
                      </br>

                        </br>

                    </br>
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">@lang('strings.bookings')</h4>
                        </div>
                        <div class="panel-body">
                          <form method="post" action="{{url('/admin/booking/search')}}" enctype="multipart/form-data" id="search_form">
                              {{csrf_field()}}
                              <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                    <label>@lang('strings.destination')</label>

                                    <select class="form-control js-select " name="destination">
                                        <option value="0">@lang('strings.All')</option>
                                        @foreach($destinations as $destination)

                                       <option {{ app('request')->input('destination') == $destination->id ? 'selected' : ''}} value="{{$destination->id}}">{{app()->getLocale() == 'ar' ?$destination->name:$destination->name_en}}</option>
                                       @endforeach
                                    </select>
                                </div>
                                  <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                      <label>@lang('strings.hotel')</label>

                                      <select class="form-control js-select " name="hotel">
                                          <option value="0">@lang('strings.All')</option>
                                          @foreach($hotels as $hotel)

                                         <option {{ app('request')->input('hotel') == $hotel->id ? 'selected' : ''}} value="{{$hotel->id}}">{{app()->getLocale() == 'ar' ?$hotel->name:$hotel->name_en}}</option>
                                         @endforeach
                                      </select>
                                  </div>
                                  <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                      <label>@lang('strings.room_type')</label>

                                      <select class="form-control js-select " name="room_type">
                                          <option value="0">@lang('strings.All')</option>
                                          @foreach($room_types as $room_type)

                                         <option {{ app('request')->input('room_type') == $room_type->id ? 'selected' : ''}} value="{{$room_type->id}}">{{app()->getLocale() == 'ar' ?$room_type->name:$room_type->name_en}}</option>
                                         @endforeach
                                      </select>
                                  </div>
                                  <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                      <label>@lang('strings.customer_name')</label>
                                      <select class="form-control  js-select " name="cust_id">
                                          <option value="0">@lang('strings.All')</option>
                                          @foreach($customers as $customer)
                                           <option {{ app('request')->input('cust_id') == $customer->id ? 'selected' : ''}}  value="{{$customer->id}}">{{ app()->getLocale() == 'ar' ? $customer->name  : $customer->name_en  }}</option>

                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                      <label>@lang('strings.phone_number')</label>
                                      <select class="form-control js-select" name="phone_number">
                                          <option value="0">@lang('strings.All')</option>
                                          @foreach($booking_fields as $booking_field)
                                          <option {{ app('request')->input('phone_number') == $booking_field->mobile ? 'selected' : ''}} value="{{$booking_field->mobile}}">{{ $booking_field->mobile }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                      <label>@lang('strings.email')</label>
                                      <select class="form-control js-select" name="email">
                                          <option value="0">@lang('strings.All')</option>
                                        @foreach($booking_fields as $booking_field)
                                              <option {{ app('request')->input('email') == $booking_field->email ? 'selected' : ''}} value="{{$booking_field->email}}">{{ $booking_field->email }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                      <label>@lang('strings.status')</label>
                                      <select class="form-control js-select" name="status">
                                            <option value="0">@lang('strings.All')</option>
                                            <option  {{app('request')->input('status')=='n'?'selected':''}} value="n" >{{ __('strings.reservation_not_confirmed') }}</option>
                                            <option {{app('request')->input('status')=='y'?'selected':''}} value="y">{{ __('strings.reservation_confirmed') }}</option>
                                            <option {{app('request')->input('status')=='c'?'selected':''}} value="c">{{ __('strings.cancelled') }}</option>
                                            <option {{app('request')->input('status')=='w'?'selected':''}} value="w">{{ __('strings.waiting') }}</option>
                                            <option {{app('request')->input('status')=='r'?'selected':''}} value="r">{{ __('strings.payment_rejected') }}</option>
                                      </select>
                                  </div>
                                  <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                      <label>@lang('strings.confirmation_no')</label>
                                      <select class="form-control js-select" name="confirmation_no">
                                          <option value="0">@lang('strings.All')</option>
                                        @foreach($booking_fields as $booking_field)
                                              <option {{ app('request')->input('confirmation_no') == $booking_field->confirmation_no ? 'selected' : ''}} value="{{$booking_field->confirmation_no}}">{{ $booking_field->confirmation_no }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                      <div class="input-group text">
                                          <label>@lang('strings.Date_fromm')</label>
                                          <input name="date_from" id="date_from" type="date" value="{{ app('request')->input('date_from') }}" class="form-control">
                                      </div>
                                  </div>

                                  <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                      <div class="input-group text">
                                          <label>@lang('strings.Date_too')</label>
                                          <input name="date_to" id="date_to" type="date" value="{{ app('request')->input('date_to') }}" class="form-control">
                                      </div>
                                  </div>
                                  <button id="search_button" type="submit" class="btn btn-primary"> <i class="fas fa-search"></i> @lang('strings.Search')</button>
                                  <a href="{{ url('/admin/hotel_reservation') }}" type="button" class="btn btn-primary"> <i class="fa fa-plus"></i> @lang('strings.add_reservation')</a>
                              </div>


                          </form>
                        </div>
                        <div class="table-responsive">
                              <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                        <tr>
                                          <th>{{__('strings.hotel')}}</th>
                                          <th>{{__('strings.from_date')}}</th>
                                          <th>{{__('strings.to_date')}}</th>
                                          <th> {{__('strings.customer_name')}}</th>
                                          <th>{{__('strings.no_adults')}}</th>
                                          <th>{{__('strings.no_childs')}}</th>
                                          <th>{{__('strings.total_amount')}}</th>
                                          <th>{{__('strings.status')}}</th>
                                          <th>{{__('strings.reserved_by')}}</th>
                                          <th>{{__('strings.date')}}</th>
                                          <th>{{__('strings.confirmation_no')}}</th>
                                          <th>{{__('strings.reservation_settings')}}</th>

                                        </tr>

                                    </thead>
                                    <tbody>
                                    @foreach($bookings as $booking)
                                            <tr>
                                              <td>{{$booking->hotel}}</td>
                                              <td>{{$booking->book_from}}</td>
                                              <td>{{$booking->book_to}}</td>
                                              <td>{{$booking->customer}}</td>
                                              <td>{{$booking->adult_no}}</td>
                                              <td>{{$booking->chiled_no}}</td>
                                              <td>{{$booking->final_price}}</td>
                                              @if($booking->book_status=="n")
                                                <td><span class="badge badge-primary">{{ __('strings.reservation_not_confirmed') }}</span></td>
                                              @elseif($booking->book_status=="y")
                                                <td><span class="badge badge-success">{{ __('strings.reservation_confirmed') }}</span></td>
                                              @elseif($booking->book_status=="w")
                                                <td><span class="badge badge-warning">{{ __('strings.waiting') }}</span></td>
                                             @elseif($booking->book_status=="c")
                                               <td><span class="badge badge-danger">{{ __('strings.cancelled') }}</span></td>
                                             @else
                                               <td><span class="badge badge-danger">{{ __('strings.payment_rejected') }}</span></td>
                                              @endif
                                              @if($booking->source_type==1)
                                                <td>{{ __('strings.reciption') }}</td>
                                              @elseif($booking->source_type==2)
                                                <td>{{ __('strings.travel_agent') }}</td>
                                              @elseif($booking->source_type==3)
                                                <td>{{ __('strings.website') }}</td>
                                              @else
                                                <td>{{ __('strings.telephone_way') }}</td>
                                              @endif
                                              <td>{{$booking->created_at}}</td>
                                              <td>{{$booking->confirmation_no}}</td>
                                              <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">@lang('strings.reservation_settings')
                                                        <span class="caret"></span></button>
                                                    <ul class="dropdown-menu">
                                                      <li><a href="{{ url('/admin/booking'). '/' .$booking->id . '/show' }}">@lang('strings.show') <i class="fa fa-search" style="color: green"></i></a></li><li class="divider"></li>
                                                      @if($booking->book_status!="y" && $booking->book_status!="c")
                                                        <li><button onclick="edit_dates_modal({{$booking->number_of_nights}},{{$booking->id}})">@lang('strings.edit_dates') <i class="fa fa-check" style="color: green"></i></button></li><li class="divider"></li>
                                                        <li><button onclick="add_rooms_modal({{$booking->id}})">@lang('strings.add_rooms') <i class="fa fa-plus" style="color: green"></i></button></li><li class="divider"></li>
                                                        <li><button onclick="cancel_rooms_modal({{$booking->id}})">@lang('strings.cancel_rooms') <i class="fa fa-times" style="color: red"></i></button></li><li class="divider"></li>
                                                        <li><a href="{{ url('/admin/booking'). '/' . $booking->id . '/edit' }}">@lang('strings.edit_customer') <i class="fa fa-cog" style="color: blue"></i></a></li><li class="divider"></li>
                                                        <li><button onclick="payandconfirm({{$booking->id}})">@lang('strings.pay_and_confirm') <i class="fa fa-money" style="color: green"></i></button></li><li class="divider"></li>
                                                      @endif
                                                      @if($booking->book_status=="y")
                                                      <li><a href="{{ url('/admin/booking'). '/' .$booking->id . '/invoice' }}">@lang('strings.invoice') <i class="fas fa-file-invoice" style="color: green"></i></a></li><li class="divider"></li>
                                                      @endif
                                                        <!--<li><a href="{{ url('/admin/reservations'). '/' . $reservation['id'] . '/edit' }}">@lang('strings.edit') <i class="fa fa-cog" style="color: blue"></i></a></li><li class="divider"></li>-->
                                                        <!--<li><a href="{{ url('/admin/reservations'). '/' . $reservation['id'] . '/cancel' }}">@lang('strings.Cancel') <i class="fa fa-times" style="color: red"></i></a></li>-->
                                                    </ul>
                                                </div>
                                              </td>
                                              @endforeach
                                            </tr>

                                          </tbody>
                                        </table>


            </div>


        </div>
    </div>
  </div>
</div>
<script>
   $('.js-select').select2();




</script>
@endsection

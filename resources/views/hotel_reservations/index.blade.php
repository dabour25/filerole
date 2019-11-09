@extends('layouts.admin', ['title' => __('strings.rooms') ])
@section('content')
    <style>
    .modal {
            display: none; /* Hidden by default */

        }
        td.details-control {
            background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
        }
    </style>

    <!--<div class="page-title">-->
    <!--    <h3>{{ __('strings.Categories_type') }}</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>-->
    <!--            <li class="active">{{ __('strings.Categories_type') }}</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->


    <div class="modal newModal" id="Modal2" role="dialog">
            <div class="modal-dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="close_modal2()">&times;</button>
                </div>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body" style="overflow: hidden">
                        <form method="post" action="{{url('admin/reserve_hotel')}}" enctype="multipart/form-data" id="add_customer_store">
                            {{csrf_field()}}
                            <div class="row">
                              <div class="col-md-12" id="no_rooms">

                              </div>
                              <div class="col-md-12" id="total_price">

                              </div>

                            </div>

                            <input type="hidden" name="destination_id">
                            <input type="hidden" name="date_from1">
                            <input type="hidden" name="date_to1">
                            <input type="hidden" name="no_childs1">
                            <input type="hidden" name="no_adults1">
                            <input type="hidden" name="cat_id[]">
                            <input type="hidden" name="sub_ids[]">
                            <input type="hidden" name="tax_ids[]">
                            <input type="hidden" name="tax_vals[]">
                            <input type="hidden" name="child_ages1[]">
                            <input type="hidden" name="total_value">
                            <button type="submit" class="btn btn-primary">{{__('strings.reserve')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
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
                      <form  id="search_form" method="get" action="{{url('admin/hotel/reservation/search')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                      <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                            <label>@lang('strings.destination_name')</label>
                                            <select class="form-control js-select" name="destination" required>

                                            @foreach(\App\Destinations::where('org_id',Auth::user()->org_id)->get() as $destination)

                                            <option  value="{{$destination->id}}" {{ app('request')->input('destination')==$destination->id?'selected':''}}>{{ app()->getLocale() == 'ar' ? $destination->name  : $destination->name_en  }}</option>
                                                @endforeach
                                            </select>
                      </div>
                      <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                          <div class="input-group text">
                              <label>@lang('strings.Date_fromm')</label>
                              <input name="date_from" class=" form-control datepicker_reservation"  placeholder="@lang('strings.Date_fromm')" id="date_from" type="text" value="{{ app('request')->input('date_from') }}" class="form-control" autocomplete="off" required>
                          </div>
                      </div>
                      <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                          <div class="input-group text">
                              <label>@lang('strings.Date_too')</label>
                              <input name="date_to" id="date_to" class="form-control datepicker_reservation2" placeholder="@lang('strings.Date_too')" type="text" value="{{ app('request')->input('date_to') }}" class="form-control" autocomplete="off" required>
                          </div>
                      </div>
                      <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                          <div class="input-group text">
                              <label>@lang('strings.adults_no')</label>
                              <select class="form-control" name="adult_no" required value="{{app('request')->input('adult_no')}}">
                                <option {{app('request')->input('adult_no')==2?'selected':''}} value="2">2</option>
                                <option {{app('request')->input('adult_no')==1?'selected':''}} value="1">1</option>
                                <option {{app('request')->input('adult_no')==3?'selected':''}} value="3">3</option>
                                <option {{app('request')->input('adult_no')==4?'selected':''}} value="4">4</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                          <div class="input-group text">
                              <label>@lang('strings.childs_no')</label>
                              <select class="form-control" name="child_no" onchange="add_ages()" id="child_no" required value="{{app('request')->input('child_no')}}">
                                <option {{app('request')->input('child_no')==0?'selected':''}} value="0">0</option>
                                <option {{app('request')->input('child_no')==1?'selected':''}} value="1">1</option>
                                <option {{app('request')->input('child_no')==2?'selected':''}} value="2">2</option>
                                <option {{app('request')->input('child_no')==3?'selected':''}} value="3">3</option>
                                <option {{app('request')->input('child_no')==4?'selected':''}} value="4">4</option>
                              </select>

                          </div>
                      </div>
                      <div id="child_ages" class="col-lg-3 col-md-4 col-sm-6 m-b-sm">

                      </div>
{{$child_ages}}
                      @if(!empty($child_ages))
                       <div id="child_ages2" class="col-lg-3 col-md-4 col-sm-6 m-b-sm">

                        @foreach($child_ages as $child=>$value)

                        <select style="width:70px;" class="form-control" name="child_age[]">
                          <option {{$value==1?'selected':''}} value="1">1</option>
                          <option {{$value==2?'selected':''}} value="2">2</option>
                          <option {{$value==3?'selected':''}} value="3">3</option>
                          <option {{$value==4?'selected':''}} value="4">4</option>
                          <option {{$value==5?'selected':''}} value="5">5</option>
                          <option {{$value==6?'selected':''}} value="6">6</option>
                          <option {{$value==7?'selected':''}} value="7">7</option>
                          <option {{$value==8?'selected':''}} value="8">8</option>
                          <option {{$value==9?'selected':''}} value="9">9</option>
                          <option {{$value==10?'selected':''}} value="10">10</option>
                          <option {{$value==11?'selected':''}} value="11">11</option>
                          <option {{$value==12?'selected':''}} value="12">12</option>
                        </select>
                    @endforeach
                          </div>
  @endif
                            <input type="hidden" name="hotel_id">

                            <button id="search_button" type="submit"  name="action" onclick="" value="available" class="btn btn-primary btn-lg">@lang('strings.Search_available')</button>
                            <button id="search_button" type="submit"  name="action" onclick="" value="waiting"  class="btn btn-primary btn-lg">@lang('strings.Search_waiting')</button>
                            <input type="hidden" name="action2" value="{{$action}}">
                    </form>
                    </br>
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">@lang('strings.hotels')</h4>
                        </div>
                        <div class="panel-body">
                        <div class="table-responsive">
                              <table id="xtreme-table{{$hotel->id}}" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                        <tr>
                                          <th>{{__('strings.destination')}}</th>
                                          <th>{{__('strings.name')}}</th>
                                          <th>{{__('strings.see_availability')}}</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                    @foreach($hotels as $hotel)
                                            <tr>
                                              <td>{{ $hotel->dest }}</td>
                                              <td>{{$hotel->name}}</td>
                                              <td><button onclick="choose_hotel({{$hotel->id}})" class="btn btn-primary">{{__('strings.see_availability')}}</button></td>
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
<script>
 







</script>
@endsection

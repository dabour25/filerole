@extends('layouts.admin', ['title' => __('strings.rooms_types') ])
@section('content')
    <style>
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
            {{ DB::table('function_new')->where('id',279)->value('description') }}
            @else
            {{ DB::table('function_new')->where('id',279)->value('description_en') }}
            @endif
                          </p>
                          <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                          </a>
                      </div>
                      </br>

                          



                    <div class="panel panel-white">
                        </br>
                          <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                              <form method="get" action="cleaning_priority" enctype="multipart/form-data">
                                   <div class="col-md-12 required form-group{{$errors->has('phone') ? ' has-error' : ''}}">
                                    <label class="control-label"  style="display:inline; width:30px;"
                                    ><strong>@lang('strings.properties_list')</strong></label>
                                                <select class="form-control js-select" id="hotel" name="property_id" onchange="this.form.submit()"  required >
                                                 <option value="0" >@lang('strings.properties_list')</option>
                                                  @foreach($properties as $property)
                                                  <option  {{ app('request')->input('property_id') == $property->id ?  'selected' : ''}} value="{{$property->id}}">{{ app()->getLocale()== 'ar' ? $property->name : $property->name_en}}</option>
                                                    @endforeach
                                              </select> @if ($errors->has('phone'))
                                  <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                            </span>
                              @endif
                                  </div>    
                                  
                                  
                                  
                              </form>
                              </div>
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">@lang('strings.cancel_order')</h4>
                        </div>
                        <div class="panel-body">

                          @if(count($cleaning_priority)==0)
                          <form method="post" action="{{url('admin/Cleaning_Priority_add')}}" enctype="multipart/form-data">
                             {{csrf_field()}}
                              @if($hotel_id)
                            <input type="hidden" name="property_id" value="{{$hotel_id}}"/>
                            @else
                            <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('property_id') }}</strong>
                          </span>
                            @endif

                          <div class="col-md-12 required form-group{{$errors->has('phone') ? ' has-error' : ''}}">

                            <label class="control-label"  style="display:inline; width:30px;"
                                     for="phone"><strong>@lang('strings.Arrivals_today')</strong></label>
                              <input type="text" style="display:inline; width:50px;" class="form-control"  id="order1" name="rank[0]"
                                     value="" required>
                              @if ($errors->has('phone'))
                                  <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                      </span>
                              @endif
                          </div>
                          <div class="col-md-12 required form-group{{$errors->has('phone') ? ' has-error' : ''}}">

                            <label class="control-label"  style="display:inline; width:30px;"
                                     for="phone"><strong>@lang('strings.house_today')</strong></label>
                                     <input type="text" style="display:inline; width:50px;" class="form-control"  id="order2" name="rank[1]"
                                     value="" required>
                              @if ($errors->has('phone'))
                                  <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                      </span>
                              @endif
                          </div>
                          <div class="col-md-12 required form-group{{$errors->has('phone') ? ' has-error' : ''}}">

                            <label class="control-label"  style="display:inline; width:30px;"
                                     for="phone"><strong>@lang('strings.Departure_today')</strong></label>
                                     <input type="text" style="display:inline; width:50px;" class="form-control"  id="order3" name="rank[2]"
                                     value="" required>
                              @if ($errors->has('phone'))
                                  <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                      </span>
                              @endif
                          </div>
                          <div class="col-md-12 required form-group{{$errors->has('phone') ? ' has-error' : ''}}">

                            <label class="control-label"  style="display:inline; width:30px;"
                                     for="phone"><strong>@lang('strings.booking_today')</strong></label>
                                     <input type="text" style="display:inline; width:50px;" class="form-control"  id="order4" name="rank[3]"
                                     value="" required>
                              @if ($errors->has('phone'))
                                  <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                      </span>
                              @endif
                          </div>
                          <div class="col-md-12 form-group text-right">
                             <button onclick=" return check_order()" type="submit" class="btn btn-primary btn-lg">{{ __('strings.Save') }}</button>

                          </div>
                       </form>
                       @else


                       <form method="post" action="{{url('admin/Cleaning_Priority_add')}}" enctype="multipart/form-data">
                          {{csrf_field()}}
                         <input type="hidden" name="property_id" value="{{$hotel_id}}"/>

                        <div class="col-md-12 required form-group{{$errors->has('phone') ? ' has-error' : ''}}">

                         <label class="control-label"  style="display:inline; width:30px;"
                                  for="phone"><strong>@lang('strings.Arrivals_today')</strong></label>
                           <input type="text" id="order1"  style="display:inline; width:50px;" class="form-control" name="rank[0]"
                                  value="{{$cleaning_priority[0]->rank}}" required>
                           @if ($errors->has('phone'))
                               <span class="help-block">
                       <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                   </span>
                           @endif
                       </div>
                       <div class="col-md-12 required form-group{{$errors->has('phone') ? ' has-error' : ''}}">

                         <label class="control-label"  style="display:inline; width:30px;"
                                  for="phone"><strong>@lang('strings.house_today')</strong></label>
                                  <input type="text" id="order2"  style="display:inline; width:50px;" class="form-control" name="rank[1]"
                                  value="{{$cleaning_priority[1]->rank}}" required>
                           @if ($errors->has('phone'))
                               <span class="help-block">
                       <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                   </span>
                           @endif
                       </div>
                       <div class="col-md-12 required form-group{{$errors->has('phone') ? ' has-error' : ''}}">

                         <label class="control-label"  style="display:inline; width:30px;"
                                  for="phone"><strong>@lang('strings.Departure_today')</strong></label>
                                  <input type="text" id="order3"  style="display:inline; width:50px;" class="form-control" name="rank[2]"
                                  value="{{$cleaning_priority[2]->rank}}" required>
                           @if ($errors->has('phone'))
                               <span class="help-block">
                       <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                   </span>
                           @endif
                       </div>
                       <div class="col-md-12 required form-group{{$errors->has('phone') ? ' has-error' : ''}}">

                         <label class="control-label"  style="display:inline; width:30px;"
                                  for="phone"><strong>@lang('strings.booking_today')</strong></label>
                                  <input type="text" id="order4" style="display:inline; width:50px;" class="form-control" name="rank[3]"
                                  value="{{$cleaning_priority[3]->rank}}" required>
                           @if ($errors->has('phone'))
                               <span class="help-block">
                       <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                   </span>
                           @endif
                       </div>
                       <div class="col-md-12 form-group text-right">
                           <button onclick=" return check_order()" type="submit" class="btn btn-primary btn-lg">{{ __('strings.Save') }}</button>
                       </div>

                    </form>




                        @endif
        </div>
    </div>
  </div>
</div>
</div>
   <script>
      $('.js-select').select2();
     function check_order(){
     
         if(document.getElementById('hotel').value ==0){
             alert('برجاء اختيار الفندق');
             return false;
         }
   
  var val1=document.getElementById('order1').value;
  var val2=document.getElementById('order2').value;
  var val3=document.getElementById('order3').value;
  var val4=document.getElementById('order4').value;
  var total=parseInt(val1)+parseInt(val2) +parseInt(val3)+parseInt(val4);
  if(total==10)
  return true;
  else {
      alert('يجب ادخال ترتيب صحيح');
    return false;

  }

}
     
  </script>
@endsection

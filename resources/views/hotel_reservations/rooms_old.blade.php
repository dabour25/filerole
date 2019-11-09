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
                            <input type="hidden" name="hotel_id" value="{{$hotel_id}}">
                            <input type="hidden" name="destination_id">
                            <input type="hidden" name="date_from1" value="{{$date_from}}">
                            <input type="hidden" name="date_to1" value="{{$date_to}}">
                            <input type="hidden" name="no_childs1" value="{{$child_no}}">
                            <input type="hidden" name="no_adults1" value="{{$adult_no}}">
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
            {{ DB::table('function_new')->where('id',231)->value('description') }}
            @else
            {{ DB::table('function_new')->where('id',231)->value('description_en') }}
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
                            <h4 class="panel-title">@lang('strings.see_availability')</h4>
                        </div>
                        <div class="panel-body">
                          @foreach($hotels as $hotel)
               @foreach($hotel->rooms as $key => $hotel_room)
               <div class="card" style="height:70px;background-color: #92a8d1;">
   <div class="row" style="padding:20px; float:right;">
   <div class="" style="border-right:2px solid #ccc;text-align:center;">{{app()->getLocale() == 'ar'? $hotel_room->name :$hotel_room->name_en}}</div>

      </div>
    </div>

                            <div class="table-responsive">
                              <table id="xtreme-table{{$hotel->id}}" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                        <tr>


                                            <th>{{__('strings.meal_plan')}}</th>
                                            <th>{{__('strings.price_for')}}{{$numberOfNights}}{{__('strings.nights')}}</th>
                                            <th>{{__('strings.cancelation_policy')}}</th>
                                            <th>@lang('strings.number_of_rooms')</th>
                                            <th></th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                    @foreach($hotel_room->meal_plans as $meal_plan)
                                            <tr>
                                              <td>{{ $meal_plan->name }}</td>
                                              <td>{{$meal_plan->price}}</td>
                                              <td>{{$meal_plan->message}}</td>
                                              <td>
                                                <select name="rooms_number[]"  data-id="{{$meal_plan->id}}" data-cat_sub_id="{{$meal_plan->catsub_id}}" data-price="{{$meal_plan->price}}" data-tax_id="{{$meal_plan->tax_id}}"  data-tax_val="{{$meal_plan->tax_val}}" data-total_rooms="{{count($hotel_room->numbers)}}">
                                                @php

                                                  for($i=0;$i<=count($hotel_room->numbers);$i++){
                                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                                  }
                                                  @endphp

                                                  </select>
                                                  <div id="validation_error"></div>
                                              </td>

                                              <td><button  onclick="reserve_room()" class="btn btn-primary">{{__('strings.reserve')}}</button></td>

                                              @endforeach
                                            </tr>

                                          </tbody>
                                        </table>


            </div>
          @endforeach
        @endforeach

        </div>
    </div>
  </div>
</div>
<script>
   $('.js-select').select2();
</script>
<script>
 function modal_show(id){
  console.log($('#modal_button').data());
  $('input[name="location_id"]').val($('#modal_button'+id).data('id'));
  $('input[name="name"]').val($('#modal_button'+id).data('name'));
  $('input[name="name_en"]').val($('#modal_button'+id).data('name_en'));

  $('input[name="description"]').val($('#modal_button'+id).data('description'));
  $('input[name="longitude"]').val($('#modal_button'+id).data('longitude'));
  $('input[name="latitude"]').val($('#modal_button'+id).data('latitude'));
  $('select[name="destination_id"]').val($('#modal_button'+id).data('destination_id'));
  $('select[name="active"]').val($('#modal_button'+id).data('active'));
 }










function add_ages(){

  var child_no=$('#child_no').val();
  $('#child_ages').empty();
  $('#child_ages2').empty();
  for(var i=0;i<child_no;i++){

    $('#child_ages').append('<select style="width:70px;" class="form-control" name="child_age[]"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>');

  }

}


function reserve_room(){
$('#no_rooms').empty();
$('#total_price').empty();
$('#validation_error').empty();
$('tr>td:nth-child(4)').css("background-color", "white");
  var total=0;
  var cat_ids=[];
  var tax_ids=[];
  var tax_vals=[];
  var sub_ids=[];
  var child_ages=[];
  var total_price=0;
  $('select[name="rooms_number[]"]').each(function(){

        total+=parseInt(this.value, 10);

        if(this.value!=0){
          total_price+=parseInt($(this).data('price'))*total;
          cat_ids.push($(this).data('id'));
          tax_ids.push($(this).data('tax_id'));
          tax_vals.push($(this).data('tax_val'));

          sub_ids.push($(this).data('cat_sub_id'));



        }

        });


        if(total==0){
          $('tr>td:nth-child(4)').css("background-color", "red");
          $('#validation_error').append('<p>{{__('strings.you_must_select_one')}}</p>');
        }
        else{

          $('#no_rooms').append('<p>{{__('strings.number_rooms')}}'+total+'</p>');
          $('#total_price').append('<p>{{__('strings.total_price')}}'+total_price+'</p>');

          $('input[name="cat_id[]"]').val(cat_ids);
          $('input[name="tax_ids[]"]').val(tax_ids);
          $('input[name="sub_ids[]"]').val(sub_ids);
          $('input[name="tax_vals[]"]').val(tax_vals);
          $('input[name="total_value"]').val(total_price);
          $('select[name="child_age[]"]').each(function(){
            console.log($(this).val());
            child_ages.push($(this).val());

          });

          $('input[name="child_ages1[]"]').val($('select[name="child_age[]"]').val());
          $('input[name="child_ages1[]"]').val(child_ages);


          var modal2 = document.getElementById('Modal2');
          modal2.style.display = "block";
        }
}
function close_modal2(){
  var modal2 = document.getElementById('Modal2');
  modal2.style.display = "none";
}
$('select[name="rooms_number[]"]').on('change', function() {
 var cat_sub_id=$(this).data('cat_sub_id');
 $('*[data-id="'+ $(this).data('id') +'"] option').removeAttr("disabled");
 var total=0;
  $('*[data-id="'+ $(this).data('id') +'"]').each(function(){
  total+=parseInt($(this).val(), 10);
 
  });
  

  no_rooms=parseInt($(this).data('total_rooms'), 10);
  diff=no_rooms-total;
  
    for(var i=no_rooms;i>diff;i--){

    $('*[data-id="'+ $(this).data('id') +'"] option[value="' + i + '"]').attr('disabled','disabled');
    $('*[data-cat_sub_id="'+cat_sub_id +'"] option[value="' + i + '"]').removeAttr("disabled");
   
  }
  
});











</script>
@endsection

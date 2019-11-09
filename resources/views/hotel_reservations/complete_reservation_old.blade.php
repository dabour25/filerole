@extends('layouts.admin', ['title' => __('strings.rooms') ])
@section('content')
  @section('styles')
   <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/css/intlTelInput.css" rel="stylesheet" />
    <style>
    .modal{
      display:none;
    }
    </style>
  @endsection

  <div class="modal newModel" id="reservation_modal" role="dialog">
          <div class="modal-dialog">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" onclick="close_reservation_modal()">&times;</button>
              </div>
              <!-- Modal content-->
              <div class="modal-content">
                  <div class="modal-body" style="overflow: hidden">
                      <form method="post" action="#" enctype="multipart/form-data" id="add_customer_store">
                          {{csrf_field()}}
                          <input type="hidden" class="form-control" name="user_id" value="{{  Auth::user()->id }}">
                          <input type="hidden" class="form-control" name="active" value="1">

                          <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                              <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                              <input type="text" class="form-control" name="name" value="{{old('name')}}" required>
                              @if ($errors->has('name'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                  </span>
                              @endif
                          </div>

                          <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                              <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                              <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}" required>
                              @if ($errors->has('name_en'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                  </span>
                              @endif
                          </div>

                          <div class="col-md-6 form-group{{$errors->has('email') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                              <label class="control-label" for="email">{{ __('strings.Email') }}</label>
                              <input type="text" class="form-control" name="email" value="{{old('email')}}" required>
                              @if ($errors->has('email'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                  </span>
                              @endif
                          </div>

                          <div class="col-md-6 form-group{{$errors->has('gender') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                              <label class="control-label" for="gender">{{ __('strings.Gender') }}</label>
                              <select class="form-control js-select" name="gender" required>
                                  <option value="1">{{ __('strings.Male') }}</option>
                                  <option value="0">{{ __('strings.Female') }}</option>
                              </select>
                              @if ($errors->has('gender'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('gender') }}</strong>
                                  </span>
                              @endif
                          </div>

                          <div class="col-md-6 form-group{{$errors->has('address') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                              <label class="control-label" for="address">{{ __('strings.Address') }}</label>
                              <input type="text" class="form-control" name="address" value="{{old('address')}}" required>
                              @if ($errors->has('address'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                  </span>
                              @endif
                          </div>

                          <div class="col-md-12 form-group{{$errors->has('phone_number') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                              <label class="control-label" for="phone_number">{{ __('strings.Phone') }}</label>
                              <input type="tel" class="form-control" name="phone_number" id="phone" value="{{old('phone_number')}}" required>
                              <span id="valid-msg" class="hide">✓ صالح</span>
                              <span id="error-msg" class="hide"></span>

                              @if ($errors->has('phone_number'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
                                  </span>
                              @endif
                          </div>
                          <div class="col-md-6 form-group{{$errors->has('signs') ? ' has-error' : ''}}">
                                  <label>{{__('strings.country')}}<strong class="text-danger">*</strong></label>
                                  <select required name="country_id" class="js-select">
                                      @foreach($countries as $country)
                                          @php
                                              $country_session = Session::has('country')  ? session('country') : 'EG';
                                          @endphp
                                          <option {{ $country_session == $country->code || old('country_id') == $country->id ? 'selected' : ''}} value="{{$country->id}}">{{ app()->getLocale() == 'ar' ? $country->name  : $country->name_en  }}</option>
                                          @endforeach
                                  </select>
                              </div>


                           <div class="col-md-6 form-group{{$errors->has('signs') ? ' has-error' : ''}}">
                                  <label>{{__('strings.city')}}<strong class="text-danger">*</strong></label>
                                  <input type="text" placeholder="" required name="city" value="{{ Session::has('city')  ? session('city') : 'EG' }}">
                              </div>
                          <div class="col-md-12 form-group text-right">
                              <button type="submit" class="btn btn-primary btn-lg" onclick="add_reservation_customer()">{{ __('strings.Save') }}</button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  <div id="main-wrapper">
      <div class="row">
          <div class="col-xs-12">
                              <div class="alert_new">
      <span class="alertIcon">
          <i class="fas fa-exclamation-circle"></i>
       </span>
       <p>
           @if (app()->getLocale() == 'ar')
          {{ DB::table('function_new')->where('id',4)->value('description') }}
          @else
          {{ DB::table('function_new')->where('id',4)->value('description_en') }}
          @endif
       </p>
       <a href="#" onclick="close_alert()" class="close_alert">  <i class="fas fa-times-circle"></i> </a>

  </div>
          </div>
          <form method="post" action="{{url('/admin/hotel_reservation/store')}}" enctype="multipart/form-data" role="form" id="add-role">
              {{csrf_field()}}

              <div class="col-md-12">
                  <div class="panel panel-white">
                      <div class="panel-heading clearfix">
                          <div class="col-md-12">
                              <h4 class="panel-title">{{ __('strings.complete_reservation') }}</h4>
                          </div>
                      </div>
                      <div class="panel-body">
                          @if(Session::has('message'))
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="alert alert-danger">
                                          {{Session::get('message')}}
                                      </div>
                                  </div>
                              </div>
                          @endif


                          <div class="col-md-6 form-group{{$errors->has('cust_code') ? ' has-error' : ''}}">
                              <label class="control-label" for="cust_code">{{ __('strings.customer') }}</label>
                              <select name="customer" id="client_selectpicker"  onchange="fill_customer_data()" class="form-control js-select" data-live-search="true" data-width="auto" title="{{__('strings.choose_customer')}}">
                                <option value="0">{{__('strings.choose_customer')}}</option>
                                @foreach($customers as $customer)
                                  <option value="{{$customer->id}}" data-email="{{$customer->email}}" data-telephone="{{$customer->phone_number}}">{{app()->getLocale()=='ar'?$customer->name:$customer->name_en}}</option>
                                @endforeach
                              </select>

                              @if ($errors->has('cust_code'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('cust_code') }}</strong>
                                  </span>
                              @endif
                              <div class="text-left">
                                <button type="button" class="btn btn-info btn-lg NewBtn btnclient" onclick="add_customer_modal()">{{__('strings.customer')}}<i class="fas fa-plus"></i></button>
                              </div>
                          </div>

                          <div class="col-md-6 form-group{{$errors->has('phone_number') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                              <label class="control-label" for="phone_number">{{ __('strings.Phone') }}</label>
                              <input type="tel" class="form-control" name="phone_number" id="phone2" value="{{old('phone_number')}}" required>
                              <span id="valid-msg2" class="hide">✓ صالح</span>
                              <span id="error-msg2" class="hide"></span>

                          @if ($errors->has('phone_number'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
                                  </span>
                              @endif
                          </div>

                          <div class="col-md-6 form-group{{$errors->has('email') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                              <label class="control-label" for="email">{{ __('strings.Email') }}</label>
                              <input type="text" class="form-control" name="email" value="{{old('email')}}">
                              @if ($errors->has('email'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                  </span>
                              @endif
                          </div>

                          <div class="col-md-6 form-group{{$errors->has('gender') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                              <label class="control-label" for="gender">{{ __('strings.reservation_source') }}</label>
                              <select class="form-control js-select" name="source" onchange="add_source_name()">
                                  <option value="1" selected>{{ __('strings.reciption') }}</option>
                                  <option value="2">{{ __('strings.travel_agent') }}</option>
                                  <option value="3">{{ __('strings.website') }}</option>
                                  <option value="4">{{ __('strings.telephone_way') }}</option>
                              </select>
                              @if ($errors->has('gender'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('gender') }}</strong>
                                  </span>
                              @endif
                              <div id="source_name_field">
                              </div>
                          </div>

                          <div class="col-md-6 form-group{{$errors->has('cust_code') ? ' has-error' : ''}}">
                            <label class="control-label" for="cust_code">{{ __('strings.additional_category') }}</label>
                            <table id="xtreme-table1" class="table table-striped table-bordered" style="width:100%">
                              <thead>
                                <tr>
                                  <th> {{ __('strings.additional_category') }} </th>
                                  <th>  {{ __('strings.number') }}  </th>
                                  <th> {{ __('strings.external_req_pricePiece') }} </th>
                                  <th> {{ __('strings.external_req_tax') }} </th>
                                  <th> {{ __('strings.external_req_total') }} </th>
                                  <th>  {{ __('strings.external_req_cancellation') }}  </th>
                                </tr>
                              </thead>
                              <tbody id="clonetr">
                                <tr id="firsttr">

                                  <td>
                                    <select name="additional_category[]" class="js-select cat_id_select">
                                      <option value="0">{{__('strings.choose_additional_categories')}}</option>
                                      @foreach($additional_categories as $additional_category)
                                        <option value="{{$additional_category->id}}">
                                          {{app()->getLocale()=='ar'?$additional_category->name:$additional_category->name_en}}
                                        </option>
                                      @endforeach
                                    </select>
                                  </td>
                                  <td>
                                   <input class="form-control qnyNum1" type="number" name="additional_number[]">
                                  </td>
                                  <td>
                                    <span class="cat_price"></span>
                                    <input class="cat_price_input1"   type="hidden" name="add_cat_price[]">
                                    <input class="tax_val1" type="hidden"   name="add_tax_val[]" required>
                                     <input class="taxId1" name="add_taxId[]" type="hidden" required>
                                  </td>
                                  <td>
                                    <span class="tax"></span>
                                  </td>
                                  <td class="fprice_1">
                                    <span class="total"></span>
                                  </td>
                                  <td>
                                    <button type="button" id="deltr" style="color: red;"   class="btn btn-defult btn-close-regust2"><i class="fas fa-times"></i></button>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <button type="button" class="btn btn-primary" id="addRow1"><i class="fas fa-plus"></i> إضافة بند </button>
                              {{-- <div class="text-left">
                                <button type="button" class="btn btn-info btn-lg NewBtn btnclient" data-toggle="modal" data-target="#addcustomer">{{__('strings.add_requirements')}}<i class="fas fa-plus"></i></button>
                              </div> --}}
                          </div>




                          <div class="col-md-6 form-group{{$errors->has('cust_code') ? ' has-error' : ''}}">
                              <label class="control-label" for="cust_code">{{ __('strings.services') }}</label>
                              <table id="xtreme-table2" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                  <tr>
                                    <th> {{ __('strings.additional_category') }} </th>
                                    <th>  {{ __('strings.number') }}  </th>
                                    <th> {{ __('strings.external_req_pricePiece') }} </th>
                                    <th> {{ __('strings.external_req_tax') }} </th>
                                    <th> {{ __('strings.external_req_total') }} </th>
                                    <th>  {{ __('strings.external_req_cancellation') }}  </th>
                                  </tr>
                                </thead>
                                <tbody id="clonetr">
                                  <tr id="firsttr">

                                    <td>
                                      <select name="services[]"  class="js-select" id="cat_id_select1">
                                        <option value="0">{{__('strings.choose')}}</option>
                                        @foreach($additional_services as $additional_service)
                                          <option value="{{$additional_service->id}}">{{app()->getLocale()=='ar'?$additional_service->name:$additional_service->name_en}}</option>
                                        @endforeach
                                      </select>
                                    </td>
                                    <td>
                                     <input class="form-control qnyNum2" type="number" name="services_number[]">
                                    </td>
                                    <td>
                                      <span class="cat_price"></span>
                                      <input class="cat_price_input2"   type="hidden" name="service_cat_price[]">
                                      <input class="tax_val2" type="hidden"   name="service_tax_val[]" required>
                                       <input class="taxId2" name="service_taxId[]" type="hidden"    required>
                                    </td>
                                    <td>
                                      <span class="tax"></span>
                                    </td>
                                    <td class="fprice_2">
                                      <span class="total"></span>
                                    </td>
                                    <td>
                                      <button type="button" id="deltr" style="color: red;"   class="btn btn-defult btn-close-regust2"><i class="fas fa-times"></i></button>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <button type="button" class="btn btn-primary" id="addRow2"><i class="fas fa-plus"></i> إضافة بند </button>

                              {{-- <div class="text-left">
                                <button type="button" class="btn btn-info btn-lg NewBtn btnclient" data-toggle="modal" data-target="#addcustomer">{{__('strings.add_services')}}<i class="fas fa-plus"></i></button>
                              </div> --}}
                          </div>





                          <div class="col-md-6 form-group{{$errors->has('gender') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                              <label class="control-label" for="gender">{{ __('strings.reservation_status') }}</label>
                              <select class="form-control js-select" name="status">
                                  <option value="n" selected>{{ __('strings.reservation_not_confirmed') }}</option>
                                  <option value="y">{{ __('strings.reservation_confirmed') }}</option>
                                  <option value="c">{{ __('strings.cancelled') }}</option>
                                  <option value="w">{{ __('strings.waiting') }}</option>
                                  <option value="r">{{ __('strings.payment_rejected') }}</option>
                              </select>
                              @if ($errors->has('gender'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('gender') }}</strong>
                                  </span>
                              @endif
                          </div>
                          <div class="col-md-6 form-group{{$errors->has('to_date') ? ' has-error' : ''}}">
                              <label class="control-label" for="to_date">{{ __('strings.special_requirements') }} </label>
                              <input type="text" class="form-control" name="additional_requirements" value="{{old('additional_requirements')}}">
                              @if ($errors->has('to_date'))
                                  <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('to_date') }}</strong>
                              </span>
                              @endif
                          </div>
                          <div class="col-md-6 form-group{{$errors->has('to_date') ? ' has-error' : ''}}">
                              <label class="control-label" for="to_date">{{ __('strings.total_amount') }} </label>
                              <input type="text" class="form-control" name="total_amount" value="{{$total_value}}">
                              <input type="hidden" name="total_amount1" value="{{$total_value}}">
                              @if ($errors->has('to_date'))
                                  <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('to_date') }}</strong>
                              </span>
                              @endif
                          </div>

                          <div class="col-md-12 form-group text-right">
                              <button type="submit" class="btn btn-primary btn-lg">  <i class="fas fa-save"></i> {{ __('strings.Save') }}</button>
                          </div>
                      </div>
                  </div>
              </div>
              <input type="hidden" name="cat_id" value="{{$cat_id}}">
              <input type="hidden" name="child_ages" value="{{$child_ages}}">
              <input type="hidden" name="destination" value="{{$destination}}">
              <input type="hidden" name="date_from" value="{{$date_from}}">
              <input type="hidden" name="date_to" value="{{$date_to}}">
              <input type="hidden" name="no_childs" value="{{$no_childs}}">
              <input type="hidden" name="no_adults" value="{{$no_adults}}">
              <input type="hidden" name="tax_ids" value="{{$tax_ids}}">
              <input type="hidden" name="tax_vals" value="{{$tax_vals}}">
              <input type="hidden" name="numbers" value="{{$numbers}}">
              <input type="hidden" name="prices" value="{{$prices}}">
              <input type="hidden" name="sub_ids" value="{{$sub_ids}}">
              <input type="hidden" name="hotel_id" value="{{$hotel_id}}">





          </form>
      </div>
  </div>
@endsection
  @section('scripts')
      <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
      <script>
      $('.js-select').select2({width: 300, required: true});

          var input = document.querySelector("#phone"),
              errorMsg = document.querySelector("#error-msg"),
              validMsg = document.querySelector("#valid-msg");

          var errorMap = ["☓ رقم غير صالح", "☓ رمز البلد غير صالح", "☓ قصير جدا", "☓ طويل جدا", "☓ رقم غير صالح"];

          var iti = window.intlTelInput(input, {
              initialCountry: "auto",
              geoIpLookup: function(callback) {
                  $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                      var countryCode = (resp && resp.country) ? resp.country : "";
                      callback(countryCode);
                  });
              },
              utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/utils.js"
          });

          var reset = function() {
              input.classList.remove("error");
              errorMsg.innerHTML = "";
              errorMsg.classList.add("hide");
              validMsg.classList.add("hide");
          };

          input.addEventListener('blur', function() {
              reset();
              if (input.value.trim()) {
                  if (iti.isValidNumber()) {
                      validMsg.classList.remove("hide");
                  } else {
                      input.classList.add("error");
                      var errorCode = iti.getValidationError();
                      errorMsg.innerHTML = errorMap[errorCode];
                      errorMsg.classList.remove("hide");
                  }
              }
          });

          input.addEventListener('change', reset);
          input.addEventListener('keyup', reset);
          var input2 = document.querySelector("#phone2"),
              errorMsg = document.querySelector("#error-msg2"),
              validMsg = document.querySelector("#valid-msg2");

          var errorMap = ["☓ رقم غير صالح", "☓ رمز البلد غير صالح", "☓ قصير جدا", "☓ طويل جدا", "☓ رقم غير صالح"];

          var iti = window.intlTelInput(input2, {
              initialCountry: "auto",
              geoIpLookup: function(callback) {
                  $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                      var countryCode = (resp && resp.country) ? resp.country : "";
                      callback(countryCode);
                  });
              },
              utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/utils.js"
          });

          var reset = function() {
              input2.classList.remove("error");
              errorMsg.innerHTML = "";
              errorMsg.classList.add("hide");
              validMsg.classList.add("hide");
          };

          input2.addEventListener('blur', function() {
              reset();
              if (input2.value.trim()) {
                  if (iti.isValidNumber()) {
                      validMsg.classList.remove("hide");
                  } else {
                      input.classList.add("error");
                      var errorCode = iti.getValidationError();
                      errorMsg.innerHTML = errorMap[errorCode];
                      errorMsg.classList.remove("hide");
                  }
              }
          });

          input2.addEventListener('change', reset);
          input2.addEventListener('keyup', reset);
      </script>
      <script>
    function fill_customer_data(){
    var cust_id= $('select[name="customer"]').val();
    var telephone= $('select[name="customer"] option:selected').data('telephone');

    var email= $('select[name="customer"] option:selected').data('email');



          $('input[name="phone_number"]').val(telephone);
          $('input[name="email"]').val(email);

        }

        function add_customer_modal(){
          var modal2 = document.getElementById('reservation_modal');
           modal2.style.display = "block";


        }
      function close_reservation_modal(){
      var modal2 = document.getElementById('reservation_modal');
      modal2.style.display = "none";
      }
      function add_reservation_customer(){
        $("#add_customer_store").ajaxForm({
            url: siteUrl + '/admin/ajax/add_customer', type: 'post',
            beforeSubmit: function (response) {
            },
            success: function (response) {

                close_reservation_modal();
                if (lang == 'ar') {
                    $("#client_selectpicker").append("<option value='" + response.data.id + "' data-email='"+response.data.email+"' data-telephone='"+response.dataphone_number+"''>" + response.data.name + "</option>");
                } else {
                    $("#client_selectpicker").append("<option value='" + response.data.id + "' data-email='"+response.data.email+"' data-telephone='"+response.dataphone_number+"''>" + response.data.name + "</option>");
                }
                $('select[name="customer"]').val(response.data.id);
                fill_customer_data();
            },
            error: function (response) {
                alert("Please check your entry date again");
            }
        })

      }
      function add_source_name(){
        $('#source_name_field').empty();
        if($('select[name="source"]').val()==2){
          $('#source_name_field').append('<div class="col-md-3 form-group"><label class="control-label" for="cust_code">{{ __('strings.source_name') }}</label><input type="text" class="form-control" name="source_name"></div>');
        }
      }

      $('#xtreme-table1').on('change', '.cat_id_select' , function () {
        var url = "{{ Route('getCatDetails') }}";

        var selected = $(this);
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: url,
          dataType: 'json',
          data: {
            cat_id: $(this).find('option:selected').val(),
            flag_req: $(this).parents('tr').find('.reg_flagg option:selected').val(),
            req_id: 2,

          },
          type: 'POST',

          beforeSend: function() {


            selected.parents('tr').find('.qnyNum1').attr('disabled',true);
            selected.parents('tr').find('.tax').empty();
            selected.parents('tr').find('.cat_price').empty();
            selected.parents('tr').find('.qnyNum1').empty();
            selected.parents('tr').find('.total').empty();
            selected.parents('tr').find('.taxId').empty();
            selected.parents('tr').find('.tax_val').empty();


          },
          success: function(msg) {
            if (msg.data == 'successGetPice') {
              selected.parents('tr').find('.tax_val').val(msg.catTax);
              selected.parents('tr').find('.tax1').text(msg.catTax);
              selected.parents('tr').find('.cat_price_input1').val(msg.catPrice);
              selected.parents('tr').find('.cat_price').text(msg.catPrice);
              selected.parents('tr').find('.qnyNum1').attr('disabled',false);

              selected.parents('tr').find('.qnyNum1').val(1);
              selected.parents('tr').find('.total').text(msg.catPrice * selected.parents('tr').find('.qnyNum1').val());
              selected.parents('tr').find('.taxId1').val(msg.taxId);
              calcResrvationtotal(selected);
              var flag_req = 0;

              if (selected.parents('tr').find('.reg_flag_select option:selected').val() == 1) {
                  selected.parents('tr').find('.qnyNum1').attr('min',0);
                  selected.parents('tr').find('.qnyNum1').val(1);

                  selected.parents('tr').find('.qnyNum1').attr('max',msg.flag);
              };

            }else{
              selected.parents('tr').find('.qnyNum1').empty();
              selected.parents('tr').find('.reg_flag_select').html(
                ` <option value="-1">{{  __('strings.external_req_ex') }}</option>
                 <option value="1">{{ __('strings.external_req_ret')}}</option>`
              );

                selected.parents('td').html(
                  `
                  <select name="additional_category[]" class="js-select cat_id_select">
                  <option value="0">{{__('strings.choose_additional_categories')}}</option>
                @foreach($additional_categories as $additional_category)
                  <option class="btnTest" value="{{ $additional_category->id }}"  >  {{app()->getLocale()=='ar'?$additional_category->name:$additional_category->name_en}} </option>
                  @endforeach
                  </select>
                  `);
                alert('هذا المنتج ليس له سعر');
            }

            }
          });
        return false;

      });
      $('#xtreme-table2').on('change', '#cat_id_select1' , function () {
        var url = "{{ Route('getCatDetails') }}";

        var selected = $(this);
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url: url,
          dataType: 'json',
          data: {
            cat_id: $(this).find('option:selected').val(),
            flag_req: $(this).parents('tr').find('.reg_flagg option:selected').val(),
            req_id: 2,

          },
          type: 'POST',

          beforeSend: function() {


            selected.parents('tr').find('.qnyNum2').attr('disabled',true);
            selected.parents('tr').find('.tax').empty();
            selected.parents('tr').find('.cat_price').empty();
            selected.parents('tr').find('.qnyNum2').empty();
            selected.parents('tr').find('.total').empty();
            selected.parents('tr').find('.taxId').empty();
            selected.parents('tr').find('.tax_val').empty();


          },
          success: function(msg) {
            if (msg.data == 'successGetPice') {
              selected.parents('tr').find('.tax_val').val(msg.catTax);
              selected.parents('tr').find('.tax2').text(msg.catTax);
              selected.parents('tr').find('.cat_price_input2').val(msg.catPrice);
              selected.parents('tr').find('.cat_price').text(msg.catPrice);
              selected.parents('tr').find('.qnyNum2').attr('disabled',false);

              selected.parents('tr').find('.qnyNum2').val(1);
              selected.parents('tr').find('.total').text(msg.catPrice * selected.parents('tr').find('.qnyNum2').val());
              selected.parents('tr').find('.taxId2').val(msg.taxId);
              calcResrvationtotal(selected);
              var flag_req = 0;

              if (selected.parents('tr').find('.reg_flag_select option:selected').val() == 1) {
                  selected.parents('tr').find('.qnyNum2').attr('min',0);
                  selected.parents('tr').find('.qnyNum2').val(1);

                  selected.parents('tr').find('.qnyNum2').attr('max',msg.flag);
              };

            }else{
              selected.parents('tr').find('.qnyNum2').empty();
              selected.parents('tr').find('.reg_flag_select').html(
                ` <option value="-1">{{  __('strings.external_req_ex') }}</option>
                 <option value="1">{{ __('strings.external_req_ret')}}</option>`
              );

                selected.parents('td').html(
                  `
                  <select name="cat_id[]" form="newRequests" class="cat_id_select form-control" required>
                  <option class="btnTest" style="display:none"></option>
                  @foreach ($iterable as  $value)
                  <option class="btnTest" value="{{ $value->id }}"  >  {{ $value->name }} </option>
                  @endforeach
                  </select>
                  `);
                alert('هذا المنتج ليس له سعر');
            }

            }
          });
        return false;

      });
      $('#xtreme-table2').on('change', '.qnyNum2' , function () {
        var total = $(this).val() * $(this).parents('tr').find('.cat_price').text() ;
        $(this).parents('tr').find('.total').text(total.toFixed(2));
        calcResrvationtotal($(this));
      });
      $('#xtreme-table1').on('change', '.qnyNum1' , function () {
        var total = $(this).val() * $(this).parents('tr').find('.cat_price').text() ;
        $(this).parents('tr').find('.total').text(total.toFixed(2));
        calcResrvationtotal($(this));
      });
      $("#xtreme-table2").on('click', '.btn-close-regust2', function () {
        var minus = 0,plus = 0;
        if ($(this).parents('tr').find('.reg_flagg select').val()  == -1) {
          minus = $('.finalTotalPrice').text()  -  $(this).parents('tr').find('.fPrice').text()  ;
          $('.finalTotalPrice').text(minus);
        }
        else if ($(this).parents('tr').find('.reg_flagg select').val()  == 1) {
          plus = $('.finalTotalPrice').text()  +  $(this).parents('tr').find('.fprice_2').text()  ;
          $('.finalTotalPrice').text(plus);
        }
        $(this).parents('tr').remove();
      });
      $("#xtreme-table1").on('click', '.btn-close-regust2', function () {
        var minus = 0,plus = 0;
        if ($(this).parents('tr').find('.reg_flagg select').val()  == -1) {
          minus = $('.finalTotalPrice').text()  -  $(this).parents('tr').find('.fPrice').text()  ;
          $('.finalTotalPrice').text(minus);
        }
        else if ($(this).parents('tr').find('.reg_flagg select').val()  == 1) {
          plus = $('.finalTotalPrice').text()  +  $(this).parents('tr').find('.fprice_1').text()  ;
          $('.finalTotalPrice').text(plus);
        }
        $(this).parents('tr').remove();
      });
      $('#main-wrapper').on('click','#addRow1',function(){
             var data = `
         <tr>
        <td>
        <select name="additional_category[]" class="js-select cat_id_select">
          <option value="0">{{__('strings.choose_additional_categories')}}</option>
          @foreach($additional_categories as $additional_category)
            <option value="{{$additional_category->id}}">
              {{app()->getLocale()=='ar'?$additional_category->name:$additional_category->name_en}}
            </option>
          @endforeach
        </select>
        </td>
        <td>
          <input class="form-control qnyNum1" name="additional_number[]"  type="number" disabled required>
        </td>
        <td>
          <span class="cat_price"></span>
          <input class="cat_price_input1"   type="hidden" name="add_cat_price[]">
          <input class="tax_val1" type="hidden"   name="add_tax_val[]" required>
           <input class="taxId1" name="add_taxId[]" type="hidden"    required>
        </td>
        <td>
          <span class="tax"></span>
        </td>
        <td class="fprice_1">
          <span class="total"></span>
        </td>
        <td>
          <button type="button" id="deltr" style="color: red;"   class="btn btn-defult btn-close-regust2"><i class="fas fa-times"></i></button>
        </td>
         </tr>

      `;
          $('#xtreme-table1 tbody').append(data);
         });
         $('#main-wrapper').on('click','#addRow2',function(){
                var data = `
            <tr>
           <td>
           <select name="services[]"  class="js-select" id="cat_id_select1">
             <option value="0">{{__('strings.choose_customer')}}</option>
             @foreach($additional_services as $additional_service)
               <option value="{{$additional_service->id}}">{{app()->getLocale()=='ar'?$additional_service->name:$additional_service->name_en}}</option>
             @endforeach
           </select>
           </td>
           <td>
             <input class="form-control qnyNum2" name="services_number[]"  type="number" disabled required>
           </td>
           <td>
             <span class="cat_price"></span>
             <input class="cat_price_input2"   type="hidden" name="service_cat_price[]">
             <input class="tax_val2" type="hidden"   name="service_tax_val[]" required>
              <input class="taxId2" name="service_taxId[]" type="hidden"    required>
           </td>
           <td>
             <span class="tax"></span>
           </td>
           <td class="fprice_2">
             <span class="total"></span>
           </td>
           <td>
             <button type="button" id="deltr" style="color: red;"   class="btn btn-defult btn-close-regust2"><i class="fas fa-times"></i></button>
           </td>
            </tr>

         `;
             $('#xtreme-table2 tbody').append(data);
            });
      </script>



  @endsection

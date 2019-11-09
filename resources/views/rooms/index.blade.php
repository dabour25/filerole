@extends('layouts.admin', ['title' => __('strings.rooms') ])
@section('content')
    <style>
        .modal {
            display: none; /* Hidden by default */
            overflow-y: auto;
            overflow-y: initial !important
        }

        td.details-control_room {
            background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control_room {
            background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
        }

        .modal-body {


        }
    </style>

    <div class="modal  newModel" id="Modal1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" onclick="close_modal()" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-content">
                <div class="modal-body" style="overflow: hidden">
                    <form method="post" id="addCategories" action="{{url('admin/rooms/add')}}" enctype="multipart/form-data">
                        {{csrf_field()}}

                            <input type="hidden" name="property_id">
                        <div class="col-md-6 form-group{{$errors->has('cate_id') ? ' has-error' : ''}}">
                            <strong
                                    class="text-danger">*</strong>
                            <label class="text-center">@lang('strings.rome_type')</label>
                            <select class="js-select2 New_select form-control" ids="cate_id" name="cate_id" id="cate_id_selected">
                                @foreach($categories as $cate)
                                    <option id="option-{{$cate->id}}" data-max_kids="{{$cate->max_kids}}"
                                            data-max_adult="{{$cate->max_adult}}"
                                            data-max_people="{{$cate->max_people}}"
                                            value="{{ $cate->id }}">{{ app()->getLocale() == 'ar' ? $cate->name : $cate->name_en }}</option>
                                @endforeach
                            </select>
                            <i id="cate_id_sf" style="display:none" class="fa fa-check  color-success"></i>
                            <i id="subcate_id" style="display:none" class="fa fa-times color-danger"></i>
                            <div id="cate_id_error" style="color: red;"  ></div>

                            <div id="showDataAfterSele">

                            </div>
                        </div>

                        <div class="col-md-6 form-group{{$errors->has('property_id') ? ' has-error' : ''}}">
                            <strong
                                    class="text-danger">*</strong>
                            <label class="text-center">@lang('strings.property_name')</label>
                            <select class="js-select form-control" id="property_id" name="property_id">

                                @foreach($hotels as $hotel)
                                    <option id="iam_here_my_op" value="{{ $hotel->id }}">{{ app()->getLocale() == 'ar' ? $hotel->name : $hotel->name_en }}</option>
                                @endforeach
                            </select>

                            <i id="subok" style="display:none" class="fa fa-check  color-success"></i>
                            <i id="subcancel" style="display:none" class="fa fa-times color-danger"></i>
                            <div id="property_id_error" style="color: red;"  ></div>
                        </div>

                        <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"><strong
                                    class="text-danger">*</strong>
                            <label class="control-label" for="name">{{ __('strings.rooms_name_ar') }}</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
                            <i id="nameok" style="display:none" class="fa fa-check  color-success"></i>
                            <i id="namecancel" style="display:none" class="fa fa-times color-danger"></i>
                            <div id="name_error" style="color: red;"  ></div>

                        </div>


                        <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                            <strong
                                    class="text-danger">*</strong>
                            <label class="control-label" for="name_en">{{ __('strings.rooms_name_en') }}</label>
                            <input type="text" class="form-control" name="name_en" id="name_en"
                                   value="{{old('name_en')}}" required="required">
                            <i id="nameok_en" style="display:none" class="fa fa-check  color-success"></i>
                            <i id="namecancel_en" style="display:none" class="fa fa-times color-danger"></i>
                            <div id="name_error_en" style="color: red;"  ></div>

                        </div>



                        <div class="col-md-6 form-group{{$errors->has('cancel_policy') ? ' has-error' : ''}}">
                            <label class="text-center">@lang('strings.cancel_policy')</label>
                            <select class="js-select2 New_select form-control" name="cancel_policy" id="cancel_policy_selected">
                              
                                <option value="free cancelation">{{__('strings.free_cancelation')}}</option>
                                <option value="before check in">{{__('strings.before_check_in')}}</option>
                            </select>

                            @if ($errors->has('cancel_policy'))
                                <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('cancel_policy
                          .') }}</strong>
                      </span>
                            @endif

                            <div id="day_cancel_policy_appen">

                            </div>
                        </div>
                        <hr>

                        <div class="panel panel-white">
                            <div class="panel-heading clearfix">
                                <h4 class="panel-title">@lang('strings.Photo')</h4>
                            </div>
                            <strong
                                    class="text-danger">*</strong>
                            <label>اختار الصوره</label>
                            <input type="file" name="photo" id="photo" data-min-width="500" data-min-height="400">
                             <span class="help-block">
                                    <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 400*500</strong>
                                </span>
                            <i id="photook" style="display:none" class="fa fa-check  color-success"></i>
                            <i id="photookcancel" style="display:none" class="fa fa-times color-danger"></i>
                            <div id="photook_error" style="color: red;"  ></div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading clearfix">
                                <h4 class="panel-title">@lang('strings.prices_room')</h4>
                            </div>
                            <div class="col-md-6" >
                                <strong class="text-danger">*</strong>
                                <label class="control-label">{{__('strings.price_a_night')}}</label>
                                <input onfocusout="focapriceslist()" type="number" step=0.001 class="form-control" name="price" id="price" value="{{old('price')}}" required="required">
                                <i id="priceen" style="display:none" class="fa fa-check  color-success"></i>
                                <i id="priceen_" style="display:none" class="fa fa-times color-danger"></i>
                                <div id="price_error_en" style="color: red;"  ></div>
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('tax') ? ' has-error' : ''}}">
                                <strong
                                        class="text-danger"></strong>
                                <label class="text-center">@lang('strings.Tax_type')</label>
                                <select class="form-control" id="tax" name="tax">
                                    <option value="">{{__('strings.Select_tax_type')}}</option>
                                    @foreach($taxs as $tax)
                                        <option id="tax-change-{{$tax->id}}" value="{{$tax->id}}" data-tax_value="{{$tax->value}}" data-tax_percent="{{$tax->percent}}">{{ app()->getLocale() == 'ar' ? $tax->name : $tax->name_en }}</option>
                                    @endforeach
                                </select>

                                <i id="taxok" style="display:none" class="fa fa-check  color-success"></i>
                                <i id="taxcancel" style="display:none" class="fa fa-times color-danger"></i>
                                <div id="taxerror" style="color: red;"  ></div>
                            </div>

                            <div id="pricesListAppend" style=" text-align: center !important;">

                            </div>



                            </div>

                        <div class="panel panel-white">
                            <div class="panel-heading clearfix">
                                <h4 class="panel-title">@lang('strings.day_closure')</h4>
                            </div>
                            <div class="copy">

                            </div>
                            <div class="col-md-12 input-group control-group after-add-more {{$errors->has('cancel_policy') ? ' has-error' : ''}}">
                                <div class="input-group-btn col-md-3">
                                    <button class="btn btn-success add-more" type="button">{{__('strings.add_more_cloth')}}</button>
                                </div>
                            </div>
                        </div>


                        <hr>

                        @if(isset($amentities))
                            <div class="col-md-6 form-group{{$errors->has('amentities') ? ' has-error' : ''}}">
                                <label class="control-label" for="amentities">{{ __('strings.amentities') }}</label>
                                <select name="amentities[]" class="js-example-basic-multiple" multiple="multiple">
                                    @foreach($amentities as $cate)
                                        <option value="{{$cate->id}}">{{ app()->getLocale()== 'ar' ? $cate->name :$cate->name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div>
                                add categories <a href="#"></a>
                            </div>
                        @endif

                        <div class="col-md-6 form-group{{$errors->has('category_num') ? ' has-error' : ''}}"><strong
                                    class="text-danger"></strong>
                            <label class="control-label" for="rank">{{ __('strings.the_number_of_rooms') }}</label>
                            <input type="number" class="form-control" name="category_num" id="category_num"
                                   value="{{old('category_num')}}">
                            <i  style="display:none" class="fa fa-check  color-success nameokcategory_num"></i>
                            <i  style="display:none" class="fa fa-times color-danger namecancelcategory_num"></i>
                            <div class="category_num_error" style="color: red;"  ></div>
                        </div>

                        <div class="col-md-12 form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg"> {{ __('strings.Save') }} </button>
                        </div>
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
                            {{ DB::table('function_new')->where('id',255)->value('description') }}
                        @else
                            {{ DB::table('function_new')->where('id',255)->value('description_en') }}
                        @endif
                    </p>
                    <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                    </a>
                </div>
                </br>
                @if($countOfRooms == 0)
                    <h2><strong>{{__('strings.ifNotFoundRooms')}}</strong></h2>
                @endif
                    </br>
                    <form method="get" action="{{url('admin/hotel/search')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                            <label>@lang('strings.property')</label>
                            <select class="form-control js-select" name="hotel">
                                <option {{$id==0?'selected':''}} value="0">{{__('strings.all')}}</option>
                                @foreach(\App\Property::where('org_id',Auth::user()->org_id)->get() as $hotel)

                                    <option {{$id==$hotel->id?'selected':''}} value="{{$hotel->id}}">{{ app()->getLocale() == 'ar' ? $hotel->name  : $hotel->name_en  }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button id="search_button" type="submit" onclick=""
                                class="btn btn-primary btn-lg">@lang('strings.Search')</button>
                    </form>
                    </br>

                    <a href="{{url('admin/property/add')}}">
                        <button type="button" class="btn btn-primary btn-lg">@lang('strings.create_property')</button>
                    </a>

                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">@lang('strings.property')</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th style="display: none;">#</th>
                                        <th>{{ __('strings.Arabic_name') }}</th>
                                        <th>{{ __('strings.English_name') }}</th>
                                        <th>{{__('strings.destination')}}
                                        <th>@lang('strings.Settings')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($hotels))
                                    @foreach($hotels as $hotel)
                                        <tr>
                                            <td class=" details-control_room"></td>
                                            <td style="display: none;">{{ $hotel->id }}</td>
                                            <td>{{ $hotel->name }}</td>
                                            <td>{{ $hotel->name_en }}</td>
                                            <td>{{app()->getLocale() == 'ar' ? $hotel->destination_name_ar:$hotel->destination_name_en}}</td>
                                            <td>
                                                @if(permissions('add_new_room') == 1)
                                                <button type="button" id="modal_button1"  data-name-hotel="{{ app()->getLocale() == 'ar' ? $hotel->name : $hotel->name_en}}"
                                                        onclick="add_room({{$hotel->id}})"
                                                        class="btn btn-info btn-lg NewBtn btnclient Hotle_name"><i
                                                            class="fas fa-plus"></i></button>
                                                 @endif            
                                                            
                                                <a href="{{url('admin/property/updated/'. $hotel->id) }}"
                                                   class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                   data-placement="bottom" title=""
                                                   data-original-title="{{ __('strings.edit') }} "> <i
                                                            class="fa fa-pencil"></i></a>
                                                <a href="#" class="btn btn-danger btn-xs" data-toggle="tooltip"
                                                   data-placement="bottom" title=""
                                                   data-original-title="{{ __('strings.delete_btn') }}"> <i
                                                            class="fa fa-trash-o"></i></a>

                                            </td>
                                        </tr>
                                    @endforeach
                                        @endif
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
            </div>
        </div>
     @endsection

  
 @section('scripts')
  <script>
       $('.js-example-basic-multiple').select2();
  </script>
  
    <script src="{{asset('js/jquery.checkImageSize.min.js')}}"></script>
    <script> 
        $("input[type='file']").checkImageSize({
              minWidth: $(this).data('min-width'),
            minHeight: $(this).data('min-height'),
            showError:true,
            ignoreError:false
        });
        
    </script>

        

    
<script>

        function modal_show(id) {
        console.log($('#modal_button').data());
        $('input[name="location_id"]').val($('#modal_button' + id).data('id'));
        $('input[name="name"]').val($('#modal_button' + id).data('name'));
        $('input[name="name_en"]').val($('#modal_button' + id).data('name_en'));

        $('input[name="description"]').val($('#modal_button' + id).data('description'));
        $('input[name="longitude"]').val($('#modal_button' + id).data('longitude'));
        $('input[name="latitude"]').val($('#modal_button' + id).data('latitude'));
        $('select[name="destination_id"]').val($('#modal_button' + id).data('destination_id'));
        $('select[name="active"]').val($('#modal_button' + id).data('active'));
        }

        function add_room(id) {

        var modal2 = document.getElementById('Modal1');
        modal2.style.display = "block";
        var my_name = $('.Hotle_name').data('name-hotel');
        console.log(my_name);
        console.log($('select[name="property_id"]').val(id));
         $('select[name="property_id"]').val(id).trigger("change");



        };

        function close_modal() {
        var modal2 = document.getElementById('Modal1');
        modal2.style.display = "none";
        };

        $('#cate_id_selected').on('change', function () {
        console.log($('#cate_id_selected').val());
        var max_adult = $('#option-' + $('#cate_id_selected').val()).data('max_adult') != undefined ? $('#option-' + $('#cate_id_selected').val()).data('max_adult') : '';
        var max_kids = $('#option-' + $('#cate_id_selected').val()).data('max_kids') != undefined ? $('#option-' + $('#cate_id_selected').val()).data('max_kids') : '';
        var max_people = $('#option-' + $('#cate_id_selected').val()).data('max_people') != undefined ? $('#option-' + $('#cate_id_selected').val()).data('max_people') : '';

        var mydi = document.getElementById('showDataAfterSele');
        mydi.style.display = "";


        $('#showDataAfterSele').empty();
        $('#showDataAfterSele').append(
        '<p>' + 'عدد كبار السن =   ' + max_adult + ' </p>' +
        '<p>' + 'عدد صغار السن =   ' + max_kids + ' </p>' +
        '<p>' + 'الحد الاقصي للافراد بالغرفه =   ' + max_people + ' </p>'
        );


        });


        $('#cancel_policy_selected').on('change', function () {

        var cansel_sele = $('#cancel_policy_selected').val();

        if (cansel_sele == 'before check in') {
        $('#day_cancel_policy_appen').append(
        '<label class="control-label" for="rank">{{ __("strings.the_number_of_days") }}</label>' +
        '<input type="number" class="form-control" name="cancel_days" id="rank">' +
        '<p>{{__("strings.day_notes")}}</p>' +
        '<label class="control-label" for="rank">{{ __("strings.cancel_charge_title") }}</label>' +
        ' <input type="number" class="form-control" step=0.01 name="cancel_charge">' +
        '<p>{{__("strings.cancel_charge_notes")}}</p>'
        );
        } else {
        $('#day_cancel_policy_appen').empty();
        }


        });


        $('#tax').on('change',function () {
            var myvalue = $('#tax-change-'+$('#tax').val()).data("tax_value")!= undefined?$('#tax-change-'+$('#tax').val()).data("tax_value"):0;
            var mypercent = $('#tax-change-'+$('#tax').val()).data("tax_percent")!= undefined?$('#tax-change-'+$('#tax').val()).data("tax_percent"):0;
            var price = $('#price').val();
            var total ;
            var show;

            if(price !='') {
                if(mypercent != '') {
                    total = price * mypercent / 100 ;

                    show = Number(price) + Number(total);
                }
                else{
                    total = Number(price) + Number(myvalue);

                    show = total;
                }
                $('#pricesListAppend').empty();
                $('#pricesListAppend').append(
                    '<p>{{__('strings.total')}}</p>'+
                    '<p>' + show +'</P>'
                );
            }else{
                $('#pricesListAppend').empty();
            }


            if(myvalue ==0 && mypercent==0)
            {
                $('#pricesListAppend').empty();
            }





        });

        function focapriceslist(){
            var price = $('#price').val();

            var myvalue = $('#tax-change-'+$('#tax').val()).data("tax_value")!= undefined?$('#tax-change-'+$('#tax').val()).data("tax_value"):0;
            var mypercent = $('#tax-change-'+$('#tax').val()).data("tax_percent")!= undefined?$('#tax-change-'+$('#tax').val()).data("tax_percent"):0;

            if(myvalue !=0 || mypercent!=0 ){
                if(price !='') {
                    if(mypercent != '') {
                        total = price * mypercent / 100 ;

                        show = Number(price) + Number(total);
                    }
                    else{
                        total = Number(price) + Number(myvalue);

                        show = total;
                    }
                    $('#pricesListAppend').empty();
                    $('#pricesListAppend').append(
                        '<p>{{__('strings.total')}}</p>'+
                        '<p>' + show +'</P>'
                    );
                }else{
                    $('#pricesListAppend').empty();
                }




            }

            if(myvalue ==0 && mypercent==0 &&price ==0)
            {
                $('#pricesListAppend').empty();
            }
        }





        $(document).ready(function () {


        $(".add-more").click(function () {
            var counter;
            counter= parseInt(localStorage.getItem('addDate'));

        var html = $(".copy").append(
        ' <div class="control-group input-group col-md-12">'+
            '<div class="col-md-4">'+
                '  <label class="text-center">@lang("strings.Date_fromm")</label>'+
                '  <input type="text" placeholder="{{ __('strings.Date_fromm') }}"  ids="from" name="from[]" class="form-control datepicker_reservation'+counter+'">'+
                '</div>'+
            '<div class="col-md-4">'+
                ' <label class="text-center">@lang("strings.To_date")</label>'+
                ' <input type="text" name="to[]" placeholder="{{ __('strings.To_date') }}" class="form-control datepicker_reservation2'+counter+'">'+
                '</div>'+
            '<div class="col-md-3">'+
                '  <label class="control-label" placeholder="{{ __('strings.reason') }}" for="reason">{{ __("strings.reason") }}</label>'+
                ' <input type="text" class="form-control" name="reason[]" id="reason">'+
                '<div class="input-group-btn pull-left">'+
                    ' <button class="btn btn-danger remove" type="button">' +
                        '<i class="glyphicon glyphicon-remove"></i></button>'+
                    '</div>'+
                ' </div>'
            );
            var reservation_date = new Date();
            $(".datepicker_reservation"+counter).datepicker({

                date: reservation_date,
                startDate: reservation_date,
                rtl: true,
                viewMode: 'years',
                format: 'yyyy-mm-dd',


            }).on('changeDate', function (e) {
                var date2 =
                    $('.datepicker_reservation'+counter).datepicker('getDate', '+1d');
                date2.setDate(date2.getDate() + 1);

                var msecsInADay = 8640000;
                var endDate = new Date(date2.getTime() + msecsInADay);
                $('.datepicker_reservation2'+counter).datepicker('setStartDate', endDate);
                $('.datepicker_reservation2'+counter).datepicker('setDate', endDate);


            });


            $('.datepicker_reservation2'+counter).datepicker({

                format: 'yyyy-mm-dd',
            });
            $(".after-add-more").after(html);

            var addnew =counter+1;
            parseInt(localStorage.setItem('addDate',addnew));


        });


            $("body").on("click", ".remove", function () {
            $(this).parents(".control-group").remove();
            });
            localStorage.setItem("addDate", 1);
            $(".add-more").click();
            });

            $("#addCategories").validate({
            errorClass: "has-error",
            validClass: "has-success",
            rules: {
            "property_id": {
            required: true,
            digits: true
            },
            "name": {
            required: true,
            maxlength: 70
            },
            "name_en": {
            required: true,
            maxlength: 70
            },
            "cate_id": {
            required: true,
            digits: true

            },"photo":{
            required: true,
            accept: "image/*"
            },"tax":{
                    required: false,
                    digits: true
            },"price":{
                    required: true,
                    number: true
                }


            },

            messages: {

            "property_id": {
            required: "{{__('strings.valid_property')}}",

            },
            "cate_id": {
            required: "{{__('strings.valid_cate_id')}}",

            },

            "category_num": {
            required: "{{__('strings.valid_category_num')}}",

            },

            "name": {
            required: "{{__('strings.valid_name')}}",
            maxlength: "{{trans('admin.max_length_validate')}}"
            },
            "name_en": {
            required: "{{__('strings.valid_name')}}",
            maxlength: "{{trans('admin.max_length_validate')}}"
            },"photo":{
            required:'يجب ادخال صوره',
            accept:'يجب ان تكون صوره',
            },"tax":{
                    required:"{{__('strings.tax_valid')}}",
           },"price":{
                    required:"{{__('strings.prices_valid')}}",
                }

            }, errorPlacement: function (error, element) {
            if (element.attr('id') == 'property_id') {
            $('#subok').hide();
            $('#subcancel').show();
            $('#property_id_error').html('<div class="error-message">' + error.html() + '</div>');
            error.remove();
            } else if (element.attr('ids') == 'cate_id') {
            $('#cate_id_sf').hide();
            $('#subcate_id').show();
            $('#cate_id_error').html('<div class="error-message">' + error.html() + '</div>');
            error.remove();
            } else if (element.attr('id') == 'name') {
            $('#nameok').hide();
            $('#namecancel').show();
            $('#name_error').html('<div class="error-message">' + error.html() + '</div>');
            error.remove();
            } else if (element.attr('id') == 'name_en') {
            $('#nameok_en').hide();
            $('#namecancel_en').show();
            $('#name_error_en').html('<div class="error-message">' + error.html() + '</div>');
            error.remove();

            }
            else if (element.attr('id') == 'photo') {
            $('#photook').hide();
            $('#photookcancel').show();
            $('#photook_error').html('<div class="error-message">' + error.html() + '</div>');
            error.remove();

            }else if (element.attr('id') == 'price') {
            $('#priceen').hide();
            $('#priceen_').show();
            $('#price_error_en').html('<div class="error-message">' + error.html() + '</div>');
            error.remove();

            }else if (element.attr('id') == 'tax') {
                $('#taxok').hide();
                $('#taxcancel').show();
                $('#taxerror').html('<div class="error-message">' + error.html() + '</div>');
                error.remove();

            }
            else {
            element.next().remove();
            error.insertAfter("#" + element.attr('id'));
            }

            },

            });


            $("#xtreme-table").on('click', '.btn-close-regust2', function () {
            var minus = 0, plus = 0;
            if ($(this).parents('tr').find('.reg_flagg select').val() == -1) {
            minus = $('.finalTotalPrice').text() - $(this).parents('tr').find('.fPrice').text();
            $('.finalTotalPrice').text(minus);
            } else if ($(this).parents('tr').find('.reg_flagg select').val() == 1) {
            plus = $('.finalTotalPrice').text() + $(this).parents('tr').find('.fprice_1').text();
            $('.finalTotalPrice').text(plus);
            }
            $(this).parents('tr').remove();
            });

            function intializecategory_type(){
            console.log($('#cate_id_selected').val());
            var max_adult = $('#option-' + $('#cate_id_selected').val()).data('max_adult') != undefined ? $('#option-' + $('#cate_id_selected').val()).data('max_adult') : '';
            var max_kids = $('#option-' + $('#cate_id_selected').val()).data('max_kids') != undefined ? $('#option-' + $('#cate_id_selected').val()).data('max_kids') : '';
            var max_people = $('#option-' + $('#cate_id_selected').val()).data('max_people') != undefined ? $('#option-' + $('#cate_id_selected').val()).data('max_people') : '';

            var mydi = document.getElementById('showDataAfterSele');
            mydi.style.display = "";


            $('#showDataAfterSele').empty();
            $('#showDataAfterSele').append(
            '<p>' + 'عدد كبار السن =   ' + max_adult + ' </p>' +
            '<p>' + 'عدد صغار السن =   ' + max_kids + ' </p>' +
            '<p>' + 'الحد الاقصي للافراد بالغرفه =   ' + max_people + ' </p>'
            );
            }
            intializecategory_type();






</script>


        </div>
@endsection

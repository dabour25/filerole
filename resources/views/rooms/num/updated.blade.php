@extends('layouts.admin', ['title' => __('strings.room_num') ])
@section('content')
    <style>
        .modal {
            display: none; /* Hidden by default */
            overflow-y: auto;
        }

        td.details-control {
            background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
        }

        .modal-body {

        }
    </style>

    <div id="main-wrapper">
        <div class="row">
            @include('alerts.index')
            <div class="" style=" text-align: center !important;">
                <h1>@lang('strings.updated_room_num')</h1>
                <br>
                <h2><strong>{{app()->getLocale() == 'ar'? $room->name :$room->name_en}}</strong></h2>
                <br>
                <a href="{{url('admin/rooms/number')}}">
                    <button type="button" class="btn btn-info btn-lg">@lang('strings.back_room_num')</button>
                </a>
            </div>
            <hr>
            <br>
            <div class="row">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('strings.edit') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form method="post" id="addNewRoomForm" action="{{url('admin/rooms/number/updated')}}"
                              enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$catNum->id}}">

                            <div class="panel panel-white">


                            </div>

                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title"></h4>
                                    <table class="table table-striped table-bordered"
                                           style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>{{ __('strings.property_name') }}</th>
                                            <th>{{__('strings.rome_type')}}
                                            <th>{{ __('strings.room_name') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>{{app()->getLocale()== 'ar' ?$catNum->pro_name :$catNum->pro_name_en}}</td>
                                                <td>{{app()->getLocale()== 'ar' ?$catNum->type_name_ar :$catNum->type_name_ar}}</td>
                                                <td>{{app()->getLocale()== 'ar' ?$catNum->categor_name :$catNum->categor_name_en}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="panel panel-white">

                                <div class="panel-body">
                                    <div class="col-md-4 form-group{{$errors->has('cat_num') ? ' has-error' : ''}}">
                                        <strong class="text-danger">*</strong>
                                        <label class="control-label" for="cat_num">{{ __('strings.cat_num') }}</label>
                                        <input type="text" class="form-control" name="cat_num" id="cat_num_"
                                               value="{{old('cat_num')!=null?old('cat_num') :$catNum->cat_num}}">
                                        <i id="cat_nummvlaid" style="display:none" class="fa fa-check  color-success"></i>
                                        <i id="cat_nummvlaid__" style="display:none" class="fa fa-times color-danger"></i>
                                        <div class="cat_num_error"></div>
                                    </div>
                                    <div class="col-md-4 form-group{{$errors->has('floor_num') ? ' has-error' : ''}}">
                                        <strong class="text-danger">*</strong>
                                        <label class="control-label" for="floor_num">{{ __('strings.floor_num') }}</label>
                                        <select class="js-select2 New_select form-control" name="floor_num" id="floor_num_">
                                            <option value="0"
                                                    @if(old('floor_num')!=null)
                                                    {{old('floor_num')==0?'selected':''}}
                                                    @else
                                                    {{$catNum->floor_num ==0?'selected':''}}
                                                   @endif
                                            >{{ __('strings.floor_0') }}</option>
                                            <option value="1"
                                            @if(old('floor_num')!=null)
                                                {{old('floor_num')==1?'selected':''}}
                                                    @else
                                                {{$catNum->floor_num ==1?'selected':''}}
                                                    @endif
                                            >{{ __('strings.floor_1') }}</option>
                                            <option value="2"
                                            @if(old('floor_num')!=null)
                                                {{old('floor_num')==2?'selected':''}}
                                                    @else
                                                {{$catNum->floor_num ==2?'selected':''}}
                                                    @endif
                                            >{{ __('strings.floor_2') }}</option>
                                            <option value="3"
                                            @if(old('floor_num')!=null)
                                                {{old('floor_num')==3?'selected':''}}
                                                    @else
                                                {{$catNum->floor_num ==3?'selected':''}}
                                                    @endif
                                            >{{ __('strings.floor_3') }}</option>
                                            <option value="4"
                                            @if(old('floor_num')!=null)
                                                {{old('floor_num')==4?'selected':''}}
                                                    @else
                                                {{$catNum->floor_num ==4?'selected':''}}
                                                    @endif
                                            >{{ __('strings.floor_4') }}</option>
                                            <option value="5"
                                            @if(old('floor_num')!=null)
                                                {{old('floor_num')==5?'selected':''}}
                                                    @else
                                                {{$catNum->floor_num ==5?'selected':''}}
                                                    @endif
                                            >{{ __('strings.floor_5') }}</option>
                                            <option value="6"
                                            @if(old('floor_num')!=null)
                                                {{old('floor_num')==6?'selected':''}}
                                                    @else
                                                {{$catNum->floor_num ==6?'selected':''}}
                                                    @endif
                                            >{{ __('strings.floor_6') }}</option>
                                            <option value="7"
                                            @if(old('floor_num')!=null)
                                                {{old('floor_num')==7?'selected':''}}
                                                    @else
                                                {{$catNum->floor_num ==7?'selected':''}}
                                                    @endif
                                            >{{ __('strings.floor_7') }}</option>
                                            <option value="8"
                                            @if(old('floor_num')!=null)
                                                {{old('floor_num')==8?'selected':''}}
                                                    @else
                                                {{$catNum->floor_num ==8?'selected':''}}
                                                    @endif
                                            >{{ __('strings.floor_8') }}</option>
                                            <option value="9"
                                            @if(old('floor_num')!=null)
                                                {{old('floor_num')==9?'selected':''}}
                                                    @else
                                                {{$catNum->floor_num ==9?'selected':''}}
                                                    @endif
                                            >{{ __('strings.floor_9') }}</option>
                                            <option value="10"
                                            @if(old('floor_num')!=null)
                                                {{old('floor_num')==10?'selected':''}}
                                                    @else
                                                {{$catNum->floor_num ==10?'selected':''}}
                                                    @endif
                                            >{{ __('strings.floor_10') }}</option>
                                        </select>
                                        <i id="floor_nummvlaid" style="display:none" class="fa fa-check  color-success"></i>
                                        <i id="floor_nummvlaid__" style="display:none" class="fa fa-times color-danger"></i>
                                        <div class="floor_num_error"></div>
                                    </div>
                                    <div class="col-md-4 form-group{{$errors->has('building') ? ' has-error' : ''}}">
                                        <strong class="text-danger"></strong>
                                        <label class="control-label" for="building">{{ __('strings.building') }}</label>
                                        <input type="text" class="form-control" name="building" id="building_"
                                               value="{{old('building')!=null?old('building'):$catNum->building}}">
                                        <i id="buildingmvlaid" style="display:none" class="fa fa-check  color-success"></i>
                                        <i id="buildingmmvlaid__" style="display:none" class="fa fa-times color-danger"></i>
                                        <div class="building_error"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">{{__('strings.cloth_day')}}</h4>
                                <div class="panel-body">
                                    <table id="xtreme-table" class="table table-striped table-bordered"
                                           style="width:100%">
                                        <thead>
                                        <tr>
                                            <th style="display: none;">*</th>
                                            <th> {{ __('strings.date_from') }} </th>
                                            <th> {{ __('strings.date_to') }} </th>
                                            <th> {{ __('strings.reason') }} </th>
                                            <th> {{ __('strings.external_req_setting') }} </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($closeDays as $cday)
                                            <tr>
                                                <td style="display: none;">{{$cday->id}}</td>
                                                <td>{{$cday->date_from}}</td>
                                                <td>{{$cday->date_to}}</td>
                                                <td>{{$cday->reason}}</td>
                                                <td>

                                                    <a href="{{url('admin/rooms/number/cloth/del/'.$cday->id)}}"
                                                       class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                       data-placement="bottom" title=""
                                                       data-original-title="{{ __('strings.remove') }} "
                                                       @if(app()->getLocale() == 'ar')
                                                       onclick="return confirm('تتاكيد حذف تاريخ الاغلاق')"
                                                       @else
                                                       onclick="return confirm('Are you sure?')"
                                                            @endif
                                                    > <i
                                                                class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>


                            <button type="button" class="btn btn-primary" onclick="add_date()"><i
                                        class="fas fa-plus"></i> اضافه مواعيد اغلاق جديده
                            </button>

                            <hr>

                            @if(isset($amentities))
                                <div class="panel panel-white">

                                <div class="col-md-6 form-group{{$errors->has('amentities') ? ' has-error' : ''}}">
                                    <label class="control-label" for="amentities">{{ __('strings.amentities') }}</label>
                                    <select name="amentities[]" class="js-example-basic-multiple" multiple="multiple">
                                        @foreach($amentities as $cate)
                                            <option value="{{$cate->id}}"
                                            @if(old('amentities')!=null)
                                                {{ (collect(old('amentities'))->contains($cate->id)) ? 'selected':'' }}
                                                        {{ (in_array($cate->id,$info->$amentities)) ? 'selected' : ''}}
                                                    @else

                                                {{ (collect($amentitiesData['cat_id'])->contains($cate->id)) ? 'selected':'' }}
                                                        {{ (in_array($cate->id,$amentitiesData)) ? 'selected' : ''}}
                                                    @endif
                                            >{{ app()->getLocale()== 'ar' ? $cate->name :$cate->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                            @else
                                <div>
                                    add categories <a href="#"></a>
                                </div>
                            @endif



                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg"> {{ __('strings.Save') }} </button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>




   <script>
        $('.js-example-basic-multiple').select2();
    </script>

    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
 
    <script>


        $("#addNewRoomForm").validate({
            errorClass: "has-error",
            validClass: "has-success",
            rules: {
                "id": {
                    required: true,
                    digits: true
                },
                "cat_num": {
                    required: true,
                    maxlength: 50
                },
                "floor_num": {
                    required: true,
                    maxlength: 4
                },
                "building": {
                    required: false,
                    maxlength: 40

                },
                "from[]":{
                    required : false,
                    date : true,
                },
                "to[]":{
                    required : false,
                    date : true,
                },
            },

            messages: {
                "cat_num": {
                    required: "{{__('strings.cat_num_valid_r')}}",
                    maxlength: "{{__('strings.cat_num_valid_max')}}"

                },
                "floor_num": {
                    required: "{{__('strings.floor_num_valid_r')}}",
                    maxlength: "{{__('strings.floor_num_valid_max')}}"
                },
                "building":{
                    maxlength:"{{__('strings.building_valid_max')}}"
                },
                "from[]":{

                    date:"يجب ادخال تاريخ"
                },
                "to[]":{

                    date:"يجب ادخال تاريخ"
                },
            }, errorPlacement: function (error, element) {
                if (element.attr('id') == 'cat_num_') {
                    $('#cat_nummvlaid').hide();
                    $('#cat_nummvlaid__').show();
                    $('.cat_num_error').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();
                }  else if (element.attr('id') == 'floor_num_') {
                    $('#floor_nummvlaid').hide();
                    $('#floor_nummvlaid__').show();
                    $('.floor_num_error').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();
                } else if (element.attr('id') == 'building_') {
                    $('#buildingmvlaid').hide();
                    $('#buildingmmvlaid__').show();
                    $('.building_error').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();
                } else if (element.attr('ids') == 'from') {
                    $('.fromvlaid').hide();
                    $('.fromvlaid_').show();
                    $('.building_error').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();
                }
                else if (element.attr('idt') == 'to') {
                    $('.tovlaid').hide();
                    $('.tovlaid_').show();
                    $('.to_error').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();
                }

                else {
                    element.next().remove();
                    error.insertAfter("#" + element.attr('id'));
                }

            },

        });

        function add_date() {
            var counter;
            counter = parseInt(localStorage.getItem('cate_num_date'));
            var data = '<tr>\n' +
                '<td class="reg_flagg">\n' +
                '</td>\n' +
                '<td>\n' +
                '<input type="text" ids="from" placeholder="{{ __('strings.Date_fromm') }}" name="from[]" class="form-control datepicker_reservation' + counter + '">' +
                    ' <i style="display:none" class="fa fa-check  color-success fromvlaid"></i>\n' +
                ' <i style="display:none" class="fa fa-times color-danger fromvlaid_"></i>\n' +
                '<div class="from_error"></div>'+
                '</td>\n' +
                '<td>\n' +
                ' <input type="text" idt="to" placeholder="{{ __('strings.To_date') }}" name="to[]" class="form-control datepicker_reservation2' + counter + '">' +
                ' <i style="display:none" class="fa fa-check  color-success tovlaid"></i>\n' +
                ' <i style="display:none" class="fa fa-times color-danger tovlaid_"></i>\n' +
                '<div class="to_error"></div>'+
                '</td>\n' +
                '<td>\n' +
                ' <input type="text" placeholder="{{ __('strings.reason') }}" class="form-control" name="reason[]" id="reason">' +
                '</td>\n' +
                '<td>\n' +
                '<button type="button" id="deltr" style="color: red;"   class="btn btn-defult btn-close-regust2"><i class="fas fa-times"></i></button>\n' +
                '</td>\n' +
                '</tr>';


            $('#xtreme-table tbody').append(data);

            var reservation_date = new Date();
            $(".datepicker_reservation" + counter).datepicker({

                date: reservation_date,
                startDate: reservation_date,
                rtl: true,
                viewMode: 'years',
                format: 'yyyy-mm-dd',


            }).on('changeDate', function (e) {
                var date2 =
                    $('.datepicker_reservation' + counter).datepicker('getDate', '+1d');
                date2.setDate(date2.getDate() + 1);

                var msecsInADay = 8640000;
                var endDate = new Date(date2.getTime() + msecsInADay);
                $('.datepicker_reservation2' + counter).datepicker('setStartDate', endDate);
                $('.datepicker_reservation2' + counter).datepicker('setDate', endDate);


            });


            $('.datepicker_reservation2' + counter).datepicker({

                format: 'yyyy-mm-dd',
            });

            var addnew = counter + 1;
            parseInt(localStorage.setItem('cate_num_date', addnew));

        }


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

    </script>



@endsection

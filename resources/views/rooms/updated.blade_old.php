@extends('layouts.admin', ['title' => __('strings.rooms') ])
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
                <h1>@lang('strings.updated_rooms')</h1>
                <br>
                <h2><strong>{{app()->getLocale() == 'ar'? $room->name :$room->name_en}}</strong></h2>
                <br>
                <a href="{{url('admin/rooms')}}">
                    <button type="button" class="btn btn-info btn-lg">@lang('strings.rooms')</button>
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
                        <div class="" style=" text-align: center !important;">
                            <p style="font-size: 25px;">{{__('strings.lastPrices')}}</p>
                        <p style="font-size: 20px;">{{cat_price($room->id)['catPrice']!=null?cat_price($room->id)['catPrice']:0}}</p>
                        </div>
                        <form method="post" id="addCategories" action="{{url('admin/rooms/updated')}}"
                              enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$room->id}}">

                            <div class="col-md-6 panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group{{$errors->has('cate_id') ? ' has-error' : ''}}">
                                        <strong
                                                class="text-danger">*</strong>
                                        <label class="control-label">@lang('strings.rome_type')</label>
                                        <select class="js-select2 New_select form-control" ids="cate_id" name="cate_id"
                                                id="cate_id_selected">
                                            @foreach($categoriesType as $cate)
                                                <option id="option-{{$cate->id}}" data-max_kids="{{$cate->max_kids}}"
                                                        data-max_adult="{{$cate->max_adult}}"
                                                        data-max_people="{{$cate->max_people}}"
                                                        value="{{$cate->id}}"
                                                @if(old('cate_id')!=null)
                                                    {{old('cate_id')== $cate->id ?'selected':''}}
                                                        @else
                                                    {{($room->category_type_id == $cate->id)?'selected':''}}
                                                        @endif
                                                >{{ app()->getLocale() == 'ar' ? $cate->name : $cate->name_en }}</option>
                                            @endforeach
                                        </select>
                                        <i id="cate_id_sf" style="display:none" class="fa fa-check  color-success"></i>
                                        <i id="subcate_id" style="display:none" class="fa fa-times color-danger"></i>
                                        <div id="cate_id_error"></div>


                                        <div id="showDataAfterSele">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 panel panel-default">
                                <div class="panel-body">
                                    <div class="col-md-12 form-group{{$errors->has('property_id') ? ' has-error' : ''}}">
                                        <strong
                                                class="text-danger">*</strong>
                                        <label class="control-label">@lang('strings.property_name')</label>
                                        <select class="js-select New_select form-control" id="property_id" name="property_id">

                                            @foreach($hotels as $hotel)
                                                <option id="iam_here_my_op" value="{{ $hotel->id }}"

                                                @if(old('property_id')!=null)
                                                    {{old('property_id')== $hotel->id ?'selected':''}}
                                                        @else
                                                    {{($room->property_id == $hotel->id)?'selected':''}}
                                                        @endif
                                                >{{ app()->getLocale() == 'ar' ? $hotel->name : $hotel->name_en }}</option>
                                            @endforeach
                                        </select>

                                        <i id="subok" style="display:none" class="fa fa-check  color-success"></i>
                                        <i id="subcancel" style="display:none" class="fa fa-times color-danger"></i>
                                        <div id="property_id_error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 panel panel-default">
                                <div class="panel-body">
                                    <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"><strong
                                                class="text-danger">*</strong>
                                        <label class="control-label"
                                               for="name">{{ __('strings.rooms_name_ar') }}</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                               value="{{old('name')!=null?old('name') :$room->name}}">
                                        <i id="nameok" style="display:none" class="fa fa-check  color-success"></i>
                                        <i id="namecancel" style="display:none" class="fa fa-times color-danger"></i>
                                        <div id="name_error"></div>

                                    </div>

                                    <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                                        <strong
                                                class="text-danger">*</strong>
                                        <label class="control-label"
                                               for="name_en">{{ __('strings.rooms_name_en') }}</label>
                                        <input type="text" class="form-control" name="name_en" id="name_en"
                                               value="{{old('name_en')!=null?old('name_en') :$room->name_en}}"
                                               required="required">
                                        <i id="nameok_en" style="display:none" class="fa fa-check  color-success"></i>
                                        <i id="namecancel_en" style="display:none" class="fa fa-times color-danger"></i>
                                        <div id="name_error_en"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group{{$errors->has('cancel_policy') ? ' has-error' : ''}}">
                                        <label class="control-label">@lang('strings.cancel_policy')</label>
                                        <select class="js-select2 New_select form-control" name="cancel_policy"
                                                id="cancel_policy_selected">
                                            <option>@lang('strings.cancel_policy')</option>
                                            <option value="free cancelation"
                                            @if(old('cancel_policy')!=null)
                                                {{old('cancel_policy')=='free cancelation'?'selected':''}}
                                                    @else
                                                {{$room->cancel_policy =='free cancelation'?'selected':''}}
                                                    @endif

                                            >{{__('strings.free_cancelation')}}</option>
                                            <option value="before check in"
                                            @if(old('cancel_policy')!=null)
                                                {{old('cancel_policy')=='before check in'?'selected':''}}
                                                    @else
                                                {{$room->cancel_policy =='before check in'?'selected':''}}
                                                    @endif

                                            >{{__('strings.before_check_in')}}</option>
                                        </select>

                                        @if ($errors->has('cancel_policy'))
                                            <span class="help-block">
                                              <strong class="text-danger">{{ $errors->first('cancel_policy') }}</strong>
                                          </span>
                                        @endif
                                    </div>
                                    @if($room->cancel_policy =='before check in' or old('cancel_policy')=='before check in')
                                        <div class="col-md-6">
                                            <label class="control-label"
                                                   for="rank">{{ __("strings.the_number_of_days") }}</label>
                                            <input type="number"
                                                   value="{{old('cancel_days')!=null?old('cancel_days'):$room->cancel_days}}"
                                                   class="form-control" name="cancel_days" id="rank">
                                            <p>{{__("strings.day_notes")}}</p>
                                            <label class="control-label"
                                                   for="rank">{{ __("strings.cancel_charge_title") }}</label>
                                            <input type="number"
                                                   value="{{old('cancel_charge')?old('cancel_charge'):$room->cancel_charge}}"
                                                   class="form-control" step=0.01 name="cancel_charge">
                                            <p>{{__("strings.cancel_charge_notes")}}</p>
                                        </div>

                                    @else
                                        <div id="day_cancel_policy_appen">

                                        </div>
                                    @endif


                                </div>
                            </div>
                            <hr>
                            <div class="panel panel-white {{$errors->has('photo') ? ' has-error' : ''}}">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">@lang('strings.Photo')</h4>
                                </div>
                                <strong
                                        class="text-danger"></strong>
                                <label>اختار الصوره</label>
                                <input type="file" name="photo" id="photo" data-min-width="500" data-min-height="400">
                                 <span class="help-block">
                                     <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 500*400</strong>
                                 </span>
                                 <hr>
                                <i id="photook" style="display:none" class="fa fa-check  color-success"></i>
                                <i id="photookcancel" style="display:none" class="fa fa-times color-danger"></i>
                                <div id="photook_error"></div>
                            </div>
                            @if ($errors->has('photo'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('image') }}</strong>
                                </span>
                        @endif

                    @if(!empty($room->photo))
                        <div class="col-md-3">
                            <img src="{{$room->photo_id ? asset($room->photo->file): asset('images/profile-placeholder.png')}}"
                                 class="img-responsive">
                                    <a href="{{url('admin/rooms/iamge/del/'.$room->id)}}" 
                     @if(app()->getLocale() == 'ar')
                        onclick="return confirm('تأكيد حذف الصوره')"
                      @else
                       onclick="return confirm('Are you sure?')"
                    @endif
                    ><button type="button" class="btn btn-danger btn-lx">حذف الصوره</button></a>
                    </div>
                        </div>
                        
                    @endif


                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">تواريخ اغلاق الغرف</h4>
                        </div>
                        <div class="panel-body">
                            <table id="xtreme-table" class="table table-striped table-bordered"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>*</th>
                                    <th> {{ __('strings.Date_fromm') }} </th>
                                    <th> {{ __('strings.date_to') }} </th>
                                    <th> {{ __('strings.reason') }} </th>
                                    <th> {{ __('strings.external_req_setting') }} </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($closeDays as $cday)
                                    <tr>
                                        <td>{{$cday->id}}</td>
                                        <td>{{$cday->from_date}}</td>
                                        <td>{{$cday->date_to}}</td>
                                        <td>{{$cday->reason}}</td>
                                        <td>

                                            <a href="{{url('admin/rooms/cloth/day/del/'.$cday->id)}}"
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

                    <button type="button" class="btn btn-primary" onclick="add_date()"><i
                                class="fas fa-plus"></i> اضافه مواعيد اغلاق جديده
                    </button>

                    <hr>

                    @if(isset($amentities))
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
                    @else
                        <div>
                            add categories <a href="#"></a>
                        </div>
                    @endif

                    <div class="col-md-3 form-group{{$errors->has('category_num') ? ' has-error' : ''}}"><strong
                                class="text-danger"></strong>
                        <label class="control-label" for="rank">{{ __('strings.New_Rooms') }}</label>
                        <input type="number" class="form-control" name="category_num" id="category_num"
                               value="{{old('category_num')}}">
                        <i style="display:none" class="fa fa-check  color-success nameokcategory_num"></i>
                        <i style="display:none" class="fa fa-times color-danger namecancelcategory_num"></i>
                        <div class="category_num_error"></div>
                    </div>
                    <div class="col-md-3 form-group{{$errors->has('category_num') ? ' has-error' : ''}}"><strong
                                class="text-danger"></strong>
                        <label class="control-label" for="rank">{{ __('strings.countRoomsOld') }}</label>
                        <input class="form-control" value="{{$countCateNum}}" disabled>
                    </div>

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
                    '<input type="number"  class="form-control" name="cancel_days" id="rank">' +
                    '<p>{{__("strings.day_notes")}}</p>' +
                    '<label class="control-label" for="rank">{{ __("strings.cancel_charge_title") }}</label>' +
                    ' <input type="number" class="form-control" step=0.01 name="cancel_charge">' +
                    '<p>{{__("strings.cancel_charge_notes")}}</p>'
                );
            } else {
                $('#day_cancel_policy_appen').empty();
            }


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

                }, "photo": {
                    required: false,
                    accept: "image/*"
                }

            },

            messages: {
                "property_id": {
                    required: "{{__('strings.valid_property')}}",

                },
                "cate_id": {
                    required: "{{__('strings.valid_cate_id')}}",

                },

                "name": {
                    required: "{{__('strings.valid_name')}}",
                    maxlength: "{{trans('admin.max_length_validate')}}"
                },
                "name_en": {
                    required: "{{__('strings.valid_name')}}",
                    maxlength: "{{trans('admin.max_length_validate')}}"
                }, "photo": {
                    accept: 'يجب ان تكون صوره',
                },

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

                } else if (element.attr('id') == 'photo') {
                    $('#photook').hide();
                    $('#photookcancel').show();
                    $('#photook_error').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();

                } else {
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
                '</td>\n' +
                '<td>\n' +
                ' <input type="text" name="to[]" placeholder="{{ __('strings.To_date') }}" class="form-control datepicker_reservation2' + counter + '">' +
                '</td>\n' +
                '<td>\n' +
                ' <input type="text" placeholder="{{ __('strings.reason') }}"  class="form-control" name="reason[]" id="reason">' +
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

        function intializecategory_type() {
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

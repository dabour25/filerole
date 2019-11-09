@extends('layouts.admin', ['title' => __('strings.room_num') ])
@section('content')
    <style>
        .modal {
            display: none; /* Hidden by default */
            overflow-y: auto;
            overflow-y: initial !important
        }

        td.details-control_ {
            background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control_ {
            background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
        }

        .modal-body {


        }
    </style>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css"
          rel="Stylesheet" type="text/css"/>

    <div class="modal  newModel" id="Modal1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" onclick="close_modal()" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-content">
                <div class="modal-body" style="overflow: hidden">
                    <form method="post" id="addCategories" action="{{url('admin/rooms/add')}}"
                          enctype="multipart/form-data">
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
                            <div id="cate_id_error"></div>

                            <div id="showDataAfterSele">

                            </div>
                        </div>

                        <div class="col-md-6 form-group{{$errors->has('property_id') ? ' has-error' : ''}}">
                            <strong
                                    class="text-danger">*</strong>
                            <label class="text-center">@lang('strings.property_name')</label>
                            <select class="js-select New_select form-control" id="property_id" name="property_id">

                                @foreach($hotels as $hotel)
                                    <option id="iam_here_my_op"
                                            value="{{ $hotel->id }}">{{ app()->getLocale() == 'ar' ? $hotel->name : $hotel->name_en }}</option>
                                @endforeach
                            </select>

                            <i id="subok" style="display:none" class="fa fa-check  color-success"></i>
                            <i id="subcancel" style="display:none" class="fa fa-times color-danger"></i>
                            <div id="property_id_error"></div>
                        </div>

                        <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}">
                            <strong class="text-danger">*</strong>
                            <label class="control-label" for="name">{{ __('strings.rooms_name_ar') }}</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
                            <i id="nameok" style="display:none" class="fa fa-check  color-success"></i>
                            <i id="namecancel" style="display:none" class="fa fa-times color-danger"></i>
                            <div id="name_error" style="color: red;"></div>
                        </div>


                        <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                            <strong
                                    class="text-danger">*</strong>
                            <label class="control-label" for="name_en">{{ __('strings.rooms_name_en') }}</label>
                            <input type="text" class="form-control" name="name_en" id="name_en"
                                   value="{{old('name_en')}}" required="required">
                            <i id="nameok_en" style="display:none" class="fa fa-check  color-success"></i>
                            <i id="namecancel_en" style="display:none" class="fa fa-times color-danger"></i>
                            <div id="name_error_en" style="color: red;"></div>

                        </div>


                        <div class="col-md-6 form-group{{$errors->has('cancel_policy') ? ' has-error' : ''}}">
                            <label class="text-center">@lang('strings.cancel_policy')</label>
                            <select class="js-select2 New_select form-control" name="cancel_policy" id="cancel_policy_selected">
                                <option>@lang('strings.cancel_policy')</option>
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
                               <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 500*400</strong>
                             </span>
                             <hr>
                            <i id="photook" style="display:none" class="fa fa-check  color-success"></i>
                            <i id="photookcancel" style="display:none" class="fa fa-times color-danger"></i>
                            <div id="photook_error" style="color: red;"></div>
                        </div>

                        <div class="panel panel-white">
                            <div class="panel-heading clearfix">
                                <h4 class="panel-title">@lang('strings.prices_room')</h4>
                            </div>
                            <div class="col-md-6" >
                                <strong class="text-danger"></strong>
                                <label class="control-label">{{__('strings.price_a_night')}}</label>
                                <input onfocusout="focapriceslist()" type="number" step=0.001 class="form-control" name="price" id="price" value="{{old('price')}}" required="required">
                                <i id="priceen" style="display:none" class="fa fa-check  color-success"></i>
                                <i id="priceen_" style="display:none" class="fa fa-times color-danger"></i>
                                <div id="price_error_en" style="color: red;"></div>
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('tax') ? ' has-error' : ''}}">
                                <strong
                                        class="text-danger">*</strong>
                                <label class="text-center">@lang('strings.Tax_type')</label>
                                <select class="form-control" id="tax" name="tax">
                                    <option value="">{{__('strings.Select_tax_type')}}</option>
                                    @foreach($taxs as $tax)
                                        <option id="tax-change-{{$tax->id}}" value="{{$tax->id}}" data-tax_value="{{$tax->value}}" data-tax_percent="{{$tax->percent}}">{{ app()->getLocale() == 'ar' ? $tax->name : $tax->name_en }}</option>
                                    @endforeach
                                </select>

                                <i id="taxok" style="display:none" class="fa fa-check  color-success"></i>
                                <i id="taxcancel" style="display:none" class="fa fa-times color-danger"></i>
                                <div id="taxerror" style="color: red;"></div>
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
                                    <button class="btn btn-success add-more"
                                            type="button">{{__('strings.add_more_cloth')}}</button>
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
                            <i style="display:none" class="fa fa-check  color-success nameokcategory_num"></i>
                            <i style="display:none" class="fa fa-times color-danger namecancelcategory_num"></i>
                            <div class="category_num_error" style="color: red;"></div>
                        </div>

                        <div class="col-md-12 form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg"> {{ __('strings.Save') }} </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal  newModel" id="Modal2" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" onclick="close_modal12()" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-content">
                <div class="modal-body" style="overflow: hidden">
                    <form method="post" id="addNewRoomForm" action="{{url('admin/rooms/number/add')}}"
                          enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="id_rooms">
                        <div id="showPhoto">
                        </div>
                        <br>
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div class="col-md-4 form-group{{$errors->has('cat_num') ? ' has-error' : ''}}">
                                    <strong class="text-danger">*</strong>
                                    <label class="control-label" for="cat_num">{{ __('strings.cat_num') }}</label>
                                    <input type="text" class="form-control" name="cat_num" id="cat_num_"
                                           value="{{old('cat_num')}}">
                                    <i id="cat_nummvlaid" style="display:none" class="fa fa-check  color-success"></i>
                                    <i id="cat_nummvlaid__" style="display:none" class="fa fa-times color-danger"></i>
                                    <div class="cat_num_error" style="color: red;"></div>
                                </div>
                                <div class="col-md-4 form-group{{$errors->has('floor_num') ? ' has-error' : ''}}">
                                    <strong class="text-danger">*</strong>
                                    <label class="control-label" for="floor_num">{{ __('strings.floor_num') }}</label>
                                    <select class="js-select2 New_select form-control" name="floor_num" id="floor_num_">
                                        <option value="0">{{ __('strings.floor_0') }}</option>
                                        <option value="1">{{ __('strings.floor_1') }}</option>
                                        <option value="2">{{ __('strings.floor_2') }}</option>
                                        <option value="3">{{ __('strings.floor_3') }}</option>
                                        <option value="4">{{ __('strings.floor_4') }}</option>
                                        <option value="5">{{ __('strings.floor_5') }}</option>
                                        <option value="6">{{ __('strings.floor_6') }}</option>
                                        <option value="7">{{ __('strings.floor_7') }}</option>
                                        <option value="8">{{ __('strings.floor_8') }}</option>
                                        <option value="9">{{ __('strings.floor_9') }}</option>
                                        <option value="10">{{ __('strings.floor_10') }}</option>
                                    </select>
                                    <i id="floor_nummvlaid" style="display:none" class="fa fa-check  color-success"></i>
                                    <i id="floor_nummvlaid__" style="display:none" class="fa fa-times color-danger"></i>
                                    <div class="floor_num_error" style="color: red;"></div>
                                </div>
                                <div class="col-md-4 form-group{{$errors->has('building') ? ' has-error' : ''}}">
                                    <strong class="text-danger"></strong>
                                    <label class="control-label" for="building">{{ __('strings.building') }}</label>
                                    <input type="text" class="form-control" name="building" id="building_"
                                           value="{{old('building')}}">
                                    <i id="buildingmvlaid" style="display:none" class="fa fa-check  color-success"></i>
                                    <i id="buildingmmvlaid__" style="display:none" class="fa fa-times color-danger"></i>
                                    <div class="building_error" style="color: red;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-white">
                            <div class="panel-heading clearfix">
                                <h4 class="panel-title">@lang('strings.day_closure')</h4>
                            </div>

                            <div class="copy_num">

                            </div>
                            <div class="col-md-12 input-group control-group after-add-more-num  {{$errors->has('cancel_policy') ? ' has-error' : ''}}">
                                <div class="input-group-btn col-md-3">
                                    <button class="btn btn-success add-more-num "
                                            type="button">{{__('strings.add_more_cloth')}}</button>
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
                            {{ DB::table('function_new')->where('id',258)->value('description') }}
                        @else
                            {{ DB::table('function_new')->where('id',258)->value('description_en') }}
                        @endif
                    </p>
                    <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                    </a>
                </div>
                </br>
                @if($category == 0)
                    <h2><strong>{{__('strings.NotFoundRooms')}}</strong></h2>
                    @endif
                    </br>
                    <form method="get" action="{{url('admin/rooms/number/search')}}" enctype="multipart/form-data">
                        <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                            <label>@lang('strings.room_type')</label>
                            <select class="form-control js-select" name="room">
                                <option {{$id==0?'selected':''}} value="0">{{__('strings.all')}}</option>
                                @foreach($category as $cat)
                                    <option {{$id==$cat->id?'selected':''}} value="{{$cat->id}}">{{ app()->getLocale() == 'ar' ? $cat->name  : $cat->name_en  }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button id="search_button" type="submit" onclick=""
                                class="btn btn-primary btn-lg">@lang('strings.Search')</button>
                    </form>
                    </br>
                @if(permissions('add_new_room') == 1)
                    <a href="#">
                        <button type="button" onclick="add_room()"
                                class="btn btn-primary btn-lg">@lang('strings.create_room')</button>
                    </a>
                    @endif

                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">@lang('strings.room_type')</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th style="display: none;">#</th>
                                        <th>{{ __('strings.room_name') }}</th>
                                        <th>{{ __('strings.property_name') }}</th>
                                        <th>{{__('strings.rome_type')}}
                                        <th>@lang('strings.Settings')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($category as $cat)
                                        <tr>
                                            <td class=" details-control_"></td>
                                            <td style="display: none;">{{ $cat->id }}</td>
                                            <td>{{app()->getLocale() == 'ar'? $cat->name :$cat->name_en}}</td>
                                            <td>{{ app()->getLocale() == 'ar'? $cat->pro_name:$cat->pro_name_en }}</td>
                                            <td>{{ app()->getLocale() == 'ar'?$cat->type_name_ar:$cat->type_name_en }}</td>
                                            <td>
                                                @if(permissions('room_num_add') == 1)
                                                <button onclick="add_new_rom({{$cat->id}})" type="button"
                                                        id="add_new_room{{$cat->id}}"
                                                        data-name_type="{{app()->getLocale() == 'ar'?$cat->type_name_ar:$cat->type_name_en}}"
                                                        data-name_room="{{app()->getLocale() == 'ar'? $cat->name :$cat->name_en}}"
                                                        data-name-hotel="{{ app()->getLocale() == 'ar' ? $cat->pro_name : $cat->pro_name_en}}"
                                                        class="btn btn-info btn-lg NewBtn btnclient Hotle_name"><i
                                                            class="fas fa-plus"></i></button>
                                                  @endif           
                                                            
                                                <a href="{{url('admin/rooms/updated/'. $cat->id) }}"
                                                   class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                   data-placement="bottom" title=""
                                                   data-original-title="{{ __('strings.edit') }} "> <i
                                                            class="fa fa-pencil"></i></a>
                                                <a href="{{url('admin/rooms/deleted/'.$cat->id)}}"
                                                   class="btn btn-danger btn-xs" data-toggle="tooltip"
                                                   data-placement="bottom" title=""
                                                   data-original-title="{{ __('strings.delete_btn') }}"> <i
                                                            class="fa fa-trash-o"></i></a>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
  
  
     <script src="{{asset('js/jquery.checkImageSize.min.js')}}"></script>
    <script> 
        $("input[type='file']").checkImageSize({
              minWidth: $(this).data('min-width'),
              minHeight: $(this).data('min-height'),
            showError:true,
            ignoreError:false
        });
        
    </script>
@endsection
@section('scripts')



     <script type="text/javascript"
             src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
     <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
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
                    required: true,
                    accept: "image/*"
                },
                "from[]": {
                    required: false,
                    date: true,
                },
                "to[]": {
                    required: false,
                    date: true,

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
                }, "photo": {
                    required: 'يجب ادخال صوره',
                    accept: 'يجب ان تكون صوره',
                },
                "from[]": {

                    date: "يجب ادخال تاريخ"
                },
                "to[]": {

                    date: "يجب ادخال تاريخ"
                },
                "price":{
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

                } else if (element.attr('id') == 'photo') {
                    $('#photook').hide();
                    $('#photookcancel').show();
                    $('#photook_error').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();
                } else if (element.attr('ids') == 'from') {
                    $('.fromvlaid').hide();
                    $('.fromvlaid_').show();
                    $('.building_error').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();
                } else if (element.attr('idt') == 'to') {
                    $('.tovlaid').hide();
                    $('.tovlaid_').show();
                    $('.to_error').html('<div class="error-message">' + error.html() + '</div>');
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

                } else {
                    element.next().remove();
                    error.insertAfter("#" + element.attr('id'));
                }

            },

        });

        $("#addNewRoomForm").validate({
            errorClass: "has-error",
            validClass: "has-success",
            rules: {
                "id_rooms": {
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
                "from[]": {
                    required: false,
                    date: true,
                },
                "to[]": {
                    required: false,
                    date: true,
                }
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
                "building": {
                    maxlength: "{{__('strings.building_valid_max')}}"
                },
                "from[]": {

                    date: "يجب ادخال تاريخ"
                },
                "to[]": {

                    date: "يجب ادخال تاريخ"
                },
            }, errorPlacement: function (error, element) {
                if (element.attr('id') == 'cat_num_') {
                    $('#cat_nummvlaid').hide();
                    $('#cat_nummvlaid__').show();
                    $('.cat_num_error').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();
                } else if (element.attr('id') == 'floor_num_') {
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
                } else if (element.attr('idt') == 'to') {
                    $('.tovlaid').hide();
                    $('.tovlaid_').show();
                    $('.to_error').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();
                } else {
                    element.next().remove();
                    error.insertAfter("#" + element.attr('id'));
                }

            },

        });
    </script>



     <script>
         $('.js-example-basic-multiple').select2();

     </script>
      <script>
                $('.js-select').select2();
      </script>


     <script>

         $(document).ready(function () {


             $(".add-more").click(function () {

                 var counter;
                 counter = parseInt(localStorage.getItem('addDate_num'));
                 var html = $(".copy").append(
                     ' <div class="control-group input-group col-md-12">' +
                     '<div class="col-md-4">' +
                     '  <label class="text-center">@lang("strings.Date_fromm")</label>' +
                     '  <input type="text" ids="from" name="from[]" autocomplete="off" class="form-control datepicker_reservation' + counter + '">' +
                     '</div>' +
                     '<div class="col-md-4">' +
                     ' <label class="text-center">@lang("strings.To_date")</label>' +
                     ' <input type="text" name="to[]" autocomplete="off" class="form-control datepicker_reservation2' + counter + '">' +
                     '</div>' +
                     '<div class="col-md-3">' +
                     '  <label class="control-label" for="reason">{{ __("strings.reason") }}</label>' +
                     ' <input type="text" class="form-control" name="reason[]" id="reason">' +
                     '<div class="input-group-btn pull-left">' +
                     ' <button class="btn btn-danger remove" type="button">' +
                     '<i class="glyphicon glyphicon-remove"></i></button>' +
                     '</div>' +
                     ' </div>'
                 );
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
                 $(".after-add-more").after(html);

                 var addnew = counter + 1;
                 parseInt(localStorage.setItem('addDate_num', addnew));

             });
             $(".add-more-num").click(function () {
                 var counter;
                 counter = parseInt(localStorage.getItem('cate_num_date'));
                 var html = $(".copy_num").append(
                     ' <div class="control-group input-group col-md-12">' +
                     '<div class="col-md-4">' +
                     '  <label class="text-center">@lang("strings.Date_fromm")</label>' +
                     '  <input type="text" ids="from" name="from[]" class="form-control datepicker_reservation' + counter + '">' +
                     '</div>' +
                     '<div class="col-md-4">' +
                     ' <label class="text-center">@lang("strings.To_date")</label>' +
                     ' <input type="text" name="to[]" class="form-control datepicker_reservation2' + counter + '">' +
                     '</div>' +
                     '<div class="col-md-3">' +
                     '  <label class="control-label" for="reason">{{ __("strings.reason") }}</label>' +
                     ' <input type="text" class="form-control" name="reason[]" id="reason">' +
                     '<div class="input-group-btn pull-left">' +
                     ' <button class="btn btn-danger remove" type="button">' +
                     '<i class="glyphicon glyphicon-remove"></i></button>' +
                     '</div>' +
                     ' </div>'
                 );

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

                 $(".after-add-more_num").after(html);

                 var addnew = counter + 1;
                 parseInt(localStorage.setItem('cate_num_date', addnew));
             });

             $("body").on("click", ".remove", function () {
                 $(this).parents(".control-group").remove();
             });

             localStorage.setItem("cate_num_date", 1);
             $(".add-more-num").click();

         });
     </script>






     <script>



         function add_room() {

             var modal2 = document.getElementById('Modal1');
             modal2.style.display = "block";
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






         function add_date() {
             var data = '<tr>\n' +
                 '<td class="reg_flagg col-sm-2">\n' +
                 '<input type="date" ids="from" name="from[]" class="form-control">' +
                 '</td>\n' +
                 '<td class="col-sm-2">\n' +
                 ' <input type="date" name="to[]" class="form-control">' +
                 '</td>\n' +
                 '<td>\n' +
                 ' <input type="text" class="form-control" name="reason[]" id="reason">' +
                 '</td>\n' +
                 '<td class="col-sm-2">\n' +
                 '<button type="button" id="deltr" style="color: red;"   class="btn btn-defult btn-close-regust2"><i class="fas fa-times"></i></button>\n' +
                 '</td>\n' +
                 '</tr>';


             $('#xtreme-table tbody').append(data);
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

         function add_new_rom(id) {

             var modal2 = document.getElementById('Modal2');
             modal2.style.display = "block";

             var type = $('#add_new_room' + id).data('name_type');
             var room = $('#add_new_room' + id).data('name_room');
             var hotel = $('#add_new_room' + id).data('name-hotel');


             $('input[name="id_rooms"]').val(id);

             $('#showPhoto').append(
                 '<div class="panel panel-white">\n' +
                 ' <div class="panel-body">\n' +
                 '<div class="table-responsive">\n' +
                 '  <table class="display table" style="width: 100%; cellspacing: 0;">\n' +
                 ' <thead>\n' +
                 '<th>{{ __('strings.property_name') }}</th>\n' +
                 '<th>{{__('strings.rome_type')}}\n' +
                 '<th>{{ __('strings.room_name') }}</th>\n' +
                 '</tr>\n' +
                 '</thead>\n' +
                 '<tbody>' +
                 ' <tr>' +
                 '<td >' + hotel + '</td>' +
                 '<td >' + type + '</td>' +
                 '<td >' + room + '</td>' +
                 '</tr>' +
                 '</tbody>' +
                 '</table>' +
                 ' </div>\n' +
                 '</div>'
             );
         };

         function close_modal12() {
             var modal2 = document.getElementById('Modal2');
             modal2.style.display = "none";

             $('#showPhoto').empty();

         };
     </script>

 @endsection

@extends('layouts.admin', ['title' => __('strings.property') ])
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

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/css/intlTelInput.css" rel="stylesheet" />



    <div id="main-wrapper">
        <div class="row">
            <!-- Modal content-->
            <div class="modal-body" style="overflow: hidden">
                <form method="post" action="{{url('admin/property/updated')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-md-12 form-group{{$errors->has('prop_type') ? ' has-error' : ''}}">
                        <div class="form-group">
                            <label class="control-label" for="prop_type">{{ __('strings.prop_type') }}</label>
                            <div class="form-field">
                                <i class="icon icon-arrow-down3"></i>
                                <select name="prop_type" class="form-control js-select2">
                                    <option value="hotel"
                                    @if(old('prop_type')!=null)
                                        {{old('prop_type') =='hotel'?'selected':''}}
                                            @else
                                        {{$property->prop_type == 'hotel'?'selected':''}}
                                            @endif
                                    >{{ __('strings.hotel') }}
                                    </option>
                                    <option value="apartment"
                                    @if(old('prop_type')!=null)
                                        {{old('prop_type') =='apartment'?'selected':''}}
                                            @else
                                        {{$property->prop_type == 'apartment'?'selected':''}}
                                            @endif
                                    >{{ __('strings.apartment') }}
                                    </option>
                                    <option value="resort"
                                    @if(old('prop_type')!=null)
                                        {{old('prop_type') =='resort'?'selected':''}}
                                            @else
                                        {{$property->prop_type == 'resort'?'selected':''}}
                                            @endif
                                    >{{ __('strings.resort') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                        <input type="text" class="form-control" name="name" value="{{old('name')!==null?old('name'):$property->name}}" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                         </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"><strong
                                class="text-danger"></strong>
                        <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                        <input type="text" class="form-control" name="name_en" value="{{old('name_en')!==null?old('name_en'):$property->name_en}}">
                        @if ($errors->has('name_en'))
                            <span class="help-block">
                                       <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                   </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('alias') ? ' has-error' : ''}}"><strong
                                class="text-danger"></strong>
                        <label class="control-label" for="name_en">{{ __('strings.alias') }}</label>
                        <input type="text" class="form-control" name="alias" value="{{old('alias')!==null?old('alias'):$property->alias}}">
                        @if ($errors->has('alias'))
                            <span class="help-block">
                                       <strong class="text-danger">{{ $errors->first('alias') }}</strong>
                                   </span>
                        @endif
                    </div>


                    <div class="col-md-6 form-group{{$errors->has('description') ? ' has-error' : ''}}"><strong
                                class="text-danger"></strong>
                        <label class="control-label" for="description_ar">{{ __('strings.description_ar') }}</label>
                        <input type="text" class="form-control" name="description" value="{{old('description')!==null?old('description'):$property->description}}">
                        @if ($errors->has('description'))
                            <span class="help-block">
                                       <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                   </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('description_en') ? ' has-error' : ''}}"><strong
                                class="text-danger"></strong>
                        <label class="control-label" for="address">{{ __('strings.description_en') }}</label>
                        <input type="text" class="form-control" name="description_en" value="{{old('description_en')!==null?old('description_en'):$property->description_en}}">
                        @if ($errors->has('description_en'))
                            <span class="help-block">
                                       <strong class="text-danger">{{ $errors->first('description_en') }}</strong>
                                   </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('image') ? ' has-error' : ''}}">
                        <strong class="text-danger"></strong>
                        <label for="image"  class="control-label">@lang('strings.Photo')</label>
                        <input type="file" id="image"name="image" >
                        @if ($errors->has('image'))
                            <span class="help-block">
                   <strong class="text-danger">{{ $errors->first('image') }}</strong>
                    </span>
                        @endif
                    </div>
                    @if(!empty($myiamge))
                        <div class="col-md-3">
                            <img src="{{$myiamge->file ? asset($myiamge->file): asset('images/profile-placeholder.png')}}" class="img-responsive">
                        </div>
                    @endif

                    <div class="col-md-6 form-group{{$errors->has('slider_desc') ? ' has-error' : ''}}"><strong
                                class="text-danger"></strong>
                        <label class="control-label" for="description_ar">{{ __('strings.slider_desc') }}</label>
                        <input type="text" class="form-control" name="slider_desc" value="{{old('slider_desc')!==null?old('slider_desc'):$property->slider_desc}}">
                        @if ($errors->has('slider_desc'))
                            <span class="help-block">
                                       <strong class="text-danger">{{ $errors->first('slider_desc') }}</strong>
                                   </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('slider_desc_en') ? ' has-error' : ''}}"><strong
                                class="text-danger"></strong>
                        <label class="control-label" for="address">{{ __('strings.slider_desc_en') }}</label>
                        <input type="text" class="form-control" name="slider_desc_en" value="{{old('slider_desc_en')!==null?old('slider_desc_en'):$property->slider_desc_en}}">
                        @if ($errors->has('slider_desc_en'))
                            <span class="help-block">
                                       <strong class="text-danger">{{ $errors->first('slider_desc_en') }}</strong>
                                  </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{$errors->has('location_id') ? ' has-error' : ''}}">
                        <div class="form-group">
                            <label class="control-label" for="location_id">{{ __('strings.Location') }}</label>
                            <div class="form-field">
                                <i class="icon icon-arrow-down3"></i>
                                @if(isset($locations))
                                    <select name="location_id" id="location_id" class="form-control js-select2">
                                        @foreach($locations as $location)
                                            <option value="{{$location->id}}"
                                           @if(old('location_id')!=null)
                                            {{old('location_id') ==$location->id?'selected':''}}
                                            @else
                                                {{$property->location_id == $location->id?'selected':''}}
                                            @endif
                                            >{{ app()->getLocale()== 'ar' ? $location->name :$location->name_en}}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('longitude') ? ' has-error' : ''}}">
                        <label class="control-label" for="longitude">{{ __('strings.line_ve') }}</label>
                        <input type="text" class="form-control" name="longitude" id="" value="{{old('longitude')!==null?old('longitude'):$property->longitude}}">
                        @if ($errors->has('longitude'))
                            <span class="help-block">
                                       <strong class="text-danger">{{ $errors->first('longitude') }}</strong>
                                   </span>
                        @endif
                    </div>
                    <div class="col-md-6 form-group{{$errors->has('latitude') ? ' has-error' : ''}}">
                        <label class="control-label" for="latitude">{{ __('strings.line_he') }}</label>
                        <input type="text" class="form-control" name="latitude" id="latitude"
                               value="{{old('latitude')!==null?old('latitude'):$property->latitude}}">
                        @if ($errors->has('latitude'))
                            <span class="help-block">
                                       <strong class="text-danger">{{ $errors->first('latitude') }}</strong>
                                   </span>
                        @endif
                    </div>

                    <div class="col-md-12 form-group{{$errors->has('currency_id') ? ' has-error' : ''}}">
                        <div class="form-group">
                            <label class="control-label" for="currency_id">{{ __('strings.currency') }}</label>
                            <div class="form-field">
                                <i class="icon icon-arrow-down3"></i>
                                @if(isset($currencies))
                                    <select name="currency_id" id="currency_id" class="form-control js-select2">
                                        @foreach($currencies as $currency)
                                            <option value="{{$currency->id}}"
                                            @if(old('currency_id')!=null)
                                                {{old('currency_id') ==$currency->id?'selected':''}}
                                                    @else
                                                {{$property->currency_id == $currency->id?'selected':''}}
                                                    @endif
                                                   >
                                                {{ app()->getLocale()== 'ar' ? $currency->name :$currency->name_en}}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('address') ? ' has-error' : ''}}"><strong
                                class="text-danger"></strong>
                        <label class="control-label" for="address">{{ __('strings.Address') }}</label>
                        <input type="text" class="form-control" name="address" value="{{old('address')!==null?old('address'):$property->address}}">
                        @if ($errors->has('address'))
                            <span class="help-block">
                             <strong class="text-danger">{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6 form-group{{$errors->has('phone') ? ' has-error' : ''}}"><strong
                                class="text-danger"></strong>
                        <label class="control-label" for="address">{{ __('strings.telephone') }}</label>
                        <input type="tel" id="phone" class="form-control" name="phone" value="{{old('phone')!==null?old('phone'):$property->telephone}}">
                        @if ($errors->has('phone'))
                            <span class="help-block">
                             <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('email') ? ' has-error' : ''}}"><strong
                                class="text-danger"></strong>
                        <label class="control-label" for="email">{{ __('strings.email') }}</label>
                        <input type="text" class="form-control" name="email" value="{{old('email')!==null?old('email'):$property->email}}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                             <strong class="text-danger">{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>


                    <div class="col-md-6 form-group{{$errors->has('property_site') ? ' has-error' : ''}}"><strong
                                class="text-danger"></strong>
                        <label class="control-label" for="email">{{ __('strings.property_site') }}</label>
                        <input type="text" class="form-control" name="property_site" value="{{old('property_site')!==null?old('property_site'):$property->property_site}}">
                        @if ($errors->has('property_site'))
                            <span class="help-block">
                             <strong class="text-danger">{{ $errors->first('property_site') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6 form-group{{$errors->has('infrontpage') ? ' has-error' : ''}}">
                        <label class="control-label" for="infrontpage">{{ __('strings.front_page') }}</label>
                        <select class="form-control" name="infrontpage">
                            <option value="1"
                            @if(old('infrontpage')!=null)
                                {{old('infrontpage') ==1?'selected':''}}
                                    @else
                                {{$property->infrontpage == 1?'selected':''}}
                                    @endif

                            >{{ __('strings.Yes') }}</option>
                            <option value="0"
                            @if(old('infrontpage')!=null)
                                {{old('infrontpage') ==0?'selected':''}}
                                    @else
                                {{$property->infrontpage == 0?'selected':''}}
                                    @endif
                            >{{ __('strings.No') }}</option>
                        </select>
                        @if ($errors->has('infrontpage'))
                            <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('infrontpage') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('service_fees') ? ' has-error' : ''}}"><strong
                                class="text-danger"></strong>
                        <label class="control-label" for="service_fees">{{ __('strings.service_fees') }}</label>
                        <input type="text" class="form-control" name="service_fees" id="service_fees"
                               value="{{old('service_fees')!==null?old('service_fees'):$property->service_fees}}">
                        @if ($errors->has('service_fees'))
                            <span class="help-block">
                             <strong class="text-danger">{{ $errors->first('service_fees') }}</strong>
                           </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}">
                        <label class="control-label" for="active">{{ __('strings.Status') }}</label>
                        <select class="form-control" name="active" required>
                            <option value="1"
                            @if(old('active')!=null)
                                {{old('active') ==1?'selected':''}}
                                    @else
                                {{$property->active == 1?'selected':''}}
                                    @endif
                            >{{ __('strings.Active') }}</option>
                            <option value="0"
                            @if(old('active')!=null)
                                {{old('active') ==0?'selected':''}}
                                    @else
                                {{$property->active == 0?'selected':''}}
                                    @endif
                            >{{ __('strings.Deactivate') }}</option>
                        </select>
                        @if ($errors->has('Status'))
                            <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('Status') }}</strong>
                                </span>
                        @endif
                    </div>
                    <div class="col-md-6 form-group{{$errors->has('stars') ? ' has-error' : ''}}">
                        <div class="form-group">
                            <label class="control-label" for="stars">{{ __('strings.stars') }}</label>
                            <div class="form-field">
                                <i class="icon icon-arrow-down3"></i>
                                <select name="stars" class="form-control js-select2">
                                    <option value="1"
                                            @if(old('stars')!==null)
                                                {{old('stars')== 1 ?'selected':''}}
                                                @else
                                                {{$property->stars == 1 ?'selected':''}}
                                            @endif
                                    >1</option>
                                    <option value="2"
                                    @if(old('stars')!==null)
                                        {{old('stars')== 2 ?'selected':''}}
                                            @else
                                        {{$property->stars == 2 ?'selected':''}}
                                            @endif
                                    >2</option>
                                    <option value="3"
                                    @if(old('stars')!==null)
                                        {{old('stars')== 3 ?'selected':''}}
                                            @else
                                        {{$property->stars == 3 ?'selected':''}}
                                            @endif
                                    >3</option>
                                    <option value="4"
                                    @if(old('stars')!==null)
                                        {{old('stars')== 4 ?'selected':''}}
                                            @else
                                        {{$property->stars == 4 ?'selected':''}}
                                            @endif
                                    >4</option>
                                    <option value="5"
                                    @if(old('stars')!==null)
                                        {{old('stars')== 5 ?'selected':''}}
                                            @else
                                        {{$property->stars == 5 ?'selected':''}}
                                            @endif
                                    >6</option>
                                    <option value="6"
                                    @if(old('stars')!==null)
                                        {{old('stars')== 6 ?'selected':''}}
                                            @else
                                        {{$property->stars == 6 ?'selected':''}}
                                            @endif
                                    >6</option>
                                    <option value="7"
                                    @if(old('stars')!==null)
                                        {{old('stars')== 7 ?'selected':''}}
                                            @else
                                        {{$property->stars == 7 ?'selected':''}}
                                            @endif
                                    >7</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    @if(isset($categories))
                        <div class="col-md-6 form-group{{$errors->has('amentities') ? ' has-error' : ''}}">
                            <label class="control-label" for="amentities">{{ __('strings.amentities') }}</label>
                            <select name="amentities[]" class="selectpicker" multiple data-actions-box="true">
                                @foreach($categories as $cate)
                                    <option value="{{$cate->id}}"
                                            @if(old('amentities')!==null)
                                                {{ (collect(old('amentities'))->contains($cate->id)) ? 'selected':'' }}
                                              {{ (in_array($cate->id,$info->$amentities)) ? 'selected' : ''}}
                                            @else
                                                {{ (collect($amentitiesData['cat_id'])->contains($cate->id)) ? 'selected':'' }}
                                                  {{ (in_array($cate->id,$amentitiesData)) ? 'selected' : ''}}
                                             @endif
                                            >{{app()->getLocale()== 'ar' ? $cate->name :$cate->name_en}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div>
                            add categories <a href="#"></a>
                        </div>
                    @endif
                    <input type="hidden" name="id" value="{{$property->id}}" >
                    <div class="col-md-12 form-group text-right">
                        <button type="submit" class="btn btn-primary btn-lg">{{ __('strings.Save') }}</button>
                    </div>
                </form>
            </div>


        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>

    <script>
        $('select').selectpicker();
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.js"></script>
    <script>
        var input = document.querySelector("#phone"),
            errorMsg = document.querySelector("#error-msg"),
            validMsg = document.querySelector("#valid-msg");

        var errorMap = ["☓ رقم غير صالح", "☓ رمز البلد غير صالح", "☓ قصير جدا", "☓ طويل جدا", "☓ رقم غير صالح"];

        var iti = window.intlTelInput(input, {
            initialCountry: "auto",
            geoIpLookup: function (callback) {
                $.get('https://ipinfo.io', function () {
                }, "jsonp").always(function (resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/utils.js"
        });

        var reset = function () {
            input.classList.remove("error");
            errorMsg.innerHTML = "";
            errorMsg.classList.add("hide");
            validMsg.classList.add("hide");
        };

        input.addEventListener('blur', function () {
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
    </script>

@endsection







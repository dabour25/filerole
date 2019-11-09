@extends('layouts.admin', ['title' => __('strings.Customers_add') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/css/intlTelInput.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
                


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
            <form method="post" action="{{route('customers.store')}}" enctype="multipart/form-data" role="form" id="add-role">
                {{csrf_field()}}
                <div class="col-md-3">
                    <div class="col-md-12">
                        <img src="{{ asset('images/profile-placeholder.png') }}" class="img-responsive" id="accountimg">
                    </div>
                    <div class="col-md-12 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                        <label for="photo_id" class="control-label">@lang('strings.Upload_photo')</label>
                        <input type="file" id="photo_id" name="photo_id" onchange="readURL(this);"  data-min-width="300" data-min-height="300">
                        <span class="help-block">
                                    <strong class="text-danger" style="font-size:12px;">برجاء اختيار صوره لا تقل ابعادها عن 300*300</strong>
                                </span>
                                <hr>
                        @if ($errors->has('photo_id'))
                            <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <div class="col-md-12">
                                <h4 class="panel-title">{{ __('strings.Customers_add') }}</h4>
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
                            <input type="hidden" class="form-control" name="user_id" value="{{  Auth::user()->id }}">
                            <input type="hidden" class="form-control" name="active" value="1">

                            <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                                <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                                <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}">
                                @if ($errors->has('name_en'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
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
                            <div class="col-md-6 form-group{{$errors->has('signs') ? ' has-error' : ''}}">
                                <label class="control-label">@lang('strings.sings')</label>
                                <label class="switch">
                                    <input name="Notifications_email" type="checkbox"
                                           id="checkbox4" >
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('gender') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="gender">{{ __('strings.Gender') }}</label>
                                <select class="form-control" name="gender">
                                    <option value="1">{{ __('strings.Male') }}</option>
                                    <option value="0" >{{ __('strings.Female') }}</option>
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('address') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="address">{{ __('strings.Address') }}</label>
                                <input type="text" class="form-control" name="address" value="{{old('address')}}">
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('signs') ? ' has-error' : ''}}">
                                    <label>{{__('strings.country')}}</label>
                                    <select required name="country_id" class="select-search">
                                        @foreach($countries as $country)
                                            @php
                                                $country_session = Session::has('country')  ? session('country') : 'EG';
                                            @endphp
                                            <option {{ $country_session == $country->code || old('country_id') == $country->id ? 'selected' : ''}} value="{{$country->id}}">{{ app()->getLocale() == 'ar' ? $country->name  : $country->name_en  }}</option>
                                        @endforeach
                                    </select>
                              </div>
                             <div class="col-md-6 form-group{{$errors->has('signs') ? ' has-error' : ''}}">
                              <label>{{__('strings.city')}}</label>
                              <input type="text" class="form-control"  placeholder="" required name="city" value="{{ Session::has('city')  ? session('city') : 'EG' }}">
                             </div>

                            <div class="col-md-6 form-group{{$errors->has('phone_number') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="phone_number">{{ __('strings.phone_number') }}</label>
                                <input type="tel" class="form-control" name="phone_number" id="phone" value="{{old('phone_number')}}">
                                <span id="valid-msg" class="hide">✓ صالح</span>
                                <span id="error-msg" class="hide"></span>

                            @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>

                              <div class="col-md-6 form-group{{$errors->has('signs') ? ' has-error' : ''}}">
                                <label class="control-label">@lang('strings.sings')</label>
                                    <label class="switch">
                                <input name="Notifications_phone" type="checkbox"   id="checkbox3" >
                                        <span class="slider round"></span>
                                    </label>


                            </div>

                            <div class="col-md-6 form-group{{$errors->has('birth_date') ? ' has-error' : ''}}">
                                <label class="control-label" for="birth_date"> {{ __('strings.Birthday') }}</label>
                                <input type="date" class="form-control" name="birth_date" value="{{old('birth_date')}}" >
                                @if ($errors->has('birth_date'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('birth_date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('marriage_date') ? ' has-error' : ''}}">
                                <label class="control-label" for="marriage_date">{{ __('strings.marriage_date') }} </label>
                                <input type="date" class="form-control" name="marriage_date" value="{{old('marriage_date')}}">
                                @if ($errors->has('marriage_date'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('marriage_date') }}</strong>
                                </span>
                                @endif
                            </div>
                             @php
                            $org_login=\App\org::where('id',Auth::user()->org_id)->first();
                            $show_customer_data=\App\ActivityLabelSetup::where(['activity_id'=>$org_login->activity_id,'type'=>'person_id'])->first();
                            @endphp
                            @if($show_customer_data)
                             <div class="col-md-6 form-group{{$errors->has('person_idtype') ? ' has-error' : ''}}">
                                    <label class="control-label" for="address">{{ __('strings.person_type') }}</label>
                                    <input type="text" class="form-control" name="person_idtype" value="{{old('person_idtype')}}">
                                    @if ($errors->has('person_idtype'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('person_idtype') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                 <div class="col-md-6 form-group{{$errors->has('person_id') ? ' has-error' : ''}}">
                                    <label class="control-label" for="person_id">{{ __('strings.person_id') }}</label>
                                    <input type="text" class="form-control" name="person_id" value="{{old('person_id')}}">
                                    @if ($errors->has('person_id'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('person_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                  <div class="col-md-6 form-group{{$errors->has('person_image') ? ' has-error' : ''}}">
                                    <label class="control-label" for="person_id">{{ __('strings.person_image') }}</label>
                                    <input type="file" class="form-control" name="person_image" value="" onchange="readURL_2(this);"   data-min-width="300" data-min-height="200">
                                           <span class="help-block">
                                    <strong class="text-danger" style="font-size:12px;">برجاء اختيار صوره لا تقل ابعادها عن 200*300</strong>
                                </span>
                                    @if ($errors->has('person_image'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('person_image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                               @endif
                                <div class="col-md-6 form-group{{$errors->has('person_image') ? ' has-error' : ''}}">
                                     <img src="{{asset('images/profile-placeholder.png') }}" style="width: 300px;height: 200px;" id="set2">
                                </div>
                               
                               <br>
                            
                            
                            <div class="col-md-12 form-group{{$errors->has('hear_about_us') ? ' has-error' : ''}}">
                                <label class="control-label" for="hear_about_us">من اين سمعت عنا</label>
                                <select name="hear_about_us"  class="select-search">
                									<option value"facebook">facebook</option>
                									<option value="friend" >friend</option>
                									<option value="instgram">instgram</option>
                                  <option value="surf net">surf net</option>
                                  <option value="other">other</option>
                								</select>
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('hear_about_us') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">  <i class="fas fa-save"></i> {{ __('strings.Save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    
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
    
     function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#accountimg')
                    .attr('src', e.target.result)
            };

            reader.readAsDataURL(input.files[0]);
            }
        };
        
        
     function readURL_2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#set2')
                    .attr('src', e.target.result)
            };

            reader.readAsDataURL(input.files[0]);
            }
        };
    
    
    
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
    </script>
@endsection
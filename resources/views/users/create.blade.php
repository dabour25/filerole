@extends('layouts.admin', ['title' => __('strings.add') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/css/intlTelInput.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="modal fade newModel" id="cat_pro" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    test
                </div>
            </div>

        </div>
    </div>
    
    <div class="modal fade newModel" id="show_time" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    test
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade newModel" id="add_section" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="overflow: hidden">
                    <form method="post" action="#" enctype="multipart/form-data" id="add_section_store">
                        {{csrf_field()}}
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

                        <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                            <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                            <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}">
                            @if ($errors->has('name_en'))
                                <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="col-md-12 form-group{{$errors->has('description') ? ' has-error' : ''}}">
                            <label class="control-label" for="description">{{ __('strings.Description') }}</label>
                            <textarea type="text" class="form-control" name="description">{{old('description')}}</textarea>
                            @if ($errors->has('description'))
                                <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="col-md-12 form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg" id="add_section_submit">{{ __('strings.Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <form method="post" action="{{ Request::is('admin/employees') || Request::is('admin/employees/*') ? route('employees.store') : route('users.store') }}" enctype="multipart/form-data" id="">
        {{csrf_field()}}
        <div class="modal fade newModel" id="add_time" role="dialog">
            <div class="modal-dialog" style="width: 90%;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="show_reguest">
                            <table id="tabelnew" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th> اليوم </th>
                                        <th> الوقت </th>
                                        <th> إلغاء </th>

                                    </tr>
                                </thead>
                                <tbody id="clonetr">
                                    <tr id="firsttr">
                                    <td>
                                        <select class="form-control" name="days[]">
                                            @if($vacations->where('name', '1')->first() == null) <option {{ old('day') == 1 ? 'selected' : '' }} value="1">{{ __('strings.Saturday') }}</option> @endif
                                            @if($vacations->where('name', '2')->first() == null) <option {{ old('day') == 2 ? 'selected' : '' }} value="2">{{ __('strings.Sunday') }}</option> @endif
                                            @if($vacations->where('name', '3')->first() == null) <option {{ old('day') == 3 ? 'selected' : '' }} value="3">{{ __('strings.Monday') }}</option> @endif
                                            @if($vacations->where('name', '4')->first() == null) <option {{ old('day') == 4 ? 'selected' : '' }} value="4">{{ __('strings.Tuesday') }}</option> @endif
                                            @if($vacations->where('name', '5')->first() == null) <option {{ old('day') == 5 ? 'selected' : '' }} value="5">{{ __('strings.Wednesday') }}</option> @endif
                                            @if($vacations->where('name', '6')->first() == null) <option {{ old('day') == 6 ? 'selected' : '' }} value="6">{{ __('strings.Thursday') }}</option> @endif
                                            @if($vacations->where('name', '7')->first() == null) <option {{ old('day') == 7 ? 'selected' : '' }} value="7">{{ __('strings.Friday') }}</option> @endif
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" name="time[]">
                                            {!! times(old('time')) !!}
                                        </select>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-defult btn-close-regust2">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <button type="button" class="btn btn-primary" id="addRow"><i class="fas fa-plus"></i> @lang('strings.add_time') </button>
{{--                                <button type="button" class="btn btn-primary" id="add_time_submit"><i class="fas fa-check-circle"></i> @lang('strings.Save') </button>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="main-wrapper">
            <div class="row">
                <input name="using" value="{{ Request::is('admin/employees') || Request::is('admin/employees/*') ? 1 : 2 }}" type="hidden">
                <div class="col-md-3">
                    <div class="col-md-12">
                        
                        <img src="{{ asset('images/profile-placeholder.png') }}" class="img-responsive" id="imgusers">
                    </div>
                    <div class="col-md-12 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                        <label for="photo_id" class="control-label">@lang('strings.Upload_photo')</label>
                        <input type="file" id="photo_id" name="photo_id" onchange="readURL(this);" data-min-width="200" data-min-height="150"> 
                        <span class="help-block">
                            <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 200*150</strong>
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
                                <h4 class="panel-title">{{ __('strings.add') }}</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <input type="hidden" class="form-control" name="user_id" value="{{  Auth::user()->id }}">
                            <input type="hidden" class="form-control" name="is_active" value="1">

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('code') ? ' has-error' : ''}}">
                                <label class="control-label" for="code">{{ __('strings.Users_code') }}</label>
                                <input type="text" class="form-control" name="code" value="{{old('code')}}" autocomplete="off">
                                @if ($errors->has('code'))
                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('code') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required autocomplete="off">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                                <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}" required autocomplete="off">
                                @if ($errors->has('name_en'))
                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('phone_number') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="phone_number">{{ __('strings.Phone') }}</label>
                                <input id="phone" type="tel" class="form-control" name="phone_number" value="{{old('phone_number')}}" required autocomplete="off">
                                <span id="valid-msg" class="hide">✓ صالح</span>
                                <span id="error-msg" class="hide"></span>

                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('email') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="email">{{ __('strings.Email') }}</label>
                                <input type="email" class="form-control" name="email" value="{{old('email')}}" required autocomplete="off">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('birthday') ? ' has-error' : ''}}">
                                <label class="control-label" for="birthday">{{ __('strings.Birthday') }}</label>
                                <input type="date" class="form-control" name="birthday" value="{{old('birthday')}}" autocomplete="off">
                                @if ($errors->has('birthday'))
                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('birthday') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('type') ? ' has-error' : ''}}">
                                <label class="control-label" for="type">{{ __('strings.Times') }}</label>
                                <select class="form-control js-select" name="type" required>
                                    <option {{ old('type') == 1 ? 'selected' : '' }} value="1">{{ __('strings.FullTime') }}</option>
                                    <option {{ old('type') == 2 ? 'selected' : '' }} value="2">{{ __('strings.PartTime') }}</option>
                                </select>
                            </div>

                            <!--<div class="col-md-4 col-xs-12 form-group{{$errors->has('using') ? ' has-error' : ''}}">
                                <label class="control-label" for="using">{{ __('strings.Type') }}</label>
                                <select class="form-control js-select" name="using" required id="using">
                                    <option  {{ old('using') == 0 ? 'selected' : '' }} value="0">{{ __('strings.select') }}</option>
                                    <option  {{ old('using') == 1 ? 'selected' : '' }} value="1">{{ __('strings.employee') }}</option>
                                    <option  {{ old('using') == 2 ? 'selected' : '' }} value="2">{{ __('strings.user') }}</option>
                                </select>
                                @if ($errors->has('using'))
                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('using') }}</strong>
                                        </span>
                                @endif
                            </div>-->

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('role_id') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="role_id">{{ __('strings.Role_users') }}</label>
                                <select class="form-control js-select" name="role_id" required>
                                    @foreach($roles as $role)
                                        @if(old('role_id')==$role->id)
                                            <option {{ old('role_id') == $role->id ? 'selected' : '' }} value="{{$role->id}}" selected>{{app()->getLocale() == 'ar' ? $role->name : $role->name_en}}</option>
                                        @else
                                            <option {{ old('role_id') == $role->id ? 'selected' : '' }} value="{{$role->id}}">{{app()->getLocale() == 'ar' ? $role->name : $role->name_en }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('role_id'))
                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('role_id') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 New_proo form-group{{$errors->has('section_id') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="section_id">{{ __('strings.Section') }}</label>
                                <select class="form-control js-select" name="section_id" required id="sections">
                                    @foreach($sections as $section)
                                        <option {{ old('section_id') == $section->id ?  'selected' : ''}} value="{{$section->id}}" > {{ app()->getLocale() == 'ar' ? $section->name : $section->name_en }} </option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-info btn-lg NewBtn btnclient" data-toggle="modal" data-target="#add_section"><i class="fas fa-plus"></i></button>

                            @if ($errors->has('section_id'))
                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('section_id') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="col-md-8 col-xs-12 form-group{{$errors->has('address') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="address">{{ __('strings.Address') }}</label>
                                <input type="text" class="form-control" name="address" value="{{old('address')}}" required autocomplete="off">
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <!--<div class="col-md-4 col-xs-12">-->
                            <!--    <button type="button" class="btn btn-info btn-lg NewBtn btnclient btnadd_time" data-toggle="modal" data-target="#add_time">-->
                            <!--        <i class="fas fa-plus"></i>-->
                            <!--        إضافة وقت مستخدم-->
                            <!--    </button>-->
                            <!--</div>-->
                            
                            <!--<div class="col-md-12 col-xs-12">-->
                            <!--    <button type="button" class="btn btn-info btn-lg NewBtn btnclient btnadd_time show_time_btn" onclick="show_time()">-->
                            <!--        <i class="fas fa-plus"></i>-->
                            <!--        عرض-->
                            <!--    </button>-->
                            <!--</div>-->
                            <!--<div class="col-md-12 col-xs-12">-->
                            <!--    <table class="table" id="tabel_time">-->
                            <!--      <tr>-->
                            <!--        <th>اليوم</th>-->
                            <!--        <th></th> -->
                            <!--        <th></th>-->
                            <!--      </tr>-->
                            <!--      <tr>-->
                            <!--        <td>السبت</td>-->
                            <!--        <td>12:00</td> -->
                            <!--        <td>12:30</td>-->
                            <!--      </tr>-->
                            <!--      <tr>-->
                            <!--        <td>الأحد</td>-->
                            <!--        <td>12:00</td> -->
                            <!--        <td>12:30</td>-->
                            <!--      </tr>-->
                            <!--    </table>-->
                            <!--</div>-->
                            <div class="col-md-8 col-xs-12 form-group{{$errors->has('shift_id') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="shift">{{ __('strings.shifts') }}</label>
                            <select class="js-example-basic-multiple" name="shift_id[]" multiple="multiple" id="shift">
                              @foreach($shifts as $shift)
                                <option {{ old('shift_id') == $shift->id ?  'selected' : ''}} value="{{$shift->id}}" > {{ app()->getLocale() == 'ar' ? $shift->name : $shift->name_en }} </option>
                              @endforeach
                              </select>
                            </div>

                            <div class="col-md-4 col-xs-12 password_hidden form-group{{$errors->has('password') ? ' has-error' : ''}}" style="display: none"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="password">{{ __('strings.Password') }}</label>
                                <input type="password" class="form-control" name="password" autocomplete="off">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 password_hidden form-group{{$errors->has('password_confirmation') ? ' has-error' : ''}}" style="display: none">
                                <strong class="text-danger">*</strong>
                                <label class="control-label" for="password_confirmation">{{ __('strings.Password_confirmation') }}</label>
                                <input type="password" class="form-control" name="password_confirmation" autocomplete="off">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('strings.Save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.js"></script>
    
    
    
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

        $('#add_section_submit').click(function() {
            $("#add_section_store").ajaxForm({
                url: '{{ url('admin/ajax/add_section') }}', type: 'post',
                success: function (response) {
                    $('#add_section').modal('toggle');

                    $("#sections").append("<option selected value='" + response.data.id + "'>" + @if(app()->getLocale() == 'ar') response.data.name
                    @else response.data.name_en @endif + "</option>"
                );
                },
                error: function (response) {
                    alert("Please check your entry date again");
                }
            })
        });

        $('#addRow').click(function () {
            var row = $("#tabelnew tr").last().clone();
            $('#tabelnew').append(row);
        });

        $("#tabelnew").on('click', '.btn-close-regust2', function () {
            $(this).parents('tr').remove();
        });
        
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
    
                reader.onload = function (e) {
                    $('#imgusers')
                        .attr('src', e.target.result)
                };
    
                reader.readAsDataURL(input.files[0]);
            }
        };
    </script>
@endsection
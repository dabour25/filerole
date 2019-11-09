@extends('layouts.admin', ['title' =>  __('strings.add_request') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/css/intlTelInput.css" rel="stylesheet" />
@endsection
@section('content')
    <style>
        #tab_logic .form-control[readonly], #tab_logic_total .form-control[readonly] {
            border: 0;
            background: transparent;
            box-shadow: none;
            padding: 0 10px;
            font-size: 15px;
        }
    </style>
    <div class="modal fade newModel" id="addclient" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                            <select class="form-control" name="gender" required>
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
                                <label>{{__('strings.city')}}<strong class="text-danger">*</strong></label>
                                <input type="text" placeholder="" required name="city" value="{{ Session::has('city')  ? session('city') : 'EG' }}">
                            </div>
                        <div class="col-md-12 form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg" id="add_customer_submit">{{ __('strings.Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade newModel" id="open-modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="overflow: hidden">

                </div>
            </div>

        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">@lang('strings.add_request')</h4>
                        </div>
                    </div>
                    <div class="panel-body">

                        <form method="post" action="{{route('followup.store')}}" enctype="multipart/form-data" role="form" id="add-role">
                            {{csrf_field()}}
                            <div class="col-md-6 form-group{{$errors->has('customers') ? ' has-error' : ''}}">
                                <label class="control-label" for="name">@lang('strings.Customers')</label>
                                <select class="form-control js-select" name="customers" id="customers" required>
                                    <option value="">@lang('strings.select')</option>
                                    @foreach($customers_list as $value)
                                        <option {{ old('service_type') == $value->id ? 'selected' : '' }} value="{{ $value->id }}">{{   app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-info btn-lg NewBtn btnclient" data-toggle="modal" data-target="#addclient"><i class="fas fa-plus"></i></button>
                                @if ($errors->has('customers'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('customers') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('request_date') ? ' has-error' : ''}}">
                                <label class="control-label" for="request_date">@lang('strings.request_date')</label>
                                <input type="date" class="form-control" name="request_date" value="{{old('request_date', date('Y-m-d'))}}" required>
                                @if ($errors->has('request_date'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('request_date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('phone') ? ' has-error' : ''}}">
                                <label class="control-label" for="phone">@lang('strings.phone')</label>
                                <input type="text" class="form-control" name="phone" value="{{old('phone')}}">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('address') ? ' has-error' : ''}}">
                                <label class="control-label" for="address">@lang('strings.address')</label>
                                <input type="text" class="form-control" name="address" value="{{old('address')}}">
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('status') ? ' has-error' : ''}}" style="display: none;">
                                <label class="control-label" for="status">@lang('strings.Status')</label>
                                <select class="form-control js-select" name="status">
                                    <option value="q" selected>@lang('strings.request')</option>
                                    <option value="a">@lang('strings.approved')</option>
                                    <option value="r">@lang('strings.return')</option>
                                    <option value="f">@lang('strings.refused')</option>
                                    <option value="s">@lang('strings.scheduled')</option>
                                </select>

                                @if ($errors->has('status'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('service_type') ? ' has-error' : ''}}">
                                <label class="control-label" for="service_type">@lang('strings.service_type')</label>
                                <select class="form-control js-select" name="service_type" required>
                                    <option value="">@lang('strings.select')</option>
                                    @foreach($services_list as $value)
                                        <option {{ old('service_type') == $value->id ? 'selected' : '' }} value="{{ $value->id }}">{{   app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-info btn-lg NewBtn btnclient open-modal-2"><i class="fas fa-plus"></i></button>
                                @if ($errors->has('service_type'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('service_type') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('description') ? ' has-error' : ''}}">
                                <label class="control-label" for="description">@lang('strings.followup_desc')</label>
                                <textarea name="description"></textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!--div class="col-md-6 form-group{{$errors->has('admin_description') ? ' has-error' : ''}}">
                                <label class="control-label" for="admin_description">@lang('strings.AdminDescription')</label>
                                <textarea name="admin_description"></textarea>
                                @if ($errors->has('admin_description'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('admin_description') }}</strong>
                                    </span>
                                @endif
                            </div-->


                            <div class="col-md-6 form-group{{$errors->has('health_status') ? ' has-error' : ''}}">
                                <label class="control-label" for="health_status">@lang('strings.health_status')</label>
                                <textarea name="health_status"></textarea>
                                @if ($errors->has('health_status'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('health_status') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <table id="tab_items" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>@lang('strings.image_type')</th>
                                            <th>@lang('strings.file')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id='row-1'>
                                            <td>
                                                <select class="form-control" id="type-1" name="types[]" required>
                                                    <option value="">@lang('strings.select')</option>
                                                    <option value="1">@lang('strings.medical')</option>
                                                    <option value="2">@lang('strings.contract')</option>
                                                    <option value="3">@lang('strings.transformation')</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="file" class="form-control" name="files[]"/ data-min-width="400" data-min-height="200">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        <a href="#" onclick="addphoto(this)" class="btn btn-default pull-left">@lang('strings.add_file')</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">@lang('strings.Save')</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.js"></script>

    <script>
    
    
        function addphoto(){
            var row = $("#tab_items tr").last().clone();
            var oldId = Number(row.attr('id').slice(-1));
        
            var id = 1 + oldId;
            
            row.attr('id', 'row-' + id );
            row.find('#type-' + oldId).attr('id', 'type-' + id); 
             $('#tab_items').append(row); 
      
               
        }

        $(document).ready(function () {
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

            $('#add_customer_submit').click(function() {
                $("#add_customer_store").ajaxForm({
                    url: '{{ url('admin/ajax/add_customer') }}', type: 'post',
                    beforeSubmit: function (response) {
                        if(iti.isValidNumber() == false) {
                            alert("Please check your phone again");
                            return false;
                        }
                    },
                    success: function (response) {
                        $('#addclient').modal('toggle');

                        $("#customers").append("<option selected value='" + response.data.id + "'>" + @if(app()->getLocale() == 'ar') response.data.name
                        @else response.data.name_en @endif + "</option>"
                    );
                    },
                    error: function (response) {
                        alert("Please check your entry date again");
                    }
                })
            });

        });
        $(document).on('click', '.open-modal-2', function () {
            jQuery('#open-modal').modal('show', {backdrop: 'true'});
            $.ajax({
                url: '{{ url('admin/ajax/categories_modal') }}/2',
                success: function (response) {
                    jQuery('#open-modal .modal-body').html(response);
                }
            });
            return false;
        });
        $("#customers").change(function() {
            $.get("{{ url('admin/followup/get-customer/') }}/" + this.value, function (data) {
                $("input[name=phone]").val(data.phone_number);
                $("input[name=address]").val(data.address);
            });
        });
    </script>
@endsection
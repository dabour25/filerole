@extends('layouts.admin', ['title' =>  __('strings.edit_request') ])
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
                            <input type="text" class="form-control" name="address" value="{{old('address')}}">
                            @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-12 form-group{{$errors->has('phone_number') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                            <label class="control-label" for="phone_number">{{ __('strings.Phone') }}</label>
                            <input type="tel" class="form-control" name="phone_number" id="phone" value="{{old('phone_number')}}">
                            <span id="valid-msg" class="hide">✓ صالح</span>
                            <span id="error-msg" class="hide"></span>

                            @if ($errors->has('phone_number'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group{{$errors->has('from_date') ? ' has-error' : ''}}">
                            <label class="control-label" for="from_date"> {{ __('strings.From_date') }}</label>
                            <input type="date" class="form-control" name="from_date" value="{{old('from_date', date('Y-m-d'))}}" >
                            @if ($errors->has('from_date'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('from_date') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 form-group{{$errors->has('to_date') ? ' has-error' : ''}}">
                            <label class="control-label" for="to_date">{{ __('strings.To_date') }} </label>
                            <input type="date" class="form-control" name="to_date" value="{{old('to_date', date('Y-m-d'))}}">
                            @if ($errors->has('to_date'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('to_date') }}</strong>
                                </span>
                            @endif
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
                    <form method="post" action="{{ route('followup.update', $followup->id) }}" enctype="multipart/form-data" role="form" id="add-role">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}

                        <div class="panel-heading clearfix">
                            <div class="col-md-12">
                                <h4 class="panel-title">@lang('strings.edit_request')</h4>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="col-md-6 form-group{{$errors->has('customers') ? ' has-error' : ''}}">
                                <label class="control-label" for="name">@lang('strings.Customers')</label>
                                <select class="form-control js-select" name="customers" id="customers" required>
                                    <option value="">@lang('strings.select')</option>
                                    @foreach($customers_list as $value)
                                        <option {{ $followup->cust_id == $value->id ? 'selected' : '' }} value="{{ $value->id }}">{{   app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</option>
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
                                <input type="date" class="form-control" name="request_date" value="{{  $followup->request_dt }}" required>
                                @if ($errors->has('request_date'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('request_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('phone') ? ' has-error' : ''}}">
                                <label class="control-label" for="phone">@lang('strings.phone')</label>
                                <input type="text" class="form-control" name="phone" value="{{ $customer->phone_number }}" readonly>
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('address') ? ' has-error' : ''}}">
                                <label class="control-label" for="address">@lang('strings.address')</label>
                                <input type="text" class="form-control" name="address" value="{{$customer->address }}" readonly>
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('status') ? ' has-error' : ''}}">
                                <label class="control-label" for="request_status">@lang('strings.Status')</label>
                                <select class="form-control js-select" name="request_status" {{ permissions('followup_confirm') == 0 && Request::is('admin/followup/*/edit') ? 'disabled' : '' }} >
                                    <option {{ $followup->status == 'q' ? 'selected' : '' }} value="q" >@lang('strings.request')</option>
                                    <option {{ $followup->status == 'a' ? 'selected' : '' }} value="a">@lang('strings.approved')</option>
                                    <option {{ $followup->status == 'r' ? 'selected' : '' }} value="r">@lang('strings.return')</option>
                                    <option {{ $followup->status == 'f' ? 'selected' : '' }} value="f">@lang('strings.refused')</option>
                                    <option {{ $followup->status == 's' ? 'selected' : '' }} value="s">@lang('strings.scheduled')</option>
                                </select>

                                @if ($errors->has('request_status'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('request_status') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('service_type') ? ' has-error' : ''}}">
                                <label class="control-label" for="service_type">@lang('strings.service_type')</label>
                                <select class="form-control js-select" name="service_type" required>
                                    <option value="">@lang('strings.select')</option>
                                    @foreach($services_list as $value)
                                        <option {{ $followup->cat_id == $value->id ? 'selected' : '' }} value="{{ $value->id }}">{{   app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</option>
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
                                <textarea name="description">{{ $followup->secr_text }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @if(Request::is('admin/followup/*/confirm'))
                            <div class="col-md-6 form-group{{$errors->has('admin_description') ? ' has-error' : ''}}">
                                <label class="control-label" for="admin_description">@lang('strings.AdminDescription')</label>
                                <textarea name="admin_description">{{ $followup->admin_text }}</textarea>
                                @if ($errors->has('admin_description'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('admin_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @endif
                            <div class="col-md-6 form-group{{$errors->has('health_status') ? ' has-error' : ''}}">
                                <label class="control-label" for="health_status">@lang('strings.health_status')</label>
                                <textarea name="health_status">{{ $followup->health_status }}</textarea>
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
                                            <th>@lang('strings.upload_file')</th>
                                            <th>@lang('strings.download')</th>
                                            <th>@lang('strings.Delete')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php $count = 1;  $photos = App\FollowupPhotos::where('followup_id', $followup->id)->get();
                                        @endphp

                                        @if(count($photos) == 0)
                                            <tr id='row-1'>
                                                <td>
                                                    <select class="form-control New_select" id="type-1" name="types[]" required>
                                                        <option value="">@lang('strings.select')</option>
                                                        <option value="1">@lang('strings.medical')</option>
                                                        <option value="2">@lang('strings.contract')</option>
                                                        <option value="3">@lang('strings.transformation')</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="file" class="form-control" name="files[]"/>
                                                </td>
                                                <td> </td>
                                                <td> </td>
                                            </tr>
                                        @else
                                            @foreach($photos as $value)
                                                <tr id='row-{{ $count }}'>
                                                    <td>
                                                        <input class="form-control" name="image_ids[]" value="{{ $value->id }}" type="hidden" id="image_ids-{{ $count }}">
                                                        <select class="form-control New_select" id="type-{{ $count }}" name="types[]" required>
                                                            <option value="">@lang('strings.select')</option>
                                                            <option {{ $value->image_type == 1 ? 'selected' : ''  }} value="1">@lang('strings.medical')</option>
                                                            <option {{ $value->image_type == 2 ? 'selected' : ''  }} value="2">@lang('strings.contract')</option>
                                                            <option {{ $value->image_type == 3 ? 'selected' : ''  }} value="3">@lang('strings.transformation')</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="file" class="form-control" name="files[]"/>
                                                    </td>
                                                    <td> <a href="{{ asset('images/'.App\FollowupPhotos::where([ 'id' => $value->id])->value('fimage')) }}" target="_blank"> <span class="label label-success" style="font-size:12px;">{{ __('strings.download') }}</span> </a></td>
                                                    <td>
                                                        <a href="{{ url('admin/followup/delete_image', $value->id) }}"
                                                           data-toggle="tooltip"
                                                           data-placement="bottom"
                                                           data-original-title="حذف الصورة"
                                                           onclick="return confirm('سوف تقوم بحذف الصورة. هل تريد الاستمرار');"><i class="fa fa-close"></i></a>
                                                    </td>
                                                </tr>
                                                @php $count++; @endphp
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        <a href="#" onclick="addphoto(this)" class="btn btn-default pull-left">@lang('strings.add_photo')</a>
                                    </div>
                                </div>
                            </div>
                            @if(Request::is('admin/followup/*/confirm') || permissions('followup_confirm') == 0 || Request::is('admin/followup/*/edit'))
                            <div class="col-md-6 form-group{{$errors->has('Deposit') ? ' has-error' : ''}}">
                                <label class="control-label" for="deposit">@lang('strings.Deposit')</label>
                                <input type="number" setp="any" class="form-control" name="deposit" {{ permissions('followup_confirm') == 0 ? 'readonly' : '' }}  value="{{ $followup->deposit }}">
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('Deposit') ? ' has-error' : ''}}">
                                <label class="control-label" for="deposit_inv_code">@lang('strings.invoice_no')</label>
                                <input type="text" class="form-control" name="deposit_inv_code" value="{{ $followup->deposit_inv_code }}">
                            </div>
                            @endif
                        </div>
                        @if(Request::is('admin/followup/*/confirm') || $followup->status == 's' && permissions('followup_confirm') == 0)
                            <div class="panel-heading clearfix">
                                <div class="col-md-12">
                                    <h4 class="panel-title">@lang('strings.schedule_table')</h4>
                                </div>
                            </div>

                            <div class="panel-body">
                                <table id="sessions" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>@lang('strings.serial')</th>
                                            <th>@lang('strings.Date')</th>
                                            <th>@lang('strings.Amount')</th>
                                            <th>@lang('strings.invoice_no')</th>
                                            <th width="15%">@lang('strings.attendance_status')</th>
                                            <th>@lang('strings.Delete')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php $count2 = 1;  $sessions = App\FollowupSessions::where('followup_id', $followup->id)->get();
                                        @endphp
                                        @if(count($sessions) == 0)
                                            <tr id='rows-1'>
                                                <td><input class="form-control" name="ids[]" value="0" type="hidden" id="ids-1"> <input class="form-control" name="serial[]" type="text" id="serial-1" value="{{ !empty(App\FollowupSessions::where(['org_id' => Auth::user()->org_id, 'followup_id' => $followup->id])->orderBy('id', 'DESC')->value('serial')) ? App\FollowupSessions::where(['org_id' => Auth::user()->org_id, 'followup_id' => $followup->id])->orderBy('id', 'DESC')->value('serial') + 1 : 1 }}"></td>
                                                <td><input class="form-control" name="date[]" type="date" value="{{ date('Y-m-d') }}"></td>
                                                <td><input type="number" setp="any" class="form-control" name="amount[]" value=""></td>
                                                <td><input type="text" class="form-control" name="invoice_no[]" value=""></td>
                                                <td>
                                                    <select class="form-control" id="status-1" name="status[]">
                                                        <option value="1">@lang('strings.reservation')</option>
                                                        <option value="2">@lang('strings.attended')</option>
                                                        <option value="3">@lang('strings.did_not_attend')</option>
                                                        <option value="4">@lang('strings.cancel')</option>
                                                    </select>
                                                </td>
                                                <td></td>
                                            </tr>
                                        @else
                                            @foreach($sessions as $value)
                                            <tr id='rows-{{ $count2 }}'>
                                                <td><input class="form-control"  name="ids[]" value="{{ $value->id }}" type="hidden" id="ids-{{ $count2 }}"> <input class="form-control" name="serial[]" id="serial-{{ $count2 }}" type="text" {{ permissions('followup_confirm') == 1 || Request::is('admin/followup/*/confirm') ? '' : 'readonly' }}  value="{{ $value->serial }}"></td>
                                                <td><input class="form-control" name="date[]" type="date" value="{{ $value->session_dt }}" {{ permissions('followup_confirm') == 1 || Request::is('admin/followup/*/confirm') ? '' : 'readonly' }}></td>
                                                <td><input type="number" setp="any" class="form-control" name="amount[]" value="{{ $value->session_pay }}" {{ permissions('followup_confirm') == 1 || Request::is('admin/followup/*/confirm') ? '' : 'readonly' }}></td>
                                                <td><input type="text" class="form-control" name="invoice_no[]" value="{{ $value->session_inv_code }}"></td>
                                                <td>
                                                    <select class="form-control" id="status-1" name="status[]">
                                                        <option {{ $value->session_status == 1 ? 'selected' : ''  }} value="1">@lang('strings.reservation')</option>
                                                        <option {{ $value->session_status == 2 ? 'selected' : ''  }} value="2">@lang('strings.attended')</option>
                                                        <option {{ $value->session_status == 3 ? 'selected' : ''  }} value="3">@lang('strings.did_not_attend')</option>
                                                        <option {{ $value->session_status == 4 ? 'selected' : ''  }} value="4">@lang('strings.cancel')</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <a href="{{ url('admin/followup/delete_session', $value->id) }}"
                                                       data-toggle="tooltip"
                                                       data-placement="bottom"
                                                       data-original-title="حذف الصورة"
                                                       onclick="return confirm('سوف تقوم بحذف الصورة. هل تريد الاستمرار');"><i class="fa fa-close"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @php $count2++; @endphp
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                @if(permissions('followup_confirm') == 1 || Request::is('admin/followup/*/confirm'))
                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        <a href="#" onclick="addsession(this)" class="btn btn-default pull-left">@lang('strings.add_session')</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        @endif
                        <div class="col-md-12 form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg">@lang('strings.Save')</button>
                        </div>
                    </form>
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
            row.find('#image_ids-' + oldId).attr('id', 'image_ids-' + id).attr('value', '0');
            row.find('td:eq(2),td:eq(3)').remove();

            $('#tab_items').append(row);
        }

        function addsession(){

            var row = $("#sessions tr").last().clone();
            var oldId = Number(row.attr('id').slice(-1));
            var id = 1 + oldId;

            row.attr('id', 'rows-' + id );
            row.find('#status-' + oldId).attr('id', 'status-' + id);
            row.find('#ids-' + oldId).attr('id', 'ids-' + id).attr('value', '0');
            row.find('#serial-' + oldId).attr('id', 'serial-' + id).attr('value', parseFloat($('#serial-' + oldId).val()) + 1);
            row.find('td:eq(5)').remove();

            $('#sessions').append(row);
        }

        $(document).ready(function () {
            var input = document.querySelector("#phone"), errorMsg = document.querySelector("#error-msg"), validMsg = document.querySelector("#valid-msg");
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
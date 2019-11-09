@extends('layouts.admin', ['title' => __('strings.smart_pricing') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.10/css/bootstrap-select.min.css" rel="stylesheet">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="row">

            <div class="col-md-12">
                <style>
                    .btn-primary:hover {
                        background: #2c9d6f !important;
                    }
                </style>

                <!-- Function Description -->
                <div class="alert_new">
                    <span class="alertIcon">
                        <i class="fas fa-exclamation-circle"></i>
                    </span>
                    <p>
                        @if (app()->getLocale() == 'ar')
                            {{ DB::table('function_new')->where('id',259)->value('description') }}
                        @else
                            {{ DB::table('function_new')->where('id',259)->value('description_en') }}
                        @endif
                    </p>
                    <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i> </a>
                </div>
                <div class="panel panel-white">
                    <form method="POST" action="{{ url('admin/rates/smart/post') }}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        {{ method_field('PATCH') }}
                        <input name="id" type="hidden" value="{{ $id }}">
                        <div class="panel-heading clearfix">
                            <div class="col-md-12">
                                <h4 class="panel-title">{{ __('strings.smart_pricing')}}</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            @if(Request::is('admin/rates/smart-pricing'))
                            
                            <div class="col-lg-4 form-group{{$errors->has('property') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="property">@lang('strings.property_head')</label>
                                <select class="form-control js-select" name="property" required id="property">
                                    <option value="">@lang('strings.select')</option>
                                    @foreach($property as $v)
                                        <option {{ app('request')->input('property') == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{   app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('property'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('property') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-4 form-group{{$errors->has('rooms') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="rooms">@lang('strings.rooms')</label>
                                <select class="form-control selectpicker" name="rooms[]" id="rooms" required multiple title="@lang('strings.rooms')" data-live-search="true" data-actions-box="true">
                                    @foreach($list as $v)
                                        <option {{ old('rooms') == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{   app()->getLocale() == 'ar' ? $v->name : $v->name_en }}  - {{ App\PriceList::where([ 'cat_id' => $v->id])->orderBy('date', 'desc')->value('date') }} </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('rooms'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('rooms') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-4 form-group{{$errors->has('usage') ? ' has-error' : ''}}">
                                <label class="control-label" for="usage">@lang('strings.rooms_usage')</label>
                                <input type="number" class="form-control" name="usage" value="{{ app('request')->input('usage') }}" max="100" min="0" id="usage">
                            </div>
                            
                            @else
                            <div class="col-lg-4 form-group{{$errors->has('usage') ? ' has-error' : ''}}">
                                <label class="control-label" for="usage">@lang('strings.rooms_usage')</label>
                                <input type="number" class="form-control" name="usage" value="{{ app('request')->input('usage') }}" max="100" min="0" id="usage">
                            </div>
                            
                            <div class="col-lg-4 form-group{{$errors->has('rooms') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="rooms">@lang('strings.rooms')</label>
                                <select class="form-control selectpicker" name="rooms[]" id="rooms" required multiple title="@lang('strings.rooms')" data-live-search="true" data-actions-box="true">
                                    @foreach($list as $v)
                                        <option {{ old('rooms') == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{   app()->getLocale() == 'ar' ? $v->name : $v->name_en }}  - {{ App\PriceList::where([ 'cat_id' => $v->id])->orderBy('date', 'desc')->value('date') }} </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('rooms'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('rooms') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @endif
                            
                            <div class="col-lg-4 form-group{{$errors->has('price_type') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="price_type">@lang('strings.price_type')</label>
                                <select class="form-control js-select" name="price_type" id="price_type" required>
                                    <option value="">@lang('strings.select')</option>
                                    <option value="1">@lang('strings.price_up')</option>
                                    <option value="2">@lang('strings.price_down')</option>
                                </select>
                                @if ($errors->has('price_type'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('price_type') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-lg-4 form-group{{$errors->has('type') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="type">@lang('strings.type')</label>
                                <select class="form-control js-select" name="type" id="discount_type" required>
                                    <option value="">@lang('strings.select')</option>
                                    <option value="1">@lang('strings.Percentage')</option>
                                    <option value="2">@lang('strings.Value')</option>
                                </select>
                                @if ($errors->has('type'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-4 form-group{{$errors->has('discount_value') ? ' has-error' : ''}}" @if($errors->has('discount_value')) @else style="display: none" @endif id="discountsss">
                                <label class="control-label" for="discount_value" id="discount_value_label">@lang('strings.Discount')</label>
                                <input type="number" class="form-control" name="discount_value" value="{{old('discount_value')}}" id="discount_value" required>
                                @if ($errors->has('discount_value'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('discount_value') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-4 form-group{{$errors->has('date') ? ' has-error' : ''}}">
                                <label class="control-label" for="date">@lang('strings.Date')</label>
                                <input type="date" class="form-control" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg" id="button_submit"> @lang('strings.Save') </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.10/js/bootstrap-select.min.js"></script>

    <script>
        $('#usage').change(function() {
            if (history.pushState) {
                @if(Request::is('admin/rates/smart-pricing'))
                var url = window.location.protocol + "//" + window.location.host + window.location.pathname + "?usage=" + this.value + "&property=" + $( "#property" ).val();
                @else
                var url = window.location.protocol + "//" + window.location.host + window.location.pathname + "?usage=" + this.value;
                @endif
                window.history.pushState({ path:url },'',url);
                location.reload();
            }
        });

        $( "#price_type" ).change(function() {
            if(this.value == 1){
                $('#discount_value_label').text('الذيادة');
            }else{
                $('#discount_value_label').text('الخصم');
            }
        });
        $('.selectpicker').selectpicker({
            selectAllText: 'اختر الكل',
            deselectAllText: 'الغاء الكل'
        });
        
        $( "#property" ).change(function() {
            if (history.pushState) {
                var url = window.location.protocol + "//" + window.location.host + window.location.pathname + "?usage=" + $( "#usage" ).val() + "&property=" + $( "#property" ).val();
                window.history.pushState({ path:url },'',url);
                location.reload();
            }
            /*$.get("{{ url('admin/rates/smart-pricing-get-rooms/') }}/" + this.value, function (data) {
                $("#rooms").empty();
                $.each(data, function (key, value) {
                    $("#rooms").append("<option value='" + value.id + "'>" + value.name + "</option>");
                });
                $('.selectpicker').selectpicker('refresh');
            });*/
        });
    </script>
@endsection
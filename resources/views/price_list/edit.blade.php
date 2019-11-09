@extends('layouts.admin', ['title' => __('strings.edit') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <!--<div class="page-title">-->
    <!--    <h3> @lang('strings.Price_list_edit') </h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>-->
    <!--            <li><a href="{{ route('price_list.index') }}"> @lang('strings.Price_list')</a></li>-->
    <!--            <li class="active">{{ $type == 1 ? __('strings.Price_list_add') : __('strings.Price_list_add_service')}}</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('strings.edit')}}</h4>
                    </div>
                    <div class="panel-body">

                        <form method="POST" action="{{ route('price_list.update', $list->id) }}" enctype="multipart/form-data">

                            {{csrf_field()}}
                            {{ method_field('PATCH') }}

                            <div class="col-md-6 form-group">
                                <label class="control-label" for="price">@lang('strings.Item_name')</label>
                                <input type="hidden" name="categories" class="form-control" value="{{ $list->cat_id }}">
                                <input type="text" class="form-control" value="{{ app()->getLocale() == 'ar' ? App\Category::findOrFail($list->cat_id)->name: App\Category::findOrFail($list->cat_id)->name_en }}" disabled>

                            </div>

                            <div class="col-md-6 form-group{{$errors->has('price') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="price">@lang('strings.Price')</label>
                                <input type="text" class="form-control" name="price" value="{{ $list->price }}" id="price">
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('tax_type') ? ' has-error' : ''}}">
                                <label class="control-label" for="tax_type">@lang('strings.Tax_type')</label>
                                <select class="form-control js-select" name="tax_type" id="tax_type">
                                    <option value="0">@lang('strings.Select_tax_type')</option>
                                    @foreach($taxs as $v)
                                        <option {{ $list->tax == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{ app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('tax_type'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('tax_type') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('date') ? ' has-error' : ''}}">
                                <label class="control-label" for="date">@lang('strings.Date')</label>
                                <input type="date" class="form-control" name="date" value="{{ $list->date }}" readonly>
                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="active">@lang('strings.Status')</label>
                                <select class="form-control js-select" name="active">
                                    <option {{ $list->active == 1 ? 'selected' : '' }} value="1">@lang('strings.Active')</option>
                                    <option {{ $list->active == 0 ? 'selected' : '' }} value="0">@lang('strings.Deactivate')</option>
                                </select>
                                @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('active') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <h2>@lang('strings.Total')</h2>

                                <ul style="list-style-type:disc" id="clac">
                                    <li id="tax"> @lang('strings.Tax_value') : {{ $list->tax_value != null ? $list->tax_value : 0 }} </li>
                                </ul>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-11"></div>
                                <div class="form-group col-md-1">
                                    <button type="submit" class="btn btn-primary btn-lg">@lang('strings.Save')</button>
                                </div>
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
<script>
    $("#tax_type").change(function () {
        $.get("{{ url('admin/price_list/get-tax/') }}/" + this.value, function (data) {
            $("#tax").empty();
            $("#pricec").empty();
            $.each(data, function (key, value) {
                if(value.value != null){
                    var total = parseFloat($('#price').val()) + parseFloat(value.value);
                    $("#tax").append("<li>@lang('strings.Tax_value') :" +  parseFloat(value.value) + "</li>");
                }else if(value.percent != null){
                    var total = Math.round(((parseFloat(value.percent) / 100) * parseFloat($('#price').val())));
                    $("#tax").append("<li>@lang('strings.Tax_value') :" +  value.percent + "</li>");
                }else{
                    $("#tax").empty();
                }
            });
        });
    });
    $("#price").change(function () {
        if(item != null) {
            $.get("{{ url('admin/price_list/check-purchasing-price/') }}/" + {{ $list->cat_id }} + '/' + this.value, function (data) {
                if (data == 1) {
                    $('#button_submit').attr('disabled', 'disabled');
                    alert('@lang('strings.Price_purchasing_alert')');
                } else {
                    $('#button_submit').removeAttr('disabled', 'disabled');
                }
            });
        }
    });
</script>
@endsection
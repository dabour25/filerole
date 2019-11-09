@extends('layouts.admin', ['title' => __('strings.add_price') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <!--<div class="page-title">-->
    <!--    <h3> @lang('strings.Price_list_add') </h3>-->
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
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('strings.add_price')}}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('price_list.store')}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="type" value="{{ $type }}">

                            <div class="col-md-6 form-group{{$errors->has('categories_type') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="categories_type">@lang('strings.Categories_type')</label>
                                <select class="form-control js-select" name="categories_type" id="categories_typess" required>
                                    <option value="0">@lang('strings.select')</option>
                                    @foreach(App\CategoriesType::where(['type' => $type, 'org_id' => Auth::user()->org_id])->get() as $v)
                                        <option {{ old('categories_type') == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{   app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('categories_type'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('categories_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <script>

                            </script>

                            <div class="col-md-6 form-group{{$errors->has('categories') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="categories">@lang('strings.Item')</label>
                                <select class="form-control js-select" name="categories" id="categoriess" required>

                                </select>
                                @if ($errors->has('categories'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('categories') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('price') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="price">@lang('strings.Price')</label>
                                <input type="number" step="any" class="form-control" name="price" value="{{old('price')}}" id="price" required>
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
                                        <option value="{{ $v->id }}">{{ $v->name }}</option>
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
                                <input type="date" class="form-control" name="date" id="date" required>
                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="active">@lang('strings.Status')</label>
                                <select class="form-control" name="active">
                                    <option value="1">@lang('strings.Active')</option>
                                    <option value="0">@lang('strings.Deactivate')</option>
                                </select>
                                @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('active') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <h2>@lang('strings.Total')</h2>
                                 <input type="hidden" id="tax_value" value="0">
                                <ul style="list-style-type:disc" id="clac">
                                    <li id="tax">@lang('strings.Tax_value') : 0 </li>
                                </ul>
                            </div>
                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg" id="button_submit"> @lang('strings.Save') </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script>
        $("#type").change(function () {
            $.get( "{{ url('admin/categories/get-type/') }}/" + this.value, function( data ) {
                $("#categories_typess").empty();
                $("#categoriess").empty();
                $("#categories_typess").append("<option value='0'> @lang('strings.Select_categories')</option>");
                $.each(data, function(key, value) {
                    $("#categories_typess").append("<option value='" + value.id + "'>" + @if(app()->getLocale() == 'ar') value.name @else value.name_en @endif + "</option>");
                });
            });

            if(this.value == 1) {
                $(".model").hide();
                $(".cloth").hide();
                $(".items").show();
                $("#barcode").show();

            }else if(this.value == 2) {
                $(".model").hide();
                $(".cloth").hide();
                $(".items").hide();
                $("#barcode").hide();
            }else if(this.value == 3) {
                $(".model").show();
                $(".cloth").hide();
                $(".items").hide();
                $("#barcode").hide();
                $.get( "{{ url('admin/categories/get-categories/') }}/" + this.value, function( data ) {
                    $("#cloths").empty();
                    $.each(data, function(key, value) {
                        $("#cloths").append("<option value='" + value.id + "'>" + @if(app()->getLocale() == 'ar') value.name @else value.name_en @endif + "</option>");
                    });
                });
            }else if(this.value == 4) {
                $(".model").hide();
                $(".cloth").show();
                $(".items").hide();
                $("#barcode").show();
            }
        });

        $("#categories_typess").change(function () {
            $.get("{{ url('admin/price_list/get-categories/') }}/" + this.value, function (data) {
                $("#categoriess").empty();
                $.each(data, function (key, value) {
                    $("#categoriess").append("<option value='" + value.id + "'>" + @if(app()->getLocale() == 'ar') value.name @else value.name_en @endif + "</option>");
                });
            });
        });
        $("#price").change(function () {
            if (parseFloat($('#tax_value').val()) < 100) {
                var price = Math.round(((parseFloat($('#price').val()) / 100) * parseFloat($('#tax_value').val()))) + parseFloat($('#price').val());
            }else{
                var price = parseFloat($('#price').val()) + parseFloat($('#tax_value').val());
            }

            if (parseFloat($('#tax_value').val()) == 0){
                var price = parseFloat($('#price').val());
            }
        });
        $("#tax_type").change(function () {
            $.get("{{ url('admin/price_list/get-tax/') }}/" + this.value, function (data) {
                $("#tax").empty();
                $("#pricec").empty();
                $.each(data, function (key, value) {
                    if(value.value != null){
                        var total = parseFloat($('#price').val()) + parseFloat(value.value);
                        $("#tax").append("<li>@lang('strings.Tax_value') :" +  parseFloat(value.value) + "</li>");
                        $("#tax_value").val(parseFloat(value.value));
                    }else if(value.percent != null){
                        var total = Math.round(((parseFloat(value.percent) / 100) * parseFloat($('#price').val())));
                        $("#tax").append("<li>@lang('strings.Tax_value') :" +  value.percent + "</li>");
                        $("#tax_value").val(value.percent);
                    }else{
                        $("#tax").empty();
                    }
                });
            });
        });
        $("#date").change(function () {
            var item = $('#categoriess').val();
            $.get("{{ url('admin/price_list/check-price/') }}/" + item + '/' + this.value, function (data) {
                if(data                                          == 1){
                    $('#button_submit').attr('disabled', 'disabled');
                    alert('@lang('strings.Price_alert')');
                }else{                                          
                    $('#button_submit').removeAttr('disabled', 'disabled');
                }
            });
            $.get("{{ url('admin/price_list/check-purchasing-price/') }}/" + item + '/' + this.value, function (data) {
                if (data == 1) {
                    $('#button_submit').attr('disabled', 'disabled');
                    alert('@lang('strings.Price_purchasing_alert')');
                } else {
                    $('#button_submit').removeAttr('disabled', 'disabled');
                }
            });
        });
        $("#price").change(function () {
            var item = $('#categoriess').val();
            if(item != null) {
                $.get("{{ url('admin/price_list/check-purchasing-price/') }}/" + item + '/' + this.value, function (data) {
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
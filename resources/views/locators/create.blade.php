@extends('layouts.admin', ['title' => __('strings.Locators') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
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
    <!--<div class="page-title">-->
    <!--    <h3> @lang('strings.locator_add')</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>-->
    <!--            <li><a href="{{ route('locators.index') }}">@lang('strings.Locators')</a></li>-->
    <!--            <li class="active">@lang('strings.locator_add')</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">@lang('strings.locator_add')</h4>
                        </div>
                    </div>
                    <div class="panel-body">

                        <form method="post" action="{{route('locators.store')}}" enctype="multipart/form-data" role="form" id="add-role">
                            {{csrf_field()}}

                            <div class="col-md-6 form-group{{$errors->has('store') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="store">@lang('strings.Store')</label>
                                <select class="form-control js-select" name="store">
                                    @foreach($stores as $value)
                                        <option value="{{ $value->id }}">{{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('store'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('store') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="name">@lang('strings.code')</label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="active">@lang('strings.Status')</label>
                                <select class="form-control js-select" name="active">
                                    <option value="1">@lang('strings.Active')</option>
                                    <option value="0">@lang('strings.Deactivate')</option>
                                </select>
                                @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('active') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group{{$errors->has('description') ? ' has-error' : ''}}">
                                <label class="control-label" for="description">@lang('strings.Description')</label>
                                <textarea type="text" class="summernote" name="description">{{old('description')}}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
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
    <script>
        $('#selectall, #selectall2').click(function (e) {
            var table = $(e.target).closest('table');
            $('td input:checkbox', table).prop('checked', this.checked);
        });
    </script>
@endsection
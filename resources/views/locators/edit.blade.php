@extends('layouts.admin', ['title' => __('strings.Locator_edit') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <!--<div class="page-title">-->
    <!--    <h3>@lang('strings.Locator_edit')</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>-->
    <!--            <li><a href="{{ route('locators.index') }}">@lang('strings.locators')</a></li>-->
    <!--            <li class="active">@lang('strings.Locator_edit')</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">@lang('strings.Locator_edit') </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="">
                            <form method="post" action="{{route('locators.update', $locator->id)}}" enctype="multipart/form-data" id="edit">
                                {{csrf_field()}}
                                {{ method_field('PATCH') }}

                                <div class="col-md-6 form-group{{$errors->has('store') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="store">@lang('strings.Locator')</label>
                                    <select class="form-control js-select" name="store">
                                        @foreach($stores as $value)
                                            <option {{ $locator->store_id == $value->id ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('store'))
                                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('store') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="name">@lang('strings.Arabic_name')</label>
                                    <input type="text" class="form-control" name="name" value="{{ $locator->name }}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>



                                <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="active">@lang('strings.Status')</label>
                                    <select class="form-control js-select" name="active">
                                        <option {{ $locator->active == 1 ? 'selected': '' }} value="1">@lang('strings.Active')</option>
                                        <option {{ $locator->active == 0 ? 'selected': '' }} value="0">@lang('strings.Deactivate')</option>
                                    </select>
                                    @if ($errors->has('active'))
                                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('active') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-12 form-group{{$errors->has('description') ? ' has-error' : ''}}">
                                    <label class="control-label" for="description">@lang('strings.Description')</label>
                                    <textarea type="text" class="summernote" name="description">{{ $locator->description}}</textarea>
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
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
@endsection
@extends('layouts.admin', ['title' => __('strings.add') ])

@section('content')
    <!--<div class="page-title">-->
    <!--    <h3> {{ $type == 1 ? __('strings.categories_type_add') : __('strings.categories_type_service_add') }} </h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>-->
    <!--            <li><a href="{{ route('categories_type.index') }}">{{ __('strings.Categories_types') }}</a></li>-->
    <!--            <li class="active">{{ $type == 1 ? __('strings.categories_type_add') : __('strings.categories_type_service_add')}}</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('strings.add')}}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('categories_type.store')}}" enctype="multipart/form-data">

                            {{csrf_field()}}
                            <input name="type" type="hidden" value="{{ $type }}">
                            <input name="active" type="hidden" value="1">

{{--                            <div class="col-md-6 form-group{{$errors->has('type') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>--}}
{{--                                <label class="control-label" for="type">{{ __('strings.Type') }}</label>--}}
{{--                                <select class="form-control" name="type" required>--}}
{{--                                    <option {{ old('type') == 1 ? 'selected' : ''}} value="1">{{ __('strings.Item') }}</option>--}}
{{--                                    <option {{ old('type') == 2 ? 'selected' : ''}} value="2">{{ __('strings.Service') }}</option>--}}
{{--                                    <option {{ old('type') == 3 ? 'selected' : ''}} value="3">{{ __('strings.Model') }}</option>--}}
{{--                                    <option {{ old('type') == 4 ? 'selected' : ''}} value="4">{{ __('strings.Clothe') }}</option>--}}
{{--                                </select>--}}
{{--                                @if ($errors->has('type'))--}}
{{--                                    <span class="help-block">--}}
{{--                                        <strong class="text-danger">{{ $errors->first('type') }}</strong>--}}
{{--                                    </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}



                            <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                                <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}" required>
                                @if ($errors->has('name_en'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="col-md-6 desk_New form-group{{$errors->has('description') ? ' has-error' : ''}}">
                                <label class="control-label" for="description">@lang('strings.description_ar')</label>
                                <textarea type="text" class="textall" name="description">{{old('description')}}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 desk_New form-group{{$errors->has('description_en') ? ' has-error' : ''}}">
                                <label class="control-label" for="description">@lang('strings.description_en')</label>
                                <textarea type="text" class="textall" name="description_en">{{old('description_en')}}</textarea>
                                @if ($errors->has('description_en'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description_en') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <!--div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="active">{{ __('strings.Status') }}</label>
                                <select class="form-control" name="active" required>
                                    <option selected value="1">{{ __('strings.Active') }}</option>
                                    <option value="0">{{ __('strings.Deactivate') }}</option>

                                </select>
                                @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('active') }}</strong>
                                    </span>
                                @endif
                            </div-->

                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg"> {{ __('strings.Save') }} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
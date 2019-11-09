@extends('layouts.admin', ['title' => __('strings.edit') ])

@section('content')

    <!--<div class="page-title">-->
    <!--    <h3> {{ $type == 1 ? __('strings.Categories_type_edit') : __('strings.Categories_type_service_edit') }} </h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>-->
    <!--            <li><a href="{{ route('categories_type.index') }}">{{ __('strings.categories_types') }}</a></li>-->
    <!--            <li class="active">{{ $type == 1 ? __('strings.Categories_type_edit') : __('strings.Categories_type_service_edit') }}</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">{{ __('strings.edit') }}</h4>
                </div>
                <div class="panel-body">
                    <form method="post" action="{{route('categories_type.update', $data->id)}}" enctype="multipart/form-data"
                  id="edit-role">
                {{csrf_field()}}
                {{ method_field('PATCH') }}
                <input name="active" type="hidden" value="1">
                <input name="type" type="hidden" value="{{ $type }}">
                <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                    <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                    <input type="text" class="form-control" name="name" value="{{ $data->name }}">
                    @if ($errors->has('name'))
                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                    <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                    <input type="text" class="form-control" name="name_en" value="{{ $data->name_en }}">
                    @if ($errors->has('name_en'))
                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                    </span>
                    @endif
                </div>


                <div class="col-md-6 desk_New form-group{{$errors->has('description') ? ' has-error' : ''}}">
                    <label class="control-label" for="description">@lang('strings.description_ar')</label>
                    <textarea type="text" class="textall" name="description">{{ $data->description }}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="col-md-6 desk_New form-group{{$errors->has('description_en') ? ' has-error' : ''}}">
                    <label class="control-label" for="description">@lang('strings.description_en')</label>
                    <textarea type="text" class="textall" name="description_en">{{ $data->description_en }}</textarea>
                    @if ($errors->has('description_en'))
                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description_en') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="col-md-12 form-group text-right">
                    <button type="submit" class="btn btn-primary btn-lg"> {{ __('strings.Save') }} </button>
                </div>

            </form>
                </div>
        </div>
    </div>

@endsection
@extends('layouts.admin', ['title' => __('strings.Sections_add') ])

@section('content')

    <!--<div class="page-title">-->
    <!--    <h3> {{ __('strings.Sections_add') }} </h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>-->
    <!--            <li><a href="{{ route('sections.index') }}">{{ __('strings.Sections') }}</a></li>-->
    <!--            <li class="active">{{ __('strings.Sections_add') }}</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('strings.Sections_add') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('sections.store')}}" enctype="multipart/form-data">

                            {{csrf_field()}}
                            <input type="hidden" class="form-control" name="user_id" value="{{  Auth::user()->id }}">

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
                                <button type="submit" class="btn btn-primary btn-lg"> {{ __('strings.Save') }} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@if(Request::is('admin/yearly_vacations/*/edit'))
@extends('layouts.admin', ['title' => __('strings.yearly_vacations_edit') ])

@section('content')

    <div class="page-title">
        <h3>@lang('strings.yearly_vacations_edit')</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>
                <li><a href="{{ route('yearly_vacations.index') }}">@lang('strings.yearly_vacations')</a></li>
                <li><a href="{{ route('yearly_vacations.create') }}">@lang('strings.yearly_vacations_add')</a></li>
                <li class="active">@lang('strings.yearly_vacations_edit')</li>

            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">@lang('strings.yearly_vacations_edit')</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('yearly_vacations.update', $vacation->id)}}" enctype="multipart/form-data">

                            {{csrf_field()}}
                            {{ method_field('PATCH') }}


                            <div class="col-md-4 form-group{{$errors->has('date') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="date">@lang('strings.Date') </label>
                                <input type="date" class="form-control" name="date" value="{{ $vacation->date }}">
                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="name">@lang('strings.Arabic_name')</label>
                                <input class="form-control" type="text" name="name" value="{{ $vacation->name }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="name_en">@lang('strings.English_name')</label>
                                <input class="form-control" type="text" name="name_en" value="{{ $vacation->name_en }}">

                                @if ($errors->has('name_en'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group{{$errors->has('description') ? ' has-error' : ''}}">
                                <label class="control-label" for="description">@lang('strings.Description')</label>
                                <textarea name="description" class="summernote">{{ $vacation->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}">
                                <label class="control-label" for="active">@lang('strings.Status')</label>
                                <select class="form-control" name="active">
                                    <option @if($vacation->active == 1) selected @endif value="1">@lang('strings.Active')</option>
                                    <option @if($vacation->active == 0) selected @endif value="0">@lang('strings.Deactivate')</option>
                                </select>
                                @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('active') }}</strong>
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

@else

@extends('layouts.admin', ['title' => __('strings.weekly_vacations_edit')])
@section('content')

    <div class="page-title">
        <h3>@lang('strings.weekly_vacations_edit')</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>
                <li><a href="{{ route('weekly_vacations.index') }}">@lang('strings.weekly_vacations')</a></li>
                <li><a href="{{ route('weekly_vacations.create') }}">@lang('strings.weekly_vacations_add')</a></li>
                <li class="active">@lang('strings.weekly_vacations_edit')</li>

            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">@lang('strings.weekly_vacations_edit')</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('weekly_vacations.update', $vacation->id)}}" enctype="multipart/form-data">

                            {{csrf_field()}}
                            {{ method_field('PATCH') }}


                            <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}">
                                <label class="control-label" for="name">@lang('strings.Day')</label>
                                <select class="form-control" name="name">
                                    <option @if($vacation->name == "1") selected @endif value="1">@lang('strings.Saturday')</option>
                                    <option @if($vacation->name == "2") selected @endif value="2">@lang('strings.Sunday')</option>
                                    <option @if($vacation->name == "3") selected @endif value="3">@lang('strings.Monday')</option>
                                    <option @if($vacation->name == "4") selected @endif value="4">@lang('strings.Tuesday')</option>
                                    <option @if($vacation->name == "5") selected @endif value="5">@lang('strings.Wednesday')</option>
                                    <option @if($vacation->name == "6") selected @endif value="6">@lang('strings.Thursday')</option>
                                    <option @if($vacation->name == "7") selected @endif value="7">@lang('strings.Friday')</option>
                                </select>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}">
                                <label class="control-label" for="active">@lang('strings.Status')</label>
                                <select class="form-control" name="active">
                                    <option @if($vacation->active == 1) selected @endif value="1">@lang('strings.Active')</option>
                                    <option @if($vacation->active == 0) selected @endif value="0">@lang('strings.Deactivate')</option>
                                </select>
                                @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('active') }}</strong>
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
@endif
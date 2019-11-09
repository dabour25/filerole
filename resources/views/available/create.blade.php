@extends('layouts.admin', ['title' => __('strings.Available_add') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')

    @include('alerts.index')
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('strings.Available_add') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('available.store')}}" enctype="multipart/form-data">

                            {{csrf_field()}}
                            <div class="col-md-6 form-group{{$errors->has('captin_id') ? ' has-error' : ''}}"><strong
                                        class="text-danger">*</strong>
                                <label class="control-label" for="captin_id">{{ __('strings.User') }}</label>
                                <select class="form-control js-select" name="captin_id">
                                    <option value="0">{{ __('strings.Select') }}</option>
                                    @foreach($users as $value)
                                        <option {{ old('captin_id') == $value->id ? 'selected' : ''}} value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('captin_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('captin_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('day') ? ' has-error' : ''}}">
                                <label class="control-label" for="day">{{ __('strings.Day') }}</label>
                                <select class="form-control js-select" name="day">
                                    {{--@foreach($vacations as $v)--}}
                                        @if($vacations->where('name', '1')->first() == null) <option {{ old('day') == 1 ? 'selected' : '' }} value="1">{{ __('strings.Saturday') }}</option> @endif
                                        @if($vacations->where('name', '2')->first() == null) <option {{ old('day') == 2 ? 'selected' : '' }} value="2">{{ __('strings.Sunday') }}</option> @endif
                                        @if($vacations->where('name', '3')->first() == null) <option {{ old('day') == 3 ? 'selected' : '' }} value="3">{{ __('strings.Monday') }}</option> @endif
                                        @if($vacations->where('name', '4')->first() == null) <option {{ old('day') == 4 ? 'selected' : '' }} value="4">{{ __('strings.Tuesday') }}</option> @endif
                                        @if($vacations->where('name', '5')->first() == null) <option {{ old('day') == 5 ? 'selected' : '' }} value="5">{{ __('strings.Wednesday') }}</option> @endif
                                        @if($vacations->where('name', '6')->first() == null) <option {{ old('day') == 6 ? 'selected' : '' }} value="6">{{ __('strings.Thursday') }}</option> @endif
                                        @if($vacations->where('name', '7')->first() == null) <option {{ old('day') == 7 ? 'selected' : '' }} value="7">{{ __('strings.Friday') }}</option> @endif
                                    {{--@endforeach--}}
                                </select>
                                @if ($errors->has('day'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('day') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('time') ? ' has-error' : ''}}">
                                <label class="control-label" for="time">{{ __('strings.Time') }}</label>
                                <select class="form-control js-select" name="time">
                                    {!! times(old('time')) !!}
                                </select>
                                @if ($errors->has('time'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('time') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}">
                                <label class="control-label" for="active">{{ __('strings.Status') }}</label>
                                <select class="form-control js-select" name="active">
                                    <option selected value="1">{{ __('strings.Active') }}</option>
                                    <option value="0">{{ __('strings.Deactivate') }}</option>
                                </select>
                                @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('active') }}</strong>
                                    </span>
                                @endif
                            </div>



                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> {{ __('strings.Save') }} </button>
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
        $(".js-select").select2();
    </script>
@endsection
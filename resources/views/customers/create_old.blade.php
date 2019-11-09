@extends('layouts.admin', ['title' => __('strings.Customers_add') ])

@section('content')

    <div class="page-title">
        <h3> {{ __('strings.Customers_add') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>
                <li><a href="{{ url('admin/customers') }}">{{ __('strings.Customers') }}</a></li>
                <li class="active">{{ __('strings.Customers_add') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('strings.Customers_add') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if(Session::has('message'))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        {{Session::get('message')}}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <form method="post" action="{{route('customers.store')}}" enctype="multipart/form-data" role="form" id="add-role">
                            {{csrf_field()}}
                            <input type="hidden" class="form-control" name="user_id" value="{{  Auth::user()->id }}">


                            <div class="col-md-6 form-group{{$errors->has('cust_code') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="cust_code">{{ __('strings.Membership') }}</label>
                                <input type="text" class="form-control" name="cust_code" value="{{ old('cust_code') }}">
                                @if ($errors->has('cust_code'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('cust_code') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                                <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                                <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}">
                                @if ($errors->has('name_en'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('email') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="email">{{ __('strings.Email') }}</label>
                                <input type="text" class="form-control" name="email" value="{{old('email')}}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>



                            <div class="col-md-6 form-group{{$errors->has('gender') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="gender">{{ __('strings.Gender') }}</label>
                                <select class="form-control" name="gender">
                                    <option value="1">{{ __('strings.Male') }}</option>
                                    <option value="0" selected >{{ __('strings.Female') }}</option>
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                                <label for="photo_id" class="control-label">{{ __('strings.Upload_photo') }}</label>
                                <input type="file" id="photo_id" name="photo_id">
                                @if ($errors->has('photo_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group{{$errors->has('address') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="address">{{ __('strings.Address') }}</label>
                                <input type="text" class="form-control" name="address" value="{{old('address')}}">
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('phone_number') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="phone_number">{{ __('strings.Phone') }}</label>
                                <input type="text" class="form-control" name="phone_number" value="{{old('phone_number')}}">
                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="active">{{ __('strings.Status') }}</label>
                                <select class="form-control" name="active">
                                    <option value="1">{{ __('strings.Active') }}</option>
                                    <option value="0">{{ __('strings.Deactivate') }}</option>
                                </select>
                                @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('active') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="col-md-6 form-group{{$errors->has('to_date') ? ' has-error' : ''}}">
                                <label class="control-label" for="to_date">{{ __('strings.To_date') }} </label>
                                <input type="date" class="form-control" name="to_date" value="{{old('to_date', date('Y-m-d'))}}">
                                @if ($errors->has('to_date'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('to_date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('from_date') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="from_date"> {{ __('strings.From_date') }}</label>
                                <input type="date" class="form-control" name="from_date" value="{{old('from_date', date('Y-m-d'))}}" >
                                @if ($errors->has('from_date'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('from_date') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="col-md-6 form-group{{$errors->has('password') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="password">{{ __('strings.Password') }}</label>
                                <input type="password" class="form-control" name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('password_confirmation') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="password_confirmation">{{ __('strings.Password_confirmation') }}</label>
                                <input type="password" class="form-control" name="password_confirmation">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">{{ __('strings.Save') }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
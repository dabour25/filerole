@extends('layouts.admin', ['title' => __('strings.Customers_edit') ])
@section('content')
    <div class="page-title">
        <h3>{{ __('strings.Customers_edit') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>
                <li><a href="{{ url('admin/customers') }}">{{ __('strings.Customers') }}</a></li>
                <li class="active">{{ __('strings.Customers_edit') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-3">
                <img src="{{$customer->photo ? asset($customer->photo->file) : asset('images/profile-placeholder.png') }}" class="img-responsive">
            </div>
            <div class="col-md-9">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('strings.Customers_edit') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="">
                            <form method="post" action="{{route('customers.update', $customer->id)}}" enctype="multipart/form-data" id="edit">
                                <input type="hidden" class="form-control" name="user_id" value="{{  Auth::user()->id }}">
                                {{csrf_field()}}
                                {{ method_field('PATCH') }}

                                <div class="col-md-6 form-group{{$errors->has('cust_code') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="cust_code">{{ __('strings.Customers_edit') }}</label>
                                    <input type="text" class="form-control" name="cust_code" value="{{$customer->cust_code}}" readonly>
                                    @if ($errors->has('cust_code'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('cust_code') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{$customer->name}}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                                    <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                                    <input type="text" class="form-control" name="name_en" value="{{$customer->name_en}}">
                                    @if ($errors->has('name_en  '))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('phone_number') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="phone_number">{{ __('strings.Phone') }}</label>
                                    <input type="text" class="form-control" name="phone_number" value="{{$customer->phone_number}}" readonly>
                                    @if ($errors->has('phone_number'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('email') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="email">{{ __('strings.Email') }}</label>
                                    <input type="email" class="form-control" name="email" value="{{$customer->email}}" readonly>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('gender') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="gender">{{ __('strings.Gender') }}</label>
                                    <select class="form-control" name="gender">
                                        <option @if($customer->gender == 1) selected @endif value="1">{{ __('strings.Male') }}</option>
                                        <option @if($customer->gender == 0) selected @endif value="0">{{ __('strings.Female') }}</option>
                                    </select>
                                    @if ($errors->has('gender'))
                                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label for="photo_id" class="control-label">{{ __('strings.Upload_photo') }}</label>
                                    <input type="file" id="photo_id" name="photo_id">
                                    @if ($errors->has('photo_id'))
                                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('address') ? ' has-error' : ''}}">
                                    <label class="control-label" for="address">{{ __('strings.Address') }}</label>
                                    <input type="text" class="form-control" name="address" value="{{$customer->address}}">
                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('to_date') ? ' has-error' : ''}}">
                                    <label class="control-label" for="to_date">{{ __('strings.To_date') }} </label>
                                    <input type="date" class="form-control" name="to_date" value="{{$customer->valid_to_date}}">
                                    @if ($errors->has('to_date'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('to_date') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('from_date') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="from_date"> {{ __('strings.From_date') }}</label>
                                    <input type="date" class="form-control" name="from_date" value="{{$customer->valid_from_date}}">
                                    @if ($errors->has('from_date'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('from_date') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}">
                                    <label class="control-label" for="active">{{ __('strings.Status') }}</label>
                                    <select class="form-control" name="active">
                                        @if($customer->active==1)
                                            <option value="1" selected>{{ __('strings.Active') }}</option>
                                            <option value="0">{{ __('strings.Deactivate') }}</option>
                                        @else
                                            <option value="1">{{ __('strings.Active') }}</option>
                                            <option value="0" selected>{{ __('strings.Deactivate') }}</option>
                                        @endif
                                    </select>
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
    </div>
@endsection
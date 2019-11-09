@extends('layouts.admin', ['title' => __('strings.Change_Password')])
@section('content')

    <!--<div class="page-title">-->
    <!--    <h3>{{ __('strings.Change_Password') }}</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>-->
    <!--            <li class="active">{{ __('strings.Change_Password') }}</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6 col-md-offset-3" style="margin-top:15px;">
                <div class="panel panel-white">
                    <a href="{{  url('/') }}" tabindex="-1">
                              <span><i class="fa fa-home"></i>{{ __('strings.Home') }}</span>
                            </a> 
                    <div class="panel-body">
                           
                        @include('alerts.customerPassword')

                        @if($errors->has('password'))
                            <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                        @endif
                        @if(Auth::guard('web')->check())
                            <form method="post" action="{{ route('postChangePassword', Auth::user()->id) }}">
                        @elseif(Auth::guard('customers')->check())
                            <form method="post" action="{{ route('postChangePassword', Auth::guard('customers')->user()->id) }}">
                        @endif
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="form-group"> <strong class="text-danger">*</strong>
                                    <label class="control-label">{{ __('strings.Change_password_old') }}</label>
                                    <input type="password" class="form-control" name="old_password" id="old_password">
                                </div>
                                <div class="form-group"> <strong class="text-danger">*</strong>
                                    <label class="control-label">{{ __('strings.Change_password_new') }}</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>
                                <div class="form-group"> <strong class="text-danger">*</strong>
                                    <label class="control-label">{{ __('strings.Change_password_confirm') }}</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">{{ __('strings.Save') }}</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
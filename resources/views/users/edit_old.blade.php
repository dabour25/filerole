@extends('layouts.admin', ['title' => __('strings.Users_edit') ])

@section('content')

    <div class="page-title">
        <h3> {{ __('strings.Users_edit') }} </h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>
                <li><a href="{{ route('users.index') }}">{{ __('strings.Users') }}</a></li>
                <li class="active">{{ __('strings.Users_edit') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <form method="post" action="{{route('users.update', $user->id)}}" enctype="multipart/form-data"
                  id="edit_users">

                {{csrf_field()}}
                {{ method_field('PATCH') }}

                <div class="col-md-3">
                    <img src="{{$user->photo ? asset($user->photo->file) : asset('images/profile-placeholder.png') }}"
                         class="img-responsive">

                    <div class="col-md-6 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                        <label for="photo_id" class="control-label">{{ __('strings.Upload_photo') }}</label>
                        <input type="file" id="photo_id" name="photo_id">
                        @if ($errors->has('photo_id'))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                    </span>
                        @endif
                    </div>

                </div>
                <div class="col-md-9">


                    <div class="col-md-6 form-group{{$errors->has('code') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="code">{{ __('strings.Users_code') }}</label>
                        <input type="text" class="form-control" name="code" value="{{$user->code}}" readonly>
                        @if ($errors->has('code'))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('code') }}</strong>
                    </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                        <input type="text" class="form-control" name="name" value="{{$user->name}}">
                        @if ($errors->has('name'))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                    </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                        <input type="text" class="form-control" name="name_en" value="{{$user->name_en}}">
                        @if ($errors->has('name_en  '))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                    </span>
                        @endif
                    </div>
                    <div class="col-md-6 form-group{{$errors->has('phone_number') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="phone_number">{{ __('strings.Phone') }}</label>
                        <input type="text" class="form-control" name="phone_number" value="{{$user->phone_number}}">
                        @if ($errors->has('phone_number'))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
                    </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('address') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="address">{{ __('strings.Address') }}</label>
                        <input type="text" class="form-control" name="address" value="{{$user->address}}">
                        @if ($errors->has('address'))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('address') }}</strong>
                    </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('birthday') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="birthday">{{ __('strings.Birthday') }}</label>
                        <input type="date" class="form-control" name="birthday" value="{{$user->birthday}}">
                        @if ($errors->has('birthday'))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('birthday') }}</strong>
                    </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('email') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="email">{{ __('strings.Email') }}</label>
                        <input type="email" class="form-control" name="email" value="{{$user->email}}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                    </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('is_active') ? ' has-error' : ''}}">
                        <label class="control-label" for="is_active">{{ __('strings.Status') }}</label>
                        <select class="form-control" name="is_active">
                            @if($user->is_active==1)
                                <option value="1" selected>{{ __('strings.Active') }}</option>
                                <option value="0">{{ __('strings.Deactivate') }}</option>
                            @else
                                <option value="1">{{ __('strings.Active') }}</option>
                                <option value="0" selected>{{ __('strings.Deactivate') }}</option>
                            @endif
                        </select>
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('type') ? ' has-error' : ''}}">
                        <label class="control-label" for="type">{{ __('strings.Type') }}</label>
                        <select class="form-control" name="type">
                            <option {{ $user->type == 1 ? 'selected' : '' }} value="1">{{ __('strings.FullTime') }}</option>
                            <option {{ $user->type == 2 ? 'selected' : '' }} value="2">{{ __('strings.PartTime') }}</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('role_id') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="role_id">{{ __('strings.Role') }}</label>
                        <select class="form-control" name="role_id">
                            <option value="0">{{ __('strings.Select') }}</option>
                            @foreach($roles as $role)
                                @if($user->role_id == $role->id)
                                    <option value="{{$role->id}}"
                                            selected>{{app()->getLocale() == 'ar' ? $role->name : $role->name_en}}</option>
                                @else
                                    <option value="{{$role->id}}">{{app()->getLocale() == 'ar' ? $role->name : $role->name_en}}</option>
                                @endif
                            @endforeach
                        </select>
                        @if ($errors->has('role_id'))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('role_id') }}</strong>
                    </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('section_id') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="section_id">{{ __('strings.Section') }}</label>
                        <select class="form-control" name="section_id">
                            <option value="0">{{ __('strings.Select') }}</option>
                            @foreach($sections as $section)
                                @if($user->section_id == $section->id)
                                    <option value="{{$section->id}}"
                                            selected>{{app()->getLocale() == 'ar' ? $section->name : $section->name_en}}</option>
                                @else
                                    <option value="{{$section->id}}">{{ app()->getLocale() == 'ar' ? $section->name : $section->name_en }}</option>
                                @endif
                            @endforeach
                        </select>
                        @if ($errors->has('section_id'))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('section_id') }}</strong>
                    </span>
                        @endif
                    </div>


                    <div class="col-md-12 form-group text-right">
                        <button type="submit" class="btn btn-primary btn-lg"> {{ __('strings.Save') }} </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

@endsection
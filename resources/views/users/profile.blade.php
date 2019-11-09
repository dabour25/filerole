@extends('layouts.admin', ['title' => __('strings.Users_edit') ])
@section('content')
<!--<div class="page-title">-->
<!--    <h3>{{ __('strings.Users_edit') }}</h3>-->
<!--    <div class="page-breadcrumb">-->
<!--        <ol class="breadcrumb">-->
<!--            <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>-->
<!--            <li><a href="{{ route('users.index') }}">{{ __('strings.Users') }}</a></li>-->
<!--            <li class="active">{{ __('strings.Users_edit') }}</li>-->
<!--        </ol>-->
<!--    </div>-->
<!--</div>-->

<div id="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <div class="col-md-12">
                        <h4 class="panel-title">{{ __('strings.Users_edit') }}</h4>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-2">
                        <img src="{{$user->photo ? asset($user->photo->file) : asset('images/profile-placeholder.png') }}" class="img-responsive img-circle">
                        <br>
                        @if($user->id != Auth::user()->id)
                            <div class="text-center">
                                <form method="post" action="{{route('users.destroy', $user->id)}}">
                                    {{csrf_field()}}
                                    {{ method_field('DELETE') }}
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger">{{ __('strings.Delete') }}</button>
                                    </div>
                                </form>
                            </div>
                        @endif

                    </div>

                    <div class="col-md-8">
                        <form method="post" action="{{route('users.update', $user->id)}}" enctype="multipart/form-data">

                            {{csrf_field()}}
                            {{ method_field('PATCH') }}

                            <div class="form-group{{$errors->has('arabic_name') ? ' has-error' : ''}}">
                                <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                                <input type="text" class="form-control" name="name" value="{{$user->name}}">
                                @if ($errors->has('arabic_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('arabic_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                                <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                                <input type="text" class="form-control" name="name_en" value="{{$user->name_en}}">
                                @if ($errors->has('name_en'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{$errors->has('phone_number') ? ' has-error' : ''}}">
                                <label class="control-label" for="phone_number">{{ __('strings.Phone') }}</label>
                                <input type="text" class="form-control" name="phone_number" value="{{$user->phone_number}}">
                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{$errors->has('address') ? ' has-error' : ''}}">
                                <label class="control-label" for="address">{{ __('strings.Address') }}</label>
                                <input type="text" class="form-control" name="address" value="{{$user->address}}">
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{$errors->has('birthday') ? ' has-error' : ''}}">
                                <label class="control-label" for="birthday">{{ __('strings.Birthday') }}</label>
                                <input type="date" class="form-control" name="birthday" value="{{$user->birthday}}">
                                @if ($errors->has('birthday'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('birthday') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
                                <label class="control-label" for="email">{{ __('strings.Email') }}</label>
                                <input type="email" class="form-control" name="email" value="{{$user->email}}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{$errors->has('is_active') ? ' has-error' : ''}}">
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

                            <div class="form-group{{$errors->has('role_id') ? ' has-error' : ''}}">
                                <label class="control-label" for="role_id">{{ __('strings.Role') }}</label>
                                <select class="form-control" name="role_id">
                                    <option value="0">{{ __('strings.Select') }}</option>
                                    @foreach($roles as $role)
                                        @if($user->role_id == $role->id)
                                            <option value="{{$role->id}}" selected>{{$role->name}}</option>
                                        @else
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('role_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('role_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{$errors->has('section_id') ? ' has-error' : ''}}">
                                <label class="control-label" for="section_id">{{ __('strings.Section') }}</label>
                                <select class="form-control" name="section_id">
                                    <option value="0">{{ __('strings.Select') }}</option>
                                    @foreach($sections as $section)
                                        @if($user->section_id == $section->id)
                                            <option value="{{$section->id}}" selected>{{$section->name}}</option>
                                        @else
                                            <option value="{{$section->id}}">{{$section->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('section_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('section_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                                <label for="photo_id" class="control-label">{{ __('strings.Upload_photo') }}</label>
                                <input type="file" id="photo_id" name="photo_id"  data-min-width="200" data-min-height="150">
                                 <span class="help-block">
                                    <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 200*150</strong>
                                 </span>
                                 <hr>
                                @if ($errors->has('photo_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg">{{ __('strings.Save') }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <script src="{{asset('js/jquery.checkImageSize.min.js')}}"></script>
    <script> 
        $("input[type='file']").checkImageSize({
              minWidth: $(this).data('min-width'),
              minHeight: $(this).data('min-height'),
            showError:true,
            ignoreError:false
        });
        
    </script>
@endsection
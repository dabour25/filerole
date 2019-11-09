@extends('layouts.admin', ['title' => __('strings.Users_add')])

@section('content')

    <div class="page-title">
        <h3> {{ __('strings.Users_add') }} </h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>
                <li><a href="{{ route('users.index') }}">{{ __('strings.Users') }}</a></li>
                <li class="active">{{ __('strings.Users_add') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('strings.Users_add') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('users.store')}}" enctype="multipart/form-data" id="">

                            {{csrf_field()}}
                            <input type="hidden" class="form-control" name="user_id" value="{{  Auth::user()->id }}">
                            
                            <div class="col-md-12 col-xs-12 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                                <label for="photo_id" class="control-label">{{ __('strings.Upload_photo') }}</label>
                                <!-- <input type="file" id="photo_id" name="photo_id" id="input-b5" name="input-b5[]">-->
                                <input id="input-25" name="input25[]" type="file" class="file-loading">
                                @if ($errors->has('photo_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('code') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="code">{{ __('strings.Users_code') }}</label>
                                <input type="text" class="form-control" name="code" value="{{old('code')}}" required autocomplete="off">
                                @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" required autocomplete="off">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                                <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}" required autocomplete="off">
                                @if ($errors->has('name_en'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('phone_number') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="phone_number">{{ __('strings.Phone') }}</label>
                                <input type="text" class="form-control" name="phone_number" value="{{old('phone_number')}}" required autocomplete="off">
                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('email') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="email">{{ __('strings.Email') }}</label>
                                <input type="email" class="form-control" name="email" value="{{old('email')}}" required autocomplete="off">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('birthday') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="birthday">{{ __('strings.Birthday') }}</label>
                                <input type="date" class="form-control" name="birthday" value="{{old('birthday')}}" required autocomplete="off">
                                @if ($errors->has('birthday'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('birthday') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('is_active') ? ' has-error' : ''}}">
                                <label class="control-label" for="is_active">{{ __('strings.Status') }}</label>
                                <select class="form-control" name="is_active" required>
                                    <option selected value="1">{{ __('strings.Active') }}</option>
                                    <option  value="0">{{ __('strings.Deactivate') }}</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('type') ? ' has-error' : ''}}">
                                <label class="control-label" for="type">{{ __('strings.Type') }}</label>
                                <select class="form-control" name="type" required>
                                    <option {{ old('type') == 1 ? 'selected' : '' }} value="1">{{ __('strings.FullTime') }}</option>
                                    <option {{ old('type') == 2 ? 'selected' : '' }} value="2">{{ __('strings.PartTime') }}</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('role_id') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="role_id">{{ __('strings.Role') }}</label>
                                <select class="form-control" name="role_id" required>
                                    <option value="0">{{ __('strings.Select') }}</option>
                                    @foreach($roles as $role)
                                        @if(old('role_id')==$role->id)
                                            <option {{ old('role_id') == $role->id ? 'selected' : '' }} value="{{$role->id}}" selected>{{app()->getLocale() == 'ar' ? $role->name : $role->name_en}}</option>
                                        @else
                                            <option {{ old('role_id') == $role->id ? 'selected' : '' }} value="{{$role->id}}">{{app()->getLocale() == 'ar' ? $role->name : $role->name_en }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('role_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('role_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('section_id') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="section_id">{{ __('strings.Section') }}</label>
                                <select class="form-control" name="section_id" required>
                                    <option value="0">{{ __('strings.Select') }}</option>
                                    @foreach($sections as $section)
                                        @if(old('section_id')==$section->id)
                                            <option value="{{$section->id}}" selected> {{ app()->getLocale() == 'ar' ? $section->name : $section->name_en }} </option>
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

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('address') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="address">{{ __('strings.Address') }}</label>
                                <input type="text" class="form-control" name="address" value="{{old('address')}}" required autocomplete="off">
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('password') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="password">{{ __('strings.Password') }}</label>
                                <input type="password" class="form-control" name="password" required autocomplete="off">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4 col-xs-12 form-group{{$errors->has('password_confirmation') ? ' has-error' : ''}}"> 
                                <strong class="text-danger">*</strong>
                                <label class="control-label" for="password_confirmation">{{ __('strings.Password_confirmation') }}</label>
                                <input type="password" class="form-control" name="password_confirmation" required autocomplete="off">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('strings.Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#FormValidator').bootstrapValidator({
            live: 'enabled',
            message: 'This value is not valid',
            submitButtons: 'button[type="submit"]',
            trigger: null,
            fields: {
                email: {
                    //message: 'The username is not valid',
                    validators: {
                        remote: {
                            url: '{{ url('admin/users/validator/email') }}',
                            // Send { username: 'its value', email: 'its value' } to the back-end
                            data: function(validator) {
                                return {
                                    email: validator.getFieldElements('email').val()
                                };
                            },
                            //message: 'The email is not available'
                        }
                    }
                },
                phone_number: {
                    //message: 'The phone number is not valid',
                    validators: {
                        remote: {
                            url: '{{ url('admin/users/validator/phone_number') }}',
                            // Send { username: 'its value', email: 'its value' } to the back-end
                            data: function(validator) {
                                return {
                                    phone_number: validator.getFieldElements('phone_number').val()
                                };
                            },
                            //message: 'The phone number is not available'
                        }
                    }
                },
                name: {
                    //message: 'The Arabic Name is not valid',
                    validators: {
                        remote: {
                            url: '{{ url('admin/users/validator/name') }}',
                            // Send { username: 'its value', email: 'its value' } to the back-end
                            data: function(validator) {
                                return {
                                    name: validator.getFieldElements('name').val()
                                };
                            },
                            //message: 'The Arabic Name is not available'
                        }
                    }
                },
                name_en: {
                    //message: 'The English Name is not valid',
                    validators: {
                        remote: {
                            url: '{{ url('admin/users/validator/name_en') }}',
                            // Send { username: 'its value', email: 'its value' } to the back-end
                            data: function(validator) {
                                return {
                                    name_en: validator.getFieldElements('name_en').val()
                                };
                            },
                            //message: 'The English Name is not available'
                        }
                    }
                },
                code: {
                    //message: 'The code is not valid',
                    validators: {
                        remote: {
                            url: '{{ url('admin/users/validator/code') }}',
                            // Send { username: 'its value', email: 'its value' } to the back-end
                            data: function(validator) {
                                return {
                                    code: validator.getFieldElements('code').val()
                                };
                            },
                            //message: 'The code is not available'
                        }
                    }
                },
                birthday: {
                    //message: 'The birthday is not valid',
                    validators: {
                        remote: {
                            url: '{{ url('admin/users/validator/birthday') }}',
                            // Send { username: 'its value', email: 'its value' } to the back-end
                            data: function(validator) {
                                return {
                                    birthday: validator.getFieldElements('birthday').val()
                                };
                            },
                            //message: 'The birthday is not available'
                        }
                    }
                },
                address: {
                    //message: 'The address is not valid',
                    validators: {
                        remote: {
                            url: '{{ url('admin/users/validator/address') }}',
                            // Send { username: 'its value', email: 'its value' } to the back-end
                            data: function(validator) {
                                return {
                                    address: validator.getFieldElements('address').val()
                                };
                            },
                            //message: 'The address is not available'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: 'The password is required and cannot be empty'
                        }
                    }
                },
                password_confirmation: {
                    validators: {
                        notEmpty: {
                            message: 'The password_confirmation is required and cannot be empty'
                        }
                    }
                }
            }
        });

        $( '#FormValidator' ).on( 'status.field.bv', function( e, data ) {
            let $this = $( this );
            let formIsValid = true;

            $( '.form-group', $this ).each( function() {
                formIsValid = formIsValid && $( this ).hasClass( 'has-success' );
            });

            $( '.submit-button', $this ).attr( 'disabled', !formIsValid );
        });

    });

</script>
@endsection
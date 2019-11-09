@extends('layouts.admin', ['title' => __('strings.Role_add') ])

@section('content')
    <div class="page-title">
        <h3> {{ __('strings.Role_add') }} </h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>
                <li><a href="{{ route('roles.index') }}">{{ __('strings.Roles') }}</a></li>
                <li class="active">{{ __('strings.Role_add') }}</li>
            </ol>
        </div>
    </div>
    <div id="main-wrapper">
        <div class="row">
                        <form method="post" action="{{route('roles.store')}}" enctype="multipart/form-data">

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

                            <div class="col-md-12 form-group">
                                <div class="check_all">
                                  <div class="title_check_menu">
                                      <h3>إعدادات القائمة</h3>
                                    	<p>
                                    		<button type="button" onclick='selectAll()'> <i class="fas fa-check"></i> تحديد الكل </button>
                                    		<button type="button" onclick='UnSelectAll()'> <i class="fas fa-times"></i> إلغاء تحديد الكل  </button>
                                    	</p>
                                  </div>
                                  @foreach( $authentications as $auth)
                                  <div class="check_menu">
                                  <!-- <input type="checkbox" name="check_auth[]"> -->
                                <label class="containerss"> {{app()->getLocale() == 'ar' ? $auth->funcname : $auth->funcname_en }}
                                  <input type="checkbox" name="acs" type="checkbox" value="{{$auth->id}}">
                                  <span class="checkmark"></span>
                                </label>
                                  </div>
                                  @endforeach
                                 </div>
                            </div>

                            
                <div class="col-md-12 form-group{{$errors->has('description') ? ' has-error' : ''}}">
                    <label class="control-label" for="description">{{ __('strings.Description') }}</label>
                    <textarea type="text" class="form-control summernote"
                              name="description">{{old('description')}}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>

                             <div class="col-md-12 form-group text-right">
                               <button type="submit" class="btn btn-primary btn-lg"> {{ __('strings.Save') }}</button>
                             </div>
                           
                        </form>
                </div>
            </div>
        </div>
    </div>

@endsection

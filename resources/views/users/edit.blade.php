@extends('layouts.admin', ['title' => __('strings.edit') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="modal fade newModel" id="add_section" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="overflow: hidden">
                    <form method="post" action="#" enctype="multipart/form-data" id="add_section_store">
                        {{csrf_field()}}
                        <input type="hidden" class="form-control" name="user_id" value="{{  Auth::user()->id }}">
                        <input type="hidden" class="form-control" name="active" value="1">

                        <div class="col-md-6 col-xs-12 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                            <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                            <input type="text" class="form-control" name="name" value="{{old('name')}}">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="col-md-6 col-xs-12 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
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
                            <button type="submit" class="btn btn-primary btn-lg" id="add_section_submit"> <i class="fas fa-save"></i> {{ __('strings.Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="main-wrapper">
        <div class="row">
            <form method="post" action="{{  Request::is('admin/employees') || Request::is('admin/employees/*') ? route('employees.update', $user->id) : route('users.update', $user->id)}}" enctype="multipart/form-data"
                  id="edit_users">
                {{csrf_field()}}
                {{ method_field('PATCH') }}
                <input name="using" value="{{ Request::is('admin/employees') || Request::is('admin/employees/*') ? 1 : 2 }}" type="hidden">

                <div class="col-md-3">
                    <img src="{{$user->photo ? asset($user->photo->file) : asset('images/profile-placeholder.png') }}"
                         class="img-responsive" id="imguser">
                         @if($user->photo !=null)
                        <div class="col-md-12 form-group text-right">
                            @if(app()->getLocale()== 'ar')
                                <a onclick="return confirm('هل انتا متاكد من حذف الصوره ؟')" href="{{url('admin/employees/del/photo/'.$user->id)}}"><button type="button" class="btn btn-danger btn-lg">حذف</button></a>
                            @else
                                <a onclick="return confirm('Are you sure you want to delete the picture?')" href="{{url('admin/employees/del/photo/'.$user->id)}}"><button type="button" class="btn btn-danger btn-lg">Deleted</button></a>
                            @endif
                        </div>
                    @endif

                    <div class="col-md-12 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                        <label for="photo_id" class="control-label">{{ __('strings.Upload_photo') }}</label>
                        <input type="file" id="photo_id" name="photo_id" data-min-width="200" data-min-height="150">
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

                </div>
                <div class="col-md-9">


                    <div class="col-md-6 col-xs-12 form-group{{$errors->has('code') ? ' has-error' : ''}}">
                        <label class="control-label" for="code">{{ __('strings.Users_code') }}</label>
                        <input type="text" class="form-control" name="code" value="{{$user->code}}">
                        @if ($errors->has('code'))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('code') }}</strong>
                    </span>
                        @endif
                    </div>

                    <div class="col-md-6 col-xs-12 form-group{{$errors->has('name') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                        <input type="text" class="form-control" name="name" value="{{$user->name}}">
                        @if ($errors->has('name'))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                    </span>
                        @endif
                    </div>

                    <div class="col-md-6 col-xs-12 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                        <input type="text" class="form-control" name="name_en" value="{{$user->name_en}}">
                        @if ($errors->has('name_en  '))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                    </span>
                        @endif
                    </div>
                    <div class="col-md-6 col-xs-12 form-group{{$errors->has('phone_number') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="phone_number">{{ __('strings.Phone') }}</label>
                        <input type="text" class="form-control" name="phone_number" value="{{$user->phone_number}}">
                        @if ($errors->has('phone_number'))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
                    </span>
                        @endif
                    </div>

                    <div class="col-md-6 col-xs-12 form-group{{$errors->has('address') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="address">{{ __('strings.Address') }}</label>
                        <input type="text" class="form-control" name="address" value="{{$user->address}}">
                        @if ($errors->has('address'))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('address') }}</strong>
                    </span>
                        @endif
                    </div>

                    <div class="col-md-6 col-xs-12 form-group{{$errors->has('birthday') ? ' has-error' : ''}}">
                        <label class="control-label" for="birthday">{{ __('strings.Birthday') }}</label>
                        <input type="date" class="form-control" name="birthday" value="{{$user->birthday}}">
                        @if ($errors->has('birthday'))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('birthday') }}</strong>
                    </span>
                        @endif
                    </div>

                    <div class="col-md-6 col-xs-12 form-group{{$errors->has('email') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="email">{{ __('strings.Email') }}</label>
                        <input type="email" class="form-control" name="email" value="{{$user->email}}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                    </span>
                        @endif
                    </div>

                    <div class="col-md-6 col-xs-12 form-group{{$errors->has('is_active') ? ' has-error' : ''}}">
                        <label class="control-label" for="is_active">{{ __('strings.Status') }}</label>
                        <select class="form-control js-select" name="is_active">
                            @if($user->is_active==1)
                                <option value="1" selected>{{ __('strings.Active') }}</option>
                                <option value="0">{{ __('strings.Deactivate') }}</option>
                            @else
                                <option value="1">{{ __('strings.Active') }}</option>
                                <option value="0" selected>{{ __('strings.Deactivate') }}</option>
                            @endif
                        </select>
                    </div>

                    <div class="col-md-6 col-xs-12 form-group{{$errors->has('type') ? ' has-error' : ''}}">
                        <label class="control-label" for="type">{{ __('strings.Times') }}</label>
                        <select class="form-control js-select" name="type">
                            <option {{ $user->type == 1 ? 'selected' : '' }} value="1">{{ __('strings.FullTime') }}</option>
                            <option {{ $user->type == 2 ? 'selected' : '' }} value="2">{{ __('strings.PartTime') }}</option>
                        </select>
                    </div>

                    <div class="col-md-6 col-xs-12 form-group{{$errors->has('role_id') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="role_id">{{ __('strings.Role_users') }}</label>
                        <select class="form-control js-select" name="role_id">
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

                    <div class="col-md-6 col-xs-12 form-group{{$errors->has('section_id') ? ' has-error' : ''}}"><strong
                                class="text-danger">*</strong>
                        <label class="control-label" for="section_id">{{ __('strings.Section') }}</label>
                        <select class="form-control js-select" name="section_id" id="sections">
                            @foreach($sections as $section)
                                @if($user->section_id == $section->id)
                                    <option value="{{$section->id}}"
                                            selected>{{app()->getLocale() == 'ar' ? $section->name : $section->name_en}}</option>
                                @else
                                    <option value="{{$section->id}}">{{ app()->getLocale() == 'ar' ? $section->name : $section->name_en }}</option>
                                @endif
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-info btn-lg NewBtn btnclient" data-toggle="modal" data-target="#add_section"><i class="fas fa-plus"></i></button>
                    @if ($errors->has('section_id'))
                            <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('section_id') }}</strong>
                    </span>
                        @endif
                    </div>
                    <div class="col-md-8 col-xs-12 form-group{{$errors->has('shift_id') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                        <label class="control-label" for="shift">{{ __('strings.shifts') }}</label>
                    <select class="js-example-basic-multiple" name="shift_id[]" multiple="multiple" id="shift">

                      @foreach($shifts as $shift)

                      <option {{  $shift->selected==1 ?  'selected' : ''}} value="{{$shift->id}}" > {{ app()->getLocale() == 'ar' ? $shift->name : $shift->name_en }} </option>

                      @endforeach
                      </select>
                    </div>


                    <div class="col-md-12 form-group text-right">
                        <button type="submit" class="btn btn-primary btn-lg"> <i class="fas fa-save"></i> {{ __('strings.Save') }} </button>
                    <!--    <button type="button" class="btn btn-primary btn-lg" onclick="show_time()"> <i class="fas fa-plus" ></i> {{ __('strings.show') }} </button>-->
                    <!--</div>-->

                </div>
            </form>
           
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    
            <script src="{{asset('js/jquery.checkImageSize.min.js')}}"></script>
    <script> 
         $("input[type='file']").checkImageSize({
              minWidth: $(this).data('min-width'),
              minHeight: $(this).data('min-height'),
            showError:true,
            ignoreError:false
        });
    </script>
    <script>
        $(".js-select").select2();

        $('#add_section_submit').click(function() {
            $("#add_section_store").ajaxForm({
                url: '{{ url('admin/ajax/add_section') }}', type: 'post',
                success: function (response) {
                    $('#add_section').modal('toggle');

                    $("#sections").append("<option selected value='" + response.data.id + "'>" + @if(app()->getLocale() == 'ar') response.data.name
                    @else response.data.name_en @endif + "</option>"
                );
                },
                error: function (response) {
                    alert("Please check your entry date again");
                }
            })
        });
        function readURL(input) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
              $('#imguser').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
          }
        }
        
        $("#photo_id").change(function() {
          readURL(this);
        });
    </script>
@endsection
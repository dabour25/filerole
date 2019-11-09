@extends('layouts.admin', ['title' => __('strings.Customers_edit') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')


    <div id="main-wrapper">
        <div class="row">
            <form method="post" action="{{route('customers.update', $customer->id)}}" enctype="multipart/form-data" id="edit">
                <input type="hidden" class="form-control" name="user_id" value="{{  Auth::user()->id }}">
                {{csrf_field()}}
                {{ method_field('PATCH') }}
                <div class="col-md-3">
                    <img src="{{$customer->photo ? asset($customer->photo->file) : asset('images/profile-placeholder.png') }}" class="img-responsive" id="accountimg">
                      @if($customer->photo_id)
                        <div class="col-md-12 form-group text-right">
                            @if(app()->getLocale()== 'ar')
                                <a onclick="return confirm('هل انتا متاكد من حذف الصوره ؟')" href="{{url('admin/customer/del/photo/'.$customer->id)}}"><button type="button" class="btn btn-danger btn-lg">حذف</button></a>
                            @else
                                <a onclick="return confirm('Are you sure you want to delete the picture?')" href="{{url('admin/customer/del/photo/'.$customer->id)}}"><button type="button" class="btn btn-danger btn-lg">Deleted</button></a>
                            @endif
                        </div>
                    @endif
                    <div class="col-md-12 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                        <label for="photo_id" class="control-label">{{ __('strings.Upload_photo') }}</label>
                        <input type="file" id="photo_id" name="photo_id" onchange="readURL(this);" data-min-width="300" data-min-height="300" >
                           <span class="help-block">
                                    <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 300*300</strong>
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
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <div class="col-md-12">
                                <h4 class="panel-title">{{ __('strings.Customers_edit') }}</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                           
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

                                <div class="col-md-3 form-group{{$errors->has('phone_number') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="phone_number">{{ __('strings.Phone') }}</label>
                                    <input type="text" class="form-control" name="phone_number" value="{{$customer->phone_number}}" readonly>
                                    @if ($errors->has('phone_number'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-3 form-group{{$errors->has('signs') ? ' has-error' : ''}}">
                                <label class="control-label">@lang('strings.sings')</label>
                                    <label class="switch">
                                       @if($customer->Notifications_phone==1)   
                                <input name="Notifications_phone" type="checkbox"  value='1'  id="checkbox3" checked >
                                @else
                                 <input name="Notifications_phone" type="checkbox"  value='0'   id="checkbox3"  >
                                 @endif
                                        <span class="slider round"></span>
                                    </label>

                            </div>

                                <div class="col-md-3 form-group{{$errors->has('email') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="email">{{ __('strings.Email') }}</label>
                                    <input type="email" class="form-control" name="email" value="{{$customer->email}}" readonly>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                 <div class="col-md-3 form-group{{$errors->has('signs') ? ' has-error' : ''}}">
                                <label class="control-label">@lang('strings.sings')</label>
                               
                                <label class="switch">
                                     @if($customer->Notifications_email==1)
                                    <input name="Notifications_email" type="checkbox"
                                        value='1'   id="checkbox4" checked >
                                    @else 
                                      <input name="Notifications_email" type="checkbox"
                                      value='0'     id="checkbox4">
                                 @endif           
                                    <span class="slider round"></span>
                                </label>
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

                                <div class="col-md-6 form-group{{$errors->has('address') ? ' has-error' : ''}}">
                                    <label class="control-label" for="address">{{ __('strings.Address') }}</label>
                                    <input type="text" class="form-control" name="address" value="{{$customer->address}}">
                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                
                            <div class="col-md-6 form-group{{$errors->has('signs') ? ' has-error' : ''}}">
                                <label>{{__('strings.country')}} <strong class="text-danger">*</strong></label>
                                <select required name="country_id" class="select-search">
                                    @foreach($countries as $country)
                                        
                                        <option   {{$customer->country_id== $country->id ? 'selected' : ''}}   value="{{$country->id}}">{{ app()->getLocale() == 'ar' ? $country->name  : $country->name_en  }}</option>
                                        @endforeach
                                </select>
                            </div>
                              <div class="col-md-6 form-group{{$errors->has('signs') ? ' has-error' : ''}}">
                                <label>{{__('strings.city')}} <strong class="text-danger">*</strong></label>
                                <input type="text" class="form-control" placeholder="{{__('strings.city')}}" required name="city" value="{{$customer->city }}">
                            </div>

                                <div class="col-md-6 form-group{{$errors->has('birth_date') ? ' has-error' : ''}}">
                                <label class="control-label" for="birth_date"> {{ __('strings.Birthday') }}</label>
                                 <input type="date" class="form-control" name="birth_date"  value="{{$customer->birth_date}}" >
                                @if ($errors->has('birth_date'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('birth_date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('marriage_date') ? ' has-error' : ''}}">
                                <label class="control-label" for="marriage_date">{{ __('strings.marriage_date') }} </label>
                                <input type="date" class="form-control" name="marriage_date" value="{{$customer->marriage_date}}">
                                @if ($errors->has('marriage_date'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('marriage_date') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                            
                            
                            
                            <div class="col-md-6 form-group{{$errors->has('hear_about_us') ? ' has-error' : ''}}">
                                <label class="control-label" for="hear_about_us">من اين سمعت عنا</label>
                                <select name="hear_about_us"  class="select-search">
                                    
                									<option {{$customer->hear_about_us == 'facebook'?selected :'' }}  value"facebook">facebook</option>
                					<option {{$customer->hear_about_us == 'friend'?selected :'' }}   value="friend" >friend</option>
                					<option {{$customer->hear_about_us == 'instgram'?selected :'' }}  value="instgram">instgram</option>
                                   <option {{$customer->hear_about_us == 'surf net'?selected :'' }}  value="surf net">surf net</option>
                                   <option {{$customer->hear_about_us == 'other'?selected :'' }} value="other">other</option>
                								</select>
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('hear_about_us') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @php
                            $org_login=\App\org::where('id',Auth::user()->org_id)->first();
                            $show_customer_data=\App\ActivityLabelSetup::where(['activity_id'=>$org_login->activity_id,'type'=>'person_id'])->first();
                            @endphp
                            @if($show_customer_data)
                             <div class="col-md-6 form-group{{$errors->has('person_idtype') ? ' has-error' : ''}}">
                                    <label class="control-label" for="address">{{ __('strings.person_type') }}</label>
                                    <input type="text" class="form-control" name="person_idtype" value="{{$customer->person_idtype}}">
                                    @if ($errors->has('person_idtype'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('person_idtype') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                 <div class="col-md-6 form-group{{$errors->has('person_id') ? ' has-error' : ''}}">
                                    <label class="control-label" for="person_id">{{ __('strings.person_id') }}</label>
                                    <input type="text" class="form-control" name="person_id" value="{{$customer->person_id}}">
                                    @if ($errors->has('person_id'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('person_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group{{$errors->has('person_image') ? ' has-error' : ''}}">
                                    <label class="control-label" for="person_id">{{ __('strings.person_image') }}</label>
                                    <input type="file" class="form-control" name="person_image" value="" onchange="readURL_2(this);" data-min-width="300" data-min-height="200">
                                    <span class="help-block">
                                    <strong class="text-danger" style="font-size:12px;"> ابعاد الصوره لا تقل عن 300*200</strong>
                                </span>
                                <hr>
                                    @if ($errors->has('person_image'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('person_image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group{{$errors->has('person_image') ? ' has-error' : ''}}">
                                                    <img src="{{$customer->person_image ? asset(\App\Photo::find($customer->person_image)->file) : asset('images/profile-placeholder.png') }}"
                                                       style="width: 300px;height: 200px;" id="set2">
                                                </div>
                               @endif
                               <br>
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
                                    <button type="submit" class="btn btn-primary btn-lg"> <i class="fas fa-save"></i> {{ __('strings.Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
        function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#accountimg')
                    .attr('src', e.target.result)
            };

            reader.readAsDataURL(input.files[0]);
            }
        };
        
              function readURL_2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
                
            reader.onload = function (e) {
                $('#set2')
                    .attr('src', e.target.result)
            };

            reader.readAsDataURL(input.files[0]);
            }
        };
    </script>
@endsection
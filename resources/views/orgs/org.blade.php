@extends('layouts.admin', ['title' =>  __('strings.org_edit')])
@section('content')
    <!--<div class="page-title">-->
    <!--    <h3>{{ __('strings.org_edit') }}</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>-->
    <!--            <li><a href="{{ ('') }}">@lang('strings.org')</a></li>-->
    <!--            <li class="active">@lang('strings.org_edit')</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->
    <div id="main-wrapper">
        <div class="row">

            <div class="col-md-9">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">@lang('strings.org_edit')</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="">

                            <form method="post" action="{{ url('admin/orgs/update',$org->id) }}"
                                  enctype="multipart/form-data" id="edit">
                                {{csrf_field()}}
                                <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                                     <label class="control-label" for="name">@lang('strings.English_name')</label>
                                    <input type="text" class="form-control" name="name_en" value="{{$org->name_en}}">
                                    @if ($errors->has('name_en'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}">
                                    <label class="control-label" for="name"> @lang('strings.Arabic_name') </label>
                                    <input type="text" class="form-control" name="name" value="{{$org->name}}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <div class="col-md-6 form-group{{$errors->has('about_us') ? ' has-error' : ''}}">
                                    <label class="control-label" for="about_us">@lang('strings.about_org')</label>
                                    <textarea type="text" class="summernote"
                                              name="about_us">{{ app()->getLocale() == 'ar' ? $org->about_us  : $org->aboutus_en  }}</textarea>
                                    @if ($errors->has('about_us'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('about_us') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group{{$errors->has('description') ? ' has-error' : ''}}">
                                    
                                    <label class="control-label" for="description">@lang('strings.Description')</label>
                                    <textarea type="text" class="summernote"
                                              name="description">{{ app()->getLocale() == 'ar' ? $org->description  : $org->description_en  }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <div class="col-md-6 form-group{{$errors->has('phone') ? ' has-error' : ''}}">
                                    <label class="control-label" for="phone">@lang('strings.Phone')</label>
                                    <input type="text" class="form-control" name="phone" value="{{$org->phone}}">
                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>




                	@if($org->attendance_flag)
                   <div class="col-md-6 form-group{{$errors->has('attendance_start_day') ? ' has-error' : ''}}" style="display:block;">
                                    <label class="control-label" for="attendance_start_day">@lang('strings.day_calcuate_attenden')</label>
                                    <input type="text" class="form-control" name="attendance_start_day" value="{{$org->attendance_start_day}}">
                                    @if ($errors->has('attendance_start_day'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('attendance_start_day') }}</strong>
                                        </span>
                                    @endif
                                </div>
								@else
						<div class="col-md-6 form-group{{$errors->has('attendance_start_day') ? ' has-error' : ''}}" style="display:none;">
                                    <label class="control-label" for="attendance_start_day">@lang('strings.mobile_one') </label>
                                    <input type="text" class="form-control" name="attendance_start_day" value="{{$org->attendance_start_day}}">
                                    @if ($errors->has('attendance_start_day'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('attendance_start_day') }}</strong>
                                        </span>
                                    @endif
                                </div>
                              @endif



                                <div class="col-md-6 form-group{{$errors->has('address') ? ' has-error' : ''}}">
                                    <label class="control-label" for="address">@lang('strings.Address')</label>
                                    <input type="text" class="form-control" name="address" value="{{$org->address}}">
                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <div class="col-md-6 form-group{{$errors->has('mobile2') ? ' has-error' : ''}}">
                                    <label class="control-label" for="mobile2">@lang('strings.mobile_two')</label>
                                    <input type="text" class="form-control" name="mobile2" value="{{$org->mobile2}}">
                                    @if ($errors->has('mobile2'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('mobile2') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <div class="col-md-6 form-group{{$errors->has('mobile1') ? ' has-error' : ''}}">
                                    <label class="control-label" for="mobile1">@lang('strings.mobile_one') </label>
                                    <input type="text" class="form-control" name="mobile1" value="{{$org->mobile1}}">
                                    @if ($errors->has('mobile1'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('mobile1') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('email') ? ' has-error' : ''}}">
                                    <label class="control-label" for="email">@lang('strings.email_support') </label>
                                    <input type="text" class="form-control" name="email" value="{{$org->email}}">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('mobile1') }}</strong>
                                        </span>
                                    @endif
                                </div>
								@if($org->attendance_flag)
                   <div class="col-md-6 form-group{{$errors->has('attendance_start_day') ? ' has-error' : ''}}" style="display:block;">
                                    <label class="control-label" for="attendance_start_day">@lang('strings.day_calcuate_attenden')</label>
                                    <input type="text" class="form-control" name="attendance_start_day" value="{{$org->attendance_start_day}}">
                                    @if ($errors->has('attendance_start_day'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('attendance_start_day') }}</strong>
                                        </span>
                                    @endif
                                </div>
								@else
						<div class="col-md-6 form-group{{$errors->has('attendance_start_day') ? ' has-error' : ''}}" style="display:none;">
                                    <label class="control-label" for="attendance_start_day">@lang('strings.mobile_one') </label>
                                    <input type="text" class="form-control" name="attendance_start_day" value="{{$org->attendance_start_day}}">
                                    @if ($errors->has('attendance_start_day'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('attendance_start_day') }}</strong>
                                        </span>
                                    @endif
                                </div>
                              @endif

                                <div class="col-md-6 form-group{{$errors->has('currency') ? ' has-error' : ''}}">
                                    <label class="control-label" for="currency">@lang('strings.currency')</label>
									
                                    <select class="form-control" name="currency">
                                     @php	
	                                $currency_org=App\Currency::where('id','=',$org->currency)->first();
									@endphp   
			              <option value="{{ $org->currency}}">{{ app()->getLocale() == 'ar' ? $currency_org->name  : $currency_org->name_en  }}</option>
		                            @php	
	                                $currencys=	App\Currency::get();
									@endphp
                                     @foreach($currencys as $currency)
                                    <option value="{{ $currency->id}}">{{ app()->getLocale() == 'ar' ? $currency->name  : $currency->name_en  }}</option>
                                        @endforeach    
                                    </select>
                                    @if ($errors->has('currency'))
                                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('currency') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="col-md-6 form-group{{$errors->has('twitter') ? ' has-error' : ''}}">
                                    <label class="control-label" for="twitter">@lang('strings.twitter')</label>
                                    <input type="text" class="form-control" name="twitter" value="{{$org->twitter}}">
                                    @if ($errors->has('twitter'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('twitter') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('email_crm') ? ' has-error' : ''}}">
                                    <strong class="text-danger">*</strong>
                                    <label class="control-label" for="email_crm">@lang('strings.email_customer') </label>
                                    <input type="text" class="form-control" name="email_crm"
                                           value="{{$org->email_crm}}">
                                    @if ($errors->has('email_crm'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('email_crm') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <div class="col-md-6 form-group{{$errors->has('facebook') ? ' has-error' : ''}}">
                                     <label class="control-label" for="facebook">@lang('strings.facebook')</label>
                                    <input type="text" class="form-control" name="facebook" value="{{$org->facebook}}">
                                    @if ($errors->has('facebook'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('facebook') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group{{$errors->has('instgram') ? ' has-error' : ''}}">
                                    <label class="control-label" for="instgram">@lang('strings.instgram')</label>
                                    <input type="text" class="form-control" name="instgram" value="{{$org->instgram}}">
                                    @if ($errors->has('instgram'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('instgram') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <table>
                                    <tr>
                                        <td style="padding-left:200px"  >
                                            <div  style="float:right">{{$errors->has('front_image') ? ' has-error' : ''}} <strong
                                                    class="text-danger"></strong>
                                            <label for="front_image" class="control-label">@lang('strings.log_img')</label>
                                            <input type="file" id="front_image" name="front_image">
                                            @if ($errors->has('front_image'))
                                                <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('front_image') }}</strong>
                                    </span>
                            @endif
                        </div>
                        </td>
                        <td style="padding-left:200px">
                            <div > {{$errors->has('image_id') ? ' has-error' : ''}} <strong  class="text-danger"></strong>
                                  
                            <label for="image_id" class="control-label">@lang('strings.org_img')</label>
                            <input type="file" id="image_id" name="image_id">
                            @if ($errors->has('image_id'))
                                <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('image_id') }}</strong>
                                    </span>
                        @endif
                    </div>
                    </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left:280px" >
                            <div style="width:100%; ">
                                <img src="{{$org->front ? asset($org->front->file) : asset('images/profile-placeholder.png') }}"
                                     class="img-responsive">
                            </div>
                        </td>
                        <td style="padding-left:280px">
                            <div style="width:100%; ">
                                <img src="{{$org->photo ? asset($org->photo->file) : asset('images/profile-placeholder.png') }}"
                                     class="img-responsive">
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
					<tr>
                        <td></td>
                        <td></td>
                    </tr>
					
                    <tr>
                        <td style="padding-left:200px" >
                            <div> {{$errors->has('location_map') ? ' has-error' : ''}} <strong
                                    class="text-danger"></strong>
                            <label for="location_map" class="control-label">@lang('strings.img_map')</label>
                            <input type="file" id="location_map" name="location_map">
                            @if ($errors->has('location_map'))
                                <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('location_map') }}</strong>
                                    </span>
                    @endif
                </div>
                </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
				
                <tr>
                    <td style="padding-left:280px">
                        <div style="width:100%; ">
                            <img src="{{$org->map ? asset($org->map->file) : asset('images/profile-placeholder.png') }}"
                                 class="img-responsive">
                        </div>
                    </td>
                </tr>
                </table>
                </br>

                <div class="col-md-12 form-group text-right">
                    <button type="submit" class="btn btn-primary btn-lg">@lang('strings.Save')</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>




@endsection
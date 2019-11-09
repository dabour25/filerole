@extends('layouts.admin', ['title' => __('strings.edit_allows')])

@section('content')


    <!--<div class="page-title">-->
    <!--    <h3>@lang('strings.edit_allows')</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>-->
    <!--           <li><a href="../">@lang('strings.allow_dedcted')</a></li>-->
    <!--            <li><a href="../savepay_type">@lang('strings.add_allows')</a></li>-->
    <!--            <li class="active">@lang('strings.edit_allows')</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">

            <div class="col-md-8">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">@lang('strings.edit_facility')</h4>
                    </div>
                    <div class="panel-body">
                      <form method="post" action="{{url('admin/update_category',$Facility->id)}}" enctype="multipart/form-data">
                          {{csrf_field()}}
                          <div class="col-md-6 form-group{{$errors->has('category_type_id') ? ' has-error' : ''}}">
                           <label  class="text-center">@lang('strings.Type')</label>
                           <select class="New_select" name="category_type_id" id="category_type_id">
                             
                             <option {{ $Facility->category_type_id == $types->id ?'selected':'' }} value="{{$types->id}}" >{{app()->getLocale()== 'ar' ? $types->name : $types->name_en }}</option>
                             <option value="{{$types->id}}" >{{app()->getLocale()== 'ar' ? $types->name : $types->name_en }}</option>
                              </select>
                                  <!-- <button type="button" class="btn btn-info btn-lg NewBtn btnclient" data-toggle="modal" data-target="#addclient"><i class="fas fa-plus"></i></button> -->
                                  @if ($errors->has('category_type_id'))
                                      <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('category_type_id') }}</strong>
                                  </span>
                                  @endif
                          </div>
                          <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                              <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                              <input type="text" class="form-control" name="name" id="name" value="{{$Facility->name}}" required="required">
                              @if ($errors->has('name'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                  </span>
                              @endif
                          </div>

                          <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                              <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                              <input type="text" class="form-control" name="name_en" id="name_en" value="{{$Facility->name_en}}" required="required">
                              @if ($errors->has('name_en'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                  </span>
                              @endif
                          </div>

                          <div class="col-md-6 form-group{{$errors->has('description') ? ' has-error' : ''}}">
                              <label class="control-label" for="description_ar">{{ __('strings.description_ar') }}</label>
                              <input type="text" class="form-control" name="description" id="description" value="{{$Facility->description}}">
                              @if ($errors->has('description'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                  </span>
                              @endif
                          </div>
                          <div class="col-md-6 form-group{{$errors->has('description_en') ? ' has-error' : ''}}">
                              <label class="control-label" for="description_en">{{ __('strings.description_en') }}</label>
                              <input type="text" class="form-control" name="description_en" id="description_en" value="{{$Facility->description_en}}">
                              @if ($errors->has('description_en'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                  </span>
                              @endif
                          </div>

                          <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}">
                           <label class="control-label" for="active">{{ __('strings.Status') }}</label>
                           <select class="form-control" name="active">
                             <option {{$Facility->active==1?'selected':''}} value="1">{{ __('strings.Active') }}</option>
                             <option {{$Facility->active==0?'selected':''}} value="0">{{ __('strings.Deactivate') }}</option>
                           </select>
                           @if ($errors->has('Status'))
                               <span class="help-block">
                                   <strong class="text-danger">{{ $errors->first('Status') }}</strong>
                               </span>
                           @endif
                          </div>
                          <div class="col-md-6 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                          <label for="photo_id"  class="control-label">@lang('strings.Photo')</label>
                            <input type="file" id="photo_id"name="photo_id" >
                             @if ($errors->has('photo_id'))
                                  <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('image') }}</strong>
                                  </span>
                            @endif
                        </div>
                        @if($Facility->photo_id)
                        <div class="col-md-3">
                            <img src="{{$Facility->photo ? asset($Facility->photo->file) : asset('images/profile-placeholder.png') }}" class="img-responsive">
                        </div>
                      @endif
                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg"> {{ __('strings.Save') }} </button>
                            </div>
                        </form>




                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

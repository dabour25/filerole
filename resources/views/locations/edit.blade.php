@extends('layouts.admin', ['title' => __('strings.edit') ])

@section('content')

    <!--<div class="page-title">-->
    <!--    <h3> {{ $type == 1 ? __('strings.Categories_type_edit') : __('strings.Categories_type_service_edit') }} </h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>-->
    <!--            <li><a href="{{ route('categories_type.index') }}">{{ __('strings.categories_types') }}</a></li>-->
    <!--            <li class="active">{{ $type == 1 ? __('strings.Categories_type_edit') : __('strings.Categories_type_service_edit') }}</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">{{ __('strings.edit') }}</h4>
                </div>
                <div class="panel-body">
                  <form method="post" action="{{url('admin/update_destinations',$destination->id)}}" enctype="multipart/form-data" files ='true'>
                      {{csrf_field()}}
                      <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                          <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                          <input type="text" class="form-control" name="name" value="{{$destination->name}}" required>
                          @if ($errors->has('name'))
                              <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('name') }}</strong>
                              </span>
                          @endif
                      </div>

                      <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                          <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                          <input type="text" class="form-control" name="name_en" value="{{$destination->name_en}}" required>
                          @if ($errors->has('name_en'))
                              <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                              </span>
                          @endif
                      </div>

                      <div class="col-md-6 form-group{{$errors->has('description') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                          <label class="control-label" for="description_ar">{{ __('strings.description_ar') }}</label>
                          <input type="text" class="form-control" name="description" value="{{$destination->description}}">
                          @if ($errors->has('description'))
                              <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('description') }}</strong>
                              </span>
                          @endif
                      </div>


                      <div class="col-md-6 form-group{{$errors->has('description_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                          <label class="control-label" for="address">{{ __('strings.description_en') }}</label>
                          <input type="text" class="form-control" name="description_en" value="{{$destination->description_en}}" >
                          @if ($errors->has('description_en'))
                              <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('description_en') }}</strong>
                              </span>
                          @endif
                      </div>

                      <div class="col-md-6 form-group{{$errors->has('longitude') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                          <label class="control-label" for="longitude">{{ __('strings.line_ve') }}</label>
                          <input type="text" class="form-control" name="longitude" id="" value="{{$destination->longitude}}" required>
                          @if ($errors->has('longitude'))
                              <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('longitude') }}</strong>
                              </span>
                          @endif
                      </div>
                      <div class="col-md-6 form-group{{$errors->has('latitude') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                          <label class="control-label" for="latitude">{{ __('strings.line_he') }}</label>
                          <input type="text" class="form-control" name="latitude" id="latitude" value="{{$destination->latitude}}" required>
                          @if ($errors->has('latitude'))
                              <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('latitude') }}</strong>
                              </span>
                          @endif
                      </div>
                      <div class="col-md-6 form-group{{$errors->has('price_start') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                          <label class="control-label" for="price_start">{{ __('strings.start_price') }}</label>
                          <input type="text" class="form-control" name="price_start" id="price_start" value="{{$destination->price_start}}" required>
                          @if ($errors->has('price_start'))
                              <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('price_start') }}</strong>
                              </span>
                          @endif
                      </div>
                     <div class="col-md-6 form-group{{$errors->has('currency_id') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                       <div class="form-group">
                       <label class="control-label" for="currency_id">{{ __('strings.currency') }}</label>
                         <div class="form-field">
                           <i class="icon icon-arrow-down3"></i>
                           <select name="currency_id" id="currency_id" class="form-control js-select">
                             <option value="{{ $destination->currency_id}}">{{ app()->getLocale() == 'ar' ? \App\Currency::findOrFail($destination->currency_id)->name  : \App\Currency::findOrFail($destination->currency_id)->name_en  }}</option>
                             @foreach($currencies as $currency)
                             <option value="{{$currency->id}}">{{ app()->getLocale()== 'ar' ? $currency->name :$currency->name_en}}</option>
                             @endforeach
                           </select>
                         </div>
                       </div>
                     </div>
                      <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}">
                       <label class="control-label" for="active">{{ __('strings.Status') }}</label>
                        <select class="form-control" name="active">
                           <option {{$destination->active==1?'selected':''}} value="1">{{ __('strings.Active') }}</option>
                           <option {{$destination->active==0?'selected':''}} value="0">{{ __('strings.Deactivate') }}</option>
                       </select>
                      </div>
                      <div class="col-md-6 form-group{{$errors->has('infrontpage') ? ' has-error' : ''}}">
                       <label class="control-label" for="infrontpage">{{ __('strings.front_page') }}</label>
                       <select class="form-control" name="infrontpage">
                           <option   {{$destination->infrontpage==1?'selected':''}} value="1">{{ __('strings.Yes') }}</option>
                           <option  {{$destination->infrontpage==0?'selected':''}}  value="0">{{ __('strings.No') }}</option>

                       </select>
                   </div>
                   <div class="col-md-6 form-group{{$errors->has('video_id') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                       <label class="control-label" for="video">{{ __('strings.video') }}</label>
                       <input type="file" class="form-control" name="video_id" id="video_id" >
                       @if ($errors->has('video_id'))
                           <span class="help-block">
                               <strong class="text-danger">{{ $errors->first('video') }}</strong>
                           </span>
                       @endif
                   </div>
                   @if($destination->video_id)
                   <div class="col-md-3">
                       <video width="263" src="{{ \App\Video::findOrFail($destination->video_id)->file  }}" controls></video>
                   </div>
                   @endif
                   <div class="col-md-6 form-group{{$errors->has('image') ? ' has-error' : ''}}">
                   <strong class="text-danger"></strong>
                   <label for="image"  class="control-label">@lang('strings.Photo')</label>
                    <input type="file" id="image"name="image" >
                    @if ($errors->has('image'))
                    <span class="help-block">
                   <strong class="text-danger">{{ $errors->first('image') }}</strong>
                    </span>
                    @endif
                  </div>
                  <div class="col-md-3">
                      <img src="{{$destination->photo ? asset($destination->photo->file) : asset('images/profile-placeholder.png') }}" class="img-responsive">
                  </div>
                      <div class="col-md-12 form-group text-right">
                          <button type="submit" class="btn btn-primary btn-lg">{{ __('strings.Save') }}</button>
                      </div>
                  </form>
                </div>
        </div>
    </div>

@endsection

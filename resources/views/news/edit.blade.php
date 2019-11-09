@extends('layouts.admin', ['title' =>   __('strings.news_edit')])
@section('content')
    <!--<div class="page-title">-->
    <!--    <h3>@lang('strings.news_edit')</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>-->
    <!--            <li><a href="{{ route('customers.index') }}">@lang('strings.news')</a></li>-->
    <!--            <li class="active">@lang('strings.news_edit')</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->
 <div id="main-wrapper">
        <div class="row">
            <div class="col-md-3">
                <img src="{{$new->photo ? asset($new->photo->file) : asset('images/profile-placeholder.png') }}" class="img-responsive">
            </div>
            <div class="col-md-9">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">@lang('strings.news_edit')</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="">
 <form method="post" action="update" enctype="multipart/form-data">
    {!! csrf_field() !!}
	
	<div class="col-md-6 form-group{{$errors->has('news_title_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="news_title_en">@lang('strings.news_title_en')</label>
                                <input type="text" class="form-control" name="news_title_en" value="{{$new->news_title_en}}">
                                @if ($errors->has('news_title_en'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('news_title_en') }}</strong>
                                    </span>
                                @endif
                            </div>
	<div class="col-md-6 form-group{{$errors->has('news_title') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="news_title">@lang('strings.news_title_ar')</label>
                    <input type="text" class="form-control" name="news_title" value="{{$new->news_title}}">
                                    @if ($errors->has('news_title'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('news_title') }}</strong>
                                        </span>
                                    @endif
            </div>
			
	<div class="col-md-12 form-group{{$errors->has('news_desc') ? ' has-error' : ''}}">
                                <label class="control-label" for="news_desc">@lang('strings.news_desc')</label>
                                <textarea type="text" class="summernote" name="news_desc">{{ app()->getLocale() == 'ar' ? $new->news_desc  : $new->news_desc_en  }}</textarea>
                                @if ($errors->has('news_desc'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('news_desc') }}</strong>
                                    </span>
                                @endif
                            </div>		
			
			
  
    <div class="col-md-6 form-group{{$errors->has('news_date') ? ' has-error' : ''}}">
                                    <label class="control-label" for="news_date">@lang('strings.news_date')</label>
                                    <input type="date" class="form-control" name="news_date" value="{{$new->news_date}}">
                                    @if ($errors->has('news_date'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('news_date') }}</strong>
                                        </span>
                                    @endif
                                </div>

   
	 <div class="col-md-6 form-group{{$errors->has('image_id') ? ' has-error' : ''}}"> 
                                   <label for="image_id" class="control-label" style="display:block"   >@lang('strings.news_img')</label>
                                    <input type="file" id="image_id" name="image_id" style="float:right">
                                    @if ($errors->has('image_id'))
                                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('image_id') }}</strong>
                                    </span>
                                    @endif
                            </div>
   
   
	<div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}">
                                    <label class="control-label" for="active">@lang('strings.Status')</label>
                                    <select class="form-control" name="active">
                                        @if($new->active==1)
                                            <option value="1" selected>@lang('strings.Active')</option>
                                            <option value="0">@lang('strings.Deactivate')</option>
                                        @else
                                            <option value="1">@lang('strings.Active')</option>
                                            <option value="0" selected>@lang('strings.Deactivate')</option>
                                        @endif
                                    </select>
                   </div>
	
	
	
	
    
          <div class="col-md-12 form-group text-right">
                                    <button type="submit" class="btn btn-primary btn-lg">@lang('strings.edit')</button>
                                </div>
         
</form>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  
@endsection

@extends('layouts.admin', ['title' =>__('strings.add_news')])

@section('content')

    <!--<div class="page-title">-->
    <!--    <h3> @lang('strings.add_news')</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>-->
    <!--            <li><a href="{{ route('customers.index') }}">@lang('strings.news')</a></li>-->
    <!--            <li class="active">@lang('strings.add_news')</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">@lang('strings.add_news')</h4>
                        </div>
                    </div>
                    <div class="panel-body">
					
 <form method="post" action="savenew" enctype="multipart/form-data">
    {!! csrf_field() !!}
	
	
	
	<div class="col-md-6 form-group{{$errors->has('news_title_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="news_title_en">@lang('strings.news_title_en')</label>
                                <input type="text" class="form-control" name="news_title_en" value="{{old('news_title_en')}}">
                                @if ($errors->has('news_title_en'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('news_title_en') }}</strong>
                                    </span>
                                @endif
                            </div>
   
   <div class="col-md-6 form-group{{$errors->has('news_title') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="news_title">@lang('strings.news_title_ar') </label>
                                <input type="text" class="form-control" name="news_title" value="{{old('news_title')}}">
                                @if ($errors->has('news_title'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('news_title') }}</strong>
                                    </span>
                                @endif
                            </div>
   
   <div class="col-md-12 form-group{{$errors->has('news_desc') ? ' has-error' : ''}}">
                                <label class="control-label" for="news_desc">@lang('strings.news_desc')</label>
                                <textarea type="text" class="summernote" name="news_desc">{{old('news_desc')}}</textarea>
                                @if ($errors->has('news_desc'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('news_desc') }}</strong>
                                    </span>
                                @endif
                            </div>
   
   <div class="col-md-6 form-group{{$errors->has('news_date') ? ' has-error' : ''}}">
                                    <label class="control-label" for="news_date">@lang('strings.news_date')</label>
                                    <input type="date" class="form-control" name="news_date" value="{{old('news_date', date('Y-m-d'))}}">
                                    @if ($errors->has('news_date'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('news_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
   
   <div class="col-md-6 form-group{{$errors->has('image_id') ? ' has-error' : ''}}"> 
                                    <label for="image_id" class="control-label" style="display:block"   >@lang('strings.news_img')<strong class="text-danger">*</strong></label>
                                    <input type="file" id="image_id" name="image_id" style="float:right">
                                    @if ($errors->has('image_id'))
                                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('image_id') }}</strong>
                                    </span>
                                    @endif
                            </div>
   
   
   
   
	 <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="active">@lang('strings.Status')</label>
                                <select class="form-control" name="active">
                                    <option value="1">@lang('strings.Active')</option>
                                    <option value="0">@lang('strings.Deactivate')</option>
                                </select>
                                @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('active') }}</strong>
                                    </span>
                                @endif
                            </div>

	
   
   
           <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">@lang('strings.Save')</button>
                            </div>
          
		  
</form>
 </div>  
 </div></div>  </div></div>
@stop
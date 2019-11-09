@extends('layouts.admin', ['title' =>   __('strings.org_edit')])
@section('content')
    <div class="page-title">
        <h3>{{ __('strings.org_edit') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>
                <li><a href="{{ ('') }}">@lang('strings.org')</a></li>
                <li class="active">@lang('strings.org_edit')</li>
            </ol>
        </div>
    </div>
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
                           @foreach($orgs as $org)
                                <div class="col-md-6 form-group{{$errors->has('description') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                   <label class="control-label" for="about_us">@lang('strings.Description_org')</label>
                        <textarea disabled type="text"  rows="5" cols="51" style="background-color:white"   name="description">{{ app()->getLocale() == 'ar' ? strip_tags(htmlspecialchars_decode( $org->description))  :strip_tags(htmlspecialchars_decode( $org->description_en))  }}</textarea>
                                     @if ($errors->has('description'))  
                                            <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="name">@lang('strings.Arabic_name')</label>
                                    <input type="text" class="form-control" name="name" value="{{$org->name}}" readonly>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                
								 
								

                                <div class="col-md-6 form-group{{$errors->has('phone') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="phone">@lang('strings.Phone')</label>
                                    <input type="text" class="form-control" name="phone" value="{{$org->phone}}" readonly>
                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                          <div class="col-md-6 form-group{{$errors->has('about_us') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="about_us">@lang('strings.about_org')</label>
             <textarea disabled type="text"  rows="5" cols="51" style="background-color: white"   name="about_us">{{ app()->getLocale() == 'ar' ? strip_tags(htmlspecialchars_decode( $org->about_us))  : strip_tags(htmlspecialchars_decode($org->aboutus_en))  }}</textarea>
                                     @if ($errors->has('about_us'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('about_us') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('address') ? ' has-error' : ''}}">
                                    <label class="control-label" for="address">@lang('strings.Address')</label>
                                    <input type="text" class="form-control" name="address" value="{{$org->address}}" readonly>
                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                

                                

                               
                                <div class="col-md-12 form-group text-right">
                                   
									 <a href="orgs/{{ $org->id }}/edit" class="btn btn-primary btn-lg">@lang('strings.edit') </a>
                                </div>
                          </div> 
</div>
						   
                        </div>
                    </div>
                </div>
            @endforeach
	
	
@endsection
@extends('front.index_layout')

@section('content')

   <div id="page_header" class="page-subheader page-subheader-bg">

        <!-- Sub-Header content wrapper -->
        <div class="ph-content-wrap d-flex">
            <div class="container align-self-center">
                <div class="row">

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="subheader-titles">
                            <h2 class="subheader-maintitle">
                              @lang('strings.peronal_profile')
                            </h2>

                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <ul class="breadcrumbs fixclear">
                            <li><a href="/">@lang('strings.Home')</a></li>
                            <li> @lang('strings.peronal_profile') </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>

        <!-- Sub-Header bottom mask style 6 -->
        <div class="kl-bottommask kl-bottommask--mask6">
            <svg width="2700px" height="57px" class="svgmask" viewBox="0 0 2700 57" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">
                <defs>
                    <filter x="-50%" y="-50%" width="200%" height="200%" filterUnits="objectBoundingBox" id="filter-mask6">
                        <feOffset dx="0" dy="-2" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset>
                        <feGaussianBlur stdDeviation="2" in="shadowOffsetOuter1" result="shadowBlurOuter1"></feGaussianBlur>
                        <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.5 0" in="shadowBlurOuter1" type="matrix" result="shadowMatrixOuter1"></feColorMatrix>
                        <feMerge>
                            <feMergeNode in="shadowMatrixOuter1"></feMergeNode>
                            <feMergeNode in="SourceGraphic"></feMergeNode>
                        </feMerge>
                    </filter>
                </defs>
                <g transform="translate(-1.000000, 10.000000)">
                    <path d="M0.455078125,18.5 L1,47 L392,47 L1577,35 L392,17 L0.455078125,18.5 Z" fill="#000000"></path>
                    <path d="M2701,0.313493752 L2701,47.2349598 L2312,47 L391,47 L2312,0 L2701,0.313493752 Z" fill="#fbfbfb" class="bmask-bgfill" filter="url(#filter-mask6)"></path>
                    <path d="M2702,3 L2702,19 L2312,19 L1127,33 L2312,3 L2702,3 Z" fill="#cd2122" class="bmask-customfill"></path>
                </g>
            </svg>
        </div>

    </div>


<div class="contactus customer">
    
    <div class="container">
        
        <ul class="nav nav-tabs nav-page-caty" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#profilec"> @lang('strings.peronal_profile') </a>
          </li>
          <!--<li class="nav-item">-->
          <!--  <a class="nav-link" data-toggle="tab" href="#passwordc">تغيير كلمة السر</a>-->
          <!--</li>-->
        </ul>
        
        <div class="tab-content">
            <div class="tab-pane active" id="profilec" role="tabpanel" aria-labelledby="profilec">
                <form action='{{ Route("updatacustomerprofile") }}' method="post">
                  {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <label> @lang('strings.Arabic_name') </label>
                            <input type="text" name="name" value="{{ app()->getLocale() == 'ar' ? $customer->name :$customer->name_en }}" required>
                            <input type="hidden" name="id" value="{{$customer->id }}" required>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <label> @lang('strings.Email')</label>
                            <input type="email"  name="email"  value="{{$customer->email}}" required>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <label>@lang('strings.phone') </label>
                            <input type="number" name="phone_number" value="{{$customer->phone_number}}" required>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <label>@lang('strings.Address') </label>
                            <input type="text"  name="address" value="{{$customer->address}}" required>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <label>{{ __('strings.Gender') }} </label>
                            <select  name="gender">
                                @if($customer->gender==1)
                              <option value="1" selected>{{ __('strings.Male') }}</option>
                              <option value="0"  >{{ __('strings.Female') }}</option>>
                              @else
                              <option value="1">{{ __('strings.Male') }}</option>
                              <option value="0" selected >{{ __('strings.Female') }}</option>>
                              @endif
                            </select>
                        </div>
                    </div>
                    <button type="submit"  class="btn btn_submit">@lang('strings.Save')</button>
                </form>
            </div>
            
        </div>

    </div>
</div>

@endsection
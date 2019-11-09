<!--
Author: FileRole
Author URL: http://filerole.com
-->

@extends('front.index_layout')

@section('content')
    <div id="page_header" class="page-subheader">

        <!-- Sub-Header content wrapper -->
        <div class="ph-content-wrap d-flex">
            <div class="container align-self-center">
                <div class="row">

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="subheader-titles">
                            <h2 class="subheader-maintitle">
                              @lang('strings.contact_us')
                            </h2>

                            <h4 class="subheader-subtitle">
                              @lang('strings.contact_us')   @lang('strings.now')
                            </h4>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <ul class="breadcrumbs fixclear">
                            <li><a href="{{url('/') }}">@lang('strings.Home')</a></li>
                            <li> @lang('strings.contact_us')</li>
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

    <!-- abous us content -->
    <div class="contactus">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <h3 class="title_contact">
                        @lang('strings.leave_massage')
                    </h3>
                    <form action="{{url('/frontmessage') }}" action="post">
                        <input type="text" name='name' placeholder="@lang('strings.Name')" required>
                        <input type="email" name="email" placeholder=" @lang('strings.Email')" required>
                        <input type="text" name="subject" placeholder="@lang('strings.subject')" required>
                        <textarea name="message" placeholder="@lang('strings.message')"></textarea>
                        <button type="submit" class="btn btn_submit">@lang('strings.send')</button>
                    </form>
                </div>
                <div class="col-md-6 col-xs-12">
                    <h3 class="title_contact">
                        @lang('strings.contact_us')
                    </h3>
                    <div class="info_contact">
                        <a href="tel:{{$org->phone}}" class="phone_footer"><i class="fas fa-phone"></i> {{$org->phone}}</a>
                        <a href="mailto:{{$org->email}}" class="email_footer"> <i class="fas fa-envelope"></i> {{$org->email}}</a>
                        <p class="adress">
                          {{$org->address}}
                        </p>
                         <p class="adress">
                          {{$org->work_time}}
                        </p> 
                    </div>
										  @if(!empty($org->location_map))
                    <img src="{{asset($org->map->file)}}">
										@endif
                </div>
            </div>
        </div>
    </div>

    @endsection

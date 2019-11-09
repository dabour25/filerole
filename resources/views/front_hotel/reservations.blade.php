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
                             @lang('strings.inovices_resrvition')
                            </h2>

                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <ul class="breadcrumbs fixclear">
                            <li><a href="/">@lang('strings.Home')</a></li>
                            <li> @lang('strings.inovices_resrvition') </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
@if(session()->has('message'))
		    <div class="alert alert-success">
		        {{ session()->get('message') }}
		    </div>
		@endif
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

    <div class="latest_product latest_product_inner categorys_product_page res_front">
        <div class="container">



            <div class="tab-content">
                     <table id="xtreme-table" class="display table table-striped table-bordered" style="width:100%">
                         <thead>
                                                         <tr>
                                <th>@lang('strings.reservation_no')</th>
                                <th>@lang('strings.reservation_category')</th>
                                <th>@lang('strings.Day')</th>
                                <th>@lang('strings.Time')</th>
                                <th>@lang('strings.reservation_captain')</th>
                                <th>@lang('strings.reservation_comment')</th>
                                <th>@lang('strings.reservation_date')</th>
                                <th>@lang('strings.reservation_confirm')</th>
                         </tr>
                         </thead>
                         <tbody>
                         @foreach($reservations as $reservation)

                             <tr>
                               <td>{{ $reservation['id'] }}</td>
                               <td>{{ app()->getLocale() == 'ar' ? App\Category::where('id', $reservation->cat_id)->value('name') : App\Category::where('id', $reservation->cat_id)->value('name_en') }}</td>


                               <td>{{ app()->getLocale() == 'ar' ? getDayNameArabic($reservation->av_day) : getDayName($reservation->av_day) }}</td>


                               <td>{{availableTimes($reservation->av_time, false) }}</td>

                               <td>{{ app()->getLocale() == 'ar' ?App\User::where('id', $reservation->captain_id)->value('name') : App\User::where('id', $reservation->captain_id)->value('name_en') }}</td>

                               <td>{{ $reservation['comment'] }}</td>
                               <td>{{ $reservation['reservation_date'] }}</td>

                               <td>
                                   <!--<Esraa  11-feb-2019 -->
                                    @if($reservation['confirm']=='y')
                                 <span class="label label-success"
                                    style="font-size:13px;color:green;">@lang('strings.confirmed2')</span>
                                    @elseif($reservation['confirm']=='c')
                                     <span class="label label-default"
                                    style="font-size:13px;background-color: #2a2a2a;border:
                                    none;color:red;" >@lang('strings.canceled')</span>
                                     @else
                                    <span class="label label-danger"
                                    style="font-size:13px;color:red;">@lang('strings.uncertain')</span>
                                      @endif
                               <!-- Esraa 11-feb-2019 -->


                               </td>
                             </tr>
                         @endforeach
                         </tbody>

                     </table>
                     {{ $reservations->links() }}
                     <ul class="nav nav-pills" role="tablist">
                         <!-- Mostafa Reservation -->
                         <li role="presentation" class="add-service"><a href="{{ url('reservation') }}"><i class="icon-calendar"></i> @lang('strings.reservation_add')  </a></li>

                         <!-- End Mostafa Reservation -->

                     </ul>





            </div>

        </div>
    </div> <!-- // latest product -->



@endsection

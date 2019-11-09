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
                             الحجوزات والفواتير
                            </h2>

                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <ul class="breadcrumbs fixclear">
                            <li><a href="/">@lang('strings.Home')</a></li>
                            <li> الحجوزات والفواتير </li>
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
    
    <div class="latest_product categorys_product_page res_front">
        <div class="container">

            <ul class="nav nav-tabs nav-page-caty" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tabelres1">الحجوزات</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tabelres2">الفواتير</a>
              </li>
            </ul>
    
            <div class="tab-content">
                
               

                <div class="tab-pane active" id="tabelres1" role="tabpanel" aria-labelledby="tabelres1">
                     <a href="{{url('reservation') }}" class="btn btn-primary reservationbtn"> <i class="fa fa-plus"></i> @lang('strings.reservation_add')  </a>
                    <table id="xtreme-table" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>@lang('strings.transactions_id')</th>
                            <th>@lang('strings.invoice_id')</th>
                            <th>@lang('strings.Date')</th>
                            <th>@lang('strings.total_request')</th>
                            <th>@lang('strings.Total_Paid')</th>
                            <th>@lang('strings.Total_Previous')</th>
                            <th>@lang('strings.Total_remaining')</th>
                            <th>@lang('strings.Status')</th>
                            <th>@lang('strings.Settings')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $value)
                            @php
                                $aaa = round(($value->transactions->where('status', 1)->where('req_flag', -1)->sum('price') - $value->transactions->sum('price')) - (App\PermissionReceivingPayments::where(['customer_req_id' =>  $value->id,'customer_id' => $value->cust_id, 'pay_flag' => 1])->sum('pay_amount') - App\PermissionReceivingPayments::where(['customer_req_id' =>  $value->id,'customer_id' => $value->cust_id, 'pay_flag' => -1])->sum('pay_amount')), 2);
                            @endphp
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->invoice_no }}</td>
                                <td>{{ Dateformat($value->date) }}</td>
                                <td>{{ Decimalplace_c(abs($value->transactions->sum('price'))) }}</td>
                                <td>{{ Decimalplace_c(App\PermissionReceivingPayments::where(['customer_req_id' =>  $value->id,'customer_id' => $value->cust_id, 'pay_flag' => 1])->sum('pay_amount')) }}</td>
                                <td>{{ Decimalplace_c(App\PermissionReceivingPayments::where(['customer_req_id' =>  $value->id,'customer_id' => $value->cust_id, 'pay_flag' => -1])->sum('pay_amount')) }}</td>
                                <td>{{ Decimalplace_c(($value->transactions->where('status', 1)->where('req_flag', -1)->sum('price') - $value->transactions->sum('price')) - (App\PermissionReceivingPayments::where(['customer_req_id' =>  $value->id,'customer_id' => $value->cust_id, 'pay_flag' => 1])->sum('pay_amount') - App\PermissionReceivingPayments::where(['customer_req_id' =>  $value->id,'customer_id' => $value->cust_id, 'pay_flag' => -1])->sum('pay_amount'))) }}</td>
    
                                {{--<td>{{ abs($value->transactions->sum('price')) }}</td>--}}
                                <td>@if($aaa < 0)
                                        <span class="label label-info"
                                              style="font-size:12px;"> @lang('strings.transactions_status_2')</span>
                                    @else
                                        @if(abs($aaa) == 0)
                                            <span class="label label-success"
                                                  style="font-size:12px;">@lang('strings.transactions_status_1')</span>
                                        @elseif(abs($aaa) == abs($value->transactions->sum('price')))
                                            <span class="label label-danger"
                                                  style="font-size:12px;">@lang('strings.transactions_status_3')</span>
                                        @elseif(abs($aaa) > 0)
                                            <span class="label label-warning"
                                                  style="font-size:12px;"> @lang('strings.transactions_status_4')</span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                                <a href="{{ url('transactions/'.$value->id.'/print') }}" class="btn btn-primary btn-xs">
                                                   <i class="fas fa-print"></i>
                                                </a>
                                                <div class="dropdown">
                                                  <button class="btn btn-secondary dropdown-toggle btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-plus"></i>
                                                  </button>
                                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('invoice/'.$value->id) }}&amp;title=share code is {{ $value->share_code }}" target="_blank" class="social-button " id=""><i class="fab fa-facebook-f"></i></a>
                                                    <a href="https://twitter.com/intent/tweet?text=share code is {{ $value->share_code }}&amp;url={{ url('invoice/'.$value->id) }}"  target="_blank" class="social-button " id=""><i class="fab fa-twitter"></i></i></a>
                                                    <a href="https://plus.google.com/share?url={{ url('invoice/'.$value->id) }}" class="social-button " target="_blank" id=""><i class="fab fa-google-plus"></i></a>
                                                    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ url('invoice/'.$value->id) }}&amp;title=share code is {{ $value->share_code }}" target="_blank" class="social-button " id=""><i class="fab fa-linkedin"></i></a>
                                                    <a href="https://wa.me/?text={{ url('invoice/'.$value->id) }} share code is {{ $value->share_code }}" class="social-button" target="_blank" id=""><i class="fab fa-whatsapp"></i></a>
                                                  </div>
                                                </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
    
                    </table>
                    {{ $orders->links() }}   
                </div>
                <div class="tab-pane active" id="tabelres2" role="tabpanel" aria-labelledby="tabelres2">
                    <table id="xtreme-tables" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>@lang('strings.transactions_id')</th>
                            <th>@lang('strings.invoice_id')</th>
                            <th>@lang('strings.Date')</th>
                            <th>@lang('strings.total_request')</th>
                            <th>@lang('strings.Total_Paid')</th>
                            <th>@lang('strings.Total_Previous')</th>
                            <th>@lang('strings.Total_remaining')</th>
                            <th>@lang('strings.Status')</th>
                            <th>@lang('strings.Settings')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $value)
                            @if($value->transactions->where('status', 1)->sum('price') == $value->transactions->sum('price'))
                            @else
                                @php
                                    $aaa = ($value->transactions->where('status', 1)->where('req_flag', -1)->sum('price') - $value->transactions->sum('price')) - (App\PermissionReceivingPayments::where(['customer_req_id' =>  $value->id,'customer_id' => $value->cust_id, 'pay_flag' => 1])->sum('pay_amount') - App\PermissionReceivingPayments::where(['customer_req_id' =>  $value->id,'customer_id' => $value->cust_id, 'pay_flag' => -1])->sum('pay_amount'));
                                @endphp
                                @if($aaa != 0)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->invoice_no }}</td>
                                        <td>{{ Dateformat($value->date) }}</td>
                                        <td>{{ Decimalplace_c(abs($value->transactions->sum('price'))) }}</td>
                                        <td>{{ Decimalplace_c(App\PermissionReceivingPayments::where(['customer_req_id' =>  $value->id,'customer_id' => $value->cust_id, 'pay_flag' => 1])->sum('pay_amount')) }}</td>
                                        <td>{{ Decimalplace_c(App\PermissionReceivingPayments::where(['customer_req_id' =>  $value->id,'customer_id' => $value->cust_id, 'pay_flag' => -1])->sum('pay_amount')) }}</td>
                                        <td>{{ Decimalplace_c(($value->transactions->where('status', 1)->where('req_flag', -1)->sum('price') - $value->transactions->sum('price')) - (App\PermissionReceivingPayments::where(['customer_req_id' =>  $value->id,'customer_id' => $value->cust_id, 'pay_flag' => 1])->sum('pay_amount') - App\PermissionReceivingPayments::where(['customer_req_id' =>  $value->id,'customer_id' => $value->cust_id, 'pay_flag' => -1])->sum('pay_amount'))) }}</td>

                                        {{--<td>{{ abs($value->transactions->sum('price')) }}</td>--}}
                                        <td>@if($aaa < 0)
                                                <span class="label label-info"
                                                      style="font-size:12px;"> @lang('strings.transactions_status_2')</span>
                                            @else @if(abs($aaa) == 0)
                                                    <span class="label label-success"
                                                          style="font-size:12px;">@lang('strings.transactions_status_1')</span>
                                                @elseif(abs($aaa) == abs($value->transactions->sum('price')))
                                                    <span class="label label-danger"
                                                          style="font-size:12px;">@lang('strings.transactions_status_3')</span>
                                                @elseif(abs($aaa) > 0)
                                                    <span class="label label-warning"
                                                          style="font-size:12px;"> @lang('strings.transactions_status_4')</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('transactions/'.$value->id.'/print') }}"
                                               class="btn btn-primary btn-xs"><i class="fas fa-print"></i></a>
                                                <div class="dropdown">
                                                  <button class="btn btn-secondary dropdown-toggle btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-plus"></i>
                                                  </button>
                                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                   <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('invoice/'.$value->id) }}&amp;title=share code is {{ $value->share_code }}" target="_blank" class="social-button " id="">
                                                       <span class="fas fa-facebook-official"></span></a>
                                                    <a href="https://twitter.com/intent/tweet?text=share code is {{ $value->share_code }}&amp;url={{ url('invoice/'.$value->id) }}"  target="_blank" class="social-button " id=""><span class="fa fa-twitter">
                                                        
                                                    </span></a>
                                                    <a href="https://plus.google.com/share?url={{ url('invoice/'.$value->id) }}" class="social-button " target="_blank" id="">
                                                        <span class="fas fa-google-plus"></span></a>
                                                    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ url('invoice/'.$value->id) }}&amp;title=share code is {{ $value->share_code }}" target="_blank" class="social-button " id="">
                                                        <span class="fas fa-linkedin"></span></a>
                                                    <a href="https://wa.me/?text={{ url('invoice/'.$value->id) }}  share code is {{ $value->share_code }}" class="social-button" target="_blank" id="">
                                                        <span class="fas fa-whatsapp"> </span></a>
                                                  </div>
                                                </div>
                                        </td>
                                    </tr>

                                @endif
                            @endif
                        @endforeach
                        </tbody>

                    </table>
                    {{ $orders->links() }}
                </div>
            </div>

        </div>
    </div> <!-- // latest product -->


@endsection

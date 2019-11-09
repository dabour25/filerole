<!--
Author: FileRole
Author URL: http://filerole.com
-->

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
                                سلة الشراء
                            </h2>

                        </div>
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

    <!-- checkout -->
    <div class="checkout">
        <div class="container">
           <h3 class="title_cart ">سلة الشراء <span class="total-coun"   >{{$count_number}}</span> </h3>
            <span class="numb_in">{{ app()->getLocale() == 'ar' ? $org_id->name :$org_id->name_en}} @lang('strings.inovice_string') {{$extra_head->invoice_code}}</span>
            <div class="row">

            <div class="col-sm-12">
                <div class="row">
                    <div class="item-check">
                        <div class="col-6">
                            <p class="title_item">المنتج</p>
                        </div>
                        <div class="col-2">
                            <p>الكمية</p>
                        </div>
                        <div class="col-2">
                            <p>السعر</p>
                        </div>
                        <div class="col-2">
                            <p>الإجمالي</p>
                        </div>
                    </div>
                </div>
            </div>

              <div class="col-sm-12">
                    <div class="row">
						@foreach($extra_trans as $extra_tran)
                        <div class="item-check item-check-pro">
                            <div class="col-6">
								@php
								$category=\App\Category::where('id',$extra_tran->cat_id)->first();
								@endphp
                                <img src=" {{asset(str_replace(' ', '%20', \App\Photo::find($category->photo_id)->file))}}">
                               
                                <p class="title-prod">{{app()->getLocale() == 'ar' ? \App\Category::find($extra_tran->cat_id)->name : \App\Category::find($extra_tran->cat_id)->name_en }} </p>
                            </div>
                            
                            <div class="col-2">
                             <p class="inuq_p">{{$extra_tran->quantity}}</p>
                            </div>
                            
                            <div class="col-2">
                                <p class="unit"> {{$extra_tran->final_price}}</p>
                            </div>
                            
                            <div class="col-2">
                                <p class="subtotal">{{$extra_tran->final_price * $extra_tran->quantity}}</p>
                            </div>
                        </div>
						@endforeach
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="total_cart">
                       
                        <p> السعر الإجمالي: <span class="total-cart”>{{ $total}}</span></p>
                       <p> السعر الإجمالي: <span class="total-cart">{{ $total.' '. $currency->name }}</span></p>
                        <span>سعر الشحن لم يضاف بعد!</span>
                    </div>
                    <div class="buttons_cart">
                        <a href='{{url("/payment/$total/$extra_head->id")}}' class="btn btn-success "> إنهاء الطلب  </a>
                      

                    </div>
                </div>

            </div>
        </div>
    </div>
    
  
     <!--<script>-->
     <!--    $( document ).ready(function(){-->
     <!--      $('.clear-cart').click();-->

     <!--    })-->
     <!--</script>-->




  	@endsection

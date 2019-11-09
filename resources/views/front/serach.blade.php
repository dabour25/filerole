<!--
Author: FileRole
Author URL: http://filerole.com
-->

@extends('front.index_layout')

@section('content')

    <div id="page_header" class="page-subheader page-subheader-bg">
      @php
      $my_url=url()->current();
      $last = explode('/', $my_url);
      $org=DB::table('organizations')->where('customer_url',$last[2])->first();
      $org_id_login=$org->id;
      if(empty($org)){
      $org_master=\App\Organization::where('custom_domain',$last[2]);
      $org=\App\org::where('id',$org_master->org_id);
      $org_id_login=$org_master->org_id;
      }
      $show_cart=\App\Settings::where(['org_id' =>$org->id,'key'=> 'basket','value'=>'on'])->first();

      @endphp
        <!-- Sub-Header content wrapper -->
        <div class="ph-content-wrap d-flex">
            <div class="container align-self-center">
                <div class="row">

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="subheader-titles">
                            <h2 class="subheader-maintitle">
                            {{app()->getLocale() == 'ar' ? $labels->value : $labels->value_en}}
                            </h2>

                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <ul class="breadcrumbs fixclear">
                            <li><a href="/">@lang('strings.Home')</a></li>
                            <li>{{app()->getLocale() == 'ar' ? $labels->value : $labels->value_en}}</li>
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

    <!-- categorys page -->
    <div class="latest_product categorys_product_page">
        <div class="container">



        <div class="tab-content">
                    <div class="row">


                        <div class="col-md-9 col-xs-12">

                            <div class="tab-content">



                                <div class="tab-pane active" id="hidden_tab" role="tabpanel" aria-labelledby="hidden_tab">

                                    <div class="row">
                                 @foreach($categorys as $category)
                               <div class="col-md-4 col-xs-12">
                                <div class="item_pro ">
                                 <a href="details/{{ $category->id }}"><img src=" {{asset(str_replace(' ', '%20', \App\Photo::find($category->photo_id)->file))}}" class="img_caty"></a>

                                 <h3>{{app()->getLocale() =='ar' ? $category->name : $category->name_en}}</h3>
                               </div>

                              @if($category->cat==1)
                               <div class="price_add">
                                   <h6 class="old_price">{{$category->price->final_price}}</h6>
                                   <h6>{{$category->price->offer_price}}</h6>
                                   @if($show_cart)
                                   <a href="#" data-name="{{app()->getLocale() =='ar' ? $category->name :$category->name_en}}" data-price="{{ $category->price->offer_price}}"  data-id="{{ $category->id}}"  class="add-to-cart btn btn-primary" ><i class="fas fa-cart-plus"></i>add to cart </a>
                                    @endif
                               </div>
                               @else
                                <div class="price_add">
                                 <h6>{{ $category->price->final_price}}</h6>
                                 @if($show_cart)
                                 <a href="#" data-name="{{app()->getLocale() =='ar' ? $category->name :$category->name_en}}" data-price="{{$category->price->final_price}}"  data-id="{{ $category->id}}"  class="add-to-cart btn btn-primary" ><i class="fas fa-cart-plus"></i>add to cart </a>
                                  @endif
                                </div>
                                @endif
                                </div>

                                 @endforeach


                                </div>
                                </div>


                                    </div>


                                </div>

                            </div>


                        </div>
                    </div>
                </div>
       </div>


    <!-- footer -->
		@endsection

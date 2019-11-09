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
      $org_id=\APP\org::where('customer_url',$last[2])->first();
      $cats=\App\ActivityLabelSetup::where(['type'=>items,'activity_id'=>$org_id->activity_id ])->first();
      $sers=\App\ActivityLabelSetup::where(['type'=>services,'activity_id'=>$org_id->activity_id ])->first();
      $labels=\App\ActivityLabelSetup::where(['type'=>item_service,'activity_id'=>$org_id->activity_id ])->first();
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

        <ul class="nav nav-tabs nav-page-caty" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#Products">  {{app()->getLocale() == 'ar' ? $cats->value : $cats->value_en}}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#Services">{{app()->getLocale() == 'ar' ? $sers->value : $sers->value_en}}</a>
          </li>
        </ul>

        <div class="tab-content">
                <div class="tab-pane active" id="Products" role="tabpanel" aria-labelledby="Products">
                    <div class="row">
                        <div class="col-md-3 col-xs-12">
                            <ul class="nav nav-tabs nav-page-caty nav-page-sub-caty" role="tablist">
                            @foreach($products as $product)
						                 	<li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#product{{$product->id}}"> <i class="fas fa-angle-right"></i> {{app()->getLocale() =='ar' ? $product->name : $product->name_en}}</a>
                              </li>
	                         @endforeach

                            </ul>
                        </div>

                        <div class="col-md-9 col-xs-12">

                            <div class="tab-content">



                                <div class="tab-pane active" id="hidden_tab" role="tabpanel" aria-labelledby="hidden_tab">
                                    
                                    <div class="row">

                                 @foreach($products as $product)
                                 @foreach($product->product_types as $product->product_type)
                                 @php
                                 $my_url=url()->current();
                                 $last = explode('/', $my_url);
                                 $org_id=\APP\org::where('customer_url',$last[2])->first();
                                 $offers=\App\Offers::where('active',1)->where('org_id',$org_id->id)->where('cat_id',$product->product_type->id)->whereDate('date_from','<=' , date('Y-m-d'))->whereDate('date_to','>=' , date('Y-m-d'))->orderBy('created_at','desc')->first();
                                 $prices=App\PriceList::where('active',1)->where('org_id',$org_id->id)->whereDate('date','<=',date('Y-m-d'))->where('cat_id',$product->product_type->id)->orderBy('date','desc')->first();

                                 if($offers)
                                 $product_offers=\APP\Category::join('offers', 'offers.cat_id', '=', 'categories.id')
                                 ->join('price_list', 'price_list.cat_id', '=', 'categories.id')
                                 ->where([ 'categories.active' => 1,'categories.category_type_id' =>$product->id ,'categories.org_id'=>$org->id])
                                 ->where('offers.id', $offers->id)
                                 ->where('price_list.id', $prices->id)
                                 ->select('categories.*','offer_price', 'final_price')
                                 ->first();


                                 @endphp
                                <div class="col-md-4 col-xs-12">
                                <div class="item_pro ">
                                 <img src="{{asset(\App\Photo::find($product->product_type->photo_id)->file)}}" class="img_caty">
                                 <h3>{{app()->getLocale() =='ar' ? $product->product_type->name : $product->product_type->name_en}}</h3>
                                 @if($offers)

                                 <div class="price_add">
                                     <h6 class="final_price">{{ $product_offers->final_price}}</h6>
                                     <h6>{{ $product_offers->offer_price}}</h6>
                                     <a href="#" data-name="{{app()->getLocale() =='ar' ? $product_offers->name :$product_offers->name_en}}" data-price="{{ $product_offers->offer_price}}"  data-id="{{ $product_offers->id}}" data-description="{{app()->getLocale() =='ar' ? $product_offers->description : $product_offers->description_en}}" class="add-to-cart btn btn-primary" ><i class="fas fa-cart-plus"></i>add to cart </a>
                                 </div>

                                 @else
                                 <div class="price_add">
                                     <h6>{{ $product->product_type->final_price}}</h6>
                                     <a href="#" data-name="{{app()->getLocale() =='ar' ? $product->product_type->name : $product->product_type->name_en}}" data-price="{{ $product->product_type->final_price}}"  data-id="{{ $product->product_type->id}}" data-description="{{app()->getLocale() =='ar' ? $product->product_type->description : $product->product_type->description_en}}" class="add-to-cart btn btn-primary"><i class="fas fa-cart-plus"></i>add to cart </a>
                                 </div>
                                 @endif
                               </div>
                                </div>
                                 @break
                                 @endforeach
                                 @endforeach

                                </div>
                                </div>
                                @foreach($products as $product)
								@if(count($product->product_types))

								<div class="tab-pane" id="product{{$product->id}}" role="tabpanel" aria-labelledby="product{{$product->id}}">

									<div class="items_product">
                                    <div class="row">
                                         @foreach($product->product_types as $product->product_type)
@php
$my_url=url()->current();
$last = explode('/', $my_url);
$org_id=\APP\org::where('customer_url',$last[2])->first();
$offers=\App\Offers::where('active',1)->where('org_id',$org_id->id)->where('cat_id',$product->product_type->id)->whereDate('date_from','<=' , date('Y-m-d'))->whereDate('date_to','>=' , date('Y-m-d'))->orderBy('created_at','desc')->first();
$prices=App\PriceList::where('active',1)->where('org_id',$org_id->id)->whereDate('date','<=',date('Y-m-d'))->where('cat_id',$product->product_type->id)->orderBy('date','desc')->first();



if($offers)
$product_offers=\APP\Category::join('offers', 'offers.cat_id', '=', 'categories.id')
->join('price_list', 'price_list.cat_id', '=', 'categories.id')
->where([ 'categories.active' => 1,'categories.category_type_id' =>$product->id ,'categories.org_id'=>$org->id])
->where('offers.id', $offers->id)
->where('price_list.id', $prices->id)
->select('categories.*','offer_price', 'final_price')
->first();


@endphp
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="item_pro " data-wow-delay="0.20s">
                                                <img src="{{asset(\App\Photo::find($product->product_type->photo_id)->file)}}">
                                                <h3>{{app()->getLocale() =='ar' ? $product->product_type->name : $product->product_type->name_en}}</h3>
                                            @if($offers)

                                            <div class="price_add">
                                                <h6 class="final_price">{{ $product_offers->final_price}}</h6>
                                                <h6>{{ $product_offers->offer_price}}</h6>
                                                <a href="#" data-name="{{app()->getLocale() =='ar' ? $product_offers->name :$product_offers->name_en}}" data-price="{{ $product_offers->offer_price}}"  data-id="{{ $product_offers->id}}" data-description="{{app()->getLocale() =='ar' ? $product_offers->description : $product_offers->description_en}}" class="add-to-cart btn btn-primary" ><i class="fas fa-cart-plus"></i>add to cart </a>
                                            </div>

                                            @else
                                            <div class="price_add">
                                                <h6>{{ $product->product_type->final_price}}</h6>
                                                <a href="#" data-name="{{app()->getLocale() =='ar' ? $product->product_type->name : $product->product_type->name_en}}" data-price="{{ $product->product_type->final_price}}"  data-id="{{ $product->product_type->id}}" data-description="{{app()->getLocale() =='ar' ? $product->product_type->description : $product->product_type->description_en}}" class="add-to-cart btn btn-primary"><i class="fas fa-cart-plus"></i>add to cart </a>
                                            </div>
                                            @endif
                                            </div>
                                        </div>
                                @endforeach

                                    </div>


                                </div>

                            </div>

								@else
								<div class="tab-pane  " id="product{{$product->id}}" role="tabpanel" aria-labelledby="product{{$product->id}}">
                                {{'NO DATA Available TO SHOW '}}
								</div>

								@endif
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>


                <div class="tab-pane" id="Services" role="tabpanel" aria-labelledby="Services">
                    <div class="row">
                        <div class="col-md-3 col-xs-12">
                            <ul class="nav nav-tabs nav-page-caty nav-page-sub-caty" role="tablist">
                                @foreach($services as $service)
                              <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#service{{$service->id}}"> <i class="fas fa-angle-right"></i> {{app()->getLocale() =='ar' ? $service->name : $service->name_en}}</a>
                              </li>
                               @endforeach
                            </ul>
                        </div>

                        <div class="col-md-9 col-xs-12">

                            <div class="tab-content">

                                 <div class="tab-pane active" id="hidden_tab" role="tabpanel" aria-labelledby="hidden_tab">

                                @foreach($services as $service)
                                @foreach($service->service_types as $service->service_type)
                                @php
                                $my_url=url()->current();
                                $last = explode('/', $my_url);
                                $org_id=\APP\org::where('customer_url',$last[2])->first();
                                $offers=\App\Offers::where('active',1)->where('org_id',$org_id->id)->where('cat_id', $service->service_type->id)->whereDate('date_from','<=' , date('Y-m-d'))->whereDate('date_to','>=' , date('Y-m-d'))->orderBy('created_at','desc')->first();
                                $prices=App\PriceList::where('active',1)->where('org_id',$org_id->id)->whereDate('date','<=',date('Y-m-d'))->where('cat_id',$service->service_type->id)->orderBy('date','desc')->first();

                                if($offers)
                                $service_offers=\APP\Category::join('offers', 'offers.cat_id', '=', 'categories.id')
                                ->join('price_list', 'price_list.cat_id', '=', 'categories.id')
                                ->where([ 'categories.active' => 1,'categories.category_type_id' =>$services->id ,'categories.org_id'=>$org->id])
                                ->where('offers.id', $offers->id)
                                ->where('price_list.id', $prices->id)
                                ->select('categories.*','offer_price', 'final_price')
                                ->first();
                                @endphp

                                <img src="{{asset(\App\Photo::find($service->service_type->photo_id)->file)}}" class="img_caty">
                                <h3>{{app()->getLocale() =='ar' ? $service->service_type->name : $service->service_type->name_en}}</h3>
                              @if($offers)
                                <div class="price_add">
                                    <h6 class="final_price">{{$service_offers->final_price}}</h6>
                                    <h6>{{$service_offers->offer_price}}</h6>
                                    <a href="#" data-name="{{app()->getLocale() =='ar' ? $service_offers->name : $service_offers->name_en}}"  data-price="{{$service_offers->offer_price}}" data-id="{{$service_offers->id}}"  data-description="{{app()->getLocale() =='ar' ? $service_offers->description : $service_offers->description_en}}" class="add-to-cart btn btn-primary"><i class="fas fa-cart-plus"></i>add to cart </a>

                                </div>
                                @else

                                <div class="price_add">
                                    <h6>{{$service->service_type->final_price}}</h6>
                                    <a href="#" data-name="{{app()->getLocale() =='ar' ? $service->service_type->name : $service->service_type->name_en}}"  data-price="{{$service->service_type->final_price}}" data-id="{{$service->service_type->id}}" data-description="{{app()->getLocale() =='ar' ? $service->service_type->description : $service->service_type->description_en}}" class="add-to-cart btn btn-primary"><i class="fas fa-cart-plus"></i>add to cart </a>

                                </div>
                                @endif
                                @break
                                @endforeach
                                @endforeach

                                </div>

                                  @foreach($services as $service)
                                  @if(count($service->service_types))

                                <div class="tab-pane " id="service{{$service->id}}" role="tabpanel" aria-labelledby="service{{$service->id}}">
                                    <div class="items_product">
                                        <div class="row">
                          @foreach($service->service_types as $service->service_type)
@php
$my_url=url()->current();
$last = explode('/', $my_url);
$org_id=\APP\org::where('customer_url',$last[2])->first();
$offers=\App\Offers::where('active',1)->where('org_id',$org_id->id)->where('cat_id', $service->service_type->id)->whereDate('date_from','<=' , date('Y-m-d'))->whereDate('date_to','>=' , date('Y-m-d'))->orderBy('created_at','desc')->first();
$prices=App\PriceList::where('active',1)->where('org_id',$org_id->id)->whereDate('date','<=',date('Y-m-d'))->where('cat_id',$service->service_type->id)->orderBy('date','desc')->first();

if($offers)
$service_offers=\APP\Category::join('offers', 'offers.cat_id', '=', 'categories.id')
->join('price_list', 'price_list.cat_id', '=', 'categories.id')
->where([ 'categories.active' => 1,'categories.category_type_id' =>$services->id ,'categories.org_id'=>$org->id])
->where('offers.id', $offers->id)
->where('price_list.id', $prices->id)
->select('categories.*','offer_price', 'final_price')
->first();
@endphp

                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="item_pro " data-wow-delay="0.20s">
                                                    <img src="{{asset(\App\Photo::find($service->service_type->photo_id)->file)}}">
                                                    <h3>{{app()->getLocale() =='ar' ? $service->service_type->name : $service->service_type->name_en}}</h3>
                                                  @if($offers)
                                                    <div class="price_add">
                                                        <h6 class="final_price">{{$service_offers->final_price}}</h6>
                                                        <h6>{{$service_offers->offer_price}}</h6>
                                                        <a href="#" data-name="{{app()->getLocale() =='ar' ? $service_offers->name : $service_offers->name_en}}"  data-price="{{$service_offers->offer_price}}" data-id="{{$service_offers->id}}"  data-description="{{app()->getLocale() =='ar' ? $service_offers->description : $service_offers->description_en}}" class="add-to-cart btn btn-primary"><i class="fas fa-cart-plus"></i>add to cart </a>

                                                    </div>
                                                    @else

                                                    <div class="price_add">
                                                        <h6>{{$service->service_type->final_price}}</h6>
                                                        <a href="#" data-name="{{app()->getLocale() =='ar' ? $service->service_type->name : $service->service_type->name_en}}"  data-price="{{$service->service_type->final_price}}" data-id="{{$service->service_type->id}}" data-description="{{app()->getLocale() =='ar' ? $service->service_type->description : $service->service_type->description_en}}" class="add-to-cart btn btn-primary"><i class="fas fa-cart-plus"></i>add to cart </a>

                                                    </div>
                                                    @endif
                                                </div>
                                            </div>

                                         @endforeach

                                        </div>
                                    </div>
                                </div>

        						@else
                                <div class="tab-pane " id="service{{$service->id}}" role="tabpanel" aria-labelledby="service{{$service->id}}">
                                  {{'NO DATA Available TO SHOW '}}
        						</div>

        						@endif
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
        </div>



        </div>
    </div> <!-- // latest product -->

    <!-- footer -->
		@endsection

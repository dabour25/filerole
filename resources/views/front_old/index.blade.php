
@extends('front.index_layout')

@section('content')

    <!-- slider -->
    @php

    $my_url=url()->current();
    $last = explode('/', $my_url);
    $org_id=DB::table('organizations')->where('customer_url',$last[2])->first();
    $show_cart=\App\Settings::where(['org_id' =>$org_id->id,'key'=> 'basket','value'=>'on'])->first();
    @endphp
      @if($org_id->front_image!=null)


    <div class="slider-home"  style="background:url('{{asset(\App\Photo::find($org_id->front_image)->file)}}');background-size:cover;">

      @else
    <div class="slider-home"  style="background:url('{{asset($org->front->file)}}');background-size:cover;">
    @endif
        <div class="bottom_cut"></div>
    	<div class="patern-layer-one" style="background-image: url(https://expert-themes.com/html/tecno/images/icons/banner-icon-1.png)"></div>
		<div class="patern-layer-two" style="background-image: url(https://expert-themes.com/html/tecno/images/icons/banner-icon-2.png)"></div>
           <div class="owl-carousel owl-theme" id="sliderHome">
             @if(count($offers))
                @foreach($offers as $offer)
               <div class="item">
                   <!-- @if(!empty($offer->photo_id))-->
                    <!--@endif-->
                   <div class="slider-text">
                        <div class="behind_slider"><a href="details/{{ $offer->cat_id }}"><img src="{{asset(str_replace(' ', '%20', \App\Photo::find($offer->photo_id)->file))}}" alt="slider1"></a></div>
                       <div class="box-text wow fadeInDown" data-wow-delay="0.50s">
                           <div class="inner_box">
                               <h1>{{ app()->getLocale() =='ar' ? $offer->name : $offer->name_en }}</h1>
                               <p class="price wow fadeIn" data-wow-delay="0.5s">{{Decimalpoint($offer->offer_price)}}</p>
                               <p class="old_price wow fadeIn" data-wow-delay="0.5s">{{Decimalpoint($offer->final_price)}}</p>
                                  @if($show_cart)
                                    <a href="#" data-name="{{app()->getLocale() =='ar' ? $offer->name : $offer->name_en}}" data-price="{{ $offer->offer_price}}" data-id="{{ $offer->cat_id }}" data-description="{{app()->getLocale() =='ar' ?$offer->description :$offer->description_en}}" class="add-to-cart btn btn-primary">
                                        <i class="fas fa-cart-plus"></i>
                                        add to cart
                                        </a>
                                  @endif
                           </div>
                       </div>

                       <!--<a href="#" class="wow fadeIn" data-wow-delay="0.30s"> see all offers </a>-->
                   </div>
               </div>
              @endforeach
              @else
                <p class="no_offers"> @lang('strings.noOffers') </p>
              @endif


           </div>
       </div> <!-- // slider -->

    <!-- box information
    <div class="information">
        <div class="container">
            <div class="in_information">
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="text-info">
                            <h3>alwaha is a Beauty Centre, We combine exclusive luxury with relaxation to enjoy our guests.</h3>
                            <p>Our spa is a haven for reflection and inner discovery. We want you to pick up your breath and enjoy yourself.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <a href="#" class="creat_account"> Creat Account Now </a>
                        <a href="#" class="learn_more"> Learn More </a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- latest product -->
    <div class="latest_product">
        <div class="container">
            <div class="all_title">
                 @php
             $labels=\App\ActivityLabelSetup::where(['type'=>item_service,'activity_id'=>$org_id->activity_id ])->first();
                 @endphp
                <h1 class="wow fadeInDown" data-wow-delay="0.20s">{{app()->getLocale() == 'ar' ? $labels->value : $labels->value_en}}</h1>
                <p class="wow fadeInUp" data-wow-delay="0.20s">Our latest product of 	{{ app()->getLocale() == 'ar' ? $org_id->name : $org_id->name_en}}..</p>
            </div>

            <div class="items_product">
                <div class="row">
                 @foreach($last_prodcts as $last_prodct)
                    <div class="col-md-3 col-sm-6 col-xs-6">
                     <div class="item_pro wow fadeIn" data-wow-delay="0.20s">
                       <a href="details/{{ $last_prodct->id }}"> <img src="{{asset(str_replace(' ', '%20', \App\Photo::find($last_prodct->photo_id)->file))}}"></a>



                         <h3>{{app()->getLocale() == 'ar' ?  $last_prodct->name :   $last_prodct->name_en}}</h3>
                       @if($last_prodct->offerCat>0)
                       <div class="price_add">

                             @if($last_prodct->offerCat==1)

                             <h6>{{ Decimalpoint($last_prodct->price->offer_price) }}</h6>
                             <h6 class="old_price wow fadeIn">{{ Decimalpoint($last_prodct->final_price->final_price)}}</h6>
                              @if($show_cart)
                             <a href="#" data-name="{{app()->getLocale() =='ar' ? $last_prodct->name : $last_prodct->name_en}}" data-price="{{ $last_prodct->price->offer_price}}"  data-id="{{ $last_prodct->id}}" data-description="{{app()->getLocale() =='ar' ? $last_prodct->description : $last_prodct->description_en}}" class="add-to-cart btn btn-primary"><i class="fas fa-cart-plus"></i>add to cart </a>
                              @endif
                             @elseif($last_prodct->offerCat==2)

                             <h6>{{ Decimalpoint($last_prodct->price->final_price)}}</h6>
                              @if($show_cart)
                             <a href="#" data-name="{{app()->getLocale() =='ar' ? $last_prodct->name : $last_prodct->name_en}}" data-price="{{ $last_prodct->price->final_price}}"  data-id="{{ $last_prodct->id}}" data-description="{{app()->getLocale() =='ar' ? $last_prodct->description : $last_prodct->description_en}}" class="add-to-cart btn btn-primary"><i class="fas fa-cart-plus"></i>add to cart </a>
                             @endif
                             @endif


                         </div>
                       @endif
                     </div>
                 </div>
                @endforeach
                </div>
            </div>

        </div>
    </div> <!-- // latest product -->

    <!-- best seller -->
    <div class="latest_product best_seller">
        <div class="container">
            <div class="all_title">
                <h1 class="wow fadeInDown" data-wow-delay="0.20s">  @lang('strings.best_seller')</h1>
                <p class="wow fadeInUp" data-wow-delay="0.20s">Our best seller of	{{ app()->getLocale() == 'ar' ? $org_id->name : $org_id->name_en}}..</p>
            </div>

            <div class="items_product">

                     @if(count($best_selers))
                     <div class="owl-carousel owl-theme" id="sliderSeller">
                    @foreach($best_selers as $best_seler)
                    <div class="item">
                        <div class="item_pro wow fadeIn" data-wow-delay="0.20s">
                           <a href="details/{{ $best_seler->cat_id }}"><img src="{{asset(str_replace(' ', '%20', \App\Photo::find($best_seler->photo_id)->file))}}"></a>

                            <h3>{{app()->getLocale() == 'ar' ?  $best_seler->name :   $best_seler->name_en}}</h3>
                           @if($best_seler->offer_price)
                            <div class="price_add">
                                <h6>{{Decimalpoint($best_seler->final_price) }}</h6>
                                <h6>{{Decimalpoint($best_seler->offer_price) }}</h6>
                                   @if($show_cart)
                                <a href="#" data-name="{{app()->getLocale() =='ar' ? $best_seler->name :
                                    $best_seler->name_en}}" data-price="{{ $best_seler->offer_price}}"  data-id="{{ $best_seler->id}}" data-description="{{app()->getLocale() =='ar' ? $best_seler->description : $best_seler->description_en}}" class="add-to-cart btn btn-primary">  <i class="fas fa-cart-plus"></i>add to cart </a>
                                @endif
                            </div>
                            @else
                            <div class="price_add">
                                 <h6>{{Decimalpoint($best_seler->final_price)}}</h6>
                                 @if($show_cart)
                                 <a href="#" data-name="{{app()->getLocale() =='ar' ? $best_seler->name :
                                     $best_seler->name_en}}" data-price="{{ $best_seler->final_price}}"  data-id="{{ $best_seler->id}}" data-description="{{app()->getLocale() =='ar' ? $best_seler->description : $best_seler->description_en}}" class="add-to-cart btn btn-primary">  <i class="fas fa-cart-plus"></i>add to cart </a>
                                 @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    </div>
                    @else
                    <p class="no_of" style="color:#fff"> @lang('strings.noOffers2') </p>
                    @endif

            </div> <!-- // best seller -->
        </div>
    </div>

    <div class="all_pop" id="news_desk">
        <div class="login register news">
            <button type="button" onclick="closeNews()" class="close_log"> <i class="fas fa-times"></i>  </button>
            <p>
            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
            </p>
        </div>
    </div>

    <!-- News -->
    <div class="latest_product news">
        <div class="container">
            <div class="all_title">
                <h1 class="wow fadeInDown" data-wow-delay="0.20s"> @lang('strings.Latest_news')</h1>
            </div>

            <div class="items_news">
                  @if(count($news))
                   <div class="owl-carousel owl-theme" id="slider_News">
                       @foreach($news as $new)
                    <div class="item">
                        <button type="button" class="more" onclick="showNews()"> <i class="fas fa-plus"></i> more </button>
                        <img src=" {{asset(str_replace(' ', '%20', \App\Photo::find($new->image_id)->file))}}">

                        <div class="text_news">
                            <h3> {{app()->getLocale() == 'ar' ?  $new->news_title :   $new->news_title_en}}  </h3>
                            <p>	{{  app()->getLocale() == 'ar' ?  $new->news_desc : $new->news_desc_en }}</p>
                        </div>
                    </div>
                    @endforeach
                    </div>
                    @else
                    <p class="no_of">  @lang('strings.noOffers3') </p>
                    @endif

            </div>
        </div> <!-- // News -->
    </div>
    @endsection

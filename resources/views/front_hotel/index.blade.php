<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700" rel="stylesheet">

<link rel="stylesheet" href="{{url('/')}}/front/css/style.css">
<link rel="stylesheet" href="{{url('/')}}/front/css/icomoon.css">
<link rel="stylesheet" href="{{url('/')}}/front/css/bootstrap2.css">
<link rel="stylesheet" href="{{url('/')}}/front/css/animate.css">
<link rel="stylesheet" href="{{url('/')}}/front/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="{{url('/')}}/front/css/magnific-popup.css">
<link rel="stylesheet" href="{{url('/')}}/front/scss/bootstrap/_grid.scss">
<link rel="stylesheet" href="{{url('/')}}/front/scss/bootstrap/__scaffolding.scss">
<link rel="stylesheet" href="{{url('/')}}/front/scss/bootstrap/mixins/_grid-framework.scss">
<link rel="stylesheet" href="{{url('/')}}/front/scss/bootstrap/_forms.scss">
<link rel="stylesheet" href="{{url('/')}}/front/scss/bootstrap/_normalize.scss">
<link rel="stylesheet" href="{{url('/')}}/front/css/flexslider.css">
<link rel="stylesheet" href="{{url('/')}}/front/css/owl.theme.default.min.css">
<link rel="stylesheet" href="{{url('/')}}/front/css/owl.carousel2.min.css">
<link rel="stylesheet" href="{{url('/')}}/front/fonts/flaticon/font/flaticon.css">
 <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />







 <!-- Magnific Popup -->

 <!-- Flexslider  -->

 <!-- Owl Carousel -->


 <!-- Flaticons  -->
 <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">


 <!-- Modernizr JS -->
 <script src="/front/js/modernizr-2.6.2.min.js"></script>
@extends('front_hotel.index_layout')

@section('content')

    <!-- slider -->
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
      @if($org->front_image!=null)


    <div class="slider-home"  style="background:url('{{asset(\App\Photo::find($org->front_image)->file)}}');background-size:cover;">

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
                <p class="no_offers">  </p>
              @endif
           </div>

					 <div id="colorlib-reservation">
					 	<div class="container">
					 		<div class="row">
					 			<div class="col-md-12 search-wrap">
					 				<form method="post" class="colorlib-form">
					 								<div class="row">
					 								<div class="col-md-3">
					 									<div class="form-group">
					 										<label for="date">Check-in:</label>
					 										<div class="form-field">
					 											<i class="icon icon-calendar2"></i>
					 											<input type="text" id="date_in" class="form-control datepicker " placeholder="Check-in date">
					 										</div>
					 									</div>
					 								</div>
					 								<div class="col-md-3">
					 									<div class="form-group">
					 										<label for="date">Check-out:</label>
					 										<div class="form-field">
					 											<i class="icon icon-calendar2"></i>
					 											<input type="text" id="date_out" class="form-control datepicker" placeholder="Check-out date">
					 										</div>
					 									</div>
					 								</div>
					 								<div class="col-md-2">
					 									<div class="form-group">
					 										<label for="adults">Adults</label>
					 										<div class="form-field">
					 											<i class="icon icon-arrow-down3"></i>
					 											<select name="people1" id="people1" class="form-control">
					 												<option value="1">1</option>
    					 												<option value="2">2</option>
    					 												<option value="3">3</option>
    					 												<option value="4">4</option>
    					 												<option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                        <option value="8">8</option>
                                                                        <option value="9">9</option>
                                                                        <option value="10">10</option>
					 											</select>
					 										</div>
					 									</div>
					 								</div>
					 								<div class="col-md-2">
					 									<div class="form-group">
					 										<label for="children">Children</label>
					 										<div class="form-field">
					 											<i class="icon icon-arrow-down3"></i>
					 											<select name="people2" id="people2" onchange="child()" class="form-control">
                                                                      <option value="1">1</option>
                                                                      <option value="2">2</option>
                                                                      <option value="3">3</option>
                                                                      <option value="4">4</option>
                                                                      <option value="5">5</option>
                                                                      <option value="6">6</option>
                                                                      <option value="7">7</option>
                                                                      <option value="8">8</option>
                                                                      <option value="9">9</option>
                                                                      <option value="10">10</option>
					 											</select>
					 										</div>
					 									</div>
                           
					 								</div>
					 							
					 								  <div  id="child_input"></div>  

													<div class="col-md-2">
					 									<div class="form-group">
					 										<label for="Destinatons">Destinatons</label>
					 										<div class="form-field">
					 											<i class="icon icon-arrow-down3"></i>
					 											<select name="" id="" class="form-control js-select">
					 											    <option value="0">{{__('strings.all')}}</option>
																	@foreach($destinatons as $destinaton)
					 												<option value="{{$destinaton->id}}">{{ app()->getLocale()== 'ar' ? $destinaton->name :$destinaton->name_en}}</option>

																	@endforeach
					 											</select>
					 										</div>
					 									</div>
					 								</div>
					 								<div class="col-md-2">
					 									<input type="submit" name="submit" id="submit" value="Search" class="btn btn-primary btn-block">
					 								</div>
					 							</div>
					 						</form>
					 			</div>
					 		</div>
					 	</div>
					 </div>
       </div> <!-- // slider -->


    <!-- latest product -->
    <div class="latest_product">
        <div class="container">
            <div class="all_title">
                 @php
             $labels=\App\ActivityLabelSetup::where(['type'=>item_service,'activity_id'=>$org->activity_id ])->first();
                 @endphp
                <h1 class="wow fadeInDown" data-wow-delay="0.20s">{{app()->getLocale() == 'ar' ? $labels->value : $labels->value_en}}</h1>
                <p class="wow fadeInUp" data-wow-delay="0.20s">Our latest destinatons  of 	{{ app()->getLocale() == 'ar' ? $org->name : $org->name_en}}..</p>
            </div>

            <div class="items_product">
                <div class="row">
									@php
									$i=0;
									@endphp
                 @foreach($destinatons as $destinaton)
								 @php
								 $i++;
								 @endphp
								 @if($i<=8)
                    <div class="col-md-3 col-sm-6 col-xs-6">
                     <div class="item_pro wow fadeIn" data-wow-delay="0.20s">
                       <a href="details/{{ $destinaton->id }}"> <img src="{{asset(str_replace(' ', '%20', \App\Photo::find($destinaton->image)->file))}}"></a>
                       <h3>{{app()->getLocale() == 'ar' ?  $destinaton->name :   $destinaton->name_en  }} </br> Rooms start from {{ $destinaton->price_start }} </br>  
                      @if($destinaton->video_id) <a  href="{{ \App\Video::findOrFail($destinaton->video_id)->file  }}" target="_blank">play video</a></br>@endif 
                       <a  class="map-link" data-title="{{$destinaton->id}}" href="https://maps.google.com/?q={{$destinaton->latitude}},{{$destinaton->longitude}}" target="_blank"> <i class="fas fa-map-marker-alt"></i></a>   </h3>
					   

                     </div>
                 </div>
								@endif
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
                <p class="wow fadeInUp" data-wow-delay="0.20s">Our best seller of	{{ app()->getLocale() == 'ar' ? $org->name : $org->name_en}}..</p>
            </div>

            <div class="items_product">

                     @if(count($best_selers))
                     <div class="owl-carousel owl-theme" id="sliderSeller">
                    @foreach($best_selers as $best_seler)
                    <div class="item">
                        <div class="item_pro wow fadeIn" data-wow-delay="0.20s">
                           <a href="details/{{ $best_seler->id }}"><img src="{{asset(str_replace(' ', '%20', \App\Photo::find($best_seler->photo_id)->file))}}"></a>

                            <h3>{{app()->getLocale() == 'ar' ?  $best_seler->name :   $best_seler->name_en}}</h3>
                          @if(cat_price($best_seler->id)['offer_price']>0)
                            <div class="price_add">
                                <h6>{{ cat_price($best_seler->id)['offer_price'] }}</h6>
                                <h6>{{ cat_price($best_seler->id)['original_price'] }}</h6>
                                   @if($show_cart)
                                <a href="#" data-name="{{app()->getLocale() =='ar' ? $best_seler->name :
                                    $best_seler->name_en}}" data-price="{{ $best_seler->offer_price}}"  data-id="{{ $best_seler->id}}" data-description="{{app()->getLocale() =='ar' ? $best_seler->description : $best_seler->description_en}}" class="add-to-cart btn btn-primary">  <i class="fas fa-cart-plus"></i>add to cart </a>
                                @endif
                            </div>
                            @else
                            <div class="price_add">
                                  <h6>{{cat_price($best_seler->id)['original_price']}}</h6>
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


 
<script src="{{url('/')}}/front/js/jquery.min.js"></script>
<script src="{{url('/')}}/front/js/jquery.easing.1.3.js"></script>
<script src="{{url('/')}}/front/js/jquery.easing.1.3.js"></script>
<script src="{{url('/')}}/front/js/bootstrap2.min.js"></script>
<script src="{{url('/')}}/front/js/jquery.waypoints.min.js"></script>
<script src="{{url('/')}}/front/js/jquery.flexslider-min.js"></script>
<script src="{{url('/')}}/front/js/owl.carousel1.min.js"></script>

<script src="{{url('/')}}/front/js/jquery.magnific-popup.min.js"></script>
<script src="{{url('/')}}/front/js/magnific-popup-options.js"></script>

<script src="{{url('/')}}/front/js/bootstrap-datepicker.js"></script>
<script src="{{url('/')}}/front/js/main2.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<!-- jQuery Easing -->
<!-- Bootstrap -->
<!-- Waypoints -->
<!-- Owl carousel -->
<!-- Magnific Popup -->
<!-- Date Picker -->
<!-- Main -->

    <script>
        $('.js-select').select2();
        $('.datepicker').datepicker();
        
        
        function child(){

   console.log($('select[name="people2"]').val());
   $('#child_input').empty();
   for(var i=1;i<=$('select[name="people2"]').val();i++){
     $('#child_input').append(' <div class="col-md-3"><label >child age </label> <input class="form-control"  type="number" name="child_age"></div> ');


   }
 }
        
    </script>

    @endsection

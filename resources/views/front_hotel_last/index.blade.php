@extends('front_hotel_last.master')
@section('content')
	<section id="search_container">
		<div id="search">
			<div class="tab-content">
				<div class="tab-pane active show" id="tours">
					<h3>@lang('strings.search_now')</h3>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>@lang('strings.destination')</label>
								<input type="text" class="form-control" id="firstname_booking" name="firstname_booking" list="distintations" placeholder="@lang('strings.select_dist')">
								<datalist id="distintations">
									@foreach($destinatons as $d)
								    <option value="{{app()->getLocale()== 'en' ?  $d->name_en : $d->name}}">
								    @endforeach
								</datalist>
							</div>
						</div>
					</div>
					<!-- End row -->
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label><i class="icon-calendar-7"></i> @lang('strings.check_in')</label>
								<input class="date-pick form-control" data-date-format="M d, D" type="text">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label><i class=" icon-clock"></i> @lang('strings.check_out')</label>
								<input class="date-pick form-control" data-date-format="M d, D" type="text">
							</div>
						</div>
						<div class="col-md-2 col-sm-3 col-6">
							<div class="form-group">
								<label>@lang('strings.adults_no')</label>
								<input type="number" max="10" min="0" value="1" id="adults" class="form-control" name="adults">
							</div>
						</div>
						<div class="col-md-2 col-sm-3 col-6">
							<div class="form-group">
								<label>@lang('strings.no_children')</label>
								<select id="children_count" class="form-control" name="children">
									@for($i=0;$i<11;$i++)
									<option value="{{$i}}">{{$i}}</option>
									@endfor
								</select>
							</div>
						</div>

					</div>
					<div class="row" id="age_cont">
						<div class="col-sm-12">
							<h4>@lang('strings.children_ages') :</h4>
						</div>
					</div>
					<!-- End row -->
					<hr>
					<button class="btn_1 green"><i class="icon-search"></i>@lang('strings.search_now')</button>
				</div>
				<!-- End rab -->
			</div>
		</div>
	</section>
	<!-- End hero -->

	<main>
	<div class="container margin_60">
    
        <div class="main_title">
            <h2>@lang('strings.our_latest')<span> @lang('strings.destinatons') </span> {{ app()->getLocale()== 'ar' ?  $org_id->name : $org_id->name_en }}</h2>
        </div>
        
        <div class="row">
        @php
		$i=0;
		@endphp
		@foreach($destinatons as $d)
	 	@php
	 	$i++;
	 	@endphp
	 	@if($i<=8)
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
                <div class="tour_container">
					<div class="ribbon_3 popular"><span>@lang('strings.popular')</span></div>
                    <div class="img_container">
                        <a  class="map-link" data-title="{{$destinaton->id}}" href="https://maps.google.com/?q={{$destinaton->latitude}},{{$destinaton->longitude}}" target="_blank"> <i class="fas fa-map-marker-alt"></i></a>
                        <a href="/details/{{ $d->id }}">
                        <img src="{{asset(str_replace(' ', '%20', \App\Photo::find($d->image)->file))}}" class="img-fluid" alt="Image" width="400px" style="height:300px">
                        <div class="short_info">
                            <span class="price"><sup>$</sup>{{ $d->price_start }}+</span>
                        </div>
                        </a>
                    </div>
                    <div class="tour_title">
                        <h3><strong>{{app()->getLocale() == 'ar' ?  $d->name :   $d->name_en  }} </strong></h3>
                        <!--<div class="rating">
                            <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                        </div>-->
                    </div>
                </div><!-- End box tour -->
            </div><!-- End col -->
        @endif
        @endforeach
        </div><!-- End row -->
		
    </div><!-- End container -->
    
    <div class="white_bg">
			<div class="container margin_60">
				<div class="main_title">
					<h2>@lang('strings.our') <span>@lang('strings.new_offers') </span>{{ app()->getLocale() == 'ar' ? $org_id->name : $org_id->name_en}}</h2>
				</div>
				<div class="row">
				@foreach($offers as $k=>$b)
		            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
		                <div class="tour_container">
		                    <div class="img_container">
		                        <a href="/details/{{ $b->id }}">
		                        <img src="{{asset(str_replace(' ', '%20', \App\Photo::find($b->image)->file))}}" class="img-fluid" alt="Image" width="400px" style="height:300px">
		                        <div class="short_info">
		                        	@if(count($days[$k])>0)
		                        	<span class="price">
		                        		<small>
		                        			@lang('strings.av_days')
		                        			@foreach($days[$k] as $c=>$day)
		                        			@switch($day->day)
											    @case(1)
											        @lang('strings.Saturday')
											        @break
											    @case(2)
											        @lang('strings.Sunday')
											        @break
											    @case(3)
											        @lang('strings.Monday')
											        @break
											    @case(4)
											        @lang('strings.Tuesday')
											        @break
											    @case(5)
											        @lang('strings.Wednesday')
											        @break
											    @case(6)
											        @lang('strings.Thursday')
											        @break
											    @case(7)
											        @lang('strings.Friday')
											        @break
											@endswitch
											@if($c!=count($days[$k])-1)
											-
											@endif
		                        			@endforeach
		                        		</small>
		                        	</span>
		                        	@else
		                            <span class="price"><small>{{$b->nights}} @lang('strings.nights')</small></span>
		                        	@endif
		                        </div>
		                        </a>
		                    </div>
		                    <div class="tour_title">
		                        <h3><strong>{{app()->getLocale() == 'ar' ?  $b->name :   $b->name_en}} </strong></h3>
		                        <button class="btn btn-primary" style="position: absolute;{{app()->getLocale()=='ar'?'left':'right'}}: 5px;top: 5px;">@lang('strings.see_more')</button>
		                    </div>
		                </div><!-- End box tour -->
		            </div><!-- End col -->
		        @endforeach
		    	</div>
		        @if(count($offers)==0)
		        <h3>@lang('strings.noOffers2')</h3>
		        @endif
			</div>
			<!-- End container -->
		</div>
		<!-- End white_bg -->

		<div class="container margin_60">

			<div class="main_title">
				<h2>@lang('strings.Latest_news')</h2>
			</div>
			<div class="items_news">
              @if(count($news)>0)
              <div class="row">
              		@foreach($news as $new)
					<div class="col-lg-4 col-md-6 text-center">
						<p>
							<a href="#"><img src="{{asset(str_replace(' ', '%20', \App\Photo::find($new->image_id)->file))}}" alt="Pic" class="img-fluid" width="150px"></a>
						</p>
						<h4>{{app()->getLocale() == 'ar' ?  $new->news_title :   $new->news_title_en}}</h4>
						<p>
							{{  app()->getLocale() == 'ar' ?  $new->news_desc : $new->news_desc_en}}
						</p>
					</div>
					@endforeach
				</div>
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
                <h3>  @lang('strings.noOffers3') </h3>
                @endif

            </div>
			       
    	</div>
		<!-- End container -->
    </main>
	<!-- End main -->
@stop
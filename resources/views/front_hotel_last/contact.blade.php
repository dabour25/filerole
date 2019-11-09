@extends('front_hotel_last.master')
@section('content')
<main>
	<div id="map_contact" class="contact_2">
		<div class="mapouter">
			<div class="gmap_canvas">
				<iframe width="800" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q={{$location->latitude}},{{$location->longitude}}&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
				</iframe>
			</div>
			<style>.mapouter{position:relative;text-align:right;height:100%;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;height:100%;width:100%;}
			</style>
		</div>
	</div>


	<!-- end map-->
	<div id="directions">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<form action="http://maps.google.com/maps" method="get" target="_blank">
						<div class="input-group">
							<input type="text" name="saddr" placeholder="@lang('strings.start_point')" class="form-control style-2" />
							<input type="hidden" name="daddr" value="{{$location->latitude}},{{$location->longitude}}" />
							<!-- Write here your end point -->
							<span class="input-group-btn">
								<button class="btn" type="submit" value="Get directions" style="margin-left:0;">@lang('strings.get_directions')</button>
							</span>
						</div>
						<!-- /input-group -->
					</form>
				</div>
			</div>
		</div>
	</div>

		<div id="position">
			<div class="container">
				<ul>
					<li><a href="/">@lang('strings.Home')</a></li>
					<li><a href="/contact">@lang('strings.contact_us')</a></li>
				</ul>
			</div>
		</div>
		<!-- End Position -->

		<div class="container margin_60">
			<div class="row">
				<div class="col-md-8">
					<div class="step">

						<div id="message-contact"></div>
						<form action="{{url('/frontmessage') }}" method="post">
							@csrf
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<input type="text" class="form-control" id="name_contact" name="name" placeholder="@lang('strings.Name')">
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<input type="email" class="form-control" id="lastname_contact" name="email" placeholder="@lang('strings.Email')">
									</div>
								</div>
							</div>
							<!-- End row -->
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<input type="text" id="email_contact" name="subject" class="form-control" placeholder="@lang('strings.subject')">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<textarea rows="5" id="message_contact" name="message" class="form-control" placeholder="@lang('strings.message')" style="height:200px;"></textarea>
									</div>
								</div>
							</div>
							<button type="submit" class="btn btn-info">@lang('strings.send')</button>
						</form>
					</div>
				</div>
				<!-- End col-md-8 -->

				<div class="col-md-4">
					<div class="box_style_1">
						<h4>@lang('strings.address') <span><i class="icon-pin pull-right"></i></span></h4>
						<p>
							{{$org_id->address}}
						</p>
						<hr>
						<h4>@lang('strings.contact_us') <span><i class="icon-help pull-right"></i></span></h4>
						<ul id="contact-info">
							<li>{{$org_id->mobile1}}/{{$org_id->mobile2}}</li>
							<li><a href="mailto:{{$org_id->email}}">{{$org_id->email}}</a>
							</li>
						</ul>
					</div>
					<div class="box_style_4">
						<i class="icon_set_1_icon-57"></i>
						<h4>@lang('strings.need_help')</h4>
						<a href="tel:{{$org_id->phone}}" class="phone">{{$org_id->phone}}</a>
						<small>{{$org_id->work_time}}</small>
					</div>
				</div>
				<!-- End col-md-4 -->
			</div>
			<!-- End row -->
		</div>
		<!-- End container -->
	</main>
	<!-- End main -->
@stop
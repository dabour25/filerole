@extends('front_hotel_last.master')
@section('content')
<section class="parallax-window" data-parallax="scroll" data-image-src="img/header_bg.jpg" data-natural-width="1400" data-natural-height="470">
	<div class="parallax-content-1">
		<div class="animated fadeInDown">
			<h1>@lang('strings.about_us')</h1>
			<p>@lang('strings.about_text1')</p>
		</div>
	</div>
</section>
<!-- End Section -->

<main>
	<div id="position">
		<div class="container">
			<ul>
				<li><a href="/">@lang('strings.Home')</a>
				</li>
				<li><a href="/aboutus">@lang('strings.about_us')</a>
				</li>
			</ul>
		</div>
	</div>
	<!-- End Position -->

	<div class="container margin_60">

		<div class="main_title">
			<h2>@lang('strings.about_us')</h2>
		</div>
		<h5>{{app()->getLocale() == 'ar' ?  $org_id->about_us:  $org_id->aboutus_en}}</h5>
		<hr>
		<div class="main_title">
			<h2>@lang('strings.about_text2')</h2>
		</div>
		<h5>{{app()->getLocale() == 'ar' ?  $org_id->description:  $org_id->description_en}}</h5>
		<hr>
		<div class="main_title">
			<h2>@lang('strings.contact_us')</h2>
		</div>
		<h5>@lang('strings.about_text3')</h5>
	</div>
	<!-- End Container -->
</main>
<!-- End main -->
@stop
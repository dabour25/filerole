<!DOCTYPE html>
<html lang="ar">

<head>
	<title>FileRole Booking Front</title>
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<meta name="keywords" content="filerole, programs, startup" />

        @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{url('/')}}/front/css/bootstrap-rtl.min.css">
        @else
        <link rel="stylesheet" href="{{url('/')}}/front/css/bootstrap.css">
        @endif

        @if(app()->getLocale() == 'ar')
        <link href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700,900" rel="stylesheet">
        @else
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
        @endif
        <link rel="icon" href="{{ asset('favicon.png') }}">

		<!-- Web Fonts -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

	    <!-- Style-CSS -->
		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    	<link rel="stylesheet" href="{{url('/')}}/front/css/animate.min.css">
    	<link rel="stylesheet" href="{{url('/')}}/front/css/owl.carousel.min.css">
      <link rel="stylesheet" href="{{ asset('public/front/intlTelInput.css') }}">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/css/fileinput.min.css">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/css/intlTelInput.css">

        @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{url('/')}}/front/css/style-ar.css">
        @else
        <link rel="stylesheet" href="{{url('/')}}/front/css/style-en.css">
        @endif

		<!-- js head -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script>
				new WOW().init();
		</script>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.js"></script>

		<script src="{{ asset('public/front/intlTelInput.js') }}"></script>

<script>
var input = document.querySelector("#phone");
window.intlTelInput(input);
</script>

</head>

<body>

  @php
   $my_url=url()->current();
   $last = explode('/', $my_url);
   $org_id=DB::table('organizations')->where('customer_url',$last[2])->first();
   @endphp

		<!-- login popup -->
		<div class="all_pop" id="login">
				<div class="login">
						<a href="#" onclick="closeLogin()" class="close_log"> <i class="fas fa-times"></i>  </a>
						<h3>SIGN IN YOUR ACCOUNT</h3>
						<form action="{{url('weblogin') }}"  method="post">
								<label> @lang('strings.Email') </label>
								<input type="email" placeholder="Example@email.com" name="login_email" required>
								<label> @lang('strings.New_password') </label>
								<input type="password" placeholder="*****" name="login_passowrd" required>
								<div class="input-group">
										<input type="checkbox"> <label> REMEMBER ME </label>
								</div>
								<button type="submit" class="btn btn_submit"> @lang('strings.Login')</button>
						</form>
						<a class="forgot_pass" href="#" onclick="showforgot()"> FORGOT YOUR PASSWORD? </a>
				</div>
		</div> <!-- // login popup -->

		<!-- register popup -->
		<!-- // register popup -->

		<div class="all_pop" id="register">
				<div class="login register">
						<a href="#" onclick="closeReg()" class="close_log"> <i class="fas fa-times"></i>  </a>
						<h3>CREATE ACCOUNT</h3>
						<form action="{{url('CreateCustomer')}}" method="post" id ="registerForm">
								<div class="row">
										<div class="col-md-6 col-xs-12">
										<label>@lang('strings.user_name') </label>
										<input type="text" placeholder="john" name="name"  id ="name" required>
										 <div id="name_error"></div>
										</div>
										<div class="col-md-6 col-xs-12">
										<label>@lang('strings.Email') </label>
										<input type="email" placeholder="Example@email.com" name="email" id="email" required>
		                 <div id="email_error"></div>
										</div>
										<div class="col-md-6 col-xs-12">
										<label>@lang('strings.Address') </label>
										<input type="text" name="address"  id ="address" required>
										 <div id="address_error"></div>
										</div>
										<div class="col-md-6 col-xs-12">
										<label>@lang('strings.phone') </label>
									<input type="tel" id="phone" name="phone" id="phone" required>

									<span id="valid-msg" class="hide">✓ Valid</span>
									 <div id="phone_error"></div>
									 <span id="error-msg" class="hide"></span>
										</div>
										<div class="col-md-6 col-xs-12">
										<label>{{ __('strings.Gender') }}</label>
										<select class="form-control" name="gender">
												<option value="1" selected>{{ __('strings.Male') }}</option>
												<option value="0"  >{{ __('strings.Female') }}</option>
										</select>
										</div>
										<div class="col-md-6 col-xs-12">
										<label>@lang('strings.New_password') </label>
										<input type="password" placeholder="*****" name="password"  id="password" required>
		               	<div id="passwd_error"></div>
										</div>
										<div class="col-md-6 col-xs-12">
										<label> @lang('strings.Password_confirmation') </label>
										<input type="password" placeholder="*****" name="confirm_passowrd" id='confirm_passowrd' required>

										<div id="passwd_error"></div>
										</div>
								</div>
							<button type="submit" class="btn btn_submit">@lang('strings.register')</button>
						</form>
						<a href="#" class="forgot_pass" onclick="showfromreg()"> ALREADY HAVE AN ACCOUNT? </a>
				</div>
		</div>



		<!-- forgot popup -->
		<div class="all_pop" id="forgot">
				<div class="login register forgot">
						<a href="#" onclick="closeforgot()" class="close_log"> <i class="fas fa-times"></i>  </a>
						<h3>FORGOT YOUR DETAILS?</h3>
						<form action="{{url('password/email')}}" method="post">
								<label> USERNAME OR EMAIL </label>
								<input type="text" placeholder="..." name="email" required>
								<button type="submit" class="btn btn_submit">SEND MY DETAILS!</button>
						</form>
						<a href="#" class="forgot_pass" onclick="showfromgot()"> I REMEMBER NOW! </a>
				</div>
		</div> <!-- // forgot popup -->

		<!-- success_cart popup -->
		<div class="all_pop" id="success_cart">
				<div class="login register success_cart">
						<a href="#" onclick="closeCart()" class="close_log"> <i class="fa fa-times"></i>  </a>
						<h3>success</h3>
						<p>C1 - 6.2-inch 16GB Mobile Phone - Mirror Black added to cart</p>
						<a href="#" class="con_shop" onclick="closeCart()"> Continue Shopping </a>
						<a href="cart.html" class="check_shop"> View Cart and Checkout </a>
				</div>
		</div> <!-- // success_cart popup -->
		@if(session()->has('message'))
		    <div class="alert alert-success">
		        {{ session()->get('message') }}
		    </div>
		@endif

		<!-- header -->
		<div class="header">

				<div class="overlay-nav"></div>

				<div class="container">

						<!-- main header -->
						<div class="main-header">

								<!-- top header -->
								<div class="top-header">
										<div class="row">

												<!-- left links -->
												<div class="col-md-6 col-xs-6">

														<!-- social -->
														<div class="social">
																<ul>
																		<li> <a href="{{$org_id->facebook}}" target="_blank"> <i class="fab fa-facebook-f"></i> </a> </li>
																		<li> <a href="{{$org_id->twitter}}" target="_blank"> <i class="fab fa-twitter"></i> </a> </li>
																		<li> <a href="{{$org_id->instgram}}" target="_blank"> <i class="fab fa-instagram"></i> </a> </li>
																</ul>
														</div>

														<!-- call us -->
														<p class="call"> QUESTIONS? CALL : <a href="tel:0220187656"> 	{{  $org_id->phone }} <i class="fa fa-phone"></i> </a> </p>

												</div>

												<!-- right links -->
												<div class="col-md-6 col-xs-6">
														<ul class="nav">
																<!-- language -->
																<li class="dropdown">
																	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																			<span class="fas fa-globe xs-icon"></span>
																			@lang('strings.language')
																	</a>
																	<ul class="dropdown-menu">

																		@if(app()->getLocale() == 'ar')
                            		                                    <li class="active"><a href="{{ url('lang/ar') }}">{{ __('strings.Arabic') }}</a></li>
                            		                                    <li><a href="{{ url('lang/en') }}">{{ __('strings.English') }}</a></li>
																		@else
                    				                                    <li><a href="{{ url('lang/ar') }}">{{ __('strings.Arabic') }}</a></li>
                    				                                    <li class="active"><a href="{{ url('lang/en') }}">{{ __('strings.English') }}</a>
																		</li>
																		@endif
																	</ul>
																</li>

																@if(Auth::guard('customers')->check())
															 	 <li class="dropdown">
															 		 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
															 				 <span class="fas fa-globe xs-icon"></span>
															 				 @lang('strings.Settings')
															 		 </a>
															 		 <ul class="dropdown-menu">


															 																		
  @php
  $id=Auth::guard('customers')->user()->id;
  @endphp
                                                                                                                                           <li ><a href='{{ url("/customerprofile/$id") }}'>روية الملف الشخصى</a></li>
                                                                                                                                           <li ><a href="{{ url('/customerdashboard') }}">روية dashboard</a></li>
																																		  <li><a href="{{ route('changePassword') }}">تغير كلمة السر</a></li>
															 																			  <li><a href="{{ url('logoutCustomer') }}">خروج</a></li>

															 		 </ul>
															 	 </li>


																@else
																	<!-- Register -->
																	<li>
																			<a href="#" onclick="showReg()"><i class="fas fa-user-plus"></i>	@lang('strings.register') </a>
																	</li>

																	<!-- login -->
																	<li>
																			<a href="#" onclick="showLogin()"><i class="fas fa-sign-in-alt"></i> 	@lang('strings.Login')</a>
																	</li>


																@endif


																<!-- search -->
																<li id="search" class="header-search">
																		<!-- open search button -->
																		<a href="#" class="searchBtn" id="open_search" onclick="showsearch()">
																				<i class="fas fa-search white-icon"></i>
																		</a>
																		<!-- close search button -->
																		<a href="#" class="searchBtn" id="close_search" onclick="closesearch()">
																				<i class="fas fa-times"></i>
																		</a>

																		<!-- search div hide untel click in button -->
																		<div id="search_container">
																				<form id="searchform" class="header-searchform" action="#" method="get" target="_blank">
																						<input maxlength="20" class="inputbox" type="text" size="20" placeholder="search ...">
																						<button type="submit" id="searchsubmit" class="searchsubmit fas fa-search white-icon"></button>
																				</form>
																		 </div>
																</li>

														</ul>
												</div>

										</div>
								</div>

								<!-- logo - navbar -->
								<div class="navbar-logo">
										<div class="row">

												<!-- logo -->
												<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
														<div class="logo">
																<a href="#">
																	{{ app()->getLocale() == 'ar' ? $org_id->name : $org_id->name_en}}
																</a>
														</div>
														<div class="open_menu visible-xs">
																<a href="#" onclick="openNav()"> <i class="fas fa-bars"></i> </a>
														</div>
												</div>

												<!-- navbar -->
												<div class="col-lg-8 col-md-10 col-sm-10 col-xs-12">
														<div class="nav-bar">
																<ul>
																		<li class="for-mobile">
																				<a href="#" onclick="closeNav()">
																						Back  <i class="fas fa-times"></i>
																				</a>
																		</li>
																	   <li> <a href="{{url('/') }}"> @lang('strings.Home') </a> </li>
																			<li> <a href="{{url('/offers') }}"> @lang('strings.Offers') </a> </li>
																			<li> <a href="{{url('/categorys') }}"> @lang('strings.cat_ser')  </a> </li>
																			<li> <a href="{{url('/aboutus') }}"> @lang('strings.about_us')  </a> </li>
																			<li> <a href="{{url('/contact') }}"> @lang('strings.contact_us')</a> </li>
																</ul>
														</div>
												</div>

												<!-- cart -->
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
														<div class="cart">
																<ul>
																		<li class="dropdown">
																			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																					<i class="fas fa-shopping-cart"></i>
																					<span class="badge">2</span>
																			</a>
																			<ul class="dropdown-menu">
																				<li>
																					<a href="#" class="img-pro"> <img src="images/best1.jpeg" alt="product"> </a>
																					<a href="#"> make-up package color </a>
																					<p class="price"> 2 x 400 S.R </p>
																					<a href="#" class="remove" title="Remove this item">×</a>
																				</li>
																				<div class="total">
																						<p> Subtotal: <span> 400 S.R </span> </p>
																				</div>
																				<div class="buttons-cart">
																						<a href="#" class="view_cart"> View Cart </a>
																						<a href="{{url('/cart') }}" class="check_cart"> check out </a>
																				</div>
																			</ul>
																		</li>
																</ul>
														</div>
												</div>


										</div>
								</div>

						</div> <!-- // main-header  -->

				</div> <!-- // container  -->
		</div> <!-- // header -->
		<script type="text/javascript" src="{{url('/')}}/front/js/jq.validate.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/fileinput.min.js"></script>
		<script>
		var x = document.getElementById("demo");

		function getLocation() {
		  if (navigator.geolocation) {
		    navigator.geolocation.getCurrentPosition(showPosition);
		  } else {
		    console.log('Geolocation is not supported by this browser');
		  }
		}

		function showPosition(position) {
		  console.log(position.coords);
		}

		</script>
		<script>
		    function scrollup() {
		        window.scrollTo(100, document.body.scrollHeight);
		    };

		    function scrolldowncheck() {
		        window.scrollTo(100, document.body.scrollHeight);
		    }
		</script>
		<script type="text/javascript">

		$("#registerForm").validate({
				errorClass: "has-error",
				validClass: "has-success",
				rules: {

						"name": {
								required: true,
								maxlength: 255
						},

						"email": {
								required: true,
								email: true,
								remote: {
										url: "checkCustomer",
										type: "get",
										data: {
												"email": function() {
														return $("#email").val();
										}
									},
										beforeSend: function() {
												$('#subok').hide();
												$('#subcancel').hide();
												$('#subdomain_loading').show();
										}, complete: function(response) {

												if ($("#email").hasClass('has-success')) {
														//   $("#email_div").addClass("has-success");
														// load_suggest($("#SiteEmail").val(), 'email');

														$('#email_error').html('');
												} else {
														//    $("#email_div").addClass("has-error");
														// load_suggest();


												}

										}
								}
							},

							"phone": {
									required: true,
									phone: true,
									remote: {
											url: "checkCustomer",
											type: "get",
											data: {
													"phone": function() {
															return $("#phone").val();
											}
										},
											beforeSend: function() {

											}, complete: function(response) {

													if ($("#phone").hasClass('has-success')) {
															//   $("#email_div").addClass("has-success");
															// load_suggest($("#SiteEmail").val(), 'email');

															$('#phone_error').html('');
													} else {
															//    $("#email_div").addClass("has-error");
															// load_suggest();
														

													}

											}
									}
								},
						"password": {
								required: true,
								minlength: 6
						},
						"confirm_passowrd": {
								required: true,
								equalTo: "#password"
						}
				},

				messages: {
						//"data[Site][business_name]": "من فضلك ادخل اسم الشركة",

						"name": {
								required:"{{trans('admin.name_required')}}",
								maxlength : "{{trans('admin.max_length_validate')}}"
						},
						"address": {
								required:"{{trans('admin.name_required')}}",
								maxlength : "{{trans('admin.max_length_validate')}}"
						},
						"phone": {
								required:"{{trans('admin.name_phone')}}",
								maxlength : "{{trans('admin.max_length_validate')}}"
						},
						"email":{
						required  : "{{trans('admin.email_required_validation')}}",
						remote:"{{trans('admin.email_validate')}}"
					},

						"password": {
								required :"{{trans('admin.password_required')}}",
								minlength : "{{trans('admin.password_minlength')}}"
						},
						"confirm_passowrd": "{{trans('admin.password_confirmation_validation')}}",
						"email":{
						required  : "{{trans('admin.email_required_validation')}}",
						remote:"{{trans('admin.email_validate')}}"
					},

				}, errorPlacement: function(error, element) {
						 if (element.attr('id') == 'email') {
								$('#email_error').html('<div class="error-message">' + error.html() + '</div>');
								error.remove();
						}
						 else if (element.attr('id') == 'name') {
							$('#name_error').html('<div class="error-message">' + error.html() + '</div>');
										error.remove();
						} else if (element.attr('id') == 'password') {
								$('#password_error').html('<div class="error-message">' + error.html() + '</div>');
								error.remove();
						} else if (element.attr('id') == 'confirm_passowrd') {
								$('#passwd_error').html('<div class="error-message">' + error.html() + '</div>');
								error.remove();
						}else if (element.attr('id') == 'phone') {
								$('#phone_error').html('<div class="error-message">' + error.html() + '</div>');
								error.remove();
						} else if (element.attr('id') == 'address') {
								$('#address_error').html('<div class="error-message">' + error.html() + '</div>');
								error.remove();
						}
						else {
							 element.next().remove();
							 error.insertAfter("#" + element.attr('id'));
					 }





				}, success: function(label, element) {
						label.addClass("has-success");
						var myid = label.attr('for');

						if (myid == 'name') {

								$('#name_error').html('');

						} else if (myid == 'email') {

								$('#email_error').html('');

						}else if (myid == 'password') {

								$('#password_error').html('');

						}else if (myid == 'confirm_passowrd') {

								$('#passwd_error').html('');

						}else if (myid == 'phone') {

								$('#phone_error').html('');

						}else if (myid == 'address') {

								$('#address_error').html('');

						}

				}
		});

	</script>

	<script>

		var input = document.querySelector("#phone"),
				errorMsg = document.querySelector("#error-msg"),
				validMsg = document.querySelector("#valid-msg");

		// here, the index maps to the error code returned from getValidationError - see readme
		var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

		// initialise plugin
		var iti = window.intlTelInput(input, {
				initialCountry: "auto",
				geoIpLookup: function (callback) {
						$.get('https://ipinfo.io', function () {
						}, "jsonp").always(function (resp) {
								var countryCode = (resp && resp.country) ? resp.country : "";
								callback(countryCode);
						});
				},
				utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/utils.js"
		});

		var reset = function () {
				input.classList.remove("error");

				errorMsg.innerHTML = "";
				$('#valid-msg').empty();


		};

		// on blur: validate
		input.addEventListener('blur', function () {
				reset();
				if (input.value.trim()) {
						if (iti.isValidNumber()) {
								validMsg.classList.remove("hide");
						} else {
								input.classList.add("error");
								var errorCode = iti.getValidationError();
								errorMsg.innerHTML = errorMap[errorCode];
								errorMsg.classList.remove("hide");
						}
				}
		});

		// on keyup / change flag: reset
		input.addEventListener('change', reset);
		input.addEventListener('keyup', reset);




</script>

<!DOCTYPE html>
<html lang="ar">
@php

$my_url=url()->current();
$last = explode('/', $my_url);
$org_id=DB::table('organizations')->where('customer_url',$last[2])->first();
@endphp

<head>
	<title>{{ app()->getLocale()== 'ar' ?  $org_id->name : $org_id->name_en }}</title>
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<meta name="keywords" content="filerole, programs, startup" />
	 <meta name="csrf-token" content="{{ csrf_token() }}" />


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
        <!--<link rel="stylesheet" href="{{url('/')}}/front/css/colors.css">-->

		<!-- js head -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script>
				new WOW().init();
		</script>
        @if(!empty($org_id))
        <style>
            .btn-submit,.btn_submit,.join_us a,.nav-page-caty .nav-link.active,
            .contactus button,.all_pop form button {
                @if(!empty($org_id->second_color))
                background: {{ $org_id->second_color }} !important;
                @else
                background: #565656;
                @endif
            }
            .all_pop h3,.join_us h3 {
                @if(!empty($org_id->main_color))
                color: {{ $org_id->main_color }} !important;
                @else
                color:#565656;
                @endif
            }
        </style>
        @endif
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.js"></script>

		<script src="{{ asset('public/front/intlTelInput.js') }}"></script>

<script>
var input = document.querySelector("#phone_number");
window.intlTelInput(input);
</script>

</head>

<body>
    
<div id="myModalpass" class="modal fade" role="dialog">
  <div class="modal-dialog">
      @php
      $id=Auth::guard('customers')->user()->id;
      @endphp
    <!-- Modal content-->
    
    <div class="modal-content">
		<div class="all_pop all_pop2">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h3> @lang('strings.change_password')   </h3>
					
						<form action="{{ url('password/update/'.$id) }}" id="changpasswordForm" method="post">
                             {{ csrf_field() }}
                               <label> @lang('strings.old_password')   </label>
                               <input type="password"  placeholder="*****" name="old_password" id="old_password" required> 
                                 <div id="old_password_error"></div>
                               <label> @lang('strings.new_password')   </label>
                               <input type="password"  placeholder="*****" name="password_new" id="password_new" required> 
                                 <div id="password_new_error"></div>

                               <label> @lang('strings.conform_password')   </label>
                               <input type="password" placeholder="*****" name="confirmed_password" id="confirmed_password" required>
                                 <div id="confirmed_password_error"></div>

                               <button type="submit"  class="btn btn_submit">@lang('strings.conform')</button>
                         </form>

		</div> <!-- // forgot popup -->
    </div>

  </div>
</div>

    <div class="for_menu">

        <div class="for_menu_over"></div>

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
							  {!! csrf_field() !!}
								<label> @lang('strings.Email') </label>
								<input type="text" placeholder="Example@email.com" name="login_email" required>
								<label> @lang('strings.New_password') </label>
								<input type="password" placeholder="*****" name="login_passowrd" required>

								<button type="submit" class="btn btn_submit"> @lang('strings.Login')</button>
						</form>
						<a class="forgot_pass" href="#" onclick="showforgot()"> @lang('strings.forget_password') ? </a>
				</div>
		</div> <!-- // login popup -->

		<!-- register popup -->
		<!-- // register popup -->

		<div class="all_pop" id="register">
				<div class="login register">
						<a href="#" onclick="closeReg()" class="close_log"> <i class="fas fa-times"></i>  </a>
						<h3> @lang('strings.register')</h3>
						<form action="{{url('CreateCustomer')}}" method="post" id="registerForm">
							  {!! csrf_field() !!}
								<div class="row">
										<div class="col-md-6 col-xs-12">
										<label>@lang('strings.user_name') </label>
										<input type="text" placeholder="john" name="name"  id ="name" required>
										 <div id="name_error"></div>
										</div>
										<div class="col-md-6 col-xs-12">
										<label>@lang('strings.Email') </label>
										<input type="email"  name="email" id="email" required>
		                                  <div id="email_error"></div>
										</div>
										<div class="col-md-6 col-xs-12">
										<label>@lang('strings.Address') </label>
										<input type="text" name="address"  id ="address" required>
										 <div id="address_error"></div>
										</div>
										<div class="col-md-6 col-xs-12">
										<label>@lang('strings.phone') </label>
									<input type="text" id="phone_number" name="phone_number"   required>
								    	<div id="phone_number_error"></div>
                                        <i id="phoneok"style="display:none" class="fa fa-check color-success"></i>
                                         <i id="phonecancel"style="display:none" class="fa fa-times color-danger"></i>
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
										<input type="password" name="password"  id="password" required>
		                            	<div id="passwd_error"></div>
										</div>
										<div class="col-md-6 col-xs-12">
										<label> @lang('strings.Password_confirmation') </label>
										<input type="password"  name="confirm_passowrd" id='confirm_passowrd' required>

										<div id="passwd_error"></div>
										</div>
								</div>
							<button type="submit" class="btn btn_submit">@lang('strings.register')</button>
						</form>
						<a href="#" class="forgot_pass" onclick="showfromreg()"> @lang('strings.have_account')? </a>
				</div>
		</div>



		<!-- forgot popup -->
		<div class="all_pop" id="forgot">
				<div class="login register forgot">
						<a href="#" onclick="closeforgot()" class="close_log"> <i class="fas fa-times"></i>  </a>
						<h3>FORGOT YOUR DETAILS?</h3>
						<form action="{{url('password/email')}}" method="post">
							  {!! csrf_field() !!}
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
												<div class="col-md-6 col-xs-12">

														<!-- social -->
														<div class="social">
																<ul>
																		<li> <a href="{{$org_id->facebook}}" target="_blank"> <i class="fab fa-facebook-f"></i> </a> </li>
																		<li> <a href="{{$org_id->twitter}}" target="_blank"> <i class="fab fa-twitter"></i> </a> </li>
																		<li> <a href="{{$org_id->instgram}}" target="_blank"> <i class="fab fa-instagram"></i> </a> </li>
																</ul>
														</div>

														<!-- call us -->
														<p class="call"> @lang('strings.QUESTIONS'): <a href="tel:0220187656"> 	{{  $org_id->phone }} <i class="fa fa-phone"></i> </a> </p>

												</div>

												<!-- right links -->
												<div class="col-md-6 col-xs-12">
														<ul class="nav">

														    <!-- search -->
														    <li class="visible-xs">
														        <div class="open_menu visible-xs">
																    <a href="#" onclick="openNav()"> <i class="fas fa-bars"></i> </a>
														        </div>
														    </li>

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
																			<form id="searchform" class="header-searchform" action="{{url('search')}}" method="get" target="_blank">
																				 {{ csrf_field() }}
																					<input type="text"   name="serach"  id="serach"   placeholder="البحث...">
																					<div id="categorysList"></div>
																					<button type="submit" id="searchsubmit" class="searchsubmit fas fa-search white-icon"></button>
																			</form>
																	 </div>
															</li>


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
      @php
      $id=Auth::guard('customers')->user()->id;
      $customer_login=Auth::guard('customers')->user();
      @endphp
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="fa fa-user"></span>
             {{app()->getLocale() == 'ar' ? $customer_login->name :
        $customer_login->name_en}}
      </a>
      <ul class="dropdown-menu">

             <li ><a href='{{ url("/customerprofile/$id") }}'> @lang('strings.Home') </a></li>
             <li ><a href="{{ url('/customerdashboard') }}">  @lang('strings.inovices_resrvition') </a></li>
             <li> <button type="button" class="btn btn-info btn-lg myModalpass" data-toggle="modal" data-target="#myModalpass"> @lang('strings.change_password') </button> </li>
             <li><a href="{{ url('logoutCustomer') }}"> @lang('strings.Logout')</a></li>
          
             
      </ul>
  </li>



																@else
																 <button type="button" class="clear-cart"style="display:none" name="button"></button>
																	<!-- Register -->
																	<li>
																			<a href="#" onclick="showReg()"><i class="fas fa-user-plus"></i>@lang('strings.register') </a>
																	</li>

																	<!-- login -->
																	<li>
																			<a id="loginclick" href="#" onclick="showLogin()"><i class="fas fa-sign-in-alt"></i>@lang('strings.Login')</a>
																	</li>


																@endif




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
																<a href="{{url('/') }}">
																	{{ app()->getLocale() == 'ar' ? $org_id->name : $org_id->name_en}}
																</a>
														</div>
												</div>

												<!-- navbar -->
												<div class="col-lg-8 col-md-10 col-sm-10 col-xs-12">
														<div class="nav-bar">
																<ul>
																    @php
                                                                        $labels=\App\ActivityLabelSetup::where(['type'=>item_service,'activity_id'=>$org_id->activity_id  ])->first();
                                                                      
                                                                    @endphp
																		<li class="for-mobile">
																				<a href="#" onclick="closeNav()">
																						Back  <i class="fas fa-times"></i>
																				</a>
																		</li>
																	   <li> <a href="{{url('/') }}"> @lang('strings.Home') </a> </li>
																		<li> <a href="{{url('/offers') }}"> @lang('strings.Offers') </a> </li>
																		<li> <a href="{{url('/categorys') }}"> {{app()->getLocale() == 'ar' ? $labels->value : $labels->value_en}}  </a> </li>
																		<li> <a href="{{url('/aboutus') }}"> @lang('strings.about_us')  </a> </li>
																		<li> <a href="{{url('/contact') }}"> @lang('strings.contact_us')</a> </li>
																</ul>
														</div>
												</div>
 @php

    $my_url=url()->current();
    $last = explode('/', $my_url);
    $org_id=DB::table('organizations')->where('customer_url',$last[2])->first();
    $show_cart=\App\Settings::where(['org_id' =>$org_id->id,'key'=> 'basket','value'=>'on'])->first();
    @endphp

												<!-- cart -->
											  @if($show_cart)	
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
														<div class="cart">
																<ul>
																	<li class="dropdown">
             <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <i class="fas fa-shopping-cart"></i>
                 <!--    <button type="button" class="btn btn-primary"
data-toggle="modal" data-target="#cart">Cart (<span class="total-count"></span>)</button>-->
                     <span class="total-count"></span>
             </a>
             <ul class="dropdown-menu">

                 <div class="total">
                         <p> Subtotal:<span class="total-cart"></span> </p>
                 </div>
				 @php
				 $my_url=url()->current();
				 $last = explode('/', $my_url);
				 $cart='http://'.$last[2].'/'.'checkout';
				 @endphp
				 @if(Request::url() == $cart)

				 @else
                 <div class="buttons-cart">
                         <a href="{{url('/cart') }}" class="view_cart"> View Cart </a>
                         <a href="#"  class="check_cart btn-checkout"> check out </a>
                 </div>
				@endif
             </ul>
         </li>

																</ul>
														</div>
												</div>
												 @endif


										</div>
								</div>

						</div> <!-- // main-header  -->

				</div> <!-- // container  -->
		</div> <!-- // header -->

		@section('scripts')
<script>
         $( document ).ready(function(){
           $('.clear-cart').click();

         })
     </script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/fileinput.min.js"></script>
		<script>
		$(document).ready(function(){

		 $('#serach').keyup(function(){
		        var query = $(this).val();
		        if(query != '')
		        {
		         var _token = $('input[name="_token"]').val();
		         $.ajax({
		          url:"{{ route('autocomplete.fetch') }}",
		          method:"POST",
		          data:{query:query, _token:_token},
		          success:function(data){
		           $('#categorysList').fadeIn();
		            $('#categorysList').html(data);
		          }
		         });
		        }
		    });

		    $(document).on('click', 'li', function(){
		        $('#serach').val($(this).text());

		        $('#categorysList').fadeOut();
		    });

		});
		</script>
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

														$('#email_error').html('');
												}

										}
								}
							},
						"phone_number": {
								required: true,
								number: true,
								remote: {
										url: "checkCustomer",
										type: "get",
										data: {
												"phone_number": function() {
														return $("#phone_number").val();
										}
									},
										beforeSend: function() {
												$('#subok').hide();
												$('#subcancel').hide();
												$('#subdomain_loading').show();
										}, complete: function(response) {



                                                        if ($("#phone_number").hasClass('has-success')) {

                                                        $('#error-msg').empty();
                                                        $('#phoneok').show();
                                                        $('#phonecancel').hide();
                                                        $('#phone_error').html('');

                                                        } else {


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


						"name": {
								required:"{{trans('strings.name_required')}}",
								maxlength : "{{trans('strings.max_length_validate')}}"
						},
						"address": {
								required:"{{trans('strings.address_validate')}}",
								maxlength : "{{trans('strings.max_length_validate')}}"
						},
						"phone_number": {
								required:"{{trans('strings.name_phone')}}",
								remote:"{{trans('strings.valid_phone')}}"

						},
						"email":{
						required  : "{{trans('strings.email_required_validation')}}",
						remote:"{{trans('strings.email_validate')}}"
					},

						"password": {
								required :"{{trans('strings.password_required')}}",
								minlength : "{{trans('strings.password_minlength')}}"
						},
						"confirm_passowrd": "{{trans('strings.password_confirmation_validation')}}",


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
						}else if (element.attr('id') == 'phone_number') {
								$('#phone_number_error').html('<div class="error-message">' + error.html() + '</div>');
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

						}else if (myid == 'phone_number') {

								$('#phone_number_error').html('');

						}else if (myid == 'address') {

								$('#address_error').html('');

						}

				}
		});

	</script>

	<script>

		var input = document.querySelector("#phone_number"),
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
<script type="text/javascript">
$("#changpasswordForm").validate({
         errorClass: "has-error",
         validClass: "has-success",
         rules: {

                 "old_password": {
                         required: true,
                         remote: {
                                 url: "passwordCheck",
                                 type: "get",
                                 data: {
                                         "old_password": function() {
                                                 return $("#old_password").val();
                                             
                                 }
                             },
                                 beforeSend: function() {
                                         $('#subok').hide();
                                         $('#subcancel').hide();
                                        $('#subdomain_loading').show();
                                 }, complete: function(response) {

                                         if 
                                    ($("#old_password").hasClass('has-success')) {

                                   $('#old_password_error').html('');
                                         }

                                 }
                         }
                     },
                 "password_new": {
                         required: true,
                         minlength: 6
                 },
                 "confirmed_password": {
                         required: true,
                         equalTo: "#password_new"
                 }
         },

         messages: {

                 "old_password":{
                 required  : "{{trans('strings.password_required')}}",
                 remote:"{{trans('strings.old_password_validate')}}"
             },

                 "password_new": {
                         required :"{{trans('strings.password_required')}}",
                         minlength : "{{trans('strings.password_minlength')}}"

                 },
                 "confirmed_password":"{{trans('strings.password_confirmation_validation')}}", 



         }, errorPlacement: function(error, element) {
                  if (element.attr('id') == 'old_password') {
                         $('#old_password_error').html('<div  class="error-message">' + error.html() + '</div>');
                                                  
                         error.remove();
                 }
                 else if (element.attr('id') == 'password_new') {
                         $('#password_new_error').html('<div class="error-message">' + error.html() + '</div>');

                         error.remove();
                 } else if (element.attr('id') == 'confirmed_password') {
                         $('#password_new_error').html('<div class="error-message">' + error.html() + '</div>');

                         error.remove();
                 }
                 else {
                      element.next().remove();
                      error.insertAfter("#" + element.attr('id'));
              }





         }, success: function(label, element) {
                 label.addClass("has-success");
                 var myid = label.attr('for');

                 if (myid == 'old_password') {

                         $('#old_password_error').html('');

                 } else if (myid == 'password_new') {

                         $('#confirmed_password_error').html('');

                 }else if (myid == 'confirm_passowrd') {

                         $('#confirmed_password_error').html('');

                 }

         }
});

setTimeout(function() {
    $('.alert').fadeOut('fast');
}, 5000); 

</script>



	    @endsection

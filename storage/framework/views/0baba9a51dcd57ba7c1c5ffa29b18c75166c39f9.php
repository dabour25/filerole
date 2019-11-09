<!DOCTYPE html>
<html lang="ar">
<?php

$my_url=url()->current();
$last = explode('/', $my_url);
$org=DB::table('organizations')->where('customer_url',$last[2])->first();
$org_id_login=$org->id;
if(empty($org)){
$org_master=\App\Organization::where('custom_domain',$last[2]);
$org=\App\org::where('id',$org_master->org_id);
$org_id_login=$org_master->org_id;
}
?>

<head>
	<title><?php echo e(app()->getLocale()== 'ar' ?  $org->name : $org->name_en); ?></title>
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<meta name="keywords" content="filerole, programs, startup" />
	 <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
	 <meta name="auth" content="<?php echo e(Auth::guard('customers')->check()?1:0); ?>">
	 <meta name="lang" content="<?php echo e(app()->getLocale()); ?>">


        <?php if(app()->getLocale() == 'ar'): ?>
        <link rel="stylesheet" href="<?php echo e(url('/')); ?>/front/css/bootstrap-rtl.min.css">
        <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(url('/')); ?>/front/css/bootstrap.css">
        <?php endif; ?>

        <?php if(app()->getLocale() == 'ar'): ?>
        <link href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700,900" rel="stylesheet">
        <?php else: ?>
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
        <?php endif; ?>
        <link rel="icon" href="<?php echo e(asset('favicon.png')); ?>">

		<!-- Web Fonts -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

	    <!-- Style-CSS -->
		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    	<link rel="stylesheet" href="<?php echo e(url('/')); ?>/front/css/animate.min.css">
    	<link rel="stylesheet" href="<?php echo e(url('/')); ?>/front/css/owl.carousel.min.css">
      <link rel="stylesheet" href="<?php echo e(asset('public/front/intlTelInput.css')); ?>">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/css/fileinput.min.css">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/css/intlTelInput.css">
	    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>
      <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css"/>


        <?php if(app()->getLocale() == 'ar'): ?>
        <link rel="stylesheet" href="<?php echo e(url('/')); ?>/front/css/style-ar.css">
        <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(url('/')); ?>/front/css/style-en.css">
        <?php endif; ?>
        <!--<link rel="stylesheet" href="<?php echo e(url('/')); ?>/front/css/colors.css">-->

		<!-- js head -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script>
				new WOW().init();
		</script>
        <?php if(!empty($org_id)): ?>
        <style>
            .btn-submit,.btn_submit,.join_us a,.nav-page-caty .nav-link.active,
            .contactus button,.all_pop form button {
                <?php if(!empty($org_id->second_color)): ?>
                background: <?php echo e($org_id->second_color); ?> !important;
                <?php else: ?>
                background: #565656;
                <?php endif; ?>
            }
            .all_pop h3,.join_us h3 {
                <?php if(!empty($org_id->main_color)): ?>
                color: <?php echo e($org_id->main_color); ?> !important;
                <?php else: ?>
                color:#565656;
                <?php endif; ?>
            }
        </style>
        <?php endif; ?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.js"></script>

		<script src="<?php echo e(asset('public/front/intlTelInput.js')); ?>"></script>

		<script src="/front/js/front.js"></script>


</head>

<body>

<div id="myModalpass" class="modal fade" role="dialog">
  <div class="modal-dialog">
      <?php
      $id=Auth::guard('customers')->user()->id;
      ?>
    <!-- Modal content-->

    <div class="modal-content">
		<div class="all_pop all_pop2">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h3> <?php echo app('translator')->getFromJson('strings.change_password'); ?>   </h3>

						<form action="<?php echo e(url('password/update/'.$id)); ?>" id="changpasswordForm" method="post">
                             <?php echo e(csrf_field()); ?>

                               <label> <?php echo app('translator')->getFromJson('strings.old_password'); ?>   </label>
                               <input type="password"  placeholder="*****" name="old_password" id="old_password" required>
                                 <div id="old_password_error"></div>
                               <label> <?php echo app('translator')->getFromJson('strings.new_password'); ?>   </label>
                               <input type="password"  placeholder="*****" name="password_new" id="password_new" required>
                                 <div id="password_new_error"></div>

                               <label> <?php echo app('translator')->getFromJson('strings.conform_password'); ?>   </label>
                               <input type="password" placeholder="*****" name="confirmed_password" id="confirmed_password" required>
                                 <div id="confirmed_password_error"></div>

                               <button type="submit"  class="btn btn_submit"><?php echo app('translator')->getFromJson('strings.conform'); ?></button>
                         </form>

		</div> <!-- // forgot popup -->
    </div>

  </div>
</div>

    <div class="for_menu">

        <div class="for_menu_over"></div>

<?php
$my_url=url()->current();
$last = explode('/', $my_url);
$org=DB::table('organizations')->where('customer_url',$last[2])->first();
$org_id_login=$org->id;
if(empty($org)){
$org_master=\App\Organization::where('custom_domain',$last[2]);
$org=\App\org::where('id',$org_master->org_id);
$org_id_login=$org_master->org_id;
}
?>
		<!-- login popup -->
		<div class="all_pop" id="login">
				<div class="login">
						<a href="#" onclick="closeLogin()" class="close_log"> <i class="fas fa-times"></i>  </a>
						<h3>SIGN IN YOUR ACCOUNT</h3>
						<form action="<?php echo e(url('weblogin')); ?>"  method="post">
							  <?php echo csrf_field(); ?>


                <div class="wrap-input100 validate-input" >
                              <input class="input100" style="width:90%; display:inline"  type="text" placeholder="Example@email.com" name="login_email" required  />
								<span class="focus-input100"></span>
								<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
							<i class="fa fa-phone" aria-hidden="true"></i>
								</span>
								
								
							</div>

								<label> <?php echo app('translator')->getFromJson('strings.New_password'); ?> </label>
								<input type="password" style="width:90%; display:inline"  placeholder="*****" name="login_passowrd" required>

								<button type="submit" class="btn btn_submit"> <?php echo app('translator')->getFromJson('strings.Login'); ?></button>

						</form>
						<a class="forgot_pass" href="#" onclick="showforgot()"> <?php echo app('translator')->getFromJson('strings.forget_password'); ?> ? </a>
				</div>
		</div> <!-- // login popup -->

		<!-- register popup -->
		<!-- // register popup -->

		<div class="all_pop" id="register">
				<div class="login register">
						<a href="#" onclick="closeReg()" class="close_log"> <i class="fas fa-times"></i>  </a>
						<h3> <?php echo app('translator')->getFromJson('strings.register'); ?></h3>
						<form action="<?php echo e(url('CreateCustomer')); ?>" method="post" id="registerForm">
							  <?php echo csrf_field(); ?>

								<div class="row">
										<div class="col-md-6 col-xs-12">
										<label><?php echo app('translator')->getFromJson('strings.user_name'); ?> </label>
										<input type="text" placeholder="john" name="name"  id ="name" required>
										 <div id="name_error"></div>
										</div>
										<div class="col-md-6 col-xs-12">
										<label><?php echo app('translator')->getFromJson('strings.Email'); ?> </label>
										<input type="email"  name="email" id="email" required>
		                                  <div id="email_error"></div>
										</div>
										<div class="col-md-6 col-xs-12">
										<label><?php echo app('translator')->getFromJson('strings.Address'); ?> </label>
										<input type="text" name="address"  id ="address" required>
										 <div id="address_error"></div>
										</div>
										<div class="col-md-6 col-xs-12">
										<label><?php echo app('translator')->getFromJson('strings.phone'); ?> </label>
									<input type="text" id="phone_number" name="phone_number"   required>
								    	<div id="phone_number_error"></div>
                                        <i id="phoneok"style="display:none" class="fa fa-check color-success"></i>
                                         <i id="phonecancel"style="display:none" class="fa fa-times color-danger"></i>
                                        <span id="error-msg" class="hide"></span>
										</div>
										<div class="col-md-6 col-xs-12">
										<label><?php echo e(__('strings.Gender')); ?></label>
										<select class="form-control" name="gender">
												<option value="1" selected><?php echo e(__('strings.Male')); ?></option>
												<option value="0"  ><?php echo e(__('strings.Female')); ?></option>
										</select>
										</div>
										<div class="col-md-6 col-xs-12">
										<label><?php echo app('translator')->getFromJson('strings.New_password'); ?> </label>
										<input type="password" name="password"  id="password" required>
		                            	<div id="passwd_error"></div>
										</div>
										<div class="col-md-6 col-xs-12">
										<label> <?php echo app('translator')->getFromJson('strings.Password_confirmation'); ?> </label>
										<input type="password"  name="confirm_passowrd" id='confirm_passowrd' required>

										<div id="passwd_error"></div>
										</div>
								</div>
							<button type="submit" class="btn btn_submit"><?php echo app('translator')->getFromJson('strings.register'); ?></button>
						</form>
						<a href="#" class="forgot_pass" onclick="showfromreg()"> <?php echo app('translator')->getFromJson('strings.have_account'); ?>? </a>
				</div>
		</div>



		<!-- forgot popup -->
		<div class="all_pop" id="forgot">
				<div class="login register forgot">
						<a href="#" onclick="closeforgot()" class="close_log"> <i class="fas fa-times"></i>  </a>
						<h3>FORGOT YOUR DETAILS?</h3>
						<form action="<?php echo e(url('password/email')); ?>" method="post">
							  <?php echo csrf_field(); ?>

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
		<?php if(session()->has('message')): ?>
		    <div class="alert alert-success">
		        <?php echo e(session()->get('message')); ?>

		    </div>
		<?php endif; ?>

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
																		<li> <a href="<?php echo e($org_id->facebook); ?>" target="_blank"> <i class="fab fa-facebook-f"></i> </a> </li>
																		<li> <a href="<?php echo e($org_id->twitter); ?>" target="_blank"> <i class="fab fa-twitter"></i> </a> </li>
																		<li> <a href="<?php echo e($org_id->instgram); ?>" target="_blank"> <i class="fab fa-instagram"></i> </a> </li>
																</ul>
														</div>

														<!-- call us -->
														<p class="call"> <?php echo app('translator')->getFromJson('strings.QUESTIONS'); ?>: <a href="tel:0220187656"> 	<?php echo e($org->phone); ?> <i class="fa fa-phone"></i> </a> </p>

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
																			<form id="searchform" class="header-searchform" action="<?php echo e(url('search')); ?>" method="get" target="_blank">
																				 <?php echo e(csrf_field()); ?>

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
																			<?php echo app('translator')->getFromJson('strings.language'); ?>
																	</a>
																	<ul class="dropdown-menu">

																		<?php if(app()->getLocale() == 'ar'): ?>
                            		                                    <li class="active"><a href="<?php echo e(url('lang/ar')); ?>"><?php echo e(__('strings.Arabic')); ?></a></li>
                            		                                    <li><a href="<?php echo e(url('lang/en')); ?>"><?php echo e(__('strings.English')); ?></a></li>
																		<?php else: ?>
                    				                                    <li><a href="<?php echo e(url('lang/ar')); ?>"><?php echo e(__('strings.Arabic')); ?></a></li>
                    				                                    <li class="active"><a href="<?php echo e(url('lang/en')); ?>"><?php echo e(__('strings.English')); ?></a>
																		</li>
																		<?php endif; ?>
																	</ul>
																</li>

																<?php if(Auth::guard('customers')->check()): ?>
															 	<li class="dropdown">
      <?php
      $id=Auth::guard('customers')->user()->id;
      $customer_login=Auth::guard('customers')->user();
      ?>
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="fa fa-user"></span>
             <?php echo e(app()->getLocale() == 'ar' ? $customer_login->name :   $customer_login->name_en); ?>


      </a>
      <ul class="dropdown-menu">

             <li ><a href='<?php echo e(url("/customerprofile/$id")); ?>'> <?php echo app('translator')->getFromJson('strings.Home'); ?> </a></li>
            <li ><a href="<?php echo e(url('/customerdashboard')); ?>">  <?php echo app('translator')->getFromJson('strings.cust_invoices'); ?> </a></li>
              <li ><a href="<?php echo e(url('/CustomerReservations')); ?>">  <?php echo app('translator')->getFromJson('strings.reservation'); ?> </a></li>
             <li> <button type="button" class="btn btn-info btn-lg myModalpass" data-toggle="modal" data-target="#myModalpass"> <?php echo app('translator')->getFromJson('strings.change_password'); ?> </button> </li>
             <li><a href="<?php echo e(url('logoutCustomer')); ?>"> <?php echo app('translator')->getFromJson('strings.Logout'); ?></a></li>


      </ul>
  </li>



																<?php else: ?>
																	<!-- Register -->
																	<li>
																			<a href="#" onclick="showReg()"><i class="fas fa-user-plus"></i><?php echo app('translator')->getFromJson('strings.register'); ?> </a>
																	</li>

																	<!-- login -->
																	<li>
																			<a id="loginclick" href="#" onclick="showLogin()"><i class="fas fa-sign-in-alt"></i><?php echo app('translator')->getFromJson('strings.Login'); ?></a>
																	</li>

                                 <button class="clear-cart"   style="display: none;" ></button>
																<?php endif; ?>




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
																<a href="<?php echo e(url('/')); ?>">
																	<?php echo e(app()->getLocale() == 'ar' ? $org->name : $org->name_en); ?>

																</a>
														</div>
												</div>

												<!-- navbar -->
												<div class="col-lg-8 col-md-10 col-sm-10 col-xs-12">
														<div class="nav-bar">
																<ul>
																    <?php
                $labels=\App\ActivityLabelSetup::where(['type'=>item_service,'activity_id'=>$org->activity_id  ])->first();

                                          ?>
																		<li class="for-mobile">
																				<a href="#" onclick="closeNav()">
																						Back  <i class="fas fa-times"></i>
																				</a>
																		</li>
																	   <li> <a href="<?php echo e(url('/')); ?>"> <?php echo app('translator')->getFromJson('strings.Home'); ?> </a> </li>
																		<li> <a href="<?php echo e(url('/offers')); ?>"> <?php echo app('translator')->getFromJson('strings.Offers'); ?> </a> </li>
																		<li> <a href="<?php echo e(url('/categorys')); ?>"> <?php echo e(app()->getLocale() == 'ar' ? $labels->value : $labels->value_en); ?>  </a> </li>
																		<li> <a href="<?php echo e(url('/aboutus')); ?>"> <?php echo app('translator')->getFromJson('strings.about_us'); ?>  </a> </li>
																		<li> <a href="<?php echo e(url('/contact')); ?>"> <?php echo app('translator')->getFromJson('strings.contact_us'); ?></a> </li>
																</ul>
														</div>
												</div>
 <?php

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
    ?>

												<!-- cart -->
											  <?php if($show_cart): ?>
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
				 <?php
				 $my_url=url()->current();
				 $last = explode('/', $my_url);
				 $cart='http://'.$last[2].'/'.'checkout';
				 ?>
				 <?php if(Request::url() == $cart): ?>

				 <?php else: ?>
                 <div class="buttons-cart">
                         <a href="<?php echo e(url('/cart')); ?>"  onclick="login_customer(event)" class="view_cart"> View Cart </a>
                         <a href="#"  class="check_cart btn-checkout"> check out </a>
                 </div>
				<?php endif; ?>
             </ul>
         </li>

																</ul>
														</div>
												</div>
												 <?php endif; ?>


										</div>
								</div>

						</div> <!-- // main-header  -->

				</div> <!-- // container  -->
		</div> <!-- // header -->
   <script>
     
         </script>
		<?php $__env->startSection('scripts'); ?>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/fileinput.min.js"></script>
      
        



	    <?php $__env->stopSection(); ?>

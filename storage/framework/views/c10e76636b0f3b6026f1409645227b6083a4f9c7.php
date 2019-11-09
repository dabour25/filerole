<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" dir="<?php echo e(app()->getlocale()=='ar'?'rtl':'ltr'); ?>">

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Citytours - Premium site template for city tours agencies, transfers and tickets.">
    <meta name="author" content="Ansonika">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <title><?php echo e(app()->getLocale()== 'ar' ?  $org_id->name : $org_id->name_en); ?></title>

    <!-- Favicons-->
    <link rel="icon" href="<?php echo e(asset('favicon.png')); ?>">

    <!-- COMMON CSS -->
	<link href="<?php echo e(asset('hotel_assets/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <?php if(app()->getlocale()=='en'): ?>
    <link href="<?php echo e(asset('hotel_assets/css/style.css')); ?>" rel="stylesheet">
    <?php else: ?>
    <link href="<?php echo e(asset('hotel_assets/css/style-rtl.css')); ?>" rel="stylesheet">
    <?php endif; ?>
	<link href="<?php echo e(asset('hotel_assets/css/vendors.css')); ?>" rel="stylesheet">
	
	<!-- CUSTOM CSS -->
	<link href="<?php echo e(asset('hotel_assets/css/custom.css')); ?>" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   
</head>
<body>

    <div id="preloader">
        <div class="sk-spinner sk-spinner-wave">
            <div class="sk-rect1"></div>
            <div class="sk-rect2"></div>
            <div class="sk-rect3"></div>
            <div class="sk-rect4"></div>
            <div class="sk-rect5"></div>
        </div>
    </div>
    <!-- End Preload -->

    <div class="layer"></div>
    <!-- Mobile menu overlay mask -->

     <!-- Header================================================== -->
    <header class="<?php echo e(Route::current()->uri=='contact'?'dark-header':''); ?>">
        <div id="top_line">
            <div class="container">
                <div class="row">
                    <div class="col-6"><i class="icon-phone"></i><strong><?php echo e($org_id->phone); ?></strong></div>
                    <div class="col-6">
                        <ul id="top_links">
                            <?php if(Auth::guard('customers')->check()): ?>
                            <li>
                                <div class="dropdown">
                                    <a href="#" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-user-circle"></i> 
                                        <?php if(App()->getlocale()=='ar'): ?>
                                        <?php echo e(Auth::guard('customers')->user()->name); ?>

                                        <?php else: ?>
                                        <?php echo e(Auth::guard('customers')->user()->name_en); ?>

                                        <?php endif; ?>
                                    </a>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <a style="color: black;" class="dropdown-item" href="/logout"><?php echo app('translator')->getFromJson('strings.Home'); ?></a>
                                    <a style="color: black;" class="dropdown-item" href="/logout"><?php echo app('translator')->getFromJson('strings.inovices_resrvition'); ?></a>
                                    <a style="color: black;" class="dropdown-item" href="/logout"><?php echo app('translator')->getFromJson('strings.change_password'); ?></a>
                                    <a style="color: black;" class="dropdown-item" href="/logout"><?php echo app('translator')->getFromJson('strings.Logout'); ?></a>
                                  </div>
                                </div>
                            </li>
                            <?php else: ?>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#signin">
                                    <i class="fa fa-user-circle"></i> <?php echo app('translator')->getFromJson('strings.sign_in'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#signup">
                                    <i class="fa fa-address-card"></i> <?php echo app('translator')->getFromJson('strings.register'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                            <li><a href="lang<?php echo e(app()->getLocale()== 'ar' ?  '/en' : '/ar'); ?>"><i class="fa fa-language"></i> <?php echo e(app()->getLocale()== 'ar' ?  'English' : 'عربى'); ?></a></li>
                            <li>
                                <div class="dropdown">
                                    <a href="#" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-credit-card"></i> <?php echo app('translator')->getFromJson('strings.currency'); ?></a>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <?php $__currentLoopData = $currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button class="dropdown-item" style="cursor: pointer;"><?php echo e(app()->getLocale()=='ar'?$c->name:$c->name_en); ?></button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div><!-- End row -->
            </div><!-- End container-->
        </div><!-- End top line-->
        
        <div class="container">
            <div class="row">
                <div class="col-md-<?php echo e(app()->getLocale()=='ar'?'1':'3'); ?>">
                    <div id="logo_home">
                    	<h1><a href="/"></a></h1>
                    </div>
                </div>
                <nav class="col-md-<?php echo e(app()->getLocale()=='ar'?'11':'9'); ?>">
                    <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
                    <div class="main-menu">
                        <div id="header_menu">
                            <img src="<?php echo e(asset('favicon.png')); ?>" width="34" height="34" data-retina="true">
                        </div>
                        <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
                        <ul style="<?php echo e(app()->getLocale()=='ar'?'direction:rtl;text-align: center;':''); ?>">
                            <li class="submenu">
                                <a href="/" class="show-submenu"><?php echo app('translator')->getFromJson('strings.home'); ?></a>
                            </li>
                            <li class="submenu">
                                <a href="/offers" class="show-submenu"><?php echo app('translator')->getFromJson('strings.Offers'); ?></a>
                            </li>
                            <li class="submenu">
                                <a href="/aboutus" class="show-submenu"><?php echo app('translator')->getFromJson('strings.about_us'); ?></a>
                            </li>
                            <li class="submenu">
                                <a href="/contact" class="show-submenu"><?php echo app('translator')->getFromJson('strings.contact_us'); ?></a>
                            </li>
                        </ul>
                    </div><!-- End main-menu -->
                </nav>
            </div>
        </div><!-- container -->
    </header><!-- End Header -->
    
	<?php echo $__env->yieldContent('content'); ?>
	
	<footer class="revealed">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3><?php echo app('translator')->getFromJson('strings.need_help'); ?></h3>
                    <a href="tel:<?php echo e($org_id->phone); ?>" id="phone"><?php echo e($org_id->phone); ?></a>
                    <a href="mailto:<?php echo e($org_id->email); ?>" id="email_footer"><?php echo e($org_id->email); ?></a>
                </div>
                <div class="col-md-3">
                    <h3><?php echo app('translator')->getFromJson('strings.about'); ?></h3>
                    <ul>
                        <li><a href="/aboutus"><?php echo app('translator')->getFromJson('strings.about_us'); ?></a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#sign-in-dialog"><?php echo app('translator')->getFromJson('strings.sign_in'); ?></a></li>
                        <li><a href="#"><?php echo app('translator')->getFromJson('strings.register'); ?></a></li>
                         <li><a href="/terms"><?php echo app('translator')->getFromJson('strings.terms_cond'); ?></a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h3><?php echo app('translator')->getFromJson('strings.Discover'); ?></h3>
                    <ul>
                        <li><a href="#">Community blog</a></li>
                        <li><a href="#">Tour guide</a></li>
                        <li><a href="#">Wishlist</a></li>
                         <li><a href="#">Gallery</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h3><?php echo app('translator')->getFromJson('strings.Settings'); ?></h3>
                    <div class="styled-select">
                        <select name="lang" id="lang">
                            <option value="en" <?php echo e(app()->getLocale()=='en'?'selected':''); ?>>English</option>
                            <option value="ar" <?php echo e(app()->getLocale()=='ar'?'selected':''); ?>>عربى</option>
                        </select>
                    </div>
                    <div class="styled-select">
                        <select name="currency" id="currency">
                            <?php $__currentLoopData = $currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c->id); ?>"><?php echo e(app()->getLocale()=='ar'?$c->name:$c->name_en); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div><!-- End row -->
            <div class="row">
                <div class="col-md-12">
                    <div id="social_footer">
                        <ul>
                            <li><a href="<?php echo e($org_id->facebook); ?>" target="_blank"><i class="icon-facebook"></i></a></li>
                            <li><a href="<?php echo e($org_id->twitter); ?>" target="_blank"><i class="icon-twitter"></i></a></li>
                            <li><a href="<?php echo e($org_id->instgram); ?>"><i class="icon-instagram" target="_blank"></i></a></li>
                        </ul>
                        <p style="<?php echo e(app()->getLocale()=='ar'?'direction: rtl;':''); ?>">
                            ©<?php echo e(date(Y)); ?> <?php echo app('translator')->getFromJson('strings.rights'); ?> <a href="http://www.filerole.com" target="_blank"><?php echo app('translator')->getFromJson('strings.fileRole'); ?></a>
                        </p>
                    </div>
                </div>
            </div><!-- End row -->
        </div><!-- End container -->
    </footer><!-- End footer -->

	<div id="toTop"></div><!-- Back to top button -->
	
	<!-- Search Menu -->
	<div class="search-overlay-menu">
		<span class="search-overlay-close"><i class="icon_set_1_icon-77"></i></span>
		<form role="search" id="searchform" method="get">
			<input value="" name="q" type="search" placeholder="Search..." />
			<button type="submit"><i class="icon_set_1_icon-78"></i>
			</button>
		</form>
	</div><!-- End Search Menu -->
	

    <!--Sign In -->
    <div class="modal fade" id="signin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form action="/weblogin" method="post">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->getFromJson('strings.sign_in'); ?></h5>
              </div>
              <div class="modal-body">
                <div class="form-group">
                    <input type="text" name="login_email" class="form-control" placeholder="<?php echo app('translator')->getFromJson('strings.email'); ?>">
                </div>
                <div class="form-group">
                    <input type="password" name="login_password" class="form-control" placeholder="<?php echo app('translator')->getFromJson('strings.password'); ?>">
                </div>
                <a href="#"><?php echo app('translator')->getFromJson('strings.forget_password'); ?></a>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><?php echo app('translator')->getFromJson('strings.sign_in'); ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo app('translator')->getFromJson('strings.close'); ?></button>
              </div>
            </div>
        </form>
      </div>
    </div>
    <!--Sign Up -->
    <div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form action="/CreateCustomer" method="post">
            <?php echo csrf_field(); ?>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->getFromJson('strings.register'); ?></h5>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <input type="text" name="name_en" class="form-control" placeholder="<?php echo app('translator')->getFromJson('strings.user_name_en'); ?>" value="<?php echo e(old('name_en')); ?>">
            </div>
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="<?php echo app('translator')->getFromJson('strings.user_name'); ?>" value="<?php echo e(old('name')); ?>">
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="<?php echo app('translator')->getFromJson('strings.email'); ?>" value="<?php echo e(old('email')); ?>">
            </div>
            <div class="form-group">
                <input type="text" name="address" class="form-control" placeholder="<?php echo app('translator')->getFromJson('strings.address'); ?>" value="<?php echo e(old('address')); ?>">
            </div>
            <div class="form-group">
                <input type="tel" name="phone_number" class="form-control" placeholder="<?php echo app('translator')->getFromJson('strings.phone_number'); ?>" value="<?php echo e(old('phone_number')); ?>">
                <div id="phone_number_error"></div>
                <i id="phoneok"style="display:none" class="fa fa-check color-success"></i>
                <i id="phonecancel"style="display:none" class="fa fa-times color-danger"></i>
            </div>
            <div class="form-group">
                <select name="gender" class="form-control">
                    <option value="1" <?php echo e(old('gender')=='1'?'selected':''); ?>><?php echo app('translator')->getFromJson('strings.Male'); ?></option>
                    <option value="0" <?php echo e(old('gender')=='0'?'selected':''); ?>><?php echo app('translator')->getFromJson('strings.Female'); ?></option>
                </select>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="<?php echo app('translator')->getFromJson('strings.password'); ?>">
            </div>
            <div class="form-group">
                <input type="password" name="confirm_passowrd" class="form-control" placeholder="<?php echo app('translator')->getFromJson('strings.Password_confirmation'); ?>">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><?php echo app('translator')->getFromJson('strings.register'); ?></button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo app('translator')->getFromJson('strings.close'); ?></button>
          </div>
        </div>
      </div>
    </div>
    <?php if($errors->any()||session()->has('message')): ?>
    <!-- Errors and Messages -->
    <div class="modal fade" id="errors" tabindex="-1" role="dialog" aria-labelledby="errortitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="errortitle"><?php echo app('translator')->getFromJson('strings.message'); ?></h5>
          </div>
          <div class="modal-body">
            <ul>
                <?php if($errors->any()): ?> <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li style="color: red;"><?php echo e($e); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php else: ?>
                <li><?php echo e(session()->get('message')); ?></li>
                <?php endif; ?>
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo app('translator')->getFromJson('strings.close'); ?></button>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
	<!-- Common scripts -->
	<script src="<?php echo e(asset('hotel_assets/js/jquery-2.2.4.min.js')); ?>"></script>
	<script src="<?php echo e(asset('hotel_assets/js/common_scripts_min.js')); ?>"></script>
	<script src="<?php echo e(asset('hotel_assets/js/functions.js')); ?>"></script>

	<script>
		$('input.date-pick').datepicker('setDate', 'today');
		$('input.time-pick').timepicker({
			minuteStep: 15,
			showInpunts: false
		})
	</script>
	
	<script src="<?php echo e(asset('hotel_assets/js/jquery.ddslick.js')); ?>"></script>
	<script>
		$("select.ddslick").each(function() {
			$(this).ddslick({
				showSelectedHTML: true
			});
		});
	</script>
	
	<!-- Check box and radio style iCheck -->
	<script>
		$('input').iCheck({
		   checkboxClass: 'icheckbox_square-grey',
		   radioClass: 'iradio_square-grey'
		 });
        $('#lang').change(function(){
            location.href='/lang/'+$('#lang').val();
        });
        var childcontent='<div class="col-sm-12"><h4><?php echo app('translator')->getFromJson("strings.children_ages"); ?>:</h4></div>';
        $('#children_count').change(function(){
            for(var i=0;i<$('#children_count').val();i++){
                childcontent+='<div class="col-md-2 col-sm-3 col-6"><div class="form-group"><label><?php echo app('translator')->getFromJson("strings.child"); ?>: '+(i+1)+'</label><div class="numbers-row"><input type="text" value="5" id="age" class="form-control" name=""></div></div></div>';
            }
            $('#age_cont').empty();
            $('#age_cont').html(childcontent);
            childcontent='<div class="col-sm-12"><h4><?php echo app('translator')->getFromJson("strings.children_ages"); ?>:</h4></div>';
        });
        <?php if($errors->any()||session()->has('message')): ?>
            $('#errors').modal('show');
            setTimeout(function(){
               $('#errors').modal('hide'); 
            },6000);
        <?php endif; ?>
	</script>

	
  </body>
</html>
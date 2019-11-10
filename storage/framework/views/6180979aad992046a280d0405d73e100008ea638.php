<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" <?php if(app()->getLocale() == 'ar'): ?> dir="rtl" <?php endif; ?>>
<head>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Title -->
    <title> <?php echo e($title); ?> - <?php echo e(__('strings.admin')); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta charset="UTF-8">
    <meta name="title" content="<?php echo e($title); ?>"/>
    <meta name="description" content="Admin Panel for <?php echo e(config('settings.business_name')); ?>."/>
    <meta name="keywords" content=""/>
    <meta name="author" content="Pharaoh"/>
    <meta name="base_url" content="<?php echo e(URL::to('/')); ?>">
    <meta name="lang" content="<?php echo e(app()->getLocale()); ?>">
    <meta name="currency" content="<?php echo e(app()->getLocale()=='ar'?\App\Currency::find(\App\org::find(Auth::user()->org_id)->currency)->name:\App\Currency::find(\App\org::find(Auth::user()->org_id)->currency)->name_en); ?>">
    <link rel="icon" href="<?php echo e(asset('favicon.png')); ?>">
    
    <!-- datatabel files -->   
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>
      <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css"/>
      
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css"/>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Droid+Sans"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.21.0/slimselect.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <!--<link href="<?php echo e(asset('plugins/pace-master/themes/blue/pace-theme-flash.css')); ?>" rel="stylesheet"/>-->
    
    <?php if(Request::route()->getName() == 'EditMenu'): ?>
      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
      <link href="<?php echo asset('bs-iconpicker/css/bootstrap-iconpicker.min.css'); ?>" rel="stylesheet">
    <?php else: ?>
      <link href="<?php echo e(asset('plugins/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <?php endif; ?>
    <link href="<?php echo e(asset('plugins/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(asset('plugins/fontawesome/css/font-awesome.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(asset('plugins/line-icons/simple-line-icons.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(asset('plugins/waves/waves.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/css/fileinput.min.css">


    <?php if(Request::is('admin/kpi/list') || Request::is('admin/kpi/create') || Request::is('admin/kpi/assign') || Request::is('admin/kpi/average/list') || Request::is('admin/kpi/reports') || Request::is('admin/kpi/average-reports') || Request::is('admin/salary_report')): ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css"/>
    <?php else: ?>
        <link href="<?php echo e(asset('plugins/bootstrap-datepicker/css/datepicker3.css')); ?>" rel="stylesheet" type="text/css"/>
    <?php endif; ?>

    <link href="<?php echo e(asset('plugins/summernote-master/summernote.css')); ?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/jquery.tagsinput.css')); ?>"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.css"/>

    <!-- Theme Styles -->
    <?php if(app()->getLocale() == 'ar'): ?>
        <link href="<?php echo e(asset('css/backend_rtl.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <?php else: ?>
        <link href="<?php echo e(asset('css/backend.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <?php endif; ?>

    <link href="<?php echo e(asset('/css/themes/green.css')); ?>" class="theme-color" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(asset('/css/custom.css')); ?>" rel="stylesheet" type="text/css"/>
    <?php echo $__env->yieldContent('styles'); ?>
  <style>




/*//////////////////////////////////////////////////////////////////
[ FONT ]*/

@font-face {
  font-family: Poppins-Regular;
  src: url('../fonts/poppins/Poppins-Regular.ttf');
}

@font-face {
  font-family: Poppins-Bold;
  src: url('../fonts/poppins/Poppins-Bold.ttf');
}

@font-face {
  font-family: Poppins-Medium;
  src: url('../fonts/poppins/Poppins-Medium.ttf');
}

@font-face {
  font-family: Montserrat-Bold;
  src: url('../fonts/montserrat/Montserrat-Bold.ttf');
}

/*//////////////////////////////////////////////////////////////////
[ RESTYLE TAG ]*/

* {
	margin: 0px;
	padding: 0px;
	box-sizing: border-box;
}

body, html {
	height: 100%;
	font-family: Poppins-Regular, sans-serif;
}

/*---------------------------------------------*/
a {
	font-family: Poppins-Regular;
	font-size: 14px;
	line-height: 1.7;
	color: #666666;
	margin: 0px;
	transition: all 0.4s;
	-webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
}

a:focus {
	outline: none !important;
}

a:hover {
	text-decoration: none;
	color: #3e3e3e;
}

/*---------------------------------------------*/
h1,h2,h3,h4,h5,h6 {
	margin: 0px;
}

p {
	font-family: Poppins-Regular;
	font-size: 14px;
	line-height: 1.7;
	color: #666666;
	margin: 0px;
}

ul, li {
	margin: 0px;
	list-style-type: none;
}


/*---------------------------------------------*/
input {
	outline: none;
	border: none;
}
.showpass {
	font-size: 18px;
	color: #6a6a6a;
	position: absolute;
	right: 20px;
	top: 15px;
}

textarea {
  outline: none;
  border: none;
}

textarea:focus, input:focus {
  border-color: transparent !important;
}

input:focus::-webkit-input-placeholder { color:transparent; }
input:focus:-moz-placeholder { color:transparent; }
input:focus::-moz-placeholder { color:transparent; }
input:focus:-ms-input-placeholder { color:transparent; }

textarea:focus::-webkit-input-placeholder { color:transparent; }
textarea:focus:-moz-placeholder { color:transparent; }
textarea:focus::-moz-placeholder { color:transparent; }
textarea:focus:-ms-input-placeholder { color:transparent; }

input::-webkit-input-placeholder { color: #999999; }
input:-moz-placeholder { color: #999999; }
input::-moz-placeholder { color: #999999; }
input:-ms-input-placeholder { color: #999999; }

textarea::-webkit-input-placeholder { color: #999999; }
textarea:-moz-placeholder { color: #999999; }
textarea::-moz-placeholder { color: #999999; }
textarea:-ms-input-placeholder { color: #999999; }

/*---------------------------------------------*/
button {
	outline: none !important;
	border: none;
	background: transparent;
}

button:hover {
	cursor: pointer;
}

iframe {
	border: none !important;
}


/*//////////////////////////////////////////////////////////////////
[ Utility ]*/
.txt1 {
  font-family: Poppins-Regular;
  font-size: 13px;
  line-height: 1.5;
  color: #000;
  font-weight: 900;
}

.txt2 {
  font-family: Poppins-Regular;
  font-size: 13px;
  line-height: 1.5;
  color: #448aff;
}


/*//////////////////////////////////////////////////////////////////
[ login ]*/

.limiter {
    margin: 0 auto;
    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 999999999 !important;
}

.container-login100 {
  width: 100%;
  min-height: 100vh;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  padding: 15px;
  background: rgba(0,0,0,0.6);
}

.wrap-login100 {
  width: 590px;
  background: none;
  border-radius: 10px;
  overflow: hidden;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  padding: 40px 50px 40px 70px;
}

/*------------------------------------------------------------------
[  ]*/
.login100-pic {
  overflow: hidden;
}

.login100-pic img {
  width: 100%;
  height: 100%;
  opacity: 0.7;
}


/*------------------------------------------------------------------
[  ]*/
.login100-form {
  width: 100%;
  margin: 25px 0 0 0;
  position: relative;
  left: 0;
  text-align: center;
  right: 0;
  background: none;
  padding: 25px 30px;
  box-shadow: none;
}

.login100-form-title {
  color: #fff;
  line-height: 1.2;
  text-align: center;
  width: 100%;
  display: block;
  padding: 35px 0 30px 0;
  font-weight: bold;
  font-size: 30px;
  text-transform: uppercase;
  font-family: auto;
  white-space: unset;
  overflow: hidden;
}


/*---------------------------------------------*/
.wrap-input100 {
  position: relative;
  width: 100%;
  z-index: 1;
  margin-bottom: 10px;
}

.input100 {
  font-family: Poppins-Medium;
  font-size: 15px;
  line-height: 1.5;
  color: #666666;
  display: block;
  width: 100%;
  background: #fff;
  height: 50px;
  border-radius: 25px;
  padding: 0 30px 0 81px;
  border: 1px solid #ccc;
}

.showpass:active {
	color:#ccc;
}


/*------------------------------------------------------------------
[ Focus ]*/
.focus-input100 {
  display: block;
  position: absolute;
  border-radius: 25px;
  bottom: 0;
  left: 0;
  z-index: -1;
  width: 100%;
  height: 100%;
  box-shadow: 0px 0px 0px 0px;
  color: rgba(87,184,70, 0.8);
}

.input100:focus + .focus-input100 {
  -webkit-animation: anim-shadow 0.5s ease-in-out forwards;
  animation: anim-shadow 0.5s ease-in-out forwards;
}

@-webkit-keyframes anim-shadow {
  to {
    box-shadow: 0px 0px 70px 25px;
    opacity: 0;
  }
}

@keyframes  anim-shadow {
  to {
    box-shadow: 0px 0px 70px 25px;
    opacity: 0;
  }
}

.symbol-input100 {
  font-size: 15px;

  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  align-items: center;
  position: absolute;
  border-radius: 25px;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100%;
  padding-left: 35px;
  pointer-events: none;
  color: #666666;

  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}

.input100:focus + .focus-input100 + .symbol-input100 {
  color: #57b846;
  padding-left: 28px;
}
.symbol-input100 i {
    margin: 0 10px 0 0;
}

/*------------------------------------------------------------------
[ Button ]*/
.container-login100-form-btn {
  width: 100%;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  padding-top: 20px;
}

.login100-form-btn {
  font-family: Montserrat-Bold;
  font-size: 15px;
  line-height: 1.5;
  color: #fff;
  text-transform: uppercase;

  width: 100%;
  height: 50px;
  border-radius: 25px;
  background: #57b846;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0 25px;

  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}

.login100-form-btn:hover {
  background: #333333;
}



/*------------------------------------------------------------------
[ Responsive ]*/



@media (max-width: 992px) {
  .wrap-login100 {
    padding: 177px 90px 33px 85px;
  }

  .login100-pic {
    width: 150px;
    height: 150px;
    margin: auto !important;
  }

  .login100-form {
    width: 50%;
  }
}

@media (max-width: 768px) {
  .wrap-login100 {
    padding: 100px 80px 33px 80px;
  }

  .login100-pic {
    display: block;
    margin: 15px 0 0 0;
  }

  .login100-form {
    width: 100%;
    left: 0;
    top: 0;
  }
  .login100-form-title {
    font-family: Poppins-Bold;
    font-size: 15px;
    color: #000;
    line-height: 1.2;
    text-align: center;
    width: 100%;
    display: block;
    padding: 30px 0 20px 0;
}
}

@media (max-width: 576px) {
  .wrap-login100 {
    padding: 0 0;
    left: 0;
    margin-top: -35%;
    top: 0;
  }
  .reset_pass {
  	margin-top: 0;
  }
}


/*------------------------------------------------------------------
[ Alert validate ]*/

.validate-input {
  position: relative;
}

.alert-validate::before {
  content: attr(data-validate);
  position: absolute;
  max-width: 70%;
  background-color: white;
  border: 1px solid #c80000;
  border-radius: 13px;
  padding: 4px 25px 4px 10px;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
  right: 8px;
  pointer-events: none;

  font-family: Poppins-Medium;
  color: #c80000;
  font-size: 13px;
  line-height: 1.4;
  text-align: left;

  visibility: hidden;
  opacity: 0;

  -webkit-transition: opacity 0.4s;
  -o-transition: opacity 0.4s;
  -moz-transition: opacity 0.4s;
  transition: opacity 0.4s;
}

.alert-validate::after {
  content: "\f06a";
  font-family: FontAwesome;
  display: block;
  position: absolute;
  color: #c80000;
  font-size: 15px;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
  right: -20px;
}

.alert-validate:hover:before {
  visibility: visible;
  opacity: 1;
}

@media (max-width: 992px) {
  .alert-validate::before {
    visibility: visible;
    opacity: 1;
  }
}

.limiter .alert {
	background: rgba(0,0,0,0.4);
    color: #fff;
    border: 0;
    border-radius: 5px;
    direction: rtl;
    text-align: center;
    font-weight: bold;
}
.limiter .alert-danger:before {
	content: "\f071";
	font-family:"fontawesome";
	font-weight:900;
	margin: 0 0 0 10px;
	color: #fff;
}

.pulse {
  margin: auto;
  display: block;
  width: 200px;
  height: 200px;
  border-radius: 50%;
  background: #dadada;
  cursor: pointer;
  box-shadow: 0 0 0 rgba(204,169,44, 0.4);
  animation: pulse 2s infinite;
  overflow: hidden;
}
.pulse:hover {
  animation: none;
}

@-webkit-keyframes pulse {
  0% {
    -webkit-box-shadow: 0 0 0 0 rgba(55, 44, 204, 0.4);
  }
  70% {
      -webkit-box-shadow: 0 0 0 50px rgba(35, 31, 186, 0);
  }
  100% {
      -webkit-box-shadow: 0 0 0 0 rgba(28, 30, 215, 0);
  }
}
@keyframes  pulse {
  0% {
    -moz-box-shadow: 0 0 0 0 rgba(28, 121, 18, 0.4);
    box-shadow: 0 0 0 0 #0f0;
  }
  70% {
      -moz-box-shadow: 0 0 0 90px rgba(204,169,44, 0);
      box-shadow: 0 0 0 25px rgba(204,169,44, 0);
  }
  100% {
      -moz-box-shadow: 0 0 0 0 rgba(204,169,44, 0);
      box-shadow: 0 0 0 0 rgba(204,169,44, 0);
  }
}
.showpass {

}
  </style>
    <style>
        .ui-autocomplete, .ui-front, .ui-menu, .ui-widget, .ui-widget-content {
            display: none;
            position: relative;
            width: 150px;
            top: -557px;
            left: 306px;
            background-color: #c5c5c5;
            color: #0c0c0c;
            overflow-y: scroll;
            height: 150px;
        }
    </style>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<?php echo $__env->yieldContent('template'); ?>

<body class="page-header-fixed small-sidebar" id="output-text">
    <?php if(\Auth::user()->welcome != 1): ?>
    <div class="fisrt_message">
        <div class="inner_fisrt_message">
            <img src="http://master.filerolesys.com/front/images/shape4.png" alt="logo">
            <h2> مرحباً <?php echo e(app()->getLocale() == 'ar' ? App\org::where('id', \Auth::user()->org_id)->value('name') : App\org::where('id', \Auth::user()->org_id)->value('name_en')); ?></h2>
            <p> <?php echo e(App\MasterSettings::where(['key' => 'welcome_message'])->value('value')); ?> </p>
            <a href="#" onclick="close_first()"> <?php echo e(App\MasterSettings::where(['key' => 'welcome_message_button'])->value('value')); ?> </a>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="overflow_inner"></div>
    
    <div class="overflow_inner_desktop"></div>
    
    <div class="menu-two before_open" id="myNavTwo">
        <ul>
               <li class="homemenu-two">
                   <a href="<?php echo e(route('home')); ?>">
                       <i class="fas fa-home"></i> <?php echo e(__('strings.home_nav')); ?>

                    </a>
               </li>
               
                <?php $__currentLoopData = Session::get('partents'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $func): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($func->appear == 1): ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                            <i class="<?php echo e($func->font); ?>"></i><?php echo e(app()->getLocale() == 'ar' ? $func->funcname :$func->funcname_en); ?>

                        </a>
    
                        <ul class="dropdown-menu">
    
                            <?php $__currentLoopData = Session::get('childs'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($func->functions_id == $sub->funcparent_id): ?>
                                    <li class="">
                                         <?php if($sub->appear == 1): ?>
                                        <?php $__currentLoopData = Session::get('links'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       
                                            <?php if($sub->functions_id == $link->id): ?>
                                           
                                                <a href="<?php echo e(url($link->technical_name)); ?>"><i class="<?php echo e(DB::table('function_new')->where('id', $link->id)->value('font')); ?>"></i><?php echo e(app()->getLocale() == 'ar' ? $sub->funcname :$sub->funcname_en); ?></a>
    
                                            <?php endif; ?>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                       
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
                        </ul>
                    </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div> 
    
    <div class="overlay"></div>
    
<?php if(App\Settings::where(['key' => 'helplinks', 'org_id' => Auth::user()->org_id])->value('value') == 'on'): ?>
<div class="abs_button">
    <div class="buttons_abs_toogle">
        <a href="#" onclick="show_abs()" class="show_aps"> <i class="fas fa-plus"></i> </a>
        <a href="#" onclick="close_abs()" class="hidden_aps"> <i class="fas fa-times"></i> </a>
    </div>
    <div class="buttons_abs_show">
          <a href="<?php echo e(url('admin/transactions/create')); ?>" class="item-1">
              <span><i class="fas fa-plus"></i> <?php echo e(__('strings.buttons_abs_toogle3')); ?> </span>
              <i class="fa fa-file" title="اضافة فاتورة"></i>
        </a>
        <a href="<?php echo e(url('admin/suppliers/create')); ?>" class="item-2" >
                <span><i class="fas fa-plus"></i> <?php echo e(__('strings.buttons_abs_toogle2')); ?> </span>
              <i class="fa fa-truck" title="اضافة مورد"></i>
        </a>
        <a href="<?php echo e(url('admin/users/create')); ?>" class="item-3" >
                <span><i class="fas fa-plus"></i>  <?php echo e(__('strings.buttons_abs_toogle1')); ?></span>
              <i class="fa fa-users" title="اضافة موظف"></i>
        </a>
    </div>
</div>
<?php endif; ?>

<!--<div class="button_dash">-->
<!--    <div id="draggable" class="ui-widget-content">-->
<!--         <nav class="menu">-->
<!--          <input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open"/>-->
<!--          <label class="menu-open-button" for="menu-open">-->
<!--            <span class="hamburger hamburger-1"></span>-->
<!--            <span class="hamburger hamburger-2"></span>-->
<!--            <span class="hamburger hamburger-3"></span>-->
<!--          </label>-->

<!--          <a href="<?php echo e(url('admin/transactions/create')); ?>" class="menu-item item-1" data-toggle="tooltip" data-placement="top" title="اضافة فاتورة"> <i class="fa fa-file" title="اضافة فاتورة"></i> </a>-->
<!--          <a href="<?php echo e(url('admin/suppliers/create')); ?>" class="menu-item item-2" data-toggle="tooltip" data-placement="top" title="اضافة مورد"> <i class="fa fa-truck" title="اضافة مورد"></i> </a>-->
<!--          <a href="<?php echo e(url('admin/users/create')); ?>" class="menu-item item-3" data-toggle="tooltip" data-placement="top" title="اضافة موظف"> <i class="fa fa-users" title="اضافة موظف"></i> </a>-->

<!--        </nav>-->

<!--         filters -->
<!--        <svg xmlns="http://www.w3.org/2000/svg" version="1.1">-->
<!--            <defs>-->
<!--              <filter id="shadowed-goo">-->

<!--                  <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10" />-->
<!--                  <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo" />-->
<!--                  <feGaussianBlur in="goo" stdDeviation="3" result="shadow" />-->
<!--                  <feColorMatrix in="shadow" mode="matrix" values="0 0 0 0 0  0 0 0 0 0  0 0 0 0 0  0 0 0 1 -0.2" result="shadow" />-->
<!--                  <feOffset in="shadow" dx="1" dy="1" result="shadow" />-->
<!--                  <feComposite in2="shadow" in="goo" result="goo" />-->
<!--                  <feComposite in2="goo" in="SourceGraphic" result="mix" />-->
<!--              </filter>-->
<!--              <filter id="goo">-->
<!--                  <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="10" />-->
<!--                  <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo" />-->
<!--                  <feComposite in2="goo" in="SourceGraphic" result="mix" />-->
<!--              </filter>-->
<!--            </defs>-->
<!--        </svg>-->
<!--    </div>-->
<!--</div>-->

<?php if(\App\Settings::where('org_id',Auth::user()->org_id)->where('key','loading')->first()->value=='on'): ?>
<div class="loading-overlay text-center" id="loadingg">
        <div class="all-spi">
            <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
</div>
<?php endif; ?>
<main class="page-content content-wrap">

    <header id="header-mob" class="visible-xs">
        <div class="container">
            <div class="row">
 <div class="col-xs-2">
                    <div class="icon-mob li-account">
                             <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                <?php if(Auth::guard('customers')->check()): ?>
                                    <span class="user-name">
                                      <?php echo e(app()->getLocale() == 'ar' ? str_limit(Auth::guard('customers')->user()->name, 5) : str_limit(Auth::guard('customers')->user()->name, 5)); ?>

                                        <i class="fas fa-chevron-down"></i>
                                    </span>
                                <?php else: ?>
                                    <span class="user-name">
                                     <?php echo e(app()->getLocale() == 'ar' ? str_limit(Auth::user()->name, 5) : str_limit(Auth::user()->name_en, 5)); ?>

                                       <i class="fas fa-chevron-down"></i>
                                    </span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <?php if(Auth::guard('customers')->check()): ?>

                                    <?php else: ?>
                                        <a href="<?php echo e(route('users.edit', Auth::user()->id)); ?>" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                            <i class="fa fa-user"></i> <span><?php echo e(__('strings.my_account')); ?> </span>
                                        </a>
                                    <?php endif; ?>
                                </li>
                                <li>
                                    <?php if(Auth::guard('customers')->check()): ?>

                                        <?php if(app()->getLocale() == 'ar'): ?>
                                         <a href="#" target="_blank" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                           <i class="fas fa-cloud-upload-alt"></i> <span>ترقية الحساب </span>
                                        </a>
                                        <?php else: ?>
                                        <a href="#" target="_blank" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                           <i class="fas fa-cloud-upload-alt"></i> <span>upgrade account  </span>
                                        </a>
                                        <?php endif; ?>


                                    <?php else: ?>

                                        <?php if(app()->getLocale() == 'ar'): ?>
                                         <a href="https://master.filerolesys.com/upgrade/<?php echo e(Auth::user()->org_id); ?>" target="_blank" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                           <i class="fas fa-cloud-upload-alt"></i> <span>ترقية الحساب </span>
                                        </a>
                                        <?php else: ?>
                                        <a href="https://master.filerolesys.com/upgrade/<?php echo e(Auth::user()->org_id); ?>" target="_blank" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                           <i class="fas fa-cloud-upload-alt"></i> <span>upgrade account  </span>
                                        </a>
                                        <?php endif; ?>

                                    <?php endif; ?>
                                </li>

                                <li>
                                    <?php if(Auth::guard('customers')->check()): ?>

                                        <?php if(app()->getLocale() == 'ar'): ?>
                                         <a href="<?php echo e(url('/')); ?>" target="_blank" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                           <i class="fa fa-home"></i> <span>صفحة العميل  </span>
                                        </a>
                                        <?php else: ?>
                                        <a href="<?php echo e(url('/')); ?>" target="_blank" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                          <i class="fa fa-home"></i> <span> customer page  </span>
                                        </a>
                                        <?php endif; ?>


                                    <?php else: ?>

                                        <?php if(app()->getLocale() == 'ar'): ?>
                                         <a href="<?php echo e(url('/')); ?>" target="_blank" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                           <i class="fa fa-home"></i> <span>صفحة العميل  </span>
                                        </a>
                                        <?php else: ?>
                                        <a href="<?php echo e(url('/')); ?>" target="_blank" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                           <i class="fa fa-home"></i> <span> customer page  </span>
                                        </a>
                                        <?php endif; ?>

                                    <?php endif; ?>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('changePassword')); ?>" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                        <i class="fa fa-shield"></i> <span><?php echo e(__('strings.Change_Password')); ?></span>
                                    </a>
                                </li>
                                <?php if(Auth::guard('customers')->check()): ?>


                                    <li>
                                        <a href="<?php echo e(url('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-lock"></i> <span><?php echo e(__('strings.Logout')); ?></span>
                                        </a>
                                    </li>
                                    <form id="logout-form" action="<?php echo e(url('logout')); ?>" method="POST"
                                          style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                <?php else: ?>
                                    <li>
                                        <a href="<?php echo e(url('admin/logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-lock"></i> <span><?php echo e(__('strings.Logout')); ?></span>
                                        </a>
                                    </li>
                                    <form id="logout-form" action="<?php echo e(url('admin/logout')); ?>" method="POST"
                                          style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                <?php endif; ?>
                            </ul>
                    </div>
                </div>
                <div class="col-xs-2">
                        <div class="icon-mob">
                            <button class="btn btn-notification" onclick="opennfMM()" id="whenopenM">
                                <i class="fas fa-bell"></i>
                                <span class="badge">3</span>
                            </button>
                            <button class="btn btn-notification" onclick="closenfMM()" id="whencloseM">
                                <i class="fas fa-bell"></i>
                                <span class="badge">3</span>
                            </button>
                        </div>

                </div>
                <div class="col-xs-2">
                    <div class="icon-mob">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="fas fa-globe"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu2">
                                <?php if(app()->getLocale() == 'ar'): ?>
                                    <li class="langN"><a href="<?php echo e(url('lang/ar')); ?>"><?php echo e(__('strings.Arabic')); ?></a></li>
                                    <!--<li><a href="<?php echo e(url('lang/en')); ?>"><?php echo e(__('strings.English')); ?></a></li>-->
                                <?php else: ?>
                                    <li><a href="<?php echo e(url('lang/ar')); ?>"><?php echo e(__('strings.Arabic')); ?></a></li>
                                    <!--<li class="langN"><a href="<?php echo e(url('lang/en')); ?>"><?php echo e(__('strings.English')); ?></a>-->
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="navmob-left">
                        <a id="viewport"><i class="fa fa-desktop"></i></a>
                    </div>
                </div>

               
                <div class="col-xs-2">
                    <div class="navmob-left">
                        <a onclick="opennav()" id="whenopenmobileR">
                            <span class="menu-icon icon-menu"><i class="fa fa-bars" aria-hidden="true"></i></span>
                        </a>
                        <a onclick="closenav()" id="whenclosemobileR">
                            <span class="menu-icon icon-menu"><i class="fas fa-times"></i></span>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="modal model-nf fade" id="myModaNFF">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <p> :الإسم</p>
                    <h4 class="modal-title">أيمن علي</h4>
                    <p> :الموضوع</p>
                    <h3>طلب توريد</h3>
                    <p> :الوقت</p>
                    <h3>4:55</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل
                    الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها
                    تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي"
                    فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب
                    تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص، وإذا قمت بإدخال "lorem ipsum" في أي محرك بحث ستظهر
                    العديد من المواقع الحديثة العهد في نتائج البحث. على مدى السنين ظهرت نسخ جديدة ومختلفة من نص لوريم
                    إيبسوم، أحياناً عن طريق الصدفة، وأحياناً عن عمد كإدخال بعض العبارات الفكاهية إليها.
                </div>

                <div class="send-message">
                    <form>
                        <p class="sendMS">:رد علي الرسالة</p>
                        <textarea placeholder="الرد علي الرسالة" class="sendMS"></textarea>
                        <button type="button" class="btn sendMS" data-dismiss="modal">إرسال</button>
                        <button type="button" class="btn hideMS" onclick="showSend()">رد</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

<?php if(Auth::guard('customers')->check()): ?>
<?php echo $__env->make('layouts.notification', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
<?php echo $__env->make('layouts.notification', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>

<!-- navbar -->
    <div class="navbar-mainmenu rtl overlay" id="myNav">
        <div class="navbar-mainmenu-inner ">
            
            <div class="nav-collapse collapse accordion-body" id="collapse-navbar">
                <ul class="nav">

<li class="dropdown for-menutwo">
      <a href="#" onclick="menuTwo_open()" class="menutwo-open"><i class="fas fa-bars"></i></a>
      <a href="#" onclick="menuTwo_close()" class="menutwo-close"><i class="fas fa-times"></i></a>
      <a href="<?php echo e(url('admin/dashboard')); ?>" tabindex="-1" class="brand title-logo">
        <span style="font-size: 26px; font-weight: bold;"><?php echo e(DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->value('name')); ?></span>
      </a>
</li>
<div class="clock"></div>
<p class="time-date time-date2"><?php echo e(date('Y-m-d')); ?></p>
<?php if(\App\org::find(Auth::user()->org_id)->due_date!=null): ?>
<?php
$Arabic = new I18N_Arabic('Date');
$time=strtotime(\App\org::find(Auth::user()->org_id)->due_date);
$correction = $Arabic->dateCorrection($time);
$Arabic2 = new I18N_Arabic('Numbers');
?>
<li class=""><?php echo e(__('strings.you_enjoy_plan')); ?> <?php echo e(app()->getLocale() == 'ar'?\App\Plans::find(\App\org::find(Auth::user()->org_id)->plan_id)->category_name:\App\Plans::find(\App\org::find(Auth::user()->org_id)->plan_id)->	category_name_en); ?></li>
<li class=""><?php echo e(__('strings.your_subscribtion_will_end_in')); ?> <?php echo e($Arabic2->int2indic($Arabic->date('dS F Y', $time, $correction))); ?> <?php echo e(__('strings.equal_to')); ?> <?php echo e(date('Y/m/d',$time)); ?></li>
<?php endif; ?>
<!--<p class="time-date"><?php echo e(date('h:i')); ?></p>-->
<!--<p class="time-date time-date2"><?php echo e(date('Y-m-d')); ?></p>-->


                <div class="visible-xs">

                    <?php if(Auth::guard('customers')->check()): ?>
                        <li class="dropdown for_margin">
                            <a href="<?php echo e(route('home')); ?>" tabindex="-1">
                              <span><i class="fa fa-home"></i><?php echo e(__('strings.Home')); ?></span>
                            </a>
                        </li>
                     <?php else: ?>
                         <li class="dropdown for_margin">
                            <a href="<?php echo e(url('admin/dashboard')); ?>" tabindex="-1">
                              <span><i class="fa fa-home"></i><?php echo e(__('strings.Home')); ?> </span>
                            </a>
                          </li>
                    <?php endif; ?>

             <!-- display functions depend on user who's login  -->
          
            <?php $__currentLoopData = Session::get('partents'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $func): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($func->appear == 1): ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                        <i class="<?php echo e($func->font); ?>"></i><?php echo e(app()->getLocale() == 'ar' ? $func->funcname : $func->funcname_en); ?>


                    </a>

                    <ul class="dropdown-menu">

                        <?php $__currentLoopData = Session::get('childs'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($func->functions_id == $sub->funcparent_id): ?>
                                <li class="">
                                      <?php if($sub->appear == 1): ?>
                                    <?php $__currentLoopData = Session::get('links'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  
                                        <?php if($sub->functions_id == $link->id): ?>
                                            <a href="<?php echo e(url($link->technical_name)); ?>"><i class="<?php echo e(DB::table('function_new')->where('id', $link->id)->value('font')); ?>"></i><?php echo e(app()->getLocale() == 'ar' ? $sub->funcname : $sub->funcname_en); ?></a>
                                        <?php endif; ?>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                    <?php endif; ?>
                                    
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>
                </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                    <!-- Profile -->
                        <li class="dropdown right new_dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                <?php if(Auth::guard('customers')->check()): ?>
                                    <span class="user-name">
                                    <?php echo e(app()->getLocale() == 'ar' ? Auth::guard('customers')->user()->name : Auth::guard('customers')->user()->name_en); ?>

                                    <i class="fa fa-user"></i>
                                        <i class="fa fa-angle-down"></i>
                            </span>
                                <?php else: ?>
                                    <span class="user-name">
                                    <?php echo e(app()->getLocale() == 'ar' ? Auth::user()->name : Auth::user()->name_en); ?>

                                    <i class="fa fa-user"></i>
                                        <i class="fa fa-angle-down"></i>
                            </span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                      <a href="<?php echo e(route('users.edit', Auth::user()->id)); ?>" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                            <i class="fa fa-user"></i> <span><?php echo e(__('strings.my_account')); ?></span>
                                        </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('changePassword')); ?>" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                        <i class="fa fa-shield"></i> <span><?php echo e(__('strings.Change_Password')); ?></span>
                                    </a>
                                </li>
                                <li>
                                    <?php if(Auth::guard('customers')->check()): ?>

                                        <?php if(app()->getLocale() == 'ar'): ?>
                                         <a href="#" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                           <i class="fas fa-cloud-upload-alt"></i> <span>ترقية الحساب </span>
                                        </a>
                                        <?php else: ?>
                                        <a href="#" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                           <i class="fas fa-cloud-upload-alt"></i> <span>upgrade account  </span>
                                        </a>
                                        <?php endif; ?>


                                    <?php else: ?>

                                        <?php if(app()->getLocale() == 'ar'): ?>
                                         <a href="https://master.filerolesys.com/upgrade/<?php echo e(Auth::user()->org_id); ?>" target="_blank" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                           <i class="fas fa-cloud-upload-alt"></i> <span>ترقية الحساب </span>
                                        </a>
                                        <?php else: ?>
                                        <a href="https://master.filerolesys.com/upgrade/<?php echo e(Auth::user()->org_id); ?>" target="_blank" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                           <i class="fas fa-cloud-upload-alt"></i> <span>upgrade account  </span>
                                        </a>
                                        <?php endif; ?>

                                    <?php endif; ?>
                                </li>

                                <li>
                                    <?php if(Auth::guard('customers')->check()): ?>

                                        <?php if(app()->getLocale() == 'ar'): ?>
                                         <a href="<?php echo e(url('/')); ?>" target="_blank" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                           <i class="fa fa-home"></i> <span>صفحة العميل  </span>
                                        </a>
                                        <?php else: ?>
                                        <a href="<?php echo e(url('/')); ?>" target="_blank" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                          <i class="fa fa-home"></i> <span> customer page  </span>
                                        </a>
                                        <?php endif; ?>


                                    <?php else: ?>

                                        <?php if(app()->getLocale() == 'ar'): ?>
                                         <a href="<?php echo e(url('/')); ?>" target="_blank" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                           <i class="fa fa-home"></i> <span>صفحة العميل  </span>
                                        </a>
                                        <?php else: ?>
                                        <a href="<?php echo e(url('/')); ?>" target="_blank" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                           <i class="fa fa-home"></i> <span> customer page  </span>
                                        </a>
                                        <?php endif; ?>

                                    <?php endif; ?>
                                </li>
                                <?php if(Auth::guard('customers')->check()): ?>


                                    <li>
                                        <a href="<?php echo e(url('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-lock"></i> <span><?php echo e(__('strings.Logout')); ?></span>
                                        </a>
                                    </li>
                                    <form id="logout-form" action="<?php echo e(url('logout')); ?>" method="POST"
                                          style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                <?php else: ?>
                                    <li>
                                        <a href="<?php echo e(url('admin/logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-lock"></i> <span><?php echo e(__('strings.Logout')); ?></span>
                                        </a>
                                    </li>
                                    <form id="logout-form" action="<?php echo e(url('admin/logout')); ?>" method="POST"
                                          style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                <?php endif; ?>
                            </ul>
                        </li>

                                                <!-- Languages -->
                        <li class="dropdown right">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                <?php if(app()->getLocale() == 'ar'): ?>
                                    AR
                                <?php else: ?>
                                    EN
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <!--<li>-->
                                <!--    <a href="<?php echo e(url('lang/en')); ?>" tabindex="-1">-->
                                <!--        <img src="https://invoice.fr3on.info/assets/img/flags/english.png"-->
                                <!--             class="img-flag"> <?php echo e(__('strings.English')); ?>-->
                                <!--    </a>-->
                                <!--</li>-->
                                <li>
                                    <a href="<?php echo e(url('lang/ar')); ?>" tabindex="-1">
                                        <img src="https://invoice.fr3on.info/assets/img/flags/arabic.png"
                                             class="img-flag"> <?php echo e(__('strings.Arabic')); ?>

                                    </a>
                                </li>
                            </ul>
                        </li>


                                <li class="dropdown right">
                                    <button class="btn btn-notification" onclick="opennf()" id="whenopen">
                                        <i class="fas fa-bell"></i>
                                        <span class="badge">3</span>
                                    </button>
                                    <button class="btn btn-notification" onclick="closenf()" id="whenclose">
                                        <i class="fas fa-bell"></i>
                                        <span class="badge">3</span>
                                    </button>
                                </li>


                </ul>
            </div>
            <div style="clear:both;"></div>
        </div>
        <div class="navbar-mainmenu-inner new_nav hidden-xs" id="navdesk">
            <div class="nav-collapse collapse accordion-body " id="collapse-navbar">
                <ul class="nav">


                    <?php if(Auth::guard('customers')->check()): ?>
                        <li class="dropdown for_margin">
                            <a href="<?php echo e(route('home')); ?>" tabindex="-1">
                              <span><i class="fa fa-home"></i><?php echo e(__('strings.Home')); ?></span>
                            </a>
                        </li>
                     <?php else: ?>
                         <li class="dropdown for_margin">
                            <a href="<?php echo e(url('admin/dashboard')); ?>" tabindex="-1">
                              <span><i class="fa fa-home"></i><?php echo e(__('strings.Home')); ?></span>
                            </a>
                          </li>
                    <?php endif; ?>

            <!-- display functions depend on user who's login  -->
           
            <?php $__currentLoopData = Session::get('partents'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $func): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($func->appear == 1): ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                        <i class="<?php echo e($func->font); ?>"></i><?php echo e(app()->getLocale() == 'ar' ? $func->funcname :$func->funcname_en); ?>

                    </a>

                    <ul class="dropdown-menu">

                        <?php $__currentLoopData = Session::get('childs'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($func->functions_id == $sub->funcparent_id): ?>
                                <li class="">
                                     <?php if($sub->appear == 1): ?>
                                    <?php $__currentLoopData = Session::get('links'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   
                                        <?php if($sub->functions_id == $link->id): ?>
                                            <a href="<?php echo e(url($link->technical_name)); ?>"><i class="<?php echo e(DB::table('function_new')->where('id', $link->id)->value('font')); ?>"></i><?php echo e(app()->getLocale() == 'ar' ? $sub->funcname :$sub->funcname_en); ?></a>

                                        <?php endif; ?>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                   
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>
                </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </ul>
            </div>


        </div>
    </div>

    <div class="navbar" id="topSide">
        <div class="navbar-inner">
            <div class="sidebar-pusher">
                <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <?php if(Auth::guard('customers')->check()): ?>
                <div class="logo-box">
                    <a href="<?php echo e(route('home')); ?>"
                       class="logo-text"><span><?php echo e(strtoupper(str_limit(config('settings.business_name'),9))); ?></span></a>
                </div><!-- Logo Box -->
            <?php else: ?>
                <div class="logo-box">
                    <a href="<?php echo e(url('admin/dashboard')); ?>"
                       class="logo-text"><span><?php echo e(strtoupper(str_limit(config('settings.business_name'),9))); ?></span></a>
                </div><!-- Logo Box -->
            <?php endif; ?>
            <div class="topmenu-outer">
                <div class="top-menu">
                    <?php if(Auth::guard('customers')->check()): ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a class="dropdown-toggle waves-effect waves-button waves-classic"
                                   data-toggle="dropdown">
                                    <span class="user-name"><?php echo e(__('strings.Languages')); ?>

                                        <i class="fa fa-angle-down"></i>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-list" role="menu">
                                    <li role="presentation">
                                        <a href="<?php echo e(url('lang/ar')); ?>"><?php echo e(__('strings.Arabic')); ?></a>
                                    </li>
                                    <!--<li role="presentation">-->
                                    <!--    <a href="<?php echo e(url('lang/en')); ?>"><?php echo e(__('strings.English')); ?></a>-->
                                    <!--</li>-->
                                </ul>
                            </li>
                        </ul>
                    <?php else: ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a class="dropdown-toggle waves-effect waves-button waves-classic"
                                   data-toggle="dropdown">
                                    <span class="user-name"><?php echo e(__('strings.Languages')); ?><i
                                                class="fa fa-angle-down"></i> </span>
                                </a>
                                <ul class="dropdown-menu dropdown-list" role="menu">
                                    <li role="presentation">
                                        <a href="<?php echo e(url('lang/ar')); ?>"><?php echo e(__('strings.Arabic')); ?></a>
                                    </li>
                                    <!--<li role="presentation">-->
                                    <!--    <a href="<?php echo e(url('lang/en')); ?>"><?php echo e(__('strings.English')); ?></a>-->
                                    <!--</li>-->
                                </ul>
                            </li>

                            <li>
                                <a href="<?php echo e(route('users.index')); ?>" data-toggle="tooltip" data-placement="bottom"
                                   title="المستخدمين">
                                    <i class="fas fa-users"></i>
                                </a>
                            </li>
                            <li>
                                <a id="loadingicon" href="<?php echo e(route('settings.index')); ?>" data-toggle="tooltip"
                                   data-placement="bottom" title="الإعدادات">
                                    <i class="icon-settings text-danger"></i>
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>


                    <ul class="navbar-totop">
                        <div class="page-sidebar sidebar" id="pageSide">
                            <div class="page-sidebar-inner slimscroll">

                                <ul class="menu accordion-menu">


                                    <?php if(Auth::guard('customers')->check()): ?>
                                        <div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="<?php echo e(route('home')); ?>"
                                               type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                               aria-haspopup="true" aria-expanded="false">
                                                <span class="menu-icon icon-home"></span> <?php echo e(__('strings.Home')); ?>

                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle"
                                               href="<?php echo e(url('admin/dashboard')); ?>" type="button" id="dropdownMenuButton"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="menu-icon icon-home"></span> <?php echo e(__('strings.Home')); ?>

                                            </a>
                                        </div>
                                    <?php endif; ?>



                                    <?php if(Auth::guard('customers')->check()): ?>

                                    <?php else: ?>
                                        <!-- display functions depend on user who's login  -->
                                        <?php $__currentLoopData = Session::get('partents'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $func): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                                    <i class="fa fa-tags"></i><?php echo e(app()->getLocale() == 'ar' ? $func->funcname :$func->funcname_en); ?>

                                                </a>

                                                <ul class="dropdown-menu">

                                                    <?php $__currentLoopData = Session::get('childs'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($func->functions_id == $sub->funcparent_id): ?>
                                                            <li class="">
                                                                <?php if($sub->appear == 1): ?>
                                                                <?php $__currentLoopData = Session::get('links'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                              
                                                                    <?php if($sub->functions_id == $link->id): ?>
                                                                        <a href="<?php echo e(url($link->technical_name)); ?>"><i class="fas fa-poll-h"></i><?php echo e(app()->getLocale() == 'ar' ? $sub->funcname :$sub->funcname_en); ?></a>
                                                                    <?php endif; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                                                    <?php endif; ?>
                                                               
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </ul>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php endif; ?>

                                    <?php if(Auth::guard('customers')->check()): ?>
                                        <li class="visible-xs visible-sm">
                                            <a href="<?php echo e(url('logout')); ?>"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                               class="waves-effect waves-button">
                                                <span class="menu-icon icon-logout"></span>
                                                <p><?php echo e(__('strings.Logout')); ?></p>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li class="visible-xs visible-sm">
                                            <a href="<?php echo e(url('admin/logout')); ?>"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                               class="waves-effect waves-button">
                                                <span class="menu-icon icon-logout"></span>
                                                <p><?php echo e(__('strings.Logout')); ?></p>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                </ul>
                            </div><!-- Page Sidebar Inner -->
                        </div><!-- Page Sidebar -->
                    </ul>

                    <ul class="nav navbar-nav navbar-left">

                    <?php if(Auth::guard('customers')->check()): ?>

                    <?php else: ?>

                        <!-- notification -->
                            <li>
                                <button class="btn btn-notification" onclick="opennf()" id="whenopen">
                                    <i class="fas fa-bell"></i>
                                    <span class="badge">3</span>
                                </button>
                                <button class="btn btn-notification" onclick="closenf()" id="whenclose">
                                    <i class="fas fa-bell"></i>
                                    <span class="badge">3</span>
                                </button>
                            </li>

                    <?php endif; ?>



                    <!-- user setting -->
                        <li class="dropdown">
                            <?php if(Auth::guard('customers')->check()): ?>


                                <a class="dropdown-toggle waves-effect waves-button waves-classic userli"
                                   data-toggle="dropdown">
                                    <span class="user-name"><?php echo e(app()->getLocale() == 'ar' ? Auth::guard('customers')->user()->name : Auth::guard('customers')->user()->name); ?>

                                        <i class="fa fa-angle-down"></i></span>
                                        <img class="img-circle avatar"
                                         src="<?php echo e(Auth::guard('customers')->user()->photo ? asset(Auth::guard('customers')->user()->photo->file) : asset('images/profile-placeholder.png')); ?>"
                                         width="40" height="40"
                                         alt="<?php echo e(app()->getLocale() == 'ar' ? Auth::guard('customers')->user()->name : Auth::guard('customers')->user()->name); ?>">
                                    <p class="time-date"><?php echo e(date('Y-m-d h:i:s')); ?></p>
                                </a>

                                <ul class="dropdown-menu dropdown-list" role="menu">
                                    
                                    <li role="presentation"><a href="<?php echo e(route('changePassword')); ?>"><i
                                                    class="icon-lock"></i> <?php echo e(__('strings.Change_Password')); ?></a></li>
                                    <li role="presentation"><a href="<?php echo e(url('logout')); ?>" onclick="
                                event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                            <i class="icon-logout m-r-xs"></i> <?php echo e(__('strings.Logout')); ?>

                                        </a>
                                    </li>
                                    <form id="logout-form" action="<?php echo e(url('logout')); ?>" method="POST"
                                          style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </ul>

                            <?php else: ?>

                                <a class="dropdown-toggle waves-effect waves-button waves-classic userli"
                                   data-toggle="dropdown">
                                    <span class="user-name"><?php echo e(app()->getLocale() == 'ar' ? Auth::user()->name : Auth::user()->name_en); ?>

                                        <i
                                                class="fa fa-angle-down"></i></span>

                                    <img class="img-circle avatar"
                                         src="<?php echo e(Auth::user()->photo ? asset(Auth::user()->photo->file) : asset('images/profile-placeholder.png')); ?>"
                                         width="40" height="40"
                                         alt="<?php echo e(app()->getLocale() == 'ar' ? Auth::user()->name : Auth::user()->name_en); ?>">
                                    <p class="time-date"><?php echo e(date('Y-m-d h:i:s')); ?></p>
                                </a>

                                <ul class="dropdown-menu dropdown-list" role="menu">

                                    <li role="presentation">
                                        <a href="<?php echo e(route('users.edit', Auth::user()->id)); ?>">
                                            <i class="icon-user"></i><?php echo e(__('strings.Profile')); ?></a>
                                    </li>

                                    <li role="presentation">
                                        <a href="<?php echo e(route('changePassword')); ?>"><i
                                                    class="icon-lock"></i><?php echo e(__('strings.Change_Password')); ?></a>
                                    </li>

                                    <li role="presentation"><a href="<?php echo e(url('admin/logout')); ?>" onclick="
                                event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                            <i class="icon-logout m-r-xs"></i><?php echo e(__('strings.Logout')); ?>

                                        </a>
                                    </li>
                                    <form id="logout-form" action="<?php echo e(url('admin/logout')); ?>" method="POST"
                                          style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <!-- <?php if(Auth::guard('customers')->check()): ?>
                        <li>
                            <a href="<?php echo e(url('logout')); ?>"
                                   class="log-out waves-effect waves-button waves-classic"
                                   onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    <span><i class="icon-logout m-r-xs"></i><?php echo e(__('strings.Logout')); ?></span>
                                </a>
                            </li>
                        <?php else: ?>
                        <li>
                            <a href="<?php echo e(url('admin/logout')); ?>"
                                   class="log-out waves-effect waves-button waves-classic"
                                   onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                    <span><i class="icon-logout m-r-xs"></i><?php echo e(__('strings.Logout')); ?></span>
                                </a>
                            </li>
                        <?php endif; ?> -->

                    </ul><!-- Nav -->
                </div><!-- Top Menu -->
            </div>
        </div>
    </div>
    <!-- Navbar -->


    <div class="page-inner pageinnertwo" style="min-height:100% !important;padding-right:45px !important;" <?php if(Request::is('admin/dashboard')): ?>  id="allbg"
         <?php else: ?> id="allbg" <?php endif; ?>>
        
        <div class="overflow_inner"></div>
 <!--hossam menu path-->
 <div class="page-title">
      <h3><?php echo e(app()->getLocale()=="ar"?\App\FunctionsUser::where('technical_name',Request::path())
        ->where('user_id',Auth::user()->id)
        ->where('org_id',Auth::user()->org_id)->first()->funcname:\App\FunctionsUser::where('technical_name',Request::path())
          ->where('user_id',Auth::user()->id)
          ->where('org_id',Auth::user()->org_id)->first()->funcname_en); ?></h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="<?php echo e(url('admin/dashboard')); ?>"><?php echo e(__('strings.Home')); ?></a></li>
                <?php $__currentLoopData = \App\FunctionsUser::where('functions_id',\App\FunctionsUser::where('technical_name',Request::path())
                  ->where('user_id',Auth::user()->id)
                  ->where('org_id',Auth::user()->org_id)->first()->funcparent_id )->where('user_id',Auth::user()->id)
                  ->where('org_id',Auth::user()->org_id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  
                <li class="active"><a href="<?php echo e(url($parent->technical_name)); ?>"><?php echo e(app()->getLocale()=="ar"?$parent->funcname:$parent->funcname_en); ?></a></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <li class="active"><a href="<?php echo e(url(\App\FunctionsUser::where('technical_name',Request::path())
                  ->where('user_id',Auth::user()->id)
                  ->where('org_id',Auth::user()->org_id)->first()->technical_name)); ?>"><?php echo e(app()->getLocale()=="ar"?\App\FunctionsUser::where('technical_name',Request::path())
                  ->where('user_id',Auth::user()->id)
                  ->where('org_id',Auth::user()->org_id)->first()->funcname:\App\FunctionsUser::where('technical_name',Request::path())
                    ->where('user_id',Auth::user()->id)
                    ->where('org_id',Auth::user()->org_id)->first()->funcname_en); ?></a></li>
            </ol>
        </div>
    </div>
    <!--end hossam menu path-->
    <?php echo $__env->make('alerts.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->yieldContent('content'); ?>

    <!-- Main Wrapper -->
    <div class="page-footer">
        <p class="no-s">
            <?php echo e(__('strings.footer_text')); ?>

        </p>
    </div>
    </div><!-- Page Inner -->
</main><!-- Page Content -->
<div class="cd-overlay"></div>


<!-- Javascripts -->
<?php if(Request::route()->getName() == 'EditMenu'): ?>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src='<?php echo asset("bs-iconpicker/js/iconset/iconset-fontawesome-4.7.0.min.js"); ?>'></script>
<script src='<?php echo asset("bs-iconpicker/js/bootstrap-iconpicker.js"); ?>'></script>
<script src='<?php echo asset("jquery-menu-editor.js"); ?>'></script>
<?php else: ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<?php endif; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>

<!--<script src="<?php echo e(asset('plugins/pace-master/pace.min.js')); ?>"></script>-->
<script src="<?php echo e(asset('plugins/bootstrap/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/jquery-slimscroll/jquery.slimscroll.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/waves/waves.min.js')); ?>"></script>

<!-- datatabels js -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script>

<script src="<?php echo e(asset('js/three.r92.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/vanta.net.min.js')); ?>"></script>

<script src="<?php echo e(asset('js/backend.min.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.0.0/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/locales/nl.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/0.8.3/purify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.4.2/Sortable.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/fileinput.min.js"></script>

<?php if(Request::is('admin/kpi/list') || Request::is('admin/kpi/create') || Request::is('admin/kpi/assign') || Request::is('admin/kpi/average/list') || Request::is('admin/kpi/reports') || Request::is('admin/kpi/average-reports')): ?>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js"></script>
<?php else: ?>
    <script src="<?php echo e(asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')); ?>"></script>
<?php endif; ?>

<script src="<?php echo e(asset('plugins/summernote-master/summernote.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/pages/form-elements.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jquery.tagsinput.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<?php if(app()->getLocale() == 'ar'): ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/language/ar_MA.js"></script>
<?php else: ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/language/en_US.js"></script>
<?php endif; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script> 

<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<script src="<?php echo e(asset('js/hossam.js')); ?>"></script>

<script src="<?php echo e(asset('js/back_app.js')); ?>"></script>
<script src="<?php echo e(asset('js/notification.js')); ?>"></script>



 <?php echo $__env->yieldContent('scripts'); ?>
    <?php echo $__env->yieldContent('chart_script'); ?>
    <script type="text/javascript">
        <?php if(App\Settings::where(['key' => 'menu', 'org_id' => Auth::user()->org_id])->value('value') == 'on'): ?>
            $('#navdesk').removeClass('nav-top-desk');
            $('.menu-two').removeClass('nav-top-desk2');
            $('.page-inner').css('paddingTop', '45px');
            $('.menutwo-open').removeClass('nav-top-desk2');
        <?php else: ?>
            $('#navdesk').addClass('nav-top-desk');
            $('.menu-two').addClass('nav-top-desk2');
            $('.page-inner').css('paddingTop', '80px');
            $('.menutwo-open').addClass('nav-top-desk2');
        <?php endif; ?>
        $(document).ready(function () {
            /* $('#xtreme-table, #xtreme-table55, .xtreme-table, #DataTables_Table_0, #tab_logic').addClass('dt-responsive');*/
            $('#xtreme-table, #xtreme-table55, .xtreme-table, #DataTables_Table_0, #tab_logic').dataTable({
                "language": {
                    <?php if(app()->getLocale() == "en"): ?>
                    "url": "<?php echo e(asset('plugins/datatables/lang/en.json')); ?>"
                    <?php elseif(app()->getLocale() == "ar"): ?>
                    "url": "<?php echo e(asset('plugins/datatables/lang/ar.json')); ?>"
                    <?php endif; ?>
                },
               "ordering": false
            });
            $.fn.dataTable.ext.errMode = 'none';
            
        });
        <?php if(App\Settings::where(['key' => 'menu', 'org_id' => Auth::user()->org_id])->value('value') == 'on' ): ?>
            $('#menu_check').change(function () {
                if ($(this).is(":checked")) {
                    $('#navdesk').addClass('nav-top-desk');
                    $('.menu-two').addClass('nav-top-desk2');
                    $('.page-inner').css('paddingTop', '80px');
                    $('.menutwo-open').addClass('nav-top-desk2');
                } else {
    
                }
            });
            <?php else: ?>
            $('#menu_check').change(function () {
                if ($(this).is(":checked")) {
                } else {
                    $('#navdesk').removeClass('nav-top-desk');
                    $('.menu-two').removeClass('nav-top-desk2');
                    $('.page-inner').css('paddingTop', '45px');
                    $('.menutwo-open').removeClass('nav-top-desk2');
                }
            });
        <?php endif; ?>
        <?php if(\Request::route()->getName() != 'EditMenu'): ?>
            /* Add slideDown animation to Bootstrap dropdown when expanding.*/
            $('.menu-two .dropdown').on('show.bs.dropdown', function () {
                $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
            });
            /* Add slideUp animation to Bootstrap dropdown when collapsing.*/
            $('.menu-two .dropdown').on('hide.bs.dropdown', function () {
                $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
            });
        <?php endif; ?>
    </script>
  

<?php if(\App\Settings::where('org_id',Auth::user()->org_id)->where('key','session')->first()->value=='on'): ?>
    <!--hossam auto session login -->
    <div class="limiter" id="session-expire-warning-modal" style="display:none;">
        <div class="container-login100">
            <div class="wrap-login100">


                
                <div class="login100-pic js-tilt pulse">
                    <img src="<?php echo e(asset(!empty(DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->value('image_id')) && !empty(App\Photo::findOrFail(DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->value('image_id'))->file) ? App\Photo::findOrFail(DB::table('organizations')->where('owner_url', explode('/',url()->current())[2] )->value('image_id'))->file : 'trust.png')); ?>"
                         alt="IMG">
                </div>

                <span class="login100-form-title">
          <?php echo e(app()->getLocale()=='ar'?Auth::user()->name:Auth::user()->name_en); ?>

        </span>

                <div class="wrap-input100 validate-input" data-validate="Email or Phone number is required">
                    <div id="remaningattempts" style="color:black;"></div>
                    <input class="input100" type="text" name="email_phone" value="<?php echo e(Auth::user()->email); ?>"  placeholder="<?php echo e(Auth::user()->email); ?>" id="email_phone">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
            <i class="fas fa-envelope" style="marign-top:20px !important;"></i>
          </span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Password is required">
                    <div id="remaningattempts" style="color:black;"></div>
                    <input class="input100" type="password" name="password" placeholder="Password" id="showpassword">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
            <i class="fa fa-lock" aria-hidden="true"></i>
          </span>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" id="butEnter" onclick="loginUser()">
                        Login
                    </button>
                </div>
                

            </div>
        </div>
    </div>
    <!--End Show Session Expire Warning Popup here -->

    <!--Start Show Session Expire Popup here -->
    <script>
        var sessServerAliveTime = 10 * 60 * 10 * 10;
        var sessionTimeout = 1 * 60000 *<?php echo e(\App\Settings::where('org_id',Auth::user()->org_id)->where('key','session_time')->first()->value); ?>;
        var i = 3;
        var sessLastActivity;
        var idleTimer, remainingTimer;
        var isTimout = false;

        var sess_intervalID, idleIntervalID;
        var sess_lastActivity;
        var timer;
        var isIdleTimerOn = false;
        localStorage.setItem('sessionSlide', 'isStarted');

        function sessPingServer() {
            if (!isTimout) {
                return true;
            }
        }

        function initSessionMonitor() {
            $(document).bind('keypress', function (ed, e) {
                console.log('hello');
                localStorage.setItem('sessionSlide', 'isStarted');

                startIdleTime();
                sessKeyPressed(ed, e);
            });
            $(document).bind('click', function (ed, e) {
                console.log('hello');
                localStorage.setItem('sessionSlide', 'isStarted');
                startIdleTime();
                sessKeyPressed(ed, e);
            });
        }

        $(window).scroll(function (e) {
            localStorage.setItem('sessionSlide', 'isStarted');
            startIdleTime();
        });
        $(window).click(function (e) {
            localStorage.setItem('sessionSlide', 'isStarted');
            startIdleTime();
        });
        $(document).keypress(function (e) {
            localStorage.setItem('sessionSlide', 'isStarted');
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("butEnter").click();
            }
            startIdleTime();
        });

        function sessKeyPressed(ed, e) {
            localStorage.setItem('sessionSlide', 'isStarted');
            startIdleTime();
            var target = ed ? ed.target : window.event.srcElement;
            var sessionTarget = $(target).parents("#session-expire-warning-modal").length;

            if (sessionTarget != null && sessionTarget != undefined) {
                if (ed.target.id != "btnSessionExpiredCancelled" && ed.target.id != "btnSessionModal" && ed.currentTarget.activeElement.id != "session-expire-warning-modal" && ed.target.id != "btnExpiredOk"
                    && ed.currentTarget.activeElement.className != "modal fade modal-overflow in" && ed.currentTarget.activeElement.className != 'modal-header'
                    && sessionTarget != 1 && ed.target.id != "session-expire-warning-modal") {
                    localStorage.setItem('sessionSlide', 'isStarted');
                    startIdleTime();
                }
            }
        }

        function startIdleTime() {
            stopIdleTime();
            localStorage.setItem("sessIdleTimeCounter", $.now());
            idleIntervalID = setInterval('checkIdleTimeout()', 1000);
            isIdleTimerOn = false;
        }

        var sessionExpired = document.getElementById("session-expired-modal");

        function sessionExpiredClicked(evt) {
            window.location = "Logout.html";
        }

        sessionExpired.addEventListener("click", sessionExpiredClicked, false);

        function stopIdleTime() {
            clearInterval(idleIntervalID);
            clearInterval(remainingTimer);
        }

        function checkIdleTimeout() {
            var idleTime = (parseInt(localStorage.getItem('sessIdleTimeCounter')) + (sessionTimeout));
            console.log(idleTime);
            if ($.now() > idleTime + 60000) {
                clearInterval(sess_intervalID);
                clearInterval(idleIntervalID);
                isTimout = true;
            } else if ($.now() > idleTime) {
                if (!isIdleTimerOn) {
                    localStorage.setItem('sessionSlide', false);
                    $.post("<?php echo e(url('ajax/logout')); ?>", function (data) {
                        console.log(data);
                    });
                    $("#session-expire-warning-modal").css('display', 'block');
                    
                    $('.page-header-fixed').addClass('bodyhide');
                    isIdleTimerOn = true;
                }
            }
        }

        $("#btnSessionExpiredCancelled").click(function () {
        });

        $("#btnOk").click(function () {
            $("#session-expire-warning-modal").modal('hide');
            $('#email_phone, #showpassword').val('');
            startIdleTime();
            clearInterval(remainingTimer);
            localStorage.setItem('sessionSlide', 'isStarted');
        });

        function loginUser() {
            $.ajax({
                url: "<?php echo e(url('/ajax/login')); ?>",
                type: "GET",
                data: {
                    password: $('#showpassword').val(), mail: $('#email_phone').val()
                },
                dataType: "json",
                success: function (data) {
                    if (data === true) {
                        $('body').css('overflow', 'auto');
                        $("#session-expire-warning-modal").css('display', 'none');
                        $('#email_phone, #showpassword').val('');
                        location.reload();
                    } else {
                        i = i - 1;
                        $('#remaningattempts').empty();
                        $('#remaningattempts').append('<?php echo e(__('strings.remaing attempts are')); ?>' + i);

                        if (i < 1) {
                            window.location.href = "<?php echo e(url('/admin/session_log_out')); ?>";
                        }
                    }
                }

            });
        }
        <?php endif; ?>
        
    </script>
    <script src="<?php echo e(asset('js/mohamed.js')); ?>"></script>
    
</body>
</html>

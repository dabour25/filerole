<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if(app()->getLocale() == 'ar') dir="rtl" @endif>
<head>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>{{ $title }} | {{ config('organizations.name') }} - {{ __('strings.admin') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta charset="UTF-8">
    <meta name="title" content="{{ $title }}"/>
    <meta name="description" content="Admin Panel for {{ config('settings.business_name') }}."/>
    <meta name="keywords" content=""/>
    <meta name="author" content="Pharaoh"/>

    <link rel="icon" href="{{ asset('favicon.png') }}">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Droid+Sans"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.21.0/slimselect.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link href="{{ asset('plugins/pace-master/themes/blue/pace-theme-flash.css') }}" rel="stylesheet"/>
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/fontawesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/line-icons/simple-line-icons.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/waves/waves.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>


    @if(Request::is('admin/kpi/list') || Request::is('admin/kpi/create') || Request::is('admin/kpi/assign') || Request::is('admin/kpi/average/list') || Request::is('admin/kpi/reports') || Request::is('admin/kpi/average-reports') || Request::is('admin/salary_report'))
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.css"/>
    @else
        <link href="{{ asset('plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css"/>
    @endif

    <link href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('plugins/summernote-master/summernote.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.tagsinput.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.css"/>

    <!-- Theme Styles -->
    @if(app()->getLocale() == 'ar')
        <link href="{{ asset('css/backend_rtl.min.css') }}" rel="stylesheet" type="text/css"/>
    @else
        <link href="{{ asset('css/backend.min.css') }}" rel="stylesheet" type="text/css"/>
    @endif

    <link href="{{ asset('/css/themes/green.css') }}" class="theme-color" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet" type="text/css"/>

    {{--<link href="https://bookify-dentists.xtreme-webs.com/css/backend.min.css" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="https://bookify-dentists.xtreme-webs.com/css/themes/green.css" class="theme-color" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="https://bookify-dentists.xtreme-webs.com/css/custom.css" rel="stylesheet" type="text/css"/>--}}
    @if(Auth::guard('customers')->check())
        <style>
            .nav-pills > li.active > a, .nav-pills > li.active > a:focus, .nav-pills > li.active > a:hover {
                color: #fff;
                background-color: {{ DB::table('organizations')->where(['id' => Auth::guard('customers')->user()->org_id])->value('main_color')}};
            }

            .btn-primary {
                color: #fff;
                background-color: {{ DB::table('organizations')->where([ 'id' => Auth::guard('customers')->user()->org_id])->value('main_color')}};
                border-color: transparent
            }

            .btn-primary.active, .btn-primary.active.focus, .btn-primary.active:focus, .btn-primary.active:hover, .btn-primary.focus, .btn-primary:active, .btn-primary:active.focus, .btn-primary:active:focus, .btn-primary:active:hover, .btn-primary:focus, .btn-primary:hover, .open > .dropdown-toggle.btn-primary, .open > .dropdown-toggle.btn-primary.focus, .open > .dropdown-toggle.btn-primary:focus, .open > .dropdown-toggle.btn-primary:hover {
                color: #fff;
                background-color: {{ DB::table('organizations')->where(['id' => Auth::guard('customers')->user()->org_id])->value('main_color')}};
                border-color: transparent
            }

            .btn-primary.disabled, .btn-primary.disabled.active, .btn-primary.disabled.focus, .btn-primary.disabled:active, .btn-primary.disabled:focus, .btn-primary.disabled:hover, .btn-primary[disabled], .btn-primary[disabled].active, .btn-primary[disabled].focus, .btn-primary[disabled]:active, .btn-primary[disabled]:focus, .btn-primary[disabled]:hover, fieldset[disabled] .btn-primary, fieldset[disabled] .btn-primary.active, fieldset[disabled] .btn-primary.focus, fieldset[disabled] .btn-primary:active, fieldset[disabled] .btn-primary:focus, fieldset[disabled] .btn-primary:hover {
                background-color: {{ DB::table('organizations')->where(['id' => Auth::guard('customers')->user()->org_id])->value('main_color')}};
                border-color: transparent
            }

            .menu {
                background: {{ DB::table('organizations')->where(['id' => Auth::guard('customers')->user()->org_id])->value('menu_color')}};
            }

            .topmenu-outer {
                height: 60px;
                background: {{ DB::table('organizations')->where([ 'id' => Auth::guard('customers')->user()->org_id])->value('head_color')}};
                margin-right: 160px;
            }

            .page-content {
                background: {{ DB::table('organizations')->where([ 'id' => Auth::guard('customers')->user()->org_id])->value('menu_color')}};
            }

            .menu.accordion-menu > li.active > a,
            .menu.accordion-menu > li.active.open > a {
                background: {{ DB::table('organizations')->where([ 'id' => Auth::guard('customers')->user()->org_id])->value('menu_color')}};
                color: #fff;
            }

            .page-footer {
                background: {{ DB::table('organizations')->where([  'id' => Auth::guard('customers')->user()->org_id])->value('head_color')}};
                width: 100%;
                display: block;
                position: absolute;
                bottom: 0;
                padding: 19px 25px
            }
        </style>
    @else
        <style>
            .nav-pills > li.active > a, .nav-pills > li.active > a:focus, .nav-pills > li.active > a:hover {
                color: #fff;
                background-color: {{ DB::table('organizations')->where([  'id' => Auth::user()->org_id])->value('main_color')}};
            }

            .btn-primary {
                color: #fff;
                background-color: {{ DB::table('organizations')->where([  'id' => Auth::user()->org_id])->value('main_color')}};
                border-color: transparent
            }

            .btn-primary.active, .btn-primary.active.focus, .btn-primary.active:focus, .btn-primary.active:hover, .btn-primary.focus, .btn-primary:active, .btn-primary:active.focus, .btn-primary:active:focus, .btn-primary:active:hover, .btn-primary:focus, .btn-primary:hover, .open > .dropdown-toggle.btn-primary, .open > .dropdown-toggle.btn-primary.focus, .open > .dropdown-toggle.btn-primary:focus, .open > .dropdown-toggle.btn-primary:hover {
                color: #fff;
                background-color: {{ DB::table('organizations')->where([  'id' => Auth::user()->org_id])->value('main_color')}};
                border-color: transparent
            }

            .btn-primary.disabled, .btn-primary.disabled.active, .btn-primary.disabled.focus, .btn-primary.disabled:active, .btn-primary.disabled:focus, .btn-primary.disabled:hover, .btn-primary[disabled], .btn-primary[disabled].active, .btn-primary[disabled].focus, .btn-primary[disabled]:active, .btn-primary[disabled]:focus, .btn-primary[disabled]:hover, fieldset[disabled] .btn-primary, fieldset[disabled] .btn-primary.active, fieldset[disabled] .btn-primary.focus, fieldset[disabled] .btn-primary:active, fieldset[disabled] .btn-primary:focus, fieldset[disabled] .btn-primary:hover {
                background-color: {{ DB::table('organizations')->where([  'id' => Auth::user()->org_id])->value('main_color')}};
                border-color: transparent
            }

            .menu {
                background: {{ DB::table('organizations')->where([ 'id' => Auth::user()->org_id])->value('menu_color')}};
            }

            .topmenu-outer {
                height: 60px;
                background: {{ DB::table('organizations')->where([ 'id' => Auth::user()->org_id])->value('head_color')}};
                margin-right: 160px;
            }

            .page-content {
                background: {{ DB::table('organizations')->where([ 'id' => Auth::user()->org_id])->value('menu_color')}};
            }

            .menu.accordion-menu > li.active > a,
            .menu.accordion-menu > li.active.open > a {
                background: {{ DB::table('organizations')->where([ 'id' => Auth::user()->org_id])->value('menu_color')}};
                color: #fff;
            }

            .page-footer {
                background: {{ DB::table('organizations')->where([ 'id' => Auth::user()->org_id])->value('head_color')}};
                width: 100%;
                display: block;
                position: absolute;
                bottom: 0;
                padding: 19px 25px
            }
        </style>
    @endif
    @yield('styles')
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

@yield('template')

<body class="page-header-fixed pace-done small-sidebar" id="output-text">
<div class="overlay"></div>

@if(Request::is('admin/inbox/*'))

@else
    @if(App\Settings::where(['key' => 'loading', 'org_id' => \Auth::user()->org_id])->value('value') != '')
        <div class="loading-overlay text-center" id="loadingg">
            <div class="all-spi">
                <div class="spinner">
                    <div class="dot1"></div>
                    <div class="dot2"></div>
                </div>
            </div>
        </div>
    @endif
@endif

<main class="page-content content-wrap">

    <header id="header-mob" class="visible-xs">
        <div class="container">
            <div class="row">
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
                <div class="col-xs-2">
                    <div class="navmob-left">
                        <a id="viewport"><i class="fa fa-desktop"></i></a>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="icon-mob">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="fas fa-globe"></i>
                            </button>
                            <ul class="dropdown-menu">
                                @if(app()->getLocale() == 'ar')
                                    <li class="langN"><a href="{{ url('lang/ar') }}">{{ __('strings.Arabic') }}</a></li>
                                    <li><a href="{{ url('lang/en') }}">{{ __('strings.English') }}</a></li>
                                @else
                                    <li><a href="{{ url('lang/ar') }}">{{ __('strings.Arabic') }}</a></li>
                                    <li class="langN"><a href="{{ url('lang/en') }}">{{ __('strings.English') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="icon-mob">
                        <a href="{{ route('settings.index') }}">
                            <i class="fas fa-users"></i>
                        </a>
                    </div>
                </div>
                <div class="col-xs-2">
                    @if(Auth::guard('customers')->check())

                    @else
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
                    @endif

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

@if(Auth::guard('customers')->check())


@endif

<!-- navbar -->
    <div class="navbar-mainmenu rtl overlay" id="myNav">
        <div class="navbar-mainmenu-inner ">

            <div class="nav-collapse collapse accordion-body" id="collapse-navbar">
                <ul class="nav">

                    @if(Auth::guard('customers')->check())
                        <li class="dropdown">
                            <a href="{{ route('home') }}" tabindex="-1" class="brand">
                                <span style="font-size: 15px; font-weight: bold;">{{ DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->value('name') }}</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="{{ route('home') }}" tabindex="-1">
                                <span><i class="fa fa-home"></i>{{ __('strings.Home') }}</span>
                            </a>
                        </li>
                    @else
                        <li class="dropdown">
                            <a href="{{ route('home') }}" tabindex="-1" class="brand">
                                <span style="font-size: 15px; font-weight: bold;">{{ DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->value('name') }}</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="{{ route('home') }}" tabindex="-1">
                                <span><i class="fa fa-home"></i>{{ __('strings.Home') }}</span>
                            </a>
                        </li>
                        <!-- display functions depend on user who's login  -->
                       
                        @foreach($funcs as $func)
                        @if($func->appear == 1)
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                    <i class="fa fa-tags"></i>{{$func->funcname}}
                                </a>

                                <ul class="dropdown-menu">

                                    @foreach($sub_funcs as $sub )
                                        @if($func->functions_id == $sub->funcparent_id)
                                            <li class="">
                                                @foreach($func_links as $link)
                                                @if($sub->appear == 1)
                                                    @if($sub->functions_id == $link->id)
                                                        <a href="{{url($link->technical_name)}}"><i class="fas fa-poll-h"></i>{{$sub->funcname}}</a>
                                                    @endif
                                                @endif
                                                @endforeach
                                            </li>
                                        @endif
                                    @endforeach

                                </ul>
                            </li>
                            @endif
                        @endforeach

                        @if(Auth::guard('customers')->check())

                        @else
                            <!-- notification -->
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
                        @endif


                    @endif

                    <!-- Profile -->
                        <li class="dropdown right">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                <span>حسابي</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    @if(Auth::guard('customers')->check())

                                    @else
                                        <a href="{{ route('users.edit', Auth::user()->id) }}" sis-modal="users_table"
                                           class="sis_modal" tabindex="-1">
                                            <i class="fa fa-user"></i> <span>الملف الشخصي</span>
                                        </a>
                                    @endif
                                </li>
                                <li>
                                    <a href="{{ route('changePassword') }}" sis-modal="users_table" class="sis_modal"
                                       tabindex="-1">
                                        <i class="fa fa-shield"></i> <span>{{ __('strings.Change_Password') }}</span>
                                    </a>
                                </li>
                                @if(Auth::guard('customers')->check())


                                    <li>
                                        <a href="{{ url('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-lock"></i> <span>{{ __('strings.Logout') }}</span>
                                        </a>
                                    </li>
                                    <form id="logout-form" action="{{ url('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                    <li>
                                        <a href="{{ url('admin/logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-lock"></i> <span>{{ __('strings.Logout') }}</span>
                                        </a>
                                    </li>
                                    <form id="logout-form" action="{{ url('admin/logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                @endif
                            </ul>
                        </li>


                        <!-- Languages -->
                        <li class="dropdown right">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                @if(app()->getLocale() == 'ar')
                                    <img src="https://invoice.fr3on.info/assets/img/flags/arabic.png" class="img-flag">
                                    &nbsp;
                                @else
                                    <img src="https://invoice.fr3on.info/assets/img/flags/english.png" class="img-flag">
                                    &nbsp;
                                @endif
                                <span class="hidden-lg-up">{{ __('strings.Languages') }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ url('lang/en') }}" tabindex="-1">
                                        <img src="https://invoice.fr3on.info/assets/img/flags/english.png"
                                             class="img-flag"> {{ __('strings.English') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('lang/ar') }}" tabindex="-1">
                                        <img src="https://invoice.fr3on.info/assets/img/flags/arabic.png"
                                             class="img-flag"> {{ __('strings.Arabic') }}
                                    </a>
                                </li>
                            </ul>
                        </li>

                </ul>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>

    <div class="navbar" id="topSide">
        <div class="navbar-inner">
            <div class="sidebar-pusher">
                <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            @if(Auth::guard('customers')->check())
                <div class="logo-box">
                    <a href="{{ route('home') }}"
                       class="logo-text"><span>{{  strtoupper(str_limit(config('settings.business_name'),9)) }}</span></a>
                </div><!-- Logo Box -->
            @else
                <div class="logo-box">
                    <a href="{{ url('admin/dashobard') }}"
                       class="logo-text"><span>{{  strtoupper(str_limit(config('settings.business_name'),9)) }}</span></a>
                </div><!-- Logo Box -->

            @endif
            <div class="topmenu-outer">
                <div class="top-menu">
                    @if(Auth::guard('customers')->check())
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a class="dropdown-toggle waves-effect waves-button waves-classic"
                                   data-toggle="dropdown">
                                    <span class="user-name">{{ __('strings.Languages') }}
                                        <i class="fa fa-angle-down"></i>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-list" role="menu">
                                    <li role="presentation">
                                        <a href="{{ url('lang/ar') }}">{{ __('strings.Arabic') }}</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="{{ url('lang/en') }}">{{ __('strings.English') }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    @else
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a class="dropdown-toggle waves-effect waves-button waves-classic"
                                   data-toggle="dropdown">
                                    <span class="user-name">{{ __('strings.Languages') }}<i
                                                class="fa fa-angle-down"></i> </span>
                                </a>
                                <ul class="dropdown-menu dropdown-list" role="menu">
                                    <li role="presentation">
                                        <a href="{{ url('lang/ar') }}">{{ __('strings.Arabic') }}</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="{{ url('lang/en') }}">{{ __('strings.English') }}</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{ route('users.index') }}" data-toggle="tooltip" data-placement="bottom"
                                   title="المستخدمين">
                                    <i class="fas fa-users"></i>
                                </a>
                            </li>
                            <li>
                                <a id="loadingicon" href="{{ route('settings.index') }}" data-toggle="tooltip"
                                   data-placement="bottom" title="الإعدادات">
                                    <i class="icon-settings text-danger"></i>
                                </a>
                            </li>
                        </ul>
                    @endif


                    <ul class="navbar-totop">
                        <div class="page-sidebar sidebar" id="pageSide">
                            <div class="page-sidebar-inner slimscroll">

                                <ul class="menu accordion-menu">


                                    @if(Auth::guard('customers')->check())
                                        <div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="{{ route('home') }}"
                                               type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                               aria-haspopup="true" aria-expanded="false">
                                                <span class="menu-icon icon-home"></span> {{ __('strings.Home') }}
                                            </a>
                                        </div>
                                    @else
                                        <div class="dropdown">
                                            <a class="btn btn-secondary dropdown-toggle"
                                               href="{{ url('admin/dashboard') }}" type="button" id="dropdownMenuButton"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="menu-icon icon-home"></span> {{ __('strings.Home') }}
                                            </a>
                                        </div>
                                    @endif



                                    @if(Auth::guard('customers')->check())

                                    @else
                                        <!-- display functions depend on user who's login  -->
                                        @foreach($funcs as $func)
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                                    <i class="fa fa-tags"></i>{{$func->funcname}}
                                                </a>

                                                <ul class="dropdown-menu">

                                                    @foreach($sub_funcs as $sub )
                                                        @if($func->functions_id == $sub->funcparent_id)
                                                            <li class="">
                                                                @foreach($func_links as $link)
                                                                    @if($sub->functions_id == $link->id)
                                                                        <a href="{{url($link->technical_name)}}"><i class="fas fa-poll-h"></i>{{$sub->funcname}}</a>
                                                                    @endif
                                                                @endforeach
                                                            </li>
                                                        @endif
                                                    @endforeach

                                                </ul>
                                            </li>
                                        @endforeach

                                    @endif

                                    @if(Auth::guard('customers')->check())
                                        <li class="visible-xs visible-sm">
                                            <a href="{{ url('logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                               class="waves-effect waves-button">
                                                <span class="menu-icon icon-logout"></span>
                                                <p>{{ __('strings.Logout') }}</p>
                                            </a>
                                        </li>
                                    @else
                                        <li class="visible-xs visible-sm">
                                            <a href="{{ url('admin/logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                               class="waves-effect waves-button">
                                                <span class="menu-icon icon-logout"></span>
                                                <p>{{ __('strings.Logout') }}</p>
                                            </a>
                                        </li>
                                    @endif

                                </ul>
                            </div><!-- Page Sidebar Inner -->
                        </div><!-- Page Sidebar -->
                    </ul>

                    <ul class="nav navbar-nav navbar-left">

                    @if(Auth::guard('customers')->check())

                    @else

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

                    @endif



                    <!-- user setting -->
                        <li class="dropdown">
                            @if(Auth::guard('customers')->check())


                                <a class="dropdown-toggle waves-effect waves-button waves-classic userli"
                                   data-toggle="dropdown">
                                    <span class="user-name">{{ app()->getLocale() == 'ar' ? Auth::guard('customers')->user()->name : Auth::guard('customers')->user()->name }}
                                        <i
                                                class="fa fa-angle-down"></i></span>

                                    <img class="img-circle avatar"
                                         src="{{ Auth::guard('customers')->user()->photo ? asset(Auth::guard('customers')->user()->photo->file) : asset('images/profile-placeholder.png') }}"
                                         width="40" height="40"
                                         alt="{{ app()->getLocale() == 'ar' ? Auth::guard('customers')->user()->name : Auth::guard('customers')->user()->name }}">
                                    <p class="time-date">{{ date('Y-m-d h:i:s') }}</p>
                                </a>

                                <ul class="dropdown-menu dropdown-list" role="menu">
                                    {{--<li role="presentation"><a href="{{ route('users.edit', Auth::user()->id) }}"><i class="icon-user"></i>الملف الشخصى</a></li>--}}
                                    <li role="presentation"><a href="{{ route('changePassword') }}"><i
                                                    class="icon-lock"></i> {{ __('strings.Change_Password') }}</a></li>
                                    <li role="presentation"><a href="{{ url('logout') }}" onclick="
                                event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                            <i class="icon-logout m-r-xs"></i> {{ __('strings.Logout') }}
                                        </a>
                                    </li>
                                    <form id="logout-form" action="{{ url('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </ul>

                            @else

                                <a class="dropdown-toggle waves-effect waves-button waves-classic userli"
                                   data-toggle="dropdown">
                                    <span class="user-name">{{ app()->getLocale() == 'ar' ? Auth::user()->name : Auth::user()->name_en }}
                                        <i
                                                class="fa fa-angle-down"></i></span>

                                    <img class="img-circle avatar"
                                         src="{{ Auth::user()->photo ? asset(Auth::user()->photo->file) : asset('images/profile-placeholder.png') }}"
                                         width="40" height="40"
                                         alt="{{ app()->getLocale() == 'ar' ? Auth::user()->name : Auth::user()->name_en }}">
                                    <p class="time-date">{{ date('Y-m-d h:i:s') }}</p>
                                </a>

                                <ul class="dropdown-menu dropdown-list" role="menu">

                                    <li role="presentation">
                                        <a href="{{ route('users.edit', Auth::user()->id) }}">
                                            <i class="icon-user"></i>{{ __('strings.Profile') }}</a>
                                    </li>

                                    <li role="presentation">
                                        <a href="{{ route('changePassword') }}"><i
                                                    class="icon-lock"></i>{{ __('strings.Change_Password') }}</a>
                                    </li>

                                    <li role="presentation"><a href="{{ url('admin/logout') }}" onclick="
                                event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                            <i class="icon-logout m-r-xs"></i>{{ __('strings.Logout') }}
                                        </a>
                                    </li>
                                    <form id="logout-form" action="{{ url('admin/logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </ul>
                            @endif
                        </li>
                    <!-- @if(Auth::guard('customers')->check())
                        <li>
                            <a href="{{ url('logout') }}"
                                   class="log-out waves-effect waves-button waves-classic"
                                   onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    <span><i class="icon-logout m-r-xs"></i>{{ __('strings.Logout') }}</span>
                                </a>
                            </li>
                        @else
                        <li>
                            <a href="{{ url('admin/logout') }}"
                                   class="log-out waves-effect waves-button waves-classic"
                                   onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                    <span><i class="icon-logout m-r-xs"></i>{{ __('strings.Logout') }}</span>
                                </a>
                            </li>
                        @endif -->

                    </ul><!-- Nav -->
                </div><!-- Top Menu -->
            </div>
        </div>
    </div>
    <!-- Navbar -->


    <div class="page-inner" style="min-height:100% !important" @if(Request::is('admin/dashboard'))  id="allbg"
         @else id="allbg" @endif>

    @yield('content')

    <!-- Main Wrapper -->
        <div class="page-footer">
            <p class="no-s">
                حقوق التأليف والنشر. © {{ date('Y') }}. جميع الحقوق محفوظة لشركة فايل رول.
            </p>
        </div>
    </div><!-- Page Inner -->
</main><!-- Page Content -->
<div class="cd-overlay"></div>


<!-- Javascripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('plugins/pace-master/pace.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('plugins/waves/waves.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script>

<script src="{{ asset('js/three.r92.min.js') }}"></script>
<script src="{{ asset('js/vanta.net.min.js') }}"></script>

<script src="{{ asset('js/backend.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/jquery.datatables.min.js') }}"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


@if(Request::is('admin/kpi/list') || Request::is('admin/kpi/create') || Request::is('admin/kpi/assign') || Request::is('admin/kpi/average/list') || Request::is('admin/kpi/reports') || Request::is('admin/kpi/average-reports'))
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js"></script>
@else
    <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
@endif

<script src="{{ asset('plugins/summernote-master/summernote.min.js') }}"></script>
<script src="{{ asset('js/pages/form-elements.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.tagsinput.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.js"></script>

@if(app()->getLocale() == 'ar')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/language/ar_MA.js"></script>
@else
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/language/en_US.js"></script>
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.21.0/slimselect.min.js"></script>


@yield('scripts')


<script type="text/javascript">
    $(document).ready(function () {

        $('#xtreme-table, #xtreme-tables, #xtreme-tabless, #xtreme-tablesss').dataTable({
            "language": {
                @if(app()->getLocale() == "en")
                "url": "{{ asset('plugins/datatables/lang/en.json') }}"
                @elseif(app()->getLocale() == "ar")
                "url": "{{ asset('plugins/datatables/lang/ar.json') }}"
                @endif
            },
            "bPaginate": false,
            "scrollX": true
        });
    });
</script>


<!-- js for open and close navbar -->
@if(app()->getLocale() == 'ar')
    <script>
        function fullWidth() {
            document.getElementById("pageSide").style.width = "250px";
            document.getElementById("topSide").style.right = "250px";
            $('.page-inner').css("paddingRight", "0");

            var element = document.getElementById("pageSide");
            element.classList.add("dropClass");

            document.getElementById("whenopenR").style.display = "none";
            document.getElementById("whencloseR").style.display = "block";
        };

        function closeFull() {
            document.getElementById("pageSide").style.width = "48px";
            document.getElementById("topSide").style.right = "48px";
            $('.page-inner').css("paddingRight", "0");

            var element = document.getElementById("pageSide");
            element.classList.remove("dropClass");

            document.getElementById("whenopenR").style.display = "block";
            document.getElementById("whencloseR").style.display = "none";
        };

        function closenf() {
            document.getElementById("nfnav").style.left = "-400px";
            document.getElementById("whenopen").style.display = "block";
            document.getElementById("whenclose").style.display = "none";
        };

        function opennf() {
            document.getElementById("nfnav").style.left = "0";
            document.getElementById("whenopen").style.display = "none";
            document.getElementById("whenclose").style.display = "block";
        };

        function closenfMM() {
            document.getElementById("nfnav").style.left = "-100%";
            document.getElementById("whenopenM").style.display = "block";
            document.getElementById("whencloseM").style.display = "none";
        };

        function opennfMM() {
            document.getElementById("nfnav").style.left = "0";
            document.getElementById("whenopenM").style.display = "none";
            document.getElementById("whencloseM").style.display = "block";
        };

        $('.close-width').click(function () {
            $("#pageSide").toggleClass("dropClass");
        });

        function opennav() {
            document.getElementById("myNav").style.width = "100%";
            document.getElementById("myNav").style.opacity = "1";
            $('.page-content').css("right", "0");
            document.getElementById("whenopenmobileR").style.display = "none";
            document.getElementById("whenclosemobileR").style.display = "block";
        };

        function closenav() {
            document.getElementById("myNav").style.width = "0%";
            document.getElementById("myNav").style.opacity = "0";
            $('.page-content').css("right", "0");
            document.getElementById("whenopenmobileR").style.display = "block";
            document.getElementById("whenclosemobileR").style.display = "none";
        };

        function opennavright() {
            document.getElementById("myNavRight").style.width = "230px";
            $('.page-content').css("right", "-230px");
        };

        function closenavright() {
            document.getElementById("myNavRight").style.width = "0%";
            $('.page-content').css("right", "0");
        };

        function youSee() {
            document.getElementById("afterSee").style.background = "#d6d6d6";
            document.getElementById("iconseeDone").style.display = "block";
        };

        function showSend() {
            $('.sendMS').css("display", "inline-block");
            $('.hideMS').css("display", "none");
        };

        function showSearch() {
            document.getElementById("messagesSearch").style.display = "block";
            document.getElementById("hidemessage").style.display = "none";
            document.getElementById("whenSS").style.display = "none";
            document.getElementById("whenHS").style.display = "block";
        };

        function hideSearch() {
            document.getElementById("messagesSearch").style.display = "none";
            document.getElementById("hidemessage").style.display = "block";
            document.getElementById("whenSS").style.display = "block";
            document.getElementById("whenHS").style.display = "none";
        };

        function gothisMessage() {
            document.getElementById("chatuser").style.display = "block";
            document.getElementById("chatclient").style.display = "none";
        };

        function backallM() {
            document.getElementById("chatuser").style.display = "none";
            document.getElementById("chatclient").style.display = "block";
        };


    </script>
@else
    <script>
        function fullWidth() {
            document.getElementById("pageSide").style.width = "250px";
            document.getElementById("topSide").style.left = "250px";
            $('.page-inner').css("paddingLeft", "250px");

            var element = document.getElementById("pageSide");
            element.classList.add("dropClass");

            document.getElementById("whenopenR").style.display = "none";
            document.getElementById("whencloseR").style.display = "block";
        };

        function closeFull() {
            document.getElementById("pageSide").style.width = "48px";
            document.getElementById("topSide").style.left = "48px";
            $('.page-inner').css("paddingLeft", "48px");

            var element = document.getElementById("pageSide");
            element.classList.remove("dropClass");

            document.getElementById("whenopenR").style.display = "block";
            document.getElementById("whencloseR").style.display = "none";
        };

        function closenf() {
            document.getElementById("nfnav").style.right = "-400px";
            document.getElementById("whenopen").style.display = "block";
            document.getElementById("whenclose").style.display = "none";
        };

        function opennf() {
            document.getElementById("nfnav").style.right = "0";
            document.getElementById("whenopen").style.display = "none";
            document.getElementById("whenclose").style.display = "block";
        };

        function closenfMM() {
            document.getElementById("nfnav").style.right = "-100%";
            document.getElementById("whenopenM").style.display = "block";
            document.getElementById("whencloseM").style.display = "none";
        };

        function opennfMM() {
            document.getElementById("nfnav").style.right = "0";
            document.getElementById("whenopenM").style.display = "none";
            document.getElementById("whencloseM").style.display = "block";
        };

        $('.close-width').click(function () {
            $("#pageSide").toggleClass("dropClass");
        });

        function opennav() {
            document.getElementById("myNav").style.width = "100%";
            document.getElementById("myNav").style.opacity = "1";
            $('.page-content').css("left", "0");
            document.getElementById("whenopenmobileR").style.display = "none";
            document.getElementById("whenclosemobileR").style.display = "block";
        };

        function closenav() {
            document.getElementById("myNav").style.width = "0%";
            document.getElementById("myNav").style.opacity = "0";
            $('.page-content').css("left", "0");
            document.getElementById("whenopenmobileR").style.display = "block";
            document.getElementById("whenclosemobileR").style.display = "none";
        };

        function opennavright() {
            document.getElementById("myNavRight").style.width = "230px";
            $('.page-content').css("right", "-230px");
        };

        function closenavright() {
            document.getElementById("myNavRight").style.width = "0%";
            $('.page-content').css("right", "0");
        };

        function youSee() {
            document.getElementById("afterSee").style.background = "#d6d6d6";
            document.getElementById("iconseeDone").style.display = "block";
        };

        function showSend() {
            $('.sendMS').css("display", "inline-block");
            $('.hideMS').css("display", "none");
        };

        function showSearch() {
            document.getElementById("messagesSearch").style.display = "block";
            document.getElementById("hidemessage").style.display = "none";
            document.getElementById("whenSS").style.display = "none";
            document.getElementById("whenHS").style.display = "block";
        };

        function hideSearch() {
            document.getElementById("messagesSearch").style.display = "none";
            document.getElementById("hidemessage").style.display = "block";
            document.getElementById("whenSS").style.display = "block";
            document.getElementById("whenHS").style.display = "none";
        };

        function gothisMessage() {
            document.getElementById("chatuser").style.display = "block";
            document.getElementById("chatclient").style.display = "none";
        };

        function backallM() {
            document.getElementById("chatuser").style.display = "none";
            document.getElementById("chatclient").style.display = "block";
        };
    </script>@endif <!-- end js navbar -->

<!-- tooltip bootstrap js -->
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>


<script>
    let chart = new frappe.Chart("#chart", { // or DOM element
        data: {
            labels: ["12am-3am", "3am-6am", "6am-9am", "9am-12pm",
                "12pm-3pm", "3pm-6pm", "6pm-9pm", "9pm-12am"],

            datasets: [
                {
                    name: "Some Data", chartType: 'bar',
                    values: [25, 40, 30, 35, 8, 52, 17, -4]
                },
                {
                    name: "Another Set", chartType: 'bar',
                    values: [25, 50, -10, 15, 18, 32, 27, 14]
                },
                {
                    name: "Yet Another", chartType: 'line',
                    values: [15, 20, -3, -15, 58, 12, -17, 37]
                }
            ],

            yMarkers: [{
                label: "Marker", value: 70,
                options: {labelPos: 'left'}
            }],
            yRegions: [{
                label: "Region", start: -10, end: 50,
                options: {labelPos: 'right'}
            }]
        },

        title: "My Awesome Chart",
        type: 'axis-mixed', // or 'bar', 'line', 'pie', 'percentage'
        height: 300,
        colors: ['purple', '#ffa3ef', 'light-blue'],

        tooltipOptions: {
            formatTooltipX: d => (d + '').toUpperCase(),
            formatTooltipY: d => d + ' pts',
        }
    });
</script>

<script type="text/javascript">
    $(function () {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });
</script>
<script>
    $(document).ready(function (e) {
        $("#viewport").click(function () {
            $("head").append("<meta name='viewport' content='width=960px, initial-scale=0.3333333333333333' data-rs='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'>");
        });
    });
</script>

<script>
    $.extend($.fn.dataTable.defaults, {
        searching: true,
        ordering: false
    });

</script>

<script>
    /* loading screen  js */
    $(window).on('load', function () {

        "use strict";

        // Loading Elements

        $(".loading-overlay .all-spi").fadeOut(1000, function () {

            // Show The Scroll

            $("body").css("overflow-y", "auto");

            $(this).parent().fadeOut(1000, function () {

                $(this).remove();
            });
        });
    });
    $('.alert').delay(5000).fadeOut('slow');

</script>

<script>

    var setCookie = function (n, val) {
        var exdays = 30;
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = n + "=" + val + "; " + expires;
    };

    var getCookie = function (n) {
        var name = n + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    };

    document.onclick = function (e) {
        if (e.target.className == 'btncolor') {
            var favColor = e.target.style.background;
            setCookie('color', favColor);
            document.getElementById("allbg").style.background = favColor;
            console.log(favColor);
        }
    };

    window.onload = function () {
        var favColor = document.body.style.background;
        var color = getCookie('color');
        if (color === '') {
            document.getElementById("allbg").style.background = favColor;
        } else {
            document.getElementById("allbg").style.background = color;
        }
    };
</script>
<script>
    function changeFont(font) {
        document.getElementById("output-text").style.fontFamily = font.value;
    }
</script>
<script>
    $(document).ready(function () {
        $("#myBtn").click(function () {
            $("#myButtons").modal({backdrop: true});
        });
        $("#myopenbg").click(function () {
            $("#mybgs").modal({backdrop: true});
        });
    });
</script>
<script>
    $(function () {
        $("#checkbox4").change(function () {
            $("#myNav").toggleClass("navbar-mainmenu-fixed-top", this.checked)
            $(".page-title").toggleClass("title-mar", this.checked)
            $(".navis-fixed").toggleClass("navis-fixed-none", this.checked)
            $(".navis-relative").toggleClass("navis-relative-block", this.checked)
        }).change();
    });

    $(function () {
        $("#loadingcheck").change(function () {
            $("#loadingg").toggleClass("loadingnone", this.checked)
            $(".navis-fixed2").toggleClass("navis-fixed-none", this.checked)
            $(".navis-relative2").toggleClass("navis-relative-block", this.checked)
        }).change();
    });
</script>
<script>
    new SlimSelect({
        select: '#single'
    });
    new SlimSelect({
        select: '#input-font'
    })
</script>
<script>
    document.querySelector("html").classList.add('js');

    var fileInput = document.querySelector(".input-file"),
        button = document.querySelector(".input-file-trigger"),
        the_return = document.querySelector(".file-return");

    button.addEventListener("keydown", function (event) {
        if (event.keyCode == 13 || event.keyCode == 32) {
            fileInput.focus();
        }
    });
    button.addEventListener("click", function (event) {
        fileInput.focus();
        return false;
    });
    fileInput.addEventListener("change", function (event) {
        the_return.innerHTML = this.value;
    });
</script>

@if(Auth::guard('customers')->check() && Request::is('admin/dashboard'))
@else
    <script>
        var color = Chart.helpers.color;

        function createConfig(legendPosition, colorName) {
            return {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    @php
                        function sum($month, $status){
                            $value1 = $value2 = $value3 = $value4 = 0;
                            foreach ($orders = App\CustomerHead::where(['org_id' => Auth::user()->org_id])->whereMonth('date', $month)->whereNotNull('cust_id')->get() as $v1){
                                foreach ($v1->transactions as $key => $v) {
                                    $v->price = $v->price * $v->quantity * $v->req_flag;
                                }
                                $statu = round(($v1->transactions->where('status', 1)->where('req_flag', -1)->sum('price') - $v1->transactions->sum('price')) - (App\PermissionReceivingPayments::where(['customer_req_id' =>  $v1->id,'customer_id' => $v1->cust_id, 'pay_flag' => 1])->sum('pay_amount') - App\PermissionReceivingPayments::where(['customer_req_id' =>  $v1->id,'customer_id' => $v1->cust_id, 'pay_flag' => -1])->sum('pay_amount')), 2);

                                if($status == 2){
                                    if($statu < 0)
                                        $value2++;
                                }
                                if($status == 1){
                                    if(abs($statu) == 0)
                                        $value1++;
                                }
                                if($status == 3){
                                    if(abs($statu) == abs($v1->transactions->sum('price')))
                                        $value3++;
                                }
                                if($status == 4){
                                    if($statu > 0){
                                        $value4++;
                                    }elseif ($statu < 0){
                                        $value4++;
                                    }elseif (abs($statu) == 0){
                                        $value4++;
                                    }elseif (abs($statu) == abs($v1->transactions->sum('price'))){
                                        $value4++;
                                    }
                                }
                            }
                            if($status == 1){
                                return $value1;
                            }
                            if($status == 2){
                                return $value2;
                            }
                            if($status == 3){
                                return $value3;
                            }
                            if($status == 4){
                                return $value4;
                            }
                        }

                    @endphp
                    datasets: [{
                        label: '@lang('strings.transactions_status_1')',
                        data: [
                            {{  abs(sum(1, 1)) }},
                            {{  abs(sum(2, 1)) }},
                            {{  abs(sum(3, 1)) }},
                            {{  abs(sum(4, 1)) }},
                            {{  abs(sum(5, 1)) }},
                            {{  abs(sum(6, 1)) }},
                            {{  abs(sum(7, 1)) }},
                            {{  abs(sum(8, 1)) }},
                            {{  abs(sum(9, 1)) }},
                            {{  abs(sum(10, 1)) }},
                            {{  abs(sum(11, 1)) }},
                            {{  abs(sum(12, 1)) }}
                        ],
                        backgroundColor: color(window.chartColors[colorName]).alpha(0.1).rgbString(),
                        borderColor: window.chartColors[colorName],
                        borderWidth: 1
                    }, {
                        label: '@lang('strings.transactions_status_2')',
                        data: [
                            {{  abs(sum(1, 2)) }},
                            {{  abs(sum(2, 2)) }},
                            {{  abs(sum(3, 2)) }},
                            {{  abs(sum(4, 2)) }},
                            {{  abs(sum(5, 2)) }},
                            {{  abs(sum(6, 2)) }},
                            {{  abs(sum(7, 2)) }},
                            {{  abs(sum(8, 2)) }},
                            {{  abs(sum(9, 2)) }},
                            {{  abs(sum(10, 2)) }},
                            {{  abs(sum(11, 2)) }},
                            {{  abs(sum(12, 2)) }}
                        ],
                        backgroundColor: color('purple').alpha(0.1).rgbString(),
                        borderColor: 'purple',
                        borderWidth: 1
                    }, {
                        label: '@lang('strings.transactions_status_3')',
                        data: [
                            {{  abs(sum(1, 3)) }},
                            {{  abs(sum(2, 3)) }},
                            {{  abs(sum(3, 3)) }},
                            {{  abs(sum(4, 3)) }},
                            {{  abs(sum(5, 3)) }},
                            {{  abs(sum(6, 3)) }},
                            {{  abs(sum(7, 3)) }},
                            {{  abs(sum(8, 3)) }},
                            {{  abs(sum(9, 3)) }},
                            {{  abs(sum(10, 3)) }},
                            {{  abs(sum(11, 3)) }},
                            {{  abs(sum(12, 3)) }}
                        ],
                        backgroundColor: color('red').alpha(0.1).rgbString(),
                        borderColor: 'red',
                        borderWidth: 1
                    }, {
                        label: '@lang('strings.transactions_status_4')',
                        data: [
                            {{  abs(sum(1, 4) - sum(1, 3) - sum(1, 2) - sum(1, 1)) }},
                            {{  abs(sum(2, 4) - sum(2, 3) - sum(2, 2) - sum(2, 1)) }},
                            {{  abs(sum(3, 4) - sum(3, 3) - sum(3, 2) - sum(3, 1)) }},
                            {{  abs(sum(4, 4) - sum(4, 3) - sum(4, 2) - sum(4, 1)) }},
                            {{  abs(sum(5, 4) - sum(5, 3) - sum(5, 2) - sum(5, 1)) }},
                            {{  abs(sum(6, 4) - sum(6, 3) - sum(6, 2) - sum(6, 1)) }},
                            {{  abs(sum(7, 4) - sum(7, 3) - sum(7, 2) - sum(7, 1)) }},
                            {{  abs(sum(8, 4) - sum(8, 3) - sum(8, 2) - sum(8, 1)) }},
                            {{  abs(sum(9, 4) - sum(9, 3) - sum(9, 2) - sum(9, 1)) }},
                            {{  abs(sum(10, 4) - sum(10, 3) - sum(10, 2) - sum(10, 1)) }},
                            {{  abs(sum(11, 4) - sum(11, 3) - sum(11, 2) - sum(11, 1)) }},
                            {{  abs(sum(12, 4) - sum(12, 3) - sum(12, 2) - sum(12, 1)) }}
                        ],
                        backgroundColor: color('orange').alpha(0.1).rgbString(),
                        borderColor: 'orange',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    legend: {
                        position: legendPosition,
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: false,
                                labelString: 'Month'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: false,
                                labelString: 'Value'
                            }
                        }]
                    },
                    title: {
                        display: false,
                        text: 'Legend Position: ' + legendPosition
                    }
                }
            };
        }

        window.onload = function () {
            [{
                id: 'chart-legend-top',
                legendPosition: 'bottom',
                color: 'green'
            }].forEach(function (details) {
                new Chart(document.getElementById(details.id).getContext('2d'), createConfig(details.legendPosition, details.color));
            });
        };
    </script>
@endif

</body>
</html>

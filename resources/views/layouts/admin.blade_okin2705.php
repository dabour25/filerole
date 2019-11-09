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
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Droid+Sans" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link href="{{ asset('plugins/pace-master/themes/blue/pace-theme-flash.css') }}" rel="stylesheet"/>
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/fontawesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/line-icons/simple-line-icons.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/waves/waves.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.css"/>

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

<body class="page-header-fixed  pace-done small-sidebar" id="output-text">
<div class="overlay"></div>

    <div class="loading-overlay text-center">
      <div class="all-spi">
        <div class="spinner">
          <div class="dot1"></div>
          <div class="dot2"></div>
        </div>
      </div>
    </div> 

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
                                    <li class="langN"><a  href="{{ url('lang/ar') }}">{{ __('strings.Arabic') }}</a></li>
                                    <li><a href="{{ url('lang/en') }}">{{ __('strings.English') }}</a></li>
                                @else
                                    <li><a  href="{{ url('lang/ar') }}">{{ __('strings.Arabic') }}</a></li>
                                    <li class="langN"><a href="{{ url('lang/en') }}">{{ __('strings.English') }}</a></li>
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
                    هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا يوجد محتوى نصي" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص، وإذا قمت بإدخال "lorem ipsum" في أي محرك بحث ستظهر العديد من المواقع الحديثة العهد في نتائج البحث. على مدى السنين ظهرت نسخ جديدة ومختلفة من نص لوريم إيبسوم، أحياناً عن طريق الصدفة، وأحياناً عن عمد كإدخال بعض العبارات الفكاهية إليها.
                </div>

                <div class="send-message">
                    <form>
                        <p class="sendMS">:رد علي الرسالة</p>
                        <textarea placeholder="الرد علي الرسالة" class="sendMS"></textarea>
                        <button type="button" class="btn sendMS" data-dismiss="modal" >إرسال</button>
                        <button type="button" class="btn hideMS" onclick="showSend()">رد</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

        @if(Auth::guard('customers')->check())
        
        @else
        
            <!-- notification -->
                <div class="notification" id="nfnav">
                    <div class="title-nf">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation">
                                <a href="#message-clients" aria-controls="profile" role="tab" data-toggle="tab">رسائل العملاء</a>
                            </li>
                            <li role="presentation" class="active">
                                <a href="#message-users" aria-controls="home" role="tab" data-toggle="tab">رسائل المستخدمين</a>
                            </li>
                        </ul>
                    </div>
                    <div class="nf-content">
        
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane" id="message-clients">
        
                                <!-- time date for notification -->
                                <div class="time-d">
                                    <p class="time-date-nf datenf-1"> <i class="fas fa-calendar"></i> 23/4/2019 </p>
                                    <p class="time-date-nf datenf-2"> <i class="fas fa-clock"></i> 3:22 </p>
                                </div>
                                <div class="trach">
                                    <a href="#" onclick="showSearch()" id="whenSS">
                                        <i class="fas fa-trash-restore"></i>
                                    </a>
                                    <a href="#" onclick="hideSearch()" id="whenHS">
                                        <i class="fas fa-arrow-circle-left"></i>
                                    </a>
                                </div>
        
                                <!-- messages -->
                                <div class="messages" id="messagesSearch">
        
                                    <form>
                                        <input type="text" placeholder="بحث">
                                    </form>
        
                                    <a href="#" type="button" data-toggle="modal">
                                        <div class="item-messages" id="afterSee">
                                            <h3>منتج بحث
                                                <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
                                                <p class="time-messages"> <i class="fas fa-clock"></i> 18:00 </p>
                                            </h3>
                                            <p class="sub-messages">عنوان الرسالة</p>
                                            <p class="desk-messages">المحتوي الخاصة بالرسالة المرسلة من قبل العميل...</p>
                                        </div>
                                    </a>
        
                                    <a href="#" type="button" data-toggle="modal">
                                        <div class="item-messages" id="afterSee">
                                            <h3>منتج بحث
                                                <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
                                                <p class="time-messages"> <i class="fas fa-clock"></i> 18:00 </p>
                                            </h3>
                                            <p class="sub-messages">عنوان الرسالة</p>
                                            <p class="desk-messages">المحتوي الخاصة بالرسالة المرسلة من قبل العميل...</p>
                                        </div>
                                    </a>
        
                                    <a href="#" type="button" data-toggle="modal">
                                        <div class="item-messages" id="afterSee">
                                            <h3>منتج بحث
                                                <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
                                                <p class="time-messages"> <i class="fas fa-clock"></i> 18:00 </p>
                                            </h3>
                                            <p class="sub-messages">عنوان الرسالة</p>
                                            <p class="desk-messages">المحتوي الخاصة بالرسالة المرسلة من قبل العميل...</p>
                                        </div>
                                    </a>
        
                                    <a href="#" type="button" data-toggle="modal">
                                        <div class="item-messages" id="afterSee">
                                            <h3>منتج بحث
                                                <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
                                                <p class="time-messages"> <i class="fas fa-clock"></i> 18:00 </p>
                                            </h3>
                                            <p class="sub-messages">عنوان الرسالة</p>
                                            <p class="desk-messages">المحتوي الخاصة بالرسالة المرسلة من قبل العميل...</p>
                                        </div>
                                    </a>
        
                                </div>
        
                                <!-- messages -->
                                <div class="messages" id="hidemessage">
        
                                    <a href="#" type="button" data-toggle="modal" data-target="#myModaNFF" onclick="youSee()">
                                        <div class="item-messages" id="afterSee">
                                            <h3>الاسم
                                                <p class="time-messages"> <i class="fas fa-clock"></i> 18:00 </p>
                                            </h3>
                                            <p class="sub-messages">عنوان الرسالة</p>
                                            <p class="desk-messages">المحتوي الخاصة بالرسالة المرسلة من قبل العميل...</p>
                                        </div>
                                    </a>
        
                                    <a href="#">
                                        <div class="item-messages">
                                            <h3>الاسم
                                                <p class="time-messages"> <i class="fas fa-clock"></i> 18:00 </p>
                                            </h3>
                                            <p class="sub-messages">عنوان الرسالة</p>
                                            <p class="desk-messages">المحتوي الخاصة بالرسالة المرسلة من قبل العميل...</p>
                                        </div>
                                    </a>
        
                                </div>
                            </div>
        
                            <!-- users messages section -->
                            <div role="tabpanel" class="tab-pane active" id="message-users">
                                <!-- time date for notification -->
                                <div class="time-d">
                                    <p class="time-date-nf datenf-1"> <i class="fas fa-calendar"></i> 23/4/2019 </p>
                                    <p class="time-date-nf datenf-2"> <i class="fas fa-clock"></i> 3:22 </p>
                                </div>
        
                                <div class="usermessage" id="chatclient">
        
                                    <a href="#" onclick="gothisMessage()">
                                        <div class="item-user">
                                            <i class="fas fa-user"></i>
                                            <h3>إسم الشخص</h3>
                                            <p>مرحباً بك أود أن أخبرك أنني قادم...</p>
                                        </div>
                                    </a>
        
                                    <a>
                                        <div class="item-user">
                                            <i class="fas fa-user"></i>
                                            <h3>إسم المستخدم</h3>
                                            <p>مرحباً بك أود أن أخبرك أنني قادم...</p>
                                        </div>
                                    </a>
        
                                    <a>
                                        <div class="item-user">
                                            <i class="fas fa-user"></i>
                                            <h3>إسم الشخص</h3>
                                            <p>مرحباً بك أود أن أخبرك أنني قادم...</p>
                                        </div>
                                    </a>
        
                                </div>
        
                                <div class="upuserCH">
                                    <div class="chat-nf" id="chatuser">
                                        <!-- fixed title -->
                                        <div class="fixed-chat">
                                            <h3> <i class="fas fa-users"></i> إسم المستخدم</h3>
        
                                            <a onclick="backallM()">
                                                <i class="fas fa-arrow-left"></i>
                                            </a>
                                        </div>
        
                                        <!-- all messages -->
                                        <div class="all-messages">
        
                                            <div class="userCH">
                                                <i class="fas fa-user"></i>
                                                <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي</p>
                                            </div>
        
                                            <div class="meCH">
                                                <i class="far fa-user"></i>
                                                <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي</p>
                                            </div>
                                            <div class="userCH">
                                                <i class="fas fa-user"></i>
                                                <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي</p>
                                            </div>
        
                                            <div class="meCH">
                                                <i class="far fa-user"></i>
                                                <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي</p>
                                            </div>
                                            <div class="userCH">
                                                <i class="fas fa-user"></i>
                                                <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي</p>
                                            </div>
        
                                            <div class="meCH">
                                                <i class="far fa-user"></i>
                                                <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي</p>
                                            </div>
                                        </div>
        
        
                                        <div class="sendchat">
                                            <form>
                                                <textarea placeholder="نص الرسالة"></textarea>
                                                <i class="fas fa-arrow-circle-left"></i>
                                            </form>
                                        </div>
                                    </div>
                                </div>
        
                            </div>
                        </div>
        
                    </div>
                </div>
        
        @endif

        <!-- navbar -->
        <div class="navbar-mainmenu navbar-mainmenu-fixed-top rtl overlay" id="myNav">
          <div class="navbar-mainmenu-inner ">
            
            <div class="nav-collapse collapse accordion-body" id="collapse-navbar">
              <ul class="nav">
                  
                    @if(Auth::guard('customers')->check())
                        <li class="dropdown">
                          <a href="{{ route('home') }}" tabindex="-1" class="brand">
                            <img src="https://invoice.fr3on.info/assets/img/logo-light.png" alt="SMART INVOICE SYSTEM" height="100%">
                            <span></span>
                          </a>
                        </li>
                        <li class="dropdown">
                            <a href="{{ route('home') }}" tabindex="-1">
                              <span><i class="fa fa-home"></i>{{ __('strings.Home') }}</span>
                            </a>
                          </li>
                     @else
                        <li class="dropdown">
                          <a href="{{ url('admin/dashboard') }}" tabindex="-1" class="brand">
                            <img src="https://invoice.fr3on.info/assets/img/logo-light.png" alt="SMART INVOICE SYSTEM" height="100%">
                            <span></span>
                          </a>
                        </li>
                        <li class="dropdown">
                            <a href="{{ url('admin/dashboard') }}" tabindex="-1">
                              <span><i class="fa fa-home"></i>{{ __('strings.Home') }}</span>
                            </a>
                          </li>
                            @if(permissions('users') == true || permissions('Kpi') == true || permissions('roles') == true || permissions('functions') == true || permissions('sections') == true)
                              <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                       @if(app()->getLocale() == 'ar')
                                          <span><i class="fas fa-users"></i> المستخدمين </span>
                                        @else
                                          <span><i class="fas fa-users"></i> Users </span>
                                        @endif
                                  </a>
                                  <ul class="dropdown-menu">
                                    @if(permissions('users') == true)
                                        <li class="{{ Request::is('admin/users') || Request::is('admin/users/*') ? 'active' : '' }}">
                                            <a href="{{ route('users.index') }}">{{ __('strings.Users') }}</a></li> @endif
                                    @if(permissions('available') == true)
                                        <li class="{{ Request::is('admin/available') || Request::is('admin/available/*') ? 'active' : '' }}">
                                            <a href="{{ route('available.index') }}">{{ __('strings.Available') }}</a>
                                        </li> 
                                      @endif
                                      <li class="divider"></li>
                                    @if(permissions('roles') == true)
                                        <li class="{{ Request::is('admin/roles') || Request::is('admin/roles/*') ? 'active' : '' }}">
                                            <a href="{{ route('roles.index') }}">{{ __('strings.Roles') }}</a>
                                      </li> 
                                      @endif
                                    @if(permissions('functions') == true)
                                        <li class="{{ Request::is('admin/functions') || Request::is('admin/functions/*') ? 'active' : '' }}">
                                            <a href="{{ route('functions.index') }}"> {{ __('strings.Functions') }}</a>
                                        </li> 
                                      @endif
                                    @if(permissions('sections') == true)
                                        <li class="{{ Request::is('admin/sections') || Request::is('admin/sections/*') ? 'active' : '' }}">
                                             <a href="{{ route('sections.index') }}">{{ __('strings.Sections') }}</a>
                                        </li>
                                     @endif  
                                      <li class="divider"></li>
                                      <li>
                                        <a href="{{ route('users.create') }}" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                          <i class="fa fa-user-plus"></i>
                                          <span>إنشاء مستخدم</span>
                                        </a>
                                      </li>
                                  </ul>
                              </li>
                             @endif 
                          
                              @if(permissions('kpi') == true)
                              <li class="dropdown">
                                <a href="#" class="dropdown-toggle {{ Request::is('admin/kpi') || Request::is('admin/kpi/rules') || Request::is('admin/kpi/average/list') || Request::is('admin/kpi/average-reports') ? 'active open' : '' }}" data-toggle="dropdown" tabindex="-1">
                                  <span><i class="fas fa-star-half-alt"></i> {{ __('strings.Kpi') }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    @if(permissions('kpi') == true)
                                        <li class="{{ Request::is('admin/kpi') ? 'active' : '' }}">
                                            <a href="{{ route('kpi.index') }}">{{ __('strings.Kpitypes') }}</a>
                                        </li>
                                    @endif
                                    @if(permissions('kpi') == true)
                                        <li class="{{ Request::is('admin/kpi/average/list') ? 'active' : '' }}">
                                            <a href="{{ url('admin/kpi/average/list') }}">{{ __('strings.Average_value') }}</a>
                                        </li>
                                    @endif
                                    @if(permissions('kpi') == true)
                                        <li class="{{ Request::is('admin/kpi/average-reports') ? 'active' : '' }}">
                                            <a href="{{ url('admin/kpi/average-reports') }}">{{ __('strings.kpi_average_reports') }}</a>
                                        </li>
                                    @endif
                                    @if(permissions('kpi') == true)
                                        <li class="{{ Request::is('admin/kpi/rules') ? 'active' : '' }}">
                                            <a href="{{ url('admin/kpi/rules') }}">{{ __('strings.kpirules') }}</a>
                                        </li>
                                    @endif  
                                    <li class="divider"></li>
                                    @if(permissions('kpi') == true)
                                        <li class="{{ Request::is('admin/kpi/list') ? 'active' : '' }}">
                                            <a href="{{ url('admin/kpi/list') }}">{{ __('strings.kpi_list') }}</a></li>
                                    @endif
                                    @if(permissions('kpi') == true)
                                        <li class="{{ Request::is('admin/kpi/reports') ? 'active' : '' }}">
                                            <a href="{{ url('admin/kpi/reports') }}">{{ __('strings.kpi_reports') }}</a>
                                        </li>
                                    @endif  
                                    <li class="divider"></li>
                                    @if(permissions('kpi') == true)
                                        <li class="{{ Request::is('admin/kpi/assign') ? 'active' : '' }}">
                                            <a href="{{ url('admin/kpi/assign') }}"><i class="fa fa-plus"></i> {{ __('strings.Kpitypes_assign') }}</a>
                                        </li>
                                    @endif
                                </ul>
                              </li>
                            @endif
            
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                              <i class="fa fa-file-text"></i> البنود
                            </a>
                            <ul class="dropdown-menu">
                                
                            @if(permissions('price_list') == true || permissions('offers') == true ||  permissions('categories_type') == true || permissions('categories') == true)
        
                              @if(permissions('categories_type') == true)
                                    <li class="{{ Request::is('admin/categories_type') ? 'active' : '' }}"><a
                                                href="{{ route('categories_type.index') }}">{{ __('strings.Categories_type') }} </a>
                                    </li> 
                                @endif
                                @if(permissions('categories') == true)
                                    <li class="{{ Request::is('admin/categories') ? 'active' : '' }}"><a
                                                href="{{ route('categories.index') }}">{{ __('strings.Categories') }}</a>
                                    </li> @endif
        
                                @if(permissions('price_list') == true)
                                    <li class="{{ Request::is('admin/price_list') || Request::is('admin/price_list/*') ? 'active' : '' }}">
                                        <a href="{{ route('price_list.index') }}">{{ __('strings.Price_list') }}</a>
                                    </li> @endif
                                @if(permissions('offers') == true)
                                    <li class="{{ Request::is('admin/offers')  || Request::is('admin/offers/*') ? 'active' : '' }}">
                                        <a href="{{ route('offers.index') }}">{{ __('strings.Offers') }}</a>
                                </li> 
                            @endif   
        
                                <li class="divider"></li>
                              @if(permissions('categories_type') == true)
                                    <li class="{{ Request::is('admin/categories_type/create') ? 'active' : '' }}">
                                        <a href="{{ route('categories_type.create') }}"><i class="fa fa-plus"></i> إضافة بند </a>
                                    </li> 
                                @endif
                            @endif
                            </ul>
                          </li>
                          
                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                              <i class="fa fa-truck"></i>  الموردين
                            </a>
                            <ul class="dropdown-menu">
                                
                             @if(permissions('stores') == true || permissions('locators') == true || permissions('suppliers') == true || permissions('supplier-invoice') == true)
                                
                                
                                @if(permissions('suppliers') == true)
                                    <li class="{{ Request::is('admin/suppliers') ? 'active' : '' }}"><a
                                                href="{{ route('suppliers.index') }}">{{ __('strings.Suppliers') }}</a>
                                    </li> 
                                @endif
                                @if(permissions('supplier-invoice') == true)
                                    <li class="{{ Request::is('admin/suppliers/invoices') ? 'active' : '' }}"><a
                                                href="{{ url('admin/suppliers/invoices') }}">{{ __('strings.Invoices') }} </a>
                                    </li> @endif
                                <li class="{{ Request::is('admin/suppliers/damaged') ? 'active' : '' }}"><a
                                            href="{{ url('admin/suppliers/damaged') }}"> {{ __('strings.Damaged') }} </a>
                                </li>
                                @if(permissions('stores') == true)
                                    <li class="{{ Request::is('admin/stores')  || Request::is('admin/stores/*') ? 'active' : '' }}">
                                        <a href="{{ route('stores.index') }}">{{ __('strings.Stores') }}</a></li> @endif
                                @if(permissions('locators') == true)
                                    <li class="{{ Request::is('admin/locators')  || Request::is('admin/locators/*') ? 'active' : '' }}">
                                        <a href="{{ route('locators.index') }}">{{ __('strings.Locators') }}</a>
                                    </li>
                                @endif 
                                
                                <li class="divider"></li>
                                    @if(permissions('suppliers') == true)
                                    <li class="{{ Request::is('admin/suppliers') ? 'active' : '' }}">
                                        <a href="{{ route('suppliers.create') }}"><i class="fa fa-plus"></i> إضافة مورد</a>
                                    </li> 
                                @endif
                                
                            @endif  
                           
                            </ul>
                          </li>
                                   
                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                              <i class="fa fa-tags"></i>  العمﻻء
                            </a>
                            <ul class="dropdown-menu">
                            @if(permissions('transactions') == true || permissions('customers') == true)    
                            
                            @if(permissions('customers') == true)
                                <li class="{{ Request::is('admin/customers') ? 'active' : '' }}"><a
                                            href="{{ route('customers.index') }}">{{ __('strings.Customers') }}</a>
                                </li> 
                             @endif
                            @if(permissions('transactions') == true)
                                <li class="{{ Request::is('admin/transactions')  || Request::is('admin/transactions/*') ? 'active' : '' }}">
                                    <a href="{{ route('transactions.index') }}">{{ __('strings.Transactions') }}</a>
                                </li> 
                              @endif  
                                 <li class="divider"></li>
                            @if(permissions('customers') == true)
                                <li class="{{ Request::is('admin/customers') ? 'active' : '' }}">
                                    <a href="{{ route('customers.create') }}"><i class="fa fa-plus"></i> إضافة عميل</a>
                                </li> 
                             @endif
                            @endif  
                           
                            </ul>
                          </li>
                          
                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle {{ Request::is('admin/reports') || Request::is('admin/reports/*') || Request::is('admin/purchases/supplier/total') || Request::is('admin/purchases/supplier/detailed')? 'active open' : '' }}" data-toggle="dropdown" tabindex="-1">
                              <i class="fa fa-line-chart"></i> تقارير
                            </a>
                            <ul class="dropdown-menu">
                           @if(permissions('Reports') == true)
                                <!-- Ghada -->
                                    <li class="{{ Request::is('admin/reports') ? 'active' : '' }}">
                                        <a href="{{url('admin/reports') }}">{{ __('strings.report1') }}</a>
                                    </li>
        
                                    <li class="{{ Request::is('admin/reports') ? 'active' : '' }}">
                                        <a href="{{url('admin/reportsUsers') }}">{{ __('strings.report2') }}</a>
                                    </li>
        
                                    <!-- Ghada-->
                                    <li class="{{ Request::is('admin/reportscash') ? 'active' : '' }}">
                                        <a href="{{url('admin/reportscash') }}">{{ __('strings.report5') }}</a>
                                    </li>
                                    <li class="{{ Request::is('admin/reportscashbank') ? 'active' : '' }}">
                                        <a href="{{url('admin/reportscashbank') }}">{{ __('strings.report6') }}</a>
                                    </li>
                            @endif  
                            <li class="divider"></li>
                            @if(permissions('Reports') == true)
                                <!-- Ahmed  -->
                                    <li class="{{ Request::is('admin/purchases/supplier/total') || Request::is('admin/purchases/supplier/detailed') ? 'active' : '' }}">
                                        <a href="{{url('admin/purchases/supplier/total') }}">{{ __('strings.report3') }}</a>
                                    </li>
        
                                    <li class="{{ Request::is('admin/purchases/employee/total') || Request::is('admin/purchases/employee/detailed') ? 'active' : '' }}">
                                        <a href="{{url('admin/purchases/employee/total') }}">{{ __('strings.report4') }}</a>
                                    </li>
        
                                    <li class="{{ Request::is('admin/stores/report')  ? 'active' : '' }}">
                                        <a href="{{url('admin/stores/report') }}">{{ __('strings.stores_report_title') }}</a>
                                    </li>
        
                                    <li class="{{ Request::is('admin/stores/value-report')  ? 'active' : '' }}">
                                        <a href="{{url('admin/stores/value-report') }}">{{ __('strings.stores_value_report_title') }}</a>
                                    </li>
                                @endif
                           
                            </ul>
                          </li>
                          
                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle {{ Request::is('admin/measures') || Request::is('admin/measures/*') || Request::is('admin/suppliers/invoices') || Request::is('admin/suppliers/invoices/*') ? 'active open' : '' }}" data-toggle="dropdown" tabindex="-1">
                              <i class="fa fa-cut"></i> المشغل
                            </a>
                            <ul class="dropdown-menu">
                                @if(permissions('measures') == true || permissions('terms') == true)
                                @if(permissions('terms') == true)
                                    <li class="{{ Request::is('admin/measures/terms') ? 'active' : '' }}"><a
                                                href="{{ route('measures.terms') }}">{{ __('strings.Terms') }}</a>
                                    </li> @endif
                                @if(permissions('measures') == true)
                                    <li class="{{ Request::is('admin/measures') ? 'active' : '' }}"><a
                                                href="{{ route('measures.index') }}">{{ __('strings.Measures_2') }}</a>
                                    </li> @endif
                                @if(permissions('measures-assign') == true)
                                    <li class="{{ Request::is('admin/measures/assign') ? 'active' : '' }}"><a
                                                href="{{ route('measures.assign') }}">{{ __('strings.Assign') }}</a>
                                    </li> @endif
                                    @endif
                            </ul>
                          </li>
                          
                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle {{ Request::is('admin/news') || Request::is('admin/news/*') ? 'active open' : '' }}" data-toggle="dropdown" tabindex="-1">
                              <i class="fa fa-tasks"></i> أدوات
                            </a>
                            <ul class="dropdown-menu">
                                @if(permissions('News') == true)
                                    <li class="{{ Request::is('admin/news') ? 'active' : '' }}">
                                        <a href="{{url('admin/news') }}">{{ __('strings.News') }}</a>
                                    </li>
                                    <li class="{{ Request::is('admin/orgs') ? 'active' : '' }}">
                                        <a href="{{url('admin/orgs') }}">{{ __('strings.Orgs') }}</a>
                                    </li>
                                @endif
                            <li class="divider"></li>
                                @if(permissions('Attendance') == true)
                                <li class="{{ Request::is('admin/attendance')  ? 'active' : '' }}">
                                    <a href="{{url('admin/attendance') }}">{{ __('strings.attendance_add') }}</a>
                                </li>
                                <li class="{{ Request::is('admin/attendance')  ? 'active' : '' }}">
                                    <a href="{{url('admin/attendance/list') }}">{{ __('strings.attendance_title') }}</a>
                                </li>
                            @endif
                            @if(permissions('weekly_vacations') == true || permissions('yearly_vacations') == true)
                                <li class="{{ Request::is('admin/weekly_vacations')  || Request::is('admin/yearly_vacations') ? 'active' : '' }}">
                                    <a href="{{ route('weekly_vacations.index') }}">{{ __('strings.Vacations') }}</a>
                                </li> 
                                @endif
                                <li class="divider"></li>
                                @if(permissions('Reservations') == true)
                                    <li class="{{ Request::is('admin/reservations') ? 'active' : '' }}">
                                        <a href="{{url('admin/reservations') }}">{{ __('strings.all_reservations') }}</a>
                                    </li>
        
                                    <li class="{{ Request::is('admin/reservations/create') ? 'active' : '' }}">
                                        <a href="{{url('admin/reservations/create') }}">
                                            <i class="fa fa-plus"></i>
                                            {{ __('strings.reservation_add') }}
                                        </a>
                                    </li>
                                @endif  
                           
                            </ul>
                          </li>
                          
                          @if(permissions('pay mangment') == true)
                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle {{ Request::is('admin/pay mangment') || Request::is('admin/pay mangment/*') ? 'active open' : '' }}" data-toggle="dropdown" tabindex="-1">
                              <span class="menu-icon icon-basket"></span>  المرتبات
                            </a>
                            <ul class="dropdown-menu">
                              @if(permissions('pay mangment') == true)
                                    <li class="{{ Request::is('admin/pay_types') ? 'active' : '' }}">
                                        <a href="{{url('admin/pay_types') }}">{{ __('strings.pay_mange') }}</a>
                                    </li>
                                    <li class="{{ Request::is('admin/employee_pay_types') ? 'active' : '' }}">
                                        <a href="{{url('admin/employee_pay_types') }}">{{ __('strings.add_emp_pay_type') }}</a>
                                    </li>
        
                                    <li class="{{ Request::is('admin/loan_emp') ? 'active' : '' }}">
                                        <a href="{{url('admin/loan_emp') }}">{{ __('strings.Loans') }}</a>
                                    </li>
        
        
                                    <!--    Hosam 7-apr-2019 -->
        
                                    <li class="{{ Request::is('admin/calculate_salary') ? 'active' : '' }}">
                                        <a href="{{url('admin/calculate_salary') }}">{{ __('strings.calculate_salary') }}</a>
        
                                    </li>
                                    <li class="{{ Request::is('admin/salary_report') ? 'active' : '' }}">
                                        <a href="{{url('admin/salary_report') }}">{{ __('strings.salary_report') }}</a>
                                    </li>
                                    <!--    Hosam -->
        
                                @endif
        
                            </ul>
                          </li>
                            @endif
                          
                          
                          @if(permissions('settings') == true)
                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle {{ Request::is('admin/settings') || Request::is('admin/settings/*') ? 'active open' : '' }}" data-toggle="dropdown" tabindex="-1">
                              <i class="fa fa-gear"></i> {{ __('strings.Settings') }}
                            </a>
                             
                             <ul class="dropdown-menu" style="left: inherit; right: 0px;">
                                @if(permissions('settings') == true)
                                    <li class="{{ Request::is('admin/settings') || Request::is('admin/settings/*') ? 'active' : '' }}">
                                        <a href="{{ route('settings.index') }}"> أعدادات الإستخدام</a>
                                    </li> 
                                @endif
                                @if(permissions('settings') == true)
                                <li class="{{ Request::is('admin/settings') || Request::is('admin/settings/*') ? 'active' : '' }}">
                                      <a href="{{ route('settings.index') }}">إعدادات القالب</a>
                                </li>
                                @endif
                                 <li class="divider"></li>
                                <li>
                                    <a href="#" tabindex="-1">
                                      <span>البريد الإلكتروني</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" tabindex="-1">
                                      <span>الضرائب</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" tabindex="-1">
                                      <span>إعدادات رافع</span>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                  <a href="#" tabindex="-1">
                                  <span>الدفع عبر الإنترنت</span>
                                </a>
                                </li>
                                 
                               <li class="divider"></li>
                                 
                                <li>
                                    <a href="#" sis-modal="" class="sis_modal" tabindex="-1">
                                      <span>استيراد البيانات</span>
                                    </a>
                                 </li>
                                <li>
                                    <a href="#" tabindex="-1">
                                      <span>النسخ الاحتياطي</span>
                                    </a>
                                 </li>
                            </ul>
        
                          </li>
                          @endif
                          
                          <!-- date -->
                          <li class="dropdown right">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                              <span><i class="fa fa-info-circle"></i></span>
                            </a>
                            <ul class="dropdown-menu drop-left">
                              <li><p class="time-date">{{ date('Y-m-d h:i:s') }}</p></li>
                            </ul>
                          </li>
        
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
                              
                              @if(Auth::guard('customers')->check())
                             
                              <li>
                                <a href="{{ route('changePassword') }}" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                  <i class="fa fa-shield"></i> <span>{{ __('strings.Change_Password') }}</span>
                                </a>
                              </li>
                              
                              <li>
                                <a href="{{ url('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                  <i class="fa fa-lock"></i> <span>{{ __('strings.Logout') }}</span>
                                </a>
                              </li>
                              <form id="logout-form" action="{{ url('logout') }}" method="POST"
                                    style="display: none;">
                                  @csrf
                              </form>
                              @else
                              <li>
                                <a href="{{ route('users.edit', Auth::user()->id) }}" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                  <i class="fa fa-user"></i> <span>الملف الشخصي</span>
                                </a>
                              </li>
                              <li>
                                <a href="{{ route('changePassword') }}" sis-modal="users_table" class="sis_modal" tabindex="-1">
                                  <i class="fa fa-shield"></i> <span>{{ __('strings.Change_Password') }}</span>
                                </a>
                              </li>
                              
                              <li>
                                <a href="{{ url('admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
                              <img src="https://invoice.fr3on.info/assets/img/flags/arabic.png" class="img-flag">&nbsp;
                            @else
                              <img src="https://invoice.fr3on.info/assets/img/flags/english.png" class="img-flag">&nbsp;
                            @endif
                            <span class="hidden-lg-up">{{ __('strings.Languages') }}</span>
                          </a>
                          <ul class="dropdown-menu">
                              <li>
                                <a href="{{ url('lang/en') }}" tabindex="-1">
                                <img src="https://invoice.fr3on.info/assets/img/flags/english.png" class="img-flag"> {{ __('strings.English') }}
                                </a>
                              </li>
                              <li>
                                  <a href="{{ url('lang/ar') }}" tabindex="-1">
                                    <img src="https://invoice.fr3on.info/assets/img/flags/arabic.png" class="img-flag"> {{ __('strings.Arabic') }}
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
                                {{--<div class="sidebar-header">--}}
                                {{--<div class="sidebar-profile">--}}
                                {{--@if(Auth::guard('customers')->check())--}}
                                {{--<a href="{{ route('users.edit', Auth::guard('customers')->user()->id) }}">--}}
                                {{--<div class="sidebar-profile-image">--}}
                                {{--<img src="{{ Auth::guard('customers')->user()->photo ? asset(Auth::guard('customers')->user()->photo->file) : asset('images/profile-placeholder.png') }}"--}}
                                {{--class="img-circle img-responsive"--}}
                                {{--alt="{{ Auth::guard('customers')->user()->name }} {{ Auth::guard('customers')->user()->name }}">--}}
                                {{--</div>--}}
                                {{--</a>--}}
                                {{--@else--}}
                                {{--<a href="{{ route('users.edit', Auth::user()->id) }}">--}}
                                {{--<div class="sidebar-profile-image">--}}
                                {{--<img src="{{ Auth::user()->photo ? asset(Auth::user()->photo->file) : asset('images/profile-placeholder.png') }}"--}}
                                {{--class="img-circle img-responsive"--}}
                                {{--alt="{{ Auth::user()->name }} {{ Auth::user()->name }}">--}}
                                {{--</div>--}}
                                {{--<div class="sidebar-profile-details">--}}
                                {{--<span>{{ Auth::user()->name }}<br><small>{{ ucfirst(Auth::user()->role->name) }}</small></span>--}}
                                {{--</div>--}}
                                {{--</a>--}}
                                {{--@endif--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                <ul class="menu accordion-menu">
                                    


                                        @if(Auth::guard('customers')->check())
                                        <div class="dropdown">
                                          <a class="btn btn-secondary dropdown-toggle" href="{{ route('home') }}" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <span class="menu-icon icon-home"></span> {{ __('strings.Home') }}
                                          </a>
                                        </div>
                                        @else
                                        <div class="dropdown">
                                          <a class="btn btn-secondary dropdown-toggle" href="{{ url('admin/dashboard') }}" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <span class="menu-icon icon-home"></span> {{ __('strings.Home') }}
                                          </a>
                                        </div>
                                        @endif
                                    


                                    @if(Auth::guard('customers')->check())

                                    @else
                                        @if(permissions('users') == true || permissions('Kpi') == true || permissions('roles') == true || permissions('functions') == true || permissions('sections') == true)
                                        <div class="dropdown">
                                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                               <i class="fas fa-users"></i> {{ __('strings.Users_list') }}
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @if(permissions('users') == true)
                                                        <li class="{{ Request::is('admin/users') || Request::is('admin/users/*') ? 'active' : '' }}">
                                                            <a href="{{ route('users.index') }}">{{ __('strings.Users') }}</a></li> @endif
                                                    @if(permissions('available') == true)
                                                        <li class="{{ Request::is('admin/available') || Request::is('admin/available/*') ? 'active' : '' }}">
                                                            <a href="{{ route('available.index') }}">{{ __('strings.Available') }}</a>
                                                        </li> @endif
                                                    @if(permissions('roles') == true)
                                                        <li class="{{ Request::is('admin/roles') || Request::is('admin/roles/*') ? 'active' : '' }}">
                                                            <a href="{{ route('roles.index') }}">{{ __('strings.Roles') }}</a></li> @endif
                                                    @if(permissions('functions') == true)
                                                        <li class="{{ Request::is('admin/functions') || Request::is('admin/functions/*') ? 'active' : '' }}">
                                                            <a href="{{ route('functions.index') }}"> {{ __('strings.Functions') }}</a>
                                                        </li> @endif
                                                    @if(permissions('sections') == true)
                                                        <li class="{{ Request::is('admin/sections') || Request::is('admin/sections/*') ? 'active' : '' }}">
                                                            <a href="{{ route('sections.index') }}">{{ __('strings.Sections') }}</a>
                                                        </li>
                                                    @endif                                          
                                            </div>
                                        </div>
                                        @endif

                                        @if(permissions('kpi') == true)
                                        <div class="dropdown">
                                          <button class="btn btn-secondary dropdown-toggle {{ Request::is('admin/kpi') || Request::is('admin/kpi/rules') || Request::is('admin/kpi/average/list') || Request::is('admin/kpi/average-reports') ? 'active open' : '' }}" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <i class="fas fa-star-half-alt"></i> {{ __('strings.Kpi_settings') }}
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @if(permissions('kpi') == true)
                                                        <li class="{{ Request::is('admin/kpi') ? 'active' : '' }}">
                                                            <a href="{{ route('kpi.index') }}">{{ __('strings.Kpitypes') }}</a>
                                                        </li>
                                                    @endif
                                                    @if(permissions('kpi') == true)
                                                        <li class="{{ Request::is('admin/kpi/average/list') ? 'active' : '' }}">
                                                            <a href="{{ url('admin/kpi/average/list') }}">{{ __('strings.Average_value') }}</a>
                                                        </li>
                                                    @endif
                                                    @if(permissions('kpi') == true)
                                                        <li class="{{ Request::is('admin/kpi/average-reports') ? 'active' : '' }}">
                                                            <a href="{{ url('admin/kpi/average-reports') }}">{{ __('strings.kpi_average_reports') }}</a>
                                                        </li>
                                                    @endif
                                                    @if(permissions('kpi') == true)
                                                        <li class="{{ Request::is('admin/kpi/rules') ? 'active' : '' }}">
                                                            <a href="{{ url('admin/kpi/rules') }}">{{ __('strings.kpirules') }}</a>
                                                        </li>
                                                    @endif                                         
                                            </div>
                                        </div>
                                        @endif
                                    
                                        @if(permissions('kpi') == true)
                                    
                                        <div class="dropdown">
                                          <button class="btn btn-secondary dropdown-toggle {{ Request::is('admin/kpi') || Request::is('admin/kpi/rules') || Request::is('admin/kpi/average/list') || Request::is('admin/kpi/average-reports') ? 'active open' : '' }}" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <i class="fas fa-star-half-alt"></i> {{ __('strings.Kpi') }}
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                  @if(permissions('kpi') == true)
                                                        <li class="{{ Request::is('admin/kpi/assign') ? 'active' : '' }}">
                                                            <a href="{{ url('admin/kpi/assign') }}">{{ __('strings.Kpitypes_assign') }}</a>
                                                        </li>
                                                    @endif
                                                    @if(permissions('kpi') == true)
                                                        <li class="{{ Request::is('admin/kpi/list') ? 'active' : '' }}">
                                                            <a href="{{ url('admin/kpi/list') }}">{{ __('strings.kpi_list') }}</a></li>
                                                    @endif
                                                    @if(permissions('kpi') == true)
                                                        <li class="{{ Request::is('admin/kpi/reports') ? 'active' : '' }}">
                                                            <a href="{{ url('admin/kpi/reports') }}">{{ __('strings.kpi_reports') }}</a>
                                                        </li>
                                                    @endif                                        
                                            </div>
                                        </div>
                                        @endif
                                    
                                        {{--@foreach(App\Functions::where('technical_name', '')->get() as $value)--}}
                                        {{--<li class="droplink {{ Request::is('admin/customers') || Request::is('admin/customers/*') ? 'active open' : '' }}">--}}
                                        {{--<a class="waves-effect waves-button">--}}
                                        {{--<span class="menu-icon {{ $value->icon }}"></span>--}}
                                        {{--<p>{{ $value->name }}</p>--}}
                                        {{--<span class="arrow"></span>--}}
                                        {{--</a>--}}

                                        {{--<ul class="sub-menu" style="display: none;">--}}
                                        {{--@foreach(App\Functions::where('parent_id', $value->id)->get() as $value2)--}}
                                        {{--@if(permissions($value2->technical_name) == true)--}}
                                        {{--<li class="{{ Request::is('admin/'.$value2->technical_name) ? 'active' : '' }}">--}}
                                        {{--@if($value2->technical_name == 'suppliers/invoices' || $value2->technical_name == 'suppliers/damaged' || $value2->technical_name == 'news')--}}
                                        {{--<a href="{{ url('admin/'.$value2->technical_name) }}">{{ $value2->name }}</a>--}}
                                        {{--@else--}}
                                        {{--<a href="{{ route($value2->technical_name . '.index') }}">{{ $value2->name }}</a>--}}
                                        {{--@endif--}}
                                        {{--</li>--}}
                                        {{--@endif--}}
                                        {{--@endforeach--}}
                                        {{--</ul>--}}

                                        {{--</li>--}}
                                        {{--@endforeach--}}

                                        @if(permissions('price_list') == true || permissions('offers') == true ||  permissions('categories_type') == true || permissions('categories') == true)
                                    
                                        <div class="dropdown">
                                          <button class="btn btn-secondary dropdown-toggle {{ Request::is('admin/kpi') || Request::is('admin/kpi/rules') || Request::is('admin/kpi/average/list') || Request::is('admin/kpi/average-reports') ? 'active open' : '' }}" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <span class="menu-icon icon-briefcase"></span> {{ __('strings.Categories_list') }}
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @if(permissions('categories_type') == true)
                                                        <li class="{{ Request::is('admin/categories_type') ? 'active' : '' }}"><a
                                                                    href="{{ route('categories_type.index') }}">{{ __('strings.Categories_type') }} </a>
                                                        </li> @endif
                                                    @if(permissions('categories') == true)
                                                        <li class="{{ Request::is('admin/categories') ? 'active' : '' }}"><a
                                                                    href="{{ route('categories.index') }}">{{ __('strings.Categories') }}</a>
                                                        </li> @endif

                                                    @if(permissions('price_list') == true)
                                                        <li class="{{ Request::is('admin/price_list') || Request::is('admin/price_list/*') ? 'active' : '' }}">
                                                            <a href="{{ route('price_list.index') }}">{{ __('strings.Price_list') }}</a>
                                                        </li> @endif
                                                    @if(permissions('offers') == true)
                                                        <li class="{{ Request::is('admin/offers')  || Request::is('admin/offers/*') ? 'active' : '' }}">
                                                            <a href="{{ route('offers.index') }}">{{ __('strings.Offers') }}</a></li> 
                                              @endif                                      
                                            </div>
                                        </div>
                                        @endif

                                        @if(permissions('transactions') == true || permissions('customers') == true)
                                            <div class="dropdown">
                                          <button class="btn btn-secondary dropdown-toggle {{ Request::is('admin/transactions')  || Request::is('admin/transactions/*') || Request::is('admin/customers') || Request::is('admin/customers/*')? 'active open' : '' }}" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <span class="menu-icon icon-calculator"></span> {{ __('strings.Sales') }}
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @if(permissions('customers') == true)
                                                        <li class="{{ Request::is('admin/customers') ? 'active' : '' }}"><a
                                                                    href="{{ route('customers.index') }}">{{ __('strings.Customers') }}</a>
                                                        </li> @endif
                                                    @if(permissions('transactions') == true)
                                                        <li class="{{ Request::is('admin/transactions')  || Request::is('admin/transactions/*') ? 'active' : '' }}">
                                                            <a href="{{ route('transactions.index') }}">{{ __('strings.Transactions') }}</a>
                                                        </li> 
                                              @endif                                     
                                            </div>
                                        </div>
                                        @endif


                                        <div class="dropdown">
                                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <span class="menu-icon icon-calculator"></span> المزيد
                                          </button>
                                            
                                            
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                              
                                      @if(permissions('stores') == true || permissions('locators') == true || permissions('suppliers') == true || permissions('supplier-invoice') == true)
                                              
                                            <div class="dropdown">
                                          <button class="btn btn-secondary dropdown-toggle {{ Request::is('admin/suppliers') || Request::is('admin/suppliers/*') || Request::is('admin/suppliers/invoices') || Request::is('admin/suppliers/invoices/*') || Request::is('admin/stores') || Request::is('admin/stores/*') || Request::is('admin/locators') || Request::is('admin/locators/*')? 'active open' : '' }}" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <span class="menu-icon icon-basket"></span> {{ __('strings.Purchases') }}
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @if(permissions('suppliers') == true)
                                                        <li class="{{ Request::is('admin/suppliers') ? 'active' : '' }}"><a
                                                                    href="{{ route('suppliers.index') }}">{{ __('strings.Suppliers') }}</a>
                                                        </li> @endif
                                                    @if(permissions('supplier-invoice') == true)
                                                        <li class="{{ Request::is('admin/suppliers/invoices') ? 'active' : '' }}"><a
                                                                    href="{{ url('admin/suppliers/invoices') }}">{{ __('strings.Invoices') }} </a>
                                                        </li> @endif
                                                    <li class="{{ Request::is('admin/suppliers/damaged') ? 'active' : '' }}"><a
                                                                href="{{ url('admin/suppliers/damaged') }}"> {{ __('strings.Damaged') }} </a>
                                                    </li>
                                                    @if(permissions('stores') == true)
                                                        <li class="{{ Request::is('admin/stores')  || Request::is('admin/stores/*') ? 'active' : '' }}">
                                                            <a href="{{ route('stores.index') }}">{{ __('strings.Stores') }}</a></li> @endif
                                                    @if(permissions('locators') == true)
                                                        <li class="{{ Request::is('admin/locators')  || Request::is('admin/locators/*') ? 'active' : '' }}">
                                                            <a href="{{ route('locators.index') }}">{{ __('strings.Locators') }}</a>
                                                        </li>
                                              @endif                                        
                                            </div>
                                        </div>
                                        @endif
                                                    
                                                    <!-- Esraa Change   11-feb-2019 -->
                                        @if(permissions('Reservations') == true)
                                            <div class="dropdown">
                                          <button class="btn btn-secondary dropdown-toggle {{ Request::is('admin/reservation') || Request::is('admin/reservation/*') ? 'active open' : '' }}" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <i class="fas fa-address-card"></i> {{ __('strings.reservation') }}
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @if(permissions('Reservations') == true)
                                                        <li class="{{ Request::is('admin/reservations') ? 'active' : '' }}">
                                                            <a href="{{url('admin/reservations') }}">{{ __('strings.all_reservations') }}</a>
                                                        </li>

                                                        <li class="{{ Request::is('admin/reservations/create') ? 'active' : '' }}">
                                                            <a href="{{url('admin/reservations/create') }}">{{ __('strings.reservation_add') }}</a>
                                                        </li>

                                                    @endif                                      
                                            </div>
                                        </div>
                                        @endif

                                    <!-- Esraa Change   26-feb-2019 -->
                                        @if(permissions('Reports') == true)
                                            <li class="droplink {{ Request::is('admin/reports') || Request::is('admin/reports/*') || Request::is('admin/purchases/supplier/total') || Request::is('admin/purchases/supplier/detailed')? 'active open' : '' }}">
                                                <a class="waves-effect waves-button">
                                                    <span class="menu-icon"><i class="fas fa-file-medical-alt"></i></span>
                                                    <p>{{ __('strings.reportsb') }} </p>
                                                    <span class="arrow"></span>
                                                </a>
                                                <ul class="sub-menu" style="display: none;">
                                                @if(permissions('Reports') == true)
                                                    <!-- Ghada -->
                                                        <li class="{{ Request::is('admin/reports') ? 'active' : '' }}">
                                                            <a href="{{url('admin/reports') }}">{{ __('strings.report1') }}</a>
                                                        </li>

                                                        <li class="{{ Request::is('admin/reports') ? 'active' : '' }}">
                                                            <a href="{{url('admin/reportsUsers') }}">{{ __('strings.report2') }}</a>
                                                        </li>

                                                        <!-- Ghada-->
                                                        <li class="{{ Request::is('admin/reportscash') ? 'active' : '' }}">
                                                            <a href="{{url('admin/reportscash') }}">{{ __('strings.report5') }}</a>
                                                        </li>
                                                        <li class="{{ Request::is('admin/reportscashbank') ? 'active' : '' }}">
                                                            <a href="{{url('admin/reportscashbank') }}">{{ __('strings.report6') }}</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </li>
                                        @endif

                                        @if(permissions('Reports') == true)
                                            <li class="droplink {{ Request::is('admin/reports') || Request::is('admin/reports/*') || Request::is('admin/purchases/supplier/total') || Request::is('admin/purchases/supplier/detailed')? 'active open' : '' }}">
                                                <a class="waves-effect waves-button">
                                                    <span class="menu-icon"><i class="fas fa-money-check"></i></span>
                                                    <p>{{ __('strings.reportss') }} </p>
                                                    <span class="arrow"></span>
                                                </a>
                                                <ul class="sub-menu" style="display: none;">
                                                @if(permissions('Reports') == true)
                                                    <!-- Ahmed  -->
                                                        <li class="{{ Request::is('admin/purchases/supplier/total') || Request::is('admin/purchases/supplier/detailed') ? 'active' : '' }}">
                                                            <a href="{{url('admin/purchases/supplier/total') }}">{{ __('strings.report3') }}</a>
                                                        </li>

                                                        <li class="{{ Request::is('admin/purchases/employee/total') || Request::is('admin/purchases/employee/detailed') ? 'active' : '' }}">
                                                            <a href="{{url('admin/purchases/employee/total') }}">{{ __('strings.report4') }}</a>
                                                        </li>

                                                        <li class="{{ Request::is('admin/stores/report')  ? 'active' : '' }}">
                                                            <a href="{{url('admin/stores/report') }}">{{ __('strings.stores_report_title') }}</a>
                                                        </li>

                                                        <li class="{{ Request::is('admin/stores/value-report')  ? 'active' : '' }}">
                                                            <a href="{{url('admin/stores/value-report') }}">{{ __('strings.stores_value_report_title') }}</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </li>
                                        @endif


                                        @if(permissions('News') == true)
                                            <li class="droplink {{ Request::is('admin/news') || Request::is('admin/news/*') ? 'active open' : '' }}">
                                                <a class="waves-effect waves-button">
                                                    <span class="menu-icon"><i class="fas fa-tablet-alt"></i></span>
                                                    <p>{{ __('strings.News_list') }} </p>
                                                    <span class="arrow"></span>
                                                </a>
                                                <ul class="sub-menu" style="display: none;">
                                                    @if(permissions('News') == true)
                                                        <li class="{{ Request::is('admin/news') ? 'active' : '' }}">
                                                            <a href="{{url('admin/news') }}">{{ __('strings.News') }}</a>
                                                        </li>
                                                        <li class="{{ Request::is('admin/orgs') ? 'active' : '' }}">
                                                            <a href="{{url('admin/orgs') }}">{{ __('strings.Orgs') }}</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </li>
                                        @endif

                                    <!-- Ghada  for Payroll Management  -->
                                    <!--@if(permissions('pay mangment') == true)
                                        <li class="droplink {{ Request::is('admin/pay mangment') || Request::is('admin/pay mangment/*') ? 'active open' : '' }}">
                                                <a href="{{url('admin/pay_types') }}">{{ __('strings.pay_mange') }}
                                                <span class="menu-icon fa fa-desktop"></span>

                                                <span class="arrow"></span>
                                            </a>
                                        </li>
                    @endif -->
                                        <!--    Ghada   26-March-2019 -->
                                        @if(permissions('pay mangment') == true)
                                            <li class="droplink {{ Request::is('admin/pay mangment') || Request::is('admin/pay mangment/*') ? 'active open' : '' }}">
                                                <a class="waves-effect waves-button">
                                                    <span class="menu-icon"><i class="fas fa-money-bill-alt"></i></span>
                                                    <p> {{ __('strings.pay_mange') }} </p>
                                                    <span class="arrow"></span>
                                                </a>
                                                <ul class="sub-menu" style="display: none;">
                                                    @if(permissions('pay mangment') == true)
                                                        <li class="{{ Request::is('admin/pay_types') ? 'active' : '' }}">
                                                            <a href="{{url('admin/pay_types') }}">{{ __('strings.pay_mange') }}</a>
                                                        </li>
                                                        <li class="{{ Request::is('admin/employee_pay_types') ? 'active' : '' }}">
                                                            <a href="{{url('admin/employee_pay_types') }}">{{ __('strings.add_emp_pay_type') }}</a>
                                                        </li>

                                                        <li class="{{ Request::is('admin/loan_emp') ? 'active' : '' }}">
                                                            <a href="{{url('admin/loan_emp') }}">{{ __('strings.Loans') }}</a>
                                                        </li>


                                                        <!--    Hosam 7-apr-2019 -->

                                                        <li class="{{ Request::is('admin/calculate_salary') ? 'active' : '' }}">
                                                            <a href="{{url('admin/calculate_salary') }}">{{ __('strings.calculate_salary') }}</a>

                                                        </li>
                                                        <li class="{{ Request::is('admin/salary_report') ? 'active' : '' }}">
                                                            <a href="{{url('admin/salary_report') }}">{{ __('strings.salary_report') }}</a>
                                                        </li>
                                                        <!--    Hosam -->

                                                    @endif
                                                </ul>
                                            </li>
                                        @endif


                                        @if(permissions('Attendance') == true || permissions('weekly_vacations') == true || permissions('yearly_vacations') == true)
                                            <li class="droplink {{ Request::is('admin/weekly_vacations')  || Request::is('admin/yearly_vacations') || Request::is('admin/attendance') || Request::is('admin/attendance/*') || Request::is('admin/attendance/list')? 'active open' : '' }}">
                                                <a class="waves-effect waves-button">
                                                    <span class="menu-icon"><i class="fas fa-book"></i></span>
                                                    <p>{{ __('strings.attendance_title') }} </p>
                                                    <span class="arrow"></span>
                                                </a>
                                                <ul class="sub-menu" style="display: none;">
                                                    @if(permissions('Attendance') == true)
                                                        <li class="{{ Request::is('admin/attendance')  ? 'active' : '' }}">
                                                            <a href="{{url('admin/attendance') }}">{{ __('strings.attendance_add') }}</a>
                                                        </li>
                                                        <li class="{{ Request::is('admin/attendance')  ? 'active' : '' }}">
                                                            <a href="{{url('admin/attendance/list') }}">{{ __('strings.attendance_title') }}</a>
                                                        </li>
                                                    @endif
                                                    @if(permissions('weekly_vacations') == true || permissions('yearly_vacations') == true)
                                                        <li class="{{ Request::is('admin/weekly_vacations')  || Request::is('admin/yearly_vacations') ? 'active' : '' }}">
                                                            <a href="{{ route('weekly_vacations.index') }}">{{ __('strings.Vacations') }}</a>
                                                        </li> @endif
                                                </ul>
                                            </li>
                                        @endif


                                        @if(permissions('measures') == true || permissions('terms') == true)
                                            <li class="droplink {{ Request::is('admin/measures') || Request::is('admin/measures/*') || Request::is('admin/suppliers/invoices') || Request::is('admin/suppliers/invoices/*') ? 'active open' : '' }}">
                                                <a class="waves-effect waves-button">
                                                    <span class="menu-icon icon-crop"></span>
                                                    <p>{{ __('strings.Measures') }}</p>
                                                    <span class="arrow"></span>
                                                </a>
                                                <ul class="sub-menu" style="display: none;">
                                                    @if(permissions('terms') == true)
                                                        <li class="{{ Request::is('admin/measures/terms') ? 'active' : '' }}"><a
                                                                    href="{{ route('measures.terms') }}">{{ __('strings.Terms') }}</a>
                                                        </li> @endif
                                                    @if(permissions('measures') == true)
                                                        <li class="{{ Request::is('admin/measures') ? 'active' : '' }}"><a
                                                                    href="{{ route('measures.index') }}">{{ __('strings.Measures_2') }}</a>
                                                        </li> @endif
                                                    @if(permissions('measures-assign') == true)
                                                        <li class="{{ Request::is('admin/measures/assign') ? 'active' : '' }}"><a
                                                                    href="{{ route('measures.assign') }}">{{ __('strings.Assign') }}</a>
                                                        </li> @endif

                                                </ul>
                                            </li>
                                        @endif

                                        @if(permissions('settings') == true)
                                            <li class="droplink {{ Request::is('admin/settings') || Request::is('admin/settings/*') ? 'active open' : '' }}">
                                                <a class="waves-effect waves-button">
                                                    <span class="menu-icon icon-settings"></span>
                                                    <p>{{ __('strings.Settings') }}</p>

                                                    <span class="arrow"></span>
                                                </a>
                                                <ul class="sub-menu" style="display: none;">
                                                    @if(permissions('settings') == true)
                                                        <li class="{{ Request::is('admin/settings') || Request::is('admin/settings/*') ? 'active' : '' }}">
                                                            <a href="{{ route('settings.index') }}">{{ __('strings.Settings') }}</a>
                                                        </li> @endif

                                                </ul>
                                            </li>
                                        @endif
                                        <!-- end of admin menu -->                                    
                                            </div>
                                        </div>
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


    <div class="page-inner" style="min-height:100% !important" @if(Request::is('admin/dashboard'))  id="allbg" @else id="allbg" @endif>

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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.js"></script>
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
            $('.page-inner').css("paddingRight","0");

            var element = document.getElementById("pageSide");
            element.classList.add("dropClass");

            document.getElementById("whenopenR").style.display = "none";
            document.getElementById("whencloseR").style.display = "block";
        };
        function closeFull() {
            document.getElementById("pageSide").style.width = "48px";
            document.getElementById("topSide").style.right = "48px";
            $('.page-inner').css("paddingRight","0");

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

        $('.close-width').click( function() {
            $("#pageSide").toggleClass("dropClass");
        } );

        function opennav() {
            document.getElementById("myNav").style.width = "100%";
            document.getElementById("myNav").style.opacity = "1";
            $('.page-content').css("right","0");
            document.getElementById("whenopenmobileR").style.display = "none";
            document.getElementById("whenclosemobileR").style.display = "block";
        };

        function closenav() {
            document.getElementById("myNav").style.width = "0%";
            document.getElementById("myNav").style.opacity = "0";
            $('.page-content').css("right","0");
            document.getElementById("whenopenmobileR").style.display = "block";
            document.getElementById("whenclosemobileR").style.display = "none";
        } ;

        function opennavright() {
            document.getElementById("myNavRight").style.width = "230px";
            $('.page-content').css("right","-230px");
        };

        function closenavright() {
            document.getElementById("myNavRight").style.width = "0%";
            $('.page-content').css("right","0");
        } ;

        function youSee() {
            document.getElementById("afterSee").style.background = "#d6d6d6";
            document.getElementById("iconseeDone").style.display = "block";
        };

        function showSend() {
            $('.sendMS').css("display","inline-block");
            $('.hideMS').css("display","none");
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
            $('.page-inner').css("paddingLeft","250px");

            var element = document.getElementById("pageSide");
            element.classList.add("dropClass");

            document.getElementById("whenopenR").style.display = "none";
            document.getElementById("whencloseR").style.display = "block";
        };
        function closeFull() {
            document.getElementById("pageSide").style.width = "48px";
            document.getElementById("topSide").style.left = "48px";
            $('.page-inner').css("paddingLeft","48px");

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

        $('.close-width').click( function() {
            $("#pageSide").toggleClass("dropClass");
        } );

        function opennav() {
            document.getElementById("myNav").style.width = "100%";
            document.getElementById("myNav").style.opacity = "1";
            $('.page-content').css("left","0");
            document.getElementById("whenopenmobileR").style.display = "none";
            document.getElementById("whenclosemobileR").style.display = "block";
        };

        function closenav() {
            document.getElementById("myNav").style.width = "0%";
            document.getElementById("myNav").style.opacity = "0";
            $('.page-content').css("left","0");
            document.getElementById("whenopenmobileR").style.display = "block";
            document.getElementById("whenclosemobileR").style.display = "none";
        } ;

        function opennavright() {
            document.getElementById("myNavRight").style.width = "230px";
            $('.page-content').css("right","-230px");
        };

        function closenavright() {
            document.getElementById("myNavRight").style.width = "0%";
            $('.page-content').css("right","0");
        } ;

        function youSee() {
            document.getElementById("afterSee").style.background = "#d6d6d6";
            document.getElementById("iconseeDone").style.display = "block";
        };

        function showSend() {
            $('.sendMS').css("display","inline-block");
            $('.hideMS').css("display","none");
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
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>


<script>
    let chart = new frappe.Chart( "#chart", { // or DOM element
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

            yMarkers: [{ label: "Marker", value: 70,
                options: { labelPos: 'left' }}],
            yRegions: [{ label: "Region", start: -10, end: 50,
                options: { labelPos: 'right' }}]
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
    $(function() {

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
    $.extend( $.fn.dataTable.defaults, {
        searching: true,
        ordering:  false
    } );

</script>
    
<script>
    /* loading screen  js */
      $(window).on('load', function(){

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
    function changeFont(font){
        document.getElementById("output-text").style.fontFamily = font.value;
    }
</script>

</body>
</html>
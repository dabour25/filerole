<!--
Author: FileRole
Author URL: http://filerole.com
-->

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>FileRole</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8"/>
    <meta name="keywords" content="filerole, programs, startup"/>
    <link rel="icon" href="{{ asset('favicon.png') }}">

    <!-- Bootstrap if AR -->
    @if(app()->getLocale()=="ar")
        <link rel="stylesheet" href=" {{asset('css/bootstrap-rtl.min.css')}}">
    @else
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
              integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
              crossorigin="anonymous">
    @endif


<!-- Bootstrap if EN
    <link rel="stylesheet" href="css/bootstrap.css"> -->

    <!-- Web Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- font if ar -->
    <link href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700,900" rel="stylesheet">

    <!-- font if en
	<link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=devanagari,latin-ext"
	 rel="stylesheet">-->

    <!-- Style-CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

    <link href="http://master.filerolesys.com/backend/LTR/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="http://master.filerolesys.com/backend/LTR/css/layout.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/steps.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/css/fileinput.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/css/intlTelInput.css">

    @if(app()->getLocale()=="ar")
        <link rel="stylesheet" href="{{ asset('css/style2.css')}}" type="text/css" media="all"/>
    @else
        <link rel="stylesheet" href="{{ asset('css/style2_en.css')}}" type="text/css" media="all"/>
@endif

<!-- js head -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
</head>

<body>

<!-- back to top button -->
<a id="back2Top" title="Back to top" href="#"><i class="fas fa-arrow-circle-up"></i></a>

<!-- loading screen -->
<div class="loading-overlay text-center">
    <div class="all-spi" style="opacity: 0.928763;">
        <div class="spinner">
            <img class="loadinglogo" src="images/loading.png">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
</div>

{{-- <!-- navbar mobile for setting -->
<div id="navSet" class="overlay visible-xs">
    <div class="overlay-content">
        <ul>
            <li><a href="login.html" class="active">دخول</a></li>
            <li><a href="register.html"> إنشاء حساب</a></li>
        </ul>

    </div>
</div>

<!-- navbar mobile for menu -->
<div id="navMenu" class="overlay visible-xs">
    <div class="overlay-content">
        <ul>
            <li><a href="index.html" class="active">الرئيسية</a></li>
            <li><a href="Advantages.html"> المميزات</a></li>
            <li><a href="program.html">البرامج </a></li>
            <li><a href="program.html">الأنشطة </a></li>
            <li><a href="contact.html">تواصل معنا</a></li>
            <li><a href="about.html">عن فايل رول</a></li>
        </ul>
    </div>

</div> --}}

<!-- main banner -->
<div class="main-top" id="home">
    <!-- header -->
    <header id="myHeader">
        <div class="overflow-logo"></div>
        {{-- <div class="container">

            <!-- header mobile -->
            <div class="header-mobile visible-xs">
                <div class="container">
                    <div class="row">
                        <div class="col-4">
                            <a onclick="openNav()" id="whenOnav">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            </a>
                            <a onclick="CloseNav()" id="whenCnav">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                        <div class="col-4">
                            <div id="logo">
                                <h1><a href="index.html"><img src="images/filerole.png"></a></h1>
                            </div>
                        </div>
                        <div class="col-4">
                            <a onclick="openSet()" id="whenO">
                                <i class="fas fa-cog"></i>
                            </a>
                            <a onclick="CloseSet()" id="whenC">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- start header desktop -->
            <div class="header d-lg-flex justify-content-between align-items-center hidden-xs">
                <!-- logo -->
                <div id="logo">
                    <h1><a href="index.html"><img src="images/filerole.png"> <img class="logo2" src="images/logo2.png"> </a></h1>
                </div>
                <!-- //logo -->
                <!-- nav -->
                <div class="nav_w3ls">
                    <nav>
                        <input type="checkbox" id="drop" />
                        <ul class="menu">
                            <li><a href="index.html" class="active">الرئيسية</a></li>
                            <li><a href="Advantages.html"><i class="fas fa-badge-check"></i> المميزات</a></li>
                            <li>
                                <!-- First Tier Drop Down -->
                                <label for="drop-2" class="toggle toogle-2">البرامج <span class="fa fa-angle-down" aria-hidden="true"></span>
                                </label>
                                <a href="program.html">البرامج <span class="fa fa-angle-down" aria-hidden="true"></span></a>
                                <input type="checkbox" id="drop-2" />
                                <ul>
                                    <li><a href="program.html" class="drop-text">برنامج الحسابات</a></li>
                                    <li><a href="program.html" class="drop-text">برنامج المبيعات</a></li>
                                    <li><a href="program.html" class="drop-text">برنامج الصالونات</a></li>
                                    <li><a href="program.html" class="drop-text">برنامج المخازن</a></li>
                                    <li><a href="program.html" class="drop-text">برنامج إدارة الأعمال</a></li>
                                </ul>
                            </li>
                            <li>
                                <!-- First Tier Drop Down -->
                                <label for="drop-2" class="toggle toogle-2">الأنشطة <span class="fa fa-angle-down" aria-hidden="true"></span>
                                </label>
                                <a href="#">الأنشطة <span class="fa fa-angle-down" aria-hidden="true"></span></a>
                                <input type="checkbox" id="drop-2" />
                                <ul>
                                    <li><a href="program.html" class="drop-text">إدارة صالونات التجميل</a></li>
                                    <li><a href="program.html" class="drop-text">إدارة مبيعات السيارات</a></li>
                                    <li><a href="program.html" class="drop-text">إدارة الجيم</a></li>
                                    <li><a href="program.html" class="drop-text">إدارة المستشفيات</a></li>
                                    <li><a href="program.html" class="drop-text">إدارة المحلات</a></li>
                                    <li><a href="program.html" class="drop-text">إدارة صالونات التجميل</a></li>
                                    <li><a href="program.html" class="drop-text">إدارة محلات البيع</a></li>
                                    <li><a href="program.html" class="drop-text">إدارة ورش التصنيع</a></li>
                                </ul>
                            </li>
                            <li><a href="contact.html">تواصل معنا</a></li>
                            <li><a href="about.html">عن فايل رول</a></li>
                            <li>
                                <!-- First Tier Drop Down -->
                                <label for="drop-2" class="toggle toogle-2">المزيد <span class="fa fa-angle-down" aria-hidden="true"></span>
                                </label>
                                <a href="#">المزيد <span class="fa fa-angle-down" aria-hidden="true"></span></a>
                                <input type="checkbox" id="drop-2" />
                                <ul>
                                    <li><a href="#services" class="drop-text">خطط الأسعار</a></li>
                                    <li><a href="#partners" class="drop-text">شركاء النجاح</a></li>
                                    <li><a href="#partners" class="drop-text">نماذج الفواتير </a></li>
                                    <li><a href="#partners" class="drop-text">برنامج الربح والشراكة </a></li>
                                    <li><a href="#partners" class="drop-text">عملائنا </a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- //nav -->
                <div class="d-flex mt-lg-1 mt-sm-2 mt-3 justify-content-center">
                    <!-- login, register -->
                    <div class="login-reg mr-3">
                        <a href="login.html" class="btn btn-login"><i class="fas fa-arrow-circle-right"></i> دخول </a>
                        <a href="register.html" class="btn btn-register"><i class="fa fa-user-circle"></i> إنشاء حساب </a>
                    </div>
                    <!-- //login, register -->
                </div>
            </div> <!-- // end header desktop -->

        </div> --}}
    </header>
</div>
<!-- //header -->

<!-- all title -->
<div class="advantages advantages-info">
    <div class="overflowadv"></div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>{{__('strings.complete')}}<span>{{__('strings.complete_account_information')}}</span></h1>
                <p>{{__('strings.help_us_complete')}}</p>
            </div>
        </div>
    </div>
</div>
<!-- // all title -->

<!-- message welcome -->
<div class="welcome-message" id="messageWelcome">
    <div class="container">
        <div class="message-in" id="itemMessage">
            <div class="logo-message"><img src="{{ asset('images/shape-8.png') }}"></div>

            <div class="content-message">
                <span></span>

                <h1>{{ __('strings.thanks_for_register') }}</h1>
                <p>{{ __('strings.save_link_for_access') }}<br></p>
                <p>{{ __('strings.save_link_for_access_1') }}<br></p>
                <a href="#" class="message-link">http://{{$owner_url}}</a>
                <a href="#" class="con-message"
                   onclick="closeMessage()">{{__('strings.continue_compelte_register')}}</a>
            </div>
        </div>
    </div>
</div>

<!-- // message welcome -->


<!-- information page -->
<div class="register">
    <div class="container">
        <form id="example-form" action="{{url('admin/register/first_setting')}}" method="post"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <div>
                <h3>{{__('strings.account_information')}}</h3>
                <section>
                    <div class="row">
                        {{-- <div class="col-md-4 col-xs-12">
                            <label>الإسم بالكامل<em>*</em></label>
                            <input type="text" name="name" required>
                        </div> --}}
                        <div class="col-md-4 col-xs-12">
                            <label>{{__('strings.address')}}</label>
                            <input type="text" name="address" placeholder="">
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <label>{{__('strings.country')}}<em>*</em></label>
                            <select required name="country_id" class="select-search">
                                @foreach($countries as $country)
                                    @php
                                        $country_session = Session::has('country')  ? session('country') : 'EG';
                                    @endphp
                                    <option {{ $country_session == $country->code || old('country_id') == $country->id ? 'selected' : ''}} value="{{$country->id}}">{{ app()->getLocale() == 'ar' ? $country->name  : $country->name_en  }}</option>
                                    {{-- <option value="{{$user->id}}">{{ app()->getLocale() == 'ar' ? $user->name  : $user->name_en  }}</option> --}}
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <label>{{__('strings.city')}}<em>*</em></label>
                            <input type="text" placeholder="" required name="govornarate" value="{{ Session::has('city')  ? session('city') : 'EG' }}">
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <label>{{__('strings.mobile')}}<em>*</em></label>
                            <input id="phone" name="mobile" type="tel">
                            <span id="valid-msg" class="hide">✓ Valid</span>
                            <span id="error-msg" class="hide"></span>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <label>{{__('strings.language')}}<em>*</em></label>
                            <select required name="disp_language">
                                <option value="ar">{{__('ar')}}</option>
                                <option value="en">{{('en')}}</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <label>{{__('strings.commercial_record')}}<em class="opt">({{__('strings.optional')}})</em></label>
                            <input type="text" placeholder="" name="busines_resgister">
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <label>{{__('strings.tax_card')}}<em class="opt">({{__('strings.optional')}})</em></label>
                            <input type="text" placeholder="" name="tax_card">
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <label> {{__('strings.logo')}} <em class="opt">({{__('strings.optional')}})</em></label>
                            <input  type="file" class="file-loading" name="image_id" onchange="readURL(this);">
                        </div>
                        <div class="col-md-4 col-xs-12">
                             <img id="blah" src="#" alt="your image" />
                        </div>
                    </div>
                    <p class="reguierd">{{__('strings.required_fields')}}</p>
                </section>
                <h3>{{__('strings.activity_type')}}</h3>
                <section>
                    <div class="type-work">

                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="title-work">
                                    <h1>{{__('strings.choose_activity')}}</h1>
                                    <p>{{__('strings.helpus_choose_activity')}}</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="search-work">
                                    <input type="text" placeholder="بحث ...">
                                </div>
                            </div>
                        </div>

                        <div class="work-items row" id="selectable">

                            @foreach($activities as $activity)

                                <div class="col-md-3 col-xs-12" id="activity{{$activity->id2}}">
                                    <input name="activity_id" type="hidden" value="{{ $activity->id}}"
                                           id="activity-{{$activity->id}}">
                                    <div class="item-w ui-widget-content" onclick="scrollup()">
                                        @if($activity->activity_image!=null)
                                            <img src="http://master.filerolesys.com/images/{{\App\Images::findOrFail($activity->activity_image)->file}}"
                                                 class="rounded-circle" width="45" height="45" alt="">
                                        @endif
                                        <h3 id="activity_name1">{{app()->getLocale()=="ar"?$activity->name:$activity->name_en}}</h3>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>
                </section>
                <h3>تأكيد النشاط </h3>
                <section>
                    <div class="type-work tyoe-after">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="title-work">
                                    <h1>
                                        <div id="activity_name"></div>{{__('strings.sure_from_activity')}}</h1>
                                    <p>{{__('strings.activity_message_note')}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="work-items row" id="selcted_activity">
                            {{-- <div class="col-md-3 col-xs-12">
                                <div class="item-w item-w-after">
                                    <i class="fas fa-store-alt"></i>
                                    <h3>المحﻻت والمتاجر</h3>
                                </div> --}}
                        </div>

                        <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"
                               onclick="scrolldowncheck()"> <label
                                for="acceptTerms">{{__('strings.yes_sure_activity')}}</label>
                    </div>
            </div>
            </section>

    </div>
    </form>
</div>
</div>
<!-- // information page -->


<!-- js files -->
<script src="https://code.jquery.com/jquery-3.4.0.min.js"
        integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
        crossorigin="anonymous"></script>
<script src="http://master.filerolesys.com/backend/global_assets/js/demo_pages/form_select2.js"></script>
<script src="http://master.filerolesys.com/backend/global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/jquery.steps.min.js') }}"></script>
<script src="{{ asset('js/wow.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/main2.js') }}"></script>
<script src="{{url('')}}/js/prism.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/intlTelInput.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/js/fileinput.min.js"></script>
<script>
$(document).on('ready', function() {
    $("#input-26").fileinput({showCaption: false, dropZoneEnabled: false});
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

<script>
    $(function () {
        $("#selectable").selectable({
            appendTo: "#selcted_activity"
        });

    });

    new WOW().init();
    /* js for steps */
    var form = $("#example-form");
    form.validate({
        errorPlacement: function errorPlacement(error, element) {
            element.before(error);
        },
        rules: {
            confirm: {
                equalTo: "#password"
            }
        }
    });
    form.children("div").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex) {
            $("#selcted_activity").empty();
            $("#activity_name").empty();
            // console.log($('.ui-selectee').hasClass('ui-selected'));
            if ($('.ui-selectee').hasClass('ui-selected')) {


                $(".ui-selected").clone().appendTo("#selcted_activity");
                $(".ui-selected h3").clone().appendTo('#activity_name');


                // console.log('hello');
            }
            else {
                $('#activity1').clone().appendTo("#selcted_activity");
                $("#activity_name1").clone().appendTo('#activity_name');
            }
            //$( ".ui-selected" ).appendTo( $( "#selcted_activity" ));
            // $( "#selcted_activity" ).empty();
            console.log('sasas');
            console.log(iti.isValidNumber());

            if (currentIndex === 0) {

                }

            // if (currentIndex === 1) {
            //     console.log('hello');
            //     if (!$('.ui-selectee').hasClass('ui-selected')) {
            //         return false;
            //     }
            // }


            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();


        },
        onFinishing: function (event, currentIndex) {

            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            $("#example-form").submit();
        }
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
            };

            reader.readAsDataURL(input.files[0]);
        }
    };
    $('#blah').on("error", function() {
      $(this).attr('src', 'https://cdn2.iconfinder.com/data/icons/photo-and-video/500/Landscape_moon_mountains_multiple_photo_photograph_pictury_sun-512.png');
    });
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
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
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
</body>

</html>

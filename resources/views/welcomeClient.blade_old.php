<!--
Author: FileRole
Author URL: http://filerole.com
-->

<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

<head>
	<title>FileRole</title>
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<meta name="keywords" content="filerole, programs, startup" />

    <link rel="stylesheet" href="{{ asset('css/bootstrap-rtl.min.css') }}">

    <!-- font if ar -->
    <link href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700,900" rel="stylesheet">


	<!-- Style-CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

    <!-- js head -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
  @if(app()->getLocale()=="ar")
    <style>
        .welcome-you {
            background: #fff;
            width: 35%;
            margin: 15% auto;
            padding: 35px 30px 50px 30px;
            box-shadow: 0 0 20px #626262;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        body {
            padding: 0;
            margin: 0;
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            background:url(images/thanksbg.png);
            background-size:cover;
            position: relative;
        }
        .overflow-welcome {
            background: #f5f5f5;
            position: absolute;
            right: -260px;
            top: -300px;
            border-radius: 50%;
            width: 400px;
            height: 400px;
        }
        .welcome-you h3 {
            font-weight: normal;
            font-size: 24px;
            margin: 0 0 15px 0;
        }
        .welcome-you h3 span {
            font-weight: bold;
            color: #3cb660;
        }
        .welcome-you p {
            color: #8a8a8a;
            line-height: 30px;
            margin: 0 0 45px 0;
            font-size: 14px;
        }
        .welcome-you p a {
            color: #fff;
            background: #3cb660;
            padding: 0 10px;
            border-radius: 3px;
            margin: 0 5px 0 0;
        }
                .account-dash {
            background: #3cb660;
            color: #fff;
            font-size: 15px;
            padding: 4px 25px;
            border-radius: 50px;
            margin: 0 0 0 0;
            font-weight: 600;
        }
        .account-dash:hover,.make-dash:hover {
            background: #f5f5f5;
            color: #3cb660;
        }
        .make-dash {
            background: #fff;
            color: #3cb660;
            font-size: 15px;
            padding: 3px 30px;
            border-radius: 50px;
            margin: 0 15px 0 0;
            font-weight: normal;
            border: 1px solid #3cb660;
        }
    </style>
  @else
    <style>
    .welcome-you {
           background: #fff;
           width: 35%;
           margin: 15% auto;
           padding: 35px 30px 50px 30px;
           box-shadow: 0 0 20px #626262;
           text-align: center;
           position: relative;
           overflow: hidden;
       }
       body {
           padding: 0;
           margin: 0;
           font-family: 'Cairo', sans-serif;
           direction: ltr;
           background:url(images/thanksbg.png);
           background-size:cover;
           position: relative;
       }
       .overflow-welcome {
           background: #f5f5f5;
           position: absolute;
           left: -260px;
           top: -300px;
           border-radius: 50%;
           width: 400px;
           height: 400px;
       }
       .welcome-you h3 {
           font-weight: normal;
           font-size: 24px;
           margin: 0 0 15px 0;
       }
       .welcome-you h3 span {
           font-weight: bold;
           color: #3cb660;
       }
       .welcome-you p {
           color: #8a8a8a;
           line-height: 30px;
           margin: 0 0 45px 0;
           font-size: 14px;
       }
       .welcome-you p a {
           color: #fff;
           background: #3cb660;
           padding: 0 10px;
           border-radius: 3px;
           margin: 0 0 0 5px;
       }
               .account-dash {
           background: #3cb660;
           color: #fff;
           font-size: 15px;
           padding: 4px 25px;
           border-radius: 50px;
           margin: 0 0 0 0;
           font-weight: 600;
       }
       .account-dash:hover,.make-dash:hover {
           background: #f5f5f5;
           color: #3cb660;
       }
       .make-dash {
           background: #fff;
           color: #3cb660;
           font-size: 15px;
           padding: 3px 30px;
           border-radius: 50px;
           margin: 0 0 0 15px;
           font-weight: normal;
           border: 1px solid #3cb660;
       }
    </style>
  @endif
</head>

<body class="thanks">

    <div class="overflow-thanks"></div>

    <div class="welcome-you wow flipInX">
        <div class="overflow-welcome"></div>
        <h3>{{__('strings.welcome_to')}}<span>{{app()->getLocale()=="ar"?$user->name:$user->name_en}}</span></h3><p>{{__('strings.complete_registration_message')}}</p><a href="http://{{$owner_url}}/admin/settings">{{__('strings.account_settings')}}</a> </p>
        <a href="" class="account-dash"> {{__('strings.account_control')}}</a>
        <a href="" class="make-dash"> {{__('strings.make_invoice')}}</a>
    </div>

    <!-- js files -->
    <script src="https://code.jquery.com/jquery-3.4.0.min.js"
    integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
    crossorigin="anonymous"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('js/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        new WOW().init();
    </script>

</body>

</html>

<!--
Author: FileRole
Author URL: http://filerole.com
-->

<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

<head>
	<title>FileRole Mail</title>
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<meta name="keywords" content="filerole, programs, startup" />

    <!-- font if ar -->
    <link href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700,900" rel="stylesheet">

	<!-- Style-CSS -->
  @if(app()->getLocale()=='ar')
    <link rel="stylesheet" href="{{ asset('css/email_style.css') }}" type="text/css" media="all" />
  @else
    <link rel="stylesheet" href="{{ asset('css/email_style_en.css') }}" type="text/css" media="all" />
  @endif
</head>

<body>

    <div class="email">
        <div class="top_hi">
            <h2> <span>{{__('strings.file_role')}}</span>{{__('strings.bussiness_mange')}}</h2>
        </div>
        <div class="two_hi">
            <h1>{{app()->getLocale()=='ar'?$data['email_content']->name:$data['email_content']->name_en}}</h1>
            <h2>{{__('strings.account_number')}}: <span>{{$data['user']->org_id}}</span> </h2>
            <h2> {{__('strings.user_name')}}: <span>{{app()->getLocale()=='ar'?$data['user']->name:$data['user']->name_en}}</span> </h2>
        </div>
        <div class="contant_mail">
            <h6>{{__('strings.welcome')}} <span>{{app()->getLocale()=='ar'?$data['user']->name:$data['user']->name_en}}</span></h6>
            <p>{{app()->getLocale()=='ar'?$data['email_content']->content:$data['email_content']->content_en}}</p>

            <div class="start_now">
                <h5>{{app()->getLocale()=='ar'?$data['email_content']->title:$data['email_content']->title_en}}</h5>
                <a href="http://{{$data['owner_url']}}">http://{{$data['owner_url']}}</a>
            </div>

        </div>

        <hr>

        <div class="plans">
            <div class="plan-item">
                <h3 class="title-plan">{{_('strings.using_plan')}}</h3>
                <div class="title-plan">
                    <h3>{{$data['plan']->category_name}}</h3>
                    <p>{{__('strings.price')}} : <span> {{$data['plan']->month_val}} /{{__('strings.price')}}</span></p>
                </div>
                <ul>
                    <li>{{$data['plan']->offer_value}} {{__('strings.offers')}} </li>
                    <li>{{$data['plan']->invoice_value}}{{__('strings.invoice')}}</li>
                    <li>{{$data['plan']->customer_value}}{{__('strings.customers')}}</li>
                    <li>{{$data['plan']->emp_value}}{{__('strings.users')}}</li>
                </ul>
            </div>
        </div>

        <hr>

        <div class="need-help">
            <h3>{{__('strings.need_help')}}</h3>
            <p> {{__('strings.email_issue')}}
                <a href="mailto:{{$data['support_email']}}">{{$data['support_email']}}</a>
            </p>
        </div>

        <div class="footer_mail">
            <p>
              {{__('strings.email_sendto')}}
                <a href="mailto:{{$data['user']->email}}">{{$data['user']->email}}</a>
                <br>
              {{__('strings.email_cancel_message')}}
                <a href="http://master.filerolesys.com/unsubscripe?{{$data['user']->email}}">{{'strings.unsubscripe'}}</a>
            </p>
            <ul>
                <li> <a href="http://master.filerolesys.com/About">{{__('strings.about_file_role')}} </a> </li>
                <li> <a href="http://master.filerolesys.com/contact">{{__('strings.contact_us')}} </a> </li>
                <li> <a href="#">{{__('strings.terms_conditions')}} </a> </li>
                <li> <a href="#">{{__('strings.privacy')}}</a> </li>
            </ul>

        </div>

    </div>


    <!-- js files -->
    <script src="https://code.jquery.com/jquery-3.4.0.min.js"
    integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
    crossorigin="anonymous"></script>

</body>

</html>

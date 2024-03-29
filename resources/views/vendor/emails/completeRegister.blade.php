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
		<style>
		body{padding:0;margin:0;background:#fff;font-family:Cairo,sans-serif;direction:rtl}.email{background:#f8f8f8;margin:15px auto;width:50%;box-shadow:0 0 15px #dbdbdb;padding:20px 0 0 0}.email .top_hi h1{margin:0;padding:0;font-size:14px;font-weight:400}.email .top_hi h2{margin:0;padding:0;font-size:16px;font-weight:400;text-align:center;line-height:30px}.email .top_hi h2 span{display:block;font-weight:700;font-size:30px;color:#2db00a}.email .two_hi{background:#10b00a;margin:15px 0 0 0;padding:25px 25px}.email .two_hi h1{color:#fff;padding:0;margin:0;font-size:24px;display:inline-block}.email .two_hi h2{color:#fff;font-size:14px;font-weight:400;display:block;float:left;margin:0 35px 0 0;text-align:right;width:auto}.email .two_hi h2 span{display:block;font-weight:700}.email .contant_mail{padding:15px 20px}.email .contant_mail h6{margin:0;font-size:20px;color:#2db00a;font-weight:400}.email .contant_mail h6 span{font-weight:700}.email .contant_mail p{font-size:14px;width:90%;line-height:30px;padding:5px 0 0 0;margin:0}.email .contant_mail h5{margin:45px 0 30px 0;font-size:16px;display:inline-block;padding:0}.email .contant_mail a{color:#fff;background:#079307;padding:12px 25px;font-size:18px;border-radius:50px;text-align:center;display:inline-block;margin:0;position:relative;top:-8px;right:20px}.start_now{text-align:center}hr{border:1px solid #e9e9e9;width:95%}.need-help{padding:5px 35px}.need-help p{padding:0 0;margin:0 0;font-size:14px}.need-help h3{margin:0;padding:0;font-size:16px;color:#1661df}.need-help p a{font-size:16px;color:#1661df}.footer_mail{margin:30px 0 0 0;background:#5b5b5b;padding:18px 0}.footer_mail ul{list-style:none;padding:0 0;margin:0 29px}.footer_mail ul li{display:inline-block;margin:0}.footer_mail ul li:after{content:" ";background:#fff;width:4px;height:4px;display:inline-block;border-radius:50%;position:relative;top:-1px;margin:0 5px}.footer_mail ul li a{color:#fff;text-decoration:none;font-size:14px}.footer_mail ul li:last-child:after{content:" ";display:none}.footer_mail p{color:#fff;padding:0 0;margin:0 30px 15px 28px;font-size:12px}.footer_mail p a{color:#fff;font-weight:700;font-size:13px;text-decoration:none;margin:0 2px}.username{text-align:center}.plans .title-plans{margin:20px 0 0 0;text-align:center;color:#7c7c7c;font-size:18px;display:inline-block;position:absolute;top:-65px;right:0;left:0}.plans .plan-item{text-align:center;background:#fff;padding:0;box-shadow:0 8px 30px #e0e0e0;width:30%;margin:25px auto;display:inline-block;position:relative}.title-plan{background:#249308;padding:10px}.title-plan h3{color:#fff;font-size:22px;font-weight:700;margin:0}.title-plan p{color:#fff;font-size:15px;margin:0 0}.title-plan p span{font-weight:700}.plans .plan-item ul{list-style:none;text-align:center;padding:0}.plans .plan-item ul li{font-size:14px;color:#908f8f;padding:12px 0 12px 0;border:1px solid #f1f1f1;border-bottom:0;border-right:0;border-left:0;font-weight:600;position:relative}.plans .plan-item ul li i{color:#77d894;font-size:13px;padding:0 0 0 5px;position:absolute;right:41px;bottom:16px}.plans{text-align:center;margin:35px 0 0 0}@media (max-width:991px) and (min-width:768px){.email{background:#f8f8f8;margin:15px auto;width:80%;box-shadow:0 0 15px #dbdbdb;padding:20px 0 0 0}}@media (max-width:767px){.email{background:#f8f8f8;margin:15px auto;width:90%;box-shadow:0 0 15px #dbdbdb;padding:20px 0 0 0}}@media (max-width:500px){.email{background:#f8f8f8;margin:15px auto;width:95%;box-shadow:0 0 15px #dbdbdb;padding:20px 0 0 0}.email .two_hi h1{color:#fff;padding:0;margin:0;font-size:14px;display:inline-block}.email .two_hi h2{color:#fff;font-size:12px;font-weight:400;display:block;float:none;margin:0;text-align:right;width:auto}.email .two_hi h2 span{display:inline-block;font-weight:700}.email .contant_mail p{font-size:11px;width:95%;line-height:30px;padding:5px 0 0 0;margin:0}.email .contant_mail h5{margin:15px 0 20px 0;font-size:12px;display:inline-block;padding:0}.email .contant_mail a{color:#fff;background:#079307;padding:10px 20px;font-size:14px;border-radius:50px;text-align:center;display:inline-block;margin:0;position:relative;top:-8px;right:0}.email .contant_mail h6{margin:0;font-size:18px;color:#2db00a;font-weight:400}.plans .title-plans{margin:20px 0 0 0;text-align:center;color:#7c7c7c;font-size:12px;display:inline-block;position:absolute;top:-65px;right:0;left:0}.plans .plan-item{text-align:center;background:#fff;padding:0;box-shadow:0 8px 30px #e0e0e0;width:85%;margin:25px auto;display:inline-block}.email .two_hi{background:#10b00a;margin:15px 0 0 0;padding:10px 25px}.title-plan{background:#249308;padding:10px}.title-plan h3{color:#fff;font-size:16px;font-weight:700;margin:0}.title-plan p{color:#fff;font-size:12px;margin:0 0}.title-plan p span{font-weight:700}.plans .plan-item ul{list-style:none;text-align:center;padding:0}.plans .plan-item ul li{font-size:12px;color:#908f8f;padding:8px 0 8px 0;border:1px solid #f1f1f1;border-bottom:0;border-right:0;border-left:0;font-weight:600;position:relative}.plans .plan-item ul li i{color:#77d894;font-size:13px;padding:0 0 0 5px;position:absolute;right:41px;bottom:16px}.plans{text-align:center;margin:35px 0 0 0}.need-help{padding:5px 35px}.need-help p{padding:0 0;margin:0 0;font-size:12px}.need-help h3{margin:0;padding:0;font-size:13px;color:#1661df}.need-help p a{font-size:16px;color:#1661df}.footer_mail{margin:30px 0 0 0;background:#5b5b5b;padding:18px 0}.footer_mail ul{list-style:none;padding:0 0;margin:0 29px}.footer_mail ul li{display:inline-block;margin:0}.footer_mail ul li:after{content:" ";background:#fff;width:4px;height:4px;display:inline-block;border-radius:50%;position:relative;top:-1px;margin:0 5px}.footer_mail ul li a{color:#fff;text-decoration:none;font-size:13px}.footer_mail ul li:last-child:after{content:" ";display:none}.footer_mail p{color:#fff;padding:0 0;margin:0 30px 15px 28px;font-size:11px}.footer_mail p a{color:#fff;font-weight:700;font-size:13px;text-decoration:none;margin:0 2px}}
		</style>

  @else
    <style>
		body{padding:0;margin:0;background:#fff;font-family:Cairo,sans-serif;direction:ltr}.email{background:#f8f8f8;margin:15px auto;width:50%;box-shadow:0 0 15px #dbdbdb;padding:20px 0 0 0}.email .top_hi h1{margin:0;padding:0;font-size:14px;font-weight:400}.email .top_hi h2{margin:0;padding:0;font-size:16px;font-weight:400;text-align:center;line-height:30px}.email .top_hi h2 span{display:block;font-weight:700;font-size:30px;color:#2db00a}.email .two_hi{background:#10b00a;margin:15px 0 0 0;padding:25px 25px}.email .two_hi h1{color:#fff;padding:0;margin:0;font-size:24px;display:inline-block}.email .two_hi h2{color:#fff;font-size:14px;font-weight:400;display:block;float:right;margin:0 0 0 35px;text-align:left;width:auto}.email .two_hi h2 span{display:block;font-weight:700}.email .contant_mail{padding:15px 20px}.email .contant_mail h6{margin:0;font-size:20px;color:#2db00a;font-weight:400}.email .contant_mail h6 span{font-weight:700}.email .contant_mail p{font-size:14px;width:90%;line-height:30px;padding:5px 0 0 0;margin:0}.email .contant_mail h5{margin:45px 0 30px 0;font-size:16px;display:inline-block;padding:0}.email .contant_mail a{color:#fff;background:#079307;padding:12px 25px;font-size:18px;border-radius:50px;text-align:center;display:inline-block;margin:0;position:relative;top:-8px;left:20px}.start_now{text-align:center}hr{border:1px solid #e9e9e9;width:95%}.need-help{padding:5px 35px}.need-help p{padding:0 0;margin:0 0;font-size:14px}.need-help h3{margin:0;padding:0;font-size:16px;color:#1661df}.need-help p a{font-size:16px;color:#1661df}.footer_mail{margin:30px 0 0 0;background:#5b5b5b;padding:18px 0}.footer_mail ul{list-style:none;padding:0 0;margin:0 29px}.footer_mail ul li{display:inline-block;margin:0}.footer_mail ul li:after{content:" ";background:#fff;width:4px;height:4px;display:inline-block;border-radius:50%;position:relative;top:-1px;margin:0 5px}.footer_mail ul li a{color:#fff;text-decoration:none;font-size:14px}.footer_mail ul li:last-child:after{content:" ";display:none}.footer_mail p{color:#fff;padding:0 0;margin:0 28px 15px 30px;font-size:12px}.footer_mail p a{color:#fff;font-weight:700;font-size:13px;text-decoration:none;margin:0 2px}.username{text-align:center}.plans .title-plans{margin:20px 0 0 0;text-align:center;color:#7c7c7c;font-size:18px;display:inline-block;position:absolute;top:-65px;left:0;right:0}.plans .plan-item{text-align:center;background:#fff;padding:0;box-shadow:0 8px 30px #e0e0e0;width:30%;margin:25px auto;display:inline-block;position:relative}.title-plan{background:#249308;padding:10px}.title-plan h3{color:#fff;font-size:22px;font-weight:700;margin:0}.title-plan p{color:#fff;font-size:15px;margin:0 0}.title-plan p span{font-weight:700}.plans .plan-item ul{list-style:none;text-align:center;padding:0}.plans .plan-item ul li{font-size:14px;color:#908f8f;padding:12px 0 12px 0;border:1px solid #f1f1f1;border-bottom:0;border-left:0;border-right:0;font-weight:600;position:relative}.plans .plan-item ul li i{color:#77d894;font-size:13px;padding:0 5px 0 0;position:absolute;left:41px;bottom:16px}.plans{text-align:center;margin:35px 0 0 0}@media (max-width:991px) and (min-width:768px){.email{background:#f8f8f8;margin:15px auto;width:80%;box-shadow:0 0 15px #dbdbdb;padding:20px 0 0 0}}@media (max-width:767px){.email{background:#f8f8f8;margin:15px auto;width:90%;box-shadow:0 0 15px #dbdbdb;padding:20px 0 0 0}}@media (max-width:500px){.email{background:#f8f8f8;margin:15px auto;width:95%;box-shadow:0 0 15px #dbdbdb;padding:20px 0 0 0}.email .two_hi h1{color:#fff;padding:0;margin:0;font-size:14px;display:inline-block}.email .two_hi h2{color:#fff;font-size:12px;font-weight:400;display:block;float:none;margin:0;text-align:left;width:auto}.email .two_hi h2 span{display:inline-block;font-weight:700}.email .contant_mail p{font-size:11px;width:95%;line-height:30px;padding:5px 0 0 0;margin:0}.email .contant_mail h5{margin:15px 0 20px 0;font-size:12px;display:inline-block;padding:0}.email .contant_mail a{color:#fff;background:#079307;padding:10px 20px;font-size:14px;border-radius:50px;text-align:center;display:inline-block;margin:0;position:relative;top:-8px;left:0}.email .contant_mail h6{margin:0;font-size:18px;color:#2db00a;font-weight:400}.plans .title-plans{margin:20px 0 0 0;text-align:center;color:#7c7c7c;font-size:12px;display:inline-block;position:absolute;top:-65px;left:0;right:0}.plans .plan-item{text-align:center;background:#fff;padding:0;box-shadow:0 8px 30px #e0e0e0;width:85%;margin:25px auto;display:inline-block}.email .two_hi{background:#10b00a;margin:15px 0 0 0;padding:10px 25px}.title-plan{background:#249308;padding:10px}.title-plan h3{color:#fff;font-size:16px;font-weight:700;margin:0}.title-plan p{color:#fff;font-size:12px;margin:0 0}.title-plan p span{font-weight:700}.plans .plan-item ul{list-style:none;text-align:center;padding:0}.plans .plan-item ul li{font-size:12px;color:#908f8f;padding:8px 0 8px 0;border:1px solid #f1f1f1;border-bottom:0;border-left:0;border-right:0;font-weight:600;position:relative}.plans .plan-item ul li i{color:#77d894;font-size:13px;padding:0 5px 0 0;position:absolute;left:41px;bottom:16px}.plans{text-align:center;margin:35px 0 0 0}.need-help{padding:5px 35px}.need-help p{padding:0 0;margin:0 0;font-size:12px}.need-help h3{margin:0;padding:0;font-size:13px;color:#1661df}.need-help p a{font-size:16px;color:#1661df}.footer_mail{margin:30px 0 0 0;background:#5b5b5b;padding:18px 0}.footer_mail ul{list-style:none;padding:0 0;margin:0 29px}.footer_mail ul li{display:inline-block;margin:0}.footer_mail ul li:after{content:" ";background:#fff;width:4px;height:4px;display:inline-block;border-radius:50%;position:relative;top:-1px;margin:0 5px}.footer_mail ul li a{color:#fff;text-decoration:none;font-size:13px}.footer_mail ul li:last-child:after{content:" ";display:none}.footer_mail p{color:#fff;padding:0 0;margin:0 28px 15px 30px;font-size:11px}.footer_mail p a{color:#fff;font-weight:700;font-size:13px;text-decoration:none;margin:0 2px}}
		</style>
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
                <a href="http://{{$data['owner_url']}}">http://{{$data['owner_url'].'/'.'admin/login'}}</a>
                <p>{{__('strings.your coustomer can use this to view your products and services')}}</p>
               
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
                <li> <a href="http://master.filerolesys.com/page/terms-and-conditions">{{__('strings.terms_conditions')}} </a> </li>
                <li> <a href="http://master.filerolesys.com/page/privacy-and-policy">{{__('strings.privacy')}}</a> </li>
            </ul>

        </div>

    </div>


    <!-- js files -->
    <script src="https://code.jquery.com/jquery-3.4.0.min.js"
    integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
    crossorigin="anonymous"></script>

</body>

</html>

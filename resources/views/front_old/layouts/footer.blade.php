<footer>
  @php

   $my_url=url()->current();
     $my_url=$_SERVER['HTTP_HOST'];
   $org_id=DB::table('organizations')->where('customer_url',$my_url)->first();

    @endphp
    <div class="container">
        <div class="row">

            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="links_footer">
                    <h3 class="title_footer">	{{ app()->getLocale() == 'ar' ? $org_id->name : $org_id->name_en}} Pages </h3>
                    <ul>
                      <li> <a href="{{url('/frontpage') }}"> @lang('strings.Home') </a> </li>
                      <li> <a href="{{url('/offers') }}"> @lang('strings.Offers') </a> </li>
                      <li> <a href="{{url('/categorys') }}"> @lang('strings.cat_ser')  </a> </li>
                      <li> <a href="{{url('/aboutus') }}"> @lang('strings.about_us')  </a> </li>
                      <li> <a href="{{url('/contact') }}"> @lang('strings.contact_us')</a> </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4 col-xs-12">
                <div class="newsletter">
                    <h3 class="title_footer">@lang('strings.front_text3') </h3>
                    <p>@lang('strings.front_text1')</p>
                    <form  action="{{url('/subscribers_message') }}" name="newsletter" action="post">
                        <input type="email" placeholder="example@email.com" name="email" required>
                        <button type="submit" class="btn btn-submit">@lang('strings.join_us')</button>
                    </form>
                </div>
            </div>

            <div class="col-md-4 col-xs-12">
                <div class="info_footer">
                    <h3 class="title_footer"> @lang('strings.front_text2')</h3>
                    <a href="tel:0220187656" class="phone_footer"><i class="fas fa-phone"></i> {{  $org_id->phone }} </a>
                    <a href="mailto:{{$org_id->email_crm}}" class="email_footer"> <i class="fas fa-envelope"></i> {{  $org_id->email_crm }}</a>
                    <p class="adress">
                      {{  $org_id->address }}
                    </p>
                    <a href="https://google.com/maps" target="_blank"> @lang('strings.front_text4') </a>
                </div>
            </div>

        </div>

        <!-- last footer -->
        <div class="last_footer">
            <div class="row">
                <div class="col-md-6 col-xs-12">

                    <p class="text_copyright">
                    <a href="#home"> {{ app()->getLocale() == 'ar' ? $org_id->name : $org_id->name_en}} </a>  <p class="buy_f"> © 2019 @lang('strings.front_text5') <a href="http://www.filerole.com/" target="_blank">@lang('strings.fileRole')</a>  </p> 
                    </p>

                </div>

                <div class="col-md-6 col-xs-12">
                    <div class="social_footer">
                        <h5>@lang('strings.contact_us')</h5>
                        <ul>
                          <li> <a href="{{$org_id->facebook}}" target="_blank"> <i class="fab fa-facebook-f"></i> </a> </li>
                          <li> <a href="{{$org_id->twitter}}" target="_blank"> <i class="fab fa-twitter"></i> </a> </li>
                          <li> <a href="{{$org_id->instgram}}" target="_blank"> <i class="fab fa-instagram"></i> </a> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> <!-- // last footer -->


    </div>
</footer> <!-- // footer -->

<!-- js files -->
<script src="https://code.jquery.com/jquery-3.4.0.min.js"
integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="/front/js/wow.min.js"></script>
<script src="/front/js/owl.carousel.min.js"></script>
<script src="/front/js/three.r92.min.js"></script>
<script src="/front/js/vanta.dots.min.js"></script>
<script src="/front/js/main.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
<script src="/front/js/script.js"></script>

<script>
VANTA.DOTS({
  el: "#bgSlider",
  backgroundColor: 0x313131
})
</script>
<script>
    $('.nav-tabs a:first').tab('show') 
</script>

@yield('scripts')
</div>
<body>
<html>


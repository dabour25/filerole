@extends('front.index_layout')

@section('content')
  <style>
  body {
   text-align: right;
   direction: rtl;
   background: #f3f3f3;
}
.pay-content .item-pay {
   display: inline-block;
   width: 100%;
   padding: 5px 0;
   border-bottom: 0;
   margin: 0 0 10px 0;
}
.pay-content .item-pay div {}
.pay-content .item-pay p {
   margin: 0;
   font-size: 16px;
   font-weight: 400;
}
.pay-content .item-pay h6 {
   font-size: 13px;
   margin: 0 0 0 0;
   color: #777;
   font-weight: normal;
}
.pay-content .item-pay h4 {
   font-size: 16px;
   margin: 0 0 0 0;
   color: #424242;
}
.pay-content .item-pay p a {}
.col-4 {
   width: 39%;
   display: inline-block;
}
.col-8 {
   width: 59%;
   display: inline-block;
}
.col-12 {
   padding: 0 0;
}
.pay-content .item-pay .forselect {
   display: inline-block;
   margin: 0 10px 0 0;
   font-size: 14px;
   color: #464646;
}
select {
   min-width: 170px;
   padding: 2px 5px 6px 5px;
}
.pay-content .item-pay .opt-pay {
   margin: 0 15px 0 0;
}
.pay-content .item-pay img {
   max-width: 100%;
   height: 20px;
   margin: 0 15px 0 0;
}
#payinfo,#paypersonal {
   display: none;
}
.pay-content input:not([type='radio']) {
   width: 100%;
   border-radius: 3px;
   box-shadow: none;
   border: 1px solid #ccc;
   padding: 8px 0;
   margin: 0 0 20px 0;
}
.pay-content select {
   width: 100%;
   border-radius: 3px;
   box-shadow: none;
   border: 1px solid #ccc;
   padding: 5px 0;
   margin: 0 0 15px 0;
   padding: 6px 5px;
}
.pay-content .not-bottom {
   width: auto;
}
.pay-content  .select_nolabel {
   margin: 31px 0 15px 0;
}
.pay-content label {
   display: block;
   margin: 0 0 10px 0;
   color: #4c4c4c;
}
.backs_pau2 {
   position: relative;
   height: 35px;
   bottom: -35px;
}
.btn-submit-pay {
   background: red;
   color: #fff;
   padding: 7px 55px;
   font-weight: bold;
   margin: 0 -15px 30px 0;
}

.payment-title {
   width: 100%;
   text-align: center;
}

.form-container .field-container:first-of-type {
   grid-area: name;
}

.form-container .field-container:nth-of-type(2) {
   grid-area: number;
}

.form-container .field-container:nth-of-type(3) {
   grid-area: expiration;
   width: 49%;
   display: inline-block;
}

.form-container .field-container:nth-of-type(4) {
   grid-area: security;
   width: 48%;
   display: inline-block;
   margin: 0 10px 0 0;
}

.field-container input {
   -webkit-box-sizing: border-box;
   box-sizing: border-box;
}

.field-container {
   position: relative;
}

.form-container {
   display: inline-block;
   grid-column-gap: 10px;
   grid-template-columns: auto auto;
   grid-template-rows: 90px 90px 90px;
   grid-template-areas: "name name""number number""expiration security";
   padding: 0;
   color: #707070;
   position: relative;
   margin: 0 0 0 0;
   width: 48%;
}

.ccicon {
   height: 32px;
   position: absolute;
   left: 0;
   top: calc(57% - 17px);
   width: 60px;
}

/* CREDIT CARD IMAGE STYLING */
.preload * {
   -webkit-transition: none !important;
   -moz-transition: none !important;
   -ms-transition: none !important;
   -o-transition: none !important;
}


#ccsingle {
   position: absolute;
   right: 15px;
   top: 20px;
}

#ccsingle svg {
   width: 100px;
   max-height: 60px;
}

.creditcard svg#cardfront,
.creditcard svg#cardback {
   width: 100%;
   -webkit-box-shadow: 1px 5px 6px 0px black;
   box-shadow: 1px 5px 6px 0px black;
   border-radius: 22px;
}

#generatecard{
   cursor: pointer;
   float: right;
   font-size: 12px;
   color: #fff;
   padding: 2px 4px;
   background-color: #909090;
   border-radius: 0;
   cursor: pointer;
   float:right;
   position: absolute;
   left: 0px;
   top: 2px;
}

/* CHANGEABLE CARD ELEMENTS */
.creditcard .lightcolor,
.creditcard .darkcolor {
   -webkit-transition: fill .5s;
   transition: fill .5s;
}

.creditcard .lightblue {
   fill: #03A9F4;
}

.creditcard .lightbluedark {
   fill: #0288D1;
}

.creditcard .red {
   fill: #ef5350;
}

.creditcard .reddark {
   fill: #d32f2f;
}

.creditcard .purple {
   fill: #ab47bc;
}

.creditcard .purpledark {
   fill: #7b1fa2;
}

.creditcard .cyan {
   fill: #26c6da;
}

.creditcard .cyandark {
   fill: #0097a7;
}

.creditcard .green {
   fill: #66bb6a;
}

.creditcard .greendark {
   fill: #388e3c;
}

.creditcard .lime {
   fill: #d4e157;
}

.creditcard .limedark {
   fill: #afb42b;
}

.creditcard .yellow {
   fill: #ffeb3b;
}

.creditcard .yellowdark {
   fill: #f9a825;
}

.creditcard .orange {
   fill: #ff9800;
}

.creditcard .orangedark {
   fill: #ef6c00;
}

.creditcard .grey {
   fill: #bdbdbd;
}

.creditcard .greydark {
   fill: #616161;
}

/* FRONT OF CARD */
#svgname {
   text-transform: uppercase;
}

#cardfront .st2 {
   fill: #FFFFFF;
}

#cardfront .st3 {
   font-family: 'Source Code Pro', monospace;
   font-weight: 600;
}

#cardfront .st4 {
   font-size: 54.7817px;
}

#cardfront .st5 {
   font-family: 'Source Code Pro', monospace;
   font-weight: 400;
}

#cardfront .st6 {
   font-size: 33.1112px;
}

#cardfront .st7 {
   opacity: 0.6;
   fill: #FFFFFF;
}

#cardfront .st8 {
   font-size: 24px;
}

#cardfront .st9 {
   font-size: 36.5498px;
}

#cardfront .st10 {
   font-family: 'Source Code Pro', monospace;
   font-weight: 300;
}

#cardfront .st11 {
   font-size: 16.1716px;
}

#cardfront .st12 {
   fill: #4C4C4C;
}

/* BACK OF CARD */
#cardback .st0 {
   fill: none;
   stroke: #0F0F0F;
   stroke-miterlimit: 10;
}

#cardback .st2 {
   fill: #111111;
}

#cardback .st3 {
   fill: #F2F2F2;
}

#cardback .st4 {
   fill: #D8D2DB;
}

#cardback .st5 {
   fill: #C4C4C4;
}

#cardback .st6 {
   font-family: 'Source Code Pro', monospace;
   font-weight: 400;
}

#cardback .st7 {
   font-size: 27px;
}

#cardback .st8 {
   opacity: 0.6;
}

#cardback .st9 {
   fill: #FFFFFF;
}

#cardback .st10 {
   font-size: 24px;
}

#cardback .st11 {
   fill: #EAEAEA;
}

#cardback .st12 {
   font-family: 'Rock Salt', cursive;
}

#cardback .st13 {
   font-size: 37.769px;
}

.creditcard {
   width: 100%;
   max-width: 400px;
   -webkit-transform-style: preserve-3d;
   transform-style: preserve-3d;
   transition: -webkit-transform 0.6s;
   -webkit-transition: -webkit-transform 0.6s;
   transition: transform 0.6s;
   transition: transform 0.6s, -webkit-transform 0.6s;
   cursor: pointer;
   display: block;
}
.cardfix {

display: inline-block;

height: 260px;

width: 46%;

margin: 0 0 0 0;

position: relative;

bottom: -20px;
}
.creditcard .front,
.creditcard .back {
   position: absolute;
   width: 100%;
   max-width: 400px;
   -webkit-backface-visibility: hidden;
   backface-visibility: hidden;
   -webkit-font-smoothing: antialiased;
   color: #47525d;
   direction: ltr;
}
.col-6 {

display: inline-block;

width: 49%;
}

.creditcard .back {
   -webkit-transform: rotateY(180deg);
   transform: rotateY(180deg);
}

.creditcard.flipped {
   -webkit-transform: rotateY(180deg);
   transform: rotateY(180deg);
}
.clearfix {
   clear: both;
}
.right-front-pay {

padding: 0 0;
}
.left-front-pay {

padding: 0;
}
.pay-content {
}
.payshadow ,.pay-first{

border-radius: 0;

margin: 25px 0;

overflow: hidden;

background: #ffffff;

padding: 20px 20px;

box-shadow: 0 0 15px #d8d8d8;
}
.left-front-pay h2 {

color: #404040;

border-bottom: 1px solid #ccc;

font-size: 20px;

font-weight: bold;

padding: 0 0 15px 0;

margin: 0 0 15px 0;
}
.item-payfront {

}
.item-payfront h6 {

color: #9c9c9c;

font-size: 18px;

width: 50%;

display: inline-block;

margin: 0 0 10px 0;
}
.item-payfront p {

color: #f00;

font-size: 18px;

width: 49%;

display: inline-block;

font-weight: bold;

text-align: left;

margin: 0 0 10px 0;
}
.total-payfront {

border-top: 1px solid #d2d2d2;

padding: 10px 0 0 0;

margin: 60px 0 0 0;
}
.title-pay h3 {

color: #040404;

font-size: 20px;

border-bottom: 1px solid #ccc;

padding: 0 0 15px 0;

margin: 0 0 20px 0;
}
.kl-bottommask--mask6 {
   position: absolute;
   bottom: 0;
   right: 0;
   width: 100%;
   height: 57px;
}
  </style>

  <div id="page_header" class="page-subheader page-subheader-bg">

      <!-- Sub-Header content wrapper -->
      <div class="ph-content-wrap d-flex">
          <div class="container align-self-center">
              <div class="row">

                  <div class="col-sm-12 col-md-6 col-lg-6">
                      <div class="subheader-titles">
                          <h2 class="subheader-maintitle">
                            {{__('strings.payment')}}
                          </h2>

                      </div>
                  </div>

                  <div class="col-sm-12 col-md-6 col-lg-6">
                      <ul class="breadcrumbs fixclear">
                          <li><a href="/">{{__('strings.home')}}</a></li>
                          <li>{{__('strings.payment')}}</li>
                      </ul>

                  </div>
              </div>
          </div>
      </div>

      <!-- Sub-Header bottom mask style 6 -->
      <div class="kl-bottommask kl-bottommask--mask6">
          <svg width="2700px" height="57px" class="svgmask" viewBox="0 0 2700 57" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">
              <defs>
                  <filter x="-50%" y="-50%" width="200%" height="200%" filterUnits="objectBoundingBox" id="filter-mask6">
                      <feOffset dx="0" dy="-2" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset>
                      <feGaussianBlur stdDeviation="2" in="shadowOffsetOuter1" result="shadowBlurOuter1"></feGaussianBlur>
                      <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.5 0" in="shadowBlurOuter1" type="matrix" result="shadowMatrixOuter1"></feColorMatrix>
                      <feMerge>
                          <feMergeNode in="shadowMatrixOuter1"></feMergeNode>
                          <feMergeNode in="SourceGraphic"></feMergeNode>
                      </feMerge>
                  </filter>
              </defs>
              <g transform="translate(-1.000000, 10.000000)">
                  <path d="M0.455078125,18.5 L1,47 L392,47 L1577,35 L392,17 L0.455078125,18.5 Z" fill="#000000"></path>
                  <path d="M2701,0.313493752 L2701,47.2349598 L2312,47 L391,47 L2312,0 L2701,0.313493752 Z" fill="#fbfbfb" class="bmask-bgfill" filter="url(#filter-mask6)"></path>
                  <path d="M2702,3 L2702,19 L2312,19 L1127,33 L2312,3 L2702,3 Z" fill="#cd2122" class="bmask-customfill"></path>
              </g>
          </svg>
      </div>

  </div>

  <div class="front-pay">
      <div class="container">
          <div class="payshadow">
          <div class="col-12">
              <div class="left-front-pay">
                  <h2> {{__('strings.cart_information')}}</h2>
                  <div class="item-payfront">
                      <h6>{{__('strings.invoice_number')}} </h6>
                      <p>{{$invoice_code}}</p>
                  </div>
                  <div class="item-payfront total-payfront">
                      <h6>{{__('strings.total')}} </h6>
                      <p>{{$total_amount}}</p>
                  </div>
              </div>
          </div>
          </div>


          <div class="col-12">
              <div class="right-front-pay pay-content">

                  <div class="payshadow">
                    <form action="{{url('execute_payment')}}" method="post" id="payment_form" class="validate">
                     <input type="hidden" name="total_amount" value="{{$total_amount}}">
                     <input type="hidden" name="invoice_number" value="{{$invoice_number}}">
                     <input type="hidden" name="external_req_id" value="{{$external_req_id}}">
                     <input type="hidden" name="invoice_code" value="{{$invoice_code}}">
                     @if(\App\PaymentSetup::where(['gateway' => 'cash', 'org_id' => Auth::guard('customers')->user()->org_id])->value('active') ==1)
                      <div class="item-pay">
                          <input type="radio" name="payment_type" {{ \App\PaymentSetup::where(['gateway' => 'cash', 'org_id' => 334])->value('default') ==1  ? 'checked' : ''}} id="cash_clicked"  value="1" class="opt-pay" onclick="show4()" checked>
                          {{__('strings.cash_on_delivery')}}
                      </div>
                      @endif
                      @if(\App\PaymentSetup::where(['gateway' => 'stripe', 'org_id' => Auth::guard('customers')->user()->org_id])->value('active') ==1 || \App\PaymentSetup::where(['gateway' => 'authorize', 'org_id' => Auth::guard('customers')->user()->org_id])->value('active') ==1 )
                      <div class="item-pay">
                          <input type="radio" name="payment_type" {{ \App\PaymentSetup::where(['gateway' => 'stripe', 'org_id' => Auth::guard('customers')->user()->org_id])->value('default') ==1 || \App\PaymentSetup::where(['gateway' => 'authorize', 'org_id' => Auth::guard('customers')->user()->org_id])->value('default') ==1  ? 'checked' : ''}}  id ="credit_clicked" value="2" class="opt-pay" onclick="show1()" >
                          {{__('strings.credit_card')}}
                          <img src="banking.PNG" alt="banking">
                      </div>
                      @endif
                      {{-- <div class="item-pay">
                          <input type="radio" name="gender" value="female" class="opt-pay" onclick="show2()">
                           تحويل بنكي
                          <img src="https://upload.wikimedia.org/wikipedia/en/thumb/e/ef/Commercial_International_Bank_logo.svg/1200px-Commercial_International_Bank_logo.svg.png" alt="banking">
                      </div> --}}
                      @if(\App\PaymentSetup::where(['gateway' => 'paypal', 'org_id' => Auth::guard('customers')->user()->org_id])->value('active') ==1)
                      <div class="item-pay">
                          <input type="radio" name="payment_type"  {{ \App\PaymentSetup::where(['gateway' => 'paypal', 'org_id' => Auth::guard('customers')->user()->org_id])->value('default') ==1  ? 'checked' : ''}} id="paypal_checked"  value="3" class="opt-pay" onclick="show3()">
                          {{__('strings.paypal')}}
                          <img src="https://commercetools.com/wp-content/uploads/2018/07/paypal.png">
                      </div>
                      @endif
                  </div>
                  <div class="col-md-12 cell example example5" id="example-5">
                      <div id="example5-paymentRequest">
                  </div>



                    {{ csrf_field() }}
                      <div class="pay-first" id="payinfo">
                          <div class="container">
                              <div class="title-pay">
                                  <h3>{{__('strings.payment_information')}}</h3>
                              </div>
                              <div class="pay-content">
                                  <div class="cardfix preload">
                                      <div class="creditcard">
                                          <div class="front">
                                              <div id="ccsingle"></div>
                                              <svg version="1.1" id="cardfront" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                  x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
                                                  <g id="Front">
                                                      <g id="CardBackground">
                                                          <g id="Page-1_1_">
                                                              <g id="amex_1_">
                                                                  <path id="Rectangle-1_1_" class="lightcolor grey" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                                                          C0,17.9,17.9,0,40,0z" />
                                                              </g>
                                                          </g>
                                                          <path class="darkcolor greydark" d="M750,431V193.2c-217.6-57.5-556.4-13.5-750,24.9V431c0,22.1,17.9,40,40,40h670C732.1,471,750,453.1,750,431z" />
                                                      </g>
                                                      <text transform="matrix(1 0 0 1 60.106 295.0121)" id="svgnumber" class="st2 st3 st4">0123 4567 8910 1112</text>
                                                      <text transform="matrix(1 0 0 1 54.1064 428.1723)" id="svgname" class="st2 st5 st6">JOHN DOE</text>
                                                      <text transform="matrix(1 0 0 1 54.1074 389.8793)" class="st7 st5 st8">cardholder name</text>
                                                      <text transform="matrix(1 0 0 1 479.7754 388.8793)" class="st7 st5 st8">expiration</text>
                                                      <text transform="matrix(1 0 0 1 65.1054 241.5)" class="st7 st5 st8">card number</text>
                                                      <g>
                                                          <text transform="matrix(1 0 0 1 574.4219 433.8095)" id="svgexpire" class="st2 st5 st9">01/23</text>
                                                          <text transform="matrix(1 0 0 1 479.3848 417.0097)" class="st2 st10 st11">VALID</text>
                                                          <text transform="matrix(1 0 0 1 479.3848 435.6762)" class="st2 st10 st11">THRU</text>
                                                          <polygon class="st2" points="554.5,421 540.4,414.2 540.4,427.9 		" />
                                                      </g>
                                                      <g id="cchip">
                                                          <g>
                                                              <path class="st2" d="M168.1,143.6H82.9c-10.2,0-18.5-8.3-18.5-18.5V74.9c0-10.2,8.3-18.5,18.5-18.5h85.3
                                                      c10.2,0,18.5,8.3,18.5,18.5v50.2C186.6,135.3,178.3,143.6,168.1,143.6z" />
                                                          </g>
                                                          <g>
                                                              <g>
                                                                  <rect x="82" y="70" class="st12" width="1.5" height="60" />
                                                              </g>
                                                              <g>
                                                                  <rect x="167.4" y="70" class="st12" width="1.5" height="60" />
                                                              </g>
                                                              <g>
                                                                  <path class="st12" d="M125.5,130.8c-10.2,0-18.5-8.3-18.5-18.5c0-4.6,1.7-8.9,4.7-12.3c-3-3.4-4.7-7.7-4.7-12.3
                                                          c0-10.2,8.3-18.5,18.5-18.5s18.5,8.3,18.5,18.5c0,4.6-1.7,8.9-4.7,12.3c3,3.4,4.7,7.7,4.7,12.3
                                                          C143.9,122.5,135.7,130.8,125.5,130.8z M125.5,70.8c-9.3,0-16.9,7.6-16.9,16.9c0,4.4,1.7,8.6,4.8,11.8l0.5,0.5l-0.5,0.5
                                                          c-3.1,3.2-4.8,7.4-4.8,11.8c0,9.3,7.6,16.9,16.9,16.9s16.9-7.6,16.9-16.9c0-4.4-1.7-8.6-4.8-11.8l-0.5-0.5l0.5-0.5
                                                          c3.1-3.2,4.8-7.4,4.8-11.8C142.4,78.4,134.8,70.8,125.5,70.8z" />
                                                              </g>
                                                              <g>
                                                                  <rect x="82.8" y="82.1" class="st12" width="25.8" height="1.5" />
                                                              </g>
                                                              <g>
                                                                  <rect x="82.8" y="117.9" class="st12" width="26.1" height="1.5" />
                                                              </g>
                                                              <g>
                                                                  <rect x="142.4" y="82.1" class="st12" width="25.8" height="1.5" />
                                                              </g>
                                                              <g>
                                                                  <rect x="142" y="117.9" class="st12" width="26.2" height="1.5" />
                                                              </g>
                                                          </g>
                                                      </g>
                                                  </g>
                                                  <g id="Back">
                                                  </g>
                                              </svg>
                                          </div>
                                          <div class="back">
                                              <svg version="1.1" id="cardback" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                  x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
                                                  <g id="Front">
                                                      <line class="st0" x1="35.3" y1="10.4" x2="36.7" y2="11" />
                                                  </g>
                                                  <g id="Back">
                                                      <g id="Page-1_2_">
                                                          <g id="amex_2_">
                                                              <path id="Rectangle-1_2_" class="darkcolor greydark" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                                                      C0,17.9,17.9,0,40,0z" />
                                                          </g>
                                                      </g>
                                                      <rect y="61.6" class="st2" width="750" height="78" />
                                                      <g>
                                                          <path class="st3" d="M701.1,249.1H48.9c-3.3,0-6-2.7-6-6v-52.5c0-3.3,2.7-6,6-6h652.1c3.3,0,6,2.7,6,6v52.5
                                                  C707.1,246.4,704.4,249.1,701.1,249.1z" />
                                                          <rect x="42.9" y="198.6" class="st4" width="664.1" height="10.5" />
                                                          <rect x="42.9" y="224.5" class="st4" width="664.1" height="10.5" />
                                                          <path class="st5" d="M701.1,184.6H618h-8h-10v64.5h10h8h83.1c3.3,0,6-2.7,6-6v-52.5C707.1,187.3,704.4,184.6,701.1,184.6z" />
                                                      </g>
                                                      <text transform="matrix(1 0 0 1 621.999 227.2734)" id="svgsecurity" class="st6 st7">985</text>
                                                      <g class="st8">
                                                          <text transform="matrix(1 0 0 1 518.083 280.0879)" class="st9 st6 st10">security code</text>
                                                      </g>
                                                      <rect x="58.1" y="378.6" class="st11" width="375.5" height="13.5" />
                                                      <rect x="58.1" y="405.6" class="st11" width="421.7" height="13.5" />
                                                      <text transform="matrix(1 0 0 1 59.5073 228.6099)" id="svgnameback" class="st12 st13">John Doe</text>
                                                  </g>
                                              </svg>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-container">
                                      <div class="field-container">
                                          <label for="name">{{__('strings.name')}}</label>
                                          <input id="name1" name="card_name" maxlength="20" type="text" >
                                      </div>
                                      <div class="field-container">
                                          <label for="cardnumber">{{__('strings.card_number')}}</label><span id="generatecard">{{__('create_number')}}</span>
                                          <input id="cardnumber" type="text" name="number" data-stripe="number">
                                          <svg id="ccicon" class="ccicon" width="750" height="471" viewBox="0 0 750 471" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                              xmlns:xlink="http://www.w3.org/1999/xlink">

                                          </svg>
                                      </div>
                                      <div class="field-container">
                                          <label for="expirationdate">{{__('strings.expiration_date')}} (mm/yy)</label>
                                          <input id="expirationdate" type="text" data-stripe="exp-date" name="exp_date">
                                      </div>
                                      <div class="field-container">
                                          <label for="securitycode">{{__('strings.Password')}}</label>
                                          <input id="securitycode" data-stripe="cvc" name="cvc" type="text">
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="pay-first" id="paypersonal">
                          <div class="container">
                              <div class="title-pay">
                                  <h3>{{__('strings.personal_information')}}</h3>
                              </div>
                              <div class="pay-content">
                                          <div class="col-6">
                                              <label>{{__('strings.first_name')}}</label>
                                              <input type="text" required name="name">
                                          </div>
                                          <div class="col-6">
                                              <label>{{__('strings.last_name')}}</label>
                                              <input type="text" name="last_name" required>
                                          </div>
                                          <div class="col-6">
                                              <label>{{__('strings.email')}}</label>
                                              <input type="email" name="email" required>
                                          </div>
                                          <div class="col-6">
                                              <label>{{__('strings.address')}}</label>
                                              <input type="text" name="address" required>
                                          </div>
                                          <div class="col-6">
                                              <label>{{__('strings.city')}}</label>
                                              <input type="text" name="city" required>
                                          </div>
                                          <div class="col-6">
                                              <label>{{__('strings.governement')}}</label>
                                              <input type="text"  name="governement" required>
                                          </div>
                                          <div class="col-6">
                                              <label>{{__('strings.postal_code')}}</label>
                                              <input type="text" name="postal_code" required>
                                          </div>
                                          <div class="col-6">
                                              <label>{{__('strings.state')}}</label>
                                              <input type="text" name="state" required>
                                          </div>
                                          <div class="col-6">
                                              <label>{{__('strings.checkPhone')}}</label>
                                              <input type="text" name="phone" required>
                                          </div>
                              </div>
                          </div>
                      </div>

                      <div class="button_sub_pay">
                          <div class="container">
                              <button type="submit" class="btn btn-submit-pay">{{__('strings.continue')}}</button>
                              
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
<script src="/front/js/hossam_front.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script><script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-de7e2ef6bfefd24b79a3f68b414b87b8db5b08439cac3f1012092b2290c719cd.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js"></script>
	<script src="https://js.stripe.com/v2/"></script>


  @if(\App\PaymentSetup::where(['gateway' => 'stripe', 'org_id' => Auth::guard('customers')->user()->org_id])->value('active') ==1)
      <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
      <script type="text/javascript">
          Stripe.setPublishableKey(\App\PaymentSetup::where(['gateway' => 'authorize', 'org_id' => Auth::guard('customers')->user()->org_id])->value('acc_password'));
          $('#payment_form').submit(function (e) {
              $form = $(this);
              $form.find('button').prop('disabled', true);
              if ($("input[name=payment_type]:checked").val() == 2) {
                  var exp_date =  $('input[name=exp_date]').val().split("/");
                  $form.append($('<input type="hidden" data-stripe="exp-month">').val(exp_date[0]));
                  $form.append($('<input type="hidden" data-stripe="exp-year">').val(exp_date[1]));
                  $form.append($('<input type="hidden" data-stripe="number">').val( $('#cardnumber').val()));
                  Stripe.card.createToken($form, function (status, response) {
                      if (response.error) {
                        alert(response.error.message);
                        //$form.find('button').prop('disabled', false);
                      } else {
                          var token = response.id;
                          console.log(token)
                          $form.append($('<input type="hidden" name="token1">').val(token));
                          $form.get(0).submit();
                      }
                  });
              }
              $form.get(0).submit();
              return false;
          });



      </script>


  @endif



@endsection

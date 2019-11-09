@extends('layouts.admin', ['title' => __('strings.Main_Settings') ])

@section('content')

    <!--<div class="page-title">-->
    <!--    <h3>@lang('strings.Main_Settings')</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>-->
    <!--            <li class="active">@lang('strings.Main_Settings')</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">

                <div role="tabpanel" class="taps-set">

                    <div class="row">

                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 no-padd">

                            <!-- Tab panes -->
                            <div class="tab-content tap-up">
                                    <h3 class="title-tap">{{app()->getLocale() =='ar'? $property->name : $property->name_en}} </h3>
                                    <div class="pay_steps">
                                        <div class="container">

                                            <!-- chash --->
                                            <div class="card card_payment">
                                                <div class="card-header" id="headingTwo">
                                                    <div class="row">
                                                        <form class="form_payment_back" method="post" action="{{ url('admin/hotel/payment')}}" enctype="multipart/form-data" role="form">
                                                            {{csrf_field()}}
                                                             <input type="hidden" value="{{$property->id}}" name="property_id" >
                                                            <div class="col-md-4 col-xs-12">
                                                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                    <i class="fa fa-plus" aria-hidden="true"></i> {{__('strings.cash')}}
                                                                </button>
                                                            </div>
                                                            <div class="col-md-8 col-xs-12">
                                                                <div class="left_choose gateway-row">
                                                                    <div class="input-group ActiveButton">
                                                                        <input type="radio" name="cash_active" {{ \App\propertyPaymethod::where(['gateway' => 'cash', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('active') ==1  ? 'checked' : ''}} value="1"> {{__('strings.active')}}
                                                                    </div>
                                                                    <div class="input-group InActiveButton">
                                                                        <input type="radio" name="cash_active"  {{ \App\propertyPaymethod::where(['gateway' => 'cash', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('active') ==0  ? 'checked' : ''}} value="0"> {{__('strings.inactive')}}
                                                                    </div>
                                                                    <div class="input-group Default">
                                                                        <input type="radio" name="default" {{ \App\propertyPaymethod::where(['gateway' => 'cash', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('default') ==1  ? 'checked' : ''}} value="cash"> {{__('strings.default')}}
                                                                  </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="row" style="padding:5px;">
                                                            <div class="col-md-4 col-xs-12">
                                                                <div class="right_img">
                                                                    <img style="width:200px;" src="https://cdn1.iconfinder.com/data/icons/business-finance-1-1/128/buy-with-cash-512.png">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 col-xs-12">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- paypal --->

                                            <div class="card card_payment">
                                                <div class="card-header" id="headingTwo">
                                                    <div class="row">
                                                        <div class="col-md-4 col-xs-12">
                                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                                                <i class="fa fa-plus" aria-hidden="true"></i> {{__('strings.paypal_standard')}}
                                                            </button>
                                                        </div>
                                                        <div class="col-md-8 col-xs-12">
                                                            <div class="left_choose gateway-row">
                                                                <div class="input-group ActiveButton">
                                                                    <input type="radio" name="paypal_active" {{ \App\propertyPaymethod::where(['gateway' => 'paypal', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('active') ==1  ? 'checked' : ''}} value="1"> {{__('strings.active')}}
                                                                </div>
                                                                <div class="input-group InActiveButton">
                                                                    <input type="radio" name="paypal_active" {{ \App\propertyPaymethod::where(['gateway' => 'paypal', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('active') ==0  ? 'checked' : ''}} value="0"> {{__('strings.inactive')}}
                                                                </div>
                                                                <div class="input-group Default">
                                                                    <input type="radio" name="default" {{ \App\propertyPaymethod::where(['gateway' => 'paypal', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('default') ==1  ? 'checked' : ''}} value="paypal"> {{__('strings.default')}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="collapse3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="row" style="padding:5px;">
                                                            <div class="col-md-4 col-xs-12">
                                                                <div class="right_img">
                                                                    <img style="width:200px;" src="http://pngimg.com/uploads/paypal/paypal_PNG2.png" class="paypal">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 col-xs-12">

                                                                <div class="input-group">
                                                                    <label>{{__('strings.user_name')}}</label>
                                                                    <input type="text"  name="paypal_user_name" value="{{\App\propertyPaymethod::where(['gateway' => 'paypal', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('acc_name')}}">
                                                                </div>
                                                                <div class="input-group">
                                                                    <label>{{__('strings.signature')}}</label>
                                                                    <input type="text" name="paypal_signature"  value="{{\App\propertyPaymethod::where(['gateway' => 'paypal', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('acc_signature')}}">
                                                                </div>
                                                                <div class="input-group">
                                                                    <label>{{__('strings.password')}}</label>
                                                                    <input type="password" name="paypal_password" value="123456">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- stripe --->
                                            <div class="card card_payment">
                                                <div class="card-header" id="headingTwo">
                                                    <div class="row">
                                                        <div class="col-md-4 col-xs-12">
                                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                <i class="fa fa-plus" aria-hidden="true"></i>{{__('strings.stripe')}}
                                                            </button>
                                                        </div>
                                                        <div class="col-md-8 col-xs-12">
                                                            <div class="left_choose gateway-row">
                                                                <div class="input-group ActiveButton">
                                                                    <input type="radio" name="stripe_active" {{ \App\propertyPaymethod::where(['gateway' => 'stripe', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('active') ==1  ? 'checked' : ''}} value="1"> {{__('strings.active')}}
                                                                </div>
                                                                <div class="input-group InActiveButton">
                                                                    <input type="radio" name="stripe_active" {{ \App\propertyPaymethod::where(['gateway' => 'stripe', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('active') ==0  ? 'checked' : ''}} value="0"> {{__('strings.inactive')}}
                                                                </div>
                                                                <div class="input-group Default">
                                                                    <input type="radio" name="default" {{ \App\propertyPaymethod::where(['gateway' => 'stripe', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('default') ==1  ? 'checked' : ''}} value="stripe"> {{__('strings.default')}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="collapse4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="row"style="padding:5px;">
                                                            <div class="col-md-4 col-xs-12">
                                                                <div class="right_img">
                                                                    <img style="width:200px;" src="https://europeansting.files.wordpress.com/2016/02/stripe-logo.png" class="paypal">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 col-xs-12">

                                                                <div class="input-group">
                                                                    {{-- <button class="btn btn-connect">{{('strings.connect')}}</button> --}}
                                                                </div>
                                                                <div class="input-group">
                                                                    <label>{{__('strings.user_name')}}</label>
                                                                    <input type="text"  name="stripe_user_name" value="{{\App\propertyPaymethod::where(['gateway' => 'stripe', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('acc_name')}}">
                                                                </div>
                                                                <div class="input-group">
                                                                    <label>{{__('strings.password')}}</label>
                                                                    <input type="password" name="stripe_password"  value="123456">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- authorize --->
                                            <div class="card card_payment">
                                                <div class="card-header" id="headingTwo">
                                                    <div class="row" >
                                                        <div class="col-md-4 col-xs-12">
                                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                                                <i class="fa fa-plus" aria-hidden="true"></i> {{__('strings.authorize')}}
                                                            </button>
                                                        </div>
                                                        <div class="col-md-8 col-xs-12">
                                                            <div class="left_choose gateway-row">
                                                                <div class="input-group ActiveButton">
                                                                    <input type="radio" name="authorize_active" {{ \App\propertyPaymethod::where(['gateway' => 'authorize', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('active') ==1  ? 'checked' : ''}} value="1"> {{__('strings.active')}}
                                                                </div>
                                                                <div class="input-group InActiveButton">
                                                                    <input type="radio" name="authorize_active" {{ \App\propertyPaymethod::where(['gateway' => 'authorize', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('active') ==0  ? 'checked' : ''}} value="0"> {{__('strings.inactive')}}
                                                                </div>
                                                                <div class="input-group Default">
                                                                    <input type="radio" name="default" {{ \App\propertyPaymethod::where(['gateway' => 'authorize', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('default') ==1  ? 'checked' : ''}}  value="authorize"> {{__('strings.default')}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="collapse5" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="row" style="padding:5px;">
                                                            <div class="col-md-4 col-xs-12">
                                                                <div class="right_img">
                                                                    <img style="width:200px;" src="https://lifterlms.com/wp-content/uploads/2019/06/LifterLMS-Authorize.Net-Payment-Gateway.png" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 col-xs-12">

                                                                <div class="input-group">
                                                                    <label>{{__('strings.user_name')}}</label>
                                                                    <input type="text" name="authorize_user_name" value="{{\App\propertyPaymethod::where(['gateway' => 'authorize', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('acc_name')}}">
                                                                </div>
                                                                <div class="input-group">
                                                                    <label>{{__('strings.login_id')}}</label>
                                                                    <input type="password" name="authorize_login_id" name="{{\App\propertyPaymethod::where(['gateway' => 'authorize', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('acc_signature')}}">
                                                                </div>
                                                                <div class="input-group">
                                                                    <label>{{__('strings.transaction_key')}}</label>
                                                                    <input type="password" name="authorize_transaction_key" value="123456">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- google pay --->
                                            <div class="card card_payment">
                                                <div class="card-header" id="headingTwo">
                                                    <div class="row">
                                                        <div class="col-md-4 col-xs-12">
                                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                                                <i class="fa fa-plus" aria-hidden="true"></i> {{__('strings.google_pay')}}
                                                            </button>
                                                        </div>
                                                        <div class="col-md-8 col-xs-12">
                                                            <div class="left_choose gateway-row">
                                                                <div class="input-group ActiveButton">
                                                                    <input type="radio" name="google_active" {{ \App\propertyPaymethod::where(['gateway' => 'google', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('active') ==1  ? 'checked' : ''}} value="1"> {{__('strings.active')}}
                                                                </div>
                                                                <div class="input-group InActiveButton">
                                                                    <input type="radio" name="google_active" {{ \App\propertyPaymethod::where(['gateway' => 'google', 'org_id' => Auth::user()->org_id,'property_id'=>$property->id ])->value('active') ==0  ? 'checked' : ''}}  value="0"> {{__('strings.inactive')}}
                                                                </div>
                                                                <div class="input-group Default">
                                                                    <input type="radio" name="default" {{ \App\propertyPaymethod::where(['gateway' => 'google', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('default') ==1  ? 'checked' : ''}}  value="google"> {{__('strings.default')}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="collapse7" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div  class="row"style="padding:5px;">
                                                            <div class="col-md-4 col-xs-12">
                                                                <div class="right_img">
                                                                    <img style="width:200px;" src="http://factjo.com/AllNewImages/large/2018_07_12_12_20_21.jpg" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 col-xs-12">

                                                                <div class="input-group">
                                                                    <label>{{__('strings.user_name')}}</label>
                                                                    <input type="text" name="google_user_name" value="{{\App\propertyPaymethod::where(['gateway' => 'google', 'org_id' => Auth::user()->org_id ,'property_id'=>$property->id])->value('acc_name')}}">
                                                                </div>
                                                                <div class="input-group">
                                                                    <label>{{__('strings.login_id')}}</label>
                                                                    <input type="password" name="google_password" value="123456">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="btn btn-primary" type="submit" style="margin: 20px 0 0 0;"> <i class="fa fa-save"></i>{{__('strings.save')}} </button>
                                        </div>
                                    </div>
                                  </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       
      @endsection

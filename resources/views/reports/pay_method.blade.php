@extends('layouts.admin', ['title' =>__('strings.report_title_customer')])

@section('content')
<style>

        #search_form > div.col-md-12.form-group.text-right > div{
            float: left;
            font-size: 1.2em;
            font-weight: 600;
            color: red;
            display: none;
        }
    </style>

    <!--<div class="page-title">-->
    <!--    <h3>@lang('strings.report_title')</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>-->
    <!--            <li class="active">@lang('strings.report_title_customer')</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper" class="report2s">
      <div class="row">
            <div class="col-md-12">

				 <!-- <a href="{{ url('admin/detailsreport') }}" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('strings.detailed_reports')</a>
        <a href="{{ url('admin/searchreport') }}" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i> &nbsp;&nbsp;@lang('strings.total_reports')</a> -->

                    <div class="panel panel-white">

                        <div class="panel-body">

						 <form method="post" action="{{ url('admin/PayMethod_search') }}" enctype="multipart/form-data" id="search_form">
                            {{csrf_field()}}
							<div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                    <label>@lang('strings.Client_name')</label>
                                    <select class="form-control" name="search_customer" >
                                        <option value="" >@lang('strings.All')</option>

		@php
$customers=App\Customers::join('external_req', function ($join) { $join->on('customers.id', '=', 'external_req.cust_id')->where([ 'customers.org_id' => Auth::user()->org_id, 'active'=>1  ]); })->select('name','customers.id','name_en')->distinct()->get();
@endphp
		@foreach($customers as $customer)


                                      <option {{ app('request')->input('search_customer') == $customer->id ? 'selected' : ''}}  value="{{$customer->id}}">{{ app()->getLocale() == 'ar' ? $customer->name  : $customer->name_en  }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                                      <label>@lang('strings.external_req_delivRes')</label>
                                                      <select class="form-control" name="search_deliRes" >
                                                          <option value="" >@lang('strings.All')</option>

                  		@php
                  $users=App\User::join('external_req', function ($join) { $join->on('users.id', '=', 'external_req.emp_id')->where([ 'users.org_id' => Auth::user()->org_id, 'is_active'=>1  ]); })->select('name','users.id','name_en')->distinct()->get();
                  @endphp
                  		@foreach($users as $user)


                                                        <option {{ app('request')->input('search_user') == $user->emp_id ? 'selected' : ''}}  value="{{$user->id}}">{{ app()->getLocale() == 'ar' ? $user->name  : $user->name_en  }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>
                                                  <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                                                        <label>@lang('strings.external_req_reqNum')</label>
                                                                        <select class="form-control" name="search_number" >
                                                                            <option value="" >@lang('strings.All')</option>

                                        @php
                                    $request_numbers=App\externalReq::where(['org_id' => Auth::user()->org_id])->whereIn('confirm',array('x','yx'))->select('invoice_no','id')->get();
                                    @endphp
                                        @foreach($request_numbers as $request_number)


                                                                          <option {{ app('request')->input('search_number') == $request_number->invoice_no ? 'selected' : ''}}  value="{{$request_number->id}}"> {{  $request_number->invoice_no   }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                                                                          <label>@lang('strings.external_req_tel')</label>
                                                                                          <select class="form-control" name="search_phone" >
                                                                                              <option value="" >@lang('strings.All')</option>

                                                          @php
                                                      $phone_numbers=App\externalReq::join('customer_payments','external_req.id', '=', 'customer_payments.external_req_id')->join('customer_payment_details','customer_payment_details.customer_payid','=','customer_payments.id')->where([ 'external_req.org_id' => Auth::user()->org_id])->whereIn('confirm',array('x','yx'))->select('email','external_req.id','mobile')->distinct()->get();
                                                      @endphp
                                                          @foreach($phone_numbers as $phone_number)


                                                                                            <option {{ app('request')->input('search_phone') == $phone_number->mobile ? 'selected' : ''}}  value="{{$phone_number->mobile}}">{{  $phone_number->mobile   }}</option>
                                                                                              @endforeach
                                                                                          </select>
                                                                                      </div>
                                                                                      <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                                                                                            <label>@lang('strings.Email')</label>
                                                                                                            <select class="form-control" name="search_email" >
                                                                                                                <option value="" >@lang('strings.All')</option>

                                                                            @php
                                                                            $request_emails=App\externalReq::join('customer_payments','external_req.id', '=', 'customer_payments.external_req_id')->join('customer_payment_details','customer_payment_details.customer_payid','=','customer_payments.id')->where([ 'external_req.org_id' => Auth::user()->org_id])->whereIn('confirm',array('x','yx'))->select('email','external_req.id','mobile')->distinct()->get();
                                                                        @endphp
                                                                            @foreach($request_emails as $request_email)


                                                                                                              <option {{ app('request')->input('search_email') == $request_email->email ? 'selected' : ''}}  value="{{ $request_email->email }}">{{  $request_email->email   }}</option>
                                                                                                                @endforeach
                                                                                                            </select>
                                                                                                        </div>
                                                                                                        <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                                                                                                                     <label>@lang('strings.Status')</label>
                                                                                                                                     <select class="form-control" name="confirm">
                                                                                                                                        <option value="">@lang('strings.All')</option>
                                                                                                                                         <option value="yx">@lang('strings.confirmed2')</option>
                                                                                                                                         <option value="x">@lang('strings.not_confirmed')</option>
                                                                                                                                     </select>

                                                                                                                                 </div>


                                                                                                        @if(app()->getLocale() == 'ar')
                                                                                       						<div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">

                                                                                                                           <div class="input-group text">
                                                                                                                            <label>@lang('strings.payment_date_to')</label>
                                                                                                                           <input type="date" class="form-control" autocomplete="off" id="report_date_to" value="{{ app('request')->input('report_date_to') }}"  name="report_date_to" >
                                                                                                                           </div>
                                                                                                                      </div>

                                                                                       							<div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                                                                                                           <div class="input-group text">
                                                                                                                            <label>@lang('strings.payment_date_from')</label>
                                                                                                                           <input type="date"  class="form-control" autocomplete="off"  id="report_date_from" value="{{ app('request')->input('report_date_from') }}" name="report_date_from">
                                                                                                                           </div>
                                                                                                                      </div>

                                                                                       								 @else

                                                                                       									<div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                                                                                                           <div class="input-group text">
                                                                                                                            <label>@lang('strings.payment_date_to')</label>
                                                                                                                           <input type="date"  class="form-control datepicker" autocomplete="off"  id="report_date_from" value="{{ app('request')->input('report_date_from') }}"  name="report_date_from">
                                                                                                                           </div>
                                                                                                                      </div>

                                                                                                                     <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">

                                                                                                                           <div class="input-group text">
                                                                                                                            <label>@lang('strings.Demand_Date_too')</label>
                                                                                                                           <input type="date" class="form-control datepicker" autocomplete="off" id="report_date_to" value="{{ app('request')->input('report_date_to') }}" name="report_date_to" >
                                                                                                                           </div>
                                                                                                                      </div>

                                                                                       								@endif
				  <button id="search_button" type="submit" class="btn btn-primary btn-lg">@lang('strings.Search')</button>
			</form>
				</div>


	</br></br></br></br></br></br>

                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>@lang('strings.transactions_id')</th>
                                    <th>@lang('strings.Client_name')</th>
                                    <th>@lang('strings.external_req_tel')</th>
                                    <th>@lang('strings.Email')</th>
                                    <th>@lang('strings.Pay_date')</th>
                                    <th>@lang('strings.currency')</th>
                                    <th>@lang('strings.Payments_type')</th>
                                    <th>@lang('strings.total_request')</th>
                                    <th>@lang('strings.external_delivery_fees')</th>
                                    <th>@lang('strings.loginHistory_status')</th>
                                    <th>@lang('strings.external_req_recipient')</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($online_payed_requests as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
									                      <td>{{ app()->getLocale() == 'ar' ?   \App\Customers::find($value->cust_id)->name : \App\Customers::find($value->cust_id)->name_en }}</td>
                                        <td>{{ $value->mobile }}</td>
                                        <td>{{ $value->email  }}</td>
                                        <td>{{ $value->payment_date }}</td>
                                        <td>{{ app()->getLocale() == 'ar' ?    \App\Currency::find($value->currency_id)->name : \App\Currency::find($value->currency_id)->name_en }}</td>
                                        <td>{{ $value->pay_gateway }}</td>
                                        <td>{{ Decimalpoint($value->payment_tot) }}</td>
                                        <td>{{ $value->delivery_fees}}</td>
                                        @if($value->confirm == 'x')
                                        <td>@lang('strings.not_confirmed')</td>
                                        @elseif($value->confirm == 'yx')
                                        <td>@lang('strings.confirmed2')</td>
                                        @endif
                                        <td>{{ app()->getLocale() == 'ar' ?   \App\User::find($value->emp_id)->name : \App\User::find($value->emp_id)->name_en  }}</td>
                                    </tr>
                                @endforeach
									                 </tr>
                                </tbody>

                        </div>

                </div>
            </div>


@section('scripts')
<script src="https://unpkg.com/vue"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script>

<script>


        $('#search_button').click(function (e) {

            $check = validateDate();
            if($check !== true){
                $('#search_form > div.col-md-12.form-group.text-right > div').css({"display":"block"});
                e.preventDefault();
            }
        });

        function validateDate() {

            var report_date_from = document.getElementById('report_date_from').value;

            var report_date_to = document.getElementById('report_date_to').value;

            if(report_date_from === "" && report_date_to === ""){

                return true;

            }

             if(Date.parse(report_date_from) <= Date.parse(report_date_to)) {
                return true;
            }else{

                return false;
            }

        }

          var app = new Vue({
                el: '#app',
            });


    </script>







@endsection

@endsection

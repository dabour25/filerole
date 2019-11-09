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
    <!--            <li class="active">@lang('strings.report6')</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
      <div class="row">
            <div class="col-md-12">

				 <a href="{{ url('admin/reportsbankdetails') }}" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('strings.detailed_reports')</a>
                  <a href="{{ url('admin/ReportsCashSearchBank') }}" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i> &nbsp;&nbsp;@lang('strings.total_reports')</a>

                    <div class="panel panel-white">

                        <div class="panel-body">

						 <form method="post" action="{{ url('admin/reportsbankdetails') }}" enctype="multipart/form-data" id="search_form">
                            {{csrf_field()}}
							<div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                    <label>@lang('strings.choose_bank_name')</label>
                                    <select class="form-control js-select" name="bank_name" >
                                        <option value="-1" >@lang('strings.All')</option>

		@php

$banks2=App\Banking::where([ 'bank_treasur.org_id' => Auth::user()->org_id, 'active'=>1 ]); })->select('name','id','name_en')->get();
@endphp

		@foreach($banks2 as $role)


                         <option value="{{$role->id}}">{{ app()->getLocale() == 'ar' ? $role->name  : $role->name_en  }}</option>
						 <option value="0">@lang('strings.credit_card')</option>
                                        @endforeach
                                    </select>
                                </div>



								 @if(app()->getLocale() == 'ar')
						<div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">

                                    <div class="input-group text">
                                     <label>@lang('strings.payment_date_to')</label>
                                    <input type="date" class="form-control " autocomplete="off" id="report_date_to" value="{{ app('request')->input('report_date_to') }}" name="report_date_to" >
                                    </div>
                               </div>

							<div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                    <div class="input-group text">
                                     <label>@lang('strings.payment_date_from')</label>
                                    <input type="date"  class="form-control " autocomplete="off"  value="{{ app('request')->input('report_date_from') }}"   id="report_date_from" name="report_date_from">
                                    </div>
                               </div>

								 @else

									<div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                    <div class="input-group text">
                                     <label>@lang('strings.payment_date_to')</label>
                                    <input type="date"  class="form-control " autocomplete="off" value="{{ app('request')->input('report_date_from') }}"  id="report_date_from" name="report_date_from">
                                    </div>
                               </div>

                              <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">

                                    <div class="input-group text">
                                     <label>@lang('strings.Demand_Date_too')</label>
                                    <input type="date" class="form-control " autocomplete="off" id="report_date_to" value="{{ app('request')->input('report_date_to') }}"  name="report_date_to" >
                                    </div>
                               </div>




								@endif




					<div class="col-md-12 form-group text-right">
					<div class="date_error">

                          @lang('strings.Message_date')
					</div>
                        </div>





				  <button id="search_button" type="submit" class="btn btn-primary btn-lg">@lang('strings.Search')</button>
			</form>
			</div>
			</div>


	</br></br></br></br></br></br>
	<div id="app">
	   {!! $chart->container() !!}
	  </div>

	  @php
	if(app('request')->input('bank_name') && app('request')->input('bank_name')!=-1 ){
	$banks = App\PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'bank_treasur_id' => app('request')->input('bank_name')])->groupby('bank_treasur_id')->get();

	}elseif(app('request')->input('bank_name')&& app('request')->input('bank_name')==0){
	$banks = App\PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'bank_treasur_id' => app('request')->input('bank_name')])->groupby('bank_treasur_id')->get();

	}elseif(empty(app('request')->input('report_date_from')) && empty(app('request')->input('report_date_to'))){
	  $banks = App\PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'pay_date' =>date('Y-m-d') ])->groupby('bank_treasur_id')->get();

	   }else 	$banks = App\PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->groupby('bank_treasur_id')->get();
	  @endphp


	  @foreach($banks as $bank)
	   <div class="panel-heading clearfix">

	  @if($bank->bank_treasur_id==0)
	{{ app()->getLocale() == 'ar' ? 'كرديت كارد' :  'credit card' }}
  @else
{{ app()->getLocale() == 'ar' ? ($bank->bank_treasur_id != '' ? App\Banking::findOrFail($bank->bank_treasur_id)->name : '')  :  ($bank->bank_treasur_id != '' ? App\Banking::findOrFail($bank->bank_treasur_id)->name_en : '') }}

	   @endif

	  </div>
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                     <th>@lang('strings.Pay_date')</th>
                                     <th>@lang('strings.total_pay')</th>
                      	             <th>@lang('strings.Description')</th>
 								                     <th>@lang('strings.customer_supplier')</th>
								                     <th>@lang('strings.invoice_number_request')</th>
                                </tr>
                                </thead>
                                <tbody>
								@php
						$total_requets=0;
	          $requets_amount=0;
		$date_from = date('Y-m-d', strtotime(app('request')->input('report_date_from')));
        $date_to = date('Y-m-d', strtotime(app('request')->input('report_date_to')));
	 $requests=App\PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->get();

		if(empty(app('request')->input('report_date_from')) && empty(app('request')->input('report_date_to'))){
		if(app('request')->input('bank_name') && app('request')->input('bank_name')!=-1 ){
	$requests =App\PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'bank_treasur_id'=>app('request')->input('bank_name')  ])->get();
		}elseif(app('request')->input('bank_name') && app('request')->input('bank_name')==0){
	$requests =App\PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'bank_treasur_id'=>app('request')->input('bank_name')  ])->get();
		}else
   $requests=App\PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'pay_date'=>date('Y-m-d') ])->get();



 }elseif(!empty(app('request')->input('report_date_to')) && !empty(app('request')->input('report_date_from'))){

		if(app('request')->input('bank_name') && app('request')->input('bank_name')!=-1 ){
$requests = App\PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'bank_treasur_id'=>app('request')->input('bank_name')])->where('pay_date','>=',$date_from)->where('pay_date','<=',$date_to)->get();
		}elseif(app('request')->input('bank_name') && app('request')->input('bank_name')==0)
	$requests = App\PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'bank_treasur_id'=>app('request')->input('bank_name')])->where('pay_date','>=',$date_from)->where('pay_date','<=',$date_to)->get();
		else{
$requests = App\PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id])->where('pay_date','>=',$date_from)->where('pay_date','<=',$date_to)->get();
		   }
	}    elseif(!empty(app('request')->input(report_date_from)) &&empty(app('request')->input(report_date_to))) {
		if(app('request')->input('bank_name')|| app('request')->input('bank_name')==0){
	$requests = App\PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'bank_treasur_id'=>app('request')->input('bank_name')  ])->where('pay_date','>=',$date_from)->get();


		}
		else{
$requests=App\PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->where('pay_date','>=',$date_from)->get();

		 }
		   }elseif (empty(app('request')->input('report_date_from')) && !empty(app('request')->input('report_date_to'))) {
		if(app('request')->input('bank_name') ||app('request')->input('bank_name')==0 ){
	$requests = App\PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id,'bank_treasur_id'=>app('request')->input('bank_name')  ])->where('pay_date','>=',$date_to)->get();

		}
		else{
	$requests=App\PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->where('pay_date','<=',$date_to)->get();
		  }


        }
	    else{  $requests =App\PermissionReceivingPayments::where(['org_id' => Auth::user()->org_id ])->get();
		}

			@endphp
						@foreach($requests->where('bank_treasur_id','=',$bank->bank_treasur_id) as $payment)
						 @php

					$requets_amount =$payment->pay_amount*$payment->pay_flag;
					$total_requets +=$requets_amount;

		if($payment->supplier_id){
$number=$payment->supp_invoice_no;
$name=app()->getLocale() == 'ar' ? ($payment->supplier_id != '' ? App\Suppliers::findOrFail($payment->supplier_id)->name : '')  :  ($payment->supplier_id != '' ? App\Suppliers::findOrFail($payment->supplier_id)->name_en : '');


		}else{
$name=app()->getLocale() == 'ar' ? ($payment->customer_id != '' ? App\Customers::findOrFail($payment->customer_id)->name : '')  :  ($payment->customer_id != '' ? App\Customers::findOrFail($payment->customer_id)->name_en : '');

			$number=$payment->customer_req_id;
		}
@endphp
							<tr>
						   <td>{{  Dateformat($payment->pay_date)}}</td>
							 <td>{{ Decimalplace(abs( $requets_amount)) }}</td>
							 <td>{{ $payment->description }}</td>
							 <td>{{$name }}</td>
							 <td>{{$number }}</td>
							  </tr>

                                @endforeach

									</tr>

                                </tbody>

								                       <tfoot>
                                        <tr>
                                            <td>{{ __('strings.Total') }}</td>
                                            <td></td>
                                            <td></td>
										                       	<td></td>
                                            <td>{{ Decimalplace($total_requets)}}</td>
                                            <td></td>
                                        </tr>
                                        </tfoot>
                            </table>
					         	@endforeach
                    @foreach($allbanks as $value)
                    @if($bank->test==0)
                    <div class="panel-heading clearfix">
                {{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}
   @php
   $total_extrnal=0;
   @endphp

                   </div>
                    <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                        <thead>
                        <tr>
                             <th>@lang('strings.Pay_date')</th>
                             <th>@lang('strings.total_pay')</th>
                             <th>@lang('strings.customer_supplier')</th>
                             <th>@lang('strings.invoice_number_request')</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($value->deails as $value->deail)
                        @php
                        $total_extrnal +=$value->deail->extra_paid;
                        @endphp
                          <tr>
            						   <td>{{Dateformat($value->deail->request_dt)}}</td>
            							 <td>{{abs($value->deail->extra_paid)}}</td>
                           <td>{{app()->getLocale() == 'ar' ? ($value->deail->cust_id != '' ? App\Customers::findOrFail($value->deail->cust_id)->name : '')  :  ($value->deail->cust_id != '' ? App\Customers::findOrFail($value->deail->cust_id)->name_en : '')}}</td>
            							 <td>{{$value->deail->invoice_no}}</td>
            							  </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                         <tr>
                             <td>{{ __('strings.Total') }}</td>
                             <td>{{abs(Decimalplace($total_extrnal)) }}</td>
                             <td></td>
                             <td></td>


                         </tr>
                         </tfoot>

                      </table>
                      @endif
                     	@endforeach




                        </div>

                </div>
            </div>


@section('scripts')
<script src="https://unpkg.com/vue"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script>
 {!! $chart->script() !!}
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

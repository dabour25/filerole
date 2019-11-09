@extends('layouts.admin', ['title' => __('strings.report_title_user')])

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
    <!--            <li class="active">@lang('strings.report_title_user')</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
      <div class="row">
            <div class="col-md-12">

               <a href="{{ url('admin/userdetails') }}" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('strings.detailed_reports')</a>
                <a href="{{ url('admin/searchreportuser') }}" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i> &nbsp;&nbsp;@lang('strings.total_reports')</a>

                    <div class="panel panel-white">

                        <div class="panel-body">

						 <form method="post" action="{{ url('admin/userdetails') }}" enctype="multipart/form-data" id="search_form">
                            {{csrf_field()}}
							<div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                    <label> @lang('strings.employee_name') </label>
                                    <select class="form-control js-select" name="search_name">
                                        <option value="0">@lang('strings.All')</option>

		@php

$users=App\User::join('customer_req_head', function ($join) { $join->on('users.id', '=', 'customer_req_head.invoice_user')->where([ 'users.org_id' => Auth::user()->org_id, 'is_active'=>1  ]); })->select('name','users.id','name_en')->distinct()->get();
@endphp

		@foreach($users as $role)


                                      <option {{ app('request')->input('search_name') == $role->id ? 'selected' : ''}} value="{{$role->id}}">{{ app()->getLocale() == 'ar' ? $role->name  : $role->name_en  }}</option>
                                        @endforeach
                                    </select>
                                </div>

						@if(app()->getLocale() == 'ar')
						<div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">

                                    <div class="input-group text">
                                     <label>@lang('strings.Invoice_Date_too')</label>
                                    <input type="date" class="form-control datepicker" autocomplete="off" id="report_date_to"  value="{{ app('request')->input('report_date_to') }}" name="report_date_to" >
                                    </div>
                               </div>

							<div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                    <div class="input-group text">
                                     <label>@lang('strings.Invoice_Date_from')</label>
                                    <input type="date"  class="form-control datepicker" autocomplete="off"  id="report_date_from"value="{{ app('request')->input('report_date_from') }}"  name="report_date_from">
                                    </div>
                               </div>

								 @else

									<div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                    <div class="input-group text">
                                     <label>@lang('strings.Invoice_Date_from')</label>
                                    <input type="date"  class="form-control datepicker" autocomplete="off"  id="report_date_from"value="{{ app('request')->input('report_date_from') }}"  name="report_date_from">
                                    </div>
                               </div>

                              <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">

                                    <div class="input-group text">
                                     <label>@lang('strings.Invoice_Date_too')</label>
                                    <input type="date" class="form-control datepicker" autocomplete="off" id="report_date_to"  value="{{ app('request')->input('report_date_to') }}" name="report_date_to" >
                                    </div>
                               </div>




								@endif


					<div class="col-md-12 form-group text-right">
					<div class="date_error">
                          @lang('strings.Message_date')
					</div>
                        </div>
				   <button  id="search_button" type="submit" class="btn btn-primary btn-lg">@lang('strings.Search')</button>
			</form>


	</br></br> </br> </br>
	</br></br> </br> </br>
	 <div id="app">
	   {!! $chart->container() !!}
	  </div>
	@php

	if(!empty(app('request')->input('search_name')) && app('request')->input('search_name') != 0 ){
		$users = App\User::where(['is_active' => 1,'org_id' => Auth::user()->org_id,'id' => app('request')->input('search_name')])->get();

	}
	else{
		$users = App\User::where(['is_active' => 1,'org_id' => Auth::user()->org_id])->get();

	}
	@endphp
	@foreach($users as $value)
	@php

	if(app('request')->input('report_date_to')&& app('request')->input('report_date_from') ){
		$head = App\CustomerHead::where(['invoice_user'   => $value->id ])->whereDate('invoice_date','>=',app('request')->input('report_date_from'))->whereDate('invoice_date','<=',app('request')->input('report_date_to')) ->get();



	}elseif(app('request')->input('report_date_to') ){
		$head = App\CustomerHead::where(['invoice_user'   => $value->id ])->whereDate('invoice_date','<=',app('request')->input('report_date_to')) ->get();



	}elseif(app('request')->input('report_date_from') ){
		$head = App\CustomerHead::where(['invoice_user'   => $value->id ])->whereDate('invoice_date','>=',app('request')->input('report_date_from')) ->get();



	}elseif(app('request')->input('search_name') ){
		$head = App\CustomerHead::where(['invoice_user'   => $value->id ])->get();



	}

	else{



		$head = App\CustomerHead::where(['invoice_user' => $value->id  ])->whereDate('invoice_date', date('Y-m-d'))->get();

	}


	@endphp
	@if(count($head) != 0)

	<div class="table-responsive">
	  <div class="panel-heading clearfix">
	 {{ app()->getLocale() == 'ar' ? $value->name  : $value->name_en }}
	  </div>

	<table id="xtreme-table"  class="display table" style="width: 100%; cellspacing: 0;">


		<thead>
			<tr>

				<th>@lang('strings.transactions_id')</th>
				<th>@lang('strings.Client_name')</th>
				<th>@lang('strings.invoice_id')</th>
				<th>@lang('strings.invoice_date')</th>
				<th>@lang('strings.total_request')</th>
				<th>@lang('strings.request_payment')</th>
				 <th>@lang('strings.Total_remaining')</th>
				<th>@lang('strings.Status')</th>
			</tr>
		</thead>

		<tbody>
		    @php
		    $total_paid=0;
		    $total_requets=0;
			$total_reminig=0;
			@endphp
			@foreach($head as $v1)



			<tr>
			    @php
			     $requests = 0;
					foreach(App\Transactions::where('cust_req_id', $v1->id)->get() as $request){
						$requests += ($request->price * $request->quantity * $request->req_flag);



					}


				$total_requets +=$requests;
				$total_reminig += (abs($requests) - abs(( App\PermissionReceivingPayments::where([ 'customer_req_id' => $v1->id])->sum('pay_amount', '*', 'pay_flag'))));
				$total_paid += abs(Decimalplace( App\PermissionReceivingPayments::where([ 'customer_req_id' => $v1->id])->sum('pay_amount', '*', 'pay_flag')));
				@endphp



				<td>{{ $v1->id }}</td>
				<td>{{ app()->getLocale() == 'ar' ? ($v1->cust_id != '' ? App\Customers::findOrFail($v1->cust_id)->name : '') : ($v1->cust_id != '' ? App\Customers::findOrFail($v1->cust_id)->name_en : '') }}</td>
				<td>{{ $v1->invoice_no}} </td>
				<td>{{Dateformat(date('Y-m-d', strtotime( ($v1->invoice_date )))) }}</td>
				</td>

				<td>{{ Decimalplace(abs($requests)) }}</td>

				<td>{{abs(Decimalplace( App\PermissionReceivingPayments::where([ 'customer_req_id' => $v1->id])->sum('pay_amount', '*', 'pay_flag'))) }} </td>
				<td>{{ Decimalplace(abs($requests)  - abs(( App\PermissionReceivingPayments::where([ 'customer_req_id' => $v1->id])->sum('pay_amount', '*', 'pay_flag'))))}}</td>

				<td>
				@php
				$status=Decimalplace( abs($requests) - abs(Decimalplace( App\PermissionReceivingPayments::where([ 'customer_req_id' => $v1->id])->sum('pay_amount', '*', 'pay_flag'))));

				@endphp

               @if(abs(Decimalplace( App\PermissionReceivingPayments::where([ 'customer_req_id' => $v1->id])->sum('pay_amount', '*', 'pay_flag')))==0)  <span class="label label-danger" style="font-size:12px;">@lang('strings.transactions_status_3')</span>
               @elseif($status==0) <span class="label label-success" style="font-size:12px;">@lang('strings.transactions_status_1')</span>
               @elseif($status<0) <span class="label label-warning" style="font-size:12px;"> @lang('strings.transactions_status_2')</span>
               @elseif($status>0) <span class="label label-info"style="font-size:12px;"> @lang('strings.transactions_status_4')</span> @endif





				</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
                                        <tr>
                                            <td>{{ __('strings.Total') }}</td>
                                            <td></td>
                                            <td></td>
											<td></td>
                                            <td>{{ Decimalplace(abs($total_requets))}}</td>
                                            <td>{{ Decimalplace($total_paid) }}</td>
                                            <td>{{Decimalplace ($total_reminig) }}</td>
                                            <td></td>
                                        </tr>
                                        </tfoot>


    </table>
	</div>
	@endif
	@endforeach








                        </div>
                    </div>
                </div>

        </div>
    </div>


@section('scripts')
<script src="https://unpkg.com/vue"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script>
 {!! $chart->script() !!}







@endsection
@endsection

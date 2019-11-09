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

						 <form method="post" action="{{ url('admin/ReportsCashSearchBank') }}" enctype="multipart/form-data" id="search_form">
                            {{csrf_field()}}


							<div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                    <label>@lang('strings.Name')</label>
                                    <select class="form-control js-select" name="bank_name" >
                                        <option value="-1" >@lang('strings.All')</option>

		@php

$all_banks=App\Banking::where([ 'org_id' => Auth::user()->org_id, 'active'=>1 ])->select('name','id','name_en')->get();
@endphp

		@foreach($all_banks as $bank)



				<option  {{ app('request')->input('bank_name') == $bank->id ? 'selected' : ''}}  value="{{$bank->id}}">{{ app()->getLocale() == 'ar' ? $bank->name  : $bank->name_en  }}</option>
								  <option value="0">@lang('strings.credit_card')</option>
                                        @endforeach
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
                                     <label>@lang('strings.payment_date_from')</label>
                                    <input type="date"  class="form-control" autocomplete="off"  id="report_date_from" value="{{ app('request')->input('report_date_from') }}" name="report_date_from">
                                    </div>
                               </div>

                              <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">

                                    <div class="input-group text">
                                     <label>@lang('strings.payment_date_to')</label>
                                    <input type="date" class="form-control" autocomplete="off" id="report_date_to" value="{{ app('request')->input('report_date_to') }}"  name="report_date_to" >
                                    </div>
                               </div>




								@endif




					<div class="col-md-12 form-group text-right">
					<div class="date_error">

                          @lang('strings.Message_date')
					</div>
                        </div>




                            </div>
				  <button id="search_button" type="submit" class="btn btn-primary btn-lg">@lang('strings.Search')</button>
			</form>
				</div>


	</br></br></br></br></br></br>
	<div id="app">
	   {!! $chart->container() !!}
	  </div>
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>@lang('strings.Name')</th>
                                    <th>@lang('strings.total_pay')</th>
                                </tr>
                                </thead>
                             @foreach($payments as $payment)
                             @php
                             $banks_id=	$payment->bank_treasur_id;
                             if($banks_id ==0)
                             $name= app()->getLocale() == 'ar' ? 'كرديت كارد'   :  'credit card';
                             else $name=app()->getLocale() == 'ar' ? ($payment->bank_treasur_id != '' ? App\Banking::findOrFail($payment->bank_treasur_id)->name : '')  :  ($payment->bank_treasur_id != '' ? App\Banking::findOrFail($payment->bank_treasur_id)->name_en : '');
                             @endphp
                            <tbody>
                            <tr>
                            <td>{{ $name }}</td>
							              <td>{{ Decimalplace($payment->request) }}</td>
							              </tr>
                            @endforeach
                          </tbody>
                            </table>
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>@lang('strings.Name')</th>
                                    <th>@lang('strings.total_pay')</th>
                                </tr>
                                </thead>
                             @foreach($banks as $value)
                            <tbody>
                          @if($value->has_external == 1)
                            <tr>
                            <td>{{app()->getLocale() == 'ar' ? $value->name  :  $value->name_en }}</td>
                            <td>{{ abs(Decimalplace($value->extra_paid)) }}</td>
                            </tr>
                           @endif
                            @endforeach
                          </tbody>
                            </table>




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

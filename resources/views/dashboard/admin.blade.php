@extends('layouts.admin', ['title' => __('strings.dashboard')])

@section('styles')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <style>
        .circular--square {
            border-top-left-radius: 50% 50%;
            border-top-right-radius: 50% 50%;
            border-bottom-right-radius: 50% 50%;
            border-bottom-left-radius: 50% 50%;
            width: 70px;
            height: 70px;
        }
    </style>
    <div id="main-wrapper" class="main-wrapper-index">
        <div class="content-dash">
            <div class="row">
                @if(App\Activities::where('id', App\Org::where('id', Auth::user()->org_id)->value('activity_id'))->value('dashboard_type') == 'Basic')
                <!--  chart by date -->
                <div class="col-sm-6 col-md-3 col-lg-3 col-xs-6 card_col">
                    <div class="card card0">
                        <div class="card-header card-header-inverse card-header-primary small font-weight-bold text-xs-center">
                            @lang('strings.this_year')
                        </div>
                        <div class="card-block text-xs-center">
                            @php
                                $year = 0; $delivery_fees = 0;
                                foreach (App\CustomerHead::where(['org_id' => Auth::user()->org_id])->whereYear('date', date('Y'))->with('transactions')->whereNotNull('cust_id')->get() as $value) {
                                    foreach ($value->transactions as $key => $v) {
                                        $year += $v->price = $v->price * $v->quantity * $v->req_flag;
                                    }
                                }
                                foreach(App\externalReq::where(['org_id' => Auth::user()->org_id])->whereIn('confirm', ['d', 'x', 'yx', 'y'])->whereYear('request_dt', date('Y'))->get() as $v2){
                                    $delivery_fees += $v2->delivery_fees; 
                                    foreach(App\externalTrans::where([ 'external_req_id' => $v2->id, 'org_id' => Auth::user()->org_id])->get() as $v3){
                                        $year += $v3->quantity * $v3->final_price  * $v3->reg_flag;
                                    }
                                }
                                $currency = app()->getLocale() == 'ar' ? App\Currency::findOrFail(App\org::where('id', Auth::user()->org_id)->value('currency'))->name : App\Currency::findOrFail(App\org::where('id', Auth::user()->org_id)->value('currency'))->name_en;
                            @endphp
                            <h3 class="home-card-number"><span class="animate-number">{{ abs($year) + $delivery_fees }}</span>
                                <small>{{ $currency }} &rlm;</small>
                            </h3>
                        </div>
                        <div class="card-block p-y-0 p-x-2 b-t-1 small">
                            <div class="row">
                                <div class="col-xs-12 p-y-1 text-xs-center">
                                    <a href="#">
                                        <div class="font-weight-bold"
                                             style=";text-align:right;direction:rtl">{{ App\CustomerHead::where(['org_id' => Auth::user()->org_id])->whereYear('date', date('Y'))->whereNotNull('cust_id')->count() + App\externalReq::where(['org_id' => Auth::user()->org_id])->whereIn('confirm', ['d', 'x', 'yx', 'y'])->whereYear('request_dt', date('Y'))->count() }}</div>
                                        <div class="text-muted" style=";text-align:right;direction:rtl">
                                            <small>@lang('strings.invoice')</small>
                                        </div>
                                    </a>
                                </div>
                                {{--<div class="col-xs-6 p-y-1 text-xs-right">--}}
                                {{--<div class="font-weight-bold">100 %</div>--}}
                                {{--<div class="text-muted"><small><i class="fa fa-arrow-up"></i></small></div>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xs-6 card_col">
                    <div class="card card1" id="this_month">
                        <div class="card-header card-header-inverse card-header-primary small font-weight-bold text-xs-center">
                            @lang('strings.this_month')
                        </div>
                        <div class="card-block text-xs-center">
                            @php
                                $month = 0; $delivery_fees = 0;
                                foreach (App\CustomerHead::where(['org_id' => Auth::user()->org_id])->whereYear('date', date('Y'))->whereMonth('date', date('m'))->with('transactions')->whereNotNull('cust_id')->get() as $value) {
                                    foreach ($value->transactions as $key => $v) {
                                        $month += $v->price = $v->price * $v->quantity * $v->req_flag;
                                    }
                                }
                                foreach(App\externalReq::where(['org_id' => Auth::user()->org_id])->whereIn('confirm', ['d', 'x', 'yx', 'y'])->whereYear('request_dt', date('Y'))->whereMonth('request_dt', date('m'))->get() as $v2){
                                    $delivery_fees += $v2->delivery_fees;
                                    foreach(App\externalTrans::where([ 'external_req_id' => $v2->id, 'org_id' => Auth::user()->org_id])->get() as $v3){
                                        $month += $v3->quantity * $v3->final_price  * $v3->reg_flag;
                                    }
                                }
                            @endphp
                            <h3 class="home-card-number"><span class="animate-number">{{ abs($month)  + $delivery_fees }}</span>
                                <small>{{ $currency }} &rlm;</small>
                            </h3>
                        </div>
                        <div class="card-block p-y-0 p-x-2 b-t-1 small">
                            <div class="row">
                                <div class="col-xs-12 p-y-1 text-xs-center">
                                    <a href="#">
                                        <div class="font-weight-bold"
                                             style=";text-align:right;direction:rtl">{{ App\CustomerHead::where(['org_id' => Auth::user()->org_id])->whereMonth('date', date('m'))->whereNotNull('cust_id')->count() + App\externalReq::where(['org_id' => Auth::user()->org_id])->whereIn('confirm', ['d', 'x', 'yx', 'y'])->whereMonth('request_dt', date('m'))->count() }}</div>
                                        <div class="text-muted" style=";text-align:right;direction:rtl">
                                            <small>@lang('strings.invoice')</small>
                                        </div>
                                    </a>
                                </div>
                                {{--<div class="col-xs-6 p-y-1 text-xs-right">--}}
                                {{--<div class="font-weight-bold">100 %</div>--}}
                                {{--<div class="text-muted"><small><i class="fa fa-arrow-up"></i></small></div>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xs-6 card_col">
                    <div class="card card2" id="today">
                        <div class="card-header card-header-inverse card-header-primary small font-weight-bold text-xs-center">
                            @lang('strings.this_day')
                        </div>
                        <div class="card-block text-xs-center">
                            @php
                                $day = 0; $delivery_fees = 0;
                                foreach (App\CustomerHead::where(['org_id' => Auth::user()->org_id])->whereDate('date', date('Y-m-d'))->with('transactions')->whereNotNull('cust_id')->get() as $value) {
                                    foreach ($value->transactions as $key => $v) {
                                        $day += $v->price = $v->price * $v->quantity * $v->req_flag;
                                    }
                                }
                                foreach(App\externalReq::where(['org_id' => Auth::user()->org_id])->whereIn('confirm', ['d', 'x', 'yx', 'y'])->whereDate('request_dt', date('Y-m-d'))->get() as $v2){
                                    $delivery_fees += $v2->delivery_fees;
                                    foreach(App\externalTrans::where([ 'external_req_id' => $v2->id, 'org_id' => Auth::user()->org_id])->get() as $v3){
                                        $day += $v3->quantity * $v3->final_price  * $v3->reg_flag;
                                    }
                                }
                            @endphp
                            <h3 class="home-card-number"><span class="animate-number">{{ abs($day) + $delivery_fees }}</span>
                                <small>{{ $currency }} &rlm;</small>
                            </h3>
                        </div>
                        <div class="card-block p-y-0 p-x-2 b-t-1 small">
                            <div class="row">
                                <div class="col-xs-12 p-y-1 text-xs-center">
                                    <a href="#">
                                        <div class="font-weight-bold"
                                             style=";text-align:right;direction:rtl">{{ App\CustomerHead::where(['org_id' => Auth::user()->org_id])->whereDay('date', date('d'))->whereNotNull('cust_id')->count() + App\externalReq::where(['org_id' => Auth::user()->org_id])->whereIn('confirm', ['d', 'x', 'yx', 'y'])->whereDay('request_dt', date('d'))->count() }}</div>
                                        <div class="text-muted" style=";text-align:right;direction:rtl">
                                            <small>@lang('strings.invoice')</small>
                                        </div>
                                    </a>
                                </div>
                                {{--<div class="col-xs-6 p-y-1 text-xs-right">--}}
                                {{--<div class="font-weight-bold">100 %</div>--}}
                                {{--<div class="text-muted"><small><i class="fa fa-arrow-up"></i></small></div>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xs-6 card_col">
                    <div class="card card3" id="sum">
                        <div class="card-header card-header-inverse card-header-success small font-weight-bold text-xs-center">
                            @lang('strings.sum_bills')
                        </div>
                        <div class="card-block text-xs-center">
                            @php
                                $paid_bills_count = App\CustomerHead::where(['org_id' => Auth::user()->org_id, 'invoice_status' => 1])->whereNotNull('cust_id')->get();
                                $paid_bills_total = 0; $delivery_fees = 0;
                                foreach ($paid_bills_count as $v0){
                                    foreach ($v0->transactions as $key => $v) {
                                        $paid_bills_total += $v->price = $v->price * $v->quantity * $v->req_flag;
                                    }
                                }
                                foreach(App\externalReq::where(['org_id' => Auth::user()->org_id])->whereIn('confirm', ['d', 'x', 'yx'])->get() as $v2){
                                    $delivery_fees += $v2->delivery_fees;
                                    foreach(App\externalTrans::where([ 'external_req_id' => $v2->id, 'org_id' => Auth::user()->org_id])->get() as $v3){
                                        $paid_bills_total += $v3->quantity * $v3->final_price  * $v3->reg_flag;
                                    }
                                }
                            @endphp
                            <h3 class="home-card-number"><span
                                        class="animate-number">{{ abs($paid_bills_total) + $delivery_fees }}</span>
                                <small>{{ $currency }} &rlm;</small>
                            </h3>
                        </div>
                        <div class="card-block p-y-0 p-x-2 b-t-1 small">
                            <div class="row">
                                <div class="col-xs-12 p-y-1 text-xs-center">
                                    <a href="#">
                                        <div class="font-weight-bold"
                                             style=";text-align:right;direction:rtl"> {{ count($paid_bills_count) + App\externalReq::where(['org_id' => Auth::user()->org_id])->whereIn('confirm', ['d', 'x', 'yx'])->count() }} </div>
                                        <div class="text-muted" style=";text-align:right;direction:rtl">
                                            <small>@lang('strings.invoice')</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xs-6 card_col">
                    <div class="card card4" id="unsum">
                        <div class="card-header card-header-inverse card-header-warning small font-weight-bold text-xs-center">
                            @lang('strings.unsum_bills')
                        </div>
                        <div class="card-block text-xs-center">
                            @php
                                $unpaid_bills_count = App\CustomerHead::where(['org_id' => Auth::user()->org_id, 'invoice_status' => 0])->whereNotNull('cust_id')->get();
                                $unpaid_bills_total = 0; $delivery_fees = 0;
                                foreach ($unpaid_bills_count as $v0){
                                    foreach ($v0->transactions as $key => $v) {
                                        $unpaid_bills_total += $v->price = $v->price * $v->quantity * $v->req_flag;
                                    }
                                }
                                
                                foreach(App\externalReq::where(['org_id' => Auth::user()->org_id, 'confirm' => 'y'])->get() as $v2){
                                    $delivery_fees += $v2->delivery_fees;
                                    foreach(App\externalTrans::where([ 'external_req_id' => $v2->id, 'org_id' => Auth::user()->org_id])->get() as $v3){
                                        $unpaid_bills_total += $v3->quantity * $v3->final_price * $v3->reg_flag;
                                    }
                                }

                            @endphp
                            <h3 class="home-card-number"><span
                                        class="animate-number">{{ abs($unpaid_bills_total)  + $delivery_fees }}</span>
                                <small>{{ $currency }} &rlm;</small>
                            </h3>
                        </div>
                        <div class="card-block p-y-0 p-x-2 b-t-1 small">
                            <div class="row">
                                <div class="col-xs-12 p-y-1 text-xs-center">
                                    <a href="#">
                                        <div class="font-weight-bold"
                                             style=";text-align:right;direction:rtl">{{ count($unpaid_bills_count) + App\externalReq::where(['org_id' => Auth::user()->org_id, 'confirm' => 'y'])->count() }}</div>
                                        <div class="text-muted" style=";text-align:right;direction:rtl">
                                            <small>@lang('strings.invoice')</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xs-6 card_col">
                    <div class="card card5" id="overdue">
                        <div class="card-header card-header-inverse card-header-danger small font-weight-bold text-xs-center">
                            @lang('strings.late_bills')
                        </div>
                        <div class="card-block text-xs-center">
                            @php
                                $late_bills_count = App\CustomerHead::where(['org_id' => Auth::user()->org_id, 'invoice_status' => 4])->whereNotNull('cust_id')->get();
                                $late_bills_total = 0;
                                foreach ($late_bills_count as $v0){
                                    foreach ($v0->transactions as $key => $v) {
                                        $late_bills_total += $v->price = $v->price * $v->quantity * $v->req_flag;
                                    }
                                }
                            @endphp
                            <h3 class="home-card-number"><span
                                        class="animate-number">{{ abs($late_bills_total) }}</span>
                                <small>{{ $currency }} &rlm;</small>
                            </h3>
                        </div>
                        <div class="card-block p-y-0 p-x-2 b-t-1 small">
                            <div class="row">
                                <div class="col-xs-12 p-y-1 text-xs-center">
                                    <a href="#">

                                        <div class="font-weight-bold"
                                             style=";text-align:right;direction:rtl">{{ count($late_bills_count) }}</div>
                                        <div class="text-muted" style=";text-align:right;direction:rtl">
                                            <small>@lang('strings.invoice')</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- late invoices -->
                <div class="col-sm-6 col-md-3 col-lg-3 col-xs-6 card_col">
                    <div class="card card6">
                        <div class="card-header card-header-inverse card-header-primary small font-weight-bold text-xs-center">
                            @lang('strings.invoice_before')
                        </div>
                        <div class="card-block text-xs-center">
                            @php
                                $prepaid_bills_count = App\CustomerHead::where(['org_id' => Auth::user()->org_id, 'invoice_status' => 3])->whereNotNull('cust_id')->get();
                                $prepaid_bills_total = 0;
                                foreach ($prepaid_bills_count as $v0){
                                    foreach ($v0->transactions as $key => $v) {
                                        $prepaid_bills_total += $v->price = $v->price * $v->quantity * $v->req_flag;
                                    }
                                }
                            @endphp
                            <h3 class="home-card-number"><span
                                        class="animate-number">{{ abs($prepaid_bills_total) }}</span>
                                <small>{{ $currency }} &rlm;</small>
                            </h3>
                        </div>
                        <div class="card-block p-y-0 p-x-2 b-t-1 small">
                            <div class="row">
                                <div class="col-xs-12 p-y-1 text-xs-center">
                                    <a href="#">

                                        <div class="font-weight-bold"
                                             style=";text-align:right;direction:rtl">{{ count($prepaid_bills_count) }}</div>
                                        <div class="text-muted" style=";text-align:right;direction:rtl">
                                            <small>@lang('strings.invoice')</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xs-6 card_col">
                    <div class="card card7">
                        <div class="card-header card-header-inverse card-header-primary small font-weight-bold text-xs-center">
                            @lang('strings.invoice_gz')
                        </div>
                        <div class="card-block text-xs-center">
                            @php
                                $partly_bills_count = App\CustomerHead::where(['org_id' => Auth::user()->org_id, 'invoice_status' => 2])->whereNotNull('cust_id')->get();
                                $partly_bills_total = 0;
                                foreach ($partly_bills_count as $v0){
                                    foreach ($v0->transactions as $key => $v) {
                                        $partly_bills_total += $v->price = $v->price * $v->quantity * $v->req_flag;
                                    }
                                }
                            @endphp
                            <h3 class="home-card-number"><span
                                        class="animate-number">{{ abs($partly_bills_total) }}</span>
                                <small>{{ $currency }} &rlm;</small>
                            </h3>
                        </div>

                        <div class="card-block p-y-0 p-x-2 b-t-1 small">
                            <div class="row">
                                <div class="col-xs-12 p-y-1 text-xs-center">
                                    <a href="#">

                                        <div class="font-weight-bold"
                                             style=";text-align:right;direction:rtl">{{ count($partly_bills_count) }}</div>
                                        <div class="text-muted" style=";text-align:right;direction:rtl">
                                            <small>@lang('strings.invoice')</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  //chart by date -->

                <!-- information -->
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="bg-white">
                        <div class="title-card">
                            <h3>@lang('strings.user_statistics')</h3>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="panel info-box panel-white5">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p class="counter">{{ App\User::where(['org_id' => Auth::user()->org_id])->count() }}</p>
                                        <span class="info-box-title">@lang('strings.user_statistics_count')</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p class="counter">{{ count($customers) }}</p>
                                        <span class="info-box-title">{{ __('strings.customers_count') }}</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="bg-white">
                        <div class="title-card">
                            <h3>@lang('strings.requests_statistics')</h3>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="panel info-box panel-white2">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p class="counter">{{ count($orders) + App\externalReq::where(['org_id' => Auth::user()->org_id])->count()}}</p>
                                        <span class="info-box-title">{{ __('strings.orders_count') }}</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-basket"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="panel info-box panel-white4">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p class="counter">{{ $offers }}</p>
                                        <span class="info-box-title">{{ __('strings.offers_count') }}</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="fab fa-buffer"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- information -->
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="bg-white">
                        <div class="title-card">
                            <h3>@lang('strings.items_and_invoices_statistics')</h3>
                        </div>
                        <div class="col-md-12">
                            @if(Session::has('database_updated'))
                                <div class="alert alert-success">{{ session('database_updated') }}</div>
                            @endif
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="panel info-box panel-white3">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p class="counter">{{ count($items) }}</p>
                                        <span class="info-box-title">{{ __('strings.items_count') }}</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="icon-arrow-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="panel info-box panel-white6">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p class="counter">{{ App\CustomerHead::where(['org_id' => Auth::user()->org_id])->whereNotNull('cust_id')->count() + App\externalReq::where(['org_id' => Auth::user()->org_id])->count() }}</p>
                                        <span class="info-box-title">@lang('strings.count_invoices')</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="fas fa-money-check-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--  chart by date big -->
                <div class="col-md-12 col-xs-12">
                    <div class="bg-white">
                        <div class="title-card title-blue">
                            <h3>@lang('strings.invoices_by_date')</h3>
                            <p>@lang('strings.invoices_by_date_dec')</p>
                        </div>
                        <div class="col-md-12">
                            <canvas id="chart-legend-top"></canvas>
                        </div>
                    </div>
                </div>
                <!-- // chart by date big -->

                <!-- last 5 invoices -->
                <div class="col-md-6 col-xs-12">
                    <div class="bg-white">
                        <div class="title-card invoic-title">
                            <h3>@lang('strings.latest_invoices')</h3>
                            <p>@lang('strings.latest_invoices_dec')</p>
                        </div>
                        <table class="table table-sm table-hover table-align-middle m-b-0" id="last_invoices"
                               style="display: table;">
                            <thead class="transparent">
                            <tr>
                                <th style="width: 120px;">@lang('strings.date')</th>
                                <th>@lang('strings.reference_number')</th>
                                <th style="width: 130px;" class="text-xs-center"><i class="fa fa-external-link"></i>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(App\CustomerHead::where(['org_id' => Auth::user()->org_id])->with('customer', 'transactions')->take(5)->whereNotNull('cust_id')->orderBy('date', 'DESC')->get() as $value)
                                <tr>
                                    <td>{{ $value->date }}</td>
                                    <td>
                                        <a href="{{ route('transactions.edit', $value->id) }}">{{ $value->id }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('transactions.edit', $value->id) }}" class="tip"
                                           title="@lang('strings.edit')"><i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="{{ url('admin/transactions/'.$value->id.'/print') }}" class="tip"
                                           title="@lang('strings.File')"><i class="fa fa-file"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Results -->
                <form method="post" action="{{ url('admin/dashboard') }}" enctype="multipart/form-data"
                      id="search_form">
                    {{csrf_field()}}
                    <div class="col-md-6 col-xs-12">
                        <div class="bg-white">
                            <div class="title-card">
                                <h3>@lang('strings.overview_chart')</h3>
                                <p>@lang('strings.overview_chart_dec')</p>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group text row">

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label>@lang('strings.Date_fromm')</label>
                                            @if(app('request')->input('report_date_from'))
                                                <input type="date" class="form-control datepicker" autocomplete="off"
                                                       id="report_date_from"
                                                       value="{{ app('request')->input('report_date_from') }}"
                                                       name="report_date_from">
                                            @else
                                                <input type="date" class="form-control datepicker" autocomplete="off"
                                                       id="report_date_from" value="{{ $pre_year}}"
                                                       name="report_date_from">
                                            @endif
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label>@lang('strings.Date_too')</label>
                                            @if(app('request')->input('report_date_to'))
                                                <input type="date" class="form-control datepicker" autocomplete="off"
                                                       id="report_date_to"
                                                       value="{{ app('request')->input('report_date_to') }}"
                                                       name="report_date_to">
                                            @else
                                                <input type="date" class="form-control datepicker" autocomplete="off"
                                                       id="report_date_to" value="{{date('Y-m-d') }}"
                                                       name="report_date_to">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 form-group text-right">
                                    <div class="date_error">
                                        @lang('strings.Message_date')
                                    </div>
                                </div>
                                <div class="btnsfor-chart">
                                    <ul class="nav nav-tabs">
                                        <li><input type="submit" name="chart" value="pie"></li>
                                        <li><input type="submit" name="chart" Value="bar"></li>
                                    </ul>
                                </div>
                                <div>
                                    {!! $chart->container() !!}
                                </div>


                            </div>
                        </div>
                    </div>
                </form>
                @endif
                @if(App\Activities::where('id', App\Org::where('id', Auth::user()->org_id)->value('activity_id'))->value('dashboard_type') == 'Hotels')
                <div class="col-md-12 col-xs-12">
                    <a class="btn btn-primary btn-lg btn-add" href="{{ url('admin/hotel_reservation') }}">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp; {{ __('strings.reservation_add') }}
                    </a>
                    <div class="bg-white">
                        <div class="title-card invoic-title">
                            <h3>@lang('strings.hotels')</h3>
                            <p>@lang('strings.latest_hotels_dec')</p>
                            <form action="" method="GET">
                                <div class="col-md-4 form-group">
                                    <label class="control-label" for="date">@lang('strings.date') </label>
                                    <input type="date" class="form-control" name="date" id="date" placeholder="@lang('strings.keyword')" value="{{ app('request')->input('date', date('Y-m-d')) }}">
                                </div>
                                <div class="col-md-4 form-group text-right">
                                    <label class="control-label" for="categories_types"></label>
                                    <button type="submit" class="btn btn-primary btn-lg"> <i class="fa fa-search"></i> {{ __('strings.search') }} </button>
                                </div>
                            </form>
                        </div>
                        <table class="table table-sm table-hover table-align-middle m-b-0" id="" style="display: table;">
                            <thead class="transparent">
                            <tr>
                                <th style="width: 40%;">@lang('strings.name')</th>
                                <th style="width: 10%;">@lang('strings.Photo')</th>
                                <th>@lang('strings.usage_present')</th>
                                <th style="width: 10%;" class="text-xs-center"><i class="fa fa-external-link"></i> </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($properties as $value)
                                <tr>
                                    <td>{{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }} - {{ app()->getLocale() == 'ar' ? App\Locations::where(['id' => $value->location_id])->value('name') : App\Locations::where(['id' => $value->location_id])->value('name_en') }}</td>
                                    <td>
                                        <a href="{{ asset(!empty($value->image) && !empty(App\Photo::where('id',$value->image)->value('file')) ? App\Photo::where('id',$value->image)->value('file') : '') }}" data-toggle="lightbox" data-title="" data-footer="{{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }} - {{ app()->getLocale() == 'ar' ? App\Locations::where(['id' => $value->location_id])->value('name') : App\Locations::where(['id' => $value->location_id])->value('name_en') }}" >
                                            <img src="{{ asset(!empty($value->image) && !empty(App\Photo::where('id',$value->image)->value('file')) ? App\Photo::where('id',$value->image)->value('file') : '') }}" alt="" class="circular--square">
                                        </a>
                                    </td>
                                    <td>@if($value->percentage != '') {{ $value->percentage }} % @else 0 @endif</td>
                                    <td>
                                        <a href="{{ url('admin/property', $value->id) }}/statistics" class="tip" title="@lang('strings.show_statistics')"><i class="fa fa-dashboard"></i></a>
                                        <a href="{{ url('admin/property', $value->id) }}/rooms" class="tip" title="@lang('strings.show')"><i class="fa fa-building"></i></a>
                                         <a target="_blank" href="{{ url('admin/property/registration/setup/'. $value->id) }}" class="tip" title="@lang('strings.print_card')"><i class="fas fa-address-card"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div>
                            {!! $properties_chart->container() !!}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="page-footer page-footerhome">
        <p class="no-s">
            {{ __('strings.footer_text') }}
        </p>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/three.r92.min.js') }}"></script>
    <script src="{{ asset('js/vanta.waves.min.js') }}"></script>
    <script src="https://unpkg.com/vue"></script>
    <script src="https://cdn.jsdelivr.net/npm/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.0.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

    <script src="{{ asset('js/clock.js') }}"></script>
    <script type="text/javascript" src="https://www.chartjs.org/dist/2.8.0/Chart.min.js"></script>
    <script src="https://www.chartjs.org/samples/latest/utils.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>

    <script>

        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });

        $('#search_button').click(function (e) {
            check = validateDate();
            if (check !== true) {
                $('.date_error').css({"display": "block"});
                e.preventDefault();
            }
        });

        function validateDate() {
            var report_date_from = document.getElementById('report_date_from').value;
            var report_date_to = document.getElementById('report_date_to').value;
            if (report_date_from === "" && report_date_to === "") {
                return true;
            }
            if (Date.parse(report_date_from) <= Date.parse(report_date_to)) {
                return true;
            } else {
                return false;
            }
        }


    </script>
@section('chart_script')
    @if(App\Activities::where('id', App\Org::where('id', Auth::user()->org_id)->value('activity_id'))->value('dashboard_type') == 'Basic')
    <script>
        var color = Chart.helpers.color;

        function createConfig(legendPosition, colorName) {
            return {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    @php
                        function sum($month, $status){

                            $value1 = $value2 = $value3 = $value4 = $value5 = 0;
                            foreach ($orders = App\CustomerHead::where(['org_id' => Auth::user()->org_id])->whereMonth('date', $month)->whereNotNull('cust_id')->get() as $v1){

                                if($v1->invoice_status == 1){
                                    $value1++;
                                }
                                if($v1->invoice_status == 3){
                                    $value2++;
                                }
                                if($v1->invoice_status == 0){
                                    $value3++;
                                }
                                if($v1->invoice_status == 2){
                                    $value4++;
                                }
                                if($v1->invoice_status == 4){
                                    $value5++;
                                }
                            }

                            if($status == 1){
                                if(App\externalReq::where(['org_id' => Auth::user()->org_id])->whereIn('confirm', ['d', 'x', 'yx'])->whereMonth('request_dt', $month)->count() != 0){
                                    return $value1 + App\externalReq::where(['org_id' => Auth::user()->org_id])->whereIn('confirm', ['d', 'x', 'yx'])->whereMonth('request_dt', $month)->count();
                                }else{
                                    return $value1;
                                }
                            }
                            if($status == 2){
                                return $value2;
                            }
                            if($status == 3){
                                return $value3 + App\externalReq::where(['org_id' => Auth::user()->org_id, 'confirm' => 'y'])->whereMonth('request_dt', $month)->count();
                            }
                            if($status == 4){
                                return $value4;
                            }
                            if($status == 5){
                                return $value5;
                            }
                        }

                    @endphp
                    datasets: [{
                        label: '@lang('strings.transactions_status_1')',
                        data: [
                            {{  abs(sum(1, 1)) }},
                            {{  abs(sum(2, 1)) }},
                            {{  abs(sum(3, 1)) }},
                            {{  abs(sum(4, 1)) }},
                            {{  abs(sum(5, 1)) }},
                            {{  abs(sum(6, 1)) }},
                            {{  abs(sum(7, 1)) }},
                            {{  abs(sum(8, 1)) }},
                            {{  abs(sum(9, 1)) }},
                            {{  abs(sum(10, 1)) }},
                            {{  abs(sum(11, 1)) }},
                            {{  abs(sum(12, 1)) }}
                        ],
                        backgroundColor: color(window.chartColors[colorName]).alpha(0.1).rgbString(),
                        borderColor: window.chartColors[colorName],
                        borderWidth: 1
                    },{
                        label: '@lang('strings.transactions_status_2')',
                        data: [
                            {{  abs(sum(1, 2)) }},
                            {{  abs(sum(2, 2)) }},
                            {{  abs(sum(3, 2)) }},
                            {{  abs(sum(4, 2)) }},
                            {{  abs(sum(5, 2)) }},
                            {{  abs(sum(6, 2)) }},
                            {{  abs(sum(7, 2)) }},
                            {{  abs(sum(8, 2)) }},
                            {{  abs(sum(9, 2)) }},
                            {{  abs(sum(10, 2)) }},
                            {{  abs(sum(11, 2)) }},
                            {{  abs(sum(12, 2)) }}
                        ],
                        backgroundColor: color('purple').alpha(0.1).rgbString(),
                        borderColor: 'purple',
                        borderWidth: 1
                    },{
                        label: '@lang('strings.transactions_status_3')',
                        data: [
                            {{  abs(sum(1, 3)) }},
                            {{  abs(sum(2, 3)) }},
                            {{  abs(sum(3, 3)) }},
                            {{  abs(sum(4, 3)) }},
                            {{  abs(sum(5, 3)) }},
                            {{  abs(sum(6, 3)) }},
                            {{  abs(sum(7, 3)) }},
                            {{  abs(sum(8, 3)) }},
                            {{  abs(sum(9, 3)) }},
                            {{  abs(sum(10, 3)) }},
                            {{  abs(sum(11, 3)) }},
                            {{  abs(sum(12, 3)) }}
                        ],
                        backgroundColor: color('red').alpha(0.1).rgbString(),
                        borderColor: 'red',
                        borderWidth: 1
                    },{
                        label: '@lang('strings.transactions_status_4')',
                        data: [
                            {{  abs(sum(1, 4)) }},
                            {{  abs(sum(2, 4)) }},
                            {{  abs(sum(3, 4)) }},
                            {{  abs(sum(4, 4)) }},
                            {{  abs(sum(5, 4)) }},
                            {{  abs(sum(6, 4)) }},
                            {{  abs(sum(7, 4)) }},
                            {{  abs(sum(8, 4)) }},
                            {{  abs(sum(9, 4)) }},
                            {{  abs(sum(10, 4)) }},
                            {{  abs(sum(11, 4)) }},
                            {{  abs(sum(12, 4)) }}
                        ],
                        backgroundColor: color('orange').alpha(0.1).rgbString(),
                        borderColor: 'orange',
                        borderWidth: 1
                    },{
                        label: '@lang('strings.transactions_status_5')',
                        data: [
                            {{  abs(sum(1, 5)) }},
                            {{  abs(sum(2, 5)) }},
                            {{  abs(sum(3, 5)) }},
                            {{  abs(sum(4, 5)) }},
                            {{  abs(sum(5, 5)) }},
                            {{  abs(sum(6, 5)) }},
                            {{  abs(sum(7, 5)) }},
                            {{  abs(sum(8, 5)) }},
                            {{  abs(sum(9, 5)) }},
                            {{  abs(sum(10, 5)) }},
                            {{  abs(sum(11, 5)) }},
                            {{  abs(sum(12, 5)) }}
                        ],
                        backgroundColor: color('green').alpha(0.1).rgbString(),
                        borderColor: 'green',
                        borderWidth: 1
                    }]
                },
                options: {
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 15,
                            bottom: 0
                        }
                    },
                    responsive: true,
                    legend: {
                        position: legendPosition,
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: false,
                                labelString: 'Month'
                            },
                            ticks: {
                                autoSkip: false,
                                maxRotation: 90,
                                minRotation: 90
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: false,
                                labelString: 'Value'
                            }
                        }]
                    },
                    title: {
                        display: false,
                        text: 'Legend Position: ' + legendPosition
                    }
                }
            };
        }

        window.onload = function () {
            [{
                id: 'chart-legend-top',
                legendPosition: 'bottom',
                color: 'green'
            }].forEach(function (details) {
                new Chart(document.getElementById(details.id).getContext('2d'), createConfig(details.legendPosition, details.color));
            });
        };
    </script>
    @endif
@endsection
    @if(App\Activities::where('id', App\Org::where('id', Auth::user()->org_id)->value('activity_id'))->value('dashboard_type') == 'Basic')
    {!! $chart->script() !!}
    @endif
    @if(App\Activities::where('id', App\Org::where('id', Auth::user()->org_id)->value('activity_id'))->value('dashboard_type') == 'Hotels')
    {!! $properties_chart->script() !!}
    @endif
@endsection

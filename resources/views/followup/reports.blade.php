@extends('layouts.admin', ['title' =>  __('strings.followup_reports') ])

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div id="main-wrapper">
        <div class="row">
            @if(Request::is('admin/followup/status/report'))
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">@lang('strings.search')</h4>
                        </div>
                        <div class="panel-body">
                            <form action="">
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="date_from">@lang('strings.Date_fromm')</label>
                                    <input class="form-control" name="date_from" type="date" value="{{ app('request')->input('date_from', date('Y-m-d')) }}">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="date_to">@lang('strings.Date_too')</label>
                                    <input class="form-control" name="date_to" type="date" value="{{ app('request')->input('date_to', date('Y-m-d')) }}">
                                </div>

                                <div class="col-md-4 form-group text-right">
                                    <label class="control-label" for="categories_type"></label>
                                    <button type="submit" class="btn btn-primary btn-lg"> <i class="fa fa-search"></i> {{ __('strings.search') }} </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @if(!empty($chart))
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">@lang('strings.chart')</h4>
                        </div>
                        <div class="panel-body">
                            <div id="app">
                                {!! $chart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-md-12">
                    @foreach($status as $key => $value)
                        @php
                            if(empty(app('request')->input('date_from')) && empty(app('request')->input('date_to'))){
                                $dates = [date('Y-m-d'), date('Y-m-d')];
                            }else{
                                $dates = [app('request')->input('date_from'), app('request')->input('date_to')];
                            }
                        @endphp
                        @if($key == 0 && App\Followup::where(['status' => 'q','org_id' => Auth::user()->org_id])->whereBetween('request_dt', $dates)->count() != 0)
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">@lang('strings.status'):  {{ $value }}</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                            <thead>
                                                <tr>
                                                    <th>@lang('strings.customer_name')</th>
                                                    <th>@lang('strings.request_no')</th>
                                                    <th>@lang('strings.service_type')</th>
                                                    <th>@lang('strings.request_date')</th>
                                                    <th>@lang('strings.total_paids')</th>
                                                    <th>@lang('strings.AdminDescription')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach(App\Followup::where(['org_id' => Auth::user()->org_id, 'status' => 'q'])->whereBetween('request_dt', $dates)->get() as $value)
                                                    @php
                                                        $customer = App\Customers::where('id', $value->cust_id)->first();
                                                        $category = App\Category::where('id', $value->cat_id)->first();
                                                        $sessions = App\FollowupSessions::where('followup_id', $value->id)->sum('session_pay');
                                                    @endphp
                                                    <tr>
                                                        <td>{{ app()->getLocale() == 'ar' ? $customer->name : $customer->name_en }}</td>
                                                        <td>{{ $value->id }}</td>
                                                        <td>{{ app()->getLocale() == 'ar' ? $category->name : $category->name_en }}</td>
                                                        <td>{{ $value->request_dt }}</td>
                                                        <td>{{ Decimalplace($sessions + $value->deposit) }}</td>
                                                        <td>{{ $value->admin_text }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($key == 1 &&  App\Followup::where(['status' => 'a','org_id' => Auth::user()->org_id])->whereBetween('request_dt', $dates)->count() != 0)
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">@lang('strings.status'):  {{ $value }}</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                            <thead>
                                                <tr>
                                                    <th>@lang('strings.customer_name')</th>
                                                    <th>@lang('strings.request_no')</th>
                                                    <th>@lang('strings.service_type')</th>
                                                    <th>@lang('strings.request_date')</th>
                                                    <th>@lang('strings.total_paids')</th>
                                                    <th>@lang('strings.AdminDescription')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach(App\Followup::where(['org_id' => Auth::user()->org_id, 'status' => 'a'])->whereBetween('request_dt', $dates)->get() as $value)
                                                    @php
                                                        $customer = App\Customers::where('id', $value->cust_id)->first();
                                                        $category = App\Category::where('id', $value->cat_id)->first();
                                                        $sessions = App\FollowupSessions::where('followup_id', $value->id)->sum('session_pay');
                                                    @endphp
                                                    <tr>
                                                        <td>{{ app()->getLocale() == 'ar' ? $customer->name : $customer->name_en }}</td>
                                                        <td>{{ $value->id }}</td>
                                                        <td>{{ app()->getLocale() == 'ar' ? $category->name : $category->name_en }}</td>
                                                        <td>{{ $value->request_dt }}</td>
                                                        <td>{{ Decimalplace($sessions + $value->deposit) }}</td>
                                                        <td>{{ $value->admin_text }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($key == 2 && App\Followup::where(['status' => 's','org_id' => Auth::user()->org_id])->whereBetween('request_dt', $dates)->count() != 0)
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">@lang('strings.status'):  {{ $value }}</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                            <thead>
                                                <tr>
                                                    <th>@lang('strings.customer_name')</th>
                                                    <th>@lang('strings.request_no')</th>
                                                    <th>@lang('strings.service_type')</th>
                                                    <th>@lang('strings.request_date')</th>
                                                    <th>@lang('strings.total_paids')</th>
                                                    <th>@lang('strings.AdminDescription')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(App\Followup::where(['org_id' => Auth::user()->org_id, 'status' => 's'])->whereBetween('request_dt', $dates)->get() as $value)
                                                @php
                                                    $customer = App\Customers::where('id', $value->cust_id)->first();
                                                    $category = App\Category::where('id', $value->cat_id)->first();
                                                    $sessions = App\FollowupSessions::where('followup_id', $value->id)->sum('session_pay');
                                                @endphp
                                                <tr>
                                                    <td>{{ app()->getLocale() == 'ar' ? $customer->name : $customer->name_en }}</td>
                                                    <td>{{ $value->id }}</td>
                                                    <td>{{ app()->getLocale() == 'ar' ? $category->name : $category->name_en }}</td>
                                                    <td>{{ $value->request_dt }}</td>
                                                    <td>{{ Decimalplace($sessions + $value->deposit) }}</td>
                                                    <td>{{ $value->admin_text }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($key == 3 && App\Followup::where(['status' => 'r','org_id' => Auth::user()->org_id])->whereBetween('request_dt', $dates)->count() != 0)
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">@lang('strings.status'):  {{ $value }}</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                            <thead>
                                                <tr>
                                                    <th>@lang('strings.customer_name')</th>
                                                    <th>@lang('strings.request_no')</th>
                                                    <th>@lang('strings.service_type')</th>
                                                    <th>@lang('strings.request_date')</th>
                                                    <th>@lang('strings.total_paids')</th>
                                                    <th>@lang('strings.AdminDescription')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach(App\Followup::where(['org_id' => Auth::user()->org_id, 'status' => 'r'])->whereBetween('request_dt', $dates)->get() as $value)
                                                    @php
                                                        $customer = App\Customers::where('id', $value->cust_id)->first();
                                                        $category = App\Category::where('id', $value->cat_id)->first();
                                                        $sessions = App\FollowupSessions::where('followup_id', $value->id)->sum('session_pay');
                                                    @endphp
                                                    <tr>
                                                        <td>{{ app()->getLocale() == 'ar' ? $customer->name : $customer->name_en }}</td>
                                                        <td>{{ $value->id }}</td>
                                                        <td>{{ app()->getLocale() == 'ar' ? $category->name : $category->name_en }}</td>
                                                        <td>{{ $value->request_dt }}</td>
                                                        <td>{{ Decimalplace($sessions + $value->deposit) }}</td>
                                                        <td>{{ $value->admin_text }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($key == 4 && App\Followup::where(['status' => 'f','org_id' => Auth::user()->org_id])->whereBetween('request_dt', $dates)->count() != 0)
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">@lang('strings.status'):  {{ $value }}</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                            <thead>
                                                <tr>
                                                    <th>@lang('strings.customer_name')</th>
                                                    <th>@lang('strings.request_no')</th>
                                                    <th>@lang('strings.service_type')</th>
                                                    <th>@lang('strings.request_date')</th>
                                                    <th>@lang('strings.total_paids')</th>
                                                    <th>@lang('strings.AdminDescription')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach(App\Followup::where(['org_id' => Auth::user()->org_id, 'status' => 'f'])->whereBetween('request_dt', $dates)->get() as $value)
                                                    @php
                                                        $customer = App\Customers::where('id', $value->cust_id)->first();
                                                        $category = App\Category::where('id', $value->cat_id)->first();
                                                        $sessions = App\FollowupSessions::where('followup_id', $value->id)->sum('session_pay');
                                                    @endphp
                                                    <tr>
                                                        <td>{{ app()->getLocale() == 'ar' ? $customer->name : $customer->name_en }}</td>
                                                        <td>{{ $value->id }}</td>
                                                        <td>{{ app()->getLocale() == 'ar' ? $category->name : $category->name_en }}</td>
                                                        <td>{{ $value->request_dt }}</td>
                                                        <td>{{ Decimalplace($sessions + $value->deposit) }}</td>
                                                        <td>{{ $value->admin_text }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

            @if(Request::is('admin/followup/details/report'))
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">@lang('strings.search')</h4>
                        </div>
                        <div class="panel-body">
                            <form action="">
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="date_from">@lang('strings.Date_fromm')</label>
                                    <input class="form-control" name="date_from" type="date" value="{{ app('request')->input('date_from', date('Y-m-d')) }}">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="date_to">@lang('strings.Date_too')</label>
                                    <input class="form-control" name="date_to" type="date" value="{{ app('request')->input('date_to', date('Y-m-d')) }}">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="categories_type">{{ __('strings.status') }}</label>
                                    <select class="form-control js-select" name="status">
                                        <option value="0"> @lang('strings.select') </option>
                                        <option {{ app('request')->input('status') == 'a' ? 'selected' : '' }} value="a">@lang('strings.approved')</option>
                                        <option {{ app('request')->input('status') == 's' ? 'selected' : '' }} value="s">@lang('strings.scheduled')</option>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="customers">{{ __('strings.Customers') }}</label>
                                    <select class="form-control js-select" name="customers">
                                        <option value="0"> @lang('strings.select') </option>
                                        @foreach(App\Customers::where(['org_id' => Auth::user()->org_id])->get() as $v)
                                            <option {{ app('request')->input('customers') == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{   app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 form-group text-right">
                                    <label class="control-label" for="categories_type"></label>
                                    <button type="submit" class="btn btn-primary btn-lg"> <i class="fa fa-search"></i> {{ __('strings.search') }} </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">@lang('strings.followup_reports_2')</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                @foreach($followup_list as $value)
                                    @php
                                        $customer = App\Customers::where('id', $value->cust_id)->first();
                                        $category = App\Category::where('id', $value->cat_id)->first();
                                        $sessions = App\FollowupSessions::where('followup_id', $value->id)->sum('session_pay');
                                    @endphp
                                    <table id="" class="display table xtreme-table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                            <tr>
                                                <th>@lang('strings.customer_name')</th>
                                                <th>@lang('strings.request_no')</th>
                                                <th>@lang('strings.service_type')</th>
                                                <th>@lang('strings.request_date')</th>
                                                <th>@lang('strings.Deposit')</th>
                                                <th>@lang('strings.invoice_no')</th>
                                            </tr>
                                            <tr>
                                                <td>{{ app()->getLocale() == 'ar' ? $customer->name : $customer->name_en }}</td>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ app()->getLocale() == 'ar' ? $category->name : $category->name_en }}</td>
                                                <td>{{ $value->request_dt }}</td>
                                                <td>{{ Decimalplace($value->deposit) }}</td>
                                                <td>{{ $value->deposit_inv_code }}</td>
                                            </tr>
                                            <tr>
                                                <th>@lang('strings.serial')</th>
                                                <th>@lang('strings.Date')</th>
                                                <th>@lang('strings.invoice_no')</th>
                                                <th>@lang('strings.attendance_status')</th>
                                                <th>@lang('strings.Amount')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(App\FollowupSessions::where('followup_id', $value->id)->get() as $v2)
                                                <tr>
                                                    <td>{{ $v2->serial }}</td>
                                                    <td>{{ $v2->session_dt }}</td>
                                                    <td>{{ $v2->session_inv_code }}</td>
                                                    <td>
                                                        {{ $v2->session_status == 1 ? __('strings.reservation') : '' }}
                                                        {{ $v2->session_status == 2 ? __('strings.attended') : '' }}
                                                        {{ $v2->session_status == 3 ? __('strings.did_not_attend') : '' }}
                                                        {{ $v2->session_status == 4 ? __('strings.cancel') : '' }}
                                                    </td>
                                                    <td>{{ Decimalplace($v2->session_pay) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(Request::is('admin/followup/messages/report'))
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">@lang('strings.search')</h4>
                        </div>
                        <div class="panel-body">
                            <form action="">
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="date_from">@lang('strings.Date_fromm')</label>
                                    <input class="form-control" name="date_from" type="date" value="{{ app('request')->input('date_from', date('Y-m-d')) }}">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="date_to">@lang('strings.Date_too')</label>
                                    <input class="form-control" name="date_to" type="date" value="{{ app('request')->input('date_to', date('Y-m-d')) }}">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="categories_type">{{ __('strings.media_type') }}</label>
                                    <select class="form-control js-select" name="status">
                                        <option value="0"> @lang('strings.select') </option>
                                        <option {{ app('request')->input('status') == 'mail' ? 'selected' : '' }} value="mail">@lang('strings.email')</option>
                                    </select>
                                </div>

                                <div class="col-md-3 form-group text-right">
                                    <label class="control-label" for="categories_type"></label>
                                    <button type="submit" class="btn btn-primary btn-lg"> <i class="fa fa-search"></i> {{ __('strings.search') }} </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">@lang('strings.followup_reports_3')</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                        <tr>
                                            <th>@lang('strings.request_no')</th>
                                            <th>@lang('strings.customer_name')</th>
                                            <th>@lang('strings.media_type')</th>
                                            <th>@lang('strings.message')</th>
                                            <th>@lang('strings.message_date')</th>
                                            <th>@lang('strings.status')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($followup_list as $value)
                                        @php
                                            $followup = App\Followup::where('id', $value->followup_id)->first();
                                            $customer = App\Customers::where('id', $followup->cust_id)->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $value->followup_id }}</td>
                                            <td>{{ app()->getLocale() == 'ar' ? $customer->name : $customer->name_en }}</td>
                                            <td>{{ $value->msg_media == 'mail' ? __('strings.email') : ''}}</td>
                                            <td>{{ $value->msg_content }}</td>
                                            <td>{{ $value->msg_dt }} </td>
                                            <td>{{ $value->msg_status == 1 ? __('strings.success') : __('strings.failed') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

    @if(Request::is('admin/followup/status/report'))
        <script src="https://unpkg.com/vue"></script>
        <script src="https://cdn.jsdelivr.net/npm/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script>
        @if(!empty($chart))
            {!! $chart->script() !!}
        @endif
        <script>
            var app = new Vue({ el: '#app', });
        </script>
    @endif
@endsection
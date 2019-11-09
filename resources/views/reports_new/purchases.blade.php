@extends('layouts.admin', ['title' => __('strings.purchases_title') ])

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">

    <!--<div class="page-title">-->
    <!--    <h3>@if($iuser =='supplier') @lang('strings.purchases_title') @else @lang('strings.purchases_title_2') @endif</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>-->
    <!--            <li class="active">@if($iuser =='supplier') @lang('strings.purchases_title') @else @lang('strings.purchases_title_2') @endif</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @if($iuser == 'supplier')
                <a class="btn btn-primary btn-lg btn-add" href="{{ url('admin/purchases/supplier/total') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('strings.total_reports')</a>
                <a class="btn btn-primary btn-lg btn-add" href="{{ url('admin/purchases/supplier/detailed') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('strings.detailed_reports')</a>
                @elseif($iuser == 'employee')
                    <a class="btn btn-primary btn-lg btn-add" href="{{ url('admin/purchases/employee/total') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('strings.total_reports')</a>
                    <a class="btn btn-primary btn-lg btn-add" href="{{ url('admin/purchases/employee/detailed') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('strings.detailed_reports')</a>
                @endif
                <div class="panel panel-white">
                    <div class="panel-body">

                        <form action="" enctype="multipart/form-data" id="add">
                            {{csrf_field()}}
                            @if($iuser == 'supplier')
                                <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                    <label>@lang('strings.Suppliers_name')</label>
                                    <select class="form-control js-select" name="search_name">
                                        <option value="0">@lang('strings.All')</option>
                                        @foreach(App\Suppliers::where(['active' => 1,'org_id' => Auth::user()->org_id])->get() as $role)
                                            <option {{ app('request')->input('search_name') == $role->id ? 'selected' : ''}} value="{{$role->id}}">{{ app()->getLocale() == 'ar' ? $role->name : $role->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif($iuser == 'employee')
                                <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                    <label>@lang('strings.Employee')</label>
                                    <select class="form-control js-select" name="search_name">
                                        <option value="0">@lang('strings.All')</option>
                                        @foreach(App\PermissionReceiving::where(['org_id' => Auth::user()->org_id])->groupBy('user_id')->get() as $role)
                                            <option {{ app('request')->input('search_name') == $role->user_id ? 'selected' : ''}} value="{{App\User::findOrFail($role->user_id)->id}}">{{ app()->getLocale() == 'ar' ? App\User::findOrFail($role->user_id)->name : App\User::findOrFail($role->user_id)->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            {{--<div class="col-lg-1 col-md-1 col-sm-1 m-b-sm">--}}
                                {{--<label>@lang('strings.Or')</label>--}}
                            {{--</div>--}}

                            {{--<div class="col-lg-1 col-md-1 col-sm-1 m-b-sm">--}}
                                {{--<label>@lang('strings.With')</label>--}}
                            {{--</div>--}}


                            <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                <div class="input-group text">
                                    <label>@lang('strings.purchases_to')</label>
                                    <input name="search_date_to" type="text" class="form-control datepicker" autocomplete="off" value="{{ app('request')->input('search_date_to') }}" id="">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                <div class="input-group text">
                                    <label>@lang('strings.purchases_from')</label>
                                    <input name="search_date_from" type="text" class="form-control datepicker" autocomplete="off" value="{{ app('request')->input('search_date_from') }}">
                                </div>
                            </div>

                            <div class="col-md-12 form-group text-right">
                                <button name="save" type="submit" class="btn btn-primary btn-lg" value="1">{{ __('strings.Search') }}</button>
                                <button name="save" type="submit" class="btn btn-primary btn-lg" value="2">{{ __('strings.Exports') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @if(!empty($chart))
                <div id="app">
                    {!! $chart->container() !!}
                </div>

                <div class="panel panel-white">
                    <div class="panel-body">
                    @if($type == 'total' && $iuser =='supplier')
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th>{{ __('strings.Name') }}</th>
                                        <th>{{ __('strings.Total') }}</th>
                                        <th>{{ __('strings.Paid') }}</th>
                                        <th>{{ __('strings.Remaining') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0;$paid = 0;$remaining = 0; @endphp
                                    @foreach($suppliers as $value)
                                        @if($value->total != 0 && $value->remaining != 0)
                                        @php
                                            $total +=$value->total;
                                            $paid +=$value->paid;
                                            $remaining +=$value->remaining;
                                        @endphp
                                        <tr>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ Decimalplace($value->total) }}</td>
                                            <td>{{ Decimalplace($value->paid) }}</td>
                                            <td>{{ Decimalplace($value->remaining) }}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>{{ __('strings.Total') }}</td>
                                        <td>{{ Decimalplace($total) }}</td>
                                        <td>{{ Decimalplace($paid) }}</td>
                                        <td>{{ Decimalplace($remaining) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @elseif($type == 'detailed' && $iuser == 'supplier')
                        <div class="table-responsive">
                            @foreach(App\Suppliers::where(['active' => 1, 'org_id' => Auth::user()->org_id])->get() as $v1)
                                @if(count($supplier_invoice->where('supplier_id', $v1->id)) != 0)
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">{{ app()->getLocale() == 'ar' ? $v1->name : $v1->name_en }}</h4>
                                </div>
                                {{--@foreach($supplier_invoice->where('supplier_id', $v1->id) as $v)--}}
                                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                    <tr>
                                        <th>{{ __('strings.invoice_id') }}</th>
                                        <th>{{ __('strings.invoice_date') }}</th>
                                        <th>{{ __('strings.Employee') }}</th>
                                        <th>{{ __('strings.total_invoice') }}</th>
                                        <th>{{ __('strings.total_paid') }}</th>
                                        <th>{{ __('strings.Paid') }}</th>
                                        <th>{{ __('strings.Refund') }}</th>
                                        <th>{{ __('strings.Remaining') }}</th>
                                        <th>{{ __('strings.Status') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $total_invoice = 0;$total_paid = 0; $paid = 0; $refund = 0; $remaining = 0; $refund = 0;@endphp
                                    @foreach($supplier_invoice->where('supplier_id', $v1->id) as $value)

                                        @php
                                            $total_invoice +=$value->total_invoice;
                                            $total_paid +=$value->total_paid;
                                            $paid +=$value->paid;
                                            $refund +=$value->refund;
                                            $remaining +=$value->remaining;
                                        @endphp
                                        <tr>
                                            <td>{{ $value->supp_invoice_no }}</td>
                                            <td>{{ Dateformat($value->supp_invoice_dt) }}</td>
                                            <td>{{ app()->getLocale() == 'ar' ? App\User::findOrFail($value->user_id)->name : App\User::findOrFail($value->user_id)->name_en }}</td>
                                            <td>{{ Decimalplace($value->total_invoice) }}</td>
                                            <td>{{ Decimalplace($value->total_paid) }}</td>
                                            <td>{{ Decimalplace($value->paid) }}</td>
                                            <td>{{ Decimalplace($value->refund) }}</td>
                                            <td>{{ Decimalplace($value->remaining) }}</td>
                                            <td>@if($value->remaining == 0) <span class="label label-success" style="font-size:12px;">@lang('strings.transactions_status_1')</span> @elseif($value->remaining == $value->total_paid) <span class="label label-danger" style="font-size:12px;">@lang('strings.transactions_status_3')</span> @elseif($value->remaining < 0) <span class="label label-info" style="font-size:12px;"> @lang('strings.transactions_status_2')</span> @elseif($value->remaining > 0) <span class="label label-warning" style="font-size:12px;"> @lang('strings.transactions_status_4')</span> @endif</td>


                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>{{ __('strings.Total') }}</td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ Decimalplace($total_invoice) }}</td>
                                            <td>{{ Decimalplace($total_paid) }}</td>
                                            <td>{{ Decimalplace($paid) }}</td>
                                            <td>{{ Decimalplace($refund) }}</td>
                                            <td>{{ Decimalplace($remaining) }}</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                {{--@endforeach--}}
                                @endif
                            @endforeach
                        </div>
                    @elseif($iuser == 'employee' && $type == 'total')
                            <div class="table-responsive">
                                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                    <tr>
                                        <th>{{ __('strings.Name') }}</th>
                                        <th>{{ __('strings.Total') }}</th>
                                        <th>{{ __('strings.Paid') }}</th>
                                        <th>{{ __('strings.Remaining') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $total = 0;$paid = 0;$remaining = 0; @endphp
                                    @foreach($suppliers as $value)
                                        @if($value->total != 0 && $value->remaining != 0)
                                        @php
                                            $total +=$value->total;
                                            $paid +=$value->paid;
                                            $remaining +=$value->remaining;
                                        @endphp
                                        <tr>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ Decimalplace($value->total) }}</td>
                                            <td>{{ Decimalplace($value->paid) }}</td>
                                            <td>{{ Decimalplace($value->remaining) }}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td>{{ __('strings.Total') }}</td>
                                        <td>{{ Decimalplace($total) }}</td>
                                        <td>{{ Decimalplace($paid) }}</td>
                                        <td>{{ Decimalplace($remaining) }}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                    @elseif($iuser == 'employee' && $type == 'detailed')
                        <div class="table-responsive">
                            @foreach(App\User::where(['is_active' => 1, 'org_id' => Auth::user()->org_id])->get() as $v1)

                                @if(count($supplier_invoice->where('user_id', $v1->id)) != 0)
                                    <div class="panel-heading clearfix">
                                        <h4 class="panel-title">{{ app()->getLocale() == 'ar' ? $v1->name : $v1->name_en }}</h4>
                                    </div>
                                    {{--@foreach($supplier_invoice->where('supplier_id', $v1->id) as $v)--}}
                                    <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                        <tr>
                                            <th>{{ __('strings.invoice_id') }}</th>
                                            <th>{{ __('strings.invoice_date') }}</th>
                                            <th>{{ __('strings.Employee') }}</th>
                                            <th>{{ __('strings.total_invoice') }}</th>
                                            <th>{{ __('strings.total_paid') }}</th>
                                            <th>{{ __('strings.Paid') }}</th>
                                            <th>{{ __('strings.Refund') }}</th>
                                            <th>{{ __('strings.Remaining') }}</th>
                                            <th>{{ __('strings.Status') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $total_invoice = 0;$total_paid = 0; $paid = 0; $refund = 0; $remaining = 0; $refund = 0;@endphp
                                        @foreach($supplier_invoice->where('user_id', $v1->id) as $value)
                                            @php
                                                $total_invoice += $value->total_invoice;
                                                $total_paid += $value->total_paid;
                                                $paid += $value->paid;
                                                $refund += $value->refund;
                                                $remaining += $value->remaining;
                                            @endphp
                                            <tr>
                                                <td>{{ $value->supp_invoice_no }}</td>
                                                <td>{{ Dateformat($value->supp_invoice_dt) }}</td>
                                                <td>{{ app()->getLocale() == 'ar' ? App\User::findOrFail($value->user_id)->name : App\User::findOrFail($value->user_id)->name_en }}</td>
                                                <td>{{ Decimalplace($value->total_invoice) }}</td>
                                                <td>{{ Decimalplace($value->total_paid) }}</td>
                                                <td>{{ Decimalplace($value->paid) }}</td>
                                                <td>{{ Decimalplace($value->refund) }}</td>
                                                <td>{{ Decimalplace($value->remaining) }}</td>
                                                <td>@if($value->remaining == 0) <span class="label label-success" style="font-size:12px;">@lang('strings.transactions_status_1')</span> @elseif($value->remaining == $value->total_paid) <span class="label label-danger" style="font-size:12px;">@lang('strings.transactions_status_3')</span> @elseif($value->remaining < 0) <span class="label label-info" style="font-size:12px;"> @lang('strings.transactions_status_2')</span> @elseif($value->remaining > 0) <span class="label label-warning" style="font-size:12px;"> @lang('strings.transactions_status_4')</span> @endif</td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td>{{ __('strings.Total') }}</td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ Decimalplace($total_invoice) }}</td>
                                            <td>{{ Decimalplace($total_paid) }}</td>
                                            <td>{{ Decimalplace($paid) }}</td>
                                            <td>{{ Decimalplace($refund) }}</td>
                                            <td>{{ Decimalplace($remaining) }}</td>
                                            <td></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    {{--@endforeach--}}
                                @endif
                            @endforeach
                        </div>
                    @endif
                        {{--{{ $customers->links() }}--}}
                    </div>
                </div>

                @endif
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/vue"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script>
    @if(!empty($chart))
    {!! $chart->script() !!}
    @endif

    <script>

        $(".datepicker").datepicker({defaultDate: null, @if(app()->getLocale() == 'ar')  rtl: true @endif });
        $('.js-select').select2({
            minimumInputLength: 2,
        });
        var app = new Vue({
            el: '#app',
        });
    </script>
@endsection
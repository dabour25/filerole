@extends('layouts.admin', ['title' => __('strings.companies')])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">@lang('strings.search')</h4>
                    </div>
                    <div class="panel-body">
                        <form action="">
                            <div class="col-md-3 form-group">
                                <label class="control-label" for="categories_type">{{ __('strings.status') }}</label>
                                <select class="form-control js-select" name="status">
                                    <option value="0"> @lang('strings.select') </option>
                                    <option {{ app('request')->input('status') == 'q' ? 'selected' : '' }} value="q">@lang('strings.request')</option>
                                    <option {{ app('request')->input('status') == 'a' ? 'selected' : '' }} value="a">@lang('strings.approved')</option>
                                    <option {{ app('request')->input('status') == 'r' ? 'selected' : '' }} value="r">@lang('strings.return')</option>
                                    <option {{ app('request')->input('status') == 'f' ? 'selected' : '' }} value="f">@lang('strings.refused')</option>
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
                            <div class="col-md-3 form-group">
                                <label class="control-label" for="request_date">@lang('strings.request_date')</label>
                                <input class="form-control" name="request_date" type="date" value="{{ app('request')->input('request_date', date('Y-m-d')) }}">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="control-label" for="phones">@lang('strings.phones')</label>
                                <select class="form-control js-select" name="phones">
                                    <option value="0"> @lang('strings.select') </option>
                                    @foreach(App\Customers::where(['org_id' => Auth::user()->org_id])->get() as $v)
                                        <option {{ app('request')->input('phones') == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{  $v->phone_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="control-label" for="service_type">@lang('strings.service_type')</label>
                                <select class="form-control js-select" name="service_type">
                                    <option value="0"> @lang('strings.select') </option>
                                    @foreach($services_list as $v)
                                        <option {{ app('request')->input('service_type') == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{   app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-4 form-group text-right">
                                <label class="control-label" for="categories_type"></label>
                                <button type="submit" class="btn btn-primary btn-lg"> <i class="fa fa-search"></i> {{ __('strings.search') }} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                @include('alerts.index')
                <div class="btn-group m-l-xs col-md-2">
                    <a class="btn btn-primary btn-lg btn-add" href="{{ route('followup.create') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('strings.add_request')</a>
                </div>
                <div class="btn-group m-l-xs col-md-2">
                    <div class="btn-group btns_sanef">
                        <button type="button" class="btn btn-primary btn-lg btn-add" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-archive"></i> @lang('strings.followup_reports')
                        </button>

                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="{{ url('admin/followup/status/report') }}"><i class="fas fa-file"></i> {{ __('strings.followup_reports_1') }} </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/followup/details/report') }}"><i class="fas fa-file"></i> {{ __('strings.followup_reports_2') }} </a>
                            </li>
                            <li>
                                <a href="{{ url('admin/followup/messages/report') }}"><i class="fas fa-file"></i> {{ __('strings.followup_reports_3') }} </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">@lang('strings.requests')</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <!--<th>#</th>-->
                                        <th>@lang('strings.request_date')</th>
                                        <th>@lang('strings.Customers')</th>
                                        <th>@lang('strings.phones')</th>
                                        <th>@lang('strings.service_type')</th>
                                        <th>@lang('strings.Status')</th>
                                        <th>@lang('strings.total_amount')</th>
                                        <th>@lang('strings.Settings')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($followup_list as $value)
                                        @php
                                            $customer = App\Customers::where('id', $value->cust_id)->first();
                                            $category = App\Category::where('id', $value->cat_id)->first();
                                            $sessions = App\FollowupSessions::where('followup_id', $value->id)->sum('session_pay');
                                        @endphp
                                        <tr>
                                            <!--<td>{{ $value->id }}</td>-->
                                            <td>{{ $value->request_dt }}</td>
                                            <td>{{ app()->getLocale() == 'ar' ? $customer->name : $customer->name_en }}</td>
                                            <td>{{ $customer->phone_number }}</td>
                                            <td>{{ app()->getLocale() == 'ar' ? $category->name : $category->name_en }}</td>
                                            <td>{{ $value->status == 'q'? __('strings.request') : ''}}  {{ $value->status == 'a'? __('strings.approved') : ''}} {{ $value->status == 'r'? __('strings.return') : ''}}  {{ $value->status == 'f'? __('strings.refused') : ''}} {{ $value->status == 's'? __('strings.scheduled') : ''}}     </td>
                                            <td>{{ Decimalplace($sessions + $value->deposit) }}</td>
                                            <td>
                                                <a href="{{ route('followup.edit', $value->id) }}" class="bn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="تعديل"><i class="fa fa-pencil"></i></a>
                                                @if(permissions('followup_confirm') == 1)
                                                    <a href="{{ route('followup.confirm', $value->id) }}" class="bn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="تاكيد"><i class="fa fa-check"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $followup_list->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
@endsection
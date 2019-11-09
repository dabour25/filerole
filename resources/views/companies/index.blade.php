@extends('layouts.admin', ['title' => __('strings.companies')])

@section('content')
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.index')
                @if(permissions('companies_add') == 1)
                    <a class="btn btn-primary btn-lg btn-add" href="{{ route('companies.create') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('strings.companies_add')</a>
                @endif
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">@lang('strings.companies')</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('strings.Arabic_name')</th>
                                        <th>@lang('strings.English_name')</th>
                                        <th>@lang('strings.Phone')</th>
                                        <th>@lang('strings.Address')</th>
                                        <th>@lang('strings.Status')</th>
                                        @if(permissions('companies_edit') == 1)
                                            <th>@lang('strings.Settings')</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($companies as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->name_en }}</td>
                                            <td>{{ $value->phone }}</td>
                                            <td>{{ $value->address }}</td>
                                            <td>
                                                @if($value->active == 1)
                                                    <span class="label label-success" style="font-size:12px;">{{ __('strings.Active') }}</span>
                                                @else
                                                    <span class="label label-danger" style="font-size:12px;">{{ __('strings.Deactivate') }}</span>
                                                @endif
                                            </td>
                                            @if(permissions('companies_edit') == 1)
                                                <td>
                                                    <a href="{{ route('companies.edit', $value->id) }}" class="bn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="تعديل"><i class="fa fa-pencil"></i></a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $companies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.admin', ['title' => __('strings.weekly_vacations') ])

@section('content')

    <div class="page-title">
        <h3>@lang('strings.weekly_vacations')</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>
                <li class="active">@lang('strings.weekly_vacations')</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.index')
                <ul class="nav nav-tabs">
                    <li @if(Request::is('admin/weekly_vacations')) class="active" @endif><a data-toggle="tab" href="#weekly_vacations">@lang('strings.weekly_vacations')</a></li>
                    <li @if(Request::is('admin/yearly_vacations')) class="active" @endif><a data-toggle="tab" href="#yearly_vacations">@lang('strings.yearly_vacations')</a></li>
                </ul>


                <div class="tab-content">
                    <div id="weekly_vacations" class="tab-pane fade @if(Request::is('admin/weekly_vacations')) in active @endif ">
                        <a class="btn btn-primary btn-lg btn-add" href="{{ route('weekly_vacations.create') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('strings.weekly_vacations_add')</a>
                        <div class="panel panel-white">
                            <div class="panel-heading clearfix">
                                <div class="col-md-12">
                                    <h4 class="panel-title">@lang('strings.weekly_vacations_list')</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('strings.Day')</th>
                                            <th>@lang('strings.Status')</th>
                                            <th>@lang('strings.Settings')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($weekly as $value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ app()->getLocale() == 'ar' ? $value->name == 1 ? 'السبت' : '' : $value->name == 1 ? 'Saturday' : '' }} {{  app()->getLocale() == 'ar' ? $value->name == 2 ? 'الاحد' : '' : $value->name == 2 ? 'Sunday' : ''}} {{ app()->getLocale() == 'ar' ? $value->name == 3 ? 'الاثنين' : '' : $value->name == 3 ? 'Monday' : ''}} {{ app()->getLocale() == 'ar' ? $value->name == 4 ? 'الثلاثاء' : '' : $value->name == 4 ? 'Tuesday' : ''}} {{ app()->getLocale() == 'ar' ? $value->name == 5 ? 'الاربعاء' : '' : $value->name == 5 ? 'Wednesday' : '' }} {{ app()->getLocale() == 'ar' ? $value->name == 6 ? 'الخميس' : '' : $value->name == 6 ? 'Thursday' : '' }} {{ app()->getLocale() == 'ar' ? $value->name == 7 ? 'الجمعه' : '' : $value->name == 7 ? 'Friday' : ''}}</td>
                                                <td>
                                                    @if($value->active == 1)
                                                        <span class="label label-success" style="font-size:12px;">{{ __('strings.Active') }}</span>
                                                    @else
                                                        <span class="label label-danger" style="font-size:12px;">{{ __('strings.Deactivate') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('weekly_vacations.edit', $value->id) }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="تعديل"><i class="fa fa-pencil"></i></a>
                                                    {{--<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $value->id }}"><i class="fa fa-trash-o"></i></a>--}}
                                                    <!-- Package Delete Modal -->
                                                    <div id="{{ $value->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title">تاكيد الحذف</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>{{ __('backend.delete_package_message') }}</p>
                                                                </div>
                                                                <form method="post" action="{{ route('weekly_vacations.destroy', $value->id) }}">
                                                                    <div class="modal-footer">
                                                                        {{csrf_field()}}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit" class="btn btn-danger">حذف</button>
                                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">الغاء</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{ $weekly->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="yearly_vacations" class="tab-pane fade @if(Request::is('admin/yearly_vacations')) in active @endif">
                        <a class="btn btn-primary btn-lg btn-add" href="{{ route('yearly_vacations.create') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('strings.yearly_vacations_add')</a>
                        <div class="panel panel-white">
                            <div class="panel-heading clearfix">
                                <div class="col-md-12">
                                    <h4 class="panel-title">@lang('strings.yearly_vacations_list')</h4>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="xtreme-tables" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('strings.Year')</th>
                                            <th>@lang('strings.Date')</th>
                                            <th>@lang('strings.Arabic_name')</th>
                                            <th>@lang('strings.English_name')</th>
                                            <th>@lang('strings.Status')</th>
                                            <th>@lang('strings.Settings')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($yearly as $value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->year }}</td>
                                                <td>{{ $value->date }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->name_en }}</td>
                                                <td>
                                                    @if($value->active == 1)
                                                        <span class="label label-success" style="font-size:12px;">{{ __('strings.Active') }}</span>
                                                    @else
                                                        <span class="label label-danger" style="font-size:12px;">{{ __('strings.Deactivate') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('yearly_vacations.edit', $value->id) }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="تعديل"><i class="fa fa-pencil"></i></a>
                                                    {{--<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $value->id }}"><i class="fa fa-trash-o"></i></a>--}}
                                                    <!-- Package Delete Modal -->
                                                    <div id="{{ $value->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title">تاكيد الحذف</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>{{ __('backend.delete_package_message') }}</p>
                                                                </div>
                                                                <form method="post" action="{{ route('yearly_vacations.destroy', $value->id) }}">
                                                                    <div class="modal-footer">
                                                                        {{csrf_field()}}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit" class="btn btn-danger">حذف</button>
                                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">الغاء</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{ $yearly->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>

@endsection
@extends('layouts.admin', ['title' =>  __('strings.Available_title') ])

@section('content')

    <!--<div class="page-title">
        <h3>{{ __('strings.Available_title') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>
                <li class="active">{{ __('strings.Available_title') }}</li>
            </ol>
        </div>
    </div>-->
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.index')
                @if(permissions('available_add') == 1)
                <a class="btn btn-primary btn-lg btn-add" href="{{ route('available.create') }}" ><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('strings.Available_add') }}</a>
                @endif
                <div class="panel panel-white">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('strings.Day') }}</th>
                                    <th>{{ __('strings.Time') }}</th>
                                    <th>{{ __('strings.User') }}</th>
                                    <th>{{ __('strings.Status') }}
                                    @if(permissions('available_edit') == 1)
                                    <th>{{ __('strings.Settings') }}</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($times as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->day == 1 ? __('strings.Saturday') : '' }} {{ $value->day == 2 ? __('strings.Sunday') : '' }} {{ $value->day == 3 ? __('strings.Monday') : ''}} {{ $value->day == 4 ? __('strings.Tuesday') : '' }} {{ $value->day == 5 ? __('strings.Wednesday') : '' }} {{ $value->day == 6 ? __('strings.Thursday') : '' }} {{ $value->day == 7 ? __('strings.Friday') : ''}}</td>
                                            <td>
                                                {{ $value->time ==  1 ? '12:00 AM : 12:30 AM' : '' }}
                                                {{ $value->time ==  2 ? '12:30 AM : 01:00 AM' : '' }}
                                                {{ $value->time ==  3 ? '01:00 AM : 01:30 AM' : '' }}
                                                {{ $value->time ==  4 ? '01:30 AM : 02:00 AM' : '' }}
                                                {{ $value->time ==  5 ? '02:00 AM : 02:30 AM' : '' }}
                                                {{ $value->time ==  6 ? '02:30 AM : 03:00 AM' : '' }}
                                                {{ $value->time ==  7 ? '03:00 AM : 03:30 AM' : '' }}
                                                {{ $value->time ==  8 ? '03:30 AM : 04:00 AM' : '' }}
                                                {{ $value->time ==  9 ? '04:00 AM : 04:30 AM' : '' }}
                                                {{ $value->time ==  10 ? '04:30 AM : 05:00 AM' : '' }}
                                                {{ $value->time ==  11 ? '05:00 AM : 05:30 AM' : '' }}
                                                {{ $value->time ==  12 ? '05:30 AM : 06:00 AM' : '' }}
                                                {{ $value->time ==  13 ? '06:00 AM : 06:30 AM' : '' }}
                                                {{ $value->time ==  14 ? '06:30 AM : 07:00 AM' : '' }}
                                                {{ $value->time ==  15 ? '07:00 AM : 07:30 AM' : '' }}
                                                {{ $value->time ==  16 ? '07:30 AM : 08:00 AM' : '' }}
                                                {{ $value->time ==  17 ? '08:00 AM : 08:30 AM' : '' }}
                                                {{ $value->time ==  18 ? '08:30 AM : 09:00 AM' : '' }}
                                                {{ $value->time ==  19 ? '09:00 AM : 09:30 AM' : '' }}
                                                {{ $value->time ==  20 ? '09:30 AM : 10:00 AM' : '' }}
                                                {{ $value->time ==  21 ? '10:00 AM : 10:30 AM' : '' }}
                                                {{ $value->time ==  22 ? '10:30 AM : 11:00 AM' : '' }}
                                                {{ $value->time ==  23 ? '11:00 AM : 11:30 AM' : '' }}
                                                {{ $value->time ==  24 ? '11:30 AM : 12:00 AM' : '' }}
                                                {{ $value->time ==  25 ? '12:00 PM : 12:30 PM' : '' }}
                                                {{ $value->time ==  26 ? '12:30 PM : 01:00 PM' : '' }}
                                                {{ $value->time ==  27 ? '01:00 PM : 01:30 PM' : '' }}
                                                {{ $value->time ==  28 ? '01:30 PM : 02:00 PM' : '' }}
                                                {{ $value->time ==  29 ? '02:00 PM : 02:30 PM' : '' }}
                                                {{ $value->time ==  30 ? '02:30 PM : 03:00 PM' : '' }}
                                                {{ $value->time ==  31 ? '03:00 PM : 03:30 PM' : '' }}
                                                {{ $value->time ==  32 ? '03:30 PM : 04:00 PM' : '' }}
                                                {{ $value->time ==  33 ? '04:00 PM : 04:30 PM' : '' }}
                                                {{ $value->time ==  34 ? '04:30 PM : 05:00 PM' : '' }}
                                                {{ $value->time ==  35 ? '05:00 PM : 05:30 PM' : '' }}
                                                {{ $value->time ==  36 ? '05:30 PM : 06:00 PM' : '' }}
                                                {{ $value->time ==  37 ? '06:00 PM : 06:30 PM' : '' }}
                                                {{ $value->time ==  38 ? '06:30 PM : 07:00 PM' : '' }}
                                                {{ $value->time ==  39 ? '07:00 PM : 07:30 PM' : '' }}
                                                {{ $value->time ==  40 ? '07:30 PM : 08:00 PM' : '' }}
                                                {{ $value->time ==  41 ? '08:00 PM : 08:30 PM' : '' }}
                                                {{ $value->time ==  42 ? '08:30 PM : 09:00 PM' : '' }}
                                                {{ $value->time ==  43 ? '09:00 PM : 09:30 PM' : '' }}
                                                {{ $value->time ==  44 ? '09:30 PM : 10:00 PM' : '' }}
                                                {{ $value->time ==  45 ? '10:00 PM : 10:30 PM' : '' }}
                                                {{ $value->time ==  46 ? '10:30 PM : 11:00 PM' : '' }}
                                                {{ $value->time ==  47 ? '11:00 PM : 11:30 PM' : '' }}
                                                {{ $value->time ==  48 ? '11:30 PM : 12:00 PM' : '' }}
                                            </td>
                                            <td>{{ app()->getLocale() == 'ar' ? App\User::where(['org_id' => Auth::user()->org_id, 'id' => $value->captin_id])->value('name')  : App\User::where(['org_id' => Auth::user()->org_id, 'id' => $value->captin_id])->value('name_en')}}</td>
                                            <td>
                                                @if($value->active == 1)
                                                    <a href="{{ url('admin/available/active/'. $value->id. '/false') }}" class="label label-success" style="font-size:12px;">{{ __('strings.Active') }}</a>
                                                @else
                                                    <a href="{{ url('admin/available/active/'. $value->id. '/true') }}" class="label label-danger" style="font-size:12px;">{{ __('strings.Deactivate') }}</a>
                                                @endif
                                            </td>
                                            @if(permissions('available_edit') == 1)
                                            <td>
                                                <a href="{{ route('available.edit',$value->id) }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="تعديل"><i class="fa fa-pencil"></i></a>

                                                {{--<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $value->id }}"><i class="fa fa-trash-o"></i></a>--}}

                                                <!-- User Delete Modal -->
                                                <div id="{{ $value->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ __('backend.delete_role_message') }}</p>
                                                            </div>
                                                            <form method="post" action="{{ route('available.destroy', $value->id) }}">
                                                                <div class="modal-footer">
                                                                    {{csrf_field()}}
                                                                    {{ method_field('DELETE') }}
                                                                    <button type="submit" class="btn btn-danger">{{ __('backend.delete_btn') }}</button>
                                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('backend.no') }}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $times->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        function _open(id, that) {
            $td_edit = $(that);
            jQuery('#modal_view_roles_edit .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="{{ asset('/lg.azure-round-loader.gif') }}" /></div>');
            // LOADING THE AJAX MODAL
            jQuery('#modal_view_roles_edit').modal('show', {backdrop: 'true'});
            // SHOW AJAX RESPONSE ON REQUEST SUCCESS
            $.ajax({
                url: 'roles/' + id + '/edit',
                success: function (response) {
                    jQuery('#modal_view_roles_edit .modal-body').html(response);
                }
            });
        }
    </script>
@endsection
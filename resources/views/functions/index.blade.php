@extends('layouts.admin', ['title' => __('strings.Functions') ])

@section('content')

    <!--<div class="page-title">-->
    <!--    <h3>{{ __('strings.Functions') }}</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>-->
    <!--            <li class="active">{{ __('strings.Functions') }}</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.users')
                {{--<a class="btn btn-primary btn-lg btn-add" href="{{ route('functions.create') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;اضافة صلاحية</a>--}}
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('strings.Functions') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('strings.Role_name') }}</th>
                                    <th>{{ __('strings.Settings') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</td>
                                            <td>
                                                <a href="{{ route('functions.edit', $value->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $roles->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function _open(id, that) {
            $td_edit = $(that);
            jQuery('#modal_view_users_edit .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="{{ asset('/lg.azure-round-loader.gif') }}" /></div>');
            // LOADING THE AJAX MODAL
            jQuery('#modal_view_users_edit').modal('show', {backdrop: 'true'});
            // SHOW AJAX RESPONSE ON REQUEST SUCCESS
            $.ajax({
                url: 'users/' + id + '/edit',
                success: function (response) {
                    jQuery('#modal_view_users_edit .modal-body').html(response);
                }
            });
        }
    </script>
@endsection
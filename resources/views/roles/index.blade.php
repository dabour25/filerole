@extends('layouts.admin', ['title' => __('strings.Roles') ])

@section('content')

    <!--<div class="page-title">-->
    <!--    <h3>{{ __('strings.Roles') }}</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>-->
    <!--            <li class="active">{{ __('strings.Roles') }}</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                  <div class="alert_new">
                          <span class="alertIcon">
                              <i class="fas fa-exclamation-circle"></i>
                           </span>
                          <p>
                              @if (app()->getLocale() == 'ar')
            {{ DB::table('function_new')->where('id',70)->value('description') }}
            @else
            {{ DB::table('function_new')->where('id',70)->value('description_en') }}
            @endif
                          </p>
                          <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                          </a>
                      </div>
                @include('alerts.roles')
                    <a class="btn btn-primary btn-lg btn-add" href="{{ route('roles.create') }}" ><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('strings.Role_add') }}</a>
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">{{ __('strings.Roles') }}</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                        <tr>
                                            <!--<th>#</th>-->
                                            <th>{{ __('strings.Arabic_name') }}</th>
                                            <th>{{ __('strings.English_name') }}</th>
                                            <th>{{ __('strings.Description') }}</th>
                                                <th>{{ __('strings.Settings') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $role)
                                            <tr>
                                                <!--<td>{{ $role->id }}</td>-->
                                                <td>{{ $role->name }}</td>
                                                <td>{{ $role->name_en }}</td>
                                                <td>{!! $role->description !!}</td>
                                                    <td>
                                                    <a href="{{ route('roles.edit',$role->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>

                                                    {{--<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $role->id }}"><i class="fa fa-trash-o"></i></a>--}}

                                                    <!-- User Delete Modal -->
                                                    <div id="{{ $role->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
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
                                                                <form method="post" action="{{ route('roles.destroy', $role->id) }}">
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
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
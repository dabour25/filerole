@extends('layouts.admin', ['title' =>  Request::is('admin/employees') ? app()->getLocale() == 'ar' ? ActivityLabel('employees')->value : ActivityLabel('employees')->value_en : __('strings.Users') ])

@section('content')

    <div id="main-wrapper" class="users-page">
        <div class="row">
            <div class="col-md-12">
                  <div class="alert_new">
                          <span class="alertIcon">
                              <i class="fas fa-exclamation-circle"></i>
                           </span>
                          <p>
                         @if(Request::is('admin/employees'))
                              @if (app()->getLocale() == 'ar')
            {{ DB::table('function_new')->where('id',69)->value('description') }}
            @else
            {{ DB::table('function_new')->where('id',69)->value('description_en') }}
            @endif
            
            @else
              @if (app()->getLocale() == 'ar')
            {{ DB::table('function_new')->where('id',101)->value('description') }}
            @else
            {{ DB::table('function_new')->where('id',101)->value('description_en') }}
            @endif
            
            @endif
                          </p>
                          <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                          </a>
                      </div>
                @include('alerts.users')
                @if(permissions('users_add') == 1 || permissions('employees_add') == 1)
                    <a class="btn btn-primary btn-lg btn-add"
                       href="{{ Request::is('admin/employees') ? route('employees.create') : route('users.create') }}"><i
                                class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('strings.add') }}
                    </a>
                @endif

                @if(permissions('users_view') == 1 || permissions('employees_view') == 1)
                    <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ Request::is('admin/employees') ? app()->getLocale() == 'ar' ? ActivityLabel('employees')->value : ActivityLabel('employees')->value_en : __('strings.Users') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div>
                            <table id="xtreme-table55" class="table table-striped table-bordered dt-responsive nowrap"
                                   style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('strings.Users_code') }}</th>
                                        <th>{{ __('strings.Photo') }}</th>
                                        <th>{{ __('strings.Arabic_name') }}</th>
                                        <th>{{ __('strings.English_name') }}</th>
                                        <th>{{ __('strings.Phone') }}</th>
                                        <th>{{ __('strings.Roles') }}</th>
                                        <th>{{ __('strings.Section') }}</th>
                                        <th>{{ __('strings.Status') }}</th>
                                        @if(permissions('users_edit') == 1 || permissions('users_change_password') == 1|| permissions('employees_edit') == 1 || permissions('users_send_password') == 1)
                                            <th>{{ __('strings.Settings') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach(Request::is('admin/employees') ? $users->where('used_type', 1) : $users->where('used_type', 2) as $user)
                                    <tr>
                                        <td>{{ $user->code }}</td>
                                        <td>
                                            <img src="{{ $user->photo ? asset($user->photo->file) : asset('images/profile-placeholder.png') }}"
                                                 class="img-circle avatar" width="40" height="40"></td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->name_en }}</td>
                                        <td>{{ $user->phone_number}}</td>
                                        <td>{{ ucfirst(app()->getLocale() == 'ar' ? $user->role->name : $user->role->name_en) }}</td>
                                        <td>{{ ucfirst(app()->getLocale() == 'ar' ? $user->section['name'] : $user->section['name_en']) }}</td>
                                        <td>
                                            @if($user->is_active)
                                                <span class="label label-success"
                                                      style="font-size:12px;">{{ __('strings.Active') }}</span>
                                            @else
                                                <span class="label label-danger"
                                                      style="font-size:12px;">{{ __('strings.Deactivate') }}</span>
                                            @endif
                                        </td>
                                        @if(permissions('users_edit') == 1 || permissions('users_change_password') == 1 || permissions('employees_edit') == 1 || permissions('users_send_password') == 1)
                                            <td>
                                                <a href="{{ Request::is('admin/employees') ? route('employees.edit', $user->id): route('users.edit', $user->id) }}"
                                                   class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                   data-placement="bottom" title="" data-original-title="تعديل"><i
                                                            class="fa fa-pencil"></i></a>
                                                @if( Request::is('admin/users'))
                                                    @if(permissions('users_send_password') == 1)
                                                        <a href="{{ route('users.send_password', $user->id) }}"
                                                           class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                           data-placement="bottom" title=""
                                                           data-original-title="أرسل بيانات الدخول"
                                                           onclick="return confirm('سنقوم بإنشاء كلمة مرور جديدة. هل تريد الاستمرار');"><i
                                                                    class="fa fa-mail-reply"></i></a>
                                                    @endif
                                                @endif
                                                @if($user->id != Auth::user()->id)
                                                    @if( Request::is('admin/users'))
                                                        @if(permissions('users_change_password') == 1)
                                                        <a href="#" onclick="_open({{ $user->id }})"
                                                           class="btn btn-primary btn-xs"><i class="fa fa-key"
                                                                                             data-toggle="tooltip"
                                                                                             data-placement="bottom"
                                                                                             title=""
                                                                                             data-original-title="تغيير كلمة السر"></i></a>
                                                        @endif
                                                    @endif
                                                    {{--<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $user->id }}"><i class="fa fa-trash-o"></i></a>--}}

                                                <!-- User Delete Modal -->
                                                    <div id="{{ $user->id }}" class="modal fade" role="dialog"
                                                         data-keyboard="false" data-backdrop="static">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal">&times;
                                                                    </button>
                                                                    <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>{{ __('backend.delete_user_message') }}</p>
                                                                </div>
                                                                <form method="post"
                                                                      action="{{ route('users.destroy', $user->id) }}">
                                                                    <div class="modal-footer">
                                                                        {{csrf_field()}}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit"
                                                                                class="btn btn-danger">{{ __('backend.delete_btn') }}</button>
                                                                        <button type="button" class="btn btn-primary"
                                                                                data-dismiss="modal">{{ __('backend.no') }}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

    <!--begin::Modal-->
    <div class="modal fade" id="modal_view_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ __('strings.Change_password') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                &times;
                            </span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-cancel" data-dismiss="modal">
                        <i class="fas fa-times"></i> {{ __('strings.Cancel') }}
                    </button>
                    <button type="button" class="btn btn-primary"
                            onclick="document.forms['password'].submit(); return false;">
                        <i class="fas fa-save"></i> {{ __('strings.Save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

    <script>
        function _open(id, that) {
            $td_edit = $(that);
            jQuery('#modal_view_password').modal('show', {backdrop: 'true'});
            $.ajax({
                url: 'users/' + id + '/change-password',
                success: function (response) {
                    jQuery('#modal_view_password .modal-body').html(response);
                }
            });
        }
    </script>
@endsection
@extends('layouts.admin', ['title' => __('strings.Search_title')])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')


    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('strings.Search_select') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">

                        <form method="post" action="" enctype="multipart/form-data" id="add" class="addform">
                            {{csrf_field()}}
                            <div class="col-md-12 form-group">
                                <div class="col-md-2">
                                    <label class="control-label" for="type">{{ __('strings.Name') }}</label>
                                    <input class="col-md-2 search-type" type="radio" value="1" name="type">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label" for="type">{{ __('strings.Phone') }}</label>
                                    <input class="col-md-2 search-type" type="radio" value="2" name="type">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label" for="type">{{ __('strings.Email') }}</label>
                                    <input class="col-md-2 search-type" type="radio" value="3" name="type">
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label" for="type">{{ __('strings.Membership') }}</label>
                                    <input class="col-md-2 search-type" type="radio" value="4" name="type">
                                </div>
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('role_id') ? ' has-error' : ''}}" style="display: none;" id="search-name">
                                <label class="control-label" for="role_id">{{ __('strings.Client_name') }}</label>
                                <select class="js-select" name="search_name">
                                    <option value="0">@lang('strings.All')</option>
                                    @foreach(App\Customers::where(['org_id' => Auth::user()->org_id])->get() as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('role_id'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('role_id') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('role_id') ? ' has-error' : ''}}" style="display: none;" id="search-phone">
                                <label class="control-label" for="role_id">{{ __('strings.Phone') }}</label>
                                <select class="js-select" name="search_phone">
                                    <option value="0">@lang('strings.All')</option>
                                    @foreach(App\Customers::where(['org_id' => Auth::user()->org_id])->get() as $role)
                                        <option value="{{$role->id}}">{{$role->phone_number}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('role_id'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('role_id') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('role_id') ? ' has-error' : ''}}" style="display: none;" id="search-email">
                                <label class="control-label" for="role_id">{{ __('strings.Email') }}</label>
                                <select class="js-select" name="search_email">
                                    <option value="0">@lang('strings.All')</option>
                                    @foreach(App\Customers::where(['org_id' => Auth::user()->org_id])->get() as $role)
                                        <option value="{{$role->id}}">{{$role->email}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('role_id'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('role_id') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('role_id') ? ' has-error' : ''}}" style="display: none;" id="search-code">
                                <label class="control-label" for="role_id">{{ __('strings.Membership') }}</label>
                                <select class="js-select" name="search_code">
                                    <option value="0">@lang('strings.All')</option>
                                    @foreach(App\Customers::where(['org_id' => Auth::user()->org_id])->get() as $role)
                                        <option value="{{$role->id}}">{{$role->cust_code}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('role_id'))
                                    <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('role_id') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">{{ __('strings.Search') }}</button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($customers != null)
            <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('strings.Customers') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('strings.Membership') }}</th>
                                        <th>{{ __('strings.Arabic_name') }}</th>
                                        <th>{{ __('strings.English_name') }}</th>
                                        <th>{{ __('strings.Email') }}</th>
                                        <th>{{ __('strings.Phone') }}</th>
                                        <th>{{ __('strings.Settings') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->cust_code }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->name_en }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->phone_number }}</td>

                                        <td>
                                            <a href="{{ route('customers.edit', $value->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>

                                            <a href="#" onclick="_open({{ $value->id }})" class="btn btn-primary btn-xs"><i class="fa fa-key"></i></a>

                                            <a href="#" onclick="_print({{ $value->id }})" class="btn btn-primary btn-xs"><i class="fa fa-print"></i></a>

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
                                                        <form method="post" action="{{ route('customers.destroy', $value->id) }}">
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
                            {{ $customers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <!--begin::Modal-->
    <div class="modal fade" id="modal_view_passwords" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{ __('strings.Cancel') }}
                    </button>
                    <button type="button" class="btn btn-primary" onclick="document.forms['password'].submit(); return false;">
                        {{ __('strings.Save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script>

        $( ".search-type" ).change(function() {
            if(this.value == 1) {
                $("#search-name").show();
                $( "#search-phone" ).hide();
                $( "#search-email" ).hide();
                $( "#search-code" ).hide();
            }else if(this.value == 2){
                $("#search-phone").show();
                $( "#search-name" ).hide();
                $( "#search-email" ).hide();
                $( "#search-code" ).hide();
            }else if(this.value == 3){
                $("#search-email").show();
                $( "#search-name" ).hide();
                $( "#search-phone" ).hide();
                $( "#search-code" ).hide();
            }else if(this.value == 4){
                $("#search-code").show();
                $( "#search-name" ).hide();
                $( "#search-phone" ).hide();
                $( "#search-email" ).hide();
            }else{
                $( "#search-name" ).hide();
                $( "#search-phone" ).hide();
                $( "#search-email" ).hide();
                $( "#search-code" ).hide();
            }
        });

        function _open(id, that) {
            $td_edit = $(that);
            
            jQuery('#modal_view_passwords').modal('show', {backdrop: 'true'});
            $.ajax({
                url: "{{ url('admin/customers/') }}/" + id + '/change-password',
                success: function (response) {
                    jQuery('#modal_view_passwords .modal-body').html(response);
                }
            });
        }

        function _print(id, that) {
            window.open("{{ url('admin/customers/') }}/" + id + "/print", '_blank');
        }
    </script>
@endsection
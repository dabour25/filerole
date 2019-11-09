@extends('layouts.admin', ['title' => __('strings.Customers') ])

@section('content')
     
    <!-- Function Description -->                 

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                    <div class="alert_new">
        <span class="alertIcon">
            <i class="fas fa-exclamation-circle"></i>
         </span>
         <p>
             @if (app()->getLocale() == 'ar')
            {{ DB::table('function_new')->where('id',5)->value('description') }}
            @else
            {{ DB::table('function_new')->where('id',5)->value('description_en') }}
            @endif
         </p>
         <a href="#" onclick="close_alert()" class="close_alert">  <i class="fas fa-times-circle"></i> </a>
         
    </div>
    
                <!-- mohamed sayed -->
    
     <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-white">
                            <div class="panel-heading clearfix">
                                <div class="col-md-12">
                                    <h4 class="panel-title">{{ __('strings.Search_select') }}</h4>
                                </div>
                            </div>
                            <div class="panel-body">

                                <form method="post" action="{{url('admin/customers/search')}}">
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
                                        <!--
                                        <div class="col-md-2">
                                            <label class="control-label" for="type">{{ __('strings.Membership') }}</label>
                                            <input class="col-md-2 search-type" type="radio" value="4" name="type">
                                        </div>
                                        -->
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

                        
                                    <!--div class="col-md-6 form-group{{$errors->has('role_id') ? ' has-error' : ''}}" style="display: none;" id="search-code">
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
                                    </div-->

                                    <div class="col-md-12 form-group text-right">
                                        <button type="submit" class="btn btn-primary btn-lg">{{ __('strings.Search') }}</button>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
    
    
                @include('alerts.customers')
                @if(permissions('customers_add') == 1)
                    <a class="btn btn-primary btn-lg btn-add" href="{{ route('customers.create') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('strings.Customers_add') }}</a>
                @endif
                <!--
                @if(permissions('customers_search') == 1)
                    <a class="btn btn-primary btn-lg btn-add" href="{{ url('admin/customers/search') }}"><i class="fa fa-search"></i>&nbsp;&nbsp;{{ __('strings.Search') }}</a>
                @endif
                -->
                
                 <div role="tabpanel">

                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('strings.Customers') }}</h4>
                    </div>
                    <div class="panel-body">
                            <table id="xtreme-table" class="display responsive" style="width:100%">
                                <thead>
                                    <tr>
                                        <!--<th>#</th>-->
                                        <th class="hide" style="display: none !important;">{{ __('strings.Membership') }}</th>
                                        <th>{{ __('strings.Arabic_name') }}</th>
                                        <th>{{ __('strings.English_name') }}</th>
                                        <th>{{ __('strings.Email') }}</th>
                                        <th>{{ __('strings.Phone') }}</th>
                                          <th>{{ __('strings.customer_type') }}</th>
                                        @if(permissions('customers_edit') == 1 || permissions('customers_change_password') == 1 || permissions('delete-customer') == 1)
                                            <th>{{ __('strings.Settings') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $value)
                                        <tr>
                                            <!--<td>{{ $value->id }}</td>-->
                                            <td class="hide" style="display: none !important;">{{ $value->cust_code }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->name_en }}</td>
                                            <td>{{ $value->email }}</td>
                                            <td>{{ $value->phone_number }}</td>
                                              @if($value->customer_type ==0)
                                                  <td> <button style="color:green;" >{{ __('strings.customer_in') }}</button></td>
                                               @else
                                                  <td> <button style="color:#1090f4;" >{{ __('strings.customer_out') }}</button></td>
                                             @endif
                                            @if(permissions('customers_edit') == 1 || permissions('customers_change_password') == 1 || permissions('delete-customer') == 1)
                                                <td>
                                                <a href="{{ route('customers.edit', $value->id) }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ __('strings.edit_client') }}"><i class="fa fa-pencil"></i></a>

                                                <a href="#" onclick="_change_password({{ $value->id }})" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ __('strings.edit_pass') }}"><i class="fa fa-key"></i></a>

                                                <a href="#" onclick="_print({{ $value->id }})" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ __('strings.kart_client') }}"><i class="fa fa-print"></i></a>
                                                @if(permissions('delete-customer') == 1)
                                                <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $value->id }}"><i class="fa fa-trash-o"></i></a>
                                                @endif
                                                <!-- User Delete Modal -->
                                                <div id="{{ $value->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">{{ __('strings.confirm') }}</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ __('strings.delete_message') }}</p>
                                                            </div>
                                                            <form method="post" action="{{ route('customers.destroy', $value->id) }}">
                                                                <div class="modal-footer">
                                                                    {{csrf_field()}}
                                                                    {{ method_field('DELETE') }}
                                                                    <button type="submit" class="btn btn-danger">{{ __('strings.delete_btn') }}</button>
                                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('strings.no') }}</button>
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
                        </div>

                        {{ $customers->links() }}
                    </div>
            </div>
            
            
            
           </div>
        </div>
    </div>

</div>
</div>
    <!--begin::Modal-->
    <div class="modal fade" id="modal_view_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        بحث عن عميل
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                &times;
                            </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{url('customers.search')}}" enctype="multipart/form-data" id="add">

                        {{csrf_field()}}

                        <div class="col-md-6 form-group{{$errors->has('role_id') ? ' has-error' : ''}}">
                            <label class="control-label" for="role_id">اسم العميل</label>
                            <select class="js-select" name="role_id">
                                <option></option>
                                @foreach(App\Customers::get() as $role)
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
                            <label class="control-label" for="role_id">رقم الهاتف</label>
                            <select class="js-select" name="role_id">
                                @foreach(App\Customers::get() as $role)
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
                            <label class="control-label" for="role_id">البريد الالكترونى</label>
                            <select class="js-select" name="role_id">
                                @foreach(App\Customers::get() as $role)
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
                            <label class="control-label" for="role_id">رقم العضوية</label>
                            <select class="js-select" name="role_id">
                                @foreach(App\Customers::get() as $role)
                                    <option value="{{$role->id}}">{{$role->cust_code}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('role_id'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('role_id') }}</strong>
                                </span>
                            @endif
                        </div>

                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        الغاء
                    </button>
                    <button type="button" class="btn btn-primary" onclick="document.forms['edit'].submit(); return false;">
                        بحث
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->


    <!--begin::Modal-->
    <div class="modal fade" id="modal_view_passwordaaaaaa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        تعديل كلمة السر
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
                        الغاء
                    </button>
                    <button type="button" class="btn btn-primary" onclick="document.forms['password'].submit(); return false;">
                        حفظ
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

@endsection

@section('scripts')


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
        function _change_password(id, that) {
            $td_edit = $(that);
            jQuery('#modal_view_passwordaaaaaa .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="{{ asset('/lg.azure-round-loader.gif') }}" /></div>');
            jQuery('#modal_view_passwordaaaaaa').modal('show', {backdrop: 'true'});
            $.ajax({
                url:  '{{ url('admin/customers') }}/' + id + '/change-password',
                success: function (response) {
                    jQuery('#modal_view_passwordaaaaaa .modal-body').html(response);
                }
            });
        }

        function _print(id, that) {
            window.open("{{ url('admin/customers/') }}/" + id + "/print", '_blank');
        }
    </script>
@endsection
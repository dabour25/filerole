@extends('layouts.admin', ['title' => __('strings.Sections')])

@section('content')
    <!--<div class="page-title">-->
    <!--    <h3>{{ __('strings.Sections_add') }}</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>-->
    <!--            <li class="active">{{ __('strings.Sections_add') }}</li>-->
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
            {{ DB::table('function_new')->where('id',72)->value('description') }}
            @else
            {{ DB::table('function_new')->where('id',72)->value('description_en') }}
            @endif
                          </p>
                          <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                          </a>
                      </div>
                @include('alerts.sections')
                @if(permissions('sections_add') == 1)
                    <a class="btn btn-primary btn-lg btn-add" href="{{ route('sections.create') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('strings.Sections_add') }}</a>
                @endif
                @if(permissions('sections_view') == 1)
                    <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('strings.Sections') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <!--<th>#</th>-->
                                        <th>{{ __('strings.Arabic_name') }}</th>
                                        <th>{{ __('strings.English_name') }}</th>
                                        @if(permissions('sections_edit') == 1)
                                            <th>{{ __('strings.Settings') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sections as $value)
                                        <tr>
                                            <!--<td>{{ $value->id }}</td>-->
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->name_en }}</td>
                                            @if(permissions('sections_edit') == 1)
                                                <td>
                                                <a href="{{ route('sections.edit', $value->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>

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
                                                                <p>{{ __('backend.delete_section_message') }}</p>
                                                            </div>
                                                            <form method="post" action="{{ route('sections.destroy', $value->id) }}">
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
                            {{ $sections->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!--begin::Modal-->
    <div class="modal fade" id="modal_view_users" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        اضافة قسم
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('sections.store')}}" enctype="multipart/form-data" id="add">

                        {{csrf_field()}}
                        <input type="hidden" class="form-control" name="user_id" value="{{  Auth::user()->id }}">


                        <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}">
                            <label class="control-label" for="name">الاسم بالعربى</label>
                            <input type="text" class="form-control" name="name" value="{{old('name')}}">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                            <label class="control-label" for="name_en">الاسم باللاتينى</label>
                            <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}">
                            @if ($errors->has('name_en'))
                                <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="col-md-12 form-group{{$errors->has('description') ? ' has-error' : ''}}">
                            <label class="control-label" for="description">الوصف</label>
                            <textarea type="text" class="form-control" name="description">{{old('description')}}</textarea>
                            @if ($errors->has('description'))
                                <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        الغاء
                    </button>
                    <button type="button" class="btn btn-primary" onclick="document.forms['add'].submit(); return false;">
                        حفظ
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->


    <!--begin::Modal-->
    <div class="modal fade" id="modal_view_users_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        تعديل القسم
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
                    <button type="button" class="btn btn-primary" onclick="document.forms['edit'].submit(); return false;">
                        حفظ
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

    <script>
        function _open(id, that) {
            $td_edit = $(that);
            jQuery('#modal_view_users_edit .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="{{ asset('/lg.azure-round-loader.gif') }}" /></div>');
            // LOADING THE AJAX MODAL
            jQuery('#modal_view_users_edit').modal('show', {backdrop: 'true'});
            // SHOW AJAX RESPONSE ON REQUEST SUCCESS
            $.ajax({
                url: 'sections/' + id + '/edit',
                success: function (response) {
                    jQuery('#modal_view_users_edit .modal-body').html(response);
                }
            });
        }
    </script>
@endsection
@extends('layouts.admin', ['title' => __('strings.Price_list') ])

@section('content')

    <!--<div class="page-title">-->
    <!--    <h3>{{ __('strings.Price_list') }}</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>-->
    <!--            <li class="active">{{ __('strings.Price_list') }}</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.index')
                @if(permissions('price_list_add') == 1)

                    @if($type == null)
                        <style>
                            .btn-primary:hover {
                                background: #2c9d6f !important;
                            }
                        </style>

                        <!-- Function Description -->
                        <div class="alert_new">
                            <span class="alertIcon">
                                <i class="fas fa-exclamation-circle"></i>
                             </span>
                            <p>
                                @if (app()->getLocale() == 'ar')
                                    {{ DB::table('function_new')->where('id',27)->value('description') }}
                                @else
                                    {{ DB::table('function_new')->where('id',27)->value('description_en') }}
                                @endif
                            </p>
                            <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                            </a>

                        </div>
                        <div class="btn-group m-l-xs">
                            <button type="button" class="btn btn-primary btn-lg btn-add" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-plus"></i> @lang('strings.add') </button>

                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="{{ url('admin/price_list/1/create') }}"><i class="fas fa-plus"></i> {{ app()->getLocale() == 'ar' ? ActivityLabel('items')->value : ActivityLabel('items')->value_en }}</a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/price_list/2/create') }}"><i class="fas fa-plus"></i> {{ app()->getLocale() == 'ar' ? ActivityLabel('services')->value : ActivityLabel('services')->value_en }}</a>
                                </li>
                            </ul>
                        </div>

                    @else
                        <a class="btn btn-primary btn-lg btn-add"
                           href="{{ $type == 1 ? url('admin/price_list/1/create') : url('admin/price_list/2/create') }}">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp; {{ __('strings.add') }}
                        </a>
                    @endif

                @endif
                <div role="tabpanel">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">{{ app()->getLocale() == 'ar' ? ActivityLabel('item_service')->value : ActivityLabel('item_service')->value_en }}</h4>
                        </div>
                        <div class="panel-body">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <!--<th>#</th>-->
                                    <th>{{ __('strings.Item_name') }}</th>
                                    <th>{{ __('strings.Price') }}</th>
                                    <th>{{ __('strings.Date') }}</th>
                                    <th>{{ __('strings.Tax') }}</th>
                                    <th>{{ __('strings.Status') }}</th>
                                    @if(permissions('price_list_edit') == 1)
                                        <th>{{ __('strings.Settings') }}</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $value)
                                        @php
                                            $CategoriesType = App\CategoriesType::where('id', $value->category_type_id)->value('type');
                                        @endphp

                                        @if($CategoriesType == $type)
                                            <tr>
                                            <!--<td>{{ $value->id }}</td>-->
                                                <td>{{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</td>
                                                <td>{{ $value->final_price !== null ? Decimalplace($value->final_price) : Decimalplace($value->price) }}</td>
                                                <td>{{ Dateformat($value->date) }}</td>
                                                <td>{{ $value->final_price == null ? 0 : Decimalplace($value->price - $value->final_price)  }}</td>
                                                <td>
                                                    @if($value->active)
                                                        <span class="label label-success"
                                                              style="font-size:12px;">{{ __('strings.Active') }}</span>
                                                    @else
                                                        <span class="label label-danger"
                                                              style="font-size:12px;">{{ __('strings.Deactivate') }}</span>
                                                    @endif
                                                </td>
                                                @if(permissions('price_list_edit') == 1)
                                                    <td>
                                                        @if($type == null)
                                                            <a href="{{ url('admin/price_list/'. $CategoriesType .'/'.$value->id.'/edit') }}"
                                                               class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                               data-placement="bottom" title="" data-original-title="تعديل"><i
                                                                        class="fa fa-pencil"></i></a>
                                                        @else
                                                            <a href="{{ url('admin/price_list/'. $type .'/'.$value->id.'/edit') }}"
                                                               class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                               data-placement="bottom" title="" data-original-title="تعديل"><i
                                                                        class="fa fa-pencil"></i></a>
                                                    @endif
                                                    {{--<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $value->id }}"><i class="fa fa-trash-o"></i></a>--}}
                                                    <!-- Category Delete Modal -->
                                                        <div id="{{ $value->id }}" class="modal fade" role="dialog"
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
                                                                        <p>{{ __('backend.delete_category_message') }}</p>
                                                                    </div>
                                                                    <form method="post"
                                                                          action="{{ route('price_list.destroy', $value->id) }}">
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
                                                    </td>
                                                @endif
                                            </tr>
                                        
                                        @elseif($type == null)
                                            <tr>
                                            <!--<td>{{ $value->id }}</td>-->
                                                <td>{{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</td>
                                                <td>{{ $value->final_price !== null ? Decimalplace($value->final_price) : Decimalplace($value->price) }}</td>
                                                <td>{{ Dateformat($value->date) }}</td>
                                                <td>{{ $value->final_price == null ? 0 : Decimalplace($value->final_price - $value->price)  }}</td>
                                                <td>
                                                    @if($value->active)
                                                        <span class="label label-success"
                                                              style="font-size:12px;">{{ __('strings.Active') }}</span>
                                                    @else
                                                        <span class="label label-danger"
                                                              style="font-size:12px;">{{ __('strings.Deactivate') }}</span>
                                                    @endif
                                                </td>
                                                @if(permissions('price_list_edit') == 1)
                                                    <td>
                                                        @if($type == null)
                                                            <a href="{{ url('admin/price_list/'. $CategoriesType .'/'.$value->id.'/edit') }}"
                                                               class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                               data-placement="bottom" title="" data-original-title="تعديل"><i
                                                                        class="fa fa-pencil"></i></a>
                                                        @else
                                                            <a href="{{ url('admin/price_list/'. $type .'/'.$value->id.'/edit') }}"
                                                               class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                               data-placement="bottom" title="" data-original-title="تعديل"><i
                                                                        class="fa fa-pencil"></i></a>
                                                    @endif
                                                    {{--<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $value->id }}"><i class="fa fa-trash-o"></i></a>--}}
                                                    <!-- Category Delete Modal -->
                                                        <div id="{{ $value->id }}" class="modal fade" role="dialog"
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
                                                                        <p>{{ __('backend.delete_category_message') }}</p>
                                                                    </div>
                                                                    <form method="post"
                                                                          action="{{ route('price_list.destroy', $value->id) }}">
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
                                                    </td>
                                                @endif
                                            </tr>
                                        @endif
                                @endforeach
                                </tbody>
                            </table>
                            {{ $list->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
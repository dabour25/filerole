@extends('layouts.admin', ['title' => __('strings.Price_list') ])

@section('content')

    <div class="page-title">
        <h3>{{ __('strings.Price_list') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>
                <li class="active">{{ __('strings.Price_list') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.index')
                <a class="btn btn-primary btn-lg btn-add" href="{{ route('price_list.create') }}" ><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('strings.Price_list_add') }}</a>
                <div role="tabpanel">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">{{ __('strings.Price_list') }}</h4>
                        </div>
                        <div class="panel-body">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('strings.Item_name') }}</th>
                                    <th>{{ __('strings.Price') }}</th>
                                    <th>{{ __('strings.Date') }}</th>
                                    <th>{{ __('strings.Tax') }}</th>
                                    <th>{{ __('strings.Status') }}</th>
                                    <th>{{ __('strings.Settings') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</td>
                                        <td>{{ $value->final_price !== null ? round($value->final_price, 3) : round($value->price, 3) }}</td>
                                        <td>{{ $value->date }}</td>
                                        <td>{{ $value->final_price == null ? 0 : $value->final_price - $value->price  }}</td>
                                        <td>
                                            @if($value->active)
                                                <span class="label label-success" style="font-size:12px;">{{ __('strings.Active') }}</span>
                                            @else
                                                <span class="label label-danger" style="font-size:12px;">{{ __('strings.Deactivate') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('price_list.edit', $value->id) }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="تعديل"><i class="fa fa-pencil"></i></a>
                                            {{--<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $value->id }}"><i class="fa fa-trash-o"></i></a>--}}
                                            <!-- Category Delete Modal -->
                                            <div id="{{ $value->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ __('backend.delete_category_message') }}</p>
                                                        </div>
                                                        <form method="post" action="{{ route('price_list.destroy', $value->id) }}">
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
                            {{ $list->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
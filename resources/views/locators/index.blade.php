@extends('layouts.admin', ['title' => __('strings.Locators') ])

@section('content')

    <!--<div class="page-title">-->
    <!--    <h3>@lang('strings.Locators')</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>-->
    <!--            <li class="active">@lang('strings.Locators')</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.index')
                @if(permissions('locators_add') == 1)
                <a class="btn btn-primary btn-lg btn-add" href="{{ route('locators.create') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('strings.locator_add')</a>
                @endif
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">@lang('strings.Locators')</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('strings.Locator_name')</th>
                                    <th>@lang('strings.Store_name')</th>
                                    <th>@lang('strings.Status')</th>
                                    @if(permissions('locators_edit') == 1)
                                        <th>@lang('strings.Settings')</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($locators as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->store_id == 0 ? '' : app()->getLocale() == 'ar' ? App\Stores::findOrFail($value->store_id)->name : App\Stores::findOrFail($value->store_id)->name_en }}</td>

                                            <td>
                                                @if($value->active)
                                                    <span class="label label-success" style="font-size:12px;">@lang('strings.Active')</span>
                                                @else
                                                    <span class="label label-danger" style="font-size:12px;">@lang('strings.Deactivate')</span>
                                                @endif
                                            </td>
                                            @if(permissions('locators_edit') == 1)
                                                <td>
                                                    <a href="{{ route('locators.edit', $value->id) }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="تعديل"><i class="fa fa-pencil"></i></a>

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
                                                                <form method="post" action="{{ route('locators.destroy', $value->id) }}">
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
                        </div>

                        {{ $locators->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
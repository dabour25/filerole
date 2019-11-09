@extends('layouts.admin', ['title' => __('strings.rates') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <style>
        td.details-control {
            background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
        }
    </style>
    <div id="main-wrapper">
        <div class="row">
            <div class="modal fade newModel" id="open-modal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body" style="overflow: hidden">

                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-12">
                @include('alerts.index')
                <div role="tabpanel">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">{{ __('strings.search') }}</h4>
                        </div>
                        <div class="panel-body">
                            <form action="">
                                {{csrf_field()}}
                                <div class="col-md-4 form-group">
                                    <label class="control-label" for="hotels">{{ __('strings.property_head') }}</label>
                                    <select class="form-control js-select" name="hotels">
                                        <option value="0"> @lang('strings.all') </option>
                                        @foreach(App\Property::where(['org_id' => Auth::user()->org_id])->get() as $v)
                                            <option {{ old('hotels') == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{ app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 form-group text-right">
                                    <label class="control-label" for=""></label>
                                    <button type="submit" class="btn btn-primary btn-lg"> <i class="fa fa-search"></i> {{ __('strings.search') }} </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div role="tabpanel">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">{{ __('strings.rates') }}</h4>
                        </div>
                        <div class="panel-body">
                            <table id="xtreme-table" class="display table dataTable no-footer" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th style="display:none ">#</th>
                                    <th>{{ __('strings.property_head') }}</th>
                                @if(permissions('rates_smart_pricing') == 1)
                                    <!--th>{{ __('strings.Settings') }}</th-->
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $value)
                                    <tr>
                                        <td class="details-control"></td>
                                        <td style="display:none ">{{ $value->id }}</td>
                                        <td>{{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</td>
                                    @if(permissions('rates_smart_pricing') == 1)
                                        <!--td>
                                                <a href="{{ url('admin/rates/smart', $value->id) }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="@lang('strings.smart_pricing_add')"><i class="fa fa-plus"></i></a>
                                            </td-->
                                        @endif
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
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

    <script>
        function format(d) {
            var table1;
            var programs = '';
            if (d != []) {
                $.each(d, function (key, item) {
                    programs += '<tr>';
                    programs += '<td>' + item.name + '</td>';
                    programs += '<td>' + item.type + '</td>';
                    programs += ' <td> @if(permissions('rates_add') == 1) <a href="{{ url('admin/rates/create') }}?id='+ item.id +'"\n' +
                        '                                                           class="btn btn-primary btn-xs" data-toggle="tooltip" target="_blank"\n' +
                        '                                                           data-placement="bottom" title="" data-original-title="اضافة سعر"><i\n' +
                        '                                                                    class="fa fa-plus"></i></a> @endif\n' +
                        '<a href="#"\n' +
                        '                                                           class="btn btn-primary btn-xs search" id="'+ item.id +'" data-toggle="tooltip"\n' +
                        '                                                           data-placement="bottom" title="" data-original-title="عرض السعر"><i\n' +
                        '                                                                    class="fa fa-search"></i></a>'+
                        ' @if(permissions('rates_delete') == 1) <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#' + item.id + '"><i class="fa fa-trash-o"></i></a> @endif\n' +
                        '\n' +
                        '                                        <!-- Delete Modal -->\n' +
                        '                                            <div id="' + item.id + '" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">\n' +
                        '                                                <div class="modal-dialog">\n' +
                        '                                                    <!-- Modal content-->\n' +
                        '                                                    <div class="modal-content">\n' +
                        '                                                        <div class="modal-header">\n' +
                        '                                                            <button type="button" class="close" data-dismiss="modal"> &times; </button>\n' +
                        '                                                            <h4 class="modal-title">{{ __('strings.confirm') }}</h4>\n' +
                        '                                                        </div>\n' +
                        '                                                        <div class="modal-body">\n' +
                        '                                                            <p>{{ __('strings.delete_modal_message') }}</p>\n' +
                        '                                                        </div>\n' +
                        '                                                        <form method="post" action="{{ url('admin/rates') }}/' + item.id + '/destroy">\n' +
                        '                                                            <div class="modal-footer">\n' +
                        '                                                                {{csrf_field()}}\n' +
                        '                                                                {{ method_field('DELETE') }}\n' +
                        '                                                                <button type="submit" class="btn btn-danger">{{ __('strings.delete_btn') }}</button>\n' +
                        '                                                                <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('strings.no') }}</button>\n' +
                        '                                                            </div>\n' +
                        '                                                        </form>\n' +
                        '                                                    </div>\n' +
                        '                                                </div>\n' +
                        '                                            </div>\n</td>';
                    programs += '</tr>';
                });
            }

            table1 = '<table class="table">\n' +
                '\t\t\t\t\t\t\t<thead>\n' +
                '\t\t\t\t\t\t\t\t<tr>\n' +
                '\t\t\t\t\t\t\t\t\t<th>@lang('strings.room_name')</th>\n' +
                '\t\t\t\t\t\t\t\t\t<th>@lang('strings.room_type')</th>\n' +
                '\t\t\t\t\t\t\t\t\t @if(permissions('rates_add') == 1 || permissions('rates_delete') == 1)<th>@lang('strings.Settings')</th>@endif \n' +
                '\t\t\t\t\t\t\t\t</tr>\n' +
                '\t\t\t\t\t\t\t</thead>\n' +
                '\t\t\t\t\t\t\t<tbody>\n' +
                programs +
                '\t\t\t\t\t\t\t</tbody>\n' +
                '\t\t\t\t\t\t</table>';


            return table1
        }

        var table = $('#xtreme-table').DataTable({
            "language": {
                @if(app()->getLocale() == "en")
                "url": "{{ asset('plugins/datatables/lang/en.json') }}",
                @elseif(app()->getLocale() == "ar")
                "url": "{{ asset('plugins/datatables/lang/ar.json') }}",
                @endif
            },
            "ordering": false
        });
        $.fn.dataTable.ext.errMode = 'none';

        $('#xtreme-table tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                $.get("{{ url('admin/rates/get-rooms/') }}/" + row.data()[1], function (data) {
                    row.child(format(data)).show();
                });
                tr.addClass('shown');
            }
        });

        $(document).on('click', '.search', function () {
            jQuery('#open-modal').modal('show', {backdrop: 'true'});

            $.ajax({
                url: '{{ url('admin/rates/get-details') }}/' + $(this).attr('id'),
                success: function (response) {
                    jQuery('#open-modal .modal-body').html(response);
                }
            });
            return false;
        });
    </script>
@endsection
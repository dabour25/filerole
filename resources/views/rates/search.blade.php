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

            <div class="col-md-12">
               <div class="alert_new">
                    <span class="alertIcon">
                        <i class="fas fa-exclamation-circle"></i>
                    </span>
                    <p>
                        @if (app()->getLocale() == 'ar')
                            {{ DB::table('function_new')->where('id',253)->value('description') }}
                        @else
                            {{ DB::table('function_new')->where('id',253)->value('description_en') }}
                        @endif
                    </p>
                    <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i> </a>
                </div>
                @include('alerts.index')
                <div role="tabpanel">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">{{ __('strings.search') }}</h4>
                        </div>
                        <div class="panel-body">
                            <form action="">
                                {{csrf_field()}}
                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="hotels">{{ __('strings.property_head') }}</label>
                                    <select class="form-control js-select" name="hotels">
                                        <option value="0"> @lang('strings.all') </option>
                                        @foreach(App\Property::where(['org_id' => Auth::user()->org_id])->get() as $v)
                                            <option {{ app('request')->input('hotels') == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{ app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="room_type">{{ __('strings.room_type') }}</label>
                                    <select class="form-control js-select" name="room_type">
                                        <option value="0"> @lang('strings.all') </option>
                                        @foreach(App\CategoriesType::where(['type' => 7,'org_id' => Auth::user()->org_id])->get() as $v)
                                            <option {{ app('request')->input('room_type') == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{ app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="hotels">{{ __('strings.date_from') }}</label>
                                    <input class="form-control" name="date_from" type="date" value="{{ app('request')->input('date_from', date('Y-m-d')) }}">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label class="control-label" for="hotels">{{ __('strings.date_to') }}</label>
                                    <input class="form-control" name="date_to" type="date" value="{{ app('request')->input('date_to', date('Y-m-d')) }}">
                                </div>

                                <div class="col-md-12 form-group">
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
                            <h4 class="panel-title">{{ __('strings.categories_and_services') }}</h4>
                        </div>
                        <div class="panel-body">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th style="display:none ">#</th>
                                        <th>@lang('strings.room_name')</th>
                                        <th>{{ __('strings.date') }}</th>
                                        <th>{{ __('strings.hotel_room_price') }}</th>
                                        <th>{{ __('strings.tax') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list as $value)
                                        @if(App\PriceList::where(['org_id' =>  Auth::user()->org_id, 'cat_id' => $value->cat_id])->orderBy('date', 'DESC')->first()->id == $value->id)
                                        <tr>
                                            <td class="details-control"></td>
                                            <td style="display:none ">{{ $value->cat_id }}</td>
                                            <td>{{ App\Category::where('id', $value->cat_id)->value('name')  }}</td>
                                            <td>{{ $value->date }}</td>
                                            <td>{{ Decimalplace($value->final_price) }}</td>
                                            <td>{{ Decimalplace($value->final_price - $value->price) }}</td>
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
    <script>
        function format(d) {
            var table1;
            var programs = '';
            if (d != []) {
                $.each(d, function (key, item) {
                    programs += '<tr>';
                    programs += '<td ></td>';
                    programs += '<td>' + item.name + '</td>';
                    programs += '<td>' + item.price + '</td>';
                });
            }

            table1 = '<table class="table">\n' +
                '\t\t\t\t\t\t\t<thead>\n' +
                '\t\t\t\t\t\t\t\t<tr>\n' +
                '\t\t\t\t\t\t\t\t\t<th></th>\n' +
                '\t\t\t\t\t\t\t\t\t<th>@lang('strings.name')</th>\n' +
                '\t\t\t\t\t\t\t\t\t<th>@lang('strings.price')</th>\n' +
                '\t\t\t\t\t\t\t\t</tr>\n' +
                '\t\t\t\t\t\t\t</thead>\n' +
                '\t\t\t\t\t\t\t<tbody>\n' +
                programs +
                '\t\t\t\t\t\t\t</tbody>\n' +
                '\t\t\t\t\t\t</table>';


            return table1
        }

        $(document).ready(function () {
            var table = $('#xtreme-table').DataTable({
                "language": {
                    @if(app()->getLocale() == "en")
                    "url": "{{ asset('plugins/datatables/lang/en.json') }}"
                    @elseif(app()->getLocale() == "ar")
                    "url": "{{ asset('plugins/datatables/lang/ar.json') }}"
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
                    $.get("{{ url('admin/rates/get-fees/') }}/" + row.data()[1], function (data) {
                        row.child(format(data)).show();
                    });
                    tr.addClass('shown');
                }
            });
        });
    </script>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
@endsection
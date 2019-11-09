@extends('layouts.admin', ['title' => __('strings.add') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="row">
            @include('alerts.index')

            <div class="" style=" text-align: center !important;">
                <h1>@lang('strings.show_prices_and_eating')</h1>
                <br>
                <h2 ><strong>{{app()->getLocale() == 'ar'? $room->name :$room->name_en}}</strong></h2>
                <br>
                <a href="{{url('admin/rooms')}}">
                    <button type="button" class="btn btn-info btn-lg">@lang('strings.rooms')</button>
                </a>
                <br>
                <br>
                <a href="{{url('admin/rooms/create/prices/'.$room->id)}}"><button class="btn btn-primary">@lang('strings.add_prices_and_eating')</button></a>

            </div>
            <hr>
            <br>
            <div class="col-md-12">
                <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <div class="col-md-12">
                                <h4 class="panel-title">{{ __('strings.kinds-prices')}}  - {{ app()->getLocale() == 'ar' ?$room->name:$room->name_en }}</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <table id="tab_items" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>@lang('strings.add_from_age')</th>
                                        <th>@lang('strings.add_to_age')</th>
                                        <th>@lang('strings.price')</th>
                                        <th>@lang('strings.Settings')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($kids as $kid)
                                    <tr id='row-1'>
                                        <td>
                                            {{$kid->age_from}}
                                        </td>
                                        <td>
                                            {{$kid->age_to}}
                                        </td>
                                        <td>
                                            {{$kid->price}}
                                        </td>
                                        <td>
                                            <a href="#" class="delete_row_2" data-toggle="tooltip" data-placement="bottom" data-original-title=""><i class="fa fa-close"></i></a>
                                        </td>
                                    </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="panel-heading clearfix">
                            <div class="col-md-12">
                                <h4 class="panel-title">{{ __('strings.prices_additional_')}} - {{ app()->getLocale() == 'ar' ?$room->name:$room->name_en }}</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table id="tab_item" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>@lang('strings.type')</th>
                                    <th>@lang('strings.price')</th>
                                    <th>@lang('strings.Settings')</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($additionals as $addit)
                                <tr id='row-1'>
                                    <td>
                                        {{app()->getLocale() == 'ar'? $addit->sub_ar:$addit->sub_en}}
                                    </td>
                                    <td>
                                        {{$addit->price}}
                                    </td>
                                    <td>
                                        <a href="#" class="delete_row" data-toggle="tooltip" data-placement="bottom" data-original-title=><i class="fa fa-close"></i></a>
                                    </td>
                                </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <a href="{{url('admin/rooms/create/prices/'.$room->id)}}" class="btn btn-default pull-left">@lang('strings.add_prices_and_eating')</a>
                                </div>
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
        function addphoto(){
            var row = $("#tab_items tr").last().clone().find('input').val('').end();
            var oldId = Number(row.attr('id').slice(-1));
            var id = 1 + oldId;
            row.attr('id', 'row-' + id );
            row.find('#ids-' + oldId).attr('id', 'ids-' + id).attr('value', {{ App\CategoriesType::where(['type' => 9, 'active' => 1,'org_id' => Auth::user()->org_id])->value('id') }});
            $('#tab_items').append(row);
        }

        function addprice(){
            var row = $("#tab_item tr").last().clone().find('input').val('').end();
            var oldId = Number(row.attr('id').slice(-1));
            var id = 1 + oldId;
            row.attr('id', 'row-' + id );

            $('#tab_item').append(row);
        }

        $(document).on('click', '.delete_row', function () {
            if($('#tab_item tbody tr').length != 1 && $(this).closest('tr').attr('id') != 'row-1') {
                $(this).closest('tr').remove();
                return false;
            }
        });
        $(document).on('click', '.delete_row_2', function () {
            if($('#tab_items tbody tr').length != 1 && $(this).closest('tr').attr('id') != 'row-1') {
                $(this).closest('tr').remove();
                return false;
            }
        });

        $( "#price, #tax_type" ).change(function() {
            $.get("{{ url('admin/rates/check-tax') }}/" + $('#tax_type :selected').val() + '/' + parseFloat($('#price').val()), function (data) {
                $('#final_price').val(data);
            });
        });
    </script>
@endsection
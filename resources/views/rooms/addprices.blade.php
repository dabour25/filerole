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
            </div>
            <hr>
            <br>
            <div class="col-md-12">
                <div class="panel panel-white">
                          <div class="" style=" text-align: center !important;">
                            <p style="font-size: 25px;">{{__('strings.lastPrices')}}</p>
                        <p style="font-size: 20px;">{{cat_price($room->id)['catPrice']!=null?cat_price($room->id)['catPrice']:0}}</p>
                        </div>
                    <form method="post" action="{{url('admin/rooms/create/prices')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="room" value="{{$room->id}}">
                        <div class="panel panel-white">
                            <div class="panel-heading clearfix">
                                <h4 class="panel-title">{{ __('strings.kinds-prices')}}  - {{ app()->getLocale() == 'ar' ?$room->name:$room->name_en }}</h4>
                            </div>
                            <div class="panel-body">
                                <table id="xtreme-table" class="table table-striped table-bordered"
                                       style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>@lang('strings.chalid_from')</th>
                                        <th>@lang('strings.price')</th>
                                        <th>@lang('strings.Settings')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($kids as $kid)
                                        <tr>
                                            <td>{{$kid->room_ar}}
                                            <td>{{$kid->price}}</td>
                                            <td>

                                                <a href="{{url('admin/rooms/my-prices/del/'.$kid->id)}}"
                                                   class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                   data-placement="bottom" title=""
                                                   data-original-title="{{ __('strings.remove') }} "
                                                   @if(app()->getLocale() == 'ar')
                                                   onclick="return confirm('تتاكيد حذف تاريخ الاغلاق')"
                                                   @else
                                                   onclick="return confirm('Are you sure?')"
                                                        @endif
                                                > <i
                                                            class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary" onclick="add_date()"><i
                                    class="fas fa-plus"></i>اضافه سعر اطفال جديد
                        </button>

                        <div class="panel-heading clearfix">
                            <div class="col-md-12">
                                <h4 class="panel-title">{{ __('strings.prices_additional_')}}</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table id="ztreme-table" class="table table-striped table-bordered"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>@lang('strings.type')</th>
                                    <th>@lang('strings.price')</th>
                                    <th>@lang('strings.Settings')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($additionals as $add)
                                    <tr>
                                        <td>{{$add->room_ar}}</td>
                                        <td>{{$add->price}}</td>
                                        <td>
                                            <a href="{{url('admin/rooms/my-prices/del/'.$add->id)}}"
                                               class="btn btn-primary btn-xs" data-toggle="tooltip"
                                               data-placement="bottom" title=""
                                               data-original-title="{{ __('strings.remove') }} "
                                               @if(app()->getLocale() == 'ar')
                                               onclick="return confirm('تتاكيد حذف تاريخ الاغلاق')"
                                               @else
                                               onclick="return confirm('Are you sure?')"
                                                    @endif
                                            > <i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>

                        <button type="button" class="btn btn-primary" onclick="addithonal_()"><i
                                    class="fas fa-plus"></i>اضافه اسعار اضافيه جديد
                        </button>


                        <div class="col-md-12 form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg" id="button_submit"> @lang('strings.Save') </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
 
    <script>
        function add_date() {
            var data = '<tr>\n' +
                '<td class="reg_flagg">\n' +
                '<select class="form-control" id="type-1" name="catsub_id[]" required>\n'+
                ' <option value="0">@lang("strings.select")</option>'+
                ' @foreach($mytypes as $value)' +
                '<option value="{{ $value->id }}">{{ app()->getLocale() == "ar" ? $value->name : $value->name_en }}</option>\n'+
                ' @endforeach'+
                '</select>'+
                '</td>\n' +
                '<td>\n' +
                ' <input name="price[]" class="form-control" type="number">' +
                '</td>\n' +
                '<td>\n' +
                '<button type="button" id="deltr" style="color: red;"   class="btn btn-defult btn-close-regust2"><i class="fas fa-times"></i></button>\n' +
                '</td>\n' +
                '</tr>';


            $('#xtreme-table tbody').append(data);
        }


        $("#xtreme-table").on('click', '.btn-close-regust2', function () {
            var minus = 0, plus = 0;
            if ($(this).parents('tr').find('.reg_flagg select').val() == -1) {
                minus = $('.finalTotalPrice').text() - $(this).parents('tr').find('.fPrice').text();
                $('.finalTotalPrice').text(minus);
            } else if ($(this).parents('tr').find('.reg_flagg select').val() == 1) {
                plus = $('.finalTotalPrice').text() + $(this).parents('tr').find('.fprice_1').text();
                $('.finalTotalPrice').text(plus);
            }
            $(this).parents('tr').remove();
        });


        function addithonal_() {
            var data = '<tr>\n' +
                '<td>\n' +
                    '<select class="form-control" id="type-1" name="catsub_id[]" required>\n'+
                    ' <option value="0">@lang("strings.select")</option>'+
                ' @foreach($types as $value)' +
                    '<option value="{{ $value->id }}">{{ app()->getLocale() == "ar" ? $value->name : $value->name_en }}</option>\n'+
                    ' @endforeach'+
                    '</select>'+
                '</td>\n' +
                '<td>\n' +
                '<input name="price[]" class="form-control" type="number">\n' +
                '</td>\n' +
                '<td>\n' +
                '<button type="button" id="deltr" style="color: red;"   class="btn btn-defult btn-close-regust2"><i class="fas fa-times"></i></button>\n' +
                '</td>\n' +
                '</tr>';


            $('#ztreme-table tbody').append(data);
        }

        $("#ztreme-table").on('click', '.btn-close-regust2', function () {
            var minus = 0, plus = 0;
            if ($(this).parents('tr').find('.reg_flagg select').val() == -1) {
                minus = $('.finalTotalPrice').text() - $(this).parents('tr').find('.fPrice').text();
                $('.finalTotalPrice').text(minus);
            } else if ($(this).parents('tr').find('.reg_flagg select').val() == 1) {
                plus = $('.finalTotalPrice').text() + $(this).parents('tr').find('.fprice_1').text();
                $('.finalTotalPrice').text(plus);
            }
            $(this).parents('tr').remove();
        });



    </script>
@endsection
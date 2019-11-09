@extends('layouts.admin', ['title' => __('strings.room_num')])
<!-- Last Modified  02/05/2019 15:14:52  -->
@section('content')
    <style>


        .panel-body form{
            padding: 20px;
        }
        .panel-body button,.panel-body a{
            margin-left: 20px;
            padding: 6px 20px;
            font-size: 15px;
        }
        #search_form > div.col-md-12.form-group.text-right > div{
            float: left;
            font-size: 1.2em;
            font-weight: 600;
            color: red;
            display: none;
        }
    </style>


    <div class="main_wrapper">
        <div class="panel panel-white">
            <div class="panel-body">
                <form method="post" action="{{url('admin/rooms/number/filter')}}">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                            <label>@lang('strings.choose_destinations')</label>

                            <select class="form-control js-select " name="destinations">
                                <option value="">@lang('strings.All')</option>
                                @foreach($destinations as $dest)
                                    <option {{ app('request')->input('destinations') == $dest->id ? 'selected' : ''}} value="{{$dest->id}}">{{app()->getLocale() == 'ar' ?$dest->name : $dest->name_en}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                            <label>@lang('strings.choose_property')</label>
                            <select class="form-control  js-select " name="property">
                                <option value="">@lang('strings.All')</option>
                                    @foreach($property as $pro)
                                    <option {{ app('request')->input('property') == $pro->id ? 'selected' : ''}}  value="{{$pro->id}}">{{app()->getLocale() == 'ar' ?$pro->name : $pro->name_en}}</option>
                                     @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                            <label>@lang('strings.choose_type_room')</label>
                            <select class="form-control js-select" name="types">
                                <option value="">@lang('strings.All')</option>
                                @foreach($types as $type)
                                    <option {{ app('request')->input('types') == $type->id ? 'selected' : ''}} value="{{$type->id}}">{{ app()->getLocale() == 'ar' ? $type->name  : $type->name_en  }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                            <label>@lang('strings.choose_amints')</label>
                            <select class="form-control js-select" name="amentities">
                                <option value="">@lang('strings.All')</option>
                                @foreach($amentities as $ament)
                                    <option {{ app('request')->input('amentities') == $ament->id ? 'selected' : ''}} value="{{$ament->id}}">{{ app()->getLocale() == 'ar' ? $ament->name  : $ament->name_en  }}</option>
                                @endforeach
                            </select>
                        </div>
                      <div>
                          <label>@lang('strings.Closed_in_period')</label>
                      </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                            <div class="input-group text">
                                <label>@lang('strings.Date_fromm')</label>
                                <input name="date_from" id="date_from" type="text" value="{{ app('request')->input('date_from') }}" class="form-control datepicker_reservation">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                            <div class="input-group text">
                                <label>@lang('strings.Date_too')</label>
                                <input name="date_to" id="date_to" type="text" value="{{ app('request')->input('date_to') }}" class="form-control datepicker_reservation2">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 form-group text-right">
                        <button id="search_button" type="submit" class="btn btn-primary">{{__('strings.Search')}}</button>
                    </div>


                </form>
            </div>

        </div>
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <h4 class="panel-title">@lang('strings.reservation')</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="xtreme-table" class="display table"
                           style="width: 100%; cellspacing: 0;">
                        <thead>
                        <tr>
                            <th>@lang('strings.hotel')</th>
                            <th>@lang('strings.room_type')</th>
                            <th>@lang('strings.cat_num')</th>
                            <th>@lang('strings.rooms_amints')</th>
                            <th>@lang('strings.cloth_day')</th>
                            <th>@lang('strings.Settings')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cateNum as $cate)
                            <tr>
                                <td>{{$cate->pro_name }}</td>
                                <td>{{$cate->cate_type_name }}</td>
                                <td>{{$cate->cat_num }}</td>
                                <td>
                                    @if(!empty($cate->facility))
                                       <ul>
                                         @foreach($cate->facility as $fac)
                                           <li>{{$fac->cateogry_name}}</li>
                                         @endforeach
                                       </ul>
                                    @endif
                                </td>
                                @if(count($cate->cloth) !=0)
                                <td>
                                    <table style="width: 100%;">
                                        <tr>
                                            <th>{{ __('strings.from_date') }}</th>
                                            <th>{{ __('strings.To_date') }}</th>
                                            <th>{{ __('strings.reason') }}</th>
                                        </tr>

                                        @foreach($cate->cloth as $mycloth)
                                        <tr>
                                            <td>{{$mycloth->date_from}}</td>
                                            <td>{{$mycloth->date_to}}</td>
                                            <td>{{$mycloth->reason}}</td>

                                        </tr>
                                         @endforeach
                                    </table>
                                </td>
                                    @else
                                   <td> </td>
                                @endif
                                <td><a href="{{url('admin/rooms/number/updated/'.$cate->id)}}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="{{ __('strings.edit') }}" data-original-title="{{ __('strings.delete_btn') }}"> <i class="fa fa-pencil"></i></a>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            var reservation_date = new Date();
            $(".datepicker_reservation").datepicker({

                date: reservation_date,
             
                rtl: true,
                viewMode: 'years',
                format: 'yyyy-mm-dd',


            }).on('changeDate', function (e) {
                var date2 =
                    $('.datepicker_reservation').datepicker('getDate', '+1d');
                date2.setDate(date2.getDate() + 1);

                var msecsInADay = 8640000;
                var endDate = new Date(date2.getTime() + msecsInADay);
                $('.datepicker_reservation2').datepicker('setStartDate', endDate);
                $('.datepicker_reservation2').datepicker('setDate', endDate);


            });


            $('.datepicker_reservation2').datepicker({

                format: 'yyyy-mm-dd',
            });
        });


    </script>
@endsection



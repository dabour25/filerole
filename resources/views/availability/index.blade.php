@extends('layouts.admin', ['title' => __('strings.availability_matrix') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div id="main-wrapper">
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
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">@lang('strings.availability_matrix')</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <div class="jus_tap" style="min-height: 130px;">
                                <div role="tabpanel">
                                    <form action="" method="GET">
                                        <div class="col-md-3 form-group">
                                            <label class="control-label" for="date">@lang('strings.hotels') </label>
                                            <select class="form-control js-select" name="hotels" required>
                                                <option value="0">@lang('strings.select')</option>
                                                @foreach(App\Property::where(['org_id' => Auth::user()->org_id])->get() as $v)
                                                    <option {{ app('request')->input('hotels') == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{   app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label class="control-label" for="date">@lang('strings.date_from') </label>
                                            <input type="date" class="form-control" name="date_from" value="{{ app('request')->input('date_from', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" onkeydown="return false">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label class="control-label" for="date">@lang('strings.date_to') </label>
                                            <input type="date" class="form-control" name="date_to" value="{{ app('request')->input('date_to', date('Y-m-d', strtotime(date('Y-m-d') . "+14 days"))) }}" min="{{ date('Y-m-d') }}" onkeydown="return false">
                                        </div>
                                        <div class="col-md-3 form-group text-right">
                                            <label class="control-label" for="categories_types"></label>
                                            <button type="submit" class="btn btn-primary btn-lg"> <i class="fa fa-search"></i> {{ __('strings.search') }} </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @php
                                $date_from = date('Y-m-d'); $date_to = date('Y-m-d', strtotime(date('Y-m-d') . "+14 days"));
                                if(!empty(app('request')->input('date_from'))){
                                    $date_from = app('request')->input('date_from');
                                }
                                if(!empty(app('request')->input('date_to'))){
                                    $date_to = app('request')->input('date_to');
                                }
                                $period = new DatePeriod(
                                     new DateTime($date_from),
                                     new DateInterval('P1D'),
                                     new DateTime($date_to)
                                );
                            @endphp
                            <table id="" class="display table">
                                <thead>
                                <tr>
                                    <th>{{ date('M-Y') }}</th>
                                </tr>
                                <tr>
                                    <th>@lang('strings.room_type') /  @lang('strings.day') </th>
                                    @foreach($period as $value)
                                        <th>{{ $value->format('d') }}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rooms as $val)
                                    <tr>
                                        <td style="font-weight: bold">{{ app()->getLocale() == 'ar' ? $val->name : $val->name_en }}  - {{ $val->category_name }}</td>
                                        @foreach($period as $value)
                                            @php
                                                $currency = App\Currency::where('id', App\org::where('id', Auth::user()->org_id)->value('currency'))->value(app()->getLocale() == 'ar' ? $name = 'name' : $name = 'name_en');
                                                $currency = $currency != '' ? $currency : '';
                                            @endphp
                                            @if(App\PriceList::where(['cat_id' => $val->cat_id])->where('date', '<=', $value->format('Y-m-d'))->exists() )
                                                <td>
                                                    <div class="input-group" style="direction: ltr">
                                                        <div class="input-group-addon">
                                                            <span class="input-group-text">{{ $currency }}</span>
                                                        </div>
                                                        <input onchange="edit_price('{{ $val->cat_id }}','{{ $value->format('Y-m-d') }}', '{{ App\PriceList::where(['cat_id' => $val->cat_id])->where('date', '<=',$value->format('Y-m-d'))->value('tax') }}', this)" type="number" class="form-control" value="{{ App\PriceList::where(['cat_id' => $val->cat_id])->where('date', '<=', $value->format('Y-m-d'))->value('final_price') }}" style="width:80px">
                                                    </div>
                                                </td>
                                            @else
                                                <td>
                                                    <div class="input-group" style="direction: ltr">
                                                        <div class="input-group-addon">
                                                            <span class="input-group-text">{{ $currency }}</span>
                                                        </div>
                                                        <input onchange="edit_price('{{ $val->cat_id }}','{{ $value->format('Y-m-d') }}', '{{ App\PriceList::where(['cat_id' => $val->cat_id])->where('date', '>=',$value->format('Y-m-d'))->value('tax') }}', this)" type="number" class="form-control" value="{{ App\PriceList::where(['cat_id' => $val->cat_id])->where('date', '>=', $value->format('Y-m-d'))->value('final_price') }}" style="width:80px">
                                                    </div>
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="">متاح للبيع</td>
                                        @foreach($period as $value)
                                            <td>{{ App\CategoryNum::where(['cat_id' => $val->cat_id])->count() }}</td>
                                        @endforeach
                                    </tr>
                                    
                                    <tr>
                                        <td class="">محجوز موكد</td>
                                        @foreach($period as $value)
                                                <td>{{ App\BookingDetails::where(['cat_id' => $val->cat_id, 'room_status' => 'y'])->join('bookings', 'bookings.id', '=', 'booking_detail.book_id')->whereRaw('? between book_from and book_to', [ $value->format('Y-m-d') ])->whereNull('booking_detail.checkin_dt')->whereNull('booking_detail.checkout_dt')->count() }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="">مشغول</td>
                                        @foreach($period as $value)
                                            <td>{{ App\BookingDetails::where(['cat_id' => $val->cat_id, 'room_status' => 'y'])->join('bookings', 'bookings.id', '=', 'booking_detail.book_id')->whereRaw('? between book_from and book_to', [ $value->format('Y-m-d') ])->whereNotNull('booking_detail.checkin_dt')->whereNull('booking_detail.checkout_dt')->where('booking_detail.checkin_dt', '<=', $value->format('Y-m-d'))->count() }}</td>

                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="">مغلق</td>
                                        @foreach($period as $value)
                                            <td>{{ App\CategoryNum::join('closing_dates_list', 'closing_dates_list.category_num_id', '=' , 'category_num.id')->where('category_num.cat_id', $val->cat_id)->whereRaw('? between closing_dates_list.date_from and closing_dates_list.date_to', [ $value->format('Y-m-d') ])->count() }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="">الباقي</td>
                                        @php $confirm=0; $inouse=0; $closed=0; @endphp
                                        @foreach($period as $value)
                                            @php
                                                $confirm = App\BookingDetails::where(['cat_id' => $val->cat_id, 'room_status' => 'y'])->join('bookings', 'bookings.id', '=', 'booking_detail.book_id')->whereRaw('? between book_from and book_to', [ $value->format('Y-m-d') ])->whereNull('booking_detail.checkin_dt')->whereNull('booking_detail.checkout_dt')->count();
                                                $inouse = App\BookingDetails::where(['cat_id' => $val->cat_id, 'room_status' => 'y'])->join('bookings', 'bookings.id', '=', 'booking_detail.book_id')->whereRaw('? between book_from and book_to', [ $value->format('Y-m-d') ])->whereNotNull('booking_detail.checkin_dt')->whereNull('booking_detail.checkout_dt')->where('booking_detail.checkin_dt', '<=', $value->format('Y-m-d'))->count();
                                                $closed = App\CategoryNum::join('closing_dates_list', 'closing_dates_list.category_num_id', '=' , 'category_num.id')->where('category_num.cat_id', $val->cat_id)->whereRaw('? between closing_dates_list.date_from and closing_dates_list.date_to', [ $value->format('Y-m-d') ])->count();
                                            
                                            @endphp
                                            <td class="">{{ App\CategoryNum::where(['cat_id' => $val->cat_id])->count() - ($confirm + $inouse + $closed) }}</td>
                                        @endforeach
                                    </tr>
                                    @if(count($rooms) != 1)
                                        <tr>
                                            <td style="background: #0b0b0b"></td>
                                            @foreach($period as $value)
                                                <td style="background: #0b0b0b"></td>
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
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
        function edit_price(cat_id, date, tax, e){
            $.ajax({
                url: '{{ url('admin/ajax/availability_update_price') }}', type: 'POST', data: { cat_id:cat_id, date:date, tax:tax, value:e.value ,_token: '{{csrf_token()}}' },
                success: function (response) {
                    if(response.status == 200){
                        $(e).parent().children('input').val( response.data.final_price );
                        $(e).parent().nextAll().children('input').val( response.data.final_price );
                    }
                }
            });
            return false;
        }
    </script>
@endsection
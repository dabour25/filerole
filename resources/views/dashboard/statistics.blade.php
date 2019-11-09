@extends('layouts.admin', ['title' => __('strings.statistics')])

@section('styles')

@endsection

@section('content')
    <div id="main-wrapper" class="main-wrapper-index">
        <div class="content-dash">
            <div class="row">
                <!-- information -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="bg-white">
                        <div class="title-card">
                            <h3>@lang('strings.statistics')</h3>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p class="counter">{{ round(AvailableRooms($id, date('Y-m-d'))['reserved'] / AvailableRooms($id, date('Y-m-d'))['available'] * 100) }} %</p>
                                        <span class="info-box-title">@lang('strings.rooms_occupied')</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="fas fa-building"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p class="counter">{{ App\Bookings::where(['bookings.property_id' => $id,'bookings.org_id' => Auth::user()->org_id])->join('booking_detail', 'booking_detail.book_id', '=', 'bookings.id')->whereDate('booking_detail.checkin_dt', date('Y-m-d'))->whereNotNull('booking_detail.checkin_dt')->orderBy('bookings.created_at', 'DESC')->count() }}</p>
                                        <span class="info-box-title">{{ __('strings.arrivals') }}</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="fas fa-plane-arrival"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="panel info-box panel-white">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p class="counter">{{ App\Bookings::where(['bookings.property_id' => $id,'bookings.org_id' => Auth::user()->org_id])->join('booking_detail', 'booking_detail.book_id', '=', 'bookings.id')->whereDate('booking_detail.checkout_dt', date('Y-m-d'))->whereNotNull('booking_detail.checkout_dt')->orderBy('bookings.created_at', 'DESC')->count() }}</p>
                                        <span class="info-box-title">{{ __('strings.departure') }}</span>
                                    </div>
                                    <div class="info-box-icon">
                                        <i class="fas fa-plane-departure"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                <div class="col-md-6 col-xs-12">
                    <div class="bg-white">
                        <div class="title-card">
                            <h3>@lang('strings.today_activity')</h3>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#sales">@lang('strings.sales')</a></li>
                            <li><a data-toggle="tab" href="#cancellations">@lang('strings.cancellations')</a></li>
                            <li><a data-toggle="tab" href="#overbookings">@lang('strings.overbookings')</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="sales" class="tab-pane fade in active">
                                <table class="table table-sm table-hover table-align-middle m-b-0" style="display: table;">
                                    <thead class="transparent">
                                        <tr>
                                            <th>@lang('strings.booked_today'): {{ App\Bookings::where(['property_id' => $id,'org_id' => Auth::user()->org_id, 'book_status' => 'y'])->whereDate('created_at', date('Y-m-d'))->count() }}</th>
                                            <th>@lang('strings.revenue'): {{ Decimalplace(App\Bookings::where(['property_id' => $id,'org_id' => Auth::user()->org_id, 'book_status' => 'y'])->whereDate('created_at', date('Y-m-d'))->sum('pay_amount')) }}</th>
                                            <th>@lang('strings.room_nights'): {{ App\Bookings::where(['property_id' => $id,'org_id' => Auth::user()->org_id, 'book_status' => 'y'])->whereDate('created_at', date('Y-m-d'))->sum('nights') }}</th>
                                        </tr>
                                        <tr>
                                            <th>@lang('strings.guest')</th>
                                            <th>@lang('strings.payments')</th>
                                            <th>@lang('strings.from_date')</th>
                                            <th>@lang('strings.nights')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(App\Bookings::where(['property_id' => $id,'org_id' => Auth::user()->org_id, 'book_status' => 'y'])->whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'DESC')->get() as $value)
                                        <tr>
                                            <td>{{ app()->getLocale() == 'ar' ? App\Customers::where('id', $value->cust_id)->value('name') : App\Customers::where('id', $value->cust_id)->value('name_en')}}</td>
                                            <td>{{ Decimalplace($value->pay_amount) }}</td>
                                            <td>{{ $value->book_from }}</td>
                                            <td>{{ $value->nights }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div id="cancellations" class="tab-pane fade">
                                <table class="table table-sm table-hover table-align-middle m-b-0" style="display: table;">
                                    <thead class="transparent">
                                        <tr>
                                            <th>@lang('strings.cancelled_today'): {{ App\Bookings::where(['bookings.property_id' => $id,'bookings.org_id' => Auth::user()->org_id, 'book_status' => 'c'])->join('booking_detail', 'booking_detail.book_id', '=', 'bookings.id')->whereDate('booking_detail.cancel_dt', date('Y-m-d'))->count() }}</th>
                                            <th>@lang('strings.cancel_charge'): {{ Decimalplace(App\Bookings::where(['bookings.property_id' => $id,'bookings.org_id' => Auth::user()->org_id, 'book_status' => 'c'])->join('booking_detail', 'booking_detail.book_id', '=', 'bookings.id')->whereDate('booking_detail.cancel_dt', date('Y-m-d'))->sum('booking_detail.cancel_charge')) }}</th>
                                        </tr>
                                        <tr>
                                            <th>@lang('strings.guest')</th>
                                            <th>@lang('strings.cancel_charge')</th>
                                            <th>@lang('strings.from_date')</th>
                                            <th>@lang('strings.nights')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php $cancel_charge = 0; @endphp
                                    @foreach(App\Bookings::where(['bookings.property_id' => $id,'bookings.org_id' => Auth::user()->org_id])->join('booking_detail', 'booking_detail.book_id', '=', 'bookings.id')->whereDate('booking_detail.cancel_dt', date('Y-m-d'))->where('booking_detail.room_status', 'c')->orderBy('bookings.created_at', 'DESC')->select('bookings.*','booking_detail.cancel_charge')->get() as $value)
                                        @php
                                            $cancel_charge += $value->cancel_charge;
                                        @endphp
                                        <tr>
                                            <td>{{ app()->getLocale() == 'ar' ? App\Customers::where('id', $value->cust_id)->value('name') : App\Customers::where('id', $value->cust_id)->value('name_en')}}</td>
                                            <td>{{ Decimalplace($cancel_charge) }}</td>
                                            <td>{{ $value->book_from }}</td>
                                            <td>{{ $value->nights }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div id="overbookings" class="tab-pane fade">
                                <table class="table table-sm table-hover table-align-middle m-b-0" style="display: table;">
                                    <thead class="transparent">
                                        <tr>
                                            <th>@lang('strings.waiting_today'): {{ App\Bookings::where(['property_id' => $id,'org_id' => Auth::user()->org_id, 'book_status' => 'w'])->whereDate('created_at', date('Y-m-d'))->count() }}</th>
                                            <th>@lang('strings.expected'): {{ Decimalplace(App\Bookings::where(['property_id' => $id,'org_id' => Auth::user()->org_id, 'book_status' => 'w'])->whereDate('created_at', date('Y-m-d'))->sum('pay_amount')) }}</th>
                                            <th>@lang('strings.room_nights'): {{ App\Bookings::where(['property_id' => $id,'org_id' => Auth::user()->org_id, 'book_status' => 'w'])->whereDate('created_at', date('Y-m-d'))->sum('nights') }}</th>
                                        </tr>
                                        <tr>
                                            <th>@lang('strings.guest')</th>
                                            <th>@lang('strings.payments')</th>
                                            <th>@lang('strings.from_date')</th>
                                            <th>@lang('strings.nights')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(App\Bookings::join('booking_detail', 'booking_detail.book_id', '=', 'bookings.id')->where(['bookings.property_id' => $id,'bookings.org_id' => Auth::user()->org_id, 'room_status' => 'w'])->whereDate('bookings.created_at', date('Y-m-d'))->orderBy('bookings.created_at', 'DESC')->get() as $value)
                                        <tr>
                                            <td>{{ app()->getLocale() == 'ar' ? App\Customers::where('id', $value->cust_id)->value('name') : App\Customers::where('id', $value->cust_id)->value('name_en')}}</td>
                                            <td>{{ Decimalplace($value->pay_amount) }}</td>
                                            <td>{{ $value->book_from }}</td>
                                            <td>{{ $value->nights }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12">
                    <div class="bg-white">
                        <div class="title-card">
                            <h3>@lang('strings.reservations')</h3>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#arrivals"> @lang('strings.arrivals')</a></li>
                            <li><a data-toggle="tab" href="#departure">@lang('strings.departure')</a></li>
                            <li><a data-toggle="tab" href="#inhouse">@lang('strings.inhouse')</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="arrivals" class="tab-pane fade in active">
                                <table class="table table-sm table-hover table-align-middle m-b-0" style="display: table;">
                                    <thead class="transparent">
                                    <tr>
                                        <th>@lang('strings.guest')</th>
                                        <th>#@lang('strings.confirmation')</th>
                                        <th>@lang('strings.room')</th>
                                        <th>@lang('strings.status')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(App\Bookings::join('booking_detail', 'booking_detail.book_id', '=', 'bookings.id')->where(['bookings.property_id' => $id,'bookings.org_id' => Auth::user()->org_id])->whereDate('booking_detail.checkin_dt', date('Y-m-d'))->whereNotNull('booking_detail.checkin_dt')->orderBy('bookings.created_at', 'DESC')->get() as $value)
                                        <tr>
                                            <td>{{ app()->getLocale() == 'ar' ? App\Customers::where('id', $value->cust_id)->value('name') : App\Customers::where('id', $value->cust_id)->value('name_en')}}</td>
                                            <td>{{ $value->confirmation_no }}</td>
                                            <td>{{ app()->getLocale() == 'ar' ? App\Category::where('id', $value->cat_id)->value('name') : App\Category::where('id', $value->cat_id)->value('name_en') }}</td>
                                            <td>@lang('strings.checkin') {{ $value->checkin_dt }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div id="departure" class="tab-pane fade">
                                <table class="table table-sm table-hover table-align-middle m-b-0" style="display: table;">
                                    <thead class="transparent">
                                        <tr>
                                            <th>@lang('strings.guest')</th>
                                            <th>#@lang('strings.confirmation')</th>
                                            <th>@lang('strings.room')</th>
                                            <th>@lang('strings.status')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(App\Bookings::join('booking_detail', 'booking_detail.book_id', '=', 'bookings.id')->where(['bookings.property_id' => $id,'bookings.org_id' => Auth::user()->org_id])->whereDate('booking_detail.checkout_dt', date('Y-m-d'))->whereNotNull('booking_detail.checkout_dt')->orderBy('bookings.created_at', 'DESC')->get() as $value)
                                        <tr>
                                            <td>{{ app()->getLocale() == 'ar' ? App\Customers::where('id', $value->cust_id)->value('name') : App\Customers::where('id', $value->cust_id)->value('name_en')}}</td>
                                            <td>{{ $value->confirmation_no }}</td>
                                            <td>{{ app()->getLocale() == 'ar' ? App\Category::where('id', $value->cat_id)->value('name') : App\Category::where('id', $value->cat_id)->value('name_en') }}</td>
                                            <td>@lang('strings.checkout') {{ $value->checkout_dt }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>  
                            <div id="inhouse" class="tab-pane fade">
                                <table class="table table-sm table-hover table-align-middle m-b-0" style="display: table;">
                                    <thead class="transparent">
                                    <tr>
                                        <th>@lang('strings.guest')</th>
                                        <th>#@lang('strings.confirmation')</th>
                                        <th>@lang('strings.room')</th>
                                        <th>@lang('strings.status')</th>
                                    </tr>
                                    </thead>    
                                    <tbody>
                                        @foreach(App\Bookings::join('booking_detail', 'booking_detail.book_id', '=', 'bookings.id')->where(['bookings.property_id' => $id, 'bookings.org_id' => Auth::user()->org_id])->whereRaw('? between bookings.book_from and bookings.book_to', [ date('Y-m-d') ])->where('booking_detail.room_status', 'y')->whereNotNull('booking_detail.checkin_dt')->whereNull('booking_detail.checkout_dt')->orderBy('bookings.created_at', 'DESC')->get() as $value)
                                            <tr>
                                                <td>{{ app()->getLocale() == 'ar' ? App\Customers::where('id', $value->cust_id)->value('name') : App\Customers::where('id', $value->cust_id)->value('name_en')}}</td>
                                                <td>{{ $value->confirmation_no }}</td>
                                                <td>{{ app()->getLocale() == 'ar' ? App\Category::where('id', $value->cat_id)->value('name') : App\Category::where('id', $value->cat_id)->value('name_en') }}</td>
                                                <td>@lang('strings.inhouse')</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection

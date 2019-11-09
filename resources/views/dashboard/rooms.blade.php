@extends('layouts.admin', ['title' => __('strings.dashboard')])

@section('styles')

@endsection

@section('content')
    <style>
        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons that are used to open the tab content */
        .tab button {
            background-color: inherit;
            float: right;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
        }
        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }
        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }
        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
            animation: fadeEffect 1s; /* Fading effect takes 1 second */
        }
        /* Go from zero to full opacity */
        @keyframes fadeEffect {
            from {opacity: 0;}
            to {opacity: 1;}
        }
        .notice {
            padding: 15px;
            background-color: #fafafa;
            border-left: 6px solid #7f7f84;
            margin-bottom: 10px;
            -webkit-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
            -moz-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
            box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
        }
        .notice-sm {
            padding: 10px;
            font-size: 80%;
        }
        .notice-lg {
            padding: 35px;
            font-size: large;
        }
        .notice-success {
            border-color: #80D651;
        }
        .notice-success>strong {
            color: #80D651;
        }
        .notice-info {
            border-color: #45ABCD;
        }
        .notice-info>strong {
            color: #45ABCD;
        }
        .notice-warning {
            border-color: #FEAF20;
        }
        .notice-warning>strong {
            color: #FEAF20;
        }
        .notice-danger {
            border-color: #d73814;
        }
        .notice-danger>strong {
            color: #d73814;
        }
    </style>
    <div id="main-wrapper" class="main-wrapper-index">
        <div class="content-dash">
            <div class="row">
                <div class="col-md-12">
                    <!-- Tab panes -->
                    <div class="jus_tap" style="min-height: 130px;">
                        <div role="tabpanel">
                            <form action="" method="GET">
                                <div class="col-md-4 form-group">
                                    <label class="control-label" for="date">@lang('strings.date') </label>
                                    <input type="date" class="form-control" name="date" placeholder="@lang('strings.keyword')" value="{{ app('request')->input('date', date('Y-m-d')) }}">
                                </div>
                                <div class="col-md-4 form-group text-right">
                                    <label class="control-label" for="categories_types"></label>
                                    <button type="submit" class="btn btn-primary btn-lg"> <i class="fa fa-search"></i> {{ __('strings.search') }} </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @if(count($buildings) != 0)

                    <!-- Tab links -->
                        <div class="tab">
                            @foreach($buildings as $key => $value)
                                <button class="tablinks  {{ $key == 0 ? 'active' : '' }}" onclick="open_tab(event, '{{ $value->building }}')" >{{ $value->building }}</button>
                            @endforeach
                        </div>
                    @foreach($buildings as $key => $value)
                        <!-- Tab content -->
                            <div id="{{ $value->building }}" class="tabcontent" style="{{ $key == 0 ? 'display: block;' : 'display:none;' }}">
                                <table class="table table-sm table-hover table-align-middle m-b-0" id="" style="display: table;">
                                    <thead class="transparent">
                                    <tr>
                                        <th style="width: 20%;">@lang('strings.floor')</th>
                                        <th style="">@lang('strings.rooms')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        if(!empty(app('request')->input('date'))){
                                            $date = app('request')->input('date');
                                        }else{
                                            $date = date('Y-m-d');
                                        }

                                        foreach(App\Category::where([ 'org_id' => Auth::user()->org_id, 'property_id' => $id  ])->get() as $valu){
                                            $ids[] = $valu->id;
                                        }
                                    @endphp
                                    @foreach([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20] as $v)
                                        @if(App\CategoryNum::where(['cat_id' => $value->cat_id, 'floor_num' => $v, 'building' => $value->building])->exists())
                                            <tr>
                                                <td>{{ $v == 0 ? __('strings.floor_0') : ''}} {{ $v == 1 ? __('strings.floor_1') : ''}} {{ $v == 2 ? __('strings.floor_2') : ''}}  {{ $v == 3 ? __('strings.floor_3') : ''}} {{ $v == 4 ? __('strings.floor_4') : ''}} {{ $v == 5 ? __('strings.floor_5') : ''}} {{ $v == 6 ? __('strings.floor_6') : ''}}  {{ $v == 7 ? __('strings.floor_7') : ''}} {{ $v == 8 ? __('strings.floor_8') : ''}} {{ $v == 9 ? __('strings.floor_9') : ''}}{{ $v == 10 ? __('strings.floor_10') : ''}}{{ $v == 11 ? __('strings.floor_11') : ''}}{{ $v == 12 ? __('strings.floor_12') : ''}}{{ $v == 13 ? __('strings.floor_13') : ''}}{{ $v == 14 ? __('strings.floor_14') : ''}}{{ $v == 15 ? __('strings.floor_15') : ''}}{{ $v == 16 ? __('strings.floor_16') : ''}}{{ $v == 17 ? __('strings.floor_17') : ''}} {{ $v == 18 ? __('strings.floor_18') : ''}}{{ $v == 19 ? __('strings.floor_19') : ''}}{{ $v == 20 ? __('strings.floor_20') : ''}}</td>
                                                <td>
                                                    @foreach(App\CategoryNum::where(['building' => $value->building, 'org_id' => Auth::user()->org_id])->whereIn('cat_id', $ids)->get() as $vv)
                                                        @if($vv->building == $value->building)
                                                            @if($v == $vv->floor_num && App\ClosingDateList::where([ 'category_num_id' => $vv->id])->whereRaw('? between date_from and date_to', [ $date ])->doesntExist())
                                                                @if(App\BookingDetails::where(['category_num_id' => $vv->id])->WhereDate('checkout_dt', $date)->value('category_num_id') == $vv->id)
                                                                    <span class="badge badge-secondary col-md-1" style="display: block; width: 70px;margin: 3px 0px 0px 3px;">{{ $vv->cat_num }}</span>
                                                                @elseif(App\Bookings::where(['id' => App\BookingDetails::where(['category_num_id' => $vv->id, 'room_status' => 'y'])->whereNotNull('checkin_dt')->whereNull('checkout_dt')->value('book_id')])->whereRaw('? between book_from and book_to', [ $date ])->exists())
                                                                    <span class="badge badge-danger col-md-1" style="display: block; background-color: #f6b908; width: 70px;margin: 3px 0px 0px 3px;">{{ $vv->cat_num }}</span>
                                                                @elseif(App\Bookings::where(['id' => App\BookingDetails::where(['category_num_id' => $vv->id, 'room_status' => 'y', 'checkin_dt' => null])->value('book_id')])->whereRaw('? between book_from and book_to', [ $date ])->exists())
                                                                    <span class="badge badge-danger col-md-1" style="display: block; width: 70px;margin: 3px 0px 0px 3px;">{{ $vv->cat_num }}</span>
                                                                @else
                                                                    <span class="badge badge-primary col-md-1" style="display: block;background-color: #28a745; width: 70px;margin: 3px 0px 0px 3px;">{{ $vv->cat_num }}</span>
                                                                @endif 
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td>@lang('strings.table_index')</td>
                                        <td><span class="badge badge-danger col-md-1" style="display: block; background-color: #f6b908; width: 70px;margin: 3px 0px 0px 3px;">@lang('strings.inhouse')</span>   <span class="badge badge-danger col-md-1" style="display: block; width: 70px;margin: 3px 0px 0px 3px;">@lang('strings.reserved_index')</span>  <span class="badge badge-danger col-md-1" style="display: block;background-color: #28a745; width: 70px;margin: 3px 0px 0px 3px;">@lang('strings.available_index')</span>   <span class="badge badge-secondary col-md-1" style="display: block; width: 70px;margin: 3px 0px 0px 3px;">@lang('strings.checkout_index')</span> </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endforeach
                    @else
                        <div class="notice notice-warning">
                            <strong>ملاحظه</strong>  لا توجد بيانات
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function open_tab(evt, cityName) {
            var i, tabcontent, tablinks;

            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
@endsection

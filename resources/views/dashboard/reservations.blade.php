@extends('layouts.admin', ['title' => __('strings.reservations') ])

<!-- Last Modified  02/06/2019 12:10:25  -->
@section('content')
    <style>
        .add-service {
            float: right !important;
            background-color: #00e3f2;
        }

        .add-service a {
            color: #FFFFFF !important;
        }

        .add-service a:hover {
            background-color: #00E3CF !important;
        }

        /* <!-- Mostafa Change  02/06/2019 12:10:25  --> */
        #snackbar {
            visibility: hidden; /* Hidden by default. Visible on click */
            min-width: 250px; /* Set a default minimum width */
            margin-left: -125px; /* Divide value of min-width by 2 */
            background-color: #333; /* Black background color */
            color: #fff; /* White text color */
            text-align: center; /* Centered text */
            border-radius: 2px; /* Rounded borders */
            padding: 16px; /* Padding */
            position: fixed; /* Sit on top of the screen */
            z-index: 1; /* Add a z-index if needed */
            left: 50%; /* Center the snackbar */
            top: 22%; /* 30px from the bottom */
        }

        /* Show the snackbar when clicking on a button (class added with JavaScript) */
        #snackbar.show {
            visibility: visible; /* Show the snackbar */
            /* Add animation: Take 0.5 seconds to fade in and out the snackbar.
            However, delay the fade out process for 2.5 seconds */
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        /* Animations to fade the snackbar in and out */
        @-webkit-keyframes fadein {
            from {
                top: 0;
                opacity: 0;
            }
            to {
                top: 22%;
                opacity: 1;
            }
        }

        @keyframes fadein {
            from {
                top: 0;
                opacity: 0;
            }
            to {
                top: 22%;
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeout {
            from {
                top: 22%;
                opacity: 1;
            }
            to {
                top: 0;
                opacity: 0;
            }
        }

        @keyframes fadeout {
            from {
                top: 22%;
                opacity: 1;
            }
            to {
                top: 0;
                opacity: 0;
            }
        }

        /* End of Mostafa Change <!-- Last Modified  02/06/2019 12:10:25  --> */

        <
        style >
        .add-service {
            float: right !important;
            background-color: #00e3f2;
        }

        .add-service a {
            color: #FFFFFF !important;
        }

        .add-service a:hover {
            background-color: #00E3CF !important;
        }

        /* <!-- Mostafa Change  02/06/2019 12:10:25  --> */
        #snackbar {
            visibility: hidden; /* Hidden by default. Visible on click */
            min-width: 250px; /* Set a default minimum width */
            margin-left: -125px; /* Divide value of min-width by 2 */
            background-color: #333; /* Black background color */
            color: #fff; /* White text color */
            text-align: center; /* Centered text */
            border-radius: 2px; /* Rounded borders */
            padding: 16px; /* Padding */
            position: fixed; /* Sit on top of the screen */
            z-index: 1; /* Add a z-index if needed */
            left: 50%; /* Center the snackbar */
            top: 22%; /* 30px from the bottom */
        }

        /* Show the snackbar when clicking on a button (class added with JavaScript) */
        #snackbar.show {
            visibility: visible; /* Show the snackbar */
            /* Add animation: Take 0.5 seconds to fade in and out the snackbar.
            However, delay the fade out process for 2.5 seconds */
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        /* Animations to fade the snackbar in and out */
        @-webkit-keyframes fadein {
            from {
                top: 0;
                opacity: 0;
            }
            to {
                top: 22%;
                opacity: 1;
            }
        }

        @keyframes fadein {
            from {
                top: 0;
                opacity: 0;
            }
            to {
                top: 22%;
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeout {
            from {
                top: 22%;
                opacity: 1;
            }
            to {
                top: 0;
                opacity: 0;
            }
        }

        @keyframes fadeout {
            from {
                top: 22%;
                opacity: 1;
            }
            to {
                top: 0;
                opacity: 0;
            }
        }

        /* End of Mostafa Change <!-- Last Modified  02/06/2019 12:10:25  --> */


    </style>

    <!--<div class="page-title">-->
    <!--    <h3>@lang('strings.dashboard')</h3>-->
    <!--</div>-->
    <div id="main-wrapper">
        <div class="row"></div>

        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        @if (session('store_status'))
            <div id="snackbar">@lang('strings.reservation_done_msg_1') <i class="fa fa-check" style="color: green"></i>
                <p style="width: 100%">@lang('strings.reservation_done_msg_2')</p>
            </div>
        @endif
        <div role="tabpanel">
            <a href="/" tabindex="-1">

                <span><i class="fa fa-home"></i>{{ __('strings.Home') }}</span>
            </a>
            <!-- Nav tabs -->
            <ul class="nav nav-pills" role="tablist">
                <!-- Mostafa Reservation -->
                <li role="presentation" class="add-service"><a href="{{ url('reservation') }}"><i
                                class="icon-calendar"></i> @lang('strings.reservation_add')  </a></li>

                <!-- End Mostafa Reservation -->

            </ul>
            <!-- Tab panes -->
            <div class="tab-content">

                <!-- Mostafa Resrvation Part -->
                <div role="tabpanel" class="tab-pane active  fade in" id="reservation">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">

                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="xtreme-table" class="display table"
                                       style="width: 100%; cellspacing: 0;">
                                    <thead>
                                    <tr>
                                        <th>@lang('strings.reservation_no')</th>
                                        <th>@lang('strings.reservation_category')</th>
                                        <th>@lang('strings.Day')</th>
                                        <th>@lang('strings.Time')</th>
                                        <th>@lang('strings.reservation_captain')</th>
                                        <th>@lang('strings.reservation_comment')</th>
                                        <th>@lang('strings.reservation_date')</th>
                                        <th>@lang('strings.reservation_confirm')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($reservations as $reservation)
                                        <tr>
                                            <td>{{ $reservation['id'] }}</td>
                                            <td>{{ app()->getLocale() == 'ar' ? App\Category::where('id', $reservation->cat_id)->value('name') : App\Category::where('id', $reservation->cat_id)->value('name_en') }}</td>
                                            <td>{{ app()->getLocale() == 'ar' ? getDayNameArabic($reservation->av_day) : getDayName($reservation->av_day) }}</td>
                                            <td>{{ availableTimes($reservation->av_time, false) }}</td>
                                            <td>{{ app()->getLocale() == 'ar' ? App\User::where('id', $reservation->captain_id)->value('name') : App\User::where('id', $reservation->captain_id)->value('name_en') }}</td>
                                            <td>{{ $reservation['comment'] }}</td>
                                            <td>{{ $reservation['reservation_date'] }}</td>
                                            <td>
                                                <!--<Esraa  11-feb-2019  -->
                                                @if($reservation['confirm']=='y')
                                                    <span class="label label-success"
                                                          style="font-size:13px;">@lang('strings.confirmed2')</span>
                                                @elseif($reservation['confirm']=='c')
                                                    <span class="label label-default"
                                                          style="font-size:13px;background-color: #2a2a2a;border: none">@lang('strings.canceled')</span>
                                                @else
                                                    <span class="label label-danger"
                                                          style="font-size:13px;">@lang('strings.uncertain')</span>
                                            @endif
                                            <!-- Esraa 11-feb-2019 -->


                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                                {{ $reservations->links() }}
                            </div>
                        </div>
                    </div>
                </div>


                <!-- End of Mostafa-->


            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(window).load(function () {
            $("#snackbar").addClass("show");
            setTimeout(function () {
                $("#snackbar").removeClass("show");
            }, 2800);
        });
    </script>
@endsection

<!DOCTYPE html>
<html>

<head>

    <!-- Title -->
    <title>  {{__('strings.Setup_Registration')}} - {{ __('strings.admin') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta charset="UTF-8">
    <meta name="title" content="{{__('strings.Setup_Registration')}}"/>
    <meta name="description" content="Admin Panel for {{ config('settings.business_name') }}."/>
    <meta name="keywords" content=""/>
    <meta name="author" content="Pharaoh"/>

    <link rel="icon" href="{{ asset('favicon.png') }}">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Droid+Sans"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.21.0/slimselect.min.css" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link href="{{ asset('plugins/pace-master/themes/blue/pace-theme-flash.css') }}" rel="stylesheet"/>
    {{-- a.nabiil  --}}

    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/fontawesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/line-icons/simple-line-icons.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/waves/waves.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.5/css/fileinput.min.css">
    <link href="{{ asset('plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css"/>


    <link href="{{ asset('plugins/summernote-master/summernote.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.tagsinput.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.css"/>

    <!-- Theme Styles -->
    <link href="{{ asset('css/backend.min.css') }}" rel="stylesheet" type="text/css"/>


    <link href="{{ asset('/css/themes/green.css') }}" class="theme-color" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet" type="text/css"/>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        @page { size: auto; margin: 0mm; }

    </style>
</head>
<body>
<div id="main-wrapper" style="width: 90%; margin: auto;">
    <div class="row">

        <div class="panel panel-white">
            {{date('d-m-Y')}}
            <br>
            <br>
            <span style="padding: 5px;">
                    Property : {{$property->name_en}}
                </span>
            <span style="padding: 5px; margin-left: 300px">
                    Reservation :#
                </span>
            <br>
            <br>
            <div class="col-md-12" style="margin: auto;">
                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                    <tr>
                        <th style="text-align: left">Name :</th>
                        <th style="text-align: left">Nationality :</th>

                    </tr>
                    <tr>
                        <td style="text-align: left">ID Type :</td>
                        <td style="text-align: left">ID number :</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">City :</td>
                        <td style="text-align: left">state :</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">Phone number :</td>
                        <td style="text-align: left">email :</td>
                    </tr>

                </table>
            </div>
            <div>
                <b class="panel-title right" >Reservation details:</b>
                <br>
                <span style="padding: 5px;">
                    Check in date :
                </span>
                <span style="padding: 5px; margin-left: 100px">
                    check out  :
                </span>
                <span style="padding: 5px;margin-left: 100px ">
                    No of adults  :
                </span>

                <span style="padding: 5px; margin-left: 80px">
                    no of children  :
                </span>
            </div>
            <br>
            <div class="col-md-12" style="margin: auto;">
                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                    <tr>
                        <th style="text-align: left">Name :</th>
                        <th style="text-align: left">Relation :</th>
                        <th style="text-align: left">age :</th>
                    </tr>
                    <tr>
                        <td style="text-align: left"></td>
                        <td style="text-align: left"></td>
                        <td style="text-align: left"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left"></td>
                        <td style="text-align: left"></td>
                        <td style="text-align: left"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left"></td>
                        <td style="text-align: left"></td>
                        <td style="text-align: left"></td>
                    </tr>

                </table>
            </div>
            <div class="col-md-12" style="margin: auto;">
                <table  class="display table" style="width: 100%; cellspacing: 0;">
                    <tr>
                        <th style="text-align: left">Accommodation Type :</th>
                        <th style="text-align: left">Meal Plan :</th>
                        <th style="text-align: left">number :</th>
                    </tr>
                    <tr>
                        <td style="text-align: left"></td>
                        <td style="text-align: left"></td>
                        <td style="text-align: left"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left"></td>
                        <td style="text-align: left"></td>
                        <td style="text-align: left"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left"></td>
                        <td style="text-align: left"></td>
                        <td style="text-align: left"></td>
                    </tr>

                </table>
            </div>
            <br>
            <h4 class="panel-title right">Extras & Services :</h4>
            <div class="col-md-12" style="margin: auto;">
                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                    <tr>
                        <td style="text-align: left"></td>
                        <td style="text-align: left"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left"></td>
                        <td style="text-align: left"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left"></td>
                        <td style="text-align: left"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left"></td>
                        <td style="text-align: left"></td>
                    </tr>
                </table>
            </div>
             <h4 class="panel-title right">Notes:</h4><br>
            <div style="border: 1px solid #000000;">
                @if($nots->details !=null)
                <P style="padding: 5px;">
                    {{app()->getLocale() == 'ar'? $nots->details :$nots->details_en}}
                </P>
                @else
                    <P style="height:40px;">
                    </P>
                @endif
            </div>
            <br>
            <div style="border: 2px solid #000000; height: 63px;">
                <br>
                <span style="padding: 5px;">
                    name :
                </span>
                <span style="padding: 5px; margin-left: 200px">
                    Signature :
                </span>
            </div>
        </div>
    </div>
</div>


@if (Request::route()->getName() == 'EditMenu')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <script src='{!! asset("bs-iconpicker/js/iconset/iconset-fontawesome-4.7.0.min.js") !!}'></script>
    <script src='{!! asset("bs-iconpicker/js/bootstrap-iconpicker.js") !!}'></script>
    <script src='{!! asset("jquery-menu-editor.js") !!}'></script>
@else
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('plugins/pace-master/pace.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('plugins/waves/waves.min.js') }}"></script>

<script>
    $(document).ready(
        function () {
            setTimeout(function () {
                window.print();
            }, 2000);
        }
    )
</script>
</body>
</html>
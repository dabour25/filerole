<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invoice #{{ $ex_request->invoice_no }}</title>
    <link rel="icon" href="{{ asset('favicon.png') }}">

    <!-- CSS FILES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets_invoice/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets_invoice/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets_invoice/css/rtl.css') }}">
    <!-- CSS FILES END -->
    <!-- JAVASCRIPT FILES -->
    <script type="text/javascript" src="{{ asset('/assets_invoice/js/libs/jquery.min.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

    <!-- JAVASCRIPT FILES END -->
    <style>
        .fa {
            border-radius: 50%;
            width: 35px;
            height: 35px;
            text-align: center;
            line-height: 35px;
            padding: 0 0 0 0;
            font-size: 20px;
            margin: 0 0 0 0;
            text-decoration: none;
            margin: 0 10px;
        }

        .fa:hover {
            opeacity: 1 !important;
            color: #fff !important;
            text-decoration: none !important;
        }

        .fa:hover {
            opacity: 0.7;
        }

        .fa-facebook {
            background: #3B5998;
            color: white;
        }

        .fa-twitter {
            background: #55ACEE;
            color: white;
        }

        .fa-linkedin {
            background: #007bb5;
            color: white;
        }

        .fa-whatsapp {
            background: #00b489;
            color: white;
        }

        .modal-content {
            text-align: center;
        }

        form {
            margin: 15px 0 0 0;
        }

        .input-group {
            display: inline-block;
            width: auto;
        }

        span.input-group-addon {
            border: 0 !important;
            background: none;
            color: #000;
            height: 35px;
            overflow: hidden;
            width: 160px;
            display: inline-block;
            float: right;
            border-radius: 0 4px 4px 0;
            padding: 9px 10px;
            min-width: auto !important;
            text-align: center;
        }

        span .input-group-text {
            height: auto;
            color: #fff;
            text-align: center;
            background: none !important;
            font-size: 16px;
            width: auto;
            padding: 0 0;
            font-weight: bold;
        }

        .modal-body .form-control {
            display: inline-block !important;
            float: none !important;
            width: 250px !important;

        }

        .modal-body div {
            display: inline-block;
        }

        div button {
            background: #57b2f6;
            box-shadow: none;
            border: 0;
            color: #fff;
            padding: 7px 20px;
            margin: 0 -5px 0 0;
            border-radius: 4px 0 0 4px;
        }

        .select2-choice {
            width: auto !important;
            margin: -9px 0 0 0 !important;
        }

        @media (max-width: 767px) {
            div button {
                background: #57b2f6;
                box-shadow: none;
                border: 0;
                color: #fff;
                padding: 7px 20px;
                margin: 10px 0 0 0;
                border-radius: 0;
            }

            span.input-group-addon {
                border: 0 !important;
                background: none !important;
                color: #000;
                height: 35px;
                overflow: hidden;
                width: 160px;
                display: inline-block;
                float: none;
                border-radius: 0;
                padding: 9px 10px;
                min-width: auto !important;
                text-align: center;
                margin: 0 auto 15px;
            }
        }
    </style>
</head>
<body dir="rtl">
<!-- Main content -->
<main class="main">
    <!-- Page Header -->
    <ol class="breadcrumb">
        <div class="flip pull-right" style="line-height: 64px;">
            <a href="#" class="btn btn-link btn-sm" id="print">
                <i class="icon-printer h3 font-weight-bold"></i>
                <small class="text-muted center-block">@lang('strings.Print')</small>
            </a>
            <a href="#" class="btn btn-link btn-sm" data-toggle="modal" data-target="#shere">
                <i class="icon-globe h3 font-weight-bold"></i>
                <small class="text-muted center-block">@lang('strings.share')</small>
            </a>
            @if(Auth::guard('customers')->check())
            @elseif(Auth::guest())
            @else
                @if(permissions('transactions_edit') == 1)
                    <a href="{{ url('admin/showReq/'. $ex_request->id) }}" class="btn btn-link btn-sm">
                        <i class="icon-pencil h3 font-weight-bold"></i>
                        <small class="text-muted center-block">@lang('strings.edit_invoice')</small>
                    </a>
                @endif
                <a href="{{ URL::previous() }}" sis-modal="" class="btn btn-link btn-sm">
                    <i class="icon-clock h3 font-weight-bold"></i>
                    <small class="text-muted center-block">@lang('strings.go_back')</small>
                </a>
            @endif
        </div>
    </ol>

    <!-- Modal -->
    <div id="shere" class="bootbox modal fade" role="dialog">
        <div class="modal-dialog">
        @php
            $prefix = [
                    '44' => 'UK (+44)',
                    '1' => 'USA (+1)',
                    '213' => 'Algeria (+213)',
                    '376' => 'Andorra (+376)',
                    '244' => 'Angola (+244)',
                    '1264' => 'Anguilla (+1264)',
                    '1268' => 'Antigua & Barbuda (+1268)',
                    '54' => 'Argentina (+54)',
                    '374' => 'Armenia (+374)',
                    '297' => 'Aruba (+297)',
                    '61' => 'Australia (+61)',
                    '43' => 'Austria (+43)',
                    '994' => 'Azerbaijan (+994)',
                    '1242' => 'Bahamas (+1242)',
                    '973' => 'Bahrain (+973)',
                    '880' => 'Bangladesh (+880)',
                    '1246' => 'Barbados (+1246)',
                    '375' => 'Belarus (+375)',
                    '32' => 'Belgium (+32)',
                    '501' => 'Belize (+501)',
                    '229' => 'Benin (+229)',
                    '1441' => 'Bermuda (+1441)',
                    '975' => 'Bhutan (+975)',
                    '591' => 'Bolivia (+591)',
                    '387' => 'Bosnia Herzegovina (+387)',
                    '267' => 'Botswana (+267)',
                    '55' => 'Brazil (+55)',
                    '673' => 'Brunei (+673)',
                    '359' => 'Bulgaria (+359)',
                    '226' => 'Burkina Faso (+226)',
                    '257' => 'Burundi (+257)',
                    '855' => 'Cambodia (+855)',
                    '237' => 'Cameroon (+237)',
                    '1' => 'Canada (+1)',
                    '238' => 'Cape Verde Islands (+238)',
                    '1345' => 'Cayman Islands (+1345)',
                    '236' => 'Central African Republic (+236)',
                    '56' => 'Chile (+56)',
                    '86' => 'China (+86)',
                    '57' => 'Colombia (+57)',
                    '269' => 'Comoros (+269)',
                    '242' => 'Congo (+242)',
                    '682' => 'Cook Islands (+682)',
                    '506' => 'Costa Rica (+506)',
                    '385' => 'Croatia (+385)',
                    '53' => 'Cuba (+53)',
                    '90392' => 'Cyprus North (+90392)',
                    '357' => 'Cyprus South (+357)',
                    '42' => 'Czech Republic (+42)',
                    '45' => 'Denmark (+45)',
                    '253' => 'Djibouti (+253)',
                    '1809' => 'Dominica (+1809)',
                    '1809' => 'Dominican Republic (+1809)',
                    '593' => 'Ecuador (+593)',
                    '20' => 'Egypt (+20)',
                    '503' => 'El Salvador (+503)',
                    '240' => 'Equatorial Guinea (+240)',
                    '291' => 'Eritrea (+291)',
                    '372' => 'Estonia (+372)',
                    '251' => 'Ethiopia (+251)',
                    '500' => 'Falkland Islands (+500)',
                    '298' => 'Faroe Islands (+298)',
                    '679' => 'Fiji (+679)',
                    '358' => 'Finland (+358)',
                    '33' => 'France (+33)',
                    '594' => 'French Guiana (+594)',
                    '689' => 'French Polynesia (+689)',
                    '241' => 'Gabon (+241)',
                    '220' => 'Gambia (+220)',
                    '7880' => 'Georgia (+7880)',
                    '49' => 'Germany (+49)',
                    '233' => 'Ghana (+233)',
                    '350' => 'Gibraltar (+350)',
                    '30' => 'Greece (+30)',
                    '299' => 'Greenland (+299)',
                    '1473' => 'Grenada (+1473)',
                    '590' => 'Guadeloupe (+590)',
                    '671' => 'Guam (+671)',
                    '502' => 'Guatemala (+502)',
                    '224' => 'Guinea (+224)',
                    '245' => 'Guinea - Bissau (+245)',
                    '592' => 'Guyana (+592)',
                    '509' => 'Haiti (+509)',
                    '504' => 'Honduras (+504)',
                    '852' => 'Hong Kong (+852)',
                    '36' => 'Hungary (+36)',
                    '354' => 'Iceland (+354)',
                    '91' => 'India (+91)',
                    '62' => 'Indonesia (+62)',
                    '98' => 'Iran (+98)',
                    '964' => 'Iraq (+964)',
                    '353' => 'Ireland (+353)',
                    '972' => 'Israel (+972)',
                    '39' => 'Italy (+39)',
                    '1876' => 'Jamaica (+1876)',
                    '81' => 'Japan (+81)',
                    '962' => 'Jordan (+962)',
                    '7' => 'Kazakhstan (+7)',
                    '254' => 'Kenya (+254)',
                    '686' => 'Kiribati (+686)',
                    '850' => 'Korea North (+850)',
                    '82' => 'Korea South (+82)',
                    '965' => 'Kuwait (+965)',
                    '996' => 'Kyrgyzstan (+996)',
                    '856' => 'Laos (+856)',
                    '371' => 'Latvia (+371)',
                    '961' => 'Lebanon (+961)',
                    '266' => 'Lesotho (+266)',
                    '231' => 'Liberia (+231)',
                    '218' => 'Libya (+218)',
                    '417' => 'Liechtenstein (+417)',
                    '370' => 'Lithuania (+370)',
                    '352' => 'Luxembourg (+352)',
                    '853' => 'Macao (+853)',
                    '389' => 'Macedonia (+389)',
                    '261' => 'Madagascar (+261)',
                    '265' => 'Malawi (+265)',
                    '60' => 'Malaysia (+60)',
                    '960' => 'Maldives (+960)',
                    '223' => 'Mali (+223)',
                    '356' => 'Malta (+356)',
                    '692' => 'Marshall Islands (+692)',
                    '596' => 'Martinique (+596)',
                    '222' => 'Mauritania (+222)',
                    '269' => 'Mayotte (+269)',
                    '52' => 'Mexico (+52)',
                    '691' => 'Micronesia (+691)',
                    '373' => 'Moldova (+373)',
                    '377' => 'Monaco (+377)',
                    '976' => 'Mongolia (+976)',
                    '1664' => 'Montserrat (+1664)',
                    '212' => 'Morocco (+212)',
                    '258' => 'Mozambique (+258)',
                    '95' => 'Myanmar (+95)',
                    '264' => 'Namibia (+264)',
                    '674' => 'Nauru (+674)',
                    '977' => 'Nepal (+977)',
                    '31' => 'Netherlands (+31)',
                    '687' => 'New Caledonia (+687)',
                    '64' => 'New Zealand (+64)',
                    '505' => 'Nicaragua (+505)',
                    '227' => 'Niger (+227)',
                    '234' => 'Nigeria (+234)',
                    '683' => 'Niue (+683)',
                    '672' => 'Norfolk Islands (+672)',
                    '670' => 'Northern Marianas (+670)',
                    '47' => 'Norway (+47)',
                    '968' => 'Oman (+968)',
                    '680' => 'Palau (+680)',
                    '507' => 'Panama (+507)',
                    '675' => 'Papua New Guinea (+675)',
                    '595' => 'Paraguay (+595)',
                    '51' => 'Peru (+51)',
                    '63' => 'Philippines (+63)',
                    '48' => 'Poland (+48)',
                    '351' => 'Portugal (+351)',
                    '1787' => 'Puerto Rico (+1787)',
                    '974' => 'Qatar (+974)',
                    '262' => 'Reunion (+262)',
                    '40' => 'Romania (+40)',
                    '7' => 'Russia (+7)',
                    '250' => 'Rwanda (+250)',
                    '378' => 'San Marino (+378)',
                    '239' => 'Sao Tome & Principe (+239)',
                    '966' => 'Saudi Arabia (+966)',
                    '221' => 'Senegal (+221)',
                    '381' => 'Serbia (+381)',
                    '248' => 'Seychelles (+248)',
                    '232' => 'Sierra Leone (+232)',
                    '65' => 'Singapore (+65)',
                    '421' => 'Slovak Republic (+421)',
                    '386' => 'Slovenia (+386)',
                    '677' => 'Solomon Islands (+677)',
                    '252' => 'Somalia (+252)',
                    '27' => 'South Africa (+27)',
                    '34' => 'Spain (+34)',
                    '94' => 'Sri Lanka (+94)',
                    '290' => 'St. Helena (+290)',
                    '1869' => 'St. Kitts (+1869)',
                    '1758' => 'St. Lucia (+1758)',
                    '249' => 'Sudan (+249)',
                    '597' => 'Suriname (+597)',
                    '268' => 'Swaziland (+268)',
                    '46' => 'Sweden (+46)',
                    '41' => 'Switzerland (+41)',
                    '963' => 'Syria (+963)',
                    '886' => 'Taiwan (+886)',
                    '7' => 'Tajikstan (+7)',
                    '66' => 'Thailand (+66)',
                    '228' => 'Togo (+228)',
                    '676' => 'Tonga (+676)',
                    '1868' => 'Trinidad & Tobago (+1868)',
                    '216' => 'Tunisia (+216)',
                    '90' => 'Turkey (+90)',
                    '7' => 'Turkmenistan (+7)',
                    '993' => 'Turkmenistan (+993)',
                    '1649' => 'Turks & Caicos Islands (+1649)',
                    '688' => 'Tuvalu (+688)',
                    '256' => 'Uganda (+256)',
                    '380' => 'Ukraine (+380)',
                    '971' => 'United Arab Emirates (+971)',
                    '598' => 'Uruguay (+598)',
                    '7' => 'Uzbekistan (+7)',
                    '678' => 'Vanuatu (+678)',
                    '379' => 'Vatican City (+379)',
                    '58' => 'Venezuela (+58)',
                    '84' => 'Vietnam (+84)',
                    '84' => 'Virgin Islands - British (+1284)',
                    '84' => 'Virgin Islands - US (+1340)',
                    '681' => 'Wallis & Futuna (+681)',
                    '969' => 'Yemen (North)(+969)',
                    '967' => 'Yemen (South)(+967)',
                    '260' => 'Zambia (+260)',
                    '263' => 'Zimbabwe (+263)',
                ];
        @endphp
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">@lang('strings.invoice_sharing')</h4>
                </div>
                <div class="modal-body">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('invoice/'.$ex_request->id) }}&amp;title=share code is {{ $ex_request->share_code }}" target="_blank"
                       class="fa fa-facebook"></a>
                    <a href="https://twitter.com/intent/tweet?text=share code is {{ $ex_request->share_code }}&amp;url={{ url('invoice/'.$ex_request->id) }}" target="_blank"
                       class="fa fa-twitter"></a>
                    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ url('invoice/'.$ex_request->id) }}&amp;title=share code is {{ $ex_request->share_code }}" target="_blank"
                       class="fa fa-linkedin"></a>
                    <button class="fa fa-whatsapp" id="whatsapp"></button>

                    <br>
                    {{-- @php
                        $customer = App\Customers::where('id', $ex_request->cust_id)->first();

                    @endphp --}}
                    <div class="whatsapp-form" style="display:none;">
                        <form action="{{ url('share-invoice') }}" method="post">
                            @csrf
                            <input name="invoice_no" value="{{ $ex_request->id }}" type="hidden">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <select class="input-group-text" name="code">
                                        @foreach($prefix as $key => $value)
                                            <option value="+{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </span>
                                <input id="email" type="text" class="form-control" name="number"
                                       placeholder="Phone number"
                                       value="{{ !empty($customer->phone_number)? $customer->phone_number : ''}}">
                            </div>
                            <div>
                                <button type="submit">@lang('strings.share')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @php
        foreach ($data = App\InvoiceTemplate::where('org_id', $ex_request->org_id)->where('name',$ex_request->invoice_template)->get() as $value){
            $value->value = json_decode($value->value, true);
        }

        if(count($data) !== 0){
            $data =  $data[0];

        }
    @endphp
    <div class="container-fluid">
        <div id="css_script">
            <style type="text/css" id="pageInit">@page {
                    size: 21cm 29.7cm
                }

                .etat_header, .etat_content, .etat_footer {
                    width: 20cm;
                }
            </style>
            <link href="{{ asset('/assets_invoice/css/print.css') }}" rel="stylesheet">

            @if(!empty($data) && $data != '[]')
                <style type="text/css">
                    #wrap_invoice.page {
                        font-family: {{ $data->value['invoice_font'] }};
                        background-color: #ffffff;
                        padding: {{ $data->value['margin'] }};
                        z-index: 1;
                    }

                    #wrap_invoice h3 {
                        color: {{ $data->value['primary_color'] }};
                    }

                    #wrap_invoice h4 {
                        color: {{ $data->value['primary_color'] }};
                    }

                    .invoice_header .invoice-logo img {
                        height: 100% !important;
                        width: auto !important;
                        max-width: 100%;
                    }

                    #wrap_invoice,
                    #wrap_invoice p,
                    #wrap_invoice .text-color,
                    #wrap_invoice .inv.col b,
                    #wrap_invoice .table_invoice {
                        font-size: {{ $data->value['font_size'] }};
                        color: #2e2e2e;
                    }

                    #wrap_invoice .table_invoice thead th {
                        background: {{ $data->value['table_line_th_bg'] }};
                        color: {{ $data->value['table_line_th_color'] }};
                        line-height: {{ $data->value['table_line_th_height'] }}px;
                        height: {{ $data->value['table_line_th_height'] }}px;
                    }

                    #wrap_invoice .table_invoice td {
                        line-height: {{ $data->value['table_line_td_height'] }}px;
                        height: {{ $data->value['table_line_td_height'] }}px;
                    }

                    #wrap_invoice .page-title {
                        color: {{ $data->value['primary_color'] }};
                        text-align: center;
                    }

                    #wrap_invoice .invoice_header {
                        background: {{ $data->value['header_bg_color'] }};
                        color: {{ $data->value['header_txt_color'] }}  !important;
                        margin: -0.5cm -0.5cm 0 -0.5cm;
                        padding: 0.5cm 0.5cm 0 0.5cm;
                    }

                    #wrap_invoice .invoice_header * {
                        color: #000000 !important;
                        margin: 0;
                    }

                    #wrap_invoice .invoice_footer,
                    #wrap_invoice .invoice_footer p,
                    #wrap_invoice .invoice_footer .pagging {
                        background: {{ $data->value['footer_bg_color'] }};
                        color: {{ $data->value['footer_txt_color'] }};
                    }
                </style>
            @else
                <style type="text/css">
                    #wrap_invoice.page {
                        font-family: Arial, Helvetica, sans-serif;
                        background-color: #ffffff;
                        padding: 0.5cm 0.5cm 0.5cm 0.5cm;
                        z-index: 1;
                    }

                    #wrap_invoice h3 {
                        color: #009be1;
                    }

                    #wrap_invoice h4 {
                        color: #009be1;
                    }

                    .invoice_header .invoice-logo img {
                        height: 100% !important;
                        width: auto !important;
                        max-width: 100%;
                    }

                    #wrap_invoice,
                    #wrap_invoice p,
                    #wrap_invoice .text-color,
                    #wrap_invoice .inv.col b,
                    #wrap_invoice .table_invoice {
                        font-size: 12px;
                        color: #2e2e2e;
                    }

                    #wrap_invoice .table_invoice thead th {
                        background: #009be1;
                        color: #ffffff;
                        line-height: 24px;
                        height: 24px;
                    }

                    #wrap_invoice .table_invoice td {
                        line-height: 23px;
                        height: 23px;
                    }

                    #wrap_invoice .page-title {
                        color: #009be1;
                        text-align: center;
                    }

                    #wrap_invoice .invoice_header {
                        background: #ffffff;
                        color: #000000 !important;
                        margin: -0.5cm -0.5cm 0 -0.5cm;
                        padding: 0.5cm 0.5cm 0 0.5cm;
                    }

                    #wrap_invoice .invoice_header * {
                        color: #000000 !important;
                        margin: 0;
                    }

                    #wrap_invoice .invoice_footer,
                    #wrap_invoice .invoice_footer p,
                    #wrap_invoice .invoice_footer .pagging {
                        background: #ffffff;
                        color: #2e2e2e;
                    }
                </style>
            @endif
        </div>
        <div id="wrap_invoice" class="page @if(!empty($data) && $data != '[]') {{ $data->value['invoice_default_layout'] }} {{ $data->value['invoice_default_size'] }} @else portrait A4 @endif">
            <header class="invoice_header etat_header">
                <div class="row model1">
                    @php
                        $organization = App\org::where('owner_url', explode('/',url()->current())[2] )->first();

                        $organization_logo = App\Photo::where('id', $organization->image_id)->value('file');

                        $organization_name = $organization->name;
                        $organization_email = $organization->email;
                        $organization_phone = $organization->phone;
                        $organization_address = $organization->address;

                    @endphp
                    <div class="col-xs-4 invoice-logo">

                        <img src="{{ !empty($organization_logo) ? asset($organization_logo) :  asset('trust.png') }}" style="width:100%; max-width:100px;">
                    </div>

                    <div class="col-xs-8 invoice-header-info"><h4>{{ $organization_name }}</h4>
                        <p>
                            <b>@lang('strings.Address'):</b> {{ $organization_address }} <br><b>@lang('strings.Phone'):</b> {{ $organization_phone }}
                            <b><br>@lang('strings.Email'): </b> {{ $organization_email }}
                        </p>
                    </div>
                </div>
                <hr>
                <div class='clearfix'></div>
            </header>
            <br>
            <center><h3 class="page-title">@if(App\InvoiceSetup::where(['type' => 1, 'org_id' => Auth::user()->org_id])->exists() && App\InvoiceSetup::where(['type' => 1, 'org_id' => Auth::user()->org_id])->value('value') !== '') {{ App\InvoiceSetup::where(['type' => 1, 'org_id' => Auth::user()->org_id])->value('value') }} @else  @lang('strings.invoice') @endif</h3></center>
            <div class="etat_content">
                <div class='page_split'>

                    <div class="row row-equal text-md-center">
                        <div class="col-xs-3">
                            <h3 class="inv col"><b>@lang('strings.invoice_id'): </b>{{  $ex_request->invoice_code }}</h3>
                        </div>
                        <div class="col-xs-3">
                            <h3 class="inv col"><b>@lang('strings.transactions_id'): </b>{{ $ex_request->id }}</h3>
                        </div>
                        <div class="col-xs-3">
                            <h3 class="inv col"><b>@lang('strings.invoice_date'): </b>{{ $ex_request->invoice_date }}</h3>
                        </div>
                        <div class="col-xs-3">
                            <h3 class="inv col"><b>@lang('strings.external_delivery_fees'): </b>{{ Decimalplace($ex_request->delivery_fees) }}</h3>
                        </div>
                        {{-- <div class="col-xs-3">
                            <h3 class="inv col"><b>@lang('strings.duedate'): </b> @if(!empty($ex_request->due_date)) {{ Dateformat( date('Y-m-d') ) }} @else {{ Dateformat( $ex_request->date ) }} @endif</h3>
                        </div> --}}
                        <div class="col-xs-3">
                            <h3 class="inv col">
                                {{-- <b>@lang('strings.Cashier_name'): </b>{{ app()->getLocale() == 'ar' ? App\User::findOrFail($ex_request->user_id)->name : App\User::findOrFail($ex_request->user_id)->name_en }} --}}
                            </h3>
                        </div>
                    </div>
                    <hr>
                    <div class="row inv">
                        <div class="col-xs-12">
                            <h4>@lang('strings.bill_to')</h4>
                        </div>
                    </div>
                    <div class="row-cols row">
                        <div class="col-6 col-xs-6">
                            <b class="inv">{{ $customer->name }}</b>
                            <br/>
                            <b>@lang('strings.Phone'): </b> {{ $customer->phone_number }} <br>
                            <b>@lang('strings.Email'): </b> {{ $customer->email }} <br>
                        </div>

                        <div class="col-6 col-xs-6"></div>
                        <div class="clearfix"></div>
                    </div>
                    <br>
                    <table class="table_invoice table_invoice-bordered table_invoice-striped"
                           style="margin-bottom: 5px;" cellpadding="0" cellspacing="0" border="0">
                        <thead>
                          {{-- a.nabiil --}}
                            <tr>
                                <th>@lang('strings.Item')</th>
                                <th>@lang('strings.Quantity')</th>
                                <th>@lang('strings.Unit_price')</th>
                                <th>@lang('strings.Total')</th>
                                <th>@lang('strings.Tax')</th>
                                <th>@lang('strings.Status')</th>
                                {{--<th>طريقة الدفع</th>--}}
                            </tr>
                        </thead>
                         <tbody>
                           @foreach ($ex_request->trans()->with('cat')->get() as  $item)
                             <tr style="text-align:center">
                               <td>{{ app()->getLocale() == 'ar' ? $item->cat->name : $item->cat->name_en }}</td>
                               <td> {{$item->quantity}} </td>
                               <td> <span class="cat_price">{{$item->final_price}}</span>  </td>
                               <td>{{$item->quantity *  $item->final_price}}</td>
                               <td>{{$item->tax_val}}</td>
                               <td>
                                 @if ($item->reg_flag == 1)
                                   {{ __('strings.externalTransPrint_return') }}
                                  @else
                                    {{ __('strings.externalTransPrint_exchange') }}
                                 @endif
                               </td>
                             </tr>
                           @endforeach

                           <tr>
                               <td colspan="4" class="text-md-right font-weight-bold">
                                   @lang('strings.Total_Tax')
                               </td>
                               <td class="text-md-right font-weight-bold text-nowrap">
                                   @php
                                     $req_transTax = DB::select('SELECT sum(quantity * reg_flag * tax_val )  AS price  FROM `external_trans` WHERE  org_id = '.Auth::user()->org_id.' AND cust_id = '.$ex_request->cust_id .' AND external_req_id = '.$ex_request->id );
                                   @endphp
                                   {{ Decimalplace(abs($req_transTax[0]->price)) }}
                               </td>

                           </tr>
                           <tr>
                               <td colspan="4" class="text-md-right font-weight-bold">
                                   @lang('strings.Total_Previous')
                               </td>
                               <td class="text-md-right font-weight-bold text-nowrap">
                                   @php
                                     $req_transRetuen = DB::select('SELECT sum(quantity * reg_flag * final_price )  AS price  FROM `external_trans` WHERE  org_id = '.Auth::user()->org_id.' AND cust_id = '.$ex_request->cust_id .' AND external_req_id = '.$ex_request->id . ' AND reg_flag = 1' );
                                   @endphp
                                   {{ Decimalplace(abs($req_transRetuen[0]->price)) }}
                               </td>

                           </tr>
                           <tr>
                               <td colspan="4" class="text-md-right font-weight-bold">
                                   @lang('strings.Total_invoices')
                               </td>
                               <td class="text-md-right font-weight-bold text-nowrap">
                                   @php
                                     $req_trans = DB::select('SELECT sum(quantity * reg_flag * final_price )  AS price  FROM `external_trans` WHERE  org_id = '.Auth::user()->org_id.' AND cust_id = '.$ex_request->cust_id .' AND external_req_id = '.$ex_request->id );
                                     $totalPrice =abs( $req_trans[0]->price) + abs($ex_request->delivery_fees);
                                   @endphp
                                   {{ Decimalplace($totalPrice) }}
                               </td>

                           </tr>
                         </tbody>
                    </table>

                </div>
            </div>
            <div style="clear: both;"></div>
            <div class="etat_footer">
                <div class="row">
                    <div class="col-xs-4 col-xs-offset-8"><p>&nbsp;</p>
                        <p style="border-bottom: 1px solid #666;">&nbsp;</p>
                        <p class='text-md-center'>@if(!empty($data) && $data != '[]')  {{ $data->value['signature_txt'] }} @else @endif</p>
                    </div>
                </div>
                <p>&nbsp;</p>
                <div style="clear: both;"></div>
            </div>
            <footer class='invoice_footer'>
                <hr>
                @if(Auth::guard('customers')->check())
                    @if(!empty($data) && $data != '[]')  {!! $data->value['footer_text'] !!} @else Filerole - {{ date('Y') }} @endif

                @elseif(Auth::guest())
                    @if(!empty($data) && $data != '[]')  {!! $data->value['footer_text'] !!} @else Filerole - {{ date('Y') }} @endif

                @else
                    @if(!empty($data) && $data != '[]')  {!! $data->value['footer_text'] !!} @else Filerole - {{ date('Y') }} @endif
                @endif
            </footer>

            <div style="clear: both;"></div>
        </div>

        <script type="text/javascript">
            function setPrinterConfig() {
                resolution = $('#resolution').val() != undefined ? $('#resolution').val() : "A4";
                rotate = $('#rotate').val() != undefined ? $('#rotate').val() : "portrait";

                $('.page').removeClass('A4 A5 Letter Legal');
                $('.page').addClass(resolution);
                $('.page').removeClass('portrait landscape');
                $('.page').addClass(rotate);

                w = "21cm";
                h = "29.7cm";
                if (resolution == "A4") {
                    w = "21cm";
                    h = "29.7cm";
                } else if (resolution == "A5") {
                    w = "14.8cm";
                    h = "21cm";
                } else if (resolution == "Letter") {
                    w = "21.6cm";
                    h = "27.9cm";
                } else if (resolution == "Legal") {
                    w = "21.6cm";
                    h = "35.6cm";
                }
                if (rotate == "landscape") {
                    $('#pageInit').html("@page{size: " + h + " " + w + "}");
                } else {
                    $('#pageInit').html("@page{size: " + w + " " + h + "}");
                }
                scaleTemplate();
            };

            function getPageHeight() {
                resolution = $('#resolution').val() != undefined ? $('#resolution').val() : "A4";
                rotate = $('#rotate').val() != undefined ? $('#rotate').val() : "portrait";

                w = 21;
                h = 29.7;
                if (resolution == "A4") {
                    w = 21;
                    h = 29.7;
                } else if (resolution == "A5") {
                    w = 14.8;
                    h = 21;
                } else if (resolution == "Letter") {
                    w = 21.6;
                    h = 27.9;
                } else if (resolution == "Legal") {
                    w = 21.6;
                    h = 35.6;
                }
                if (rotate == "landscape") {
                    return w;
                } else {
                    return h;
                }
            };

            function getPageWidth() {
                resolution = $('#resolution').val() != undefined ? $('#resolution').val() : "A4";
                rotate = $('#rotate').val() != undefined ? $('#rotate').val() : "portrait";

                w = 21;
                h = 29.7;
                if (resolution == "A4") {
                    w = 21;
                    h = 29.7;
                } else if (resolution == "A5") {
                    w = 14.8;
                    h = 21;
                } else if (resolution == "Letter") {
                    w = 21.6;
                    h = 27.9;
                } else if (resolution == "Legal") {
                    w = 21.6;
                    h = 35.6;
                }
                if (rotate == "landscape") {
                    return h;
                } else {
                    return w;
                }
            };

            function scaleTemplate() {
                $.each($('[id=wrap_invoice]'), function (i, wrap_invoice) {
                    var scale = 1;
                    if ($(wrap_invoice).parent().is(".wrapper")) {
                        $(wrap_invoice).unwrap();
                    }
                    var parent = $(wrap_invoice).parent();
                    var padding = $(parent).outerWidth() - $(parent).width();
                    var outer_height = $(parent).height();
                    var inner_height = $(wrap_invoice).outerHeight();
                    var outer_width = $(parent).width();
                    var inner_width = $(wrap_invoice).outerWidth();
                    if (outer_width < inner_width) {
                        if (padding == 0) {
                            scale = parseFloat(outer_width / (inner_width + 20));
                            padding = 20;
                        } else {
                            scale = parseFloat(outer_width / inner_width);
                            padding = 0;
                        }
                        var x = padding / 2;
                        var x = inner_width - x;
                        var origin = x.toFixed(2) + "px 0px 0px";
                        $(wrap_invoice).css({
                            '-webkit-transform': 'scale(' + (scale.toFixed(2)) + ')',
                            '-webkit-transform-origin': origin
                        });
                        var wrapper = $("<div class='wrapper'></div>");
                        $(wrapper).css({
                            'width': inner_width * scale,
                            'height': inner_height * scale,
                            "overflow": "hidden"
                        });
                        $(wrap_invoice).wrap(wrapper);
                    } else {
                        $(wrap_invoice).css({'-webkit-transform': '', '-webkit-transform-origin': ""});
                    }
                });
            };

            document.table_border = false;
            document.table_strip = false;
            document.table_border = true;
            document.table_strip = true;

            $(document).ready(function () {
                $('#wrap_invoice table').removeClass();
                $('#wrap_invoice table').addClass('table_invoice table_invoice-condensed');

                $('#wrap_invoice table').addClass('table_invoice-bordered');

                $('#wrap_invoice table').addClass('table_invoice-striped');


                setPrinterConfig();
                $('body').on('keyup', function (ev) {
                    if (ev.keyCode == 27) {
                        $('#close_page').click();
                    }
                });

                $('#close_page').click(function () {
                    window.close();
                    window.parent.window.close();
                    return false;
                });
            });
            setTimeout(function () {
                $(window).trigger("resize");
            }, 100);
        </script>

    </div>
    <!-- /.conainer-fluid -->
</main>

<!-- JAVASCRIPT FILES -->
<script type="text/javascript" src="{{ asset('/assets_invoice/vendor/jquery-ui/jquery-ui.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets_invoice/js/libs/tether.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets_invoice/js/libs/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets_invoice/js/libs/pace.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets_invoice/vendor/chartjs/Chart.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets_invoice/js/libs/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets_invoice/vendor/toastrjs/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets_invoice/vendor/bootbox/bootbox.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets_invoice/js/libs/gauge.min.js') }}"></script>
<!-- JAVASCRIPT FILES END -->
<div class="loading-backdrop"></div>
<script>
    $('#print').click(function () {
        $('.breadcrumb').hide();
        window.print();
        $('.breadcrumb').show();
    });
    $('select').select2({
        minimumInputLength: 1 // only start searching when the user has input 3 or more characters
    });
    $('#whatsapp').click(function () {
        $('.whatsapp-form').show();
    });

</script>
</body>
</html>

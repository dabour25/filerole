<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invoice #{{ $booking->invoice_no }}</title>
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
        .old_price{
          text-decoration: line-through;
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
                    	'AD'=>array('name'=>'ANDORRA','code'=>'376'),
                        'AE'=>array('name'=>'UNITED ARAB EMIRATES','code'=>'971'),
                        'AF'=>array('name'=>'AFGHANISTAN','code'=>'93'),
                        'AG'=>array('name'=>'ANTIGUA AND BARBUDA','code'=>'1268'),
                        'AI'=>array('name'=>'ANGUILLA','code'=>'1264'),
                        'AL'=>array('name'=>'ALBANIA','code'=>'355'),
                        'AM'=>array('name'=>'ARMENIA','code'=>'374'),
                        'AN'=>array('name'=>'NETHERLANDS ANTILLES','code'=>'599'),
                        'AO'=>array('name'=>'ANGOLA','code'=>'244'),
                        'AQ'=>array('name'=>'ANTARCTICA','code'=>'672'),
                        'AR'=>array('name'=>'ARGENTINA','code'=>'54'),
                        'AS'=>array('name'=>'AMERICAN SAMOA','code'=>'1684'),
                        'AT'=>array('name'=>'AUSTRIA','code'=>'43'),
                        'AU'=>array('name'=>'AUSTRALIA','code'=>'61'),
                        'AW'=>array('name'=>'ARUBA','code'=>'297'),
                        'AZ'=>array('name'=>'AZERBAIJAN','code'=>'994'),
                        'BA'=>array('name'=>'BOSNIA AND HERZEGOVINA','code'=>'387'),
                        'BB'=>array('name'=>'BARBADOS','code'=>'1246'),
                        'BD'=>array('name'=>'BANGLADESH','code'=>'880'),
                        'BE'=>array('name'=>'BELGIUM','code'=>'32'),
                        'BF'=>array('name'=>'BURKINA FASO','code'=>'226'),
                        'BG'=>array('name'=>'BULGARIA','code'=>'359'),
                        'BH'=>array('name'=>'BAHRAIN','code'=>'973'),
                        'BI'=>array('name'=>'BURUNDI','code'=>'257'),
                        'BJ'=>array('name'=>'BENIN','code'=>'229'),
                        'BL'=>array('name'=>'SAINT BARTHELEMY','code'=>'590'),
                        'BM'=>array('name'=>'BERMUDA','code'=>'1441'),
                        'BN'=>array('name'=>'BRUNEI DARUSSALAM','code'=>'673'),
                        'BO'=>array('name'=>'BOLIVIA','code'=>'591'),
                        'BR'=>array('name'=>'BRAZIL','code'=>'55'),
                        'BS'=>array('name'=>'BAHAMAS','code'=>'1242'),
                        'BT'=>array('name'=>'BHUTAN','code'=>'975'),
                        'BW'=>array('name'=>'BOTSWANA','code'=>'267'),
                        'BY'=>array('name'=>'BELARUS','code'=>'375'),
                        'BZ'=>array('name'=>'BELIZE','code'=>'501'),
                        'CA'=>array('name'=>'CANADA','code'=>'1'),
                        'CC'=>array('name'=>'COCOS (KEELING) ISLANDS','code'=>'61'),
                        'CD'=>array('name'=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE','code'=>'243'),
                        'CF'=>array('name'=>'CENTRAL AFRICAN REPUBLIC','code'=>'236'),
                        'CG'=>array('name'=>'CONGO','code'=>'242'),
                        'CH'=>array('name'=>'SWITZERLAND','code'=>'41'),
                        'CI'=>array('name'=>'COTE D IVOIRE','code'=>'225'),
                        'CK'=>array('name'=>'COOK ISLANDS','code'=>'682'),
                        'CL'=>array('name'=>'CHILE','code'=>'56'),
                        'CM'=>array('name'=>'CAMEROON','code'=>'237'),
                        'CN'=>array('name'=>'CHINA','code'=>'86'),
                        'CO'=>array('name'=>'COLOMBIA','code'=>'57'),
                        'CR'=>array('name'=>'COSTA RICA','code'=>'506'),
                        'CU'=>array('name'=>'CUBA','code'=>'53'),
                        'CV'=>array('name'=>'CAPE VERDE','code'=>'238'),
                        'CX'=>array('name'=>'CHRISTMAS ISLAND','code'=>'61'),
                        'CY'=>array('name'=>'CYPRUS','code'=>'357'),
                        'CZ'=>array('name'=>'CZECH REPUBLIC','code'=>'420'),
                        'DE'=>array('name'=>'GERMANY','code'=>'49'),
                        'DJ'=>array('name'=>'DJIBOUTI','code'=>'253'),
                        'DK'=>array('name'=>'DENMARK','code'=>'45'),
                        'DM'=>array('name'=>'DOMINICA','code'=>'1767'),
                        'DO'=>array('name'=>'DOMINICAN REPUBLIC','code'=>'1809'),
                        'DZ'=>array('name'=>'ALGERIA','code'=>'213'),
                        'EC'=>array('name'=>'ECUADOR','code'=>'593'),
                        'EE'=>array('name'=>'ESTONIA','code'=>'372'),
                        'EG'=>array('name'=>'EGYPT','code'=>'20'),
                        'ER'=>array('name'=>'ERITREA','code'=>'291'),
                        'ES'=>array('name'=>'SPAIN','code'=>'34'),
                        'ET'=>array('name'=>'ETHIOPIA','code'=>'251'),
                        'FI'=>array('name'=>'FINLAND','code'=>'358'),
                        'FJ'=>array('name'=>'FIJI','code'=>'679'),
                        'FK'=>array('name'=>'FALKLAND ISLANDS (MALVINAS)','code'=>'500'),
                        'FM'=>array('name'=>'MICRONESIA, FEDERATED STATES OF','code'=>'691'),
                        'FO'=>array('name'=>'FAROE ISLANDS','code'=>'298'),
                        'FR'=>array('name'=>'FRANCE','code'=>'33'),
                        'GA'=>array('name'=>'GABON','code'=>'241'),
                        'GB'=>array('name'=>'UNITED KINGDOM','code'=>'44'),
                        'GD'=>array('name'=>'GRENADA','code'=>'1473'),
                        'GE'=>array('name'=>'GEORGIA','code'=>'995'),
                        'GH'=>array('name'=>'GHANA','code'=>'233'),
                        'GI'=>array('name'=>'GIBRALTAR','code'=>'350'),
                        'GL'=>array('name'=>'GREENLAND','code'=>'299'),
                        'GM'=>array('name'=>'GAMBIA','code'=>'220'),
                        'GN'=>array('name'=>'GUINEA','code'=>'224'),
                        'GQ'=>array('name'=>'EQUATORIAL GUINEA','code'=>'240'),
                        'GR'=>array('name'=>'GREECE','code'=>'30'),
                        'GT'=>array('name'=>'GUATEMALA','code'=>'502'),
                        'GU'=>array('name'=>'GUAM','code'=>'1671'),
                        'GW'=>array('name'=>'GUINEA-BISSAU','code'=>'245'),
                        'GY'=>array('name'=>'GUYANA','code'=>'592'),
                        'HK'=>array('name'=>'HONG KONG','code'=>'852'),
                        'HN'=>array('name'=>'HONDURAS','code'=>'504'),
                        'HR'=>array('name'=>'CROATIA','code'=>'385'),
                        'HT'=>array('name'=>'HAITI','code'=>'509'),
                        'HU'=>array('name'=>'HUNGARY','code'=>'36'),
                        'ID'=>array('name'=>'INDONESIA','code'=>'62'),
                        'IE'=>array('name'=>'IRELAND','code'=>'353'),
                        'IL'=>array('name'=>'ISRAEL','code'=>'972'),
                        'IM'=>array('name'=>'ISLE OF MAN','code'=>'44'),
                        'IN'=>array('name'=>'INDIA','code'=>'91'),
                        'IQ'=>array('name'=>'IRAQ','code'=>'964'),
                        'IR'=>array('name'=>'IRAN, ISLAMIC REPUBLIC OF','code'=>'98'),
                        'IS'=>array('name'=>'ICELAND','code'=>'354'),
                        'IT'=>array('name'=>'ITALY','code'=>'39'),
                        'JM'=>array('name'=>'JAMAICA','code'=>'1876'),
                        'JO'=>array('name'=>'JORDAN','code'=>'962'),
                        'JP'=>array('name'=>'JAPAN','code'=>'81'),
                        'KE'=>array('name'=>'KENYA','code'=>'254'),
                        'KG'=>array('name'=>'KYRGYZSTAN','code'=>'996'),
                        'KH'=>array('name'=>'CAMBODIA','code'=>'855'),
                        'KI'=>array('name'=>'KIRIBATI','code'=>'686'),
                        'KM'=>array('name'=>'COMOROS','code'=>'269'),
                        'KN'=>array('name'=>'SAINT KITTS AND NEVIS','code'=>'1869'),
                        'KP'=>array('name'=>'KOREA DEMOCRATIC PEOPLES REPUBLIC OF','code'=>'850'),
                        'KR'=>array('name'=>'KOREA REPUBLIC OF','code'=>'82'),
                        'KW'=>array('name'=>'KUWAIT','code'=>'965'),
                        'KY'=>array('name'=>'CAYMAN ISLANDS','code'=>'1345'),
                        'KZ'=>array('name'=>'KAZAKSTAN','code'=>'7'),
                        'LA'=>array('name'=>'LAO PEOPLES DEMOCRATIC REPUBLIC','code'=>'856'),
                        'LB'=>array('name'=>'LEBANON','code'=>'961'),
                        'LC'=>array('name'=>'SAINT LUCIA','code'=>'1758'),
                        'LI'=>array('name'=>'LIECHTENSTEIN','code'=>'423'),
                        'LK'=>array('name'=>'SRI LANKA','code'=>'94'),
                        'LR'=>array('name'=>'LIBERIA','code'=>'231'),
                        'LS'=>array('name'=>'LESOTHO','code'=>'266'),
                        'LT'=>array('name'=>'LITHUANIA','code'=>'370'),
                        'LU'=>array('name'=>'LUXEMBOURG','code'=>'352'),
                        'LV'=>array('name'=>'LATVIA','code'=>'371'),
                        'LY'=>array('name'=>'LIBYAN ARAB JAMAHIRIYA','code'=>'218'),
                        'MA'=>array('name'=>'MOROCCO','code'=>'212'),
                        'MC'=>array('name'=>'MONACO','code'=>'377'),
                        'MD'=>array('name'=>'MOLDOVA, REPUBLIC OF','code'=>'373'),
                        'ME'=>array('name'=>'MONTENEGRO','code'=>'382'),
                        'MF'=>array('name'=>'SAINT MARTIN','code'=>'1599'),
                        'MG'=>array('name'=>'MADAGASCAR','code'=>'261'),
                        'MH'=>array('name'=>'MARSHALL ISLANDS','code'=>'692'),
                        'MK'=>array('name'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','code'=>'389'),
                        'ML'=>array('name'=>'MALI','code'=>'223'),
                        'MM'=>array('name'=>'MYANMAR','code'=>'95'),
                        'MN'=>array('name'=>'MONGOLIA','code'=>'976'),
                        'MO'=>array('name'=>'MACAU','code'=>'853'),
                        'MP'=>array('name'=>'NORTHERN MARIANA ISLANDS','code'=>'1670'),
                        'MR'=>array('name'=>'MAURITANIA','code'=>'222'),
                        'MS'=>array('name'=>'MONTSERRAT','code'=>'1664'),
                        'MT'=>array('name'=>'MALTA','code'=>'356'),
                        'MU'=>array('name'=>'MAURITIUS','code'=>'230'),
                        'MV'=>array('name'=>'MALDIVES','code'=>'960'),
                        'MW'=>array('name'=>'MALAWI','code'=>'265'),
                        'MX'=>array('name'=>'MEXICO','code'=>'52'),
                        'MY'=>array('name'=>'MALAYSIA','code'=>'60'),
                        'MZ'=>array('name'=>'MOZAMBIQUE','code'=>'258'),
                        'NA'=>array('name'=>'NAMIBIA','code'=>'264'),
                        'NC'=>array('name'=>'NEW CALEDONIA','code'=>'687'),
                        'NE'=>array('name'=>'NIGER','code'=>'227'),
                        'NG'=>array('name'=>'NIGERIA','code'=>'234'),
                        'NI'=>array('name'=>'NICARAGUA','code'=>'505'),
                        'NL'=>array('name'=>'NETHERLANDS','code'=>'31'),
                        'NO'=>array('name'=>'NORWAY','code'=>'47'),
                        'NP'=>array('name'=>'NEPAL','code'=>'977'),
                        'NR'=>array('name'=>'NAURU','code'=>'674'),
                        'NU'=>array('name'=>'NIUE','code'=>'683'),
                        'NZ'=>array('name'=>'NEW ZEALAND','code'=>'64'),
                        'OM'=>array('name'=>'OMAN','code'=>'968'),
                        'PA'=>array('name'=>'PANAMA','code'=>'507'),
                        'PE'=>array('name'=>'PERU','code'=>'51'),
                        'PF'=>array('name'=>'FRENCH POLYNESIA','code'=>'689'),
                        'PG'=>array('name'=>'PAPUA NEW GUINEA','code'=>'675'),
                        'PH'=>array('name'=>'PHILIPPINES','code'=>'63'),
                        'PK'=>array('name'=>'PAKISTAN','code'=>'92'),
                        'PL'=>array('name'=>'POLAND','code'=>'48'),
                        'PM'=>array('name'=>'SAINT PIERRE AND MIQUELON','code'=>'508'),
                        'PN'=>array('name'=>'PITCAIRN','code'=>'870'),
                        'PR'=>array('name'=>'PUERTO RICO','code'=>'1'),
                        'PT'=>array('name'=>'PORTUGAL','code'=>'351'),
                        'PW'=>array('name'=>'PALAU','code'=>'680'),
                        'PY'=>array('name'=>'PARAGUAY','code'=>'595'),
                        'QA'=>array('name'=>'QATAR','code'=>'974'),
                        'RO'=>array('name'=>'ROMANIA','code'=>'40'),
                        'RS'=>array('name'=>'SERBIA','code'=>'381'),
                        'RU'=>array('name'=>'RUSSIAN FEDERATION','code'=>'7'),
                        'RW'=>array('name'=>'RWANDA','code'=>'250'),
                        'SA'=>array('name'=>'SAUDI ARABIA','code'=>'966'),
                        'SB'=>array('name'=>'SOLOMON ISLANDS','code'=>'677'),
                        'SC'=>array('name'=>'SEYCHELLES','code'=>'248'),
                        'SD'=>array('name'=>'SUDAN','code'=>'249'),
                        'SE'=>array('name'=>'SWEDEN','code'=>'46'),
                        'SG'=>array('name'=>'SINGAPORE','code'=>'65'),
                        'SH'=>array('name'=>'SAINT HELENA','code'=>'290'),
                        'SI'=>array('name'=>'SLOVENIA','code'=>'386'),
                        'SK'=>array('name'=>'SLOVAKIA','code'=>'421'),
                        'SL'=>array('name'=>'SIERRA LEONE','code'=>'232'),
                        'SM'=>array('name'=>'SAN MARINO','code'=>'378'),
                        'SN'=>array('name'=>'SENEGAL','code'=>'221'),
                        'SO'=>array('name'=>'SOMALIA','code'=>'252'),
                        'SR'=>array('name'=>'SURINAME','code'=>'597'),
                        'ST'=>array('name'=>'SAO TOME AND PRINCIPE','code'=>'239'),
                        'SV'=>array('name'=>'EL SALVADOR','code'=>'503'),
                        'SY'=>array('name'=>'SYRIAN ARAB REPUBLIC','code'=>'963'),
                        'SZ'=>array('name'=>'SWAZILAND','code'=>'268'),
                        'TC'=>array('name'=>'TURKS AND CAICOS ISLANDS','code'=>'1649'),
                        'TD'=>array('name'=>'CHAD','code'=>'235'),
                        'TG'=>array('name'=>'TOGO','code'=>'228'),
                        'TH'=>array('name'=>'THAILAND','code'=>'66'),
                        'TJ'=>array('name'=>'TAJIKISTAN','code'=>'992'),
                        'TK'=>array('name'=>'TOKELAU','code'=>'690'),
                        'TL'=>array('name'=>'TIMOR-LESTE','code'=>'670'),
                        'TM'=>array('name'=>'TURKMENISTAN','code'=>'993'),
                        'TN'=>array('name'=>'TUNISIA','code'=>'216'),
                        'TO'=>array('name'=>'TONGA','code'=>'676'),
                        'TR'=>array('name'=>'TURKEY','code'=>'90'),
                        'TT'=>array('name'=>'TRINIDAD AND TOBAGO','code'=>'1868'),
                        'TV'=>array('name'=>'TUVALU','code'=>'688'),
                        'TW'=>array('name'=>'TAIWAN, PROVINCE OF CHINA','code'=>'886'),
                        'TZ'=>array('name'=>'TANZANIA, UNITED REPUBLIC OF','code'=>'255'),
                        'UA'=>array('name'=>'UKRAINE','code'=>'380'),
                        'UG'=>array('name'=>'UGANDA','code'=>'256'),
                        'US'=>array('name'=>'UNITED STATES','code'=>'1'),
                        'UY'=>array('name'=>'URUGUAY','code'=>'598'),
                        'UZ'=>array('name'=>'UZBEKISTAN','code'=>'998'),
                        'VA'=>array('name'=>'HOLY SEE (VATICAN CITY STATE)','code'=>'39'),
                        'VC'=>array('name'=>'SAINT VINCENT AND THE GRENADINES','code'=>'1784'),
                        'VE'=>array('name'=>'VENEZUELA','code'=>'58'),
                        'VG'=>array('name'=>'VIRGIN ISLANDS, BRITISH','code'=>'1284'),
                        'VI'=>array('name'=>'VIRGIN ISLANDS, U.S.','code'=>'1340'),
                        'VN'=>array('name'=>'VIET NAM','code'=>'84'),
                        'VU'=>array('name'=>'VANUATU','code'=>'678'),
                        'WF'=>array('name'=>'WALLIS AND FUTUNA','code'=>'681'),
                        'WS'=>array('name'=>'SAMOA','code'=>'685'),
                        'XK'=>array('name'=>'KOSOVO','code'=>'381'),
                        'YE'=>array('name'=>'YEMEN','code'=>'967'),
                        'YT'=>array('name'=>'MAYOTTE','code'=>'262'),
                        'ZA'=>array('name'=>'SOUTH AFRICA','code'=>'27'),
                        'ZM'=>array('name'=>'ZAMBIA','code'=>'260'),
                        'ZW'=>array('name'=>'ZIMBABWE','code'=>'263')
                ];
        @endphp
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">@lang('strings.invoice_sharing')</h4>
                </div>
                <div class="modal-body">
                    <button class="fa fa-inbox" id="mailto"></button>
                    <a href="https://twitter.com/intent/tweet?text=share code is {{ $booking->share_code }} and url {{ url('hotel/invoice/'.$booking->id) }}"
                       target="_blank"
                       class="fa fa-twitter"></a>
                    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ url('hotel/invoice/'.$booking->id) }}&amp;title=share code is {{ $booking->share_code }}"
                       target="_blank"
                       class="fa fa-linkedin"></a>
                    <button class="fa fa-whatsapp" id="whatsapp"></button>

                    <br>
                    @php
                        $customer = App\Customers::where('id', $booking->cust_id)->first();
                    @endphp
                    <div class="whatsapp-form" style="display:none;">
                        <form action="{{ url('share-invoice') }}" method="post">
                            @csrf
                            <input name="invoice_no" value="{{ $booking->invoice_no }}" type="hidden">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <select class="input-group-text" name="code">
                                        @foreach($prefix as $key => $value)
                                            <option {{ strtolower(session('country')) == strtolower($key) ? 'selected' : ''}}  value="+{{ $value['code'] }}">{{ $value['name'] }}</option>
                                        @endforeach
                                    </select>
                                </span>
                                <input id="email" type="text" class="form-control" name="number"
                                       placeholder="Phone number"
                                       value="{{ !empty($booking->mobile)? $booking->mobile : ''}}">
                            </div>
                            <div>
                                <button type="submit">@lang('strings.share')</button>
                            </div>
                        </form>
                    </div>

                    <div class="mailto-form" style="display:none;">
                        </br>
                        <div class="input-group">
                            <input id="mailto-message" type="hidden" class="form-control" value="Share code is:{{ $booking->share_code }} and url {{ url('hotel/invoice/'.$booking->id) }}">
                            <input id="mailto-email" type="email" class="form-control" placeholder="Email address" value="{{ !empty($booking->email)? $booking->email : ''}}">
                        </div>
                        <div>
                            <button id="mailto-button">@lang('strings.share')</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @php
        foreach ($data = App\InvoiceTemplate::where('name', $booking->invoice_template)->get() as $value){
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
                        color: {{ $data->value['header_txt_color'] }}   !important;
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
        <div id="wrap_invoice"
             class="page @if(!empty($data) && $data != '[]') {{ $data->value['invoice_default_layout'] }} {{ $data->value['invoice_default_size'] }} @else portrait A4 @endif">
            <header class="invoice_header etat_header">
                <div class="row model1">
                    @php
                        $organization = App\org::where('owner_url', explode('/',url()->current())[2] )->first();

                        $organization_logo = App\Photo::where('id', $organization->image_id)->value('file');

                    @endphp
                    <div class="col-xs-4 invoice-logo">

                        <img src="{{ !empty($organization_logo) ? asset($organization_logo) :  asset('trust.png') }}"
                             style="width:100%; max-width:100px;">
                    </div>

                    <div class="col-xs-8 invoice-header-info"><h4>{{ app()->getLocale()=='ar'?$booking->hotel->name:$booking->hotel->name_en }}</h4>
                        <p>
                            <b>@lang('strings.Address'):</b> {{ $booking->hotel->address }} <br><b>@lang('strings.Phone')
                                :</b> {{ $booking->hotel->telephone }}
                            <b><br>@lang('strings.Email'): </b> {{ $booking->hotel->email  }}
                        </p>
                    </div>
                </div>
                <hr>
                <div class='clearfix'></div>
            </header>
            <br>
            <center>
                <h3 class="page-title">@if(App\InvoiceSetup::where(['type' => 1, 'org_id' => Auth::user()->org_id])->exists() && App\InvoiceSetup::where(['type' => 1, 'org_id' => Auth::user()->org_id])->value('value') !== '') {{ App\InvoiceSetup::where(['type' => 1, 'org_id' => Auth::user()->org_id])->value('value') }} @else  @lang('strings.invoice') @endif</h3>
            </center>
            <div class="etat_content">
                <div class='page_split'>

                    <div class="row row-equal text-md-center">
                        <div class="col-xs-3">
                            <h3 class="inv col"><b>@lang('strings.invoice_id')
                                    : </b>{{  $booking->invoice_code }}</h3>
                        </div>
                        <div class="col-xs-3">
                            <h3 class="inv col"><b>@lang('strings.reservatation_no'): </b>{{ $booking->confirmation_no}}</h3>
                        </div>
                        <div class="col-xs-3">
                            <h3 class="inv col"><b>@lang('strings.invoice_date'): </b>{{ $booking->invoice_date }}</h3>
                        </div>
                        {{-- <div class="col-xs-3">
                            <h3 class="inv col"><b>@lang('strings.duedate')
                                    : </b> @if(!empty($list[0]->due_date)) {{ Dateformat( date('Y-m-d', strtotime($list[0]->date."".$list[0]->due_date." days")) ) }} @else {{ Dateformat( $list[0]->date ) }} @endif
                            </h3>
                        </div> --}}
                        <div class="col-xs-3">
                            <h3 class="inv col">
                                <b>@lang('strings.Cashier_name')
                                    : </b>{{ app()->getLocale() == 'ar' ? Auth::user()->name:Auth::user()->name_en}}
                            </h3>
                        </div>
                    </div>
                    <hr>
                    <div class="row inv">
                        <div class="col-xs-12">
                            <h4>@lang('strings.bill_to')</h4>
                        </div>
                    </div>
                    @php
                        $customer = App\Customers::where('id', $booking->cust_id)->first();
                    @endphp
                    <div class="row-cols row">
                        <div class="col-6 col-xs-6">
                            <b class="inv">{{ $customer->name }}</b>
                            <br/>
                            <b>@lang('strings.Phone'): </b> {{ $booking->mobile }} <br>
                            <b>@lang('strings.Email'): </b> {{ $booking->email }} <br>
                        </div>

                        <div class="col-6 col-xs-6"></div>
                        <div class="clearfix"></div>
                    </div>
                    <br>
                    <table class="table_invoice table_invoice-bordered table_invoice-striped"
                           style="margin-bottom: 5px;" cellpadding="0" cellspacing="0" border="0">
                        <thead>
                        <tr>
                            <th>@lang('strings.checkin_data')</th>
                            <th>@lang('strings.checkout_data')</th>
                            <th>@lang('strings.no_rooms')</th>
                            <th>@lang('strings.no_nights')</th>
                            <th>@lang('strings.no_adults')</th>
                            <th>@lang('strings.no_children')</th>
                        </tr>
                        </thead>
                        <tbody>
                          <tr>
                          <td>{{$booking->book_from}}</td>
                          <td>{{$booking->book_to}}</td>
                          <td>{{$booking->no_rooms}}</td>
                          <td>{{$booking->nights}}</td>
                          <td>{{$booking->adult_no}}</td>
                          <td>{{$booking->chiled_no}}</td>
                        </tr>
                      </tbody>
                    </table>



                    <table class="table_invoice table_invoice-bordered table_invoice-striped"
                           style="margin-bottom: 5px;" cellpadding="0" cellspacing="0" border="0">
                        <thead>
                        <tr>
                            <th>@lang('strings.Item')</th>
                            <th>@lang('strings.meal_plan')</th>
                            <th>@lang('strings.no_nights')</th>
                            <th>@lang('strings.Unit_price')</th>
                            <th>@lang('strings.Total')</th>
                            <th>@lang('strings.Tax')</th>


                        </tr>
                        </thead>
                        <tbody>
                        @if($booking->confirmed_rooms->get()->count() != 0)
                            <tr>
                                <th class="text-md-center">
                                    @lang('strings.Rooms')
                                </th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($booking->confirmed_rooms->get() as $value)
                                <tr>
                                    <td class="text-md-center">{{ app()->getLocale() == 'ar' ? App\Category::find($value->cat_id)->name : App\Category::find($value->cat_id)->name_en }}</td>
                                   @if($value->catsub_id==0)
                                    <td class="text-md-center">{{ app()->getLocale() == 'ar' ?'غرفة فقط' :'Room only'}}</td>
                                  @else
                                    <td class="text-md-center">{{ app()->getLocale() == 'ar' ? App\Category::find($value->catsub_id)->name : App\Category::find($value->catsub_id)->name_en }}</td>
                                  @endif
                                    <td class="text-md-center">{{$booking->nights}}</td>

                                    <td class="text-md-center">{{ Decimalplace(abs($value->cat_final_price/$booking->nights)) }}</td>

                                    <td class="text-md-center">{{ Decimalplace(abs($value->cat_final_price)) }}</td>

                                    <td class="text-md-center"> {{$value->tax_val}}</td>

                                </tr>
                            @endforeach
                        @endif
                        @if($booking->canceled_rooms->get()->count() != 0)
                            <tr>
                                <th class="text-md-center">
                                    @lang('strings.Canceled_rooms')
                                </th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="text-md-center">@lang('strings.cancellation_charge')</th>
                                <th></th>


                            </tr>
                            @foreach($booking->canceled_rooms->get() as $value)
                                <tr class="item">
                                    <td class="text-md-center">{{ app()->getLocale() == 'ar' ? App\Category::findOrFail($value->cat_id)->name : App\Category::findOrFail($value->cat_id)->name_en }}</td>
                                    @if($value->catsub_id==0)
                                     <td class="text-md-center">{{ app()->getLocale() == 'ar' ?'غرفة فقط' :'Room only'}}</td>
                                   @else
                                     <td class="text-md-center">{{ app()->getLocale() == 'ar' ? App\Category::findOrFail($value->catsub_id)->name : App\Category::findOrFail($value->catsub_id)->name_en }}</td>
                                   @endif
                                    <td class="text-md-center">{{ $booking->nights }}</td>
                                    <td class="text-md-center old_price wow fadeIn">{{ Decimalplace(abs($value->cat_final_price*$booking->nights)) }}</td>

                                    <td class="text-md-center">{{ Decimalplace(abs($value->cancel_charge)) }}</td>

                                    <td class="text-md-center">{{ Decimalplace(abs($value->cancel_charge)) }}</td>

                                </tr>
                            @endforeach
                        @endif

                        @if($booking->additonal_categories->get()->count() != 0)
                            <tr>
                                <th class="text-md-center">
                                    @lang('strings.additional_categories')
                                </th>
                                <th class="text-md-center">@lang('strings.type')</th>
                                <th class="text-md-center">@lang('strings.number')</th>
                                <th></th>
                                <th></th>
                                <th></th>

                            </tr>
                            @foreach($booking->additonal_categories->get() as $value)
                                <tr class="item">
                                    <td class="text-md-center">{{ app()->getLocale() == 'ar' ? App\Category::findOrFail($value->cat_id)->name : App\Category::findOrFail($value->cat_id)->name_en }}</td>
                                    <td class="text-md-center">{{ app()->getLocale() == 'ar' ? App\Category::findOrFail($value->catsub_id)->name : App\Category::findOrFail($value->catsub_id)->name_en }}</td>
                                    <td class="text-md-center">{{ $value->number }}</td>
                                    <td class="text-md-center">{{ Decimalplace(abs($value->cat_final_price)) }}</td>
                                    <td class="text-md-center">{{ Decimalplace(abs($value->cat_final_price*$value->number))}}</td>
                                    <td class="text-md-center">{{ Decimalplace(abs($value->tax_val)) }}</td>



                                </tr>
                            @endforeach
                        @endif
                        @if($booking->services->get()->count() != 0)
                            <tr>
                                <th class="text-md-center">
                                    @lang('strings.Services')
                                </th>
                                <th class="text-md-center">@lang('strings.type')</th>
                                <th class="text-md-center">@lang('strings.number')</th>
                                <th></th>
                                <th></th>
                                <th></th>

                            </tr>
                            @foreach($booking->services->get() as $value)
                                <tr>
                                   <td class="text-md-center">#####</td>
                                    <td class="text-md-center">{{ app()->getLocale() == 'ar' ? App\Category::findOrFail($value->catsub_id)->name : App\Category::findOrFail($value->catsub_id)->name_en }}</td>
                                    <td class="text-md-center">{{ $value->number }}</td>
                                    <td class="text-md-center">{{ Decimalplace(abs($value->cat_final_price)) }}</td>
                                    <td class="text-md-center">{{ Decimalplace(abs($value->cat_final_price*$value->number))}}</td>
                                    <td class="text-md-center">{{ Decimalplace(abs($value->tax_val)) }}</td>



                                </tr>
                            @endforeach
                        @endif


                        <tr>
                            <td colspan="4" class="text-md-right font-weight-bold">
                                @lang('strings.Total_Paid')
                            </td>
                            <td class="text-md-right font-weight-bold text-nowrap">
                                {{ Decimalplace($booking->pay_amount) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-md-right font-weight-bold">
                                @lang('strings.Total_Tax')
                            </td>
                            <td class="text-md-right font-weight-bold text-nowrap">
                                {{ Decimalplace(abs($booking->tax_val)) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-md-right font-weight-bold">
                                @lang('strings.Total_invoices')
                            </td>
                            <td class="text-md-right font-weight-bold text-nowrap">
                                {{ Decimalplace(abs($booking->pay_amount)) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="clear: both;"></div>
            @if(!empty($data) && $data != '[]')
            @if($data->value['show_signature'] == 1)
            <div class="etat_footer">
                <div class="row">
                    <div class="col-xs-4 col-xs-offset-8"><p>&nbsp;</p>
                    <p style="border-bottom: 1px solid #666;">&nbsp;</p>
                    <p class='text-md-center'>{{ $data->value['signature_txt'] }}</p>
                    </div>
                    </div>
                    <p>&nbsp;</p>
                    <div style="clear: both;"></div>
                    </div>
                    @endif
                    @endif
            <footer class='invoice_footer'>
                <hr>
                @if(Auth::guard('customers')->check())
                    @if(!empty($data) && $data != '[]')  {!! $data->value['footer_text'] !!} @else Filerole
                    - {{ date('Y') }} @endif

                @elseif(Auth::guest())
                    @if(!empty($data) && $data != '[]')  {!! $data->value['footer_text'] !!} @else Filerole
                    - {{ date('Y') }} @endif

                @else
                    @if(!empty($data) && $data != '[]')  {!! $data->value['footer_text'] !!} @else Filerole
                    - {{ date('Y') }} @endif
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
        minimumInputLength: 1
    });
    $('#whatsapp').click(function () {
        $('.whatsapp-form').show();
        $('.mailto-form').hide();
    });
    $('#mailto').click(function () {
        $('.mailto-form').show();
        $('.whatsapp-form').hide();
    });
    $('#mailto-button').on('click', function (event) {
          event.preventDefault();

        var email = $('#mailto-email').val();
        var subject = 'Invoice shere';
        var emailBody = $('#mailto-message').val();

        window.location = 'mailto:' + email + '?subject=' + subject + '&body=' +   emailBody;
    });

</script>
</body>
</html>

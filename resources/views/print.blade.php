<!DDOCTYPE HTML>
<html>
<head>
    <title>Filerole Membership card</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">

    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.png') }}">

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

        @page  {
            size: auto;   /* auto is the initial value */
            margin: 0mm;  /* this affects the margin in the printer settings */
        }

        html {
            background-color: #FFFFFF;
            margin: 0mm; /* this affects the margin on the html before sending to printer */
        }

        body {
            padding: 30px; /* margin you want for the content */
        }

        @import  url("https://fonts.googleapis.com/css?family=Quicksand:400,500,700&subset=latin-ext");
        html {
            position: relative;
            overflow-x: hidden !important;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            color: #324e63;
            margin: 0;
        }

        a, a:hover {
            text-decoration: none;
        }

        .icon {
            display: inline-block;
            width: 1em;
            height: 1em;
            stroke-width: 0;
            stroke: currentColor;
            fill: currentColor;
        }

        .wrapper {
            width: 100%;
            height: auto;
            min-height: 100vh;
            padding: 50px 20px;
            padding-top: 100px;
            background: none;
        }

        @media  screen and (max-width: 768px) {
            .wrapper {
                height: auto;
                min-height: 100vh;
                padding-top: 100px;
            }
        }

        .profile-card {
            width: 100%;
            min-height: auto;
            margin: auto;
            box-shadow: 0px 8px 60px -10px rgba(158, 158, 158, 0.6);
            background: #fff;
            border-radius: 12px;
            max-width: 700px;
            position: relative;
            overflow: hidden;
            text-align: right;
            direction: rtl;
            padding: 35px 35px;
            border: 0;
        }

        .title_member {

            overflow: hidden;
        }

        .title_member .fa-user {

            width: 100px;

            height: 100px;

            border-radius: 50%;

            box-shadow: 0 0 35px #e4e4e4;

            float: left;

            margin: 0 0 0 0;

            padding: 10px;

            font-size: 65px;

            text-align: center;

            line-height: 81px;

            opacity: 0.8;

            color: #101010;
        }

        .title_member img {
            width: 85px;
            height: 84px;
            border-radius: 50%;
            box-shadow: 0 0 10px #ccc;
            float: left;
            margin: 5px;
            padding: 0;
            opacity: 0.8;
        }

        .title_member .member_name {

            display: inline-block;

            font-weight: bold;

            color: #101010;

            font-size: 18px;

            margin: 5px 0 4px 0;

            color: #1fbb1f;
            display:block;
        }

        .title_member_client .member_name {display: block;font-weight: bold;margin: 3px 0 15px 0 !important;margin: 3px 0 4px 0;color: #1fbb1f;}

        .title_member .member_desk {

            display: inline-block;

            font-size: 14px;

            width: 80%;

            color: #5f5f5f;

            line-height: 25px;
        }

        hr {

            border: 1px solid #dcdcdc;

            border-bottom: 0;

            margin: 25px 5px 25px 0;

            display: block;

            width: 98%;
        }

        .info_member {padding: 0 0 0 0;display: inline-block;margin: 0 0 0 10px;font-weight: 500;color: #000;font-size: 14px;}

        .info_member i {

            margin: 0 0 0 6px;
        }

        .copyright_member {

        }

        .copyright_member p {
            display: block;
            float: none;
            width: 100%;
            font-size: 12px;
            margin: auto;
            line-height: 0;
            text-align: center;
        }

        .copyright_member a {
            text-decoration: none;
            float: none;
            color: #797979;
            font-weight: bold;
        }

        .social {
            float: none;
            display: block;
            text-align: center;
            margin: 20px 0 0 0;
        }

        .social ul {
            list-style: none;
            padding: 0 0 0 0;
            margin: 0 0 0 0;
        }

        .social ul li {
            display: inline-block;
            margin: 0 15px 0 0;
        }

        .social ul li a {
            color: #4c4c4c;
            float: none;
            font-size: 15px;
            font-weight: 400;
        }

        .social ul li a i {

            float: left;

            display: block;

            position: relative;

            font-size: 20px;

            margin: 7px 10px 0 0;
        }

        .facebook i {

            color: #1632f5;
        }

        .twitter i {

            color: #1897f1;
        }

        .instagram i {
            color: #b23bef;
        }

        .buttons_member {

            text-align: center;

            margin: 30px 0 0 0;
        }

        .buttons_member a {

            background: #000;

            color: #fff;

            padding: 5px 50px;

            border-radius: 50px;

            margin: 0 10px;

            border: 2px solid #1fbb1f;
        }

        .print {

            background: #1fbb1f !important;
        }

        .Share {

            background: none !important;

            border: 2px solid blue !important;

            color: blue !important;

            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="profile-card js-profile-card">
        
        <div id='htmltoimage'>
        @php
            $org = App\org::where('owner_url', explode('/',url()->current())[2])->first();

        @endphp
        <div class="title_member">
            <img src="{{ asset(!empty(DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->value('image_id')) && !empty(App\Photo::findOrFail(DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->value('image_id'))->file) ? App\Photo::findOrFail(DB::table('organizations')->where('owner_url', explode('/',url()->current())[2] )->value('image_id'))->file : 'trust.png') }}">
            <div class="member_name">{{ app()->getLocale() == 'ar' ? $org->name : $org->name_en }}</div>
            <p class="info_member"><i class="fa fa-envelope"></i> {{ $org->address }} </p>
            <p class="info_member"><i class="fa fa-phone"></i> {{ $org->phone }} </p>
            <p class="info_member"><i class="fa fa-barcode"></i> {{ app()->getLocale() == 'ar' ? $org->description : $org->description_en }} </p>
        </div>

        <hr>

        <div class="title_member title_member_client">
            <img src="{{$customer->photo ? asset($customer->photo->file) : asset('images/profile-placeholder.png') }}">
            <div class="member_name">{{ app()->getLocale() == 'ar' ? $customer->name : $customer->name_en }}</div>
            <p class="info_member"><i class="fa fa-envelope"></i> {{ $customer->email }} </p>
            <p class="info_member"><i class="fa fa-phone"></i> {{ $customer->phone_number }} </p>
            <p class="info_member"><i class="fa fa-barcode"></i> {{ $customer->cust_code }} </p>
        </div>

        <hr>

        <div class="copyright_member">
            <div class="social">
                <ul>
                    <li><a href="http://{{ $org->owner_url }}" target="_blank" class="link">  {{ $org->owner_url }} <i
                                    class="fa fa-link"></i></a></li>
                    @if(!empty($org->facebook))
                        <li><a href="{{ $org->facebook }}" target="_blank" class="facebook"> <i
                                        class="fa fa-facebook-f"></i> facebook </a></li>
                    @endif
                    @if(!empty($org->twitter))
                        <li><a href="{{ $org->twitter }}" target="_blank" class="twitter"> <i class="fa fa-twitter"></i>twitter
                            </a></li>
                    @endif
                    @if(!empty($org->instagram))
                        <li><a href="{{ $org->instagram }}" target="_blank" class="instagram"> <i
                                        class="fa fa-instagram"></i>instagram </a></li>
                    @endif
                </ul>
            </div>
        </div>

         </div>
       
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
                <div class="modal-content" style=" text-align: center; direction: rtl;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="font-size: 18px; font-weight: 500; color: #000; text-align: center; direction: rtl; margin: auto;">@lang('strings.invoice_sharing')</h4>
                    </div>
                    <div class="modal-body">
                        <button class="fa fa-inbox" id="mailto"></button>
                        
                        <a href="https://twitter.com/intent/tweet?text=&amp;url={{ url('invoice') }}" target="_blank"
                           class="fa fa-twitter"></a>
                        <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ url('invoice') }}&amp;title=share code is" target="_blank"
                           class="fa fa-linkedin"></a>
                        <button class="fa fa-whatsapp" id="whatsapp"></button>

                        <br>
                        <div class="whatsapp-form" style="display:none;">
                            <form action="{{ url('share-print') }}" method="post">
                                @csrf
                                <input name="id" value="{{ $customer->id }}" type="hidden">
                                <div class="input-group" style="margin: 0 0 15px 0;">
                                <span class="input-group-addon" style=" width: 135px; padding: 0 0 0 0; border: 1px solid #d6d6d6 !important;">
                                    <select class="input-group-text" name="code" style="color: #000; font-weight: normal; border: 0; padding: 0 0 0 0;">
                                        @foreach($prefix as $key => $value)
                                            <option {{ strtolower(session('country')) == strtolower($key) ? 'selected' : ''}}  value="+{{ $value['code'] }}">{{ $value['name'] }}</option>
                                        @endforeach
                                    </select>
                                </span>
                                    <input id="email" type="text" class="form-control" name="number" placeholder="Phone number" style="border-radius: 0;border-right: 0; height: 35px;" value="{{ !empty($customer->phone_number)? $customer->phone_number : ''}}">
                                </div>
                                <div>
                                    <button type="submit" style="border-radius: 3px; ">@lang('strings.share')</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="mailto-form" style="display:none;">
                        </br>
                        <div class="input-group">
                            <input id="mailto-message" type="hidden" class="form-control" value="Share code is:{{ $customer->share_code }} and url {{ url('membership/'.$customer->id) }}">
                            <input id="mailto-email" type="email" class="form-control" placeholder="Email address" value="{{ !empty($customer->email)? $customer->email : ''}}">
                        </div>
                        <div>
                            <button id="mailto-button">@lang('strings.share')</button>
                        </div>
                    </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="buttons_member">
            <a id='download-iamge' style='color:#fff;  background: #E61396 !important;border: 2px solid #E61396 !important;'>download</a>
            <a href="#" class="print"> Print </a>
            @if(\Session::get('share_code_2')[0] || \Session::get('share_submit_2')[0])
            @else
                <a href="#" class="Share" data-toggle="modal" data-target="#shere"> Share </a>
            @endif
        </div>
        


    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="{{asset('js/can/html2canvas.js')}}"></script>
    <script>
    
    $('#download-iamge').click(function () {
           var container = document.getElementById("htmltoimage");
        html2canvas(container,{allowTaint : true}).then(function(canvas) {
    
            var link = document.createElement("a");
            document.body.appendChild(link);
            link.download = "Customer.png";
            link.href = canvas.toDataURL("image/png");
            link.target = '_blank';
            link.click();
        });
    });
    
    
        $('.print').click(function () {
            $('.buttons_member').hide();
            window.print();
            $('.buttons_member').show();
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
</div>
</body>
</html>

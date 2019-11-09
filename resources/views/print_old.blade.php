<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title></title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>@page { size: A5 landscape }</style>

    <!-- Custom styles for this document -->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <style>
        body   { font-family: Roboto }
        h1     { font-family: 'Roboto', cursive; font-size: 30pt; line-height: 18mm}
        h2, h3 { font-family: 'Roboto', cursive; font-size: 16pt; line-height: 7mm; text-align: right; float:right; }
        h4     { font-size: 32pt; line-height: 14mm }
        h2 + p { font-size: 18pt; line-height: 7mm }
        h3 + p { font-size: 14pt; line-height: 7mm }
        li     { font-size: 14pt; line-height: 7mm }
        h1      { margin: 0 }
        h1 + ul { margin: 2mm 0 5mm }
        h2, h3  { margin: 0 3mm 3mm 37px; float: right }
        h2 + p,
        h3 + p  { margin: 0 0 3mm 50mm }
        h4      { margin: 10mm 0 0 40mm; border-bottom: 2px solid black }
        h4 + ul { margin: 10mm 0 0 40mm }
        article { border: 4px double black; padding: 5mm 10mm; border-radius: 3mm }
        .row {
            width: 100%;
            max-width: 1440px;
            min-width: 1200px;
            margin: 0px auto;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A5 landscape">

<!-- Each sheet element should have the class "sheet" -->
<!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
<section class="sheet padding-20mm">
    <div class="row">
        <img src="{{ App\Photo::where('id', DB::table('organizations')->where('id', Auth::user()->org_id)->value('image_id'))->value('file') }}" style="max-width: 10%">
    </div>
    <center> <h1> {{ config('settings.business_name') }} </h1> </center>
    <br>
    <article>
        <h3>@lang('strings.Client_name'):</h3>
        <p> {{ app()->getLocale() == 'ar' ? $customer->name : $customer->name_en }}</p>

        <h3>@lang('strings.Membership_start') :</h3>
        <p>{{ $customer->valid_from_date }}</p>

        <h3>@lang('strings.Membership_end') :</h3>
        <p>{{ $customer->valid_to_date }}</p>
    </article>

</section>

</body>

</html>
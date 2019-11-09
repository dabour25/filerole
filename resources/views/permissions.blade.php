<!DOCTYPE html>
<html lang="id" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!-- Title -->
    <title>Sorry, This Page Can&#39;t Be Accessed</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
</head>
<body class="bg-dark text-white py-5">
<div class="container py-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>خطا رقم : 403</p>
            <h3>الرسالة</h3>
            @if(Session::has('message'))
                <p>{{session('message')}}.</p>
            @endif
            <a class="btn btn-danger" href="javascript:history.back()">الرجوع للخلف</a>
        </div>
    </div>
</div>
</body>

</html>
<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Title -->
    <title><?php echo e(__('errors.error_404')); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <link rel="icon" href="<?php echo e(asset('favicon.png')); ?>">
</head>
<body style="background-color: #F2F2F2;">

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center" style="margin-top:10%;">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 text-center">
                        <p style="text-align: center;">
                            <img src="<?php echo e(asset('images/icon-booking-failed.png')); ?>">
                        </p>
                        <h1 class="text-dark"><strong><?php echo e(__('errors.error_404')); ?></strong></h1>
                        <br>
                        <h4 style="font-weight: 300;"><?php echo e(__('errors.404_message')); ?></h4>
                        <br>
                        <a href="javascript:history.go(-1)" class="btn btn-dark btn-lg"><?php echo e(__('errors.go_back_btn')); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js "></script>
<script src="<?php echo e(asset('js/app.js')); ?>"></script>
</body>
</html>
<?php echo $__env->make('front_hotel.layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<!-- Page content -->
<div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">
            <?php echo $__env->yieldContent('content'); ?>
            <?php echo $__env->make('front_hotel.layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <!-- /main content -->
</div>
<!-- /page content -->

</body>
</html>

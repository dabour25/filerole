<?php if(Session::has('created')): ?>
    <div class="alert alert-success" style="background:green !important;color:#fff !important"><?php echo e(session('created')); ?></div>
<?php endif; ?>

<?php if(Session::has('deleted')): ?>
    <div class="alert alert-success" style="background:green !important;color:#fff !important"><?php echo e(session('deleted')); ?></div>
<?php endif; ?>

<?php if(Session::has('updated')): ?>
    <div class="alert alert-success" style="background:green !important;color:#fff !important"><?php echo e(session('updated')); ?></div>
<?php endif; ?>

<?php if(Session::has('danger')): ?>
    <div class="alert alert-danger" style="background:red !important;color:#fff !important"><?php echo e(session('danger')); ?></div>
<?php endif; ?>
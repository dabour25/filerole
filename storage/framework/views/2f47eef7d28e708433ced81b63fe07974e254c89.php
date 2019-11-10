<?php if(Session::has('role_created')): ?>
    <div class="alert alert-success"><?php echo e(session('role_created')); ?></div>
<?php endif; ?>

<?php if(Session::has('role_deleted')): ?>
    <div class="alert alert-success"><?php echo e(session('role_deleted')); ?></div>
<?php endif; ?>

<?php if(Session::has('role_updated')): ?>
    <div class="alert alert-success"><?php echo e(session('role_updated')); ?></div>
<?php endif; ?>
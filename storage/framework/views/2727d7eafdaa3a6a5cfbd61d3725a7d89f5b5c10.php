<?php if(Session::has('user_created')): ?>
    <div class="alert alert-success"><?php echo e(session('user_created')); ?></div>
<?php endif; ?>

<?php if(Session::has('user_deleted')): ?>
    <div class="alert alert-success"><?php echo e(session('user_deleted')); ?></div>
<?php endif; ?>

<?php if(Session::has('user_updated')): ?>
    <div class="alert alert-success"><?php echo e(session('user_updated')); ?></div>
<?php endif; ?>
<?php if(Session::has('user_type_created')): ?>
    <div class="alert alert-success"><?php echo e(session('user_type_created')); ?></div>
<?php endif; ?>
<?php if(Session::has('user_change_password')): ?>
    <div class="alert alert-success"><?php echo e(session('user_change_password')); ?></div>
<?php endif; ?>


<?php if(Session::has('danger')): ?>
    <div class="alert alert-danger"><?php echo e(session('danger')); ?></div>
<?php endif; ?>
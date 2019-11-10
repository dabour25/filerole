<?php $__env->startSection('content'); ?>

    <!--<div class="page-title">-->
    <!--    <h3><?php echo e(__('strings.Roles')); ?></h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="<?php echo e(route('home')); ?>"><?php echo e(__('strings.Home')); ?></a></li>-->
    <!--            <li class="active"><?php echo e(__('strings.Roles')); ?></li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                  <div class="alert_new">
                          <span class="alertIcon">
                              <i class="fas fa-exclamation-circle"></i>
                           </span>
                          <p>
                              <?php if(app()->getLocale() == 'ar'): ?>
            <?php echo e(DB::table('function_new')->where('id',70)->value('description')); ?>

            <?php else: ?>
            <?php echo e(DB::table('function_new')->where('id',70)->value('description_en')); ?>

            <?php endif; ?>
                          </p>
                          <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                          </a>
                      </div>
                <?php echo $__env->make('alerts.roles', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <a class="btn btn-primary btn-lg btn-add" href="<?php echo e(route('roles.create')); ?>" ><i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo e(__('strings.Role_add')); ?></a>
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title"><?php echo e(__('strings.Roles')); ?></h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                        <tr>
                                            <!--<th>#</th>-->
                                            <th><?php echo e(__('strings.Arabic_name')); ?></th>
                                            <th><?php echo e(__('strings.English_name')); ?></th>
                                            <th><?php echo e(__('strings.Description')); ?></th>
                                                <th><?php echo e(__('strings.Settings')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <!--<td><?php echo e($role->id); ?></td>-->
                                                <td><?php echo e($role->name); ?></td>
                                                <td><?php echo e($role->name_en); ?></td>
                                                <td><?php echo $role->description; ?></td>
                                                    <td>
                                                    <a href="<?php echo e(route('roles.edit',$role->id)); ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>

                                                    

                                                    <!-- User Delete Modal -->
                                                    <div id="<?php echo e($role->id); ?>" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title"><?php echo e(__('backend.confirm')); ?></h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><?php echo e(__('backend.delete_role_message')); ?></p>
                                                                </div>
                                                                <form method="post" action="<?php echo e(route('roles.destroy', $role->id)); ?>">
                                                                    <div class="modal-footer">
                                                                        <?php echo e(csrf_field()); ?>

                                                                        <?php echo e(method_field('DELETE')); ?>

                                                                        <button type="submit" class="btn btn-danger"><?php echo e(__('backend.delete_btn')); ?></button>
                                                                        <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo e(__('backend.no')); ?></button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <script>

        function _open(id, that) {
            $td_edit = $(that);
            jQuery('#modal_view_roles_edit .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="<?php echo e(asset('/lg.azure-round-loader.gif')); ?>" /></div>');
            // LOADING THE AJAX MODAL
            jQuery('#modal_view_roles_edit').modal('show', {backdrop: 'true'});
            // SHOW AJAX RESPONSE ON REQUEST SUCCESS
            $.ajax({
                url: 'roles/' + id + '/edit',
                success: function (response) {
                    jQuery('#modal_view_roles_edit .modal-body').html(response);
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', ['title' => __('strings.Roles') ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
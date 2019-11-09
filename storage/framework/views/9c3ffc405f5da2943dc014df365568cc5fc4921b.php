<?php $__env->startSection('content'); ?>

    <div id="main-wrapper" class="users-page">
        <div class="row">
            <div class="col-md-12">
                  <div class="alert_new">
                          <span class="alertIcon">
                              <i class="fas fa-exclamation-circle"></i>
                           </span>
                          <p>
                         <?php if(Request::is('admin/employees')): ?>
                              <?php if(app()->getLocale() == 'ar'): ?>
            <?php echo e(DB::table('function_new')->where('id',69)->value('description')); ?>

            <?php else: ?>
            <?php echo e(DB::table('function_new')->where('id',69)->value('description_en')); ?>

            <?php endif; ?>
            
            <?php else: ?>
              <?php if(app()->getLocale() == 'ar'): ?>
            <?php echo e(DB::table('function_new')->where('id',101)->value('description')); ?>

            <?php else: ?>
            <?php echo e(DB::table('function_new')->where('id',101)->value('description_en')); ?>

            <?php endif; ?>
            
            <?php endif; ?>
                          </p>
                          <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                          </a>
                      </div>
                <?php echo $__env->make('alerts.users', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php if(permissions('users_add') == 1 || permissions('employees_add') == 1): ?>
                    <a class="btn btn-primary btn-lg btn-add"
                       href="<?php echo e(Request::is('admin/employees') ? route('employees.create') : route('users.create')); ?>"><i
                                class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo e(__('strings.add')); ?>

                    </a>
                <?php endif; ?>

                <?php if(permissions('users_view') == 1 || permissions('employees_view') == 1): ?>
                    <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title"><?php echo e(Request::is('admin/employees') ? app()->getLocale() == 'ar' ? ActivityLabel('employees')->value : ActivityLabel('employees')->value_en : __('strings.Users')); ?></h4>
                    </div>
                    <div class="panel-body">
                        <div>
                            <table id="xtreme-table55" class="table table-striped table-bordered dt-responsive nowrap"
                                   style="width: 100%">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('strings.Users_code')); ?></th>
                                        <th><?php echo e(__('strings.Photo')); ?></th>
                                        <th><?php echo e(__('strings.Arabic_name')); ?></th>
                                        <th><?php echo e(__('strings.English_name')); ?></th>
                                        <th><?php echo e(__('strings.Phone')); ?></th>
                                        <th><?php echo e(__('strings.Roles')); ?></th>
                                        <th><?php echo e(__('strings.Section')); ?></th>
                                        <th><?php echo e(__('strings.Status')); ?></th>
                                        <?php if(permissions('users_edit') == 1 || permissions('users_change_password') == 1|| permissions('employees_edit') == 1 || permissions('users_send_password') == 1): ?>
                                            <th><?php echo e(__('strings.Settings')); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = Request::is('admin/employees') ? $users->where('used_type', 1) : $users->where('used_type', 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($user->code); ?></td>
                                        <td>
                                            <img src="<?php echo e($user->photo ? asset($user->photo->file) : asset('images/profile-placeholder.png')); ?>"
                                                 class="img-circle avatar" width="40" height="40"></td>
                                        <td><?php echo e($user->name); ?></td>
                                        <td><?php echo e($user->name_en); ?></td>
                                        <td><?php echo e($user->phone_number); ?></td>
                                        <td><?php echo e(ucfirst(app()->getLocale() == 'ar' ? $user->role->name : $user->role->name_en)); ?></td>
                                        <td><?php echo e(ucfirst(app()->getLocale() == 'ar' ? $user->section['name'] : $user->section['name_en'])); ?></td>
                                        <td>
                                            <?php if($user->is_active): ?>
                                                <span class="label label-success"
                                                      style="font-size:12px;"><?php echo e(__('strings.Active')); ?></span>
                                            <?php else: ?>
                                                <span class="label label-danger"
                                                      style="font-size:12px;"><?php echo e(__('strings.Deactivate')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <?php if(permissions('users_edit') == 1 || permissions('users_change_password') == 1 || permissions('employees_edit') == 1 || permissions('users_send_password') == 1): ?>
                                            <td>
                                                <a href="<?php echo e(Request::is('admin/employees') ? route('employees.edit', $user->id): route('users.edit', $user->id)); ?>"
                                                   class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                   data-placement="bottom" title="" data-original-title="تعديل"><i
                                                            class="fa fa-pencil"></i></a>
                                                <?php if( Request::is('admin/users')): ?>
                                                    <?php if(permissions('users_send_password') == 1): ?>
                                                        <a href="<?php echo e(route('users.send_password', $user->id)); ?>"
                                                           class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                           data-placement="bottom" title=""
                                                           data-original-title="أرسل بيانات الدخول"
                                                           onclick="return confirm('سنقوم بإنشاء كلمة مرور جديدة. هل تريد الاستمرار');"><i
                                                                    class="fa fa-mail-reply"></i></a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php if($user->id != Auth::user()->id): ?>
                                                    <?php if( Request::is('admin/users')): ?>
                                                        <?php if(permissions('users_change_password') == 1): ?>
                                                        <a href="#" onclick="_open(<?php echo e($user->id); ?>)"
                                                           class="btn btn-primary btn-xs"><i class="fa fa-key"
                                                                                             data-toggle="tooltip"
                                                                                             data-placement="bottom"
                                                                                             title=""
                                                                                             data-original-title="تغيير كلمة السر"></i></a>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    

                                                <!-- User Delete Modal -->
                                                    <div id="<?php echo e($user->id); ?>" class="modal fade" role="dialog"
                                                         data-keyboard="false" data-backdrop="static">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal">&times;
                                                                    </button>
                                                                    <h4 class="modal-title"><?php echo e(__('backend.confirm')); ?></h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><?php echo e(__('backend.delete_user_message')); ?></p>
                                                                </div>
                                                                <form method="post"
                                                                      action="<?php echo e(route('users.destroy', $user->id)); ?>">
                                                                    <div class="modal-footer">
                                                                        <?php echo e(csrf_field()); ?>

                                                                        <?php echo e(method_field('DELETE')); ?>

                                                                        <button type="submit"
                                                                                class="btn btn-danger"><?php echo e(__('backend.delete_btn')); ?></button>
                                                                        <button type="button" class="btn btn-primary"
                                                                                data-dismiss="modal"><?php echo e(__('backend.no')); ?></button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>

                            </table>
                            <?php echo e($users->links()); ?>

                        </div>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!--begin::Modal-->
    <div class="modal fade" id="modal_view_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <?php echo e(__('strings.Change_password')); ?>

                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                &times;
                            </span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-cancel" data-dismiss="modal">
                        <i class="fas fa-times"></i> <?php echo e(__('strings.Cancel')); ?>

                    </button>
                    <button type="button" class="btn btn-primary"
                            onclick="document.forms['password'].submit(); return false;">
                        <i class="fas fa-save"></i> <?php echo e(__('strings.Save')); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

    <script>
        function _open(id, that) {
            $td_edit = $(that);
            jQuery('#modal_view_password').modal('show', {backdrop: 'true'});
            $.ajax({
                url: 'users/' + id + '/change-password',
                success: function (response) {
                    jQuery('#modal_view_password .modal-body').html(response);
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', ['title' =>  Request::is('admin/employees') ? app()->getLocale() == 'ar' ? ActivityLabel('employees')->value : ActivityLabel('employees')->value_en : __('strings.Users') ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
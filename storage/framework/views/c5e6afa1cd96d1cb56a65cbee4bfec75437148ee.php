<?php $__env->startSection('content'); ?>
    <!--<div class="page-title">-->
    <!--    <h3> <?php echo e(__('strings.Role_add')); ?> </h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="<?php echo e(route('home')); ?>"><?php echo e(__('strings.Home')); ?></a></li>-->
    <!--            <li><a href="<?php echo e(route('roles.index')); ?>"><?php echo e(__('strings.Roles')); ?></a></li>-->
    <!--            <li class="active"><?php echo e(__('strings.Role_add')); ?></li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->
    <div id="main-wrapper">
        <div class="row">
            <form method="post" action="<?php echo e(route('roles.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" class="form-control" name="user_id" value="<?php echo e(Auth::user()->id); ?>">

                <div class="col-md-6 form-group<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                    <strong class="text-danger">*</strong>
                    <label class="control-label" for="name"><?php echo e(__('strings.Arabic_name')); ?></label>
                    <input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>">
                    <?php if($errors->has('name')): ?>
                        <span class="help-block">
                            <strong class="text-danger"><?php echo e($errors->first('name')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 form-group<?php echo e($errors->has('name_en') ? ' has-error' : ''); ?>">
                    <strong class="text-danger">*</strong>
                    <label class="control-label" for="name_en"><?php echo e(__('strings.English_name')); ?></label>
                    <input type="text" class="form-control" name="name_en" value="<?php echo e(old('name_en')); ?>">
                    <?php if($errors->has('name_en')): ?>
                        <span class="help-block">
                            <strong class="text-danger"><?php echo e($errors->first('name_en')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="col-md-12 form-group">
                    <div class="check_all">
                        
                      <div class="title_check_menu">
                          <h3>إعدادات القائمة</h3>
                          <p>
                            <button type="button" class="checkall checkall_check"> تحديد الكل </button>
                            <button type="button" class="checkall checkall_uncheck"> الغاء الكل </button>
                          </p>
                      </div>
                      
                      <ul class="Newnav">
                          
                         <?php $__currentLoopData = $parent_auths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $par): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          
                        <li class="dropdown mega-dropdown">
                            <input type="checkbox" onclick="checkallin(<?php echo e($par->id); ?>)" class="checkhour" id="par<?php echo e($par->id); ?>" name="acs[]" value="<?php echo e($par->id); ?>">
                            <a href="javascript:;" class="dropdown-toggle" tabindex="-1" aria-expanded="false" class="dropdown-toggle">
                                <p id="partext<?php echo e($par->id); ?>" class="partext">
                                    <?php echo e(app()->getLocale()=='ar'?$par->funcname:$par->funcname_en); ?>

                                    <i class="fas fa-chevron-down"></i>
                                </p>
                            </a>
                            
                            <ul class="dropdown-menu dropdown-menuNew mega-dropdown-menu">
                                <?php $__currentLoopData = $par->childs()->where('org_id', Auth::user()->org_id)->where('funcparent_id','>',0)->orderBy('porder')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="check_menu">
                                    
                                    <label class="containerss">
                                    <?php echo e(app()->getLocale() == 'ar' ? $auth->funcname : $auth->funcname_en); ?>

                                   <input type="checkbox" name="acs[]" type="checkbox" value="<?php echo e($auth->id); ?>" class="checkhour checkchild<?php echo e($par->id); ?>" id="child<?php echo e($auth->id); ?>" onclick="checktiny(<?php echo e($par->id); ?>,<?php echo e($auth->id); ?>)">
                                   <span class="checkmark"></span>
                                   </label>

                                    <div class="innercon">
                                    <?php $__currentLoopData = $auth->childs()->where('org_id',Auth::user()->org_id)->orderby('porder')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="containerss"> 
                                        <?php echo e(app()->getLocale() == 'ar' ? $child->funcname : $child->funcname_en); ?>

                                        <input type="checkbox" name="acs[]" type="checkbox" value="<?php echo e($child->id); ?>" class="checkhour checkchild<?php echo e($par->id); ?> tinycheck<?php echo e($auth->id); ?>" id="tiny<?php echo e($child->id); ?>" onclick="checkselected(<?php echo e($par->id); ?>,<?php echo e($auth->id); ?>)"> 
                                        <span class="checkmark"></span>
                                        </label>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </div>
   
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            
                        </li>
                        
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </ul>
                    </div>
                </div>
                <div class="col-md-12 form-group<?php echo e($errors->has('description') ? ' has-error' : ''); ?>">
                    <label class="control-label" for="description"><?php echo e(__('strings.Description')); ?></label>
                    <textarea type="text" class="form-control textall" name="description"><?php echo e(old('description')); ?></textarea>
                    <?php if($errors->has('description')): ?>
                    <span class="help-block">
                        <strong class="text-danger"><?php echo e($errors->first('description')); ?></strong>
                    </span>
                    <?php endif; ?>
                </div>
                <div class="col-md-12 form-group text-right">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> <?php echo e(__('strings.Save')); ?>

                    </button>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', ['title' => __('strings.Role_add') ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
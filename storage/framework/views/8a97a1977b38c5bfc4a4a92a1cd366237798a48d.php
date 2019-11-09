<?php
	if(DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->exists()){
		$org = DB::table('organizations')->where('owner_url', explode('/',url()->current())[2])->first();
	}
	if(App\Organization::where('custom_domain', explode('/',url()->current())[2])->exists()){
		$org = App\Organization::where('custom_domain', explode('/',url()->current())[2])->first();
	}
?>



<?php $__env->startSection('content'); ?>
    <div class="limiter">
        <div class="container-login100" style="background:url(<?php echo e(asset(!empty($org->front_image) && !empty(App\Photo::findOrFail($org->front_image)->file) ? str_replace(' ', '%20', App\Photo::findOrFail($org->front_image)->file) : '')); ?>)">
            <div class="overlay_login"></div>

            <a href="http://master.filerolesys.com" target="_blank">
                <img src="http://master.filerolesys.com/front/images/shape4.png" alt="" class="img-fluid shape-wthree shape-w3-five" style="    position: absolute;left: 35px;top: 20px;">
            </a>

            <div class="wrap-login100">
                <?php if(Request::is('admin/login')): ?>
                    <form class="login100-form validate-form" method="post" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="login100-pic js-tilt pulse" data-tilt>
                            <img src="<?php echo e(asset(!empty($org->image_id) && !empty(App\Photo::findOrFail($org->image_id)->file) ? App\Photo::findOrFail($org->image_id)->file : 'trust.png')); ?>"
                                 alt="IMG">
                        </div>

                        <span class="login100-form-title">
							<?php echo e($org->name); ?>

						</span>
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <strong style="font-weight: 400;"><?php echo e($errors->first()); ?></strong>
                            </div>
                        <?php endif; ?>
                        <div class="wrap-input100 validate-input" data-validate="Email Or Phone number is required">
                            <input class="input100" type="text" name="email_phone" placeholder="Email Or Phone number"
                                   value="<?php echo e(old('email_phone')); ?>">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
								<i class="fa fa-envelope" aria-hidden="true"></i>
								<i class="fa fa-phone" aria-hidden="true"></i>
							</span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Password is required">
                            <input class="input100" type="password" name="password" placeholder="Password"
                                   id="showpassword">
                            <a href="#" onclick="showPass()" class="showpass"><i class="fa fa-eye"></i></a>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
								<i class="fa fa-lock" aria-hidden="true"></i>
							</span>
                        </div>

                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                Login
                            </button>
                        </div>

                        <div class="text-center p-t-12">
					<span class="txt1">
						Forgot
					</span>
                            <a class="txt2" href="<?php echo e(url('admin/password/reset')); ?>">
                                Password?
                            </a>
                        </div>

                        <!--<div class="text-center p-t-136">
                            <a class="txt2" href="#">
                                Create your Account
                                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                            </a>
                        </div>-->
                    </form>
                <?php else: ?>
                    <form class="login100-form validate-form" method="post" action="<?php echo e(url('dologin')); ?>">
                        <?php echo csrf_field(); ?>
                        <span class="login100-form-title">
						Member Login
					</span>
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <strong><?php echo e($errors->first()); ?></strong>
                            </div>
                        <?php endif; ?>

                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <input class="input100" type="text" name="email" placeholder="Email"
                                   value="<?php echo e(old('email')); ?>">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Password is required">
                            <input class="input100" type="password" name="password" placeholder="Password">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                        </div>

                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                Login
                            </button>
                        </div>

                        <div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
                            <a class="txt2" href="<?php echo e(route('password.request')); ?>">
                                Username / Password?
                            </a>
                        </div>

                        <!--<div class="text-center p-t-136">
                            <a class="txt2" href="#">
                                Create your Account
                                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                            </a>
                        </div>-->
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function showPass() {
            var x = document.getElementById("showpassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.login', ['title' => $org->name_en. ' - Admin Login'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
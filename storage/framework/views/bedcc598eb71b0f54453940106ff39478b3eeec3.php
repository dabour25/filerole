<footer>
  <?php

     $my_url=url()->current();
     $my_url=$_SERVER['HTTP_HOST'];
    $org=DB::table('organizations')->where('customer_url',$my_url)->first();
    $org_id_login=$org->id;
   if(empty($org)){
    $org_master=\App\Organization::where('custom_domain',$last[2]);
    $org=\App\org::where('id',$org_master->org_id);
    $org_id_login=$org_master->org_id;
   }

    ?>
    <div class="container">
        <div class="row">

            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="links_footer">
                    <h3 class="title_footer">	<?php echo e(app()->getLocale() == 'ar' ? $org->name : $org->name_en); ?> Pages </h3>
                    <ul>
                      <li> <a href="<?php echo e(url('/frontpage')); ?>"> <?php echo app('translator')->getFromJson('strings.Home'); ?> </a> </li>
                      <li> <a href="<?php echo e(url('/offers')); ?>"> <?php echo app('translator')->getFromJson('strings.Offers'); ?> </a> </li>
                      <li> <a href="<?php echo e(url('/categorys')); ?>"> <?php echo app('translator')->getFromJson('strings.cat_ser'); ?>  </a> </li>
                      <li> <a href="<?php echo e(url('/aboutus')); ?>"> <?php echo app('translator')->getFromJson('strings.about_us'); ?>  </a> </li>
                      <li> <a href="<?php echo e(url('/contact')); ?>"> <?php echo app('translator')->getFromJson('strings.contact_us'); ?></a> </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4 col-xs-12">
                <div class="newsletter">
                    <h3 class="title_footer"><?php echo app('translator')->getFromJson('strings.front_text3'); ?> </h3>
                    <p><?php echo app('translator')->getFromJson('strings.front_text1'); ?></p>
                    <form  action="<?php echo e(url('/subscribers_message')); ?>" name="newsletter" action="post">
                        <input type="email" placeholder="example@email.com" name="email" required>
                        <button type="submit" class="btn btn-submit"><?php echo app('translator')->getFromJson('strings.join_us'); ?></button>
                    </form>
                </div>
            </div>

            <div class="col-md-4 col-xs-12">
                <div class="info_footer">
                    <h3 class="title_footer"> <?php echo app('translator')->getFromJson('strings.front_text2'); ?></h3>
                    <a href="tel:0220187656" class="phone_footer"><i class="fas fa-phone"></i> <?php echo e($org->phone); ?> </a>
                    <a href="mailto:<?php echo e($org_id->email_crm); ?>" class="email_footer"> <i class="fas fa-envelope"></i> <?php echo e($org->email_crm); ?></a>
                    <p class="adress">
                      <?php echo e($org_id->address); ?>

                    </p>
                    <a href="https://google.com/maps" target="_blank"> <?php echo app('translator')->getFromJson('strings.front_text4'); ?> </a>
                </div>
            </div>

        </div>

        <!-- last footer -->
        <div class="last_footer">
            <div class="row">
                <div class="col-md-6 col-xs-12">

                    <p class="text_copyright">
                    <a href="#home"> <?php echo e(app()->getLocale() == 'ar' ? $org->name : $org->name_en); ?> </a>  <p class="buy_f"> © 2019 <?php echo app('translator')->getFromJson('strings.front_text5'); ?> <a href="http://www.filerole.com/" target="_blank"><?php echo app('translator')->getFromJson('strings.fileRole'); ?></a>  </p>
                    </p>

                </div>

                <div class="col-md-6 col-xs-12">
                    <div class="social_footer">
                        <h5><?php echo app('translator')->getFromJson('strings.contact_us'); ?></h5>
                        <ul>
                          <li> <a href="<?php echo e($org_id->facebook); ?>" target="_blank"> <i class="fab fa-facebook-f"></i> </a> </li>
                          <li> <a href="<?php echo e($org_id->twitter); ?>" target="_blank"> <i class="fab fa-twitter"></i> </a> </li>
                          <li> <a href="<?php echo e($org_id->instgram); ?>" target="_blank"> <i class="fab fa-instagram"></i> </a> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> <!-- // last footer -->


    </div>
</footer> <!-- // footer -->

<!-- js files -->
<script src="https://code.jquery.com/jquery-3.4.0.min.js"
integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="/front/js/wow.min.js"></script>
<script src="/front/js/owl.carousel.min.js"></script>
<script src="/front/js/three.r92.min.js"></script>
<script src="/front/js/vanta.dots.min.js"></script>
<script src="/front/js/main.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
<script src="/front/js/script.js"></script>

<script>
VANTA.DOTS({
  el: "#bgSlider",
  backgroundColor: 0x313131
})
</script>
<script>
    $('.nav-tabs a:first').tab('show')
</script>

<?php echo $__env->yieldContent('scripts'); ?>
</div>
<body>
<html>

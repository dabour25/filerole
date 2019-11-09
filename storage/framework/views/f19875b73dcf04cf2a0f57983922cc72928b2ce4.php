<!--
Author: FileRole
Author URL: http://filerole.com
-->



<?php $__env->startSection('content'); ?>

    <div id="page_header" class="page-subheader page-subheader-bg">
      <?php

      $my_url=url()->current();
      $last = explode('/', $my_url);
      $org=DB::table('organizations')->where('customer_url',$last[2])->first();
      $org_id_login=$org->id;
      if(empty($org)){
      $org_master=\App\Organization::where('custom_domain',$last[2]);
      $org=\App\org::where('id',$org_master->org_id);
      $org_id_login=$org_master->org_id;
      }
      $show_cart=\App\Settings::where(['org_id' =>$org->id,'key'=> 'basket','value'=>'on'])->first();
      ?>
        <!-- Sub-Header content wrapper -->
        <div class="ph-content-wrap d-flex">
            <div class="container align-self-center">
                <div class="row">

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="subheader-titles">
                            <h2 class="subheader-maintitle">
                              <?php echo app('translator')->getFromJson('strings.Offers'); ?>
                            </h2>

                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <ul class="breadcrumbs fixclear">
                            <li><a href="/"><?php echo app('translator')->getFromJson('strings.Home'); ?></a></li>
                            <li><?php echo app('translator')->getFromJson('strings.Offers'); ?></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>

        <!-- Sub-Header bottom mask style 6 -->
        <div class="kl-bottommask kl-bottommask--mask6">
            <svg width="2700px" height="57px" class="svgmask" viewBox="0 0 2700 57" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">
                <defs>
                    <filter x="-50%" y="-50%" width="200%" height="200%" filterUnits="objectBoundingBox" id="filter-mask6">
                        <feOffset dx="0" dy="-2" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset>
                        <feGaussianBlur stdDeviation="2" in="shadowOffsetOuter1" result="shadowBlurOuter1"></feGaussianBlur>
                        <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.5 0" in="shadowBlurOuter1" type="matrix" result="shadowMatrixOuter1"></feColorMatrix>
                        <feMerge>
                            <feMergeNode in="shadowMatrixOuter1"></feMergeNode>
                            <feMergeNode in="SourceGraphic"></feMergeNode>
                        </feMerge>
                    </filter>
                </defs>
                <g transform="translate(-1.000000, 10.000000)">
                    <path d="M0.455078125,18.5 L1,47 L392,47 L1577,35 L392,17 L0.455078125,18.5 Z" fill="#000000"></path>
                    <path d="M2701,0.313493752 L2701,47.2349598 L2312,47 L391,47 L2312,0 L2701,0.313493752 Z" fill="#fbfbfb" class="bmask-bgfill" filter="url(#filter-mask6)"></path>
                    <path d="M2702,3 L2702,19 L2312,19 L1127,33 L2312,3 L2702,3 Z" fill="#cd2122" class="bmask-customfill"></path>
                </g>
            </svg>
        </div>

    </div>

    <!-- categorys page -->
    <div class="latest_product categorys_product_page">
        <div class="container">

        <ul class="nav nav-tabs nav-page-caty" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#Products"><?php echo app('translator')->getFromJson('strings.products'); ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#Services"><?php echo app('translator')->getFromJson('strings.Services'); ?></a>
          </li>
        </ul>

        <div class="tab-content">

                <div class="tab-pane active" id="Products" role="tabpanel" aria-labelledby="Products">
                    <div class="row">
                        <div class="col-md-3 col-xs-12">
                            <ul class="nav nav-tabs nav-page-caty nav-page-sub-caty" role="tablist">
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#product<?php echo e($product->id); ?>"> <i class="fas fa-angle-right"></i> <?php echo e(app()->getLocale() =='ar' ? $product->name : $product->name_en); ?></a>
                              </li>
	                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </ul>
                        </div>

                        <div class="col-md-9 col-xs-12">



                            <div class="tab-content">

                                <div class="tab-pane active" id="hidden_tab" role="tabpanel" aria-labelledby="hidden_tab">
                                     <div class="row">

                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $product->product_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product->product_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(front_cat_price($product->product_type->id,$org_id_login)['original_price'] != front_cat_price($product->product_type->id,$org_id_login)['catPrice']): ?>
                                <div class="col-md-4 col-xs-12">
                                <div class="item_pro ">
                                <a href="details/<?php echo e($product->product_type->id); ?>"> <img src="<?php echo e(asset(str_replace(' ', '%20', \App\Photo::find($product->product_type->photo_id)->file))); ?>"   class="img_caty"></a>
                                <h3><?php echo e(app()->getLocale() =='ar' ? $product->product_type->name : $product->product_type->name_en); ?></h3>
                                <div class="price_add">
                                     <h6 class="final_price"><?php echo e(front_cat_price($product->product_type->id,$org_id_login)['original_price']); ?></h6>
                                     <h6><?php echo e(front_cat_price($product->product_type->id,$org_id_login)['catPrice']); ?></h6>
                                       <?php if($show_cart): ?>
                                     <a href="#" data-name="<?php echo e(app()->getLocale() =='ar' ?  $product->product_type->name : $product->product_type->name_en); ?>" data-price="<?php echo e(front_cat_price($product->product_type->id,$org_id_login)['catPrice']); ?>"  data-id="<?php echo e($product->product_type->id); ?>" data-description="<?php echo e(app()->getLocale() =='ar' ? $product->product_type->description :  $product->product_type->description_en); ?>" class="add-to-cart btn btn-primary" ><i class="fas fa-cart-plus"></i>add to cart </a>
                                        <?php endif; ?>
                                 </div>
                                  </div>
                                </div>
                                <?php endif; ?>
                                <?php break; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>
                                </div>

                                 <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    							  <?php if(count($product->product_types)): ?>


									<div class="tab-pane  " id="product<?php echo e($product->id); ?>" role="tabpanel" aria-labelledby="product<?php echo e($product->id); ?>">

									<div class="items_product">
                                    <div class="row">
                                         <?php $__currentLoopData = $product->product_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product->product_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <?php if(front_cat_price($product->product_type->id,$org_id_login)['original_price'] != front_cat_price($product->product_type->id,$org_id_login)['catPrice']): ?>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="item_pro " data-wow-delay="0.20s">
                                                  <a href="details/<?php echo e($product->product_type->id); ?>"> <img src="<?php echo e(asset(str_replace(' ', '%20', \App\Photo::find($product->product_type->photo_id)->file))); ?>"   class="img_caty"></a>
                                                <h3><?php echo e(app()->getLocale() =='ar' ? $product->product_type->name : $product->product_type->name_en); ?></h3>
                                                <div class="price_add">
                                                       <h6 class="final_price"><?php echo e(front_cat_price($product->product_type->id,$org_id_login)['original_price']); ?></h6>
                                                       <h6><?php echo e(front_cat_price($product->product_type->id,$org_id_login)['catPrice']); ?></h6>
                                                      <?php if($show_cart): ?>
                                                    <a href="#" data-name="<?php echo e(app()->getLocale() =='ar' ? $product->product_type->name : $product->product_type->name_en); ?>" data-price="<?php echo e(front_cat_price($product->product_type->id,$org_id_login)['catPrice']); ?>"  data-id="<?php echo e($product->product_type->id); ?>" data-description="<?php echo e(app()->getLocale() =='ar' ? $product->product_type->description : $product->product_type->description_en); ?>" class="add-to-cart btn btn-primary"><i class="fas fa-cart-plus"></i>add to cart </a>
                                                      <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                          <?php endif; ?>
                                    	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                            </div>



						   <?php else: ?>
						  <div class="tab-pane  " id="product<?php echo e($product->id); ?>" role="tabpanel" aria-labelledby="product<?php echo e($product->id); ?>">
                          <?php echo e('NO DATA Available TO SHOW '); ?>

							</div>

    						<?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="tab-pane" id="Services" role="tabpanel" aria-labelledby="Services">
                    <div class="row">
                        <div class="col-md-3 col-xs-12">
                            <ul class="nav nav-tabs nav-page-caty nav-page-sub-caty" role="tablist">
                                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#service<?php echo e($service->id); ?>"> <i class="fas fa-angle-right"></i> <?php echo e(app()->getLocale() =='ar' ? $service->name : $service->name_en); ?></a>
                              </li>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>

                        <div class="col-md-9 col-xs-12">

                            <div class="tab-content">

                            <div class="tab-pane active" id="hidden_tab" role="tabpanel" aria-labelledby="hidden_tab">
                                 <div class="row">
                             <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php $__currentLoopData = $service->service_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service->service_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php if(front_cat_price( $service->service_type->id,$org_id_login)['original_price'] != front_cat_price($service->service_type->id,$org_id_login)['catPrice']): ?>
                               <div class="col-md-4 col-xs-12">
                                <div class="item_pro ">
                                 <a href="details/<?php echo e($service->service_type->id); ?>"> <img src="<?php echo e(asset(str_replace(' ', '%20', \App\Photo::find($service->service_type->photo_id)->file))); ?>"   class="img_caty"></a>
                                <div class="price_add">
                                    <h6 class="final_price"><?php echo e(front_cat_price($service->service_type->id,$org_id_login)['original_price']); ?></h6>
                                    <h6><?php echo e(front_cat_price($service->service_type->id,$org_id_login)['catPrice']); ?></h6>
                                    <?php if($show_cart): ?>
                                    <a href="#" data-name="<?php echo e(app()->getLocale() =='ar' ? $service->service_type->name : $service->service_type->name_en); ?>"  data-price="<?php echo e(front_cat_price($service->service_type->id,$org_id_login)['catPrice']); ?>" data-id="<?php echo e($service->service_type->id); ?>"  data-description="<?php echo e(app()->getLocale() =='ar' ? $service->service_type->description : $service->service_type->description_en); ?>" class="add-to-cart btn btn-primary"><i class="fas fa-cart-plus"></i>add to cart </a>
                                   <?php endif; ?>
                                </div>
                                </div>
                               </div>
                               <?php endif; ?>
                                <?php break; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>
                                </div>
                              <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php if(count($service->service_types)): ?>


                            <div class="tab-pane " id="service<?php echo e($service->id); ?>" role="tabpanel" aria-labelledby="service<?php echo e($service->id); ?>">
                                <div class="items_product">
                                    <div class="row">
                                        <?php $__currentLoopData = $service->service_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service->service_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(front_cat_price( $service->service_type->id,$org_id_login)['original_price'] != front_cat_price($service->service_type->id,$org_id_login)['catPrice']): ?>
                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="item_pro " data-wow-delay="0.20s">
                                                  <a href="details/<?php echo e($service->service_type->id); ?>"> <img src="<?php echo e(asset(str_replace(' ', '%20', \App\Photo::find($service->service_type->photo_id)->file))); ?>"class="img_caty"></a>
                                                <h3><?php echo e(app()->getLocale() =='ar' ? $service->service_type->name : $service->service_type->name_en); ?></h3>
                                                <div class="price_add">
                                               <h6 class="final_price"><?php echo e(front_cat_price($service->service_type->id,$org_id_login)['original_price']); ?></h6>
                                               <h6><?php echo e(front_cat_price($service->service_type->id,$org_id_login)['catPrice']); ?></h6>

                                                      <?php if($show_cart): ?>
                                                   <a href="#" data-name="<?php echo e(app()->getLocale() =='ar' ? $service->service_type->name : $service->service_type->name_en); ?>" data-price="<?php echo e(front_cat_price($service->service_type->id,$org_id_login)['catPrice']); ?>" class="add-to-cart btn btn-primary"><i class="fas fa-cart-plus"></i>add to cart </a>
                                                   <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </div>
                                </div>
                            </div>


    												<?php else: ?>
                            <div class="tab-pane " id="service<?php echo e($service->id); ?>" role="tabpanel" aria-labelledby="service<?php echo e($service->id); ?>">
                              <?php echo e('NO DATA Available TO SHOW '); ?>

    												 </div>

    												<?php endif; ?>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                        </div>
                    </div>
                </div>

        </div>



        </div>
    </div> <!-- // latest product -->

    <!-- footer -->
		<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.index_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
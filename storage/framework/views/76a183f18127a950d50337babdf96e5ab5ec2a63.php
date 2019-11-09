<?php $__env->startSection('content'); ?>
	<section id="search_container">
		<div id="search">
			<div class="tab-content">
				<div class="tab-pane active show" id="tours">
					<h3><?php echo app('translator')->getFromJson('strings.search_now'); ?></h3>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label><?php echo app('translator')->getFromJson('strings.destination'); ?></label>
								<input type="text" class="form-control" id="firstname_booking" name="firstname_booking" list="distintations" placeholder="<?php echo app('translator')->getFromJson('strings.select_dist'); ?>">
								<datalist id="distintations">
									<?php $__currentLoopData = $destinatons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								    <option value="<?php echo e(app()->getLocale()== 'en' ?  $d->name_en : $d->name); ?>">
								    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</datalist>
							</div>
						</div>
					</div>
					<!-- End row -->
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label><i class="icon-calendar-7"></i> <?php echo app('translator')->getFromJson('strings.check_in'); ?></label>
								<input class="date-pick form-control" data-date-format="M d, D" type="text">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label><i class=" icon-clock"></i> <?php echo app('translator')->getFromJson('strings.check_out'); ?></label>
								<input class="date-pick form-control" data-date-format="M d, D" type="text">
							</div>
						</div>
						<div class="col-md-2 col-sm-3 col-6">
							<div class="form-group">
								<label><?php echo app('translator')->getFromJson('strings.adults_no'); ?></label>
								<input type="number" max="10" min="0" value="1" id="adults" class="form-control" name="adults">
							</div>
						</div>
						<div class="col-md-2 col-sm-3 col-6">
							<div class="form-group">
								<label><?php echo app('translator')->getFromJson('strings.no_children'); ?></label>
								<select id="children_count" class="form-control" name="children">
									<?php for($i=0;$i<11;$i++): ?>
									<option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
									<?php endfor; ?>
								</select>
							</div>
						</div>

					</div>
					<div class="row" id="age_cont">
						<div class="col-sm-12">
							<h4><?php echo app('translator')->getFromJson('strings.children_ages'); ?> :</h4>
						</div>
					</div>
					<!-- End row -->
					<hr>
					<button class="btn_1 green"><i class="icon-search"></i><?php echo app('translator')->getFromJson('strings.search_now'); ?></button>
				</div>
				<!-- End rab -->
			</div>
		</div>
	</section>
	<!-- End hero -->

	<main>
	<div class="container margin_60">
    
        <div class="main_title">
            <h2><?php echo app('translator')->getFromJson('strings.our_latest'); ?><span> <?php echo app('translator')->getFromJson('strings.destinatons'); ?> </span> <?php echo e(app()->getLocale()== 'ar' ?  $org_id->name : $org_id->name_en); ?></h2>
        </div>
        
        <div class="row">
        <?php
		$i=0;
		?>
		<?php $__currentLoopData = $destinatons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	 	<?php
	 	$i++;
	 	?>
	 	<?php if($i<=8): ?>
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
                <div class="tour_container">
					<div class="ribbon_3 popular"><span><?php echo app('translator')->getFromJson('strings.popular'); ?></span></div>
                    <div class="img_container">
                        <a  class="map-link" data-title="<?php echo e($destinaton->id); ?>" href="https://maps.google.com/?q=<?php echo e($destinaton->latitude); ?>,<?php echo e($destinaton->longitude); ?>" target="_blank"> <i class="fas fa-map-marker-alt"></i></a>
                        <a href="/details/<?php echo e($d->id); ?>">
                        <img src="<?php echo e(asset(str_replace(' ', '%20', \App\Photo::find($d->image)->file))); ?>" class="img-fluid" alt="Image" width="400px" style="height:300px">
                        <div class="short_info">
                            <span class="price"><sup>$</sup><?php echo e($d->price_start); ?>+</span>
                        </div>
                        </a>
                    </div>
                    <div class="tour_title">
                        <h3><strong><?php echo e(app()->getLocale() == 'ar' ?  $d->name :   $d->name_en); ?> </strong></h3>
                        <!--<div class="rating">
                            <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                        </div>-->
                    </div>
                </div><!-- End box tour -->
            </div><!-- End col -->
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div><!-- End row -->
		
    </div><!-- End container -->
    
    <div class="white_bg">
			<div class="container margin_60">
				<div class="main_title">
					<h2><?php echo app('translator')->getFromJson('strings.our'); ?> <span><?php echo app('translator')->getFromJson('strings.new_offers'); ?> </span><?php echo e(app()->getLocale() == 'ar' ? $org_id->name : $org_id->name_en); ?></h2>
				</div>
				<div class="row">
				<?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
		                <div class="tour_container">
		                    <div class="img_container">
		                        <a href="/details/<?php echo e($b->id); ?>">
		                        <img src="<?php echo e(asset(str_replace(' ', '%20', \App\Photo::find($b->image)->file))); ?>" class="img-fluid" alt="Image" width="400px" style="height:300px">
		                        <div class="short_info">
		                        	<?php if(count($days[$k])>0): ?>
		                        	<span class="price">
		                        		<small>
		                        			<?php echo app('translator')->getFromJson('strings.av_days'); ?>
		                        			<?php $__currentLoopData = $days[$k]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c=>$day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                        			<?php switch($day->day):
											    case (1): ?>
											        <?php echo app('translator')->getFromJson('strings.Saturday'); ?>
											        <?php break; ?>
											    <?php case (2): ?>
											        <?php echo app('translator')->getFromJson('strings.Sunday'); ?>
											        <?php break; ?>
											    <?php case (3): ?>
											        <?php echo app('translator')->getFromJson('strings.Monday'); ?>
											        <?php break; ?>
											    <?php case (4): ?>
											        <?php echo app('translator')->getFromJson('strings.Tuesday'); ?>
											        <?php break; ?>
											    <?php case (5): ?>
											        <?php echo app('translator')->getFromJson('strings.Wednesday'); ?>
											        <?php break; ?>
											    <?php case (6): ?>
											        <?php echo app('translator')->getFromJson('strings.Thursday'); ?>
											        <?php break; ?>
											    <?php case (7): ?>
											        <?php echo app('translator')->getFromJson('strings.Friday'); ?>
											        <?php break; ?>
											<?php endswitch; ?>
											<?php if($c!=count($days[$k])-1): ?>
											-
											<?php endif; ?>
		                        			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                        		</small>
		                        	</span>
		                        	<?php else: ?>
		                            <span class="price"><small><?php echo e($b->nights); ?> <?php echo app('translator')->getFromJson('strings.nights'); ?></small></span>
		                        	<?php endif; ?>
		                        </div>
		                        </a>
		                    </div>
		                    <div class="tour_title">
		                        <h3><strong><?php echo e(app()->getLocale() == 'ar' ?  $b->name :   $b->name_en); ?> </strong></h3>
		                        <button class="btn btn-primary" style="position: absolute;<?php echo e(app()->getLocale()=='ar'?'left':'right'); ?>: 5px;top: 5px;"><?php echo app('translator')->getFromJson('strings.see_more'); ?></button>
		                    </div>
		                </div><!-- End box tour -->
		            </div><!-- End col -->
		        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		    	</div>
		        <?php if(count($offers)==0): ?>
		        <h3><?php echo app('translator')->getFromJson('strings.noOffers2'); ?></h3>
		        <?php endif; ?>
			</div>
			<!-- End container -->
		</div>
		<!-- End white_bg -->

		<div class="container margin_60">

			<div class="main_title">
				<h2><?php echo app('translator')->getFromJson('strings.Latest_news'); ?></h2>
			</div>
			<div class="items_news">
              <?php if(count($news)>0): ?>
              <div class="row">
              		<?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $new): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="col-lg-4 col-md-6 text-center">
						<p>
							<a href="#"><img src="<?php echo e(asset(str_replace(' ', '%20', \App\Photo::find($new->image_id)->file))); ?>" alt="Pic" class="img-fluid" width="150px"></a>
						</p>
						<h4><?php echo e(app()->getLocale() == 'ar' ?  $new->news_title :   $new->news_title_en); ?></h4>
						<p>
							<?php echo e(app()->getLocale() == 'ar' ?  $new->news_desc : $new->news_desc_en); ?>

						</p>
					</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
               <div class="owl-carousel owl-theme" id="slider_News">
                   <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $new): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="item">
                    <button type="button" class="more" onclick="showNews()"> <i class="fas fa-plus"></i> more </button>
                    <img src=" <?php echo e(asset(str_replace(' ', '%20', \App\Photo::find($new->image_id)->file))); ?>">

                    <div class="text_news">
                        <h3> <?php echo e(app()->getLocale() == 'ar' ?  $new->news_title :   $new->news_title_en); ?>  </h3>
                        <p>	<?php echo e(app()->getLocale() == 'ar' ?  $new->news_desc : $new->news_desc_en); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <h3>  <?php echo app('translator')->getFromJson('strings.noOffers3'); ?> </h3>
                <?php endif; ?>

            </div>
			       
    	</div>
		<!-- End container -->
    </main>
	<!-- End main -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front_hotel_last.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
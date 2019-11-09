<?php $__env->startSection('content'); ?>
	<section id="search_container">
		<div id="search">
			<div class="tab-content">
				<div class="tab-pane active show" id="tours">
					<h3>Search Now</h3>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Destination</label>
								<input type="text" class="form-control" id="firstname_booking" name="firstname_booking" list="distintations" placeholder="Type/select your destination here">
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
								<label><i class="icon-calendar-7"></i> Check-in</label>
								<input class="date-pick form-control" data-date-format="M d, D" type="text">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label><i class=" icon-clock"></i> Check-out</label>
								<input class="date-pick form-control" data-date-format="M d, D" type="text">
							</div>
						</div>
						<div class="col-md-2 col-sm-3 col-6">
							<div class="form-group">
								<label>Adults</label>
								<input type="number" max="10" min="0" value="1" id="adults" class="form-control" name="adults">
							</div>
						</div>
						<div class="col-md-2 col-sm-3 col-6">
							<div class="form-group">
								<label>Children</label>
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
							<h4>Children Ages:</h4>
						</div>
					</div>
					<!-- End row -->
					<hr>
					<button class="btn_1 green"><i class="icon-search"></i>Search now</button>
				</div>
				<!-- End rab -->
				<div class="tab-pane" id="hotels">
					<h3>Search Hotels in Paris</h3>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label><i class="icon-calendar-7"></i> Check in</label>
								<input class="date-pick form-control" data-date-format="M d, D" type="text">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label><i class="icon-calendar-7"></i> Check out</label>
								<input class="date-pick form-control" data-date-format="M d, D" type="text">
							</div>
						</div>
						<div class="col-md-2 col-sm-3 col-6">
							<div class="form-group">
								<label>Adults</label>
								<div class="numbers-row">
									<input type="text" value="1" id="adults" class="qty2 form-control" name="adults_2">
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-3 col-6">
							<div class="form-group">
								<label>Children</label>
								<div class="numbers-row">
									<input type="text" value="0" id="children" class="qty2 form-control" name="children_2">
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-3 col-12">
							<div class="form-group">
								<label>Rooms</label>
								<div class="numbers-row">
									<input type="text" value="1" id="children" class="qty2 form-control" name="rooms">
								</div>
							</div>
						</div>
					</div>
					<!-- End row -->
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Hotel name</label>
								<input type="text" class="form-control" id="hotel_name" name="hotel_name" placeholder="Optionally type hotel name">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Preferred city area</label>
								<select class="form-control" name="area">
												<option value="Centre" selected>Centre</option>
												<option value="Gar du Nord Station">Gar du Nord Station</option>
												<option value="La Defance">La Defance</option>
											</select>
							</div>
						</div>
					</div>
					<!-- End row -->
					<hr>
					<button class="btn_1 green"><i class="icon-search"></i>Search now</button>
				</div>
				<div class="tab-pane" id="transfers">
					<h3>Search Transfers in Paris</h3>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="select-label">Pick up location</label>
								<select class="form-control">
												<option value="orly_airport">Orly airport</option>
												<option value="gar_du_nord">Gar du Nord Station</option>
												<option value="hotel_rivoli">Hotel Rivoli</option>
											</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="select-label">Drop off location</label>
								<select class="form-control">
												<option value="orly_airport">Orly airport</option>
												<option value="gar_du_nord">Gar du Nord Station</option>
												<option value="hotel_rivoli">Hotel Rivoli</option>
											</select>
							</div>
						</div>
					</div>
					<!-- End row -->
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label><i class="icon-calendar-7"></i> Date</label>
								<input class="date-pick form-control" data-date-format="M d, D" type="text">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label><i class=" icon-clock"></i> Time</label>
								<input class="time-pick form-control" value="12:00 AM" type="text">
							</div>
						</div>
						<div class="col-md-2 col-sm-3">
							<div class="form-group">
								<label>Adults</label>
								<div class="numbers-row">
									<input type="text" value="1" id="adults" class="qty2 form-control" name="quantity">
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-9">
							<div class="form-group">
								<div class="radio_fix">
									<label class="radio-inline" style="padding-left:0">
											  <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked> One Way
											</label>
								</div>
								<div class="radio_fix">
									<label class="radio-inline">
											  <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"> Return
											</label>
								</div>
							</div>
						</div>
					</div>
					<!-- End row -->
					<hr>
					<button class="btn_1 green"><i class="icon-search"></i>Search now</button>
				</div>
				<div class="tab-pane" id="restaurants">
					<h3>Search Restaurants in Paris</h3>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Search by name</label>
								<input type="text" class="form-control" id="restaurant_name" name="restaurant_name" placeholder="Type your search terms">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Food type</label>
								<select class="ddslick" name="category_2">
												<option value="0" data-imagesrc="<?php echo e(asset('hotel_assets/img/icons_search/all_restaurants.png')); ?>" selected>All restaurants</option>
												<option value="1" data-imagesrc="<?php echo e(asset('hotel_assets/img/icons_search/fast_food.png')); ?>">Fast food</option>
												<option value="2"  data-imagesrc="<?php echo e(asset('hotel_assets/img/icons_search/pizza_italian.png')); ?>">Pizza / Italian</option>
												<option value="3" data-imagesrc="<?php echo e(asset('hotel_assets/img/icons_search/international.png')); ?>">International</option>
												<option value="4" data-imagesrc="<?php echo e(asset('hotel_assets/img/icons_search/japanese.png')); ?>">Japanese</option>
												<option value="5" data-imagesrc="<?php echo e(asset('hotel_assets/img/icons_search/chinese.png')); ?>">Chinese</option>
												<option value="6" data-imagesrc="<?php echo e(asset('hotel_assets/img/icons_search/bar.png')); ?>">Coffee Bar</option>
											</select>
							</div>
						</div>
					</div>
					<!-- End row -->
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label><i class="icon-calendar-7"></i> Date</label>
								<input class="date-pick form-control" data-date-format="M d, D" type="text">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label><i class=" icon-clock"></i> Time</label>
								<input class="time-pick form-control" value="12:00 AM" type="text">
							</div>
						</div>
						<div class="col-md-2 col-sm-3 col-6">
							<div class="form-group">
								<label>Adults</label>
								<div class="numbers-row">
									<input type="text" value="1" id="adults" class="qty2 form-control" name="adults">
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-3 col-6">
							<div class="form-group">
								<label>Children</label>
								<div class="numbers-row">
									<input type="text" value="0" id="children" class="qty2 form-control" name="children">
								</div>
							</div>
						</div>

					</div>
					<!-- End row -->
					<hr>
					<button class="btn_1 green"><i class="icon-search"></i>Search now</button>
				</div>
			</div>
		</div>
	</section>
	<!-- End hero -->

	<main>
	<div class="container margin_60">
    
        <div class="main_title">
            <h2>Our latest<span> destinatons </span> of <?php echo e(app()->getLocale()== 'ar' ?  $org_id->name : $org_id->name_en); ?></h2>
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
					<div class="ribbon_3 popular"><span>Popular</span></div>
                    <div class="img_container">
                        <a  class="map-link" data-title="<?php echo e($destinaton->id); ?>" href="https://maps.google.com/?q=<?php echo e($destinaton->latitude); ?>,<?php echo e($destinaton->longitude); ?>" target="_blank"> <i class="fas fa-map-marker-alt"></i></a>
                        <a href="/details/<?php echo e($d->id); ?>">
                        <img src="<?php echo e(asset(str_replace(' ', '%20', \App\Photo::find($d->image)->file))); ?>" class="img-fluid" alt="Image" width="400px" style="height:300px">
                        <div class="short_info">
                            <i class="icon_set_1_icon-44"></i><span class="price"><sup>$</sup><?php echo e($d->price_start); ?>+</span>
                        </div>
                        </a>
                    </div>
                    <div class="tour_title">
                        <h3><strong><?php echo e(app()->getLocale() == 'ar' ?  $d->name :   $d->name_en); ?> </strong></h3>
                        <div class="rating">
                            <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                        </div><!-- end rating -->
                        <div class="wishlist">
                            <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                        </div><!-- End wish list-->
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
					<h2>our <span><?php echo app('translator')->getFromJson('strings.best_seller'); ?></span> of <?php echo e(app()->getLocale() == 'ar' ? $org_id->name : $org_id->name_en); ?></h2>
				</div>
				<?php $__currentLoopData = $best_selers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
		                <div class="tour_container">
		                    <div class="img_container">
		                        <a href="/details/<?php echo e($b->id); ?>">
		                        <img src="<?php echo e(asset(str_replace(' ', '%20', \App\Photo::find($b->photo_id)->file))); ?>" class="img-fluid" alt="Image" width="400px" style="height:300px">
		                        <div class="short_info">
		                            <i class="icon_set_1_icon-44"></i><span class="price"><sup>$</sup><?php echo e(cat_price($best_seler->id)['offer_price']); ?> <del><?php echo e(cat_price($best_seler->id)['original_price']); ?></del></span>
		                        </div>
		                        </a>
		                    </div>
		                    <div class="tour_title">
		                        <h3><strong><?php echo e(app()->getLocale() == 'ar' ?  $b->name :   $b->name_en); ?> </strong></h3>
		                        <div class="rating">
		                            <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
		                        </div><!-- end rating -->
		                        <div class="wishlist">
		                            <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
		                        </div><!-- End wish list-->
		                    </div>
		                </div><!-- End box tour -->
		            </div><!-- End col -->
		        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		        <?php if(count($best_selers)==0): ?>
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
              <?php if(count($news)): ?>
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
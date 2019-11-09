<?php $__env->startSection('content'); ?>

<style>
/* single product page */
.single_pro {
    padding: 60px 0 0 0;
}
.single_pro .img_pro {
    border-right: 1px solid #ededed;
    padding: 0 50px 0 0;
    text-align: center;
    background: #ffffff;
}
.single_pro .img_pro .main_image {
    width: 93%;
    height: 400px;
    object-fit: cover;
    cursor: pointer;
    transition:all 0.3s ease-in-out;
}
.single_pro .img_pro .main_image:hover,.single_pro .sub_images img:hover {
	opacity:0.9;
}
.single_pro .sub_images {}
.single_pro .sub_images img {
    width: 21%;
    border: 1px solid #e7e7e7;
    padding: 5px;
    height: 90px;
    margin: 10px 5px 0 5px;
    object-fit: cover;
    cursor: pointer;
    transition:all 0.3s ease-in-out;
}
.info_pro {
    margin: 0 0 0 30px;
}
.info_pro h3 {
    font-size: 28px;
    line-height: 1.4;
    font-weight: 400;
    text-transform: unset;
    color: #5b5b5b;
    margin: 0 0 35px 0;
}
.info_pro p {}
.price,.old_price {
    font-weight: 500;
    font-size: 24px;
    color: #383838;
    letter-spacing: 2px;
    position: relative;
    display: inline-block;
}
.price span,.old_price span {
	position: absolute;
	top: -18px;
	font-size: 13px;
	color: #cd2122;
}
.old_price span {
	color: #9d9d9d;
	font-weight: 500;
}
.old_price {
    margin: 0 35px 0 0;
    text-decoration: line-through;
    color: #515151;
    font-weight: 400;
}
.desk_pro {
    margin: 15px 0 35px 0;
    font-size: 16px;
    width: 85%;
}
.info_pro form input {
    text-align: center;
    padding: 0 0;
    display: inline-block;
    height: 33px;
    width: 50px;
    border-radius: 3px;
    border: 1px solid #D9D9D9;
}
.info_pro form button {
    background: #CD2122;
    font-size: 13px !important;
    padding: 6px 20px;
    color: #fff;
    font-weight: 500;
    text-transform: uppercase;
    position: relative;
    top: -2px;
    left: 10px;
    transition: all 0.3s ease-in-out;
}
.info_pro form button:hover {
	background:#b01d1e;
}
.info_pro .pro_add p {
	color: #535353;
	display: block;
	font-size: 16px;
	margin: 0;
}
.info_pro .pro_add ul {
	list-style: none;
	display: inline-block;
}
.info_pro .pro_add ul p {
	display:inline-block;
}
.info_pro .pro_add ul li {
	display: inline-block;
}
.info_pro .pro_add ul li:after {
	content:",";
}
.info_pro .pro_add ul li:last-child:after {
	display:none;
}
.info_pro .pro_add ul li a {
	color: #000;
	font-weight: 400;
	text-decoration: none;
	transition:all 0.3s ease-in-out;
	text-transform: uppercase;
}
.info_pro .pro_add ul li a:hover {
	color:#cd2122;
}
.info_pro .pro_add {
	border-left: 3px solid rgba(0,0,0,0.1);
	padding: 5px 0 5px 20px;
	position: relative;
}
.info_pro .pro_add form {
	margin: 0 0 30px 0;
}
.info_pro .pro_add:before {
	content: '';
	width: 20px;
	height: 1px;
	background: #ccc;
	display: inline-block;
	vertical-align: middle;
	position: absolute;
	left: 0;
	top: 55px;
}
    </style>

<body>

     <div id="page_header" class="page-subheader">

        <!-- Sub-Header content wrapper -->
        <div class="ph-content-wrap d-flex">
            <div class="container align-self-center">
                <div class="row">

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="subheader-titles">
                            <h2 class="subheader-maintitle">

                            </h2>

                            <h4 class="subheader-subtitle">

                            </h4>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <ul class="breadcrumbs fixclear">
                            <li><a href="<?php echo e(url('/')); ?>"></a></li>
                            <li> </li>
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
    <!-- single product content -->
    <div class="single_pro">
        <div class="container">

            <div class="row">
                <div class="col-md-5 col-xs-12">
                    <div class="img_pro">
                        <img class="main_image" src="<?php echo e(asset(str_replace(' ', '%20', \App\Photo::find($category_price->photo_id)->file))); ?>" alt="product image">
                    </div>
                </div>
                <div class="col-md-7 col-xs-12">
                    <div class="info_pro">
                        <h3><?php echo e(app()->getLocale() =='ar' ? $category_price->name : $category_price->name_en); ?></h3>
                    <?php if(front_cat_price($category_price->id,$org_id_login)['catPrice'] == front_cat_price($category_price->id,$org_id_login)['original_price'] ): ?>
                      <p class="price"><?php echo e(front_cat_price($category_price->id,$org_id_login)['original_price']); ?></p>
                       <?php if($show_cart  && (front_cat_price($category_price->id,$org_id_login)['catPrice']) ): ?>

                    <a href="#" data-name="<?php echo e(app()->getLocale() =='ar' ? $category_price->name : $category_price->name_en); ?>"  data-price="<?php echo e(front_cat_price($category_price->id,$org_id_login)['catPrice']); ?>" data-id="<?php echo e($category_price->id); ?>"  data-description="<?php echo e(app()->getLocale() =='ar' ?$category_price->description : $category_price>description_en); ?>" class="add-to-cart btn btn-primary"><i class="fas fa-cart-plus"></i>add to cart </a>

                      <?php endif; ?>
                       <?php else: ?>
                        <p class="old_price"><?php echo e(front_cat_price($category_price->id,$org_id_login)['original_price']); ?></p>
                        </br>
                        <p class="price"><?php echo e(front_cat_price($category_price->id,$org_id_login)['catPrice']); ?></p>
                          <?php if($show_cart): ?>
                        <a href="#" data-name="<?php echo e(app()->getLocale() =='ar' ? $category_price->name :$category_price->name_en); ?>" data-price="<?php echo e(front_cat_price($category_price->id,$org_id_login)['catPrice']); ?>"  data-id="<?php echo e($category_price->id); ?>" data-description="<?php echo e(app()->getLocale() =='ar' ? $category_price->description :$category_price->description_en); ?>"  class="add-to-cart btn btn-primary" ><i class="fas fa-cart-plus"></i>add to cart </a>
                         <?php endif; ?>
                        <?php endif; ?>
                        <p class="desk_pro"><?php echo e(app()->getLocale() =='ar' ?  strip_tags(htmlspecialchars_decode( $category_price->description)) : strip_tags(htmlspecialchars_decode($category_price->description_en))); ?></p>



                                <!-- <button type="submit" class="fas fa-cart-plus">add to cart</button> -->




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- js files -->
    <script src="https://code.jquery.com/jquery-3.4.0.min.js"integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="crossorigin="anonymous"></script>



	<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.index_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
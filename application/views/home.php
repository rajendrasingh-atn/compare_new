<?php
  $currency =  get_admin_setting('currency_code');
  $currency_code =  get_currency_symbol($currency);
?>
<!-- <h6 class="d-none"><?php echo lang('Compare'); ?></h6> -->
<!-- <div>
   <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel" data-interval="3000">
      <div class="carousel-inner">
         <?php $home_first_slide = get_admin_setting('home_first_slide') ? base_url('/assets/images/logo/').get_admin_setting('home_first_slide') : '//pbs.twimg.com/media/EGHYvtkUcAAuc8T?format=jpg&name=large' ?>
         <div class="carousel-item active">
            <img src="<?php echo $home_first_slide; ?>" alt='<?php echo $this->settings->site_name; ?>' class="d-block w-100" > 
         </div>
         <?php 
            $home_slide_second = get_admin_setting('home_slide_second');
            if($home_slide_second)
            { ?>
         <div class="carousel-item">
            <img src="<?php echo base_url('/assets/images/logo/').get_admin_setting('home_slide_second'); ?>" alt='<?php echo $this->settings->site_name; ?>' class="d-block w-100" >
         </div>
         <?php
            } ?>
         <?php 
            $home_third_slide = get_admin_setting('home_third_slide');
            if($home_third_slide) 
            { ?>
         <div class="carousel-item">
            <img src="<?php echo base_url('/assets/images/logo/').get_admin_setting('home_third_slide'); ?>" alt='<?php echo $this->settings->site_name; ?>' class="d-block w-100">
         </div>
         <?php
            } ?>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
      </a>
   </div>
</div> -->
<div class="container-fluid  slider-section">
    <div class="container">
      <div class="row">
        <div class="col-md-7 pt-2 pr-0 slick-parent">
          <div class="multiple-items">
              <?php $home_first_slide = get_admin_setting('home_first_slide') ? base_url('/assets/images/logo/').get_admin_setting('home_first_slide') : '//pbs.twimg.com/media/EGHYvtkUcAAuc8T?format=jpg&name=large' ?>
              <img src="<?php echo $home_first_slide; ?>" alt="<?php echo $this->settings->site_name; ?>" />
              <?php 
                $home_slide_second = get_admin_setting('home_slide_second');
                if($home_slide_second) { 
              ?>
              <img src="<?php echo base_url('/assets/images/logo/').get_admin_setting('home_slide_second'); ?>" alt="<?php echo $this->settings->site_name; ?>" />
            <?php } 
              $home_third_slide = get_admin_setting('home_third_slide');
              if($home_third_slide) { 
            ?>
              <img src="<?php echo base_url('/assets/images/logo/').get_admin_setting('home_third_slide'); ?>" alt="<?php echo $this->settings->site_name; ?>" />
            <?php  } ?>  
          </div>    
        </div>
        <div class="col-md-2 pt-2 pr-0 top-sale"> 
          <div class="mb-2 border mega-sale"><img src="../template/images/balar.png"></div>
          <div class="mb-2 border mega-sale"><img src="../template/images/megasale.jpg"></div>
          <div class="mb-2 border mega-sale"><img src="../template/images/gogals.jpg"></div>    
        </div>
        <div class="col-md-3 pt-2">
          <div class="alarm-product border">
            <div class="gunun-main">
              <div class="gunun">GÜNÜN FIRSATI</div>
              <div class="migros">MIGROS Sanalmarket</div>
            </div>
            <div class="single-item">
              <div class="slide">
                <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                <div class="slide-text">
                  <label>Product Name</label>
                  <h5>2229 TL</h5>
                  <span class="price-percentage mt-2">% 40</span>
                  <span class="actual-price mt-2">565,00 TL</span>
                </div>  
              </div>
              <div class="slide">
                <img src="../template/images/balar.png">  
                <div class="slide-text">
                  <label>Product Name</label>
                  <h5>2229</h5>
                  <span class="price-percentage mt-2">% 40</span>
                  <span class="actual-price mt-2">565,00 TL</span>
                </div>  
              </div>  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<section>
  <div class="container">
    <div class="market-main">
      <div class="market-inner">
        <?php foreach($markets as $market_key => $market_value) { ?>
            <div class="brand-name">
              <?php $market_image = (isset($market_value->market_logo) && !empty($market_value->market_logo) ? base_url('/assets/images/market_image/'.$market_value->market_logo) : base_url('/assets/images/market_image/default_market.jpg')); ?>
              <img src="<?php echo $market_image;?>">
            </div>
        <?php } ?>
      </div>
    </div>
  </div>
</section>
<!-- <div class="search-sec ">
   <div class="container">
      <form  method="post" >
         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
         <div class="row">
            <div class="col-lg-12">
               <div class="row">
                  <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                     <input type="text" name="product_or_brand" class="form-control search-slt" placeholder="<?php echo lang('Search Product Or Brand') ?>">
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                     <select class="form-control search-slt select2" name='category_name' id="category_name">
                        <option value="all"><?php echo lang('All') ?></option>
                        <?php foreach ($category_data as $category_array) {
                           echo "<option value='".$category_array->category_slug."'>".$category_array->category_title."</option>";
                           } ?>
                     </select>
                     <?php echo form_error('category_name', '<div class="small text-danger px-2">', '</div>'); ?>
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                     <select class="form-control search-slt" name="price_range" id="price_range">
                        <option value=""><?php echo lang('Select Price Range') ?></option>
                        <option value="5000-10000">Rs. 5,000 - Rs. 10,000 </option>
                        <option value="10000-15000">Rs. 10,000 - Rs. 15,000 </option>
                        <option value="15000-20000">Rs. 15,000 - Rs.20,000</option>
                        <option value="20000-30000">Rs. 20,000 - Rs. 30,000</option>
                        <option value="30000-40000">Rs. 30,000 - Rs. 40,000</option>
                        <option value="40000-50000000">Rs. 40,000 and above</option>
                     </select>
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                     <button type="submit" name='search' value="search" class="btn btn-danger wrn-btn"><?php echo lang('search products') ?></button>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div> -->

<!-- <?php
  if($coupons)
  {
    ?>
    <div class="latest_coupons container px-4 product_compare">
      <h3 class="h3"> <span class="text-danger"><?php echo lang('New In');?> </span> <?php echo 'coupons'; ?> </h3>
      <div class="row carousel-coupons">
        <?php
        foreach ($coupons as  $coupon_array) 
        {
          $image = $coupon_array->image ? $coupon_array->image : 'default.png';
          $dir =  base_url('assets/images/coupon/');
          $coupon_img = $dir.$image;
          ?>
            <div class="col-md-3 col-sm-6 mb-5 slide">
               <div class="coupon_detail w-100 text-center">
                  <a href="<?php echo base_url('coupons/list'); ?>" class="no_underline" >
                     <img class="pic-2 p-2" src="<?php echo $coupon_img;?>" alt="<?php echo $this->settings->site_name; ?>">
                  
                     <div class="price small"> <?php //echo $coupon_array->coupon_code; ?> </div>
                     <div class="price small"> <?php //echo $coupon_array->valid_till; ?> </div>
                     <?php
                     $coupon_title = strip_tags($coupon_array->title);
                     $coupon_title = strlen($coupon_title) > 30 ? substr($coupon_title,0,27)."..." : $coupon_title;

                     $coupon_description = strip_tags($coupon_array->description);
                     $coupon_description = strlen($coupon_description) > 40 ? strip_tags(substr($coupon_description,0, 37))."..." : $coupon_description;
                     ?>
                    <h4 class="title"><?php echo ucfirst($coupon_title); ?></h4>
                    <p class="m-0"><?php echo $coupon_description; ?></p>

                  </a>                  
                </div>
                <a href="<?php echo base_url('coupons/list'); ?>" class=" btn btn-primary btn-block no_underline " > See All Offers </a>
            </div>
          <?php
        }
        ?>
      </div>

    </div>
    <?php
  }
 ?> -->

<section class="mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="top-products top-slider">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Top Products</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Best Seller</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Favourite Product</a>
              </li>
            </ul>
          </div>
          <div class="see-all"><a href="#">See all</a></div>
          <div class="clearfix"></div>
          <div class="tab-content" id="pills-tabContent">
            
              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="tab-slide">
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="tab-slide">
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <div class="tab-slide">
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="slide-tab">
                      <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                      <div class="product-bell border top-alarm mb-1"><i class="far fa-bell"></i></div>
                      <div class="product-bell border top-alarm"><i class="far fa-heart" aria-hidden="true"></i></div>
                      <div class="clearfix"></div>
                      <div class="top-text">
                        <h4>Ray Ban RB3441 50 Unisex product listing</h4>
                        <h6>En iyi fiyat</h6>
                        <div class="product-price">275,00 TL</div>
                        <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="mt-5" >
    <div class="container">
      <div class="row">
        <div class="col-md-7">
          <div class="row">
            <div class="col-md-6 ">
              <div class="section4-main border-right">
                <div class="section4-left">
                  <img src="../template/images/headphone.png">
                </div>
                <div class="section4-right">
                  <span class="section4-price">49,89 TL</span>
                  <h6>Strong Low Bass Streao Headphones</h6>
                  <div class="setction4-star"><img src="../template/images/empty-star.png"></div>
                  <div class="setction4-star"><img src="../template/images/empty-star.png"></div>
                  <div class="setction4-star"><img src="../template/images/empty-star.png"></div>
                  <div class="setction4-star"><img src="../template/images/empty-star.png"></div>
                  <div class="setction4-star"><img src="../template/images/empty-star.png"></div>
                  <div class="star-count">(0)</div>
                </div>
              </div>
              <div class="section4-main border-right">
                <div class="section4-left">
                  <img src="../template/images/sterio.png">
                </div>
                <div class="section4-right">
                  <span class="section4-price">49,89 TL</span>
                  <h6>Strong Low Bass Streao Headphones</h6>
                  <div class="setction4-star"><img src="../template/images/color-star.png"></div>
                  <div class="setction4-star"><img src="../template/images/color-star.png"></div>
                  <div class="setction4-star"><img src="../template/images/color-star.png"></div>
                  <div class="setction4-star"><img src="../template/images/color-star.png"></div>
                  <div class="setction4-star"><img src="../template/images/color-star.png"></div>
                  
                  <div class="star-count">(0)</div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="section4-main">
                <div class="section4-left">
                  <img src="../template/images/bass.png">
                </div>
                <div class="section4-right">
                  <span class="section4-price">49,89 TL</span>
                  <h6>Strong Low Bass Streao Headphones</h6>
                  <div class="setction4-star"><img src="../template/images/empty-star.png"></div>
                  <div class="setction4-star"><img src="../template/images/empty-star.png"></div>
                  <div class="setction4-star"><img src="../template/images/empty-star.png"></div>
                  <div class="setction4-star"><img src="../template/images/empty-star.png"></div>
                  <div class="setction4-star"><img src="../template/images/empty-star.png"></div>
                  <div class="star-count">(0)</div>
                </div>
              </div>
              <div class="section4-main">
                <div class="section4-left">
                  <img src="../template/images/watch.png">
                </div>
                <div class="section4-right">
                  <span class="section4-price">49,89 TL</span>
                  <h6>Strong Low Bass Streao Headphones</h6>
                  <div class="setction4-star"><img src="../template/images/color-star.png"></div>
                  <div class="setction4-star"><img src="../template/images/color-star.png"></div>
                  <div class="setction4-star"><img src="../template/images/color-star.png"></div>
                  <div class="setction4-star"><img src="../template/images/color-star.png"></div>
                  <div class="setction4-star"><img src="../template/images/color-star.png"></div>
                  <div class="star-count">(0)</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5 pr-0">
          <div class="advertisement"><img src="../template/images/advertise.jpg"></div>
        </div>
      </div>
      <?php foreach($markets as $market_key => $market_value) { 
        $market_image = (isset($market_value->market_logo) && !empty($market_value->market_logo) ? base_url('/assets/images/market_image/'.$market_value->market_logo) : base_url('/assets/images/market_image/default_market.jpg'));

        ?>
        <div class="section4-brand"><img src="<?php echo $market_image;?>" /></div>
      <?php } ?>
    </div>
  </section>
  <section class="mt-3">
    <div class="container powerful-audio"> 
      <div class="row">
        <div class="col-md-8 pl-4 pr-0">
          <h1 class="powerful-heading">Powerful Audio & Visual entertainment</h1>
          <div class="power-slide">
            <div class="left-power">
              <div class="powerful-left pb-3">
                <div class="powerful-inner"><img src="../template/images/audio1.png"></div>
                <div class="powerful-text">
                  <h5>Emporio Armani 5 58 Erkek Gunes</h5>
                  <h6>En iyi fiyat</h6>
                  <span class="product-price">199.90 TL</span>
                  <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                </div>
              </div>
            </div>
            <div class="left-power">
              <div class="powerful-left pb-3">
                <div class="powerful-inner"><img src="../template/images/audio1.png"></div>
                <div class="powerful-text">
                  <h5>Emporio Armani 5 58 Erkek Gunes</h5>
                  <h6>En iyi fiyat</h6>
                  <span class="product-price">199.90 TL</span>
                  <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                </div>
              </div>
            </div>
            <div class="left-power">
              <div class="powerful-left pb-3">
                <div class="powerful-inner"><img src="../template/images/audio1.png"></div>
                <div class="powerful-text">
                  <h5>Emporio Armani 5 58 Erkek Gunes</h5>
                  <h6>En iyi fiyat</h6>
                  <span class="product-price">199.90 TL</span>
                  <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                </div>
              </div>
            </div>
            <div class="left-power">
              <div class="powerful-left pb-3">
                <div class="powerful-inner"><img src="../template/images/audio1.png"></div>
                <div class="powerful-text">
                  <h5>Emporio Armani 5 58 Erkek Gunes</h5>
                  <h6>En iyi fiyat</h6>
                  <span class="product-price">199.90 TL</span>
                  <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                </div>
              </div>
            </div>
            <div class="left-power">
              <div class="powerful-left pb-3">
                <div class="powerful-inner"><img src="../template/images/audio1.png"></div>
                <div class="powerful-text">
                  <h5>Emporio Armani 5 58 Erkek Gunes</h5>
                  <h6>En iyi fiyat</h6>
                  <span class="product-price">199.90 TL</span>
                  <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                </div>
              </div>
            </div>
            <div class="left-power">
              <div class="powerful-left pb-3">
                <div class="powerful-inner"><img src="../template/images/audio1.png"></div>
                <div class="powerful-text">
                  <h5>Emporio Armani 5 58 Erkek Gunes</h5>
                  <h6>En iyi fiyat</h6>
                  <span class="product-price">199.90 TL</span>
                  <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                </div>
              </div>
            </div>
            <div class="left-power">
              <div class="powerful-left pb-3">
                <div class="powerful-inner"><img src="../template/images/audio1.png"></div>
                <div class="powerful-text">
                  <h5>Emporio Armani 5 58 Erkek Gunes</h5>
                  <h6>En iyi fiyat</h6>
                  <span class="product-price">199.90 TL</span>
                  <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                </div>
              </div>
            </div>
            <div class="left-power">
              <div class="powerful-left pb-3">
                <div class="powerful-inner"><img src="../template/images/audio1.png"></div>
                <div class="powerful-text">
                  <h5>Emporio Armani 5 58 Erkek Gunes</h5>
                  <h6>En iyi fiyat</h6>
                  <span class="product-price">199.90 TL</span>
                  <span class="product-store">From 1590854 stores <a href="#" class="read-more"><i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                </div>
              </div>
            </div>
          </div>    
        </div>
        <div class="col-md-4 pl-0 pr-0">
          <div class="product-right"><img src="../template/images/product-side.jpg"></div>
        </div>
      </div>
    </div>  
  </section>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-12 mb-3">
          <div class="top-products mb-3">
            <ul class="nav nav-pills mt-2" id="pills-tab" role="tablist">
              <?php
                 $product_img_dir = base_url('/assets/images/product_image/');
                 $i = 1;
                 if($home_category_prodducts) 
                 {
                     foreach ($home_category_prodducts as $category_name => $category_products_array) 
                     { 
                      //echo '<pre>';print_r($home_category_prodducts);exit;
                      if($i == 1)
                      {
                        $active = 'active';
                      }
                      else
                      {
                        $active = '';
                      }
                      $i++;
                      if($category_products_array)
                      {            
              ?>
                <li class="nav-item">
                  <a class="nav-link custom-popular <?php echo $active;?>" id="popular-<?php echo $category_name;?>-tab" data-toggle="pill" href="#popular-<?php echo $category_name;?>" role="tab" aria-controls="popular-<?php echo $category_name;?>" aria-selected="true">Popular <?php echo $category_name;?></a>
                </li>
              <?php  } } } ?>
            </ul>
          </div>
          <div class="tab-content" id="pills-tabContent">
            <?php
                 $product_img_dir = base_url('/assets/images/product_image/');
                 $i = 1;
                 if($home_category_prodducts) 
                 {
                     foreach ($home_category_prodducts as $category_name => $category_products_array) 
                     { 
                      //echo '<pre>';print_r($home_category_prodducts);exit;
                      if($i == 1)
                      {
                        $active = 'active show';
                      }
                      else
                      {
                        $active = '';
                      }
                      $i++;
                      if($category_products_array)
                      {            
            ?>
              <div class="tab-pane fade <?php echo $active;?>" id="popular-<?php echo $category_name;?>" role="tabpanel" aria-labelledby="popular-<?php echo $category_name;?>-tab">
                <div class="row">
                  <?php
                   foreach ($category_products_array as $category_products) 
                   {
                      $pro_sale_price = $category_products->sale_price ? $category_products->sale_price : '00.0';
                       $affiliate_marketing_url = $category_products->affiliate_marketing_url ? $category_products->affiliate_marketing_url : '#';
                       $product_images = json_decode($category_products->product_image,true);
                       $product_image_one = $product_img_dir.'default.png';
                       //print_r($product_images);exit;

                       if(isset($product_images[0]) && $product_images[0])
                       {
                           // $product_image_one = $product_img_dir.$product_images[0];
                           $product_image_one = get_s3_url('quickcompare/products/'.$product_images[0]);
                       }
                       
                       $product_url = base_url('product/').$category_products->category_slug.'/'.$category_products->product_slug;

                       $fav_icon =  $category_products->is_fav ? 'text-danger' : 'text-secondary';
                  ?>            
                    <!-- <div class="col-md-2 col-half-offset2"> -->
                      <div class="box">
                        <div class="popoular-tab"><a href="<?php echo $product_url;?>">
                          <img src="<?php echo $product_image_one?>" alt="" class="category-image" />
                          <div class="product-bell border top-alarm mb-1"><i class="far fa-bell" aria-hidden="true"></i></div>
                          <div class="product-bell border top-alarm">
                            <a href="javascript:void(0)" class="add_fav_product_btn" data-product_id = "<?php echo $category_products->product_id; ?>"> 
                              <i class="fav_icon far fa-heart  <?php echo $fav_icon; ?>" data-icon='fav'></i> 
                            </a>
                          </div>
                          <div class="clearfix"></div>
                          <div class="poopular-text">
                            <?php
                             $product_title = urldecode($category_products->product_title);
                             $product_title = strlen($product_title) > 50 ? substr($product_title,0,50)."..." : $product_title;
                            ?>
                            <h4><?php echo $product_title;?></h4>
                            <span class="product-price"><?php echo $pro_sale_price.' '.$currency_code?></span><div class="clearfix"></div>
                            <span class="product-store">From <a href="<?php echo $affiliate_marketing_url;?>"><?php echo $affiliate_marketing_url;?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                          </div>
                        </a></div>
                      </div>
                    <!-- </div> -->
                  <?php } ?>
                </div>    
              </div>
            <?php } } } ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row border border-dark">
        <div class="daha">
          <div class="editor-category">Editorun secimi</div>
          <h3 class="category-heading">Popular Category</h3>
          <div class="category-arrow"></div>
          <div class="category-arrow"></div>
          <div class="category-last">DAHA FAZLA GOSTER</div>
        </div>
        <div class="daha-right">
          <div class="slide-category">
            <div class="category-slider">
              <img src="../template/images/dron.png" alt="" class="category-image" />
              <div class="top-text">
                <h4 class="text-center category-text">Droner</h4>
              </div>
            </div>
            <div class="category-slider bg-slider">
              <img src="../template/images/watch.png" alt="" class="category-image" />
              <div class="top-text">
                <h4 class="text-center category-text">Watch</h4>
              </div>
            </div>
            <div class="category-slider">
              <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
              <div class="top-text">
                <h4 class="text-center category-text">Ray Ban</h4>
              </div>
            </div>
            <div class="category-slider bg-slider">
              <img src="../template/images/philips.png" alt="" class="category-image" />
              <div class="top-text">
                <h4 class="text-center category-text">Philips</h4>
              </div>
            </div>
            <div class="category-slider">
              <img src="../template/images/philips.png" alt="" class="category-image" />
              <div class="top-text">
                <h4 class="text-center category-text">Philips</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row mt-3">
        <div class="col-md-4 pl-0">
          <div class="category-film"><img src="../template/images/film.jpg"></div>
          <div class="film-text">Evde film ve dizi keyfi</div>
          <div class="text-desc">kindi sinema salaounumuy kurun</div>
        </div>
        <div class="col-md-4 pl-0">
          <div class="category-film"><img src="../template/images/table.jpg"></div>
          <div class="film-text">Evde film ve dizi keyfi</div>
          <div class="text-desc">kindi sinema salaounumuy kurun</div>
        </div>
        <div class="col-md-4 pl-0 pr-0">
          <div class="category-film"><img src="../template/images/ac.jpg"></div>
          <div class="film-text">Evde film ve dizi keyfi</div>
          <div class="text-desc">kindi sinema salaounumuy kurun</div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-6 pl-0 mt-4">
          <div class="yeni pb-4">
            <div class="yeni-left">Yeni indirime girenler</div>
            <div class="yeni-right"><a href="#">See All</a></div>
            <div class="clearfix"></div>
            <div class="yeni-description border-top">
              <span class="yeni-heading-border"></span>
              <div class="yeni-image"><img src="../template/images/watch.png"></div>
              <div class="yeni-title">
                <h6>Ray Ban RB3447 001 50 Unisex GUnes Gosiaos</h6>
                <span>From 159895 Stores</span>
              </div>
              <div class="yeni-price">
                <div class="yeni-market">indirim oran</div>
                <span class="price-percentage">% 10</span><br/>
                <span class="currency">275,00 TL</span>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="yeni-description">
              <div class="yeni-image"><img src="../template/images/jcb.png"></div>
              <div class="yeni-title">
                <h6>Ray Ban RB3447 001 50 Unisex GUnes Gosiaos</h6>
                <span>From 159895 Stores</span>
              </div>
              <div class="yeni-price">
                <div class="yeni-market">indirim oran</div>
                <span class="price-percentage">% 10</span><br/>
                <span class="currency">275,00 TL</span>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="yeni-description">
              <div class="yeni-image"><img src="../template/images/shoes.png"></div>
              <div class="yeni-title">
                <h6>Ray Ban RB3447 001 50 Unisex GUnes Gosiaos</h6>
                <span>From 159895 Stores</span>
              </div>
              <div class="yeni-price">
                <div class="yeni-market">indirim oran</div>
                <span class="price-percentage">% 10</span><br/>
                <span class="currency">275,00 TL</span>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="yeni-description">
              <div class="yeni-image"><img src="../template/images/balar.png"></div>
              <div class="yeni-title">
                <h6>Ray Ban RB3447 001 50 Unisex GUnes Gosiaos</h6>
                <span>From 159895 Stores</span>
              </div>
              <div class="yeni-price">
                <div class="yeni-market">indirim oran</div>
                <span class="price-percentage">% 10</span><br/>
                <span class="currency ">275,00 TL</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 p-0 mt-4">
          <div class="yeni pb-4">
            <div class="yeni-left">Yeni indirime girenler</div>
            <div class="yeni-right"><a href="#">See All</a></div>
            <div class="clearfix"></div>
            <div class="yeni-description border-top">
              <span class="yeni-heading-border"></span>
              <div class="yeni-image"><img src="../template/images/watch.png"></div>
              <div class="yeni-title">
                <h6>Ray Ban RB3447 001 50 Unisex GUnes Gosiaos</h6>
                <span>From 159895 Stores</span>
              </div>
              <div class="yeni-price">
                <div class="yeni-market">indirim oran</div>
                <span class="price-percentage">% 10</span><br/>
                <span class="currency">275,00 TL</span>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="yeni-description">
              <div class="yeni-image"><img src="../template/images/jcb.png"></div>
              <div class="yeni-title">
                <h6>Ray Ban RB3447 001 50 Unisex GUnes Gosiaos</h6>
                <span>From 159895 Stores</span>
              </div>
              <div class="yeni-price">
                <div class="yeni-market">indirim oran</div>
                <span class="price-percentage">% 10</span><br/>
                <span class="currency">275,00 TL</span>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="yeni-description">
              <div class="yeni-image"><img src="../template/images/shoes.png"></div>
              <div class="yeni-title">
                <h6>Ray Ban RB3447 001 50 Unisex GUnes Gosiaos</h6>
                <span>From 159895 Stores</span>
              </div>
              <div class="yeni-price">
                <div class="yeni-market">indirim oran</div>
                <span class="price-percentage">% 10</span><br/>
                <span class="currency">275,00 TL</span>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="yeni-description">
              <div class="yeni-image"><img src="../template/images/balar.png"></div>
              <div class="yeni-title">
                <h6>Ray Ban RB3447 001 50 Unisex GUnes Gosiaos</h6>
                <span>From 159895 Stores</span>
              </div>
              <div class="yeni-price">
                <div class="yeni-market">indirim oran</div>
                <span class="price-percentage">% 10</span><br/>
                <span class="currency ">275,00 TL</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-12 p-0">
          <div class="extremely-advertise"><img src="../template/images/extremely.jpg"></div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row pt-3 pb-3">
        <div class="col-md-4 pl-0 pr-0 border-bottom">
          <div class="hotseller"><h1>Hot Best Seller</h1></div>
        </div>
        <div class="col-md-8 pl-0 pr-0 border-bottom">
          <div class="top-products top-hot-seller">
            <ul class="nav nav-pills pills-border" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link custom-popular active" id="top20-tab" data-toggle="pill" href="#top20" role="tab" aria-controls="top-20" aria-selected="true">Top 20</a>
              </li>
              <li class="nav-item">
                <a class="nav-link custom-popular" id="audio-video-tab" data-toggle="pill" href="#audiovideo" role="tab" aria-controls="audio-video" aria-selected="false">Audio & Video</a>
              </li>
              <li class="nav-item">
                <a class="nav-link custom-popular" id="laptop-tab" data-toggle="pill" href="#laptop-com" role="tab" aria-controls="laptop-computer" aria-selected="false">Laptop & Computer</a>
              </li>
              <li class="nav-item">
                <a class="nav-link custom-popular" id="video-tab" data-toggle="pill" href="#video-camera" role="tab" aria-controls="video-cam" aria-selected="false">Video Cameras</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-12">
          <div class="tab-content mt-5" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
              <div class="best-seller">
                <div class="seller-tab">
                  <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                  <div class="seller-text">
                    <span class="seller-price">275,00 TL <label class="price-through">99.99 TL</label></span><div class="clearfix"></div>
                    <span class="seller-title">Strong Low Bass Strereo</span>
                  </div>
                </div>
                <div class="seller-tab">
                  <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                  <div class="seller-text">
                    <span class="seller-price">275,00 TL <label class="price-through">99.99 TL</label></span><div class="clearfix"></div>
                    <span class="seller-title">Strong Low Bass Strereo</span>
                  </div>
                </div>
                <div class="seller-tab">
                  <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                  <div class="seller-text">
                    <span class="seller-price">275,00 TL <label class="price-through">99.99 TL</label></span><div class="clearfix"></div>
                    <span class="seller-title">Strong Low Bass Strereo</span>
                  </div>
                </div>
                <div class="seller-tab">
                  <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                  <div class="seller-text">
                    <span class="seller-price">275,00 TL <label class="price-through">99.99 TL</label></span><div class="clearfix"></div>
                    <span class="seller-title">Strong Low Bass Strereo</span>
                  </div>
                </div>
                <div class="seller-tab">
                  <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                  <div class="seller-text">
                    <span class="seller-price">275,00 TL <label class="price-through">99.99 TL</label></span><div class="clearfix"></div>
                    <span class="seller-title">Strong Low Bass Strereo</span>
                  </div>
                </div>
                <div class="seller-tab">
                  <img src="http://farm3.staticflickr.com/2854/10380193164_9b65e4c5ed_n.jpg" alt="" class="category-image" />
                  <div class="seller-text">
                    <span class="seller-price">275,00 TL <label class="price-through">99.99 TL</label></span><div class="clearfix"></div>
                    <span class="seller-title">Strong Low Bass Strereo</span>
                  </div>
                </div>
              </div> 
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-4 pr-0">
          <div class="arrivals-advertise"><img src="../template/images/arrival.jpg"></div>
        </div>
        <div class="col-md-4 pr-0">
          <div class="arrivals-advertise"><img src="../template/images/arrival2.png"></div>
        </div>
        <div class="col-md-4">
          <div class="arrivals-advertise"><img src="../template/images/arrival3.png"></div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row">
        <?php
         $product_img_dir = base_url('/assets/images/product_image/');
         $i = 1;
         if($home_category_prodducts) 
         {
             foreach ($home_category_prodducts as $category_name => $category_products_array) 
             { 
              //echo '<pre>';print_r($home_category_prodducts);exit;
              if($i > 1)
              {
                 break;
              }
              else
              {
                $i++;
              }
              
              if($category_products_array)
              {            
        ?>
        <div class="col-md-12 mt-3">
          <div class="top-mobiles">Popular <?php echo $category_name;?></div>   
          <div class="row">
            <?php
             foreach ($category_products_array as $category_products) 
             {
                $pro_sale_price = $category_products->sale_price ? $category_products->sale_price : '00.0';
                 $affiliate_marketing_url = $category_products->affiliate_marketing_url ? $category_products->affiliate_marketing_url : '#';
                 $product_images = json_decode($category_products->product_image,true);
                 $product_image_one = $product_img_dir.'default.png';
                 //print_r($product_images);exit;

                 if(isset($product_images[0]) && $product_images[0])
                 {
                     // $product_image_one = $product_img_dir.$product_images[0];
                     $product_image_one = get_s3_url('quickcompare/products/'.$product_images[0]);
                 }
                 
                 $product_url = base_url('product/').$category_products->category_slug.'/'.$category_products->product_slug;

                 $fav_icon =  $category_products->is_fav ? 'text-danger' : 'text-secondary';
            ?>  
              <div class="box">
                <div class="popoular-tab"><a href="<?php echo $product_url;?>">
                  <img src="<?php echo $product_image_one;?>" alt="" class="category-image" />
                  <div class="product-bell border top-alarm mb-1"><i class="far fa-bell" aria-hidden="true"></i></div>
                  <div class="product-bell border top-alarm">
                    <a href="javascript:void(0)" class="add_fav_product_btn" data-product_id = "<?php echo $category_products->product_id; ?>"> 
                      <i class="fav_icon far fa-heart  <?php echo $fav_icon; ?>" data-icon='fav'></i> 
                    </a>
                  </div>
                  <div class="clearfix"></div>
                  <div class="poopular-text">
                    <?php
                     $product_title = urldecode($category_products->product_title);
                     $product_title = strlen($product_title) > 50 ? substr($product_title,0,50)."..." : $product_title;
                    ?>
                    <h4><?php echo $product_title;?></h4>
                    <span class="product-price"><?php echo $pro_sale_price.' '.$currency_code?></span><div class="clearfix"></div>
                    <span class="product-store">From <a href="<?php echo $affiliate_marketing_url;?>"><?php echo $affiliate_marketing_url;?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                  </div>
                </a></div>            
              </div>
            <?php } ?>
          </div>      
        </div>
      <?php  } } } ?>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row mt-3">
        <div class="col-md-6 pr-0 pl-0">
          <div class="home-advertise"><img src="../template/images/advertise1.jpg"></div>
        </div>
        <div class="col-md-6 pl-0">
          <div class="home-advertise"><img src="../template/images/advertise2.png"></div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-12 mt-3">
          <div class="top-products">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="popular-category-tab" data-toggle="pill" href="#popular-category" role="tab" aria-controls="popular_category" aria-selected="true">Popular Category</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="popular-product-tab" data-toggle="pill" href="#popular-product" role="tab" aria-controls="popular_product" aria-selected="false">Popular Product</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="popular-skelpy-tab" data-toggle="pill" href="#popular-skelpy" role="tab" aria-controls="popular_skelpy" aria-selected="false">Popular Sklepy</a>
              </li>
            </ul>
          </div>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="popular-mobile" role="tabpanel" aria-labelledby="popular-mobile-tab">
              <div class="row">
                <div class="col-md-2">
                  <div class="category-tag"><a href="#">asdfasd</a></div>
                </div>
                <div class="col-md-2">
                  <div class="category-tag"><a href="#">asdfasd</a></div>
                </div>
                <div class="col-md-2">
                  <div class="category-tag"><a href="#">asdfasd</a></div>
                </div>
                <div class="col-md-2">
                  <div class="category-tag"><a href="#">asdfasd</a></div>
                </div>
                <div class="col-md-2">
                  <div class="category-tag"><a href="#">asdfasd</a></div>
                </div>
                <div class="col-md-2">
                  <div class="category-tag"><a href="#">asdfasd</a></div>
                </div>
                <div class="col-md-2">
                  <div class="category-tag"><a href="#">asdfasd</a></div>
                </div>
                <div class="col-md-2">
                  <div class="category-tag"><a href="#">asdfasd</a></div>
                </div>
                <div class="col-md-2">
                  <div class="category-tag"><a href="#">asdfasd</a></div>
                </div>
                <div class="col-md-2">
                  <div class="category-tag"><a href="#">asdfasd</a></div>
                </div>
                <div class="col-md-2">
                  <div class="category-tag"><a href="#">asdfasd</a></div>
                </div>
                <div class="col-md-2">
                  <div class="category-tag"><a href="#">asdfasd</a></div>
                </div>
                <div class="col-md-2">
                  <div class="category-tag"><a href="#">asdfasd</a></div>
                </div>
                <div class="col-md-2">
                  <div class="category-tag"><a href="#">asdfasd</a></div>
                </div>
                <div class="col-md-2">
                  <div class="category-tag"><a href="#">asdfasd</a></div>
                </div>
                <div class="col-md-2">
                  <div class="category-tag"><a href="#">asdfasd</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>    
      </div>
    </div>
  </section>

<!-- <?php
   $product_img_dir = base_url('/assets/images/product_image/');
   
   if($home_category_prodducts) 
   {
       foreach ($home_category_prodducts as $category_name => $category_products_array) 
       { 
           if($category_products_array)
           {
               ?>
<div class="latest_products_cart container px-4 product_compare">
   <h3 class="h3"> <span class="text-danger"><?php echo lang('New In');?> </span> <?php echo $category_name; ?> </h3>
   <div class="row">
      <?php
         foreach ($category_products_array as $category_products) 
         { 
          // p($category_products); 
             $sale = $category_products->base_price - $category_products->sale_price;
             $sale_percentaage = $sale > 0 ? ($sale/$category_products->base_price)*100 : 0;
             $pro_base_price = $category_products->base_price ? $category_products->base_price : '00.0';
             $pro_sale_price = $category_products->sale_price ? $category_products->sale_price : '00.0';
             $affiliate_marketing_url = $category_products->affiliate_marketing_url ? $category_products->affiliate_marketing_url : '#';
             
         
             $product_images = json_decode($category_products->product_image,true); 
          
             $product_image_one = $product_img_dir.'default.png';
             $product_image_two = $product_img_dir.'default.png';
             //print_r($product_images);exit;

             if(isset($product_images[0]) && $product_images[0])
             {
                 // $product_image_one = $product_img_dir.$product_images[0];
                 $product_image_one = get_s3_url('quickcompare/products/'.$product_images[0]);
             }
             if(isset($product_images[1]) && $product_images[1])
             {
                 // $product_image_two = $product_img_dir.$product_images[1];
                 $product_image_two = get_s3_url('quickcompare/products/'.$product_images[1]);
             }



            $product_url = base_url('product/').$category_products->category_slug.'/'.$category_products->product_slug;

            $fav_icon =  $category_products->is_fav ? 'text-danger' : 'text-secondary';

            $add_to_compare = in_array($category_products->product_slug, $compare_session) ? 'add_to_compare' : '';
            $compare_icon = $add_to_compare ? 'fa-check' : 'fa-plus';
                      
         
             ?>
      <div class="col-md-3 col-sm-6 mb-5">
         <div class="product-grid8">
            <a href="javascript:void(0)" class="add_fav_product_btn" data-product_id = "<?php echo $category_products->product_id; ?>"> 
            <i class="fav_icon fas fa-heart  <?php echo $fav_icon; ?>" data-icon='fav'></i> 
            </a>
            <div class="product-image8">
               <a href="<?php echo $product_url; ?>">
               <img class="pic-1 p-2" src="<?php echo $product_image_one?>" alt='<?php echo $this->settings->site_name; ?>'>
               <img class="pic-2 p-2" src="<?php echo $product_image_two?>" alt="<?php echo $this->settings->site_name; ?>">
               </a>
               <ul class="social">

                  <li><a href="tg://msg?text=Checkout: <?php echo str_replace(' ', '+', $category_products->product_title); ?> on <?php echo base_url('product/').$category_products->category_slug.'/'.$category_products->product_slug; ?>&to=<?php echo str_replace(' ', '', get_admin_setting('site_phone_number')); ?>" class="fab fa-telegram" target="_blank"></a></li>

                  <li><a href="//web.whatsapp.com/send?phone=<?php echo str_replace(' ', '', get_admin_setting('site_phone_number')); ?>&amp;text=Checkout: <?php echo str_replace(' ', '+', $category_products->product_title); ?> on <?php echo base_url('product/').$category_products->category_slug.'/'.$category_products->product_slug; ?>" class="fab fa-whatsapp" target="_blank"></a></li>

                  <li><a href="//www.facebook.com/sharer.php?u=<?php echo $product_url; ?>" class="fab fa-facebook" target="_blank"></a></li>
                  <li><a href="//twitter.com/share?text=<?php echo str_replace(' ', '+', $category_products->product_title); ?>&url=<?php echo $product_url; ?>" class="fab fa-twitter" target="_blank"></a></li>
               </ul>
               <span class="product-discount-label"><?php echo round($sale_percentaage) ?>% <?php echo lang('Off');?></span>
            </div>
            <div class="product-content">
               <div class="price small"> <?php echo $currency_code.' '.$pro_sale_price ?>
                  <span><?php echo $currency_code.' '.$pro_base_price?></span>
               </div>
               <?php
               $product_title = urldecode($category_products->product_title);
               $product_title = strlen($product_title) > 50 ? substr($product_title,0,50)."..." : $product_title;
               ?>
               <h6 class="title"><a href="<?php echo $product_url; ?>"><?php echo $product_title; ?></a></h6>
              
              <a href="javascript:void(0)" data-product_category="<?php echo $category_products->category_slug ; ?>"  data-product_slug="<?php echo $category_products->product_slug ; ?>" class="compare_product_link list_compare_link btn btn-light btn-block <?php echo $add_to_compare; ?> <?php echo $category_products->product_slug ; ?>"> <i class="fas <?php echo $compare_icon; ?> small"></i> <?php echo lang('product compare btn'); ?></a>

              <a class="all-deals small" target="_blank" href="<?php echo $affiliate_marketing_url; ?>"> <?php echo lang('Buy Now');?> <i class="fa fa-angle-right icon"></i></a>
               
            </div>
         </div>
      </div>
      <?php
         } ?>
   </div>
</div>
<hr>
<?php
   }  
 }
}
?> -->

  <!-- <section class="client">
    <div class="container">
      <div class="row">

        <h3 class="h3"><span class="text-danger"><?php echo lang('Our Brand'); ?></span> <?php echo lang('Partners'); ?> </h3>

        <div class="carousel-client">

          <?php 
            $markets_all = get_footer_markets_helper();

            foreach ($markets_all as  $market_array) 
            { 
              $f_market_logo = $market_array->market_logo? $market_array->market_logo :'default.png';
              $f_market_logo = base_url('assets/images/market_image/').$f_market_logo;
              ?>
              <div class="slide"><img src="<?php echo $f_market_logo ?>"></div>
              <?php
            }
          ?>

        </div>
      </div>
    </div>
  </section> -->









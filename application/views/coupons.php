<div class="latest_coupons_details container px-4 product_compare">
	<h3 class="h3"> <?php echo 'coupons'; ?> </h3>
	<div class="row">

		<div class="col-12">
			<ul class="nav mb-3" id="coupon_tabs" role="tablist">
			  <li class="coupon-nav-item">
			    <a class="coupon-nav-link active no_underline " id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">All (<?php echo count($coupons); ?>)</a>
			  </li>
			  <li class="coupon-nav-item">
			    <a class="coupon-nav-link no_underline" id="deals-tab" data-toggle="tab" href="#deals" role="tab" aria-controls="deals" aria-selected="false">Deals (<?php echo count($coupons_deals); ?>)</a>
			  </li>
			  <li class="coupon-nav-item">
			    <a class="coupon-nav-link no_underline" id="code-tab" data-toggle="tab" href="#code" role="tab" aria-controls="code" aria-selected="false">Code (<?php echo count($coupons_code); ?>)</a>
			  </li>
			</ul>
		</div>
		<div class="clearfix"></div>


		<div class="col-md-12 col-sm-12 tab-content my-5 " id="myTabContent">

			<div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">			  
				<?php
				if($coupons)
				{
				  	 foreach ($coupons as  $coupon_array) 
				        {
				          	$image = $coupon_array->image ? $coupon_array->image : 'default.png';
				          	$dir =  base_url('assets/images/coupon/');
				          	$coupon_img = $dir.$image;
				          	$coupon_title = strip_tags($coupon_array->title);
		                	$coupon_title = strlen($coupon_title) > 50 ? substr($coupon_title,0,50)."..." : $coupon_title;
		                    $coupon_description = strip_tags($coupon_array->description);
		                    $coupon_description = strlen($coupon_description) > 150 ? substr($coupon_description,0,150)."..." : $coupon_description;
				          ?>
				            <div class="row  mb-2">
				               	<div class=" col-md-2 w20 coupon_detail text-center ">		                  
				                    <img class="pic-1 p-2" src="<?php echo $coupon_img;?>" alt='<?php echo $this->settings->site_name; ?>'>
				                    <h4 class="w-100"> <?php echo ucfirst($coupon_title); ?> </h4>
				                </div>
					                 
					            <div class="col-md-8 w80 coupon_detail">
				                    <h6 class="m-0"><?php echo $coupon_description; ?></h6>
				                    <?php
				                    if($coupon_array->coupon_code)
				                    {
				                    	?>
				                    		<div class="price small my-1">Coupon Code : - <?php echo $coupon_array->coupon_code; ?> </div>
				                    	<?php
				                    } 
				                    ?>


				                    <?php
				                    if($coupon_array->valid_till)
				                    {
				                    	?>
				                    	<div class="price small my-1">Coupon Valid Till : - <?php echo date('D, d- M - Y h : i : s A',strtotime($coupon_array->valid_till)); ?> </div>
				                    	<?php
				                    } 
				                    ?>
					            </div>

					            <div class="col-md-2 coupon_detail view_deail">
				                    <a href="<?php echo $coupon_array->promo_link; ?>" class="btn btn-primary btn-block" > View Deal</a>
					            </div>
				            </div>
				          <?php
				        }
				}
				else
				{ ?>
				  	<div class="col-12 py-5 border"> Sorry No Coupon Found</div>
				  <?php
				}
					?>
		    </div>

			<div class="tab-pane fade" id="deals" role="tabpanel" aria-labelledby="deals-tab">
				<?php
				if($coupons_deals)
				{
				  	 foreach ($coupons_deals as  $coupon_array) 
				        {
				          	$image = $coupon_array->image ? $coupon_array->image : 'default.png';
				          	$dir =  base_url('assets/images/coupon/');
				          	$coupon_img = $dir.$image;
				          	$coupon_title = strip_tags($coupon_array->title);
		                	$coupon_title = strlen($coupon_title) > 50 ? substr($coupon_title,0,50)."..." : $coupon_title;
		                    $coupon_description = strip_tags($coupon_array->description);
		                    $coupon_description = strlen($coupon_description) > 150 ? substr($coupon_description,0,150)."..." : $coupon_description;
				          ?>
				            <div class="row  mb-2">
				               	<div class=" col-md-2 w20 coupon_detail text-center ">		                  
				                    <img class="pic-1 p-2" src="<?php echo $coupon_img;?>" alt='<?php echo $this->settings->site_name; ?>'>
				                    <h4 class="w-100"> <?php echo ucfirst($coupon_title); ?> </h4>
				                </div>
					                 
					            <div class="col-md-8 w80 coupon_detail">
				                    <h6 class="m-0"><?php echo $coupon_description; ?></h6>
				                    <?php
				                    if($coupon_array->coupon_code)
				                    {
				                    	?>
				                    		<div class="price small my-1">Coupon Code : - <?php echo $coupon_array->coupon_code; ?> </div>
				                    	<?php
				                    } 
				                    ?>


				                    <?php
				                    if($coupon_array->valid_till)
				                    {
				                    	?>
				                    	<div class="price small my-1">Coupon Valid Till : - <?php echo date('D, d- M - Y h : i : s A',strtotime($coupon_array->valid_till)); ?> </div>
				                    	<?php
				                    } 
				                    ?>
					            </div>

					            <div class="col-md-2 coupon_detail view_deail">
				                    <a href="<?php echo $coupon_array->promo_link; ?>" class="btn btn-primary btn-block" > View Deal</a>
					            </div>
				            </div>
				          <?php
				        }
				}
				else
				{ ?>
				  	<div class="col-12  py-5 border"> Sorry No Coupon Deal Found</div>
				  <?php
				}
				?>

			</div>
			<div class="tab-pane fade" id="code" role="tabpanel" aria-labelledby="code-tab">
				<?php
				if($coupons_code)
				{
				  	 foreach ($coupons_code as  $coupon_array) 
				        {
				          	$image = $coupon_array->image ? $coupon_array->image : 'default.png';
				          	$dir =  base_url('assets/images/coupon/');
				          	$coupon_img = $dir.$image;
				          	$coupon_title = strip_tags($coupon_array->title);
		                	$coupon_title = strlen($coupon_title) > 50 ? substr($coupon_title,0,50)."..." : $coupon_title;
		                    $coupon_description = strip_tags($coupon_array->description);
		                    $coupon_description = strlen($coupon_description) > 150 ? substr($coupon_description,0,150)."..." : $coupon_description;
				          ?>
				            <div class="row  mb-2">
				               	<div class=" col-md-2 w20 coupon_detail text-center ">		                  
				                    <img class="pic-1 p-2" src="<?php echo $coupon_img;?>" alt='<?php echo $this->settings->site_name; ?>'>
				                    <h4 class="w-100"> <?php echo ucfirst($coupon_title); ?> </h4>
				                </div>
					                 
					            <div class="col-md-8 w80 coupon_detail">
				                    <h6 class="m-0"><?php echo $coupon_description; ?></h6>
				                    <?php
				                    if($coupon_array->coupon_code)
				                    {
				                    	?>
				                    		<div class="price small my-1">Coupon Code : - <?php echo $coupon_array->coupon_code; ?> </div>
				                    	<?php
				                    } 
				                    ?>


				                    <?php
				                    if($coupon_array->valid_till)
				                    {
				                    	?>
				                    	<div class="price small my-1">Coupon Valid Till : - <?php echo date('D, d- M - Y h : i : s A',strtotime($coupon_array->valid_till)); ?> </div>
				                    	<?php
				                    } 
				                    ?>
					            </div>

					            <div class="col-md-2 coupon_detail view_deail">
				                    <a href="<?php echo $coupon_array->promo_link; ?>" class="btn btn-primary btn-block" > View Deal</a>
					            </div>
				            </div>
				          <?php
				        }
				}
				else
				{ ?>
				  	<div class="col-12  py-5 border"> Sorry No Coupon Code Found</div>
				  <?php
				}
				?>

			</div>
		</div>
	</div>
</div>

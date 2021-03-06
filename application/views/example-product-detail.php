<?php
   $currency =  get_admin_setting('currency_code');
   $currency_code =  get_currency_symbol($currency);

   $add_to_compare = in_array($products->product_slug, $compare_session) ? 'add_to_compare' : '';
   $compare_icon = $add_to_compare ? 'fa-check' : 'fa-plus';
   //echo '<pre>';echo print_r($price_history);exit;  
   $price_date =  $price_minimum = $max_price = array();
   foreach($price_history as $price_key => $price_value)
   {
      $price_date[] = date("d-m-Y", strtotime($price_value->day));
      $price_minimum[] = $price_value->min_price;
      $max_price[] = $price_value->min_price;
   }
   $price_date = json_encode($price_date);
   $price_minimum = json_encode($price_minimum);
   if($max_price)
   {
      $max_price = max($max_price)+100;
   }
?>
<script type="text/javascript">
   var price_date = <?php echo $price_date; ?>; 
   var price_minimum = <?php echo $price_minimum; ?>;
   var price_maximum = <?php echo $max_price; ?>;
</script>

<div class="container-fluid pt-4 detail_page product_compare">
   <div class="container">
      <div class="row ">
         <div class="col-md-12">
            <h6 class="product-breadcrumb mr-1">
               <a href="<?php echo base_url(); ?>"><?php echo 'Home'; ?> </a> 
               <i class="fas fa-arrow-right" aria-hidden="true"></i>
               <a href="<?php echo base_url('search/').$products->category_slug; ?>" class="text-capitalize"><?php echo $products->category_title; ?> </a> 
               <i class="fas fa-arrow-right" aria-hidden="true"></i>
               <a href="<?php echo base_url('search/').$products->category_slug.'?brands='.$products->brand_slug; ?>">        
               <span class=" ml-1 text-capitalize"><?php echo $products->brand_title; ?></span>
               </a>
            </h6>
         </div>
         <div class="col-md-4">
            <div class="width_100 bg-white py-2 ">
               <div class="tab-content row py-3  d-flex justify-content-center align-items-center pro_img_preview" id="myTabContent">
                  <div class="product-variation">
                     <div class="list-product cursor"><a class="open-fancybox" rel="gallery1" href="" title="hello"><img src="<?php echo base_url('assets/images/image-click.jpg');?>" alt="" ></a></div>
                      
                     <div class="chart-product"><a href="#"><img src="<?php echo base_url('assets/images/chart-bar.jpg');?>" alt=""></div>
                     <div class="chart-product"><a href="#"><img src="<?php echo base_url('assets/images/rating-list.jpg');?>" alt=""></div>
                  </div>
                  <!-- <?php $product_image_array = json_decode($products->product_image); 
                     $product_img_dir = base_url('/assets/images/product_image/');
                     $active = 'show active';
                     $i = 0;
                     if($product_image_array)
                     {
                     	foreach ($product_image_array as $product_image) 
                     	{ 
                     		$i++;
                     		$product_image = $product_image ? get_s3_url('quickcompare/products/'.$product_image) : $product_img_dir.'default.jpg';
                     
                     	?>
                  <div class="tab-pane fade col-lg-12 <?php echo $active; ?>" id="img-<?php echo $i;?>" role="tabpanel" aria-labelledby="img-tab-<?php echo $i;?>">
                     <img  class="img-fluid" alt="<?php echo $products->category_title; ?>" src="<?php echo $product_image;?>" />
                  </div>
                  <?php
                     $active = '';
                     }
                  } else { 
                  ?>
                  <div class="tab-pane fade col-lg-12 active show" id="img-default" role="tabpanel" aria-labelledby="img-tab-default">
                     <img class="img-fluid"  alt="<?php echo $products->category_title; ?>" src="<?php echo $product_img_dir?>default.png" />
                  </div>
                  <?php } ?> -->
               </div>

               <!-- <ul class="nav nav-tabs text-center pro-details mt-5" id="imagepreview_tab" role="tablist">
                  <?php $product_image_array = json_decode($products->product_image); 
                     $product_img_dir = base_url('/assets/images/product_image/');
                     $active = 'show active';
                     $i = 0;
                     if($product_image_array)
                     {
                     	foreach ($product_image_array as $product_image) 
                     	{ 
                     		// $product_image = $product_image ? $product_image : 'default.jpg';
                           $product_image = $product_image ? get_s3_url('quickcompare/products/'.$product_image) : $product_img_dir.'default.jpg';

                     		$i++;
                     
                     	?>
                  <li class="nav-item mb-2">
                     <img alt="<?php echo $products->category_title; ?>" class="img-fluid <?php echo $active; ?> " src="<?php echo $product_image;?>"  id="img-tab-<?php echo $i;?>" data-toggle="tab" href="#img-<?php echo $i;?>" role="tab" aria-controls="img-<?php echo $i;?>" aria-selected="true"/>
                  </li>
                  <?php
                     $active = '';
                     }
                     }
                     else
                     { ?>
                  <li class="nav-item mb-2">
                     <img alt="<?php echo $products->category_title; ?>" class="img-fluid active show" src="<?php echo $product_img_dir;?>default.png"  id="img-tab-default" data-toggle="tab" href="#img-default" role="tab" aria-controls="img-default" aria-selected="true"/>
                  </li>
                  <?php
                     }
                     ?>
               </ul>

               <ul class="social_detail_page d-flex p-0">
                  <li class="px-1 h4"><a href="//social-plugins.line.me/lineit/share?url=<?php echo base_url('product/').$products->category_slug.'/'.$products->product_slug; ?>&to=<?php echo str_replace(' ', '', get_admin_setting('site_phone_number')); ?>" class="fab fa-line" target="_blank"></a></li>
                  <li class="px-1 h4"><a href="tg://msg?text=Checkout: <?php echo str_replace(' ', '+', $products->product_title); ?> on <?php echo base_url('product/').$products->category_slug.'/'.$products->product_slug; ?>&to=<?php echo str_replace(' ', '', get_admin_setting('site_phone_number')); ?>" class="fab fa-telegram" target="_blank"></a></li>
                  <li class="px-1 h4"><a href="//web.whatsapp.com/send?phone=<?php echo str_replace(' ', '', get_admin_setting('site_phone_number')); ?>&amp;text=Checkout: <?php echo str_replace(' ', '+', $products->product_title); ?> on <?php echo base_url('product/').$products->category_slug.'/'.$products->product_slug; ?>" class="fab fa-whatsapp" target="_blank"></a></li>

                  <li class="px-1 h4"><a href="//www.facebook.com/sharer.php?u=<?php echo base_url('product/').$products->category_slug.'/'.$products->product_slug; ?>" class="fab fa-facebook" target="_blank"></a></li>
                  <li class="px-1 h4"><a href="//twitter.com/share?text=<?php echo str_replace(' ', '+', $products->product_title); ?>&url=<?php echo base_url('product/').$products->category_slug.'/'.$products->product_slug; ?>" class="fab fa-twitter" target="_blank"></a></li>
                  <li class="px-1 h4"><a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>

               </ul> -->
               <div class="product-detail-single">
                 <?php 
                     $product_image_array = json_decode($products->product_image); 
                     $product_img_dir = base_url('/assets/images/product_image/');   
                     if($product_image_array)
                     {
                        foreach ($product_image_array as $product_image) 
                        { 
                           
                           $product_image = $product_image ? get_s3_url('quickcompare/products/'.$product_image) : $product_img_dir.'default.jpg';
            
                  ?> 
                    <div class="detail-slide">
                      <img src="<?php echo $product_image;?>" alt="" class="category-image" />  
                    </div>
                  <?php  } } ?>
               </div>

               <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                 <div class="modal-dialog" role="document">
                   <div class="modal-content">
                     <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalLabel">Contact Seller</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                       </button>
                     </div>
                     <form id="sellerform" method="POST" enctype='multipart/form-data' action="<?php echo base_url('')."product/contactseller";?>">
                        <div class="modal-body">
                           <div class="form-group">
                              <label for="recipient-name" class="col-form-label text-left">Name:</label>
                              <input type="text" class="form-control" id="recipient-name" name="name">
                            </div>     
                           <div class="form-group">
                              <input type="hidden" name="productid" value="<?php echo $products->product_id;?>">
                              <label class="required font-weight-bold text-dark text-2 text-left">Message</label>
                              <textarea data-msg-required="Please enter your message." name="message" id="message" required class="form-control" id="message-text"></textarea>
                           </div>
                           <div class="form-group col-sm-12<?php echo form_error('captcha') ? ' has-error' : ''; ?>">
                              <div class="form-group">
                                 <?php echo form_label(lang('contact input captcha'), 'captcha', array('class'=>'control-label')); ?>
                                 <br />
                                 <div class="row">
                                    <div class="col-3 captcha_image">  <?php echo $captcha_image; ?> </div>
                                    <div class="col-2"></div>
                                    <div class="col-7">
                                       <?php echo form_input(array('name'=>'captcha', 'id'=>'captcha','placeholder'=>'captcha', 'value'=>"", 'class'=>'form-control h-auto')); ?>
                                       <span class="small text-danger"> <?php echo strip_tags(form_error('captcha')); ?> </span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <input type="submit" name="sub" value="Submit" id="submitForm" class="btn btn-primary btn-modern" data-loading-text="Loading...">
                        </div>
                     </form>
                   </div>
                 </div>
               </div>

            </div>
         </div>

         <?php $fav_icon =  $products->is_fav ? 'text-danger' : 'text-secondary';  ?>
         <div class="col-md-8">
            <div class="card-body p-3 bg-white">
               <h3 class="product-detail-title mb-3 mt-4"><?php echo $products->product_title; ?>
                  <?php $totalrating = (isset($count_product_id->Total) && !empty($count_product_id->Total) ? $count_product_id->Total : 0);?>
                  <!-- <a href="#rating-block" class="reviewtotal">(<?php echo $totalrating .' Reviews';?>)</a>
                  <a href="javascript:void(0)" class="add_fav_product_btn small" data-product_id = "<?php echo $products->product_id; ?>"> 
                     <i class="fav_icon fas fa-heart  <?php echo $fav_icon; ?>" data-icon='fav'></i> 
                  </a> -->
                  
               </h3>

               <div class="minimum-price"><?php echo $products->min_price .' '. $currency_code;?></div>
               <div class="uan">$uan en ucuzu</div>
               <div class="gitiyor"><img src="<?php echo base_url('assets/images/product_image/giti-com.jpg');?>"> gitigidiyor.com</div>
               <div class="clearfix"></div>
               <div class="product-detail-like mt-5">
                  <div class="like-button">
                     <a href="javascript:void(0)" class="add_fav_product_btn small" data-product_id = "<?php echo $products->product_id; ?>"> 
                        <i class="fav_icon fas fa-heart  <?php echo $fav_icon; ?>" data-icon='fav'></i>  <span class="pl-2 pr-1">urunu began</span>
                     </a>
                  </div>
                  <div class="bell-button">
                     <?php $bellicon = (isset($user_alarm_exist) && !empty($user_alarm_exist) ? 'text-success' : 'text-secondary');
                     $user_alarm_data = (isset($get_user_alarm) && !empty($get_user_alarm) ? $get_user_alarm->price : "");
                     ?>
                     <input type="hidden" class="alam-data" value="<?php echo $user_alarm_data;?>" data-variant_id="<?php echo $products->product_varient_id;?>">
                     <div class="bellicon"><i class="fa fa-bell <?php echo $bellicon;?>" id ="bellactive" aria-hidden="true"></i> <span class="pl-2 pr-1">Fiyat Alarmi</span></div>   
                  </div>
                  <div class="diger">
                     <div class="diger-inner"><img src="<?php echo base_url('assets/images/product_image/diger.jpg');?>"> <span class="pl-2 pr-1">Diger urunlerle karsilastir</span></div>   
                  </div>
               </div>
               <!-- <h6 class="text-primary mr-1">
                  <a href="<?php echo base_url('search/').$products->category_slug; ?>"><?php echo $products->category_title; ?> </a> 
                  <i class="fas fa-chevron-right small"></i>
                  <a href="<?php echo base_url('search/').$products->category_slug.'?brands='.$products->brand_slug; ?>">			
                  <span class=" ml-1 text-capitalize text-warning"><?php echo $products->brand_title; ?></span>
                  </a>
               </h6> -->


               <div class="clearfix"></div>
               <!-- <div class="product_markets_container">
               <?php
                  if($product_markets)
                  { 
                     $total_markets = count($product_markets);
                     $market_img_dir = base_url('/assets/images/market_image/');
                     if($total_markets > 3) {

                  ?>
                     <table class="table product_markets mt-5">
                        <?php for($i=0;$i<3;$i++) 
                           { 
                              $market_image = $product_markets[$i]->market_logo ? $product_markets[$i]->market_logo : 'default_market.jpg';
                           
                              ?>
                        <tr>
                           <th><img alt="<?php echo $products->category_title; ?>" class="rounded-circle" src="<?php echo $market_img_dir.$market_image;?>" width="50px" height="50px"></th>
                           <th><?php echo $currency_code.' '.$product_market_data->sale_price;?></th>
                           <th><a  target="_blank" href="<?php echo $product_markets[$i]->affiliate_marketing_url;?>"><i class="fas fa-shopping-cart mr-2"></i> <?php echo lang('Buy Now'); ?> </a></th>
                        </tr>
                        <?php 
                           } ?>
                     </table>


               <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="heading_moremarkets">
                     <h4 class="panel-title">
                        <a role="button" class="p-2 text-primary h5" data-toggle="collapse" data-parent="#accordion" href="#collapse_moremarkets" aria-expanded="true" aria-controls="collapse_moremarkets">
                        <?php echo lang('More Makets');?>
                        <i class="fas fa-chevron-down float-right"></i></a>
                     </h4>
                  </div>
                  <div id="collapse_moremarkets" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_moremarkets">


                     <table class="table table-striped product_markets mt-5">
                        <?php for($i=3;$i<$total_markets;$i++) 
                           { 
                              $market_image = $product_markets[$i]->market_logo ? $product_markets[$i]->market_logo : 'default_market.jpg';
                           
                              ?>
                        <tr>
                           <th><img alt="<?php echo $products->category_title; ?>" class="rounded-circle" src="<?php echo $market_img_dir.$market_image;?>" width="50px" height="50px"></th>
                           <th><?php echo $currency_code.' '.$product_market_data->sale_price;?></th>
                           <th><a  target="_blank" href="<?php echo $product_markets[$i]->affiliate_marketing_url;?>"><i class="fas fa-shopping-cart mr-2"></i> <?php echo lang('Buy Now'); ?> </a></th>
                        </tr>

                        <?php 
                           } ?>
                     </table>

                     
                  </div>
                  <hr>
               </div>


                  <?php
                     } else {
                  ?>

                     <table class="table product_markets mt-5 table-striped">
                        <?php foreach ($product_markets as $product_market_data) 
                           { 
                              $market_image = $product_market_data->market_logo ? $product_market_data->market_logo : '';
                           
                              ?>
                        <tr>
                           <th>
                              <?php if ($market_image)
                              { ?>
                                 
                                 <img title="<?php echo $product_market_data->market_title; ?>" alt="<?php echo $product_market_data->market_title; ?>" class="rounded-circle" src="<?php echo $market_img_dir.$market_image;?>" width="50px" height="50px">

                                <?php
                              }
                              else
                              {
                                 echo $product_market_data->market_title;
                              } ?>

                           </th>
                           <th><?php echo $currency_code.' '.$product_market_data->sale_price;?></th>
                           <th><a  target="_blank" href="<?php echo $product_market_data->affiliate_marketing_url;?>"><i class="fas fa-shopping-cart mr-2"></i> <?php echo lang('Buy Now'); ?> </a></th>
                        </tr>
                        <?php 
                           } ?>
                     </table>

                  <?php

                     }
                  ?>


               <?php
                  }
                  ?> -->
                  <!-- <table class="table product_markets mt-5 table-striped">
                     <?php  
                        if(isset($product_additional_market_price) && !empty($product_additional_market_price))
                        {
                           foreach($product_additional_market_price as $additional_key => $additional_value)
                           {
                     ?>
                              <tr>
                                 <th><?php echo ucfirst($additional_value->market_name);?></th>
                                 <th><?php echo $currency_code.' '.$additional_value->sale_price;?></th>
                                 <th><a  target="_blank" href="<?php echo $additional_value->affiliate_url;?>"><i class="fas fa-shopping-cart mr-2"></i> <?php //echo lang('Buy Now'); ?> </th>
                              </tr>
                     <?php } } ?>
                  </table> -->
               </div>
               <!-- // End product_markets_container -->


               <div class="clearfix"></div>
               <!-- // Start Additional Market Price Detail -->
               <div class="additionalmain">
                  
               </div>
               <!-- // End Additional Market Price Detail -->
               <!-- <div class="clearfix"></div>
               <a href="javascript:void(0)" data-product_category="<?php echo $products->category_slug ; ?>"  data-product_slug="<?php echo $products->product_slug ; ?>" class="compare_product_link list_compare_link btn btn-light btn-block <?php echo $add_to_compare; ?> <?php echo $products->product_slug ; ?>"> <i class="fas <?php echo $compare_icon; ?> small"></i> <?php echo lang('product compare btn'); ?></a>
 -->
               
               
            </div>
            <!-- card-body.// -->
         </div>
         <!-- Product Detail col-7// -->

      </div>
   </a></div>

      <!-- Product Detail chart// -->
      <?php if($price_history){ ?>
         <div class="row mt-5">
            <canvas id="canvas" class="chartjs-render-monitor"></canvas>
         </div>
      <?php } ?>

      <?php
         if(count($varient_custom_field_values))
         { 
      ?>

      <div class="row mt-5">
         <div class="col-md-12 text-center">
            <div class="width_100 bg-white py-2 ">
               <div class="clearfix"></div>


      <?php

                     echo '<h5 class="text-warning my-3 text-center">'.lang('Available Product Variant').'</h5>';
                     $i=false;
                     echo "<div class='table-responsive'>";
                     echo '<table class="table table-striped" >';

                     foreach ($varient_custom_field_values as $sku => $varients) 
                     {
                        if(!$i) {
                           echo '<thead><tr>';
                           foreach ($varients as $key => $value) 
                           {
                              echo '<th scope="col">'.$key.'</th>';
                           }
                           echo '<th scope="col">Varient Detail</th>';
                           echo '</tr></thead>';
                        } else {
                           echo '<tr>';
                        }

                        foreach ($varients as $key => $value) 
                        {
                           $test = @json_decode($value);
                           if(is_array($test))
                           {
                              $value_data = implode(',', $test);
                           }
                           else
                           {
                              $value_data = $value;
                           }
                           echo '<td scope="col">'.$value_data.'</td>';

                        }
                           $product_variant_id = $varients['product_variant_id'];
                           echo '<td scope="col"><a href="'.base_url("varient/").$category_slug.'/'.$product_variant_id.'" class="varient_btn"><i class="far fa-eye"></i> </a></td>';

                        if($i) 
                        {
                           echo '</tr>';
                        }

                        $i=true;
                     }
                     echo '</table>';
                     echo "</div>";
      ?>

            </div>
         </div>
      </div>
      <?php } ?>


      <div class="row mt-5">
         <div class="col-md-12">
            <div class="width_100 bg-white py-2 h-100">
               <h2 class="text-center text-uppercase my-5"><span class="text-danger"><?php echo lang('front Product');?></span> <?php echo lang('front Details');?> </h2>
            </div>
         </div>
         <div class="col-md-12 product-info mb-5">
            <div class="width_100 bg-white p-4 h-100">
               <ul class="nav nav-tabs" id="product_details_Tab" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active" id="service-one-tab" data-toggle="tab" href="#service-one" role="tab" aria-controls="service-one" aria-selected="true"><?php echo lang('PRODUCT INFO');?></a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="service-two-tab" data-toggle="tab" href="#service-two" role="tab" aria-controls="service-two" aria-selected="false"><?php echo lang('DESCRIPTION');?></a>
                  </li>
               </ul>
               <div class="tab-content mb-5" id="myTabContent">
                  <div class="tab-pane fade show active" id="service-one" role="tabpanel" aria-labelledby="service-one-tab">
                     <section class="container product-info pt-3">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                           <?php 
                              $i = 0;
                              $product_field_group_array = json_decode($products->product_full_detail);
                              	foreach ($product_field_group_array as $custom_field_group => $custom_field_array) 
                              	{ 
                              		$i++;
                              		?>
                           <div class="panel panel-default">
                              <div class="panel-heading" role="tab" id="heading_<?php echo $i;?>">
                                 <h4 class="panel-title">
                                    <a role="button" class="p-2 text-primary h5" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $i;?>" aria-expanded="true" aria-controls="collapse_<?php echo $i;?>">
                                    <?php echo $custom_field_group; ?>
                                    <i class="fas fa-chevron-down float-right"></i></a>
                                 </h4>
                              </div>
                              <div id="collapse_<?php echo $i;?>" class="panel-collapse collapse <?php echo ($i==1) ? "show" : "in" ?>" role="tabpanel" aria-labelledby="heading_<?php echo $i;?>">
                                 <?php
                                    foreach ($custom_field_array as $custom_field_name => $custom_field_data) 
                                                  		{ 
                                                  			$field_filter_val = $custom_field_data->value ? $custom_field_data->value : NULL;
                                                   			if($field_filter_val)
                                                   			{
                                                   				?>
                                 <div class="panel-body">
                                    <table class="table mb-0 px-3 border-none">
                                       <tr>
                                          <td width="30%"><span class='h6'> <?php echo $custom_field_name; ?> </span></td>
                                          <td  width="70%"><span class="mmml-5"><?php echo $field_filter_val; ?></span></td>
                                       </tr>
                                    </table>
                                 </div>
                                 <?php 
                                    }
                                    
                                                		} ?>
                              </div>
                              <hr>
                           </div>
                           <?php
                              } ?>
                        </div>
                     </section>
                  </div>
                  <div class="tab-pane fade" id="service-two" role="tabpanel" aria-labelledby="service-two-tab">
                     <section class="container product-details pt-3">
                        <?php 
                           if($products){
                           	echo $products->product_description;
                           }
                           ?>
                     </section>
                     <hr class="mt-5">
                  </div>
               </div>
            </div>
         </div>
         <!-- background-white-height-100 -->
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="bg-white py-2">
               <h2 class="text-center text-uppercase my-5"> Rate the <span class="text-danger"><?php echo lang('front Product');?></span></h2>
               <div class="p-3">
                  <?php if(empty($comments_exist_with_productid_userid)) 
                     {
                  ?>
                     <form id="sellerform" method="POST" enctype='multipart/form-data' action="<?php echo base_url('')."rating/submit_rating";?>">
                        <?php echo form_label('Message'); ?> 
                        <input type="hidden" name="variantid" class="variantid" value="<?php echo $products->product_varient_id?>">
                        <textarea class="form-control" name="ratingcontent"></textarea>
                        
                        <div class="form-group" id="rating-ability-wrapper">
                            <label class="control-label mt-3" for="rating">
                               <span class="field-label-info">Rate Star</span>
                               <input type="hidden" id="selected_rating" name="selected_rating" value="" required="required">
                            </label>
                            <h2 class="bold rating-header" style="">
                              
                            </h2>
                            <button type="button" class="btnrating btn btn-default" data-attr="1" id="rating-star-1">
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btnrating btn btn-default" data-attr="2" id="rating-star-2">
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btnrating btn btn-default" data-attr="3" id="rating-star-3">
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btnrating btn btn-default" data-attr="4" id="rating-star-4">
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btnrating btn btn-default" data-attr="5" id="rating-star-5">
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </button>
                        </div>
                        <input type="hidden" class="rate" name="reviewstar" value="">
                        <input type="submit" name="save" value="Save" class="btn btn-primary btn-lg">
                     </form>
                  <?php  } ?>  
               </div>
               <div class="row p-3">
                  <div class="col-md-4">
                     <div id="rating-block">
                        <h4 class="pt-2 pb-2">Average user rating</h4>
                        <?php 
                              $average_rating = (isset($average) && !empty($average) ? round($average) : 0); 
                        ?>
                        <h2 class="bold padding-bottom-7"><?php echo $average_rating;?><small>/ 5</small></h2>
                        <?php if($average_rating >= 1) { ?>
                           <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                              <i class="fa fa-star text-white starfontsize" aria-hidden="true"></i>
                           </button> 
                        <?php } else { ?>
                        <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                           <i class="fa fa-star text-dark starfontsize" aria-hidden="true"></i>
                        </button>
                        <?php } ?>
                        <?php if($average_rating >= 2) { ?>
                           <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                              <i class="fa fa-star text-white starfontsize" aria-hidden="true"></i>
                           </button> 
                        <?php } else { ?>
                        <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                           <i class="fa fa-star text-dark starfontsize" aria-hidden="true"></i>
                        </button>
                        <?php } ?>
                        <?php if($average_rating >= 3) { ?>
                           <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                              <i class="fa fa-star text-white starfontsize" aria-hidden="true"></i>
                           </button> 
                        <?php } else { ?>
                        <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                           <i class="fa fa-star text-dark starfontsize" aria-hidden="true"></i>
                        </button>
                        <?php } ?>
                        <?php if($average_rating >= 4) { ?>
                           <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                              <i class="fa fa-star text-white starfontsize" aria-hidden="true"></i>
                           </button> 
                        <?php } else { ?>
                        <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                           <i class="fa fa-star text-dark starfontsize" aria-hidden="true"></i>
                        </button>
                        <?php } ?>
                        <?php if($average_rating >= 5) { ?>
                           <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                              <i class="fa fa-star text-white starfontsize" aria-hidden="true"></i>
                           </button> 
                        <?php } else { ?>
                        <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                           <i class="fa fa-star text-dark starfontsize" aria-hidden="true"></i>
                        </button>
                        <?php } ?>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <h4>Rating breakdown</h4>
                     <div class="progress-main">
                        <div class="starno">5 <i class="fa fa-star text-dark starfontsize" aria-hidden="true"></i></div>
                        <div class="progress mb-2 mt-2 customprogress">
                           <?php $rating_progress = (isset($rating_star[4]) && !empty($rating_star[4]) ? $rating_star[4]*100/$count_product_id->Total : 0);
                           ?>
                           <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo round($rating_progress)."%";?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div> 
                        <?php $rating_count = (isset($rating_star[4]) && !empty($rating_star[4]) ? $rating_star[4] : 0);?>
                        <div class="ratingcount"><?php echo $rating_count;?></div>
                     </div>
                     <div class="clearfix"></div>
                     <div class="progress-main">
                        <div class="starno">4 <i class="fa fa-star text-dark starfontsize" aria-hidden="true"></i></div>
                        <div class="progress mb-2 mt-2 customprogress">
                           <?php $rating_progress = (isset($rating_star[3]) && !empty($rating_star[3]) ? $rating_star[3]*100/$count_product_id->Total : 0);?>
                          <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo round($rating_progress)."%";?>" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <?php $rating_count = (isset($rating_star[3]) && !empty($rating_star[3]) ? $rating_star[3] : 0);?>
                        <div class="ratingcount"><?php echo $rating_count;?></div>
                     </div>
                     <div class="clearfix"></div>
                     <div class="progress-main">
                        <div class="starno">3 <i class="fa fa-star text-dark starfontsize" aria-hidden="true"></i></div>
                        <div class="progress mb-2 mt-2 customprogress">
                           <?php $rating_progress = (isset($rating_star[2]) && !empty($rating_star[2]) ? $rating_star[2]*100/$count_product_id->Total : 0);?>
                          <div class="progress-bar progress-bg-info" role="progressbar" style="width: <?php echo round($rating_progress)."%";?>" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <?php $rating_count = (isset($rating_star[2]) && !empty($rating_star[2]) ? $rating_star[2] : 0);?>
                        <div class="ratingcount"><?php echo $rating_count;?></div>
                     </div>
                     <div class="clearfix"></div>
                     <div class="progress-main">
                        <div class="starno">2 <i class="fa fa-star text-dark starfontsize" aria-hidden="true"></i></div>
                        <div class="progress mb-2 mt-2 customprogress">
                           <?php $rating_progress = (isset($rating_star[1]) && !empty($rating_star[1]) ? $rating_star[1]*100/$count_product_id->Total : 0);?>
                          <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo round($rating_progress)."%";?>" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <?php $rating_count = (isset($rating_star[1]) && !empty($rating_star[1]) ? $rating_star[1] : 0);?>
                        <div class="ratingcount"><?php echo $rating_count;?></div>
                     </div>
                     <div class="clearfix"></div>
                     <div class="progress-main">
                        <div class="starno">1 <i class="fa fa-star text-dark starfontsize" aria-hidden="true"></i></div>
                        <div class="progress mb-2 mt-2 customprogress">
                           <?php $rating_progress = (isset($rating_star[0]) && !empty($rating_star[0]) ? $rating_star[0]*100/$count_product_id->Total : 0);?>
                          <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo round($rating_progress)."%";?>" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <?php $rating_count = (isset($rating_star[0]) && !empty($rating_star[0]) ? $rating_star[0] : 0);?>
                        <div class="ratingcount"><?php echo $rating_count;?></div>
                     </div>
                     <div class="clearfix"></div>
                  </div>
               </div>
               <div class="border-bottom partition m-3"></div>
               <?php if($product_comments)
                 {
               ?>
               <div class="review-block ml-3 mr-3">
                  <?php   
                     foreach($product_comments as $comment_key => $comment_value)
                     {
                  ?>
                        <div class="row">
                           <div class="col-md-3">
                              <?php $userimage = (isset($comment_value->image) && !empty($comment_value->image) ? base_url('/assets/images/user_image/'.$comment_value->image) : base_url('assets/images/user_image/avatar-1.png'));?>
                              <img src="<?php echo $userimage;?>" class="img-rounded">
                              <div class="review-block-name"><?php echo $comment_value->first_name. ' ' .$comment_value->last_name;?></div>
                              <div class="review-block-date"><?php echo date('F d, Y', strtotime($comment_value->added));?><br/><?php echo time_elapsed_string($comment_value->added);?></div>
                           </div>
                           <div class="col-md-9">
                              <div class="review-block-rate">
                                <?php if($comment_value->rating >= 1) { ?>
                                    <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                       <i class="fa fa-star text-white starfontsize" aria-hidden="true"></i>
                                    </button> 
                                 <?php } else { ?>
                                    <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                       <i class="fa fa-star text-dark starfontsize" aria-hidden="true"></i>
                                    </button>   
                                 <?php } ?>
                                   
                                 <?php if($comment_value->rating >= 2) { ?>
                                    <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                       <i class="fa fa-star text-white starfontsize" aria-hidden="true"></i>
                                    </button> 
                                 <?php } else { ?>
                                    <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                       <i class="fa fa-star text-dark starfontsize" aria-hidden="true"></i>
                                    </button>   
                                 <?php } ?>

                                 <?php if($comment_value->rating >= 3) { ?>
                                    <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                       <i class="fa fa-star text-white starfontsize" aria-hidden="true"></i>
                                    </button> 
                                 <?php } else { ?>
                                    <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                       <i class="fa fa-star text-dark starfontsize" aria-hidden="true"></i>
                                    </button>   
                                 <?php } ?>

                                 <?php if($comment_value->rating >= 4) { ?>
                                    <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                       <i class="fa fa-star text-white starfontsize" aria-hidden="true"></i>
                                    </button> 
                                 <?php } else { ?>
                                    <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                       <i class="fa fa-star text-dark starfontsize" aria-hidden="true"></i>
                                    </button>   
                                 <?php } ?>

                                 <?php if($comment_value->rating >= 5) { ?>
                                    <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                       <i class="fa fa-star text-white starfontsize" aria-hidden="true"></i>
                                    </button> 
                                 <?php } else { ?>
                                    <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                       <i class="fa fa-star text-dark starfontsize" aria-hidden="true"></i>
                                    </button>   
                                 <?php } ?>
                              </div>
                              <?php
                                if(get_user_review_like($comment_value->id))
                                {
                                   $liked_or_not = 'review-like';
                                } 
                                else
                                {
                                    $liked_or_not = 'review-not-visit';
                                }
                              ?>
                              <div class="like-icon"><i class="fa fa-thumbs-up <?php echo $liked_or_not;?>" id="change-color_<?php echo $comment_value->id; ?>" aria-hidden="true" data-review_id="<?php echo $comment_value->id;?>"></i>
                                    <span class="total-likes">
                                       <?php 
                                       if($comment_value->total_like > 0 && isset($comment_value->total_like)) { 
                                          echo "$comment_value->total_like";
                                       }
                                       ?>
                                    </span>
                              </div>
                              <div class="clearfix"></div>
                              <p><?php echo $comment_value->review_content;?></p>
                           </div>
                        </div>
                        <hr/>
                  <?php } ?>
               </div>
               <?php } ?>            
            </div>
         </div>
      </div>   
   </div>
</div>

<!-- <?php
               $table_row = '';
                  if($product_markets)
                  { 
                     $i = 0;
                     $total_markets = count($product_markets);
                     $market_img_dir = base_url('/assets/images/market_image/');
               ?>      
                  <table class="table">
                     <?php foreach ($product_markets as $product_market_data) 
                        { 
                           $i++;
                          if($i <=2)
                          {
                              $table_row = 'detail-market-main';
                          }
                          else
                          {
                              $table_row = 'bg-white';
                           if($i==4)
                           {
                            $i = 0;  
                           }
                          } 
                           $market_image = $product_market_data->market_logo ? $product_market_data->market_logo : '';
                     ?>
                        <tr class="<?php echo $table_row;?>">
                           <th class="detail-market-image">
                              <?php if ($market_image)
                              { ?>
                                 
                                 <img title="<?php echo $product_market_data->market_title; ?>" alt="<?php echo $product_market_data->market_title; ?>" class="market-image" src="<?php echo $market_img_dir.$market_image;?>" width="50px" height="50px">

                                <?php
                              }
                              else
                              {
                                 echo $product_market_data->market_title;
                              } 
                              ?>
                           </th>
                           <th class="table-product-title"><?php echo $products->product_title;?></th>
                           <th class="kargo">asdfasdf</th>
                           <th class="table-price"><?php echo $product_market_data->sale_price .' '. $currency_code;?></th>
                           <th class="detail-buy-now"><a  target="_blank" href="<?php echo $product_market_data->affiliate_marketing_url;?>"><?php echo lang('Buy Now'); ?></a></th>
                        </tr>

                     <?php  } ?>
                        <tr class="load-main">
                           <th></th>
                           <th></th>
                           <th>
                              <span class="load-more">Show More</span>
                           </th>
                           <th></th>
                           <th></th>
                        </tr>   
                  </table>
            <?php  } ?> -->
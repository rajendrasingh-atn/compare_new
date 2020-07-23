<?php
   $currency =  get_admin_setting('currency_code');
   $currency_code =  get_currency_symbol($currency);
   
   ?>
<div class="container-fluid body_background product_compare_page">
   <div class="container">
      <div class="row">
         <div class="compare_header col-12">
            <h2 class="text-center mt-5 text-primary text-uppercase"><?php echo lang('Compare');?></h2>
              <h4 class="text-center mt-52">
               <?php 
                  $product_total = count($products);
                  $j = 0 ;
                  foreach ($products as  $products_compare) 
                  { $j++;
                    echo "<span class='compareTitle mx-2'>$products_compare->product_title</span>";
                      if ($product_total > $j) 
                      {
                        echo "<span class='text-danger'>vs</span>";
                      }
                  }
                  ?>
            </h4>
         </div>
         <div class="col-md-10 my-4 mx-auto">
            <div class="row">
               <div class="col-lg-12">
                  <div class="row bg-white">
                      <!--                      
                      <div class="col-3 my-auto h-100 ">
                        <div class="text-center width_100 h-100">
                           COMPARE
                        </div>
                     </div> 
                   -->

                     <div class="col-12 box_image_100">
                        <div class="row">
                           <?php
                              $product_count = COUNT($products);
                              $col_md = $product_count == 4 ? 'col-3' : ($product_count == 3 ? 'col-4' : 'col-6');
                              $product_img_dir = base_url('/assets/images/product_image/');
                              foreach ($products as $product_slug => $products_array) 
                              { 
                                $product_lowest_marcket = json_decode($products_array->product_lowest_marcket);
                                $product_url = base_url("product/$products_array->category_slug/$products_array->product_slug");
                                $sale_price = isset($product_lowest_marcket->sale_price) ? $product_lowest_marcket->sale_price : 0.00;
                                $affiliate_marketing_url = isset($product_lowest_marcket->affiliate_marketing_url) ? $product_lowest_marcket->affiliate_marketing_url : '#';
                                $market_title = isset($product_lowest_marcket->market_title) ? $product_lowest_marcket->market_title :'';           
                                $sale = null;
                                $sale_percentaage = null;
                                if($product_lowest_marcket)
                                {
                                  $sale = $product_lowest_marcket->base_price - $product_lowest_marcket->sale_price;
                                  $sale_percentaage = $sale > 0 ? ($sale/$product_lowest_marcket->base_price)*100 : 0;
                                }
                                
                                $product_images = json_decode($products_array->product_image);
                                $product_image = $product_img_dir.'default.png';
                                if(isset($product_images[0]) && $product_images[0])
                                {
                                    // $product_image = $product_img_dir.$product_images[0];
                                    $product_image = get_s3_url('quickcompare/products/'.$product_images[0]);
                                }

                                $product_title = urldecode($products_array->product_title);
                                $product_title = strlen($product_title) > 50 ? substr($product_title,0,50)."..." : $product_title;

                              ?>
                           <div class="<?php echo $col_md; ?> bg-white py-3 border compare_product_box">
                              <span class="ribbon"><?php echo round($sale_percentaage); ?>% <?php echo lang('Off');?></span>
                              <a class="link-text text-center width_100" href="<?php echo $product_url; ?>" target="_parent">
                              <img alt="image" class="img-responsive" src="<?php echo $product_image; ?>">
                              </a>
                              <a class="text-dark text-link small text-center d-flex product_title" title="<?php echo $products_array->product_title; ?>" href="<?php echo $product_url; ?>" target="_parent">
                              <span class="col-12 p-0 mt-3"><?php echo $product_title; ?></span>
                              </a>
                              <hr>
                              <div class="buy_now_section">
                                 <p class="small">
                                    <a class="text-dark h6" target="_blank" href="<?php echo $affiliate_marketing_url; ?>" target="_parent"> <?php echo $currency_code.' '.$sale_price; ?></a><br>
                                    <span> <?php echo lang('Buy From');?></span><br>
                                    <span class=" text-warning text-capitalize"><?php echo $market_title; ?></span>
                                 </p>
                              </div>
                              <a class="buy_now_btn btn btn-warning text-white btn-sm btn-block" target="_blank" href="<?php echo $affiliate_marketing_url; ?>"><?php echo lang('Buy Now');?> </a>
                           </div>
                           <!-- white box end col-3 -->
                           <?php  
                              }
                              ?>
                        </div>
                     </div>
                  </div>
                  <div class="clearfix mt-5"></div>
                  <section class="Product_detail_div">
                     <?php
                        foreach ($products_fields_array as $custom_group_name => $custom_group_val_array) 
                        { ?>
                     <h5 class="bg-info p-2 row text-white mb-0"><?php echo $custom_group_name; ?></h5>
                     <?php
                        foreach ($custom_group_val_array as $field_id => $field_array) 
                        { 
                          ?>
                     <div class="row bg-white border border-secondary">
                        <div class="col-12 my-auto h-100  p-2 mb-2 border-bottom"> 
                           <span class="h-100 h6"><?php echo $products_fields_name_array[$custom_group_name][$field_id]; ?> </span>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-12 my-auto h-100 ">
                           <div class="row child-parent">
                              <?php
                                 foreach ($field_array as $key => $field_value) 
                                 { ?>
                              <div class="<?php echo $col_md; ?>  p-2"> 
                                 <span class="word-break small"><?php echo $field_value; ?></span> 
                              </div>
                              <?php
                                 }
                                 ?>
                           </div>
                        </div>
                     </div>
                     <?php
                        }
                        }
                        ?>
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php
   $currency =  get_admin_setting('currency_code');
   $currency_code =  get_currency_symbol($currency);
   $add_to_compare = in_array($varients->product_slug, $compare_session) ? 'add_to_compare' : '';
   $compare_icon = $add_to_compare ? 'fa-check' : 'fa-plus';
   

   //map data for 90 days
   $price_date_90 =  $price_data_90 = $max_price_90 = array();
   $min_price_90 = $min_price_60 = $min_price_30="";
   
   foreach($price_history_90 as $price_key => $price_value)
   {
      $price_date_90[] = date("d-m-Y", strtotime($price_value->day));
      $price_data_90[] = $price_value->min_price;
      $max_price_90[] = $price_value->min_price;
   }
   //print_r($price_date_90);exit;
   if($price_date_90)
   {

      $min_price_90 = min($price_data_90) - 1000;
      $price_date_90 = json_encode($price_date_90);
      $price_data_90 = json_encode($price_data_90);
   }
   
   if($max_price_90)
   {
      $max_price_90 = max($max_price_90)+100;
   }
   $minimum_price_90 = $min_price_90 > 1000 ? $min_price_90 : 0;

   //map data for 60 days
   $price_date_60 =  $price_data_60 = $max_price_60 = array();
   foreach($price_history_60 as $price_key => $price_value)
   {
      $price_date_60[] = date("d-m-Y", strtotime($price_value->day));
      $price_data_60[] = $price_value->min_price;
      $max_price_60[] = $price_value->min_price;
   }

   if($price_data_60)
   {
      $min_price_60 = min($price_data_60) - 1000;
   }
   $price_date_60 = json_encode($price_date_60);
   $price_data_60 = json_encode($price_data_60);
   
   if($max_price_60)
   {
      $max_price_60 = max($max_price_60)+100;
   }
   $minimum_price_60 = $min_price_60 > 1000 ? $min_price_60 : 0;
   
   // map data for 30 days
   $price_date_30 =  $price_data_30 = $max_price_30 = array();
   foreach($price_history_30 as $price_key => $price_value)
   {

      $price_date_30[] = date("d-m-Y", strtotime($price_value->day));
      $price_data_30[] = $price_value->min_price;
      $max_price_30[] = $price_value->min_price;
   }

   if($price_data_30)
   {
      $min_price_30 = min($price_data_30) - 1000;
   }
   $price_date_30 = json_encode($price_date_30);
   $price_data_30 = json_encode($price_data_30);
   
   if($max_price_30)
   {
      $max_price_30 = max($max_price_30)+100;
   }
   $minimum_price_30 = $min_price_30 > 1000 ? $min_price_30 : 0;
?>

<script type="text/javascript">
  
   //90 days data
   
   var price_date_90 = <?php echo $price_date_90 ? $price_date_90  : 0 ?>; 
   var price_data_90 = <?php echo $price_data_90 ? $price_data_90 : 0 ?>;
   var price_maximum_90 = <?php echo $max_price_90 ? $max_price_90 : 0?>;
   var min_price_90 = <?php echo $minimum_price_90 ? $minimum_price_90  : 0?>;

   //60 days data
   
   var price_date_60 = <?php echo $price_date_60 ? $price_date_60 : 0 ?>; 
   var price_data_60 = <?php echo $price_data_60 ? $price_data_60  : 0?>;
   var min_price_60 = <?php echo $minimum_price_60 ? $minimum_price_60 : 0 ?>;
    var price_maximum_60 = <?php echo $max_price_60 ? $max_price_60  : 0?>;


   //30 days data
   
   var price_date_30 = <?php echo $price_date_30 ? $price_date_30 : 0 ?>; 
   var price_data_30 = <?php echo $price_data_30 ? $price_data_30 : 0 ?>;
   var price_maximum_30 = <?php echo $max_price_30 ? $max_price_30 : 0 ?>;
   var min_price_30 = <?php echo $minimum_price_30 ? $minimum_price_30 : 0 ?>;

</script>

<div class="container-fluid pt-4 detail_page product_compare">
   <div class="container">
      <div class="row ">
         <div class="col-md-12">
            <h6 class="product-breadcrumb mr-1">
               <a href="<?php echo base_url(); ?>"><?php echo 'Home'; ?> </a> 
               <i class="fas fa-arrow-right" aria-hidden="true"></i>
               <a href="<?php echo base_url('search/').$products->category_slug; ?>" class="text-capitalize"><?php echo $varients->category_title; ?> </a> 
               <i class="fas fa-arrow-right" aria-hidden="true"></i>
               <a href="<?php echo base_url('search/').$products->category_slug.'?brands='.$products->brand_slug; ?>">        
                  <span class=" ml-1 text-capitalize"><?php echo $varients->brand_title; ?></span>
               </a>
            </h6>
         </div>
         <div class="col-md-4">
            <div class="product-variation">
               <div class="list-product cursor popup-gallery">
                  <?php 
                     $detail_image = json_decode($varients->product_image,true);
                     $first_image = isset($detail_image[0]) ? $detail_image[0] : "";
                  ?>
                  <a rel="gallery1" href="<?php echo get_s3_url('quickcompare/products/'.$first_image);?>" title="<?php echo $varients->product_title .'_image_1';?> "><img src="<?php echo base_url('assets/images/image-click.jpg');?>" alt="" ></a>
               </div>
               <div class="popup-gallery" style="display: none;">
                  <?php
                     $product_img_dir = base_url('/assets/images/product_image/');
                     unset($detail_image[0]);
                     $i = 2;
                     foreach($detail_image as $detail_key => $detail_value)
                     {
                        $detail_value = $detail_value ? get_s3_url('quickcompare/products/'.$detail_value) : $detail_value.'default.jpg';
                  ?>
                     <a href="<?php echo $detail_value;?>" title="<?php echo $varients->product_title.'_image_'.$i;?>"><img src="<?php echo $detail_value;?>" width="75" height="75"></a>
                  <?php          
                     $i++;}
                  ?>   
               </div>

               <div class="chart-product"><a href="#map-detail"><img src="<?php echo base_url('assets/images/chart-bar.jpg');?>" alt=""></a></div>
               <div class="chart-product"><a href="#detail-custome-field"><img src="<?php echo base_url('assets/images/rating-list.jpg');?>" alt=""></a></div>
            </div>
            <div class="product-detail-single">
              <?php 
                  //echo '<pre>';print_r($products);exit;
                  $product_image_array = json_decode($varients->product_image); 
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
               <div class="price-percentage-main"></div>  
               <?php @$increase_decrease = ($varients->min_price - $varients->alarm_price) * 100 / $varients->min_price; 
                  $increase_decrease = round($increase_decrease);
                  if($varients->alarm_price > $varients->min_price)
                  {
               ?>
                  <div class="detail-price-percentage"><?php echo '%'.$increase_decrease;?> cheaper</div> 
               <?php } ?>   
         </div>
         <?php $fav_icon =  $varients->is_fav ? 'text-danger' : 'text-secondary';  ?>
         <div class="col-md-8">
            <div class="card-body p-3 bg-white">
               <h3 class="product-detail-title mb-3 mt-4"><?php echo $varients->product_title; ?>
                  <?php $totalrating = (isset($count_product_id->Total) && !empty($count_product_id->Total) ? $count_product_id->Total : 0);?>
                  <!-- <a href="#rating-block" class="reviewtotal">(<?php echo $totalrating .' Reviews';?>)</a>
                  <a href="javascript:void(0)" class="add_fav_product_btn small" data-product_id = "<?php echo $products->product_id; ?>"> 
                     <i class="fav_icon fas fa-heart  <?php echo $fav_icon; ?>" data-icon='fav'></i> 
                  </a> -->
                  
               </h3>
               <div class="minimum-price"><?php echo $varients->min_price .' '. $currency_code;?></div>
               <div class="uan"><?php echo $currency_code .' '. $products->min_price .' cheapest';?></div>
               <div class="gitiyor"><img src="<?php echo base_url('assets/images/product_image/giti-com.jpg');?>"> <a href="<?php echo $products->market_url;?>" target="_blank"><?php echo $products->market_url;?></a></div>
               <div class="clearfix"></div>
               <div class="product-detail-like mt-5">
                  <div class="like-button">
                     <a href="javascript:void(0)" class="add_fav_product_btn small" data-product_id = "<?php echo $products->product_id; ?>"> 
                        <i class="fav_icon fas fa-heart  <?php echo $fav_icon; ?>" data-icon='fav'></i>  <span class="pl-2 pr-1">Like The Product</span>
                     </a>
                  </div>
                  <div class="bell-button">
                     <?php $bellicon = (isset($user_alarm_exist) && !empty($user_alarm_exist) ? 'text-success' : 'text-secondary');
                     $user_alarm_data = (isset($get_user_alarm) && !empty($get_user_alarm) ? $get_user_alarm->price : "");
                     ?>
                     <input type="hidden" class="alam-data" value="<?php echo $user_alarm_data;?>" data-variant_id="<?php echo $varients->product_varient_id;?>">
                     <div class="bellicon"><i class="fa fa-bell <?php echo $bellicon;?>" id ="bellactive" aria-hidden="true"></i> <span class="pl-2 pr-1">Price Alarm</span></div>   
                  </div>
                  <div class="diger">
                     <div class="diger-inner">
                        <a href="javascript:void(0)" data-product_category="<?php echo $varients->category_slug ; ?>"  data-product_slug="<?php echo $varients->product_slug ; ?>" class="compare_product_link list_compare_link <?php echo $add_to_compare; ?> <?php echo $varients->product_slug ; ?>">
                              <img src="<?php echo base_url('assets/images/product_image/diger.jpg');?>"> <span class="pl-2 pr-1">Compare with other products</span>
                        </a>      
                     </div>   
                  </div>
               </div>
               <div class="clearfix"></div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="detail-fiyat">
            <div class="fiyat-image"><img src="<?php echo base_url('assets/images/product_image/detail-fiyat.jpg');?>"></div>
         </div>
      </div>
   </div>
</div>

<section class="market-detail">
   <div class="container">
      <div class="row">
         <div class="col-md-12 mb-2">
            <div class="sorting-main">
              <div class="sorting-left">13 guvenilir magazada <span class="sorting-inner">fiyatliri asdjfad</span></div>
              <div class="sorting-right">
                 <span class="sorting-icon"><img src="<?php echo base_url('assets/images/product_image/sort-image.png');?>"></span>
                 <span class="dropdown">
                    <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Dropdown button
                    </div>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="javascript:void(0)" data-price_select="high">Price High</a>
                      <a class="dropdown-item" href="javascript:void(0)" data-price_select="low">Price low</a>
                    </div>
                 </span>
              </div>
            </div>
            <div class="isotope-grid"></div>
            <?php 
               if($product_markets)
               { 
                  $count = 0;
                  $i = 0;
                  $total_markets = count($product_markets);
                  $market_img_dir = base_url('/assets/images/market_image/');
                  foreach ($product_markets as $product_market_data)
                  {
                     $i++;
                     $count++;
                     if($count <= 4)
                     {
                       if($i <=2)
                       {
                           $div_row = 'detail-market-main';
                       }
                       else
                       {
                           $div_row = 'detail-market-main2';
                           if($i==4)
                           {
                            $i = 0;  
                           }
                       }
                     $market_image = $product_market_data->market_logo ? $product_market_data->market_logo : '';  
            ?>
               <div class="<?php echo $div_row;?> grid-item">
                  <span class="detail-market-image">
                     <?php if ($market_image)
                        { 
                     ?>      
                        <img title="<?php echo $product_market_data->market_title; ?>" alt="<?php echo $product_market_data->market_title; ?>" class="market-image" src="<?php echo $market_img_dir.$market_image;?>" width="50px" height="50px">

                     <?php
                     }
                     else
                     {
                        echo $product_market_data->market_title;
                     } 
                     ?>
                  </span>
                  <span class="table-product-title"><?php echo $varients->product_title;?></span>
                  <span class="kargo">aasd</span>
                  <span class="table-price" data-market_price="<?php echo $product_market_data->sale_price;?>"><?php echo $product_market_data->sale_price .' '. $currency_code;?></span>
                  <span class="detail-buy-now"><a  target="_blank" href="<?php echo $product_market_data->affiliate_marketing_url;?>"><?php echo lang('Buy Now'); ?></a></span>
               </div>
            <?php } } } ?>
            
            <div class="collapse" id="collapse_market_field">
               <?php 
                  if($product_markets)
                  { 
                     $count = 0;
                     $i = 0;
                     $total_markets = count($product_markets);
                     $market_img_dir = base_url('/assets/images/market_image/');
                     foreach ($product_markets as $product_market_data)
                     {
                        $i++;
                        $count++;
                        if($count > 4)
                        {
                          if($i <=2)
                          {
                              $div_row = 'detail-market-main';
                          }
                          else
                          {
                              $div_row = 'detail-market-main2';
                              if($i==4)
                              {
                               $i = 0;  
                              }
                          }
                          $market_image = $product_market_data->market_logo ? $product_market_data->market_logo : '';  
               ?>
                  <div class="<?php echo $div_row;?> grid-item">
                     <span class="detail-market-image">
                        <?php if ($market_image)
                           { 
                        ?>      
                           <img title="<?php echo $product_market_data->market_title; ?>" alt="<?php echo $product_market_data->market_title; ?>" class="market-image" src="<?php echo $market_img_dir.$market_image;?>" width="50px" height="50px">

                        <?php
                        }
                        else
                        {
                           echo $product_market_data->market_title;
                        } 
                        ?>
                     </span>
                     <span class="table-product-title"><?php echo $varients->product_title;?></span>
                     <span class="kargo">aasd</span>
                     <span class="table-price" data-market_price="<?php echo $product_market_data->sale_price;?>"><?php echo $product_market_data->sale_price .' '. $currency_code;?></span>
                     <span class="detail-buy-now"><a  target="_blank" href="<?php echo $product_market_data->affiliate_marketing_url;?>"><?php echo lang('Buy Now'); ?></a></span>
                  </div>
               <?php } } }?>
            </div>
            <?php if(isset($total_markets) && $total_markets > 4)
               {
            ?>
               <div class="load-more-main">
                  <a class="load-more" data-toggle="collapse" href="#collapse_market_field" role="button" aria-expanded="true" aria-controls="collapse_market_field">Show More</a>
               </div>
            <?php  } ?>   
         </div>
         <?php
            $count_price_30 = count($price_history_30); 
            if($count_price_30 >= 1)
            { 
         ?>
            <div class="col-md-12">
               <div class="map-main" id="map-detail">
                  <div class="detail-map-left">
                       <h4>Fiyat Analizi</h4>
                       <span>Gun aisduasdas asdhfajsdfoaiuw fjfhfiufjhfjk fia</span>
                   </div>
                   <div class="detail-map-right mt-3">
                       <ul class="nav nav-pills pills-border" id="pills-tab" role="tablist">
                         <li class="nav-item">
                           <a class="nav-link" id="days30-tab" data-toggle="pill" href="#days30" role="tab" aria-controls="days-30" aria-selected="false">30 Days</a>
                         </li>
                         <li class="nav-item">
                           <a class="nav-link" id="days60-tab" data-toggle="pill" href="#days60" role="tab" aria-controls="days-60" aria-selected="false">60 Days</a>
                         </li>
                         <li class="nav-item">
                           <a class="nav-link active" id="days90-tab" data-toggle="pill" href="#days90" role="tab" aria-controls="days-90" aria-selected="true">90 Days</a>
                         </li>
                       </ul>
                   </div>
                   <div class="clearfix"></div>

                   <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade" id="days30" role="tabpanel" aria-labelledby="days30-tab">
                           <?php  if($price_history_30) { ?>
                              <canvas id="thirty_days" class="chartjs-render-monitor"></canvas>
                           <?php  } ?>
                        </div>
                        <div class="tab-pane fade" id="days60" role="tabpanel" aria-labelledby="days60-tab">
                           <?php  if($price_history_60){ ?>
                             <canvas id="sixty_days" class="chartjs-render-monitor"></canvas>
                           <?php  } ?>
                        </div>
                        <div class="tab-pane fade show active" id="days90" role="tabpanel" aria-labelledby="days90-tab">
                          <?php if($price_history_90){ ?>
                             <canvas id="ninty_days" class="chartjs-render-monitor"></canvas>
                          <?php  } ?>
                        </div>
                   </div>
               </div>
            </div>
         <?php } ?>
         <div class="col-md-12">
            <div class="map-main" id="detail-custome-field">
               <div class="product-description"><?php echo lang('front Product');?> <?php echo lang('front Details');?> <span><?php echo $varients->category_title ." " .$varients->product_title . " " .$varients->product_description; ?> </span></div>
               <?php 
                  $i = 0;
                  $product_field_group_array = json_decode($varients->product_full_detail);
                  foreach ($product_field_group_array as $custom_field_group => $custom_field_array) 
                  { 
                     $i++;
                     if($i<=2) 
                     {
               ?>
                  <div class="custom-table-main">
                    <div class="custom-group"><?php echo $custom_field_group;?></div>
                    <table class="table table-striped">
                       <tbody>
                        <?php
                           
                           foreach ($custom_field_array as $custom_field_name => $custom_field_data) 
                           { 
                              $field_filter_val = $custom_field_data->value ? $custom_field_data->value : NULL;
                              if($field_filter_val)
                              {
                        ?>
                            <tr>
                              <td class="custom-field"><?php echo $custom_field_name;?></td>
                              <td><?php echo $field_filter_val;?></td>
                            </tr>
                        <?php } }?> 
                       </tbody>
                     </table>
                  </div>
               <?php } } ?>
               <div class="collapse" id="collapse_custom_field">
                  <?php 
                     $i = 0;
                     $product_field_group_array = json_decode($varients->product_full_detail);
                     foreach ($product_field_group_array as $custom_field_group => $custom_field_array) 
                     { 
                        $i++;
                        if($i>2) 
                        {
                  ?>
                     <div class="custom-table-main">
                        <div class="custom-group"><?php echo $custom_field_group;?></div>
                        <table class="table table-striped">
                          <tbody>
                           <?php
                              
                              foreach ($custom_field_array as $custom_field_name => $custom_field_data) 
                              { 
                                 $field_filter_val = $custom_field_data->value ? $custom_field_data->value : NULL;
                                 if($field_filter_val)
                                 {
                           ?>
                               <tr>
                                 <td class="custom-field"><?php echo $custom_field_name;?></td>
                                 <td><?php echo $field_filter_val;?></td>
                               </tr>
                           <?php } }?> 
                          </tbody>
                        </table>
                     </div>
                  <?php } } ?>     
               </div>
               <?php if($i>2) { ?>
                  <div class="detail-show-more">
                     <a class="show-inner" data-toggle="collapse" href="#collapse_custom_field" role="button" aria-expanded="true" aria-controls="collapse_custom_field">Show More</a>
                  </div>
               <?php } ?>   
            </div>
         </div>

         <div class="col-md-12">
            <div class="rating-main" id="detail-rating">
               <div class="average-rating-main">
                  <div class="row">
                     <div class="col-md-6">
                        <?php 
                           $average_rating = (isset($average) && !empty($average) ? round($average) : 0); 
                        ?>
                        <div class="average-text">Average Rating</div>
                        <div class="averate-number-main">
                           <div class="total-average"><?php echo $average_rating;?></div>
                           <div class="average-star">
                              <?php if($average_rating >= 1) { ?>
                                 <span><i class="fa fa-star fill-star" aria-hidden="true"></i></span>
                              <?php } else { ?>
                                 <span><i class="far fa-star empty-star" aria-hidden="true"></i></span>
                              <?php }  if($average_rating >= 2) { ?>   
                                 <span><i class="fa fa-star fill-star" aria-hidden="true"></i></span>
                              <?php } else { ?>   
                                 <span><i class="far fa-star empty-star" aria-hidden="true"></i></span>
                              <?php } if($average_rating >= 3) { ?>   
                                 <span><i class="fa fa-star fill-star" aria-hidden="true"></i></span>
                              <?php } else { ?>   
                                 <span><i class="far fa-star empty-star" aria-hidden="true"></i></span>
                              <?php } if($average_rating >= 4) { ?>      
                                 <span><i class="fa fa-star fill-star" aria-hidden="true"></i></span>
                              <?php } else { ?>   
                                 <span><i class="far fa-star empty-star" aria-hidden="true"></i></span>
                              <?php } if($average_rating >= 5) { ?>      
                                 <span><i class="fa fa-star fill-star" aria-hidden="true"></i></span>
                              <?php } else { ?>   
                                 <span><i class="far fa-star empty-star" aria-hidden="true"></i></span>   
                              <?php  } ?>   
                              <div class="evaluation">434 Degerlendirme</div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="yorum">
                           <?php $totalrating = (isset($count_product_id->Total) && !empty($count_product_id->Total) ? $count_product_id->Total : 0);
                           //print_r($totalrating);exit;
                           ?>
                           <span><i class="far fa-comment-alt"></i> <?php echo $totalrating;?> Comment</span>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="share">
                           <span>Share</span>
                           <span><a href="//www.facebook.com/sharer.php?u=<?php echo base_url('product/').$varients->category_slug.'/'.$varients->product_slug; ?>"  target="_blank"><i class="fab fa-facebook-f"></i></a></span>
                           <span><a href="//social-plugins.line.me/lineit/share?url=<?php echo base_url('product/').$varients->category_slug.'/'.$varients->product_slug; ?>&to=<?php echo str_replace(' ', '', get_admin_setting('site_phone_number')); ?>"  target="_blank"><i class="fab fa-line"></i></a></span>
                           <span><a href="//twitter.com/share?text=<?php echo str_replace(' ', '+', $varients->product_title); ?>&url=<?php echo base_url('product/').$varients->category_slug.'/'.$varients->product_slug; ?>" target="_blank"><i class="fab fa-twitter"></i></a></span>
                           <span><a href="tg://msg?text=Checkout: <?php echo str_replace(' ', '+', $varients->product_title); ?> on <?php echo base_url('product/').$varients->category_slug.'/'.$varients->product_slug; ?>&to=<?php echo str_replace(' ', '', get_admin_setting('site_phone_number')); ?>" target="_blank"><i class="fab fa-telegram-plane"></i></a></span>
                           <span><a href="//web.whatsapp.com/send?phone=<?php echo str_replace(' ', '', get_admin_setting('site_phone_number')); ?>&amp;text=Checkout: <?php echo str_replace(' ', '+', $varients->product_title); ?> on <?php echo base_url('product/').$varients->category_slug.'/'.$varients->product_slug; ?>" target="_blank"><i class="fab fa-whatsapp"></i></a></span>
                        </div>
                     </div>
                  </div>
               </div>
               <?php if(empty($comments_exist_with_productid_userid)) 
                  {
               ?>
                  <div class="save-rating-main">
                     <form id="sellerform" method="POST" enctype='multipart/form-data' action="<?php echo base_url('')."rating/submit_rating";?>">
                        <input type="hidden" name="variantid" class="variantid" value="<?php echo $varients->product_varient_id?>">
                        <div class="row">
                           <div class="col-md-5 pt-3">
                              <div class="averate-number-main">
                                 <div class="total-save-rating">0.0</div>
                                 <div class="form-group" id="rating-ability-wrapper">
                                    <input type="hidden" id="selected_rating" name="selected_rating" value="" required="required">
                                    <div class="average-star">
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
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-7">
                              <div class="save-message">
                                 <textarea class="form-control save-heading" name="ratingcontent" placeholder="Wrtie your comment here"></textarea>
                                 <input type="hidden" class="rate" name="reviewstar" value="">
                                 <input type="submit" name="save" value="Save" class="save-rating-btn btn-lg">
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               <?php } ?>   
            </div>
            <?php   
               $count = 0;
               foreach($product_comments as $comment_key => $comment_value)
               {
                $count ++;
            ?>
               <div class="comment-list">
                  <div class="row">
                     <div class="col-md-1">
                        <?php $userimage = (isset($comment_value->image) && !empty($comment_value->image) ? base_url('/assets/images/user_image/'.$comment_value->image) : base_url('assets/images/user_image/avatar-1.png'));?>
                        <div class="user-image"><img src="<?php echo $userimage;?>"></div>
                     </div>
                     <div class="col-md-2">
                        <div class="user-name"><?php echo $comment_value->first_name. ' ' .$comment_value->last_name;?></div>
                        <div class="comment-date"><?php echo date('d.m.Y H:i', strtotime($comment_value->added));?></div>
                     </div>
                     <div class="col-md-3">
                        <div class="averate-number-main">
                           <div class="user-rating"><?php echo $comment_value->rating.'.0';?></div>
                           <div class="average-star">
                              <?php if($comment_value->rating >= 1) { ?>
                                 <span><i class="fa fa-star fill-star" aria-hidden="true"></i></span>
                              <?php } else { ?> 
                                 <span><i class="far fa-star empty-star" aria-hidden="true"></i></span>
                              <?php } if($comment_value->rating >= 2) { ?>    
                                 <span><i class="fa fa-star fill-star" aria-hidden="true"></i></span>
                              <?php } else { ?>   
                                 <span><i class="far fa-star empty-star" aria-hidden="true"></i></span>
                              <?php } if($comment_value->rating >= 3) {  ?>   
                                 <span><i class="fa fa-star fill-star" aria-hidden="true"></i></span>
                              <?php } else { ?>   
                                 <span><i class="far fa-star empty-star" aria-hidden="true"></i></span>
                              <?php } if($comment_value->rating >= 4) { ?>
                                 <span><i class="fa fa-star fill-star" aria-hidden="true"></i></span>
                              <?php } else { ?>   
                                 <span><i class="far fa-star empty-star" aria-hidden="true"></i></span>
                              <?php } if($comment_value->rating >= 5) { ?>
                                 <span><i class="fa fa-star fill-star" aria-hidden="true"></i></span>
                              <?php } else { ?>   
                                 <span><i class="far fa-star empty-star" aria-hidden="true"></i></span>
                              <?php } ?>         
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                         <div class="comment-text"><p><?php echo $comment_value->review_content;?></p></div>
                         <div class="do-you-sure">Bu yorumu faydali buluyor musunuz?</div>
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
                         <div class="evet like-icon"><i class="fa fa-thumbs-up <?php echo $liked_or_not;?>" id="change-color_<?php echo $comment_value->id; ?>" aria-hidden="true" data-review_id="<?php echo $comment_value->id;?>"></i> 
                           <span class="total-likes">
                              <?php 
                                 if($comment_value->total_like > 0 && isset($comment_value->total_like)) { 
                                    echo '('."$comment_value->total_like".')';
                                 }
                              ?>
                           </span>
                         </div>
                     </div>
                  </div>
               </div>      
            <?php } 
               $last_id = isset($comment_value->id) ? $comment_value->id : 0;
               if($count >= 9) {
            ?>
               <div class="more-comments"></div>
               <div class="detail-show-more bg-white pb-1">
                 <div class="detail-loader"><img src="<?php echo base_url('assets/themes/default/css/ajax-loader.gif');?>"></div>
                 <input type="hidden" name="last-id" class="last-id" value="<?php echo $last_id;?>">
                 <div class="show-inner show-more-comment">Show More</div>
               </div>
            <?php } ?>   
         </div>
      </div>
   </div>
</section>

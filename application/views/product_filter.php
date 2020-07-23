<?php
   $currency =  get_admin_setting('currency_code');
   $currency_code =  get_currency_symbol($currency);
   ?>
<div class="container-fluid filter_listing product_compare" >
   <input type="hidden" name="base_url" value="<?php echo base_url(); ?>" id="base_url">
   <div class="container container-pad" id="product-listings">
      <div class="row ">
         <div class="col-md-3 col-sm-12">
            <div class="width_100 bg-white py-2">
               <h6 class="px-4 py-1"><?php echo lang('Refine results'); ?><a href="" class="ml-5 link-text small" id="clear_all"><?php echo lang('Clear All'); ?></a></h6>
            </div>
         </div>
         <div class="col-md-9 col-sm-12">
            <div class="width_100 bg-white py-2">
               <p class="float-left p-1 my-auto"> <span class="h5 px-3"><?php echo $count_products; ?></span> <?php echo lang('Products Found'); ?>  </p>
               <div class="form-group my-auto float-right">
                  <div class="selectgroup selectgroup-pills">
                     <label class="selectgroup-item my-auto">
                     <input type="radio" name="icon-input" value="1" class="selectgroup-input listing_type_list" checked="">
                     <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-th-list"></i></span>
                     </label>
                     <label class="selectgroup-item my-auto">
                     <input type="radio" name="icon-input" value="2" class="selectgroup-input listing_type_gride">
                     <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-th-large"></i></span>
                     </label>
                  </div>
               </div>
               <select class="products_sorting d-none">
                  <option value=""><?php echo lang('Sort by'); ?></option>
                  <option value="Price"> <?php echo lang('Price'); ?> </option>
                  <option value="Recent"> <?php echo lang('New Products'); ?></option>
               </select>
            </div>
         </div>
         <!-- end col-9 -->
      </div>
      <div class="clearfix mb-3"></div>
      <div class="row">
         <div class="col-sm-3 col-md-3">
            <section class="bg-white p-2 h-auto">
               <div class="form-group">
                  <label class="form-label "><?php echo lang('Price Category'); ?></label>
                  <select class="form-control search-slt select2" name='category_name' id="category_name">
                     <option value=""><?php echo lang('Select Category'); ?></option>
                     <?php foreach ($category_data as $category_array) 
                        {
                        	$selected = $category_array->category_slug == $category_slug ? 'selected' : ''; 
                           echo "<option ".$selected." value='".$category_array->category_slug."'>".$category_array->category_title."</option>";
                        } ?>
                  </select>
               </div>
               <label class="form-label "><?php echo lang('Price Range'); ?></label>
               <div class="range-slider">
                  <input value="<?php echo $price_from ? $price_from : 1; ?>" min="1" max="999999" step="10" type="range"/>
                  <input value="<?php echo $price_to ? $price_to : 999999;?>" min="1" max="999999" step="10" type="range"/>
                  <svg width="100%" height="24">
                     <line x1="4" y1="0" x2="300" y2="0" stroke="#444" stroke-width="12" stroke-dasharray="1 28"></line>
                  </svg>
                  <input class="form-control float-left mr-2 small price_from width_36" type="number" value="<?php echo $price_from ? $price_from : 1; ?>" min="1" max="999999"/>
                  <input class="form-control float-left small price_to width_36"  type="number" value="<?php echo $price_to ? $price_to : 999999;?>" min="1" max="999999"/>
                  <a class="btn btn-light float-right filter_by_price width_20" href="#"><?php echo lang('Go'); ?></a>
               </div>
               <div class="form-group mt-3">
                  <label class="form-label "><?php echo lang('Brand'); ?></label>
                  <select class="form-control search-slt selectpicker product_brnad" name='Brand' id="product_brnad" multiple  data-live-search="true">
                     <option disabled  value=""><?php echo lang('Select Brand'); ?></option>
                     <?php foreach ($all_brands as $brands_array) 
                        {
                        
                        	$selected = in_array($brands_array->brand_slug, $brands_filter) ? 'selected':'';
                           	echo "<option $selected value='".$brands_array->brand_slug."'>".$brands_array->brand_title."</option>";
                        } ?>
                  </select>
               </div>
               <div class="form-group">
                  <label class="form-label "><?php echo lang('Market'); ?></label>
                  <select class="form-control search-slt selectpicker product_markets" name='Market' id="product_markets" multiple>
                     <option disabled  value="">Select Market</option>
                     <?php foreach ($all_markets as $markets_array) 
                        {
                        	$selected = in_array($markets_array->market_slug, $markets_filter) ? 'selected':'';
                           	echo "<option $selected value='".$markets_array->market_slug."'>".$markets_array->market_title."</option>";
                        } ?>
                  </select>
               </div>
               <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <?php 
                     $i = 0;
                     	foreach ($product_filter_array as $custom_field_group => $custom_field_array) 
                     	{ 
                     		$i++;
                     		?>
                  <div class="panel panel-default">
                     <div class="panel-heading" role="tab" id="heading_<?php echo $i;?>">
                        <h4 class="panel-title">
                           <a role="button" class="p-2" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $i;?>" aria-expanded="true" aria-controls="collapse_<?php echo $i;?>">
                           <?php echo $custom_field_group; ?>
                           <i class="fas fa-chevron-down float-right"></i></a>
                        </h4>
                     </div>
                     <hr>
                     <div id="collapse_<?php echo $i;?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_<?php echo $i;?>">
                        <?php
                           foreach ($custom_field_array as $custom_field_slug => $custom_field_data) 
                                         		{ 
                                         			$field_filter_val = NULL;
                                         			if(isset($field_filter_request[$custom_field_slug]->field_value))
                                         			{
                                         				$field_filter_val = $field_filter_request[$custom_field_slug]->field_value;
                                         			}
                           
                                          		if($custom_field_data->is_numeric==1)
                                          		{ 
                                          			echo"<span class='p-2 mt-2'> $custom_field_data->field_name</span>";
                                          			$field_filter_val_array = explode('-', $field_filter_val);
                                          			
                                          			$range_from = isset($field_filter_val_array[0]) ? $field_filter_val_array[0] : NULL;
                                      						$range_to = isset($field_filter_val_array[1]) ? $field_filter_val_array[1] : NULL;
                           
                                          		?>
                        <div class="panel-body p-2">
                           <div class="row p-2 field_range">
                              <input class="form-control float-left mr-2 small range_from width_35" type="number" value="<?php echo $range_from ?>" min="1" max="9999"/>
                              <input class="form-control float-left small range_to width_35" type="number" value="<?php echo $range_to ?>" min="1" max="9999"/>
                              <a class="btn btn-light float-right field_range_btn ml-2 width_20" data-field_slug="<?php echo $custom_field_slug ?>" href="#"><?php echo lang('Go'); ?></a>
                           </div>
                        </div>
                        <?php 
                           }
                           elseif($custom_field_data->custom_input_type=='dropdown' && $custom_field_data->is_numeric == 0)
                                         		{ 
                                         			echo"<span class='p-2 mt-2'> $custom_field_data->field_name</span>";
                                         		?>
                        <div class="panel-body filter_page_select2 p-2">
                           <div class="row p-2">
                              <select class="form-control field_dropdown select2" data-field_slug="<?php echo $custom_field_slug ?>">
                                 <option value=''><?php echo lang('Select One'); ?></option>
                                 <?php 
                                    $options_array = json_decode($custom_field_data->options);
                                    foreach ($options_array as $key => $value) { 
                                    	$selected = $field_filter_val==$value ? 'selected' : '';
                                    	?>
                                 <option <?php echo $selected; ?> ><?php echo $value; ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                        </div>
                        <?php 
                           } 
                           elseif($custom_field_data->custom_input_type=='text' && $custom_field_data->is_numeric == 0)
                                         		{ 
                                         			echo"<span class='p-2 mt-2'> $custom_field_data->field_name</span>";
                                         		?>
                        <div class="panel-body p-2">
                           <div class="row p-2 input_text_field">
                              <input class="form-control float-left mr-2 small input_text width_76" placeholder="<?php echo $custom_field_data->field_name ?>" type="text" value="<?php echo $field_filter_val ?>" />
                              <a class="btn btn-light float-right field_text width_20" href="#" data-field_slug="<?php echo $custom_field_slug ?>" ><?php echo lang('Go'); ?></a>
                           </div>
                        </div>
                        <?php 
                           } 
                           elseif($custom_field_data->custom_input_type=='checkbox')
                                         		{ 
                                         			echo"<span class='p-2 mt-2'> $custom_field_data->field_name</span>";
                                         		?>
                        <div class="panel-body p-2">
                           <div class="row p-2">
                              <div class="form-group mb-0">
                                 <?php 
                                    $options_array = json_decode($custom_field_data->options);
                                    foreach ($options_array as $key => $value) { 
                                    	$field_filter_val_array = explode(',',$field_filter_val);
                                    	$checked = in_array($value, $field_filter_val_array) ? 'checked':'';
                                    	?>
                                 <div class="form-check pl-1 mb-2">
                                    <input class="form-check-input field_checkbox" data-field_slug="<?php echo $custom_field_slug ?>" name="<?php echo $custom_field_slug ?>" value="<?php echo $value; ?>" type="checkbox" <?php echo $checked ?> >
                                    <label class="form-check-label text-secondary">
                                    <?php echo $value; ?>
                                    </label>
                                 </div>
                                 <?php } ?>
                              </div>
                           </div>
                        </div>
                        <?php 
                           } 
                           elseif($custom_field_data->custom_input_type=='radio')
                                         		{ 
                                         			echo"<span class='p-2 mt-2'> $custom_field_data->field_name</span>";
                                         		?>
                        <div class="panel-body p-2">
                           <div class="form-group">
                              <div class="custom-switches-stacked mt-2">
                                 <?php 
                                    $options_array = json_decode($custom_field_data->options);
                                    foreach ($options_array as $key => $value) { 
                                    	$checked = $field_filter_val==$value ? 'checked' : '';
                                    	?>
                                 <label class="custom-switch">
                                 <input type="radio" name="<?php echo $custom_field_slug ?>" value="<?php echo $value; ?>" data-field_slug="<?php echo $custom_field_slug ?>" class="custom-switch-input field_radio" <?php echo $checked ?> >
                                 <span class="custom-switch-indicator"></span>
                                 <span class="custom-switch-description"><?php echo $value; ?></span>
                                 </label>
                                 <?php } ?>
                              </div>
                           </div>
                        </div>
                        <?php 
                           }  
                                        		} ?>
                     </div>
                  </div>
                  <?php
                     } ?>
               </div>
            </section>
         </div>
         <div class="col-sm-9 col-md-9">
            <?php if($this->input->get()){ ?>
            <div class="width_100 bg-white py-2">
               <div class="selected_filters filter new-mobile">
                  <div id="filter_list">
                     <ul class="group" data-heading="Price Range">
                        <?php foreach ($this->input->get() as $request_name => $request_val) 
                           { 
                           	?>
                        <li data-val="<?php echo $request_val; ?>">
                           <span><?php echo $request_name.' : '.$request_val; ?> 
                           <a class="remove_url_paramiter" href="#" data-url_paramiter='<?php echo $request_name;?>'>
                           <i class="fas fa-times text-danger"></i>
                           </a>
                           </span>
                        </li>
                        <?php 
                           } ?>
                     </ul>
                  </div>
               </div>
            </div>
            <?php } ?>
            <section class="list width_100">
               <div class="row " >
                  <?php
                     if($products)
                     {
                        $product_img_dir = base_url('/assets/images/product_image/');
                        foreach ($products as $products_array) 
                        {
                           //echo '<pre>';print_r($products_array);exit;
                        	$product_lowest_marcket = json_decode($products_array->product_lowest_marcket);
                        	$product_url = base_url("product/$products_array->category_slug/$products_array->product_slug");
                        	$sale_price = isset($product_lowest_marcket->sale_price) ? $product_lowest_marcket->sale_price : 0.00;			                	$sale = null;
                        	$sale_percentaage = null;
                        	if($product_lowest_marcket)
                        	{
                        		$sale = $product_lowest_marcket->base_price - $product_lowest_marcket->sale_price;
                         	 $sale_percentaage = $sale > 0 ? ($sale/$product_lowest_marcket->base_price)*100 : 0;
                        	}
                         
                         $product_images = json_decode($products_array->product_image,true);
                         $product_image = $product_img_dir.'default.png';
                         if(isset($product_images[0]) && $product_images[0])
                         {
                             // $product_image = $product_img_dir.$product_images[0];
                             $product_image = get_s3_url('quickcompare/products/'.$product_images[0]);
                         }
                         $fav_icon =  $products_array->is_fav ? 'text-danger' : 'text-secondary';
                     	?>

                     <?php
                      $add_to_compare = in_array($products_array->product_slug, $compare_session) ? 'add_to_compare' : '';
                      $compare_icon = $add_to_compare ? 'fa-check' : 'fa-plus';
                      ?>

                  <div class="col-12">

                     <div class="brdr bgc-fff pad-10 box-shad btm-mrg-20 product-listing">
                        <div class="media row">

                           <div class="product_img_block col-md-3 col-sm-12" >
                              <a href="javascript:void(0)" class="add_fav_product_btn" data-product_id = "<?php echo $products_array->product_id; ?>"> 
                              <i class="fav_icon fas fa-heart  <?php echo $fav_icon; ?>" data-icon='fav'></i>
                              </a>

                              <span class="ribbon"><?php echo round($sale_percentaage) ?>% <?php echo lang('Off'); ?></span>
                              <a class="float-left m-auto width_100" href="<?php echo $product_url;?>" target="_parent">
                              <img alt="image" class="img-responsive width_100 m-auto" src="<?php echo $product_image?>"/>
                              </a>

                             <a href="javascript:void(0)" data-product_category="<?php echo $products_array->category_slug ; ?>"  data-product_slug="<?php echo $products_array->product_slug ; ?>" class="compare_product_link list_compare_link link-text <?php if(isset($add_to_compare)) echo $add_to_compare; ?> <?php echo $products_array->product_slug ; ?>"> <i class="fas <?php if(isset($compare_icon)) echo $compare_icon; ?> small"></i> <?php echo lang('product compare btn'); ?></a>
                           </div>


                           <div class="media-body fnt-smaller product_detail_block table-responsive col-md-9 col-sm-12">
                              <div class="row">
                                 <div class="col-12">
                                    <h4 class="media-heading">
                                       <a href="<?php echo $product_url;?>" target="_parent">
                                        <?php echo (strlen($products_array->product_title) > 43) ? substr($products_array->product_title, 0, 40).'...' : $products_array->product_title ?> 
                                       <small class="float-right h6"> <?php echo $currency_code.' '.$sale_price; ?></small>
                                       </a>
                                    </h4>
                                 </div>
                                 <div class="col-12">
                                 <table class="specsTable table-responsive">
                                    <tbody>
                                       <tr>
                                          <?php 
                                             $product_short_detail =$products_array->product_short_detail ? $products_array->product_short_detail : '[]';
                                             $product_short_detail_arr = json_decode($product_short_detail);
                                             
                                             foreach ($product_short_detail_arr as $field_group_name => $custom_field_array) 
                                             { ?>
                                          <td class="specstd">
                                             <ul class="specs_ul">
                                                <li>
                                                   <div class="hd_tlt spcedHead"><?php echo $field_group_name; ?>
                                                   </div>
                                                   <?php
                                                      foreach ($custom_field_array as $custom_field_name => $custom_field_value) 
                                                      { 
                                                      	?>
                                                   <label class="specs_txt positive_value" title="<?php echo $custom_field_value->value; ?>"><?php echo $custom_field_name.' : - '.$custom_field_value->value; ?></label> 
                                                   <?php
                                                      }
                                                      
                                                      ?>
                                                </li>
                                             </ul>
                                          </td>
                                          <?php
                                             }
                                             ?>
                                       </tr>
                                    </tbody>
                                 </table>
                                 <span class="fnt-smaller fnt-lighter fnt-arial"><?php echo substr(strip_tags($products_array->product_description),0, 250); ?>...</span>
                              </div>
                              
                              </div>
                           </div>

                        </div>
                     </div>
                     <!-- End Listing-->
                  </div>
                  <!-- col-12-end -->
                  <div class="clearfix"></div>
                  <?php 	
                     }
                     }
                     else
                     {
                     echo '<div class="col-md-3"></div><div class="col-md-9 text-left py-5"> Sorry No Product Found </div>';
                     }
                     ?>
               </div>
               <!-- End List row -->
            </section>
            <!-- End section row -->
            <section class="gride width_100 display-none">
               <div class="row ">
                  <?php
                     if($products)
                     {
                                  $product_img_dir = base_url('/assets/images/product_image/');
                                  foreach ($products as $products_array) 
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
                     
                                   
                                   $product_images = json_decode($products_array->product_image,true);
                                   $product_image = $product_img_dir.'default.png';
                                   if(isset($product_images[0]) && $product_images[0])
                                   {
                                       $product_image = $product_img_dir.$product_images[0];
                                   }
                                   $fav_icon =  $products_array->is_fav ? 'text-danger' : 'text-secondary';
                               	?>
                  <div class="col-4 mb-4">
                     <div class="col-12 bg-white py-3 border">
                        <span class="ribbon"><?php echo round($sale_percentaage) ?>% off</span>
                        <a href="javascript:void(0)" class="add_fav_product_btn" data-product_id = "<?php echo $products_array->product_id; ?>"> 
                        <i class="fav_icon fas fa-heart  <?php echo $fav_icon; ?>" data-icon='fav'></i>
                        </a>
                        <a class="link-text" href="<?php echo $product_url;?>" target="_parent">
                        <img alt="image" class="img-responsive" src="<?php echo $product_image?>"/>
                        </a>
                        <h6 class="mt-3">
                           <a class="text-dark" href="<?php echo $product_url;?>" target="_parent"><?php echo $products_array->product_title?></a>
                        </h6>
                        <hr>
                        <div class="buy_now_section">
                           <p class="small">
                              <a class="text-dark h6" target="_blank" href="<?php echo $affiliate_marketing_url;?>"> <?php echo $currency_code.' '.$sale_price;?></a><br>
                              <span>Buy From </span><br>
                              <span class=" text-warning text-capitalize"><?php echo $market_title?></span>
                           </p>
                           <a class="buy_now_btn btn btn-warning text-white btn-sm" target="_blank" href="<?php echo $affiliate_marketing_url;?>"><?php echo lang('Buy Now'); ?> </a>
                        </div>
                     </div>
                     <!-- white box end -->
                     <?php
                        $add_to_compare = in_array($products_array->product_slug, $compare_session) ? 'add_to_compare' : '';
                         $compare_icon = $add_to_compare ? 'fa-check' : 'fa-plus';
                        ?>
                     <a href="javascript:void(0)" data-product_category="<?php echo $products_array->category_slug ; ?>"  data-product_slug="<?php echo $products_array->product_slug ; ?>" class=" text-uppercase btn btn-block btn-light compare_product_link list_compare_link <?php echo $add_to_compare; ?> <?php echo $products_array->product_slug ; ?> "> <i class="fas <?php echo $compare_icon; ?> small"></i> <?php echo lang('product compare btn'); ?></a>
                  </div>
                  <!-- col-4-end -->
                  <div class="clearfix"></div>
                  <?php 	
                     }
                     }
                     else
                     {
                     echo '<div class="col-3"></div><div class="col-9 text-left py-5"> '.lang('Sorry No Product Found').' </div>';
                     }
                     ?>
               </div>
               <!-- Gride row End -->
            </section>
            <!-- Gride section End -->
         </div>
         <!-- End Col -->
         <div class="col-12">
            <div class=" float-right">            		
               <?php echo $page_links; ?>
            </div>
         </div>
      </div>
      <!-- End row -->
   </div>
   <!-- End container -->
</div>
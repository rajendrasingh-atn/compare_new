<?php
   $currency =  get_admin_setting('currency_code');
   $currency_code =  get_currency_symbol($currency);
   ?>
<div class="row">
   <?php
      if($products)
      {
                       
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
          ?>
   <div class="col-12 bg-white py-3 border">
      <span class="ribbon"><?php echo round($sale_percentaage); ?>% <?php echo lang('Off');?></span>
      <a data-product_category="<?php echo $products_array->category_slug ; ?>"  data-product_slug="<?php echo $products_array->product_slug; ?>" class="remove_from_compare btn btn-link " href="javascript:void(0)"> 
      <i class="far fa-times-circle"></i>
      </a>
      <a class="link-text text-center width_100" href="<?php echo $product_url; ?>" target="_parent">
      <img alt="image" class="img-responsive" src="<?php echo $product_image; ?>">
      </a>
      <a class="text-dark text-link small text-center d-flex" title="<?php echo $products_array->product_title; ?>" href="<?php echo $product_url; ?>" target="_parent">
      <span class="col-12 p-0 mt-3"><?php echo substr(strip_tags($products_array->product_title),0, 30); ?></span>
      </a>
      <hr>
      <div class="buy_now_section">
         <p class="small">
            <a class="text-dark h6" target="_blank" href="<?php echo $affiliate_marketing_url; ?>" target="_parent"><?php echo $currency_code.' '.$sale_price; ?></a><br>
            <span><?php echo lang('Buy From');?> </span><br>
            <span class=" text-warning text-capitalize"><?php echo $market_title; ?></span>
         </p>
      </div>
      <a class="buy_now_btn btn btn-warning text-white btn-sm btn-block" target="_blank" href="<?php echo $affiliate_marketing_url; ?>"><?php echo lang('Buy Now');?> </a>
   </div>
   <!-- white box end col-12 -->
   <?php  
      } ?>
   <a class="btn btn-primary btn-sm btn-block mt-3" href="<?php echo $compare_url; ?>"><?php echo lang('Compare Now');?> </a>
   <?php
      }
      else
      { ?>
   <div class="col-12"> <?php echo lang('Sorry No Product Found  For Compare');?> </div>
   <?php
      } ?>
</div>
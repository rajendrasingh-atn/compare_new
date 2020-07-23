<?php defined('BASEPATH') OR exit('No direct script access allowed');//echo '<pre>'; print_r($product_view_month);exit;?>
<?php // p($total_visits); ?>
<script type="text/javascript">
   var product_view_month = <?php echo $product_view_month; ?>;
   var product_visits_array = <?php echo $product_visits_array; ?>;
   var total_visits = <?php echo $total_visits; ?>;
   console.log(product_view_month);
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/themes/admin/css/linechart.css'); ?>">

<script src="<?php echo base_url(); ?>/assets/themes/admin/js/analytics.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>/assets/themes/admin/js/Chart.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>/assets/themes/admin/js/utils.js" type="text/javascript" ></script>


<div class="row">
   <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
         <div class="card-icon bg-primary"><i class="far fa-user"></i></div>
         <div class="card-wrap">
            <div class="card-header">
               <h4>
                  <a  href="<?php echo base_url('admin/users') ?>"><?php echo lang('dashboard user'); ?> (<?php echo $users->count; ?>) </a>
               </h4>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
         <div class="card-icon bg-primary">
            <i class="fab fa-blogger-b"></i>
         </div>
         <div class="card-wrap">
            <div class="card-header">
               <h4>
                  <a  href="<?php echo base_url('admin/brand') ?>"><?php echo lang('dashboard Brand'); ?> (<?php echo $brands->count; ?>) </a>
               </h4>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
         <div class="card-icon bg-primary">
            <i class="fas fa fa-globe" aria-hidden="true"></i>
         </div>
         <div class="card-header">
            <h4>
               <a  href="<?php echo base_url('admin/market') ?>"><?php echo lang('dashboard Markets'); ?> (<?php echo $market->count; ?>) </a>
            </h4>
         </div>
      </div>
   </div>
   <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
         <div class="card-icon bg-primary">
            <i class="fas fa fa-list-alt" aria-hidden="true"></i>
         </div>
         <div class="card-header">
            <h4>
               <a  href="<?php echo base_url('admin/category') ?>"><?php echo lang('dashboard Categories'); ?> (<?php echo $category->count; ?>) </a>
            </h4>
         </div>
      </div>
   </div>
   <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
         <div class="card-icon bg-primary">
            <i class="fas fa-cart-arrow-down"></i>
         </div>
         <div class="card-header">
            <h4>
               <a  href="<?php echo base_url('admin/product') ?>"><?php echo lang('dashboard Products'); ?> (<?php echo $products->count; ?>) </a>
            </h4>
         </div>
      </div>
   </div>

   <div class="clearfix"></div>
   <div class="col-12">
      <hr>
      <h4 class="my-3"><?php echo lang('Top 4 Visited  Products'); ?> </h4>

      <div class="row">
         <?php
         foreach ($top_products as $top_products_array) 
         {
            ?>

            <div class="col-3">

               <div class="card card-statistic-1">
                  <div class="card-icon bg-primary">
                      <i class="text-white"><?php echo $top_products_array['total_visits']; ?></i>
                      <!-- <i class="fas fa-cart-arrow-down"></i> -->
                  </div>
                  <div class="card-header">
                     <h4>
                        <a  href="<?php echo base_url('admin/product/form/').$top_products_array['product_id']; ?>"><?php echo $top_products_array['product_title']; ?></a>
                     </h4>
                  </div>
               </div>

               
            </div>

            <?php
         }
         ?>
      </div>
      <hr>
   </div>
   <div class="clearfix"></div>
   <div class="col-12">
      <div class="row mb-3">
         <div class="col-sm-8"></div>
         <div class="col-sm-4">
            <div class="formgroup">
               <label><?php echo lang('Select Month For Graph'); ?></label>
               <select name="month" class="form-control graph_month" id="graph_month">
                  <?php
                     foreach ($product_visit_month as $key => $array_value) 
                     {
                        $select = $array_value == date("M - Y") ? "Selected" : "";
                        echo "<option value='".$key."' $select> $array_value </option>";
                     }
                  ?>
               </select>
            </div>
         </div>
      </div>
   </div>
   <div class="clearfix"></div>
<!--    <div class="col-12">
      <div id="chartContainer" style="height: 370px; width: 100%;"></div>
   </div> -->

   <div class="clearfix"></div>
   <div class="col-12">
      <div>
      <canvas id="canvassss" style="display: block; width: 1013px; height: 506px;" width="1013" height="506" class="chartjs-render-monitor"></canvas>
      </div>
   </div>
</div>





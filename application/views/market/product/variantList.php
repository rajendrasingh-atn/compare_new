<?php defined('BASEPATH') OR exit('No direct script access allowed');
   if($this->session->flashdata('success')) {
    echo '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" aria-label="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> '.$this->session->flashdata("success").'
        </div>';
   }
   ?>
<div class="panel panel-default">
   <input type="hidden" value="<?php echo $editData['id'];?>" name="page_url" id="productid">
   <a href="<?php echo base_url("market/product");?>" class="btn btn-dark float-right ml-3">Back</a>
   <a href="<?php echo base_url("market/product/variant_form/".$editData['id']);?>" class="btn btn-primary variantadd float-right" > <?php echo lang('admin Variant btn Add Variant'); ?> </a>
   <div class="clearfix"></div>
   <hr>
   <div class="productname">
      <?php $productTitle = (!empty($editData['product_title']) && isset($editData['product_title']) ? $editData['product_title'] : '');?>
      <h3>Product Name: <?php echo ucfirst($productTitle);?> </h3>
   </div>
   <table id="table" class="display table table-striped table-bordered" cellspacing="0" width="100%">
      <thead>
         <tr>
            <th><?php echo lang('admin table no'); ?></th>
            <th><?php echo lang('admin varient table Sku'); ?></th>
            <th><?php echo lang('admin varient table Options'); ?></th>
            <th><?php echo lang('admin varient table added'); ?></th>
            <th><?php echo lang('admin table Action'); ?></th>
         </tr>
      </thead>
      <tbody>
      </tbody>
   </table>
</div>
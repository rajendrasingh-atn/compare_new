<!-- Button trigger modal -->
<div class="modal-dialog" role="document">
   <div class="modal-content">
      <div class="modal-header border-bottom-1">
         <h5 class="modal-title"><?php echo lang('admin Product Varient form') ?></h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <div class="modal-body">
         <?php 
            if($product_varient)
            {
            
              foreach ($product_varient as $product) 
              { ?>
         <div class="row border-bottom-1 p-2">
            <div class="col-md-8">
               <a class="btn btn-link mr-1 " href="<?php echo base_url('market/product/variant_form_edit/').$product->id; ?>">
               <?php echo $product->sku ?>
               </a>
            </div>
            <div class="col-md-4">
               <a title="Edit Product Variant" class="btn btn-info mr-1 " href="<?php echo base_url('market/product/variant_form_edit/').$product->id; ?>">
               <i class="fas fa-pencil-alt"></i>
               </a> 

               <a title="Delete Product Variant" class="btn btn-danger mr-1 " href="<?php echo base_url('market/product/delete_product_variant/').$product->id; ?>">
                <i class="fas fa-trash"></i>
               </a> 

            </div>
         </div>
         <?php }
            }
            else 
            {?>
         <div class="row">
            <div class="col-md-12"><?php echo lang('Sorry No Product Found') ?></div>
         </div>
         <?php }?>
      </div>
      <div class="modal-footer bg-whitesmoke br">
         <button type="button" class="btn btn-dark" data-dismiss="modal"><?php echo lang('core button close') ?></button>
      </div>
   </div>
</div>
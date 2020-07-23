<?php defined('BASEPATH') OR exit('No direct script access allowed');?>  
<div class="row">
   <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
         <div class="card-body">
            <div class="draglabel">
               <div class="row">
                  <div class="col-12 form-group">
                     <h4><?php echo lang('admin category All Label') ?></h4>

                     <?php echo form_open('', array('role'=>'form')); ?>
                     <select class="form-control" multiple="multiple" name="customfield_id[]" id="custom-fields">
                        <?php
                           foreach($category_custom_fields as $key => $custome_label)
                           {
                           ?>
                           <option <?php echo isset($custome_label['category_custom_order']) ? 'selected' : '' ?> value="<?php echo $custome_label['id'];?>"><?php echo ucfirst($custome_label['custom_label']); ?></option>
                        <?php } ?>
                     </select>

                     <input type="hidden" name="cat_id" class="category_id" class="category_id" value="<?php echo $categoryid;?>">
                     <input type="submit" name="<?php echo lang('core button save'); ?>" value="<?php echo lang('core button save'); ?>" class="btn btn-primary btn-lg">
                     <a href="<?php echo base_url('admin/category');?>" class="btn btn-dark btn-lg"><?php echo lang('core button cancel'); ?></a>
                     <?php echo form_close(); ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
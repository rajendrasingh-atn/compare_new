<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="row">
   <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
         <div class="card-body">
            <?php echo form_open_multipart('', array('role'=>'form')); ?>
            <div class="row">
               <div class="col-6">
                  <div class="form-group">
                     <?php echo  form_label(lang('brand input name'), 'name'); ?> 
                     <span class="required">*</span>
                     <?php $populateData = (!empty($this->input->post('brandtitle')) ? $this->input->post('brandtitle') : (!empty($editData['brand_title']) && isset($editData['brand_title']) ? $editData['brand_title'] : '' )); ?>
                     <input type="text" name="brandtitle" id="b_title" class="form-control" value="<?php echo  $populateData;?>">
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <?php echo  form_label(lang('brand input upload'), 'upload'); ?>
                     <input type="file" name="brandimage" id="b_image" class="form-control">
                     <?php 
                        if(!empty($editData['id']) && isset($editData['id']))
                        {
                        		$populateImg = (!empty($editData['brand_image']) && isset($editData['brand_image']) ? base_url('assets\images\brand_image\\'.$editData['brand_image']) : (empty($editData['brand_image']) ? base_url('assets/images/brand_image/default_brand.jpg') : '' )); 
                        ?>
                     <img src="<?php echo  $populateImg;?>" class="img_thumb mt-2 popup">
                     <?php } ?>
                  </div>
               </div>
               <div class="col-12">
                  <div class="form-group">
                     <?php echo  form_label(lang('brand input description'), 'description'); ?>
                     <?php $populateData = (!empty($this->input->post('branddescription')) ? $this->input->post('branddescription') : (!empty($editData['brand_description']) && isset($editData['brand_description']) ? $editData['brand_description'] : '' )); ?>
                     <textarea name="branddescription" id="bdesc" class="form-control" rows="5" ><?php echo  $populateData;?></textarea>
                  </div>
               </div>
               <div class="col-12">
                  <?php $populateData = isset($editData['id']) && $editData['id'] ? lang('core button update') : lang('core button save'); ?>
                  <input type="submit" name="<?php echo  $populateData;?>" value="<?php echo  ucfirst($populateData);?>" class="btn btn-primary btn-lg">
                  <button type="button" onclick="location.href = '<?php echo base_url("admin/brand");?>';" class="btn btn-dark btn-lg cancelbtn"><?php echo lang('core button cancel'); ?></button>
               </div>
            </div>
            <?php echo form_close();?>
         </div>
      </div>
   </div>
</div>
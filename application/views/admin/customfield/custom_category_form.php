<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="row">
   <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
         <div class="card-body">
            <?php echo form_open_multipart('', array('role'=>'form')); ?>
            <div class="row">
               <div class="col-6">
                  <div class="form-group">
                     <?php echo form_label(lang('custom input catcustomname'), 'catcustomname'); ?> 
                     <span class="required">*</span>
                     <?php $populateData = (!empty($this->input->post('catcustom')) ? $this->input->post('catcustom') : (!empty($editData['title']) && isset($editData['title']) ? $editData['title'] : '' )); ?>
                     <input type="text" name="catcustom" id="catcustomname" class="form-control" value="<?php echo $populateData;?>">
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <?php echo form_label(lang('custom input catcustomicon'), 'catcustomicon'); ?>
                     <div class="input-group">
                        <?php $populateData = (!empty($this->input->post('customcategoryicon')) ? $this->input->post('customcategoryicon') : (!empty($editData['icon']) && isset($editData['icon']) ? $editData['icon'] : '' )); ?>
                        <input type="text" class="form-control" name="customcategoryicon" value="<?php echo $populateData;?>" id="iconfield">
                        <span class="input-group-append" id="target">
                        <button class="btn btn-outline-secondary" data-icon="<?php echo $populateData;?>" role="iconpicker"></button>
                        </span>
                     </div>
                  </div>
               </div>
            </div>
            <?php 
               $populateData = isset($editData['id']) && $editData['id'] ? lang('core button update') : lang('core button save'); ?>
               
            <input type="submit" name="<?php echo $populateData;?>" value="<?php echo ucfirst($populateData);?>" class="btn btn-primary btn-lg">
            <a href="<?php echo base_url("admin/customfield/customcategorylist");?>" class="btn btn-dark btn-lg"><?php echo lang('core button cancel'); ?></a>
            <?php echo form_close(); ?>
         </div>
      </div>
   </div>
</div>
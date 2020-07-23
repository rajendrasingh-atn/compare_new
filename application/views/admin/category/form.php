<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="row">
   <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
         <div class="card-body">
            <?php echo form_open_multipart('', array('role'=>'form')); ?>
            <div class="row">
               <div class="col-6">
                  <div class="form-group">
                     <?php echo form_label(lang('category input title'), 'title'); ?> 
                     <span class="required">*</span>
                     <?php $populateData = (!empty($this->input->post('title')) ? $this->input->post('title') : (!empty($editData['category_title']) && isset($editData['category_title']) ? $editData['category_title'] : '' )); ?>
                     <input type="text" name="title" id="title" class="form-control" value="<?php echo $populateData;?>">
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <?php echo form_label(lang('category input parentcategory'), 'parentcategory'); ?>
                     <?php $populateData = (!empty($editData['parent_category']) && isset($editData['parent_category']) ? $editData['parent_category'] : (!empty($this->input->post('parentcat')) ? $this->input->post('parentcat') : '' )); ?> 
                     <select class="select_dropdown form-control" name="parentcat">
                        <option value=""><?php echo lang('Select One'); ?></option>
                        <?php
                           foreach($cat_title as $key=>$parentCategory)
                           {
                           $selected = ($parentCategory['id'] == $populateData) ? "selected" : ''; 
                           ?>
                        <option <?php echo $selected;?> value="<?php echo $parentCategory['id'];?>"><?php echo $parentCategory['category_title'];?>   </option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <?php echo form_label(lang('category input categoryicon'), 'categoryicon'); ?>
                     <div class="input-group">
                        <?php $populateData = (!empty($this->input->post('categoryicon')) ? $this->input->post('categoryicon') : (!empty($editData['category_icon']) && isset($editData['category_icon']) ? $editData['category_icon'] : '' )); ?>
                        <input type="text" class="form-control" name="categoryicon" value="<?php echo $populateData;?>" id="iconfield">
                        <span class="input-group-append" id="target">
                        <button class="btn btn-outline-secondary" data-icon="<?php echo $populateData;?>" role="iconpicker"></button>
                        </span>
                     </div>
                  </div>
               </div>
               <?php
                  $checked = $this->input->post('display_on_home') ? 'checked' : (isset($editData['display_on_home']) && $editData['display_on_home'] == 1 ? 'checked' : '');
                  
                  ?>
               <div class="col-6">
                  <div class="form-group">
                     <div class="control-label"><?php echo lang('admin category Display on Home Or Menu'); ?></div>
                     <label class="custom-switch mt-2 form-control">
                     <input type="checkbox" <?php echo $checked; ?> name="display_on_home" value="1" class="custom-switch-input">
                     <span class="custom-switch-indicator"></span>
                     <span class="custom-switch-description"><?php echo lang('admin category Display on Home Or Menu msg'); ?></span>
                     </label>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <?php echo form_label(lang('category input categorydesc'), 'categorydesc'); ?>
               <?php $populateData = (!empty($this->input->post('description')) ? $this->input->post('description') : (!empty($editData['category_description']) && isset($editData['category_description']) ? $editData['category_description'] : '' )); ?>
               <textarea name="description" id="categorydesc" rows="5" class="form-control"><?php echo $populateData;?></textarea>
            </div>
            <div class="form-group">
               <?php echo form_label(lang('category input categoryimage'), 'categoryimage'); ?>
               <input type="file" name="image" id="categoryimage" class="form-control">
               <?php 
                  if(!empty($editData['id']) && isset($editData['id']))
                  {
                  $populateData = (!empty($editData['category_image']) && isset($editData['category_image']) ? base_url('assets\images\category_image\\'.$editData['category_image']) : (empty($editData['category_image']) ? base_url('assets/images/category_image/default_category.jpg') : ''));
                  ?>
               <img src="<?php echo $populateData;?>" class="img_thumb mt-2 popup">
               <?php } ?>
            </div>
            <?php 
               $populateData = isset($editData['id']) && $editData['id'] ? lang('core button update') : lang('core button save'); ?>
               
            <input type="submit" name="<?php echo $populateData;?>" value="<?php echo ucfirst($populateData);?>" class="btn btn-primary btn-lg">
            <a href="<?php echo base_url("admin/category");?>" class="btn btn-dark btn-lg"> <?php echo lang('core button cancel'); ?></a>
            <?php echo form_close(); ?>
         </div>
      </div>
   </div>
</div>
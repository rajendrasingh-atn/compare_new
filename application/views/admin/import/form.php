<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
   <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
         <div class="card-body">
            <?php echo form_open_multipart('', array('role'=>'form','novalidate'=>'novalidate')); ?>
            <div class="row">
               
               
               <div class="col-6">
                  <div class="form-group">
                     <?php echo  form_label(lang('admin import Product Category'), 'category'); ?> <span class="required text-danger">*</span>
                     <?php $populateData = (!empty($this->input->post('category')) ? $this->input->post('category') : '' ); ?>
  
                     <select class="select_dropdown form-control category" id="category" name="category">
                        <option value=""><?php echo lang('Select Category');?></option>
                        <?php foreach($category_data as  $category_array) { 
                           $selected = ($category_array['id'] == $populateData) ? "selected" : "";
                           ?>
                        <option <?php echo $selected;?> value="<?php echo  $category_array['id'];?>"><?php echo  $category_array['category_title'];?></option>
                        <?php } ?>
                     </select>

                     <span class="small text-danger form-error"> <?php echo strip_tags(form_error('category')); ?> </span>  

                  </div>
               </div>

               <div class="col-6">
                  <div class="form-group">
                     <?php echo  form_label(lang('admin Upload Excel File'), 'excel_file'); ?> <span class="required text-danger">*</span>
                     <input type="File" name="excel_file" class="form-control excel_file" id="excel_file">
                     <span class="small text-danger form-error"> <?php echo strip_tags(form_error('excel_file')); ?> </span>  
                    </div>
               </div>

               <div class="col-12 my-2">
                  <a target="_blank" href="<?php echo base_url('assets/import-demo/demo.xlsx'); ?>"> <?php echo lang('Downlod Sample File'); ?> </a>
               </div>




               <div class="clearfix"></div>

               <div class="col-12 mt-5 text-center">
                  <input type="Submit" class="btn btn-success mr-5" value="<?php echo lang('admin import btn Upload') ?>">
                  <a href="<?php echo base_url('admin') ?>" class="btn btn-dark"><?php echo lang('core button cancel'); ?></a>
               </div>
            </div>
            <?php echo form_close();?>
         </div>
      </div>
   </div>
</div>
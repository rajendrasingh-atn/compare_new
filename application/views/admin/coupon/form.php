<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $update = isset($coupon_id) && $coupon_id ? '_update' : '' ?>
<div class="row page">
  <style type="text/css">
/*.bootstrap-datetimepicker-widget .picker-switch td span, .bootstrap-datetimepicker-widget .picker-switch td i { line-height: 2.5; height: 2.5em; width: 100%; background-color: #080808; color: #fff; }*/
  </style>
   <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
         <div class="card-body">
            <?php echo form_open_multipart('', array('role'=>'form','novalidate'=>'novalidate')); ?>
            <div class="row">

               <div class="col-6">
                  <div class="form-group <?php echo form_error('title') ? ' has-error' : ''; ?>">
                     <?php echo  form_label('Coupon title', 'title'); ?> 
                     <span class="required">*</span>
                     <?php 
                     $populateData = $this->input->post('title') ? $this->input->post('title') : (isset($coupon_data->title) ? $coupon_data->title :  '' );
                     ?>

                     <input type="text" name="title" id="title" class="form-control" value="<?php echo $populateData;?>">
                     <span class="small form-error"> <?php echo strip_tags(form_error('title')); ?> </span>
                  </div>
               </div>


              <div class="col-6">
                  <div class="form-group <?php echo form_error('image') ? ' has-error' : ''; ?>">
                     <?php echo  form_label('Coupon Image', 'image'); ?>

                     <span class="required">*</span>

                     <?php 
                        $populateData = isset($coupon_data->image) && $coupon_data->image ? $coupon_data->image :  ''; 
                     ?> 

                    <input type="file" name="image" id="image" class="form-control">
                    <span class="small form-error"> <?php echo strip_tags(form_error('image')); ?> </span> 
                    <?php 
                    if($populateData)
                    {
                    ?> 
                    <div class="">
                      <img class="image_preview popup" src="<?php echo base_url('assets/images/coupon/').$populateData; ?>">
                    </div>
                    <?php
                    }
                    ?>

                  </div>
              </div>

               <div class="clearfix"></div>


               <div class="col-6">
                  <div class="form-group <?php echo form_error('promo_link') ? ' has-error' : ''; ?>">
                     <?php echo  form_label('Coupon Promo Link', 'promo_link'); ?> 
                     <span class="required">*</span>
                     <?php 
                     $populateData = $this->input->post('promo_link') ? $this->input->post('promo_link') : (isset($coupon_data->promo_link) ? $coupon_data->promo_link :  '' );
                     ?>

                     <input type="text" name="promo_link" id="promo_link" class="form-control" value="<?php echo $populateData;?>">
                     <span class="small form-error"> <?php echo strip_tags(form_error('promo_link')); ?> </span>
                  </div>
               </div>



               <div class="col-6">
                  <div class="form-group <?php echo form_error('valid_till') ? ' has-error' : ''; ?>">
                     <?php echo  form_label('Coupon Valid Till', 'valid_till'); ?> 
                     <span class="required">*</span>
                     <?php 
                     $populateData = $this->input->post('valid_till') ? $this->input->post('valid_till') : (isset($coupon_data->valid_till) ? $coupon_data->valid_till :  '' );
                     ?>

                     <input type="text" name="valid_till" id="datetimepicker2" class="form-control datetimepicker" value="<?php echo $populateData;?>">
                     <span class="small form-error"> <?php echo strip_tags(form_error('valid_till')); ?> </span>
                  </div>
               </div>


               <div class="clearfix"></div>


               <?php
                  $checked = $this->input->post('is_coupon') ? 'checked' : (isset($coupon_data->is_coupon) && $coupon_data->is_coupon == 1 ? 'checked' : '');
                    $display  = $checked ? 'block' : 'none';
                  
                  ?>
               <div class="col-6 is_coupon_box">
                  <div class="form-group"> 
                     <div class="control-label"><?php echo lang('admin is coupon code'); ?></div>
                     <label class="custom-switch mt-2 form-control">
                     <input type="checkbox" <?php echo $checked; ?> name="is_coupon" value="1" class="custom-switch-input is_coupon">
                     <span class="custom-switch-indicator"></span>
                     <span class="custom-switch-description"><?php echo lang('admin is coupon code msg'); ?></span>
                     </label>
                  </div>
               </div>



               <div class="col-6 coupon_code_box" style="display: <?php echo $display; ?>;">
                  <div class="form-group <?php echo form_error('coupon_code') ? ' has-error' : ''; ?>">
                     <?php echo  form_label('Coupon Prome Code', 'coupon_code'); ?> 
                     <span class="required">*</span>
                     <?php 
                     $populateData = $this->input->post('coupon_code') ? $this->input->post('coupon_code') : (isset($coupon_data->coupon_code) ? $coupon_data->coupon_code :  '' );
                     ?>

                     <input type="text" name="coupon_code" id="coupon_code" class="form-control" value="<?php echo $populateData;?>">
                     <span class="small form-error"> <?php echo strip_tags(form_error('coupon_code')); ?> </span>
                  </div>
               </div>


               <div class="clearfix"></div>

               <div class="col-12">
                  <div class="form-group <?php echo form_error('description') ? ' has-error' : ''; ?>">
                     <?php echo  form_label('Coupon description', 'description'); ?>
                      <span class="required">*</span>
                     <?php
                        $populateData = $this->input->post('description') ? $this->input->post('description') : (isset($coupon_data->description) ? $coupon_data->description :  '' );
                        ?>
                     <textarea name="description" id="description" class="form-control editor" rows="5" ><?php echo $populateData;?></textarea>
                     <span class="small form-error"> <?php echo strip_tags(form_error('description')); ?> </span>
                  </div>
               </div>

               <div class="clearfix"></div>



               <hr>
               
               <div class="col-12">
                  <?php $saveUpdate = isset($coupon_id) ? 'Update' : 'Save'; ?>
                  <input type="submit"  value="<?php echo ucfirst($saveUpdate);?>" class="btn btn-primary px-5">
                  <a href="<?php echo base_url('admin/coupon');?>" class="btn btn-dark px-5">Cancel</a>
               </div>
               <div class="clearfix"></div>
            </div>
            <?php echo form_close();?>
         </div>
      </div>
   </div>
</div>


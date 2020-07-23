<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $update = isset($language_id) && $language_id ? '_update' : '' ?>
<div class="row page">
   <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
         <div class="card-body">
            <?php echo form_open_multipart('', array('role'=>'form','novalidate'=>'novalidate')); ?>
            <div class="row">
              <input type="hidden" name="language_id" value="<?php echo isset($language_id) && $language_id ? $language_id : ''; ?>">
               <div class="col-6">
                  <div class="form-group <?php echo form_error('lang') ? ' has-error' : ''; ?>">
                     <?php echo  form_label('Language Name', 'lang'); ?> 
                     <span class="required">*</span>
                     <?php 
                     $populateData = $this->input->post('lang') ? $this->input->post('lang') : (isset($language_data->lang) ? $language_data->lang :  '' );
                     ?>

                     <input type="text" name="lang" id="lang" class="form-control" value="<?php echo $populateData;?>">
                     <span class="small form-error"> <?php echo strip_tags(form_error('lang')); ?> </span>
                  </div>
               </div>

               <div class="col-6">
                  <div class="form-group <?php echo form_error('category') ? ' has-error' : ''; ?>">
                     <?php echo  form_label('Language Category', 'category'); ?> 
                     <span class="required">*</span>
                     <?php 
                     $populateData = $this->input->post('category') ? $this->input->post('category') : (isset($language_data->category) ? $language_data->category :  '' );
                     ?>

                     <input type="text" name="category" id="category" class="form-control" value="<?php echo $populateData;?>">
                     <span class="small form-error"> <?php echo strip_tags(form_error('category')); ?> </span>
                  </div>
               </div>


               <div class="col-6">
                  <div class="form-group <?php echo form_error('token') ? ' has-error' : ''; ?>">
                     <?php echo  form_label('Language Token', 'token'); ?> 
                     <span class="required">*</span>
                     <?php 
                     $populateData = $this->input->post('token') ? $this->input->post('token') : (isset($language_data->token) ? $language_data->token :  '' );
                     ?>

                     <input type="text" name="token" id="token" class="form-control" value="<?php echo $populateData;?>">
                     <span class="small form-error"> <?php echo strip_tags(form_error('token')); ?> </span>
                  </div>
               </div>


              <div class="col-6">
                  <div class="form-group <?php echo form_error('flag') ? ' has-error' : ''; ?>">
                     <?php echo  form_label('Lanague Flag', 'flag'); ?>

                     <span class="required">*</span>

                     <?php 
                        $populateData = isset($language_data->flag) && $language_data->flag ? $language_data->flag :  ''; 
                     ?> 

                    <input type="file" name="flag" id="flag" class="form-control">
                    <span class="small form-error"> <?php echo strip_tags(form_error('flag')); ?> </span> 

                    <?php 
                    if($populateData)
                    {
                    ?> 
                    <div class="">
                      <img class="image_preview popup" src="<?php echo base_url('assets/images/language/').$populateData; ?>">
                    </div>
                    <?php
                    }
                    ?>

                  </div>
               </div>

               
               <div class="clearfix"></div>

               <div class="col-12">
                  <div class="form-group <?php echo form_error('description') ? ' has-error' : ''; ?>">
                     <?php echo  form_label('Language Description', 'description'); ?> 
                     <span class="required">*</span>
                     <?php 
                     $populateData = $this->input->post('description') ? $this->input->post('description') : (isset($language_data->description) ? $language_data->description :  '' );
                     ?>

                     <input type="text" name="description" id="description" class="form-control" value="<?php echo $populateData;?>">
                     <span class="small form-error"> <?php echo strip_tags(form_error('description')); ?> </span>
                  </div>
               </div>


               <div class="clearfix"></div>

               <hr>
               
               <div class="col-12">
                  <?php $saveUpdate = isset($language_id) ? 'Update' : 'Save'; ?>
                  <input type="submit"  value="<?php echo ucfirst($saveUpdate);?>" class="btn btn-primary px-5">
                  <a href="<?php echo base_url('admin/language');?>" class="btn btn-dark px-5">Cancel</a>
               </div>
               <div class="clearfix"></div>
            </div>
            <?php echo form_close();?>
         </div>
      </div>
   </div>
</div>


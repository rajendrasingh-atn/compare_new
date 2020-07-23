<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="row">
   <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
         <div class="card-body">
            <?php echo form_open_multipart('', array('role'=>'form')); ?>
            <div class="row">
               <div class="col-6">
                  <div class="form-group">
                     <?php echo  form_label(lang('market input name'), 'name'); ?> 
                     <span class="required">*</span>
                     <?php $populateData = (!empty($this->input->post('markettitle')) ? $this->input->post('markettitle') : (!empty($editData['market_title']) && isset($editData['market_title']) ? $editData['market_title'] : '' )); ?>
                     <input type="text" name="markettitle" id="m_title" class="form-control" value="<?php echo  $populateData;?>">
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <?php echo  form_label(lang('market input upload'), 'upload'); ?>
                     <input type="file" name="marketimage" id="m_image" class="form-control">
                     <?php 
                        if(!empty($editData['id']) && isset($editData['id']))
                        {
                        $populateImg = (!empty($editData['market_logo']) && isset($editData['market_logo']) ? base_url('assets\images\market_image\\'.$editData['market_logo']) : (empty($editData['market_logo']) ? base_url('assets/images/market_image/default_market.jpg') : '' )); 
                        ?>
                     <img src="<?php echo  $populateImg;?>"  class="img_thumb mt-2 popup">
                     <?php } ?>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <?php echo  form_label(lang('admin market Market Url'), 'market_url'); ?>
                     <span class="required">*</span>
                     <?php $populateData = (!empty($this->input->post('market_url')) ? $this->input->post('market_url') : (!empty($editData['market_url']) && isset($editData['market_url']) ? $editData['market_url'] : '' )); ?>
                     <input type="text" name="market_url" id="market_url" class="form-control market_url" value="<?php echo  $populateData;?>">
                  </div>
               </div>

               <?php
                  $checked = $this->input->post('display_on_footer') ? 'checked' : (isset($editData['display_on_footer']) && $editData['display_on_footer'] == 1 ? 'checked' : '');
                  
                  ?>
               <div class="col-6">
                  <div class="form-group"> 
                     <div class="control-label"><?php echo lang('admin market display in footer'); ?></div>
                     <label class="custom-switch mt-2 form-control">
                     <input type="checkbox" <?php echo $checked; ?> name="display_on_footer" value="1" class="custom-switch-input">
                     <span class="custom-switch-indicator"></span>
                     <span class="custom-switch-description"><?php echo lang('admin market display in footer msg'); ?></span>
                     </label>
                  </div>
               </div>


               <div class="clearfix"></div>
               <?php 
                  $disable = isset($market_id) && $market_id ? 'disabled' : '';
                  $disable = '';
                ?>

               <div class="col-4">
                  <div class="form-group">
                     <?php echo  form_label(lang('market input username'), 'username'); ?> 
                     <span class="required">*</span>
                     <?php $populateData = (!empty($this->input->post('username')) ? $this->input->post('username') : (!empty($user_data['username']) && isset($user_data['username']) ? $user_data['username'] : '' )); ?>
                     <input type="text" name="username" id="m_title" class="form-control" value="<?php echo  $populateData;?>" <?php echo $disable; ?> >
                  </div>
               </div>



               <div class="col-4">
                  <div class="form-group">
                     <?php echo  form_label(lang('market input email'), 'email'); ?> 
                     <span class="required">*</span>
                     <?php $populateData = (!empty($this->input->post('email')) ? $this->input->post('email') : (!empty($user_data['email']) && isset($user_data['email']) ? $user_data['email'] : '' )); ?>
                     <input type="text" name="email" id="m_title" class="form-control" value="<?php echo  $populateData;?>" <?php echo $disable; ?>>
                  </div>
               </div>




               <div class="col-4">
                  <div class="form-group">
                     <?php echo  form_label(lang('market input password'), 'password'); ?> 
                     <span class="required">*</span>
                     <?php $populateData = (!empty($this->input->post('password')) ? $this->input->post('password') : (!empty($user_data['password']) && isset($user_data['password']) ? $user_data['password'] : '' )); ?>
                     <input type="password" name="password" id="m_title" class="form-control" value="<?php echo  $populateData;?>" <?php echo $disable; ?> autocomplete="new-password" />
                  </div>
               </div>

               <div class="clearfix"></div>

               <div class="col-12">
                  <div class="form-group">
                     <?php echo  form_label(lang('market input description'), 'description'); ?>
                     <?php $populateData = (!empty($this->input->post('marketdescription')) ? $this->input->post('marketdescription') : (!empty($editData['market_description']) && isset($editData['market_description']) ? $editData['market_description'] : '' )); ?>
                     <textarea name="marketdescription" id="mdesc" class="form-control" rows="5" ><?php echo  $populateData;?></textarea>
                  </div>
               </div>

               <div class="clearfix"></div>


               <div class="col-12">
                  <?php $populateData = isset($editData['id']) && $editData['id'] ? lang('core button update') : lang('core button save'); ?>
                  <input type="submit" name="<?php echo  $populateData;?>" value="<?php echo  ucfirst($populateData);?>" class="btn btn-primary btn-lg">
                  <button type="button" onclick="location.href = '<?php echo base_url("admin/market");?>';" class="btn btn-dark btn-lg cancelbtn"><?php echo lang('core button cancel'); ?></button>
               </div>
            </div>
            <?php echo form_close();?>
         </div>
      </div>
   </div>
</div>
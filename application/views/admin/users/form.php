<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-body">
               <?php echo form_open_multipart('', array('role'=>'form')); ?>
               <?php // hidden id ?>
               <?php if (isset($user_id)) : ?>
               <?php echo form_hidden('id', $user_id); ?>
               <?php endif; ?>
               <div class="row">
                  <?php // username ?>
                  <div class="form-group col-sm-4<?php echo form_error('username') ? ' has-error' : ''; ?>">
                     <?php echo form_label(lang('users input username'), 'username', array('class'=>'control-label')); ?>
                     <span class="required">*</span>
                     <?php echo form_input(array('name'=>'username', 'value'=>set_value('username', (isset($user['username']) ? $user['username'] : '')), 'class'=>'form-control')); ?>
                  </div>
                  <?php // first name ?>
                  <div class="form-group col-sm-4<?php echo form_error('first_name') ? ' has-error' : ''; ?>">
                     <?php echo form_label(lang('users input first_name'), 'first_name', array('class'=>'control-label')); ?>
                     <span class="required">*</span>
                     <?php echo form_input(array('name'=>'first_name', 'value'=>set_value('first_name', (isset($user['first_name']) ? $user['first_name'] : '')), 'class'=>'form-control')); ?>
                  </div>
                  <?php // last name ?>
                  <div class="form-group col-sm-4<?php echo form_error('last_name') ? ' has-error' : ''; ?>">
                     <?php echo form_label(lang('users input last_name'), 'last_name', array('class'=>'control-label')); ?>
                     <span class="required">*</span>
                     <?php echo form_input(array('name'=>'last_name', 'value'=>set_value('last_name', (isset($user['last_name']) ? $user['last_name'] : '')), 'class'=>'form-control')); ?>
                  </div>
                  <?php // language ?>
                  <div class="form-group col-sm-6<?php echo form_error('language') ? ' has-error' : ''; ?>">
                     <?php echo form_label(lang('users input language'), 'language', array('class'=>'control-label')); ?>
                     <span class="required">*</span>
                     <?php echo form_dropdown('language', $this->languages, (isset($user['language']) ? $user['language'] : $this->config->item('language')), 'id="language" class="form-control"'); ?>
                  </div>
                  <?php // email ?>
                  <div class="form-group col-sm-6<?php echo form_error('email') ? ' has-error' : ''; ?>">
                     <?php echo form_label(lang('users input email'), 'email', array('class'=>'control-label')); ?>
                     <span class="required">*</span>
                     <?php echo form_input(array('name'=>'email', 'value'=>set_value('email', (isset($user['email']) ? $user['email'] : '')), 'class'=>'form-control')); ?>
                  </div>
                  <?php // status ?>
                  <div class="form-group col-sm-6<?php echo form_error('status') ? ' has-error' : ''; ?>">
                     <?php echo form_label(lang('users input status'), '', array('class'=>'control-label')); ?>
                     <span class="required">*</span>
                     <div class="form-control">
                        <div class="radio float-left mr-3">
                           <label >
                           <?php echo form_radio(array('name'=>'status', 'id'=>'radio-status-1', 'value'=>'1', 'checked'=>(( ! isset($user['status']) OR (isset($user['status']) && (int)$user['status'] == 1) OR $user['id'] == 1) ? 'checked' : FALSE))); ?>
                           <?php echo lang('admin input active'); ?>
                           </label>
                        </div>
                        <?php if (!@$user['id'] OR @$user['id'] > 1) : ?>
                        <div class="radio">
                           <label>
                           <?php echo form_radio(array('name'=>'status', 'id'=>'radio-status-2', 'value'=>'0', 'checked'=>((isset($user['status']) && (int)$user['status'] == 0) ? 'checked' : FALSE))); ?>
                           <?php echo lang('admin input inactive'); ?>
                           </label>
                        </div>
                        <?php endif; ?>
                     </div>
                  </div>
                  <?php // administrator ?>
                  <div class="form-group col-sm-6<?php echo form_error('is_admin') ? ' has-error' : ''; ?>">
                     <?php echo form_label(lang('users input is_admin'), '', array('class'=>'control-label')); ?>
                     <span class="required">*</span>
                     <div class="form-control">
                        <?php if (! @$user['id'] OR @$user['id'] > 1) : ?>
                        <div class="radio float-left mr-3">
                           <label >
                           <?php echo form_radio(array('name'=>'is_admin', 'id'=>'radio-is_admin-1', 'value'=>'0', 'checked'=>(( ! isset($user['is_admin']) OR (isset($user['is_admin']) && (int)$user['is_admin'] == 0) && $user['id'] != 1) ? 'checked' : FALSE))); ?>
                           <?php echo lang('core text no'); ?>
                           </label>
                        </div>
                        <?php endif; ?>
                        <div class="radio">
                           <label>
                           <?php echo form_radio(array('name'=>'is_admin', 'id'=>'radio-is_admin-2', 'value'=>'1', 'checked'=>((isset($user['is_admin']) && (int)$user['is_admin'] == 1) ? 'checked' : FALSE))); ?>
                           <?php echo lang('core text yes'); ?>
                           </label>
                        </div>
                     </div>
                  </div>
                  <?php // password ?>
                  <div class="form-group col-sm-6<?php echo form_error('password') ? ' has-error' : ''; ?>">
                     <?php echo form_label(lang('users input password'), 'password', array('class'=>'control-label')); ?>
                     <?php if ($password_required) : ?><span class="required">*</span><?php endif; ?>
                     <?php echo form_password(array('name'=>'password', 'value'=>'', 'class'=>'form-control', 'autocomplete'=>'off')); ?>
                     <?php if ( ! $password_required) : ?>
                     <div class="width_100 mt-2">                
                        <span class="help-block text-warning"><?php echo lang('users help passwords'); ?></span>
                     </div>
                     <?php endif; ?>
                  </div>
                  <?php // password repeat ?>
                  <div class="form-group col-sm-6<?php echo form_error('password_repeat') ? ' has-error' : ''; ?>">
                     <?php echo form_label(lang('users input password_repeat'), 'password_repeat', array('class'=>'control-label')); ?>
                     <?php if ($password_required) : ?><span class="required">*</span><?php endif; ?>
                     <?php echo form_password(array('name'=>'password_repeat', 'value'=>'', 'class'=>'form-control', 'autocomplete'=>'off')); ?>
                  </div>
                  <div class="form-group col-sm-12 mb-3<?php echo form_error('password_repeat') ? ' has-error' : ''; ?>">
                     <?php echo form_label(lang('users input user_image'), 'user_image', array('class'=>'control-label')); ?>
                     <?php echo form_upload(array('name'=>'user_image','class'=>'form-control')); ?>
                     <?php 
                        if(!empty($user['id']) && isset($user['id'])) 
                        {
                            $populateimg = (isset($user['image']) && $user['image'] ? $user['image'] : 'avatar-1.png');
                            $populateimg = base_url('assets/images/user_image/').$populateimg;
                        ?>
                     <img src="<?php echo $populateimg;?>" class="img_thumb mt-2 popup">
                     <?php } ?>
                  </div>
               </div>
               <?php // buttons ?>
               <div class="row pull-right">
                  <div class="col-12">
                     <button type="submit" name="submit" class="btn btn-primary"><?php echo lang('core button save'); ?></button>
                     <a class="btn btn-dark ml-3" href="<?php echo $cancel_url; ?>"><?php echo lang('core button cancel'); ?></a>
                  </div>
               </div>
               <?php echo form_close(); ?>
            </div>
         </div>
      </div>
   </div>
</div>
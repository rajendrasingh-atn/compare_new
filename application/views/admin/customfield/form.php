<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="row">
<div class="col-12 col-md-12 col-lg-12">
   <div class="card">
      <div class="card-body">
         <?php echo form_open('', array('role'=>'form','id'=>'customfieldform')); ?>
         <div class="form-group">
            <div class="row">
               <div class="col-6">
                  <?php echo  form_label(lang('custom input categorycustomfield'), 'categorycustomfield');?>
                  <span class="required">*</span>
                  <?php $populateData = (!empty($this->input->post('customfieldcategories')) ? $this->input->post('customfieldcategories') : (!empty($editData['custom_field_category_id']) && isset($editData['custom_field_category_id']) ? $editData['custom_field_category_id'] : '' )); ?>
                  <select class="select_dropdown form-control" name="customfieldcategories">
                     <option value=""><?php echo lang('Select Custom Field Group'); ?></option>
                     <?php 
                        foreach($customfield_category as $key => $custom_cat_name)
                        {
                           $selected = ($custom_cat_name['id'] == $populateData) ? "selected" : '';   
                        ?>
                     <option <?php echo  $selected;?> value="<?php echo $custom_cat_name['id'];?>"><?php echo  $custom_cat_name['title'];?></option>
                     <?php } ?>
                  </select>
               </div>
               <div class="col-6">
                  <?php echo form_label(lang('custom input customtype'), 'customtype'); ?>
                  <span class="required">*</span>
                  <?php $populateData = (!empty($editData['custom_input_type']) && isset($editData['custom_input_type']) ? $editData['custom_input_type'] : '');
                     $insertedData = ($this->input->post('inputtype'));
                     ?>
                  <select name="inputtype" class="form-control cat custom_group">
                     <option value=""><?php echo lang('Select One'); ?></option>
                     <?php $text = ($populateData == 'text') ? "selected" : (($insertedData == 1) ? "selected" :''); ?>
                     <option <?php echo $text;?> value="1">Text</option>
                     <?php $text = ($populateData == 'textarea') ? "selected" : (($insertedData == 2) ? "selected" :''); ?>
                     <option <?php echo $text;?> value="2">Text Area</option>
                     <?php $text = ($populateData == 'dropdown') ? "selected" : (($insertedData == 3) ? "selected" :''); ?>
                     <option <?php echo $text;?> value="3">Drop Down</option>
                     <?php $text = ($populateData == 'checkbox') ? "selected" : (($insertedData == 4) ? "selected" :''); ?>
                     <option <?php echo $text;?> value="4">Checkbox</option>
                     <?php $text = ($populateData == 'radio') ? "selected" : (($insertedData == 5) ? "selected" :''); ?>
                     <option <?php echo $text;?> value="5">Radio</option>
                  </select>
               </div>
               <div class="clearfix mt-5"></div>
               <div class="col-12">
                  <label ><?php echo lang('custom input validation');?></label>
                  <div class="form-group">
                     <div class="selectgroup selectgroup-pills">
                        <!-- is_numeric -->
                        <?php 
                           if(isset($editData['is_numeric']) && $editData['is_numeric'] == '1')
                           {
                              $check = 'checked="checked"';
                           }
                           elseif ($this->input->post('isnumeric') == '1') 
                           {
                              $check = 'checked="checked"';
                           }
                           else
                           {
                              $check = false;
                           }
                           ?>
                        <label class="selectgroup-item">
                        <input type="checkbox" name="isnumeric" value="1" class="selectgroup-input" <?php echo $check;?> >
                        <span class="selectgroup-button"><?php echo lang('custom input isnum');?></span>
                        </label>
                        <!-- is_numeric -->
                        <?php 
                           if(isset($editData['is_required']) && $editData['is_required'] == '1')
                           {
                              $check = 'checked="checked"';
                           }
                           elseif ($this->input->post('isrequire') == '1') 
                           {
                              $check = 'checked="checked"';
                           }
                           else
                           {
                              $check = '';
                           }
                           ?>
                        <label class="selectgroup-item">
                        <input type="checkbox" name="isrequire" value="1" class="selectgroup-input" <?php echo  $check;?>>
                        <span class="selectgroup-button"><?php echo  lang('custom input isreq');?></span>
                        </label>
                        <!-- invariant  -->
                        <?php 
                           if($this->input->post('invariant') == '1')
                           {
                              $check = 'checked="checked"';
                           }
                           elseif (isset($editData['in_variant']) && $editData['in_variant'] == '1') 
                           {
                              $check = 'checked="checked"';
                           }
                           else
                           {
                              $check = '';
                           }
                           ?>
                        <label class="selectgroup-item">
                        <input type="checkbox" name="invariant" value="1" class="selectgroup-input" <?php echo  $check;?> >
                        <span class="selectgroup-button"><?php echo  lang('custom input isvariant');?> </span>
                        </label>
                        <!-- use for filter -->
                        <?php 
                           if(isset($editData['isforfilter']) && $editData['isforfilter'] == '1')
                           {
                              $check = 'checked="checked"';
                           }
                           elseif ($this->input->post('isforfilter') == '1') 
                           {
                              $check = 'checked="checked"';
                           }
                           else
                           {
                              $check = false;
                           }
                           ?>
                        <label class="selectgroup-item">
                        <input type="checkbox" name="isforfilter" value="1" class="selectgroup-input" <?php echo  $check;?> >
                        <span class="selectgroup-button"><?php echo  lang('custom input isforfilter');?> </span>
                        </label>
                        <!-- display on front -->
                        <?php 
                           if(isset($editData['isforfront']) && $editData['isforfront'] == '1')
                           {
                              $check = 'checked="checked"';
                           }
                           elseif ($this->input->post('isforfront') == '1') 
                           {
                              $check = 'checked="checked"';
                           }
                           else
                           {
                              $check = false;
                           }
                           ?>
                        <label class="selectgroup-item">
                        <input type="checkbox" name="isforfront" value="1" class="selectgroup-input" <?php echo  $check;?> >
                        <span class="selectgroup-button"><?php echo  lang('custom input isforfront');?> </span>
                        </label>
                        <!-- display on List -->
                        <?php 
                           if(isset($editData['isforlist']) && $editData['isforlist'] == '1')
                           {
                              $check = 'checked="checked"';
                           }
                           elseif ($this->input->post('isforlist') == '1') 
                           {
                              $check = 'checked="checked"';
                           }
                           else
                           {
                              $check = false;
                           }
                           ?>
                        <label class="selectgroup-item">
                        <input type="checkbox" name="isforlist" value="1" class="selectgroup-input" <?php echo  $check;?> >
                        <span class="selectgroup-button"><?php echo  lang('custom input isforlist');?> </span>
                        </label>
                        <!-- is_date  -->
                        <?php 
                           if(isset($editData['is_date']) && $editData['is_date'] == '1')
                           {
                              $check = 'checked="checked"';
                           }
                           elseif ($this->input->post('is_date') == '1') 
                           {
                              $check = 'checked="checked"';
                           }
                           else
                           {
                              $check = false;
                           }
                           ?>
                        <label class="selectgroup-item">
                        <input type="checkbox" name="is_date" value="1" class="selectgroup-input" <?php echo  $check;?> >
                        <span class="selectgroup-button"><?php echo  lang('custom input is_date');?> </span>
                        </label>
                     </div>
                  </div>
               </div>
               <div class="clearfix mt-5"></div>
               <div class="col-4">
                  <?php echo form_label(lang('custom input displayname'), 'displayname'); ?> 
                  <span class="required">*</span>
                  <?php $populateData = (!empty($this->input->post('displaytitle')) ? $this->input->post('displaytitle') : (!empty($editData['display_name']) && isset($editData['display_name']) ? $editData['display_name'] :  '' ));?>
                  <input type="text" name="displaytitle" id="displayname" class="form-control cat" value="<?php echo $populateData;?>">
               </div>
               <div class="col-4">
                  <?php echo form_label(lang('custom input customlabel'), 'customlabel'); ?>  
                  <span class="required">*</span>
                  <?php $populateData = (!empty($this->input->post('customlabel')) ? $this->input->post('customlabel') : (!empty($editData['custom_label']) && isset($editData['custom_label']) ? $editData['custom_label'] : '' ));?>
                  <input type="text" name="customlabel" id="customlabel" class="form-control cat" value="<?php echo $populateData;?>">
               </div>
               <div class="col-4">
                  <?php echo form_label(lang('custom input customhint'), 'customhint'); ?>
                  <span class="required">*</span>
                  <?php $hint = (!empty($this->input->post('customhint')) ? $this->input->post('customhint') : (!empty($editData['custom_hint']) && isset($editData['custom_hint']) ? $editData['custom_hint'] : '' ));?>
                  <input type="text" name="customhint" id="customhint" class="form-control cat" value="<?php echo $hint;?>">
               </div>
               <div class="length_limit col-12" >
                  <div class="row">
                     <div class="col-6">
                        <?php echo form_label(lang('custom input custommin'), 'custommin'); ?>
                        <?php $minValue = (!empty($this->input->post('minval')) ? $this->input->post('minval') : (!empty($editData['min_value']) && isset($editData['min_value']) ? $editData['min_value']  : '' ));?>
                        <input type="text" name="minval" id="custommin" class="form-control cat" value="<?php echo $minValue;?>">
                     </div>
                     <div class="col-6">
                        <?php echo form_label(lang('custom input custommax'), 'custommax'); ?>
                        <?php $maxValue = (!empty($this->input->post('maxval')) ? $this->input->post('maxval') : (!empty($editData['max_value']) && isset($editData['max_value']) ? $editData['max_value'] : '' ));?>
                        <input type="text" name="maxval" id="custommax" class="form-control cat" value="<?php echo $maxValue;?>">
                     </div>
                  </div>
               </div>
               <?php
                  if(isset($editData['options']))
                  {
                  $result = json_decode($editData['options']);
                  $first_record = $result[0];
                  unset($result[0]);
                  }
                  ?>
               <div class="col-12 add_option" >
                  <?php echo form_label(lang('custom input customoption'), 'customoption'); ?><br/>
                  <?php $first_option = isset(set_value('custom_options')[0]) ? set_value('custom_options')[0] : ((isset($first_record) ? $first_record : '')); ?>
                  <div class="new-text-div">
                     <input type="text" name="custom_options[]" id="customoption" class="form-control addmore" value="<?php echo $first_option;?>">
                     <button class="btn btn-success add_field py-2" id="add"><?php echo lang('admin add more'); ?>
                     <i class="fa fa-plus" aria-hidden="true"></i>
                     </button>
                     <?php 
                        if(isset($result) && $result && empty($this->input->post('custom_options')))
                        {
                              foreach($result as $key => $optionsValue)
                              { ?>
                     <div class="optionparent new-text-div">
                        <input type="text" name="custom_options[]" id="customoption" class="form-control addmore" value="<?php echo $optionsValue;?>">
                        <button class="btn btn-danger removebtn removeoption add_field py-2"> <?php echo lang('admin remove'); ?> 
                        <i class=" px-2 fa fa-times" aria-hidden="true"></i>
                        </button>
                     </div>
                     <?php }
                        }
                        if($this->input->post('custom_options'))
                        {
                           $field_number = 1;
                           $custom_options = $this->input->post('custom_options');
                           unset($custom_options[0]);
                           foreach ($custom_options as $custom_option_val) 
                           {  ?>
                     <div class="optionparent new-text-div">
                        <input type="text" name="custom_options[]" id="customoption" class="form-control addmore" value="<?php echo  $custom_option_val;?>">
                        <button class="btn btn-danger removebtn removeoption add_field py-2"> Remove 
                        <i class=" px-2 fa fa-times" aria-hidden="true"></i>
                        </button>
                     </div>
                     <?php
                        } 
                        } 
                        ?>
                  </div>
               </div>
               <div class="col-12 mt-3">
                  <?php $saveUpdate = isset($editData['id']) && $editData['id'] ? lang('core button update') : lang('core button save'); ?>
                  <input type="submit" name="<?php echo $saveUpdate;?>" value="<?php echo ucfirst($saveUpdate);?>" class="btn-lg btn btn-primary float-right">
                  <a href="<?php echo base_url("admin/customfield");?>" class="btn btn-dark btn-lg float-right mr-3"><?php echo lang('core button cancel'); ?></a>
               </div>
            </div>
            <?php echo form_close(); ?>
         </div>
      </div>
   </div>
</div>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
   <div class="col-12 col-md-12 col-lg-12">
      <a href ='<?php echo base_url("market/product");?>' class="btn btn-light float-right mb-3">Back</a>
      <div class="clearfix"></div>
      <div class="card">
         <div class="card-body">
            <?php echo form_open_multipart('', array('role'=>'form','action'=>$action)); ?>
            <div class="row">
               <div class="col-6">
                  <div class="form-group">
                     <label> Product Name </label>
                     <label class="form-control"> <?php echo $product_info->product_title ?></label>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <?php echo  form_label(lang('product input sku'), 'sku'); ?> <span class="text-danger">*</span>
                     <?php $populateData = (!empty($this->input->post('productsku')) ? $this->input->post('productsku') : (isset($product_variant_data->sku) ? $product_variant_data->sku :  '' ));?>
                     <input type="text" name="productsku" id="p_sku" class="form-control" value="<?php echo $populateData;?>">
                     <span class="small text-danger form-error"> <?php echo strip_tags(form_error('productsku')); ?> </span> 
                  </div>
               </div>
               <!-- custom field Work -->
               <div class="clearfix"></div>
               <div class="col-12">
                  <div class="row Category_Field_data">
                     <?php if($field_groups_of_category){ ?>            
                     <div class="col-2 vertical_tab_menu">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                           <?php $active_class = 'active'; ?>
                           <?php foreach ($field_groups_of_category as  $field_groups_of_category_array) 
                              { 
                                 $custom_field_group_id = $field_groups_of_category_array['custom_field_group_id']; 
                                 $custom_field_group_name = $field_groups_of_category_array['custom_field_group_name']; ?>
                           <a class="nav-link <?php echo $active_class?>" id="v-pills-<?php echo $custom_field_group_id?>-tab" data-toggle="pill" href="#v-pills-<?php echo $custom_field_group_id?>" role="tab" aria-controls="v-pills-<?php echo $custom_field_group_id?>" aria-selected="true"><?php echo $custom_field_group_name?></a>
                           <?php $active_class = ''; 
                              } ?>
                        </div>
                     </div>
                     <div class="col-10">
                        <div class="tab-content" id="v-pills-tabContent vertical_tab_content">
                           <?php $active_class = 'active show'; ?>
                           <?php foreach ($field_groups_of_category as  $field_groups_of_category_array) 
                              {  
                              
                                 $custom_field_group_id = $field_groups_of_category_array['custom_field_group_id']; 
                              $custom_field_group_name = $field_groups_of_category_array['custom_field_group_name']; ?>
                           <div class="tab-pane fade <?php echo $active_class?>  pt-0" id="v-pills-<?php echo $custom_field_group_id?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $custom_field_group_id?>-tab">
                              <h4 class="text-white text-center text-uppercase p-2 bg-info"><?php echo $custom_field_group_name?></h4>
                              <div class="row">
                                 <?php
                                    foreach ($custom_field_group_data[$custom_field_group_id] as $custom_field_group_data_array) 
                                    {
                                       $custom_field_id = $custom_field_group_data_array['custom_field_id']; 
                                    
                                                   $input_selected_value = isset($category_data[$custom_field_id]) ? $category_data[$custom_field_id] : (isset($custom_varient_field_value[$custom_field_id]) ? $custom_varient_field_value[$custom_field_id] :'');
                                    
                                                   $is_required = $custom_field_group_data_array['is_required'];
                                    $is_required = $is_required == 1 ? 'required' : '';
                                    ?>
                                 <div class="col-6">
                                    <div class="form-group mb-0 tab_varient_field">
                                       <label><?php echo $custom_field_group_data_array['custom_label'];?> </label>
                                       <?php
                                          switch ($custom_field_group_data_array['custom_input_type']) 
                                                      {
                                          case 'text': 
                                          $min_value = $custom_field_group_data_array['min_value']; 
                                          $min_value = $min_value > 0 ? 'min="'.$min_value.'"' : '';
                                          
                                          $max_value = $custom_field_group_data_array['max_value'];
                                          $max_value = $max_value > 0 ? 'max="'.$max_value.'"' : '';
                                          
                                          if($custom_field_group_data_array['is_numeric']==1)
                                          {
                                             $type = 'number';
                                          }
                                          elseif($custom_field_group_data_array['is_date']==1)
                                          {
                                             $type = 'date';
                                          }
                                          else
                                          {
                                             $type = 'text';
                                          }
                                          ?>
                                       <input type="<?php echo $type?>" name="custom_field[<?php echo  $custom_field_id ?>]" class="form-control" value="<?php echo $input_selected_value ?>" <?php echo $min_value?> <?php echo $max_value?> <?php echo $is_required?> />
                                       <?php 
                                          break;
                                          
                                          case 'checkbox':
                                             
                                          $optionvalues = json_decode($custom_field_group_data_array['options']);
                                          echo "<div class='form-control'";
                                          foreach($optionvalues as $optionkey => $optionarray)
                                          {
                                             
                                             $selected = ($optionarray == $input_selected_value) ? "checked='checked'" : "";
                                             
                                             echo '<span class="manualchk"><input type="checkbox" name="custom_field['.$custom_field_group_data_array["custom_field_id"].']" class="mx-2" value="'.$optionarray.'" '.$selected.' '.$is_required.'>'.$optionarray.'</span>';
                                          }
                                          echo "</div>";
                                          break;
                                          
                                          case 'radio':
                                             $optionvalues = json_decode($custom_field_group_data_array['options']);
                                             echo "<div class='form-control'";
                                             foreach($optionvalues as $optionkey => $optionarray)
                                             {  
                                                $selected = ($optionarray == $input_selected_value) ? "checked='checked'" : "";
                                                
                                                echo '<span class="manualchk"><input type="radio" name="custom_field['.$custom_field_group_data_array["custom_field_id"].']" class="mx-2" value="'.$optionarray.'" '.$selected.' '.$is_required.'>'.$optionarray.'</span>';
                                             }
                                             echo "</div>";
                                          
                                          break;
                                          
                                          case 'dropdown':
                                             $optionvalues = json_decode($custom_field_group_data_array['options']);
                                          
                                                            echo '<select name="custom_field['.$custom_field_group_data_array["custom_field_id"].']" class="form-control select_dropdown" '.$is_required.'>';
                                                            echo '<option value="">Select Type</option>';
                                          
                                                           
                                                foreach($optionvalues as $optionarray)
                                                {  
                                                   $selected = $optionarray == $input_selected_value ? "selected":"";
                                                                  echo '<option '.$selected.' value="'.$optionarray.'">'.$optionarray.'</option>';
                                                            }
                                                             echo '</select>';
                                          
                                                         break;
                                                         case 'textarea':
                                          
                                          
                                                         $min_value = $custom_field_group_data_array['min_value']; 
                                          $min_value = $min_value > 0 ? 'min="'.$min_value.'"' : '';
                                          
                                          $max_value = $custom_field_group_data_array['max_value'];
                                          $max_value = $max_value > 0 ? 'max="'.$max_value.'"' : '';
                                          ?>
                                       <textarea name="custom_field[<?php echo $custom_field_id?>]" rows="5" class="form-control"  <?php echo $min_value?> <?php echo $max_value?> <?php echo $is_required?> > <?php echo $input_selected_value?></textarea>
                                       <?php
                                          break;      
                                          
                                          }?>
                                       <label class="text-warning"><?php echo $custom_field_group_data_array['custom_hint'];?> </label>
                                    </div>
                                 </div>
                                 <?php    }  ?>
                              </div>
                           </div>
                           <!-- End tab Content -->
                           <?php $active_class = ''; 
                              } ?>
                        </div>
                     </div>
                     <?php    }
                        else
                        {
                           echo '<div class="col-12 mb-3"><div class="form-control text-danger text-center" > No Variend Field Added Yet In This Product Category </div></div>';
                        }
                        ?>             
                  </div>
                  <!-- row End -->
               </div>
               <!-- col-12 end -->
               <div class="clearfix"></div>
               <!-- End custom field Work -->
               


               <div class="col-12">
                  <div class="form-group">
                     <?php echo  form_label(lang('product input upload'), 'upload'); ?>
                     <div class="dropzone clsbox" id="imageupload">
                     </div>
                     <?php if(isset($product_variant_data->product_image) && $product_variant_data->product_image)
                        {
                        
                           $product_image_array = json_decode($product_variant_data->product_image); ?>
                     <div class="row product_uploded_image mt-3">
                        <?php foreach ($product_image_array as  $product_image_name) 
                           {?>
                        <div class="col-1">
                           <img class="img-thumbnail popup" src="<?php echo  base_url('assets/images/product_image')?>/<?php echo $product_image_name?>">
                           <a href="#" class="btn btn-link p-0 delete_product_image" data-image_name = "<?php echo $product_image_name?>" data-variant_id="<?php echo $product_variant_data->variant_id?>">Delete</a>
                        </div>
                        <?php  }?>
                     </div>
                     <?php } ?>
                  </div>
                  <div class="product_image_block">
                  </div>
               </div>
               <?php
                  if(isset($editVariantData['id']))
                  {
                     $break_image = explode(',', $editVariantData['product_image']);
                           if(!empty($break_image)) { 
                              foreach($break_image as $key => $imgvalue ) { ?>
               <div class="col-sm-1">
                  <?php if(!empty($imgvalue)){ ?>
                  <div class="editImage"> 
                     <img src="<?php echo base_url('assets/images/product_image/'.$imgvalue)?>"><br/>
                     <button type="button" data-uploadimg="<?php echo $imgvalue; ?>" data-id="<?php echo $editVariantData['id'];?>" class="btn btn-link py-1 remove_img_btn">Delete</button>
                  </div>
                  <?php } else {}?> 
               </div>
               <?php } } }?>
               <?php $populateData = (!empty($editVariantData['product_image']) && isset($editVariantData['product_image']) ? $editVariantData['product_image'] : '');?>






               <div class="col-12">
                  <?php echo  form_label(lang('product input marketprice'), 'Market Price'); ?>
                  <table class="table">
                     <thead>
                        <tr>
                           <th scope="col">Name</th>
                           <th scope="col">Availabel Product</th>
                           <th scope="col">Base Price</th>
                           <th scope="col">Sale Price</th>
                           <th scope="col">Affiliate Marketing Url</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach($marketname as $key => $marketData) { 
                           ?>
                        <tr  class="market_data">
                           <td scope="row">
                              <?php $populateImg = (!empty($marketData['market_logo']) && isset($marketData['market_logo']) ? base_url('assets\images\market_image\\'.$marketData['market_logo']) : (empty($marketData['market_logo']) ? base_url('assets/images/market_image/default_market.jpg') : '' ));?>
                              <img src="<?php echo  $populateImg;?>" class="market_image" > 
                              <?php echo  ucfirst($marketData['market_title']); ?>
                           </td>
                           <td scope="row">
                              <?php
                                 $checked = '';
                                 if($this->input->post('product['.$marketData["id"].'][saleprice]'))
                                    {
                                       $populateMarket_value = $this->input->post('product['.$marketData["id"].'][saleprice]');
                                    }
                                 elseif(isset($fetch_market_last_data[$marketData['id']]['sale_price']) && $fetch_market_last_data[$marketData['id']]['sale_price'])
                                    {
                                       $checked = 'checked';
                                    }
                                  ?>
                              <label class="custom-switch mt-2">
                              <input type="checkbox" <?php echo $checked; ?> name="custom-switch-checkbox" class="custom-switch-input market_product_status">
                              <span class="custom-switch-indicator indication"></span>
                              </label>
                           </td>
                           <td scope="row">
                              <?php 
                                 if($this->input->post('product['.$marketData["id"].'][baseprice]'))
                                 {
                                    $populateMarket_value = $this->input->post('product['.$marketData["id"].'][baseprice]');
                                    $disabled = '';
                                 }
                                 elseif(isset($fetch_market_last_data[$marketData['id']]['base_price']))
                                 {
                                    $populateMarket_value = $fetch_market_last_data[$marketData['id']]['base_price'];
                                    $disabled = '';
                                 }
                                 else
                                 {
                                    $populateMarket_value = "";
                                    $disabled = 'disabled';
                                 }
                                 ?>
                              <input type="number" <?php echo $disabled; ?> name="product[<?php echo $marketData["id"]?>][baseprice]" class="form-control base_price" value="<?php echo  $populateMarket_value;?>">
                           </td>
                           <td scope="row">
                              <?php 
                                 if($this->input->post('product['.$marketData["id"].'][saleprice]'))
                                 {
                                    $populateMarket_value = $this->input->post('product['.$marketData["id"].'][saleprice]');
                                    $disabled = '';
                                 }
                                 elseif(isset($fetch_market_last_data[$marketData['id']]['sale_price']))
                                 {
                                    $populateMarket_value = $fetch_market_last_data[$marketData['id']]['sale_price'];
                                    $disabled = '';
                                 }
                                 else
                                 {
                                    $populateMarket_value = "";
                                    $disabled = 'disabled';
                                 }
                                 ?>
                              <input type="number" <?php echo $disabled; ?> name="product[<?php echo $marketData["id"]?>][saleprice]" class="form-control sale_price" value="<?php echo   $populateMarket_value;?>">
                           </td>
                           <td scope="row">
                              <?php 
                                 if($this->input->post('product['.$marketData["id"].'][affiliate_marketing_url]'))
                                 {
                                    $populateMarket_value = $this->input->post('product['.$marketData["id"].'][affiliate_marketing_url]');
                                    $disabled = '';
                                 }
                                 elseif(isset($fetch_market_last_data[$marketData['id']]['affiliate_marketing_url']) OR isset($fetch_market_last_data[$marketData['id']]['affiliate_marketing_url'])!=NULL)
                                 {
                                    $populateMarket_value = isset($fetch_market_last_data[$marketData['id']]['affiliate_marketing_url']) ? $fetch_market_last_data[$marketData['id']]['affiliate_marketing_url'] : '';
                                    $disabled = '';
                                 }
                                 else
                                 {
                                    $populateMarket_value = "";
                                    $disabled = 'disabled';
                                 }
                                 ?>
                              <input type="text" <?php echo $disabled; ?> name="product[<?php echo  $marketData["id"]?>][affiliate_marketing_url]" class="form-control affiliate_marketing_url" value="<?php echo  $populateMarket_value;?>">
                           </td>
                        </tr>
                        <?php } ?>
                     </tbody>
                  </table>
               </div>
               <div class="col-12">
                  <?php $saveUpdate = $variant_id ? 'Update' : 'Save';?>
                  <input type="submit" name="<?php echo $form_submit_btn?>" value="<?php echo $form_submit_btn?>" class="btn btn-primary btn-lg">
                  <a href ='<?php echo base_url("market/product");?>' class="btn btn-dark btn-lg cancelbtn">Cancel</a>
               </div>
            </div>
            <?php echo form_close();?>
         </div>
      </div>
   </div>
</div>
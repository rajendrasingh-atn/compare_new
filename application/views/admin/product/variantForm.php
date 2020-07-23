<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
   <div class="col-12 col-md-12 col-lg-12">
      <a href ='<?php echo base_url("admin/product");?>' class="btn btn-light float-right mb-3"><?php echo lang('core button back'); ?></a>
      <div class="clearfix"></div>
      <div class="card">
         <div class="card-body">
            <?php echo form_open_multipart('', array('role'=>'form','action'=>$action, 'novalidate'=>'novalidate')); ?>
            <div class="row">
               <div class="col-6"> 
                  <div class="form-group">
                     <label> <?php echo lang('admin product Product Name'); ?></label>
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
                                       //echo '<pre>';print_r($custom_field_group_data_array);exit;
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


                                          $field_val_arr = isset($custom_varient_field_value[$custom_field_id]) ? json_decode($custom_varient_field_value[$custom_field_id]) : array();

                                          $field_val_arr = is_array($field_val_arr) ? $field_val_arr : array();

                                          $input_selected_value_arr = isset($category_data[$custom_field_id]) && is_array($category_data[$custom_field_id]) ? $category_data[$custom_field_id] : $field_val_arr; 



                                             
                                          $optionvalues = json_decode($custom_field_group_data_array['options']);
                                          echo "<div class='form-control h-100'";
                                          foreach($optionvalues as $optionkey => $optionarray)
                                          {
                                                $selected = '';
                                                foreach ($input_selected_value_arr as $value_key) 
                                                {
                                                   if(empty($selected))
                                                   {
                                                      $selected = $optionarray == $value_key ? "checked='checked'" : "";
                                                   }
                                                }
                                             
                                             echo '<span class="manualchk"><input type="checkbox" name="custom_field['.$custom_field_group_data_array["custom_field_id"].'][]" class="mx-2" value="'.$optionarray.'" '.$selected.' '.$is_required.'>'.$optionarray.'</span>';
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
                  <?php echo  form_label(lang('product input marketprice'), 'Market Price'); ?>
                  <table class="table">
                     <thead>
                        <tr>
                           <th scope="col"><?php echo lang('admin product market list name'); ?></th>
                           <th scope="col"><?php echo lang('admin product market list Base Price'); ?></th>
                           <th scope="col"><?php echo lang('admin product market list Sale Price'); ?></th>
                           <th scope="col"><?php echo lang('admin product market list Affiliate Marketing Url'); ?></th>
                           <th scope="col"></th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $html = '';
                        $html .='<tr class="market_data">
                           <td scope="row">';
                              $firstrecord = isset($fetch_market_data[0]['market_id']) ? $fetch_market_data[0]['market_id'] : '';
                              $html .='<select name="marketname[]" class="form-control marketfield">
                                 <option value="">Select One</option>';
                                    foreach($marketname as $key => $marketData) { 
                                       $firstselected = ($marketData['id'] == $firstrecord) ? "selected" : "";
                                 
                                    $html .='<option '.$firstselected.' value="'.$marketData['id'].'">'.$marketData['market_title'].'</option>';
                                     }
                              $html .='</select>
                              
                           </td>
                           
                           <td scope="row">';
                              $firstrecord = isset($fetch_market_data[0]['base_price']) ? $fetch_market_data[0]['base_price'] : '';   
                              $html .= '<input type="number" name="baseprice[]" class="form-control base_price" value="'.$firstrecord.'">
                           </td>
                           <td scope="row">';
                              $firstrecord = isset($fetch_market_data[0]['sale_price']) ? $fetch_market_data[0]['sale_price'] : '';
                              $html .= '<input type="number" name="saleprice[]" class="form-control sale_price" value="'.$firstrecord.'" required>
                           </td>
                           <td scope="row">';
                              $firstrecord = isset($fetch_market_data[0]['affiliate_marketing_url']) ? $fetch_market_data[0]['affiliate_marketing_url'] : '';
                              $html .= '<input type="text" name="affiliate_marketing_url[]" class="form-control affiliate_marketing_url" value="'.$firstrecord.'">
                           </td>
                           <td class="addbtn"><div class="marketicon btn btn-info float-right"><i class="fa fa-plus" aria-hidden="true"></i></div></td>
                        </tr>'; 
                        echo $html;
                        ?>
                        <?php
                           if(isset($product_variant_data->variant_id) && !empty($product_variant_data->variant_id))
                           {
                              unset($fetch_market_data[0]);
                              foreach($fetch_market_data as $fetch_market_key => $fetch_market_value)
                              {
                         ?>
                                  <tr class="market_data">
                                    <td scope="row">
                                       <?php 
                                          $populate_data = isset($fetch_market_value['market_id']) ? $fetch_market_value['market_id'] : "";
                                       ?>
                                       <select name="marketname[]" class="form-control">
                                          <option>Select One</option>
                                          <?php foreach($marketname as $key => $marketData) {
                                             $selected = ($marketData['id'] == $populate_data) ? "selected" : "";
                                           ?>
                                          <option <?php echo $selected;?> value="<?php echo $marketData['id'];?>"><?php echo $marketData['market_title'];?></option>
                                          <?php } ?>
                                       </select>
                                    </td>
                                    <td scope="row">
                                       <?php 
                                          $populate_data = ($this->input->post('baseprice')[$fetch_market_key] ? $this->input->post('baseprice')[$fetch_market_key] : (isset($fetch_market_value['base_price']) && !empty($fetch_market_value['base_price']) ? $fetch_market_value['base_price'] : ""));
                                       ?>
                                       <input type="number" name="baseprice[]" class="form-control base_price" value="<?php echo $populate_data;?>">
                                    </td>
                                    <td scope="row">
                                       <?php 
                                          $populate_data = ($this->input->post('saleprice')[$fetch_market_key] ? $this->input->post('saleprice')[$fetch_market_key] : (isset($fetch_market_value['sale_price']) && !empty($fetch_market_value['sale_price']) ? $fetch_market_value['sale_price'] : ""));
                                       ?>
                                       <input type="number" name="saleprice[]" class="form-control sale_price" value="<?php echo $populate_data;?>" required>
                                    </td>
                                    <td scope="row">
                                       <?php 
                                          $populate_data = ($this->input->post('affiliate_marketing_url')[$fetch_market_key] ? $this->input->post('affiliate_marketing_url')[$fetch_market_key] : (isset($fetch_market_value['affiliate_marketing_url']) && !empty($fetch_market_value['affiliate_marketing_url']) ? $fetch_market_value['affiliate_marketing_url'] : ""));
                                       ?>
                                       <input type="text" name="affiliate_marketing_url[]" class="form-control affiliate_marketing_url" value="<?php echo $populate_data;?>">
                                    </td>
                                    <td scope='row'>
                                       <div class='remove btn btn-danger removebtn py-2'>Remove<i class='px-2 fa fa-times' aria-hidden='true'></i></div>
                                    </td>
                                 </tr>
                        <?php } 
                           }
                        ?>
                        <!-- <?php if(isset($product_variant_data->variant_id) && !empty($product_variant_data->variant_id)) 
                           {
                              foreach($fetch_additional_market_data as $additional_key => $additional_value)
                              {
                        ?>
                                 <tr class="addition-row">
                                    <td scope="row">
                                       <?php 
                                          $populate_additional_market = ($this->input->post('additionalmarketname')[$additional_key] ? $this->input->post('additionalmarketname')[$additional_key] : (isset($additional_value['market_name']) && !empty($additional_value['market_name']) ? $additional_value['market_name'] : ""));
                                       ?>
                                       <input type="text" class="form-control" name="additionalmarketname[]" id="marketname" value="<?php echo $populate_additional_market; ?>" />
                                    </td>
                                    <td scope="row">
                                       <?php 
                                          $populate_additional_market = ($this->input->post('additionalbaseprice')[$additional_key] ? $this->input->post('additionalbaseprice')[$additional_key] : (isset($additional_value['base_price']) && !empty($additional_value['base_price']) ? $additional_value['base_price'] : ""));
                                       ?>
                                       <input type="number" class="form-control" name="additionalbaseprice[]" id="additionbaseprice" value="<?php echo $populate_additional_market;?>" />
                                    </td>
                                    <td scope="row">
                                       <?php 
                                          $populate_additional_market = ($this->input->post('additionalsaleprice')[$additional_key] ? $this->input->post('additionalsaleprice')[$additional_key] : (isset($additional_value['sale_price']) && !empty($additional_value['sale_price']) ? $additional_value['sale_price'] : ""));
                                       ?>
                                       <input type="number" class="form-control" name="additionalsaleprice[]" id="additionsaleprice" value="<?php echo $populate_additional_market;?>" />
                                    </td>
                                    <td scope="row">
                                       <?php 
                                          $populate_additional_market = ($this->input->post('additionalaffiliateurl')[$additional_key] ? $this->input->post('additionalaffiliateurl')[$additional_key] : (isset($additional_value['affiliate_url']) && !empty($additional_value['affiliate_url']) ? $additional_value['affiliate_url'] : ""));
                                       ?>
                                       <input type="text" class="form-control" name="additionalaffiliateurl[]" id="affiliatemarketurl" value="<?php echo $populate_additional_market;?>" />
                                    </td>
                                    <td scope="row"><div class="remove btn btn-danger removebtn py-2"> Remove <i class=" px-2 fa fa-times" aria-hidden="true"></i> </div></td>
                                 </tr>
                        <?php          
                              }
                           }   
                        ?> -->
                     </tbody>
                  </table>
               </div>
               <div class="col-12">
                  <?php $saveUpdate = $variant_id ? lang('core button update') : lang('core button save'); ?>

                  <input type="submit" name="<?php echo $form_submit_btn?>" value="<?php echo $form_submit_btn?>" class="btn btn-primary btn-lg">

                  <a href ='<?php echo base_url("admin/product");?>' class="btn btn-dark btn-lg cancelbtn"><?php echo lang('core button cancel'); ?></a>

               </div>
            </div>
            <?php echo form_close();?>
         </div>
      </div>
   </div>
</div>
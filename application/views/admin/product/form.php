<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="row">
   <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
         <div class="card-body">
            <?php echo form_open_multipart('', array('role'=>'form','novalidate'=>'novalidate')); ?>
            <div class="row">
               <div class="col-6">
                  <div class="form-group">
                     <?php echo  form_label(lang('product input name'), 'name'); ?> 
                     <span class="required">*</span>
                     <?php $populateData = (!empty($this->input->post('producttitle')) ? $this->input->post('producttitle') : (!empty($product_data['product_title']) && isset($product_data['product_title']) ? $product_data['product_title'] :  '' ));?>
                     <input type="text" name="producttitle" id="p_title" class="form-control" value="<?php echo $populateData;?>">
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <?php echo  form_label(lang('product input sku'), 'sku'); ?> <span class="required">*</span>
                     <?php $populateData = (!empty($this->input->post('productsku')) ? $this->input->post('productsku') : (!empty($product_data['product_title']) && isset($product_data['sku']) ? $product_data['sku'] :  '' ));?>
                     <input type="text" name="productsku" id="p_sku" class="form-control" value="<?php echo $populateData;?>">
                  </div>
               </div>
               <div class="col-12">
                  <div class="form-group">
                     <?php echo  form_label(lang('product input description'), 'description'); ?>
                     <?php $populateData = (!empty($this->input->post('productdescription')) ? $this->input->post('productdescription') : (!empty($product_data['product_description']) && isset($product_data['product_description']) ? $product_data['product_description'] :  '' ));?>
                     <textarea name="productdescription" id="p_desc" class="form-control editor" rows="5" ><?php echo $populateData;?></textarea>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <?php echo  form_label(lang('product input category'), 'category'); ?>
                     <?php $populateData = (!empty($this->input->post('productcategory')) ? $this->input->post('productcategory') : (!empty($product_data['product_category_id']) && isset($product_data['product_category_id']) ? $product_data['product_category_id'] : '' ));
                        if($product_category_info) 
                        { ?>
                     <select class="form-control select_category" id="selectcategory" name="productcategory">
                        <option value="<?php echo $product_category_info->id?>"><?php echo $product_category_info->category_title?></option>
                     </select>
                     <?php 
                        }
                        else
                        { ?>
                     <select class="select_dropdown form-control select_category" id="selectcategory" name="productcategory">
                        <option value=""><?php echo lang('Select Category'); ?></option>
                        <?php foreach($categoryname as $key => $categoryData) { 
                           $selected = ($categoryData['id'] == $populateData) ? "selected" : "";
                           ?>
                        <option <?php echo $selected;?> value="<?php echo  $categoryData['id'];?>"><?php echo  $categoryData['category_title'];?></option>
                        <?php } ?>
                     </select>
                     <?php } ?>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <?php echo  form_label(lang('product input brand'), 'brand'); ?>
                     <?php $populateData = (!empty($this->input->post('productbrand')) ? $this->input->post('productbrand') : (!empty($product_data['product_brand_id']) && isset($product_data['product_brand_id']) ? $product_data['product_brand_id'] : '' )); ?>
                     <select class="select_dropdown form-control" name="productbrand">
                        <option value=""><?php echo lang('Select Brand'); ?></option>
                        <?php foreach($brand as $key => $brandData) { 
                           $selected = ($brandData['id'] == $populateData) ? "selected" : "";
                           ?>
                        <option <?php echo $selected;?> value="<?php echo  $brandData['id'];?>"><?php echo  $brandData['brand_title'];?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <?php echo  form_label(lang('product input metakeyword'), 'metakeyword'); ?> 
                     <div class="clearfix"></div>
                     <?php $populateData = (!empty($this->input->post('metakeyword')) ? $this->input->post('metakeyword') : (!empty($product_data['product_meta_keyword']) && isset($product_data['product_meta_keyword']) ? $product_data['product_meta_keyword'] : '' )); ?>
                     <input type="text" name="metakeyword" id="p_mkeyword" data-role="tagsinput" class="form-control inputtags" value="<?php echo $populateData;?>">
                  </div>
               </div>
               <div class="col-6">
                  <div class="form-group">
                     <?php echo  form_label(lang('product input metadescription'), 'metadescription'); ?>
                     <?php $populateData = (!empty($this->input->post('metadescription')) ? $this->input->post('metadescription') : (!empty($product_data['product_meta_description']) && isset($product_data['product_meta_description']) ? $product_data['product_meta_description'] : '' )); ?>                      
                     <textarea name="metadescription" id="p_mdescription" class="form-control" rows="4" ><?php echo $populateData;?></textarea>
                  </div>
               </div>
               <div class="clearfix"></div>
               <div class="col-12">
                  <div class="row Category_Field_data">
                     <div class="col-2 vertical_tab_menu">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                           <?php $active_class = 'active'; ?>
                           <?php foreach ($field_groups_of_category as  $field_groups_of_category_array) 
                              { 
                                 $custom_field_group_id = $field_groups_of_category_array['custom_field_group_id']; 
                                 $custom_field_group_name = $field_groups_of_category_array['custom_field_group_name']; ?>
                           <a class="nav-link <?php echo $active_class?>" id="v-pills-<?php echo $custom_field_group_id?>-tab" data-toggle="pill" href="#v-pills-<?php echo $custom_field_group_id?>" role="tab" aria-controls="v-pills-<?php echo $custom_field_group_id ?>" ><?php echo $custom_field_group_name?></a>
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
                           <div class="tab-pane fade <?php echo $active_class?>  pt0" id="v-pills-<?php echo $custom_field_group_id?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $custom_field_group_id?>-tab">
                              <h4 class="text-white text-center text-uppercase p-2 bg-info"><?php echo $custom_field_group_name?></h4>
                              <div class="row">
                                 <?php
                                    if($product_id OR $this->input->post(lang('core button save')))
                                                {  
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


                                        /*********************checkbox****************************************/  
                                          case 'checkbox':
                                             
                                             $field_val_arr = isset($custom_varient_field_value[$custom_field_id]) ? json_decode($custom_varient_field_value[$custom_field_id]) : array();

                                             $field_val_arr = is_array($field_val_arr) ? $field_val_arr : array();

                                             $input_selected_value_arr = isset($category_data[$custom_field_id]) && is_array($category_data[$custom_field_id]) ? $category_data[$custom_field_id] : $field_val_arr; 

                                             $optionvalues = json_decode($custom_field_group_data_array['options']);
                                             echo "<div class='form-control h-100'";
                                             foreach($optionvalues as $optionarray)
                                             {
                                                
                                                foreach ($input_selected_value_arr as $value_key) 
                                                {
                                                   if(empty($selected))
                                                   {
                                                      $selected = $optionarray == $value_key ? "checked='checked'" : "";
                                                   }
                                                }
                                                   
                                                echo '<span class="manualchk"><input type="checkbox" name="custom_field['.$custom_field_id.'][]" class="m-2" value="'.$optionarray.'" '.$selected.' '.$is_required.'>'.$optionarray.'</span>';

                                                $selected ='';
                                          
                                             }
                                             echo "</div>";
                                          break;
                                          
                                        /*********************radio btn****************************************/  

                                          case 'radio':
                                             $optionvalues = json_decode($custom_field_group_data_array['options']);
                                             echo "<div class='form-control h-100'";
                                             foreach($optionvalues as $optionkey => $optionarray)
                                             {  
                                                $selected = ($optionarray == $input_selected_value) ? "checked='checked'" : "";
                                                   
                                                echo '<span class="manualchk"><input type="radio" name="custom_field['.$custom_field_id.']" class="mx-2" value="'.$optionarray.'" '.$selected.' '.$is_required.'>'.$optionarray.'</span>';
                                             }
                                             echo "</div>";
                                          break;
                                        /*********************end radio btn****************************************/  
                                          case 'dropdown':
                                                               echo '<select name="custom_field['.$custom_field_id.']" class="form-control select_dropdown" '.$is_required.'>';
                                                               echo '<option value="">Select Type</option>';
                                                              $optionvalues = json_decode($custom_field_group_data_array['options']);
                                                foreach($optionvalues as $optionkey => $optionarray)
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
                                       <textarea name="custom_field[<?php echo $custom_field_id?>]" rows="5" class="form-control" <?php echo $min_value?> <?php echo $max_value?> <?php echo $is_required?> ><?php echo $input_selected_value ?></textarea>';
                                       <?php
                                          break;      
                                          
                                          }?>
                                       <label class="text-warning"><?php echo $custom_field_group_data_array['custom_hint'];?> </label>
                                    </div>
                                 </div>
                                 <?php
                                    }
                                    }?>
                              </div>
                              <!-- end row -->
                           </div>
                           <!-- tab-pane -->
                           <?php $active_class = ''; 
                              }?>
                        </div>
                        <!-- end tab-content -->
                     </div>
                     <!-- col-10 end -->
                  </div>
                  <!-- row End -->
               </div>
               <!-- col-12 end -->
               <div class="clearfix"></div>
               <div class="col-12 mt-4">
                  <div class="form-group">
                     <?php echo  form_label(lang('product input upload'), 'upload');  ?>
                     <div class="dropzone clsbox" id="imageupload">
                     </div>
                     <?php if(isset($get_product_varient->product_image) && $get_product_varient->product_image)
                        {
                        
                           $product_image_array = json_decode($get_product_varient->product_image); ?>
                     <div class="row product_uploded_image mt-3">
                        <?php foreach ($product_image_array as  $product_image_name) 
                           {
                              $product_image_one = get_s3_url('quickcompare/products/'.$product_image_name);
                              ?>
                        <div class="col-1">
                           <img class="img-thumbnail popup" src="<?php echo $product_image_one;?>">
                           <a href="#" class="btn btn-link p-0 delete_product_image" data-image_name = "<?php echo $product_image_name?>" data-variant_id="<?php echo $get_product_varient->id?>">Delete</a>
                        </div>
                        <?php  }?>
                     </div>
                     <?php } ?>
                  </div>
                  <div class="product_image_block">
                  </div>
               </div>
               <div class="col-12">
                  <?php echo  form_label(lang('product input marketprice'), 'upload'); ?> 
                  <table class="table">
                     <thead>
                        <tr>
                           <th scope="col"><?php echo lang('admin product market list name'); ?></th>
                           <th scope="col"><?php echo lang('admin product market list Base Price'); ?></th>
                           <th scope="col"><?php echo lang('admin product market list Sale Price'); ?></th>
                           <th scope="col"><?php echo lang('admin product market list Affiliate Marketing Url'); ?></th>
                           <th scope="col"></th>
                           <!-- <th scope="col"><?php //echo lang('admin product market list Availabel Product'); ?></th> -->
                        </tr>
                     </thead>
                     <tbody>
                        <?php $html = '';
                        $html .='<tr class="market_data">
                           <td scope="row">';
                              $firstrecord = isset($fetchmarketdata[0]['market_id']) ? $fetchmarketdata[0]['market_id'] : '';
                              $html .='<select name="marketname[]" class="form-control marketfield">
                                 <option value="">Select One</option>';
                                    foreach($marketname as $key => $marketData) { 
                                       $firstselected = ($marketData['id'] == $firstrecord) ? "selected" : "";
                                 
                                    $html .='<option '.$firstselected.' value="'.$marketData['id'].'">'.$marketData['market_title'].'</option>';
                                     }
                              $html .='</select>
                              
                           </td>
                           
                           <td scope="row">';
                              $firstrecord = isset($fetchmarketdata[0]['base_price']) ? $fetchmarketdata[0]['base_price'] : '';   
                              $html .= '<input type="number" name="baseprice[]" class="form-control base_price" value="'.$firstrecord.'">
                           </td>
                           <td scope="row">';
                              $firstrecord = isset($fetchmarketdata[0]['sale_price']) ? $fetchmarketdata[0]['sale_price'] : '';
                              $html .= '<input type="number" name="saleprice[]" class="form-control sale_price" value="'.$firstrecord.'" required>
                           </td>
                           <td scope="row">';
                              $firstrecord = isset($fetchmarketdata[0]['affiliate_marketing_url']) ? $fetchmarketdata[0]['affiliate_marketing_url'] : '';
                              $html .= '<input type="text" name="affiliate_marketing_url[]" class="form-control affiliate_marketing_url" value="'.$firstrecord.'">
                           </td>
                           <td class="addbtn"><div class="marketicon btn btn-info float-right"><i class="fa fa-plus" aria-hidden="true"></i></div></td>
                        </tr>'; 
                        echo $html;
                        ?>

                        <?php if(isset($product_data['id']) && !empty($product_data['id']))
                           {
                              unset($fetchmarketdata[0]);
                              foreach($fetchmarketdata as $fetch_market_key => $fetch_market_value)
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
                        <?php         
                              }
                           }
                        ?>

                        <!-- <?php if(isset($product_data['id']) && !empty($product_data['id']))
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
                        ?>
                        <?php 
                           if($additionalmarket_array)
                           {
                              $i = 0;
                              foreach($additionalmarket_array as $add_key => $add_value)
                              {

                                 $i++;
                        ?>
                           <tr class="addition-row">
                              <td scope="row">
                                 <input type="text" class="form-control" name="additionalmarketname[]" id="marketname" value="<?php echo $additionalmarket_array[$add_key]; ?>" />
                              </td>
                              <td scope="row">
                                 <input type="number" class="form-control" name="additionalbaseprice[]" id="additionbaseprice" value="<?php echo $additionalbaseprice_array[$add_key];?>" />
                              </td>
                              <td scope="row">
                                 <input type="number" class="form-control" name="additionalsaleprice[]" id="additionsaleprice" value="<?php echo $additionalsaleprice_array[$add_key];?>" />
                              </td>
                              <td scope="row">
                                 <input type="text" class="form-control" name="additionalaffiliateurl[]" id="affiliatemarketurl" value="<?php echo $additionalaffiurl_array[$add_key];?>" />
                              </td>
                              <td scope="row"><div class="remove btn btn-danger removebtn py-2"> Remove <i class=" px-2 fa fa-times" aria-hidden="true"></i> </div></td>
                           </tr>
                        <?php         
                              }
                           }
                        ?> -->
                     </tbody>
                  </table>
<!--                 
                  <div id="tabledata" class="d-none">
                     <?php echo $html; ?>
                  </div> -->
                  <script type="text/javascript">var jsVar = "$html";</script>
               </div>
               <div class="col-12">
                  <?php $saveUpdate = isset($product_data['id']) && $product_data['id'] ? lang('core button update') : lang('core button save'); ?>
                  <input type="submit" name="<?php echo $saveUpdate;?>" value="<?php echo ucfirst($saveUpdate);?>" class="btn btn-primary btn-lg">
                  <a href='<?php echo base_url("admin/product");?>' class="btn btn-dark btn-lg cancelbtn"><?php echo lang('core button cancel'); ?></a>
               </div>
               <div class="clearfix"></div>
            </div>
            <?php echo form_close();?>
         </div>
      </div>
   </div>
</div>
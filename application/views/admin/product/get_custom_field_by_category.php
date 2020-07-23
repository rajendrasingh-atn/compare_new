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
         $custom_field_group_name = $field_groups_of_category_array['custom_field_group_name']; 
         ?>
      <div class="tab-pane fade <?php echo $active_class?>" id="v-pills-<?php echo $custom_field_group_id?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $custom_field_group_id?>-tab">
         <h4 class="text-white text-center text-uppercase p-2 bg-info"><?php echo $custom_field_group_name?></h4>
         <div class="row">
            <?php 
               foreach ($custom_field_group_data[$custom_field_group_id] as $custom_field_group_data_array) 
                  {
                     $custom_field_id = $custom_field_group_data_array['custom_field_id']; 
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
                  <input type="text" name="custom_field[<?php echo  $custom_field_id ?>]" class="form-control" value="" <?php echo $min_value?> <?php echo $max_value?> <?php echo $is_required?> />
                  <?php 
                     break;



                     case 'checkbox':
                        
                     $optionvalues = json_decode($custom_field_group_data_array['options']);
                     echo "<div class='form-control h-100'";
                     foreach($optionvalues as $optionkey => $optionarray)
                     { ?>
                  <span class="manualchk">
                  <input type="checkbox" class="m-2" name="custom_field[<?php echo $custom_field_group_data_array["custom_field_id"]?>][]" value="<?php echo $optionarray; ?>" <?php echo $is_required ;?> ><?php echo $optionarray ;?> 
                  </span>
                  <?php }
                     echo "</div>";
                     break;



                     case 'radio':
                        $optionvalues = json_decode($custom_field_group_data_array['options']);
                        echo "<div class='form-control'";
                        foreach($optionvalues as $optionkey => $optionarray)
                        {  ?>
                  <span class="manualchk">
                  <input type="radio" name="custom_field[<?php echo $custom_field_group_data_array["custom_field_id"]?>]" class="mx-2" value="<?php echo $optionarray ?>"  <?php echo $is_required ;?> ><?php echo $optionarray; ?> 
                  </span>
                  <?php }
                     echo "</div>";
                     break;
                     


                     case 'dropdown': ?>
                  <select name="custom_field[<?php echo $custom_field_group_data_array["custom_field_id"]?>]" class="form-control select_dropdown" <?php echo $is_required?> >
                  <option value="">Select Type</option>
                  <?php $optionvalues = json_decode($custom_field_group_data_array['options']);
                     foreach($optionvalues as $optionkey => $optionarray)
                     {  
                                 echo '<option  value="'.$optionarray.'">'.$optionarray.'</option>';
                              }
                                 echo '</select>';
                             break;
                     
                             case 'textarea': 
                     
                             $min_value = $custom_field_group_data_array['min_value']; 
                     $min_value = $min_value > 0 ? 'min="'.$min_value.'"' : '';
                     
                     $max_value = $custom_field_group_data_array['max_value'];
                     $max_value = $max_value > 0 ? 'max="'.$max_value.'"' : '';
                     ?>
                  <textarea name="custom_field[<?php echo $custom_field_id?>]" rows="5" class="form-control"  <?php echo $min_value?> <?php echo $max_value?> <?php echo $is_required?> ></textarea>
                  ';
                  <?php break;      
                     }?>
                  <label class="text-warning"><?php echo $custom_field_group_data_array['custom_hint'];?> </label>
               </div>
            </div>
            <?php } ?>
         </div>
      </div>
      <!-- End tab Content -->
      <?php $active_class = ''; 
         } ?>
   </div>
</div>
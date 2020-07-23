<?php
   if($varient_custom_field_values)
   { 
      $i = 0;
      ?>
<div class="panel-group" id="product_varient" role="tablist" aria-multiselectable="true">
   <?php foreach ($varient_custom_field_values as $product_sku => $product_fields_array) 
      { 
         $i++;
         ?>
   <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="varient_<?php echo $i;?>">
         <h4 class="panel-title">
            <a role="button" class="p-2 text-primary h5" data-toggle="collapse" data-parent="#product_varient" href="#collapse_var<?php echo $i;?>" aria-expanded="true" aria-controls="collapse_var<?php echo $i;?>">
            <?php echo $product_sku; ?>
            <i class="fas fa-chevron-down float-right"></i></a>
         </h4>
      </div>
      <div id="collapse_var<?php echo $i;?>" class="panel-collapse collapse in p-2" role="tabpanel" aria-labelledby="heading_<?php echo $i;?>">
         <?php
            foreach ($product_fields_array as $field_name => $custom_field_array) 
            { ?>
         <div class="panel-body">
            <h6 class="text-warning mb-3"><?php echo $field_name; ?></h6>
            <?php
               foreach ($custom_field_array as $field_id => $field_data) 
               { ?>
            <table class="table mb-0 px-3 border-none ">
               <tr>
                  <td width="30%"><span class=''> <?php echo $field_data->custom_field_name; ?> </span></td>
                  <td  width="70%">
                     <span class="ml-5">
                     <?php 

                        $test = @json_decode($field_data->field_value);
                        if(is_array($test))
                        {
                           $value_data = implode(',', $test);
                        }
                        else
                        {
                           $value_data = $field_data->field_value;
                        }

                        echo $value_data; 

                     ?>
                        
                     </span></td>
               </tr>
            </table>
            <?php
               } ?>
         </div>
         <hr>
         <?php
            }
            ?>
      </div>
      <hr>
   </div>
   <?php 
      } ?>
</div>
<?php
   }
   ?>
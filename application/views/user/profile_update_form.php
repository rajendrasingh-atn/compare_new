<?php defined('BASEPATH') OR exit('No direct script access allowed'); //print_r(count_user_alarm_data());exit;?>
<?php
   $currency =  get_admin_setting('currency_code');
   $currency_code =  get_currency_symbol($currency); 
   ?>
<div class="container-fluid pt-5 body_background profile_update_page">
   <div class="container">
      <div class="row">
         <div class="col-12 ">
            <ul class="nav nav-tabs" id="my-profile-Tab" role="tablist">
               <li class="nav-item w-30">
                  <?php 
                        $active_profile = $active_alert = '';

                        if(!empty(count_user_alarm_data()) && count_user_alarm_data()>0)
                        { 
                           $active_alert = 'active show';
                        }
                        else 
                        {
                           $active_profile = 'active show';
                        }
                  ?>
                  <a class="nav-link <?php echo $active_profile;?>" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo lang('Profile User'); ?></a>
               </li>
               <li class="nav-item w-30">
                  <a class="nav-link " id="fav-product-tab" data-toggle="tab" href="#fav-product" role="tab" aria-controls="fav-product" aria-selected="true"><?php echo lang('Favourite Products'); ?></a> 
               </li>
               <li class="nav-item w-30">
                  <a class="nav-link <?php echo $active_alert;?>" id="user-alarm-tab" data-toggle="tab" href="#user_alarm" role="tab" aria-controls="user-alarm-data" aria-selected="true"><?php echo 'User Alarm'; ?></a> 
               </li>
            </ul>
            <div class="tab-content" id="my-profile-TabContent">
               <div class="tab-pane fade <?php echo $active_profile;?>" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                  <div class="card card-primary">
                     <div class="card-header">
                        <h4><?php echo lang('Update Profile'); ?></h4>
                     </div>
                     <div class="card-body">
                        <?php echo form_open_multipart('', array('role'=>'form')); ?>
                        <?php // username ?>
                        <div class="row">
                           <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                              <div class="row">
                                 <div class="form-group col-12<?php echo form_error('username') ? ' has-error' : ''; ?>">
                                    <?php echo form_label(lang('users input username'), 'username', array('class'=>'control-label')); ?>
                                    <span class="required"> * </span>
                                    <?php echo form_input(array('name'=>'username', 'id'=>'username','value'=>set_value('username', (isset($user['username']) ? $user['username'] : '')), 'class'=>'form-control')); ?>
                                    <span class="small text-danger"> <?php echo strip_tags(form_error('username')); ?> </span>
                                 </div>
                              </div>
                              <div class="row">
                                 <?php // first name ?>    
                                 <div class="form-group col-6<?php echo form_error('first_name') ? ' has-error' : ''; ?>">
                                    <?php echo form_label(lang('users input first_name'), 'first_name', array('class'=>'control-label')); ?>
                                    <span class="required">*</span>
                                    <?php echo form_input(array('name'=>'first_name','id'=>'first_name', 'value'=>set_value('first_name', (isset($user['first_name']) ? $user['first_name'] : '')), 'class'=>'form-control')); ?>
                                    <span class="small text-danger"> <?php echo strip_tags(form_error('first_name')); ?> </span>
                                 </div>
                                 <?php // last name ?>
                                 <div class="form-group col-6<?php echo form_error('last_name') ? ' has-error' : ''; ?>">
                                    <?php echo form_label(lang('users input last_name'), 'last_name', array('class'=>'control-label')); ?>
                                    <span class="required">*</span>
                                    <?php echo form_input(array('name'=>'last_name','id'=>'last_name', 'value'=>set_value('last_name', (isset($user['last_name']) ? $user['last_name'] : '')), 'class'=>'form-control')); ?>
                                    <span class="small text-danger"> <?php echo strip_tags(form_error('last_name')); ?> </span>
                                 </div>
                              </div>
                              <div class="row">
                                 <?php // email ?>
                                 <div class="form-group col-6<?php echo form_error('email') ? ' has-error' : ''; ?>">
                                    <?php echo form_label(lang('users input email'), 'email', array('class'=>'control-label')); ?>
                                    <span class="required">*</span>
                                    <?php echo form_input(array('name'=>'email', 'value'=>set_value('email', (isset($user['email']) ? $user['email'] : '')), 'class'=>'form-control', 'type'=>'email')); ?>
                                    <span class="small text-danger"> <?php echo strip_tags(form_error('email')); ?> </span>
                                 </div>
                                 <?php // language ?>
                                 <div class="form-group col-6<?php echo form_error('language') ? ' has-error' : ''; ?>">
                                    <?php echo form_label(lang('users input language'), 'language', array('class'=>'control-label')); ?>
                                    <span class="required">*</span>
                                    <?php echo form_dropdown('language', $this->languages, (isset($user['language']) ? $user['language'] : $this->config->item('language')), 'id="language" class="form-control"'); ?>
                                    <span class="small text-danger"> <?php echo strip_tags(form_error('language')); ?> </span>
                                 </div>
                              </div>
                              <div class="row">
                                 <?php // password ?>
                                 <div class="form-group col-6<?php echo form_error('password') ? ' has-error' : ''; ?>">
                                    <?php echo form_label(lang('users input password'), 'password', array('class'=>'control-label')); ?>
                                    <?php if ($password_required) : ?>
                                    <span class="required">* </span>
                                    <?php endif; ?>
                                    <?php echo form_password(array('name'=>'password', 'value'=>'', 'class'=>'form-control', 'autocomplete'=>'off')); ?>
                                    <span class="small text-danger"> <?php echo strip_tags(form_error('password')); ?> </span>
                                 </div>
                                 <?php // password repeat ?>
                                 <div class="form-group col-6<?php echo form_error('password_repeat') ? ' has-error' : ''; ?>">
                                    <?php echo form_label(lang('users input password_repeat'), 'password_repeat', array('class'=>'control-label')); ?>
                                    <?php if ($password_required) : ?>
                                    <span class="required">* </span>
                                    <?php endif; ?>
                                    <?php echo form_password(array('name'=>'password_repeat', 'value'=>'', 'class'=>'form-control', 'autocomplete'=>'off')); ?>
                                    <span class="small text-danger"> <?php echo strip_tags(form_error('password_repeat')); ?> </span>
                                 </div>
                                 <?php if ( ! $password_required) : ?>
                                 <div class="col-12 mb-3">
                                    <span class="help-block text-warning"><?php echo lang('users help passwords'); ?></span>
                                 </div>
                                 <?php endif; ?>
                              </div>
                              <div class="row d-none">
                                 <div class="form-group col-12<?php echo form_error('password_repeat') ? ' has-error' : ''; ?>">
                                    <?php echo form_label(lang('users input user_image'), 'user_image', array('class'=>'control-label')); ?>
                                    <?php echo form_upload(array('name'=>'user_image','class'=>'form-control'));?>
                                 </div>
                              </div>
                              <?php // buttons ?>
                              <div class="row ">
                                 <div class="form-group col-12 mt-3"> 
                                    <?php if ($this->session->userdata('logged_in')) : ?>
                                    <button type="submit" name="submit" class="btn btn-block btn-primary"><span class="glyphicon glyphicon-save"></span> <?php echo lang('core button save'); ?></button>
                                    <?php else : ?>
                                    <button type="submit" name="submit" class="btn btn-block btn-primary btn-lg"><?php echo lang('users button register'); ?></button>
                                    <?php endif; ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php echo form_close(); ?>      
                     </div>
                  </div>
                  <!-- card premium-->
               </div>
               <!-- End Profile Tab-->
               <div class="tab-pane fade" id="fav-product" role="tabpanel" aria-labelledby="fav-product-tab">
                  <div class="card card-primary">
                     <div class="card-header">
                        <h4><?php echo lang('Favourite Products'); ?></h4>
                     </div>
                     <div class="card-body">
                        <?php
                           if($products)
                           {
                               $product_img_dir = base_url('/assets/images/product_image/');
                               foreach ($products as $products_array) 
                               {
                                   $product_lowest_marcket = json_decode($products_array->product_lowest_marcket);
                                   $product_url = base_url("product/$products_array->category_slug/$products_array->product_slug");
                                   $sale_price = isset($product_lowest_marcket->sale_price) ? $product_lowest_marcket->sale_price : 0.00;                              
                                   $sale = null;
                                   $sale_percentaage = null;
                                   if($product_lowest_marcket)
                                   {
                                       $sale = $product_lowest_marcket->base_price - $product_lowest_marcket->sale_price;
                                       $sale_percentaage = $sale > 0 ? ($sale/$product_lowest_marcket->base_price)*100 : 0;
                                   }
                                   
                                   $product_images = json_decode($products_array->product_image);
                                   $product_image = $product_img_dir.'default.png';
                                   if(isset($product_images[0]) && $product_images[0])
                                   {
                                       $product_image = get_s3_url('quickcompare/products/'.$product_images[0]);
                                   }
                           
                                   $fav_icon = 'text-danger';
                                   ?>
                        <div class="col-12">
                           <!-- Begin Listing: 609 W GRAVERS LN-->
                           <div class="brdr bgc-fff pad-10 box-shad btm-mrg-20 product-listing">
                              <div class="media row">
                                 <div class="product_img_block m-auto">
                                    <span class="ribbon"><?php echo round($sale_percentaage) ?>% off</span>
                                    <a href="<?php echo base_url('remove-from-favourite/').$products_array->product_id; ?>" class="remove_fav_product_btn"> 
                                    <i class="h5 fas fa-heart  <?php echo $fav_icon; ?>"></i> 
                                    </a>
                                    <a class="float-left pt-4 m-auto width_100" href="<?php echo $product_url;?>" target="_parent">
                                    <img alt="image" class="img-responsive width_100 m-auto" src="<?php echo $product_image?>"/>
                                    </a>
                                 </div>
                                 <div class="media-body fnt-smaller px-5 product_detail_block table-responsive">
                                    <h4 class="media-heading">
                                       <a href="<?php echo $product_url;?>" target="_parent"><?php echo $products_array->product_title?> 
                                       <small class="float-right h6"> <?php echo $currency_code.' '.$sale_price; ?></small>
                                       </a>
                                    </h4>
                                    <table class="specsTable">
                                       <tbody>
                                          <tr>
                                             <?php 
                                                $product_short_detail =$products_array->product_short_detail ? $products_array->product_short_detail : '[]';
                                                $product_short_detail_arr = json_decode($product_short_detail);
                                                
                                                foreach ($product_short_detail_arr as $field_group_name => $custom_field_array) 
                                                { ?>
                                             <td class="specstd">
                                                <ul class="specs_ul">
                                                   <li>
                                                      <div class="hd_tlt spcedHead"><?php echo $field_group_name; ?>
                                                      </div>
                                                      <?php
                                                         foreach ($custom_field_array as $custom_field_name => $custom_field_value) 
                                                         { 
                                                             ?>
                                                      <label class="specs_txt positive_value" title="<?php echo $custom_field_value->value; ?>"><?php echo $custom_field_name.' : - '.$custom_field_value->value; ?></label> 
                                                      <?php
                                                         }
                                                         
                                                         ?>
                                                   </li>
                                                </ul>
                                             </td>
                                             <?php
                                                }
                                                ?>
                                          </tr>
                                       </tbody>
                                    </table>
                                    <span class="fnt-smaller fnt-lighter fnt-arial"><?php echo substr(strip_tags($products_array->product_description),0, 250); ?>...</span>
                                 </div>
                              </div>
                           </div>
                           <!-- End Listing-->
                        </div>
                        <!-- col-12-end -->
                        <div class="clearfix"></div>
                        <hr>
                        <?php   
                           }
                           }
                           else
                           {
                           echo '<div class="col-md-3"></div><div class="col-md-9 text-left py-5"> Sorry No Product Found </div>';
                           }
                           ?>
                     </div>
                  </div>
               </div>
               <!-- End Favourite Products Tab-->
               
                <div class="tab-pane fade <?php echo $active_alert;?>" id="user_alarm" role="tabpanel" aria-labelledby="user-alarm-tab">
                   <div class="card card-primary">
                      <div class="card-header">
                        <h4><?php echo 'User Alarm'; ?></h4>
                     </div>
                     <?php if($alarm) { ?>
                        <div class="card-body">
                           <?php foreach($alarm as $alarm_key => $alarm_value)
                              {
                                 //echo '<pre>';print_r($alarm);exit;
                                 $product_images = json_decode($alarm_value->product_image);
                           ?>
                              <?php 
                                 $check_status = (!empty($alarm_value->status) && $alarm_value->status == 1 ? 'status-color' : 'bg-white');
                              ?>
                              <div class="row p-3 <?php echo $check_status;?>" id="status_value_<?php echo $alarm_value->product_variant_id;?>">
                                 <div class="col-3">
                                    <div class="imagemain">
                                       <?php $image = (isset($product_images) && !empty($product_images) ? get_s3_url('quickcompare/products/'.$product_images[0]) : base_url('/assets/images/product_image/default.png')); ?>
                                       <img src="<?php echo $image;?>">
                                       <span class="bell"><i class="fa fa-bell text-success" id ="bellactive" aria-hidden="true" data-variant_id='<?php echo $alarm_value->product_variant_id?>'></i></span>
                                    </div>
                                 </div>
                                 <div class="col-3">
                                    <div class="product-title">
                                       <h3><?php echo $alarm_value->product_title;?></h3>
                                    </div>
                                 </div>
                                 <div class="col-3">
                                    <div class="user-main-price">
                                       <label class="user-price-title">Alarm Price</label>
                                       <span class="price"><?php echo $alarm_value->price;?></span>
                                    </div>
                                    <div class="price-variation-main">
                                       <?php 
                                          $increase_decrease = ($alarm_value->minimum_price - $alarm_value->price) * 100 / $alarm_value->minimum_price;
                                          $result = round($increase_decrease);
                                          //print_r($percentage);exit;
                                          if($alarm_value->minimum_price > $alarm_value->price)
                                          {
                                       ?>   
                                          <div class="variation-inner border border-danger">
                                             <i class="fa fa-arrow-up price-high" aria-hidden="true"> <br/>% <?php echo $result;?></i>
                                          </div>
                                       <?php  } else { ?>
                                          <div class="variation-inner border border-success">
                                             <i class="fa fa-arrow-down price-low" aria-hidden="true"> <br/>% <?php echo $result;?></i>
                                          </div>
                                       <?php  } ?>
                                    </div>
                                    <div class="product-main">
                                       <div class="product-main-price">
                                          <label class="user-price-title">Price</label>
                                          <span class="price"><?php echo $alarm_value->minimum_price;?></span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-3">
                                    <div class="product-title2">
                                       <h3>Product price updated on <?php echo date('d-m-Y',strtotime($alarm_value->updated_date));?></h3>
                                       <?php $redirect_url = base_url("varient/$alarm_value->category_slug/$alarm_value->product_variant_id"); ?> 
                                    </div>
                                    <div class="d-inline"><a href="<?php echo $redirect_url;?>" class="btn btn-primary set-status" data-variant_id="<?php echo $alarm_value->product_variant_id;?>" data-status="<?php echo $alarm_value->status;?>">View More</a></div>
                                    <div class="d-inline"><a href="<?php echo $alarm_value->market_url;?>" target="_blank" class="btn btn-warning change-status" data-variant_id="<?php echo $alarm_value->product_variant_id;?>" data-status="<?php echo $alarm_value->status;?>">Buy Now</a></div>
                                    <div class="mt-2 text-danger">
                                       <?php $date_update = (isset($alarm_value->price_update) && !empty($alarm_value->price_update)  && $alarm_value->price > $alarm_value->minimum_price ? 'Note: Price Below on '.date('d-m-Y',strtotime($alarm_value->price_update)) : "");
                                          echo $date_update;
                                       ?>

                                    </div>
                                 </div>
                              </div>
                              <hr>
                           <?php } ?>
                        </div>
                     <?php } ?>   
                   </div>
                </div>
               <!-- End User Alarm Tab-->
            </div>
            <!-- End Tabs-->
         </div>
         <!-- <col-12> -->
      </div>
      <!---row-->
   </div>
</div>
</div>
<?php
   if ($this->session->userdata('logged_in')) : 
       if(uri_string() == 'user/register')
       {
            return redirect(base_url('profile'));
       }
   endif;
    ?>
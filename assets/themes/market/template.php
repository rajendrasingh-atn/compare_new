<?php defined('BASEPATH') OR exit('No direct script access allowed');
   /**
    * Admin Template
    */
   ?>
<!DOCTYPE html>

   <?php 
   $is_rtl = '';
   $rtl_dir = '';
   $margin_auto = 'mr-auto'; 
   $order_two = NULL; 
   if ($this->session->is_rtl) 
   {
   ?>
   <html lang="en" dir="rtl">
   <?php  
   $is_rtl = 'rtl_language';
   $rtl_dir = 'rtl';
   $margin_auto = 'ml-auto';
   $order_two = 'order-2';
   }
   else
   { 
   ?>
   <html lang="en">
   <?php 
   } 
   ?>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="">
      <link rel="icon" type="image/x-icon" sizes="32x32" href="<?php echo base_url('/assets/images/logo/'); ?><?php echo get_admin_setting('site_favicon'); ?>" />
      <title><?php echo $page_title; ?> - <?php echo $this->settings->site_name; ?></title>


      <?php 
       if ($this->session->is_rtl) 
       {
       ?>
          <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/themes/market/css/");?>/rtl.bootstrap.min.css">
       <?php  
       }
       ?>


      <?php // CSS files ?>
      <?php if (isset($css_files) && is_array($css_files)) : ?>
      <?php foreach ($css_files as $css) : ?>
      <?php if ( ! is_null($css)) : ?>
      <?php $separator = (strstr($css, '?')) ? '&' : '?'; ?>
      <link rel="stylesheet" href="<?php echo $css; ?><?php echo $separator; ?>v=<?php echo $this->settings->site_version; ?>">
      <?php echo "\n"; ?>
      <?php endif; ?>
      <?php endforeach; ?>
      <?php endif; ?>
      <script> 
         var BASE_URL = '<?php echo base_url(); ?>'; 
         var csrf_Name = '<?php echo $this->security->get_csrf_token_name() ?>'; 
         var csrf_Hash = '<?php echo $this->security->get_csrf_hash(); ?>'; 
         var rtl_dir = "<?php echo $rtl_dir; ?>";
         var are_you_sure = "<?php echo lang('Are You Sure'); ?>";
         var permanently_deleted = "<?php echo lang('it will permanently deleted'); ?>";
         var yes_delere_it = "<?php echo lang('yes delere it'); ?>";
         var table_search = "<?php echo lang('table search'); ?>";
         var table_show = "<?php echo lang('table show'); ?>";
         var table_entries = "<?php echo lang('table entries'); ?>";
         var table_showing = "<?php echo lang('Table Showing'); ?>";
         var table_to = "<?php echo lang('table to'); ?>";
         var table_of = "<?php echo lang('table of'); ?>";
         var java_error_msg = "<?php echo lang('java error msg'); ?>";
         var table_previous = "<?php echo lang('table previous'); ?>";
         var table_next = "<?php echo lang('table next'); ?>";

      </script>
   </head>
   <body class="<?php echo $is_rtl; ?>">
      <div id="app">
         <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
               <form class="form-inline <?php echo $margin_auto; ?>">
                  <ul class="navbar-nav mr-3">
                     <li>
                        <a href="<?php echo base_url(''); ?>" data-toggle="sidebar" class="nav-link nav-link-lg">
                        <i class="fas fa-bars"></i>
                        </a>
                     </li>
                     <li>
                        <a href="<?php echo base_url(''); ?>" data-toggle="search" class="nav-link nav-link-lg d-sm-none">
                        <i class="fas fa-search"></i>
                        </a>
                     </li>
                  </ul>
               </form>
               <ul class="navbar-nav navbar-right">


                     <li>
                        <span class="dropdown">
                            <button id="session-language" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default">
                                <i class="fa fa-language"></i>
                                <span class="caret"></span>
                            </button>
                            <ul id="session-language-dropdown" class="dropdown-menu" role="menu" aria-labelledby="session-language">
                                <?php foreach ($this->languages as $key=>$name) : ?>
                                    <li>
                                        <a href="#" rel="<?php echo $key; ?>">
                                            <?php if ($key == $this->session->language) : ?>
                                                <i class="fa fa-check selected-session-language"></i>
                                            <?php endif; ?>
                                            <?php echo $name; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </span>
                    </li>


                  <?php 
                  if($this->session->logged_in && $this->session->logged_in['role'] == 'market')
                  {
                  ?>
                  <li class="dropdown">
                     <a href="<?php echo base_url('market/users/edit/').$this->session->logged_in['id'];?>" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <?php $loginImage = ($this->session->logged_in['image'] ? base_url('assets/images/user_image/'.$this->session->logged_in['image']) : base_url('assets/images/user_image/avatar-1.png'))?>
                        <img alt="" src="<?php echo $loginImage;?>" class="rounded-circle mr-1">
                        <div class="d-sm-none d-lg-inline-block">Hi, <?php echo substr($this->session->logged_in['username'],0,10)."..";?>
                        </div>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right">
                        <a href="<?php echo base_url('profile');?>" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> <?php echo lang('Profile'); ?>
                        </a>
                        
                        <div class="dropdown-divider"></div>

                        <a href="<?php echo base_url('logout'); ?>" class="dropdown-item has-icon"><i class="fas fa-sign-out-alt"></i><?php echo lang('core button logout'); ?>
                        </a>
                     </div>
                  </li>

                  <?php } ?>
               </ul>
            </nav>
            <?php // Fixed navbar ?>

            <div class="main-sidebar sidebar-style-2 " tabindex="1" style="overflow: hidden;outline: none;">
               <aside id="sidebar-wrapper">
                  <div class="sidebar-brand">
                     <a href="<?php echo base_url(); ?>"><?php echo $this->settings->site_name; ?></a>
                  </div>
                  <div class="sidebar-brand sidebar-brand-sm">
                     <?php 
                        $words = explode(" ", $this->settings->site_name);
                        $acronym = "";
                        foreach ($words as $w) 
                        {
                          $acronym .= $w[0];
                        }
                        ?>
                     <a class="text-uppercase" href="<?php echo base_url(); ?>"><?php echo $acronym; ?></a>
                  </div>
                  <ul class="sidebar-menu">
                     
                     <li class="dropdown <?php echo $this->uri->segment(2) == '' || $this->uri->segment(2) == 'index' || $this->uri->segment(2) == 'index_0' ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('market/dashboard'); ?>" class="nav-link">
                        <i class="fas fa-fire"></i>
                        <span><?php echo lang('admin title admin');?></span>
                        </a>
                     </li>




                     <li class="dropdown<?php echo (strstr(uri_string(), 'market/product')) ? ' active' : ''; ?>">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-mobile-alt"></i>
                        <span><?php echo lang('admin button product'); ?></span>
                        </a>
                        <ul class="dropdown-menu">
                           <li class="<?php echo (uri_string() == 'market/product') ? 'active' : ''; ?>">
                              <a href="<?php echo base_url('market/product'); ?>" class="nav-link"><?php echo lang('admin button product_list'); ?>
                              </a>
                           </li>
                           <li class="<?php echo (uri_string() == 'market/product/form') ? 'active' : ''; ?>">
                              <a href="<?php echo base_url('market/product/form'); ?>" class="nav-link"><?php echo lang('admin button product_add'); ?>
                              </a>
                           </li>
                        </ul>
                     </li>




                     
                     <li class="dropdown<?php echo (strstr(uri_string(), 'market/coupon')) ? ' active' : ''; ?>">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-tags"></i>
                        <span><?php echo 'Coupon'; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                           <li class="<?php echo (uri_string() == 'market/coupon') ? 'active' : ''; ?>">
                              <a href="<?php echo base_url('market/coupon'); ?>" class="nav-link"><?php echo 'Coupon List'; ?>
                              </a>
                           </li>
                           <li class="<?php echo (uri_string() == 'market/coupon/add') ? 'active' : ''; ?>">
                              <a href="<?php echo base_url('market/coupon/add'); ?>" class="nav-link"><?php echo 'Coupon Add'; ?>
                              </a>
                           </li>
                        </ul>
                     </li>



                     <li class="<?php echo (uri_string() == 'market/Excel_import') ? 'active' : ''; ?>">
                        <a href="<?php echo base_url('/market/Excel_import'); ?>" class="nav-link">
                        <i class="fas fa-upload"></i>
                        <span><?php echo lang('admin Bulk Import'); ?></span>
                        </a>
                     </li>


                  </ul>
               </aside>
            </div>

            <?php // Main body ?>
            <div class="main-content ">
               <section class="section">
                  <?php // Page title ?>
                  <div class="section-header">
                     <h1><?php echo $page_header; ?></h1>

                  </div>
                  <div class="section-body"></div>
                  <?php // System messages ?>
                  <?php if ($this->session->flashdata('message')) : ?>
                  <div class="alert alert-success alert-dismissible show fade">
                     <div class="alert-body">
                        <button class="close" data-dismiss="alert"><span>x</span></button>
                        <?php echo $this->session->flashdata('message'); ?>
                     </div>
                  </div>
                  <?php /**elseif ($this->session->flashdata('success')) : ?>
                  <div class="alert alert-success alert-dismissible show fade">
                     <div class="alert-body">
                        <button class="close" data-dismiss="alert"><span>x</span></button>
                        <?php echo $this->session->flashdata('success'); ?>
                     </div>
                  </div> <?php */?>
                  
                  <?php elseif ($this->session->flashdata('error')) : ?>
                  <div class="alert alert-danger alert-dismissible show fade">
                     <div class="alert-body">
                        <button class="close" data-dismiss="alert"><span>x</span></button>
                        <?php echo $this->session->flashdata('error'); ?>
                     </div>
                  </div>
                  <?php elseif (validation_errors()) : ?>
                  <div class="alert alert-danger alert-dismissible show fade">
                     <div class="alert-body">
                        <button class="close" data-dismiss="alert"><span>x</span></button>
                        <?php echo validation_errors(); ?>
                     </div>
                  </div>
                  <?php elseif ($this->error) : ?>
                  <div class="alert alert-danger alert-dismissible show fade">
                     <button class="close" data-dismiss="alert"><span>x</span></button>
                     <?php echo $this->error; ?>
                  </div>
                  <?php endif; ?>
                  <?php // Main content ?>
                  <?php echo $content; ?>
               </section>
            </div>


            <?php // Footer ?>
            <footer class="main-footer">
               <div class="footer-left">
                  <p class="text-muted">
                     <?php echo lang('core text page_rendered'); ?>
                     | PHP v<?php echo phpversion(); ?>
                     | MySQL v<?php echo mysqli_get_client_version(); ?>
                     | CodeIgniter v<?php echo CI_VERSION; ?>
                     | <?php echo $this->settings->site_name; ?> v<?php echo $this->settings->site_version; ?>
                  </p>
               </div>
               <div class="footer-right">
               </div>
            </footer>

            <?php // Javascript files ?>
            <?php if (isset($js_files) && is_array($js_files)) : ?>
            <?php foreach ($js_files as $js) : ?>
            <?php if ( ! is_null($js)) : ?>
            <?php $separator = (strstr($js, '?')) ? '&' : '?'; ?>
            <?php echo "\n"; ?><script src="<?php echo $js; ?><?php echo $separator; ?>v=<?php echo $this->settings->site_version; ?>" type="text/javascript" ></script><?php echo "\n"; ?>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php endif; ?>
            <?php if (isset($js_files_i18n) && is_array($js_files_i18n)) : ?>
            <?php foreach ($js_files_i18n as $js) : ?>
            <?php if ( ! is_null($js)) : ?>
            <?php echo "\n"; ?><script type="text/javascript"><?php echo "\n" . $js . "\n"; ?></script><?php echo "\n"; ?>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php endif; ?>

         </div>
      </div>
      <?php if (isset($model_box)){
         echo $model_box;
         } ?>
      <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog model_1000">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Image preview</h4>
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
               </div>
               <div class="modal-body text-center">
                  <img src="" id="imagepreview" style="width: auto; height: auto;" >
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
      <!-- Button trigger modal -->
      <div class="modal fade" tabindex="-1" role="dialog" id="model_box_content">
         <div class="modal-dialog " role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Modal Box</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <p>No Data YEt</p>
               </div>
               <div class="modal-footer bg-whitesmoke br">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Welcome</button>
               </div>
            </div>
         </div>
      </div>
      </div>
      <!-- Button trigger modal -->
      <!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->
   </body>
</html>
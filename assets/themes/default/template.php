<?php defined('BASEPATH') OR exit('No direct script access allowed');
//echo '<pre>';print_r(count_user_alarm_data());exit;
/**
 * Default Public Template
 */
?>
<!DOCTYPE html>
<?php 
$is_rtl = '';
$rtl_dir = '';
if ($this->session->is_rtl) 
{
?>
<html lang="en" dir="rtl">
<?php  
$is_rtl = 'rtl_language';
$rtl_dir = 'rtl';
}
else
{
?>
<html lang="en">
<?php 
}
?>
<!-- <html lang="en" > -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="">
    <link rel="icon" type="image/x-icon" sizes="32x32" href="<?php echo base_url('/assets/images/logo/'); ?><?php echo get_admin_setting('site_favicon'); ?>" />


    <title><?php echo $page_title; ?> - <?php echo $this->settings->site_name; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php 

       $currency =  get_admin_setting('currency_code');
       $currency_code =  get_currency_symbol($currency);


      if(isset($categoru_description_or_brand) && $categoru_description_or_brand)
      {
        ?>

        <meta name="keywords" content="<?php echo $categoru_description_or_brand['brand_tags'].$categoru_description_or_brand['category_names']; ?>">
        <!-- <meta name="description" content="<?php echo $categoru_description_or_brand['category_description']; ?>"> -->

        <?php
      }
      else
      { ?>

        <meta name="keywords" content="<?php echo $this->settings->meta_keywords; ?>">
        <!-- <meta name="description" content="<?php echo $this->settings->meta_description; ?>"> -->

        <?php
      }


      if(isset($details_page_product_meta) && $details_page_product_meta)
      {
        $details_page_img_arr = json_decode($details_page_product_meta->product_image,true); 
        $details_page_img = (isset($details_page_img_arr[0]) && $details_page_img_arr[0]) ? $details_page_img_arr[0] : 'default.png';
        $details_page_img = base_url('/assets/images/product_image/').$details_page_img;
        $detail_lowest_market = json_decode($details_page_product_meta->product_lowest_marcket);
        $detail_lowest_base_price = isset($detail_lowest_market->base_price) && $detail_lowest_market->base_price ? $detail_lowest_market->base_price : 00.0;
        $detail_lowest_sale_price = isset($detail_lowest_market->sale_price) && $detail_lowest_market->sale_price ? $detail_lowest_market->sale_price : 00.0;

        ?>

        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="<?php echo $details_page_product_meta->product_title; ?>">
        <meta itemprop="description" content="<?php echo substr(strip_tags($details_page_product_meta->product_description),0, 200); ?>...">

        <meta itemprop="image" content="<?php echo $details_page_img; ?>">

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="<?php echo $details_page_product_meta->category_title; ?>">
        <meta name="twitter:site" content="@<?php echo $this->settings->site_name; ?>">
        <meta name="twitter:title" content="<?php echo $details_page_product_meta->product_title; ?>">
        <meta name="twitter:description" content="<?php echo substr(strip_tags($details_page_product_meta->product_description),0, 200); ?>...">
        <meta name="twitter:creator" content="@<?php echo $this->settings->site_name; ?>">
        <meta name="twitter:image" content="<?php echo $details_page_img; ?>">
        <meta name="twitter:data1" content="<?php echo $currency_code.' '.$detail_lowest_sale_price ?>">
        <meta name="twitter:label1" content="Sale Price">
        <meta name="twitter:data2" content="<?php echo $currency_code.' '.$detail_lowest_base_price ?>">
        <meta name="twitter:label2" content="Base Price">

        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo $details_page_product_meta->product_title; ?>" />
        <meta property="og:type" content="<?php echo $details_page_product_meta->category_title; ?>" />
        <meta property="og:app_id" content="2486410284933204" />

        <meta property="og:url" content="<?php echo base_url('product/').$details_page_product_meta->category_slug.'/'.$details_page_product_meta->product_slug; ?>" />
        <meta property="og:image" content="<?php echo $details_page_img; ?>" />
        <meta property="og:description" content="<?php echo substr(strip_tags($details_page_product_meta->product_description),0, 200); ?>..." />
        <meta property="og:site_name" content="<?php echo $this->settings->site_name; ?>" />
        <meta property="og:price:amount" content="<?php echo $detail_lowest_sale_price; ?>" />
        <meta property="og:price:currency" content="<?php echo $currency_code; ?>" />

        <?php
      }
     ?> 

   <?php 
    if ($this->session->is_rtl) 
    {
    ?>
       <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/themes/admin/css/");?>/rtl.bootstrap.min.css">
    <?php  
    }
    ?>

    <?php // CSS files ?>
    <?php if (isset($css_files) && is_array($css_files)) : ?>
        <?php foreach ($css_files as $css) : ?>
            <?php if ( ! is_null($css)) : ?>
                <?php $separator = (strstr($css, '?')) ? '&' : '?'; ?>
                <link rel="stylesheet" href="<?php echo $css; ?><?php echo $separator; ?>v=<?php echo $this->settings->site_version; ?>"><?php echo "\n"; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <script> 
        var BASE_URL = '<?php echo base_url(); ?>'; 
        var csrf_Name = '<?php echo $this->security->get_csrf_token_name() ?>'; 
        var csrf_Hash = '<?php echo $this->security->get_csrf_hash(); ?>'; 
        var rtl_dir = "<?php echo $rtl_dir; ?>";
    </script>

</head>
<body class="<?php echo $is_rtl; ?>">


  <!-- Back to top button -->
  <a id="btt-button"><i class="fas fa-arrow-up"></i></a>
  <input type="hidden" id="main_base_url" value="<?php echo base_url()?>">

    <div id="app">
        <div class="section">

          <header>
    <div class="top"></div>
    <section class="header2">
      <div class="container">
        <div class="row header-inner">
          <div class="col-md-2 my-auto log_div">
            <a class="text-white" href="<?php echo base_url()?>"><img src="<?php echo base_url('/assets/images/logo/'); ?><?php echo get_admin_setting('site_logo'); ?>" alt='<?php echo $this->settings->site_name; ?>'></a>
          </div>
          <div class="col-md-7">
            <div class="dropdown">
              <div class="header-category dropdown-toggle w-80" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="nav-bar"><i class="fa fa-bars" aria-hidden="true"></i></span>
                <label class="category-text">Category</label>
              </div>
                <?php $all_category_array =  get_all_category_helper(); 
                  if($all_category_array)
                    {
                ?>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php foreach ($all_category_array as $menu_category) { ?>
                      <a class="dropdown-item" href="<?php echo base_url('search/').$menu_category->category_slug?>"><?php echo $menu_category->category_title; ?></a>
                    <?php } ?>
                  </div>
                <?php } ?>
            </div>
          
            <div class="header-search">
              <input type="text" class="search-text" placeholder="category name">
              <span class="search-icon"><i class="fa fa-search" aria-hidden="true"></i></span>
            </div>
          </div>
          <div class="col-md-3">
            <div class="header-cart"><i class="fa fa-bell" aria-hidden="true"></i>
              <?php 
                if(!empty(count_user_alarm_data()) && count_user_alarm_data() > 0)
                {
              ?>
                <a href="<?php echo base_url('/profile'); ?>"><span class="cart-count"><?php echo count_user_alarm_data();?></span></a>
              <?php } ?>
            </div>
            <?php if ($this->session->userdata('logged_in')) 
              { 
                $username = "";
                $username = strlen($this->session->userdata('logged_in')['username']) > 6 ? substr($this->session->userdata('logged_in')['username'],0,6) ."..." : $this->session->userdata('logged_in')['username'];
                if ($this->user['is_admin'])
                { 

            ?>
            <div class="dropdown header-login">
              <div class="dropdown-toggle  <?php echo (uri_string() == 'profile') ? 'active' : ''; ?>" id="dropdownlogoutbutton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="nav-bar"><i class="fa fa-user" aria-hidden="true"></i></span>

                  <label class="category-text"><?php echo $username;?></label>  
              </div>

              <div class="dropdown-menu" aria-labelledby="dropdownlogoutbutton">
                <a title="Profile" class="dropdown-item nav-link" href="<?php echo base_url('/profile'); ?>">Profile</a>
                <a title="Logout" class="dropdown-item nav-link" href="<?php echo base_url('/logout'); ?>">Logout</a>
              </div>
            </div>
             <?php  } elseif ($this->user['role']=='market') { ?>
              <div class="header-login  <?php echo (uri_string() == 'profile') ? 'active' : ''; ?>">
                <a title="Profile" class="header-profile" href="<?php echo base_url('/market'); ?>">
                  <i class="h4 fas fa-user-cog"></i>
                </a>
              </div>
            <?php } else { ?>
              <div class="dropdown header-login">
                <div class="dropdown-toggle  <?php echo (uri_string() == 'profile') ? 'active' : ''; ?>" id="dropdownlogoutbutton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="nav-bar"><i class="fa fa-user" aria-hidden="true"></i></span>
                    <label class="category-text"><?php echo $username;?></label>
                </div>

                <div class="dropdown-menu" aria-labelledby="dropdownlogoutbutton">
                  <a title="Profile" class="dropdown-item nav-link" href="<?php echo base_url('/profile'); ?>">Profile</a>
                  <a title="Logout" class="dropdown-item nav-link" href="<?php echo base_url('/logout'); ?>">Logout</a>
                </div>
              </div>
            <?php } } else { ?>
                <div class="header-login  <?php echo (uri_string() == 'login') ? 'active' : ''; ?>">
                  <a title="Sign In" class="header-profile alert-nav" href="<?php echo base_url('/login'); ?>">
                    <span class="nav-bar"><i class="fa fa-user" aria-hidden="true"></i></span>
                    <label class="category-text">Login</label>
                  </a>
                </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </section>
  </header>

        <!-- <div class=" container-fluid bg-primary py-1 text-white top_header_onfo">
        <div class="container">
            <div class="row px-3 py-1 ">
                
                <div class="col-md-5 my-auto text-small left_info">
                  <?php if(get_admin_setting('site_phone_number') != '') { ?>
                    <a class="text-white pr-3 no_underline" href="tel:<?php echo str_replace(' ', '',get_admin_setting('site_phone_number')); ?>"><i class="mr-2 fas fa-phone-volume"></i><?php echo get_admin_setting('site_phone_number'); ?></a>
                  <?php } ?>
                  <?php if(get_admin_setting('site_email') != '') { ?>
                    <a class="text-white no_underline" href="mailto:<?php echo get_admin_setting('site_email'); ?>"> <i class="mr-2 far fa-envelope"></i><?php echo get_admin_setting('site_email'); ?></a>
                  <?php } ?>
                </div>


                <div class="col-md-6 text-right my-auto text-small right_info">
                  <?php if(get_admin_setting('site_facebook_url')!='') { ?>
                    
                    <a class="fb-ic" href="<?php echo get_admin_setting('site_facebook_url'); ?>" target="_blank">
                      <i class="fab fa-facebook-f fa-lg  mr-4 text-white"> </i>
                    </a>
                  <?php } ?>

                  <?php if(get_admin_setting('site_twitter_url')!='') { ?>
                    
                    <a class="tw-ic"  href="<?php echo get_admin_setting('site_twitter_url'); ?>" target="_blank">
                      <i class="fab fa-twitter fa-lg   mr-4 text-white"> </i>
                    </a>
                  <?php } ?>

                  <?php if(get_admin_setting('site_google_plus_url')!='') { ?>
                    
                    <a class="gplus-ic"  href="<?php echo get_admin_setting('site_google_plus_url'); ?>" target="_blank">
                      <i class="fab fa-google-plus-g fa-lg  mr-4 text-white"> </i>
                    </a>
                  <?php } ?>

                  <?php if(get_admin_setting('site_linkedin_url')!='') { ?>
                    
                    <a class="li-ic"  href="<?php echo get_admin_setting('site_linkedin_url'); ?>" target="_blank">
                      <i class="fab fa-linkedin-in fa-lg  mr-4 text-white"> </i>
                    </a>
                  <?php } ?>

                  <?php if(get_admin_setting('site_instagram_url')!='') { ?>
                    
                    <a class="ins-ic"  href="<?php echo get_admin_setting('site_instagram_url'); ?>" target="_blank">
                      <i class="fab fa-instagram fa-lg  mr-4 text-white "> </i>
                    </a>
                  <?php } ?>

                  <?php if(get_admin_setting('site_pininterest_url')!='') { ?>
                    
                    <a class="pin-ic"  href="<?php echo get_admin_setting('site_pininterest_url'); ?>" target="_blank">
                      <i class="fab fa-pinterest fa-lg text-white"> </i>
                    </a>
                  <?php } ?>

                  </div>

                  <div class="col-md-1 text-right my-auto text-small right_info">
                    <nav class="navbar navbar-expand-lg navbar-dark p-0">
                      <ul class="session-lang-dropdown">
                       <li>
                          <span class="dropdown">
                            <button id="session-language" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default">
                              <i class="fa fa-language"></i>
                              <span class="caret"></span>
                            </button>
                            <ul id="session-language-dropdown" class="dropdown-menu" role="menu" aria-labelledby="session-language">
                              <?php foreach ($this->languages as $key=>$name) : ?>
                                <li>


                                  <a href="<?php echo base_url('change-language'); ?>" rel="<?php echo $key; ?>">
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
                      </ul>
                    </nav>
                  </div>

                </div>
                

                </div>
            </div> -->
          

    <!-- <div class="container-fluid  header_nav">
      <div class="container">
        
        <div class="row">
            <div class="col-md-3 my-auto log_div">
                <a class="navbar-brand text-white" href="<?php echo base_url()?>"><img class="logo" src="<?php echo base_url('/assets/images/logo/'); ?><?php echo get_admin_setting('site_logo'); ?>" alt='<?php echo $this->settings->site_name; ?>'></a>
            </div>
        
         
            <div class="col-md-9 my-auto">

                <nav class="navbar navbar-expand-lg navbar-dark p-0">
                 
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>

                  <div class="collapse navbar-collapse " id="navbarColor02">
                    <ul class="navbar-nav">

                        <?php $menu_category_array =  parent_categories(); 

                          if($menu_category_array)
                          {
                            foreach ($menu_category_array as $menu_category) 
                            { 

                              $child_categories =  child_categories($menu_category->id); 
                              if($child_categories)
                              { ?>

                              <li class="nav-item dropdown <?php echo (uri_string() == 'search/'.$menu_category->category_slug) ? 'active' : ''; ?>">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="<?php echo base_url('search/').$menu_category->category_slug?>" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $menu_category->category_title; ?></a>
                                <div class="dropdown-menu bg-dark text-white border-0" >
                                   <?php
                                    foreach ($child_categories as $other_menu_category) 
                                    { ?>
                                      <a class="dropdown-item" href="<?php echo base_url('search/').$other_menu_category->category_slug?>"><?php echo $other_menu_category->category_title; ?>
                                      </a>
                                     <?php
                                    } ?>
                                </div>
                              </li>

                                <?php
                              } 
                              else 
                              { 
                                ?>

                              <li class="nav-item <?php echo (uri_string() == 'search/'.$menu_category->category_slug) ? 'active' : ''; ?>">
                                <a class="nav-link" href="<?php echo base_url('search/').$menu_category->category_slug?>"><?php echo $menu_category->category_title; ?></a>
                              </li>


                            <?php } ?>


                             <?php
                            }
                          }
                        ?>

                        <?php $other_menu_category_array =  get_other_menu_item_helper(); 

                          if($other_menu_category_array)
                          { ?>

                            <li class="nav-item dropdown <?php echo (uri_string() == 'Other') ? 'active' : ''; ?>">
                              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="<?php echo base_url()?>" role="button" aria-haspopup="true" aria-expanded="false"> <?php echo lang('Other'); ?></a>
                                <div class="dropdown-menu bg-dark text-white border-0" >
                                   <?php
                                    foreach ($other_menu_category_array as $other_menu_category) 
                                    { ?>

                                      <a class="dropdown-item" href="<?php echo base_url('search/').$other_menu_category->category_slug?>"><?php echo $other_menu_category->category_title; ?>
                                        
                                      </a>

                                     <?php
                                    } ?>

                                </div>
                          </li>

                            <?php
                          }
                        ?>

                      <li class="nav-item <?php echo (uri_string() == 'Compare') ? 'active' : ''; ?> comapre_products_nav">
                        <a class="nav-link" href="javascript:void(0)"><?php echo lang('Compare');?> 
                          <span class="badge badge-dark">
                            <?php 
                            echo $this->session->userdata('Compare_products') ? count($this->session->userdata('Compare_products')) : 0;
                            ?>
                            </span>
                        </a>
                        <div class="comapre_products bg-white p-2 display-none">
                          <?php if($this->session->userdata('Compare_products'))
                          {
                            foreach ($this->session->userdata('Compare_products') as $key => $pro_slug) 
                            {
                              echo " <h5 class='text-left'>".$pro_slug."</h5>";
                            }
                          }
                          else
                          {
                            echo " <h5 class=''> ".lang('No Product Added Yet')."</h5>";
                          }
                          ?>
                         
                        </div>
                      </li>

                       
                      <li class="nav-item <?php echo (uri_string() == 'coupons/list') ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo base_url('coupons/list')?>"> Coupon</a>
                      </li>   
                      

                      <li class="nav-item <?php echo (uri_string() == 'contact') ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo base_url('contact')?>"><?php echo lang('contact'); ?> </a>
                      </li>


                       <?php if ($this->session->userdata('logged_in')) 
                        { 
                          if ($this->user['is_admin'])
                          { ?>

                              <li class="nav-item <?php echo (uri_string() == 'profile') ? 'active' : ''; ?>">
                                <a title="Profile" class="nav-link alert-nav" href="<?php echo base_url('/profile'); ?>">
                                  <i class="h4 fas fa-user-circle">
                                    <?php 
                                      if(!empty(count_user_alarm_data()) && count_user_alarm_data() > 0)
                                      {

                                    ?>
                                      <span class="aler-data"><?php echo count_user_alarm_data();?></span>
                                    <?php } ?>
                                  </i>
                                </a>
                              </li>

                              <li class="nav-item <?php echo (uri_string() == 'logout') ? 'active' : ''; ?>">
                                <a title="Logout" class="nav-link" href="<?php echo base_url('/logout'); ?>">
                                  <i class="h4 fas fa-sign-out-alt"></i>
                                </a>
                              </li>


                              <?php
                          }
                          elseif ($this->user['role']=='market')
                          { ?>

                              <li class="nav-item <?php echo (uri_string() == 'profile') ? 'active' : ''; ?>">
                                <a title="Profile" class="nav-link" href="<?php echo base_url('/market'); ?>">
                                  <i class="h4 fas fa-user-cog"></i>
                                </a>
                              </li>

                              <li class="nav-item <?php echo (uri_string() == 'logout') ? 'active' : ''; ?>">
                                <a title="Logout" class="nav-link" href="<?php echo base_url('/logout'); ?>">
                                  <i class="h4 fas fa-sign-out-alt"></i>
                                </a>
                              </li>


                              <?php
                          }
                          else
                          { ?>
                              <li class="nav-item <?php echo (uri_string() == 'profile') ? 'active' : ''; ?>">
                                <a title="Profile" class="nav-link alert-nav" href="<?php echo base_url('/profile'); ?>">
                                  <i class="h4 fas fa-user-circle">
                                    <?php 
                                      if(!empty(count_user_alarm_data()) && count_user_alarm_data() > 0)
                                      {

                                    ?>
                                      <span class="aler-data"><?php echo count_user_alarm_data();?></span>
                                    <?php } ?>
                                  </i>
                                </a>
                              </li>

                              <li class="nav-item <?php echo (uri_string() == 'user/logout') ? 'active' : ''; ?>">
                                <a title="Logout" class="nav-link" href="<?php echo base_url('user/logout'); ?>">
                                  <i class="h4 fas fa-sign-out-alt"></i>
                                </a>
                              </li>

                              <?php 
                          }
                        }  
                        else
                        { ?>

                          <li class="nav-item <?php echo (uri_string() == 'login') ? 'active' : ''; ?>">
                                <a title="Sign In" class="nav-link" href="<?php echo base_url('/login'); ?>">
                                   <i class="h4 fas fa-sign-in-alt"></i>
                                </a>
                          </li>

                          <?php
                        }
                        ?> 


                      
                    </ul>
                  </div>
                </nav>
            </div>
        </div>
    </div>
  </div> -->



<?php // Main body ?>
<?php if($this->session->flashdata() OR $this->error) : ?>
<div class="container-fluid body_background">
   <div class="container">
    <?php // System messages ?>
    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-success alert-dismissable flashdata">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $this->session->flashdata('message'); ?>
        </div>
    <?php elseif ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissable flashdata">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $this->session->flashdata('error'); ?>
        </div>

    <?php elseif ($this->error) : ?>
        <div class="alert alert-danger alert-dismissable flashdata">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $this->error; ?>
        </div>
    <?php endif; ?>
  </div>
</div>

<?php endif; ?>



<?php // Main content ?>
<?php echo $content; ?>

<!-- Footer -->

<footer>
    <section class="last-section mt-3">
      <div class="container">
        <div class="row pt-5">
          <div class="col-md-2 col-half-right-offset">
            <div class="footer-menu">
              <h3>xdraf.com</h3>
              <ul>
                <li><a href="#">asdfasd</a></li>
                <li><a href="#">asdfasd</a></li>
                <li><a href="#">asdfasd</a></li>
                <li><a href="#">asdfasd</a></li>
                <li><a href="#">asdfasd</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-2 col-half-offset2">
            <div class="footer-menu">
              <h3>Popular Category</h3>
              <?php $all_category_array =  get_all_category_helper(); 
                  if($all_category_array) { ?>
              <ul>
                <?php  foreach ($all_category_array as $menu_category) {  ?>
                  <li><a href="<?php echo base_url('search/').$menu_category->category_slug?>"><?php echo $menu_category->category_title; ?></a></li>
                <?php } ?>  
              </ul>
            <?php } ?>
            </div>
          </div>
          <div class="col-md-2 col-half-offset2">
            <div class="footer-menu">
              <h3>xdraf.com</h3>
              <ul>
                <li><a href="#">asdfasd</a></li>
                <li><a href="#">asdfasd</a></li>
                <li><a href="#">asdfasd</a></li>
                <li><a href="#">asdfasd</a></li>
                <li><a href="#">asdfasd</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-2 col-half-offset2">
            <div class="footer-menu">
              <h3>xdraf.com</h3>
              <ul>
                <li><a href="#">asdfasd</a></li>
                <li><a href="#">asdfasd</a></li>
                <li><a href="#">asdfasd</a></li>
                <li><a href="#">asdfasd</a></li>
                <li><a href="#">asdfasd</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-2 col-half-offset2">
            <div class="footer-menu">
              <h3>xdraf.com</h3>
              <ul>
                <li><a href="#">asdfasd</a></li>
                <li><a href="#">asdfasd</a></li>
                <li><a href="#">asdfasd</a></li>
                <li><a href="#">asdfasd</a></li>
                <li><a href="#">asdfasd</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-12">
            <div class="footer-border pt-3 pb-3"></div>
          </div>
          <div class="col-md-2 mt-3 log_div">
            <div class="footer-logo">
              <a class="navbar-brand text-white" href="<?php echo base_url()?>"><img class="logo" src="<?php echo base_url('/assets/images/logo/'); ?><?php echo get_admin_setting('site_logo'); ?>" alt='<?php echo $this->settings->site_name; ?>'></a>
            </div>
          </div>
          <div class="col-md-2 mt-3 text-center">
            <?php if(get_admin_setting('site_facebook_url')!='') { ?>
              <div class="footer-social"><a class="" href="<?php echo get_admin_setting('site_facebook_url'); ?>" target="_blank">
                <i class="fab fa-facebook-f fa-lg social-icon"> </i></a>
              </div>
            <?php } ?>
            <?php if(get_admin_setting('site_instagram_url')!='') { ?>
              <div class="footer-social"><a class="" href="<?php echo get_admin_setting('site_instagram_url'); ?>" target="_blank">
                <i class="fab fa-instagram fa-lg social-icon"> </i></a>
              </div>
            <?php } ?>
            <?php if(get_admin_setting('site_twitter_url')!='') { ?>
              <div class="footer-social"><a class="" href="<?php echo get_admin_setting('site_twitter_url'); ?>" target="_blank">
                <i class="fab fa-twitter fa-lg social-icon"> </i></a>
              </div>
            <?php } ?>
            <?php if(get_admin_setting('site_linkedin_url')!='') { ?>
              <div class="footer-social"><a class="" href="<?php echo get_admin_setting('site_linkedin_url'); ?>" target="_blank">
                <i class="fab fa-linkedin-in fa-lg social-icon"> </i></a>
              </div>
            <?php } ?>
          </div>
          <div class="col-md-3 mt-3">
            <div class="app-store"><img src="<?php echo base_url('assets/images/app-store.jpg');?>"></div>
            <div class="app-store"><img src="<?php echo base_url('assets/images/google-play.jpg');?>"></div>
          </div>
          <div class="col-md-5 mt-3">
            <div class="footer-policy">
              <ul>
                <li><a href="#">asdfasdf</a></li>
                <li><a href="#">asdfasdf asdfadsfasdf</a></li>
                <li><a href="#">asdfasdf</a></li>
                <li><a href="#">asdfasdf</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 mt-5">
            <div class="copyright"><p>© <?php echo date('Y')?> Email address 
              <?php if(get_admin_setting('site_email') != '') { ?>
                <a class="no_underline" href="mailto:<?php echo get_admin_setting('site_email'); ?>"><?php echo get_admin_setting('site_email'); ?></a>
                <?php } ?><br/>
              <?php if(get_admin_setting('site_phone_number') != '') { ?>
                    <a class=" pr-3 no_underline" href="tel:<?php echo str_replace(' ', '',get_admin_setting('site_phone_number')); ?>">Mobile No: <?php echo get_admin_setting('site_phone_number'); ?></a></p>
                  <?php } ?>
            </div>
          </div>
          <div class="col-md-6 mt-5">
            <div class="copyright"><p>&copy 2000-2020 shop biligi san ve tic ac Kayliti electronic post address shopbiligiknolojileri@hs06.kep.tr Mersis No: 00165469894645656</p></div>
          </div>
        </div>
      </div>
    </section>
  </footer>

<!-- <footer class="page-footer font-small special-color-dark ">


<div class="alert text-center cookiealert" role="alert">
    <b><?php echo lang('Do you like cookies'); ?></b> &#x1F36A; <?php echo lang('We use cookies'); ?> <a href="https://cookiesandyou.com/" target="_blank"><?php echo lang('Learn more'); ?></a>

    <button type="button" class="btn btn-primary btn-sm acceptcookies" aria-label="Close">
        I agree
    </button>
</div>



  <div class="container-fluid bg-dark p-5">

    <div class="container">
              
              <div class="row">

                
                <div class="col-md-4 mt-md-0 mt-3">

                  
                  <h5 class="text-uppercase font-weight-bold text-white"> <?php echo lang('Footer Text Heading'); ?></h5> 
                  <p class="text-white">
                     <?php echo lang('Footer Text'); ?>
                     <?php //echo get_admin_setting('footer_text_heading'); ?>
                     <?php// echo get_admin_setting('site_footer_text');  ?>
                  </p>

                </div>
             
                

                <hr class="clearfix w-100 d-md-none">

                
                <div class="col-md-4 mx-auto">

                
                  <h5 class="font-weight-bold text-uppercase  mb-3 text-white"><?php echo lang('Categories'); ?></h5>

                  <ul class="list-unstyled text-white category">
                    <?php $all_category_array =  get_all_category_helper(); 

                    if($all_category_array)
                    {
                      foreach ($all_category_array as $menu_category) 
                      { 
                
                        ?>
                        <li>
                          <a class="text-white text-link" href="<?php echo base_url('search/').$menu_category->category_slug?>"><?php echo $menu_category->category_title; ?> </a>
                        </li>
                       <?php
                      }
                    } ?>

                  </ul>

                </div>
                

                
                <div class="col-md-4 mb-4">
                  <h5 class="font-weight-bold text-uppercase  mb-3 text-white"><?php echo lang('AVAILABLE MARKETS'); ?></h5>

                  <div class="width_100 market_logos">
                    <ul>
                      <?php 
                        $markets_all = get_footer_markets_helper(true);

                        foreach ($markets_all as  $market_array) 
                        { 
                          $f_market_logo = $market_array->market_logo? $market_array->market_logo :'default.png';
                          $f_market_logo = base_url('assets/images/market_image/').$f_market_logo;
                          ?>
                          <li class="m-2">
                            <a target="_blank" href="<?php echo $market_array->market_url; ?>" class="d-flex">
                              <img src="<?php echo $f_market_logo; ?>" alt="<?php echo $market_array->market_title; ?>" class="market_logo">
                            </a>
                          </li>

                          <?php
                        }
                      ?>
                    </ul>
                  </div>
                </div> 

                
                <hr class="clearfix w-100 d-md-none">

              </div> 

            </div>
          </div>

          
          <div class="bg-primary footer-copyright text-center py-3 text-white">
            <div class="container">
              <div class="row">
                <div class="col-md-6 text-left">
                  <?php echo $this->settings->site_name; ?> v<?php echo $this->settings->site_version; ?>
                </div>
                <div class="col-md-6 text-right">
                  © <?php echo date('Y')?> <?php echo lang('Copyright'); ?>
                </div>
              </div>
            </div>
          </div>
          

          </footer> -->



          <?php // Javascript files ?>
          <?php if (isset($js_files) && is_array($js_files)) : ?>
              <?php foreach ($js_files as $js) : ?>
                  <?php if ( ! is_null($js)) : ?>
                      <?php $separator = (strstr($js, '?')) ? '&' : '?'; ?>
                      <?php echo "\n"; ?><script src="<?php echo $js; ?><?php echo $separator; ?>v=<?php echo $this->settings->site_version; ?>" defer ></script><?php echo "\n"; ?>
                  <?php endif; ?>
              <?php endforeach; ?>
          <?php endif; ?>
          <?php if (isset($js_files_i18n) && is_array($js_files_i18n)) : ?>
              <?php foreach ($js_files_i18n as $js) : ?>
                  <?php if ( ! is_null($js)) : ?>
                      <?php echo "\n"; ?><script ><?php echo "\n" . $js . "\n"; ?></script><?php echo "\n"; ?>
                  <?php endif; ?>
              <?php endforeach; ?>
          <?php endif; ?>

        </div>
    </div>


</body>
</html>

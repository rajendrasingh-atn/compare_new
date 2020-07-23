<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller']   					= 'Home_Controller';
$route['404_override']         					= 'errors/error404';
$route['translate_uri_dashes'] 					= TRUE;

$route['login']                					= 'user/login';
$route['logout']               					= 'user/logout';
$route['admin']                					= 'admin/dashboard';
$route['market']                				= 'market/dashboard';

$route['sitemap\.xml']         					= 'sitemap';

$route['search/(:any)/(:any)']         			= 'Filter_Controller/search/$1/$2';
$route['search/(:any)']         				= 'Filter_Controller/search/$1';
$route['product/(:any)']         		        = 'Product_detail_Controller/contactseller/$1';
$route['product/(:any)/(:any)']         		= 'Product_detail_Controller/index/$1/$2';

$route['rating/(:any)']         		        = 'Product_detail_Controller/submit_rating';
$route['review_like/(:any)']         		    = 'Product_detail_Controller/review_insert';
$route['review_dislike/(:any)']         		= 'Product_detail_Controller/review_delete';
$route['alert/(:any)']         					= 'Product_detail_Controller/insert_alert_data';
$route['remove_alert/(:any)']         		    = 'Product_detail_Controller/delete_alert_data';
$route['get_comment/(:any)']         		    = 'Product_detail_Controller/get_more_comment';

$route['compare/(:any)']         				= 'Compare_Controller/index/$1';
$route['compare-product/(:any)/(:any)']         = 'Compare_Controller/compare_product/$1/$2';
$route['compare-product-remove/(:any)/(:any)']  = 'Compare_Controller/compare_product_remove/$1/$2';
$route['compare-product-nav-data']  			= 'Compare_Controller/compare_product_nav_data';
$route['admin/admin-setting']  					= 'Admin_setting_Controller/index';

$route['remove-from-favourite/(:num)']  		= 'Profile/remove_from_favourite/$1';
$route['add-to-fav-product/(:num)']  			= 'Home_Controller/add_to_fav_product/$1';
$route['remove_alarm/(:any)']  					= 'Profile/remove_user_alarm';
$route['status_change/(:any)']  				= 'Profile/update_user_alarm_status';

$route['user/reset-my-password/(:any)'] 		= 'User/reset_password_form/$1';
$route['user/update-my-password'] 				= 'Home_Controller/update_user_password';

$route['coupons/list'] 							= 'Home_Controller/coupons';

$route['varient/(:any)/(:any)']         		= 'Varient_detail_Controller/index/$1/$2';

$route['google-login']         		= 'User_Authentication/index';

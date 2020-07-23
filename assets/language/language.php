<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Admin Language File
 */

// Titles
$lang['admin title admin']                = "Dashboard";
$lang['admin compre portal']              = "Compare Portal";
$lang['admin cmp portal']                 = "CMP";

// Buttons
$lang['admin button csv_export']          = "CSV Export";
$lang['admin button dashboard']           = "Dashboard";
$lang['admin button delete']              = "Delete";
$lang['admin button edit']                = "Edit";
$lang['admin button messages']            = "Messages";
$lang['admin button settings']            = "Settings";
$lang['admin button language']            = "Language";
$lang['admin button users']               = "Users";
$lang['admin button users_add']           = "Add New User";
$lang['admin button users_list']          = "List Users";
$lang['admin button category']            = "Categories";
$lang['admin button category_list']       = "List Category";
$lang['admin button category_add']        = "Add New Category";
$lang['admin button custom']              = "Custom Fields";
$lang['admin button custom group']        = "Custom Field Group";
$lang['admin button custom_list']         = "List Custom";
$lang['admin button customfield_add']     = "Add New Custom Field";
$lang['admin button catecustom_list']     = "List Custom Group ";
$lang['admin button catecustomfield_add'] = "Add Custom Group";
$lang['admin button brand']               = "Brands";
$lang['admin button brand_list']          = "List Brand";
$lang['admin button brand_add']           = "Add New Brand";
$lang['admin button market']              = "Market";
$lang['admin button market_list']         = "List Market";
$lang['admin button market_add']          = "Add New Market";
$lang['admin button product']             = "Product";
$lang['admin button product_list']        = "List Product";
$lang['admin button product_add']          = "Add New Product";

// Tooltips
$lang['admin tooltip csv_export']         = "Export a CSV file of all results with filters applied.";
$lang['admin tooltip filter']             = "Update results based on your filters.";
$lang['admin tooltip filter_reset']       = "Clear all your filters and sorting.";

// Form Inputs
$lang['admin input active']               = "Active";
$lang['admin input inactive']             = "Inactive";
$lang['admin input items_per_page']       = "items/page";
$lang['admin input select']               = "select...";
$lang['admin input username']             = "Username";

// Table Columns
$lang['admin col actions']                = "Actions";
$lang['admin col status']                 = "Status";

// Form Labels
$lang['admin label rows']                 = "%s row(s)";




/**********************************************************************************************************
 * 											Contact Language File
 ***********************************************************************************************************/

// Titles
$lang['contact title']                  = "Contact Us";
$lang['contact title messages_list']    = "Messages";

// Buttons
$lang['contact button read']            = "Read Message";

// Table Columns
$lang['contact col message_id']         = "ID";
$lang['contact col name']               = "Name";
$lang['contact col email']              = "Email";
$lang['contact col title']              = "Title";
$lang['contact col created']            = "Received";

// Form Inputs
$lang['contact input name']             = "Name";
$lang['contact input email']            = "Email";
$lang['contact input title']            = "Title";
$lang['contact input message']          = "Message";
$lang['contact input captcha']          = "CAPTCHA Text";
$lang['contact input created']          = "Received";

// Messages
$lang['contact msg send_success']       = "Thanks for contacting us, %s! Your message has been sent.";
$lang['contact msg updated']            = "Message updated!";

// Errors
$lang['contact error captcha']          = "The CAPTCHA text did not match.";
$lang['contact error send_failed']      = "Sorry, %s. There was a problem sending your message. Please try again.";
$lang['contact error update_failed']    = "Could not update status.";


/**********************************************************************************************************
 * 											 Core Language File - English
 ***********************************************************************************************************/


// Buttons
$lang['core button admin']                  = "Admin";
$lang['core button cancel']              	= "Cancel";
$lang['core button close']               	= "Close";
$lang['core button contact']               	= "Contact";
$lang['core button filter']              	= "Filter";
$lang['core button home']                	= "Home";
$lang['core button login']               	= "Login";
$lang['core button logout']              	= "Logout";
$lang['core button profile']              	= "Profile";
$lang['core button reset']               	= "Reset";
$lang['core button save']                	= "Save";
$lang['core button search']              	= "Search";
$lang['core button toggle_nav']          	= "Toggle navigation";
$lang['core button return_home']            = "Return Home";

// Text
$lang['core text no']                    	= "No";
$lang['core text yes']                   	= "Yes";
$lang['core text page_rendered']            = "Page rendered in <strong>{elapsed_time}</strong> seconds";
$lang['core text oops']                     = "OOPS!";
$lang['core text 404_error']                = "You requested a page that does not exist.";

// Emails
$lang['core email start']                	= "<!DOCTYPE html><html><head><style>
                                                    body { background: #fff; color: #333; }
                                               </style></head><body>";
$lang['core email end']                  	= "</body></html>";

// Additional date_lang
$lang['UM75']	                         	= "(UTC -7:00) Arizona Time";

// Errors
$lang['core error no_results']              = "No results found!";
$lang['core error page_not_found']          = "Page Not Found";
$lang['core error session_language']        = "There was a problem setting the language!";
$lang['core error direct_access_forbidden'] = "Direct accesss is forbidden!";


/**********************************************************************************************************
 * 											 Admin Dashboard Language File
 ***********************************************************************************************************/


// Text
$lang['admin dashboard text welcome']  = "Hello and welcome to the dashboard!";

// Buttons
$lang['admin dashboard btn demo']      = "Click for Jsi18n Demo";

// Jsi18n Demo
$lang['admin dashboard jsi18n-sample'] = "This is a demonstration of the Jsi18n library. It takes text from a language file and inserts it into your Javascripts. See the jsi18n.php library and dashboard_i18n.js for usage.";



/**********************************************************************************************************
 * 											 Welcome Language File
 ***********************************************************************************************************/


$lang['home']                       = "Compare %s";

// Content
$lang['welcome content view_location']       = "If you would like to edit this page you'll find the View located at:";
$lang['welcome content controller_location'] = "The corresponding Controller for this page is found at:";
$lang['welcome content ci_docs']             = "If you are exploring CodeIgniter for the very first time, you should start by reading the <a href=\"http://www.codeigniter.com/userguide3/index.html\" target=\"_blank\">User Guide</a>.";
$lang['welcome content click_here']          = "CLICK HERE";
$lang['welcome content sample_api']          = "view sample API output of users. This is for demo purposes only! Be sure to remove the users API before putting your site in a production environment.";
$lang['welcome content sample_profile']      = "view a sample user profile.";
$lang['welcome content sample_admin']        = "view the admin interface.";
$lang['welcome content username']            = "Username";
$lang['welcome content or_email']            = "OR Email";
$lang['welcome content password']            = "Password";
$lang['welcome content 404_error']           = "view custom 404 error page.";
$lang['welcome content sitemap']             = "view dynamic sitemap.";


$lang['search']                       = "Search Page";



/**********************************************************************************************************
 * 											  Settings Language File
 ***********************************************************************************************************/

// Titles
$lang['admin settings title']             = "Settings";

// Messages
$lang['admin settings msg save_success']  = "Settings have been successfully saved.";

// Errors
$lang['admin settings error save_failed'] = "There was a problem saving settings. Please try again.";




/**********************************************************************************************************
 * 											  Users Language File
 ***********************************************************************************************************/




// Titles
$lang['users title forgot']                   = "Forgot Password";
$lang['users title login']                    = "Login";
$lang['users title profile']                  = "Profile";
$lang['users title register']                 = "Register";
$lang['users title user_add']                 = "Add User";
$lang['users title user_delete']              = "Confirm Delete User";
$lang['users title user_edit']                = "Edit User";
$lang['users title user_list']                = "User List";

$lang['category title category_list']         = "Category List";
$lang['language language name']         		= "Language Name";
$lang['category title category_add']          = "Add Category";
$lang['category title category_edit']         = "Edit Category";

$lang['customfield title custom_list']        = "Custom Field List";
$lang['customfield title customfield_add']    = "Add Custom Field";
$lang['customfield title customfield_edit']   = "Edit Custom Field";

$lang['customfield title catcustom_list']     = "Custom Field Categories List";
$lang['customfield title catcustomfield_add'] = "Add Custom Field Categories";
$lang['customfield title catcustomfield_edit']= "Edit Custom Field Categories";

$lang['category title custom label']          = "Set Label";

$lang['brand title brand_list']            	  = "Brand List";
$lang['brand title brand_add']                = "Add Brand";
$lang['brand title brand_edit']               = "Edit Brand";

$lang['market title market_list']             = "Market List";
$lang['market title market_add']              = "Add Market";
$lang['market title market_edit']             = "Edit Market";

$lang['product title product_list']           = "Product List";
$lang['product title product_add']            = "Add Product";
$lang['product title product_edit']           = "Edit Product";

$lang['product title variant_list']           = "Variant List";
$lang['product title variant_add']            = "Add Variant";
$lang['product title variant_edit']           = "Edit Variant";

// Buttons
$lang['users button add_new_user']            = "Add New User";
$lang['users button register']                = "Create Account";
$lang['users button reset_password']          = "Reset Password";
$lang['users button login_try_again']         = "Try Again";

// Tooltips
$lang['users tooltip add_new_user']           = "Create a brand new user.";

// Links
$lang['users link forgot_password']           = "Forgot your password?";
$lang['users link register_account']          = "Register for an account.";

// Table Columns
$lang['users col first_name']                 = "First Name";
$lang['users col is_admin']                   = "Admin";
$lang['users col last_name']                  = "Last Name";
$lang['users col user_id']                    = "ID";
$lang['users col username']                   = "Username";

// Form Inputs
$lang['users input email']                    = "Email";
$lang['users input first_name']               = "First Name";
$lang['users input is_admin']                 = "Is Admin";
$lang['users input language']                 = "Language";
$lang['users input last_name']                = "Last Name";
$lang['users input password']                 = "Password";
$lang['users input password_repeat']          = "Repeat Password";
$lang['users input user_image']               = "User Image";
$lang['users input status']                   = "Status";
$lang['users input username']                 = "Username";
$lang['users input username_email']           = "Username or Email";

$lang['category input title']                 = "Title";
$lang['category input parentcategory']        = "Parent Category";
$lang['category input categorydesc']          = "Description";
$lang['category input categoryicon']          = "Icon";
$lang['category input categoryimage']         = "Upload";

$lang['custom input displayname']             = "Name On Front";
$lang['custom input customlabel']			  = "Name On Admin Panel";
$lang['custom input categorycustomfield']	  = "Custom Field Group";
$lang['custom input customtype']			  = "Input Field Type";
$lang['custom input isnum']			          = "Is Numeric";
$lang['custom input isreq']			          = "Is Required";
$lang['custom input isvariant']			      = "Is Variant";
$lang['custom input is_date']			      = "Is Date";
$lang['custom input isforfront']			  = "Display On Front";
$lang['custom input isforlist']			  	  = "Display On List Page";
$lang['custom input isforfilter']		      = "Available For Filter";
$lang['custom input custommin']			      = "Min Value";
$lang['custom input custommax']			      = "Max Value";
$lang['custom input customhint']			  = "Hint For This Field";
$lang['custom input customoption']			  = "Options"; 
$lang['custom input validation']			  = "Field Validation"; 


$lang['custom input catcustomname']           = "Title";
$lang['custom input catcustomicon']			  = "Icon";


$lang['brand input name']                     = "Title";
$lang['brand input description']              = "Description";
$lang['brand input upload']                   = "Upload";
$lang['market input name']                    = "Title";
$lang['market input description']             = "Description";
$lang['market input upload']                  = "Upload";
$lang['product input name']                   = "Title";
$lang['product input description']            = "Description";
$lang['product input upload']                 = "Upload";
$lang['product input sku']					  = "Product Sku";
$lang['product input metakeyword']			  = "Meta Keyword";
$lang['product input metadescription']		  = "Meta Description";	
$lang['product input category']			      = "Select Category";
$lang['product input brand']			  	  = "Select Brand";
$lang['product input customfield']			  = "Custom Field";
$lang['product input marketprice']			  = "Market Price";

// Help
$lang['users help passwords']                 = "Only enter passwords if you want to change it.";

// Messages
$lang['users msg add_user_success']           = "%s was successfully added!";
$lang['users msg delete_confirm']             = "Are you sure you want to delete <strong>%s</strong>? This can not be undone.";
$lang['users msg delete_user']                = "You have succesfully deleted <strong>%s</strong>!";
$lang['users msg edit_profile_success']       = "Your profile was successfully modified!";
$lang['users msg edit_user_success']          = "%s was successfully modified!";
$lang['users msg register_success']           = "Thanks for registering, %s! Check your email for a confirmation message. Once
                                                 your account has been verified, you will be able to log in with the credentials
                                                 you provided.";
$lang['users msg password_reset_success']     = "Your password has been reset, %s! Please check your email for your new temporary password.";
$lang['users msg validate_success']           = "Your account has been verified. You may now log in to your account.";
$lang['users msg email_new_account']          = "<p>Thank you for creating an account at %s. Click the link below to validate your
                                                 email address and activate your account.<br /><br /><a href=\"%s\">%s</a></p>";
$lang['users msg email_new_account_title']    = "New Account for ";
$lang['users msg email_password_reset']       = "<p>Your password for %s Can be reset By This Link. <br /><br /><strong>%s</strong><br /><br /><a href=\"%s\">%s</a>
                                                </p>";
$lang['users msg email_password_reset_title'] = "Password Reset for ";

// Errors
$lang['users error add_user_failed']          = "%s could not be added!";
$lang['users error delete_user']              = "<strong>%s</strong> could not be deleted!";
$lang['users error edit_profile_failed']      = "Your profile could not be modified!";
$lang['users error edit_user_failed']         = "%s could not be modified!";
$lang['users error email_exists']             = "The email <strong>%s</strong> already exists!";
$lang['users error email_not_exists']         = "That email does not exists!";
$lang['users error invalid_login']            = "Invalid username or password";
$lang['users error password_reset_failed']    = "There was a problem resetting your password Or Your is not Active.";
$lang['users error register_failed']          = "Your account could not be created at this time. Please try again.";
$lang['users error user_id_required']         = "A numeric user ID is required!";
$lang['users error user_not_exist']           = "That user does not exist!";
$lang['users error username_exists']          = "The username <strong>%s</strong> already exists!";
$lang['users error validate_failed']          = "There was a problem validating your account. Please try again.";
$lang['users error too_many_login_attempts']  = "You've made too many attempts to log in too quickly. Please wait %s seconds and try again.";




/**********************************************************************************************************
 * 											 * Welcome Language File
 ***********************************************************************************************************/



// Titles
$lang['welcome title']                       = "Welcome to %s";

// Content
$lang['welcome content view_location']       = "If you would like to edit this page you'll find the View located at:";
$lang['welcome content controller_location'] = "The corresponding Controller for this page is found at:";
$lang['welcome content ci_docs']             = "If you are exploring CodeIgniter for the very first time, you should start by reading the <a href=\"http://www.codeigniter.com/userguide3/index.html\" target=\"_blank\">User Guide</a>.";
$lang['welcome content click_here']          = "CLICK HERE";
$lang['welcome content sample_api']          = "view sample API output of users. This is for demo purposes only! Be sure to remove the users API before putting your site in a production environment.";
$lang['welcome content sample_profile']      = "view a sample user profile.";
$lang['welcome content sample_admin']        = "view the admin interface.";
$lang['welcome content username']            = "Username";
$lang['welcome content or_email']            = "OR Email";
$lang['welcome content password']            = "Password";
$lang['welcome content 404_error']           = "view custom 404 error page.";
$lang['welcome content sitemap']             = "view dynamic sitemap.";



/**********************************************************************************************************
 * 											 Admin Dashboard Language File
 ***********************************************************************************************************/







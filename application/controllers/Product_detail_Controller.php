<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Product_detail_Controller extends Public_Controller {
    /**
     * Constructor
     */
    function __construct() 
    {
        parent::__construct();
        $this->lang->load('language');
        $this->load->model('Product_detail_Model');
        $this->load->library('form_validation');
        $this->add_css_theme('sweetalert.css');
        $this->add_external_js(base_url("assets/themes/default/js/slick.min.js"));
        $this->add_external_css(base_url("assets/themes/default/css/slick-theme.css"));
        $this->add_external_css(base_url("assets/themes/default/css/slick.css"));
        $this->add_external_css(base_url("assets/themes/default/css/magnific-popup.css"));
        $this->add_external_js(base_url("assets/themes/default/js/jquery.magnific-popup.min.js"));
        
        $this->add_js_theme('sweetalert-dev.js');
        $this->add_js_theme('Chart.min.js');
        $this->add_js_theme('utils.js');
        $this->add_js_theme('product_detail.js');

        // load the captcha helper  
        $this->load->helper('captcha');

    }
    function index($category_slug = NULL, $product_slug = NULL) 
    {
        // $this->load->helper('my_date'); 
        
        $captcha = create_captcha(array('img_path' => "./{$this->settings->captcha_folder}/", 'img_url' => base_url("/{$this->settings->captcha_folder}/"), 'font_path' => FCPATH . "{$this->settings->themes_folder}/core/fonts/bromine/Bromine.ttf", 'img_width' => 170, 'img_height' => 50));
        $captcha_data = array('captcha_time' => $captcha['time'], 'ip_address' => $this->input->ip_address(), 'word' => $captcha['word']);
        $this->Product_detail_Model->save_captcha($captcha_data);
                
        $this->set_title(lang('Product Details'));
        $this->add_js_theme('product_detail.js');   
        $data = $this->includes;
        $products = $this->Product_detail_Model->product_data($category_slug, $product_slug);
        //echo '<pre>';print_r($products);exit;

        if (empty($products)) {
            return redirect(base_url('404_override'));
        }
        $userid = $this->session->userdata('logged_in')['id'];
        $product_id = $products->product_id;
        $variant_id = $products->product_varient_id;
        //print_r($variant_id);exit;
        $product_comments = $this->Product_detail_Model->get_product_related_comment($variant_id);

        $count_product_id = $this->Product_detail_Model->get_total_rating_related_product($variant_id);
        //echo '<pre>';print_r($count_product_id);exit;
        $comments_exist_with_productid_userid = $this->Product_detail_Model->get_comment_through_variantid_userid($variant_id,$userid);

        $get_user_alarm = $user_alarm_exist = "";
        
        if(isset($userid) && !empty($userid))
        {
            $user_alarm_exist = $this->Product_detail_Model->get_alarm_through_userid_variantid($variant_id,$userid); 
            $get_user_alarm = $this->Product_detail_Model->get_alarm_data($variant_id,$userid);
        }
        //print_r($get_user_alarm);exit;
        //$one_star = $two_star = $tree_star = $four_star = $five_star = 0;

        $rating_star = [0, 0, 0, 0, 0];
        foreach ($product_comments as $rating_key => $rating_value) 
        {
            if($rating_value->rating == 1) $rating_star[0]++;
            if($rating_value->rating == 2) $rating_star[1]++;
            if($rating_value->rating == 3) $rating_star[2]++;
            if($rating_value->rating == 4) $rating_star[3]++;
            if($rating_value->rating == 5) $rating_star[4]++;
        }
        if($count_product_id->Total)
        {

            $average = ($rating_star[0] * 1 + $rating_star[1] * 2 + $rating_star[2] * 3 + $rating_star[3] * 4 + $rating_star[4] * 5) / $count_product_id->Total;
        }
        else
        {
            $average = 0;
        }
        $this->visitor($product_id);
        $product_all_varients = $this->Product_detail_Model->product_all_varients($product_id);
        $product_markets = $this->Product_detail_Model->get_product_markets($products->product_varient_id);
        //$product_additional_market_price = $this->Product_detail_Model->get_additional_markets_price($products->product_varient_id);
        //echo '<pre>';print_r($count_product_id);exit;
        $varient_values = array();
        $varient_custom_field_values = array();
        foreach ($product_all_varients as $varient_array) {
            $product_varient_id = $varient_array->product_varient_id;
            $product_sku = $varient_array->product_sku;
            $varient_values[$product_sku] = $this->Product_detail_Model->get_varient_values($product_varient_id);
        }
        if ($varient_values) {
            foreach ($varient_values as $product_sku => $varient_values_array) 
            {
                foreach ($varient_values_array as $group_field_array) 
                {
                    // $varient_custom_field_values[$product_sku][$group_field_array->field_group_name][$group_field_array->custom_field_id] = $group_field_array;
                    $varient_custom_field_values[$product_sku][$group_field_array->custom_field_name] = $group_field_array->field_value;
                    $varient_custom_field_values[$product_sku]['product_variant_id'] = $group_field_array->product_variant_id;
                }
            }
        }


        if ($this->session->userdata('Compare_products')) {
            $compare_session = $this->session->userdata('Compare_products');
        } else {
            $this->session->set_userdata('Compare_products', array());
            $compare_session = $this->session->userdata('Compare_products');
        }


        $product_tags = $products->product_meta_keyword.',';
        $categoru_description_or_brand = array('category_description' => $products->product_meta_description,'brand_tags'=>$product_tags,'category_names'=>$products->category_title); 

        $price_history_30 = $this->Product_detail_Model->get_price_history_through_variantid($variant_id,30);
        $price_history_60 = $this->Product_detail_Model->get_price_history_through_variantid($variant_id,60);
        $price_history_90 = $this->Product_detail_Model->get_price_history_through_variantid($variant_id,90);
        //echo '<pre>';print_r(count($price_history_30));exit;

        $content_data = array('Page_message' => 'Product Details', 'products' => $products, 'varient_custom_field_values' => $varient_custom_field_values, 'product_markets' => $product_markets,'compare_session' => $compare_session,'category_slug' => $category_slug,'captcha_image' => $captcha['image'], 'product_comments' => $product_comments, 'rating_star' => $rating_star, 'count_product_id' => $count_product_id, 'average' => $average, 'user_alarm_exist' => $user_alarm_exist, 'get_user_alarm' => $get_user_alarm, 'comments_exist_with_productid_userid' => $comments_exist_with_productid_userid, 'price_history_30' => $price_history_30, 'price_history_60' => $price_history_60, 'price_history_90' => $price_history_90);

        $data['content'] = $this->load->view('product_detail', $content_data, TRUE);
        $data['details_page_product_meta'] = $products;
        $data['categoru_description_or_brand'] = $categoru_description_or_brand;

        $this->load->view($this->template, $data);
    }

    function visitor($product_id)
    {
        $visit_array = array();

        $ip = $this->input->ip_address();
        $ip = $ip=='::1' ? '117.247.238.182' : $ip;
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        $country = isset($ipdat->geoplugin_countryCode) && $ipdat->geoplugin_countryCode ? $ipdat->geoplugin_countryCode : 'IN';

        $last_visited_data = $this->Product_detail_Model->get_product_last_visit($product_id ,$ip, $country);
        if($last_visited_data)
        {
            $visit_array['product_id'] = $product_id;
            $visit_array['ip'] = $ip;
            $visit_array['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            $visit_array['country'] = $country;
            $visit_array['last_visited'] = date('Y-m-d H:i:s');
            $visit_array['total_visits'] = $last_visited_data->total_visits + 1;
            $last_visited_data = $this->Product_detail_Model->update_product_last_visit($last_visited_data->id, $visit_array);
        }
        else
        {
            $visit_array['product_id'] = $product_id;
            $visit_array['ip'] = $ip;
            $visit_array['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            $visit_array['country'] = $country;
            $visit_array['last_visited'] = date('Y-m-d H:i:s');
            $visit_array['total_visits'] = 1;
            $last_visited_data = $this->Product_detail_Model->insert_product_last_visit($visit_array);
        }

        return true;
    }

    function contactseller()
    {

        $this->form_validation->set_rules('captcha', 'Captcha', 'required|trim|callback__check_captcha');
        $form_data = array();
        if($this->input->post('sub'))
        {
            if ($this->form_validation->run() == TRUE) 
            {
                $form_data['product_id'] = $this->input->post('productid');
                $form_data['name'] = $this->input->post('name');
                $form_data['message'] = $this->input->post('message');
                $inserted_data = $this->Product_detail_Model->insert_contactseller($form_data);
                
                if($inserted_data)
                {
                    $this->session->set_flashdata('message', 'Record Added Successfully');                              
                }
                else
                {
                    $this->session->set_flashdata('error', 'Eroor During Added Record'); 
                }
            }
            else
            {
                $fielderror = $this->form_validation->error_array();
                //print_r($fielderror);exit;
                $this->session->set_flashdata('error', implode(" ", $fielderror)); 
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
        
        redirect(base_url());
    }

    function _check_captcha($captcha) {
        $verified = $this->Product_detail_Model->verify_captcha($captcha);
        if ($verified == FALSE) {
            $this->form_validation->set_message('_check_captcha', lang('contact error captcha'));
            return FALSE;
        } else {
            return $captcha;
        }
    }

    function submit_rating()
    {   
        $this->form_validation->set_rules('reviewstar','Review Star', 'required|min_length[1]|max_length[5]');
        $save_rating_data = array();
        if($this->session->userdata('logged_in')) 
        {
            if($this->input->post('save'))
            {
                if ($this->form_validation->run() == TRUE) 
                {
                    $save_rating_data['user_id'] = $this->session->userdata('logged_in')['id'];
                    $save_rating_data['product_variant_id'] = $this->input->post('variantid');
                    $save_rating_data['review_content'] = $this->input->post('ratingcontent');
                    $save_rating_data['rating'] = $this->input->post('reviewstar');
                    $inserted_data = $this->Product_detail_Model->insert_rating_data($save_rating_data);
                    if($inserted_data)
                    {
                        $this->session->set_flashdata('message', 'Ratting Added Successfully');                              
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Eroor During Ratting Added'); 
                    }
                }
                else
                {
                    $fielderror = $this->form_validation->error_array();
                    //print_r($fielderror);exit;
                    $this->session->set_flashdata('error', implode(" ", $fielderror)); 
                    redirect($_SERVER['HTTP_REFERER']);                               
                }
            }
        } 
        else 
        {
           $this->session->set_flashdata('error', 'Please Register First'); 
           redirect(base_url(""));
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    function review_insert()
    {
        $response = [];    
        if($this->session->userdata('logged_in')) 
        {
            $save_review_like['review_id'] = $_POST['review_id'];
            $save_review_like['user_id'] = $this->session->userdata('logged_in')['id'];
            $inserted_data = $this->Product_detail_Model->insert_review_like($save_review_like);
            $get_count_of_likes = $this->Product_detail_Model->get_count_likes_through_review_id($_POST['review_id']);
            
            if($inserted_data)
            {
                $response['success'] = $get_count_of_likes;
            }
            else
            {
                $response['error'] = 'unsuccessfull';   
            }
        }
        else
        {
            $response['status'] = 'redirect';
        }
        echo json_encode($response);
    }

    function review_delete()
    {
        $response = [];
        if($this->session->userdata('logged_in')) 
        {
            $review_id = $_POST['review_id'];
            $delete_data = $this->Product_detail_Model->delete_review_like_through_reviewid($review_id,$this->user['id']);
            $get_count_of_likes = $this->Product_detail_Model->get_count_likes_through_review_id($_POST['review_id']);
            if($delete_data)
            {
                $response['successfull'] = $get_count_of_likes;
            }
            else
            {
                $response['error'] = 'unsuccessfull';
            }
        }
        else
        {
            $response['status'] = 'redirect';
        }
        echo json_encode($response);
    }

    function insert_alert_data()
    {
        $response = [];
        $minimum_price = $_POST['minprice'];
        $detail_variant_id = $_POST['variant_id'];
        if(isset($this->user['id'])) 
        {
            if(is_numeric($minimum_price))
            {
                $save_alarm_data['user_id'] = $this->user['id'];
                $save_alarm_data['product_variant_id'] = $detail_variant_id;
                $save_alarm_data['price'] = $minimum_price;
                $inserted_data = $this->Product_detail_Model->insert_alarm_data($save_alarm_data);
                if($inserted_data)
                {
                    $response['successfull'] = 'success';
                }
                else
                {
                    $response['unsuccessfull'] = 'error';
                }
            }
            else
            {
                $response['incorrect'] = 'notnumber';
            }
            
        }
        else
        {
           $response['status'] = 'redirect'; 
        }
        echo json_encode($response);
    }

    function delete_alert_data()
    {
        $response = [];
        $alarm_variant_id = $_POST['variant_id'];
        if(isset($this->user['id'])) 
        {
            $delete_data = $this->Product_detail_Model->delete_alarm_data($alarm_variant_id,$this->user['id']);   
            if($delete_data)
            {
                $response['successfull'] = 'success';
            }
            else
            {
                $response['unsuccessfull'] = 'error';
            }
        }
        else
        {
            $response['status'] = "redirect";
        }
        echo json_encode($response);
    }

    function get_more_comment()
    {
        $view_data = [];
        $last_id = $this->input->get('last_id');
        $get_more_comment_data = $this->Product_detail_Model->get_more_comment_data($_GET['variant_id'],$last_id);
        $view = '';
        if($get_more_comment_data)
        {
            foreach ($get_more_comment_data as $comment_key => $comment_value) 
            {
                $userimage = (isset($comment_value->image) && !empty($comment_value->image) ? base_url('/assets/images/user_image/'.$comment_value->image) : base_url('assets/images/user_image/avatar-1.png'));
                $view .= '<div class="comment-list">
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="user-image"><img src="'.$userimage.'"></div>                                        
                                </div>
                                <div class="col-md-2">
                                    <div class="user-name">'.$comment_value->first_name. ' ' .$comment_value->last_name.'</div>
                                    <div class="comment-date">'.date('d.m.Y H:i', strtotime($comment_value->added)).'</div>   
                                </div>
                                <div class="col-md-3">
                                    <div class="averate-number-main">
                                        <div class="user-rating">'.$comment_value->rating.'.0'.'</div>
                                        <div class="average-star">';
                                            if($comment_value->rating >= 1) {
                $view .=                        '<span><i class="fa fa-star fill-star" aria-hidden="true"></i></span>';                              
                                            }
                                            else 
                                            {
                $view .=                        '<span><i class="far fa-star empty-star" aria-hidden="true"></i></span>';                            
                                            } if($comment_value->rating >= 2) {                         
                $view .=                        '<span><i class="fa fa-star fill-star" aria-hidden="true"></i></span>';                        
                                            }
                                            else 
                                            {
                $view .=                        '<span><i class="far fa-star empty-star" aria-hidden="true"></i></span>';                            
                                            } if($comment_value->rating >= 3) {    
                $view .=                        '<span><i class="fa fa-star fill-star" aria-hidden="true"></i></span>';                        
                                            }        
                                            else 
                                            {
                $view .=                        '<span><i class="far fa-star empty-star" aria-hidden="true"></i></span>';
                                            } if($comment_value->rating >= 4) {                            
                $view .=                        '<span><i class="fa fa-star fill-star" aria-hidden="true"></i></span>';
                                            }
                                            else
                                            {
                $view .=                        '<span><i class="far fa-star empty-star" aria-hidden="true"></i></span>';        
                                            } if($comment_value->rating >= 5) {
                $view .=                        '<span><i class="fa fa-star fill-star" aria-hidden="true"></i></span>';
                                            } 
                                            else
                                            {
                $view .=                        '<span><i class="far fa-star empty-star" aria-hidden="true"></i></span>';
                                            }                                
                $view .=                '</div>                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="comment-text"><p>'.$comment_value->review_content.'</p></div>
                                    <div class="do-you-sure">Bu yorumu faydali buluyor musunuz?</div>';
                                    if(get_user_review_like($comment_value->id))
                                    {
                                        $liked_or_not = 'review-like';
                                    } 
                                    else
                                    {
                                        $liked_or_not = 'review-not-visit';
                                    }
                $view .=            '<div class="evet like-icon">
                                        <i class="fa fa-thumbs-up '.$liked_or_not.'" id="change-color_'.$comment_value->id.'" aria-hidden="true" data-review_id="'.$comment_value->id.'"></i>
                                        <span class="total-likes">';
                                            if($comment_value->total_like > 0 && isset($comment_value->total_like)) {
                $view .=                       $comment_value->total_like;
                                            }
                $view .=                '</span>
                                    </div>    
                                </div>
                            </div>
                          </div>';
                          
            }
            $view_data['view'] = $view;
            $view_data['last_id'] = $comment_value->id;
            
        }
        if(empty($get_more_comment_data))
        {   
            $view_data['view'] = 'No Comments';
        }
        echo json_encode($view_data);
    }
}

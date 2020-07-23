<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Varient_detail_Controller extends Public_Controller {
    /**
     * Constructor 
     */
    function __construct() 
    {
        parent::__construct();
        $this->lang->load('language');
        $this->load->model('Varient_detail_Model');
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
    }
    function index($category_slug = NULL, $varient_id = NULL) 
    {

        $this->set_title('Varient Details');
        $data = $this->includes;

        $varients = $this->Varient_detail_Model->varient_data($category_slug, $varient_id);
        //echo '<pre>';print_r($varients);exit;
        $product_varients = $this->Varient_detail_Model->product_varients($varient_id);

        if (empty($varients) && $product_varients) 
        {
            return redirect(base_url('404_override'));
        }
       
        $product_id = $varients->product_id; 
        $userid = $this->session->userdata('logged_in')['id'];
        $comments_exist_with_productid_userid = $this->Varient_detail_Model->get_comment_through_variantid_userid($varient_id,$userid);
        $product_comments = $this->Varient_detail_Model->get_product_related_comment($varient_id);
        $count_product_id = $this->Varient_detail_Model->get_total_rating_related_product($varient_id);

        $get_user_alarm = $user_alarm_exist = "";
        
        if(isset($userid) && !empty($userid))
        {
            $user_alarm_exist = $this->Varient_detail_Model->get_alarm_through_userid_variantid($varient_id,$userid); 
            $get_user_alarm = $this->Varient_detail_Model->get_alarm_data($varient_id,$userid);
        }

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

        $product_data = $this->Varient_detail_Model->get_primary_product_data($product_id);
        $product_markets = $this->Varient_detail_Model->get_product_markets($varient_id);
        $varient_values = array();
      
        $product_sku = $product_varients->product_sku;
        $varient_values[$product_sku] = $this->Varient_detail_Model->get_varient_values($varient_id);
        

        if ($this->session->userdata('Compare_products')) {
            $compare_session = $this->session->userdata('Compare_products');
        } else {
            $this->session->set_userdata('Compare_products', array());
            $compare_session = $this->session->userdata('Compare_products');
        }


        $product_tags = $varients->product_meta_keyword.',';
        $categoru_description_or_brand = array('category_description' => $varients->product_meta_description,'brand_tags'=>$product_tags,'category_names'=>$varients->category_title); 

        
        $price_history_30 = $this->Varient_detail_Model->get_price_history_through_variantid($varient_id,30);
        $price_history_60 = $this->Varient_detail_Model->get_price_history_through_variantid($varient_id,60);
        $price_history_90 = $this->Varient_detail_Model->get_price_history_through_variantid($varient_id,90);

        $content_data = array('Page_message' => 'Varient Details', 'varients' => $varients, 'product_markets' => $product_markets,'compare_session' => $compare_session,'category_slug' => $category_slug , 'product_data' => $product_data, 'comments_exist_with_productid_userid' => $comments_exist_with_productid_userid, 'product_comments' => $product_comments, 'rating_star' => $rating_star, 'count_product_id' => $count_product_id, 'average' => $average, 'user_alarm_exist' => $user_alarm_exist, 'get_user_alarm' => $get_user_alarm, 'price_history_30' => $price_history_30, 'price_history_60' => $price_history_60, 'price_history_90' => $price_history_90);

        $data['content'] = $this->load->view('varient_detail', $content_data, TRUE);
        $data['details_page_product_meta'] = $varients;
        $data['categoru_description_or_brand'] = $categoru_description_or_brand;

        $this->load->view($this->template, $data);
    }

    function visitor($product_id)
    {
        $visit_array = array();

        $ip = $this->input->ip_address();
        $ip = $ip == '::1' ? '117.247.238.182' : $ip;

        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        $country = isset($ipdat->geoplugin_countryCode) && $ipdat->geoplugin_countryCode ? $ipdat->geoplugin_countryCode : 'IN';

        $last_visited_data = $this->Product_detail_Model->get_product_last_visit($product_id, $ip, $country);

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
                    $inserted_data = $this->Varient_detail_Model->insert_rating_data($save_rating_data);
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
            $inserted_data = $this->Varient_detail_Model->insert_review_like($save_review_like);
            $get_count_of_likes = $this->Varient_detail_Model->get_count_likes_through_review_id($_POST['review_id']);
            
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
            $delete_data = $this->Varient_detail_Model->delete_review_like_through_reviewid($review_id,$this->user['id']);
            $get_count_of_likes = $this->Varient_detail_Model->get_count_likes_through_review_id($_POST['review_id']);
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
                $inserted_data = $this->Varient_detail_Model->insert_alarm_data($save_alarm_data);
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
            $delete_data = $this->Varient_detail_Model->delete_alarm_data($alarm_variant_id,$this->user['id']);   
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
}

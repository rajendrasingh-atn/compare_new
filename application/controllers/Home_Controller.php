<?php defined('BASEPATH') OR exit('No direct script access allowed'); //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
class Home_Controller extends Public_Controller {
    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        // load the language file 
        $this->lang->load('language');
        $this->add_js_theme('jquery.bxslider.js');
        //$this->add_js_theme('home.js');
        //$this->add_external_js(base_url("assets/themes/default/js/slick.min.js"));
        $this->add_external_js(base_url("assets/themes/default/js/jquery-migrate.min.js"));
        $this->add_external_css(base_url("assets/themes/default/css/slick-theme.css"));
        $this->add_external_css(base_url("assets/themes/default/css/slick.css"));
        $this->add_external_css(array(base_url("/assets/themes/admin/css/select2.min.css")));
        $this->add_external_js(array(base_url("/assets/themes/admin/js/select2.min.js"),));
        $this->load->model('Home_Model');
        $this->load->library('form_validation');
       
    }
    function index() {
        $this->set_title(sprintf(lang('home'), $this->settings->site_name));
        //$this->add_css_theme('product.css');

        
        $category_data = $this->Home_Model->get_category();
        $latest_products = $this->Home_Model->get_latest_products();
        $markets = $this->Home_Model->get_market();
        $data = $this->includes;
        if ($this->input->post('search', TRUE)) { 
            $this->form_validation->set_rules('category_name', 'Category', 'required');
            if ($this->form_validation->run() == false) {
                $this->form_validation->error_array();
            } else {
                $category_slug = $this->input->post('category_name', TRUE);
                $price_range = $this->input->post('price_range') ? $this->input->post('price_range', TRUE) : '1-999999';
                $product_or_brand = $this->input->post('product_or_brand') ? $this->input->post('product_or_brand', TRUE) : 'all';
                redirect(base_url("/search/$category_slug?price-range=$price_range&search=$product_or_brand"));
            }
        }
        $home_category_prodducts = array();
        $menu_category_array = get_menu_item_helper();
        if ($menu_category_array) {
            foreach ($menu_category_array as $menu_category) {
                $home_category_prodducts[$menu_category->category_title] = $this->Home_Model->get_products_by_category($menu_category->id);
            }
        }
        $coupons =  $this->Home_Model->get_latest_coupons();

        if ($this->session->userdata('Compare_products')) {
            $compare_session = $this->session->userdata('Compare_products');
        } else {
            $this->session->set_userdata('Compare_products', array());
            $compare_session = $this->session->userdata('Compare_products');
        }

        $content_data = array('Page_message' => 'Welcome To Compare Site', 'category_data' => $category_data, 'latest_products' => $latest_products, 'home_category_prodducts' => $home_category_prodducts,'compare_session' => $compare_session,'coupons' => $coupons, 'markets' => $markets, );
        $data['content'] = $this->load->view('home', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    function add_to_fav_product($product_id) {
        $response['status'] = 'error';
        $response['msg'] = 'Invalid Request !';
        if (isset($this->user['id'])) {
            $user_id = $this->user['id'];
            $is_exist = $this->Home_Model->view_fav_product($this->user['id'], $product_id);
            if ($is_exist) {
                $status = $this->Home_Model->remove_from_fav_product($user_id, $product_id);
                if ($status) {
                    $response['status'] = 'success';
                    $response['action'] = 'removed';
                    $response['msg'] = 'Product Removed From Favourite List !';
                } else {
                    $response['status'] = 'error';
                    $response['action'] = 'alert';
                    $response['msg'] = 'Invalid Request';
                }
            } else {
                $data['user_id'] = $this->user['id'];
                $data['products_id'] = $product_id;
                $data['added_on'] = date('Y-m-d H:i:s');
                $status = $this->Home_Model->add_to_fav_product($data);
                if ($status) {
                    $response['status'] = 'success';
                    $response['action'] = 'added';
                    $response['msg'] = 'Product Added To Favorite  !';
                } else {
                    $response['status'] = 'error';
                    $response['msg'] = 'Sorry Error During Add To Favorite Product !';
                }
            }
        } else {
            $response['status'] = 'error';
            $response['action'] = 'redirect';
            $response['msg'] = 'Plz Login First To Add Favorite Product !';
        }
        echo json_encode($response);
        return json_encode($response);
    }

    public function coupons()
    {
        $this->set_title('Coupons', $this->settings->site_name);
        // $this->add_css_theme('product.css');
        
        $coupons =  $this->Home_Model->get_latest_coupons();
        $coupons_deals =  $this->Home_Model->get_latest_coupons_deals();
        $coupons_code =  $this->Home_Model->get_latest_coupons_code();
        $data = $this->includes;

        if ($this->session->userdata('Compare_products')) {
            $compare_session = $this->session->userdata('Compare_products');
        } else {
            $this->session->set_userdata('Compare_products', array());
            $compare_session = $this->session->userdata('Compare_products');
        }

        $content_data = array('Page_message' => 'All Coupons', 'coupons' => $coupons,'coupons_deals' => $coupons_deals, 'coupons_code' => $coupons_code );
        $data['content'] = $this->load->view('coupons', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
}

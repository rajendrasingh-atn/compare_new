<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Filter_Controller extends Public_Controller {
    /**
     * Constructor 
     */
    function __construct() 
    {
        parent::__construct();
        $this->lang->load('language');
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->model('Home_Model');
        $this->load->library('form_validation');

        $this->add_css_theme('bootstrap-select.css');
        $this->add_external_css(array(base_url("/assets/themes/admin/css/select2.min.css")));
        $this->add_js_theme('bootstrap.bundle.min.js');
        $this->add_js_theme('bootstrap-select.js');
        $this->add_external_js(array(base_url("/assets/themes/admin/js/select2.min.js"),));
        $this->add_css_theme('range-slider.css');
        $this->add_js_theme('range-slider.js');
        $this->add_js_theme('filter.js');
    }
    
    function search($category_slug = NULL, $page_number = NULL) 
    {
        $price_range = $this->input->get('price-range') ? $this->input->get('price-range') : NULL;
        $product_or_brand = $this->input->get('search') ? $this->input->get('search') : NULL;
        $category_data = $this->Home_Model->get_category();
        $all_brands = $this->Home_Model->get_brand_all_brands();
        $all_markets = $this->Home_Model->get_brand_all_markets();
        $category_by_slug = $this->Home_Model->get_category_by_slug($category_slug);

        $category_title = $category_by_slug ? $category_by_slug->category_title : "All";
        $this->set_title($category_title);

        $category_id = $category_by_slug ? $category_by_slug->id : NULL;
        $price_from = NULL;
        $price_to = NULL;
        if ($price_range) {
            $price_range = explode('-', $price_range);
            $price_from = isset($price_range[0]) ? $price_range[0] : NULL;
            $price_to = isset($price_range[1]) ? $price_range[1] : NULL;
        }
        $brands_filter = array();
        if ($this->input->get('brands')) {
            $brands_filter = explode(',', $this->input->get('brands'));
        }
        $markets_filter = array();
        if ($this->input->get('markets')) {
            $markets_filter = explode(',', $this->input->get('markets'));
        }
        $sort_by = $this->input->get('sort_by') ? $this->input->get('sort_by') : NULL;
        $filter_customfield__data_array = $this->Home_Model->filter_customfield__data($category_id);
        $product_filter_array = array();
        foreach ($filter_customfield__data_array as $filter_customfield__data) {
            $custom_field_group_name = $filter_customfield__data->custom_field_group_name;
            $custom_field_name = $filter_customfield__data->field_name;
            $custom_field_slug = $filter_customfield__data->field_slug;
            $product_filter_array[$custom_field_group_name][$custom_field_slug] = $filter_customfield__data;
        }
        $field_filter_request = array();
        foreach ($this->input->get() as $request_name => $request_val) {
            foreach ($filter_customfield__data_array as $filter_customfield__data) {
                if ($filter_customfield__data->field_slug == $request_name) {
                    $filter_customfield__data->field_value = $request_val;
                    $field_filter_request[$request_name] = $filter_customfield__data;
                }
            }
        }
        if ($this->session->userdata('Compare_products')) {
            $compare_session = $this->session->userdata('Compare_products');
        } else {
            $this->session->set_userdata('Compare_products', array());
            $compare_session = $this->session->userdata('Compare_products');
        }
        $count_products = count($this->Home_Model->get_product_count($category_id, $product_or_brand, $price_from, $price_to, $brands_filter, $markets_filter, $field_filter_request, $sort_by));
        $config['base_url'] = base_url('search/') . $category_slug;
        $config['total_rows'] = $count_products;
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = FALSE;
        $config['reuse_query_string'] = TRUE;
        $config['first_link'] = 'First';
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['attributes'] = ['class' => 'page-link'];
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $pro_per_page = $config['per_page'];
        $page = $this->uri->segment(3) > 0 ? (($this->uri->segment(3) - 1) * $pro_per_page) : $this->uri->segment(3);
        $page_links = $this->pagination->create_links();

        $products = $this->Home_Model->home_product_filter_data($category_id, $product_or_brand, $price_from, $price_to, $brands_filter, $markets_filter, $field_filter_request, $sort_by, $page, $pro_per_page);

        $content_data = array('products' => $products, 'category_slug' => $category_slug, 'price_from' => $price_from, 'price_to' => $price_to, 'category_data' => $category_data, 'all_brands' => $all_brands, 'brands_filter' => $brands_filter, 'all_markets' => $all_markets, 'markets_filter' => $markets_filter, 'product_filter_array' => $product_filter_array, 'field_filter_request' => $field_filter_request, 'compare_session' => $compare_session, 'page_links' => $page_links, 'Page_message' => 'Product Filter', 'count_products' => $count_products);

        $brand_tags = '';
        foreach ($all_brands as  $value) 
        {
           $brand_tags .= $value->brand_title.',';
        }

        $category_description = $category_by_slug ? $category_by_slug->category_description : "";

        $categoru_description_or_brand = array('category_description' => $category_description, 'brand_tags' => $brand_tags, 'category_names' => $category_title); 

        $data = $this->includes;
        $data['content'] = $this->load->view('product_filter', $content_data, TRUE);
        $data['categoru_description_or_brand'] = $categoru_description_or_brand;
        $this->load->view($this->template, $data);
    }
}

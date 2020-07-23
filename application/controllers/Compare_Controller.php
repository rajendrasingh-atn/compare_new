<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Compare_Controller extends Public_Controller {
    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        // $this->lang->load('language');
        $this->load->model('Compare_Model');
        $this->load->library('form_validation');
        $this->add_js_theme('product_compare.js');
        $this->lang->load('language');

    }
    function index($products_slug = NULL) {
        $products = array();
        $session_products_slug = array();
        $custom_field_by_category_array = array();
        $category_slug = NULL;
        $category_id = NULL;
        $products_slug_array = explode('-vs-', $products_slug);
        if (count($products_slug_array) < 2) {
            $this->session->set_flashdata('error', lang('compare atleast 2'));
            return redirect(base_url('search/mobile'));
        } elseif (count($products_slug_array) > 4) {
            $this->session->set_flashdata("error", lang('less then four product'));
            return redirect(base_url('search/mobile'));
        }
        foreach ($products_slug_array as $product_slug) {
            $product_data = $this->Compare_Model->product_data($product_slug);
            if ($product_data) {
                if ($category_id && $category_id != $product_data->product_category_id) {
                    $this->session->set_flashdata("error", lang('Can Compare Same Category'));
                    return redirect(base_url('search/mobile'));
                }
                $category_id = $product_data->product_category_id;
                $products[$product_data->product_slug] = $product_data;
                $session_products_slug['Compare_products'][] = $product_data->product_slug;
            }
        }
        if (empty($products) && empty($category_id)) {
            return redirect(base_url('404_override'));
        } elseif (count($products) < 2) {
            $this->session->set_flashdata("error", lang('compare atleast 2'));
            return redirect(base_url('search/mobile'));
        }
        $this->session->set_userdata($session_products_slug);
        $products_fields_values = array();
        $products_fields_array = array();
        $products_fields_name_array = array();
        foreach ($products as $product_slug => $product_data) {
            $products_fields_values[$product_slug] = $this->Compare_Model->products_fields_values($product_data->product_varient_id);
        }
        foreach ($products_fields_values as $product_slug => $products_group_val_array) {
            foreach ($products_group_val_array as $products_field_val_array) {
                $products_fields_array[$products_field_val_array->field_group_name][$products_field_val_array->custom_field_id][] = $products_field_val_array->field_value;
                $products_fields_name_array[$products_field_val_array->field_group_name][$products_field_val_array->custom_field_id] = $products_field_val_array->custom_field_name;
            }
        }
        $this->set_title(sprintf(lang('search'), $this->settings->site_name));
        $data = $this->includes;
        $content_data = array('Page_message' => 'Product Compare', 'products' => $products, 'products_fields_array' => $products_fields_array, 'products_fields_name_array' => $products_fields_name_array,);
        $data['content'] = $this->load->view('product_compare', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    function compare_product($product_slug, $category_slug) {
        $product_category_id = NULL;
        if ($this->session->userdata('Compare_products')) {
            $compare_session = $this->session->userdata('Compare_products');
        } else {
            $this->session->set_userdata('Compare_products', array());
            $compare_session = $this->session->userdata('Compare_products');
        }
        $compare_count = count($compare_session);
        if ($compare_count) {
            foreach ($compare_session as $compare_session_slug) {
                $product_data_by_session = $this->Compare_Model->product_data($compare_session_slug);
            }
            $product_category_id = $product_data_by_session->product_category_id;
        }
        if ($compare_count < 4) {
            $product_data = $this->Compare_Model->product_data($product_slug);
            if ($product_data) {
                if ($product_category_id && $product_category_id != $product_data->product_category_id) {
                    $response['status'] = 'error';
                    $response['msg'] = lang('Can Compare Same Category');
                } elseif (in_array($product_data->product_slug, $compare_session)) {
                    $response['status'] = 'error';
                    $response['msg'] = lang('Can Not Compare Same Products');
                } else {
                    $response['status'] = 'success';
                    array_push($compare_session, $product_data->product_slug);
                    $this->session->set_userdata('Compare_products', $compare_session);
                }
            }
        } else {
            $response['status'] = 'error';
            $response['msg'] = lang('less then four product');
        }
        $response['compare_count'] = count($this->session->userdata('Compare_products'));
        $json_response = json_encode($response);
        echo $json_response;
        return $json_response;
    }
    public function compare_product_remove($product_slug, $category_slug) {
        if ($this->session->userdata('Compare_products')) {
            $compare_session = $this->session->userdata('Compare_products');
        } else {
            $this->session->set_userdata('Compare_products', array());
            $compare_session = $this->session->userdata('Compare_products');
        }
        $product_data = $this->Compare_Model->product_data($product_slug);
        if ($product_data) {
            if (in_array($product_data->product_slug, $compare_session)) {
                foreach ($compare_session as $key => $pro_slug) {
                    if ($pro_slug == $product_data->product_slug) {
                        unset($compare_session[$key]);
                        $response['msg'] = $product_data->product_slug . lang('Removed From Compare List');
                    }
                }
                $response['status'] = 'success';
                $this->session->set_userdata('Compare_products', $compare_session);
            } else {
                $response['status'] = 'error';
                $response['msg'] = lang('Already Removed From Compare List');
            }
        } else {
            $response['status'] = 'error';
            $response['msg'] = lang('Invalid Request Or Products Already Removed');
        }
        $response['compare_count'] = count($this->session->userdata('Compare_products'));
        $json_response = json_encode($response);
        echo $json_response;
        return $json_response;
    }
    public function compare_product_nav_data() {
        $product_data = array();
        $compare_url = '';
        $compare_session = $this->session->userdata('Compare_products');
        if ($compare_session) {
            $product_total = count($compare_session);
            $j = 0;
            foreach ($compare_session as $key => $product_slug) {
                $product_data[$product_slug] = $this->Compare_Model->product_data($product_slug);
                $j++;
                if ($product_total > $j) {
                    $compare_url.= $product_slug . '-vs-';
                } else {
                    $compare_url.= $product_slug;
                }
            }
        }
        $data['compare_url'] = base_url("compare/" . $compare_url);
        $data['products'] = $product_data;
        $response['content'] = $this->load->view('product_compare_menu_data', $data, TRUE);
        echo json_encode($response);
        return json_encode($response);
    }
}

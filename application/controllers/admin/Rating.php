<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rating extends Admin_Controller {
	 function __construct() {
        parent::__construct();
        $this->add_css_theme('all.css');
        $this->add_js_theme('jquery.multi-select.min.js');
        $this->add_js_theme('rating_custome_script.js');
        // load the rating model
        $this->load->model('rating_model');
        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/rating'));
        define('DEFAULT_LIMIT', 10);
        define('DEFAULT_OFFSET', 0);
        define('DEFAULT_SORT', "last_name");
        define('DEFAULT_DIR', "asc");
    }

    function index() {
        $this->add_css_theme('sweetalert.css')->add_js_theme('sweetalert-dev.js')->add_js_theme('bootstrap-notify.min.js')->set_title('Disapprove Rating List');
        $data = $this->includes;
        $content_data = array();
        // load views
        $data['content'] = $this->load->view('admin/rating/list', $content_data, TRUE);
        $this->load->view($this->template, $data); 
    }

    function rating_list()
    {
    	$list = $this->rating_model->get_rating();
        //echo '<pre>';print_r($list);exit;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rating) {
            $no++;
            $row = array();
            $row[] = $rating->username;
            $row[] = ucfirst($rating->review_content);
            $row[] = ucfirst($rating->rating);
            $checkvalue = ($rating->status == 0 ? "" : 'checked="checked"');
            $row[] = '<label class="custom-switch mt-2">
                <input type="checkbox" data-id="' . $rating->id . '" name="custom-switch-checkbox" class="custom-switch-input togle_switch" ' . $checkvalue . '>
                <span class="custom-switch-indicator indication"></span>
                </label>';
            $data[] = $row;
        }
        $output = array("draw" => $_POST['draw'], "recordsTotal" => $this->rating_model->count_all(), "recordsFiltered" => $this->rating_model->count_filtered(), "data" => $data);
        //output to json format
        echo json_encode($output);
    }

    function update_status()
    {
    	action_not_permitted();
        $id = $_POST['rating_id'];
        $status = $_POST['status'];
        $this->rating_model->update_status($id, $status);
        $success = array('status' => $status, 'messages' => lang('admin Rating Status Updated Successfully'));
        echo json_encode($success);
    }

    function approve()
    {
        
        $this->add_css_theme('sweetalert.css')->add_js_theme('sweetalert-dev.js')->add_js_theme('bootstrap-notify.min.js')->set_title('Approve Rating List');
        $data = $this->includes;
        $content_data = array();
        // load views
        $data['content'] = $this->load->view('admin/rating/approvelist', $content_data, TRUE);
        $this->load->view($this->template, $data);        
    }

    function approve_rating_list()
    {
        $list = $this->rating_model->get_approve_rating();        
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rating) {
            $no++;
            $row = array();
            $row[] = $rating->username;
            $row[] = ucfirst($rating->review_content);
            $row[] = ucfirst($rating->rating);
            $checkvalue = ($rating->status == 0 ? "" : 'checked="checked"');
            $row[] = '<label class="custom-switch mt-2">
                <input type="checkbox" data-id="' . $rating->id . '" name="custom-switch-checkbox" class="custom-switch-input togle_switch" ' . $checkvalue . '>
                <span class="custom-switch-indicator indication"></span>
                </label>';
            $data[] = $row;
        }
        $output = array("draw" => $_POST['draw'], "recordsTotal" => $this->rating_model->approve_count_all(), "recordsFiltered" => $this->rating_model->approve_count_filtered(), "data" => $data);
        //output to json format
        echo json_encode($output);
    }

}

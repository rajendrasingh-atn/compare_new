<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Brand extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->add_css_theme('all.css');
        $this->add_js_theme('brand_custom_script.js');
        // load the language files
        $this->lang->load('language');
        // load the brand model
        $this->load->model('brand_model');
        //load the form validation
        $this->load->library('form_validation');
        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/brand'));
        define('DEFAULT_LIMIT', 10);
        define('DEFAULT_OFFSET', 0);
        define('DEFAULT_SORT', "last_name");
        define('DEFAULT_DIR', "asc");
    }
    function index() {
        $this->add_css_theme('sweetalert.css');
        $this->add_js_theme('sweetalert-dev.js');
        $this->set_title(lang('brand title brand_list'));
        $data = $this->includes;
        $content_data = array();
        // load views
        $data['content'] = $this->load->view('admin/brand/list', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    function form($id = NULL) {
        $editData = "";
        if ($id) {
            $editData = $this->brand_model->getbrandfetch($id);
        }
        $this->form_validation->set_rules('brandtitle', lang('brand input name'), 'trim|required');
        $this->form_validation->set_rules('branddescription', lang('brand input description'), 'trim');
        if ($this->form_validation->run() != false) {
            $brand_name_count = $this->brand_model->brand_name_like_this($id, $this->input->post('brandtitle'), TRUE);
            $count = $brand_name_count > 0 ? '-' . $brand_name_count : '';
            $formData = array();
            $formData['brand_title'] = $this->input->post('brandtitle', TRUE);
            $formData['brand_slug'] = slugify_string($this->input->post('brandtitle', TRUE) . $count);
            $formData['brand_description'] = $this->input->post('branddescription', TRUE);
            $checkImage = $this->brand_model->fetcheditimg($id);
            $formData['brand_image'] = $checkImage;
            if ($_FILES['brandimage']['name']) {
                if (!empty($checkImage)) {
                    $path = "./assets/images/brand_image/$checkImage";
                    unlink($path);
                }
                $config['upload_path'] = "./assets/images/brand_image/";
                $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('brandimage')) {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error', $error['error']);
                }
                $file = $this->upload->data();
                $formData['brand_image'] = $file['file_name'];
            }
            if ($this->input->post(lang('core button save'), TRUE)) {
                $this->brand_model->insert($formData);
                $this->session->set_flashdata('message', lang('admin Brand Brand Inserted Successfully'));
                redirect(base_url('admin/brand'));
            }
            if ($this->input->post(lang('core button update'), TRUE)) {
                action_not_permitted();
                $this->brand_model->update($formData, $id);
                $this->session->set_flashdata('message', lang('admin Brand Updated Successfully'));
                redirect(base_url('admin/brand'));
            }
        } else {
            $fielderror = $this->form_validation->error_array();
        }
        if ($id) {
            $this->set_title(lang('brand title brand_edit'));
        } else {
            $this->set_title(lang('brand title brand_add'));
        }
        $data = $this->includes;
        $content_data = array('editData' => $editData);
        // load views
        $data['content'] = $this->load->view('admin/brand/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    function brand_list() {
        $list = $this->brand_model->get_brand();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $brand) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ucfirst($brand->brand_title);
            $brandImg = ($brand->brand_image ? base_url('assets/images/brand_image/' . $brand->brand_image) : base_url('assets\images\brand_image\default_brand.jpg'));
            $row[] = '<img src="' . $brandImg . '" class="listing_img">';
            $row[] = '<a href="' . base_url("admin/brand/form/" . $brand->id) . '" class="btn btn-primary btn-action mr-1"><i class="fas fa-pencil-alt"></i></a>
                <a href="' . base_url("admin/brand/delete/" . $brand->id) . '" class="btn btn-danger btn-action mr-1 common_delete"><i class="fas fa-trash"></i></a>';
            $data[] = $row;
        }
        $output = array("draw" => $_POST['draw'], "recordsTotal" => $this->brand_model->count_all(), "recordsFiltered" => $this->brand_model->count_filtered(), "data" => $data);
        //output to json format
        echo json_encode($output);
    }
    function delete($id = NULL) {
        action_not_permitted();
        $findImage = $this->brand_model->deleteimage($id);
        if (!empty($findImage)) {
            $path = "./assets/images/brand_image/$findImage";
            unlink($path);
        }
        $this->brand_model->delete($id);
        $this->session->set_flashdata('message', lang('admin brand Brand Deleted'));
        redirect(base_url('admin/brand'));
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->add_css_theme('all.css');
        $this->add_js_theme('jquery.multi-select.min.js');
        $this->add_js_theme('category_custome_script.js');
        // load the language files
        $this->lang->load('language');
        // load the category model
        $this->load->model('category_model');
        //load the form validation
        $this->load->library('form_validation');
        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/category'));
        define('DEFAULT_LIMIT', 10);
        define('DEFAULT_OFFSET', 0);
        define('DEFAULT_SORT', "last_name");
        define('DEFAULT_DIR', "asc");
    }
    function index() {
        $this->add_css_theme('sweetalert.css')->add_js_theme('sweetalert-dev.js')->add_js_theme('bootstrap-notify.min.js')->set_title(lang('category title category_list'));
        $data = $this->includes;
        $content_data = array();
        // load views
        $data['content'] = $this->load->view('admin/category/list', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    function form($id = null) {
        $parentcat = $this->category_model->allcategory($id);
        $editData = "";
        if ($id) {
            $editData = $this->category_model->getfetch($id);
        }
        $this->form_validation->set_rules('title', lang('category input title'), 'trim|required');
        if ($this->form_validation->run() != false) {
            $content = array();
            $display_on_home = $this->input->post('display_on_home', TRUE) ? 1 : 0;
            $category_name_count = $this->category_model->category_name_like_this($id, $this->input->post('title', TRUE));
            $count = $category_name_count > 0 ? '-' . $category_name_count : '';
            $content['category_title'] = $this->input->post('title', TRUE);
            $content['category_slug'] = slugify_string($this->input->post('title', TRUE) . $count);
            $content['parent_category'] = $this->input->post('parentcat', TRUE);
            $content['category_description'] = $this->input->post('description', TRUE);
            $content['category_icon'] = $this->input->post('categoryicon', TRUE);
            $content['display_on_home'] = $display_on_home;
            $name = $_FILES['image']['name'];
            if ($name) {
                $checkImg = $this->category_model->getImage($id);
                if ($checkImg) {
                    $path = "./assets/images/category_image/" . $checkImg;
                    unlink($path);
                }
                $config['upload_path'] = "./assets/images/category_image/";
                $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image')) {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error', $error['error']);
                }
                $file = $this->upload->data();
                $content['category_image'] = $file['file_name'];
            }
            if ($this->input->post(lang('core button save'), TRUE)) {
                $this->category_model->insert($content);
                $this->session->set_flashdata('message', lang('admin Category Inserted Successfully'));
                redirect(base_url('admin/category'));
            }
            if ($this->input->post(lang('core button update'), TRUE)) {
                action_not_permitted();
                $this->category_model->update($content, $id);
                $this->session->set_flashdata('message', lang('admin Category Updated Successfully'));
                redirect(base_url('admin/category'));
            }
        } else {
            $fielderror = $this->form_validation->error_array();
        }
        $this->add_js_theme('bootstrap-iconpicker.bundle.min.js');
        $this->add_js_theme('bootstrap.bundle.min.js');
        $this->add_css_theme('bootstrap-iconpicker.min.css');
        if ($id) {
            $this->set_title(lang('category title category_edit'));
        } else {
            $this->set_title(lang('category title category_add'));
        }
        $data = $this->includes;
        $content_data = array('editData' => $editData, 'cat_title' => $parentcat);
        // load views
        $data['content'] = $this->load->view('admin/category/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    function category_list() {
        $list = $this->category_model->get_category();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $category) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ucfirst($category->category_title);
            if ($category->category_image) {
                $row[] = "<img src='" . base_url('assets/images/category_image/' . $category->category_image) . "' class='listing_img'>";
            } else {
                $row[] = "<img src='" . base_url('assets/images/category_image/default_category.jpg') . "' class='listing_img'>";
            }
            $row[] = '<i class="' . $category->category_icon . ' listing_icon"></i>';
            $checkvalue = ($category->category_status == 1 ? 'checked="checked"' : "");
            $row[] = '<label class="custom-switch mt-2">
                <input type="checkbox" data-id="' . $category->id . '" name="custom-switch-checkbox" class="custom-switch-input togle_switch" ' . $checkvalue . '>
                <span class="custom-switch-indicator indication"></span>
                </label>';
            $row[] = '<a href="' . base_url("admin/category/form/" . $category->id) . '" class="btn btn-primary btn-action mr-1"><i class="fas fa-pencil-alt"></i></a>
            <a href="' . base_url("admin/category/category_custom_field/" . $category->id) . '" class="btn btn-dark mr-1"><i class="fas fa-align-justify"></i></a>
            <a href="' . base_url("admin/category/delete/" . $category->id) . '" class="btn btn-danger btn-action mr-1 cat_delete"><i class="fas fa-trash"></i></a>';
            $data[] = $row;
        }
        $output = array("draw" => $_POST['draw'], "recordsTotal" => $this->category_model->count_all(), "recordsFiltered" => $this->category_model->count_filtered(), "data" => $data);
        //output to json format
        echo json_encode($output);
    }
    function update_status() {
        action_not_permitted();
        $id = $_POST['category_id'];
        $status = $_POST['status'];
        $this->category_model->updatestatus($id, $status);
        $success = array('status' => $status, 'messages' => lang('admin Category Status Updated Successfully'));
        echo json_encode($success);
    }
    function delete($id = NULL) {
        action_not_permitted();
        $findImage = $this->category_model->deleteimage($id);
        if (!empty($findImage)) {
            $path = "./assets/images/category_image/$findImage";
            unlink($path);
        }
        $this->category_model->delete($id);
        $this->session->set_flashdata('message', lang('admin Category Deleted Successfully'));
        redirect(base_url('admin/category'));
    }
    function category_custom_field($id = NULL) {
        $content = array();
        $category_custom_fields = $this->category_model->get_category_custom_fields($id);

        if ($this->input->post(lang('core button save'), TRUE)) {
            action_not_permitted();
            if (!empty($id)) {
                $this->category_model->delete_label($id);
            }
            $entry_no = sizeof($this->input->post('customfield_id[]', TRUE));
            for ($i = 0;$i < $entry_no;$i++) {
                $content['category_id'] = $this->input->post('cat_id');
                $content['custom_field_id'] = $this->input->post("customfield_id[$i]", TRUE);
                $content['category_custom_order'] = $i;
                $res = $this->category_model->category_custom($content);
                $content = array();
            }
            $this->session->set_flashdata('message', 'Label Inserted Successfully !');
            redirect(base_url('admin/category'));
        }
        $this->set_title(lang('category title custom label'));
        $data = $this->includes;
        $content_data = array('category_custom_fields' => $category_custom_fields, 'categoryid' => $id);
        // load views
        $data['content'] = $this->load->view('admin/category/category_custom_field', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
}

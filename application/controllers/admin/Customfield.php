<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customfield extends Admin_Controller {
    function __construct() {
        parent::__construct();
        // load the language files
        $this->lang->load('language');
        // load the users model
        $this->load->model('customfield_model');
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
        $this->add_css_theme('sweetalert.css');
        $this->add_js_theme('sweetalert-dev.js');
        $this->add_js_theme('customfield_custom_script.js');
        $this->set_title(lang('customfield title custom_list'));
        $data = $this->includes;
        $content_data = array();
        // load views
        $data['content'] = $this->load->view('admin/customfield/list', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    function form($id = null) {
        $customfield_category = $this->customfield_model->customcategory_name();
        $editData = array();
        if ($id) {
            $editData = $this->customfield_model->getfetch($id);
        }
        $this->form_validation->set_rules('inputtype', lang('admin c_f Input Type'), 'numeric|required');
        $this->form_validation->set_rules('customfieldcategories', lang('custom input categorycustomfield'), 'numeric|required');
        $this->form_validation->set_rules('customhint', lang('custom input customhint'), 'trim|required');
        $this->form_validation->set_rules('displaytitle', lang('admin c_f Input Display Name'), 'trim|required');
        $this->form_validation->set_rules('customlabel', lang('admin c_f Input label'), 'trim|required');
        $this->form_validation->set_rules('minval', lang('custom input custommin'), 'numeric');
        $this->form_validation->set_rules('maxval', lang('custom input custommax'), 'numeric');
        if ($this->input->post('inputtype') == 3 || $this->input->post('inputtype') == 4 || $this->input->post('inputtype') == 5) {
            $this->form_validation->set_rules('custom_options[]', 'Custom Options', 'required');
        }
        if ($this->form_validation->run() == false) {
            $fielderror = $this->form_validation->error_array();
        } else {
            $options = json_encode($this->input->post('custom_options[]', TRUE));
            $isnumeric = $this->input->post('isnumeric') != 1 ? 0 : 1;
            $isrequire = $this->input->post('isrequire') != 1 ? 0 : 1;
            $invariant = $this->input->post('invariant') != 1 ? 0 : 1;
            $isforfilter = $this->input->post('isforfilter') != 1 ? 0 : 1;
            $isforfront = $this->input->post('isforfront') != 1 ? 0 : 1;
            $isforlist = $this->input->post('isforlist') != 1 ? 0 : 1;
            $is_date = $this->input->post('is_date') != 1 ? 0 : 1;
            $field_name_count = $this->customfield_model->field_name_like_this($id, $this->input->post('displaytitle', TRUE));
            $count = $field_name_count > 0 ? '-' . $field_name_count : '';

            $content = array();
            $content['display_name'] = $this->input->post('displaytitle', TRUE);
            $content['field_slug'] = slugify_string($this->input->post('displaytitle', TRUE));
            $field_name_count = $this->customfield_model->field_name_like_this($id, $content['field_slug']);
            $count = $field_name_count > 0 ? '-' . $field_name_count : '';
            $content['field_slug'] = slugify_string($this->input->post('displaytitle', TRUE) . $count);

            $content['custom_label'] = $this->input->post('customlabel', TRUE);
            $content['custom_field_category_id'] = $this->input->post('customfieldcategories', TRUE);
            $content['custom_input_type'] = $this->input->post('inputtype', TRUE);
            $content['custom_hint'] = $this->input->post('customhint', TRUE);
            $content['is_numeric'] = $isnumeric;
            $content['is_required'] = $isrequire;
            $content['in_variant'] = $invariant;
            $content['isforfilter'] = $isforfilter;
            $content['isforfront'] = $isforfront;
            $content['isforlist'] = $isforlist;
            $content['is_date'] = $is_date;
            $content['min_value'] = $this->input->post('minval', TRUE);
            $content['max_value'] = $this->input->post('maxval', TRUE);
            $content['options'] = $options;
            if ($this->input->post(lang('core button save'), TRUE)) 
            {
                $this->customfield_model->insert($content);
                $this->session->set_flashdata('message', lang('admin c_f Inserted Successfully'));
                redirect(base_url('admin/customfield'));
            }
            if ($this->input->post(lang('core button update'), TRUE)) {
                action_not_permitted();
                $this->customfield_model->update($id, $content);
                $this->session->set_flashdata('message', lang('admin c_f Updated Successfully'));
                redirect(base_url('admin/customfield'));
            }
        }
        $this->add_js_theme('customfield_custom_script.js');
        if ($id) {
            $this->set_title(lang('customfield title customfield_edit'));
        } else {
            $this->set_title(lang('customfield title customfield_add'));
        }
        $data = $this->includes;
        $content_data = array('editData' => $editData, 'customfield_category' => $customfield_category);
        // load views
        $data['content'] = $this->load->view('admin/customfield/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    function customfield_list() {
        $list = $this->customfield_model->get_customfield();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $customfield) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ucfirst($customfield->title);
            $row[] = ucfirst($customfield->display_name);
            $row[] = ucfirst($customfield->custom_input_type);
            $row[] = '<a href="' . base_url("admin/customfield/form/" . $customfield->id) . '" class="btn btn-primary btn-action mr-1" data-toggle="tooltip"><i class="fas fa-pencil-alt"></i></a>
                <a href="' . base_url("admin/customfield/delete/" . $customfield->id) . '" data-toggle="tooltip" class="btn btn-danger btn-action customfield_delete"><i class="fas fa-trash"></i></a>';
            $data[] = $row;
        }
        $output = array("draw" => $_POST['draw'], "recordsTotal" => $this->customfield_model->count_all(), "recordsFiltered" => $this->customfield_model->count_filtered(), "data" => $data);
        //output to json format
        echo json_encode($output);
    }
    function delete($id = NULL) {
        action_not_permitted();
        $this->customfield_model->delete($id);
        $this->session->set_flashdata('message', lang('admin c_f Deleted Successfully'));
        redirect(base_url('admin/customfield'));
    }
    function customcategorylist() {
        $this->add_css_theme('sweetalert.css');
        $this->add_js_theme('sweetalert-dev.js');
        $this->add_js_theme('custom_category_field.js');
        $this->set_title(lang('customfield title catcustom_list'));
        $data = $this->includes;
        $content_data = array();
        // load views
        $data['content'] = $this->load->view('admin/customfield/custom_category_list', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    function customcategories($id = NULL) {
        $editData = array();
        if ($id) {
            $editData = $this->customfield_model->customcategoryedit($id);
        }
        $this->form_validation->set_rules('catcustom', 'Title', 'trim|required');
        if ($this->form_validation->run() != false) {
            $formData = array();
            $formData['title'] = $this->input->post('catcustom', TRUE);
            $formData['icon'] = $this->input->post('customcategoryicon', TRUE);
            if ($this->input->post(lang('core button save'))) 
            {
                $this->customfield_model->custominsert($formData);
                $this->session->set_flashdata('message', lang('admin c_f_c Inserted Successfully'));
                redirect(base_url('admin/customfield/customcategorylist'));
            }
            if ($this->input->post(lang('core button update'))) {
                action_not_permitted();
                $this->customfield_model->customupdate($formData, $id);
                $this->session->set_flashdata('message', lang('admin c_f_c Updated Successfully'));
                redirect(base_url('admin/customfield/customcategorylist'));
            }
        } else {
            $fielderror = $this->form_validation->error_array();
        }
        $this->add_css_theme('sweetalert.css');
        $this->add_css_theme('bootstrap-iconpicker.min.css');
        $this->add_js_theme('sweetalert-dev.js');
        $this->add_js_theme('custom_category_field.js');
        $this->add_js_theme('bootstrap-iconpicker.bundle.min.js');
        $this->add_js_theme('bootstrap.bundle.min.js');
        if ($id) {
            $this->set_title(lang('customfield title catcustomfield_edit'));
        } else {
            $this->set_title(lang('customfield title catcustomfield_add'));
        }
        $data = $this->includes;
        $content_data = array('editData' => $editData);
        // load views
        $data['content'] = $this->load->view('admin/customfield/custom_category_form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    function customcategory_list() {
        $list = $this->customfield_model->get_customcategory();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $customcategory) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ucfirst($customcategory->title);
            $row[] = '<i class="' . $customcategory->icon . '"></i>';
            $row[] = date("Y-M-d", strtotime($customcategory->added));
            $row[] = '<a href="' . base_url("admin/customfield/customcategories/" . $customcategory->id) . '" class="btn btn-primary btn-action mr-1"><i class="fas fa-pencil-alt"></i></a>
            <a href="' . base_url("admin/customfield/customdelete/" . $customcategory->id) . '" class="btn btn-danger btn-action mr-1 cat_delete"><i class="fas fa-trash"></i></a>';
            $data[] = $row;
        }
        $output = array("draw" => $_POST['draw'], "recordsTotal" => $this->customfield_model->customcat_count_all(), "recordsFiltered" => $this->customfield_model->customcat_count_filtered(), "data" => $data);
        //output to json format
        echo json_encode($output);
    }
    function customdelete($id) {
        action_not_permitted();
        $this->customfield_model->custom_delete($id);
        $this->session->set_flashdata('message', lang('admin c_f_c Deleted Successfully'));
        redirect(base_url('admin/customfield/customcategorylist'));
    }
}

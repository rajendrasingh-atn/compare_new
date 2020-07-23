<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Market extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->add_css_theme('all.css');
        $this->add_js_theme('market_custom_script.js');
        // load the language files
        $this->lang->load('language');
        // load the users model
        $this->load->model('market_model');
        //load the form validation
        $this->load->library('form_validation');
        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/market'));
        define('DEFAULT_LIMIT', 10);
        define('DEFAULT_OFFSET', 0);
        define('DEFAULT_SORT', "last_name");
        define('DEFAULT_DIR', "asc");
    }
    function index() {
        $this->add_css_theme('sweetalert.css');
        $this->add_js_theme('sweetalert-dev.js');
        $this->set_title(lang('market title market_list'));
        $data = $this->includes;
        $content_data = array();
        // load views
        $data['content'] = $this->load->view('admin/market/list', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    function form($id = NULL) {
        $editData = array();
        $user_data = array();

        if ($id) {
            $editData = $this->market_model->getmarketfetch($id);
            if(isset($editData['market_user_id']) && $editData['market_user_id'])
            {
                $user_data = $this->market_model->get_market_user($editData['market_user_id']);
            }
        }

        $is_unique_username = isset($user_data['username']) && $user_data['username'] == $this->input->post('username', TRUE) ? '' : "|is_unique[users.username]";
        $is_unique_email = isset($user_data['email']) && $user_data['email'] == $this->input->post('email', TRUE) ? '' : "|is_unique[users.email]";
        $this->form_validation->set_rules('markettitle', lang('market input name'), 'trim|required');
        $this->form_validation->set_rules('market_url', lang('admin market Market Url'), 'trim|required');
        $this->form_validation->set_rules('marketdescription', lang('admin market Market description'), 'trim');

        $this->form_validation->set_rules('username', lang('market input username'), 'trim|required'.$is_unique_username);
        $this->form_validation->set_rules('email', lang('market input email'), 'trim|required'.$is_unique_email);
        $this->form_validation->set_rules('password', lang('market input password'), 'trim|required');


        if ($this->form_validation->run() != false) 
        {
            $market_user_id = isset($user_data['id']) && $user_data['id'] ? $user_data['id'] : NULL;

            // if(empty($user_data) OR empty($market_user_id))
            if(isset($editData['market_user_id']) && $editData['market_user_id'])            
            {
                $market_user_id = $editData['market_user_id'];

                $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), TRUE));
                $password = hash('sha512', $this->input->post('password', TRUE) . $salt);

                $user_data['username'] = $this->input->post('username', TRUE);
                $user_data['email'] = $this->input->post('email', TRUE);
                // $user_data['password'] = $password;
                // $user_data['salt'] = $salt;
                $this->market_model->update_market_user($market_user_id, $user_data);

            }
            else
            {
                $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), TRUE));
                $password = hash('sha512', $this->input->post('password', TRUE) . $salt);

                $user_data['username'] = $this->input->post('username', TRUE);
                $user_data['email'] = $this->input->post('email', TRUE);
                $user_data['password'] = $password;
                $user_data['salt'] = $salt;
                $user_data['first_name'] = $this->input->post('markettitle', TRUE);
                $user_data['last_name'] = $this->input->post('markettitle', TRUE);
                $user_data['is_admin'] = '0';
                $user_data['role'] = 'market';
                $user_data['status'] = '1';
                $user_data['deleted'] = '0';
                $user_data['created'] = date("Y-m-d H:i:s");

                $market_user_id = $this->market_model->insert_new_market_user($user_data);
            }
           

            if($market_user_id)
            {

                $market_name_count = $this->market_model->market_name_like_this($id, $this->input->post('markettitle', TRUE));
                $display_on_footer = $this->input->post('display_on_footer', TRUE) ? 1 : 0;

                $count = $market_name_count > 0 ? '-' . $market_name_count : '';
                $formData = array();
                $formData['market_title'] = $this->input->post('markettitle', TRUE);
                $formData['market_slug'] = slugify_string($this->input->post('markettitle', TRUE) . $count);
                $formData['market_url'] = $this->input->post('market_url', TRUE);
                $formData['market_description'] = $this->input->post('marketdescription', TRUE);
                $formData['display_on_footer'] = $display_on_footer;
                $formData['market_user_id'] = $market_user_id;

                $checkImage = $this->market_model->fetcheditimg($id);
                $formData['market_logo'] = $checkImage;
                if ($_FILES['marketimage']['name']) {
                    if (!empty($checkImage)) {
                        $path = "./assets/images/market_image/$checkImage";
                        unlink($path);
                    }
                    $config['upload_path'] = "./assets/images/market_image";
                    $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('marketimage')) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('error', $error['error']);
                    }
                    $file = $this->upload->data();
                    $formData['market_logo'] = $file['file_name'];
                }
                if ($this->input->post(lang('core button save'))) {
                    $this->market_model->insert($formData);
                    $this->session->set_flashdata('message', lang('admin market Market Inserted Successfully'));
                    redirect(base_url('admin/market'));
                }
                if ($this->input->post(lang('core button update'))) {
                    action_not_permitted();
                    $this->market_model->update($formData, $id);
                    $this->session->set_flashdata('message', lang('admin market Market Updated'));
                    redirect(base_url('admin/market'));
                }

            }
            else
            {
                $this->session->set_flashdata('error', lang('admin market user add error'));
                redirect(base_url('admin/market'));
            }
        } 
        else 
        {
            $fielderror = $this->form_validation->error_array();
        }


        if ($id) {
            $this->set_title(lang('market title market_edit'));
        } else {
            $this->set_title(lang('market title market_add'));
        }
        $data = $this->includes;
        // p($user_data);
        $content_data = array('editData' => $editData,'market_id' => $id ,'user_data' => $user_data);
        // load views
        $data['content'] = $this->load->view('admin/market/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

    function market_list() {
        $list = $this->market_model->get_market();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $market) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ucfirst($market->market_title);
            $marketImg = ($market->market_logo ? base_url('assets/images/market_image/' . $market->market_logo) : base_url('assets\images\market_image\default_market.jpg'));
            $row[] = '<img src="' . $marketImg . '" class="listing_img">';
            $row[] = '<a href="' . base_url("admin/market/form/" . $market->id) . '" class="btn btn-primary btn-action mr-1"><i class="fas fa-pencil-alt"></i></a>
                <a href="' . base_url("admin/market/delete/" . $market->id) . '" class="btn btn-danger btn-action mr-1 common_delete"><i class="fas fa-trash"></i></a>';
            $data[] = $row;
        }
        $output = array("draw" => $_POST['draw'], "recordsTotal" => $this->market_model->count_all(), "recordsFiltered" => $this->market_model->count_filtered(), "data" => $data);
        //output to json format
        echo json_encode($output);
    }
    function delete($id = NULL) {
        action_not_permitted();
        $findImage = $this->market_model->deleteimage($id);
        if (!empty($findImage)) {
            $path = "./assets/images/market_image/$findImage";
            unlink($path);
        }
        $this->market_model->delete($id);
        $this->session->set_flashdata('message', lang('admin market Market Deleted'));
        redirect(base_url('admin/market'));
    }
}

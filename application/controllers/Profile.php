<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends Private_Controller {
    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        // load the language file 
        $this->lang->load('language');
        // load the users model
        $this->load->model('users_model');
        $this->load->library('form_validation');
        $this->add_css_theme('sweetalert.css');
        $this->add_js_theme('sweetalert-dev.js');
        $this->add_js_theme('custom_profile.js');
    }
    /**************************************************************************************
     * PUBLIC FUNCTIONS 
     **************************************************************************************/
    /**
     * Profile Editor
     */
    function index() {
        // validators
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('username', lang('users input username'), 'required|trim|min_length[5]|max_length[30]|callback__check_username');
        $this->form_validation->set_rules('first_name', lang('users input first_name'), 'required|trim|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('last_name', lang('users input last_name'), 'required|trim|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('email', lang('users input email'), 'required|trim|max_length[128]|valid_email|callback__check_email');
        $this->form_validation->set_rules('language', lang('users input language'), 'required|trim');
        $this->form_validation->set_rules('password_repeat', lang('users input password_repeat'), 'min_length[5]');
        $this->form_validation->set_rules('password', lang('users input password'), 'min_length[5]|matches[password_repeat]');
        $this->form_validation->set_error_delimiters('', '');
        if ($this->form_validation->run() == TRUE) {
            action_not_permitted();
            // save the changes
            $saved = $this->users_model->edit_profile($this->input->post(), $this->user['id']);
            if ($saved) {
                // reload the new user data and store in session
                $this->user = $this->users_model->get_user($this->user['id']);
                unset($this->user['password']);
                unset($this->user['salt']);
                $this->session->set_userdata('logged_in', $this->user);
                $this->session->language = $this->user['language'];
                $this->lang->load('users', $this->user['language']);
                $this->session->set_flashdata('message', lang('users msg edit_profile_success'));
            } else {
                $this->session->set_flashdata('error', lang('users error edit_profile_failed'));
            }
            // reload page and display message
            redirect('profile');
        }
        $user_id = $this->user['id'] ? $this->user['id'] : 0;
        $products = $this->users_model->fav_product_data($user_id);
        $alarm = $this->users_model->get_user_alarm_through_userid($user_id);
        //echo '<pre>';print_r($alarm);exit;
        // setup page header data
        $this->set_title(lang('users title profile'));
        $data = $this->includes;
        // set content data
        $content_data = array('cancel_url' => base_url(), 'user' => $this->user, 'password_required' => FALSE, 'products' => $products, 'alarm' => $alarm, );
        // load views
        $data['content'] = $this->load->view('user/profile_update_form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    /**************************************************************************************
     * PRIVATE VALIDATION CALLBACK FUNCTIONS
     **************************************************************************************/
    /**
     * Make sure username is available
     *
     * @param  string $username
     * @return int|boolean
     */
    function _check_username($username) {
        if (trim($username) != $this->user['username'] && $this->users_model->username_exists($username)) {
            $this->form_validation->set_message('_check_username', sprintf(lang('users error username_exists'), $username));
            return FALSE;
        } else {
            return $username;
        }
    }
    /**
     * Make sure email is available
     *
     * @param  string $email
     * @return int|boolean
     */
    function _check_email($email) {
        if (trim($email) != $this->user['email'] && $this->users_model->email_exists($email)) {
            $this->form_validation->set_message('_check_email', sprintf(lang('users error email_exists'), $email));
            return FALSE;
        } else {
            return $email;
        }
    }
    function remove_from_favourite($product_id = NULL) {
        $status = $this->users_model->remove_from_fav_product($this->user['id'], $product_id);
        if ($status) {
            $this->session->set_flashdata('message', 'Product Removed From Favourite List');
            return redirect(base_url('profile'));
        } else {
            $this->session->set_flashdata('error', 'Invalid Request');
            return redirect(base_url('profile'));
        }
    }

    function remove_user_alarm()
    {
        $variant_id = $_POST['variant_id'];
        if(isset($this->user['id']))
        {
            $delete_data = $this->users_model->delete_alarm_data($variant_id,$this->user['id']); 
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

    function update_user_alarm_status()
    {
        $variant_id = $_POST['variant_id'];

        if(isset($this->user['id']))
        {
            $update_status = $this->users_model->update_status_through_variandid($variant_id,$this->user['id']);

            if($update_status)
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

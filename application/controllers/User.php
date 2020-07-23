<?php defined('BASEPATH') OR exit('No direct script access allowed');
class User extends Public_Controller {
    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        // load the users model
        $this->load->model('users_model');
        // load the users language file
        $this->lang->load('language');
        $this->load->library('encryption');

    }
    /**************************************************************************************
     * PUBLIC FUNCTIONS
     **************************************************************************************/
    /**
     * Default
     */
    function index() 
    {
        return redirect(base_url('login'));
    }
    /**
     * Validate login credentials
     */
    function login() {
        if ($this->session->userdata('logged_in')) {
            $logged_in_user = $this->session->userdata('logged_in');
            if ($logged_in_user['is_admin']) 
            {
                redirect('admin');
            }
            elseif($logged_in_user['role'] == 'market')
            {
                redirect(base_url('market'));
            } 
            else 
            {
                redirect(base_url());
            }
        }
        // set form validation rules
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('username', lang('users input username_email'), 'required|trim|max_length[256]');
        $this->form_validation->set_rules('password', lang('users input password'), 'required|trim|max_length[72]|callback__check_login');
        if ($this->form_validation->run() == TRUE) 
        {
            if ($this->session->userdata('redirect')) 
            {
                // redirect to desired page
                $redirect = $this->session->userdata('redirect');
                $this->session->unset_userdata('redirect');
                redirect($redirect);
            } 
            else 
            {
                $logged_in_user = $this->session->userdata('logged_in');
                if ($logged_in_user['is_admin']) 
                {
                    // redirect to admin dashboard
                    redirect('admin');
                } 
                elseif ($logged_in_user['role'] == 'market') 
                {
                    // redirect to admin dashboard
                    redirect('market');
                } 
                else 
                {
                    // redirect to landing page
                    redirect(base_url());
                }
            }
        }
        // setup page header data
        $this->set_title(lang('users title login'));
        $this->add_css_theme('login.css');
        $data = $this->includes;
        // load views
        $data['content'] = $this->load->view('user/login', NULL, TRUE);
        $this->load->view($this->template, $data);
    }
    /**
     * Logout
     */
    function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        redirect('login');
    }
    /**
     * Registration Form
     */
    function register() {
        // validators
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('username', lang('users input username'), 'required|trim|min_length[5]|max_length[30]|callback__check_username');
        $this->form_validation->set_rules('first_name', lang('users input first_name'), 'required|trim|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('last_name', lang('users input last_name'), 'required|trim|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('email', lang('users input email'), 'required|trim|max_length[256]|valid_email|callback__check_email');
        $this->form_validation->set_rules('language', lang('users input language'), 'required|trim');
        $this->form_validation->set_rules('password', lang('users input password'), 'required|trim|min_length[5]');
        $this->form_validation->set_rules('password_repeat', lang('users input password_repeat'), 'required|trim|matches[password]');
        if ($this->form_validation->run() == TRUE) 
        {
            $mail_active = get_admin_setting('email_user_activation');

            // save the changes
            $user_save_info = $this->users_model->create_profile($this->input->post(),$mail_active);

            if ($user_save_info && isset($user_save_info['id'])) 
            {
                $validation_code = $user_save_info['validation_code'];
                $user_id = $user_save_info['id'];

                if( $mail_active =="YES")
                {
                    // build the validation URL
                    $encrypted_email = sha1($this->input->post('email', TRUE));
                    $validation_url = base_url('user/validate') . "?e={$encrypted_email}&c={$validation_code}";
                    // build email
                    $email_msg = lang('core email start');
                    $email_msg.= sprintf(lang('users msg email_new_account'), $this->settings->site_name, $validation_url,'Click Here');
                    $email_msg.= lang('core email end');

                    $this->session->language = $this->input->post('language', TRUE);
                    $this->lang->load('language', $this->user['language']);
                    
                    $mail_subject = lang('users msg email_new_account_title').$this->input->post('first_name', TRUE);
                    $mail_to = $this->input->post('email', TRUE);
                    $recipet_name = $this->input->post('first_name', TRUE);

                    $this->load->library('SendMail');  

                    $mail_status = $this->sendmail->sendTo($mail_to, $mail_subject, $recipet_name, $email_msg);

                    if($mail_status)
                    {
                        $this->session->set_flashdata('message', sprintf(lang('users msg register_success'), $this->input->post('first_name', TRUE)));
                    }
                    else
                    {
                        $this->session->set_flashdata('error', "Something went wrong while sending email, If you're admin please check the SMTP configuration in site settings.");
                        $this->users_model->delete_user_by_id($user_id);
                    }
                }
                else
                {
                    $this->session->set_flashdata('message', sprintf(lang('users msg register_success'), $this->input->post('first_name', TRUE)));
                }
            } 
            else 
            {
                $this->session->set_flashdata('error', lang('users error register_failed'));
                redirect($_SERVER['REQUEST_URI'], 'refresh');
            }
            // redirect home and display message
            redirect(base_url('login'));
        }
        // setup page header data
        $this->set_title(lang('users title register'));
        $data = $this->includes;
        // set content data
        $content_data = array('cancel_url' => base_url(), 'user' => NULL, 'password_required' => TRUE);
        // load views
        $data['content'] = $this->load->view('user/profile_form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    /**
     * Validate new account
     */
    function validate() {
        // get codes
        $encrypted_email = $this->input->get('e');
        $validation_code = $this->input->get('c');
        // validate account
        $validated = $this->users_model->validate_account($encrypted_email, $validation_code);
        if ($validated) {
            $this->session->set_flashdata('message', lang('users msg validate_success'));
        } else {
            $this->session->set_flashdata('error', lang('users error validate_failed'));
        }
        redirect(base_url('login'));
    }
    /**
     * Forgot password
     */
    function forgot() 
    {
        // validators
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('email', lang('users input email'), 'required|trim|max_length[256]|valid_email|callback__check_email_exists');
        if ($this->form_validation->run() == TRUE) {
            action_not_permitted();
            // save the changes
            $results = $this->users_model->reset_password_by_token($this->input->post('email',TRUE));
            if ($results) 
            {
                $key = uniqid(rand(),1);
                $token = md5($key."_EMAIL_".$results->email);

                $token_data = array();
                $token_data['token']         = $token;
                $token_data['updated']       = date('Y-m-d H:i:s');

                $update_status = $this->users_model->update_user_token_by_email($results->email, $token_data);
                if($update_status)
                {
                    $reset_url = base_url('user/reset-my-password/').$token;

                    $email_msg = lang('core email start');
                    $email_msg.= sprintf(lang('users msg email_password_reset'), $this->settings->site_name, 'Click the below link to reset your password <br>',$reset_url,'click Here');
                    $email_msg.= '<br>'.lang('core email end');
                    // send email

                    $mail_to = $results->email;
                    $recipet_name = $results->first_name;
                    $mail_subject = lang('users msg email_password_reset_title').$results->first_name;

                    $this->load->library('SendMail');   

                    $mail_status = $this->sendmail->sendTo($mail_to, $mail_subject, $recipet_name, $email_msg);

                    if($mail_status)
                    {
                        $this->session->set_flashdata("message", "An email has been sent to the address you have provided. Please follow the link in the email to complete you password reset request.");
                    }
                    else
                    {
                        $this->session->set_flashdata("error","Something went wrong while sending email, If you're admin please check the SMTP configuration in site settings.");
                    }
                }
                else
                {
                     $this->session->set_flashdata("error","Sorry! Error occurred while password update process.");
                }
                
            } 
            else 
            {
                $this->session->set_flashdata('error', lang('users error password_reset_failed'));
            }

            redirect(base_url('login'));
        }
        // setup page header data
        $this->set_title(lang('users title forgot'));
        $data = $this->includes;
        // set content data
        $content_data = array('cancel_url' => base_url(), 'user' => NULL);
        // load views
        $data['content'] = $this->load->view('user/forgot_form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

    function resend_activation() 
    {
        // validators
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('email', lang('users input email'), 'required|trim|max_length[256]|valid_email|callback__check_email_exists');
        if ($this->form_validation->run() == TRUE) 
        {
            action_not_permitted();
            // save the changes

                $user_data = $this->users_model->users_email_activation_exist($this->input->post('email', TRUE));
                if(empty($user_data))
                {
                    $this->session->set_flashdata('error','Invalid User Email Address ! ');

                    redirect(base_url('login'));
                }

                if($user_data->status === 1)
                {
                    $this->session->set_flashdata('error',"$user_data->first_name ".'Your Account is Already active !');

                    redirect(base_url('login'));
                }


                $validation_code = sha1(microtime(TRUE) . mt_rand(10000, 90000));
                $email = $this->input->post('email', TRUE);
            
                $data['validation_code'] = $validation_code;
                $update = $this->users_model->update_user_token_by_email($email,$data);

                if($update)
                {
                                        // build the validation URL
                    $encrypted_email = sha1($this->input->post('email', TRUE));
                    $validation_url = base_url('user/validate') . "?e={$encrypted_email}&c={$validation_code}";
                    // build email
                    $email_msg = lang('core email start');
                    $email_msg.= sprintf(lang('users msg email_new_account'), $this->settings->site_name, $validation_url,'Click Here');
                    $email_msg.= lang('core email end');

                    $this->session->language = $user_data->language;
                    $this->lang->load('language', $this->user['language']);
                    
                    $mail_subject = lang('users msg email_new_account_title').$user_data->first_name;
                    $mail_to = $email;
                    $recipet_name = $user_data->first_name;

                    $this->load->library('SendMail');  

                    $mail_status = $this->sendmail->sendTo($mail_to, $mail_subject, $recipet_name, $email_msg);

                    if($mail_status)
                    {
                        $this->session->set_flashdata('message', sprintf(lang('users msg register_success'), $this->input->post('first_name', TRUE)));
                    }
                    else
                    {
                        $this->session->set_flashdata('error', "Something went wrong while sending email, If you're admin please check the SMTP configuration in site settings.");
                    }
                }
                else
                {
                     $this->session->set_flashdata('error', "Something went wrong Try After Some Time .");
                }

            redirect(base_url('login'));
        }
        // setup page header data
        $this->set_title(lang('users title forgot'));
        $data = $this->includes;
        // set content data
        $content_data = array('cancel_url' => base_url(), 'user' => NULL);
        // load views
        $data['content'] = $this->load->view('user/resend_form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    /**************************************************************************************
     * PRIVATE VALIDATION CALLBACK FUNCTIONS
     **************************************************************************************/
    /**
     * Verify the login credentials
     *
     * @param  string $password
     * @return boolean
     */
    function _check_login($password) {
        // limit number of login attempts
        $ok_to_login = $this->users_model->login_attempts();
        if ($ok_to_login) {
            $login = $this->users_model->login($this->input->post('username', TRUE), $password);
            if ($login && $login !='not-active') {
                $this->session->set_userdata('logged_in', $login);
                return TRUE;
            }
            elseif($login =='not-active')
            {
               
                $this->form_validation->set_message('_check_login', 'Before you can login, you must active your account with the code sent to your email address. Or Resend Activation Mail ');
                return FALSE;
            }
            else
            {
                $this->form_validation->set_message('_check_login', lang('users error invalid_login'));
                return FALSE;

            }
        }
        $this->form_validation->set_message('_check_login', sprintf(lang('users error too_many_login_attempts'), $this->config->item('login_max_time')));
        return FALSE;
    }
    /**
     * Make sure username is available
     *
     * @param  string $username
     * @return int|boolean
     */
    function _check_username($username) {
        if ($this->users_model->username_exists($username)) {
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
        if ($this->users_model->email_exists($email)) {
            $this->form_validation->set_message('_check_email', sprintf(lang('users error email_exists'), $email));
            return FALSE;
        } else {
            return $email;
        }
    }
    /**
     * Make sure email exists
     *
     * @param  string $email
     * @return int|boolean
     */
    function _check_email_exists($email) {
        if (!$this->users_model->email_exists($email)) {
            $this->form_validation->set_message('_check_email_exists', sprintf(lang('users error email_not_exists'), $email));
            return FALSE;
        } else {
            return $email;
        }
    }




public function reset_password_form($token = NULL)
{

    if(empty($token))
    {
        $this->session->set_flashdata("error", "Sorry! The link is invalid or has been expired!");
        return redirect(base_url('login'));
    }
       

    $user_data = $this->users_model->check_is_valid_user($token);

    if(empty($user_data))
    {
        
        $this->session->set_flashdata("error", "Sorry! The link is invalid or has been expired!");
        return redirect(base_url('login'));
    }
    
    $email = $user_data->email;
    $action = base_url('user/reset-my-password/').$token;
    $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
    $this->form_validation->set_rules('password', lang('users input password'), 'required|trim|min_length[5]');
    $this->form_validation->set_rules('password_repeat', lang('users input password_repeat'), 'required|trim|matches[password]');
        
    if ($this->form_validation->run() == TRUE) 
    {
        if($this->input->post('password') == $this->input->post('password_repeat'))
        {

            $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), TRUE));
            $password = hash('sha512', $this->input->post('password',TRUE) . $salt);

             $data['password']             = $password;
             $data['salt']                 = $salt;
             $data['token']                = NULL;
             $data['updated']              = date('Y-m-d H:i:s');

            $update_status = $this->users_model->update_user_token_by_email($email,$data);
            if($update_status)
            {
                $this->session->set_flashdata("message", "Success! Your Password has been changed!");
                return redirect(base_url('login'));
            }
            else
            {
                $this->session->set_flashdata("error", "Something went wrong while password update.");
                return redirect($action);
            }
        } 
        else 
        {
            $this->session->set_flashdata("error", "'Confirm Password' and 'Password' do not match.");
            return redirect($action);
        }
    }
    else
    {
        $this->set_title('Reset Password');
        $data = $this->includes;
        $content_data = array('cancel_url' => base_url(), 'user' => NULL, 'action' => $action);
        $data['content'] = $this->load->view('user/reset_password_form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }       

}


}
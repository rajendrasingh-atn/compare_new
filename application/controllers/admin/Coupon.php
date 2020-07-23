<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Coupon extends Admin_Controller {
    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        $this->add_css_theme('all.css');
        $this->add_js_theme('jquery.multi-select.min.js');
        $this->add_js_theme('coupon.js');
        $this->add_css_theme('sweetalert.css');
        $this->add_js_theme('sweetalert-dev.js');
        $this->add_js_theme('bootstrap-notify.min.js');
		
		$this->add_css_theme('summernote.css');
        $this->add_js_theme('summernote.min.js');

		
		// $this->add_css_theme('font-awesome-4.7.min.css');
		$this->add_css_theme('bootstrap-datetimepicker.min.css');
        $this->add_js_theme('moment-with-locales.js');
        $this->add_js_theme('bootstrap-datetimepicker.min.js');
		
		// $this->add_css_theme('bootstrap-timepicker.min.css');
  //       $this->add_js_theme('bootstrap-timepicker.min.js');

        // load the language files
        $this->lang->load('language');
        // load the category model
        $this->load->model('CouponModel');
        //load the form validation
        $this->load->library('form_validation');
        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/coupon'));
        define('DEFAULT_LIMIT', 10);
        define('DEFAULT_OFFSET', 0);
        define('DEFAULT_SORT', "id");
        define('DEFAULT_DIR', "asc");
    }


    function index() 
    {
        
        $this->set_title('Coupons List');
        $data = $this->includes;
        $content_data = array();
        $data['content'] = $this->load->view('admin/coupon/list', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }



    function add() 
    {
        $image = NULL;

        $this->form_validation->set_rules('title', 'Coupons Title', 'required|trim|is_unique[coupons.title]');
        $this->form_validation->set_rules('description', 'Coupons Description', 'required|trim');
        $this->form_validation->set_rules('promo_link', 'Coupons Promo Link', 'required|trim');
        // $this->form_validation->set_rules('coupon_code', 'Coupons Code', 'required|trim');
        $this->form_validation->set_rules('valid_till', 'Coupons Valid Till', 'required|trim');

        if (empty($_FILES['image']['name'])) 
        {
            $this->form_validation->set_rules('image', 'Coupons Image', 'required|trim');
        }
        else
        {
            $new_name = date('Y_m_d_H_i_s_').$_FILES["image"]['name'];
            $config['upload_path'] = "./assets/images/coupon/";
            $config['allowed_types'] = 'jpg|png|bmp|jpeg';
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image')) 
            {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
                $this->form_validation->set_rules('image', 'Coupons Image', 'required|trim');
            }

            $file = $this->upload->data();
            $image = $file['file_name'];
        
        }

        if ($this->form_validation->run() == false) 
        {
            $this->form_validation->error_array();
        } 
        else 
        {
            $coupon_content = array();

            $is_coupon = $this->input->post('is_coupon', TRUE) ? 1 : 0;
            $coupon_code = $this->input->post('coupon_code',TRUE) ? $this->input->post('coupon_code',TRUE) : NULL;


            $coupon_content['title'] = $this->input->post('title',TRUE);
            $coupon_content['description'] = $this->input->post('description',TRUE);
            $coupon_content['promo_link'] = $this->input->post('promo_link',TRUE);
            $coupon_content['coupon_code'] = $coupon_code;
            $coupon_content['valid_till'] = $this->input->post('valid_till',TRUE);
            $coupon_content['is_coupon'] = $is_coupon;

            if($image)
            {                
                $coupon_content['image'] = $image;
            }

            $coupon_content['added'] =  date('Y-m-d H:i:s');

            $coupon_id = $this->CouponModel->insert_coupon($coupon_content);

            if($coupon_id)
            {                
                $this->session->set_flashdata('message', 'Coupon Added Successfully !');                  
            }
            else
            {
                $this->session->set_flashdata('error', 'Error During Ading Coupon !'); 
            }
             redirect(base_url('admin/coupon'));

        }
            
        $this->set_title('Add Coupon');
        $data = $this->includes;

        $content_data = array();
        // load views
        $data['content'] = $this->load->view('admin/coupon/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }



    function update($coupon_id = NULL) 
    {
        if(empty($coupon_id))
        {
           $this->session->set_flashdata('error', 'Invalid Url'); 
           redirect(base_url('admin/coupon'));
        }

        $coupon_data = $this->CouponModel->get_coupon_by_id($coupon_id);

        if(empty($coupon_data))
        {
           $this->session->set_flashdata('error', 'Invalid Coupon Id'); 
           redirect(base_url('admin/coupon'));
        }
       

        $title_unique = $this->input->post('title')  != $coupon_data->title ? '|is_unique[coupons.title]' : '';       

        $this->form_validation->set_rules('title', 'Coupon Name', 'required|trim'.$title_unique);
        $this->form_validation->set_rules('description', 'Coupons Description', 'required|trim');
        $this->form_validation->set_rules('promo_link', 'Coupons Promo Link', 'required|trim');
        // $this->form_validation->set_rules('coupon_code', 'Coupons Code', 'required|trim');
        $this->form_validation->set_rules('valid_till', 'Coupons Valid Till', 'required|trim');


        if (empty($_FILES['image']['name']) && empty($coupon_data->image)) 
        {
            $this->form_validation->set_rules('image', 'Coupons Image', 'required|trim');
        }
        
        $image = NULL;

        if(isset($_FILES['image']['name']) && $_FILES['image']['name'])
        {
            $new_name = date('Y_m_d_H_i_s_').$_FILES["image"]['name'];
            $config['upload_path'] = "./assets/images/coupon/";
            $config['allowed_types'] = 'jpg|png|bmp|jpeg';
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image')) 
            {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
                $this->form_validation->set_rules('image', 'Coupon Image', 'required|trim');
            }

            $file = $this->upload->data();
            $image = $file['file_name'];
        
        }

        
        if ($this->form_validation->run() == false) 
        {
            $this->form_validation->error_array();
        } 
        else 
        {
            $is_coupon = $this->input->post('is_coupon', TRUE) ? 1 : 0;
            $coupon_code = $this->input->post('coupon_code',TRUE) ? $this->input->post('coupon_code',TRUE) : NULL;

            $coupon_content = array();

            $coupon_content['title'] = $this->input->post('title',TRUE);
            $coupon_content['description'] = $this->input->post('description',TRUE);
            $coupon_content['promo_link'] = $this->input->post('promo_link',TRUE);
            $coupon_content['coupon_code'] = $coupon_code;
            $coupon_content['valid_till'] = $this->input->post('valid_till',TRUE);
            $coupon_content['is_coupon'] = $is_coupon;

            if($image)
            {                
                $coupon_content['image'] = $image;
            }

            $coupon_content['updated'] =  date('Y-m-d H:i:s');

            $language_update_status = $this->CouponModel->update_coupon($coupon_id, $coupon_content);

            if($language_update_status)
            {
                $this->session->set_flashdata('message', 'Coupon Updated Successfully !');                  
            }
            else
            {
                $this->session->set_flashdata('error', 'Error During Updating Coupon !'); 
            }
            
            redirect(base_url('admin/coupon'));
        }

        
        $this->set_title('Update Coupon');
        $data = $this->includes;

        $content_data = array('coupon_id' => $coupon_id, 'coupon_data' => $coupon_data);
        // load views
        $data['content'] = $this->load->view('admin/coupon/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }


    function delete($coupon_id = NULL)
    {
        $status = $this->CouponModel->delete_coupon($coupon_id);
        if ($status) 
        {
            $this->session->set_flashdata('message', 'Coupon delete Successfully !');  
        }
        else
        {
            $this->session->set_flashdata('error', 'Error During delete Coupon !'); 
        }
        redirect(base_url('admin/coupon'));
    }


    function coupon_list() 
    {
        $data = array();
        $list = $this->CouponModel->get_coupons();

        $no = $_POST['start'];
        foreach ($list as $coupon_data) 
        {
            $image  = $coupon_data->image ? $coupon_data->image : 'default.png';
            $image_dir  = base_url('assets/images/coupon/');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ucfirst($coupon_data->title);
            $row[] = $coupon_data->promo_link;
            $row[] = $coupon_data->coupon_code;
            $row[] = $coupon_data->valid_till;

            $button = '<a href="' . base_url("admin/coupon/update/". $coupon_data->id) . '"  title="Edit Coupon" class="btn btn-primary btn-action mr-1">
            <i class="fas fa-pencil-alt"></i>
            </a>';

           
            $button.= '
                <a href="' . base_url("admin/coupon/delete/" . $coupon_data->id) . '"  title="Delete Coupon" class="btn btn-danger btn-action mr-1 common_delete">
                <i class="fas fa-trash"></i>
                </a>';
            $row[] = $button;
            $data[] = $row;
        }
        $output = array("draw" => $_POST['draw'], "recordsTotal" => $this->CouponModel->count_all(), "recordsFiltered" => $this->CouponModel->count_filtered(), "data" => $data,);
        //output to json format
        echo json_encode($output);
    }

      
}


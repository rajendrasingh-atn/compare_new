<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Rap2hpoutre\FastExcel\FastExcel;
use App\User;

class Excel_import extends Market_Controller {
    /**
     * @var string
     */
    private $_redirect_url;

    protected $brands = [];

    protected $markets = [];
    protected $groups = [];
    protected $custom_fields = [];
    // protected $custom_fields = [
    //     'id' =>
    //     'name/display_name' => $display_name,
    //     'custom_label' => $display_name,
    //     'custom_input_type' => 'text',
    //     'group_id/custom_field_categor_id' => 
    // ];
    



    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        $this->load->model('Import_Model');
        $this->load->model('product_model');
        $this->lang->load('language');

        // $this->load->model('excel_import_model');
        // $this->load->library('excel');

    }
    /**************************************************************************************
     * PUBLIC FUNCTIONS
     **************************************************************************************/
    /**
     * Message list page
     */
    function index() 
    {

        $this->form_validation->set_rules('category', lang('admin import Product Category'), 'numaric|required');
        if(empty($_FILES["excel_file"]['name']))
        {            
            $this->form_validation->set_rules('excel_file', lang('admin import Excel FIle'), 'required');
        }

        if ($this->form_validation->run() OR empty($this->input->post('category'))) 
        {
            $this->form_validation->error_array();
        }
        else
        {
            $image = time().'-'.$_FILES["excel_file"]['name'];
            
            $config['upload_path']      = "./assets/excel";
            $config['allowed_types']    = 'xlsx|csv|xls';
            $config['file_name']        = $image;
            
            $this->load->library('upload', $config);
            // $this->upload->initialize($config);
            if (!$this->upload->do_upload('excel_file')) 
            {
                $error =  $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
                return redirect(base_url('market/excel_import'));
            }
            else
            {
                $file = $this->upload->data();
                $content['category_image'] = $file['file_name'];
            }
            $category_id = $this->input->post('category');
            $import = $this->import_Excel_data($file['file_name'], $category_id);

            if($import)
            {
                $this->session->set_flashdata('message', lang('admin import Data Import Successfully'));
                return redirect(base_url('market/excel_import'));                
            }
            else
            {
                $this->session->set_flashdata('error', lang('admin import Data Import Error'));
                return redirect(base_url('market/excel_import'));        
            }
        }
       
        $this->set_title(lang('admin Import Product Data'));
        $data = $this->includes;
        $category_data = $this->Import_Model->all_category_name();
        $content_data = array('category_data' => $category_data);
        // load views
        $data['content'] = $this->load->view('market/import/form', $content_data, TRUE);
        $this->load->view($this->template, $data);

    }

    function import_Excel_data($file_name, $category_id) 
    {

        $file_dir = "./assets/excel/".$file_name;
        $brands_array = $this->Import_Model->get_all_brands_from_db();
        $markets_array = $this->Import_Model->get_all_markets_from_db();


        foreach ($brands_array as $brands_data_array) 
        {
            $this->brands[$brands_data_array->id] = $brands_data_array->brand_title;
        }

        foreach ($markets_array as $market_data_array) 
        {
            $this->markets[$market_data_array->id] = $market_data_array->market_title;
        }

        $product_detail_array = (new FastExcel)->import($file_dir);
        // $product_detail_array = (new FastExcel)->import('./test1.xlsx');

        $product_detail_array = $product_detail_array ? $product_detail_array : array();
        $product_array = array();

        $product_id = NULL;


        foreach ($product_detail_array as $key => $product_detail_data) 
        {
            if($product_detail_data['product_title'])
            {
                $brand = $product_detail_data['brand'];

                if($brand_id = array_search($brand, $this->brands)) 
                {
                   // $brand_id = $this->brands;
                } 
                else 
                {
                    $brand_data['brand_title'] = $brand;
                    $brand_data['brand_slug'] = slugify_string($brand);
                    $brand_data['added'] = date("Y-m-d H:i:s");
                    // $brand_id = $this->Import_Model->insert_brand($brand_data);
                    $brand_id = 1;
                    $this->brands[$brand_id] = $brand;
                }



                if(!$key) 
                {

                    foreach ($product_detail_data as $keyy => $value) 
                    {
                        
                        if (strpos($keyy, 'Market::') !== false) 
                        {
                            $market_key_array = explode("::", $keyy);

                            $market_name = isset($market_key_array[1]) ? $market_key_array[1] : '';
                            $market_field = isset($market_key_array[2]) ? $market_key_array[2] : '';
                            $market_excel_data[$market_name][$market_field] = $value;

                            if(array_search($market_name, $this->markets) == FALSE) 
                            {
                                $market_content['market_title'] = $market_name;
                                $market_content['market_slug'] = slugify_string($market_name);
                                $market_content['market_url'] = $market_excel_data[$market_name]['market_url'];
                                $market_content['market_description'] = $market_name;
                                $market_content['market_added'] = date("Y-m-d H:i:s");
                                $market_id = $this->Import_Model->insert_market_data($market_content);
                                $market_content =array();
                                $this->markets[$market_id] = $market_name;
                            }

                        }


                        if (strpos($keyy, 'Group::') !== false) 
                        {
                            $group_key_array = explode("::", $keyy);

                            $group_name = isset($group_key_array[1]) ? $group_key_array[1] : '';
                            $custom_field = isset($group_key_array[2]) ? $group_key_array[2] : '';
                            $group_excel_data[$group_name][$custom_field] = $value;

                            if(array_search($group_name, $this->groups))
                            {
                                $group_id = array_search($group_name, $this->groups);
                            }
                            else 
                            {
                                $group_content['title'] = $group_name;
                                $group_content['added'] = date("Y-m-d H:i:s");
                                $is_group = $this->Import_Model->is_group_exist($group_name);

                                if($is_group)
                                {
                                    $group_id = $is_group->id;
                                    $this->groups[$group_id] = $group_name;
                                }
                                else
                                {
                                    $group_id = $this->Import_Model->insert_group_data($group_content); 
                                    $this->groups[$group_id] = $group_name;
                                }
                                
                                $group_content =array();
                            }


                            $is_custom_field_exist = $this->Import_Model->is_custom_field_exist($group_id, $custom_field);
                            $custom_field_like = $this->Import_Model->custom_field_like($custom_field);

                            if($is_custom_field_exist)
                            {
                                $custom_field_id = $is_custom_field_exist->id;
                            }
                            else
                            {
                                $custom_field_content['display_name'] = $custom_field;
                                $custom_field_content['field_slug'] = slugify_string($custom_field.$custom_field_like);
                                $custom_field_content['custom_label'] = $custom_field;
                                $custom_field_content['custom_field_category_id'] = $group_id;
                                $custom_field_content['custom_input_type'] = 'text';
                                $custom_field_content['isforfront'] = 1;
                                $custom_field_content['isforlist'] = 1;
                                $custom_field_id = $this->Import_Model->insert_custom_field_data($custom_field_content);

                                $custom_field_content =array();

                                $category_custom_field_data['category_id'] = $category_id;
                                $category_custom_field_data['custom_field_id'] = $custom_field_id;
                                $category_custom_field_data['category_custom_order'] = 0;
                                $this->Import_Model->insert_category_custom_field_data($category_custom_field_data);
                                $category_custom_field_data = array();
                            }
                            $this->custom_fields[$group_name][$custom_field_id] = $custom_field;
                        }
                    }
                }

                 
                $is_product = $this->Import_Model->product_is_exist($product_detail_data['product_title']);

                $product_array['product_title'] = $product_detail_data['product_title'];
                $product_array['product_slug'] = slugify_string($product_detail_data['product_title']);
                $product_array['product_category_id'] = $category_id;
                $product_array['product_brand_id'] = $brand_id;
                $product_array['product_description'] = $product_detail_data['product_description'];
                $product_array['product_meta_keyword'] = $product_detail_data['product_meta_keyword'];
                $product_array['product_meta_description'] = $product_detail_data['product_meta_description'];

                if($is_product)
                {
                    $product_id = $is_product->id;
                    $this->Import_Model->update_product_data($product_array,$product_id);
                }
                else
                {
                    $product_id = $this->Import_Model->product_insert($product_array); 

                }
                $product_varient_data = $this->Import_Model->product_varient_by_pro_id($product_id);
                                    echo "<pre>";

                if($product_varient_data)
                {
                    $variant_id  = $product_varient_data->id;
                }
                else
                {
                    $product_title_sku = slugify_string($product_detail_data['product_title']);

                    $product_sku_count = $this->Import_Model->product_sku_is_exist($product_title_sku);

                    $product_variant['product_id'] = $product_id;
                    $product_variant['product_image'] = json_encode(array());
                    $product_variant['is_primary'] = 1;
                    $product_variant['sku'] = slugify_string($product_title_sku.'-'.$product_sku_count);

                    $variant_id = $this->Import_Model->product_varient_insert($product_variant);  

                }


                $market_key_array = array();
                $market_excel_data = array();
                $market_id_array = array();
                $market_content = array();

                $group_key_array  =array();
                $group_excel_data = array();
                $custom_field_id_array = array();
                $custom_field_content = array();
                $market_excel_data = array();
                $market_key_array =array();


                foreach ($product_detail_data as $excel_key => $market_value) 
                {

                    if (strpos($excel_key, 'Market::') !== false) 
                    {
                        $market_key_array = explode("::", $excel_key);
                        $market_name = isset($market_key_array[1]) ? $market_key_array[1] : '';
                        $market_field = isset($market_key_array[2]) ? $market_key_array[2] : '';
                        $market_excel_data[$market_name][$market_field] = $market_value;
                        
                    }

                    if (strpos($excel_key, 'Group::') !== false) 
                    {
                        $group_key_array = explode("::", $excel_key);
                        $group_name = isset($group_key_array[1]) ? $group_key_array[1] : '';
                        $custom_field = isset($group_key_array[2]) ? $group_key_array[2] : '';
                        $group_excel_data[$group_name][$custom_field] = $market_value;
                    }
                }
     
                foreach ($market_excel_data as $data_market_name => $market_field_array) 
                {

                    if($market_id = array_search($data_market_name, $this->markets)) 
                    {
                        $market_id_array[] = $market_id;
                        $market_content[] = array(
                                                   'product_variant_id' => $variant_id,
                                                   'market_id'          => $market_id,
                                                   'base_price'         => $market_excel_data[$market_name]['product_price'],
                                                   'sale_price'         => $market_excel_data[$market_name]['product_price'],
                                                   'affiliate_marketing_url'         => $market_excel_data[$market_name]['market_url'],
                                                ); 
                    }
                }

                if($market_id_array)
                {
                    $this->Import_Model->varient_market_delete($variant_id, $market_id_array); 
                    $this->Import_Model->insert_market_varient_data($market_content);  
                    $market_content = array();
                }

                foreach ($group_excel_data as $data_group_name => $custom_field_array) 
                {
                    if($this->custom_fields[$data_group_name]) 
                    {


                        foreach ($custom_field_array as $custom_field_name => $c_f_value) 
                        {
                            $field_id = array_search($custom_field_name, $this->custom_fields[$data_group_name]);
                            $custom_field_id_array[] = $field_id;

                            $custom_field_content[] = array (
                                                               'product_variant_id' => $variant_id,
                                                               'custom_field_id'    => $field_id,
                                                               'value'              => $c_f_value,
                                                            ); 
                        }                    
                    }
                }
                if($custom_field_id_array)
                {
                    $this->Import_Model->varient_c_field_delete($variant_id, $custom_field_id_array); 
                    $this->Import_Model->insert_c_field_varient_data($custom_field_content);  
                }

                $this->update_product_details_data($category_id, $variant_id, $product_id);

            }
        }

        return TRUE;
    }


    public function update_product_details_data($category_id = NULL, $product_variant_id = NULL, $product_id = NULL) 
    {
        /************** Product Details Work *****************/
        $product_short_details = array(); 
        $product_full_details = array();
        $product_lowest_marcket = array();
        $list_page_customfield__data_array = $this->product_model->list_page_customfield__data($category_id, $product_variant_id);
        foreach ($list_page_customfield__data_array as $list_page_customfield__data) {
            $custom_field_group_name = $list_page_customfield__data['custom_field_group_name'];
            $custom_field_name = $list_page_customfield__data['field_name'];
            $product_short_details[$custom_field_group_name][$custom_field_name] = array('value' => $list_page_customfield__data['value'],);
        }
        $detail_page_customfield__data_array = $this->product_model->detail_page_customfield__data_array($category_id, $product_variant_id);
        foreach ($detail_page_customfield__data_array as $detail_page_customfield__data) {
            $custom_field_group_name = $detail_page_customfield__data['custom_field_group_name'];
            $custom_field_name = $detail_page_customfield__data['field_name'];
            if ($detail_page_customfield__data['value']) {
                $product_full_details[$custom_field_group_name][$custom_field_name] = array('value' => $detail_page_customfield__data['value']);
            }
        }
        $product_lowest_marcket = $this->product_model->get_product_lowest_marcket($product_variant_id);
        $product_details['product_short_detail'] = json_encode($product_short_details);
        $product_details['product_full_detail'] = json_encode($product_full_details);
        $product_details['product_lowest_marcket'] = json_encode($product_lowest_marcket);
        return $this->product_model->update_product_details($product_id, $product_details);
        /************** End Product Details Work *****************/
    }



    public function importdata()
    { 
        if(isset($_POST["submit"]))
        {
            $file = $_FILES['file']['tmp_name'];
            $handle = fopen($file, "r");
            $c = 0;//
            while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
            {
                $fname = $filesop[0];
                $lname = $filesop[1];
                if($c<>0){                  //SKIP THE FIRST ROW
                    $this->Crud_model->saverecords($fname,$lname);
                }
                $c = $c + 1;
            }
            echo lang('admin sucessfully import data');
                
        }
    }

        
    /**
     * Export list to CSV
     */
    function export() {
        // get parameters
        $sort = $this->input->get('sort') ? $this->input->get('sort', TRUE) : DEFAULT_SORT;
        $dir = $this->input->get('dir') ? $this->input->get('dir', TRUE) : DEFAULT_DIR;
        // get filters
        $filters = array();
        if ($this->input->get('name')) {
            $filters['name'] = $this->input->get('name', TRUE);
        }
        if ($this->input->get('email')) {
            $filters['email'] = $this->input->get('email', TRUE);
        }
        if ($this->input->get('title')) {
            $filters['title'] = $this->input->get('title', TRUE);
        }
        if ($this->input->get('created')) {
            $filters['created'] = date('Y-m-d', strtotime(str_replace('-', '/', $this->input->get('created', TRUE))));
        }
        // get all messages
        $messages = $this->contact_model->get_all(0, 0, $filters, $sort, $dir);
        if ($messages['total'] > 0) {
            // export the file
            array_to_csv($messages['results'], "messages");
        } else {
            // nothing to export
            $this->session->set_flashdata('error', lang('core error no_results'));
            redirect($this->_redirect_url);
        }
        exit;
    }
    /**************************************************************************************
     * AJAX FUNCTIONS
     **************************************************************************************/
    /**
     * Marks email message as read
     *
     * @param  int $id
     * @return boolean
     */
    function read($id = NULL) {
        if ($id) {
            $read = $this->contact_model->read($id, $this->user['id']);
            if ($read) {
                $results['success'] = lang('contact msg updated');
            } else {
                $results['error'] = lang('contact error update_failed');
            }
        } else {
            $results['error'] = lang('contact error update_failed');
        }
        display_json($results);
        exit;
    }
}

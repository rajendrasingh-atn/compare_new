<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception; 

class Product extends Admin_Controller {
    function __construct() { 
        parent::__construct();
        $this->add_css_theme('all.css');
        $this->add_css_theme('dropzone.css');
        $this->add_css_theme('bootstrap4-toggle.min.css');
        $this->add_js_theme('dropzone.js');
        $this->add_js_theme('bootstrap4-toggle.min.js');
        $this->lang->load('language');
        $this->load->model('product_model');
        $this->load->library('form_validation');
        $this->load->helper("My_custom_field_helper");
        $this->load->helper('url');
        // set constants
        define('REFERRER', "referrer");
        define('THIS_URL', base_url('admin/product'));
        define('DEFAULT_LIMIT', 10);
        define('DEFAULT_OFFSET', 0);
        define('DEFAULT_SORT', "last_name");
        define('DEFAULT_DIR', "asc");
    }
    
    function index() 
    {
        $this->add_css_theme('sweetalert.css');
        $this->add_js_theme('sweetalert-dev.js');
        $this->add_js_theme('product_custom_script.js');
        $this->set_title(lang('product title product_list'));
        $data = $this->includes;
        $content_data = array();
        // load views
        $data['content'] = $this->load->view('admin/product/list', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

    function form($product_id = NULL) 
    {
        $product_data = array();
        $fetchmarketdata = array();
        $fetch_additional_market_data = array();
        $get_custom_field_with_category = array();
        $field_groups_of_category = array();
        $custom_field_group_data = array();
        $category_data = array();
        $get_product_varient = array();
        $custom_varient_field_value = array();
        $product_category_info = array();
        $category_id = NULL;
        $last_variant_id = NULL;
        // product edit work 
        $additionalmarket_array = $this->input->post('additionalmarketname') ? $this->input->post('additionalmarketname') : array();
        $additionalbaseprice_array = $this->input->post('additionalbaseprice') ? $this->input->post('additionalbaseprice') : array();
        $additionalsaleprice_array = $this->input->post('additionalsaleprice') ? $this->input->post('additionalsaleprice') : array();
        $additionalaffiurl_array = $this->input->post('additionalaffiliateurl') ? $this->input->post('additionalaffiliateurl') : array();
        

        if ($product_id) 
        {
            $product_data = $this->product_model->fetchproductdata($product_id);

            if (empty($product_data)) 
            {
                $this->session->set_flashdata('error', lang('Sorry Invalid Request'));
                return redirect(base_url('/admin/product'));
            }

            $category_id = $product_data['product_category_id'];
            $get_product_varient = $product_varient = $this->product_model->get_first_product_varient($product_id);
            $last_variant_id = $get_product_varient->id;
            $fetchmarketdata= $this->product_model->fetchproductmarket($last_variant_id);
            // $fetch_additional_market_data = $this->product_model->fetchadditionalmarket($last_variant_id);
            //echo '<pre>';print_r($fetchmarketdataget);exit;

            // foreach ($fetchmarketdataget as $market_variant_values) 
            // {
            //     $fetchmarketdata[$market_variant_values['market_id']] = $market_variant_values;
            // }
        }
        
        if ($this->input->post('productcategory')) 
        {
            $category_id = $this->input->post('productcategory', TRUE);
        }

        if ($category_id) 
        {
            
            $category_custom_field_ids = $this->product_model->category_custom_field_id($category_id);
            $field_groups_of_category = $this->product_model->field_groups_of_category($category_id);
            $get_custom_field_with_category = $this->product_model->get_custom_field_width_category_id($category_id);
            $product_category_info = $this->product_model->product_category_info($category_id);
            
            foreach ($field_groups_of_category as $field_groups_of_category_array) 
            {
                $custom_field_group_id = $field_groups_of_category_array['custom_field_group_id'];
                $custom_field_group_data[$custom_field_group_id] = $this->product_model->custom_field_group_data($category_id, $custom_field_group_id);
            }
            
            foreach ($category_custom_field_ids as $category_custom_field_id_array) 
            {
                $category_custom_field_id = $category_custom_field_id_array['custom_field_id'];
                
                if (isset($_POST['custom_field'][$category_custom_field_id])) 
                {
                    $category_data[$category_custom_field_id] = $_POST['custom_field'][$category_custom_field_id];
                }
            }
            
            if ($last_variant_id) 
            {
                foreach ($category_custom_field_ids as $custom_field_id_array) 
                {
                    $category_custom_field_id = $custom_field_id_array['custom_field_id'];
                    $custom_varient_field_value[$category_custom_field_id] = $this->product_model->get_custom_varient_field_value($last_variant_id, $category_custom_field_id);
                }
            }
        }
        
        $brand = $this->product_model->brandname();
        $categoryname = $this->product_model->categoryname();
        $marketname = $this->product_model->marketname();

        $this->form_validation->set_rules('producttitle', lang('product input name'), 'trim|required');
        $this->form_validation->set_rules('productcategory', lang('product input category'), 'trim|required');
        $this->form_validation->set_rules('productbrand', lang('product input brand'), 'trim|required');

        if ($product_id) 
        {
            $this->form_validation->set_rules('productsku', lang('product input sku'), 'required|trim|callback_check_variant_sku[' . $last_variant_id . ']');
        } 
        else 
        {
            $this->form_validation->set_rules('productsku', lang('product input sku'), 'trim|is_unique[product_varient.sku]');
        }

        if ($this->input->post('product')) 
        {
            foreach ($this->input->post('product', TRUE) as $market_price) 
            {
                if ($market_price['baseprice'] < $market_price['saleprice']) 
                {
                    $this->session->set_flashdata('error', lang('admin product Sale Price Must grater'));
                    redirect_back();
                }
            }
        }

        if ($this->form_validation->run() != false) 
        {
            //product table data
            $formData1 = array();
            $formData1['product_title'] = $this->input->post('producttitle', TRUE);
            $formData1['product_description'] = $this->input->post('productdescription', TRUE);
            $formData1['product_category_id'] = $this->input->post('productcategory', TRUE);
            $formData1['product_brand_id'] = $this->input->post('productbrand', TRUE);
            $formData1['product_meta_keyword'] = $this->input->post('metakeyword', TRUE);
            $formData1['product_meta_description'] = $this->input->post('metadescription', TRUE);
            $product_name_count = $this->product_model->product_name_like_this($product_id, $this->input->post('producttitle', TRUE));
            $count = $product_name_count > 0 ? '-' . $product_name_count : '';
            $formData1['product_slug'] = slugify_string($this->input->post('producttitle', TRUE) . $count);
            //product varient data
            $variantData = array();
            
            if (ucfirst($this->input->post(lang('core button save')))) 
            {
 
                $product_id = $this->product_model->productinsert($formData1);
                $is_first_varient = $this->product_model->is_first_varient($product_id);
                $variantData['is_primary'] = 0;
                
                if (empty($is_first_varient)) 
                {
                    $variantData['is_primary'] = 1;
                }

                $variantData['sku'] = $this->input->post('productsku', TRUE);
                $product_image = $this->input->post('product_image') ? $this->input->post('product_image', TRUE) : array();
                $variantData['product_image'] = json_encode($product_image);
                $variantData['product_id'] = $product_id;
                $product_variant_id = $this->product_model->productvarient($variantData);
                $custom_fields = $this->input->post('custom_field') ? $this->input->post('custom_field', TRUE) : array();
                
                if ($custom_fields) 
                {
                    $save_custom_field = array();
                    
                    foreach ($custom_fields as $custom_field_id => $option_value) 
                    {
                        $option_value = is_array($option_value) ? json_encode($option_value) : $option_value;

                        $save_custom_field[$custom_field_id]['product_variant_id'] = $product_variant_id;
                        $save_custom_field[$custom_field_id]['custom_field_id'] = $custom_field_id;
                        $save_custom_field[$custom_field_id]['value'] = $option_value;
                    }

                    $this->product_model->save_custom_field($save_custom_field);

                }

                $marketData = array();
                $productval = $this->input->post('product') ? $this->input->post('product', TRUE) : array();
                $market = $this->input->post('marketname');
                $baseprice = $this->input->post('baseprice');
                $saleprice = $this->input->post('saleprice');
                $affiliateurl = $this->input->post('affiliate_marketing_url');
                for($i=0; $i < count($market); $i++)
                {
                    $marketData[] = array('product_variant_id'=>$product_variant_id,'market_id'=>$market[$i],'base_price'=>$baseprice[$i],'sale_price'=>$saleprice[$i],'affiliate_marketing_url'=>$affiliateurl[$i]);
                }
                
                $this->product_model->save_market_data($marketData);
                

                //save minimum price 
                $minsaleprice = min($this->input->post('saleprice'));

                //find affiliate url
                $market_url = $this->product_model->get_url_through_minprice($product_variant_id,$minsaleprice);
                $minpricedata['product_variant_id'] = $product_variant_id;
                $minpricedata['min_price'] = $minsaleprice;
                $minpricedata['affiliate_url'] = $market_url->affiliate_marketing_url;
                $minpricedata['day'] = date('Y-m-d'); 

                if($minpricedata)
                {
                    $this->product_model->save_min_price($minpricedata);
                    $this->price_history_detail($product_variant_id);
                }

                // if ($productval) {
                //     foreach ($productval as $product_key => $marketvalue) {
                //         $marketData[$product_key]['product_variant_id'] = $product_variant_id;
                //         $marketData[$product_key]['market_id'] = $product_key;
                //         $marketData[$product_key]['base_price'] = $marketvalue['baseprice'];
                //         $marketData[$product_key]['sale_price'] = $marketvalue['saleprice'];
                //         $marketData[$product_key]['affiliate_marketing_url'] = $marketvalue['affiliate_marketing_url'];
                //     }
                //     if ($marketData) {
                //         $this->product_model->save_market_data($marketData);
                //     }
                // }

                // $additional_market_data = array();
                // $additionalmarket = $this->input->post('additionalmarketname');
                // $additionalbaseprice = $this->input->post('additionalbaseprice');
                // $additionalsaleprice = $this->input->post('additionalsaleprice');
                // $additionalaffiliateurl = $this->input->post('additionalaffiliateurl');
                // for($i=0; $i < count($additionalmarket); $i++)
                // {
                //     $additional_market_data[] = array('product_id'=>$product_id,'product_variant_id'=>$product_variant_id,'market_name'=>$additionalmarket[$i],'base_price'=>$additionalbaseprice[$i],'sale_price'=>$additionalsaleprice[$i],'affiliate_url'=>$additionalaffiliateurl[$i]);
                // }

                // $this->product_model->save_addittional_market_data($additional_market_data);   
                    //print_r($additiona_value);exit;
                 
                /************** Product Details Work *****************/
                $this->update_product_details_data($category_id, $product_variant_id, $product_id);
                /************** End Product Details Work *****************/
                $this->session->set_flashdata('message', lang('admin Product Inserted Successfully'));
                redirect(base_url('admin/product'));
            }

            if (ucfirst($this->input->post(lang('core button update')) && $product_id)) 
            {

                action_not_permitted();
                $this->product_model->productupdate($formData1, $product_id);
                $product_variant_id = $get_product_varient->id;
                $variantData['sku'] = $this->input->post('productsku', TRUE);
                if ($this->input->post('product_image')) {
                    if ($get_product_varient->product_image) {
                        $product_image = json_decode($get_product_varient->product_image);
                        $product_image = json_decode(json_encode($product_image), True);
                        $product_image = array_merge($product_image, $this->input->post('product_image', TRUE));
                        $variantData['product_image'] = json_encode($product_image);
                    } else {
                        $variantData['product_image'] = json_encode($this->input->post('product_image', TRUE));
                    }
                }
                $result = $this->product_model->update_product_variend_data_by_id($product_variant_id, $variantData);
                $custom_fields = $this->input->post('custom_field') ? $this->input->post('custom_field', TRUE) : array();
                if ($custom_fields) {
                    //delete for relational table data
                    $this->product_model->oldcustom_variant_value($product_variant_id);
                    
                    //insert relational table data
                    $save_custom_field = array();
                    foreach ($custom_fields as $custom_field_id => $option_value) 
                    {
                        $option_value = is_array($option_value) ? json_encode($option_value) : $option_value;

                        $save_custom_field[$custom_field_id]['product_variant_id'] = $product_variant_id;
                        $save_custom_field[$custom_field_id]['custom_field_id'] = $custom_field_id;
                        $save_custom_field[$custom_field_id]['value'] = $option_value;
                    }
                    if ($save_custom_field) {
                        $this->product_model->save_custom_field($save_custom_field);
                    }
                }
                //product market field data

                $productval = $this->input->post('product') ? $this->input->post('product', TRUE) : array();
                $this->product_model->oldmarket_price_value($product_variant_id);
                $marketData = array();
                $market = $this->input->post('marketname');
                $baseprice = $this->input->post('baseprice');
                $saleprice = $this->input->post('saleprice');
                $affiliateurl = $this->input->post('affiliate_marketing_url');
                for($i=0; $i < count($market); $i++)
                {
                    $marketData[] = array('product_variant_id'=>$product_variant_id,'market_id'=>$market[$i],'base_price'=>$baseprice[$i],'sale_price'=>$saleprice[$i],'affiliate_marketing_url'=>$affiliateurl[$i]);
                }
                
                $this->product_model->save_market_data($marketData);

                //get min price data and edit min price data
                $get_min_saleprice_data = $this->product_model->get_min_price($product_variant_id);
                //echo '<pre>';print_r($get_min_saleprice_data);exit;
                $previous_date = $get_min_saleprice_data->day;
                $previous_saleprice = $get_min_saleprice_data->min_price;
                $today_date = date('Y-m-d');
                $new_saleprice = min($this->input->post('saleprice'));
                $market_url = $this->product_model->get_url_through_minprice($product_variant_id,$new_saleprice);

                if($previous_saleprice > $new_saleprice && $previous_date == $today_date)
                {
                    
                    $min_saleprice_data['product_variant_id'] = $product_variant_id;
                    $min_saleprice_data['min_price'] = $new_saleprice;
                    $min_saleprice_data['affiliate_url'] = $market_url->affiliate_marketing_url;
                    $min_saleprice_data['day'] = $today_date;
                    $update_min_saleprice_data = $this->product_model->update_min_saleprice($min_saleprice_data,$get_min_saleprice_data->id);
                    $this->user_alarm_status_update($product_variant_id,$get_min_saleprice_data->id);
                    $this->price_history_detail($product_variant_id);
                }
                elseif($previous_saleprice != $new_saleprice && $previous_date != $today_date)
                {
                    
                    $min_saleprice_data['product_variant_id'] = $product_variant_id;
                    $min_saleprice_data['min_price'] = $new_saleprice;
                    $min_saleprice_data['affiliate_url'] = $market_url->affiliate_marketing_url;
                    $min_saleprice_data['day'] = $today_date;
                    $inserted_data = $this->product_model->save_min_price($min_saleprice_data);  
                    $this->user_alarm_status_update($product_variant_id,$inserted_data);
                    $this->price_history_detail($product_variant_id);
                }


                // $marketData = array();
                // if ($productval) {
                //     foreach ($productval as $id => $marketvalue) {
                //         $marketData[$id]['product_variant_id'] = $product_variant_id;
                //         $marketData[$id]['market_id'] = $id;
                //         $marketData[$id]['base_price'] = $marketvalue['baseprice'];
                //         $marketData[$id]['sale_price'] = $marketvalue['saleprice'];
                //         $marketData[$id]['affiliate_marketing_url'] = $marketvalue['affiliate_marketing_url'];
                //     }
                //     $this->product_model->save_market_data($marketData);
                // }

                //update additional market data work
                // $this->product_model->oldadditional_market_price_delete($product_variant_id);
                // $additional_market_data = array();
                // $additionalmarket = $this->input->post('additionalmarketname');
                // $additionalbaseprice = $this->input->post('additionalbaseprice');
                // $additionalsaleprice = $this->input->post('additionalsaleprice');
                // $additionalaffiliateurl = $this->input->post('additionalaffiliateurl');
                // for($i=0; $i < count($additionalmarket); $i++)
                // {
                //     $additional_market_data[] = array('product_id'=>$product_id,'product_variant_id'=>$product_variant_id,'market_name'=>$additionalmarket[$i],'base_price'=>$additionalbaseprice[$i],'sale_price'=>$additionalsaleprice[$i],'affiliate_url'=>$additionalaffiliateurl[$i]);
                // }

                // $this->product_model->save_addittional_market_data($additional_market_data);   
                /************** Product Details Work *****************/
                $this->update_product_details_data($category_id, $product_variant_id, $product_id);
                /************** End Product Details Work *****************/
                $this->session->set_flashdata('message', lang('admin Product Updated Successfully'));
                redirect(base_url('admin/product'));
            }
        } 
        else 
        {
            $fielderror = $this->form_validation->error_array();
        }
        $this->add_css_theme('select2.min.css');
        $this->add_js_theme('product_custom_script.js');
        $this->add_css_theme('summernote.css');
        $this->add_js_theme('plugin/taginput/bootstrap-tagsinput.min.js');
        $this->add_css_theme('plugin/taginput/bootstrap-tagsinput.css');
        $this->add_js_theme('summernote.min.js');
        if ($product_id) {
            $this->set_title(lang('product title product_edit'));
        } else {
            $this->set_title(lang('product title product_add'));
        }
        $data = $this->includes;
        $content_data = array('product_id' => $product_id, 'brand' => $brand, 'categoryname' => $categoryname, 'get_product_varient' => $get_product_varient, 'marketname' => $marketname, 'product_data' => $product_data, 'fetchmarketdata' => $fetchmarketdata, 'category_id' => $category_id, 'product_category_info' => $product_category_info, 'get_custom_field_with_category' => $get_custom_field_with_category, 'custom_field_group_data' => $custom_field_group_data, 'field_groups_of_category' => $field_groups_of_category, 'custom_varient_field_value' => $custom_varient_field_value, 'category_data' => $category_data,'fetch_additional_market_data' => $fetch_additional_market_data, 'additionalmarket_array' => $additionalmarket_array, 'additionalbaseprice_array' => $additionalbaseprice_array, 'additionalsaleprice_array' => $additionalsaleprice_array, 'additionalaffiurl_array' => $additionalaffiurl_array,);
        // load views
        $data['content'] = $this->load->view('admin/product/form', $content_data, TRUE);
        $this->load->view($this->template, $data);
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

    function productuploadfile()  
    {
        // Initialize your S3 connection. 
        // To generate your YOUR_IAM_USER_KEY and YOUR_IAM_USER_SECRET create and Aws IAM user with the S3FullAccess Role 
        // to do so follow : https://docs.aws.amazon.com/IAM/latest/UserGuide/id_users_create.html
        $s3 = new Aws\S3\S3Client([
          'region' => 'ewr1',
          'endpoint' => 'https://ewr1.vultrobjects.com', 
          // 'hostname' => 'vultrobjects.com', 
          'version' => 'latest',
          'credentials' => [
              'key'    => "QRU13IK7Y8GP7ZQS24O8",
              'secret' => "FMbkTvqbUB4xJVM54gmVSYiy4WONwRCMEmdvIFw6",
            ]
          ]);

        $bucketName = 'enes';


        $image = array();
        $file_name = $_FILES['file']['name'];
        $file_path = $_FILES['file']['tmp_name'];

        // $config['upload_path'] = "./assets/images/product_image";
        // $config['allowed_types'] = 'jpg|png|bmp|jpeg';
        // $this->load->library('upload', $config);
        // $status = $this->upload->do_upload('file');
        $result = $s3->putObject([
            'Bucket' => $bucketName,
            'Key'    => 'quickcompare/products/'.$file_name,
            'Body' => fopen($file_path, 'r+')
        ]);

        // Wait for the file to be uploaded and accessible :
        $s3->waitUntil('ObjectExists', array(
          'Bucket' => $bucketName,
          'Key'    => 'quickcompare/products/'.$file_name
        ));


        // $file = $this->upload->data();
        $success = array('status' => true, 'messages' => lang('admin image upload Success'), 'name' => $file_name, 'original_name' => $file_name);
        echo json_encode($success);
        exit;


        $image = array();
        $name = $_FILES['file']['name'];
        $config['upload_path'] = "./assets/images/product_image";
        $config['allowed_types'] = 'jpg|png|bmp|jpeg';
        $this->load->library('upload', $config);
        $status = $this->upload->do_upload('file');

        if ($status) {
            $file = $this->upload->data();
            $success = array('status' => true, 'messages' => lang('admin image upload Success'), 'name' => $file['file_name'], 'original_name' => $name,);
            echo json_encode($success);
        } else {
            $image['msg'] = 'error';
            echo json_encode($image);
        }
    }

    function productdel_file() 
    {
        $filename = $_POST['filename'];
        $path = "./assets/images/product_image/$filename";
        if ($path) {
            unlink($path);
            $status = json_encode($filename);
            echo $status;
            return $status;
        }
        echo false;
        return false;
    }

    function product_list() 
    {
        $data = array();
        $list = $this->product_model->get_product();
        $no = $_POST['start'];
        foreach ($list as $product) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ucfirst($product->product_title);
            $row[] = ucfirst($product->category_title);
            $button = '<a href="' . base_url("admin/product/form/" . $product->productId) . '"  title="'.lang("admin p_t Edit Product").'" class="btn btn-primary btn-action mr-1">
            <i class="fas fa-pencil-alt"></i>
            </a>';
            if ($product->num_of_variant > 1) {
                $button.= '
                    <a title="'.lang("admin p_t Edit Product Varient").'" class="btn btn-success btn-action mr-1 edit_product_varient" data-product_id="' . $product->productId . '" data-product_varient_id="' . $product->p_v_id . '">
                    <i class="fas fa-pencil-alt"></i>
                    </a>';
            } else {
                $button.= '
                        <a title="'.lang("admin p_t No Product Variant").'" class="btn btn-secondary mr-1 no_pointer" data-href="' . base_url("admin/product/variant/" . $product->productId) . '">
                        <i class="fas fa-pencil-alt"></i>
                        </a>';
            }
            $button.= '
                <a href="' . base_url("admin/product/variant_form/" . $product->productId) . '"  title="'.lang("admin p_t Add Product Variant").'" class="btn btn-info mr-1">
               <i class="fa fa-plus-circle" aria-hidden="true"></i>
                </a>';
            $button.= '
                <a href="' . base_url("admin/product/copy_products/" . $product->productId) . '"  title="'.lang("admin p_t Copy Product").'" class="btn btn-warning mr-1">
               <i class="far fa-copy"></i>
                </a>';
            $button.='<a href="'.base_url("admin/product/contact_seller/". $product->productId) . '" title="Contact Seller" class="btn btn-success mr-1"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
            $button.= '
                <a href="' . base_url("admin/product/product_variant_delete/" . $product->productId) . '"  title="'.lang("admin p_t Delete Product").'" class="btn btn-danger btn-action mr-1 common_delete">
                <i class="fas fa-trash"></i>
                </a>';
            $row[] = $button;
            $data[] = $row;
        }
        $output = array("draw" => $_POST['draw'], "recordsTotal" => $this->product_model->count_all(), "recordsFiltered" => $this->product_model->count_filtered(), "data" => $data,);
        //output to json format
        echo json_encode($output);
    }

    function updatedDelete() 
    {
        $fileName = $_POST['filename'];
        $fileid = $_POST['id'];
        $path = "./assets/images/product_image/" . $fileName;
        unlink($path);
        $imgName = $this->product_model->checkimg($fileid);
        if (strpos($imgName['product_image'], $fileName . ',') !== false) {
            $result = str_replace($fileName . ',', "", $imgName['product_image']);
        } elseif (strpos($imgName['product_image'], ',' . $fileName) !== false) {
            $result = str_replace(',' . $fileName, "", $imgName['product_image']);
        } else {
            $result = str_replace($fileName, "", $imgName['product_image']);
        }
        $this->product_model->fileupdate($fileid, $result);
        $success = array('status' => true, 'messages' => lang('image Deleted Success'), 'name' => $fileName,);
        echo json_encode($success);
    }

    function product_variant_delete($id = NULL) {
        action_not_permitted();
        $findImage = $this->product_model->deleteimage($id);
        $path_break = explode(",", $findImage);
        if (!empty($path_break)) {
            foreach ($path_break as $path_key => $path) {
                $unlink_file = "./assets/images/product_image/$path";
                unlink($unlink_file);
            }
        }
        $this->product_model->delete_product_with_variant($id);
        $this->session->set_flashdata('message', lang('admin product Variant Deleted Successfully'));
        redirect(base_url('admin/product'));
    }


    function delete_product_variant($id = NULL) 
    {
        action_not_permitted();

        $this->product_model->delete_product_variant_by_id($id);
        $this->session->set_flashdata('message', lang('admin product Variant Deleted Successfully'));
        redirect(base_url('admin/product'));
    }


    function variant($productId = NULL) 
    {
        $editData = "";
        if ($productId) {
            $editData = $this->product_model->fetchproductdata($productId);
        }
        $this->add_css_theme('sweetalert.css');
        $this->add_js_theme('sweetalert-dev.js');
        $this->add_js_theme('add_variant_custom_script.js');
        $this->set_title(lang('product title variant_list'));
        $data = $this->includes;
        $content_data = array('editData' => $editData,);
        // load views
        $data['content'] = $this->load->view('admin/product/variantList', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

    function variant_form($product_id = NULL) 
    {
        if (empty($product_id)) {
            $this->session->set_flashdata('error', lang('Sorry Invalid Request'));
            return redirect(base_url('/admin/product'));
        }

        $product_info = $this->product_model->get_product_by_id($product_id);
        if (empty($product_info)) {
            $this->session->set_flashdata('error', lang('admin Product No Product Varient Found'));
            $url = base_url('admin/product');
            return redirect($url);
        }

        $field_groups_of_category = array();
        $custom_field_group_data = array();
        $category_data = array();
        $custom_varient_field_value = array();
        $get_custom_field = $this->product_model->get_custom_field_on_add($product_info->product_category_id);
        $marketname = $this->product_model->marketname();
        if ($product_info->product_category_id) 
        {
            $category_id = $product_info->product_category_id;
            $category_custom_field_ids = $this->product_model->category_custom_field_id($category_id);
            $field_groups_of_category = $this->product_model->varient_field_groups_of_category($category_id);
            foreach ($field_groups_of_category as $field_groups_of_category_array) {
                $custom_field_group_id = $field_groups_of_category_array['custom_field_group_id'];
                $custom_field_group_data[$custom_field_group_id] = $this->product_model->custom_field_group_data_of_varient($category_id, $custom_field_group_id);
            }
            //echo '<pre>';print_r($custom_field_group_data);exit;
            foreach ($category_custom_field_ids as $valuees) 
            {
                $iddd = $valuees['custom_field_id'];
                if (isset($_POST['custom_field'][$iddd][0])) {
                    $category_data[$valuees['custom_field_id']] = $_POST['custom_field'][$iddd][0];
                }
            }
        }

        if ($this->input->post(lang('core button save'))) 
        {
            $this->form_validation->set_rules('productsku', lang('product input sku'), 'required|trim|is_unique[product_varient.sku]');

            if ($this->form_validation->run() == false) 
            {
                $fielderror = $this->form_validation->error_array();
            }
            else 
            {
                foreach ($this->input->post('product', TRUE) as $market_price) 
                {
                    if ($market_price['baseprice'] < $market_price['saleprice']) 
                    {
                        $this->session->set_flashdata('error', lang('admin product Sale Price Must grater'));
                        redirect_back();
                    }
                }
                $variantData = array();
                $variantData['product_id'] = $product_id;
                $variantData['sku'] = $this->input->post('productsku', TRUE);
                $variantData['product_image'] = json_encode(array());

                $product_variant_id = $this->product_model->productvarient($variantData);
                $custom_fields = $this->input->post('custom_field') ? $this->input->post('custom_field', TRUE) : array();

                $save_custom_field = array();
                if ($custom_fields) 
                {
                    foreach ($custom_fields as $custom_field_id => $option_value) 
                    {
                        $option_value = is_array($option_value) ? json_encode($option_value) : $option_value;
                        $save_custom_field[$custom_field_id]['product_variant_id'] = $product_variant_id;
                        $save_custom_field[$custom_field_id]['custom_field_id'] = $custom_field_id;
                        $save_custom_field[$custom_field_id]['value'] = $option_value;
                    }
                    $this->product_model->save_custom_field($save_custom_field);
                }

                $productval = $this->input->post('product') ? $this->input->post('product', TRUE) : array();
                $marketData = array();
                $productval = $this->input->post('product') ? $this->input->post('product', TRUE) : array();
                $market = $this->input->post('marketname');
                $baseprice = $this->input->post('baseprice');
                $saleprice = $this->input->post('saleprice');
                $affiliateurl = $this->input->post('affiliate_marketing_url');
                for($i=0; $i < count($market); $i++)
                {
                    $marketData[] = array('product_variant_id'=>$product_variant_id,'market_id'=>$market[$i],'base_price'=>$baseprice[$i],'sale_price'=>$saleprice[$i],'affiliate_marketing_url'=>$affiliateurl[$i]);
                }
                
                $this->product_model->save_market_data($marketData);

                //insert min sale price data
                $minsaleprice = min($this->input->post('saleprice'));
                $market_url = $this->product_model->get_url_through_minprice($product_variant_id,$minsaleprice);
                $minpricedata['product_variant_id'] = $product_variant_id;
                $minpricedata['min_price'] = $minsaleprice;
                $minpricedata['affiliate_url'] = $market_url->affiliate_marketing_url;
                $minpricedata['day'] = date('Y-m-d'); 

                if($minpricedata)
                {
                    $this->product_model->save_min_price($minpricedata);
                    $this->price_history_detail($product_variant_id);
                }

                // $marketData = array();
                // if ($productval) {
                //     foreach ($productval as $id => $marketvalue) {
                //         $marketData[$id]['product_variant_id'] = $product_variant_id;
                //         $marketData[$id]['market_id'] = $id;
                //         $marketData[$id]['base_price'] = $marketvalue['baseprice'];
                //         $marketData[$id]['sale_price'] = $marketvalue['saleprice'];
                //         $marketData[$id]['additional_price'] = $marketvalue['additionalprice'];
                //         $marketData[$id]['affiliate_marketing_url'] = $marketvalue['affiliate_marketing_url'];
                //     }
                //     $this->product_model->save_market_data($marketData);
                // }

                // //additional market price add
                // $additional_market_data = array();
                // $additionalmarket = $this->input->post('additionalmarketname');
                // $additionalbaseprice = $this->input->post('additionalbaseprice');
                // $additionalsaleprice = $this->input->post('additionalsaleprice');
                // $additionalaffiliateurl = $this->input->post('additionalaffiliateurl');
                // for($i=0; $i < count($additionalmarket); $i++)
                // {
                //     $additional_market_data[] = array('product_id'=>$product_id,'product_variant_id'=>$product_variant_id,'market_name'=>$additionalmarket[$i],'base_price'=>$additionalbaseprice[$i],'sale_price'=>$additionalsaleprice[$i],'affiliate_url'=>$additionalaffiliateurl[$i]);
                // }

                // $this->product_model->save_addittional_market_data($additional_market_data);

                $this->session->set_flashdata('message', lang('admin Product Variant Inserted Successfully'));
                redirect(base_url('admin/product/'));
            }
        }

        $this->add_css_theme('select2.min.css');
        $this->add_js_theme('add_variant_custom_script.js');
        $this->set_title(lang('product title variant_add'));
        $data = $this->includes;
        $form_action = base_url('admin/product/variant_form/') . $product_id;
        $form_submit_btn = 'Save';
        $fetch_market_last_data = array();
        $content_data = array('product_info' => $product_info, 'marketname' => $marketname, 'variant_id' => $product_id, 'field_groups_of_category' => $field_groups_of_category, 'custom_field_group_data' => $custom_field_group_data, 'category_data' => $category_data, 'action' => $form_action, 'form_submit_btn' => $form_submit_btn, 'fetch_market_last_data' => $fetch_market_last_data, 'custom_varient_field_value' => $custom_varient_field_value,);
        // load views
        $data['content'] = $this->load->view('admin/product/variantForm', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

    function variant_form_edit($variant_id = NULL) 
    {
        if (empty($variant_id)) {
            $this->session->set_flashdata('error', lang('Sorry Invalid Request'));
            return redirect(base_url('/admin/product'));
        }

        $field_groups_of_category = array();
        $custom_field_group_data = array();
        $category_data = array();
        $fetch_market_last_data = array();
        $fetch_additional_market_data = array();
        $custom_varient_field_value = array();
        $product_variant_data = $this->product_model->get_product_variant_data($variant_id);
        // $fetch_additional_market_data = $this->product_model->fetchadditionalmarket($variant_id);
        if (empty($product_variant_data)) {
            $this->session->set_flashdata('error', lang('admin Product No Product Varient Found'));
            $url = base_url('admin/product');
            return redirect($url);
        }
        $product_id = $product_variant_data->product_id;
        $category_id = $product_variant_data->product_category_id;
        $marketname = $this->product_model->marketname();
        $product_info = $this->product_model->get_product_by_id($product_id);
        $category_custom_field_ids = $this->product_model->category_custom_field_id($category_id);
        $field_groups_of_category = $this->product_model->varient_field_groups_of_category($category_id);
        foreach ($field_groups_of_category as $field_groups_of_category_array) {
            $custom_field_group_id = $field_groups_of_category_array['custom_field_group_id'];
            $custom_field_group_data[$custom_field_group_id] = $this->product_model->custom_field_group_data_of_varient_id($category_id, $custom_field_group_id, $variant_id);
        }
        foreach ($category_custom_field_ids as $valuees) 
        {
            $iddd = $valuees['custom_field_id'];
            if (isset($_POST['custom_field'][$iddd][0])) {
                $category_data[$valuees['custom_field_id']] = $_POST['custom_field'][$iddd][0];
            }
        }
        foreach ($category_custom_field_ids as $custom_field_id_array) {
            $category_custom_field_id = $custom_field_id_array['custom_field_id'];
            $custom_varient_field_value[$category_custom_field_id] = $this->product_model->get_custom_varient_field_value($variant_id, $category_custom_field_id);
        }
        $fetch_market_data = $this->product_model->fetchproductmarket($variant_id);
        // foreach ($fetch_market_data as $market_variant_values) {
        //     $fetch_market_last_data[$market_variant_values['market_id']] = $market_variant_values;
        // }
        if ($this->input->post(lang('core button update'))) {
            action_not_permitted();
            $this->form_validation->set_rules('productsku', lang('product input sku'), 'required|trim|callback_check_variant_sku[' . $variant_id . ']');
            if ($this->form_validation->run() == false) {
                $this->form_validation->error_array();
            } else {
                foreach ($this->input->post('product', TRUE) as $market_price) {
                    if ($market_price['baseprice'] < $market_price['saleprice']) {
                        $this->session->set_flashdata('error', lang('admin product Sale Price Must grater'));
                        redirect_back();
                    }
                }
                $variantData = array();
                $save_custom_field = array();
                $marketData = array();
                $variantData['product_id'] = $product_id;
                $variantData['sku'] = $this->input->post('productsku', TRUE);

                $this->product_model->updatevariant($variantData, $variant_id);
                $custom_fields = $this->input->post('custom_field') ? $this->input->post('custom_field', TRUE) : array();
                if ($custom_fields) {
                    //delete for relational table data
                    $this->product_model->oldcustom_variant_value($variant_id);
                    // $this->product_model->oldmarket_price_value($variant_id);
                    //insert relational table data
                    $save_custom_field = array();
                    foreach ($custom_fields as $custom_field_id => $option_value) 
                    {
                        $option_value = is_array($option_value) ? json_encode($option_value) : $option_value;
                        $save_custom_field[$custom_field_id]['product_variant_id'] = $variant_id;
                        $save_custom_field[$custom_field_id]['custom_field_id'] = $custom_field_id;
                        $save_custom_field[$custom_field_id]['value'] = $option_value;
                    }
                    $this->product_model->save_custom_field($save_custom_field);
                }
                //product market field data
                $productval = $this->input->post('product') ? $this->input->post('product', TRUE) : array();
                $this->product_model->oldmarket_price_value($variant_id);
                $marketData = array();
                $market = $this->input->post('marketname');
                $baseprice = $this->input->post('baseprice');
                $saleprice = $this->input->post('saleprice');
                $affiliateurl = $this->input->post('affiliate_marketing_url');
                for($i=0; $i < count($market); $i++)
                {
                    $marketData[] = array('product_variant_id'=>$variant_id,'market_id'=>$market[$i],'base_price'=>$baseprice[$i],'sale_price'=>$saleprice[$i],'affiliate_marketing_url'=>$affiliateurl[$i]);
                }
                
                $this->product_model->save_market_data($marketData);

                //get min price data and edit min price data
                $get_min_saleprice_data = $this->product_model->get_min_price($variant_id);
                //echo '<pre>';print_r($get_min_saleprice_data);exit;
                $previous_date = $get_min_saleprice_data->day;
                $previous_saleprice = $get_min_saleprice_data->min_price;
                $today_date = date('Y-m-d');
                $new_saleprice = min($this->input->post('saleprice'));
                $market_url = $this->product_model->get_url_through_minprice($variant_id,$new_saleprice);
                if($previous_saleprice > $new_saleprice && $previous_date == $today_date)
                {
                    $min_saleprice_data['product_variant_id'] = $variant_id;
                    $min_saleprice_data['min_price'] = $new_saleprice;
                    $min_saleprice_data['affiliate_url'] = $market_url->affiliate_marketing_url;
                    $min_saleprice_data['day'] = $today_date;
                    $update_min_saleprice_data = $this->product_model->update_min_saleprice($min_saleprice_data,$get_min_saleprice_data->id);
                    $this->user_alarm_status_update($variant_id,$get_min_saleprice_data->id);
                    $this->price_history_detail($variant_id);

                }
                elseif($previous_saleprice != $new_saleprice && $previous_date != $today_date)
                {

                    $min_saleprice_data['product_variant_id'] = $variant_id;
                    $min_saleprice_data['min_price'] = $new_saleprice;
                    $min_saleprice_data['affiliate_url'] = $market_url->affiliate_marketing_url;
                    $min_saleprice_data['day'] = $today_date;
                    $inserted_data = $this->product_model->save_min_price($min_saleprice_data);
                    $this->user_alarm_status_update($variant_id,$inserted_data);
                    $this->price_history_detail($variant_id);  
                }
                
                // $marketData = array();
                // if ($productval) {
                //     foreach ($productval as $id => $marketvalue) {
                //         $marketData[$id]['product_variant_id'] = $variant_id;
                //         $marketData[$id]['market_id'] = $id;
                //         $marketData[$id]['base_price'] = $marketvalue['baseprice'];
                //         $marketData[$id]['sale_price'] = $marketvalue['saleprice'];
                //         $marketData[$id]['affiliate_marketing_url'] = $marketvalue['affiliate_marketing_url'];
                //     }
                //     $this->product_model->save_market_data($marketData);
                // }

                // //update additional market data work
                // $this->product_model->oldadditional_market_price_delete($variant_id);

                // $additional_market_data = array();
                // $additionalmarket = $this->input->post('additionalmarketname');
                // $additionalbaseprice = $this->input->post('additionalbaseprice');
                // $additionalsaleprice = $this->input->post('additionalsaleprice');
                // $additionalaffiliateurl = $this->input->post('additionalaffiliateurl');
                // for($i=0; $i < count($additionalmarket); $i++)
                // {
                //     $additional_market_data[] = array('product_id'=>$product_id,'product_variant_id'=>$variant_id,'market_name'=>$additionalmarket[$i],'base_price'=>$additionalbaseprice[$i],'sale_price'=>$additionalsaleprice[$i],'affiliate_url'=>$additionalaffiliateurl[$i]);
                // }

                // $this->product_model->save_addittional_market_data($additional_market_data);

                $this->session->set_flashdata('message', lang('admin Product Variant Updated Successfully'));
                redirect(base_url('admin/product'));
            }
        }
        $this->add_css_theme('select2.min.css');
        $this->add_js_theme('add_variant_custom_script.js');
        $this->set_title(lang('product title variant_edit'));
        $data = $this->includes;
        $form_action = base_url('admin/product/variant_form_edit/') . $variant_id;
        $form_submit_btn = 'Update';
        $content_data = array('product_variant_data' => $product_variant_data, 'product_info' => $product_info, 'marketname' => $marketname, 'product_id' => $product_id, 'variant_id' => $variant_id, 'field_groups_of_category' => $field_groups_of_category, 'custom_field_group_data' => $custom_field_group_data, 'category_data' => $category_data, 'fetch_market_data' => $fetch_market_data, 'action' => $form_action, 'form_submit_btn' => $form_submit_btn, 'custom_varient_field_value' => $custom_varient_field_value, 'fetch_additional_market_data' => $fetch_additional_market_data);
        // load views
        $data['content'] = $this->load->view('admin/product/variantForm', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }





    function check_variant_sku($check_sku, $variantId = false) {
        if ($this->input->post('productsku')) {
            $check_sku = $this->input->post('productsku', TRUE);
        } else {
            $check_sku = '';
        }
        $sku_result = $this->product_model->check_unique_productvariant_sku($check_sku, $variantId);
        if ($sku_result == 0) {
            $sku_response = true;
        } else {
            $this->form_validation->set_message('check_variant_sku', lang('admin Product Sku must be unique'));
            $sku_response = false;
        }
        return $sku_response;
    }
    
    function addvariantfileupload() {
        $image = array();
        $name = $_FILES['file']['name'];
        $config['upload_path'] = "./assets/images/product_image";
        $config['allowed_types'] = 'jpg|png|bmp|jpeg';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file')) {
            $image['msg'] = 'error';
            echo json_encode($image);
        } else {
            $file = $this->upload->data();
            $success = array('status' => true, 'messages' => lang('admin image upload Success'), 'name' => $file['file_name'], 'original_name' => $name,);
            echo json_encode($success);
        }
    }
    
    function variantdel_file() {
        $fileName = $_POST['filename'];
        $path = "./assets/images/product_image/$fileName";
        unlink($path);
        $success = array('status' => true, 'messages' => lang('image Deleted Success'), 'name' => $fileName,);
        echo json_encode($success);
    }
    function product_variant_list($productId = NULL) {
        $deleteicon = "";
        $productId = $_POST['productid'];
        $list = $this->product_model->get_product_variant($productId);
        $totalVariantrecord = sizeof($list);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $productVariant) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ucfirst($productVariant->sku);
            $option_values = explode("||", $productVariant->options);
            $option_to_assign = '';
            foreach ($option_values as $key => $value) {
                $option_value = explode("::", $value);
                $variantdecode = (isset($option_value[1])) ? json_decode($option_value[1]) : array();
                foreach ($variantdecode as $val_key => $optionValueArray) {
                    $option_to_assign.= '<br /><b>' . $option_value[0] . ':</b> ' . $optionValueArray;
                }
            }
            $row[] = $option_to_assign;
            $row[] = date("Y-M-d", strtotime($productVariant->product_varient_added));

            $button = '<a href="' . base_url("admin/product/variant_form/$productVariant->product_id/" . $productVariant->id) . '" class="btn btn-primary btn-action mr-1"><i class="fas fa-pencil-alt"></i></a> ';
            
            $button .= '<a href="' . base_url("admin/product/variant_delete/$productVariant->product_id/" . $productVariant->id) . '" class="btn btn-primary btn-action mr-1 common_delete"><i class="fas fa-trash"></a>';



            $row[] = $button;
            $data[] = $row;
        }
        $output = array("draw" => $_POST['draw'], "recordsTotal" => $this->product_model->count_all_variant($productId), "recordsFiltered" => $this->product_model->count_filtered_variant($productId), "data" => $data,);
        echo json_encode($output);
    }
    function variant_delete($productId = NULL, $variantId = NULL) {
        action_not_permitted();
        $variant_list_page = $this->uri->segment('4');
        $findImage = $this->product_model->deleteimage($variantId);
        $path_break = explode(",", $findImage);
        if (!empty($path_break)) {
            foreach ($path_break as $path_key => $path) {
                $unlink_file = "./assets/images/product_image/$path";
                unlink($unlink_file);
            }
        }
        $this->product_model->variant_values($variantId, $productId);
        $this->session->set_flashdata('message', lang('admin Variant Deleted Successfully'));
        redirect(base_url('admin/product/variant/' . $variant_list_page));
    }
    public function get_custom_field_by_category($category_id = NULL) {
        if (empty($category_id)) {
            return false;
        }
        $field_groups_of_category = array();
        $custom_field_group_data = array();
        $field_groups_of_category = $this->product_model->field_groups_of_category($category_id);
        foreach ($field_groups_of_category as $field_groups_of_category_array) {
            $custom_field_group_id = $field_groups_of_category_array['custom_field_group_id'];
            $custom_field_group_data[$custom_field_group_id] = $this->product_model->custom_field_group_data($category_id, $custom_field_group_id);
        }
        $content_data = array('custom_field_group_data' => $custom_field_group_data, 'field_groups_of_category' => $field_groups_of_category,);
        if ($custom_field_group_data) {
            // load views
            $custom_html[] = $this->load->view('admin/product/get_custom_field_by_category', $content_data, TRUE);
        } else {
            $custom_html[] = '<div class="col-12 mb-3">
            <div class=" form-control text-danger text-center" > '.lang('No Custom Field Added Yet In This Category').' </div></div>';
        }
        $success = array('customHtml' => $custom_html);
        echo json_encode($success);
    }
    public function product_varient($product_id = NULL, $product_varient_id = NULL) {
        if ($product_id && $product_varient_id && is_numeric($product_id) && is_numeric($product_varient_id)) {
            $product_varient = array();
            $product_varient = $this->product_model->get_product_varient($product_id, $product_varient_id);
            $data['product_varient'] = $product_varient;
            $custom_html['data'] = $this->load->view('admin/product/get_product_varient_model', $data, TRUE);
            echo json_encode($custom_html);
        } else {
            return falseL;
        }
    }

    public function variant_edit($product_varient_id = NULL) {
        if (empty($product_varient_id)) {
            $this->session->set_flashdata('error', lang('Sorry Invalid Request'));
            return redirect(base_url('/admin/product'));
        }
        $product_varient = $this->product_model->get_product_varient_by_id($product_varient_id);
        $markets = $this->product_model->marketname();
        $data['product_varient'] = $product_varient;
        $data['markets'] = $markets;
        if ($product_varient) {
            $this->load->view('admin/product/variant_Form', $data);
        } else {
            $this->session->set_flashdata('error', lang('admin Product No Product Varient Found'));
            $url = base_url('admin/product');
            return redirect($url);
        }
    }

    public function delete_varient_image($variant_id = NULL) {

        $variant_id = $this->input->post('variant_id', TRUE);
        $product_image_name = $this->input->post('product_image_name', TRUE);

        $bucket_name = 'enes';

        $s3 = new Aws\S3\S3Client([
          'region' => 'ewr1',
          'endpoint' => 'https://ewr1.vultrobjects.com', 
          // 'hostname' => 'vultrobjects.com', 
          'version' => 'latest',
          'credentials' => [
              'key'    => "QRU13IK7Y8GP7ZQS24O8",
              'secret' => "FMbkTvqbUB4xJVM54gmVSYiy4WONwRCMEmdvIFw6",
            ]
          ]);

        if ($variant_id && $product_image_name) 
        {
            
            $keyname = $product_image_name;
            $variant_data = $this->product_model->get_product_variant_data($variant_id);
            $product_image_array = json_decode($variant_data->product_image);
            $product_image_array = json_decode(json_encode($product_image_array), True);
            if (($key = array_search($product_image_name, $product_image_array)) !== false) {
                unset($product_image_array[$key]);
            }
            $updated_image_value = json_encode($product_image_array);
            $result = $this->product_model->update_product_images_by_id($variant_id, $updated_image_value);

            $bucket_result = $s3->deleteObject([
                'Bucket' => $bucket_name,
                'Key'    => 'quickcompare/products/'.$product_image_name,
            ]);
            //print_r($bucket_result['DeleteMarker']);exit;
            if ($bucket_result['DeleteMarker'])
            {
                echo $keyname . ' was deleted or does not exist.' . PHP_EOL;
            } 
            else 
            {
                exit('Error: ' . $keyname . ' was not deleted.' . PHP_EOL);
            }
            //$path = "./assets/images/product_image/$product_image_name";
            //unlink($path);
            echo $result;
            return $result;
        } else {
            echo false;
            return false;
        }     
    }

    public function copy_products($product_id) {
        action_not_permitted();
        $selected_product_data = $this->product_model->get_product_by_id($product_id);
        $varient_by_product_id = $this->product_model->get_varient_by_product_id($product_id);
        $selected_varient__id = $varient_by_product_id->id;
        $product_name_count = $this->product_model->product_name_like_this(NULL, $selected_product_data->product_title);
        $count = $product_name_count > 0 ? '-' . $product_name_count : '';
        $copy_product['product_title'] = $selected_product_data->product_title . '-copy' . $count;
        $copy_product['product_slug'] = slugify_string($selected_product_data->product_title . '-copy' . $count);
        $copy_product['product_description'] = $selected_product_data->product_description;
        $copy_product['product_category_id'] = $selected_product_data->product_category_id;
        $copy_product['product_brand_id'] = $selected_product_data->product_brand_id;
        $copy_product['product_meta_keyword'] = $selected_product_data->product_meta_keyword;
        $copy_product['product_meta_description'] = $selected_product_data->product_meta_description;
        $copy_product['product_short_detail'] = $selected_product_data->product_short_detail;
        $copy_product['product_full_detail'] = $selected_product_data->product_full_detail;
        $copy_product['product_lowest_marcket'] = $selected_product_data->product_lowest_marcket;
        $new_product_id = $this->product_model->productinsert($copy_product);
        $product_sku_count = $this->product_model->product_sku_like_this($varient_by_product_id->sku);
        $sku_count = $product_sku_count > 0 ? '-' . $product_sku_count : '';
        $copy_variant['product_id'] = $new_product_id;
        $copy_variant['product_image'] = json_encode(array());
        $copy_variant['is_primary'] = 1;
        $copy_variant['sku'] = slugify_string($varient_by_product_id->sku . '-copy' . $sku_count);
        $new_variant_id = $this->product_model->productvarient($copy_variant);
        $field_val_array = array();
        $val_custom_fields = $this->product_model->get_field_values_by_varient_id($selected_varient__id);
        if ($val_custom_fields) {
            foreach ($val_custom_fields as $field_array) {
                $field_val_array[$field_array->custom_field_id]['product_variant_id'] = $new_variant_id;
                $field_val_array[$field_array->custom_field_id]['custom_field_id'] = $field_array->custom_field_id;
                $field_val_array[$field_array->custom_field_id]['value'] = $field_array->value;
            }
        }
        if ($field_val_array) {
            $this->product_model->save_custom_field($field_val_array);
        }
        $marketData = array();
        $val_markets = $this->product_model->get_markets_values_by_varient_id($selected_varient__id);
        if ($val_markets) {
            foreach ($val_markets as $market_array) {
                $marketData[$market_array->market_id]['product_variant_id'] = $new_variant_id;
                $marketData[$market_array->market_id]['market_id'] = $market_array->market_id;
                $marketData[$market_array->market_id]['base_price'] = $market_array->base_price;
                $marketData[$market_array->market_id]['sale_price'] = $market_array->sale_price;
                $marketData[$market_array->market_id]['affiliate_marketing_url'] = $market_array->affiliate_marketing_url;
            }
        }
        if ($marketData) {
            $this->product_model->save_market_data($marketData);
        }
        $this->session->set_flashdata('message', lang('admin Product Copyed Successfully'));
        redirect(base_url('admin/product'));
    }

    function contact_seller($product_id) {
        $this->set_title('Contact Seller List');
        $data = $this->includes;
        $content_data = array();
        // load views
        $data['content'] = $this->load->view('admin/product/sellerlist', $content_data, TRUE);
        $this->load->view($this->template, $data);  
    }

    function user_alarm_status_update($variant_id = false,$history_id=false)
    {
        
        $user_alert = $this->product_model->update_user_alarm_status($variant_id,$history_id);
        return $user_alert;
    }

    function price_history_detail($variant_id = false)
    {
        $s3 = new Aws\S3\S3Client([
          'region' => 'ewr1',
          'endpoint' => 'https://ewr1.vultrobjects.com', 
          // 'hostname' => 'vultrobjects.com', 
          'version' => 'latest',
          'credentials' => [
              'key'    => "QRU13IK7Y8GP7ZQS24O8",
              'secret' => "FMbkTvqbUB4xJVM54gmVSYiy4WONwRCMEmdvIFw6",
            ]
        ]);

        $price_history_data =  $this->product_model->get_price_history_through_variantid($variant_id);
        $price_json_data = json_encode($price_history_data);
        $dir = ('upload/price_history_files/'.$variant_id.'.json');
        //print_r($dir);exit;
        file_put_contents($dir, $price_json_data);
        //print_r($rrr);exit;
        $bucketName = 'enes';

        $result = $s3->putObject([
            'Bucket' => $bucketName,
            'Key'    => 'quickcompare/price_history_files/'.$variant_id.'.json',
            'Body' => $price_json_data,     // fopen($file_path, 'r+')
        ]);

        // Wait for the file to be uploaded and accessible :
        $s3->waitUntil('ObjectExists', array(
          'Bucket' => $bucketName,
          'Key'    => 'quickcompare/price_history_files/'.$variant_id.'.json'
        ));
    }

}

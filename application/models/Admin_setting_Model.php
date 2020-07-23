<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_setting_Model extends CI_Model 
{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    function get_admin_setting_by_field_name($field_name) {
        return $this->db->where('name', $field_name)->get('settings')->row();
    }
    function get_admin_setting_val_by_field_name($field_name) {
        $result = $this->db->where('name', $field_name)->get('settings')->row();
        if($result)
        {
        	return $result->value;
        }
        else
        {
        	return false;
        }
    }

    function get_product_detail_by_id($detail_product_id)
    {
        $user_id = isset($this->user['id']) ? $this->user['id'] : 0;
        $this->db->select("product.id as product_id, product_title, product_description, product_category_id, product_brand_id, product_meta_keyword, product_meta_description, product_short_detail, product_full_detail, product_lowest_marcket, product_varient.id as product_varient_id,  product_varient.sku as product_sku, product_image, category.category_title,brand.brand_title,(SELECT favourite_products.products_id FROM favourite_products WHERE user_id = " . $user_id . " AND favourite_products.products_id = product.id ) as is_fav");
        $this->db->join('product_varient', 'product_varient.product_id = product.id', 'left');
        $this->db->join('category', 'category.id = product.product_category_id', 'left');
        $this->db->join('brand', 'brand.id = product.product_brand_id', 'left');
        $this->db->join('product_variant_custom_field_values', 'product_variant_custom_field_values.product_variant_id = product_varient.id', 'left');
        $this->db->where('product.id', $detail_product_id);
        $this->db->where('product_varient.is_primary', 1);
        return $this->db->get('product')->row();
    }
}
<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Compare_Model extends CI_Model {
    function product_data($product_slug) {
        $this->db->select('product.id as product_id, product_title, product_description, product_category_id, product_brand_id, product_meta_keyword, product_meta_description, product_short_detail, product_full_detail, product_lowest_marcket, product_slug, product_varient.id as product_varient_id,  product_varient.sku as product_sku, product_image, category.category_title,brand.brand_title,category_title,category_slug ');
        $this->db->join('product_varient', 'product_varient.product_id = product.id', 'left');
        $this->db->join('category', 'category.id = product.product_category_id', 'left');
        $this->db->join('brand', 'brand.id = product.product_brand_id', 'left');
        $this->db->where('product.product_slug', $product_slug);
        $this->db->where('is_primary', 1);
        $this->db->group_by('product_varient.product_id');
        return $this->db->get('product')->row();
    }
    function product_all_varients($product_id) {
        $this->db->select('product_varient.id as product_varient_id,  product_varient.sku as product_sku');
        $this->db->where('product_varient.product_id', $product_id);
        return $this->db->get('product_varient')->result();
    }
    function products_fields_values($product_varient_id) {
        $this->db->select('custom_field.id as custom_field_id,  custom_field.display_name as custom_field_name,custom_field_category.title as field_group_name,product_variant_custom_field_values.value as field_value');
        $this->db->join('custom_field_category', 'custom_field_category.id = custom_field.custom_field_category_id', 'left');
        $this->db->join('product_variant_custom_field_values', 'product_variant_custom_field_values.custom_field_id = custom_field.id', 'left');
        $this->db->where('product_variant_custom_field_values.product_variant_id', $product_varient_id);
        $this->db->where('custom_field.isforfront', 1);
        return $this->db->get('custom_field')->result();
    }
    function get_varient_values($product_varient_id) {
        $this->db->select('custom_field.id as custom_field_id,  custom_field.display_name as custom_field_name,custom_field_category.title as field_group_name,product_variant_custom_field_values.value as field_value');
        $this->db->join('custom_field_category', 'custom_field_category.id = custom_field.custom_field_category_id', 'left');
        $this->db->join('product_variant_custom_field_values', 'product_variant_custom_field_values.custom_field_id = custom_field.id', 'left');
        $this->db->where('product_variant_custom_field_values.product_variant_id', $product_varient_id);
        $this->db->where('custom_field.in_variant', 1);
        $this->db->where('product_variant_custom_field_values.value !=', '');
        return $this->db->get('custom_field')->result();
    }
    function get_product_markets($product_varient_id) {
        $this->db->select('sale_price, base_price, affiliate_marketing_url, market_title, market_slug, market_logo');
        $this->db->join('market', 'market.id = product_variant_market.market_id', 'left');
        $this->db->where('product_variant_market.product_variant_id', $product_varient_id);
        return $this->db->get('product_variant_market')->result();
    }
    function get_custom_field_by_category($category_id) {
        $this->db->select('category_custom_field.custom_field_id as custom_field_id,  custom_field.display_name as custom_field_name,custom_field_category.title as field_group_name,field_slug');
        $this->db->join('custom_field', 'custom_field.id = category_custom_field.custom_field_id', 'left');
        $this->db->join('custom_field_category', 'custom_field_category.id = custom_field.custom_field_category_id', 'left');
        $this->db->where('category_custom_field.category_id', $category_id);
        $this->db->where('custom_field.isforfront', 1);
        return $this->db->get('category_custom_field')->result();
    }

}

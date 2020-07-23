<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Import_Model extends CI_Model 
{
    function saverecords($fname,$lname)
    {
        $query="insert into user values('$fname','$lname')";
        $this->db->query($query);
    }

    function check_category($category_name)
    {
        $this->db->like('category_title', $category_name);
        return $this->db->get('category')->row();
    } 

    function product_is_exist($title) {
        $this->db->where('product_title', $title);
        return $this->db->get('product')->row();
    }

    function product_insert($prodata) {
        $this->db->insert('product', $prodata);
        $proinsert_id = $this->db->insert_id();
        return $proinsert_id;
    }

    function update_product_data($data, $product_id) 
    {
        $this->db->set($data)->where('id', $product_id)->update('product');
        return $this->db->affected_rows();
    }

    function product_varient_by_pro_id($product_id) 
    {
        return $this->db->where('is_primary', 1)->where('product_id', $product_id)->get('product_varient')->row();
    }

    function product_sku_is_exist($sku) 
    {
        $this->db->like('sku', $sku);

        $count = $this->db->count_all_results('product_varient');

        return $count > 0 ? "-$count" : '';
    }

    function product_varient_insert($prodata) {
        $this->db->insert('product_varient', $prodata);
        $proinsert_id = $this->db->insert_id();
        return $proinsert_id;
    }

    function update_product_varient_data($data, $varient_id) 
    {
        $this->db->set($data)->where('id', $varient_id)->update('product_varient');
        return $this->db->affected_rows();
    }


    function insert_category($data) 
    {
        $this->db->insert('category', $data);
        return $this->db->insert_id();
    }   


    function check_brand($brand_name)
    {
        $this->db->like('brand_title', $brand_name);
        return $this->db->get('brand')->row();
    } 

    function insert_brand($data) 
    {
        $this->db->insert('brand', $data);
        return $this->db->insert_id();
    }   

    function insert_market_data($data) 
    {
        $this->db->insert('market', $data);
        return $this->db->insert_id();
    }   

    function get_all_brands_from_db() 
    {
        return $this->db->get('brand')->result();
    }   

    function get_all_markets_from_db() 
    {
        return $this->db->get('market')->result();
    }

    function varient_market_delete($variant_id, $market_id_array)
    {
        $this->db->where('product_variant_id', $variant_id);
        
        $this->db->where_in('market_id', $market_id_array);

        $this->db->delete('product_variant_market');
        return $this->db->affected_rows();
    }

    function insert_market_varient_data($market_Data)
    {
        return $this->db->insert_batch('product_variant_market', $market_Data);
    } 

    function is_group_exist($group_name)
    {
        $this->db->where('title', $group_name);
        return $this->db->get('custom_field_category')->row();
    }  


    function insert_group_data($group_content)
    {
        $this->db->insert('custom_field_category', $group_content);
        return $this->db->insert_id();
    }
 
    function is_custom_field_exist($group_id, $custom_field)
    {
        $this->db->where('display_name', $custom_field);
        $this->db->where('custom_field_category_id', $group_id);
        return $this->db->get('custom_field')->row();
    } 
 
    function custom_field_like($custom_field)
    {
        $this->db->like('display_name',$custom_field);

        $count = $this->db->count_all_results('custom_field');

        return $count > 0 ? "-$count" : '';
    } 

    function insert_custom_field_data($custom_field_content)
    {
        $this->db->insert('custom_field', $custom_field_content);
        return $this->db->insert_id();
    } 
    function insert_category_custom_field_data($category_custom_field_data)
    {
        $this->db->insert('category_custom_field', $category_custom_field_data);
        return $this->db->insert_id();
    } 



    function varient_c_field_delete($variant_id, $custom_field_id_array)
    {
        $this->db->where('product_variant_id', $variant_id);
                  
        $this->db->where_in('custom_field_id', $custom_field_id_array);

        $this->db->delete('product_variant_custom_field_values');
        return $this->db->affected_rows();
    }

    function insert_c_field_varient_data($custom_field_content)
    {
        return $this->db->insert_batch('product_variant_custom_field_values', $custom_field_content);
    } 

    function all_category_name() 
    {
        $category = $this->db->select('id,category_title')->where('parent_category=', 0)->get('category')->result_array();
        return $category;
    }


}

<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Menu_item_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    function get_category_menu_item() {
        $this->db->where('display_on_home', 1);
        $this->db->where('category_status', 1);
        $this->db->where('category_is_delete', 0);
        return $this->db->get('category')->result();
    }
    function get_other_menu_item() {
        $this->db->where('display_on_home', 0);
        $this->db->where('category_status', 1);
        $this->db->where('category_is_delete', 0);
        // added sort by category name
        $this->db->order_by('category_title');

        return $this->db->get('category')->result();
    }
    function get_all_category_helper() {
        $this->db->where('category_status', 1);
        $this->db->where('category_is_delete', 0);
        return $this->db->get('category')->result();
    }
    function get_footer_markets($is_footer=false) {
        $data = $this->db;
        
        // if($limit) {
        //     $data->limit($limit);
        // }
        if($is_footer) {
            $data = $data->where('display_on_footer', 1);
        }
        return $data->get('market')->result();
    }
    function get_parent_categories() {
        $this->db->where('parent_category', 0);
        $this->db->where('display_on_home', 1);

        $this->db->where('category_status', 1);
        $this->db->where('category_is_delete', 0);
        // added sort by category name
        $this->db->order_by('category_title');
        
        return $this->db->get('category')->result();
    }
    function get_child_categories($category_id) {

        $this->db->where('parent_category', $category_id);
        $this->db->where('display_on_home', 1);

        $this->db->where('category_status', 1);
        $this->db->where('category_is_delete', 0);
        // added sort by category name
        $this->db->order_by('category_title');

        return $this->db->get('category')->result();
    }
}

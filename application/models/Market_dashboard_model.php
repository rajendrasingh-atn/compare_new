<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Market_dashboard_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    function products_count() {
        return $this->db->select('count(*) as count')->where('user_id',$this->user['id'])->get('product')->row();
    }
    function markets_count() {
        return $this->db->select('count(*) as count')->where('user_id',$this->user['id'])->get('market')->row();
    }
    
    function coupons_count() 
    {
        return $this->db->select('count(*) as count')->where('user_id',$this->user['id'])->get('coupons')->row();
    }

    function brands_count() {
        return $this->db->select('count(*) as count')->get('brand')->row();
    }
    function categories_count() {
        return $this->db->select('count(*) as count')->get('category')->row();
    }
    function user_count() {
        return $this->db->select('count(*) as count')->get('users')->row();
    }

    function get_products_view($current_month)
    {
        $this->db->limit(31);
        $this->db->where('YEAR(last_visited)', date('Y',strtotime($current_month)));
        $this->db->where('MONTH(last_visited)', date('m',strtotime($current_month)));
        return $this->db->get('product_views')->result();   
         // P($this->db->last_query());
    }


    function get_top_products($month)
    {
        return $this->db->query('SELECT product_id, COUNT(total_visits) unique_visits, SUM(total_visits) total_visits 
        FROM product_views WHERE last_visited LIKE "'.date('Y-m-',strtotime($month)).'%" 
        GROUP BY product_id ORDER BY unique_visits DESC limit 4')->result();
         // P($this->db->last_query());
    }

    

    function get_products_year_month()
    {
        return $this->db->query('SELECT * FROM product_views GROUP BY YEAR(`last_visited`), MONTH(`last_visited`)')->result();
    }

    function get_highest_click($current_month)
    {   $total_visits = 10;
        $current_year = date('Y',strtotime($current_month));
        $current_monthh = date('m',strtotime($current_month));
        
        $row = $this->db->query('SELECT MAX(total_visits) AS `total_visits` FROM `product_views` WHERE YEAR(last_visited) = "$current_year" AND MONTH(last_visited) = "$current_monthh"')->row();
                       
        if ($row) 
        {
            $total_visits = $row->total_visits + 10; 
        }
        return $total_visits;
    }

    function get_product_with_id($id)
    {
        $this->db->select('product_title,product_slug,product_category_id');
        $this->db->where('id', $id);
        $this->db->order_by('id', 'ASC');
        return $this->db->get('product')->row_array();
    }
}
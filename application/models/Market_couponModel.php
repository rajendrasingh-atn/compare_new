<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Market_couponModel extends CI_Model 
{
    

    var $table = 'coupons';
    var $column_order = array(null, 'title', 'promo_link','coupon_code','valid_till', NULL );
    var $column_search = array('title', 'promo_link','coupon_code','valid_till');
    var $order = array('id' => 'asc');

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query() 
    {
        $this->db->from($this->table);
        $this->db->where('user_id',$this->user['id']);
        $i = 0;
        foreach ($this->column_search as $item) {
            // if datatable send POST for search
            if ($_POST['search']['value']) {
                // first loop
                if ($i === 0) {
                    // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                // last loop
                if (count($this->column_search) - 1 == $i) {
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
        // here order processing
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order) ]);
        }
    }

    function count_filtered() 
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() 
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function insert_coupon($data) 
    {
        $this->db->insert('coupons', $data);
        return $this->db->insert_id();
    }

    function coupon_name_like_this($title) 
    {
        $this->db->like('title', $title);
        return $this->db->count_all_results('coupons');
    }

    function coupon_slug_like_this($slug,$id) 
    {
        $this->db->like('slug', $slug);
        if($id)
        {
            $this->db->where('id !=', $id);
        }
        $count = $this->db->count_all_results('coupons');
        return $count > 0 ? "-$count" : '';
    }
    
    function get_coupons() 
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != - 1) 
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->select('coupons.*')
        ->get();
        return $query->result();
    }

    function get_coupon_by_id($language_id)
    {
        return $this->db->where('id',$language_id)->where('user_id',$this->user['id'])->get('coupons')->row();
    }

    function update_coupon($language_id, $data) 
    {
        $this->db->set($data)->where('id', $language_id)->where('user_id',$this->user['id'])->update('coupons');
        return $this->db->affected_rows();
    }

    function delete_coupon($language_id) 
    {
        $this->db->where('id', $language_id)->where('user_id',$this->user['id'])->delete('coupons');
        return $this->db->affected_rows();
    }


}

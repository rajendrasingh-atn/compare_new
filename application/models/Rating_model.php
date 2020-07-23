<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Rating_model extends CI_Model {
	var $table = 'product_reviews';
    // set column field database for datatable orderable 
    var $column_order = array('users.username', 'review_content', 'rating', 'product_reviews.status', null);
    // set column field database for datatable searchable
    var $column_search = array('users.username','review_content', 'rating', 'product_reviews.status');
    // default order
    var $order = array('product_reviews.id' => 'asc');
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    private function _get_datatables_query() {
        $this->db->from('product_reviews');
        $this->db->select('users.username,product_reviews.review_content,product_reviews.rating,product_reviews.id,product_reviews.status');
        $this->db->join('users','users.id = product_reviews.user_id','left');
        $this->db->where('product_reviews.status',0);
        $i = 0;
        // loop column
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
    function get_rating() {
        $this->_get_datatables_query();
        if ($_POST['length'] != - 1) $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all() {
        $this->db->from($this->table);
        $this->db->where('product_reviews.status',0);
        return $this->db->count_all_results();
    }
    function update_status($id,$status)
    {
    	$this->db->set('status', $status)->where('id', $id)->update('product_reviews');
    }
    
    private function approve_get_datatables_query() {
        $this->db->from('product_reviews');
        $this->db->select('users.username,product_reviews.review_content,product_reviews.rating,product_reviews.id,product_reviews.status');
        $this->db->join('users','users.id = product_reviews.user_id','left');
        $this->db->where('product_reviews.status',1);
        $i = 0;
        // loop column
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
    function get_approve_rating() {
        $this->approve_get_datatables_query();
        if ($_POST['length'] != - 1) $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function approve_count_all() {
        $this->approve_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function approve_count_filtered() {
        $this->db->from($this->table);
        $this->db->where('product_reviews.status',1);
        return $this->db->count_all_results();
    }
}
<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Market_model extends CI_Model {
    var $table = 'market';
    // set column field database for datatable orderable
    var $column_order = array(null, 'market_title', null, null);
    // set column field database for datatable searchable
    var $column_search = array('market_title');
    // default order
    var $order = array('id' => 'asc');
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    private function _get_datatables_query() {
        $this->db->from($this->table);
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
    function get_market() {
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
        return $this->db->count_all_results();
    }
    function insert($insert) {
        return $this->db->insert('market', $insert);
    }
    function getmarketfetch($id) {
        $editretult = $this->db->where('id', $id)->get('market')->row_array();
        return $editretult;
    }
    function fetcheditimg($id) {
        $editimage = $this->db->where('id', $id)->get('market')->row('market_logo');
        return $editimage;
    }
    function update($updatedata, $id) {
        $this->db->where('id', $id)->update('market', $updatedata);
    }
    function deleteimage($id) {
        $delimage = $this->db->where('id', $id)->get('market')->row('market_logo');
        return $delimage;
    }
    function delete($id) {
        $this->db->where('id', $id)->delete('market');
    }
    function market_name_like_this($market_id, $title) {
        $this->db->like('market_title', $title);
        if ($market_id) {
            $this->db->where('id !=', $market_id);
            $this->db->where('id <', $market_id);
        }
        return $this->db->count_all_results('market');
    }

    function update_market_user($user_id, $user_data)
    {
        return $this->db->where('id', $user_id)->update('users', $user_data);
    }
    function insert_new_market_user($user_data)
    {
        $this->db->insert('users', $user_data);
        return $this->db->insert_id();
    }

    function get_market_user($market_user_id)
    {
        $this->db->where('id', $market_user_id);
        return $this->db->get('users')->row_array();
    }
}

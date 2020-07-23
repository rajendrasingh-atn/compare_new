<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Brand_model extends CI_Model {
    var $table = 'brand';
    // set column field database for datatable orderable
    var $column_order = array(null, 'brand_title', null, null);
    // set column field database for datatable searchable
    var $column_search = array('brand_title');
    // default order
    var $order = array('id' => 'asc');
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    function insert($insertbrand) {
        $this->db->insert('brand', $insertbrand);
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
                if (count($this->column_search) - 1 == $i)
                // close bracket
                $this->db->group_end();
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
    function get_brand() {
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
    function getbrandfetch($id) {
        $editresult = $this->db->where('id', $id)->get('brand')->row_array();
        return $editresult;
    }
    function fetcheditimg($id) {
        $image = $this->db->where('id', $id)->get('brand')->row('brand_image');
        return $image;
    }
    function update($updatedata, $id) {
        $this->db->where('id', $id)->update('brand', $updatedata);
    }
    function deleteimage($id) {
        $del_image = $this->db->where('id', $id)->get('brand')->row('brand_image');
        return $del_image;
    }
    function delete($id) {
        $this->db->where('id', $id)->delete('brand');
    }
    function brand_name_like_this($brand_id, $title) {
        $this->db->like('brand_title', $title);
        if ($brand_id) {
            $this->db->where('id !=', $brand_id);
            $this->db->where('id <', $brand_id);
        }
        return $this->db->count_all_results('brand');
    }
}

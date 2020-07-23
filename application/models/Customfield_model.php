<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Customfield_model extends CI_Model {
    var $table = 'custom_field';
    // set column field database for datatable orderable
    var $column_order = array(null, 'custom_field_category.title', 'display_name', 'custom_input_type', null);
    // set column field database for datatable searchable
    var $column_search = array('custom_field_category.title', 'display_name', 'custom_input_type');
    // default order
    var $order = array('custom_field.id' => 'asc');
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    function customcategory_name() {
        $customcat_name = $this->db->select('id,title')->get('custom_field_category')->result_array();
        return $customcat_name;
    }
    function insert($data) {
        $this->db->insert('custom_field', $data);
    }
    private function _get_datatables_query() {
        $this->db->select('custom_field.id, custom_field.display_name, custom_input_type, custom_field_category.title');
        $this->db->from($this->table);
        $this->db->join('custom_field_category', 'custom_field_category.id = custom_field.custom_field_category_id');
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
    function get_customfield() {
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
    function getfetch($id) {
        return $this->db->where('id', $id)->get('custom_field')->row_array();
    }
    function update($id, $data) {
        $this->db->where('id', $id)->update('custom_field', $data);
    }
    function delete($id) {
        $this->db->where('id', $id)->delete('custom_field');
    }
    function custominsert($formdata) {
        $this->db->insert('custom_field_category', $formdata);
    }
    var $customcategorytable = 'custom_field_category';
    // set column field database for datatable orderable
    var $customcatcolumn_order = array(null, 'title', null, 'added');
    // set column field database for datatable searchable
    var $customcatcolumn_search = array('title');
    // default order
    var $customcatorder = array('id' => 'asc');
    private function _get_custom_datatables_query() {
        $this->db->from($this->customcategorytable);
        $i = 0;
        // loop column
        foreach ($this->customcatcolumn_search as $item) {
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
                if (count($this->customcatcolumn_search) - 1 == $i) {
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
        // here order processing
        if (isset($_POST['order'])) {
            $this->db->order_by($this->customcatcolumn_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->customcatorder)) {
            $customcatorder = $this->customcatorder;
            $this->db->order_by(key($customcatorder), $customcatorder[key($customcatorder) ]);
        }
    }
    function get_customcategory() {
        $this->_get_custom_datatables_query();
        if ($_POST['length'] != - 1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function customcat_count_filtered() {
        $this->_get_custom_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function customcat_count_all() {
        $this->db->from($this->customcategorytable);
        return $this->db->count_all_results();
    }
    function customcategoryedit($id) {
        return $this->db->where('id', $id)->get('custom_field_category')->row_array();
    }
    function get_fields() {
        return $this->db->get('custom_field')->result();
    }
    function customupdate($c_data, $id) {
        $this->db->where('id', $id)->update('custom_field_category', $c_data);
    }
    function custom_delete($id) {
        $this->db->where('id', $id)->delete('custom_field_category');
    }
    function field_name_like_this($custom_field_id, $title) {
        $this->db->like('display_name', $title);
        if ($custom_field_id) {
            $this->db->where('id !=', $custom_field_id);
            // $this->db->where('id <', $custom_field_id);
        }
        return $this->db->count_all_results('custom_field');
    }
}

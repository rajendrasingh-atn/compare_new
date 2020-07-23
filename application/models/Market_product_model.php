<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Market_product_model extends CI_Model {
    function brandname() {
        $brand = $this->db->select('id,brand_title')->get('brand')->result_array();
        return $brand;
    }
    function inputname() {
        $inputname = $this->db->select('id,display_name,custom_input_type,custom_hint,options')->get('custom_field')->result_array();
        return $inputname;
    }
    function categoryname() {
        $category = $this->db->select('id,category_title')->where('category_is_delete', 0)->get('category')->result_array();
        return $category;
    }
    function marketname() {
        $market = $this->db->select('id, market_title, market_url, market_logo')
                        ->where('market_user_id',$this->user['id'])
                        ->get('market')
                        ->result_array();
        return $market;
    }
    function customfieldlabel($c_id) {
        $customlabel_id = $this->db->select('category_id,custom_field_id')->where('category_id', $c_id)->get('category_custom_field')->result_array();
        return $customlabel_id;
    }
    function inputField($customfield_id_array) {
        return $this->db->select('id,custom_label,custom_input_type,options')->where_in('id', $customfield_id_array)->order_by("id", "asc")->get('custom_field')->result_array();
    }
    function sku_old() {
        return $this->db->select('sku')->get('product_varient')->result_array();
    }
    function check_unique_productvariant_sku($sku, $id) {
        return $this->db->where('sku', $sku)->where('id !=', $id)->get('product_varient')->num_rows();
    }
    function productinsert($prodata) {
        $this->db->insert('product', $prodata);
        $proinsert_id = $this->db->insert_id();
        return $proinsert_id;
    }
    function productvarient($provarient) {
        $this->db->insert('product_varient', $provarient);
        $provarient_id = $this->db->insert_id();
        return $provarient_id;
    }
    function save_custom_field($custom_fielddata) {
        $this->db->insert_batch('product_variant_custom_field_values', $custom_fielddata);
    }
    function save_market_data($market_Data) {
        $this->db->insert_batch('product_variant_market', $market_Data);
    }
    var $table = 'product';
    // set column field database for datatable orderable
    var $column_order = array(null, 'product_title', 'product_category_id', 'sku', null);
    // set column field database for datatable searchable
    var $column_search = array('product_title', 'product_category_id');
    // default order
    var $order = array('product.id' => 'asc');
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    private function _get_datatables_query() {
        $this->db->from($this->table);
        $this->db->Where('user_id',$this->user['id']);
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
    function get_product() {
        $this->_get_datatables_query();
        if ($_POST['length'] != - 1) $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->select('(SELECT MIN(id) FROM product_varient WHERE product_id = product.id) p_v_id, (SELECT sku FROM product_varient WHERE product_id = product.id ORDER BY id LIMIT 1 ) sku, category.category_title, product.product_title, product.product_added, product.id productId, (SELECT COUNT(id) FROM product_varient WHERE product_id = product.id) num_of_variant')
            // ->Where('user_id',$this->user['id'])
            ->join('category', 'product.product_category_id=category.id', 'inner')->order_by('product.product_added', 'desc')->get();
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
    function fetchproductdata($fetch_editid) {
        $edit_fetchdata = $this->db->select('product.id,product_title,product_description,product_category_id,product_brand_id,product_meta_keyword,product_meta_description,product_varient.sku')->join('product_varient', 'product_varient.product_id = product.id')
        ->where('product.id', $fetch_editid)
        ->where('product.user_id', $this->user['id'])
        ->get('product')
        ->row_array();
        return $edit_fetchdata;
    }
    function get_custom_field_width_category_id($category_id) {
        return $this->db->select('category_custom_field.custom_field_id,custom_field_category_id as custom_field_group_id, custom_field_category.title as custom_field_group_name,custom_label,custom_input_type,options,value')->join('custom_field', 'category_custom_field.custom_field_id = custom_field.id')->join('custom_field_category', 'custom_field_category.id = custom_field.custom_field_category_id')->join('product_variant_custom_field_values', 'product_variant_custom_field_values.custom_field_id = category_custom_field.custom_field_id', 'left')->where('category_id', $category_id)->get('category_custom_field')->result_array();
    }
    function custom_field_group_data($category_id, $custom_field_group_id) {
        return $this->db->select('custom_field.id as custom_field_id, custom_field_category_id as custom_field_group_id, custom_field.custom_label, custom_field.custom_hint, custom_field.is_numeric, custom_field.is_required, custom_field.is_date, custom_field.min_value, custom_field.max_value, custom_field.custom_input_type, custom_field.options')->from('custom_field')->join('category_custom_field', 'category_custom_field.custom_field_id = custom_field.id', 'left')->where('category_custom_field.category_id', $category_id)->where('custom_field.custom_field_category_id', $custom_field_group_id)->get()->result_array();
    }
    function custom_field_group_data_of_varient($category_id, $custom_field_group_id) {
        return $this->db->select('custom_field.id as custom_field_id, custom_field_category_id as custom_field_group_id, custom_field.custom_label, custom_field.custom_hint, custom_field.is_numeric, custom_field.is_required, custom_field.is_date, custom_field.min_value, custom_field.max_value, custom_field.custom_input_type, custom_field.options')->from('custom_field')->join('category_custom_field', 'category_custom_field.custom_field_id = custom_field.id')->where('category_custom_field.category_id', $category_id)->where('custom_field.in_variant', 1)->where('custom_field.custom_field_category_id', $custom_field_group_id)->get()->result_array();
    }
    function custom_field_group_data_of_varient_id($category_id, $custom_field_group_id, $variant_id) {
        return $this->db->select('custom_field.id as custom_field_id, custom_field_category_id as custom_field_group_id, custom_field.custom_label, custom_field.custom_hint, custom_field.is_numeric, custom_field.is_required, custom_field.is_date, custom_field.min_value, custom_field.max_value, custom_field.custom_input_type, custom_field.options')->from('custom_field')->join('category_custom_field', 'category_custom_field.custom_field_id = custom_field.id')->join('product_variant_custom_field_values', 'product_variant_custom_field_values.custom_field_id = custom_field.id')->where('category_custom_field.category_id', $category_id)->where('custom_field.in_variant', 1)->group_by('product_variant_custom_field_values.custom_field_id')->where('custom_field.custom_field_category_id', $custom_field_group_id)->get()->result_array();
    }
    function field_groups_of_category($category_id) {
        return $this->db->select('custom_field_category_id as custom_field_group_id, custom_field_category.title as custom_field_group_name')->join('custom_field', 'custom_field.id = category_custom_field.custom_field_id')->join('custom_field_category', 'custom_field_category.id = custom_field.custom_field_category_id')->where('category_custom_field.category_id', $category_id)->group_by('custom_field_group_id')->get('category_custom_field')->result_array();
    }
    function fetchproductmarket($product_variant_id) {
        $edit_market = $this->db->where('product_variant_id', $product_variant_id)->get('product_variant_market')->result_array();
        return $edit_market;
    }
    function checkimg($id) {
        return $this->db->select('product_image')->where('id', $id)->get('product_varient')->row_array();
    }
    function fileupdate($id, $imgfield) {
        $this->db->set('product_image', $imgfield)->where('id', $id)->update('product_varient');
    }
    function productupdate($update_product_data, $product_id) {
        $this->db->where('id', $product_id)->update('product', $update_product_data);
    }
    function updatevariant($update_variant, $id) {
        $this->db->where('id', $id)->update('product_varient', $update_variant);
    }
    function oldcustom_variant_value($id) {
        $this->db->where_in('product_variant_id', $id)->delete('product_variant_custom_field_values');
    }
    function oldmarket_price_value($id) {
        $this->db->where_in('product_variant_id', $id)->delete('product_variant_market');
    }
    function deleteimage($id) {
        return $this->db->where('id', $id)->get('product_varient')->row('product_image');
    }
    function delete_product_with_variant($product_id) 
    {
        $products = $this->db->where('id', $product_id)->where('user_id',$this->user['id'])->get('product')->row();
        if($products)
        {
             // delete custom field values from product_variant_custom_field_values table
            $this->db->query('DELETE FROM product_variant_custom_field_values WHERE product_variant_id IN (SELECT id FROM product_varient WHERE product_id = ' . $product_id . ')');
            // delete market price values from product_variant_market table
            $this->db->query('DELETE FROM  product_variant_market WHERE product_variant_id IN (SELECT id FROM product_varient WHERE product_id = ' . $product_id . ')');
            // delete variants from product_variant table
            $this->db->where_in('product_id', $product_id)->delete('product_varient');
            // delete product from product table
            $this->db->where('id', $product_id)->delete('product');
            return true;
        }
        return false;

    }

    function delete_product_variant_by_id($id)
    {

        $products = $this->db->join('product', 'product.id = product_varient.product_id')
                            ->where('product_varient.id', $id)
                            ->where('user_id',$this->user['id'])
                            ->get('product_varient')->row();

            if($products)
            {
                $this->db->where('id', $id)->delete('product_varient');
                $this->db->where('product_variant_id', $id)->delete('product_variant_market');
                $this->db->where('product_variant_id', $id)->delete('product_variant_custom_field_values');
                return true; 
            }
            return false;
    }

    function delete_market_price_value($product_id) {
        // will add function body
        
    }
    function delete_product_variant_Delete($id) {
        $this->db->where('id', $id)->delete('product_varient');
    }
    function delete_product($id) {
        $this->db->where('id =', $id)->delete('product');
    }
    function get_product_variant_data($variant_id) {
        return $this->db->select('product.id as product_id, product_title, product_description, product_meta_keyword, product_meta_description, category_title, brand_title, product_category_id, product_varient.id as variant_id, product_varient.sku, product_varient.product_image ')
            ->join('product', 'product.id = product_varient.product_id')
            ->join('category', 'product.product_category_id = category.id', 'left')
            ->join('brand', 'product.product_brand_id = brand.id', 'left')
            ->where('product.user_id',$this->user['id'])
            ->where('product_varient.id', $variant_id)
            ->get('product_varient')->row();
    }
    function get_custom_field_on_add($category_id) {
        $on_add_customfield = $this->db->select("category_custom_field.* , custom_field.* ")->from('category_custom_field')->join('custom_field', 'category_custom_field.custom_field_id=custom_field.id', 'left join')->where('category_id', $category_id)->get()->result_array();
        return $on_add_customfield;
    }
    var $varianttable = 'product_varient';
    // set column field database for datatable orderable
    var $variant_column_order = array(null, 'sku', 'options', 'product_varient_added', null);
    // set column field database for datatable searchable
    var $variant_column_search = array('sku');
    // default order
    var $variant_order = array('product_varient.id' => 'asc');
    private function variant_get_datatables_query() {
        $this->db->from($this->varianttable);
        $i = 0;
        // loop column
        foreach ($this->variant_column_search as $item) {
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
                if (count($this->variant_column_search) - 1 == $i) {
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
        // here order processing
        if (isset($_POST['order'])) {
            $this->db->order_by($this->variant_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->variant_order)) {
            $order = $this->variant_order;
            $this->db->order_by(key($order), $order[key($order) ]);
        }
    }
    function get_product_variant($productId) {
        $this->variant_get_datatables_query();
        if ($_POST['length'] != - 1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->select("product_varient.id,sku,product_varient_added,product_id,(select GROUP_CONCAT((select custom_label FROM custom_field WHERE id = PVCFV.custom_field_id),'::', `value` SEPARATOR '||') FROM product_variant_custom_field_values PVCFV WHERE PVCFV.product_variant_id = product_varient.id) AS options")->where('product_varient.product_id', $productId)->get();
        return $query->result();
    }
    function count_filtered_variant($productId) {
        $this->variant_get_datatables_query();
        $this->db->Where('user_id',$this->user['id']);
        $query = $this->db->where('product_id', $productId)->get();
        return $query->num_rows();
    }
    public function count_all_variant($productId) {
        $this->db->from($this->varianttable)->where('product_id', $productId);
        return $this->db->count_all_results();
    }
    function getVariant($variantId) {
        return $this->db->where('id', $variantId)->get('product_varient')->row_array();
    }
    function getcustomvariantValue($variantId, $custom_field_id) {
        return $this->db->select("value AS custom_field_value,product_variant_id")->where('product_variant_id', $variantId)->where('custom_field_id', $custom_field_id)->get('product_variant_custom_field_values')->row_array();
    }
    function variant_values($variantId, $productId) {
        $query = $this->db->select('id')->from('product_varient')
                            ->join('product', 'product.id = product_varient.product_id')
                            ->where('product_id', $productId)
                            ->where('user_id',$this->user['id'])
                            ->get()
                            ->result_array();
        $totalvariant = sizeof($query);
        if ($totalvariant > 1) {
            $this->db->where_in('product_variant_id', $variantId)->delete('product_variant_custom_field_values');
            $this->db->where_in('product_variant_id', $variantId)->delete('product_variant_market');
            $this->db->where('id', $variantId)->delete('product_varient');
        } else {
            $this->session->set_flashdata('error', '! Not Delete last variant');
            redirect(base_url("admin/product/variant/$productId"));
        }
    }
    function category_custom_field_id($category_id) {
        return $this->db->select('custom_field_id')->where('category_id', $category_id)->get('category_custom_field')->result_array();
    }
    function get_product_varient($product_id, $product_varient_id) {
        return $this->db->select('*')
                        ->where('id !=', $product_varient_id)
                        ->where('product_id', $product_id)
                        ->order_by('product_varient_added')
                        ->get('product_varient')
                        ->result();
    }
    function get_product_varient_by_id($product_varient_id) {
        return $this->db->select('product_varient.*,product.product_title,product.product_category_id,product.product_brand_id')
            ->join('product', 'product.id = product_varient.product_id')
            ->where('user_id',$this->user['id'])
            ->where('product_varient.id', $product_varient_id)
            ->get('product_varient')
            ->row();
    }
    function get_product_by_id($product_id) {
        return $this->db->where('product.id', $product_id)->where('product.user_id', $this->user['id'])->get('product')->row();
    }
    function varient_field_groups_of_category($category_id) {
        return $this->db->select('custom_field_category_id as custom_field_group_id, custom_field_category.title as custom_field_group_name')->join('custom_field', 'custom_field.id = category_custom_field.custom_field_id')->join('custom_field_category', 'custom_field_category.id = custom_field.custom_field_category_id')->where('category_custom_field.category_id', $category_id)->group_by('custom_field_group_id')->where('custom_field.in_variant', 1)->get('category_custom_field')->result_array();
    }
    function update_product_images_by_id($variant_id, $updated_image_value) {
        return $this->db->set('product_image', $updated_image_value)->where('id', $variant_id)->update('product_varient');
    }
    function update_product_variend_data_by_id($product_variant_id, $variantData) {
        return $this->db->set($variantData)->where('id', $product_variant_id)->update('product_varient');
    }
    function get_first_product_varient($product_id) {
        return $this->db->select('*')->where('product_id', $product_id)->order_by('product_varient_added')->where('is_primary', 1)->limit(1)->get('product_varient')->row();
    }
    function get_custom_varient_field_value($variant_id, $custom_field_id) {
        $return = $this->db->select('product_variant_custom_field_values.value')->where('product_variant_id', $variant_id)->where('custom_field_id', $custom_field_id)->get('product_variant_custom_field_values')->row();
        return isset($return->value) ? $return->value : false;
    }
    function product_category_info($category_id) {
        return $this->db->select('category_title,id')->where('id', $category_id)->get('category')->row();
    }
    function is_first_varient($product_id) {
        return $this->db->select('id')->where('product_id', $product_id)->get('product_varient')->row();
    }
    function img_array($product_id, $v_id) {
        return $this->db->select('product_image')->where('product_id', $product_id)->where('id', $v_id)->get('product_varient')->row();
    }
    function update_img($product_id, $v_id, $data) {
        $this->db->set($data)->where('product_id', $product_id)->where('id', $v_id)->update('product_varient');
    }
    function product_name_like_this($product_id, $title) {
        $this->db->like('product_title', $title);
        if ($product_id) {
            $this->db->where('id !=', $product_id);
            $this->db->where('id <', $product_id);
        }
        return $this->db->count_all_results('product');
    }
    function product_sku_like_this($sku) {
        $this->db->like('sku', $sku);
        return $this->db->count_all_results('product_varient');
    }
    function list_page_customfield__data($category_id, $variant_id) {
        return $this->db->select('category_custom_field.custom_field_id,custom_field_category_id as custom_field_group_id, custom_field_category.title as custom_field_group_name,custom_label,display_name as field_name,custom_input_type,options,value,product_varient.sku')->join('custom_field', 'custom_field.id = category_custom_field.custom_field_id')->join('custom_field_category', 'custom_field_category.id = custom_field.custom_field_category_id')->join('product_variant_custom_field_values', 'product_variant_custom_field_values.custom_field_id = category_custom_field.custom_field_id', 'left')->join('product_varient', 'product_varient.id = product_variant_custom_field_values.product_variant_id', 'left')->where('category_custom_field.category_id', $category_id)->where('product_varient.is_primary', 1)->where('custom_field.isforlist', 1)->where('product_varient.id', $variant_id)->order_by('custom_field.id')->get('category_custom_field')->result_array();
    }
    function detail_page_customfield__data_array($category_id, $variant_id) {
        return $this->db->select('category_custom_field.custom_field_id,custom_field_category_id as custom_field_group_id, custom_field_category.title as custom_field_group_name,custom_label,display_name as field_name,custom_input_type,options,value,product_varient.sku')->join('custom_field', 'custom_field.id = category_custom_field.custom_field_id')->join('custom_field_category', 'custom_field_category.id = custom_field.custom_field_category_id')->join('product_variant_custom_field_values', 'product_variant_custom_field_values.custom_field_id = category_custom_field.custom_field_id', 'left')->join('product_varient', 'product_varient.id = product_variant_custom_field_values.product_variant_id', 'left')->where('category_custom_field.category_id', $category_id)->where('product_varient.is_primary', 1)->where('custom_field.isforfront', 1)->where('product_varient.id', $variant_id)->order_by('custom_field.id')->get('category_custom_field')->result_array();
    }
    public function get_product_lowest_marcket($product_variant_id) {
        return $this->db->select('market.*,product_variant_market.*')->where('product_variant_id', $product_variant_id)->join('market', 'market.id = product_variant_market.market_id')->order_by('sale_price')->limit(1)->get('product_variant_market')->row();
    }
    public function get_custom_field_group($custom_field_group_id) {
        return $this->db->where('id', $custom_field_group_id)->get('custom_field_category')->row();
    }
    public function get_custom_field_name($custom_field_id) {
        return $this->db->where('id', $custom_field_id)->get('custom_field')->row();
    }
    public function update_product_details($product_id, $product_details) {
        return $this->db->set($product_details)->where('id', $product_id)->update('product');
    }
    function get_varient_by_product_id($product_id) {
        return $this->db->join('product', 'product.id = product_varient.product_id')
                        ->where('user_id',$this->user['id'])
                        ->where('product_id', $product_id)
                        ->get('product_varient')->row();
    }
    function get_field_values_by_varient_id($product_variant_id) {
        return $this->db->where('product_variant_id', $product_variant_id)->get('product_variant_custom_field_values')->result();
    }
    function get_markets_values_by_varient_id($product_variant_id) {
        return $this->db->where('product_variant_id', $product_variant_id)->get('product_variant_market')->result();
    }

    function get_user_market_data($market_user_id)
    {
        return $this->db->where('market_user_id', $market_user_id)->get('market')->row();
    }
}

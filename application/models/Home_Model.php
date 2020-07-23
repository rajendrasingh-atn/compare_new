<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Home_Model extends CI_Model {
    function get_brand_all_brands() {
        return $this->db->get('brand')->result();
    }
    function get_brand_all_markets() {
        return $this->db->get('market')->result();
    }
    function get_input_name() {
        $inputname = $this->db->select('id,display_name,custom_input_type,custom_hint,options')->get('custom_field')->result_array();
        return $inputname;
    }
    function get_category() {
        return $this->db
                // ->where('parent_category=', 0)
                ->get('category')
                ->result();
    }
    function get_custom_field_label($c_id) {
        $customlabel_id = $this->db->select('category_id,custom_field_id')->where('category_id', $c_id)->get('category_custom_field')->result_array();
        return $customlabel_id;
    }
    function get_input_Field($customfield_id_array) {
        return $this->db->select('id,custom_label,custom_input_type,options')->where_in('id', $customfield_id_array)->order_by("id", "asc")->get('custom_field')->result_array();
    }
    function get_custom_field_width_category_id($category_id) {
        return $this->db->select('category_custom_field.custom_field_id,custom_field_category_id as custom_field_group_id, custom_field_category.title as custom_field_group_name,custom_label,custom_input_type,options,value')->join('custom_field', 'category_custom_field.custom_field_id = custom_field.id')->join('custom_field_category', 'custom_field_category.id = custom_field.custom_field_category_id')->join('product_variant_custom_field_values', 'product_variant_custom_field_values.product_variant_id = category_custom_field.custom_field_id', 'left')->where('category_id', $category_id)->get('category_custom_field')->result_array();
    }
    function custom_field_group_data($category_id, $custom_field_group_id) {
        return $this->db->select('custom_field.id as custom_field_id, custom_field_category_id as custom_field_group_id, custom_field.custom_label, custom_field.custom_hint, custom_field.is_numeric, custom_field.is_required, custom_field.is_date, custom_field.min_value, custom_field.max_value, custom_field.custom_input_type, custom_field.options')->from('custom_field')->join('category_custom_field', 'category_custom_field.custom_field_id = custom_field.id')->join('product_variant_custom_field_values', 'product_variant_custom_field_values.custom_field_id = custom_field.id')->where('category_custom_field.category_id', $category_id)->where('custom_field.custom_field_category_id', $custom_field_group_id)->group_by('product_variant_custom_field_values.custom_field_id')->get()->result_array();
    }
    function custom_field_group_data_of_varient($category_id, $custom_field_group_id) {
        return $this->db->select('custom_field.id as custom_field_id, custom_field_category_id as custom_field_group_id, custom_field.custom_label, custom_field.custom_hint, custom_field.is_numeric, custom_field.is_required, custom_field.is_date, custom_field.min_value, custom_field.max_value, custom_field.custom_input_type, custom_field.options')->from('custom_field')->join('category_custom_field', 'category_custom_field.custom_field_id = custom_field.id')->where('category_custom_field.category_id', $category_id)->where('custom_field.in_variant', 1)->where('custom_field.custom_field_category_id', $custom_field_group_id)->get()->result_array();
    }
    function custom_field_group_data_of_varient_id($category_id, $custom_field_group_id, $variant_id) {

        return $this->db->select('custom_field.id as custom_field_id, custom_field_category_id as custom_field_group_id, custom_field.custom_label, custom_field.custom_hint, custom_field.is_numeric, custom_field.is_required, custom_field.is_date, custom_field.min_value, custom_field.max_value, custom_field.custom_input_type, custom_field.options')->from('custom_field')->join('category_custom_field', 'category_custom_field.custom_field_id = custom_field.id')->join('product_variant_custom_field_values', 'product_variant_custom_field_values.custom_field_id = custom_field.id')->where('category_custom_field.category_id', $category_id)->where('custom_field.in_variant', 1)->group_by('product_variant_custom_field_values.custom_field_id')->where('custom_field.custom_field_category_id', $custom_field_group_id)->get()->result_array();
    }
    function category_custom_field_id($category_id) {
        return $this->db->select('custom_field_id')->where('category_id', $category_id)->get('category_custom_field')->result_array();
    }
    function get_product_varient($product_id, $product_varient_id) {
        return $this->db->select('*')->where('id !=', $product_varient_id)->where('product_id', $product_id)->order_by('product_varient_added')->get('product_varient')->result();
    }
    function get_product_varient_by_id($product_varient_id) {
        return $this->db->select('product_varient.*,product.product_title,product.product_category_id,product.product_brand_id')->join('product', 'product.id = product_varient.product_id')->where('product_varient.id', $product_varient_id)->get('product_varient')->row();
    }
    function get_product_by_id($product_id) {
        return $this->db->where('product.id', $product_id)->get('product')->row();
    }
    function varient_field_groups_of_category($category_id) {

        return $this->db->select('custom_field_category_id as custom_field_group_id, custom_field_category.title as custom_field_group_name')->join('custom_field', 'custom_field.id = category_custom_field.custom_field_id')->join('custom_field_category', 'custom_field_category.id = custom_field.custom_field_category_id')->where('category_custom_field.category_id', $category_id)->group_by('custom_field_group_id')->where('custom_field.in_variant', 1)->get('category_custom_field')->result_array();
    }
    function get_first_product_varient($product_id) {
        return $this->db->select('*')->where('product_id', $product_id)->order_by('product_varient_added')->limit(1)->get('product_varient')->row();
    }
    function get_custom_varient_field_value($variant_id, $custom_field_id) {
        $return = $this->db->select('product_variant_custom_field_values.value')->where('product_variant_id', $variant_id)->where('custom_field_id', $custom_field_id)->get('product_variant_custom_field_values')->row();
        return isset($return->value) ? $return->value : false;
    }
    function product_category_info($category_id) {
        return $this->db->select('category_title,id')->where('id', $category_id)->get('category')->row();
    }
    function get_category_by_slug($category_slug) {
        return $this->db->where('category_slug', $category_slug)->get('category')->row();
    }
    function home_product_filter_backup_only($category_id, $product_or_brand, $price_from, $price_to) {

        $this->db->select('product.id as product_id, product_title, product_description, product_category_id, product_brand_id, product_meta_keyword, product_meta_description,  product_varient.id as product_varient_id,  product_varient.sku as product_sku, product_image, base_price, sale_price');
        $this->db->join('product_varient', 'product_varient.product_id = product.id', 'left');
        $this->db->join('product_variant_market', 'product_variant_market.product_variant_id = product_varient.id', 'left');
        $this->db->join('brand', 'brand.id = product.product_brand_id', 'left');
        $this->db->where('product.product_category_id', $category_id);
        $this->db->where('is_primary', 1);
        if ($product_or_brand != 'all') {
            $this->db->like('product.product_title', $product_or_brand);
            $this->db->or_like('product.product_title', $product_or_brand);
        }
        $this->db->where('product_variant_market.sale_price >=', $price_from);
        $this->db->where('product_variant_market.sale_price <=', $price_to);
        $this->db->order_by('product_varient_added', 'desc');
        $this->db->group_by('product_varient.product_id');
        $this->db->limit(50);
        return $this->db->get('product')->result();
    }
    public function get_product_count($category_id, $product_or_brand, $price_from, $price_to, $brands_filter, $markets_filter, $field_filter_request, $sort_by) {
        $this->db->select('product.id as product_id, product_title,  product_category_id, product_brand_id, product_meta_keyword, product_meta_description, product_short_detail, product_full_detail, product_lowest_marcket, product_slug, category_slug, product_varient.id as product_varient_id,  product_varient.sku as product_sku, product_image, category_slug');
        $this->db->join('category', 'category.id = product.product_category_id', 'left');
        $this->db->join('product_varient', 'product_varient.product_id = product.id', 'left');
        $this->db->join('product_variant_market', 'product_variant_market.product_variant_id = product_varient.id', 'left');
        $this->db->join('brand', 'brand.id = product.product_brand_id', 'left');
        $this->db->join('market', 'market.id = product_variant_market.market_id', 'left');
        $this->db->join('product_variant_custom_field_values', 'product_variant_custom_field_values.product_variant_id = product_varient.id', 'left');
        $this->db->where("(product.product_category_id = '$category_id' OR product.product_category_id IN (SELECT id FROM category WHERE parent_category = '$category_id') )");
        $this->db->where('is_primary', 1);
        if ($product_or_brand && $product_or_brand != 'all') {
            $this->db->like('product.product_title', $product_or_brand);
            $this->db->or_like('product.product_title', $product_or_brand);
        }
        if ($price_from && $price_to) {
            $this->db->where('product_variant_market.sale_price >=', $price_from);
            $this->db->where('product_variant_market.sale_price <=', $price_to);
        }
        if ($brands_filter) {
            $this->db->where_in('brand.brand_slug', $brands_filter);
        }
        if ($markets_filter) {
            $this->db->where_in('market.market_slug', $markets_filter);
        }
        if ($field_filter_request) {
            foreach ($field_filter_request as $field_sluf => $field_data_array) {
                if ($field_data_array->is_numeric == 1) {
                    $field_value_array = explode('-', $field_data_array->field_value);
                    $range_from = isset($field_value_array[0]) ? $field_value_array[0] : 0.1;
                    $range_to = isset($field_value_array[1]) ? $field_value_array[1] : 999999;
                    $this->db->where('product_variant_custom_field_values.value >=', $range_from);
                    $this->db->where('product_variant_custom_field_values.value <=', $range_to);
                } elseif ($field_data_array->custom_input_type == 'dropdown' && $field_data_array->is_numeric == 0) {
                    $field_value_array = $field_data_array->field_value;
                    $this->db->where('product_variant_custom_field_values.value', $field_value_array);
                } elseif ($field_data_array->custom_input_type == 'radio' && $field_data_array->is_numeric == 0) {
                    $field_value_array = $field_data_array->field_value;
                    $this->db->where('product_variant_custom_field_values.value', $field_value_array);
                } elseif ($field_data_array->custom_input_type == 'checkbox' && $field_data_array->is_numeric == 0) {
                    $field_value_array = explode(',', $field_data_array->field_value);
                    $this->db->where_in('product_variant_custom_field_values.value', $field_value_array);
                } elseif ($field_data_array->custom_input_type == 'text' && $field_data_array->is_numeric == 0) {
                    $field_value_array = $field_data_array->field_value;
                    $this->db->like('product_variant_custom_field_values.value', $field_value_array);
                }
            }
        }
        if ($sort_by == 'Price') {
            $this->db->order_by('product_variant_market.sale_price', 'asc');
        } elseif ($sort_by == 'Recent') {
            $this->db->order_by('product_varient_added', 'desc');
        } else {
            $this->db->order_by('product_varient_added', 'desc');
        }

        $this->db->group_by('product_varient.product_id');
        return $this->db->get('product')->result();
    }
    function home_product_filter_data($category_id, $product_or_brand, $price_from, $price_to, $brands_filter, $markets_filter, $field_filter_request, $sort_by, $page, $pro_per_page) {
        $user_id = isset($this->user['id']) ? $this->user['id'] : 0;
        $this->db->select("product.id as product_id, product_title, product_description, product_category_id, product_brand_id, product_meta_keyword, product_meta_description, product_short_detail, product_full_detail, product_lowest_marcket, product_slug, category_slug, product_varient.id as product_varient_id,  product_varient.sku as product_sku, product_image,(SELECT favourite_products.products_id FROM favourite_products WHERE user_id = " . $user_id . " AND favourite_products.products_id = product.id ) as is_fav");
        $this->db->join('category', 'category.id = product.product_category_id', 'left');
        $this->db->join('product_varient', 'product_varient.product_id = product.id', 'left');
        $this->db->join('product_variant_market', 'product_variant_market.product_variant_id = product_varient.id', 'left');
        $this->db->join('brand', 'brand.id = product.product_brand_id', 'left');
        $this->db->join('market', 'market.id = product_variant_market.market_id', 'left');
        $this->db->join('product_variant_custom_field_values', 'product_variant_custom_field_values.product_variant_id = product_varient.id', 'left');
        $this->db->where("(product.product_category_id = '$category_id' OR product.product_category_id IN (SELECT id FROM category WHERE parent_category = '$category_id') )");

        // $this->db->where('product.product_category_id', $category_id);
        $this->db->where('is_primary', 1);
        if ($product_or_brand && $product_or_brand != 'all') {
            $this->db->like('product.product_title', $product_or_brand);
            $this->db->or_like('product.product_title', $product_or_brand);
        }
        if ($price_from && $price_to) {
            $this->db->where('product_variant_market.sale_price >=', $price_from);
            $this->db->where('product_variant_market.sale_price <=', $price_to);
        }
        if ($brands_filter) {
            $this->db->where_in('brand.brand_slug', $brands_filter);
        }
        if ($markets_filter) {
            $this->db->where_in('market.market_slug', $markets_filter);
        }
        if ($field_filter_request) {
            foreach ($field_filter_request as $field_sluf => $field_data_array) {
                if ($field_data_array->is_numeric == 1) {
                    $field_value_array = explode('-', $field_data_array->field_value);
                    $range_from = isset($field_value_array[0]) ? $field_value_array[0] : 0.1;
                    $range_to = isset($field_value_array[1]) ? $field_value_array[1] : 999999;
                    $this->db->where('product_variant_custom_field_values.value >=', $range_from);
                    $this->db->where('product_variant_custom_field_values.value <=', $range_to);
                } elseif ($field_data_array->custom_input_type == 'dropdown' && $field_data_array->is_numeric == 0) {
                    $field_value_array = $field_data_array->field_value;
                    $this->db->where('product_variant_custom_field_values.value', $field_value_array);
                } elseif ($field_data_array->custom_input_type == 'radio' && $field_data_array->is_numeric == 0) {
                    $field_value_array = $field_data_array->field_value;
                    $this->db->where('product_variant_custom_field_values.value', $field_value_array);
                } elseif ($field_data_array->custom_input_type == 'checkbox' && $field_data_array->is_numeric == 0) {
                    $field_value_array = explode(',', $field_data_array->field_value);
                    $this->db->where_in('product_variant_custom_field_values.value', $field_value_array);
                } elseif ($field_data_array->custom_input_type == 'text' && $field_data_array->is_numeric == 0) {
                    $field_value_array = $field_data_array->field_value;
                    $this->db->like('product_variant_custom_field_values.value', $field_value_array);
                }
            }
        }
        if ($sort_by == 'Price') {
            $this->db->order_by('product_variant_market.sale_price', 'asc');
        } elseif ($sort_by == 'Recent') {
            $this->db->order_by('product_varient_added', 'desc');
        } else {
            $this->db->order_by('product_varient_added', 'desc');
        }

        $this->db->group_by('product_varient.product_id');
        $this->db->limit($pro_per_page, $page);
        return $this->db->get('product')->result();
    }
    function get_latest_products() {

        return $this->db->select('product.id as product_id, product_title, product_description, product_category_id, product_brand_id, product_meta_keyword, product_meta_description,  product_varient.id as product_varient_id,  product_varient.sku as product_sku, product_image, base_price, sale_price')->join('product_varient', 'product_varient.product_id = product.id')->join('product_variant_market', 'product_variant_market.product_variant_id = product_varient.id', 'left')->where('is_primary', 1)->order_by('product_varient_added', 'desc')->group_by('product_varient.product_id')->limit(50)->get('product')->result();
    }

    function get_latest_coupons()
    {
        return $this->db->where('valid_till >=', date('Y-m-d H:i:s'))
                        ->order_by('valid_till', 'desc')
                        ->limit(20)->get('coupons')
                        ->result();
    }
    function get_latest_coupons_deals()
    {
        return $this->db->where('valid_till >=', date('Y-m-d H:i:s'))
                        ->where('is_coupon',0)
                        ->order_by('valid_till', 'desc')
                        ->limit(20)->get('coupons')
                        ->result();
    }
    function get_latest_coupons_code()
    {
        return $this->db->where('valid_till >=', date('Y-m-d H:i:s'))
                        ->where('is_coupon',1)
                        ->order_by('valid_till', 'desc')
                        ->limit(20)
                        ->get('coupons')
                        ->result();
    }

    function get_coupons()
    {
        return $this->db->where('valid_till >=', date('Y-m-d H:i:s'))->order_by('valid_till', 'desc')->get('coupons')->result();
    }
    function filter_customfield__data($category_id) {
        return $this->db->select('category_custom_field.custom_field_id,custom_field_category_id as custom_field_group_id, custom_field_category.title as custom_field_group_name,custom_label, display_name as field_name, custom_input_type, is_numeric, options, field_slug')->join('custom_field', 'custom_field.id = category_custom_field.custom_field_id')->join('custom_field_category', 'custom_field_category.id = custom_field.custom_field_category_id')->where('category_custom_field.category_id', $category_id)->where('custom_field.isforfilter', 1)->order_by('custom_field.id')->get('category_custom_field')->result();
    }
    function get_products_by_category($category_id) {
        $user_id = isset($this->user['id']) ? $this->user['id'] : 0;

        return $this->db->select("product.id as product_id, product_title, product_slug, product_category_id, product_brand_id, product_meta_keyword, product_meta_description,  product_varient.id as product_varient_id,  product_varient.sku as product_sku, product_image,affiliate_marketing_url, base_price, sale_price,category_title,category_slug,(SELECT favourite_products.products_id FROM favourite_products WHERE user_id = " . $user_id . " AND favourite_products.products_id = product.id ) as is_fav")->join('product_varient', 'product_varient.product_id = product.id')->join('product_variant_market', 'product_variant_market.product_variant_id = product_varient.id', 'left')->join('category', 'category.id = product.product_category_id', 'left')->where('is_primary', 1)->where('product_category_id', $category_id)->order_by('product_varient_added', 'desc')->group_by('product_varient.product_id')->limit(10)->get('product')->result();
    }
    function add_to_fav_product($data) {
        return $this->db->insert('favourite_products', $data);
    }
    function view_fav_product($user_id, $product_id) {
        return $this->db->select('id')->where('user_id', $user_id)->where('products_id', $product_id)->get('favourite_products')->row();
    }
    function remove_from_fav_product($user_id, $product_id) {
        $user_id = $user_id ? $user_id : 0;
        $this->db->where('user_id', $user_id);
        $this->db->where('products_id', $product_id);
        $this->db->delete('favourite_products');
        return $this->db->affected_rows();
    }

    function get_market()
    {
        return $this->db->select('market_logo')->limit(6)->get('market')->result();
    }
}

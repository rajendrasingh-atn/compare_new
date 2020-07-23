<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Varient_detail_Model extends CI_Model {
    
    function varient_data($category_slug, $varient_id) {
        $user_id = isset($this->user['id']) ? $this->user['id'] : 0;
        $this->db->select("product.id as product_id, product_title,product_slug, product_description, product_category_id, product_brand_id, product_meta_keyword, product_meta_description, product_short_detail, product_full_detail, product_lowest_marcket, product_varient.id as product_varient_id,  product_varient.sku as product_sku, product_image, category.category_title,category.category_slug,category_description ,brand.brand_title,brand.brand_slug,user_alarm.price as alarm_price,(SELECT favourite_products.products_id FROM favourite_products WHERE user_id = " . $user_id . " AND favourite_products.products_id = product.id ) as is_fav, (SELECT min_price FROM price_history WHERE price_history.product_variant_id = product_varient.id ORDER BY day DESC LIMIT 1) as min_price,(SELECT affiliate_url FROM price_history WHERE price_history.product_variant_id = product_varient.id ORDER BY day DESC LIMIT 1)as market_url");
        $this->db->join('product_varient', 'product_varient.product_id = product.id', 'left');
        $this->db->join('category', 'category.id = product.product_category_id', 'left');
        $this->db->join('brand', 'brand.id = product.product_brand_id', 'left');
        $this->db->join('product_variant_custom_field_values', 'product_variant_custom_field_values.product_variant_id = product_varient.id', 'left');
        $this->db->join('user_alarm','user_alarm.product_variant_id = product_varient.id AND user_alarm.user_id = '.$user_id.'','left');
        $this->db->where('category.category_slug', $category_slug);
        $this->db->where('product_varient.id', $varient_id);
        $this->db->group_by('product_varient.product_id');
        return $this->db->get('product')->row();
    }

    function product_varients($varient_id) {
        $this->db->select('product_varient.id as product_varient_id,  product_varient.sku as product_sku');
        $this->db->where('product_varient.id', $varient_id);
        return $this->db->get('product_varient')->row();
    }

    function get_primary_product_data($product_id) 
    {
        $this->db->select('product.*, product_varient.product_image');
        $this->db->join('product_varient', 'product_varient.product_id = product.id', 'left');
        $this->db->where('product.id', $product_id);
        return $this->db->get('product')->row();
    }
    function get_varient_values($product_varient_id) {
        $this->db->select('custom_field.id as custom_field_id,  custom_field.display_name as custom_field_name,custom_field_category.title as field_group_name,product_variant_custom_field_values.value as field_value,product_variant_id');
        $this->db->join('custom_field_category', 'custom_field_category.id = custom_field.custom_field_category_id', 'left');
        $this->db->join('product_variant_custom_field_values', 'product_variant_custom_field_values.custom_field_id = custom_field.id', 'left');
        $this->db->where('product_variant_custom_field_values.product_variant_id', $product_varient_id);
        $this->db->where('custom_field.in_variant', 1);
        $this->db->where('product_variant_custom_field_values.value !=', '');
        return $this->db->get('custom_field')->result();
    }
    function get_product_markets($product_varient_id) {
        $this->db->select('sale_price, base_price, affiliate_marketing_url, market_title, market_slug, market_logo');
        $this->db->join('market', 'market.id = product_variant_market.market_id', 'left');
        $this->db->where('product_variant_market.product_variant_id', $product_varient_id);
        return $this->db->get('product_variant_market')->result();
    }
    function get_brand_all_brands() {
        return $this->db->get('brand')->result();
    }
    function get_comment_through_variantid_userid($variant_id,$user_id)
    {
        $this->db->select('product_reviews.*');
        $this->db->where('product_variant_id',$variant_id);
        $this->db->where('user_id',$user_id);
        $result = $this->db->get('product_reviews');   
        return $result->num_rows();
    }

    function get_product_related_comment($variant_id)
    {
        $this->db->select('product_reviews.*,users.first_name,users.last_name,users.image, (SELECT COUNT(id) FROM review_likes WHERE review_id = product_reviews.id) AS total_like');
        $this->db->join('users', 'users.id = product_reviews.user_id', 'left');
        //$this->db->join('review_likes', 'review_likes.review_id = product_reviews.id', 'left');
        $this->db->where('product_variant_id',$variant_id);
        $this->db->where('product_reviews.status',1);
        return $this->db->get('product_reviews')->result();
    }

    function get_total_rating_related_product($variant_id)
    {
        $this->db->select('count(product_variant_id) as Total');
        $this->db->where('product_variant_id',$variant_id);
        $this->db->where('product_reviews.status',1);
        return $this->db->get('product_reviews')->row();   
    }
    function insert_rating_data($rating_data)
    {
        $this->db->insert('product_reviews',$rating_data);
        return $this->db->insert_id();
    }
    function insert_review_like($review_like)
    {
        $this->db->insert('review_likes',$review_like);
        return $this->db->insert_id();
    }
    function get_count_likes_through_review_id($review_id)
    {
        $this->db->select('count(id) as total_like');
        $this->db->where('review_id',$review_id);
        return $this->db->get('review_likes')->row();
    }
    function delete_review_like_through_reviewid($review_id,$user_id)
    {
        $this->db->where('review_id',$review_id)->where('user_id',$user_id)->delete('review_likes');
        return $this->db->affected_rows();
    }
    function insert_alarm_data($alarm_data)
    {
        $this->db->insert('user_alarm',$alarm_data);
        return $this->db->insert_id();
    }
    function get_alarm_through_userid_variantid($variant_id,$user_id)
    {
        $this->db->select('product_variant_id,user_id');
        $this->db->where('product_variant_id',$variant_id);
        $this->db->where('user_id',$user_id);
        $result = $this->db->get('user_alarm');   
        return $result->num_rows();
    }
    function get_alarm_data($variant_id,$user_id)
    {
        $this->db->select('user_alarm.*');
        $this->db->where('product_variant_id',$variant_id);
        $this->db->where('user_id',$user_id);
        return $this->db->get('user_alarm')->row();
    }

    function delete_alarm_data($variant_id,$user_id)
    {
        $this->db->where('product_variant_id',$variant_id);
        $this->db->where('user_id',$user_id);
        $this->db->delete('user_alarm');
        return $this->db->affected_rows();
    }

    function get_price_history_through_variantid($variant_id,$days)
    {
        $this->db->select('price_history.*');
        $this->db->where('day BETWEEN DATE_SUB(NOW(), INTERVAL '.$days.' DAY) AND NOW()');
        $this->db->where('product_variant_id',$variant_id);
        $this->db->order_by('day','desc');
        return $this->db->get('price_history')->result();
    }
}

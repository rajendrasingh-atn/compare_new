<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Overwriting the timezones function to include Arizona timezone
 */
if (!function_exists('get_menu_item_helper')) {
    function get_menu_item_helper() {
        $ci = & get_instance();
        $ci->load->database();
        $category_menu_item = $ci->Menu_item_model->get_category_menu_item();
        return $category_menu_item;
    }
}
if (!function_exists('get_other_menu_item_helper')) {
    function get_other_menu_item_helper() {
        $ci = & get_instance();
        $ci->load->database();
        $category_other_menu_item = $ci->Menu_item_model->get_other_menu_item();
        return $category_other_menu_item;
    }
}
if (!function_exists('get_footer_markets_helper')) {
    function get_footer_markets_helper($is_footer=false) {
        $ci = & get_instance();
        $ci->load->database();

        $get_footer_markets = $ci->Menu_item_model->get_footer_markets($is_footer);

        return $get_footer_markets;
    }
}
if (!function_exists('get_all_category_helper')) {
    function get_all_category_helper() {
        $ci = & get_instance();
        $ci->load->database();
        $get_footer_markets = $ci->Menu_item_model->get_all_category_helper();
        return $get_footer_markets;
    }
}
if (!function_exists('parent_categories')) {
    function parent_categories() {
        $ci = & get_instance();
        $ci->load->database();
        $parent_categories = $ci->Menu_item_model->get_parent_categories();
        return $parent_categories;
    }
}
if (!function_exists('child_categories')) {
    function child_categories($category_id=false) {
        if($category_id) {
            $ci = & get_instance();
            $ci->load->database();
            $child_categories = $ci->Menu_item_model->get_child_categories($category_id);
            return $child_categories;
        }
        return false;
    }
}

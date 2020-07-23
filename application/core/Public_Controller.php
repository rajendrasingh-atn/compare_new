<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Base Public Class - used for all public pages
 */
class Public_Controller extends MY_Controller {
    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();


        // prepare theme name

        $this->settings->theme = strtolower($this->config->item('public_theme'));
        $this->lang->load('language');

        // set up global header data

        $this->add_css_theme("{$this->settings->theme}.css")
            ->add_css_theme("style.css")
            ->add_css_theme("custom.css");
            // ->add_js_theme("{$this->settings->theme}_i18n.js", TRUE); base_url("/assets/themes/admin/css/dataTables.bootstrap4.min.css"),base_url("/assets/themes/admin/css/select2.min.css"),base_url("/assets/themes/default/css/cookiealert.css"),base_url("/assets/themes/admin/js/jquery.dataTables.min.js"),base_url("/assets/themes/admin/js/dataTables.bootstrap4.min.js"),
        $this->add_external_css(array(base_url("/assets/themes/admin/css/all.min.css"),));
        $this->add_external_js(array(base_url("/assets/themes/default/js/jquery-ui.min.js"), base_url("assets/themes/default/js/slick.min.js"),  base_url("/assets/themes/default/js/commonjs.js"), base_url("/assets/themes/default/js/cookiealert.js"),

        // '//ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js'

        ));
        $this->load->helper("my_menu_item_helper");
        $this->load->helper("my_admin_setting_helper");
        $this->load->helper("meta_key_word_helper");
        $this->load->model("Menu_item_model");
        $this->load->model("Admin_setting_Model");

        // declare main template
        
        $this->template = "../../{$this->settings->themes_folder}/{$this->settings->theme}/template.php";
    }
}

<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Base Private Class - used for all private pages
 */
class Private_Controller extends MY_Controller {
    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        // must be logged in
        if (!$this->user) {
            if (current_url() != base_url()) {
                // store requested URL to session - will load once logged in
                $data = array('redirect' => current_url());
                $this->session->set_userdata($data);
            }
            redirect('login');
        }
        // prepare theme name
        $this->settings->theme = strtolower($this->config->item('public_theme'));
        // set up global header data
        $this->add_css_theme("{$this->settings->theme}.css")->add_js_theme("{$this->settings->theme}_i18n.js", TRUE);
        $this->add_external_js(array(
            base_url("assets/themes/default/js/slick.min.js"),
            base_url("/assets/themes/default/js/commonjs.js"),
            //base_url("/assets/themes/default/js/cookiealert.js"),
        ));
        $this->add_external_css(array(
            base_url("/assets/themes/default/css/custom.css"),
            base_url("/assets/themes/default/css/style.css"),
            //base_url("/assets/themes/default/css/cookiealert.css")
        ));
        $this->load->helper("my_menu_item_helper");
        $this->load->helper("my_admin_setting_helper");
        $this->load->model("Menu_item_model");
        $this->load->model("Admin_setting_Model");
        // declare main template
        $this->template = "../../{$this->settings->themes_folder}/{$this->settings->theme}/template.php";
    }
}

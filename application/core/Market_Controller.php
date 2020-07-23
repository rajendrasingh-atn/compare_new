<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Base Admin Class - used for all administration pages
 */
class Market_Controller extends MY_Controller {
    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        // must be logged in
        if (!$this->user) {
            if (current_url() != base_url()) {
                //store requested URL to session - will load once logged in
                $data = array('redirect' => current_url());
                $this->session->set_userdata($data);
            }
            redirect('login');
        }
        // make sure this user is setup as admin

        if ($this->user['is_admin'])
        {
            redirect(base_url('admin'));
        }
        if ($this->user['role'] != 'market') 
        {
            redirect(base_url());
        }

        // load the admin language file
        $this->lang->load('language');
        // prepare theme name
        $this->settings->theme = strtolower($this->config->item('market_theme'));
        // set up global header data
        $this->add_css_theme("{$this->settings->theme}.css, summernote-bs4.css")->add_css_theme("style.css")->add_css_theme("components.css")->add_js_theme("summernote-bs4.js")->add_js_theme("scripts.js")->add_js_theme("custom.js")->add_js_theme("{$this->settings->theme}_i18n.js", TRUE);
        $this->add_external_css(array(base_url("/assets/themes/admin/css/dataTables.bootstrap4.min.css"), base_url("/assets/themes/admin/css/select2.min.css"), base_url("/assets/themes/admin/css/custom.css")));
        $this->add_external_js(array(base_url("/assets/themes/admin/js/jquery.dataTables.min.js"), base_url("/assets/themes/admin/js/dataTables.bootstrap4.min.js"), base_url("/assets/themes/admin/js/select2.min.js"),));
        $this->load->helper("my_menu_item_helper");
        $this->load->helper("my_admin_setting_helper");
        $this->load->model("Menu_item_model");
        $this->load->model("Admin_setting_Model");
        // declare main template
        $this->template = "../../{$this->settings->themes_folder}/{$this->settings->theme}/template.php";
    }
}

<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends API_Controller {
    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
    }
    /**
     * Default
     */
    function index() {
        $this->lang->load('language');
        $results['error'] = lang('core error no_results');
        display_json($results);
        exit;
    }
    /**
     * Users API - DO NOT LEAVE THIS ACTIVE IN A PRODUCTION ENVIRONMENT !!! - for demo purposes only
     */
    function users() {
        // load the users model and admin language file
        $this->load->model('users_model');
        $this->lang->load('language');
        // get user data
        $users = $this->users_model->get_all();
        $results['data'] = NULL;
        if ($users) {
            // build usable array
            foreach ($users['results'] as $user) {
                $results['data'][$user['id']] = array('name' => $user['first_name'] . " " . $user['last_name'], 'email' => $user['email'], 'status' => ($user['status']) ? lang('admin input active') : lang('admin input inactive'));
            }
            $results['total'] = $users['total'];
        } else {
            $results['error'] = lang('core error no_results');
        }
        // display results using the JSON formatter helper
        display_json($results);
        exit;
    }
}

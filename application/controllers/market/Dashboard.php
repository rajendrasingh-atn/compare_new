<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends Market_Controller {
    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        // load the language files
        $this->lang->load('language');
        // $this->add_js_theme('canvasjs.min.js');
        $this->add_js_theme('dashboard_i18n.js');
        $this->load->model('Market_dashboard_model');
    }
    /**
     * Dashboard
     */
    function index($month = NULL) 
    {

    $get_month = $this->Market_dashboard_model->get_products_year_month(); 
    // P( $get_month);
    $product_visit_month = array();
    $top_products = array();
    foreach ($get_month as $array_value) 
    {
        $month_date = $array_value->last_visited;
        $product_visit_month[$month_date] = date('M - Y',strtotime($month_date));
    }

    $current_month = date('M - Y');

    $top_products_array = $this->Market_dashboard_model->get_top_products(date('Y-m-d'));

    $top_products = array();

    foreach ($top_products_array as  $top_products_val) 
    {
        $get_pr_detail =  $this->Market_dashboard_model->get_product_with_id($top_products_val->product_id);
        $get_pr_detail['product_id'] = $top_products_val->product_id;
        $get_pr_detail['unique_visits'] = $top_products_val->unique_visits;
        $get_pr_detail['total_visits'] = $top_products_val->total_visits;
        $top_products[] = $get_pr_detail;
    }


    $total_visits = $this->Market_dashboard_model->get_highest_click($current_month);
    $products_view = $this->Market_dashboard_model->get_products_view($current_month);

    $product_v_dates =array();

    foreach ($products_view as  $value_array) 
    {  
        $visit_date = date('Y-m-d',strtotime($value_array->last_visited));
       
        $product_v_dates[$visit_date] = $value_array; 
        
    }


    $day_of_month = date("t", strtotime($current_month));

    $product_view_array = array();
    $product_view_month = array();
    $product_visits_array = array();

    $date_key = date('Y-m',strtotime($current_month));
    $date_key = $date_key."-00";
    for($i = 1; $i <= $day_of_month; $i++)
    {
        $date_key = date('Y-m-d', strtotime($date_key . ' +1 day'));

        if(isset($product_v_dates[$date_key]))
        {
            // $product_view_array[] = array('x' => date(strtotime($product_v_dates[$date_key]->last_visited))*1000 , 'y' => $product_v_dates[$date_key]->total_visits ); 
            
            $product_view_month[] = date('d-M-Y',strtotime($product_v_dates[$date_key]->last_visited));
            $product_visits_array[] = $product_v_dates[$date_key]->total_visits; 
        }
        else
        {
            // $product_view_array[] = array('x' => date(strtotime($date_key))*1000 , 'y' => 0 ); 
            $product_view_month[] = date('d-M-Y',strtotime($date_key));
            $product_visits_array[] = 0;             
        }
    }

    $product_view_month = json_encode($product_view_month,JSON_NUMERIC_CHECK);
    $product_visits_array = json_encode($product_visits_array,JSON_NUMERIC_CHECK);


        $this->set_title(lang('admin title admin'));
        $data = $this->includes;
        $data['products'] = $this->Market_dashboard_model->products_count();
        $data['coupons'] = $this->Market_dashboard_model->coupons_count();
        // $data['product_view_array'] = $product_view_array;
        $data['total_visits'] = $total_visits;
        $data['product_visit_month'] = $product_visit_month;
        $data['top_products'] = $top_products;
        $data['product_view_month'] = $product_view_month;
        $data['product_visits_array'] = $product_visits_array;
        $data['total_visits'] = $total_visits;
        $data['product_visit_month'] = $product_visit_month;
        $data['top_products'] = $top_products;


        // load views
        $data['content'] = $this->load->view('market/dashboard', $data, TRUE);
        $this->load->view($this->template, $data);
    }


    function get_month_product_view()
    {
        $graph_month_time = $this->input->post('graph_month');
        if($graph_month_time)
        {
                $graph_month = date('M - Y',strtotime($graph_month_time));
                $products_view = $this->Market_dashboard_model->get_products_view($graph_month);

                $product_v_dates =array();

                foreach ($products_view as  $value_array) 
                {  
                    $visit_date = date('Y-m-d',strtotime($value_array->last_visited));
                   
                    $product_v_dates[$visit_date] = $value_array; 
                    
                }


                $day_of_month = date("t", strtotime($graph_month));

                $product_view_array = array();

                $date_key = date('Y-m',strtotime($graph_month));
                $date_key = $date_key."-00";
                for($i = 1; $i <= $day_of_month; $i++)
                {
                    $date_key = date('Y-m-d', strtotime($date_key . ' +1 day'));

                    if(isset($product_v_dates[$date_key]))
                    {
                        // $product_view_array[] = array('x' => date(strtotime($product_v_dates[$date_key]->last_visited))*1000 , 'y' => $product_v_dates[$date_key]->total_visits ); 

                        $product_view_month[] = date('d-M-Y',strtotime($product_v_dates[$date_key]->last_visited));
                        $product_visits_array[] = $product_v_dates[$date_key]->total_visits; 

                    }
                    else
                    {
                        // $product_view_array[] = array('x' => date(strtotime($date_key))*1000 , 'y' => 0 ); 

                        $product_view_month[] = date('d-M-Y',strtotime($date_key));
                        $product_visits_array[] = 0; 

                    }
                }

                $response['status'] = 'success';
                $response['product_view_month'] = $product_view_month;
                $response['product_visits_array'] = $product_visits_array;
                $response['total_visits'] = $total_visits;

        }
        else
        {
            $response['status'] = 'error';
            $response['msg'] = lang('Some thing Went Wrong');
        }

        echo json_encode($response,JSON_NUMERIC_CHECK);
        return json_encode($response,JSON_NUMERIC_CHECK);
    }

    
}

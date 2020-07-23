<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Overwriting the timezones function to include Arizona timezone
 */

if (!function_exists('page_meta_key_words')) 
{
    function page_meta_key_words($detail_product_id)
    {
        $ci = & get_instance();
        $ci->load->database();
        $product_array = $ci->Admin_setting_Model->get_product_detail_by_id($detail_product_id);

        // <title>Page Title. Maximum length 60-70 characters</title>
        // <meta name="description" content="Page description. No longer than 155 characters." />

        // <!-- Schema.org markup for Google+ -->
        // <meta itemprop="name" content="The Name or Title Here">
        // <meta itemprop="description" content="This is the page description">
        // <meta itemprop="image" content="http://www.example.com/image.jpg">

        // <!-- Twitter Card data -->
        // <meta name="twitter:card" content="product">
        // <meta name="twitter:site" content="@publisher_handle">
        // <meta name="twitter:title" content="Page Title">
        // <meta name="twitter:description" content="Page description less than 200 characters">
        // <meta name="twitter:creator" content="@author_handle">
        // <meta name="twitter:image" content="http://www.example.com/image.jpg">
        // <meta name="twitter:data1" content="$3">
        // <meta name="twitter:label1" content="Price">
        // <meta name="twitter:data2" content="Black">
        // <meta name="twitter:label2" content="Color">

        // <!-- Open Graph data -->
        // <meta property="og:title" content="Title Here" />
        // <meta property="og:type" content="article" />
        // <meta property="og:url" content="http://www.example.com/" />
        // <meta property="og:image" content="http://example.com/image.jpg" />
        // <meta property="og:description" content="Description Here" />
        // <meta property="og:site_name" content="Site Name, i.e. Moz" />
        // <meta property="og:price:amount" content="15.00" />
        // <meta property="og:price:currency" content="USD" />

    }
}

                
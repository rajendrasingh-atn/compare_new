<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Outputs an array in a user-readable JSON format
 *
 * @param array $array
 */
if (!function_exists('display_json')) {
    function display_json($array) {
        $data = json_indent($array);
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo $data;
    }
}
/**
 * Convert an array to a user-readable JSON string
 *
 * @param array $array - The original array to convert to JSON
 * @return string - Friendly formatted JSON string
 */
if (!function_exists('json_indent')) {
    function json_indent($array = array()) {
        // make sure array is provided
        if (empty($array)) return NULL;
        //Encode the string
        $json = json_encode($array);
        $result = '';
        $pos = 0;
        $str_len = strlen($json);
        $indent_str = '  ';
        $new_line = "\n";
        $prev_char = '';
        $out_of_quotes = true;
        for ($i = 0;$i <= $str_len;$i++) {
            // grab the next character in the string
            $char = substr($json, $i, 1);
            // are we inside a quoted string?
            if ($char == '"' && $prev_char != '\\') {
                $out_of_quotes = !$out_of_quotes;
            }
            // if this character is the end of an element, output a new line and indent the next line
            elseif (($char == '}' OR $char == ']') && $out_of_quotes) {
                $result.= $new_line;
                $pos--;
                for ($j = 0;$j < $pos;$j++) {
                    $result.= $indent_str;
                }
            }
            // add the character to the result string
            $result.= $char;
            // if the last character was the beginning of an element, output a new line and indent the next line
            if (($char == ',' OR $char == '{' OR $char == '[') && $out_of_quotes) {
                $result.= $new_line;
                if ($char == '{' OR $char == '[') {
                    $pos++;
                }
                for ($j = 0;$j < $pos;$j++) {
                    $result.= $indent_str;
                }
            }
            $prev_char = $char;
        }
        // return result
        return $result . $new_line;
    }
}
/**
 * Save data to a CSV file
 *
 * @param array $array
 * @param string $filename
 * @return bool
 */
if (!function_exists('array_to_csv')) {
    function array_to_csv($array = array(), $filename = "export.csv") {
        $CI = get_instance();
        // disable the profiler otherwise header errors will occur
        $CI->output->enable_profiler(FALSE);
        if (!empty($array)) {
            // ensure proper file extension is used
            if (!substr(strrchr($filename, '.csv'), 1)) {
                $filename.= '.csv';
            }
            try {
                // set the headers for file download
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header("Content-type: text/csv");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename={$filename}");
                $output = @fopen('php://output', 'w');
                // used to determine header row
                $header_displayed = FALSE;
                foreach ($array as $row) {
                    if (!$header_displayed) {
                        // use the array keys as the header row
                        fputcsv($output, array_keys($row));
                        $header_displayed = TRUE;
                    }
                    // clean the data
                    $allowed = '/[^a-zA-Z0-9_ %\|\[\]\.\(\)%&-]/s';
                    foreach ($row as $key => $value) {
                        $row[$key] = preg_replace($allowed, '', $value);
                    }
                    // insert the data
                    fputcsv($output, $row);
                }
                fclose($output);
            }
            catch(Exception $e) {
            }
        }
        exit;
    }
}
/**
 * Generates a random password
 *
 * @return string
 */
if (!function_exists('generate_random_password')) {
    function generate_random_password() {
        $characters = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array();
        $alpha_length = strlen($characters) - 1;
        for ($i = 0;$i < 8;$i++) {
            $n = rand(0, $alpha_length);
            $pass[] = $characters[$n];
        }
        return implode($pass);
    }
}
/**
 * Retrieves list of language folders
 *
 * @return array
 */
if (!function_exists('get_languages')) {
    function get_languages() 
    {
        $CI = get_instance();

        $CI->load->model('languageModel');
        $get_languages_name = $CI->languageModel->get_languages_name();
        $languages = array();

        foreach ($get_languages_name as $lang_array) 
        {
            $languages[$lang_array->lang] = $lang_array->lang;
        }
        if(empty($languages))
        {
            $languages['English'] = 'English';
        }


        // if ($CI->session->languages) 
        // {
            // p($CI->session->languages);
            // return $CI->session->languages;
        // }
        // $CI->load->helper('directory');
        // $language_directories = directory_map(APPPATH . '/language/', 1);
        // if (!$language_directories) {
        //     $language_directories = directory_map(BASEPATH . '/language/', 1);
        // }
        // foreach ($language_directories as $language) {
        //     if (substr($language, -1) == "/" || substr($language, -1) == "\\") {
        //         $languages[substr($language, 0, -1) ] = ucwords(str_replace(array('-', '_'), ' ', substr($language, 0, -1)));
        //     }
        // }

        $CI->session->languages = $languages;
        return $languages;
    }
}
/**
 * Sort a multi-dimensional array
 *
 * @param array $arr - the array to sort
 * @param string $col - the key to base the sorting on
 * @param string $dir - SORT_ASC or SORT_DESC
 */
if (!function_exists('array_sort_by_column')) {
    function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }
        array_multisort($sort_col, $dir, $arr);
    }
}
if (!function_exists('action_not_permitted')) {
    function action_not_permitted() {
        return true;
        $ci = & get_instance();
        $ci->session->set_flashdata('error', "This action is not permitted.");
        redirect_back();
    }
}
if (!function_exists('slugify_string')) {
    function slugify_string($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }
}


if (!function_exists('get_s3_url')) {
    function get_s3_url($file_name, $bucketName='enes') {
        $s3 = new Aws\S3\S3Client([
          'region' => 'ewr1',
          'endpoint' => 'https://ewr1.vultrobjects.com', 
          // 'hostname' => 'vultrobjects.com', 
          'version' => 'latest',
          'credentials' => [
              'key'    => "QRU13IK7Y8GP7ZQS24O8",
              'secret' => "FMbkTvqbUB4xJVM54gmVSYiy4WONwRCMEmdvIFw6",
            ]
          ]);

        //Get a command to GetObject
        $cmd = $s3->getCommand('GetObject', [
            'Bucket' => $bucketName,
            'Key'    => $file_name
        ]);

        //The period of availability
        $request = $s3->createPresignedRequest($cmd, '+20 minutes');

        //Get the pre-signed URL
        return $signedUrl = (string) $request->getUri();
        // echo '<img src="'.$signedUrl.'" />';
    }
}



function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function get_user_review_like($review_id = false)
{

    $ci = & get_instance();
    $ci->load->database();
    $ci->load->model('Product_detail_Model');
    if($ci->session->userdata('logged_in'))
    {
        $review_value = $ci->Product_detail_Model->get_review_like_user_wise($ci->session->userdata('logged_in')['id'],$review_id);
        return count($review_value);    
    }
}

function count_user_alarm_data()
{
    $ci = & get_instance();
    $ci->load->database();
    $ci->load->model('users_model');
    if($ci->session->userdata('logged_in'))
    {
        $alert_count = $ci->users_model->get_user_alarm_status($ci->session->userdata('logged_in')['id']);
        $alert_data = $alert_count->total_alert;    
        return $alert_data;
    }   
}





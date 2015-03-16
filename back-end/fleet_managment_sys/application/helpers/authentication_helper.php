<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('is_user_logged_in')) {
    function is_user_logged_in()
    {
        //return true; // TODO: remove this line, until get the database authentication support

        $ci =& get_instance();
        if($ci->session->userdata('blocked')){
            $ci->session->set_userdata('error', 'You account has been blocked.Please contact Admin !');
            return FALSE;
        }else {

            if ($ci->session->userdata('logged_in')) {
                $session_data = $ci->session->userdata('logged_in');
                return $session_data;

            } else {
                $ci->session->set_userdata('error', 'Invalid username or password!');
               return FALSE;
            }
        }


    }

}

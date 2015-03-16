<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function index()
    {

        if (is_user_logged_in() && $this->isUserRoleAdmin()) {
            $userData = $this->session->userdata('user');
            $this->load->view('admin/manage_cabs',$userData);
        }else{
            redirect('login', 'refresh');
        }
    }

    function isUserRoleAdmin(){
        $userData = $this->session->userdata('user');
        if($userData['user_type'] == 'admin'){
            return true;
        }else{
            return false;
        }
    }
}
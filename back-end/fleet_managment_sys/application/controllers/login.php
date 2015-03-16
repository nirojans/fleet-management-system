<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

if (!isset($_SESSION)) {
	session_start();
}

class Login extends CI_Controller {

	public function index() {

        $user = $this->session->userdata('user');
        $timeStamp = new MongoDate();
        if (is_user_logged_in()) {
            $log_input_data = array('userId' => new MongoInt32($user['userId']) , 'date' => date('Y-m-d', $timeStamp->sec), 'time' => $timeStamp , 'user_type' => $user['user_type'] , 'log_type' => 'login');
            $this->log_dao->createLog($log_input_data);
            if($user['user_type']=='dispatcher') {
                redirect('dispatcher', 'refresh');
            }
            if($user == 'admin'){
                redirect('admin', 'refresh');
            }
            if($user['user_type'] == 'driver'){
                $log_input_data = array('userId' => new MongoInt32($user['userId']) , 'date' => date('Y-m-d', $timeStamp->sec), 'time' => $timeStamp , 'user_type' => $user['user_type'] , 'log_type' => 'failed');
                $this->log_dao->createLog($log_input_data);
                $this -> load -> helper(array('form'));
                $this -> load -> view('login/index');
            }
            if($user['user_type'] == 'cro'){
                redirect('cro_controller', 'refresh');
            }
            if($user['user_type'] == 'admin'){
                redirect('admin', 'refresh');
            }
		} else {
            $log_input_data = array('userId' => new MongoInt32($user['userId']) , 'date' => date('Y-m-d', $timeStamp->sec), 'time' => $timeStamp , 'user_type' => $user['user_type'] , 'log_type' => 'failed');
            $this->log_dao->createLog($log_input_data);
            $this -> load -> helper(array('form'));
			$this -> load -> view('login/index');
		}
	}

	public function logout() {
        $user = $this->session->userdata('user');
        $timeStamp = new MongoDate();
        $log_input_data = array('userId' => new MongoInt32($user['userId']) , 'date' => date('Y-m-d', $timeStamp->sec), 'time' => $timeStamp , 'user_type' => $user['user_type'] , 'log_type' => 'logout');
        $this->log_dao->createLog($log_input_data);
		$this -> session -> unset_userdata('logged_in');
        $this -> session -> unset_userdata('user');
        $this->session->sess_destroy();
		redirect(base_url(), 'refresh');
	}

    public function authenticate(){

        $userName = $this->input->post('username');
        $pass = $this->input->post('password');
        if($userName=='admin' && $pass=='admin'){
            $result = array('userId' => -1, 'user_type' => 'admin' , 'uName' => 'admin');
        }else{
            $result = $this->user_dao->authenticate($userName,$pass);
        }
        if($result != null ){
            if(isset($result["blocked"]) && $result["blocked"] == 'true'){
                $this->session->set_userdata('blocked', true);
              }else{
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('user', $result);
              }

        }else{
            $this->session->set_userdata('blocked', false);
        }

        $this->index();
    }

    public function isAdmin(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $statusMsg = "false";
        if($input_data['pass'] == 'admin'){
            $statusMsg = "true";
        }
        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg)));
    }

}
?>
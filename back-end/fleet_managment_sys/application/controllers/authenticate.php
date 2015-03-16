<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Authenticate extends CI_Controller {
	function __construct() {
		parent::__construct();
//		$this -> load -> model('user', '', TRUE);
	}

	public function index() {
		//This method will have the credentials validation
		$this -> load -> library('form_validation');

		$this -> form_validation -> set_rules('username', 'Username', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

		if ($this -> form_validation -> run() == FALSE) {
			//Field validation failed.  User redirected to login page
			$this -> load -> view('login/index');
		} else {
			//Go to private area
			redirect('dispatcher', 'refresh');
		}

	}

    function checkStatus(){
        $input = file_get_contents('php://input');
        $inputArray = json_decode(trim($input), true);
        $userId = $inputArray['id'];
        $timeStamp = new MongoDate();
        $authenticationResult = $this->user_dao->status($userId);
        $orderResult = $this->live_dao->getRunningHire($userId);
        if (!$authenticationResult) {
            $authentication = array('loggedOut' => false,'isIdle' =>$orderResult);
        }else {
            $authentication = array('loggedOut' => true,'isIdle' =>$orderResult);
            $log_input_data = array('userId' => new MongoInt32($userId) , 'date' => date('Y-m-d', $timeStamp->sec), 'time' => $timeStamp , 'callingNumber' => $authenticationResult['callingNumber'] , 'user_type' => 'driver' , 'log_type' => 'logout');
            $this->log_dao->createLog($log_input_data);
            $this->log_dao->updateLoginOnLogout(date('Y-m-d', $timeStamp->sec),$timeStamp,new MongoInt32($userId));
            $this->user_dao->setLastLogout($userId,$timeStamp);
            $this->user_dao->setDriverCallingNumberMinus($userId);
        }
        $this -> output -> set_content_type('application/json') -> set_output(json_encode($authentication));
    }


    function force_logout(){
        $input = file_get_contents('php://input');
        $inputArray = json_decode(trim($input), true);
        $userId = $inputArray['uName'];
        $this->user_dao->setIsLogout($userId, True);
        $timeStamp = new MongoDate();

        $authenticationResult = $this->user_dao->logout($userId);
        $log_input_data = array('userId' => new MongoInt32($userId), 'date' => date('Y-m-d', $timeStamp->sec), 'time' => $timeStamp, 'callingNumber' => $authenticationResult['callingNumber'], 'logSheetNumber' => $authenticationResult['logSheetNumber'] , 'user_type' => 'driver', 'log_type' => 'logout');

        $this->log_dao->createLog($log_input_data);
        $this->log_dao->updateLoginOnLogout(date('Y-m-d', $timeStamp->sec), $timeStamp, new MongoInt32($userId));
        $authentication = array('isAuthorized' => true);
        $this->user_dao->setLastLogout($userId, $timeStamp);
        $this->user_dao->setDriverCallingNumberMinus($userId);


        $this -> output -> set_content_type('application/json') -> set_output(json_encode($authentication));
    }

    function logout(){

        $input = file_get_contents('php://input');
        $inputArray = json_decode(trim($input), true);
        $userId = $inputArray['uName'];

        $authenticationResult = $this->user_dao->logout($userId);
        if(!$authenticationResult) {
            $authentication = array('isAuthorized' => true);
        }else{
            $authentication = array('isAuthorized' => false);
        }
        $this -> output -> set_content_type('application/json') -> set_output(json_encode($authentication));
    }


    function driver(){
        $input = file_get_contents('php://input');
        $inputArray = json_decode(trim($input), true);
        $userId = $inputArray['uName'];
        $timeStamp = new MongoDate();
        $authenticationResult = $this->user_dao->driverAuthenticate($userId,$inputArray['pass']);
        $hoursAfterLastLogin = $this->user_dao->hoursAfterLastLogin($authenticationResult['userId'],$timeStamp->sec);
               // $this->log_dao->updateCallingNumber(date('YYYY-mm-dd', $timeStamp->sec),$authenticationResult['userId'],$timeStamp->sec);
        if (!$authenticationResult || $hoursAfterLastLogin<5) {
            $authentication = array('isAuthorized' => false);
        }else {

            $driver = $this->user_dao->getUserById($userId);
            $this->user_dao->setIsLogout($userId, false);
            $log_input_data = array('userId' => new MongoInt32($userId) , 'date' => date('Y-m-d', $timeStamp->sec), 'time' => $timeStamp , 'callingNumber' => $driver['callingNumber'] , 'logSheetNumber' => $driver['logSheetNumber'] , 'user_type' => 'driver' , 'log_type' => 'login' , 'logged_out' => 'no','logout_time' => '-');
            $this->log_dao->createLog($log_input_data);
            // For reference $driver->role->cab->id and $driver->role->id and $driver->role->cab->type
            $authentication = array('isAuthorized' => true,'driverId' => $driver['userId'],  'cabId' => $driver['cabId'] ,'vehicleType' => 'van');
        }
        $this -> output -> set_content_type('application/json') -> set_output(json_encode($authentication));
    }

	function check_database($password) {
        return TRUE; // TODO: remove this line when user db is ready
		//Field validation succeeded.  Validate against database
		$username = $this -> input -> post('username');

		//query the database
		$row = $this -> user -> login($username, $password);

		if ($row) {
			if ($row -> loginApprovalBit == "0") {
				$sess_array = array('computer_number' => $row -> computer_number, 'full_name' => $row -> Full_Name, 'isAdmin' => $this->user->isAdmin($row -> computer_number));
				$this -> session -> set_userdata('logged_in', $sess_array);
				$this->user->update_login($row -> computer_number);
				return TRUE;
			} else {
                $driver = $this->user_dao->find();
				$this -> form_validation -> set_message('check_database', 'Sorry you do not have privileges to login to the system');
				return false;
			}

		} else {
			$this -> form_validation -> set_message('check_database', 'Invalid username or password');
			return false;
		}
	}

}
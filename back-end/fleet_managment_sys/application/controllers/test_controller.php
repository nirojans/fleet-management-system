<?php
class Test_controller extends CI_Controller
{//var cro = {'name' : name , 'uName' : uName , 'pass' : pass , 'nic' : nic ,'tp' : tp };

    function get_collection($collection = 'calls')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;

    }

    public function index()
    {

        $userIds = $this->user_dao->getUserIds_by_type("cro");
        foreach($userIds as $userId){
            $hireUserId = $userId . '-hires';
            $activeUserId= $userId . '-activeCalls';
            $this->counters_dao->resetNextId($hireUserId);
            $this->counters_dao->resetNextId($activeUserId);
        }


    }

    function test(){

    }
    function createUser()
    {
        $userId = $this->counters_dao->getNextId('test_collection');echo $userId;
        $user_details = array('userId' => $userId, 'name' => 'test_user_1', 'uName' => 'uname1', 'pass' => '1234', 'nic' => '852003674', 'tp' => '665488105', 'state'=> 'inactive');
        $this->test_dao->createUser($user_details);
    }

    function getUSer(){}
    function getAllUSer()
    {
        $users = $this->test_dao->getAllUsers();
        print_r($users);
    }
    function update_and_get_user()
    {
        $user_data = $this->test_dao->update_and_get_user(array('address' => ''),array('address' => 'test address 2'));
        print_r($user_data);
    }
    function getCRONavBarView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('admin/cro/cro_navbar', $table_data, TRUE);//, $table_data, TRUE
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }
    function getDriverNavBarView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('admin/driver/driver_navbar', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getAllUsersView(){

        //$input_data = json_decode(trim(file_get_contents('php://input')), true);
        //$limit = $input_data['limit'];
        //$skip = $input_data['skip'];
        $user_type = 'driver';//$input_data['user_type'];


        $data = $this->user_dao->getAllUsers_by_type($user_type);
        var_dump($data);
        print_r($data);
        //$data['table_content'] = $this->load->view('admin/'.$user_type.'/all_'.$user_type.'_view', $data, TRUE);
        //$this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }
    function getNewFormUserView(){
        //$table_data['x'] = 1;

        //$input_data = json_decode(trim(file_get_contents('php://input')), true);
        $user_type = 'driver';
        $cab_ids = array();
        if($user_type === 'driver')
        {
            $cursor = $this->cab_dao->get_unassigned_cabs();
            foreach($cursor as $cab_id){$cab_ids[] = $cab_id;}
        }
        print_r($cab_ids);
        $this->load->view('admin/'.$user_type.'/new_'.$user_type.'_view',array('cab_ids' => $cab_ids,TRUE));// ,array('cab_ids' => $cab_ids), TRUE
        //var_dump($var);
//        $data['table_content'] = $this->load->view('admin/'.$user_type.'/new_'.$user_type.'_view', array('cab_ids' => $cab_ids), TRUE);
//        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }
    function getFees()
    {
        $data = $this->history_dao->getBookingFees();
        var_dump($data);
    }
    function get_free_cabs()
    {
        $cab_ids = array();
        $userId = $_GET['id'];$userId = 3;
        $cursor= $this->cab_dao->get_unassigned_cabs();
        foreach($cursor as $cab_id){$cab_ids[] = $cab_id;}//print_r($cab_ids);
        $data = $this->user_dao->getUser($userId);//print_r($data);
        //$data = array_merge($data,$cab_ids);
        $data['cab_ids'] = $cab_ids;//array_fill_keys(array('cab_ids'), $cab_ids);
        var_dump($data);
        print_r($data);$i=0;
        foreach($data['cab_ids'] as $cabId){echo '<br>'.$cabId['cabId'];$i++;}
        echo '<br>'.$data['cab_ids'][1]['cabId'];
        //$data[$user_type.'_edit_view'] = $this->load->view('admin/'.$user_type.'/edit_'.$user_type, $data, TRUE);
    }
    function updateCab()
    {
        var_dump($this->test_dao->updateCab(1,array('userId' => 3)));
    }

    function get_all_complaints()
    {
        $complaints = $this->complaint_dao->get_all_complaints();
        $complaints['table_content'] = $this->load->view('admin/reports/complaint_reports_view', $complaints, TRUE);
        var_dump($complaints);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $complaints)));
        //print_r($complaints);//comment the array print and load complaints to a view with jason encode

    }

    function get_users_and_complaints()
    {
        $users_cursor = $this->user_dao->getAllUsers();
        $users = array();
        foreach($users_cursor as $user){$users[] = $user;}

        $complaints_cursor = $this->complaint_dao->get_all_complaints();
        $complaints = array();
        foreach($complaints_cursor as $complaint){$complaints[] = $complaint;}
        var_dump($users);
        var_dump($complaints);
    }

    function get_all_complaints_by_driver()
    {//$complaint_data['userId_driver']//this line is for testing
        //$complaint_data = json_decode(trim(file_get_contents('php://input')), true);
        $complaint_data['userId_driver'] = '4';
        $complaints_by_driver = $this->complaint_dao->get_all_complaints_by_driver($complaint_data['userId_driver']);
        $complaints_by_driver['table_content'] = $this->load->view('admin/reports/complaint_reports_view', $complaints_by_driver, TRUE);
        var_dump($complaints_by_driver);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $complaints_by_driver)));
        //var_dump($complaints_by_driver);//comment the array print and load complaints to a view with jason encode
    }
    function get_complaint_by_refId()
    {//$complaint_data['refId'] = 10;//this line is for testing
        //$complaint_data = json_decode(trim(file_get_contents('php://input')), true);
        $complaint_data['refId'] = 5;
        $complaints_by_refId = $this->complaint_dao->get_complaint_by_refId($complaint_data['refId']);
        $complaints_by_refId['table_content'] = $this->load->view('admin/reports/complaint_reports_view', $complaints_by_refId, TRUE);var_dump($complaints_by_refId);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $complaints_by_refId)));
        //var_dump($complaints_by_refId);//comment the array print and load complaints to a view with jason encode
    }

    function get_complaint_by_complaintId()
    {//$complaint_data['complaintId'] = 12;//this line is for testing
        //$complaint_data = json_decode(trim(file_get_contents('php://input')), true);
        $complaint_data['complaintId'] = 9;
        $complaints['complaints'] = $this->complaint_dao->get_complaint_by_complaintId($complaint_data['complaintId']);var_dump($complaints);//$complaints_by_complaintId
        $complaints['table_content'] = $this->load->view('admin/reports/complaint_reports_view', $complaints, TRUE);var_dump($complaints);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $complaints)));
        //var_dump($complaints_by_complaintId);//comment the array print and load complaints to a view with jason encode
    }

    function get_all_cancel_reports()
    {
        //$input = json_decode(trim(file_get_contents('php://input')), true);
        $type = 'ALL';//$input['type'];
        $date_needed = 'today';
        $cancel_report_data = $this->complaint_dao->get_all_cancel_reports($type,$date_needed);
        $cancel_report_data['table_content'] = $this->load->view('admin/reports/cancel_reports_view', $cancel_report_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $cancel_report_data)));
    }
    
    function get_assigned_cabs()
    {
        var_dump($this->cab_dao->get_assigned_cabs());
    }


}

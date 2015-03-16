<?php
class Complaint_controller extends CI_Controller
{
    //Rrecords a complaint with refId(booking ref id), complaint(string containing the customers complaint), complaintId and tineOfComplaint..it is better to record the userId of the CRO as well
    function record_complaint()
    {//$complaint_data = array('refId' => 1, 'complaint' => 'test complaint', 'userId_cro_complaint' => 2);//this line is for testing
        $complaint_data = json_decode(trim(file_get_contents('php://input')), true);
        $complaint_data['complaintId'] = (int)($this->counters_dao->getNextId("complaints"));
        $complaint_data['timeOfComplaint'] = new MongoDate();
        $driver_cro = $this->history_dao->get_driver_and_cro_by_refId($complaint_data['refId']);
        $complaint_data['userId_driver'] = $driver_cro['driverId'];
        $complaint_data['userId_cro_booking'] = $driver_cro['croId'];
        
        $user = $this->session->userdata('user');
        $complaint_data['userId_cro_complaint'] = $user['userId'];
        
        $result = $this->complaint_dao->record_complaint($complaint_data);
        
        $statusMsg = 'success';
        if(!$result){
            $statusMsg = 'fail';
        }
        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg)));
    }    
    //get all complaints in the complaints collection
    function get_all_complaints()
    {
        $complaints = $this->complaint_dao->get_all_complaints();
        $complaints['table_content'] = $this->load->view('admin/reports/complaint_reports_view', $complaints, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $complaints)));
       //print_r($complaints);//comment the array print and load complaints to a view with jason encode
        
    }
    
    function get_all_complaints_by_driver()
    {//$complaint_data['userId_driver']//this line is for testing
        $complaint_data = json_decode(trim(file_get_contents('php://input')), true);
        $complaints = $this->complaint_dao->get_all_complaints_by_driver($complaint_data['userId_driver']);//$complaints_by_driver
        $complaints['table_content'] = $this->load->view('admin/reports/complaint_reports_view', $complaints, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $complaints)));
        //var_dump($complaints_by_driver);//comment the array print and load complaints to a view with jason encode
    }
    
    function get_complaint_by_refId()
    {//$complaint_data['refId'] = 10;//this line is for testing
        $complaint_data = json_decode(trim(file_get_contents('php://input')), true);
        $complaints_by_refId = $this->complaint_dao->get_complaint_by_refId($complaint_data['refId']);
        $complaints_by_refId['table_content'] = $this->load->view('admin/reports/complaint_reports_view', $complaints_by_refId, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $complaints_by_refId)));
        //var_dump($complaints_by_refId);//comment the array print and load complaints to a view with jason encode       
    }
    
    function get_complaint_by_complaintId()
    {//$complaint_data['complaintId'] = 12;//this line is for testing
        $complaint_data = json_decode(trim(file_get_contents('php://input')), true);
        $complaints_by_complaintId = $this->complaint_dao->get_complaint_by_complaintId($complaint_data['complaintId']);
        $complaints_by_complaintId['table_content'] = $this->load->view('admin/reports/complaint_reports_view', $complaints_by_complaintId, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $complaints_by_complaintId)));
        //var_dump($complaints_by_complaintId);//comment the array print and load complaints to a view with jason encode        
    }
    
    function updatae_complaint()
    {//$complaint_data['complaintId'] = 12; $complaint_data['complaint'] = 'edited the complaint';//this line is for testing
        $complaint_data = json_decode(trim(file_get_contents('php://input')), true);
        $complaints_by_complaintId = $this->complaint_dao->update_complaint($complaint_data['complaintId'],array('complaint' => $complaint_data['complaint']));
        var_dump($complaints_by_complaintId);//comment the array print and load complaints to a view with jason encode
        
    }
    
    function getReportsNavBarView(){
               
        $table_data['x'] = 1;
        
//        $input_data = json_decode(trim(file_get_contents('php://input')), true);
//        $user_type = $input_data['user_type'];
        
        $data['table_content'] = $this->load->view('admin/reports/reports_navbar', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }
    
    function getSidePanelView(){
        $table_data['x'] = 1;
        
//        $input_data = json_decode(trim(file_get_contents('php://input')), true);
//        $user_type = $input_data['user_type'];
        
        $data['table_content'] = $this->load->view('admin/reports/reports_sidepanel', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }
    
    //Functions for cancel reports
    
    function get_all_cancel_reports()
    {
        $input = json_decode(trim(file_get_contents('php://input')), true);
        $type = $input['type'];
        $date_needed = $input['date_needed'];
        $cancel_report_data = $this->complaint_dao->get_all_cancel_reports($type,$date_needed);
        $cancel_report_data['table_content'] = $this->load->view('admin/reports/cancel_reports_view', $cancel_report_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $cancel_report_data)));
    }
    
    //Functions for missed calls
    
    function get_missed_calls_today()
    {
        $missed_calls['missed_call'] = $this->call_dao->get_missed_calls_today();
        $missed_calls_info['table_content'] = $this->load->view('admin/reports/missed_call_report_view', $missed_calls, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $missed_calls_info)));
        //var_dump($missed_calls);
    }
    
    function get_all_missed_calls()
    {
        $missed_calls['missed_call'] = $this->call_dao->get_all_missed_calls();
        $missed_calls_info['table_content'] = $this->load->view('admin/reports/missed_call_report_view', $missed_calls, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $missed_calls_info)));
    }
    
    function get_all_missed_calls_by_date()
    {//$date = array('date' => "2014-12-10");
        $date = json_decode(trim(file_get_contents('php://input')), true);//var_dump($date);
        $missed_calls['missed_call'] = $this->call_dao->get_all_missed_calls_by_date($date['date']);
        $missed_calls_info['table_content'] = $this->load->view('admin/reports/missed_call_report_view', $missed_calls, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $missed_calls_info)));        
    }
}

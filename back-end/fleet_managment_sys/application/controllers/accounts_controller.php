<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts_controller extends CI_Controller
{
    function getAllAccountsView()
    {
        $data = $this->history_dao->getBookingFees();
        $data['table_content'] = $this->load->view('admin/accounts/all_accounts_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }

    function getAccountsViewByDriverId()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->history_dao->getBookingFeesByDriverId($input_data['driverId']);
        $data['table_content'] = $this->load->view('admin/accounts/all_accounts_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }

    function updateFee()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->history_dao->updateBookingChargeByRef($input_data['refId'],$input_data['bookingCharge']);
        $this->output->set_output(json_encode(array("statusMsg" => "success")));

    }
    
    function getAccountsNavBarView(){
               
        $table_data['x'] = 1;
        
//        $input_data = json_decode(trim(file_get_contents('php://input')), true);
//        $user_type = $input_data['user_type'];
        
        $data['table_content'] = $this->load->view('admin/accounts/accounts_navbar', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }
    
    function getSidePanelView(){
        $table_data['x'] = 1;
        
//        $input_data = json_decode(trim(file_get_contents('php://input')), true);
//        $user_type = $input_data['user_type'];
        
        $data['table_content'] = $this->load->view('admin/accounts/accounts_sidepanel', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getBookingsByDateRange(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $startDate = new MongoDate(strtotime($input_data['startDate']));
        $endDate = new MongoDate(strtotime($input_data['endDate']));
        $userId = $input_data['userId'];
        $cabId = $input_data['cabId'];
        $historyCursor = $this->history_dao->getBookingsByDateRange($startDate,$endDate,$userId,$cabId);
        $liveCursor = $this->live_dao->getBookingsByDateRange($startDate,$endDate,$userId,$cabId);
        $data= array('data'=> array());
        foreach ($liveCursor as $booking) {
            $data['data'][]= $booking;
        }
        foreach ($historyCursor as $booking) {
            $data['data'][]= $booking;
        }

        $data['table_content'] = $this->load->view('admin/reports/summary_table', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));
    }

    function getSummaryView(){
        $driverIds = $this->user_dao->getUserIds_by_type('driver');
        $cabIds = $this->cab_dao->getCabIds();
        $data['driverIds'] = $driverIds;
        $data['cabIds'] = $cabIds;
        $data['table_content'] = $this->load->view('admin/reports/summary_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }

    function getHireSummaryView(){
        $data = "";
        $data['table_content'] = $this->load->view('admin/reports/hire_summary_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }

    function getWorkingHoursView(){
        $driverIds = $this->user_dao->getUserIds_by_type('driver');
        $data['driverIds'] = $driverIds;
        $data['table_content'] = $this->load->view('admin/reports/working_hours_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }
    /*function getCallingNumberSummaryView(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $date = $input_data['date'];
        $historyCursor = $this->history_dao->getHireSummaryByDate($date);
        $liveCursor = $this->live_dao->getHireSummaryByDate($date);
        $data= array('data'=> array());
        $i = 0;
        foreach ($liveCursor as $booking) {
            $data['data'][$i]= $booking;
            $relevantLogin=$this->log_dao->getCallingNumberByDate($date,$booking['driverId']);
            $relevantLogout=$this->log_dao->getLogoutByDate($date,$booking['driverId']);
            $data['data'][$i]['callingNumber']=$relevantLogin['callingNumber'];
            if(isset($relevantLogin['time'])) {
                $timeOn = new MongoDate(strtotime($relevantLogin['time']));
                $data['data'][$i]['timeOn']=date('h:i:s', $timeOn->sec);
            }else{
                $timeOn = "-";
                $data['data'][$i]['timeOn']=$timeOn;
            }
            if(isset($relevantLogin['time'])) {
                $timeOut = new MongoDate(strtotime($relevantLogout['time']));
                $data['data'][$i]['timeOut']=date('h:i:s', $timeOut->sec);
            }else{
                $timeOut = "-";
                $data['data'][$i]['timeOut']=$timeOut;
            }
            $i++;
        }
        foreach ($historyCursor as $booking) {
            $data['data'][$i]= $booking;
            $relevantLogin=$this->log_dao->getCallingNumberByDate($date,$booking['driverId']);
            $relevantLogout=$this->log_dao->getLogoutByDate($date,$booking['driverId']);
            $data['data'][$i]['callingNumber']=$relevantLogin['callingNumber'];
            if(isset($relevantLogin['time'])) {
                $timeOn = new MongoDate(strtotime($relevantLogin['time']));
                $data['data'][$i]['timeOn']=date('h:i:s', $timeOn->sec);
            }else{
                $timeOn = "-";
                $data['data'][$i]['timeOn']=$timeOn;
            }
            if(isset($relevantLogin['time'])) {
                $timeOut = new MongoDate(strtotime($relevantLogout['time']));
                $data['data'][$i]['timeOut']=date('h:i:s', $timeOut->sec);
            }else{
                $timeOut = "-";
                $data['data'][$i]['timeOut']=$timeOut;
            }
            $i++;
        }
        $data['table_content'] = $this->load->view('admin/reports/hire_summary_table', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }*/

    function getCallingNumberSummaryView(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $date = $input_data['date'];
        $loginCursor=$this->log_dao->getLoginByDate($date);
        $data= array('data'=> array());
        $i = 0;
        foreach ($loginCursor as $entry) {
            $data['data'][$i]= $entry;
            $timeOut=$entry['logout_time']; //$this->log_dao->getLogoutForLogin($entry['date'],$entry['userId']);
            if($timeOut=='-'){
                $timeOut = new MongoDate();
                $data['data'][$i]['timeOut'] = 'not logged out';
            }else{
                $data['data'][$i]['timeOut'] = date('Y-m-d h:i:s', $timeOut->sec);
            }

            $timeOn = $entry['time'];
            $data['data'][$i]['timeOn'] = date('Y-m-d h:i:s', $timeOn->sec);
            $historyHireTypes=$this->history_dao->getHireTypesSummaryByDate($timeOn,$timeOut,$entry['userId']);
            $liveHireTypes=$this->live_dao->getHireTypesSummaryByDate($timeOn,$timeOut,$entry['userId']);
                $data['data'][$i]['drop']=$historyHireTypes['data']['drop'] + $liveHireTypes['data']['drop'];
                $data['data'][$i]['bothway']=$historyHireTypes['data']['bothway'] + $liveHireTypes['data']['bothway'];
                $data['data'][$i]['guestCarrier']=$historyHireTypes['data']['guestCarrier'] + $liveHireTypes['data']['guestCarrier'];
                $data['data'][$i]['outside']=$historyHireTypes['data']['outside'] + $liveHireTypes['data']['outside'];
                $data['data'][$i]['day']=$historyHireTypes['data']['day'] + $liveHireTypes['data']['day'];
                $data['data'][$i]['normal']=$historyHireTypes['data']['normal'] + $liveHireTypes['data']['normal'];
                $data['data'][$i]['cabId']=$historyHireTypes['data']['cabId'];
                $data['data'][$i]['hires']=$historyHireTypes['data']['hires']+$liveHireTypes['data']['hires'];
                $data['data'][$i]['cancel']=$historyHireTypes['data']['cancel']+$liveHireTypes['data']['cancel'];
            $i++;
        }

        $data['table_content'] = $this->load->view('admin/reports/hire_summary_table', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }
    function getWorkingHoursByDate(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $startDate = new MongoDate(strtotime($input_data['startDate']));
        $endDate = new MongoDate(strtotime($input_data['endDate']));
        $cursor = $this->log_dao->getLoginByDateRange($startDate,$endDate);
        $data= array('data'=> array());

        foreach ($cursor as $booking) {
            //$data['data'][$i]= $booking;
            $timeOut=$booking['logout_time'];
            $timeIn=$booking['time'];
            $driverId=$booking['userId'];

            if($timeOut=='-'){

            }else{
                $preWorkingHours = $timeOut->sec - $timeIn->sec;
                $workingHour=(int)($preWorkingHours/3600);
                $data['data'][$driverId]['userId'] =$driverId;
                if(isset($data['data'][$driverId]['workingHours'])) {
                    $data['data'][$driverId]['workingHours'] += $workingHour;
                }else{
                    $data['data'][$driverId]['workingHours'] = $workingHour;
                }
            }

            //$data['data'][$i]['workingHours'] = $booking['logout_time']-$booking['time'];

        }

        $data['table_content'] = $this->load->view('admin/reports/working_hours_table', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }

    function getDetailedWorkingHoursByDate(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $startDate = new MongoDate(strtotime($input_data['startDate']));
        $endDate = new MongoDate(strtotime($input_data['endDate']));
        $driverId = $input_data['userId'];
        $cursor = $this->log_dao->getLoginByDateRangeAndDriver($startDate,$endDate,$driverId);
        $data= array('data'=> array());
        $i=0;
        foreach ($cursor as $booking) {
            $data['data'][$i]= $booking;
            //$data['data'][$i]['workingHours'] = $booking['logout_time']-$booking['time'];
            $i++;
        }

        $data['table_content'] = $this->load->view('admin/reports/detailed_working_hours', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }


}
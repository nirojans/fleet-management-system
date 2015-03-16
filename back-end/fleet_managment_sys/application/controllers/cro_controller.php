<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cro_controller extends CI_Controller
{

    public function index()
    {
        if (is_user_logged_in() && $this->isUserRoleCRO()) {
            $userData = $this->session->userdata('user');
            $counterHireName = $userData['userId'] . '-hires';
            $counterActiveName = $userData['userId'] . '-activeCalls';

            $isNewDay = $this->call_dao->isNewDay();
            /* Reset all the counter to zero if it is a new day */
            if($isNewDay){
                $this->counters_dao->resetNextId("answeredCalls");
                $this->counters_dao->resetNextId("missedCalls");
                $this->counters_dao->resetNextId("activeCalls");
                $this->counters_dao->resetNextId("totalHires");
                $userIds = $this->user_dao->getUserIds_by_type("cro");
                foreach($userIds as $userId){
                    $hireUserId = $userId . '-hires';
                    $activeUserId= $userId . '-activeCalls';
                    $this->counters_dao->resetNextId($hireUserId);
                    $this->counters_dao->resetNextId($activeUserId);
                }
            }

            $callStat['activeCalls'] = $this->counters_dao->getCounterValue("activeCalls");
            $callStat['missedCalls'] = $this->counters_dao->getCounterValue("missedCalls");
            $callStat['answeredCalls'] = $this->counters_dao->getCounterValue("answeredCalls");
            $callStat['totalCalls'] = $callStat['missedCalls'] + $callStat['answeredCalls'];
            $callStat['totalHires'] = $this->counters_dao->getCounterValue("totalHires");
            $callStat['croHires'] = $this->counters_dao->getCounterValue($counterHireName);
            $callStat['croActiveCalls'] = $this->counters_dao->getCounterValue($counterActiveName);

            $userData['callStat']=$callStat;

            $this->load->view('cro/cro_main',$userData);
            $location_board_pane = $this->load->view("dispatcher/panels/locView", NULL, TRUE);
        }else{
            redirect('login', 'refresh');
        }

    }

    function isUserRoleCRO(){
        $userData = $this->session->userdata('user');
        if($userData['user_type'] == 'cro'){
            return true;
        }else{
            return false;
        }
    }

    function loadBookingsView(){

        if (is_user_logged_in()) {
            $userData = $this->session->userdata('user');
            $this->load->view('cro/bookings/bookings_main',$userData);
        }else{
            $this -> load -> helper(array('form'));
            $this -> load -> view('login/index');
        }
    }

    function loadMyBookingsView(){

        if (is_user_logged_in()) {
            $userData = $this->session->userdata('user');
            $this->load->view('cro/my_bookings/my_bookings_main',$userData);
        }else{
            $this -> load -> helper(array('form'));
            $this -> load -> view('login/index');
        }
    }

    function loadLocationBoardView(){

        if (is_user_logged_in()) {
            $userData = $this->session->userdata('user');
            $location_board_pane = $this->load->view("dispatcher/panels/locView", NULL, TRUE);
            $data = array(
                'userData'=> $userData,
                'location_board_pane' => $location_board_pane
            );
            $this->load->view('cro/non_editable_loc_board',$data);

        }else{
            $this -> load -> helper(array('form'));
            $this -> load -> view('login/index');
        }
    }


    function loadMapView(){

        if (is_user_logged_in()) {
            $userData = $this->session->userdata('user');
            $this->load->view('cro/map/map_main',$userData);
        }else{
            $this -> load -> helper(array('form'));
            $this -> load -> view('login/index');
        }
    }

    function getAdvancedBookingsView(){
        $data= $this->live_dao->getAllBookingsTest();
        $view_data['advanced_bookings_view'] = $this->load->view('cro/bookings/advanced_bookings', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", 'data' => $data,"view" => $view_data)));
    }

    function getBookingByRefIdView(){
        $statusMsg = 'false';
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->live_dao->getBooking($input_data["refId"]);

        if($data == null){
            $data = $this->history_dao->getBookingByRefId($input_data["refId"]);
        }

        $view_data['advanced_bookings_view'] = "";
        if($data != null){
            $statusMsg = 'true';
            foreach($data['profileLinks'] as $profile){
                $data['customerProfile'][] =  $this->customer_dao->getCustomerByMongoObjId($profile);
            }
            $view_data['advanced_bookings_view'] = $this->load->view('cro/bookings/bookings_by_reference', $data, TRUE);
        }
        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg , "data" => $data , 'view' => $view_data)));
    }

    function getSearchByNamesViews(){
        $statusMsg = 'true';
        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $result = $this->customer_dao->getSimilarNames($input_data["name"]);

        if(isset($result['data'])){
            foreach( $result['data'] as $data){
                if(isset($data['call_history']))unset($data['call_history']);
                if(isset($data['history']))unset($data['history']);
            }
        }

        $view_data['customers_by_name_view'] = $this->load->view('cro/bookings/customers_by_name', $result, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg , 'view' => $view_data)));

    }

    function getSearchByTownView(){
        $statusMsg = 'true';
        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $result['live'] = $this->live_dao->getBookingsByTown($input_data["town"]);
        $result['history'] = $this->history_dao->getBookingsByTown($input_data["town"]);

        $view_data['bookings_by_address_view'] = $this->load->view('cro/bookings/bookings_by_address', $result, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg , 'view' => $view_data)));

    }

    function getTodayMyBookings(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $user = $this->session->userdata('user');
        $data = $this->live_dao->getCroBookingsToday($user['userId']);

        $data['booking_summary'] = $this->load->view('cro/my_bookings/booking_summary', $data , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }

    function  getMyBookings(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $user = $this->session->userdata('user');

        $data = $this->live_dao->getCroBookings($user['userId']);

        $data['booking_summary'] = $this->load->view('cro/my_bookings/booking_summary', $data , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getCustomerInfoEditView(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getCustomer($input_data['tp']);

        $data['customer_info_edit_view'] = $this->load->view('cro/customer_info_edit', $result , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }

    function getEditBookingView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->live_dao->getBookingByMongoId($input_data['objId']);
        $result['airportPackages'] = $this->packages_dao->getAllAirportPackages();
        $result['dayPackages'] = $this->packages_dao->getAllDayPackages();
        $data['edit_booking_view'] = $this->load->view('cro/edit_booking', $result , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getCancelConfirmationView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $bookingData = $this->live_dao->getBookingByMongoId($input_data['_id']);

        $data['cancel_confirmation_view'] = $this->load->view('cro/cancel_booking', $bookingData , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function loadCabHeaderView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $bookingData = $this->live_dao->getBookingByMongoId($input_data['_id']);

        $data['cancel_confirmation_view'] = $this->load->view('cro/cancel_booking', $bookingData , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getCustomerInfoView(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $userData = $this->session->userdata('user');
        $counterHireName = $userData['userId'] . '-hires';
        $counterActiveName = $userData['userId'] . '-activeCalls';

        $result = $this->customer_dao->getCustomer($input_data['tp']);

        $isNewDay = $this->call_dao->isNewDay();
        if($isNewDay){
            $this->counters_dao->resetNextId("answeredCalls");
            $this->counters_dao->resetNextId("missedCalls");
            $this->counters_dao->resetNextId("activeCalls");
            $this->counters_dao->resetNextId("totalHires");
            $userIds = $this->user_dao->getUserIds_by_type("cro");
            foreach($userIds as $userId){
                $hireUserId = $userId . '-hires';
                $activeUserId= $userId . '-activeCalls';
                $this->counters_dao->resetNextId($hireUserId);
                $this->counters_dao->resetNextId($activeUserId);
            }
        }

        $callStat['activeCalls'] = $this->counters_dao->getCounterValue("activeCalls");
        $callStat['missedCalls'] = $this->counters_dao->getCounterValue("missedCalls");
        $callStat['answeredCalls'] = $this->counters_dao->getCounterValue("answeredCalls");
        $callStat['totalCalls'] = $callStat['missedCalls'] + $callStat['answeredCalls'];
        $callStat['totalHires'] = $this->counters_dao->getCounterValue("totalHires");

        $callStat['croHires'] = $this->counters_dao->getCounterValue($counterHireName);
        $callStat['croActiveCalls'] = $this->counters_dao->getCounterValue($counterActiveName);

        if($result == null){
            $result =array('tp' => $input_data['tp']);
            $data['customer_info_view'] = $this->load->view('cro/new_customer_form', $result , TRUE);
            /* Customer is new so send empty to to the JOB Info View */
            $data['call_center_info_view'] = $this->load->view('cro/call_center_info', $callStat , TRUE);
            $data['job_info_view'] = '';
            $data['new_booking_view'] = '';
            $data['booking_history_view']= '';
            $data['call_history_view']= '';
            $this->output->set_output(json_encode(array("statusMsg" => "fail","view" => $data)));
        }else{

            $bookingData=array('customerInfo' => $result);

            /* TODO ADD PABX DATA TO CALL TIME */
            $user = $this->session->userdata('user');

//            if($input_data['isFromPABX'] == 'true'){
//                $result['call_history'][] = array('callTime' => new MongoDate() , 'croId' => $user['userId'] , 'croUname' => $user['uName']);
//                $this->customer_dao->updateCustomer($input_data["tp"], $result);
//            }

            foreach($result as $key => $value){
                if($key == 'history'){
                    foreach($value as $newKey){
                        $liveData = $this->live_dao->getBookingByMongoId($newKey['_id']);
                        if($liveData  != null){
                            /* Get Driver Details For the Booking */
                            if($liveData['driverId'] != '-'){
                                $user = $this->user_dao->getUserById($liveData['driverId']);
                                $liveData['driverTp'] = $user['tp'];
                            }else{
                                $liveData['driverTp']= '-';
                            }

                            /* Get Cab Details For the Booking */
                            if($liveData['cabId'] != '-'){
                                $cab = $this->cab_dao->getCab($liveData['cabId']);
                                $liveData['cabColor'] = $cab['color'];
                                $liveData['cabPlateNo'] = $cab['plateNo'];
                                $liveData['cabModel'] = $cab['model'];
                            }else{
                                $liveData['cabColor'] = '-';
                                $liveData['cabPlateNo'] = '-';
                                $liveData['cabModel'] = '-';
                            }
                            $bookingData['live_booking'][] = $liveData ;
                        }

                        $historyData = $this->history_dao->getBookingByMongoId($newKey['_id']);
                        if($historyData != null){

                            if($historyData ['driverId'] != '-'){
                                $user = $this->user_dao->getUserById($historyData ['driverId']);
                                $historyData ['driverTp'] = $user['tp'];
                            }else{
                                $historyData ['driverTp']= '-';
                            }

                            /* Get Cab Details For the Booking */
                            if($historyData['cabId'] != '-'){
                                $cab = $this->cab_dao->getCab($historyData['cabId']);
                                $historyData['cabColor'] = $cab['color'];
                                $historyData['cabPlateNo'] = $cab['plateNo'];
                                $historyData['cabModel'] = $cab['model'];
                            }else{
                                $historyData['cabColor'] = '-';
                                $historyData['cabPlateNo'] = '-';
                                $historyData['cabModel'] = '-';
                            }
                            $bookingData['history_booking'][] = $historyData ;
                        }
                    }
                }
            }

            if($result['profileType'] == 'Cooperate'){
                if(isset($result['personalProfiles'])){
                    foreach($result['personalProfiles'] as $personalProfileTp){
                        $userInfo = $this->customer_dao->getCustomerByObjId($personalProfileTp['_id']);
                        unset($userInfo['history']);
                        if($userInfo != null)
                        $result['userInfo'][] =$userInfo;
                    }
                }
            }

            /* Get all packages and send it to the new bookings view */
            $result['airportPackages'] = $this->packages_dao->getAllAirportPackages();
            $result['dayPackages'] = $this->packages_dao->getAllDayPackages();
            $bookingData['airport_packages'] = $this->packages_dao->getAllAirportPackages();
            $bookingData['day_packages'] = $this->packages_dao->getAllDayPackages();

            $data['call_center_info_view'] = $this->load->view('cro/call_center_info', $callStat , TRUE);
            $data['customer_info_view'] = $this->load->view('cro/customer_info', $result , TRUE);
            $data['job_info_view'] = $this->load->view('cro/job_info', $bookingData , TRUE);
            $data['new_booking_view'] = $this->load->view('cro/new_booking', $result , TRUE);
            $data['booking_history_view'] = $this->load->view('cro/booking_history', $bookingData , TRUE);
            $data['call_history_view'] = $this->load->view('cro/call_history', $result , TRUE);
            $this->output->set_output(json_encode(array("statusMsg" => "success","important" => $bookingData ,"view" => $data)));
        }
    }

    function getCabHeaderView(){
        if (is_user_logged_in()) {
            $userData = $this->session->userdata('user');
            $this->load->view('cro/cabs/cab_header',$userData);
        }else{
            $this -> load -> helper(array('form'));
            $this -> load -> view('login/index');
        }

    }
    
    function getAllPackagesView()
    {
        if (is_user_logged_in())
        {
            $userData = $this->session->userdata('user');
            $this->load->view('cro/packages/packages_main',$userData);
        }
        else
        {
            $this -> load -> helper(array('form'));
        }
    }

}
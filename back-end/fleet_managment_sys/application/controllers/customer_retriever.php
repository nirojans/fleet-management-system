<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Customer_retriever extends CI_Controller
{

    public function index()
    {

    }

    public function createCustomer()
    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->createCustomer($input_data);
        if ($result == true)
            $this->output->set_output(json_encode(array("statusMsg" => "success", "data" => "customer created successfully ")));
        else
            $this->output->set_output(json_encode(array("statusMsg" => "fail", "data" => "customer already exists")));
    }

    public function getSimilarTpNumbers()
    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getSimilar($input_data["tp"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "data" => $result)));

    }

    public function getCustomer()
    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getCustomer($input_data["tp"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "data" => $result)));

    }

    public function updateCustomer()
    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->customer_dao->updateCustomer($input_data["tp"], $input_data["data"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success")));

    }

    public function addBooking()
    {
        $statusMsg = 'success';
        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $user = $this->session->userdata('user');

        $input_data["data"]["refId"] = $this->counters_dao->getNextId('reference');
        $input_data['data']['croId'] = $user['userId'];

        /* Set the date and time to UTC */
        $input_data["data"]["callTime"] = new MongoDate();
        $input_data["data"]["bookTime"] = new MongoDate(strtotime($input_data['data']['bDate'] . " " . $input_data["data"]['bTime']));

        /* Unset the values of bDate and bTime */
        //unset($input_data['data']['bTime']);
        //unset($input_data['data']['bDate']);

        $input_data["data"]["tp"] = $input_data["tp"];
        $customerProfile = $this->customer_dao->getCustomer($input_data['tp']);
        $input_data['data']['profileLinks'][] = $customerProfile['_id'];

        /* If it is a cooperate booking a personal profile also will be sent */
        if ($input_data['data']['personalProfileTp'] != '-') {
            $customerProfile2 = $this->customer_dao->getCustomer($input_data['data']['personalProfileTp']);
            $input_data['data']['profileLinks'][] = $customerProfile2['_id'];
        }

        $this->live_dao->createBooking($input_data["data"]);
        $this->customer_dao->addTotalJob($input_data["tp"]);

        $bookingCreated = $this->live_dao->getBooking($input_data['data']['refId']);
        $bookingObjId = array('_id' => $bookingCreated['_id']);
        /* Add the booking array to the customer collection */
        $this->customer_dao->addBooking($input_data["tp"], $bookingObjId);
        if(isset($customerProfile2)){
            $this->customer_dao->addBooking($customerProfile2['tp'],$bookingObjId);
        }

        $counterHireName = $user['userId'] . '-hires';
        $counterActiveName = $user['userId'] . '-activeCalls';
        $isNewDay = $this->call_dao->isNewDay();
        /* Reset all the counter to zero if it is a new day */
        if($isNewDay){

            $this->counters_dao->resetNextId("answeredCalls");
            $this->counters_dao->resetNextId("missedCalls");
            $this->counters_dao->resetNextId("activeCalls");
            $this->counters_dao->resetNextId("totalHires");
            $this->counters_dao->resetNextId($counterHireName);
            $this->counters_dao->resetNextId($counterActiveName);

        }else{
            if($input_data["data"]["sessionFirstBooking"] == "true" ){
                $this->counters_dao->getNextId("activeCalls");
                $this->counters_dao->getNextId($counterActiveName);
            }
            $this->counters_dao->getNextId("totalHires");
            $this->counters_dao->getNextId($counterHireName);
        }

        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg, 'tp' => $input_data["tp"] ,
                                    'refId' => $input_data["data"]["refId"])));

    }

    public function sendBookingDetails(){
        $statusMsg = 'true';
        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $customerProfile = $this->customer_dao->getCustomer($input_data['tp']);
        $bookingCreated = $this->live_dao->getBooking($input_data['refId']);

        $user = $this->session->userdata('user');

        if(isset($input_data['isSendWebSocket']) && $input_data['isSendWebSocket'] == 'true'){
            $webSocket = new Websocket('localhost', '5555', $user['userId']);
            $webSocket->send($bookingCreated, 'dispatcher1');
            $webSocket->send($bookingCreated, 'monitor1');
        }

        if(sizeof($customerProfile['history']) == 1){
            $welcomeMessage = 'Welcome to the Hao Family. Thank you for choosing us to be part of your journey. It is' .
                ' a privilege to serve you. Hao City Cabs : 2 888 888';
            $this->sendWelcomeMessage($customerProfile, $welcomeMessage);
        }
        $message = 'Your order has been confirmed. Date : '. date('jS-M-y', $bookingCreated['bookTime']->sec).
                ' Time :'. date('h:i a', $bookingCreated['bookTime']->sec).' Ref . No :' . $bookingCreated['refId'] . ' .';

        if($bookingCreated['callUpPrice'] != '0'){
            $message = $message . ' Call Up Price : ' . $bookingCreated['callUpPrice'];
        }
        $message = $message . ' ThankYou for calling Hao City Cabs : (011) 2 888 888.';
        $this->sendSms($bookingCreated, $message);
        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg, 'message' => $message , 'booking' => $bookingCreated , 'profile' => $customerProfile )));

    }

    function sendSms($bookingCreated, $message)
    {
        $sms = new Sms();
        foreach ($bookingCreated['profileLinks'] as $item) {
            $customerProfile = $this->customer_dao->getCustomerByMongoObjId($item);
            if ($customerProfile['tp'] != '-' && $customerProfile['type1'] != 'land') {
                $sms->send($customerProfile['tp'], $message);
            }
            if ($customerProfile['tp2'] != '-' && $customerProfile['type2'] != 'land') {
                $sms->send($customerProfile['tp2'], $message);
            }
        }
    }

    function sendWelcomeMessage($customerProfile , $welcomeMessage){
        $sms = new Sms();
        if ($customerProfile['tp'] != '-') {
            $sms->send($customerProfile['tp'], $welcomeMessage);
        }
        if ($customerProfile['tp2'] != '-') {
            $sms->send($customerProfile['tp2'], $welcomeMessage);
        }
    }

    public function canceled()
    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $user = $this->session->userdata('user');
        $bookingData = $this->live_dao->getBookingByMongoId($input_data['_id']);
        $bookingData['cancelUserId'] = $user['userId'];
        $bookingData['cancelTime'] = new MongoDate();
        $this->live_dao->updateBooking($input_data['_id'] ,  $bookingData );

        $result = $bookingData['status'];

        if ($bookingData != null) {

            if($result == 'START'){
                $this->live_dao->updateStatus($input_data['_id'], "CANCEL");
            } else {
                /* Adds +1 to the dis_cancel in customers collection */
                $this->customer_dao->addCanceledDispatch($input_data["tp"]);
                $this->live_dao->updateStatus($input_data['_id'], "DIS_CANCEL");
            }

            /* Adds +1 to the tot_cancel in customers collection */
            $this->customer_dao->addCanceledTotal($input_data["tp"]);
            /* Remove the record from live collection and add it to the history */
            $bookingData = $this->live_dao->getBookingByMongoId($input_data['_id']);
            $this->live_dao->deleteBookingByMongoId($input_data['_id']);
            /* Add removed booking from live to the history collection */
            $bookingData['cancelReason'] = $input_data['cancelReason'];
            $this->history_dao->createBooking($bookingData);


            if($input_data['sendSms'] == "true" ){
                $message = 'Your booking has been canceled. Sorry for the inconvenience. Ref.No : ' . $bookingData['refId'] .
                    '.Cancel Reason : ' .$bookingData['cancelReason']. '. Thank You for calling Hao City Cabs : 2 888 888';

                $this->sendSms($bookingData, $message);
            }
//
//            /* Send the canceled booking to the dispatch view */
//
            $webSocket = new Websocket('localhost', '5555', $user['userId']);
            $webSocket->send($bookingData, 'monitor1');
            $webSocket->send($bookingData, 'dispatcher1');

        }
        $this->output->set_output(json_encode(array("statusMsg" => "success")));
    }

    public function updateBooking()
    {

        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $user = $this->session->userdata('user');

        $input_data["data"]["bookTime"] = new MongoDate(strtotime($input_data['data']['bDate'] . " " . $input_data["data"]['bTime']));
        /* Unset the values of bDate and bTime */
        unset($input_data['data']['bTime']);
        unset($input_data['data']['bDate']);

        $this->live_dao->updateBooking($input_data["_id"], $input_data["data"]);
        $bookingData = $this->live_dao->getBookingByMongoId($input_data['_id']);

        /* Send the updated booking to the dispatch view */
        $webSocket = new Websocket('localhost', '5555', $user['userId']);
        $webSocket->send($bookingData, 'monitor1');
        $webSocket->send($bookingData, 'dispatcher1');
        $this->output->set_output(json_encode(array("statusMsg" => "success")));

    }


    public function getBookingByRefTown()
    {
        $statusMsg = 'success';
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $bookings_town = $this->live_dao->getBookingByTown($input_data["town"]);
        if($bookings_town != null){
            $statusMsg = 'fail';
        }
        $data['edit_booking_view'] = $this->load->view('cro/edit_booking', $bookings_town, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg , "view" => $data)));
    }

    public function addInquireCall()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->live_dao->addInquireCall($input_data["objId"]);
        $bookingCreated = $this->live_dao->getBookingByMongoId($input_data["objId"]);

        $user = $this->session->userdata('user');

        $webSocket = new Websocket('localhost', '5555', $user['userId']);
        $webSocket->send($bookingCreated, 'dispatcher1');
        $webSocket->send($bookingCreated, 'monitor1');

        $this->output->set_output(json_encode(array("statusMsg" => "success" , 'booking' => $bookingCreated)));
    }

    public function addCustomerToCooperateProfile()
    {
        $status = true;
        $message = "Number Inserted";
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $cooperateProfile = $this->customer_dao->getCustomer($input_data["tp"]);
        $personalProfile = $this->customer_dao->getCustomer($input_data["userTp"]);

        if ($personalProfile != null) {
            $customerObjId = array('_id' => $personalProfile['_id']);

            if(isset($cooperateProfile['personalProfiles'])){
                foreach($cooperateProfile['personalProfiles'] as $item){
                    if($item == $customerObjId ){
                        $status = false;
                        $message = 'Number Already Exists';
                        break;
                    }
                }
            }

            if($status){
                $cooperateProfile['personalProfiles'][] = $customerObjId;
                $this->customer_dao->updateCustomer($input_data["tp"], $cooperateProfile);
            }
        }else{
            $status = false;
            $message = "Number Does Not Exist";
        }
        $this->output->set_output(json_encode(array("status" => $status , "message" => $message)));
    }
}
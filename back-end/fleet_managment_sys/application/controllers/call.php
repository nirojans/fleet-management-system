<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Call extends CI_Controller
{

    public function index()
    {

    }


    function getLiveCalls()
    {

        $calls = $this->call_dao->getLiveCalls();
        $this->output->set_output(json_encode($calls));

    }

    function callDump()
    {
        $postData = $this->input->post();
        $this->call_dao->addToCallDump($postData);
    }

    function modemData(){

        $postData = $this->input->post();
        $state = array_keys($postData)[0];
        $csvCallArray = str_getcsv($postData[$state]);
//        var_dump(trim($csvCallArray[1]));

//        $this->call_dao->addToCallDump($postData);

        $numberreplaced  = str_replace(array("\\r", "\\n"), "", $csvCallArray[1]);
        $today = date("Y-m-d h:ia");
        $todayUTC = new MongoDate(strtotime($today));

        $dbData = array(
            'number' => trim($numberreplaced),
            'ext' => (int)trim($csvCallArray[2]),
            'time' => $todayUTC,
            'reference' => explode(" ",$csvCallArray[5])[3],
            'rawData' => $postData[$state]
        );

        $this->call_dao->createCall($dbData);

        $webSocket = new Websocket('localhost', '5555', 'pabx');
        $webSocket->send($dbData, 'cro1');

        echo "ok";
    }



    function pabxData()
    {
        $postData = $this->input->post();
        $state = array_keys($postData)[0];

        $today = date("Y-m-d h:ia");

        $csvCallArray = str_getcsv($postData[$state]);
//        var_dump($csvCallArray);

        /*        $callInfo = array(
                    "state" => $state,
                    "phone_number" => trim($csvCallArray[7]),
                    "date" => new MongoDate(strtotime($today)),
                    "parameter1" => $csvCallArray[2],
                    "extension_number" => trim($csvCallArray[6]),
                    "raw_data" => $postData[$state]
                );*/

        $counter = 1;
        $valueArray = array();
        $valueArray[0] = $state;
        foreach($csvCallArray as $csvalue){
            $counter++;
            if($csvalue != "" && $csvalue != " "){
                $valueArray[$counter] = $csvalue;
            }


        }
        //Data Structure
        /*
                "2" : "Incoming",
                "3" : "0329312121845",
                "5" : "06/12/2014",
                "6" : "12:17 ",
                "8" : "0779823445",
                "9" : "Missed Call",
                "12" : "\\\"submit\\\"",
                "13" : "\\\"POST\\\" /",
                "14" : "controller"

                "2" : "Incoming",
                "3" : "064012124316",
                "5" : "06/12/2014",
                "6" : "12:42 ",
                "7" : "14 ",
                "8" : "0112696948",
                "9" : "00:01:08",
                "12" : "\\\"submit\\\"",
                "13" : "\\\"POST\\\" /",
                "14" : "controller"

                "2" : "Outgoing",
                "3" : "0925312125027",
                "5" : "06/12/2014",
                "6" : "12:49 ",
                "7" : "16 ",
                "8" : "0112696948",
                "9" : "00:00:24",
                "12" : "\\\"submit\\\"",
                "13" : "\\\"POST\\\" /",
                "14" : "controller"

                "2" : " 0112077333\\r\\n",
                "3" : "11",
                "4" : "12:03:01 PM",
                "5" : "12/6/2014",
                "6" : "SmartConnet Reference : 210121231",
                "8" : "\\\"submit\\\"",
                "9" : "\\\"POST\\\" />\"
            */
        $callState = null;
        //Deduce Call State: Live,AnsweredEnded, Missed, Outgoing
        if($valueArray[10] == "Missed Call"){
            $callState = "Missed";
        }
        else if($state == "Incoming_Call"){
            $callState = "Live";
        }
        else if($state == "Incoming" && $valueArray[10] != "Missed Call"){
            $callState = "AnsweredEnded";
        }
        else if($state == "Outgoing"){
            $callState = "Outgoing";
        }
        else{
            $callState = "Garbage";
        }

        $callInfo = null;
        if($callState == "Live"){
            $callInfo = array(
                "state" => $callState,
                "phone_number" =>trim($valueArray[3]),
                "date" => new MongoDate(strtotime($today)),
                "duration" => null,
                "extension_number" => (int)trim($valueArray[4]),
                "raw_data" => $postData[$state]
            );
        }
        else if($callState == "Missed"){
            $callInfo = array(
                "state" => $callState,
                "phone_number" =>$valueArray[9],
                "date" => new MongoDate(strtotime($today)),
                "duration" => null,
                "extension_number" => null,
                "raw_data" => $postData[$state]
            );

            $isNewDay = $this->call_dao->isNewDay($callInfo);
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
            }else{
                $this->counters_dao->getNextId("missedCalls");
            }


        }
        else if($callState == "AnsweredEnded"){
            $callInfo = array(
                "state" => $callState,
                "phone_number" =>$valueArray[9],
                "date" => new MongoDate(strtotime($today)),
                "duration" => $valueArray[10],
                "extension_number" => (int)trim($valueArray[8]),
                "raw_data" => $postData[$state]
            );

            $isNewDay = $this->call_dao->isNewDay($callInfo);
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
            }else{
                $this->counters_dao->getNextId("answeredCalls");
            }
        }
        else if($callState == "Outgoing"){
            $callInfo = array(
                "state" => $callState,
                "phone_number" =>$valueArray[9],
                "date" => new MongoDate(strtotime($today)),
                "duration" => $valueArray[10],
                "extension_number" => (int)trim($valueArray[8]),
                "raw_data" => $postData[$state]
            );
        }
        else {
            $callInfo = array(
                "state" => $callState,
                "raw_data" => $postData[$state]
            );
        }

        if($callState != "Garbage" ) {
            $result = $this->customer_dao->getCustomer($callInfo['phone_number']);
            /* If there is a customer record exists only input */
            if($result != null){
                $result['call_history'][] = array('callTime' => $callInfo['date'],
                    'extension_number' => $callInfo['extension_number'],
                    'state' => $callInfo['$callState'],
                    'duration' => $callInfo['duration']);
                $this->customer_dao->updateCustomer($callInfo['phone_number'], $result);
            }
        }

        $this->call_dao->addToCallDump($callInfo);
        /*$webSocket = new Websocket('localhost', '5555', 'pabx');
        $webSocket->send($callInfo, 'cro1');
        $this->call_dao->createCall($callInfo);*/

    }

    function getCallsInLastSeconds(){

        $calls = $this->call_dao->getCallsInLastSeconds();
        $this->output->set_output(json_encode($calls));

    }
}
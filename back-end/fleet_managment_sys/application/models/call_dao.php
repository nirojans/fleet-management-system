<?php
/**
 *  @property Cab_dao $Cab_dao
 */
class Call_dao extends CI_Model
{

    function __construct()
    {

    }


    function get_collection($collection = 'calls')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;
    }

    function createCall($callArray)
    {

        $collection = $this->get_collection();

        $statusMsg = true;
        $collection->insert($callArray);

        return $statusMsg;
    }


    function getLiveCalls(){

        $collection = $this->get_collection();
        $searchQuery = array("state" => "LIVE");
        $cursor = $collection->find($searchQuery);
        $callArray = array();
        foreach ($cursor as $doc) {
            array_push($callArray,$doc);
        }
        return $callArray;
    }

    function addToCallDump($totalCallArray){
        $collection = $this->get_collection('call_dump');
        $collection->insert($totalCallArray);
    }


    function getCallsInLastSeconds(){

        $collection = $this->get_collection();
        //$SecondsBeforeNow = strtotime("now")-150;
        $SecondsBeforeNowinMongo = new MongoDate(strtotime("-2 minutes"));
        $cursor =$collection->find(array('time'=> array('$gte' => new MongoDate(strtotime("-2 minutes")))));
        $callArray = array();
        foreach ($cursor as $doc) {
            array_push($callArray,$doc);
        }
        return $callArray;
    }
    
    function get_missed_calls_today()
    {
        $collection = $this->get_collection('call_dump');
        $missed_calls = array();
        $today = new MongoDate(strtotime(date("y-m-d")));
        $searchQuery = array('state' => "Missed",'date' => array('$gt' => $today));
        $feilds = array('phone_number' => true, 'date' => true);
        $missed_calls_cursor = $collection->find($searchQuery,$feilds);
        foreach($missed_calls_cursor as $missed_call){$missed_calls[] = $missed_call;}
        return $missed_calls;
    }
    
    function get_all_missed_calls()
    {
        $collection = $this->get_collection('call_dump');
        $missed_calls = array();        
        $searchQuery = array('state' => "Missed");
        $feilds = array('phone_number' => true, 'date' => true);
        $missed_calls_cursor = $collection->find($searchQuery,$feilds);
        foreach($missed_calls_cursor as $missed_call){$missed_calls[] = $missed_call;}
        return $missed_calls;
    }
    function get_all_missed_calls_by_date($date)
    {
        $collection = $this->get_collection('call_dump');
        $missed_calls = array();
        $date_needed = new MongoDate(strtotime($date));//new MongoDate(strtotime(date("y-m-d")));
        $next_day = new MongoDate(($date_needed->sec + 86400));//var_dump($next_day);
        $searchQuery = array('state' => "Missed",'date' => array('$gt' => $date_needed, '$lt' => $next_day));
        $feilds = array('phone_number' => true, 'date' => true);
        $missed_calls_cursor = $collection->find($searchQuery,$feilds);
        foreach($missed_calls_cursor as $missed_call){$missed_calls[] = $missed_call;}
        return $missed_calls;
    }

    function isNewDay(){

        $collection = $this->get_collection("callStat");
        $result = $collection->findOne(array("reference" => "nextDay"));
        $nextDay = date('Y-m-d 00:00:00', strtotime(' +1 day'));
        $test = date('Y-m-d 00:00:00', strtotime(' +3 day'));

        if($result == null){
            $data = array("reference" => "nextDay" , "timeStamp" => new MongoDate(strtotime($nextDay)));
            $collection->insert($data);
            return true;
        }else{
            $isNewDay = $collection->findOne(array("reference" => "nextDay" ,
                                                    "timeStamp" => array('$lt'=>new MongoDate())));
            if($isNewDay != null){
                $isNewDay['timeStamp'] =  new MongoDate(strtotime($nextDay));
                $collection->save($isNewDay);
                return true;
            }
            else
                return false;
        }

    }

}
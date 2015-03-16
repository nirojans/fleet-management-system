<?php
/**
 *  @property Cab_dao $Cab_dao
 */
class Cab_dao extends CI_Model
{

    function __construct()
    {

    }

    
    function get_collection($collection = 'cabs')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;
    }
    function createCab($cabArray){
        
        $collection = $this->get_collection();

        $statusMsg = true;
        $record = $collection->findOne(array("cabId" => $cabArray['cabId']));

        if( $record == null) {
            $cabArray["state"] = "IDLE";
            $cabArray["zone"] = "None";

            $collection->insert($cabArray);
        }
        else $statusMsg=false;

        return $statusMsg;
    }

    function deleteCab($cabId)
    {
        $collection = $this->get_collection();
        $searchQuery= array('cabId' => (int)$cabId);
        $collection->remove($searchQuery);
        $record = $collection->findOne($searchQuery);
        if( $record == null){ $statusMsg=true;}
        else {$statusMsg = false;}
        return $statusMsg;
    }
    function getCabIds()
    {
        $collection = $this->get_collection();
        $cursor = $collection->find();

        $cabIds= array();
        foreach ($cursor as $cab) {
            $cabIds[]= $cab['cabId'];
        }

        return $cabIds;
    }

    function deleteCabDriver($driverId){
        $collection = $this->get_collection();
        $cabArray = array('userId' => '-1');
        $searchQuery= array('userId' => $driverId);
        //$record = $collection->findOne($searchQuery);
        $collection->update($searchQuery,array('$set' => $cabArray));

    }

    function updateCab($cabId , $cabArray){
        
        $driverId = $cabArray['userId'];
        $collection = $this->get_collection();
        
        $searchQuery= array('cabId' => $cabId);
        $this->find_and_release_cab_by_driverId($driverId, $collection);
        //$record = $collection->findOne($searchQuery);
        $collection->update($searchQuery,array('$set' => $cabArray));

//        foreach ($cabArray as $key => $value){
//            $record[$key] = $cabArray[$key];
//        }
//
//        $collection->save($record);

    }
    
    function find_and_release_cab_by_driverId($driverId,$collection)
    {//$this->debug_to_console("in function : find_and_release_cab_by_driverId() ");
        $searchQuery = array('userId' => $driverId );
        $record = $collection->findOne($searchQuery);
        if($record != null)
            {
                $details_to_be_edited = array('$set' => array('userId' => -1));
                $collection->update($searchQuery,$details_to_be_edited);
            }
    }
    
    function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}

    function get_unassigned_cabs()
    {
        $collection = $this->get_collection();
        $searchQuery = array('userId' => -1);
        $unassigned_cabs = $collection->find($searchQuery,array('cabId' => true,'plateNo' => true, 'vType' => true));
        return $unassigned_cabs;
    }
    
    function get_assigned_cabs()
    {
        $collection = $this->get_collection();
        $searchQuery = array('userId' => array('$nin'=> array(-1)));//array(-1) - the '-1' should be given as an array
        $assigned_cabs = array();
        $assigned_cabs_cursor = $collection->find($searchQuery);
        foreach($assigned_cabs_cursor as $cab){$assigned_cabs[] = $cab;}
        return $assigned_cabs;
    }
    
    function  getCab($cabId){
        
        $collection = $this->get_collection();
        $searchQuery= array('cabId' => (int)$cabId);
        $cab = $collection->findOne($searchQuery);

        $driver = $this->user_dao->getDriverByCabId((int)$cab['cabId']);
        if($driver['callingNumber'] != null){
            $cab['callingNumber'] = $driver['callingNumber'];
        }
        else{
            $cab['callingNumber'] = -1;
        }
        $cab['logSheetNumber'] = $driver['logSheetNumber'];
        $cab['driverId'] = $driver['userId'];

        return $cab;
    }

    function getAllCabs(){

        $collection = $this->get_collection();

        $cursor = $collection->find();
        $sorted_cursor = $cursor->sort(array('cabId' => 1));
        $data= array();
        foreach ($sorted_cursor as $doc) {
            $data[]= $doc;
        }
        return $data;
    }

    function getCabsInZones(){
        $allCabs = $this->getAllCabs();

        $data = array();
        foreach ($allCabs as $cab) {
            $driver = $this->user_dao->getDriverByCabId((int)$cab['cabId']);
            if($driver['callingNumber'] != null){
                $cab['callingNumber'] = $driver['callingNumber'];
            }
            else{
                $cab['callingNumber'] = -1;
            }
            $cab['logSheetNumber'] = $driver['logSheetNumber'];
            $cab['driverId'] = $driver['userId'];
            array_push($data,$cab);
        }
        return $data;
    }


    function getCabsByPage($limit,$skip){

        $collection = $this->get_collection();

        $cursor = $collection->find()->limit($limit)->skip($skip);
        $sorted_cursor = $cursor->sort(array('cabId' => 1));
        $data= array('data' => array());
        foreach ($sorted_cursor as $doc ) {
            $data['data'][]= $doc;
        }
        return $data;
    }

    function getCabByPlate($noPlate){
        
        $collection = $this->get_collection();

        $searchQuery = array('noPlate' => $noPlate);
        return $collection->findOne($searchQuery);
    }

    function getVehicleType($cabId){
        
        $collection = $this->get_collection();

        $searchQuery = array('cabId'=> $cabId);
        $record = $collection->findOne($searchQuery);

        return $record['vType'];
    }


    function setZone($cabId , $zone){
        
        $collection = $this->get_collection();
        
        $searchQuery= array('cabId' => (int)$cabId);

        $collection->update($searchQuery ,array('$set' => array('zone' => $zone)),array('new' => true));
        return $collection->findOne($searchQuery);

    }

    function setState($cabId,$state){
        
        $collection = $this->get_collection();
        
        $searchQuery= array('cabId' => (int)$cabId);
        $collection->update($searchQuery ,array('$set' => array('state' => $state)),array('new' => true));
        return $collection->findOne($searchQuery);

    }


    function setPobDestinationZoneTime($cabId , $zone, $eta){
        
        $collection = $this->get_collection();
        
        $searchQuery= array('cabId' => (int)$cabId);
        $this->setState($cabId,'POB');
        $this->setZone($cabId,$zone);
        $collection->update($searchQuery ,array('$set' => array('eta' => $eta)),array('new' => true));
        return $collection->findOne($searchQuery);

    }

    function find($query, $attribute = 'cabId')
    {
        $collection = $this->get_collection();
        if($attribute == 'cabId'){
            $result = $collection->find(array($attribute => (int)$query));  //, "feature_code" => array('$in' => array("PPL","PPLL","PPLX"))
        }
        else{
            $result = $collection->find(array($attribute => new MongoRegex('/' . $query . '/i')));  //, "feature_code" => array('$in' => array("PPL","PPLL","PPLX"))
        }
        $result->limit(10);

        $return = array();
        $i = 0;
        while ($result->hasNext()) {

            $return[$i] = $result->getNext();
            $return[$i++]['_id'] = $result->key();
        }
        return json_encode($return);
    }

    function getCabsByState($state = "IDLE"){

        $collection = $this->get_collection();
        $searchQuery= array('state' => $state);
        return $collection->find($searchQuery);

    }

}
<?php
class Customer_dao extends CI_Model
{

    function __construct()
    {

    }

    function get_collection($collection = 'customers')
    {

        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;
    }

   /*
   * creates a new customer record in the customers collection
   * @keys in the customerArray {"telephone" => "", type => "", "Name" => "", "title" => "", "designation" => "" }
   */
    function createCustomer($customerArray){

        $collection = $this->get_collection();
        $statusMsg = true;

        if($collection->findOne(array("tp" => $customerArray["tp"]))==null)
        $collection->insert($customerArray);
        else $statusMsg=false;

        return $statusMsg;
    }

    /*
    * Adds a new booking entry to the history array in the customer collection
    * @parameters $tp= customer tp number $booking = {'id'=>'', 'status' => '', address : {}}
    */
    function addBooking($tp , $booking){

        $collection = $this->get_collection();
        $searchQuery = array('tp' => $tp);
        $result = $collection->findOne($searchQuery);

        if($result == null){
            $searchQuery = array('tp2' => $tp);
        }
        $collection->update($searchQuery, array('$push' => array("history" => $booking)));
    }


    /*
    * @method add +1 to the dispatch_cancel in the customers collection
    */
    function addCanceledDispatch($tp){

        $collection = $this->get_collection();
        $searchQuery= array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        if($record == null){
            $searchQuery = array('tp2' => $tp);
            $record = $collection->findOne($searchQuery);
        }

        /* If a record doesn't exist create new else update*/
        if(!isset($record['dis_cancel'])){
            $record["dis_cancel"] = 1;
        }
        else {
            $record["dis_cancel"]++;
        }
        $collection->save($record);
    }

    /*
     * @method add +1 to the cancel_tot in the customers collection
     */
    function addCanceledTotal($tp){

        $collection = $this->get_collection();
        $searchQuery= array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        if($record == null){
            $searchQuery = array('tp2' => $tp);
            $record = $collection->findOne($searchQuery);
        }

        /* If a record doesn't exist create new else update*/
        if(!isset($record['tot_cancel'])){
            $record["tot_cancel"] = 1;
        }
        else {
            $record["tot_cancel"]++;
        }
        $collection->save($record);
    }

    /*
     * @method add +1 to the total job
     */
    function addTotalJob($tp){

        $collection = $this->get_collection();
        $searchQuery= array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        if($record == null){
            $searchQuery = array('tp2' => $tp);
            $record = $collection->findOne($searchQuery);
        }

        /* If a record doesn't exist create new else update*/
        if(!isset($record['tot_job'])){
            $record["tot_job"] = 1;
        }
        else {
            $record["tot_job"]++;
        }
        $collection->save($record);
    }

    function addCallTime($tp){

        $collection = $this->get_collection();
        $searchQuery= array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        if($record == null){
            $searchQuery = array('tp2' => $tp);
            $record = $collection->findOne($searchQuery);
        }

        /* If a record doesn't exist create new else update*/
        if(!isset($record['callTime'])){
            $record["tot_job"] = 1;
        }
        else {
            $record["tot_job"]++;
        }
        $collection->save($record);
    }

    /*
     * @returns similar tp numbers that matches the input
     */
    function getSimilar($tp){

        $collection = $this->get_collection();
        $regex = new MongoRegex("/^$tp/i");
        $cursor = $collection->find(array('tp' => $regex));
        $data= array();
        $int = 0;
        foreach ($cursor as $doc) {
            $data[$int]= $doc["tp"];
            $int++;
        }
        return $data;
    }

    function getSimilarNames($name){

        $collection = $this->get_collection();
        $result= $collection->find(array("name" => new MongoRegex('/' . $name . '/i')));
        $result->limit(20);
        $data= array();
        foreach ($result as $doc) {
            $data['data'][]= $doc;
        }
        return $data;
    }




    /*
    * @returns null if record doesn't exist , if exist sends the first record
    */
    function getCustomer($tp){

        $collection = $this->get_collection();
        $searchQuery = array('tp' => $tp);
        $result = $collection->findOne($searchQuery);

        if($result == null){
            $searchQuery = array('tp2' => $tp);
            $result = $collection->findOne($searchQuery);
        }

        return $result;
    }

    /*
* @returns null if record doesn't exist , if exist sends the first record
*/
    function getCustomerByObjId($objId){

        $collection = $this->get_collection();
        $searchQuery= array('_id' => new MongoId($objId));
        return $collection->findOne($searchQuery);
    }


/*
* @returns null if record doesn't exist , if exist sends the first record
*/
    function getCustomerByMongoObjId($mongoObjId){

        $collection = $this->get_collection();
        $searchQuery= array('_id' => $mongoObjId);
        return $collection->findOne($searchQuery);
    }

    /*
     *@Returns the status of a given order
     */
    function getBooking( $tp , $refId){

        $collection = $this->get_collection();
        $searchQuery = array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        $stat=array("index" => -1 , "found" => false);
        $stat= $this->getIndex($record , $refId, $stat);

        return $record["history"][$stat["index"]];
    }

    /*
    * @method updates the customer information
    * {"tp" => "", type => "", "Name" => "", "title" => "", "designation" => "" }
    * DO NOT UPDATE THE HISTORY[ORDERS] WITH THIS METHOD
    */
    function updateCustomer($tp , $data){

        $collection = $this->get_collection();
        $searchQuery= array('tp' => $tp);
        $record = $collection->findOne($searchQuery);

        if($record == null){
            $searchQuery= array('tp2' => $tp);
            $record = $collection->findOne($searchQuery);
        }

        foreach ($data as $key => $value){
            $record[$key] = $data[$key];
        }

        $collection->save($record);
    }

    /*
    * @Method Returns the array index for the customer order id [ref_id]
    */
    function getIndex($record ,$refId , $stat )
    {

        foreach ($record as $key => $value)
        {
            if (is_array($value) && $stat["found"]==false)

                $stat = $this->getIndex($value,$refId,$stat);
            else {

                if($key == "refId") {
                    $stat["index"]++;
                    if($record[$key] == $refId){
                        $stat["found"]=true;
                    }
                }
            }

        }
        return $stat;
    }
}



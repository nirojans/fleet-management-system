<?php
class Log_dao extends CI_Model
{

    function __construct()
    {

    }

    function get_collection($collection = 'logs')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;

    }

    function createLog($input_data){
        $collection = $this->get_collection();
        $collection->insert($input_data);
        return;
    }

    function getCallingNumberByDate($date,$driverId){
        $collection = $this->get_collection();
        $searchQuery = array('userId' => $driverId,'date' => $date ,'user_type' => 'driver', 'log_type' => 'login' );
        $log = $collection->findOne($searchQuery);
        return $log;
    }

    function getLoginByDate($date){
        $collection = $this->get_collection();
        $searchQuery = array('date' => $date ,'user_type' => 'driver', 'log_type' => 'login' );
        $log = $collection->find($searchQuery);
        return $log;
    }

    function getLoginByDateRange($start,$end){
        $collection = $this->get_collection();
        $searchQuery = array('time' => array('$gt' => $start, '$lte' => $end) ,'user_type' => 'driver', 'log_type' => 'login' );
        $log = $collection->find($searchQuery);
        return $log;
    }

    function getLoginByDateRangeAndDriver($start,$end,$driverId){
        $collection = $this->get_collection();
        $searchQuery = array('time' => array('$gt' => $start, '$lte' => $end) ,'userId' => new MongoInt32($driverId),'user_type' => 'driver', 'log_type' => 'login' );
        $log = $collection->find($searchQuery);
        return $log;
    }

    function getLogoutForLogin($date,$driverId){
        $collection = $this->get_collection();
        $searchQuery = array('userId' => $driverId,'date' => $date ,'user_type' => 'driver', 'log_type' => 'failed' );
        $log = $collection->findOne($searchQuery);
        return $log['time'];
    }

    function getLogoutByDate($date,$driverId){
        $collection = $this->get_collection();
        $searchQuery = array('userId' => $driverId,'date' => $date ,'user_type' => 'driver', 'log_type' => 'logout' );
        $log = $collection->findOne($searchQuery);
        return $log;
    }

    function updateCallingNumber($date,$driverId,$callingNo){
        $collection = $this->get_collection();
        $searchQuery = array('userId' => $driverId,'date' => $date ,'user_type' => 'driver','logged_out' => 'no');
        $collection->update($searchQuery,array('$set' => array('callingNumber' => new MongoInt32($callingNo))),array('multiple' => true));
    }

    function updateLogSheetNumber($date,$driverId,$logSheetNo){
        $collection = $this->get_collection();
        $searchQuery = array('userId' => $driverId,'date' => $date ,'user_type' => 'driver','logged_out' => 'no');
        $collection->update($searchQuery,array('$set' => array('logSheetNumber' => new MongoInt32($logSheetNo))),array('multiple' => true));
    }

    function updateLoginOnLogout($date,$time,$driverId){
        $collection = $this->get_collection();
        $searchQuery = array('userId' => $driverId,'user_type' => 'driver','logged_out' => 'no'); //remove the date here if date is a problem
        $collection->update($searchQuery,array('$set' => array('logged_out' => 'yes','logout_time' => $time)),array('multiple' => true));
    }



}
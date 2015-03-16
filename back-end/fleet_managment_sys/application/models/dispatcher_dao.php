<?php
class Dispatcher_dao extends CI_Model
{

    function __construct()
    {

    }

    function createDispatcher($dispatcherArray){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('dispatcher');

        $statusMsg = true;
        $record = $collection->findOne(array("dispatcherId" => $dispatcherArray['dispatcherId']));

        if( $record == null)
            $collection->insert($dispatcherArray);
        else $statusMsg=false;

        return $statusMsg;
    }

    function getDispatcher($dispatcherId){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('dispatcher');

        $searchQuery = array('dispatcherId' => $dispatcherId);
        return $collection->findOne($searchQuery);
    }

    function getAllDispatchers(){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('dispatcher');

        $cursor = $collection->find();
        $data= array();
        foreach ($cursor as $doc) {
            $data[]= $doc;
        }

        return $data;
    }

    function getDriverByCabId(){

    }

    function getDispatchersByPage($limit,$skip){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('dispatcher');

        $cursor = $collection->find()->limit($limit)->skip($skip);
        $data= array('data' => array());
        foreach ($cursor as $doc ) {
            $data['data'][]= $doc;
        }
        return $data;
    }

    function authenticate($userName , $pass ){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('dispatcher');

        return $collection->findOne(array("uName" => $userName , 'pass' => $pass ));

    }

    function updateDispatcher($dispatcherId , $data){
        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $collection = $dbName->selectCollection('dispatcher');

        $searchQuery= array('dispatcherId' => $dispatcherId);
        $record = $collection->findOne($searchQuery);

        foreach ($data as $key => $value){
            $record[$key] = $data[$key];
        }

        $collection->save($record);
    }


}
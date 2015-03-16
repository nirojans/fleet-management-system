<?php

class Test_dao extends CI_Model
{
    function get_collection()
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection('cabs');
        return $collection;
        
    }
    
    function createUser($user_details)
    {
        $collection = $this->get_collection();
        $collection->insert($user_details);
    }
    
    function getUser($userId)
    {
        $collection = $this->get_collection();
        $query = array('userId' => $userId);
        $result = $collection->findOne($query);
        return $result;
    }
    
    function getAllUsers()
    {
        $collection = $this->get_collection();
        $cursor = $collection->find();
        $users= array();
        foreach ($cursor as $user)
        {
            $users[]= $user;
        }

        return $users;
    }
    function update_and_get_user($query, $edited_info)
    {
        $collection = $this->get_collection();
        //$query = array('userId' => $userId);
        $collection->update($query, array('$set' => $edited_info));
        $cursor = $collection->find();
        $users = array();
        foreach($cursor as $user)
            {
                $users[] = $user;
            }
         return $users;
    }
    function getUsersByPage_by_type($type)
    {
        $collection = $this->get_collection();
        echo $type;
        $user_type = array('user_type' => $type);
        $cursor = $collection->find();//$user_type
        $users= array('data' => array());
        foreach ($cursor as $user) 
        {
            $users['data'][]= $user;
        }
        return $users;
    }
    
    function updateCab($cabId , $cabArray){
        
        $driverId = $cabArray['userId'];//echo '<br>'.$driverId;
        $collection = $this->get_collection();
        
        $searchQuery= array('cabId' => $cabId);
        $record = $this->find_and_release_cab_by_driverId($driverId, $collection);
        return $record;
        //$record = $collection->findOne($searchQuery);
        //$collection->update($searchQuery,array('$set' => $cabArray));

//        foreach ($cabArray as $key => $value){
//            $record[$key] = $cabArray[$key];
//        }
//
//        $collection->save($record);

    }
    
    function find_and_release_cab_by_driverId($driverId,$collection)
    {//$this->debug_to_console("in function : find_and_release_cab_by_driverId() ");
        $searchQuery = array('userId' => $driverId );print_r($searchQuery);
        $record = $collection->findOne($searchQuery);print_r($record);
        return $record;
//        if($record != null)
//            {
//                $details_to_be_edited = array('$set' => array('driverId' => -1));
//                $collection->update($searchQuery,$details_to_be_edited);
//            }
    }
}
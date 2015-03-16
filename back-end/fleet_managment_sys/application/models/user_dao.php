<?php

class User_dao extends CI_Model
{

    function __construct()
    {

    }

    function get_collection($collection = 'users')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;

    }

    function createUser($user_details)
    {
        $collection = $this->get_collection();

        $statusMsg = true;
        $searchQuery = array('userId' => $user_details['userId']);
        $record = $collection->findOne($searchQuery);

        if ($record == null) {
            $collection->insert($user_details);
        } else {
            $statusMsg = false;
        }

        return $statusMsg;
    }

    function getUser($userId, $userType)
    {
        $collection = $this->get_collection();

        $searchQuery = array('userId' => (int)$userId, 'user_type' => $userType);
        // TODO: FTW ? parameter  name is userId and searching for uName while
        //there is an attribute for userId FK
        $user = $collection->findOne($searchQuery);
        return $user;
    }

    function getUserById($userId)
    {
        $collection = $this->get_collection();

        $searchQuery = array('userId' => (int)$userId);
        $user = $collection->findOne($searchQuery);
        return $user;
    }

    function deleteUser($userId)
    {
        $collection = $this->get_collection();
        $searchQuery = array('userId' => $userId);
        $collection->remove($searchQuery);
        $record = $collection->findOne($searchQuery);
        if ($record == null) {
            $statusMsg = true;
        } else {
            $statusMsg = false;
        }
        return $statusMsg;
    }

    //This function will be used if needed to get all user types
    function getAllUsers()
    {
        $collection = $this->get_collection();

        $cursor = $collection->find();
        $users = array();
        foreach ($cursor as $user) {
            $users[] = $user;
        }

        return $users;
    }

    //This function will be used if needed to get all user types, number of users limited to page size
    function getUsersByPage($limit, $skip)
    {
        $collection = $this->get_collection();

        $cursor = $collection->find()->limit($limit)->skip($skip);
        $users = array('data' => array());
        foreach ($cursor as $user) {
            $users['data'][] = $user;
        }
        return $users;
    }

    //This function is used to get all users of a certain type
    function getAllUsers_by_type($type)
    {
        $collection = $this->get_collection();

        $user_type = array('user_type' => $type);
        $cursor = $collection->find($user_type);
        $sorted_cursor = $cursor->sort(array('userId' => -1));
        $users = array('data' => array());
        foreach ($sorted_cursor as $user) {
            $users['data'][] = $user;
        }

        return $users;
    }

    function getUserIds_by_type($type)
    {
        $collection = $this->get_collection();

        $user_type = array('user_type' => $type);
        $cursor = $collection->find($user_type);
        $userIds = array();
        foreach ($cursor as $user) {
            $userIds[] = $user['userId'];
        }

        return $userIds;
    }

    //This function is used to get all users of a certain type, limited to page size
    function getUsersByPage_by_type($limit, $skip, $type)
    {
        $collection = $this->get_collection();

        $user_type = array('user_type' => $type);
        $cursor = $collection->find($user_type)->limit($limit)->skip($skip);//$user_type
        $sorted_cursor = $cursor->sort(array('userId' => 1));
        $users = array('data' => array());
        foreach ($sorted_cursor as $user) {
            $users['data'][] = $user;
        }
        return $users;
    }

    function authenticate($userName, $pass)
    {
        $collection = $this->get_collection();
        $searchQuery = array("uName" => $userName, 'pass' => $pass);
        $user = $collection->findOne($searchQuery);
        return $user;

    }

    function driverAuthenticate($driverId, $pass)
    {
        $collection = $this->get_collection();
        $searchQuery = array("userId" => (int)$driverId, 'pass' => $pass, "user_type" => "driver");
        $user = $collection->findOne($searchQuery);
        return $user;

    }

    /**
     * Returns the time after last login in hours
     * @param $userId
     * @param $timeStamp
     * @return array|null
     */
    function hoursAfterLastLogin($userId, $timeStamp)
    {
        $collection = $this->get_collection();
        $searchQuery = array('userId' => $userId);
        $user = $collection->findOne($searchQuery);
        $lastLogout = new MongoDate(strtotime($user['lastLogout']));
        $seconds_diff = $timeStamp - (float)$lastLogout->sec;
        $hour_diff = $seconds_diff / 3600;
        return $hour_diff;

    }


    /**log
     * sets The last Logout time
     * @param $userId
     * @param $timeStamp
     */
    function setLastLogout($userId, $timeStamp)
    {
        $collection = $this->get_collection();
        $searchQuery = array('userId' => new MongoInt32($userId));
        $collection->update($searchQuery, array('$set' => array('lastLogout' => $timeStamp)));

    }

    /**
     * Returns if user is able to logout or not
     * @param $driverId
     * @return array|null
     */
    function logout($driverId)//the variable $dirverId refers to the 'userId' atrribute of a single driver(user)
    {
        $collection = $this->get_collection();
        $searchQuery = array("userId" => new MongoInt32($driverId), 'isLogout' => false); // Need to be a login user to logout
        $user = $collection->findOne($searchQuery);
        return $user;

    }

    function status($driverId)//the variable $dirverId refers to the 'userId' atrribute of a single driver(user)
    {
        $collection = $this->get_collection();
        $searchQuery = array("userId" => new MongoInt32($driverId), 'logout' => true);
        $user = $collection->findOne($searchQuery);
        return $user;

    }

    function updateUser($userId, $edited_data)
    {
        $collection = $this->get_collection();

        $searchQuery = array('userId' => (int)$userId);
        $collection->update($searchQuery, array('$set' => $edited_data));
        //$user = $collection->findOne($searchQuery);

//        foreach ($edited_data as $key => $value)
//        {
//            $user[$key] = $edited_data[$key];
//        }
//
//        $collection->save($user);
    }

    //Special functions
    function getDriverByCabId($cabId)
    {
        $collection = $this->get_collection();
        $searchQuery = array('cabId' => (int)$cabId, 'user_type' => 'driver');
        $user = $collection->findOne($searchQuery);

        $collection = $this->get_collection('cabs');
        $searchQuery = array('cabId' => (int)$cabId);
        $cab = $collection->findOne($searchQuery);
//        $user['cab'] = $cab;

        return $user;

    }

    /**
     * sets The last Logout time
     * @param $userId
     * @internal param $timeStamp
     */
    function setDriverCallingNumberMinus($userId)
    {
        $collection = $this->get_collection();
        $searchQuery = array('userId' => new MongoInt32($userId));
        $collection->update($searchQuery, array('$set' => array('callingNumber' => -1)));
    }


    function getCabByDriverId($driverId)
    {
        $collection = $this->get_collection();
        $searchQuery = array('userId' => (int)$driverId, 'user_type' => 'driver');
        $driver = $collection->findOne($searchQuery);

        $collection = $this->get_collection('cabs');
        $searchQuery = array('cabId' => (int)$driver['cabId']);
        $cab = $collection->findOne($searchQuery);
        $cab['driver'] = $driver;

        return $cab;
    }

    function getDriversSortedByCallingNumber()
    {
        $collection = $this->get_collection();
        $searchQuery = array('user_type' => 'driver', "callingNumber" => array('$ne' => -1)); // TODO: why need to have a calling number? "callingNumber" => array('$ne' => -1)
        $drivers = $collection->find($searchQuery)->sort(array("callingNumber", 1));
        return $drivers;


    }

 function setIsLogout($userId, $logoutStatus){
     $collection = $this->get_collection();
     $searchQuery = array('userId' => new MongoInt32($userId));
     $collection->update($searchQuery, array('$set' => array('isLogout' => $logoutStatus)));

 }

    function checkIsLogout($userId){
        $collection = $this->get_collection();
        $searchQuery = array("userId" => new MongoInt32($userId), 'isLogout' => true);
        $user = $collection->findOne($searchQuery);
        return $user;
    }


}
<?php
class Location_dao extends CI_Model
{
    function __construct(){
        $this -> db = new MongoClient();
    }
}
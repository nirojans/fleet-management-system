<?php

class Bigdata_dao extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->mongodb = new MongoClient();
        $this->history_data = $this->mongodb->tracking_history;
    }

    function stats(){
        $collection_stats = $this->history_data->command(array('collStats' => 'history'));
        return $collection_stats;
    }

    function history_today(){
        $this->history_data->history->find();
        /*db.history.find({id: 14,'properties.timeStamp': {"$lte": Date()}}).count()*/
    }

}

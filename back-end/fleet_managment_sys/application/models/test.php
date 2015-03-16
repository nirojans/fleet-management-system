<?php
class Test extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->mongodb = new MongoClient();
    }

    /**
     * @param $geoNameId Geoname ID of a location , This is the default primary key for the geo_names collection
     * Return the
     * @return array|null
     */
    function live(){
        $result =  $this->mongodb->geo_names->customer->find();

        $return = array();
        $i=0;
        while( $result->hasNext() )
        {

            $return[$i] = $result->getNext();
            $return[$i++]['_id'] = $result->key();
        }
        return $return;
    }

}
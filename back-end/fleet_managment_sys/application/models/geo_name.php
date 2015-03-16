<?php

class Geo_name extends CI_Model
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
     * sample:
     * {
     * "_id" : 1222722,
     * "feature_code" : "PPL",
     * "elevation" : "",
     * "name" : "Karunkandalvannakulam",
     * "dem" : "10",
     * "alternatenames" : "Karunkandalvannakulam,Vannakulam",
     * "asciiname" : "Karunkandalvannakulam",
     * "feature_class" : "P",
     * "location" : {
     * "type" : "Point",
     * "coordinates" : [
     * 80.0145,
     * 8.90928
     * ]
     * }
     * }
     * @return JSON encoded string
     */
    function find($query)
    {
        $result = $this->mongodb->track->geo_names->find(array("name" => new MongoRegex('/' . $query . '/i')));  //, "feature_code" => array('$in' => array("PPL","PPLL","PPLX"))
        $result->limit(10);

        $return = array();
        $i = 0;
        while ($result->hasNext()) {

            $return[$i] = $result->getNext();
            $return[$i++]['_id'] = $result->key();
        }
        return json_encode($return);
    }

    function geoCode($query){
        $result = $this->mongodb->track->geo_names->find($query);
        $result->limit(10);

        $return = array();
        $i = 0;
        while ($result->hasNext()) {

            $return[$i] = $result->getNext();
            $return[$i++]['_id'] = $result->key();
        }
        return json_encode($return);
    }

}

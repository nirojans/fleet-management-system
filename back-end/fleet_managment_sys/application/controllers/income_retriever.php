<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Income_retriever extends CI_Controller
{
    public $percentage = 0.05;
    public function index()
    {
        //$this->insertRecord();
        $this->getFullBreakDown();
    }

    function getTodayIncome(){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $hisColl = $dbName->selectCollection('history');

        $dtToday = new DateTime(date('Y-m-d'). ''.date('H:i:s'), new DateTimeZone('UTC'));
        $tsTodat = $dtToday->getTimestamp();

        $dtYes = new DateTime(date('Y-m-d'). ''.date('00:00:00'), new DateTimeZone('UTC'));
        $tsYes = $dtYes->getTimestamp();

        $dtOrd = new DateTime(date('Y-m-d'). ''.date('01:00:00'), new DateTimeZone('UTC'));
        $tsOrd = $dtOrd->getTimestamp();

        $today = new MongoDate($tsTodat);
        $Ord = new MongoDate($tsOrd);
        $yesday = new MongoDate($tsYes);


        $data=array('endTime' => $Ord,'status' => 'end',
                    'cabId' => 1 , 'fee' => 500);
        $searchQuery= $data;
        $hisColl->insert($searchQuery);
        $revenue=0;
        $result = $hisColl->find(array("endTime" => array('$gt' => $yesday, '$lte' => $today), 'status' => 'end'));

        foreach($result as $key => $value){
            $vehicle = $this->cab_dao->getVehicleType($value['cabId']);
            var_dump($vehicle);
            if($vehicle == 'car' || $vehicle == 'van'){
                $revenue = $revenue+$value['fee'];
            }

        }
        $profit=$revenue*$this->percentage;
        var_dump($profit);
        var_dump($revenue);
    }


    function getFullBreakDown(){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $hisColl = $dbName->selectCollection('history');

        $startDT = new DateTime(date('Y-m-d'). ''.date('00:00:00'), new DateTimeZone('UTC'));
        $startTS = $startDT->getTimestamp();
        $start = new MongoDate($startTS);

        $endDT = new DateTime(date('Y-m-d'). ''.date('23:00:00'), new DateTimeZone('UTC'));
        $endTS = $endDT->getTimestamp();
        $end = new MongoDate($endTS);

        $result = $hisColl->find(array("endTime" => array('$gt' => $start, '$lte' => $end), 'status' => 'end'));
        var_dump($result);
        $driverDet=array();

        foreach($result as $key => $value){
            var_dump($value);

            if(!isset($driverDet[0])) {
                echo 'came';
                $driverDet[] = $value['driverId'];
                var_dump($driverDet);
            }
            else{
                var_dump($driverDet);

                foreach($driverDet as $dKey => $dValue){

                    if($dValue == $value['driverId']){
                        echo 'second';
                        $driverDet[] = $value['driverId'];
                        var_dump($driverDet);
                    }
                }
            }
        }
    }

    function insertRecord(){

        $connection = new MongoClient();
        $dbName = $connection->selectDB('track');
        $hisColl = $dbName->selectCollection('history');

        $bookDT = new DateTime(date('Y-m-d'). ''.date('1:00:00'), new DateTimeZone('UTC'));
        $bookTS = $bookDT->getTimestamp();
        $book = new MongoDate($bookTS);

        $insertQuery=array('endTime' => $book ,'status' => 'end', 'cabId' => 1 , 'fee' => 500 , 'driverId' => 2);
        $hisColl->insert($insertQuery);

    }


    /*
     * echo gmdate('Y-m-d H:i:s', strtotime('2014-10-13 08:15'));
     *$start = new MongoDate(strtotime(date("2014-10-13").' '.date("00:00:00" , time()+19800)));
        $end   = new MongoDate(strtotime(date("Y-m-d").' '.date("08:00:00" , time()+19800)));
     *
     */
}
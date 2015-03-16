<?php
/*
 * This controller is for testing purpose only ,
 * You may use this for check the log files,
 * do testing with Code Igniter or anything you wish but,
 * please make sure that no other controller or file make dependence on this controller
 * again this controller is ONLY FOR TESTING PURPOSE!!!!
 * */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start();

class Testing extends CI_Controller
{
    private $logPath; //path to the php log

    /**
     *   Class constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->logPath = ini_get('error_log');
        $this->load->model('geo_name');
        $this->load->model('live_dao');
        $this->mongodb = new MongoClient();
    }

    /**
     * index: Shows the php error log
     * @access public
     */
    public function debug()
    {

        $this->output->enable_profiler(TRUE);
//        show_error('message' , 500  );
//        log_message("info","hmmm");
//        print_r();
        $today = getdate();
        $test = function ($today) {
            return strlen($today['mday']) <= 1 ? '0' : '';
        };
        $logFile = "application/logs/log-" . $today['year'] . "-" . $today['mon'] . "-" . $test($today) . $today['mday'] . ".php";
        echo nl2br(@file_get_contents($logFile, false, null, (filesize($logFile) - 500 * 10)));
        exit;
    }


    function geo_names()
    {
        $POST = $this->input->get();
        $query = $POST['location'];
        $geo_names = $this->geo_name->find($query);
        header('Content-Type: application/json');
        echo $geo_names;
    }


    function session_user(){
        var_dump($this->session->userdata('user'));
    }

    function geoCode()
    {
        $POST = $this->input->post();
        $lng = $POST['longitude'];
        $lat = $POST['latitude'];
//        db.lk_test.find(    {location:
//            { $near :{$geometry: { type: "Point",  coordinates: [ 79.861979,7.190108  ] },$minDistance: 0,
//              $maxDistance: 2000 }}} )

        $geo_names = $this->geo_name->geoCode(
            array(
                'location' => array(
                    '$near' => array(
                        '$geometry' => array(
                            'type' => 'Point',
                            'coordinates' => [(float)$lng , (float)$lat]
                        ),
                        '$minDistance' => 0,
                        '$maxDistance' => 2000
                    )
                )
            )
        );
        $this->output->set_content_type('Content-Type: application/json');
        echo json_encode($geo_names);
    }

    function new_orders()
    {
        $new_orders = $this->live_dao->getAllBookings();

        $this->load->view("panels/new_orders", array('orders' => $new_orders));
    }

    function php_info()
    {
        phpinfo();
    }


    function send()
    {
        $sms = new Sms("Testing message");
        $sent = $sms->send("0711661919", "Testing sms from system!");
        var_dump($sent);
    }

    function webSocket($destination)
    {
        $webSocket = new Websocket('localhost', '5555', 'testingId');
        $response = $webSocket->send("Testing websocket message", $destination);
        var_dump($response);
    }

    function nextId($name)
    {
        print_r($this->counters_dao->getNextId($name));
    }

    function createUser($uName, $pass)
    {
        var_dump($this->user_dao->create($uName, $pass));
    }

    function userAuth($username = 'kasun', $pass = 'pasd')
    {
        $searchQuery = array('uName' => 'kasun', 'pass' => 'pasd');
        var_dump($this->mongodb->track->users->findOne($searchQuery));
    }

    function setZone($driverId , $zone){
        $cab = $this->user_dao->getCabByDriverId($driverId);
        $result = $this->cab_dao->setZone($cab['cabId'] , $zone);
        echo implode(" ",array_keys($result));
        echo("\n");
        echo implode(" ",array_values($result));
    }

    function getCabsInZones(){
        $result = $this->cab_dao->getCabsInZones();
        $this->output->set_content_type('application/json');
        echo json_encode($result);
    }

    function getDriverByCabId($cabId){
        $result = $this->user_dao->getDriverByCabId($cabId);
        $this->output->set_content_type('application/json');
        echo json_encode($result);
    }

    function cancelOrder(){
        $refId = $this->input->post('refId');
        $order = $this->live_dao->getBooking($refId);
        $this->live_dao->updateStatus((string)$order['_id'], "CANCEL");

    }

    function pabxData(){
        $refId = $this->input->post();
        log_message('info',$refId);
        echo "ok";
    }

    function thisYear($year = 'year'){
        $result = $this->history_dao->getBookings(null,null,$year);
//        var_dump($result);
        $this->output->set_content_type('application/json');
        echo json_encode($result);
    }

    function bigstats(){
        $this->load->model('bigdata_dao');
        $data_stats = $this->bigdata_dao->stats();
        $this->output->set_content_type('application/json');
        echo $data_stats;
    }
}
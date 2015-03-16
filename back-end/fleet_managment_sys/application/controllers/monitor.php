<?php
 if (!defined('BASEPATH'))
     exit('No direct script access allowed');
 session_start();
 class Monitor extends CI_Controller {

     public function index() {
         if (is_user_logged_in()) {
             $new_orders = $this->live_dao->getAllBookings();
             $idle_cabs = $this->cab_dao->getCabsByState();
             $this -> load -> view('monitor/index',array('orders' => $new_orders,'idle_cabs'=>$idle_cabs));
         } else {
             //If no session, redirect to login page
             $this -> load -> library('form_validation');
             $this -> form_validation -> set_message('check_database', 'Invalid username or password');
             redirect('login', 'refresh');
         }
     }

     public function getOrder($orderRefId){
         $order = $this->live_dao->getBooking($orderRefId);
         if(is_null($order)){
             $return = null;
         }
         else{
             $driver = $this->user_dao->getUser($order['driverId'],'driver');
             $order['driver'] = $driver;
             $cro = $this->user_dao->getUser($order['croId'],'cro');
             $order['cro'] = $cro;
             $return = $order;
         }

         $this->output->set_content_type('application/json');
         echo json_encode($return);
     }
 }
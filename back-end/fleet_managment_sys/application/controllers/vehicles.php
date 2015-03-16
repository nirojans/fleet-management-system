<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
session_start();
class Vehicles extends CI_Controller {

	function __construct() {
		parent::__construct();
		if (!is_user_logged_in())
			redirect('login/index', 'refresh');
		$this -> load -> model('vehicle');		
	}

	public function index() {
		$query = $this -> vehicle -> all();
		$this -> output -> set_content_type('application/json') -> set_output(json_encode($query -> result()));
	}

	public function counts() {
		$query = $this -> vehicle -> counts();
		$this -> output -> set_content_type('application/json') -> set_output(json_encode($query));
	}
	
	public function details() {
		// $vehicle_id = $this -> input -> get('vehicle_id');
		$vehicle_reg_num = $this -> input -> get('reg_number');
		$query = $this -> vehicle -> find_by_reg_number($vehicle_reg_num);
		$this -> output -> set_content_type('application/json') -> set_output(json_encode($query -> result()));
	}
	

}

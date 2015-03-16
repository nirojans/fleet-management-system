<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Navigator extends CI_Controller
{

    public function index()
    {
        $this->load->view('drivers');
    }

    public function hello(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('myview', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }

    public function drivers(){
        $this->load->view('drivers');
    }
}
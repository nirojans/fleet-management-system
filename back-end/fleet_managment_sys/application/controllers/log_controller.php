<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_controller extends CI_Controller
{

    function createLog()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->log_dao->createLog($input_data);
    }

    function getLog()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->log_dao->createLog($input_data);
    }

}
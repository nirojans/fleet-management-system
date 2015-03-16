<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cab_retriever extends CI_Controller
{

    public function index()
    {

    }


    function getNewCabView(){

        $data['new_cab_view'] = $this->load->view('admin/cabs/new_cab_view', 'data', TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }

    function getAllCabsView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $data = $this->cab_dao->getCabsByPage($input_data['limit'],$input_data['skip']);
        $i = -1;
        foreach ($data['data'] as $doc ) {
            $i++;
            $driverData = $this->user_dao->getDriverByCabId($doc['cabId']);
            if(isset($doc['userId']) && $doc['userId'] != -1) {
                $data['data'][$i]['startLocation'] = $driverData['startLocation'];
            }else{
                $data['data'][$i]['startLocation'] = "Not Assigned";
            }
        }
        $data['table_content'] = $this->load->view('admin/cabs/all_cabs_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }

    function getAllCabsViewCRO(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $data = $this->cab_dao->getCabsByPage($input_data['limit'],$input_data['skip']);
        $i = -1;
        foreach ($data['data'] as $doc ) {
            $i++;
            $driverData = $this->user_dao->getDriverByCabId($doc['cabId']);
            if(isset($doc['userId']) && $doc['userId'] != -1) {
                $data['data'][$i]['startLocation'] = $driverData['startLocation'];
            }else{
                $data['data'][$i]['startLocation'] = "not assigned";
            }
        }
        $data['table_content'] = $this->load->view('cro/cabs/all_cabs_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }

    function getCabSearchView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->cab_dao->getCab($input_data['cabId']);
        $driverData = $this->user_dao->getDriverByCabId($data['cabId']);
            if(isset($data['userId']) && $data['userId'] != -1) {
                $data['startLocation'] = $driverData['startLocation'];
            }else{
                $data['startLocation'] = "not assigned";
            }

        $data['table_content'] = $this->load->view('admin/cabs/cab_search', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getCabSearchViewCRO(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->cab_dao->getCab($input_data['cabId']);
        $driverData = $this->user_dao->getDriverByCabId($data['cabId']);
        if(isset($data['userId']) && $data['userId'] != -1) {
            $data['startLocation'] = $driverData['startLocation'];
        }else{
            $data['startLocation'] = "not assigned";
        }
        $data['table_content'] = $this->load->view('cro/cabs/cab_search', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getCabNavBar(){

        $data['cab_navbar_view'] = $this->load->view('admin/cabs/cab_navbar', '1', TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getSidePanelView(){
        $data['side_panel_view'] = $this->load->view('admin/cabs/cab_side_panel', '1' , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }



    function getCabEditView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->cab_dao->getCab($input_data['cabId']);
        $data['cab_edit_view'] = $this->load->view('admin/cabs/edit_cabs', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function createCab(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $input_data['cabId'] = (int)$this->counters_dao->getNextId("cab");
        $input_data['userId'] = (int)$input_data['userId'];
        $result = $this->cab_dao->createCab($input_data);
        if($result == true)
            $this->output->set_output(json_encode(array("statusMsg" => "success","data" => "Cab Created Successfully ")));
        else
            $this->output->set_output(json_encode(array("statusMsg" => "fail","data" => "Cab Already Exists")));

    }

    function getCab(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        if($input_data==null){
            $input_data = $_GET;
        }
        $result = $this->cab_dao->getCab($input_data['cabId']);
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));

    }

    function getAllCabs(){
        $result = $this->cab_dao->getAllCabs();
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));

    }

    function getCabsByPage(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->cab_dao->getCabsByPage($input_data['limit'],$input_data['skip']);
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));
    }

    function updateCab(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        if((array_key_exists('userId', $input_data['details']) && $input_data['details']['userId'] === 'empty') || !(array_key_exists('userId', $input_data['details']))){$input_data['details']['userId'] = -1;}
        $this->cab_dao->updateCab($input_data['cabId'],$input_data['details']);
        $this->output->set_output(json_encode(array("statusMsg" => "success")));
    }
}
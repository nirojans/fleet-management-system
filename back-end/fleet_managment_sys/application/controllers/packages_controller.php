<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Packages_controller extends CI_Controller
{
    function getAllPackagesView()
    {
        $data = $this->packages_dao->getAllPackages();
        $data['table_content'] = $this->load->view('admin/packages/all_packages_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }

    function getAllAddressView()
    {
        $data = $this->packages_dao->getAllAddress();
        $data['table_content'] = $this->load->view('admin/packages/all_address_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }

    function getPackageEditView()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->packages_dao->getPackageForEdit($input_data['packageId']);
        $data['packages_edit_view'] = $this->load->view('admin/packages/edit_packages', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }

    function getAddressEditView()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->packages_dao->getAddressForEdit($input_data['addressId']);
        $data['address_edit_view'] = $this->load->view('admin/packages/edit_address', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }

    function getPackagesViewByPackageId()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $data = $this->packages_dao->getPackage($input_data['packageId']);
        $data['table_content'] = $this->load->view('admin/packages/all_packages_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "view" => $data)));

    }
    function getNewPackageView(){

        $data['new_package_view'] = $this->load->view('admin/packages/new_package_view', 'data', TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }

    function getNewAddressView(){

        $data['new_address_view'] = $this->load->view('admin/packages/new_address', 'data', TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }

    function createPackage()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $input_data['packageId'] = $this->counters_dao->getNextId('packages');
        $this->packages_dao->createPackage($input_data);
        $this->output->set_output(json_encode(array("statusMsg" => "Success")));

    }

    function createAddress()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $input_data['addressId'] = $this->counters_dao->getNextId('address');
        $this->packages_dao->createAddress($input_data);
        $this->output->set_output(json_encode(array("statusMsg" => "Success")));

    }

    function updatePackage()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $input_data['packageId'] = (int)$input_data['packageId'];
        $this->packages_dao->updatePackage($input_data['packageId'],$input_data);
        $this->output->set_output(json_encode(array("statusMsg" => "success")));

    }

    function updateAddress()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $input_data['addressId'] = (int)$input_data['addressId'];
        $this->packages_dao->updateAddress($input_data['addressId'],$input_data);
        $this->output->set_output(json_encode(array("statusMsg" => "success")));

    }

    function deletePackage()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->packages_dao->deletePackage($input_data['packageId']);
        $this->output->set_output(json_encode(array("statusMsg" => "success")));

    }

    function deleteAddress()
    {
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->packages_dao->deleteAddress($input_data['addressId']);
        $this->output->set_output(json_encode(array("statusMsg" => "success")));

    }

    function getPackagesNavBarView(){

        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('admin/packages/packages_navbar', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getSidePanelView(){
        $table_data['x'] = 1;
        $data['table_content'] = $this->load->view('admin/packages/packages_sidepanel', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }
}
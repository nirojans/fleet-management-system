<?php
class Packages_dao extends CI_Model
{

    function __construct()
    {

    }

    function get_collection($collection = 'packages')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;

    }

    function get_address_collection($collection = 'address')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;

    }

    function createPackage($input_data){
        $collection = $this->get_collection();
        $collection->insert($input_data);
        return;
    }

    function createAddress($input_data){
        $collection = $this->get_address_collection();
        $collection->insert($input_data);
        return;
    }

    function deletePackage($packageId)
    {
        $collection = $this->get_collection();
        $searchQuery= array('packageId' => new MongoInt32($packageId) );
        $collection->remove($searchQuery);
        $record = $collection->findOne($searchQuery);
        if( $record == null){ $statusMsg=true;}
        else {$statusMsg = false;}
        return $statusMsg;
    }

    function deleteAddress($addressId)
    {
        $collection = $this->get_address_collection();
        $searchQuery= array('addressId' => new MongoInt32($addressId) );
        $collection->remove($searchQuery);
        $record = $collection->findOne($searchQuery);
        if( $record == null){ $statusMsg=true;}
        else {$statusMsg = false;}
        return $statusMsg;
    }

    function getPackage($packageId){
        $collection = $this->get_collection();
        $searchQuery= array('packageId' => new MongoInt32($packageId) );
        $cursor = $collection->find($searchQuery);
        $packages= array('data'=> array());
        foreach ($cursor as $package) {
            $packages['data'][]= $package;
        }
        return $packages;
    }

    function getPackageForEdit($packageId){
        $collection = $this->get_collection();
        $searchQuery= array('packageId' => new MongoInt32($packageId) );
        return $collection->findOne($searchQuery);
    }

    function getAddressForEdit($addressId){
        $collection = $this->get_address_collection();
        $searchQuery= array('addressId' => new MongoInt32($addressId) );
        return $collection->findOne($searchQuery);
    }

    function getAllPackages(){

        $collection = $this->get_collection();
        $cursor = $collection->find();
        $packages= array('data'=> array());
        foreach ($cursor as $package) {
            $packages['data'][]= $package;
        }
        return $packages;
    }

    function getAllAddress(){

        $collection = $this->get_address_collection();
        $cursor = $collection->find();
        $address= array('data'=> array());
        foreach ($cursor as $singleAddress) {
            $address['data'][]= $singleAddress;
        }
        return $address;
    }

    function getAllAirportPackages(){

        $collection = $this->get_collection();
        $searchQuery = array('feeType' => 'airport');
        $cursor = $collection->find($searchQuery);
        $packages= array('data'=> array());
        foreach ($cursor as $package) {
            $packages['data'][]= $package;
        }
        return $packages;
    }

    function getAllDayPackages(){

        $collection = $this->get_collection();
        $searchQuery = array('feeType' => 'day');
        $cursor = $collection->find($searchQuery);
        $packages= array('data'=> array());
        foreach ($cursor as $package) {
            $packages['data'][]= $package;
        }
        return $packages;
    }


    function updatePackage($packageId , $data){
        $collection = $this->get_collection();

        $searchQuery= array('packageId' => (int)$packageId);
        $collection->update($searchQuery,array('$set' => $data ));

    }

    function updateAddress($addressId , $data){
        $collection = $this->get_address_collection();

        $searchQuery= array('addressId' => (int)$addressId);
        $collection->update($searchQuery,array('$set' => $data ));

    }

}
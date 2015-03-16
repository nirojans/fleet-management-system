<?php
class Complaint_dao extends CI_Model
{
    function get_collection($collection = 'complaints')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;
    }
    
    function record_complaint($complaint_data)
    {
        $collection = $this->get_collection();
        $complaint_data['refId'] = (int)$complaint_data['refId'];
        $collection->insert($complaint_data);
        return true;              
    }
    
    function get_all_complaints()
    {
        $collection = $this->get_collection();
        $complaints_cursor = $collection->find();
        $complaints = array('complaints' => array());
        foreach($complaints_cursor as $comlaint){$complaints['complaints'][] = $comlaint;}
        return $complaints;
    }
    function get_all_complaints_by_driver($userId_driver)
    {
        $collection = $this->get_collection();
        $searchQuery = array('userId_driver' => (int)$userId_driver);
        $complaints_cursor_by_driver = $collection->find($searchQuery);
        $complaints_by_driver = array('complaints' => array());
        foreach($complaints_cursor_by_driver as $complaint_by_driver){$complaints_by_driver['complaints'][] = $complaint_by_driver;}
        return $complaints_by_driver;
    }
    function get_complaint_by_refId($refId)
    {
        $collection = $this->get_collection();
        $searchQuery = array('refId' => (int)$refId);
        $complaints_cursor_by_refId = $collection->find($searchQuery);
        $complaints_by_refId = array('complaints' => array());
        foreach($complaints_cursor_by_refId as $complaint_by_refId){$complaints_by_refId['complaints'][] = $complaint_by_refId;}
        return $complaints_by_refId;
    }
    function get_complaint_by_complaintId($complaintId)
    {
        $collection = $this->get_collection();
        $searchQuery = array('complaintId' => (int)$complaintId);
        $complaint_by_refId = array('complaints' => $collection->find($searchQuery));//$collection->find($searchQuery);//array('complaints' => $collection->findOne($searchQuery));
        return $complaint_by_refId;
    }
    
    function update_complaint($complaintId,$edited_complaint)
    {
        $collection = $this->get_collection();
        $searchQuery = array('complaintId' => $complaintId);
        $collection->update($searchQuery,array('$set' => $edited_complaint));
    }
    
    //Fucnitons for cancel reports
    
    function get_all_cancel_reports($type,$date)
    {
        if($date === 'today'){$date_needed = new MongoDate(strtotime(date('Y-m-d')));}
        else{$date_needed = new MongoDate(strtotime($date));}//var_dump(date('Y-m-d H:i:s',$date_needed->sec));
        //new MongoDate(strtotime(date("y-m-d")));
        $next_day = new MongoDate(($date_needed->sec + 86400));//var_dump(date("Y-m-d H:i:s",$next_day->sec));
        
        $collection = $this->get_collection("history");
        if($type === 'ALL'){$searchQuery = array('$or' => array(array('status' => 'DIS_CANCEL'),array('status' => 'CANCEL')), 'cancelTime' => array('$gte' => $date_needed, '$lt' => $next_day));}
        elseif($type === 'CANCEL'){$searchQuery = array('status' => 'CANCEL', 'cancelTime' => array('$gte' => $date_needed, '$lt' => $next_day));}
        elseif($type === 'DIS_CANCEL'){$searchQuery = array('status' => 'DIS_CANCEL', 'cancelTime' => array('$gte' => $date_needed, '$lt' => $next_day));}//, 'cancelTime' => array('$gt' => $date_needed, '$lt' => $next_day)
        $cancel_cursor = $collection->find($searchQuery);
        $cancellations = array('cancellations' => array());
        foreach($cancel_cursor as $cancel_report){$cancellations['cancellations'][] = $cancel_report;}
        //var_dump($cancellations);
        return $cancellations;
    }
  
}

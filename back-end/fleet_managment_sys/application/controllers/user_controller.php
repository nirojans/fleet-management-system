<?php
class User_controller extends CI_Controller
{
    public function index()
    {
    }

    function getUserNavBarView(){
        
        
        
        
        $table_data['x'] = 1;
        
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $user_type = $input_data['user_type'];
        
        $data['table_content'] = $this->load->view('admin/'.$user_type.'/'.$user_type.'_navbar', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getNewFormUserView(){
        $table_data['x'] = 1;
        
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $user_type = $input_data['user_type'];
        if($user_type === 'driver')
            {
                $cab_ids = array();
                $cursor= $this->cab_dao->get_unassigned_cabs();
                foreach($cursor as $cab_id){$cab_ids[] = $cab_id;}
                $data['table_content'] = $this->load->view('admin/'.$user_type.'/new_'.$user_type.'_view',array('cab_ids' => $cab_ids),TRUE);
            }
        else{$data['table_content'] = $this->load->view('admin/'.$user_type.'/new_'.$user_type.'_view',$table_data,TRUE );}
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getSidePanelView(){
        $table_data['x'] = 1;
        
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $user_type = $input_data['user_type'];
        
        $data['table_content'] = $this->load->view('admin/'.$user_type.'/'.$user_type.'_sidepanel', $table_data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }


    function getAllUsersView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $limit = $input_data['limit'];
        $skip = $input_data['skip'];
        $user_type = $input_data['user_type'];//strtoupper($input_data['user_type']);
        
        //$data = $this->user_dao->getAllUsers_by_type($user_type);
        $data = $this->user_dao->getUsersByPage_by_type($limit,$skip,$user_type);
        $data['table_content'] = $this->load->view('admin/'.$user_type.'/all_'.$user_type.'_view', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }

    function getUserSearchView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $userId = $input_data['userId'];
        $user_type = $input_data['user_type'];
        
        $data = $this->user_dao->getUser($userId,$user_type);

        $data['table_content'] = $this->load->view('admin/'.$user_type.'/'.$user_type.'_search', $data, TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getUserEditView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $userId = $input_data['userId'];
        $user_type = $input_data['user_type'];
        $cab_ids = array();
        if($user_type === 'driver')
            {                
                $cursor= $this->cab_dao->get_unassigned_cabs();
                foreach($cursor as $cab_id){$cab_ids[] = $cab_id;}
                $data = $this->user_dao->getUser($userId,$user_type);
                $data['cab_ids'] = $cab_ids;//array('cab_ids' => $cab_ids);//array_merge($data,$cab_ids);
                $data[$user_type.'_edit_view'] = $this->load->view('admin/'.$user_type.'/edit_'.$user_type, $data, TRUE);
                //$data['table_content'] = $this->load->view('admin/'.$user_type.'/new_'.$user_type.'_view',array('cab_ids' => $cab_ids),TRUE);
            }
        else
            {
                $data = $this->user_dao->getUser($userId,$user_type);
                $data[$user_type.'_edit_view'] = $this->load->view('admin/'.$user_type.'/edit_'.$user_type, $data, TRUE);
            }        
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function authenticate(){
        $statusMsg = 'fail';
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->user_dao->authenticate($input_data['uName'],$input_data['pass']);

        $data=array();
        if( $result != null ){
            $statusMsg = 'success';
            $data['userId']=$result['userId'];
            $data['cabId']=$result['cabId'];
        }
        $this->output->set_output( json_encode ( array ( "statusMsg" => $statusMsg , 'data' => $data )));
    }

    function createUser(){
        $statusMsg = 'success';
        $input_data = json_decode(trim(file_get_contents('php://input')), true); //TODO: change to this structure $this->input->post(NULL,true); //

        $input_data["userId"] = (int)($this->counters_dao->getNextId("users"));
        if(key_exists('cabId',$input_data))
                {
                    if($input_data['cabId'] === ""){$input_data['cabId']= (int)-1;}
                    else
                        {
                            $input_data['cabId']= (int)$input_data['cabId'];
                            $this->cab_dao->updateCab($input_data['cabId'],array('userId' => $input_data["userId"] ));
                        }
                    $input_data['status'] = 'out';
                    $input_data['lastLogout'] = new MongoDate(strtotime("2010-01-15 00:00:00"));
                    $input_data['lastLogin'] = new MongoDate();
                    $input_data['callingNumber'] = (int)$input_data['callingNumber'];                  
                }
        $result = $this->user_dao->createUser($input_data);

        if(!$result){
            $statusMsg = 'fail';
        }
        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg)));
    }

    function updateUser(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $input_data['userId'] = (int)$input_data['userId'];
        if(array_key_exists('cabId',$input_data['details']))//better to set the condition of the 'if' using the 'userType'
                {
                    if($input_data['details']['cabId'] === "" || $input_data['details']['cabId'] == -1)
                        {
                            $input_data['details']['cabId']= (int)-1;                            
                        }
                        $input_data['details']['cabId']= (int)$input_data['details']['cabId'];
                        
                        
                        $timeStamp = new MongoDate();
                        if(array_key_exists('callingNumber', $input_data['details']))
                            {//Add front end validation for calling number to be numeric and also add condition for acalling number to be assigned only if a user is assigned to a cab
                                if($input_data['details']['callingNumber'] == "" || !is_numeric($input_data['details']['callingNumber'])){$input_data['details']['callingNumber'] = (int)-1;}
                                else {$input_data['details']['callingNumber'] = (int)$input_data['details']['callingNumber'];}
                                
                                if($input_data['details']['logSheetNumber'] == "" || !is_numeric($input_data['details']['logSheetNumber'])){$input_data['details']['logSheetNumber'] = (int)-1;}
                                else {$input_data['details']['logSheetNumber'] = (int)$input_data['details']['logSheetNumber'];}
                                //$input_data['details']['callingNumber'] = (int)$input_data['details']['callingNumber'];
                                //need to 'insert' insted of update and also update the 'Log Sheet Number'
                                $this->log_dao->updateCallingNumber(date('Y-m-d', $timeStamp->sec),$input_data['userId'],$input_data['details']['callingNumber']);
                                $this->log_dao->updateLogSheetNumber(date('Y-m-d', $timeStamp->sec),$input_data['userId'],$input_data['details']['logSheetNumber']);

                            }
                        $this->cab_dao->updateCab($input_data['details']['cabId'],array('userId' => $input_data["userId"], 'callingNumber' => $input_data['details']['callingNumber'], 'logSheetNumber' => $input_data['details']['logSheetNumber']));
//                    else
//                        {
//                            $input_data['details']['cabId']= (int)$input_data['details']['cabId'];
//                            $this->cab_dao->updateCab($input_data['details']['cabId'],array('userId' => $input_data["userId"] ));
//                        }
                        //add relese_cab() here
            
                }
        
        $this->user_dao->updateUser($input_data['userId'],$input_data['details']);
        $this->output->set_output(json_encode(array("statusMsg" => "success")));
    }
    
    function releaseCab($cabId)
    {
        
    }

    function getUser(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->user_dao->getUser($input_data['userId'],$input_data['user_type']);
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));

    }

    function getUsersByPage(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->user_dao->getUsersByPage($input_data['limit'],$input_data['skip']);
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));
    }

    function deleteUser(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->user_dao->deleteUser($input_data['userId']);
        if($input_data['user_type']=='driver'){
            $result = $this->cab_dao->deleteCabDriver($input_data['userId']);
        }
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));

    }

    function checkExistingUser($uName){
        return $this->user_dao->checkExisting($uName);
    }

    function getAllUsers(){
        $result = $this->user_dao->getAllUsers();
        $this->output->set_output(json_encode(array("statusMsg" => "success","data" => $result )));
    }
}


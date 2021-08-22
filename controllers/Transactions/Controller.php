<?php

require_once('../includes/Classes/Users.php');
require_once('../includes/Classes/Transactions.php');
require_once('../includes/Functions/SpecialFunctions.php');
require_once("../includes/Classes/Notification.php");


class TransactionController extends Transactions{


    private $data_="";

    public function __construct($data){
        $this->data_=$data;
    }


    public function userLogin(){

        $username       = $this->data_['username'];
        $password       = $this->data_['password'];

        $user           = new Users();
        $user->username = $username;
        $user->password = $password;

        return json_encode($user->Authenticate());
    }


    public function getRecords(){


        $field = $this->data_['searchBy'];

        if($field === "Name"){
            $this->lastName  =  $this->data_['lastName'];
            $this->firstName =  $this->data_['firstName'];
        }elseif($field === "gsisIdNo"){
            $this->gsisIdNo =  $this->data_['gsisIdNo'];
        }
        elseif($field === "agency"){
            $this->agency =  $this->data_['agency'];
        }
        else{
            $this->BpNo =  $this->data_['BpNo'];
        }

        $this->searchField =  $field;

        $result  = $this->getSearchRecords();

        return json_encode(array("data" => $result));
    }

    public function addRecord(){
        return json_encode($this->addNewRecord($this->data_));
    }


    public function confirmLogin(){

        $username       = $this->data_['username'];
        $password       = $this->data_['password'];
        $action         = $this->data_['userRequestAction'];
        $recordID       = $this->data_['recordID'];

        $user           = new Users();
        $user->username = $username;
        $user->password = $password;
        $user->recordId = $recordID;


        $result = $user->checkUserAccessibility();

       if($result['status'] === "success"){

            if($action === 'edit'){

                return json_encode([
                                'status'    => 'success',
                                'form'      => convertFileintoText('/pages/editRecordForm.php',array('userid'=>$result['userid'],'id'=>$result['recID'])) ,
                                'id'        => 'editRecordForm'
                            ]);

            }else if ($action === 'addAppointment'){
            
                return json_encode([
                                'status'    => 'success',
                                'form'      => convertFileintoText('/pages/addAppointmentForm.php',array('userid'=>$result['userid'],'id'=>$result['recID'])) ,
                                'id'        => 'addAppointmentForm'
                            ]);
            
            }else{

                if($result['userType'] == 3){
                    return json_encode([
                                    'status'    => 'success',
                                    'form'      => convertFileintoText('/pages/deleteRecordForm.php',array('id'=> $result['recID'],'userid'=>$result['userid'])),
                                    'id'        => 'deleteForm'
                                ]);
                }else{
                    return json_encode([
                                    'status'  => 'failed',
                                    'result'  => 'User cannot delete the record'
                                ]);
                }
            }



       }else{
            return json_encode($result);
       }
    }

    public function editRecord(){
        return json_encode($this->saveEditRecord($this->data_));

    }

    public function deleteRecord(){

        $this->id = $this->data_['recordID'];

        if(!Users::isLogin())
            $this->userid = $this->data_['userid'];

        return json_encode($this->destroy());

    }

    public function saveCSV(){

        $file_name		=   $_FILES['csvFile']['name'];
        $file_tmp 		=   $_FILES['csvFile']['tmp_name'];
        $file_type		=   $_FILES['csvFile']['type'];
        $file_size      =   $_FILES['csvFile']['size'];
        $ext_explode	=	explode('.',$_FILES['csvFile']['name']);
        $ext_end		=	end($ext_explode);
        $file_ext		=	strtolower($ext_end);
        $maxsize        =   2097152;

        date_default_timezone_set('Asia/Manila');
        $date = date("Y_m_d_H_i_s");
        $new_Filename = $ext_explode[0].'-'.$date.'.'.$file_ext;


        if($file_ext !== "csv"){
            return json_encode(array('status'=>'failed','result' => 'Please provide a CSV file.'));
        }else if($file_size > $maxsize){
            return json_encode(array('status'=>'failed','result' => 'File too large. File must be less than 2 megabytes.'));
        }else{
            if($result = $this->saveFile($file_tmp,$new_Filename)['status'] === "failed"){
                return json_encode($result);
            }else{
                return json_encode(array("status" => "success","result" => $this->savedatasFromCSV($new_Filename,$this->data_)));
            }

        }
    }


    public function searchMemberPaginate(){

        $field        = $this->data_['searchBy'];
        $textToSearch = $this->data_['searchText'];

        $this->searchField  = $field;
        $this->searchText   = $textToSearch;

        $totalPage = $this->getTotalPagination(10);
        $firstPage = $this->searchRecordPaginate(1,10);

        return json_encode(array("page"=>$firstPage,"total_Page"=>$totalPage));
    }




    public function paginatePage(){

        $field        = $this->data_['searchBy'];
        $textToSearch = $this->data_['searchText'];

        $this->searchField  = $field;
        $this->searchText   = $textToSearch;
        $page = $this->searchRecordPaginate($this->data_['pageNo'],10);
        return json_encode($page);

    }

    public function selectRecord(){
        return json_encode($this->geteCardInfo($this->data_['id']));
    }

    public function saveListofecard(){
        return json_encode($this->multipleReleaseEcard($this->data_));
    }


    public function getUsers(){
        return json_encode(array("data" => Users::getUsers()));
    }


    public function addUser(){
        $user = new Users();
        return json_encode($user->addUser($this->data_));
    }

    public function editUser(){
        $user = new Users();
        return json_encode($user->editUser($this->data_));
    }

    public function resetPassword(){
        $user = new Users();
        return json_encode($user->resetPassword($this->data_));
    }

    public function changeStatus(){
        $user = new Users();
        return json_encode($user->userStatusChange($this->data_['recordID']));
    }

    public function changeUserPriviges(){
        $user = new Users();
        return json_encode($user->changeUserPrivilegesStatus($this->data_['recordId']));
    }


    public function changePassword(){
        $user = new Users();
        return json_encode($user->changePassword($this->data_));
    }


    public function backupdata_base(){
        return json_encode($this->backup());
    }

    public function saveAppointment(){
        return json_encode($this->setAppointment($this->data_));
    }

    public function appoinments(){

        $from = $this->data_["from"];
        $to   = $this->data_["to"];

        $result = $this->getAppointments(["from" => $from, "to" =>  $to]);
        return json_encode(["data" => $result]);
    }

    public function saveEditAppointment(){
        echo json_encode($this->changeDateAppointment($this->data_));
    }


    public function deleteAppointment(){
        $this->id = $this->data_['recordID'];
        return json_encode($this->destroyAppointment());
    }

    public function addRequest(){
        return json_encode($this->saveRequest($this->data_));
    }

    public function getRequest(){
        $result = $this->showAllRequest( );
        return json_encode(["data" => $result]);
    }

    public function taskComplete(){
        $this->id = $this->data_['recid'];
        return json_encode($this->requestAccomplished());
    }

    public function countRequest(){
        return json_encode(Notification::count());
    }
}

?>
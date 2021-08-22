<?php

    require_once('../includes/Functions/SpecialFunctions.php');
    require_once('../includes/Classes/Transactions.php');
    require_once('../includes/Classes/Users.php');


    class FormController extends Transactions{

        private $data = null;


        public function __construct($data){
            $this->data = $data;
        }

        public function LoginForm(){
            return json_encode(["result" => ['form'=> convertFileintoText('/pages/loginPage.php') ,'id' => 'LoginForm']]);
        }

        public function addRecord(){
            return  json_encode(["result" => ['form' => convertFileintoText('/pages/addRecordForm.php'),'id' => 'addRecord']]);
        }

        public function editRecord(){

            return Users::isLogin() ? json_encode(["result" => ['form' => convertFileintoText('/pages/editRecordForm.php', ['id'=>$this->data['id'],'userid'=>Users::getSessionRecord()['userID']]),'id' => 'editRecordForm']])
                                    : json_encode(["result" => ['form' => convertFileintoText('/pages/loginConfirmation.php', ['action'=>'edit','id' => $this->data['id']]) ,'id'=> 'confirmLogin']]);

        }

        public function deleteRecord(){

            if(Users::isLogin()){
                return Users::getSessionRecord()['userType'] == 3 ? json_encode(['status' => 'success', 'form'    => convertFileintoText('/pages/deleteRecordForm.php',['id'=>$this->data['id'],'userid'=> Users::getSessionRecord()['userID']]),'id' => 'deleteForm'])
                                                                  : json_encode(['status' => 'failed',  'result'  => 'User cannot delete the record']);
            }else{
                return json_encode(['form' => convertFileintoText('/pages/loginConfirmation.php',['action'=>'delete','id' => $this->data['id']]) , 'id' => 'confirmLogin']);
            }

        }

        public function viewInformation(){
            $id = $this->data['id'];
            $transactions  = new Transactions();
            $result = $transactions->viewCardInformation($id);
            return json_encode(["result" => ['form' => convertFileintoText('/pages/viewInformation.php') ,'id' => 'viewInformation', 'data' => $result ]]);
        }

        public function getReleasedForm(){
           return json_encode(['form' => convertFileintoText('/pages/releaseForm.php',Transactions::setquery("SELECT * FROM designation")->get())]);
        }

        public function getaddUserForm(){
            return json_encode(['form' => convertFileintoText('/pages/addUserForm.php') ,'id' => 'addUserForm']);
        }

        public function editUser(){
            return json_encode(['form' => convertFileintoText('/pages/editUserForm.php',['id' => $this->data['id']]) , 'id' => 'editUserForm']);
        }

        public function resetPassword(){
            return json_encode(['form' => convertFileintoText('/pages/resetPassword.php',['id' => $this->data['id']]) ,'id' => 'resetPasswordForm']);
        }

        public function changeStatus(){
            return json_encode(['form' => convertFileintoText('/pages/changeUserStatusForm.php',['id' => $this->data['id']]) ,'id' => 'changeStatus']);
        }

        public function UserPrivileges(){
            return json_encode(['form' => convertFileintoText('/pages/userPrevileges.php') , 'id' => 'UserPrivileges']);
        }

        public function Backup(){
            return json_encode(["result" => ['form' => convertFileintoText('/pages/backUpForm.php') ,'id' => 'backupForm']]);
        }

        public function addAppointmentForm (){  

            if(($this->find($this->data['id']))->eCardStatus == 1) 
                return json_encode(['result' => ['status' => "failed","message" => "The card is already released"]]);
            
            $hasAppointment = $this->hasAppointment($this->data['id']);
            if(count($hasAppointment) > 0) 
                return json_encode(['result' => ['status' => "failed","message" => "The member has appointment on ".$hasAppointment[0]->appointmentDate ]]);

            return Users::isLogin() ? json_encode(["result" => ['status' => "success" , 'form' => convertFileintoText('/pages/addAppointmentForm.php', ['id'=>$this->data['id'],'userid'=>Users::getSessionRecord()['userID']]),'id' => 'addAppointmentForm']])
                                    : json_encode(["result" => ['status' => "success" ,'form' => convertFileintoText('/pages/loginConfirmation.php', ['action'=>'addAppointment','id' => $this->data['id']]) ,'id'=> 'confirmLogin']]);
        }


        public function editAppointment(){

            return json_encode (
                                ["result" => 
                                    [
                                        'status' => "success" , 
                                        'form' => convertFileintoText('/pages/editAppointmentForm.php', ['id' => $this->data['id']]),
                                        'id' => 'editAppointmentForm'
                                    ]
                                ]
                            );

        }


        public function deleteAppointment(){

            return json_encode (
                                ["result" => 
                                    [
                                        'status' =>  "success" , 
                                        'form'   =>  convertFileintoText('/pages/deleteAppointmentForm.php', ['id' => $this->data['id']]),
                                        'id'     =>  'deleteAppointmentForm'
                                    ]
                                ]
                            );

        }

        public function addRequest(){
            return json_encode(['form' => convertFileintoText('/pages/addRequestForm.php') ,'id' => 'addRequestForm']);
        }

    }

?>
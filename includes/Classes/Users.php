
<?php

    require_once 'Database.php';


    class Users extends Database{

        public  $username ="";
        public  $password ="";
        public  $recordId = "";

        public static function getSessionRecord(){
            return  $_SESSION['sessionRecords'];
        }

        public function saveLoginSession($datas){
            $_SESSION['sessionRecords'] = $datas;
        }

        public static function isLogin(){
            if(!isset($_SESSION['sessionRecords'])){
                return false;
            }
            return true;
        }

        public function Authenticate(){

            $username = $this->filterData($this->username);
            $password = $this->filterData($this->password);
            $HASHPASSWORD = md5($password);

            $isExist =  "SELECT COUNT(*) AS 'isExist' FROM users WHERE userName ='$username'";
            $result = self::setquery($isExist)->getField('isExist');

            if($result <= 0){
                return array("status"=>"failed","result" => "User does not Exist");
            }else{

                $isExist =  "SELECT * FROM users WHERE userName ='$username'";
                $result = self::setquery($isExist)->get()[0];

                if($result->status == 0){
                    return array("status"=>"failed","result" => "The user is Locked.");
                }


                if($result->userPassword === $HASHPASSWORD){

                    $this->saveLoginSession([
                        'userID'       => $result->id,
                        'fullName'     => $result->fullName,
                        'userType'     => $result->userType
                    ]);

                    return array("status"=>"success","result" => "Successfully Login");
                }else{
                    return array("status"=>"failed","result" => "Incorrect Password");
                }

            }
        }



        //for guest alternation of records
        public function checkUserAccessibility(){

            $username = $this->filterData($this->username);
            $password = $this->filterData($this->password);
            $HASHPASSWORD = md5($password);

            $isExist =  "SELECT COUNT(*) AS 'isExist' FROM users WHERE userName ='$username'";
            $result = self::setquery($isExist)->getField('isExist');


            if($result <= 0){
                return array("status"=>"failed","result" => "User does not Exist");
            }else{

                //get user record
                $getUsersCredentials =  "SELECT * FROM users WHERE userName ='$username'";
                $result = self::setquery($getUsersCredentials)->get()[0];



                if($result->userPassword === $HASHPASSWORD){


                    //getmemberType of the record
                    $recid = $this->recordId;
                    $getMemberType = "SELECT memberType FROM records WHERE id ='$recid'";
                    $memberType = self::setquery($getMemberType)->getField('memberType');


                    //check if the user can alter the record
                   $userTYpe = $result->userType;

                    $checkAccessibility = "SELECT `status` FROM recordaccessibility WHERE memberType = '$memberType' AND usertype = '$userTYpe'";

                    if(self::setquery($checkAccessibility)->getField('status') == 0){
                        return array("status"=>"failed","result" => "User cannot alter the record.");
                    }

                    if($result->status == 0){
                        return array("status"=>"failed","result" => "The user is Locked.");
                    }

                    //if success
                    return array("status" => "success" , "result" => "Successfully Login" , "recID" => $recid , "userid" => $result->id , "userType" => $result->userType);

                }else{
                    //wrong credentials
                    return array("status"=>"failed","result" => "Incorrect Credentials");
                }
            }

        }

        public static function getUserPrivilages($id){
            $query = "SELECT memberType FROM recordaccessibility WHERE usertype = '$id' AND `status` = 1";
            $result = self::setquery($query)->getArray();
            return count($result) <= 0 ? array(0) : $result;
        }

        public static function logout(){
            session_unset();
            session_destroy();
        }



        public static function getUsers(){
            return self::setquery("SELECT
                                        s.`id`,
                                        s.`userName` AS 'USERNAME',
                                        s.`fullName` AS 'FULLNAME',
                                        t.`description` AS 'USERTYPE',
                                        s.`status`  AS 'UserStatus'
                                    FROM users s
                                        LEFT JOIN usertype t
                                            ON(s.`userType`=t.id)")->get();
        }


/////////////////////////////////////////////

        public function addUser($data){

            $fullName     = $this->filterData($data['fullname']);
            $userType     = $this->filterData($data['usertype']);
            $userName     = $this->filterData($data['username']);
            $userPassword = $this->filterData($data['password']);
            $status       = 1;

            if((self::setquery("SELECT count(*) as 'totaluser' FROM users where userName='$userName'")->getField('totaluser')) > 0){
                return array("status"=>"failed","result"=>"Username already taken.");
            }

            if(strlen($userPassword) < 8){
                return array("status"=>"failed","result"=>"Password must contain atleast 8 characters.");
            }

            $userPassword = md5($userPassword);

            $query = " INSERT INTO `users` (
                        `fullName`,
                        `userType`,
                        `userName`,
                        `userPassword`,
                        `status`
                        )
                        VALUES
                        (
                            '$fullName',
                            '$userType',
                            '$userName',
                            '$userPassword',
                            '$status'
                        );";

            return self::setquery($query)->save() ? array("status"=>"success","result"=>"Added Successfully")
                                                  : array("failed"=>"failed","result"=>"Something went wrong. Please Contact your administrator");

        }


        public function editUser($data = array()){

            $fullName = $this->filterData($data['fullname']);
            $userType = $this->filterData($data['usertype']);
            $userName = $this->filterData($data['username']);
            $id       = $this->filterData($data['userID']);

            $query = "UPDATE
                            `users`
                        SET
                            `fullName` = '$fullName',
                            `userType` = '$userType',
                            `userName` = '$userName'
                        WHERE `id` = '$id';";


            if(count(self::setquery("SELECT id FROM users where userName='$userName'")->get()) > 0){
                if((self::setquery("SELECT id FROM users where userName='$userName'")->getField("id")) != $id ){
                    return array("status"=>"failed","result"=>"Username already taken.");
                }
            }


            return self::setquery($query)->save() ? array("status"=>"success","result"=>"Altered Successfully")
                                                  : array("failed"=>"failed","result"=>"Something went wrong. Please Contact your administrator");
        }


        public function checkLastPassword($id,$password){

            $checkPassword = md5($this->filterData($password));
            $query = "SELECT userPassword FROM users WHERE id = '$id'";
            $lastPassword = self::setquery($query)->getField('userPassword');
            return $lastPassword === $checkPassword ? true : false;

        }

        public function changePassword($data=array()){

           $lastPassword        = $this->filterData($data ['currentPassword']);
           $newPassword         = $this->filterData($data ['newPassword']);
           $confirmPassword     = $this->filterData($data ['confirmPassword']);
           $userID              = self::getSessionRecord()['userID'];

            if(!$this->checkLastPassword($userID,$lastPassword)){
                return array("status"=>"failed","result"=>"Current Password not match");
            }else if($newPassword != $confirmPassword){
                return array("status"=>"failed","result"=>"New password and Confirm password not match");
            }else if(strlen($newPassword) < 8 ){
                return array("status"=>"failed","result"=>"Password must contain atleast 8 characters.");
            }else{

                $newPassword = md5($newPassword);

                if(self::setquery("UPDATE users SET userPassword='$newPassword' WHERE id = '$userID'")->save()){
                    return array("status"=>"success","result"=>"Successfully Changed");
                }else{
                    return array("status"=>"failed","result"=>"Something went wrong. Please contact your administrator.");
                }
            }

        }

        public function resetPassword($data){
            $password           = md5($this->filterData($data['password']));
            $id                 = $this->filterData($data['recordID']);

            if(self::setquery("UPDATE users SET userPassword='$password' WHERE id = '$id'")->save()){
                return array("status"=>"success","result"=>"Successfully changed!");
            }else{
                return array("status"=>"failed","result"=>"Something went wrong. Please contact your administrator.");
            }
        }


        public function userStatusChange($id){
            $userStatus = self::setquery("SELECT `status` FROM users WHERE id = '$id'")->getField('status');
            $status = $userStatus == 1 ? 0 : 1;
            if(self::setquery("UPDATE users SET `status`='$status' WHERE id='$id'")->save()){

                $msg = "User successfully "." ".($status == 1 ? "Unlocked":"Locked");

                return array("status"=>"success","result" => $msg );
            }else{
                return array("status"=>"failed","result"=>"Something went wrong. Please contact your administrator.");
            }
        }

        public function getUserRecord($id){
            return self::setquery("SELECT * FROM users WHERE id='$id'")->get();
        }


        public function getusertypes(){
            return self::setquery("SELECT * FROM usertype WHERE id != 3")->get();
        }


        public function getMemberTypes(){
            return self::setquery("SELECT * FROM membertypes")->get();
        }


        public function getStatusUserPrivileges($memberType,$userType){
            return self::setquery("SELECT
                                        `id`,
                                        `status`
                                    FROM recordaccessibility
                                        WHERE memberType='$memberType' AND usertype='$userType'")->get()[0];
        }

        public function changeUserPrivilegesStatus($id){
            $status = self::setquery("SELECT `status` FROM recordaccessibility WHERE id ='$id'")->getField('status');

            $saveStatus = $status == 1 ? 0 : 1;

            if(self::setquery("UPDATE recordaccessibility SET `status` = '$saveStatus' WHERE id ='$id'")->save()){
                return array("status"=>"success","result" => "Successfully Changed!" );
            }else{
                return array("status"=>"failed","result" => "Something went wrong, Please contact your support." );
            }
        }
    }






?>
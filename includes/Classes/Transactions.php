<?php

    require_once 'Database.php';
    require_once 'Users.php';

    class Transactions extends Database {

        protected $searchField ="";
        protected $searchText ="";
        protected $lastName = "";
        protected $firstName = "";
        protected $BpNo = "";
        protected $gsisIdNo = "";
        protected $agency = "";
        protected $userType = "";
        protected $id = "";
        protected $userid = null;

        private $table = "records";

        protected function getSearchRecords(){


            $whereClause = "";




            switch ($this->searchField) {
                case "Name":
                    $whereClause = "WHERE r.lastName LIKE '".($this->filterData($this->lastName))."%' AND r.firstName LIKE '".($this->filterData($this->firstName))."%' AND r.soft_delete IS NULL ORDER BY r.lastName ASC";
                break;

                case "BpNo":
                    $whereClause = "WHERE r.bpNo = '".($this->filterData($this->BpNo))."' AND r.soft_delete IS NULL";
                break;

                case "gsisIdNo":
                    $whereClause = "WHERE r.gsisIDNO = '".($this->filterData($this->gsisIdNo))."' AND r.soft_delete IS NULL";
                break;

                case "agency":
                    $whereClause = "WHERE r.agency LIKE '".($this->filterData($this->agency))."%' AND r.soft_delete IS NULL";
                break;
            }




            //buildQuery
            $query = "SELECT

                            r.id as 'RECORD_ID',
                            eCard.`description` AS 'ECARD_TYPE',
                            ecStatus.`description` AS 'ECARD_STATUS',
                            B.`bankcode` AS 'BANK',
                            DATE_FORMAT(r.`releaseDate`,'%M, %d %Y') AS 'DATE_RELEASED',
                            CONCAT(r.`gsisIDNO`,' / ',r.`bpNo`) AS 'gsisid',
                            r.`lastName` AS 'LASTNAME',
                            r.`firstName` AS 'FISTNAME',
                            r.`middleName` AS 'MIDDLENAME',
                            r.`agency` AS 'AGENCY',
                            mT.`description` AS 'MEMBERTYPE',
                            r.`remarks` AS 'CARD_REMARKS'

                        FROM records r

                            LEFT JOIN membertypes mT
                                ON(r.`memberType` = mT.`id`)
                            LEFT JOIN ecardtypes eCard
                                ON(r.`eCardType` = eCard.`id`)
                            LEFT JOIN banks B
                                ON(r.`bank` = B.`id`)
                            LEFT JOIN ecardstatus ecStatus
                                ON(r.`eCardStatus` = ecStatus.`id`)
                            LEFT JOIN designation d
                                ON(r.`releaseTo` = d.`id`) ".$whereClause;


            //return datas
            return self::setquery($query)->get();

        }



        public function viewCardInformation($id){


            $query ="SELECT
                            eCard.`description` AS 'ECARD_TYPE',
                            ecStatus.`description` AS 'ECARD_STATUS',
                            B.`bankcode` AS 'BANK',
                            DATE_FORMAT(r.`releaseDate`,'%M %d, %Y') AS 'DATE_RELEASED',
                            DATE_FORMAT(r.`dateRecieved`,'%M %d, %Y') AS 'DATE_RECIEVED',
                            d.`description` AS 'RELEASED_TO',
                            r.`designation` AS 'DESIGNATION',
                            s.`userName` AS 'RELEASED_BY',
                            r.`gsisIDNO` AS 'gsisid',
                            r.`bpNo`,
                            r.`lastName` AS 'LASTNAME',
                            r.`firstName` AS 'FIRSTNAME',
                            r.`middleName` AS 'MIDDLENAME',
                            r.`agency` AS 'AGENCY',
                            r.`contactNumber` AS 'CONTACT_NO',
                            mT.`description` AS 'MEMBERTYPE',
                            r.`remarks` AS 'CARD_REMARKS'

                        FROM records r

                            LEFT JOIN membertypes mT
                                ON(r.`memberType` = mT.`id`)
                            LEFT JOIN ecardtypes eCard
                                ON(r.`eCardType` = eCard.`id`)
                            LEFT JOIN banks B
                                ON(r.`bank` = B.`id`)
                            LEFT JOIN ecardstatus ecStatus
                                ON(r.`eCardStatus` = ecStatus.`id`)
                            LEFT JOIN designation d
                                ON(r.`releaseTo` = d.`id`)
                            LEFT JOIN users s
                                ON(r.`releaseBy` = s.`id`)

                                WHERE r.id ='".$id."'";

            return self::setquery($query)->get();
        }

        protected function addNewRecord($data = array()){

            $gsisIDNO       =  $this->filterData($data['gsisidno']);
            $bpNo           =  $this->filterData($data['bpNo']);
            $lastName       =  $this->filterData($data['lastname']);
            $middleName     =  $this->filterData($data['middlename']);
            $firstName      =  $this->filterData($data['firstname']);
            $contactNumber  =  $this->filterData($data['contact']);
            $agency         =  $this->filterData($data['agency']);
            $memberType     =  $this->filterData($data['membertype']);
            $eCardType      =  $this->filterData($data['ecardtype']);
            $bank           =  $this->filterData($data['bank']);
            $dateRecieved   =  $this->filterData($data['datereceived']);
            $eCardStatus    =  2;


            $query = self::insert([
                            'gsisIDNO'      => $gsisIDNO,
                            'bpNo'          => $bpNo,
                            'lastName'      => $lastName,
                            'middleName'    => $middleName,
                            'firstName'     => $firstName,
                            'contactNumber' => $contactNumber,
                            'agency'        => $agency,
                            'memberType'    => $memberType,
                            'eCardType'     => $eCardType,
                            'bank'          => $bank,
                            'dateRecieved'  => $dateRecieved,
                            'eCardStatus'   => $eCardStatus
            ],$this->table);

            $result = self::setquery($query)->save();

            return $result ? array("status"=>"success","result"=>"Record Successfully Save!") : array("status"=>"failed","result"=> "Something went wrong.");

        }



        protected function addReleasedRecord($data = array()){


            $gsisIDNO       =  $this->filterData($data['gsisidno']);
            $bpNo           =  $this->filterData($data['bpNo']);
            $lastName       =  $this->filterData($data['lastname']);
            $middleName     =  $this->filterData($data['middlename']);
            $firstName      =  $this->filterData($data['firstname']);
            $contactNumber  =  $this->filterData($data['contact']);
            $agency         =  $this->filterData($data['agency']);
            $memberType     =  $this->filterData($data['membertype']);
            $eCardType      =  $this->filterData($data['ecardtype']);
            $bank           =  $this->filterData($data['bank']);
            $dateRecieved   =  $this->filterData($data['datereceived']);
            $releaseBy      =  $this->filterData($data['releaseBy']);
            $releaseTo      =  $this->filterData($data['releaseTo']);
            $designation    =  $this->filterData($data['designation']);
            $releaseDate    =  $this->filterData($data['releaseDate']);
            $remarks        =  $this->filterData($data['remarks']);
            $eCardStatus    =  1;

            $query = self::insert([
                    'gsisIDNO'        => $gsisIDNO,
                    'bpNo'            => $bpNo,
                    'lastName'        => $lastName,
                    'middleName'      => $middleName,
                    'firstName'       => $firstName,
                    'contactNumber'   => $contactNumber,
                    'agency'          => $agency,
                    'memberType'      => $memberType,
                    'eCardType'       => $eCardType,
                    'bank'            => $bank,
                    'dateRecieved'    => $dateRecieved,
                    'eCardStatus'     => $eCardStatus,
                    'releaseBy'       => $releaseBy,
                    'releaseTo'       => $releaseTo,
                    'designation'     => $designation,
                    'releaseDate'     => $releaseDate,
                    'remarks'         => $remarks
            ],$this->table);


        return  self::setquery($query)->save();

        }


        public static function getDropDownDatas($id=''){

            $usertype = Users::isLogin() == true ?  Users::getSessionRecord()['userType'] : self::setquery("SELECT userType FROM users WHERE id = '$id'")->getField('userType');

            $estat          = self::setquery("SELECT * FROM ecardstatus")->get();
            $designations   = self::setquery("SELECT * FROM designation")->get();
            $bank           = self::setquery("SELECT * FROM banks")->get();
            $ecardTypes     = self::setquery("SELECT * FROM ecardtypes")->get();
            $memberTypes    = self::setquery("SELECT m.`id`,m.`description` FROM recordaccessibility r LEFT JOIN membertypes m ON (r.`memberType`=m.`id`) WHERE usertype ='$usertype' AND STATUS =1 ORDER BY m.`id` ASC")->get();

            return array(
                            "status"        =>  $estat,
                            "bank"          =>  $bank,
                            "etypes"        =>  $ecardTypes,
                            "mTypes"        =>  $memberTypes,
                            "designations"  =>  $designations
                        );

        }


        public function find($id){
            $id= $this->filterData($id);
            return self::setquery("SELECT * FROM records WHERE id ='$id'")->get()[0];
        }

        protected function saveEditRecord($data){

            $id             =  $this->filterData($data['recordID']);
            $gsisIDNO       =  $this->filterData($data['gsisidno']);
            $BpNo           =  $this->filterData($data['BpNo']);
            $lastName       =  $this->filterData($data['lastname']);
            $middleName     =  $this->filterData($data['middlename']);
            $firstName      =  $this->filterData($data['firstname']);
            $contactNumber  =  $this->filterData($data['contact']);
            $agency         =  $this->filterData($data['agency']);
            $memberType     =  $this->filterData($data['membertype']);
            $eCardType      =  $this->filterData($data['ecardtype']);
            $bank           =  $this->filterData($data['bank']);
            $dateRecieved   =  $this->filterData($data['datereceived']);
            $remarks        =  $this->filterData($data['remarks']);



            $query = "";

            //if the record is already released
            if(($this->find($this->filterData($data['recordID']))->eCardStatus == 1) || (isset($data['isRelease']) === false)){

                $query = self::update([
                    'gsisIDNO'      => $gsisIDNO,
                    'bpNo'          => $BpNo,
                    'lastName'      => $lastName,
                    'middleName'    => $middleName,
                    'firstName'     => $firstName,
                    'contactNumber' => $contactNumber,
                    'agency'        => $agency,
                    'memberType'    => $memberType,
                    'eCardType'     => $eCardType,
                    'bank'          => $bank,
                    'dateRecieved'  => $dateRecieved,
                    'remarks'       => $remarks
                ],$this->table,$id);


            }else{

                //if the record is pending

                    $eCardStatus    = 1;
                    $releaseTo      = $this->filterData($data['designation']);
                    $releaseBy      = Users::isLogin() ? Users::getSessionRecord()['userID'] : $this->filterData($data['userid']);
                    $releaseDate    = $this->filterData($data['dateReleased']);
                    $designation    = $this->filterData($data['designationPerson']);

                    $query = self::update([
                        'gsisIDNO'      => $gsisIDNO,
                        'bpNo'          => $BpNo,
                        'lastName'      => $lastName,
                        'middleName'    => $middleName,
                        'firstName'     => $firstName,
                        'contactNumber' => $contactNumber,
                        'agency'        => $agency,
                        'memberType'    => $memberType,
                        'eCardType'     => $eCardType,
                        'bank'          => $bank,
                        'dateRecieved'  => $dateRecieved,
                        'eCardStatus'   => $eCardStatus,
                        'releaseBy'     => $releaseBy,
                        'releaseTo'     => $releaseTo,
                        'designation'   => $designation,
                        'releaseDate'   => $releaseDate,
                        'remarks'       => $remarks
                    ],$this->table,$id);

            }



            return self::setquery($query)->save() ? array("status"=>"success","result"=>"Record was successfully saved")
                                                  : array("status"=>"failed","result"=>"Something went wrong. Please contact your support");

        }

        public function getReleaseInformation($recordID){
            return self::setquery("SELECT
                                    d.`description`,
                                    u.`fullName`,
                                    r.`releaseDate`,
                                    r.`designation`

                                FROM records r
                                    LEFT JOIN designation d
                                        ON(r.`releaseTo` = d.`id`)
                                    LEFT JOIN users u
                                        ON(r.`releaseBy` = u.`id`)
                                    WHERE r.id ='$recordID'")->get()[0];
        }


        protected function destroy(){

            date_default_timezone_set('Asia/Manila');
            $id = $this->filterData($this->id);
            $userID   = Users::isLogin() ? Users::getSessionRecord()['userID'] : $this->userid;
            $dateTime = date('Y-m-d H:i:s');

            $query = self::update(['soft_delete' => $dateTime, 'deleted_by' => $userID ],$this->table,$id);

            return self::setquery($query)->save() ?  array("status"=>"success","result"=>"Record was successfully deleted.")
                                                  : array("status"=>"failed","result"=>"Something went wrong. Please contact your support");
        }

        protected function saveFile($temporaryName,$filename){

            $tempname =$temporaryName;
            $userID   = Users::getSessionRecord()['userID'];

            date_default_timezone_set('Asia/Manila');
            $date = date("Y-m-d H:i:s");


            $query = self::insert([
                'fileName'       => $filename,
                'uploadedBy'     => $userID,
                'dateUpload'     => $date,
            ],"uploadedfiles");


            if(self::setquery($query)->save()){
                 if(move_uploaded_file($tempname,"../files/". $filename)){
                    return array("status"=>"success");
                 }else{
                    $id = $this->getLastId();
                    self::setquery("DELETE FROM uploadedfiles WHERE id='$id'")->save();
                    return array("status"=>"failed","result"=> "Unable to save the file.");
                 }
            }
            return array("status"=>"failed","result"=> "Unable to save the file in the database.");
        }


        protected function saveDatasFromCSV($filename,$postDatas){

            $file_dir = '../files/'.$filename;
            $file = fopen($file_dir,'r');

            switch($postDatas['recordStatus']){

                case 'newRecord':
                    return $this->csvNewRecord($file);
                break;


                case 'oldRecord':
                    return $this->csvOldRecord($file);
                break;
            }

        }


        protected function csvNewRecord($file){

            $resultArray = array("status"=>"success", "success" => array() , "error" => array());

            while($data = fgetcsv($file)){

                $data = $this->utf8ize($data);

                $membertype  = $this->array_index_search($data[4],['ACTIVE','PENSIONER']);
                $ecardtype   = $this->array_index_search($data[5],['EMVECARDPLUS','EMVTEMPORARY','EMVUMID']);
                $bank        = $this->array_index_search($data[6],['LBP','UBP']);

                if($this->isBlank($membertype) || $this->isBlank($ecardtype)|| $this->isBlank($bank)){
                    array_push($resultArray['error'],$data);
                    continue;
                }

                $datasubmit = array(
                                        'gsisidno'      => $data[7],
                                        'bpNo'          => $data[8],
                                        'lastname'      => $data[0],
                                        'middlename'    => $data[2],
                                        'firstname'     => $data[1],
                                        'contact'       => $data[9],
                                        'agency'        => $data[3],
                                        'membertype'    => $membertype,
                                        'ecardtype'     => $ecardtype,
                                        'bank'          => $bank,
                                        'datereceived'  => date('Y-m-d')
                                    );




                if($this->addNewRecord($datasubmit)['status'] === "failed"){
                    array_push($resultArray['error'],$data);
                }else{
                    array_push($resultArray['success'],$data);
                }


            }


            return $resultArray;
        }


        protected function csvOldRecord($file){

            $resultArray = array("success" => array() , "error" => array());

            while($data = fgetcsv($file)){

                //convert string UTF-8
                $data = $this->utf8ize($data);

                //get values
                $eCardStatus = $data[11];
                $membertype  = $this->array_index_search($data[4],['ACTIVE','PENSIONER']);
                $ecardtype   = $this->array_index_search($data[5],['EMVECARDPLUS','EMVTEMPORARY','EMVUMID']);
                $bank        = $this->array_index_search($data[6],['LBP','UBP']);


                $releaseBy   = $eCardStatus ==="PENDING"? '' : self::setquery("SELECT id FROM users WHERE userName = '".$data[15]."'")->getField('id') ;
                $releaseTo   = $eCardStatus ==="PENDING"? '' : self::setquery("SELECT id FROM designation WHERE code = '".$data[13]."'")->getField('id') ;


                //releaseDate
                $releaseDate = $eCardStatus ==="PENDING"? '' : str_replace('/', '-', $data[12]);
                $releaseDate = $eCardStatus ==="PENDING"? '' : date('Y-m-d',strtotime($releaseDate));

                //receivedDate
                $dateReceived = str_replace('/', '-', $data[10]);
                $dateReceived = date('Y-m-d',strtotime($dateReceived));


                //form data set
                $datasubmit = array(
                   'gsisidno'      => $data[7],
                   'bpNo'          => $data[8],
                   'lastname'      => $data[0],
                   'middlename'    => $data[2],
                   'firstname'     => $data[1],
                   'contact'       => $data[9],
                   'agency'        => $data[3],
                   'membertype'    => $membertype,
                   'ecardtype'     => $ecardtype,
                   'bank'          => $bank,
                   'datereceived'  => $dateReceived,
                   'releaseBy'     => $releaseBy,
                   'releaseTo'     => $releaseTo,
                   'designation'   => $eCardStatus ==="PENDING"? '' : $data[14],
                   'releaseDate'   => $releaseDate,
                   'remarks'       => $eCardStatus ==="PENDING"? '' : $data[16]
                );


                if($eCardStatus === "RELEASED"){

                    if($this->isBlank($membertype) || $this->isBlank($ecardtype) || $this->isBlank($bank) || $this->isBlank($releaseBy) || $this->isBlank($releaseTo)){
                        array_push($resultArray['error'],$data);
                        continue;
                    }

                        if(!$this->addReleasedRecord($datasubmit)){
                            array_push($resultArray['error'],$data);
                        }else{
                            array_push($resultArray['success'],$data);
                        }

                }else{

                    if($this->isBlank($membertype) || $this->isBlank($ecardtype) || $this->isBlank($bank)){
                        array_push($resultArray['error'],$data);
                        continue;
                    }

                        if($this->addNewRecord($datasubmit)['status'] === "failed"){
                            array_push($resultArray['error'],$data);
                        }else{
                            array_push($resultArray['success'],$data);
                        }
                }


            }

            return $resultArray;

        }





    protected function getTotalPagination($limit){

        $fieldsToSearch     = array (
            'lastname'  => 'lastName',
            'firstname' => 'firstName',
            'gsisid'    => 'gsisIDNO',
            'bpNo'      => 'bpNo',
            'office'    => 'agency'
        );


        $userPrivileges = implode(',' , Users::getUserPrivilages(Users::getSessionRecord()['userType']));


        $field = $this->filterData($this->searchField);
        $text = $this->filterData($this->searchText);

        $condition = "LIKE '".$text."%'";

        $total =  self::setquery("SELECT
                                   COUNT(*) AS 'TOTALPAGES'
                                FROM records r
                                    LEFT JOIN membertypes m
                                        ON(r.`memberType` = m.`id`)
                                    LEFT JOIN ecardtypes ec
                                        ON(r.`eCardType` = ec.`id`)
                                        WHERE r.`".$fieldsToSearch[$field]."` ".$condition."  AND r.eCardStatus = 2 AND (memberType IN (".$userPrivileges."))")->getfield('TOTALPAGES');
        return ceil($total/$limit);
    }


    protected function searchRecordPaginate($page,$limit){

        $fieldsToSearch     = array (
            'lastname'  => 'lastName',
            'firstname' => 'firstName',
            'gsisid'    => 'gsisIDNO',
            'bpNo'      => 'bpNo',
            'office'    => 'agency'
        );


        $userPrivileges = implode(',' , Users::getUserPrivilages(Users::getSessionRecord()['userType']));


        $field = $this->filterData($this->searchField);
        $text = $this->filterData($this->searchText);

        $condition = "LIKE '".$text."%'";


        $offset = ($page - 1) * $limit;


        return self::setquery("SELECT
                                    r.id,
                                    CONCAT(r.`lastName`,', ',r.`firstName`,', ',r.`middleName` ) AS 'fullname',
                                    r.`gsisIDNO`,
                                    r.`agency`,
                                    m.`description` as 'MEMBERTYPE',
                                    ec.`description` as 'ECARDTYPE'
                                FROM records r
                                    LEFT JOIN membertypes m
                                        ON(r.`memberType` = m.`id`)
                                    LEFT JOIN ecardtypes ec
                                        ON(r.`eCardType` = ec.`id`)
                                        WHERE r.`".$fieldsToSearch[$field]."` ".$condition." AND r.eCardStatus = 2 AND r.soft_delete IS NULL AND (memberType IN (".$userPrivileges.")) ORDER BY r.`lastName` LIMIT $offset , $limit")->get();


    }

    protected function geteCardInfo($id){
        return self::setquery("SELECT
                                    r.id,
                                    CONCAT(r.`lastName`,', ',r.`firstName`,', ',r.`middleName` ) AS 'fullname',
                                    r.`gsisIDNO`,
                                    r.`agency`,
                                    m.`description` AS 'MEMBERTYPE',
                                    ec.`description` AS 'ECARDTYPE'
                                FROM records r
                                    LEFT JOIN membertypes m
                                        ON(r.`memberType` = m.`id`)
                                    LEFT JOIN ecardtypes ec
                                        ON(r.`eCardType` = ec.`id`)
                                            WHERE r.id='$id'")->get();
    }


    protected function multipleReleaseEcard($data){

        $designations = $data['designation'];
        $dateReleased = $data['dateReleased'];
        $remarks      = $data['remarks'];
        $releaseBy    = Users::getSessionRecord()['userID'];
        $eCardStatus  = 1;

        if(!isset($data['recordID'])){
            return array("status" => "failed","result"=>"There is no list of eCard to be release.");
        }


        for($i=0; $i < count($data['recordID']); $i++){

            $id = $data['recordID'][$i];

            $member = $this->find($id);

            $receiver = $designations != 1 ? $data['receiver'] : $member->firstName." ".$member->middleName." ".$member->lastName;


            $query = self::update([
                'eCardStatus'   => $eCardStatus,
                'releaseBy'     => $releaseBy,
                'releaseTo'     => $designations,
                'releaseDate'   => $dateReleased,
                'designation'   => $receiver,
                'remarks'       => $remarks
            ],$this->table,$id);

            self::setquery($query)->save();

        }

        return array("status" => "success");
    }

    public function reportSummary(){

        $activeMembers              = self::setquery("SELECT COUNT(*) AS 'totalActive' FROM records WHERE memberType=1 AND `soft_delete` IS NULL")->getField("totalActive");
        $pensionerMembers           = self::setquery("SELECT COUNT(*) AS 'totalPensioner' FROM records WHERE memberType=2 AND `soft_delete` IS NULL")->getField("totalPensioner");

        $totalActiveReleased        = self::setquery("SELECT COUNT(*) AS 'totalActiveReleased' FROM records WHERE memberType=1 AND eCardStatus =1 AND `soft_delete` IS NULL")->getField("totalActiveReleased");
        $totalPensionerReleased     = self::setquery("SELECT COUNT(*) AS 'totalPensionerReleased' FROM records WHERE memberType=2 AND  eCardStatus =1 AND `soft_delete` IS NULL")->getField("totalPensionerReleased");

        $totalActiveRemain          = self::setquery("SELECT COUNT(*) AS 'totalActiveRemain' FROM records WHERE memberType=1 AND eCardStatus =2 AND `soft_delete` IS NULL")->getField("totalActiveRemain");
        $totalPensionerRemain       = self::setquery("SELECT COUNT(*) AS 'totalPensionerRemain' FROM records WHERE memberType=2 AND eCardStatus =2 AND `soft_delete` IS NULL")->getField("totalPensionerRemain");

        $totalActiveLBP             = self::setquery("SELECT COUNT(*) AS 'totalActiveLBP' FROM records WHERE memberType=1 AND bank =1 AND `soft_delete` IS NULL")->getField("totalActiveLBP");
        $totalPensionerLBP          = self::setquery("SELECT COUNT(*) AS 'totalPensionerLBP' FROM records WHERE memberType=2 AND bank =1 AND `soft_delete` IS NULL")->getField("totalPensionerLBP");

        $totalActiveUBP             = self::setquery("SELECT COUNT(*) AS 'totalActiveUBP' FROM records WHERE memberType=1 AND bank =2 AND `soft_delete` IS NULL")->getField("totalActiveUBP");
        $totalPensionerUBP          = self::setquery("SELECT COUNT(*) AS 'totalPensionerUBP' FROM records WHERE memberType=2 AND bank =2 AND `soft_delete` IS NULL")->getField("totalPensionerUBP");

        return array(
                        "activeMembers"             => $activeMembers,
                        "pensionerMembers"          => $pensionerMembers,
                        "totalActiveReleased"       => $totalActiveReleased,
                        "totalPensionerReleased"    => $totalPensionerReleased,
                        "totalActiveRemain"         => $totalActiveRemain,
                        "totalPensionerRemain"      => $totalPensionerRemain,
                        "totalActiveLBP"            => $totalActiveLBP,
                        "totalPensionerLBP"         => $totalPensionerLBP,
                        "totalActiveUBP"            => $totalActiveUBP,
                        "totalPensionerUBP"         => $totalPensionerUBP
                    );
    }

    protected function isBlank($data){
        return ($data == null || $data === "") ? true:false;
    }


    protected function utf8ize($mixed){
        if (is_array($mixed)){
            foreach ($mixed as $key => $value) {
                $mixed[$key] = $this->utf8ize($value);
            }
        }elseif(is_string($mixed)){
            return mb_convert_encoding($mixed,"UTF-8","UTF-8");
        }
        return $mixed;
    }


    protected function array_index_search($value,$array){
        $result = array_search(trim($value),$array);
        return $result === false ? null : ($result + 1);
    }

    protected function backup(){
        return self::backUpDataBase();
    }



    //appointments
    protected function setAppointment($data = array()){

        date_default_timezone_set('Asia/Manila');
        $recordID        =  $this->filterData($data['recordID']);
        $userID          =  Users::isLogin() ? Users::getSessionRecord()['userID'] : $this->filterData($data['userid']);
        $appointmentDate =  $this->filterData($data['appointmentDate']);
        $dateTime        = date('Y-m-d H:i:s');

        $query = self::insert([
                "recordID"          => $recordID,
                "appointmentDate"   => $appointmentDate,
                "createdBy"         => $userID,
                "createdAt"         => $dateTime
        ],"appointments");


        return self::setquery($query)->save() ? array("status"=>"success","result"=>"Appointment Successfully Save!") 
                                              : array("status"=>"failed","result"=> $query);
    }

    protected function hasAppointment($id){
        return self::setquery("SELECT * FROM appointments WHERE deletedAt IS NULL AND recordID = '$id'")->get();
    }

    protected function changeDateAppointment($datas) {

        $appointmentDate =  $this->filterData($datas['appointmentDate']);
        $id = $this->filterData($datas['recordID']);

        $query = self::update(['appointmentDate' => $appointmentDate],"appointments",$id);

        return self::setquery($query)->save() ? array("status"=>"success","result"=>"Successfully saved!") 
                                              : array("status"=>"failed","result"=> $query);
    }

    protected function destroyAppointment(){

        date_default_timezone_set('Asia/Manila');
        $id = $this->filterData($this->id);
        $dateTime = date('Y-m-d H:i:s');

        $query = self::update(['deletedAt' => $dateTime],"appointments",$id);

        return self::setquery($query)->save() ?  array("status"=>"success","result"=>"Appointment was successfully deleted.")
                                              : array("status"=>"failed","result"=>"Something went wrong. Please contact your support");
    }


    protected function getAppointments ($datas){

        $fromApp =  $this->filterData($datas['from']);
        $toApp   =  $this->filterData($datas['to']);

        $query = "SELECT 
                        app.`id`,
                        rec.`bpNo` AS 'BPNO',
                        rec.`gsisIDNO` AS 'GSISID',
                        CONCAT(rec.`lastName`,', ',rec.`firstName`,' ',rec.`middleName`) AS 'FULLNAME',
                        rec.`agency` AS 'AGENCY',
                        mt.`description` AS 'MEMBERSTAT',
                        b.`bankcode` AS 'BANK',
                        ectype.`description`  AS 'ECARDTYPE',
                        app.`appointmentDate` AS 'APPOINTMENTDATE',
                        u.`fullName` AS 'APPOINTEDBY',
                        app.`createdAt` AS 'DATECREATED'
                    
                FROM appointments app
                    LEFT JOIN records rec
                        ON(app.`recordID` = rec.`id`)
                    LEFT JOIN membertypes mt
                        ON(rec.`memberType` = mt.`id`)
                    LEFT JOIN banks b
                        ON(rec.`bank` = b.`id`)
                    LEFT JOIN ecardtypes ectype
                        ON(rec.`eCardType` = ectype.`id`)
                    LEFT JOIN users u
                        ON(app.`createdBy` = u.`id`)
                        
                            WHERE (app.`appointmentDate` BETWEEN '$fromApp' AND '$toApp' ) AND app.`deletedAt` IS NULL ";

        return self::setquery($query)->get();
    }

    public function getAppointmentInfo($id){

        $query = "SELECT 
                        app.`id`,
                        rec.`bpNo` AS 'BPNO',
                        rec.`gsisIDNO` AS 'GSISID',
                        CONCAT(rec.`lastName`,', ',rec.`firstName`,' ',rec.`middleName`) AS 'FULLNAME',
                        rec.`agency` AS 'AGENCY',
                        mt.`description` AS 'MEMBERSTAT',
                        b.`bankcode` AS 'BANK',
                        ectype.`description`  AS 'ECARDTYPE',
                        app.`appointmentDate` AS 'APPOINTMENTDATE',
                        u.`fullName` AS 'APPOINTEDBY',
                        app.`createdAt` AS 'DATECREATED'
                    
                FROM appointments app
                    LEFT JOIN records rec
                        ON(app.`recordID` = rec.`id`)
                    LEFT JOIN membertypes mt
                        ON(rec.`memberType` = mt.`id`)
                    LEFT JOIN banks b
                        ON(rec.`bank` = b.`id`)
                    LEFT JOIN ecardtypes ectype
                        ON(rec.`eCardType` = ectype.`id`)
                    LEFT JOIN users u
                        ON(app.`createdBy` = u.`id`)
                        
                            WHERE app.id = '$id'";

        return self::setquery($query)->get()[0];

    }


    protected function saveRequest($data){

        $lastName       =  $this->filterData($data['lastName']);
        $firstName      =  $this->filterData($data['firstName']);
        $middleName     =  $this->filterData($data['middleName']);
        $agency         =  $this->filterData($data['agency']);
        $remarks        =  $this->filterData($data['remarks']);
        $requestedBy    =  $this->filterData($data['requestedBy']);
        $importancyLevel    =  $this->filterData($data['importancyLevel']);
        date_default_timezone_set('Asia/Manila');
        $dateTime        = date('Y-m-d H:i:s');


        $query = self::insert([
                "lastName"          => $lastName,
                "firstName"         => $firstName,
                "middleName"        => $middleName,
                "agency"            => $agency,
                "remarks"           => $remarks,
                "levelOfImportancy" => $importancyLevel,
                "requestedBy"       => $requestedBy,
                "isDone"            => 0,
                "createdAt"         => $dateTime
        ],"queries");


        return self::setquery($query)->save() ? array("status"=>"success","result"=>"Request added successfully!") 
                                          : array("status"=>"failed","result"=> $query);
    }

    public function showAllRequest(){
        return self::setquery('SELECT
                                    q.id,
                                    CONCAT(q.lastName, ", ",q.firstName," ",q.middleName) AS "MEMBER",
                                    q.agency AS "AGENCY",
                                    q.remarks AS "REMARKS",
                                    DATE_FORMAT(q.createdAt,"%M %d , %Y @ %h:%i %p") AS "CREATED_AT",
                                    emp.`fullName` AS "REQUESTED_BY",
                                    lvl.`important_label` AS "LABEL",
                                    lvl.`color` AS "COLOR"
                                
                                FROM queries q
                                
                                LEFT JOIN gsisemployees emp
                                    ON(emp.`id` = q.`requestedBy`)
                                LEFT JOIN levels_of_importance lvl
                                    ON(q.`levelOfImportancy` = lvl.`id`)
                                        WHERE q.isDone = 0 ORDER BY q.`createdAt` ASC')->get();
    }

    protected function requestAccomplished(){

        date_default_timezone_set('Asia/Manila');
        $id = $this->filterData($this->id);
        $dateTime = date('Y-m-d H:i:s');

        $query = self::update(['isDone' => 1 ,'accomplishedAt' => $dateTime],"queries",$id);

        return self::setquery($query)->save() ?  array("status"=>"success","result"=>"Accomplished")
                                              : array("status"=>"failed","result"=>"Something went wrong. Please contact your support");
    }

    public function showEmployees(){
        return self::setquery("SELECT * FROM gsisemployees")->get();
    }

    public function showLevelsOFImportancy(){
        return self::setquery("SELECT * FROM levels_of_importance")->get();
    }
    

}



?>
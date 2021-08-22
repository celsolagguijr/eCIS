<?php

    require_once('Database.php');

    class Report extends Database{

        private $requestReport = "";


        public function __construct($request = ''){
            $this->requestReport = $request;
        }



        public function getReport(){

            $request     = $this->requestReport;

            if(!array_key_exists($request,$this->reportsMap()))
                return ["status" => "error","message" => "Request not Found!"];

            $queryReport = $this->reportsMap()[$request];
            $header      = self::setquery($this->$queryReport())->getFields();
            $datas       = self::setquery($this->$queryReport())->get();

            return ["status" => "success" ,"header" => $header , "datas" => $datas];
        }


        protected function reportsMap(){
            return [
                    "activeMembers"      => "activeMembers",
                    "pensionerMembers"   => "pensionerMembers",
                    "activeReleased"     => "activeReleased",
                    "pensionerReleased"  => "pensionerReleased",
                    "activeRemain"       => "activeRemain",
                    "pensionerRemain"    => "pensionerRemain",
                    "activeLBP"          => "activeLBP",
                    "pensionerLBP"       => "pensionerLBP",
                    "activeUBP"          => "activeUBP",
                    "pensionerUBP"       => "pensionerUBP"
                ];
        }

        private function activeMembers(){
            return "SELECT

                    r.`lastName` AS 'LASTNAME',
                    r.`firstName` AS 'FIRSTNAME',
                    r.`middleName` AS 'MIDDLENAME',
                    r.`gsisIDNO` AS 'GSISIDNO',
                    r.`bpNo` AS 'BPNO',
                    r.`agency` AS 'AGENCY',
                    r.`contactNumber` AS 'CONTACT_NUMBER',
                    mType.`description` AS 'MEMBER_STATUS',
                    eType.description AS 'ECARD_TYPE',
                    b.bankcode AS 'SERVICING_BANK',
                    r.dateRecieved AS 'DATE_RECEIVED',
                    eStat.description AS 'ECARD_STATUS',
                    releaseBy.`fullName` AS 'RELEASE_BY',
                    desig.`description` AS 'DESIGNATION',
                    r.`designation` AS 'RECEIVERS_NAME',
                    r.`releaseDate` AS 'RELEASE_DATE',
                    r.`remarks` AS 'REMARKS'


                FROM records r

                    LEFT JOIN membertypes mType
                        ON(r.`memberType` = mType.id)
                    LEFT JOIN ecardtypes eType
                        ON(r.`eCardType` = eType.id)
                    LEFT JOIN ecardstatus eStat
                        ON(r.`eCardStatus` = eStat.id)
                    LEFT JOIN banks b
                        ON(r.`bank` = b.id)
                    LEFT JOIN users releaseBy
                        ON(r.`releaseBy` = releaseBy.`id`)
                    LEFT JOIN designation desig
                        ON(r.`releaseTo` = desig.id)

                        WHERE r.`memberType` = 1 AND r.`soft_delete` IS NULL";
        }

        private function pensionerMembers(){
            return "SELECT

                    r.`lastName` AS 'LASTNAME',
                    r.`firstName` AS 'FIRSTNAME',
                    r.`middleName` AS 'MIDDLENAME',
                    r.`gsisIDNO` AS 'GSISIDNO',
                    r.`bpNo` AS 'BPNO',
                    r.`agency` AS 'AGENCY',
                    r.`contactNumber` AS 'CONTACT_NUMBER',
                    mType.`description` AS 'MEMBER_STATUS',
                    eType.description AS 'ECARD_TYPE',
                    b.bankcode AS 'SERVICING_BANK',
                    r.dateRecieved AS 'DATE_RECEIVED',
                    eStat.description AS 'ECARD_STATUS',
                    releaseBy.`fullName` AS 'RELEASE_BY',
                    desig.`description` AS 'DESIGNATION',
                    r.`designation` AS 'RECEIVERS_NAME',
                    r.`releaseDate` AS 'RELEASE_DATE',
                    r.`remarks` AS 'REMARKS'


                FROM records r

                    LEFT JOIN membertypes mType
                        ON(r.`memberType` = mType.id)
                    LEFT JOIN ecardtypes eType
                        ON(r.`eCardType` = eType.id)
                    LEFT JOIN ecardstatus eStat
                        ON(r.`eCardStatus` = eStat.id)
                    LEFT JOIN banks b
                        ON(r.`bank` = b.id)
                    LEFT JOIN users releaseBy
                        ON(r.`releaseBy` = releaseBy.`id`)
                    LEFT JOIN designation desig
                        ON(r.`releaseTo` = desig.id)

                        WHERE r.`memberType` = 2 AND r.`soft_delete` IS NULL";
        }


        private function activeReleased(){
            return "SELECT
                    r.`lastName` AS 'LASTNAME',
                    r.`firstName` AS 'FIRSTNAME',
                    r.`middleName` AS 'MIDDLENAME',
                    r.`gsisIDNO` AS 'GSISIDNO',
                    r.`bpNo` AS 'BPNO',
                    r.`agency` AS 'AGENCY',
                    r.`contactNumber` AS 'CONTACT_NUMBER',
                    mType.`description` AS 'MEMBER_STATUS',
                    eType.description AS 'ECARD_TYPE',
                    b.bankcode AS 'SERVICING_BANK',
                    r.dateRecieved AS 'DATE_RECEIVED',
                    eStat.description AS 'ECARD_STATUS',
                    releaseBy.`fullName` AS 'RELEASE_BY',
                    desig.`description` AS 'DESIGNATION',
                    r.`designation` AS 'RECEIVERS_NAME',
                    r.`releaseDate` AS 'RELEASE_DATE',
                    r.`remarks` AS 'REMARKS'


                FROM records r

                    LEFT JOIN membertypes mType
                        ON(r.`memberType` = mType.id)
                    LEFT JOIN ecardtypes eType
                        ON(r.`eCardType` = eType.id)
                    LEFT JOIN ecardstatus eStat
                        ON(r.`eCardStatus` = eStat.id)
                    LEFT JOIN banks b
                        ON(r.`bank` = b.id)
                    LEFT JOIN users releaseBy
                        ON(r.`releaseBy` = releaseBy.`id`)
                    LEFT JOIN designation desig
                        ON(r.`releaseTo` = desig.id)

                        WHERE r.`memberType` = 1 AND r.`eCardStatus`= 1 AND r.`soft_delete` IS NULL";
        }



        private function pensionerReleased(){
            return "SELECT
                    r.`lastName` AS 'LASTNAME',
                    r.`firstName` AS 'FIRSTNAME',
                    r.`middleName` AS 'MIDDLENAME',
                    r.`gsisIDNO` AS 'GSISIDNO',
                    r.`bpNo` AS 'BPNO',
                    r.`agency` AS 'AGENCY',
                    r.`contactNumber` AS 'CONTACT_NUMBER',
                    mType.`description` AS 'MEMBER_STATUS',
                    eType.description AS 'ECARD_TYPE',
                    b.bankcode AS 'SERVICING_BANK',
                    r.dateRecieved AS 'DATE_RECEIVED',
                    eStat.description AS 'ECARD_STATUS',
                    releaseBy.`fullName` AS 'RELEASE_BY',
                    desig.`description` AS 'DESIGNATION',
                    r.`designation` AS 'RECEIVERS_NAME',
                    r.`releaseDate` AS 'RELEASE_DATE',
                    r.`remarks` AS 'REMARKS'

                FROM records r

                    LEFT JOIN membertypes mType
                        ON(r.`memberType` = mType.id)
                    LEFT JOIN ecardtypes eType
                        ON(r.`eCardType` = eType.id)
                    LEFT JOIN ecardstatus eStat
                        ON(r.`eCardStatus` = eStat.id)
                    LEFT JOIN banks b
                        ON(r.`bank` = b.id)
                    LEFT JOIN users releaseBy
                        ON(r.`releaseBy` = releaseBy.`id`)
                    LEFT JOIN designation desig
                        ON(r.`releaseTo` = desig.id)

                        WHERE r.`memberType` = 2 AND r.`eCardStatus`= 1 AND r.`soft_delete` IS NULL";
        }

        private function activeRemain(){
            return "SELECT

                    r.`lastName` AS 'LASTNAME',
                    r.`firstName` AS 'FIRSTNAME',
                    r.`middleName` AS 'MIDDLENAME',
                    r.`gsisIDNO` AS 'GSISIDNO',
                    r.`bpNo` AS 'BPNO',
                    r.`agency` AS 'AGENCY',
                    r.`contactNumber` AS 'CONTACT_NUMBER',
                    mType.`description` AS 'MEMBER_STATUS',
                    eType.description AS 'ECARD_TYPE',
                    b.bankcode AS 'SERVICING_BANK',
                    r.dateRecieved AS 'DATE_RECEIVED',
                    eStat.description AS 'ECARD_STATUS',
                    r.`remarks` AS 'REMARKS'


                FROM records r

                    LEFT JOIN membertypes mType
                        ON(r.`memberType` = mType.id)
                    LEFT JOIN ecardtypes eType
                        ON(r.`eCardType` = eType.id)
                    LEFT JOIN ecardstatus eStat
                        ON(r.`eCardStatus` = eStat.id)
                    LEFT JOIN banks b
                        ON(r.`bank` = b.id)
                    LEFT JOIN users releaseBy
                        ON(r.`releaseBy` = releaseBy.`id`)
                    LEFT JOIN designation desig
                        ON(r.`releaseTo` = desig.id)

                        WHERE r.`memberType` = 1 AND r.`eCardStatus`= 2 AND r.`soft_delete` IS NULL";
        }


        private function pensionerRemain(){
            return "SELECT

                    r.`lastName` AS 'LASTNAME',
                    r.`firstName` AS 'FIRSTNAME',
                    r.`middleName` AS 'MIDDLENAME',
                    r.`gsisIDNO` AS 'GSISIDNO',
                    r.`bpNo` AS 'BPNO',
                    r.`agency` AS 'AGENCY',
                    r.`contactNumber` AS 'CONTACT_NUMBER',
                    mType.`description` AS 'MEMBER_STATUS',
                    eType.description AS 'ECARD_TYPE',
                    b.bankcode AS 'SERVICING_BANK',
                    r.dateRecieved AS 'DATE_RECEIVED',
                    eStat.description AS 'ECARD_STATUS',
                    r.`remarks` AS 'REMARKS'


                FROM records r

                    LEFT JOIN membertypes mType
                        ON(r.`memberType` = mType.id)
                    LEFT JOIN ecardtypes eType
                        ON(r.`eCardType` = eType.id)
                    LEFT JOIN ecardstatus eStat
                        ON(r.`eCardStatus` = eStat.id)
                    LEFT JOIN banks b
                        ON(r.`bank` = b.id)
                    LEFT JOIN users releaseBy
                        ON(r.`releaseBy` = releaseBy.`id`)
                    LEFT JOIN designation desig
                        ON(r.`releaseTo` = desig.id)

                        WHERE r.`memberType` = 2 AND r.`eCardStatus`= 2 AND r.`soft_delete` IS NULL";
        }

        private function activeLBP(){
            return "SELECT

                r.`lastName` AS 'LASTNAME',
                r.`firstName` AS 'FIRSTNAME',
                r.`middleName` AS 'MIDDLENAME',
                r.`gsisIDNO` AS 'GSISIDNO',
                r.`bpNo` AS 'BPNO',
                r.`agency` AS 'AGENCY',
                r.`contactNumber` AS 'CONTACT_NUMBER',
                mType.`description` AS 'MEMBER_STATUS',
                eType.description AS 'ECARD_TYPE',
                b.bankcode AS 'SERVICING_BANK',
                r.dateRecieved AS 'DATE_RECEIVED',
                eStat.description AS 'ECARD_STATUS',
                releaseBy.`fullName` AS 'RELEASE_BY',
                desig.`description` AS 'DESIGNATION',
                r.`designation` AS 'RECEIVERS_NAME',
                r.`releaseDate` AS 'RELEASE_DATE',
                r.`remarks` AS 'REMARKS'


            FROM records r

                LEFT JOIN membertypes mType
                    ON(r.`memberType` = mType.id)
                LEFT JOIN ecardtypes eType
                    ON(r.`eCardType` = eType.id)
                LEFT JOIN ecardstatus eStat
                    ON(r.`eCardStatus` = eStat.id)
                LEFT JOIN banks b
                    ON(r.`bank` = b.id)
                LEFT JOIN users releaseBy
                    ON(r.`releaseBy` = releaseBy.`id`)
                LEFT JOIN designation desig
                    ON(r.`releaseTo` = desig.id)

                    WHERE r.`memberType` = 1 AND r.`bank` = 1 AND r.`soft_delete` IS NULL";
        }


        private function pensionerLBP(){
            return "SELECT

                r.`lastName` AS 'LASTNAME',
                r.`firstName` AS 'FIRSTNAME',
                r.`middleName` AS 'MIDDLENAME',
                r.`gsisIDNO` AS 'GSISIDNO',
                r.`bpNo` AS 'BPNO',
                r.`agency` AS 'AGENCY',
                r.`contactNumber` AS 'CONTACT_NUMBER',
                mType.`description` AS 'MEMBER_STATUS',
                eType.description AS 'ECARD_TYPE',
                b.bankcode AS 'SERVICING_BANK',
                r.dateRecieved AS 'DATE_RECEIVED',
                eStat.description AS 'ECARD_STATUS',
                releaseBy.`fullName` AS 'RELEASE_BY',
                desig.`description` AS 'DESIGNATION',
                r.`designation` AS 'RECEIVERS_NAME',
                r.`releaseDate` AS 'RELEASE_DATE',
                r.`remarks` AS 'REMARKS'


            FROM records r

                LEFT JOIN membertypes mType
                    ON(r.`memberType` = mType.id)
                LEFT JOIN ecardtypes eType
                    ON(r.`eCardType` = eType.id)
                LEFT JOIN ecardstatus eStat
                    ON(r.`eCardStatus` = eStat.id)
                LEFT JOIN banks b
                    ON(r.`bank` = b.id)
                LEFT JOIN users releaseBy
                    ON(r.`releaseBy` = releaseBy.`id`)
                LEFT JOIN designation desig
                    ON(r.`releaseTo` = desig.id)

                    WHERE r.`memberType` = 2 AND r.`bank` = 1 AND  r.`soft_delete` IS NULL";
        }

        private function activeUBP(){
            return "SELECT

                r.`lastName` AS 'LASTNAME',
                r.`firstName` AS 'FIRSTNAME',
                r.`middleName` AS 'MIDDLENAME',
                r.`gsisIDNO` AS 'GSISIDNO',
                r.`bpNo` AS 'BPNO',
                r.`agency` AS 'AGENCY',
                r.`contactNumber` AS 'CONTACT_NUMBER',
                mType.`description` AS 'MEMBER_STATUS',
                eType.description AS 'ECARD_TYPE',
                b.bankcode AS 'SERVICING_BANK',
                r.dateRecieved AS 'DATE_RECEIVED',
                eStat.description AS 'ECARD_STATUS',
                releaseBy.`fullName` AS 'RELEASE_BY',
                desig.`description` AS 'DESIGNATION',
                r.`designation` AS 'RECEIVERS_NAME',
                r.`releaseDate` AS 'RELEASE_DATE',
                r.`remarks` AS 'REMARKS'


            FROM records r

                LEFT JOIN membertypes mType
                    ON(r.`memberType` = mType.id)
                LEFT JOIN ecardtypes eType
                    ON(r.`eCardType` = eType.id)
                LEFT JOIN ecardstatus eStat
                    ON(r.`eCardStatus` = eStat.id)
                LEFT JOIN banks b
                    ON(r.`bank` = b.id)
                LEFT JOIN users releaseBy
                    ON(r.`releaseBy` = releaseBy.`id`)
                LEFT JOIN designation desig
                    ON(r.`releaseTo` = desig.id)

                    WHERE r.`memberType` = 1 AND r.`bank` = 2 AND r.`soft_delete` IS NULL";
        }

        private function pensionerUBP(){
            return "SELECT
                r.`lastName` AS 'LASTNAME',
                r.`firstName` AS 'FIRSTNAME',
                r.`middleName` AS 'MIDDLENAME',
                r.`gsisIDNO` AS 'GSISIDNO',
                r.`bpNo` AS 'BPNO',
                r.`agency` AS 'AGENCY',
                r.`contactNumber` AS 'CONTACT_NUMBER',
                mType.`description` AS 'MEMBER_STATUS',
                eType.description AS 'ECARD_TYPE',
                b.bankcode AS 'SERVICING_BANK',
                r.dateRecieved AS 'DATE_RECEIVED',
                eStat.description AS 'ECARD_STATUS',
                releaseBy.`fullName` AS 'RELEASE_BY',
                desig.`description` AS 'DESIGNATION',
                r.`designation` AS 'RECEIVERS_NAME',
                r.`releaseDate` AS 'RELEASE_DATE',
                r.`remarks` AS 'REMARKS'


            FROM records r

                LEFT JOIN membertypes mType
                    ON(r.`memberType` = mType.id)
                LEFT JOIN ecardtypes eType
                    ON(r.`eCardType` = eType.id)
                LEFT JOIN ecardstatus eStat
                    ON(r.`eCardStatus` = eStat.id)
                LEFT JOIN banks b
                    ON(r.`bank` = b.id)
                LEFT JOIN users releaseBy
                    ON(r.`releaseBy` = releaseBy.`id`)
                LEFT JOIN designation desig
                    ON(r.`releaseTo` = desig.id)

                    WHERE r.`memberType` = 2 AND r.`bank` = 2 AND  r.`soft_delete` IS NULL";
        }
 
        public function generateReport($data,$optionalDateFilter = null){

            $memberType = implode(',',$data["memberType"]);
            $ecardType  = implode(',',$data["ecardType"]);
            $bank       = implode(',',$data["banks"]);
            $ecardStat  = implode(',',$data["status"]);
            $isNotNotified = $data["notYetNotified"];
 
            $whereDateBetween = $optionalDateFilter == null ? '' :  " r.`".$optionalDateFilter['field']."` BETWEEN '".$optionalDateFilter["from"]."' AND '".$optionalDateFilter["to"]."' AND ";
            $agency = $optionalDateFilter['agency'] == '' ? '' :  " r.`agency` LIKE '".$optionalDateFilter['agency']."%' AND ";


            try {
                $query =   "SELECT
                r.`lastName` AS 'LASTNAME',
                r.`firstName` AS 'FIRSTNAME',
                r.`middleName` AS 'MIDDLENAME',
                r.`gsisIDNO` AS 'GSISIDNO',
                r.`bpNo` AS 'BPNO',
                r.`agency` AS 'AGENCY',
                r.`contactNumber` AS 'CONTACT_NUMBER',
                mType.`description` AS 'MEMBER_STATUS',
                eType.description AS 'ECARD_TYPE',
                b.bankcode AS 'SERVICING_BANK',
                r.dateRecieved AS 'DATE_RECEIVED',
                eStat.description AS 'ECARD_STATUS',
                releaseBy.`fullName` AS 'RELEASE_BY',
                desig.`description` AS 'DESIGNATION',
                r.`designation` AS 'RECEIVERS_NAME',
                r.`releaseDate` AS 'RELEASE_DATE',
                r.`remarks` AS 'REMARKS'

            FROM records r
            
                LEFT JOIN membertypes mType
                    ON(r.`memberType` = mType.id)
                LEFT JOIN ecardtypes eType
                    ON(r.`eCardType` = eType.id)
                LEFT JOIN ecardstatus eStat
                    ON(r.`eCardStatus` = eStat.id)
                LEFT JOIN banks b
                    ON(r.`bank` = b.id)
                LEFT JOIN users releaseBy
                    ON(r.`releaseBy` = releaseBy.`id`)
                LEFT JOIN designation desig
                    ON(r.`releaseTo` = desig.id)
                    
            WHERE 
                r.`memberType` IN (".$memberType.") AND  
                r.`eCardType` IN(".$ecardType.")  AND
                r.`bank` IN (".$bank.") AND 
                r.`eCardStatus` IN (".$ecardStat.") AND ";

                $isNOtifiedStatement = $isNotNotified == 1 ? 'r.`isNotified` = 0 AND '  : '';
                $isDeleteStatement = "r.`soft_delete` IS NULL;";

              
                // echo $query.$agency.$whereDateBetween.$isDeleteStatement;

                $header = self::setquery($query.$agency.$whereDateBetween.$isDeleteStatement)->getFields();
                $datas  = self::setquery($query.$agency.$whereDateBetween.$isDeleteStatement)->get();



                return ["status" => "success" ,"header" => $header , "datas" => $datas];

            } catch (\Throwable $th) {
                echo 'Failed';
            }
        }
    }

?>
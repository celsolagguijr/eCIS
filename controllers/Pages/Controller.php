<?php


require_once('../includes/Functions/SpecialFunctions.php');
require_once('../includes/Classes/Users.php');
require_once('../includes/Classes/Transactions.php');
require_once("../includes/Classes/Notification.php");

class PageController{


    private function pageSetUp($content,$navigation,$username){

        $content    =   convertFileintoText($content);
        $navigation =   navBarContent($navigation);
        $username   =   $username;
        return json_encode(["content" => $content ,"navigations" => $navigation ,"user" => $username]);

    }

    public function importCSV(){
        return $this->pageSetUp('pages/importCSV.php', Users::getSessionRecord()['userType'] , Users::getSessionRecord()['fullName']);
    }

    public function batchRelease(){
        return $this->pageSetUp('pages/batchRelease.php', Users::getSessionRecord()['userType'] , Users::getSessionRecord()['fullName']);
    }

    public function users(){
        return $this->pageSetUp('pages/userPage.php', Users::getSessionRecord()['userType'], Users::getSessionRecord()['fullName']);
    }

    public function changePassword(){
        return $this->pageSetUp('pages/changePasswordPage.php', Users::getSessionRecord()['userType'] , Users::getSessionRecord()['fullName']);
    }

    public function report(){
        return $this->pageSetUp('pages/reportPage.php', Users::getSessionRecord()['userType'] , Users::getSessionRecord()['fullName']);
    }

    public function Logout(){
        Users::logout();
        return  json_encode(array("result" => "success"));
    }


    public function home(){
        return Users::isLogin() ? $this->pageSetUp('pages/home.php', Users::getSessionRecord()['userType'], Users::getSessionRecord()['fullName'])
                                : $this->pageSetUp('pages/home.php', "default" , "Guest");
    }

    public function shoAllRequest(){

        return Users::isLogin() ? $this->pageSetUp('pages/showAllRequest.php', Users::getSessionRecord()['userType'], Users::getSessionRecord()['fullName'])
                                : $this->pageSetUp('pages/showAllRequest.php', "default" , "Guest");
    }

}
?>


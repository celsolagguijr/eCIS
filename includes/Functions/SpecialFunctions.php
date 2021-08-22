<?php



    function sec() {
        require_once($_SERVER['DOCUMENT_ROOT']."/eCIS/includes/Classes/Database.php");
        $s = new Security();
        return $s->sec();
    }

    function convertFileintoText($url,$data = array()){
        ob_start();
        require_once("../views/".$url);
        return ob_get_clean();
    }

    function navBarContent($userType){
        switch ($userType) {
            case 1:
                return array(
                    'result' => [
                                    array('pageName' => 'Home'                  ,   'name'  => 'homePage'       ,   'icon' => 'fa fa-home'      ,    'type'  => 'Page'),
                                    array('pageName' => 'Add Record'            ,   'name'  => 'addRecord'      ,   'icon' => 'fa fa-plus'      ,    'type'  => 'Form'),
                                    array('pageName' => 'Import CSV'            ,   'name'  => 'importCSV'      ,   'icon' => 'fa fa-download'  ,    'type'  => 'Page'),
                                    array('pageName' => 'Batch Release'         ,   'name'  => 'batchRelease'    ,   'icon' => 'fa fa-book'     ,    'type'  => 'Page'),
                                    array('pageName' => 'Reports'               ,   'name'  => 'report'         ,   'icon' => 'fa fa-chart-bar' ,    'type'  => 'Page'),
                                    array('pageName' => 'ChangePassword'        ,   'name'  => 'changePassword' ,   'icon' => 'fa fa-lock'      ,    'type'  => 'Page'),
                                    array('pageName' => 'Logout'                ,   'name'  => 'Logout'         ,   'icon' => 'fa fa-sign-out-alt'  ,    'type'  => 'Logout'),
                                ]
                    );
            break;

            case 2:
                return array(
                    'result' => [
                                    array('pageName' => 'Home'                  ,   'name'  => 'homePage'       ,   'icon' => 'fa fa-home'      ,    'type'  => 'Page'),
                                    array('pageName' => 'Add Record'            ,   'name'  => 'addRecord'      ,   'icon' => 'fa fa-plus'      ,    'type'  => 'Form'),
                                    array('pageName' => 'Import CSV'            ,   'name'  => 'importCSV'      ,   'icon' => 'fa fa-download'  ,    'type'  => 'Page'),
                                    array('pageName' => 'Batch Release'         ,   'name'  => 'batchRelease'  ,   'icon' => 'fa fa-book'      ,    'type'  => 'Page'),
                                    array('pageName' => 'Reports'               ,   'name'  => 'report'         ,   'icon' => 'fa fa-chart-bar' ,    'type'  => 'Page'),
                                    array('pageName' => 'ChangePassword'        ,   'name'  => 'changePassword' ,   'icon' => 'fa fa-lock'      ,    'type'  => 'Page'),
                                    array('pageName' => 'Logout'                ,   'name'  => 'Logout'         ,   'icon' => 'fa fa-sign-out-alt'  ,    'type'  => 'Logout'),
                                ]
                    );
            break;

            case 3:
                return array(
                    'result' => [


                                    array('pageName' => 'Home'                  ,   'name'  => 'homePage'       ,   'icon' => 'fa fa-home'      ,    'type'  => 'Page'),
                                    array('pageName' => 'Users'                 ,   'name'  => 'users'          ,   'icon' => 'fa fa-users'     ,    'type'  => 'Page'),
                                    array('pageName' => 'Add Record'            ,   'name'  => 'addRecord'      ,   'icon' => 'fa fa-plus'      ,    'type'  => 'Form'),
                                    array('pageName' => 'Import CSV'            ,   'name'  => 'importCSV'      ,   'icon' => 'fa fa-download'  ,    'type'  => 'Page'),
                                    array('pageName' => 'Batch Release'         ,   'name'  => 'batchRelease'    ,   'icon' => 'fa fa-book'      ,    'type'  => 'Page'),
                                    array('pageName' => 'Reports'               ,   'name'  => 'report'         ,   'icon' => 'fa fa-chart-bar' ,    'type'  => 'Page'),
                                    array('pageName' => 'Backup'                ,   'name'  => 'Backup'         ,   'icon' => 'fa fa-save'      ,    'type'  => 'Form'),
                                    array('pageName' => 'Change Password'        ,  'name'  => 'changePassword' ,   'icon' => 'fa fa-lock'      ,    'type'  => 'Page'),
                                    array('pageName' => 'Logout'                ,   'name'  => 'Logout'         ,   'icon' => 'fa fa-sign-out-alt'  ,    'type'  => 'Logout'),

                                ]
                    );
            break;

            default:
                return array(
                    'result' => [
                                    array('pageName' => 'Home'                  ,   'name'  => 'homePage'           ,   'icon' => 'fa fa-home'             ,  'type'  => 'Page'),
                                    array('pageName' => 'Login'                 ,   'name'  => 'LoginForm'          ,   'icon' => 'fa fa-sign-in-alt'      ,    'type'  => 'Form'),
                                ]
                    );
            break;
        }
    }


?>
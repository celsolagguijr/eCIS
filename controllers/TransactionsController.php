<?php

    session_start();
    require_once('Transactions/Controller.php');

    $request = $_POST['userAction'];

    $transactionObj = new TransactionController($_POST);

    $transactionMap = array(
        "userLogin"                 => "userLogin",
        "getRecords"                => "getRecords",
        "addRecord"                 => "addRecord",
        "confirmLogin"              => "confirmLogin",
        "editRecord"                => "editRecord",
        "deleteRecord"              => "deleteRecord",
        "saveCSV"                   => "saveCSV",
        "searchMemberPaginate"      => "searchMemberPaginate",
        "paginatePage"              => "paginatePage",
        "selectRecord"              => "selectRecord",
        "saveListofecard"           => "saveListofecard",
        "getUsers"                  => "getUsers",
        "addUser"                   => "addUser",
        "editUser"                  => "editUser",
        "resetPassword"             => "resetPassword",
        "changeStatus"              => "changeStatus",
        "changeUserPriviges"        => "changeUserPriviges",
        "changePassword"            => "changePassword",
        "backupDatabase"            => "backupdata_base",
        "saveAppointment"           => "saveAppointment",
        "appoinments"               => "appoinments",
        "saveEditAppointment"       => "saveEditAppointment",
        "deleteAppointment"         => "deleteAppointment",
        "addRequest"                => "addRequest",
        "getRequest"                => "getRequest",
        "taskComplete"              => "taskComplete",
        "countRequest"              => "countRequest"
        
    );

    $method = $transactionMap[$request];
    echo $transactionObj->$method();

?>
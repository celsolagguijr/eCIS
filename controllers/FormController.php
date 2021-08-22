<?php

    session_start();

    require_once("Forms/Controller.php");

    $formRequest = $_GET['form'];

    $formObj = new FormController($_GET);

    $formMap = [
        "LoginForm"             => "LoginForm",
        "addRecord"             => "addRecord",
        "editRecord"            => "editRecord",
        "deleteRecord"          => "deleteRecord",
        "viewInformation"       => "viewInformation",
        "getReleasedForm"       => "getReleasedForm",
        "getaddUserForm"        => "getaddUserForm",
        "editUser"              => "editUser",
        "resetPassword"         => "resetPassword",
        "changeStatus"          => "changeStatus",
        "UserPrivileges"        => "UserPrivileges",
        "Backup"                => "Backup",
        "addAppointmentForm"    => "addAppointmentForm",
        "editAppointment"       => "editAppointment",
        "deleteAppointment"     => "deleteAppointment",
        "addRequest"            => "addRequest"
    ];

    $method = $formMap[$formRequest];
    echo $formObj->$method();
?>
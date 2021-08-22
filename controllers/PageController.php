<?php

    session_start();

    require_once("Pages/Controller.php");

    $pageObj = new PageController();

    $pageRequest = $_GET['pageName'];

    $pageMap = [
        "importCSV"         => "importCSV",
        "batchRelease"      => "batchRelease",
        "users"             => "users",
        "changePassword"    => "changePassword",
        "report"            => "report",
        "Logout"            => "Logout",
        "Home"              => "home",
        "shoAllRequest"     => "shoAllRequest"
    ];

    $method =  !array_key_exists($pageRequest,$pageMap) ? "Home" :  $pageMap[$pageRequest];
    echo $pageObj->$method();


?>
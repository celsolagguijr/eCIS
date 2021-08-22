<?php

    ob_start();
    $file_url = $_GET['requestFile'] === "newRec" ? "http://192.168.141.165/eCIS/assets/file/new_record_file.zip" : "http://192.168.141.165/eCIS/assets/file/old_record_file.zip";
    header("location: ".$file_url);
    exit;
?>
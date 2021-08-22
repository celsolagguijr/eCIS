<?php

    require_once("Database.php");


    class Notification extends Database{

        public static function count(){
            return Database::setquery("SELECT COUNT(*) AS 'NOTIFICATIONS' FROM queries WHERE isDone=0")->getField("NOTIFICATIONS");
        }

    }

?>
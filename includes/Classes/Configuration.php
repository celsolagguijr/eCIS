<?php

    abstract class Configuration{

        private static $configDatas = array (
                                                'host'       => 'localhost',
                                                'username'   => 'root',
                                                'password'   => '',
                                                'db'         => 'ecis'
                                            );


        private static $backUpDirectories = ["C:/xampp/htdocs/eCIS/backup","C:/Users/cglagguijr/Desktop/ECISBACKUP","C:\ECIS_BACKUP_SQL"];

        public static function dataBaseData(){
            return self::$configDatas;
        }

        public static function backUpDirectories(){
            return self::$backUpDirectories;
        }
    }





?>
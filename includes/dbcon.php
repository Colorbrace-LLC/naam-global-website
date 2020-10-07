<?php

 //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


function db_connect() {

    static $db;

    if(!isset($db)) {
          try {
        $config = parse_ini_file('private.ini'); 
        $db = mysqli_connect($config['servername'],$config['username'],$config['password'],$config['dbname']);

    }

     catch(Exception $e) {
  error_log($e->getMessage());
  include 'dbconerror.php';
  exit(); 
}
    return $db;
}
    return true;
}

$db = db_connect();





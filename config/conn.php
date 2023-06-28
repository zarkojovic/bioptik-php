<?php
require_once ("config.php");
zabeleziPosetuStranici();


try {
    $conn = new PDO('mysql:host='.trim(SERVER).';dbname='.trim(DATABASE), trim(USERNAME), trim(PASSWORD));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

function zabeleziPosetuStranici(){
    $open = fopen(LOG_FAJL,"a");
    if($open){
        if(str_contains($_SERVER['REQUEST_URI'],"models")){
            return;
        }
        if(str_contains($_SERVER['REQUEST_URI'],"admin")){
            return;
        }
        $time = date("d-m-Y h:i:s");
        fwrite($open,"{$_SERVER['REQUEST_URI']}\t{$_SERVER['REMOTE_ADDR']}\t{$time}\n");
        fclose($open);
    }
}

?>
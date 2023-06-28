<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
include_once("conn.php");


    if (isset($_POST["submit"])) {

        $a = "Unos!";

        $name = $_POST["name"];
        $email = $_POST["email"];
        $subject = $_POST["subject"];
        $message = $_POST["message"];

        $regFullName = "/^[A-ZĆČŠĐŽ][a-zćčšđž]{2,13}\s[A-ZĆČŠĐŽ][a-zćčšđž]{2,13}$/";
        $regSubject = "/^(([A-ZĆČŠĐŽa-zćčšđž]{1,13}\s)*){4,70}$/";
        $regEmail = "/^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/";
        $brGresaka = 0;

        if (!preg_match($regFullName, $name)) {
            $brGresaka++;
        }
        if ($subject == "") {
            $brGresaka++;
        }
        if (!preg_match($regEmail, $email)) {
            $brGresaka++;
        }
        if ($message == "") {
            $brGresaka++;
        }

        if ($brGresaka > 0) {
            http_response_code(500);
            die;
        }

        $message = addslashes($message);
        $subject = addslashes($subject);
        $insertQuery = "INSERT INTO `messages`(`name`, `email`,  `subject`, `message`) VALUES (:name,:email,:subject,:message)";

        $query = $conn->prepare($insertQuery);

        $query->bindParam(":name", $name);
        $query->bindParam(":email", $email);
        $query->bindParam(":subject", $subject);
        $query->bindParam(":message", $message);

        $query->execute();

        $rez = $query->fetch();

        if($rez){
            echo(http_response_code(200));
        }else{
            echo(http_response_code(500));
        }


    }
}else{
    http_response_code(404);
}
?>
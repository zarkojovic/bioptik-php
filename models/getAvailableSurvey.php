<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once("../config/conn.php");
    if (isset($_SESSION["user_id"])) {
        $data = array();
        $user_id = $_SESSION["user_id"];
        $query = "SELECT * FROM `questions` WHERE question_id NOT IN (SELECT DISTINCT question_id FROM surveys WHERE user_id = $user_id) AND status = 1";
        $data[] = $conn->query($query)->fetch();
        if(isset($data[0]["question_id"])){
            $answersQuery = "SELECT * FROM `answers` WHERE question_id = {$data[0]["question_id"]}";
            $data[] = $conn->query($answersQuery)->fetchAll();
        }
        echo json_encode($data);
//        echo json_encode($answers);
    }else{
        $data = 401;
        echo json_encode($data);
    }

} else {
    http_response_code(404);
}
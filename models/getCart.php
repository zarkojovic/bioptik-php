<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once("../config/conn.php");
    if (isset($_SESSION["user_id"])) {
        $u_id = $_SESSION["user_id"];
        $query = "SELECT COUNT(*) as 'num' FROM `articles_to_cart` WHERE user_id = $u_id AND bought_at IS NULL";
        $res = $conn->query($query)->fetch();
        echo json_encode($res["num"]);
    }
}else{
    http_response_code(404);
}
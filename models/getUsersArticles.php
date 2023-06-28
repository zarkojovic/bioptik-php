<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include_once ("../config/conn.php");

    $u_id = $_SESSION["user_id"];

    $query = "SELECT * FROM `articles_to_cart` as atc JOIN `articles` a ON atc.article_id = a.article_id WHERE user_id = $u_id AND bought_at IS NULL";

    $data = $conn->query($query)->fetchAll();

    echo json_encode($data);

}else{
    http_response_code(404);
}
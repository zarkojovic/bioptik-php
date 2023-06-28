<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include_once ("../config/conn.php");
    if(isset($_SESSION["user_id"])){
        $u_id = $_SESSION["user_id"];
        $data = array();
        $ordersQuery = "SELECT DISTINCT `bought_at` FROM `articles_to_cart` WHERE user_id = $u_id AND bought_at IS NOT NULL";
        $detailQuery = "SELECT atc.`atc_id`, atc.`article_id`, atc.`user_id`, atc.`quantity`, atc.`bought_at`, a.current_price, a.name FROM `articles_to_cart` AS atc JOIN `articles` a ON atc.article_id = a.article_id WHERE atc.user_id = $u_id AND atc.bought_at IS NOT NULL";
        $orders = $conn->query($ordersQuery)->fetchAll();
        $details = $conn->query($detailQuery)->fetchAll();
        $data[] = $orders;
        $data[] = $details;
        echo json_encode($data);
    }
}else{
    http_response_code(404);
}
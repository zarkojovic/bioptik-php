<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
include_once("../config/conn.php");

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $cartQuery = "INSERT INTO `carts`(`user_id`) VALUES ('$user_id')";
    if ($conn->exec($cartQuery) == 1) {
        $cart_id = $conn->lastInsertId();

        $niz = json_decode($_POST["data"]);
        foreach ($niz as $el) {
            $CAquery = "INSERT INTO `carts_articles`(`cart_id`, `article_id`, `quantity`) VALUES ('$cart_id','$el->id','$el->qty')";
            // echo ($el->id . " " . $el->qty);
            $conn->exec($CAquery);
        }
    }
    echo "1";
} else {
    echo "0";
    die;
}
}else{
    http_response_code(404);
}
?>
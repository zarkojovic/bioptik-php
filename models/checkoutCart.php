<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include_once ("../config/conn.php");
    $u_id = $_SESSION["user_id"];

    $updateQuery = "UPDATE `articles_to_cart` SET `bought_at`= CURRENT_TIMESTAMP WHERE user_id = $u_id AND bought_at IS NULL";

    $update = $conn->exec($updateQuery);

    if($update){
        echo "najjacee";
    }

}else{
    http_response_code(404);
}
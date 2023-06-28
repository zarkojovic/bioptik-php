<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    include_once ("../config/conn.php");
    if(isset($_SESSION["user_id"])){
        $u_id = $_SESSION["user_id"];
        $a_id = $_POST["id"];
        $action = $_POST["action"];
        if($action == "add"){
            $query = "SELECT `atc_id`, `article_id`, `user_id`, `quantity`, `bought_at` FROM `articles_to_cart` WHERE article_id = $a_id AND user_id = $u_id AND bought_at IS NULL";
            $checkQuery = $conn->query($query)->fetch();
            if(!$checkQuery){
                $insertQuery = "INSERT INTO `articles_to_cart`(`article_id`, `user_id`) VALUES ($a_id,$u_id)";
                $insert = $conn->exec($insertQuery);
                if($insert){
                    echo "1";
                }
            }else{
                $qty = $checkQuery["quantity"];
                $qty = (int)$qty +1;
                $updateQuery = "UPDATE `articles_to_cart` SET `quantity`=$qty WHERE user_id = $u_id AND article_id = $a_id";
                $upate = $conn->exec($updateQuery);
                if($upate){
                    echo "2";
                }
            }
        }else if($action == "subtract"){
            $query = "SELECT `atc_id`, `article_id`, `user_id`, `quantity`, `bought_at` FROM `articles_to_cart` WHERE article_id = $a_id AND user_id = $u_id AND bought_at IS NULL";
            $checkQuery = $conn->query($query)->fetch();
            if($checkQuery){
                $qty = $checkQuery["quantity"];
                $qty = (int)$qty;
                if($qty == 1){
                    $deleteQuery = "DELETE FROM `articles_to_cart` WHERE user_id = $u_id AND article_id = $a_id AND bought_at IS NULL";
                    $delete = $conn->exec($deleteQuery);
                    if($delete){
                        echo "0";
                    }
                }else if($qty > 1){
                    $qty--;
                    $updateQuery = "UPDATE `articles_to_cart` SET `quantity`=$qty WHERE user_id = $u_id AND article_id = $a_id";
                    $upate = $conn->exec($updateQuery);
                    if($upate){
                        echo "-1";
                    }
                }
            }
        }else if($action == "remove"){
            $deleteQuery = "DELETE FROM `articles_to_cart` WHERE user_id = $u_id AND article_id = $a_id AND bought_at IS NULL";
            $delete = $conn->exec($deleteQuery);
            if($delete){
                echo "0";
            }
        }
    }else{
        http_response_code(501);
    }



}else{
    http_response_code(404);
}
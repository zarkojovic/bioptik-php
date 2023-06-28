<?php
session_start();
include_once("functions.php");

if (isset($_SESSION["user_id"])) {
    unset($_SESSION["username"]);
    unset($_SESSION["role_id"]);
    unset($_SESSION["user_id"]);
    redirect("../index.php");
}
?>
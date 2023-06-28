<?php
session_start();
ob_start();
include_once("config/config.php");
include_once("config/conn.php");
include_once("models/functions.php");

if(isset($_GET["page"])){
if(!in_array($_GET["page"],_PAGES)){
    redirect("index.php");
}}
?>
<!DOCTYPE html>
<html lang="zxx">

<?php
include_once("views/fixed/head.php");
?>
<body>
    <?php

    require_once("views/fixed/header.php");

    ?>
    <?php
        if(!isset($_GET["page"])){
            include_once("views/pages/home.php");
        }else{
            $page = $_GET["page"];

            if(in_array($page,_PAGES)){
                include_once("views/pages/".$page.".php");
            }else{
                header("Location: index.php");
            }
        }
    ?>

	<!-- footer -->
    <?php include_once("views/fixed/footer.php"); ?>
    <?php include_once("views/fixed/scripts.php"); ?>
	<!-- footer -->

</body>

</html>
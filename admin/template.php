<?php
session_start();
include_once("../models/functions.php");
include_once("../config/conn.php");
$root = "/sajtpraktikum";
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $user = getLoggedUserInfo();
  //stats
  $file = file("..\data\log.txt");

} else {
  redirect($root . "/index.php");
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel | Dashboard</title>
  <?php include_once("views/fixed/links.php") ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <?php include_once("views/fixed/navbar.php"); ?>

  <!-- Main Sidebar Container -->
  <?php include_once("views/fixed/sidemenu.php"); ?>
  <!-- Content Wrapper. Contains page content -->
  <!-- Main Sidebar Container -->
  <?php
  if(!isset($_GET["page"])){
    include_once("views/pages/home.php");
  }else{
    $page = $_GET["page"];

    if(in_array($page,_ADMIN_PAGES)){
      include_once("views/pages/".$page.".php");
    }else{
      header("Location: admin/index.php");
    }
  }
  ?>
  <!-- Content Wrapper. Contains page content -->


  <?php include_once("views/fixed/script.php") ?>
  <!-- /.content-wrapper -->
  <?php include_once("views/fixed/footer.php") ?>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include_once("views/fixed/script.php") ?>

</body>

</html>

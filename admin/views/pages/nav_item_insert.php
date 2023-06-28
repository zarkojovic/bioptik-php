<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $u_id = $_SESSION["user_id"];
  $getUser = "SELECT * FROM users WHERE user_id = $u_id";

  if (isset($_POST["submitInsertNav"])) {
    $brGresaka = 0;
    $errors = "";

    if (isset($_POST["title"])) {
      $title = $_POST["title"];
      if ($title == "") {
        $brGresaka++;
        $errors .= "<li>Ime ne sme biti prazno!</li>";
      }
    }
    if (isset($_POST["href"])) {
      $href = $_POST["href"];
      if ($href == "") {
        $brGresaka++;
        $errors .= "<li>Ime ne sme biti prazno!</li>";
      }
    }
    if ($brGresaka > 0) {
      redirect("index.php?page=nav_item_insert&errors={$errors}");
    } else {
      $insertNavQuery = "INSERT INTO `nav_items`( `href`, `title`) VALUES ('$href','$title')";

      // var_dump($updateNavQuery);
      $rez = $conn->exec($insertNavQuery);

      if ($rez) {
        redirect("index.php?page=nav_data");
      }
    }
  }

  $user = $conn->query($getUser)->fetch();

} else {
  redirect("../../index.php");
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Insert Nav Item</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">DataTables</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">
                New Nav Item
              </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?= $_SERVER["PHP_SELF"] ?>?page=nav_item_insert" method="POST">
              <div class="card-body">
                <div class="form-group">
                  <label for="firstName">Title</label>
                  <input type="text" class="form-control" id="title" name="title" value=""
                         placeholder="Title">
                </div>
                <div class="form-group">
                  <label for="firstName">Href</label>
                  <input type="text" class="form-control" id="href" name="href" value=""
                         placeholder="Link">
                </div>
                <div class="form-group">
                  <?php if (isset($_GET["errors"])): ?>
                    <div class="alert alert-danger" role="alert">
                      <?= $_GET["errors"]; ?>
                    </div>
                  <?php elseif (isset($_GET["success"])): ?>
                    <div class="alert alert-success" role="alert">
                      <?=
                      "Success"; ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              <!-- /.card-body -->
              <input type="hidden" name="nav_item_id" value="">
              <div class="card-footer">
                <button type="submit" name="submitInsertNav"
                        class="btn btn-primary">Submit
                </button>
              </div>
            </form>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $u_id = $_SESSION["user_id"];
  $getUser = "SELECT * FROM users WHERE user_id = $u_id";

  if (isset($_POST["submitEditBrand"])) {
    $brGresaka = 0;
    $errors = "";

    if (isset($_POST["name"])) {
      $name = $_POST["name"];
      if ($name == "") {
        $brGresaka++;
        $errors .= "<li>Ime ne sme biti prazno!</li>";
      }
    }
    if ($brGresaka > 0) {
      redirect("index.php?page=brands_edit&id={$_POST["brand_id"]}&errors={$errors}");
    } else {
      $bid = $_POST["brand_id"];

      $updateNavQuery = "UPDATE `brands` SET`brand_name`='$name' WHERE brand_id = $bid";

      // var_dump($updateNavQuery);
      $rez = $conn->exec($updateNavQuery);

      if ($rez) {
        redirect("index.php?page=brands_edit&id=$bid&success=1");
      }
    }
  }


  $user = $conn->query($getUser)->fetch();


  // $usersQuery = "SELECT u.user_id,u.username, u.email, u.first_name, u.last_name, r.role_name, u.created_at, u.image FROM `users`u, roles r WHERE r.role_id = u.role_id";

  // $users = $conn->query($usersQuery)->fetchAll();

  if (isset($_GET["id"])) {
    $editBrandId = $_GET["id"];
    $brandQuery = "SELECT `brand_id`, `brand_name` FROM `brands`  WHERE brand_id = $editBrandId";
    $editBrand = $conn->query($brandQuery)->fetch();

    if (!$editBrand) {
      redirect("../../index.php");
    }
  } else {
    redirect("../../index.php");
  }

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
          <h1>Edit Role</h1>
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
                <?= $editBrand["brand_name"] ?>
              </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?= $_SERVER["PHP_SELF"] ?>?page=brands_edit&id=<?= $_GET["id"] ?>" method="POST"
                  enctype="multipart/form-data">
              <div class="card-body">
                <div class="form-group">
                  <label for="firstName">Brand Name</label>
                  <input type="text" class="form-control" id="name" name="name"
                         value="<?= $editBrand["brand_name"] ?>" placeholder="Title">
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
              <input type="hidden" name="brand_id" value="<?= $editBrandId ?>">
              <div class="card-footer">
                <button type="submit" name="submitEditBrand"
                        class="btn btn-primary">Submit</button>
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

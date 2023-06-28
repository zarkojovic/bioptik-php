<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $u_id = $_SESSION["user_id"];
  $getUser = "SELECT * FROM users WHERE user_id = $u_id";

  if (isset($_POST["submitInsertRole"])) {
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

      redirect("insert_role.php?id={$_POST["article_id"]}&errors={$errors}");
    } else {
      $rid = $_POST["role_id"];

      $insertRoleQuery = "INSERT INTO `roles`(`role_name`) VALUES ('$name')";

      $rez = $conn->exec($insertRoleQuery);

      if ($rez) {
        redirect("index.php?page=role_data");
      }
    }
  }


  $user = $conn->query($getUser)->fetch();

  $tagsQuery = "SELECT `tag_id`, `tag_name` FROM `tags`";

  $tags = $conn->query($tagsQuery)->fetchAll();

  $brandsQuery = "SELECT `brand_id`, `brand_name` FROM `brands`";

  $brands = $conn->query($brandsQuery)->fetchAll();

  // $usersQuery = "SELECT u.user_id,u.username, u.email, u.first_name, u.last_name, r.role_name, u.created_at, u.image FROM `users`u, roles r WHERE r.role_id = u.role_id";

  // $users = $conn->query($usersQuery)->fetchAll();

  // if (isset($_GET["id"])) {
  //     $editRoleId = $_GET["id"];
  //     $roleQuery = "SELECT `role_id`, `role_name` FROM `roles` WHERE role_id = $editRoleId";
  //     $editRole = $conn->query($roleQuery)->fetch();

  //     if (!$editRole) {
  //         redirect("../../index.php");
  //     }
  // } else {
  //     redirect("../../index.php");
  // }

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
                New Role
              </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?= $_SERVER["PHP_SELF"] ?>?page=role_insert" method="POST">
              <div class="card-body">
                <div class="form-group">
                  <label for="firstName">Name</label>
                  <input type="text" class="form-control" id="name" name="name"
                         placeholder="Name">
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
              <input type="hidden" name="role_id">
              <div class="card-footer">
                <button type="submit" name="submitInsertRole"
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

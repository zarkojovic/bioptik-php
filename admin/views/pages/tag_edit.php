<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $u_id = $_SESSION["user_id"];
  $getUser = "SELECT * FROM users WHERE user_id = $u_id";

  if (isset($_POST["submitEditTag"])) {
    $brGresaka = 0;
    $errors = "";

    if (isset($_POST["name"])) {
      $name = $_POST["name"];
      if ($name == "") {
        $brGresaka++;
        $errors .= "<li>Ime ne sme biti prazno!</li>";
      }
    }
    if (isset($_POST["class"])) {
      $class = $_POST["class"];
      if ($class == "") {
        $brGresaka++;
        $errors .= "<li>Klasa ne sme biti prazno!</li>";
      }
    }
    if ($brGresaka > 0) {
      redirect("index.php?page=tag_edit&id={$_POST["tag_id"]}&errors={$errors}");
    } else {
      $tid = $_POST["tag_id"];

      $updateNavQuery = "UPDATE `tags` SET `tag_name`='$name',`class`='$class' WHERE tag_id = $tid";

      // var_dump($updateNavQuery);
      $rez = $conn->exec($updateNavQuery);

      if ($rez) {
        redirect("index.php?page=tag_edit&id=$tid&success=1");
      }
    }
  }


  $user = $conn->query($getUser)->fetch();


  // $usersQuery = "SELECT u.user_id,u.username, u.email, u.first_name, u.last_name, r.role_name, u.created_at, u.image FROM `users`u, roles r WHERE r.role_id = u.role_id";

  // $users = $conn->query($usersQuery)->fetchAll();

  if (isset($_GET["id"])) {
    $editTagId = $_GET["id"];
    $tagQuery = "SELECT `tag_id`, `tag_name`, `class` FROM `tags` WHERE tag_id = $editTagId";
    $editTag = $conn->query($tagQuery)->fetch();

    if (!$editTag) {
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
                <?= $editTag["tag_name"] ?>
              </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?= $_SERVER["PHP_SELF"] ?>?page=tag_edit&id=<?= $_GET["id"] ?>" method="POST">
              <div class="card-body">
                <div class="form-group">
                  <label for="firstName">Tag Name</label>
                  <input type="text" class="form-control" id="name" name="name"
                         value="<?= $editTag["tag_name"] ?>" placeholder="Title">
                </div>
                <div class="form-group">
                  <label for="firstName">Tag Class</label>
                  <input type="text" class="form-control" id="class" name="class"
                         value="<?= $editTag["class"] ?>" placeholder="Class">
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
              <input type="hidden" name="tag_id" value="<?= $editTagId ?>">
              <div class="card-footer">
                <button type="submit" name="submitEditTag"
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

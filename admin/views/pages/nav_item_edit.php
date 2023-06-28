<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $u_id = $_SESSION["user_id"];
  $getUser = "SELECT * FROM users WHERE user_id = $u_id";

  if (isset($_POST["submitEditNav"])) {
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
      redirect("index.php?page=nav_item_edit&id={$_POST["nav_item_id"]}&errors={$errors}");
    } else {
      $nid = $_POST["nav_item_id"];

      $updateNavQuery = "UPDATE `nav_items` SET `href`='$href',`title`='$title' WHERE nav_item_id = $nid";

      // var_dump($updateNavQuery);
      $rez = $conn->exec($updateNavQuery);

      if ($rez) {
        redirect("index.php?page=nav_item_edit&id=$nid&success=1");
      }
    }
  }


  $user = $conn->query($getUser)->fetch();


  // $usersQuery = "SELECT u.user_id,u.username, u.email, u.first_name, u.last_name, r.role_name, u.created_at, u.image FROM `users`u, roles r WHERE r.role_id = u.role_id";

  // $users = $conn->query($usersQuery)->fetchAll();

  if (isset($_GET["id"])) {
    $editNavId = $_GET["id"];
    $navQuery = "SELECT `nav_item_id`, `href`, `title` FROM `nav_items` WHERE nav_item_id = $editNavId";
    $editNav = $conn->query($navQuery)->fetch();

    if (!$editNav) {
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
                <?= $editNav["title"] ?>
              </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?= $_SERVER["PHP_SELF"] ?>?page=nav_item_edit&id=<?= $_GET["id"] ?>" method="POST"
                  enctype="multipart/form-data">
              <div class="card-body">
                <div class="form-group">
                  <label for="firstName">Title</label>
                  <input type="text" class="form-control" id="title" name="title"
                         value="<?= $editNav["title"] ?>" placeholder="Title">
                </div>
                <div class="form-group">
                  <label for="firstName">Href</label>
                  <input type="text" class="form-control" id="href" name="href"
                         value="<?= $editNav["href"] ?>" placeholder="Link">
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
              <input type="hidden" name="nav_item_id" value="<?= $editNavId ?>">
              <div class="card-footer">
                <button type="submit" name="submitEditNav"
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

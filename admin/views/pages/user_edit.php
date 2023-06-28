<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $u_id = $_SESSION["user_id"];
  $getUser = "SELECT * FROM users WHERE user_id = $u_id";

  if (isset($_POST["submitEditUser"])) {
    $brGresaka = 0;
    $errors = "";
    // $email;
    $isBanned = $_POST["isBanned"];
    $userUpdateId = $_POST["user_id"];
    $checkNames = "/^[a-zA-Z,.'-]+$/";
    $checkUsername = "/^[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*$/";
    $checkPassword = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";
    if (isset($_POST["firstName"])) {
      $firstName = $_POST["firstName"];
      if ($firstName == "") {
        $brGresaka++;
        $errors .= "<li>Ime ne sme biti prazno!</li>";
      } else
        if (!preg_match($checkNames, $firstName)) {
          $brGresaka++;
          $errors .= "<li>Lose Upisano ime</li>";
        }
    }
    if (isset($_POST["lastName"])) {
      $lastName = $_POST["lastName"];
      if ($firstName == "") {
        $brGresaka++;
        $errors .= "<li>Prezime ne sme biti prazno!</li>";
      } else
        if (!preg_match($checkNames, $lastName)) {
          $brGresaka++;
          $errors .= "<li>Lose Upisano prezime. Npr.</li>";
        }
    }
    if (isset($_POST["username"])) {
      $username = $_POST["username"];

      if ($username == "") {
        $brGresaka++;
        $errors .= "<li>Korisnicko ime ne sme biti prazno!</li>";
      } else
        if (!preg_match($checkUsername, $username)) {
          $brGresaka++;
          $errors .= "<li>Lose Upisano korisnicko ime</li>";
        }
    }
    if (isset($_POST["user_email"])) {
      $email = $_POST["user_email"];


      if ($email == "") {
        $brGresaka++;
        $errors .= "<li>Email ne sme biti prazno!</li>";
      } else
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $brGresaka++;
          $errors .= "<li>Lose Upisan email</li>";
        }
    }
    if (isset($_POST["password"])) {

      $password = $_POST["password"];

    }

    if (isset($_POST["roles"])) {
      $role_id = $_POST["roles"];
    }
    if (isset($_FILES["image"])) {
      $fajl = $_FILES["image"];
      if ($fajl["size"] > 0) {

        $nazivFajla = $fajl['name'];
        $tmpFajl = $fajl['tmp_name'];
        $velicinaFajla = $fajl['size'];
        $tipFajla = $fajl['type'];
        $greskeFajl = $fajl['error'];

        $dozvoljeniTipovi = ["image/png", "image/jpeg"];

        if (!in_array($tipFajla, $dozvoljeniTipovi)) {
          $brGresaka++;
          $errors .= "Greška prilikom upload-a fajla. Dozvoljeni tipovi: jpeg, png.";
        }
      }
    }

    if ($brGresaka > 0) {
      redirect("index.php?page=user_edit&id={$_POST["user_id"]}&errors={$errors}");
    } else {
      if ($fajl["size"] > 0) {
        $noviNazivFajla = time() . "_" . $nazivFajla;
        $putanja = "../../../images/" . $noviNazivFajla;
        if (moveImages($fajl,true,"../")) {

          if ($password != '') {
            $password = md5($password);
            $addedPw = ",`password`='$password'";
          } else {
            $addedPw = "";
          }

        }
        $updateUserQuery = "UPDATE `users` SET `email`='$email'" . $addedPw . ",`first_name`='$firstName',`isBanned`=$isBanned,`last_name`='$lastName',`role_id`=$role_id,`image`='$noviNazivFajla' WHERE user_id = $userUpdateId";
      } else {
        if ($password != '') {
          $password = md5($password);
          $addedPw = ",`password`='$password'";
        } else {
          $addedPw = "";
        }
        $updateUserQuery = "UPDATE `users` SET `email`='$email'" . $addedPw . ",`role_id`=$role_id,`first_name`='$firstName',`isBanned`=$isBanned,`last_name`='$lastName' WHERE user_id = $userUpdateId";
      }

      $rez = $conn->exec($updateUserQuery);

      if ($rez) {
        redirect("index.php?page=user_edit&id={$_POST["user_id"]}&success=1");
      }

    }
  }

  $user = $conn->query($getUser)->fetch();

  $rolesQuery = "SELECT `role_id`, `role_name` FROM `roles`";

  $roles = $conn->query($rolesQuery)->fetchAll();

  $usersQuery = "SELECT u.isBanned,u.user_id,u.username, u.email, u.first_name, u.last_name, r.role_name, u.created_at, u.image FROM `users`u, roles r WHERE r.role_id = u.role_id";

  $users = $conn->query($usersQuery)->fetchAll();

  if (isset($_GET["id"])) {
    $editUserId = $_GET["id"];
    $userQuery = "SELECT `user_id`,`isBanned`, `username`, `email`, `password`, `first_name`, `last_name`, `role_id`,  `image` FROM `users` WHERE user_id = $editUserId";
    $editUser = $conn->query($userQuery)->fetch();
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
          <h1>Edit User</h1>
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
                <?= $editUser["username"] ?>
              </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?= $_SERVER["PHP_SELF"] ?>?page=user_edit&id=<?= $_GET["id"] ?>" method="POST"
                  enctype="multipart/form-data">
              <div class="card-body">
                <img src="<?= ROOT_FOLDER ?>/assets/img/<?= $editUser["image"] ?>" width="150px"
                     height="150px" class="mb-3" alt="avatar">
                <div class="form-group">
                  <label for="firstName">First Name</label>
                  <input type="text" class="form-control" id="firstName" name="firstName"
                         value="<?= $editUser["first_name"] ?>" placeholder="First Name">
                </div>
                <div class="form-group">
                  <label for="lastName">Last Name</label>
                  <input type="text" class="form-control" id="lastName" name="lastName"
                         value="<?= $editUser["last_name"] ?>" placeholder="Last Name">
                </div>
                <div class="form-group">
                  <label for="user_email">Email address</label>
                  <input type="email" class="form-control" id="user_email" name="user_email"
                         value="<?= $editUser["email"] ?>" placeholder="Enter email">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Is Banned</label>
                  <div class="form-group">
                    <select class=" form-control" id="isBanned" name="isBanned">
                      <option value="0" <?= $editUser["isBanned"] == "0" ? "selected" : "" ?>>Not Banned</option>
                      <option value="1" <?= $editUser["isBanned"] == "1" ? "selected" : "" ?>>Banned</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Role</label>
                  <div class="form-group">
                    <select class=" form-control" id="roles" name="roles">
                      <?php foreach ($roles as $role): ?>
                        <option value="<?= $role["role_id"] ?>"
                          <?= $role["role_id"] == $editUser["role_id"] ? "selected" : "" ?>>
                          <?= $role["role_name"] ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="password">New password</label>
                  <input type="password" class="form-control" id="password" name="password"
                         placeholder="Password">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="image"
                             id="image">
                      <label class="custom-file-label" for="image">Choose
                        file</label>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text">Upload</span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <?php if (isset($_GET["errors"])): ?>
                    <div class="alert alert-danger" role="alert">
                      <?= $_GET["errors"]; ?>
                    </div>
                  <?php elseif (isset($_GET["errors"])): ?>
                    <div class="alert alert-success" role="alert">
                      <?=
                      "Success"; ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              <!-- /.card-body -->
              <input type="hidden" name="user_id" value="<?= $editUserId ?>">
              <div class="card-footer">
                <button type="submit" name="submitEditUser"
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

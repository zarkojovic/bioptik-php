<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $u_id = $_SESSION["user_id"];
  $getUser = "SELECT * FROM users WHERE user_id = $u_id";

  if (isset($_POST["submitEditArticle"])) {
    $brGresaka = 0;
    $errors = "";

    if (isset($_POST["name"])) {
      $name = $_POST["name"];
      if ($name == "") {
        $brGresaka++;
        $errors .= "<li>Ime ne sme biti prazno!</li>";
      }
    }
    if (isset($_POST["description"])) {
      $description = $_POST["description"];
      if ($description == "") {
        $brGresaka++;
        $errors .= "<li>Ime ne sme biti prazno!</li>";
      }
    }
    if (isset($_POST["current_price"])) {
      $current = $_POST["current_price"];
      if ($current == "") {
        $brGresaka++;
        $errors .= "<li>Ime ne sme biti prazno!</li>";
      }
    }
    if (isset($_POST["rating"])) {
      $rating = $_POST["rating"];
      if ($rating == "") {
        $brGresaka++;
        $errors .= "<li>Rating ne sme biti prazno!</li>";
      }
    }
    if (isset($_POST["old_price"])) {
      $old = $_POST["old_price"];
    }

    if (isset($_POST["discount"])) {
      $discount = $_POST["discount"];
    }
    if (isset($_POST["brands"])) {
      $brands = $_POST["brands"];
    }
    if (isset($_POST["tags"])) {
      $tag = $_POST["tags"];
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
      redirect("index.php?page=articles_edit&id={$_POST["article_id"]}&errors={$errors}");
    } else {
      $aid = $_POST["article_id"];
      if ($fajl["size"] > 0) {
        $noviNazivFajla = time() . "_" . $nazivFajla;
        moveImages($fajl, false, "../../../");
        $old = $old == "" ? "NULL" : $old;
        $discount = $discount == "" ? "NULL" : $discount;
        $tag = $tag == 0 ? "NULL" : $tag;
        $description = addslashes($description);
        $updateUserQuery = "UPDATE `articles` SET `name`='$name',`photo`='$noviNazivFajla',`old_price`=$old,`current_price`='$current',`discount`=$discount,`tag_id`=$tag,`rating`='$rating',`brand_id`=$brands,`description`='$description' WHERE article_id = $aid";

      } else {
        $old = $old == "" ? "NULL" : $old;
        $discount = $discount == "" ? "NULL" : $discount;
        $tag = $tag == 0 ? "NULL" : $tag;
        $description = addslashes($description);
        $updateUserQuery = "UPDATE `articles` SET `name`='$name',`old_price`=$old,`current_price`='$current',`discount`=$discount,`tag_id`=$tag,`rating`='$rating',`brand_id`=$brands,`description`='$description' WHERE article_id = $aid";
      }
      $rez = $conn->exec($updateUserQuery);

      if ($rez) {
        redirect("index.php?page=articles_edit&id=$aid&success=1");
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

  if (isset($_GET["id"])) {
    $editArticleId = $_GET["id"];
    $articleQuery = "SELECT `article_id`, `name`, `old_price`, `current_price`, `discount`, `photo`, `tag_id`, `rating`, `brand_id`, `description`, `created_at` FROM `articles` WHERE article_id = $editArticleId";
    $editArticle = $conn->query($articleQuery)->fetch();

    if (!$editArticle) {

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
          <h1>Edit Article</h1>
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
                <?= $editArticle["name"] ?>
              </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?= $_SERVER["PHP_SELF"] ?>?page=articles_edit&id=<?= $_GET["id"] ?>" method="POST"
                  enctype="multipart/form-data">
              <div class="card-body">
                <img src="<?= ROOT_FOLDER ?>/assets/img/<?= $editArticle["photo"] ?>" width="150px"
                     height="150px" class="mb-3" alt="avatar">
                <div class="form-group">
                  <label for="firstName">Name</label>
                  <input type="text" class="form-control" id="name" name="name"
                         value="<?= $editArticle["name"] ?>" placeholder="Name">
                </div>
                <div class="form-group">
                  <label for="lastName">Description</label>
                  <input type="text" class="form-control" id="description" name="description"
                         value="<?= $editArticle["description"] ?>" placeholder="Description">
                </Div>
                <div class="form-group">
                  <label for="user_email">Current Price</label>
                  <input type="text" class="form-control" id="current_price"
                         name="current_price" value="<?= $editArticle["current_price"] ?>"
                         placeholder="Current Price">
                </div>
                <div class="form-group">
                  <label for="user_email">Old Price</label>
                  <input type="text" class="form-control" id="old_price" name="old_price"
                         value="<?= $editArticle["old_price"] ?>" placeholder="Old Price">
                </div>
                <div class="form-group">
                  <label for="user_email">Rating</label>
                  <input type="text" class="form-control" id="rating" name="rating"
                         value="<?= $editArticle["rating"] ?>" placeholder="Rating">
                </div>
                <div class="form-group">
                  <label for="user_email">Discount</label>

                  <input type="text" class="form-control" id="discount" name="discount"
                         value="<?= $editArticle["discount"] ?>" placeholder="Discount">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Brand</label>
                  <div class="form-group">
                    <select class=" form-control" id="brands" name="brands">
                      <?php foreach ($brands as $brand): ?>
                        <option value="<?= $brand["brand_id"] ?>"
                          <?= $brand["brand_id"] == $editArticle["brand_id"] ? "selected" : "" ?>>
                          <?= $brand["brand_name"] ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Tag</label>
                  <div class="form-group">
                    <select class=" form-control" id="tags" name="tags">
                      <option value="0">Select Tag</option>
                      <?php foreach ($tags as $tag): ?>
                        <option value="<?= $tag["tag_id"] ?>"
                          <?= $tag["tag_id"] == $editArticle["tag_id"] ? "selected" : "" ?>>
                          <?= $tag["tag_name"] ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Change Picture</label>
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
              <input type="hidden" name="article_id" value="<?= $editArticleId ?>">
              <div class="card-footer">
                <button type="submit" name="submitEditArticle"
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

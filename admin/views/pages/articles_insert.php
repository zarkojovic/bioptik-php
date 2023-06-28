<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $u_id = $_SESSION["user_id"];
  $getUser = "SELECT * FROM users WHERE user_id = $u_id";

  if (isset($_POST["submitInsertArticle"])) {
    $brGresaka = 0;
    $errors = "";

    echo "<h1 class='text-center'>ajde bree</h1>";
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
        $errors .= "<li>Opis ne sme biti prazno!</li>";
      }
    }
    if (isset($_POST["current_price"])) {
      $current = $_POST["current_price"];
      if ($current == "") {
        $brGresaka++;
        $errors .= "<li>Trenutna cena ne sme biti prazno!</li>";
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
      } else {

        $brGresaka++;
        $errors .= "<li>Slika mora biti postavljena!</li>";
      }
    }

    if ($brGresaka > 0) {
      redirect("index.php?page=articles_insert&errors={$errors}");
    } else {
      if ($fajl["size"] > 0) {
        $noviNazivFajla = time() . "_" . $nazivFajla;
        moveImages($fajl,false,"../");
          $old = $old == "" ? "NULL" : $old;
          $discount = $discount == "" ? "NULL" : $old;
          $tag = $tag == 0 ? "NULL" : $tag;
          $description = addslashes($description);
          $updateUserQuery = "INSERT INTO `articles`( `name`, `old_price`, `current_price`, `discount`, `photo`, `tag_id`, `rating`, `brand_id`, `description`) VALUES ('$name',$old,'$current',$discount,'$noviNazivFajla',$tag,$rating,$brands,'$description')";

          $rez = $conn->exec($updateUserQuery);
          if ($rez) {
            redirect("index.php?page=articles_insert?success=1");
          }
        }

//      }else {
//        redirect("index.php?page=articles_insert&errors={$errors}");
//      }


    }
  }


  $user = $conn->query($getUser)->fetch();

  $tagsQuery = "SELECT `tag_id`, `tag_name` FROM `tags`";

  $tags = $conn->query($tagsQuery)->fetchAll();

  $brandsQuery = "SELECT `brand_id`, `brand_name` FROM `brands`";

  $brands = $conn->query($brandsQuery)->fetchAll();

  // $usersQuery = "SELECT u.user_id,u.username, u.email, u.first_name, u.last_name, r.role_name, u.created_at, u.image FROM `users`u, roles r WHERE r.role_id = u.role_id";

  // $users = $conn->query($usersQuery)->fetchAll();


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
          <h1>Insert Article</h1>
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
                New Article
              </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?= $_SERVER["PHP_SELF"] ?>?page=articles_insert" method="POST" enctype="multipart/form-data">
              <div class="card-body">
                <div class="form-group">
                  <label for="firstName">Name</label>
                  <input type="text" class="form-control" id="name" name="name"
                         placeholder="Name">
                </div>
                <div class="form-group">
                  <label for="lastName">Description</label>
                  <input type="text" class="form-control" id="description" name="description"
                         placeholder="Description">
                </Div>
                <div class="form-group">
                  <label for="user_email">Current Price</label>
                  <input type="text" class="form-control" id="current_price"
                         name="current_price" placeholder="Current Price">
                </div>
                <div class="form-group">
                  <label for="user_email">Old Price</label>
                  <input type="text" class="form-control" id="old_price" name="old_price"
                         placeholder="Old Price">
                </div>
                <div class="form-group">
                  <label for="user_email">Rating</label>
                  <input type="text" class="form-control" id="rating" name="rating"
                         placeholder="Rating">
                </div>
                <div class="form-group">
                  <label for="user_email">Discount</label>

                  <input type="text" class="form-control" id="discount" name="discount"
                         placeholder="Discount">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Brand</label>
                  <div class="form-group">
                    <select class=" form-control" id="brands" name="brands">
                      <?php foreach ($brands as $brand): ?>
                        <option value="<?= $brand["brand_id"] ?>">
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
                        <option value="<?= $tag["tag_id"] ?>">
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
                  <?php elseif (isset($_GET["success"])): ?>
                    <div class="alert alert-success" role="alert">
                      <?=
                      "Success"; ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              <!-- /.card-body -->
              <input type="hidden" name="article_id">
              <div class="card-footer">
                <button type="submit" name="submitInsertArticle"
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

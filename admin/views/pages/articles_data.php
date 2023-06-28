<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $u_id = $_SESSION["user_id"];
  $getUser = "SELECT * FROM users WHERE user_id = $u_id";

  if (!empty($conn)) {
    $user = $conn->query($getUser)->fetch();
  }

  if (isset($_POST["submitDelete"])) {

    $aid = $_POST["article_id"];
    echo "<h1 class='text-center'>$aid</h1>";
    $deleteArticle = "DELETE FROM articles WHERE article_id = $aid";
    $upit = $conn->exec($deleteArticle);
  }
  $articlesQuery = "SELECT  a.article_id,a.description,a.name,a.old_price,a.discount,a.current_price,a.photo,a.rating,t.class,t.tag_name,b.brand_name FROM  articles a LEFT JOIN tags t ON a.tag_id = t.tag_id LEFT JOIN brands b ON  b.brand_id = a.brand_id";

  $articles = $conn->query($articlesQuery)->fetchAll();


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
          <h1>Articles</h1>
          <a href="index.php?page=articles_insert" class="btn btn-primary mt-3">
            New Article
          </a>
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
          <div class="card">
            <!-- <div class="card-header">
<h3 class="card-title">DataTable with minimal features & hover style</h3>
</div> -->
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Current Price</th>
                  <th>Old Price</th>
                  <th>Discount</th>
                  <th>Rating</th>
                  <th>Tag</th>
                  <th>Brand</th>
                  <th>Edit user</th>
                  <th>Delet user</th>
                </tr>
                </thead>
                <tbody>
                <?php $index = 0;
                foreach ($articles as $u):
                  $index++; ?>
                  <tr>
                    <td>
                      <?= $index ?>
                    </td>
                    <td><img src="<?= ROOT_FOLDER ?>/assets/img/<?= $u["photo"] ?>" width="50px"
                             height="50px" alt="user image">
                    </td>
                    <td>
                      <?= $u["name"] ?>
                    </td>
                    <td>
                      <?= $u["description"] ?>
                    </td>
                    <td>
                      <?= $u["current_price"] ?>
                    </td>
                    <td>
                      <?= $u["old_price"] ?>
                    </td>
                    <td>
                      <?= $u["discount"] ?>
                    </td>
                    <td>
                      <?= $u["rating"] ?>
                    </td>
                    <td>
                      <?= $u["tag_name"] ?>
                    </td>
                    <td>
                      <?= $u["brand_name"] ?>
                    </td>
                    <td>
                      <a href="index.php?page=articles_edit&id=<?= $u["article_id"] ?>"
                         class="btn btn-primary">Edit</a>
                    </td>
                    <td>
                      <button class="btn btn-danger btnDelete" data-toggle="modal" data-name="article_id"
                              data-id="<?= $u["article_id"] ?>" data-target="#deleteModal">
                        Delete
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Current Price</th>
                  <th>Old Price</th>
                  <th>Discount</th>
                  <th>Rating</th>
                  <th>Tag</th>
                  <th>Brand</th>
                  <th>Edit user</th>
                  <th>Delet user</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
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

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete user</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this user?
      </div>
      <div class="modal-footer">
        <form action="<?= $_SERVER["PHP_SELF"] ?>?page=articles_data" name="deleteForm" method="POST">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="hidden" name="article_id" value="0">
          <button type="submit" name="submitDelete" class="btn btn-danger">Delete it</button>
        </form>
      </div>
    </div>
  </div>
</div>


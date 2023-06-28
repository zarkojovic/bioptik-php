<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $u_id = $_SESSION["user_id"];
  $getUser = "SELECT * FROM users WHERE user_id = $u_id";


  $user = $conn->query($getUser)->fetch();

  if (isset($_POST["submitDelete"])) {
    $tid = $_POST["tag_id"];

    $deleteTag = "DELETE FROM `tags` WHERE tag_id = $tid";

    $upit = $conn->exec($deleteTag);
  }

  $tagQuery = "SELECT `tag_id`, `tag_name`,`class` FROM `tags`";

  $tags = $conn->query($tagQuery)->fetchAll();

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
          <h1>Tags</h1>
          <a href="index.php?page=tag_insert" class="btn btn-primary mt-3">
            New Tag
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
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Tag</th>
                  <th>Class</th>
                  <th>Edit Item</th>
                  <th>Delete Item</th>
                </tr>
                </thead>
                <tbody>
                <?php $index = 0;
                foreach ($tags as $u):
                  $index++; ?>
                  <tr>
                    <td>
                      <?= $index ?>
                    </td>
                    <td>
                      <?= $u["tag_name"] ?>
                    </td>
                    <td>
                      <?= $u["class"] ?>
                    </td>
                    <td>
                      <a href="index.php?page=tag_edit&id=<?= $u["tag_id"] ?>"
                         class="btn btn-primary">Edit</a>
                    </td>
                    <td>
                      <button class="btn btn-danger btnDelete" data-toggle="modal" data-name="tag_id"
                              data-id="<?= $u["tag_id"] ?>" data-target="#deleteModal">
                        Delete
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Tag</th>
                  <th>Class</th>
                  <th>Edit Item</th>
                  <th>Delete Item</th>
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
        <form action="<?= $_SERVER["PHP_SELF"] ?>?page=tag_data" name="deleteForm" method="POST">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="hidden" name="tag_id" value="0">
          <button type="submit" name="submitDelete" class="btn btn-danger">Delete it</button>
        </form>
      </div>
    </div>
  </div>
</div>


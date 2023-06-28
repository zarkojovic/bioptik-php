<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $u_id = $_SESSION["user_id"];
  $getUser = "SELECT * FROM users WHERE user_id = $u_id";


  $user = $conn->query($getUser)->fetch();

  if (isset($_POST["submitDelete"])) {
    $nid = $_POST["nav_item_id"];
    $deleteNav = "DELETE FROM `nav_items` WHERE nav_item_id = $nid";
    $upit = $conn->exec($deleteNav);
  }

  $navQuery = "SELECT `nav_item_id`, `href`, `title` FROM `nav_items`";

  $navs = $conn->query($navQuery)->fetchAll();

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
          <h1>Nav Items</h1>
          <a href="index.php?page=nav_item_insert" class="btn btn-primary mt-3">
            New Nav Item
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
                  <th>Title</th>
                  <th>Href</th>
                  <th>Edit Item</th>
                  <th>Delete Item</th>
                </tr>
                </thead>
                <tbody>
                <?php $index = 0;
                foreach ($navs as $u):
                  $index++; ?>
                  <tr>
                    <td>
                      <?= $index ?>
                    </td>
                    <td>
                      <?= $u["title"] ?>
                    </td>
                    <td>
                      <?= $u["href"] ?>
                    </td>
                    <td>
                      <a href="index.php?page=nav_item_edit&id=<?= $u["nav_item_id"] ?>"
                         class="btn btn-primary">Edit</a>
                    </td>
                    <td>
                      <button class="btn btn-danger btnDelete" data-toggle="modal" data-name="nav_item_id"
                              data-id="<?= $u["nav_item_id"] ?>" data-target="#deleteModal">
                        Delete
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Title</th>
                  <th>Href</th>
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
        <form action="<?= $_SERVER["PHP_SELF"] ?>?page=nav_data" name="deleteForm" method="POST">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="hidden" name="nav_item_id" value="0">
          <button type="submit" name="submitDelete" class="btn btn-danger">Delete it</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $u_id = $_SESSION["user_id"];
  $getUser = "SELECT * FROM users WHERE user_id = $u_id";


  $user = $conn->query($getUser)->fetch();

  if (isset($_POST["submitDelete"])) {
    $uid = $_POST["message_id"];
    $deleteUser = "DELETE FROM messages WHERE message_id = $uid";
    $upit = $conn->exec($deleteUser);
  }

  $messagesQuery = "SELECT  `message_id`,`name`, `email`, `sent_at`, `subject`, `message` FROM `messages` WHERE 1";

  $messages = $conn->query($messagesQuery)->fetchAll();


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
          <h1>Contact Messages</h1>

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
                  <th>From</th>
                  <th>Email</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Sent At</th>
                  <th>Delete Message</th>
                </tr>
                </thead>
                <tbody>
                <?php $index = 0;
                foreach ($messages as $u):
                  $index++; ?>
                  <tr>
                    <td>
                      <?= $index ?>
                    </td>
                    <td>
                      <?= $u["name"] ?>
                    </td>
                    <td>
                      <?= $u["email"] ?>
                    </td>
                    <td>
                      <?= $u["subject"] ?>
                    </td>
                    <td>
                      <?= $u["message"] ?>
                    </td>
                    <td>
                      <?= $u["sent_at"] ?>
                    </td>
                    <td>
                      <button class="btn btn-danger btnDelete" data-toggle="modal" data-name="message_id"
                              data-id="<?= $u["message_id"] ?>" data-target="#deleteModal">
                        Delete
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Id</th>
                  <th>From</th>
                  <th>Email</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Sent At</th>
                  <th>Delete Message</th>
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
        <form action="<?= $_SERVER["PHP_SELF"] ?>?page=messages_data" name="deleteForm" method="POST">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <input type="hidden" name="message_id" value="0">
          <button type="submit" name="submitDelete" class="btn btn-danger">Delete it</button>
        </form>
      </div>
    </div>
  </div>
</div>

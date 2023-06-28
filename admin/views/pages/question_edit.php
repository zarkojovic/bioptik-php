<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $u_id = $_SESSION["user_id"];
  $getUser = "SELECT * FROM users WHERE user_id = $u_id";


  $user = $conn->query($getUser)->fetch();

  if (isset($_GET["id"])) {
    $editQuestionId = $_GET["id"];
    $questionQuery = "SELECT `question_id`, `question`, `type`, `status` FROM `questions` WHERE question_id = $editQuestionId";
    $editQuestion = $conn->query($questionQuery)->fetch();

    if (!$editQuestion) {
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
          <h1>Edit Question</h1>
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
                <?= $editQuestion["question"] ?>
              </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?= $_SERVER["PHP_SELF"] ?>?page=question_edit&id=<?= $_GET["id"] ?>" method="POST">
              <div class="card-body">
                <div class="form-group">
                  <label for="question">Question</label>
                  <input type="text" class="form-control" id="question" name="question"
                         value="<?= $editQuestion["question"] ?>" placeholder="Title">
                </div>
                <div class="form-group">
                  <label for="type">Type</label>
                  <div class="form-group">
                    <select class=" form-control" id="type" name="type">
                      <option value="0" <?= $editQuestion["type"] == 0 ? "selected" : "" ?>>
                        Multiple Answers
                      </option>
                      <option value="1" <?= $editQuestion["type"] == 1 ? "selected" : "" ?>>
                        Single Answers
                      </option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="type">Status</label>
                  <div class="form-group">
                    <select class=" form-control" id="status" name="status">
                      <option value="0" <?= $editQuestion["status"] == 0 ? "selected" : "" ?>>
                        Inactive
                      </option>
                      <option value="1" <?= $editQuestion["status"] == 1 ? "selected" : "" ?>>
                        Active
                      </option>
                    </select>
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
                  <div class="alert alert-success d-none" id="successSpan" role="alert">
                    Successfully updated!
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
              <input type="hidden" name="question_id" id="question_id" value="<?= $editQuestionId ?>">
              <div class="card-footer">
                <button type="button" name="submitEditTag" id="submitEditTag"
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
<script>
  $(document).ready(function (){
    $(document).on("click","#submitEditTag",function (){
      console.log("pozz");
      let question = $("#question").val();
      let question_id = $("#question_id").val();
      let type = $("#type").val();
      let status = $("#status").val();
      let obj = {
        question: question,
        type: type,
        status: status,
        question_id: question_id,
        table: "questions"
      }
      console.log(obj);
      $.ajax({
        url:"../models/updateTable.php",
        method: "POST",
        data: obj,
        success: function (data){
          console.log(data);
          $("#successSpan").removeClass("d-none");
          setTimeout(function (){

            $("#successSpan").addClass("d-none");
          },3000);
        }
      })
    })
  })
</script>

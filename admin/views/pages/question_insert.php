<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $u_id = $_SESSION["user_id"];
  $getUser = "SELECT * FROM users WHERE user_id = $u_id";

  if (isset($_POST["submitInsertQuestion"])) {
    $brGresaka = 0;
    $errors = "";

    if (isset($_POST["question"])) {
      $question = $_POST["question"];
      if ($question == "") {
        $brGresaka++;
        $errors .= "<li>Pitanje ne sme biti prazno!</li>";
      }
    }
    if (isset($_POST["type"])) {
      $type = $_POST["type"];
      if ($type == "") {
        $brGresaka++;
        $errors .= "<li>Tip ne sme biti prazno!</li>";
      }
    }
    if (isset($_POST["status"])) {
      $status = $_POST["status"];
      if ($status == "") {
        $brGresaka++;
        $errors .= "<li>Status ne sme biti prazno!</li>";
      }
    }
    if ($brGresaka > 0) {
      redirect("index.php?page=question_insert&errors={$errors}");
    } else {
      $qid = $_POST["question_id"];

      $updateQuestionQuery = "INSERT INTO `questions`( `question`, `type`, `status`) VALUES ('$question',$type,$status)";

      // var_dump($updateNavQuery);
      $rez = $conn->exec($updateQuestionQuery);

      if ($rez) {
        redirect("index.php?page=question_data");
      }
    }
  }


  $user = $conn->query($getUser)->fetch();


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
          <h1>Insert Question</h1>
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
                New Question
              </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?= $_SERVER["PHP_SELF"] ?>?page=question_insert" name="insertForm" method="POST">
              <div class="card-body">
                <div class="form-group">
                  <label for="question">Question</label>
                  <input type="text" class="form-control" id="question" name="question"
                         placeholder="Question">
                </div>
                <div class="form-group">
                  <label for="type">Type</label>
                  <div class="form-group">
                    <select class=" form-control" id="type" name="type">
                      <option value="0">
                        Multiple Answers
                      </option>
                      <option value="1">
                        Single Answers
                      </option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="type">Status</label>
                  <div class="form-group">
                    <select class=" form-control" id="status" name="status">
                      <option value="0">
                        Inactive
                      </option>
                      <option value="1">
                        Active
                      </option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="alert alert-danger d-none" id="errorMessages" role="alert"></div>
                  <div class="alert alert-success d-none" id="successMessages" role="alert"></div>
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
              <input type="hidden" name="question_id">
              <div class="card-footer">
                <button type="button" name="submitInsertQuestion" id="submitInsertQuestion"
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
  $(document).ready(function () {
    $(document).on("click", "#submitInsertQuestion", function () {
      let question = $("#question").val();
      let type = $("#type").val();
      let status = $("#status").val();

      let err = [];

      if (question == "") {
        err.push("Pitanje ne sme biti prazno!");
      }
      if (type == "") {
        err.push("Tip ne sme biti prazno!");
      }
      if (status == "") {
        err.push("Status ne sme biti prazno!");
      }

      if (err.length > 0) {
        let html = "";
        err.forEach(el => {
          html += `${el}</br>`;
        });
        $("#errorMessages").removeClass("d-none");
        $("#errorMessages").html(html);
      } else {

        $("#errorMessages").addClass("d-none");
        $("#errorMessages").html("");
        let obj = {
          question: question,
          type: type,
          status: status,
          table: "questions"
        }
        $.ajax({
          url: "../models/insertRowInTable.php",
          method: "POST",
          data: obj,
          success: function (data) {
            $("#successMessages").removeClass("d-none");
            $("#successMessages").html("Successful insert!");
            document.forms["insertForm"].reset();
            setTimeout(function (){
              $("#successMessages").addClass("d-none");
              $("#successMessages").html("");
            },3000);
          }
        })
      }
    });
  })
</script>

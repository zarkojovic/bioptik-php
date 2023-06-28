<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $page = "answers_edit";
  $u_id = $_SESSION["user_id"];
  $getUser = "SELECT * FROM users WHERE user_id = $u_id";

  if (isset($_POST["submitEditTag"])) {
    $brGresaka = 0;
    $errors = "";

    if (isset($_POST["answer"])) {
      $answer = $_POST["answer"];
      if ($answer == "") {
        $brGresaka++;
        $errors .= "<li>Odgovor ne sme biti prazno!</li>";
      }
    }
    if (isset($_POST["question"])) {
      $question = $_POST["question"];
      if ($question == "") {
        $brGresaka++;
        $errors .= "<li>Tip ne sme biti prazno!</li>";
      }
    }
    if ($brGresaka > 0) {
      redirect("index.php?page=$page&id={$_POST["question_id"]}&errors={$errors}");
    } else {
      $aid = $_POST["answer_id"];

      $updateQuestionQuery = "UPDATE `answers` SET `answer`='$answer',`question_id`= $question WHERE answer_id = $aid";

      // var_dump($updateNavQuery);
      $rez = $conn->exec($updateQuestionQuery);

      if ($rez) {
        redirect("index.php?page=$page&id=$aid&success=1");
      }
    }
  }


  $user = $conn->query($getUser)->fetch();

  if (isset($_GET["id"])) {
    $editAnswerId = $_GET["id"];
    $answerQuery = "SELECT `answer_id`, `answer`, `question_id` FROM `answers` WHERE answer_id = $editAnswerId";
    $editAnswer = $conn->query($answerQuery)->fetch();

    $quesitonsQuery = "SELECT `question_id`, `question`, `type`, `status` FROM `questions`";
    $questions = $conn->query($quesitonsQuery)->fetchAll();


    if (!$editAnswer) {
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
                <?= $editAnswer["answer"] ?>
              </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?= $_SERVER["PHP_SELF"] ?>?page=<?= $page ?>&id=<?= $_GET["id"] ?>" method="POST">
              <div class="card-body">
                <div class="form-group">
                  <label for="question">Answer</label>
                  <input type="text" class="form-control" id="answer" name="answer"
                         value="<?= $editAnswer["answer"] ?>" placeholder="Title">
                </div>
                <div class="form-group">
                  <label for="type">Type</label>
                  <div class="form-group">
                    <select class=" form-control" id="question" name="question">
                      <?php foreach ($questions as $q): ?>
                        <option value="<?= $q["question_id"] ?>"
                          <?= $editAnswer["question_id"] == $q["question_id"] ? "selected" : "" ?>>
                          <?= $q["question"] ?>
                        </option>
                      <?php endforeach; ?>
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
                </div>
              </div>
              <!-- /.card-body -->
              <input type="hidden" name="answer_id" value="<?= $editAnswerId ?>">
              <div class="card-footer">
                <button type="submit" name="submitEditTag"
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


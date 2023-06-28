<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {

  if (isset($_POST["submitDelete"])) {
    $aid = $_POST["answer_id"];

    $deleteQuestion = "DELETE FROM `answers` WHERE answer_id = $aid";

    $upit = $conn->exec($deleteQuestion);
  }

  $answerQuery = "SELECT a.answer_id, a.answer, q.question FROM answers a, questions q WHERE q.question_id = a.question_id";

  $answers = $conn->query($answerQuery)->fetchAll();

} else {
  redirect("../../index.php");
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Answers</h1>
          <a href="insert_answer.php" class="btn btn-primary mt-3">
            New Answer
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
                  <th>Answer</th>
                  <th>Question</th>
                  <th>Edit Item</th>
                  <th>Delete Item</th>
                </tr>
                </thead>
                <tbody>
                <?php $index = 0;
                foreach ($answers as $u):
                  $index++; ?>
                  <tr>
                    <td>
                      <?= $index ?>
                    </td>
                    <td>
                      <?= $u["answer"] ?>
                    </td>
                    <td>
                      <?= $u["question"] ?>
                    </td>
                    <td>
                      <a href="edit_answer.php?id=<?= $u["answer_id"] ?>"
                         class="btn btn-primary">Edit</a>
                    </td>
                    <td>
                      <button class="btn btn-danger btnDelete" data-toggle="modal"
                              data-id="<?= $u["answer_id"] ?>" data-target="#deleteModal">
                        Delete
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Answer</th>
                  <th>Question</th>
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

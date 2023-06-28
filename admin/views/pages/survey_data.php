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

  $questionsQuery = "SELECT `question_id`, `question`, `type`, `status` FROM `questions` WHERE 1";

  $questions = $conn->query($questionsQuery)->fetchAll();



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
          <h1>Surveys</h1>

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

                <tbody>
                <?php $index = 0;
                foreach ($questions as $q):
                  $index++;
                  $answersQuery = "SELECT * FROM `answers` WHERE question_id = {$q["question_id"]}";
                  $statArray = array();
                  $answers = $conn->query($answersQuery)->fetchAll();
                  $j = 0;
                  $sum = 0; foreach ($answers as $a) {
                  $questionStatQuery = "SELECT `question`,a.answer,sa.answer_id, COUNT(sa.answer_id) as 'count' FROM questions q, answers a, surveys_answers sa WHERE a.question_id = q.question_id AND sa.answer_id = a.answer_id AND q.question_id = {$q["question_id"]} AND a.answer_id = {$a["answer_id"]};";
                  $stats = $conn->query($questionStatQuery)->fetch();
                  $statArray[$j]["answer"] = $stats["answer"];
                  $statArray[$j]["count"] = $stats["count"];
                  $sum += $statArray[$j]["count"];
                  $j++;
                }
                  echo "<tr>";
                  echo "<td>{$q["question"]} </td>";

                  foreach ($statArray as $st) {
                    $percent = round(($st["count"] / $sum) * 100, 2);
                    echo "<td>" . $st["answer"] . " - {$st["count"]} ($percent%) </td>";
                    // echo "<td>" . $st["count"] . "</td>";
                  }

                  echo "<td>Total : $sum votes</td>";
                  echo "</tr>";
                  ?>

                  </tr>
                <?php endforeach; ?>


                </tbody>
                <!-- <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>From</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Sent At</th>
                        <th>Delete Message</th>
                    </tr>
                </tfoot> -->
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

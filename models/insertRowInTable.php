<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once("../config/conn.php");
    if (isset($_POST["table"])) {
        if($_POST["table"] == "questions") {
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
                http_response_code(501);
            } else {

                $updateQuestionQuery = "INSERT INTO `questions`( `question`, `type`, `status`) VALUES ('$question',$type,$status)";

                // var_dump($updateNavQuery);
                $rez = $conn->exec($updateQuestionQuery);

                if ($rez) {
                    echo "uspeh!";
                }
            }
        }
    }
}else{
    http_response_code(404);
}
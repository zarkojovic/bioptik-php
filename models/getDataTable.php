<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once("../config/conn.php");
    if(isset($_POST["table"])){
        if($_POST["table"] == "questions"){
            $questionsQuery = "SELECT `question_id`, `question`, `type`, `status` FROM `questions`";
            $questions = $conn->query($questionsQuery)->fetchAll();
            if($questions){
                echo json_encode($questions);
            }
        }
    }
}else{
    http_response_code(404);
}
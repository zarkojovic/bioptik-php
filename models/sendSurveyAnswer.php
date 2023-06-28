<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include_once("../config/conn.php");
    $answer = $_POST["answer"];
    $question = $_POST["question"];
    $u_id = $_SESSION["user_id"];

//    $insertSurvey = "INSERT INTO `surveys`(`user_id`, `question_id`) VALUES ('$u_id','$question');";
//    $conn->query($insertSurvey);
//    $sid = $conn->lastInsertId();
//    $insertQuery = "INSERT INTO `surveys_answers`(`survey_id`, `answer_id`) VALUES ('$sid','$answer')";
//    $conn->query($insertQuery);
    echo json_encode($question);
    if (is_array($answer)) {
        $insertSurvey = "INSERT INTO `surveys`(`user_id`, `question_id`) VALUES ('$u_id','$question');";
        $conn->query($insertSurvey);
        $sid = $conn->lastInsertId();
        foreach ($answer as $unos) {
            $insertQuery = "INSERT INTO `surveys_answers`(`survey_id`, `answer_id`) VALUES ('$sid','$unos')";
            $conn->query($insertQuery);
        }

    } else {
        $insertSurvey = "INSERT INTO `surveys`(`user_id`, `question_id`) VALUES ('$u_id','$question');";
        $conn->query($insertSurvey);
        $sid = $conn->lastInsertId();
        $insertQuery = "INSERT INTO `surveys_answers`(`survey_id`, `answer_id`) VALUES ('$sid','$answer')";
        $conn->query($insertQuery);
    }
    echo "USPEH!";


//    if (isset($_SESSION["user_id"])) {
//        $user_id = $_SESSION["user_id"];
//        $surveyQuery = "SELECT * FROM `questions` WHERE question_id NOT IN (SELECT DISTINCT question_id FROM surveys WHERE user_id = $user_id) AND status = 1";
//        $getQuestion = $conn->query($surveyQuery)->fetch();
//        echo $getQuestion;
//    }else{
//        http_response_code(501);
//    }
}else{
    http_response_code(404);

}
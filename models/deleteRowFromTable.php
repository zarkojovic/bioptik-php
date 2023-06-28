<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include_once ("../config/conn.php");
    if(isset($_POST["table"])){
        if($_POST["table"] == "questions"){


            $qid = $_POST["id"];
            $deleteAnswers = "DELETE FROM `answers` WHERE question_id = $qid";
            $izbrisi = $conn->exec($deleteAnswers);

            $deleteQuestion = "DELETE FROM `questions` WHERE question_id = $qid";
            $upit = $conn->exec($deleteQuestion);
            if($upit){
                echo "useph!";
            }else{
                echo "neuspeh buraz ".$qid;
            }
        }
    }
}else{
    http_response_code(404);
}
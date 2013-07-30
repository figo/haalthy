<?php
$connect=mysqli_connect("127.0.0.1","root","","forum");
if(!$connect)
    echo "connect error";
else{
    $answerRowData = file_get_contents("php://input"); 
    $recvData = preg_split("/&/", $answerRowData);
    $patient = $recvData[0];
    $patientInfo = preg_split("/=/", $patient);
    $patientID = $patientInfo[1];
    unset($recvData[0]);
    $answers = array_values($recvData);
    foreach($answers as $answer){
        $questionAndAnswer = preg_split("/=/", $answer);
        $question = $questionAndAnswer[0];
        $questionLen = strlen("Question");
        $questionId = substr($question, $questionLen, strlen($question)-$questionLen);
        $newAnswer = $questionAndAnswer[1];
        if($answer){
            $editPatientSql = "update PatientAnswerSheet set Answer='".$newAnswer."' where PatientID = ".$patientID." and QuestionID=".$questionId.";";
            print_r($editPatientSql);
            mysqli_query($connect, $editPatientSql);
        }
    }
} 
mysqli_close($connect);
?>

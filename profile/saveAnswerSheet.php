<?php
$connect=mysqli_connect("127.0.0.1","root","","forum");
if(!$connect)
    echo "connect error";
else{
    $answerRowData = file_get_contents("php://input"); 
    $recvData = preg_split("/&/", $answerRowData);
    $user = $recvData[0];
    $userName = preg_split("/=/", $user);
    $userValue = $userName[1];
    $today = getdate();
    $patientName = $userValue.".Patient.".$today['0'];
    mysqli_query($connect,"insert into Patient (name) values ('".$patientName."');");
    $patients = mysqli_query($connect, "select * from Patient where name = '".$patientName."'");
    $patientID;
    while($patient = mysqli_fetch_array($patients)){
        $patientID = $patient['PatientID'];
    }
    $users = mysqli_query($connect, "select * from GDN_User where Name = '".$userValue."';");
    $userID;
    while($user = mysqli_fetch_array($users)){
        $userID = $user['UserID'];
    }
    mysqli_query($connect, "insert into UserPatient(UserID, PatientID) values('".$userID."','".$patientID."')");
    unset($recvData[0]);
    $answers = array_values($recvData);
    foreach($answers as $answer){
        $questionAndAnswer = preg_split("/=/", $answer);
        $question = $questionAndAnswer[0];
        $questionLen = strlen("Question");
        $questionId = substr($question, $questionLen, strlen($question)-$questionLen);
        $answer = $questionAndAnswer[1];
//        if($answer){
            $insertPatientSql = "insert into PatientAnswerSheet(PatientID, QuestionID, Answer) values('".$patientID."','".$questionId."','".$answer."')";
            mysqli_query($connect, $insertPatientSql);
            print_r($insertPatientSql);
//        }
    }
} 
mysqli_close($connect);
?>

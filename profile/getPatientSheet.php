<?php
    $user = $_POST['user'];
    if(!$user)
        $user = file_get_contents("php://input");
    $connect=mysqli_connect("127.0.0.1","root","","forum");
    if(!$connect) 
        echo "connect Error!";
    else {
        echo "<div id='patientRecord'>";
            $getPatientsSql = mysqli_query($connect, "select * from UserPatient where UserID=(select UserID from GDN_User where Name='".$user."')");
            while($patient = mysqli_fetch_array($getPatientsSql)){
                echo "<table border=0 class = 'PatientInfo'>";
                $getAnswersSql = mysqli_query($connect, "select q.Keywords, a.answer from Question q, PatientAnswerSheet a where (q.QuestionID = a.QuestionID and a.PatientID = ".$patient['PatientID'].")");
                while($answer = mysqli_fetch_array($getAnswersSql)){
                    echo "<tr>";
                    echo "<td width = '25%'>".$answer['Keywords'].":</td><td>".$answer['answer']."</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "
                    <form name='editPatient' action='editpatient.php' method='post'>
                    <input type='hidden' name='patientID' value='".$patient['PatientID']."'>
                    <input type='hidden' name='user' value='".$user."'>
                    <input type='submit' name='action' value='edit'>
                    <input type='submit' name='action' value='delete' onclick='javascript:deletePatient(\"".$patient['PatientID']."\",\"".$user."\")'>
                    </form>
                    ";
            }
        echo "</div>";
    }
    mysqli_close($connect);
?>


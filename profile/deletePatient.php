<?php
$connect=mysqli_connect("127.0.0.1","root","","forum");
if(!$connect)
    echo "connect error";
else{
    $patientID = file_get_contents("php://input");
    mysqli_query($connect, "delete from Patient where PatientID=".$patientID);
    mysqli_query($connect, "delete from UserPatient where PatientID=".$patientID);
    mysqli_close();
}
?>

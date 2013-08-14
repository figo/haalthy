<html>
    <?php
        include ('header.php');
    ?>
    <body>
    <?php
        include ('divHead.php');
    ?>
        <div id='Content'>
<div class = 'PatientSheet'>
    Patient Record
</div>
<div id = 'PatientInfo'>
<?php
    include('getPatientSheet.php');
?> 
</div>
</div>
<?php
        session_start();
?>
    <br>
    <form name='addPatient' action='addpatient.php' method='post'>
    <?php
        echo "<input type='hidden' name='user' value='".$_SESSION['user']."'>";
    ?>
    <input type='submit' value='add a new patient profile'>
    </form>
    </body>
</html>

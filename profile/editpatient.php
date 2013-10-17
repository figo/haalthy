<html>
    <?php
        include ('header.php');
    ?>
    <body>
    <?php
        include ('divHead.php');
        if(strlen($_POST['patientID'])>0){
            if($_POST['action'] == 'edit')
                include ('editQuestionSheet.php');
        }else{
        }
?>
    <form name='addPatient' action='addpatient.php' method='post'>
    <?php
        echo "<input type='hidden' name='user' value='".$_POST['user']."'>";
    ?>
    <input type='submit' value='add a new patient profile'>
    </form>
</body>

</html>

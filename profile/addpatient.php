<html>
    <?php
        include ('header.php');
    ?>
    <body>
    <?php
        include ('divHead.php');
        echo $_SESSION['user'];
        if(strlen($_POST['user'])>0){
            include ('questionSheet.php');
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

<div id='Content'>
<div class = 'PatientSheet'>
    Patient Record
</div>
<?php
    $connect=mysqli_connect("127.0.0.1","root","","forum");
    if(!$connect) 
        echo "connect Error!";
    else {
        echo "<div id='patientRecord'>";
        $user = $_POST['user'];
        echo "<form name='input' action='javascript:saveAnswerSheet(\"".$user."\")' method='post'>";
        $questions = mysqli_query($connect,"select * from Question where questionID in (select questionId from QuestionSheet where QuestionSheetId=1) order by questionId;");
        while($question = mysqli_fetch_array($questions))
        {
            echo "<div class = 'QuestionHead'>";
              echo $question['Content'];
            echo "<br></div>";
            $options = mysqli_query($connect, "select * from QuestionOption where questionID = ".$question['QuestionID']);
            echo "<div class = 'Answer'>";
            while($option = mysqli_fetch_array($options)){
                echo "<input type='radio' class='option' name='Question".$option['QuestionID']."' onclick = 'javascript:getNextQuestionSheet(".$option['OptionID'].",".$option['QuestionID'].")' value='".$option['Content']."'>".$option['Content']."<br>";
            }
            echo "</div>";
            echo "<div id='nextQuestionSheet".$question['QuestionID']."'></div>";
         }
         echo "<input type='submit' name='savepatient' value='save'>";
         echo "</form>";
         echo "</div>";
    }
    mysqli_close($connect);

?> 

</div>

<?php 
    $connect=mysqli_connect("127.0.0.1","root","","forum");
    if(!$connect) 
        echo "connect Error!";
    else {
        $questions = mysqli_query($connect,"select * from Question where questionID in (select questionId from QuestionSheet where QuestionSheetId=(select RelativeQuestionSheet from QuestionOption where optionId=".$_GET['optionId'].")) order by questionId;");
        while($question = mysqli_fetch_array($questions))
        {
            echo "<div class = 'QuestionHead'>";
              echo $question['Content'];
            echo "<br></div>";
            $options = mysqli_query($connect, "select * from QuestionOption where questionID = ".$question['QuestionID']);
            echo "<div class = 'Answer'>";
            while($option = mysqli_fetch_array($options)){
                echo "<input type='radio' class='option' name='Question".$question['QuestionID']."' onclick = 'javascript:getNextQuestionSheet(".$option['OptionID'].",".$option['QuestionID'].")' value='".$option['Content']."'>".$option['Content']."<br>";
            }
            echo "</div>";
            echo "<div id='nextQuestionSheet".$question['QuestionID']."'></div>";
         }

    }
    mysqli_close($connect);


?>

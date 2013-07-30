<div id='Content'>
<div class = 'PatientSheet'>
    Patient Record
</div>
<?php
    $connect=mysqli_connect("127.0.0.1","root","","forum");
    if(!$connect) 
        echo "connect Error!";
    else {
        $patientID = $_POST['patientID'];
        $user = $_POST['user'];
        if($patientID){
            echo "<div id='patientRecord'>";
            echo "<form name='input' action='javascript:editAnswerSheet(\"".$patientID."\",\"".$user."\")' method='post'>";
            $answers = mysqli_query($connect,"select q.QuestionID, q.Content, p.Answer from PatientAnswerSheet p, Question q where p.patientID = ".$patientID." and p.QuestionID = q.QuestionID order by p.QuestionID");
            $nextQuestionSheetTagged = 0;
            $nextQuestionSheetTaggedEnd = 0;
            while($answer = mysqli_fetch_array($answers)){
                if($answer['QuestionID']>1){
                    if(!$nextQuestionSheetTagged){
                        echo "<div id='nextQuestionSheet1'>";
                        $nextQuestionSheetTagged = 1;
                    }
                }
                echo "<div class = 'QuestionHead'>";
                echo $answer['Content'];
                echo "<br></div>";
                $options = mysqli_query($connect, "select * from QuestionOption where questionID = ".$answer['QuestionID']);
                echo "<div class = 'Answer'>";
                while($option = mysqli_fetch_array($options)){
                    $optionRadio = '';
                    if($answer['Answer']==$option['Content'])
                        $optionRadio = "<input type='radio' class='option' name='Question".$option['QuestionID']."' onclick = 'javascript:getNextQuestionSheet(".$option['OptionID'].",".$option['QuestionID'].")' value='".$option['Content']."' checked='checked'>".$option['Content']."<br>";
                    if(strlen($optionRadio)==0){
                        $optionRadio = "<input type='radio' class='option' name='Question".$option['QuestionID']."' onclick = 'javascript:getNextQuestionSheet(".$option['OptionID'].",".$option['QuestionID'].")' value='".$option['Content']."'>".$option['Content']."<br>";
                    }
                    echo $optionRadio;
                }
                echo "</div>";
                                //echo "<div id='nextQuestionSheet".$answer['QuestionID']."'></div>";
            }
            if(($nextQuestionSheetTagged)&&(!$nextQuestionSheetTaggedEnd)){
                    $nextQuestionSheetTaggedEnd = 1;
                    echo "</div>";
                }

            echo "<input type='submit' name='savepatient' value='save'>";
            echo "</form>";
            echo "</div>";
        }
    mysqli_close($connect);
    }

?> 
</div>

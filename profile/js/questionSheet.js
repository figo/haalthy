var user;
var optionId;
var questionId;
var getQuestionSheetHttpresq;
var saveAnswerSheetHttpresq;
var getPatientSheetHttpresq;
var deletePatientHttpresq;
function getNextQuestionSheet(optionID,questionID){
    optionId = optionID;
    questionId = questionID;
    var httpLink = 'http://192.168.16.133/profile/nextQuestionSheet.php?optionId='+optionId;
    getQuestionSheetHttpresq = new XMLHttpRequest();
    getQuestionSheetHttpresq.open( "GET", httpLink, false );
    getQuestionSheetHttpresq.onreadystatechange = handler;
    getQuestionSheetHttpresq.send();
}

function handler(evtXHR)
{
    if (getQuestionSheetHttpresq.readyState == 4)
    {
        if (getQuestionSheetHttpresq.status == 200)
        {
            var questionSheetDivId = "nextQuestionSheet"+questionId;
            var questionSheetDiv = document.getElementById(questionSheetDivId);
            if(questionSheetDiv)
                questionSheetDiv.innerHTML = getQuestionSheetHttpresq.responseText;
        }
    }
}

function saveAnswerSheet(usr){
    user = usr;
   var options = document.getElementsByClassName('option');
   var answerSheetParam = 'user='+user+'&';
   var listQuestionArray = new Array();
   var checkedQuestionArray = new Array();
   for(var i = 0; i < options.length; i++){
      var option = options[i];
       if(listQuestionArray.indexOf(option.name)<0)
           listQuestionArray.push(option.name);
      if((option.type=='radio')&&(option.checked==true)){
          checkedQuestionArray.push(option.name);
        answerSheetParam += option.name + '=' + option.value + '&';
      }
   }
   for(var i=0; i<listQuestionArray.length; i++){
        var question = listQuestionArray[i];
        if(checkedQuestionArray.indexOf(question)<0)
            answerSheetParam +=question+'=&';
   }

    var httpLink = 'http://192.168.16.133/profile/saveAnswerSheet.php';
    saveAnswerSheetHttpresq = new XMLHttpRequest();
    saveAnswerSheetHttpresq.open( "post", httpLink, false );
    saveAnswerSheetHttpresq.onreadystatechange = posthandler;
    saveAnswerSheetHttpresq.send(answerSheetParam);
}

function editAnswerSheet(patientID,usr){
    user = usr;
   var options = document.getElementsByClassName('option');
   var answerSheetParam = 'patientID='+patientID+'&';
   for(var i = 0; i < options.length; i++){
      var option = options[i];
      if((option.type=='radio')&&(option.checked==true)){
        answerSheetParam += option.name + '=' + option.value + '&';
      }
   }
    var httpLink = 'http://192.168.16.133/profile/editAnswerSheet.php';
    saveAnswerSheetHttpresq = new XMLHttpRequest();
    saveAnswerSheetHttpresq.open( "post", httpLink, false );
    saveAnswerSheetHttpresq.onreadystatechange = posthandler;
    saveAnswerSheetHttpresq.send(answerSheetParam);
}

function posthandler(evtXHR){
/*    if (saveAnswerSheetHttpresq.readyState == 4)
    {
        if (saveAnswerSheetHttpresq.status == 200)
        {
*/
            var httpLink = 'http://192.168.16.133/profile/getPatientSheet.php'
            getPatientSheetHttpresq = new XMLHttpRequest();
            getPatientSheetHttpresq.open( "post", httpLink, false );
            getPatientSheetHttpresq.onreadystatechange = getpatienthandler;
            getPatientSheetHttpresq.send(user);
/*        }
    }*/

}

function getpatienthandler(evtXHR){
    if(getPatientSheetHttpresq.readyState == 4){
        if(getPatientSheetHttpresq.status == 200) {
            var questionSheetDiv = document.getElementById('patientRecord');
            questionSheetDiv.innerHTML = getPatientSheetHttpresq.responseText;
        }
    }
}

function deletePatient(patientID,usr){
    user = usr;
    var httpLink = 'http://192.168.16.133/profile/deletePatient.php';
     deletePatientHttpresq = new XMLHttpRequest();
     deletePatientHttpresq.open( "post", httpLink, false );
     deletePatientHttpresq.onreadystatechange = posthandler;
     deletePatientHttpresq.send(patientID);
}

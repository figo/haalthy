<?php if (!defined('APPLICATION')) exit(); ?>
<h1><?php echo T('Thank You!'); ?></h1>
<div class="Box">
   <p><?php echo T('Your application will be reviewed by an administrator. You will be notified by email if your application is approved.'); ?></p>
   <p><?php 
	    $Session = Gdn::Session();
        $ProfileSlug = $Session->User->Name;
        $patientForm = "<form id='subPatient' action='http://192.168.16.133/profile/addpatient.php' method='post'> <input type='hidden' name='user' value="."'".$ProfileSlug."'"."/> <a href='javascript:document.getElementById("."\""."subPatient"."\"".").submit();'>Patients</a></form>";
        echo T('Would you please input your patients information, so we can learn more about you and give u some suggestion?'); 
        echo $patientForm;
        ?>
   </div>
</p>


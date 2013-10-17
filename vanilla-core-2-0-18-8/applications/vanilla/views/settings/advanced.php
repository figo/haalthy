<?php if (!defined('APPLICATION')) exit();
echo $this->Form->Open();
echo $this->Form->Errors();
include './conf/config-defaults.php';
//include 'loginQQ.php';
?>
<h1><?php echo T('Advanced'); ?></h1>
<ul>
   <li>
      <?php
         $Options = array('10' => '10', '15' => '15', '20' => '20', '25' => '25', '30' => '30', '50' => '50', '100' => '100');
         $Fields = array('TextField' => 'Code', 'ValueField' => 'Code');
         echo $this->Form->Label('Discussions per Page', 'Vanilla.Discussions.PerPage');
         echo $this->Form->DropDown('Vanilla.Discussions.PerPage', $Options, $Fields);
      ?>
   </li>
   <li>
      <?php
         echo $this->Form->Label('Comments per Page', 'Vanilla.Comments.PerPage');
         echo $this->Form->DropDown('Vanilla.Comments.PerPage', $Options, $Fields);
      ?>
   </li>
   <li>
      <?php
         $Options = array('0' => T('Authors cannot edit their posts'),
                        '350' => T('Authors can edit for 5 minutes after posting'), 
                        '900' => T('Authors can edit for 15 minutes after posting'), 
                       '1800' => T('Authors can edit for 30 minutes after posting'),
                      '86400' => T('Authors can edit for 1 day after posting'),
                     '604800' => T('Authors can edit for 1 week after posting'),
                    '2592000' => T('Authors can edit for 1 month after posting'),
                         '-1' => T('Authors can always edit their posts'));
         $Fields = array('TextField' => 'Text', 'ValueField' => 'Code');
         echo $this->Form->Label('Discussion & Comment Editing', 'Garden.EditContentTimeout');
         echo $this->Form->DropDown('Garden.EditContentTimeout', $Options, $Fields);
			echo Wrap(T('EditContentTimeout.Notes', 'Note: If a user is in a role that has permission to edit content, those permissions will override any value selected here.'), 'div', array('class' => 'Info'));
      ?>
   </li>
   <li>
      <?php
         $Options2 = array('0' => T('Don\'t Refresh'), 
                           '5' => T('Every 5 seconds'),
                          '10' => T('Every 10 seconds'),
                          '30' => T('Every 30 seconds'),
                          '60' => T('Every 1 minute'),
                         '300' => T('Every 5 minutes'));
         echo $this->Form->Label('Refresh Comments', 'Vanilla.Comments.AutoRefresh');
         echo $this->Form->DropDown('Vanilla.Comments.AutoRefresh', $Options2, $Fields);
      ?>
   </li>
   <li>
      <?php
         echo $this->Form->Label('Archive Discussions', 'Vanilla.Archive.Date');
			echo '<div class="Info">',
				T('Vanilla.Archive.Description', 'You can choose to archive forum discussions older than a certain date. Archived discussions are effectively closed, allowing no new posts.'),
				'</div>';
         echo $this->Form->Calendar('Vanilla.Archive.Date');
			echo ' '.T('(YYYY-mm-dd)');
      ?>
   </li>
	<li>
      <?php
         echo $this->Form->CheckBox('Vanilla.Archive.Exclude', 'Exclude archived discussions from the discussions list');
      ?>
   </li>
   <li>
      <?php
         echo $this->Form->Label('Content From Other Source');
         echo '<div class="Info">',T('','Content From QQ Group Chat Log'),'</div>';
         echo '<table>';
         $gids = array();
         $qqId = $Configuration['QQ']['Id'];
         $qqpwd = $Configuration['QQ']['pwd'];
         if($qqId){
             $groupsArr = explode(' ', $Configuration['QQ']['groups']);
             echo '<tr><td>Default QQ:</td><td>'.$qqId.'</td></tr>';
             echo '<tr><td>Group Log</td><td>';
             foreach($groupsArr as $group){
                 $gInfo = explode('.', $group);
                 array_push($gids, $gInfo[1]);
                 echo '<div id = "'.$gInfo[1].'">';
                 echo $gInfo[0].'<br>';
                 echo '<div id = "chatLog'.$gInfo[1].'" ></div>';
                 echo '</div>';
             } 
             echo '</td></tr>';
         }else{
              
         }
         echo '</table>';
?>
             <script>
         var xmlHttp;
         var gidsStr;
         function getChatLog(qqId, qqpwd, veriCode, gids){
             gidsStr = gids;
             if(veriCode==0){
                 veriCode = document.getElementById('verifycode').value;
             }
             var chatDate = document.getElementById("chatDate");
             var url = 'http://'+window.location.hostname+'/vanilla-core-2-0-18-8/applications/vanilla/views/settings/getDiscussionByChat.php?&gids='+gids+'&chatdate='+chatDate;
             //alert(url);
             /*
             var gidsArr = gids.split(",");
             var i;
             for(i = 0; i < gidsArr.length; i++){
                var chatLog = document.getElementById("chatLog".$gidsArr[i]);
                 
         }*/
             xmlHttp = new XMLHttpRequest();
             xmlHttp.open( "GET", url, false );
             xmlHttp.onreadystatechange = receiveChatLog;
             xmlHttp.send(); 
         }
         function receiveChatLog(){
             if ((xmlHttp.readyState == 4)&&(xmlHttp.status == 200))
             {
                 //alert(xmlHttp.responseText);
             }
         }
         var getVeriImageHttp;
         var qqid;
         function getVeriImage(qqId){
             qqid = qqId;
             var url = 'http://'+window.location.hostname+'/vanilla-core-2-0-18-8/applications/vanilla/views/settings/getVeriImage.php?qqId='+qqId;
             getVeriImageHttp = new XMLHttpRequest();
             getVeriImageHttp.open( "GET", url, false );
             getVeriImageHttp.onreadystatechange = receiveVeriImage;
             getVeriImageHttp.send(); 
         }
         function receiveVeriImage(){
            document.getElementById('imgVerify').src = "veriImage"+qqid+".png";
         }
            </script>
<?php
         $ptvfsession;
         function check_verify($qqId)
         {
             $temp_dir = tempnam(sys_get_temp_dir(), 'loginQQ');
             $ch = curl_init("http://ptlogin2.qq.com/check?uin={$qqId}&appid=1003903&js_ver=10046&js_type=0&login_sig=2yl9aqteJokdziSaA7OZdsPLQnwx5fdSbnAufskAnJ7pKWAnIhRIMQDN5RNHBAVs&u1=http%3A%2F%2Fweb2.qq.com%2Floginproxy.html&r=0.7583650903003927");
             $cookie = "pgv_pvid=2152677377; pt2gguin=o00{$qqId}; o_cookie={$qqId}; ptui_loginuin={$qqId}; ptcz=8586f1a8e63922675b98b66120309d67f3aa3bb670808ea4248ad0c01d24ca28; lv_irt_id=6dd888e29706679e311ff39aeaa5c1d2; RK=CRZH4Baakp; pgv_info=pgvReferrer=&ssid=s1599367146; chkuin={$qqId}; uin=o00{$qqId}; skey=@0N4D4Gs3e; ETK=Wd7zGrrwxyI-XFlPxXTeV62pw94asVtCgay2z8FVLE5snIiJcNr2suYCNy0yvzZx7v4sU-ChGKc4pI7Jj8G9Lw__; superuin=o00{$qqId}; superkey=-05J03M5a6vTyCozTA3PhE8rcB*oGKamKychasenxJ8_; supertoken=3311387555; ptisp=os; ptuserinfo=4c696c79; confirmuin={$qqId}; ptvfsession=00cbe4e6206f12ea4dbd4bc0c7ed1384b020075d0c2adcee47f5e3320c6c2d659b74a956a746d49d429d5f3eba1ce693";
             curl_setopt($ch, CURLOPT_COOKIE, $cookie);
             curl_setopt($ch, CURLOPT_COOKIESESSION, true);
             curl_setopt($ch, CURLOPT_COOKIEFILE, $temp_dir."cookie");
             curl_setopt($ch, CURLOPT_COOKIEJAR, $temp_dir."cookie");
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($ch, CURLOPT_HEADER, true);
             curl_setopt($ch, CURLINFO_HEADER_OUT, true);
             $data = curl_exec($ch);
            //echo $data;
            preg_match('/ptvfsession=\w*/', $data, $m);
            $cookies = explode('=', $m[0]);
            global $ptvfsession;
            $ptvfsession = $cookies[1];
            $information = curl_getinfo($ch);
            if (preg_match("/ptui_checkVC\('(.*)','(.*)','(.*)'\);/", $data, $verify))
            {
                $returnArr = array_slice($verify, 1);
                return $returnArr[1];
            }
         }
         $veriCode = check_verify($qqId);
         if(strlen($veriCode) == 48){
/*             $ch = curl_init("http://captcha.qq.com/getimage?aid=1003903&r=0.4113517610392986&uin=".$qqId);
             $cookie = "pgv_pvid=2152677377; pt2gguin=o00{$qqId}; o_cookie={$qqId}; ptui_loginuin={$qqId}; ptcz=8586f1a8e63922675b98b66120309d67f3aa3bb670808ea4248ad0c01d24ca28; lv_irt_id=6dd888e29706679e311ff39aeaa5c1d2; RK=CRZH4Baakp; pgv_info=pgvReferrer=&ssid=s1599367146; chkuin={$qqId}; uin=o00{$qqId}; skey=@0N4D4Gs3e; ETK=Wd7zGrrwxyI-XFlPxXTeV62pw94asVtCgay2z8FVLE5snIiJcNr2suYCNy0yvzZx7v4sU-ChGKc4pI7Jj8G9Lw__; superuin=o00{$qqId}; superkey=-05J03M5a6vTyCozTA3PhE8rcB*oGKamKychasenxJ8_; supertoken=3311387555; ptisp=os; ptuserinfo=4c696c79; confirmuin={$qqId}; ptvfsession=00cbe4e6206f12ea4dbd4bc0c7ed1384b020075d0c2adcee47f5e3320c6c2d659b74a956a746d49d429d5f3eba1ce693";
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $temp_dir."cookie");
    curl_setopt($ch, CURLOPT_COOKIEJAR, $temp_dir."cookie");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_HEADER, true);
//    curl_setopt($ch, CURLINFO_HEADER_OUT, true); 
    $data = curl_exec($ch);
    echo $data;
    $fh = fopen('/User/lily/filename.jpg', 'wx');
    fwrite($fh, $data);
    fclose($fh);*/
//            file_put_contents("veriImage".$qqId.".png", file_get_contents("http://captcha.qq.com/getimage?aid=1003903&r=0.4113517610392986&uin=".$qqId));
//            echo '<img width="130" height="53" id="imgVerify" src="veriImage'.$qqId.'.png"><input type="text" maxlength="5" value="" width = "80" style="ime-mode:disabled" name="verifycode" id="verifycode" autocomplete="off">';
//            echo '<img width="130" height="53" id="imgVerify" src="https://ssl.captcha.qq.com/getimage?aid=1003903&r=0.9889829835739483&uin=494681475"><input type="text" maxlength="5" value="" width = "80" style="ime-mode:disabled" name="verifycode" id="verifycode" autocomplete="off">';
//            echo '<button onclick="getVeriImage(\''.$qqId.'\');">click to use another image</button>';
         }else if(strlen($veriCode) == 4){
             $gidsStr;
             foreach($gids as $gid)
                 $gidsStr = $gidStr + ',' + $gid;
             echo '<input type ="text" maxlength="8" id="chatDate">input chat date(eg:20131013)';
             echo '<button onclick="getChatLog(\''.$qqId.'\',\''.$qqpwd.'\',\''.$veriCode.'\',\''.$gidsStr.'\');">get Discussion By Chat Content</button>';
         }

      ?>
   </li>
</ul>
<?php echo $this->Form->Close('Save');

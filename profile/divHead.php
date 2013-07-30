<?php
echo '
<div id="Head">
    <div class="Menu">
            <h1><a href="/vanilla-core-2-0-18-8/index.php?p=/" class="Title"><span>Smart Treatment</span></a></h1>
            <ul id="Menu">
                <li class="Discussions Highlight"><a href="/vanilla-core-2-0-18-8/index.php?p=/discussions">Discussions</a></li>
                <li class="Activity"><a href="/vanilla-core-2-0-18-8/index.php?p=/activity">Activity</a></li>
                <li class="Inbox"><a href="/vanilla-core-2-0-18-8/index.php?p=/messages/all">Inbox</a></li>
                <li class="UserNotifications"><a href="/vanilla-core-2-0-18-8/index.php?p=/profile/'.$_POST['user'].'">'.$_POST['user'].'</a></li>
                <li class="UserNotifications">
                    <form method="post" action="http://192.168.16.133/profile/patients.php" name="subPatient">
                        <input type="hidden" value="'.$_POST['user'].'" name="user">
                        <a href="javascript:document.subPatient.submit();">Patients</a>
                    </form></li>
                <li class="NonTab SignOut"><a href="/vanilla-core-2-0-18-8/index.php?p=/entry/signout&amp;TransientKey=CLGG5WVGWWRC">Sign Out</a></li>
             </ul>
             <div class="Search">
              <form action="/vanilla-core-2-0-18-8/index.php" method="get">
                <div>
                    <input type="hidden" value="/search" name="p">
                    <input type="text" class="InputBox" value="" name="Search" id="Form_Search">
                    <input type="submit" class="Button" value="Go" id="Form_Go">
                 </div>
                </form>
               </div>
    </div>
    </div>';
?>

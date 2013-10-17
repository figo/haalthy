<table>
<?php
    $connect=mysqli_connect("127.0.0.1","root","","forum");
    if(!$connect) 
        echo "connect Error!";
    else {
        session_start();
        $getFollowedTagsSql = mysqli_query($connect, "select TagID from GDN_UserTag where UserID=".$_SESSION['userID']);
        $followedTags = array();
        while($followedTag = mysqli_fetch_array($getFollowedTagsSql)){
            array_push($followedTags, $followedTag['TagID']);            
        }
        $getAllTagsSql = mysqli_query($connect, "select * from GDN_Tag");
        while($tag = mysqli_fetch_array($getAllTagsSql)){
            $tagsInfo = array();
            array_push($tagsInfo, $tag['TagID']);
            array_push($tagsInfo, $tag['CountDiscussions']);
            array_push($tagsInfo, $tag['countFollowers']);
            echo "<tr>";
            echo "<td class='main-td' width=33% padding=12px valign='top'>";
            if(in_Array($tag['TagID'], $followedTags))
                echo "<a id='".$tag['Name']."' class='followed tag' href='/vanilla-core-2-0-18-8/index.php?p=/discussions/tagged&Tag=".$tag['Name']."'>".$tag['Name']."</a>";
            else
                echo "<a id='".$tag['Name']."' class='unfollowed tag' href='/vanilla-core-2-0-18-8/index.php?p=/discussions/tagged&Tag=".$tag['Name']."'>".$tag['Name']."</a>";
            echo "<div class = 'tagDescription'>".$tag['Description']."</div>";
       //     if(in_Array($tag['TagID'], $followedTags))
       //         echo "<a href='javascript:changeToUnFavorite(".$tag['TagID'].", ".$_SESSION['userID'].", \"/vanilla-core-2-0-18-8/index.php?p=/plugin/updateusertag\"); changeTagInListToUnFavorite(".$tag['TagID'].",".$_SESSION['userID'].");' id='TagList".$tag['TagID']."'>unfollow this tag</a>";
      //      else
      //          echo "<a href='javascript:changeToFavorite(".$tag['TagID'].", ".$_SESSION['userID'].", \"/vanilla-core-2-0-18-8/index.php?p=/plugin/updateusertag\"); changeTagInListToFavorite(".$tag['TagID'].",".$_SESSION['userID'].");' id='TagList".$tag['TagID']."'>follow this tag</a>";
            echo "</td>";
            $tdIndex = 1;
            do{
                $tag = mysqli_fetch_array($getAllTagsSql);
                array_push($tagsInfo, $tag['TagID']);
                array_push($tagsInfo, $tag['CountDiscussions']);
                array_push($tagsInfo, $tag['countFollowers']);
                if(!$tag){
                    break;
                }
                echo "<td class='main-td' width=33% padding=12px>";
                if(in_Array($tag['TagID'], $followedTags))
                    echo "<a id='".$tag['Name']."' class='followed tag' href='/vanilla-core-2-0-18-8/index.php?p=/discussions/tagged&Tag=".$tag['Name']."'>".$tag['Name']."</a>";
                else
                    echo "<a id='".$tag['Name']."' class='unfollowed tag' href='/vanilla-core-2-0-18-8/index.php?p=/discussions/tagged&Tag=".$tag['Name']."'>".$tag['Name']."</a>";
                echo "<div class = 'tagDescription'>".$tag['Description']."</div>";
     //           if(in_Array($tag['TagID'], $followedTags))
     //               echo "<a href='javascript:changeToUnFavorite(".$tag['TagID'].", ".$_SESSION['userID'].", \"/vanilla-core-2-0-18-8/index.php?p=/plugin/updateusertag\");'>unfollow this tag</a>";
      //          else
     //               echo "<a href='javascript:changeToFavorite(".$tag['TagID'].", ".$_SESSION['userID'].", \"/vanilla-core-2-0-18-8/index.php?p=/plugin/updateusertag\");'>follow this tag</a>";
                echo "</td>";
                $tdIndex++;
            }while($tdIndex<3); 
            echo "</tr>";
            echo "<tr>";
            for($i=0; $i<$tdIndex; $i++){
                echo "<td class='main-td' width=33% padding=12px valign='top'>";
                if(in_Array($tagsInfo[$i*3], $followedTags))
                    echo "<a href='javascript:changeToUnFavorite(".$tagsInfo[$i*3].", ".$_SESSION['userID'].", \"/vanilla-core-2-0-18-8/index.php?p=/plugin/updateusertag\"); changeTagInListToUnFavorite(".$tagsInfo[$i*3].",".$_SESSION['userID'].");' id='TagList".$tagsInfo[$i*3]."'>unfollow this tag</a>";
                else
                    echo "<a href='javascript:changeToFavorite(".$tagsInfo[$i*3].", ".$_SESSION['userID'].", \"/vanilla-core-2-0-18-8/index.php?p=/plugin/updateusertag\"); changeTagInListToFavorite(".$tagsInfo[$i*3].",".$_SESSION['userID'].");' id='TagList".$tagsInfo[$i*3]."'>follow this tag</a>";

                echo "<div id='count'>".$tagsInfo[$i*3+1]." discussions</div>
                    <div id='count'>".$tagsInfo[$i*3+2]." followers</div>";
                echo "</td>";
            }
            echo "</tr>";
       }
    }
    mysqli_close($connect);
?>
</table>

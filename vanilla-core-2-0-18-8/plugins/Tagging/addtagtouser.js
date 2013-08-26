//
var updateusertagHttpresq;
var deleteusertagHttpresq;
function changeToFavorite(tagID, userID, updateLink){
//    var favTag = document.getElementById('favriteTag'+tagID);
//    favTag.src = "favoritestar.png";
    var httpLink = 'http://' + location.host+'/' + updateLink + '/' + userID + ',' + tagID + ',addfavorite';
//    alert(httpLink);
    if(userID == 0){
        alert("Please SignIn ");
        return;
    }
    updateusertagHttpresq = new XMLHttpRequest();
    updateusertagHttpresq.open( "GET", httpLink, false );
    updateusertagHttpresq.onreadystatechange = function(){
       if (updateusertagHttpresq.readyState == 4)
           {
            if (updateusertagHttpresq.status == 200)
            {
                var htmlObject = document.createElement('li');
                htmlObject.innerHTML = document.getElementById('Tag'+tagID).innerHTML;

                //remove Tag from Popular Tags;
                var suggestTagBox = document.getElementById('SuggestedTags');
                suggestTagBox.removeChild(document.getElementById('Tag'+tagID));

                var atag = htmlObject.getElementsByTagName('a');
                atag[1].href = "javascript:changeToUnFavorite("+tagID+", "+userID+", '"+updateLink+"');";
                var favoriteTagBox = document.getElementById('FavoriteTags');
                favoriteTagBox.innerHTML = "<li id='Tag"+tagID+"'>"+htmlObject.innerHTML+"</li>"+favoriteTagBox.innerHTML;
                var favImage = document.getElementById('favriteTag'+tagID);
                favImage.src = "favoritestar.png";
       }
   }
   
    
    };
    updateusertagHttpresq.send();
}

function changeToUnFavorite(tagID, userID, updateLink){
//    var favTag = document.getElementById('favriteTag'+tagID);
//    favTag.src = "unfavoritestar.png";
    var httpLink = 'http://' + location.host+'/' + updateLink + '/' + userID + ',' + tagID + ',deletefavorite';
    deleteusertagHttpresq = new XMLHttpRequest();
    deleteusertagHttpresq.open( "GET", httpLink, false );
    deleteusertagHttpresq.onreadystatechange = function(){
       if (deleteusertagHttpresq.readyState == 4)
           {
            if (deleteusertagHttpresq.status == 200)
            {
                var htmlObject = document.createElement('li');
                htmlObject.innerHTML = document.getElementById('Tag'+tagID).innerHTML;
                //remove Tag from Popular Tags;
                var favoriteTagBox = document.getElementById('FavoriteTags');
                favoriteTagBox.removeChild(document.getElementById('Tag'+tagID));

                var atag = htmlObject.getElementsByTagName('a');
                atag[1].href = "javascript:changeToFavorite("+tagID+", "+userID+", '"+updateLink+"');";
                var suggestedTagBox = document.getElementById('SuggestedTags');
                suggestedTagBox.innerHTML = "<li id='Tag"+tagID+"'>"+htmlObject.innerHTML+"</li>"+suggestedTagBox.innerHTML;
                var favImage = document.getElementById('favriteTag'+tagID);
                favImage.src = "unfavoritestar.png";
            }
        }
   };
   deleteusertagHttpresq.send();
}

function changeTagInListToFavorite(tagID, userID){
    var changeTagAttributeLink = document.getElementById('TagList'+tagID);
    changeTagAttributeLink.innerHTML = "unfollow this tag";
    changeTagAttributeLink.href = "javascript:changeToUnFavorite("+tagID+", "+userID+", \"/vanilla-core-2-0-18-8/index.php?p=/plugin/updateusertag\"); changeTagInListToUnFavorite("+tagID+","+userID+");";
}

function changeTagInListToUnFavorite(tagID, userID){
    var changeTagAttributeLink = document.getElementById('TagList'+tagID);
    changeTagAttributeLink.innerHTML = "follow this tag";
    changeTagAttributeLink.href = "javascript:changeToFavorite("+tagID+", "+userID+", \"/vanilla-core-2-0-18-8/index.php?p=/plugin/updateusertag\"); changeTagInListToFavorite("+tagID+","+userID+");";
}

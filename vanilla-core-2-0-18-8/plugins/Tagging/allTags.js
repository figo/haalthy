
var getTagsHttpresq;
function listAllTags(){
    var httpLink = 'http://' + location.host+'/tags/alltags.php';
    getTagsHttpresq = new XMLHttpRequest();
    getTagsHttpresq.open( "GET", httpLink, false );
    getTagsHttpresq.onreadystatechange = function(){
       if (getTagsHttpresq.readyState == 4) {
            if (getTagsHttpresq.status == 200)
            {
                var content = document.getElementById('Content');
                content.innerHTML = getTagsHttpresq.responseText;
            }
        }
    };
    getTagsHttpresq.send();
}

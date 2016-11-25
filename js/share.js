var sharePostId;
function openShareDialogue(postId){
  sharePostId = postId;
  var message = document.getElementById('content' + postId);
  var messdisp = document.getElementById('post-to-share');
  messdisp.innerHTML = message.innerHTML;
  document.getElementById('share-with').value = "";
  document.getElementById('share-with-message').value = "";
  document.getElementById('share-error').innerHTML = "";
  dialog.showModal();
}
dialog.querySelector('.send').addEventListener('click', function() {
  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState == XMLHttpRequest.DONE) {
      console.log(request.responseText);
      if(request.responseText == "1"){
        dialog.close();
      }else{
        document.getElementById('share-error').innerHTML = "Failed to share post!";
      }
    }
  }
  var dest = document.getElementById('share-with').value;
  var message = document.getElementById('share-with-message').value;

  request.open("POST","api/share.php",true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  request.send("dest=" + dest + "&post=" + sharePostId + "&message=" + message);
});
dialog.querySelector('.close').addEventListener('click', function() {
  dialog.close();
});

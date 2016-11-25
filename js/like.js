
function likes(heart, post, action){
  //console.log("Click:\npost: " + post + "\nuser: " + user + "\naction: " + action);
  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState == XMLHttpRequest.DONE) {
      if(request.responseText == "1"){
        heart.classList.toggle("heart-gray");
        heart.classList.toggle("heart-red");
        var counter = document.getElementById("count"+post);
        var number = counter.innerHTML;
        if(action == 0){
          number++;
          heart.setAttribute("onclick","likes(this," + post + ",1)");
        }else if(action == 1){
          number--;
          heart.setAttribute("onclick","likes(this," + post + ",0)");
        }
        counter.innerHTML = number;
      }
    }
  }
  request.open("POST","api/like.php",true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  request.send("post=" + post + "&action=" + action);
}

function subscribe(button, channel, action){
  var request = new XMLHttpRequest();

  request.onreadystatechange = function() {
    if (request.readyState == XMLHttpRequest.DONE) {
      if(request.responseText == "1"){
        var icon = document.getElementById("subscribeIcon");
        var text = document.getElementById("subscribeText");
        if(action == 0){
          icon.innerHTML = "notifications_off";
          text.innerHTML = "Unsubscribe";
          button.setAttribute("onclick","subscribe(this,'" + channel + "',1)");
        }else if(action == 1){
          icon.innerHTML = "notifications";
          text.innerHTML = "Subscribe";
          button.setAttribute("onclick","subscribe(this,'" + channel + "',0)");
        }
      }
    }
  }
  request.open("POST","api/subscribe.php",true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  request.send("channel=" + channel + "&action=" + action);
}

function deletePost(button, post){
  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState == XMLHttpRequest.DONE) {
      console.log(request.responseText);
      if(request.responseText == "1"){
        button.classList.remove("error");
        button.innerHTML = "Deleted!";
        var posthtml = document.getElementById('post'+post);
        posthtml.style.display = 'none';
      }else{
        button.classList.add("error");
        button.innerHTML = "Failed!";
      }
    }
  }
  request.open("POST","api/delete.php",true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  request.send("post=" + post);
}

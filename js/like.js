
function likes(heart, post, user, action){
  if(user != "0"){
    heart.classList.toggle("heart-gray");
    heart.classList.toggle("heart-red");
    //console.log("Click:\npost: " + post + "\nuser: " + user + "\naction: " + action);
    var request = new XMLHttpRequest();
    request.open("POST","like.php",true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send("post=" + post + "&user=" + user + "&action=" + action);
    var counter = document.getElementById("count"+post);
    var number = counter.innerHTML;
    if(action == 0){
      number++;
      heart.setAttribute("onclick","likes(this," + post + "," + user + ",1)");
    }else if(action == 1){
      number--;
      heart.setAttribute("onclick","likes(this," + post + "," + user + ",0)");
    }
    counter.innerHTML = number;
  }
}

function subscribe(button, channel, user, action){
  if(user != "0"){
    var request = new XMLHttpRequest();
    request.open("POST","subscribe.php",true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send("channel=" + channel + "&user=" + user + "&action=" + action);

    var icon = document.getElementById("subscribeIcon");
    if(action == 0){
      icon.innerHTML = "notifications_off";
      button.setAttribute("title","Unsubscribe");
      button.setAttribute("onclick","subscribe(this,'" + channel + "'," + user + ",1)");
    }else if(action == 1){
      icon.innerHTML = "notifications";
      button.setAttribute("title","Subscribe");
      button.setAttribute("onclick","subscribe(this,'" + channel + "'," + user + ",0)");
    }
  }
}


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

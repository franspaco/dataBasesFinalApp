<?php
  include'api_header.php';

  if($_loggedIn){
    if(isset($_POST['post'])){
      $deletePost->bind_param("ss", $userId, $_POST['post']);
      echo $deletePost->execute();
    }else{
      echo 0;
    }
  }else{
    echo 0;
  }
 ?>

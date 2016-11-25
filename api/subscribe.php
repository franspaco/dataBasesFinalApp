<?php
  include'api_header.php';
  
  $resCh = $_POST['channel'];

  if($_loggedIn){
    if($_POST['action'] == "0"){
      $insertSubscription->bind_param("ss", $userId, $resCh);
      echo $insertSubscription->execute();
    }else if ($_POST['action'] == "1"){
      $deleteSubscription->bind_param("ss", $userId, $resCh);
      echo $deleteSubscription->execute();
    }
  }
 ?>

<?php
  include'php/header.php';
  /*
  $queryChannelId->bind_param("s", $_POST['channel']);
  $queryChannelId->execute();
  $resCh = $queryChannelId->get_result()->fetch_assoc()['id'];
  */
  $resCh = $_POST['channel'];

  if($_loggedIn && $_POST['user'] == $_SESSION['userID']){
    var_dump($_GET);
    echo "<br>POST:<br>";
    var_dump($_POST);
    if($_POST['action'] == "0"){
      $insertSubscription->bind_param("ss", $_POST['user'], $resCh);
      $insertSubscription->execute();
    }else if ($_POST['action'] == "1"){
      $deleteSubscription->bind_param("ss", $_POST['user'], $resCh);
      $deleteSubscription->execute();
    }
  }
 ?>

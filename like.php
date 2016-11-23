<?php
  include'php/header.php';

  if($_loggedIn){
    var_dump($_GET);
    echo "<br>POST:<br>";
    var_dump($_POST);
    if($_POST['action'] == "0"){
      $insertLike->bind_param("ss",$userId,$_POST['post']);
      $insertLike->execute();
    }else if ($_POST['action'] == "1"){
      $deleteLike->bind_param("ss",$userId,$_POST['post']);
      $deleteLike->execute();
    }
  }
 ?>

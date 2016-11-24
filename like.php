<?php
  include'php/header.php';

  if($_loggedIn){
    if($_POST['action'] == "0"){
      $insertLike->bind_param("ss",$userId,$_POST['post']);
      echo $insertLike->execute();
    }else if ($_POST['action'] == "1"){
      $deleteLike->bind_param("ss",$userId,$_POST['post']);
      echo $deleteLike->execute();
    }
  }
 ?>

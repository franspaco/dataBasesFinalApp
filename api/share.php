<?php
  include'api_header.php';
  
  if($_loggedIn && !empty($_POST['dest']) && !empty($_POST['post']) && isset($_POST['message'])){
    $queryUserData->bind_param("s", $_POST['dest']);
    if($queryUserData->execute()){
      $res = $queryUserData->get_result()->fetch_assoc();
      if(isset($res)){
        $insertShare->bind_param("ssss", $userId, $res['id'], $_POST['message'], $_POST['post']);
        echo $insertShare->execute();
      }else{
        echo 0;
      }
    }else{
      echo 0;
    }
  }else{
    echo 0;
  }
 ?>

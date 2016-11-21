<?php
  include'php/header.php';
  
  echo "<br><br>";
  echo "<br><br><br>";
  $queryChannel->bind_param("is", 2, "funny");
  echo $queryChannel->execute();
  $res = $queryChannel->get_result();
  var_dump($res);
  while($row = $res->fetch_assoc()){
    echo "ROW:<br>";
    echo $row['id'] . "<br>";
  }
 ?>

<?php
  include'php/header.php';
  $_SESSION['username'] = "";
  $_SESSION['LoggedIn'] = 0;
  session_destroy();
 ?>

<script>
  document.location = "index.php";
</script>

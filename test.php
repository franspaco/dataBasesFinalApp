<?php
  include 'php/header.php';
  include 'php/lib_autolink.php';
  echo password_hash("123456",PASSWORD_DEFAULT);


  $str = "Hey there http://google.com";
  echo "<br><br>String:<br>";
  echo $str;
  echo "<br>With links<br>";
  echo autolink($str);
 ?>

 <table>
          <tbody><tr>
            <td><img src="http://cultofthepartyparrot.com/parrots/parrot.gif"></td>
            <td><img src="http://cultofthepartyparrot.com/parrots/middleparrot.gif"><img src="http://cultofthepartyparrot.com/parrots/middleparrot.gif"><img src="http://cultofthepartyparrot.com/parrots/middleparrot.gif"><img src="http://cultofthepartyparrot.com/parrots/middleparrot.gif"><img src="http://cultofthepartyparrot.com/parrots/middleparrot.gif"><img src="http://cultofthepartyparrot.com/parrots/middleparrot.gif"><img src="http://cultofthepartyparrot.com/parrots/middleparrot.gif"><img src="http://cultofthepartyparrot.com/parrots/middleparrot.gif"></td>
            <td><img src="http://cultofthepartyparrot.com/parrots/rightparrot.gif"></td>
          </tr>
          <tr>
            <td><img src="http://cultofthepartyparrot.com/parrots/parrot.gif"></td>
            <td><h2>PARTY OR DIE</h2></td>
            <td><img src="http://cultofthepartyparrot.com/parrots/rightparrot.gif"></td>
          </tr>
          <tr>
            <td><img src="http://cultofthepartyparrot.com/parrots/parrot.gif"></td>
            <td><img src="http://cultofthepartyparrot.com/parrots/middleparrot.gif"><img src="http://cultofthepartyparrot.com/parrots/middleparrot.gif"><img src="http://cultofthepartyparrot.com/parrots/middleparrot.gif"><img src="http://cultofthepartyparrot.com/parrots/middleparrot.gif"><img src="http://cultofthepartyparrot.com/parrots/middleparrot.gif"><img src="http://cultofthepartyparrot.com/parrots/middleparrot.gif"><img src="http://cultofthepartyparrot.com/parrots/middleparrot.gif"><img src="http://cultofthepartyparrot.com/parrots/middleparrot.gif"></td>
            <td><img src="http://cultofthepartyparrot.com/parrots/rightparrot.gif"></td>
          </tr>
        </tbody></table>

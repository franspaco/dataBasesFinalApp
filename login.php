<?php
  include'php/header.php';
  $_ch = isset($_GET['ch']) ? $_GET['ch'] : "all";
  echo "<br>Post: <br>";
  var_dump ($_POST);
  echo "<br>loggedIn: <br>";
  var_dump ($_loggedIn);

  if(!empty($_POST['loginUsername']) && !empty($_POST['loginPassword'])){
    $usernm = $_POST['loginUsername'];
    $passwd = $_POST['loginPassword'];
    $queryLoginData->bind_param("ss", $usernm, $passwd);
    $queryLoginData->execute();
    $res = $queryLoginData->get_result();
    echo "<br>RES: <br>";
    var_dump($res);
    $row = $res->fetch_assoc();
    $queryLoginData->close();
    echo "<br>ROW: <br>";
    var_dump($row);
    echo "1";
    if(isset($row)){
      echo "2";
      $_SESSION['username'] = $usernm;
      $_SESSION['LoggedIn'] = 1;
      $_SESSION['userID'] = $row['id'];
      $_loggedIn = true;
      echo "<script>document.location = \"index.php\"</script>";
    }
  }

  echo "Session: <br>";
  var_dump ($_SESSION);
  echo "<br>";

  $_loggedIn = $_GET['login'];
  if($_loggedIn){
    echo "<a href=\"index.php\">You are logged in! Go to the fron page!</a>";
    //echo "<script>document.location = \"index.php\"</script>";
  }

 ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title> Login | chirper </title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="images/favicon.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Material Design Lite">
    <link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF">

    <link rel="shortcut icon" href="images/favicon.png">

    <!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
    <!--
    <link rel="canonical" href="http://www.example.com/">
    -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/material.min.css" />
    <link rel="stylesheet" href="css/custom.css" />
    <link rel="stylesheet" href="css/hoover.css" />
    <link rel="stylesheet" href="css/styles.css">
    <style>
    #view-source {
      position: fixed;
      display: block;
      right: 0;
      bottom: 0;
      margin-right: 40px;
      margin-bottom: 40px;
      z-index: 900;
    }
    </style>
  </head>
  <body class="mdl-demo mdl-color--grey-100 mdl-color-text--grey-700 mdl-base">
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header mdl-layout__header--scroll mdl-color--primary">
        <div class="mdl-layout--large-screen-only mdl-layout__header-row">
        </div>
        <div class="mdl-layout--large-screen-only mdl-layout__header-row hvr-forward">
          <h3><a href="index.php">chirper</a></h3>
        </div>
        <div class="mdl-layout--large-screen-only mdl-layout__header-row">
        </div>
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect mdl-color--primary-dark">
          <span class="mdl-layout__tab" id="current-channel"> Log In </span>
          <?php
            if(!$_loggedIn){
              $queryDefaultChannels->execute();
              $res = $queryDefaultChannels->get_result();
              while($rowLink = $res->fetch_assoc()){
                echo "<a href=\"channel.php?ch=" . $rowLink['name'] . "\" class=\"mdl-layout__tab\">#". $rowLink['name'] . "</a>";
              }
            }else{

            }
          ?>
        </div>
      </header>
      <main class="mdl-layout__content">
        <div class="mdl-layout__tab-panel is-active" id="overview">
          <section class="section--center mdl-grid mdl-grid--no-spacing">
            <div class="mdl-card mdl-cell mdl-cell--12-col mdl-shadow--2dp post-card">
              <div class="mdl-card__supporting-text">
                <h4>Log in to chirper</h4>
                <form class="" action="login.php" method="post">
                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="sample3" name="loginUsername">
                    <label class="mdl-textfield__label" for="sample3">Username...</label>
                  </div>
                  <br>
                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="password" id="sample3" name="loginPassword">
                    <label class="mdl-textfield__label" for="sample3">Password...</label>
                  </div>
                  <div>
                    <input type="submit" class="hvr-fade login-submit" id="login-submit">
                  </div>
                </form>
              </div>
              <div class="mdl-card__actions">
                <a href="register.php" class="mdl-button">Register</a>
              </div>
            </div>
          </section>
        </div>
      </main>
    </div>
    <script src="https://code.getmdl.io/1.2.1/material.min.js"></script>
  </body>
</html>

<?php
  include'php/header.php';

  if(isset($_POST['loginUsername']) && isset($_POST['loginPassword'])){
    $usernm = $_POST['loginUsername'];
    $passwd = $_POST['loginPassword'];
    $queryLoginData->bind_param("s", $usernm);
    $queryLoginData->execute();
    $row = $queryLoginData->get_result()->fetch_assoc();
    $queryLoginData->close();

    if(isset($row)){
      if(password_verify($passwd, $row['password'])){
        $_SESSION['username'] = $usernm;
        $_SESSION['LoggedIn'] = 1;
        $_SESSION['userID'] = $row['id'];
        $_loggedIn = true;
        echo "<script>document.location = \"index.php\"</script>";
      }else{
        $error = "Hash Failed!";
      }
    }else{
      $error = "Wrong username or password!";
    }
  }
  if($_loggedIn){
    echo "<a href=\"index.php\">You are logged in! Go to the fron page!</a>";
    echo "<script>document.location = \"index.php\"</script>";
  }

 ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="chirper, taking over the world one chirp at a time">
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
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <span class="mdl-layout-title"><a href="index.php" class="index-link">chirper</a></span>
          <!-- Add spacer, to align navigation to the right -->
          <div class="mdl-layout-spacer"></div>
          <!-- Navigation. We hide it in small screens. -->
          <nav class="mdl-navigation mdl-layout--large-screen-only">
            <?php
              if($_loggedIn){
                ?> <a class="mdl-navigation__link" href="logout.php">LOGOUT</a> <?php
              }else{
                ?> <a class="mdl-navigation__link" href="login.php">LOGIN</a> <?php
              }
            ?>
          </nav>
        </div>
      </header>
      <div class="mdl-layout__drawer">
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link hvr-icon-forward" href="guide.php">Channel Guide</a>
          <?php
            if($_loggedIn){
              ?> <span class="mdl-navigation__spacer">My channels:</span> <?php
              $queryUserSubscribed->bind_param("s", $_SESSION['userID']);
              $queryUserSubscribed->execute();
              $res = $queryUserSubscribed->get_result();
            }else{
              ?> <span class="mdl-navigation__spacer">Default:</span> <?php
              $queryDefaultChannels->execute();
              $res = $queryDefaultChannels->get_result();
            }
            while($row = $res->fetch_assoc()){
              echo "<a href=\"channel.php?ch=" . $row['name'] . "\" class=\"mdl-navigation__link hvr-icon-forward\">#". $row['name'] . "</a>";
            }
           ?>
        </nav>
      </div>
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
                    <input type="submit" class="hvr-fade login-submit-en" id="login-submit">
                  </div>
                </form>
                <span class="error"><?php echo $error; ?></span>
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

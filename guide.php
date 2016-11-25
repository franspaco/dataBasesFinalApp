<?php
  session_start();
  include'php/header.php';

  $new_channel = ($_GET['new'] == 'channel');

  if(!empty($_POST['chName']) && $_loggedIn){
    $new_channel = true;
    $insertChannel->bind_param("ss", htmlentities($_POST['chName']), $userId);
    if($insertChannel->execute()){
      $newCh_id = $mysqli->query("SELECT LAST_INSERT_ID() AS id;")->fetch_assoc()['id'];
      $insertSubscription->bind_param("ss", $userId, $newCh_id);
      $insertSubscription->execute();
      echo "<script>document.location=\"channel.php?ch=" . $_POST['chName'] ."\"</script>";
    }else{
      $error = "Could not create channel!";
    }
  }

 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="chirper, taking over the world one chirp at a time">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title> Guide | chirper </title>

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
      <!--<header class="mdl-layout__header mdl-layout__header--scroll mdl-color--primary">
        <div class="mdl-layout--large-screen-only mdl-layout__header-row">
        </div>
        <div class="mdl-layout--large-screen-only mdl-layout__header-row">
          <h3 class="hvr-forward"><a href="index.php" class="pointer">chirper</a></h3>
        </div>
        <div class="mdl-layout--large-screen-only mdl-layout__header-row">
          <h5><?php echo ($new_channel) ? "Create Channel":"Guide"; ?></h5>
        </div>
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect mdl-color--primary-dark">
          <a href="guide.php" class="mdl-layout__tab" id="current-channel"> Guide </span>
          <?php
            echo "<span class=\"mdl-layout__tab\" id=\"current-channel\">#" . $_ch . "</span>";
            if(!$_loggedIn){
              $queryDefaultChannels->execute();
              $res = $queryDefaultChannels->get_result();
              while($row = $res->fetch_assoc()){
                echo "<a href=\"channel.php?ch=" . $row['name'] . "\" class=\"mdl-layout__tab\">#". $row['name'] . "</a>";
              }
              echo "
                <div style=\"width: 100%;\">
                  <a href=\"login.php\" class=\"mdl-layout__tab login-button\">LOGIN</a>
                </div>";
            }else{
              $queryUserSubscribed->bind_param("s", $_SESSION['userID']);
              $queryUserSubscribed->execute();
              $res = $queryUserSubscribed->get_result();
              while($row = $res->fetch_assoc()){
                echo "<a href=\"channel.php?ch=" . $row['name'] . "\" class=\"mdl-layout__tab\">#". $row['name'] . "</a>";
              }
              ?>
                <div style="width: 100%;">
                  <a href="logout.php" class="mdl-layout__tab login-button">LOGOUT</a>
                </div>"
                <button title="New Post" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-shadow--4dp mdl-color--accent"
                  id="add"
                  onclick="redirectNewChannel()">
                  <i class="material-icons" role="presentation">create</i>
                  <span class="visuallyhidden">Create</span>
                </button>
                <script>
                  function redirectNewChannel() {
                    document.location="guide.php?new=channel";
                  }
                </script>
              <?php
            }
          ?>
        </div>
      </header>-->
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <span class="mdl-layout-title"><a href="index.php" class="index-link">chirper</a></span>
          <!-- Add spacer, to align navigation to the right -->
          <div class="mdl-layout-spacer"></div>
          <span class="mdl-layout-title index-link">Guide</span>
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
              ?>
                <a class="mdl-navigation__link hvr-icon-forward" href="shares.php">Shared with me <?php echo ($inbox > 0) ? "(" . $inbox .")" : ""; ?></a>
                <span class="mdl-navigation__spacer">My channels:</span>
              <?php
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
            <?php
            if(!$new_channel){
              $queryChannels->execute();
              $res = $queryChannels->get_result();
              while($row = $res->fetch_assoc()){
                ?>
                <a href="channel.php?ch=<?php echo htmlentities($row['name']) ?>" class="hvr-underline-from-left channel-button">#<?php echo htmlentities($row['name']) ?>
                  <br>
                  <span class="ch-owner">by <?php echo $row['username'] ?></span>
                </a>
                <?php
              }
            }else{
              ?>
              <div class="mdl-card mdl-cell mdl-cell--12-col mdl-shadow--2dp post-card">
                <div class="mdl-card__supporting-text">
              <?php
              if($_loggedIn){
              ?>
                    <h4>New channel</h4>
                    <form class="" action="guide.php" method="post">
                      <div id="counterDisp" style="color: #AAA;">Remaining: 25</div>
                      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="text" id="textField1" name="chName" onkeyup="counter()">
                        <label class="mdl-textfield__label" for="sample3">Channel Name...</label>
                      </div>
                      <br>
                      <div>
                        <input type="submit" class="hvr-fade login-submit-en" id="login-submit">
                      </div>
                    </form>
                    <span class="error"><?php echo $error; ?></span>
                    <script type="text/javascript">
                      function counter(){
                        var max = 25;
                        var field = document.getElementById("textField1");
                        var disp = document.getElementById("counterDisp");
                        if(field.value.length > max){
                          field.value = field.value.substring(0, max);
                        }else{
                          disp.innerHTML = "Remaining: " + (max - field.value.length);
                        }
                      }
                    </script>
              <?php
              }else{
                ?>
                <h4>You need to log in to post</h4>
                <a href="login.php">Log In</a>
                <?php
              }
              ?>
                  </div>
                </div>
                <?php
            }
            ?>
          </section>
        </div>
      </main>
    </div>
    <script src="https://code.getmdl.io/1.2.1/material.min.js"></script>
  </body>
</html>

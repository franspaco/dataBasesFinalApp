<?php
  session_start();
  include'php/header.php';

  $_ch = isset($_GET['ch']) ? $_GET['ch'] : "all";
  if($_loggedIn){
    $querySubscribed->bind_param("ss",$_SESSION['userID'],$_ch);
    $querySubscribed->execute();
    $is_sub = $querySubscribed->get_result()->fetch_assoc()['is_sub'];
  }
  $queryChannelId->bind_param("s", $_ch);
  $queryChannelId->execute();
  $resCh = $queryChannelId->get_result()->fetch_assoc()['id'];
  $chExists = isset($resCh);
 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="chirper, taking over the world one chirp at a time">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title> <?php echo $_ch ?> | chirper </title>

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
    <?php echo ($_loggedIn) ? "<script src=\"js/like.js\"></script>" : ""; ?>
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
          <h5>#<?php echo $_ch ?></h5>
        </div>
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect mdl-color--primary-dark">
          <a href="guide.php" class="mdl-layout__tab" id="current-channel"> Guide </span>
          <?php
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
              </div>
              <?php
              if($chExists){
              ?>
                <button title="New Post" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-shadow--4dp mdl-color--accent"
                  id="add"
                  onclick="redirectNewPost()">
                  <i class="material-icons" role="presentation">create</i>
                  <span class="visuallyhidden">Create</span>
                </button>

                <button title=" <?php echo ($is_sub)? "Unsubscribe": "Subscribe" ?> "
                  class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-shadow--4dp mdl-color--accent"
                  id="subscribe"
                  onclick="subscribe(this,'<?php echo $resCh . "'," . $is_sub ?>)">
                  <i class="material-icons" role="presentation" id="subscribeIcon">notifications<?php echo ($is_sub)? "_off": "" ?></i>
                  <span class="visuallyhidden">Notifications</span>
                </button>
                <script>
                  function redirectNewPost() {
                    document.location="post.php?new=<?php echo $_ch ?>";
                  }
                </script>
              <?php
              }
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
            <?php
            if($chExists){
              $queryPosts->bind_param("ssss", $userId, $null, $_ch, $null);
              $queryPosts->execute();
              $res = $queryPosts->get_result();
              if($res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                  echo "<div class=\"mdl-card mdl-cell mdl-cell--12-col mdl-shadow--2dp post-card\">
                          <div class=\"post-card-text mdl-card__supporting-text\">"
                            . htmlentities($row['message']) .
                          "</div>
                          <div class=\"mdl-card__actions\">
                          <div class=\"likes-container\">
                            <i class=\"fa fa-heart likes-heart " . (($row['likes']) ? "heart-red":"heart-gray") . "\"
                              aria-hidden=\"true\" onclick=\"likes(this," . $row['id'] . "," . $row['likes'] . ")\"></i>
                            <span id=\"count" . $row['id'] . "\">" . $row['total'] .
                            "</span>
                          </div>
                          <div class=\"author-tag\">
                            by
                            <a class=\"hvr-underline-reveal author-name\" href=\"user.php?user="
                              . htmlentities($row['username']) . "\">"
                              . htmlentities($row['username']) .
                            "</a>
                            on "
                            . $row['timestamp'] .
                          "</div>
                            <a href=\"post.php?post=". $row['id'] ."\" class=\"mdl-button\">Permalink</a>
                          </div>
                        </div>";
                        ?>
                        <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btn3">
                          <i class="material-icons">more_vert</i>
                        </button>
                        <ul class="mdl-menu mdl-js-menu mdl-menu--bottom-right" for="btn3">
                          <li class="mdl-menu__item">Lorem</li>
                          <li class="mdl-menu__item" disabled>Ipsum</li>
                          <li class="mdl-menu__item">Dolor</li>
                        </ul>
                        <?php
                }
              }else{
                echo "<div class=\"mdl-card mdl-cell mdl-cell--12-col mdl-shadow--2dp post-card\">
                        <div class=\"post-card-text mdl-card__supporting-text\">
                        No one has posted here yet...
                        </div>
                        <div class=\"mdl-card__actions\">
                          <a href=\"index.php\" class=\"mdl-button\">GO BACK</a>";
              }
            }else{
              echo "<div class=\"mdl-card mdl-cell mdl-cell--12-col mdl-shadow--2dp post-card\">
                      <div class=\"post-card-text mdl-card__supporting-text\">
                      Uh oh... no channel found. 404!!1!
                      </div>
                      <div class=\"mdl-card__actions\">
                        <a href=\"index.php\" class=\"mdl-button\">GO BACK</a>";
            }
            ?>
          </section>
        </div>
      </main>
    </div>
    <script src="https://code.getmdl.io/1.2.1/material.min.js"></script>
  </body>
</html>

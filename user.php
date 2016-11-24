<?php
  include'php/header.php';
  $_usr = isset($_GET['user']) ? $_GET['user'] : "";
 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title> <?php echo $_usr?> | chirper </title>

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
            $queryPosts->bind_param("isss", $userId, $null, $null, $_usr);
            $queryPosts->execute();
            $res = $queryPosts->get_result();

            while($row = $res->fetch_assoc()){
              echo "<div class=\"mdl-card mdl-cell mdl-cell--12-col mdl-shadow--2dp post-card\">
                      <div class=\"post-card-text mdl-card__supporting-text\">"
                        . htmlentities($row['message']) .
                      "</div>
                      <div class=\"mdl-card__actions\">
                      <div class=\"likes-container\">
                        <i class=\"fa fa-heart likes-heart " . (($row['likes']) ? "heart-red":"heart-gray") . "\"
                          aria-hidden=\"true\" " . (($_loggedIn)? "onclick=\"likes(this," . $row['id'] . "," . $row['likes'] . ")" : "" )  . "\"></i>
                        <span id=\"count" . $row['id'] . "\">" . $row['total'] .
                        "</span>
                      </div>
                      <div class=\"author-tag\">
                        by
                        <a class=\"hvr-underline-reveal author-name\" href=\"user.php?="
                          . htmlentities($row['username']) . "\">"
                          . htmlentities($row['username']) .
                        "</a>
                        on "
                        . $row['timestamp'] .
                        " | posted in
                        <a class=\"hvr-underline-reveal author-name\" href=\"channel.php?ch="
                          . $row['name'] . "\">#"
                          . $row['name'] .
                        "</a>
                      </div>
                        <a href=\"post.php?post=". $row['id'] ."\" class=\"mdl-button\">Permalink</a>
                      </div>
                    </div>";
            }
            ?>
          </section>
        </div>
      </main>
    </div>
    <script src="https://code.getmdl.io/1.2.1/material.min.js"></script>
  </body>
</html>

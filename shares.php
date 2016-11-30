<?php
  include'php/header.php';
  include 'php/lib_autolink.php';
 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="chirper, taking over the world one chirp at a time">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title> Front Page | chirper </title>

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

    <script src="js/dialog-polyfill.js"></script>
    <link rel="stylesheet" type="text/css" href="css/dialog-polyfill.css" />

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
      <header class="mdl-layout__header scroll">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <span class="mdl-layout-title"><a href="index.php" class="index-link">chirper</a></span>
          <!-- Add spacer, to align navigation to the right -->
          <div class="mdl-layout-spacer"></div>
          <span class="mdl-layout-title index-link">Shared with me <?php echo ($inbox > 0) ? "(" . $inbox .")" : ""; ?></span>
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
            if($_loggedIn){
              $queryInbox->bind_param("s", $userId);
              $queryInbox->execute();
              $res = $queryInbox->get_result();
              while($row = $res->fetch_assoc()){
                $updateSeen->bind_param("s", $row['id']);
                $updateSeen->execute();
                ?>
                <div class="mdl-card mdl-cell mdl-cell--12-col mdl-shadow--2dp post-card" id="post<?php $row['id']?>">
                  <div class="post-card-text mdl-card__supporting-text">
                    <h4>
                      <a href="user.php?user=<?php echo htmlentities($row['username']) ?>" class="hvr-underline-reveal sender-name">
                        <?php echo htmlentities($row['username']) ?>
                      </a>
                      shared a post with you:
                      <?php
                        if(!$row['seen']){
                          echo "<div class=\"new-badge\">New</div>";
                        }
                      ?>
                    </h4>
                    <?php echo autolink(nl2br(htmlentities($row['message'])), 'target="_blank"') ?>
                  </div>
                  <div class="mdl-card__actions">
                    <div class="author-tag">
                      Received on <?php echo $row['sent']?>
                    </div>
                    <a href="post.php?post=<?php echo $row['post']?>"  class="mdl-button share-permalink">Check it out</a>
                  </div>
                </div>
                <?php
              }
            }
            ?>
          </section>
        </div>
      </main>
    </div>
    <script src="https://code.getmdl.io/1.2.1/material.min.js"></script>
  </body>
</html>

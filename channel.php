<?php
  session_start();
  include'php/header.php';
  include 'php/lib_autolink.php';

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
    <?php if($_loggedIn){ ?>
      <dialog class="mdl-dialog">
        <h5 class="mdl-dialog__title">Share post</h5>
        <div class="mdl-dialog__content">
          <form action="#">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <input class="mdl-textfield__input" type="text" id="share-with">
              <label class="mdl-textfield__label" for="share-with">Share with...</label>
            </div>
            <div class="mdl-textfield mdl-js-textfield">
              <textarea class="mdl-textfield__input" type="text" rows= "2" id="share-with-message" ></textarea>
              <label class="mdl-textfield__label" for="share-with-message">Message...</label>
            </div>
          </form>
          Sharing:
          <div class="" id="post-to-share"></div>
          <div class="error" id="share-error"></div>
        </div>
        <div class="mdl-dialog__actions">
          <button type="button" class="mdl-button send">Share</button>
          <button type="button" class="mdl-button close">Cancel</button>
        </div>
      </dialog>
      <script>
        var dialog = document.querySelector('dialog');
        if (! dialog.showModal) {
          dialogPolyfill.registerDialog(dialog);
        }
      </script>
    <?php } ?>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header scroll">
        <div class="mdl-layout__header-row scroll">
          <!-- Title -->
          <span class="mdl-layout-title"><a href="index.php" class="index-link">chirper</a></span>
          <!-- Add spacer, to align navigation to the right -->
          <div class="mdl-layout-spacer"></div>
          <span class="mdl-layout-title index-link">#<?php echo $_ch ?></span>
          <div class="mdl-layout-spacer"></div>
          <!-- Navigation. We hide it in small screens. -->
          <nav class="mdl-navigation mdl-layout--large-screen-only">
            <?php
              if($_loggedIn){
                ?>
                  <span class="mdl-navigation__link pointer" onclick="redirectNewPost()">
                    <i class="material-icons" role="presentation">create</i>
                    <span>New</span>
                  </span>
                  <script>
                    function redirectNewPost() {
                      document.location="post.php?new=<?php echo $_ch ?>";
                    }
                  </script>
                  <span class="mdl-navigation__link sub pointer" onclick="subscribe(this,'<?php echo $resCh . "'," . $is_sub ?>)">
                    <i class="material-icons" role="presentation" id="subscribeIcon">notifications<?php echo ($is_sub)? "_off": "" ?></i>
                    <span id="subscribeText"><?php echo ($is_sub)? "Unsubscribe": "Subscribe" ?></span>
                  </span>
                  <a class="mdl-navigation__link" href="logout.php">LogOut</a>
                <?php
              }else{
                ?> <a class="mdl-navigation__link" href="login.php">LogIn</a> <?php
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
          <?php
            if($chExists){
              $queryPosts->bind_param("ssss", $userId, $null, $_ch, $null);
              $queryPosts->execute();
              $res = $queryPosts->get_result();
              if($res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                  ?>
                    <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp" id="post<?php echo $row['id']?>">
                      <div class="mdl-card mdl-cell mdl-cell--12-col">
                        <div class="mdl-card__supporting-text post-card-text" id="content<?php echo $row['id']?>">
                          <?php echo autolink(nl2br(htmlentities($row['message'])), 'target="_blank"') ?>
                        </div>
                        <div class="mdl-card__actions">
                          <div class="likes-container">
                            <i class="fa fa-heart likes-heart <?php echo (($row['likes']) ? "heart-red":"heart-gray") ?>"
                              aria-hidden="true" onclick="likes(this,<?php echo $row['id'] . "," . $row['likes'] ?> )"></i>
                            <span id="count<?php echo $row['id'] ?>" >
                              <?php echo $row['total'] ?>
                            </span>
                          </div>
                          <div class="author-tag">
                            by
                            <a class="hvr-underline-reveal author-name" href="user.php?user=<?php echo htmlentities($row['username'])?>">
                              <?php echo htmlentities($row['username'])?>
                            </a>
                            on <?php echo $row['timestamp']?>
                          </div>
                          <a href="post.php?post=<?php echo $row['id']?>"  class="mdl-button">Permalink</a>
                        </div>
                      </div>
                      <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="opt<?php echo $row['id']?>">
                        <i class="material-icons">more_vert</i>
                      </button>
                      <ul class="mdl-menu mdl-js-menu mdl-menu--bottom-right" for="opt<?php echo $row['id']?>">
                        <?php
                          if($row['owner'] == $userId){
                           ?>
                              <li class="mdl-menu__item" onclick="deletePost(this,<?php echo $row['id']?>)">Delete</li>
                            <?php
                          }
                          if($_loggedIn){
                            ?>
                              <li class="mdl-menu__item hvr-icon-float-away share" onclick="openShareDialogue(<?php echo $row['id']?>)">Share</li>
                            <?php
                          }
                        ?>
                      </ul>
                    </section>
                  <?php
                }
              }else{
                ?>
                <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
                  <div class="mdl-card mdl-cell mdl-cell--12-col">
                    <div class="post-card-text mdl-card__supporting-text">
                      No one has posted here yet...
                    </div>
                    <div class="mdl-card__actions">
                      <a href="index.php" class="mdl-button">GO BACK</a>
                    </div>
                </section>
                <?php
              }
            }else{
              ?>
              <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
                <div class="mdl-card mdl-cell mdl-cell--12-col">
                    <div class="post-card-text mdl-card__supporting-text">
                      Uh oh... no channel found. 404!!1!
                    </div>
                    <div class="mdl-card__actions">
                      <a href="index.php" class="mdl-button">GO BACK</a>
                    </div>
                </section>
              <?php
            }
          ?>
        </div>
      </main>
    </div>
    <script src="https://code.getmdl.io/1.2.1/material.min.js"></script>
    <?php if($_loggedIn) { ?><script src="js/share.js"></script><?php } ?>
  </body>
</html>

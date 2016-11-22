<?php
  include'php/header.php';
  $_posting = isset($_GET['new']);
  $_postid = $_GET['post'];

  if(!empty($_POST['dest']) && !empty($_POST['postContent']) && $_loggedIn){
    $_posting = false;
    $queryChannelId->bind_param("s", $_POST['dest']);
    $queryChannelId->execute();
    $resCh = $queryChannelId->get_result();
    $rowCh = $resCh->fetch_assoc();
    if(isset($rowCh)){
      $insertPost->bind_param("sss", $_SESSION['userID'], $rowCh['id'], $_POST['postContent']);
      if($insertPost->execute()){
        $newPost = $mysqli->query("SELECT LAST_INSERT_ID() AS id;")->fetch_assoc();
        $_postid = $newPost['id'];
        //echo "<script>document.location = \"post.php?post=" . $newPost['id'] . "\"</script>";
      }else{
        $error = "Could not create post!";
      }
    }else{
      $error = "Channel does not exist!";
    }
  }
  if(!$_posting){
    if(isset($_postid)){
      $queryPosts->bind_param("iss", $userId, $_postid, $null);
      $queryPosts->execute();
      $res = $queryPosts->get_result();
      $row = $res->fetch_assoc();
    }
  }
 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title> post | chirper </title>

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
    <script src="js/like.js"></script>
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
          <span class="mdl-layout__tab" id="current-channel"> Post </span>
          <?php
          if(!$_loggedIn){
            $queryDefaultChannels->execute();
            $res = $queryDefaultChannels->get_result();
            while($rowCh = $res->fetch_assoc()){
              echo "<a href=\"channel.php?ch=" . $rowCh['name'] . "\" class=\"mdl-layout__tab\">#". $rowCh['name'] . "</a>";
            }
            echo "
              <div style=\"width: 100%;\">
                <a href=\"login.php\" class=\"mdl-layout__tab login-button\">LOGIN</a>
              </div>";
          }else{
            $queryUserSubscribed->bind_param("s", $_SESSION['userID']);
            $queryUserSubscribed->execute();
            $res = $queryUserSubscribed->get_result();
            while($rowCh = $res->fetch_assoc()){
              echo "<a href=\"channel.php?ch=" . $rowCh['name'] . "\" class=\"mdl-layout__tab\">#". $rowCh['name'] . "</a>";
            }
            echo "
              <div style=\"width: 100%;\">
                <a href=\"logout.php\" class=\"mdl-layout__tab login-button\">LOGOUT</a>
              </div>";
          }
          ?>
        </div>
      </header>
      <main class="mdl-layout__content">
        <div class="mdl-layout__tab-panel is-active" id="overview">
          <section class="section--center mdl-grid mdl-grid--no-spacing">
            <?php
            if(!$_posting){
              if(isset($row)){
                echo "<div class=\"mdl-card mdl-cell mdl-cell--12-col mdl-shadow--2dp post-card\">
                        <div class=\"post-card-text mdl-card__supporting-text\">"
                          . $row['message'] .
                        "</div>
                        <div class=\"mdl-card__actions\">
                          <div class=\"likes-container\">
                            <i class=\"fa fa-heart likes-heart " . (($row['likes']) ? "heart-red":"heart-gray") . "\"
                              aria-hidden=\"true\" onclick=\"likes(this," . $row['id'] . "," . $userId . "," . $row['likes'] . ")\"></i>
                            <span id=\"count" . $row['id'] . "\">" . $row['total'] .
                            "</span>
                          </div>
                          <div class=\"author-tag\">
                            by
                            <a class=\"hvr-underline-reveal author-name\" href=\"user.php?user="
                              . $row['username'] . "\">"
                              . $row['username'] .
                            "</a>
                            on "
                            . $row['timestamp'] .
                            " | posted in
                            <a class=\"hvr-underline-reveal author-name\" href=\"channel.php?ch="
                              . $row['name'] . "\">"
                              . $row['name'] .
                            "</a>
                          </div>
                        </div>
                      </div>";
              } else {
                echo "<div class=\"mdl-card mdl-cell mdl-cell--12-col mdl-shadow--2dp post-card\">
                        <div class=\"post-card-text mdl-card__supporting-text\">
                        Uh oh... no post found.
                        </div>
                        <div class=\"mdl-card__actions\">
                          <a href=\"index.php\" class=\"mdl-button\">GO BACK</a>";
              }
            }else{
              ?>
              <div class="mdl-card mdl-cell mdl-cell--12-col mdl-shadow--2dp post-card">
                <div class="mdl-card__supporting-text">
              <?php
              if($_loggedIn){
              ?>
                    <h4>New Post to #<?php echo $_GET['new'] ?> </h4>
                    <form class="" action="post.php" method="post">
                      <div id="counterDisp" style="color: #AAA;">Remaining: 500</div>
                      <div class="mdl-textfield mdl-js-textfield">
                        <textarea class="mdl-textfield__input" type="text" rows= "10" onkeyup="counter()" name="postContent" id="textArea1"></textarea>
                        <label class="mdl-textfield__label" for="textArea1">Write here...</label>
                      </div>
                      <input type="hidden" name="dest" value="<?php echo $_GET['new']; ?>">
                      <div>
                        <input type="submit" class="hvr-fade login-submit-en" id="login-submit">
                      </div>
                    </form>
                    <span class="error"><?php echo $error; ?></span>
                    <script type="text/javascript">
                      function counter(){
                        var max = 500;
                        var field = document.getElementById("textArea1");
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

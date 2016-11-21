<?php
  session_start();
  $_loggedIn = !empty($_SESSION['LoggedIn']) && !empty($_SESSION['username']) && $_SESSION['LoggedIn'];

  $_config = parse_ini_file("../php_files/config.php.ini");
  $mysqli = new mysqli("localhost", $_config['mysqluser'], $_config['mysqlpass'], $_config['mysqlDB']);

  $userId = isset($_SESSION['userID']) ? $_SESSION['userID'] : 0;

  $queryChannel = $mysqli->prepare(
    "SELECT USERS.username, POSTS.id, POSTS.message, POSTS.timestamp, CHANNELS.name, coalesce(likesCount, 0) AS total, coalesce(usrLikes, 0) AS likes
    FROM (CHANNELS INNER JOIN POSTS
      ON POSTS.channel = CHANNELS.id ) INNER JOIN USERS
        ON USERS.id = POSTS.owner LEFT JOIN
        (
          SELECT POSTS_id, count(*) AS likesCount, count(case USERS_id when (?) then 1 else null end) AS usrLikes
          FROM LIKES
          GROUP BY POSTS_id
        ) AS postLikes
          ON POSTS_id = POSTS.id
    WHERE CHANNELS.name=?
    ORDER BY timestamp DESC"
  );

  $queryPost = $mysqli->prepare(
    "SELECT USERS.username, POSTS.id, POSTS.message, POSTS.timestamp, CHANNELS.name, coalesce(likesCount, 0) AS total, coalesce(usrLikes, 0) AS likes
    FROM (CHANNELS INNER JOIN POSTS
      ON POSTS.channel = CHANNELS.id ) INNER JOIN USERS
        ON USERS.id = POSTS.owner LEFT JOIN
        (
          SELECT POSTS_id, count(*) AS likesCount, count(case USERS_id when (?) then 1 else null end) AS usrLikes
          FROM LIKES
          GROUP BY POSTS_id
        ) AS postLikes
          ON POSTS_id = POSTS.id
    WHERE POSTS.id = ?"
  );

  $queryDefaultChannels = $mysqli->prepare("SELECT * FROM CHANNELS WHERE is_default = true");
  $querySubsChannels = $mysqli->prepare("");

  $queryFrontPage = $mysqli->prepare(
    "SELECT USERS.username, POSTS.id, POSTS.message, POSTS.timestamp, CHANNELS.name, coalesce(likesCount, 0) AS total, coalesce(usrLikes, 0) AS likes
    FROM (CHANNELS INNER JOIN POSTS
      ON POSTS.channel = CHANNELS.id ) INNER JOIN USERS
      ON USERS.id = POSTS.owner LEFT JOIN
      (
        SELECT POSTS_id, count(*) AS likesCount, count(case USERS_id when (?) then 1 else null end) AS usrLikes
        FROM LIKES
        GROUP BY POSTS_id
      ) AS postLikes
        ON POSTS_id = POSTS.id
    ORDER BY timestamp DESC"
   );

   $queryUserFrontPage = $mysqli->prepare("");

   $queryLoginData = $mysqli->prepare(
     "SELECT *
     FROM USERS
     WHERE username=? AND password=?
     "
   );

   $queryUserLikesPost = $mysqli->prepare(
     "SELECT coalesce(LikesPost.count, 0) AS likes
     FROM LIKES
     WHERE USERS_id=? AND USERS_id=?
     "
   );


   $queryUserSubscribed = $mysqli->prepare(
     "SELECT CHANNELS_id, name
     FROM SUBSCRIBED INNER JOIN CHANNELS_id
       ON SUBSCRIBED.CHANNELS_id = CHANNELS.id
     WHERE USERS_id=?
     "
   );

   $queryChannelId = $mysqli->prepare(
     "SELECT id
     FROM CHANNELS
     WHERE name=?"
   );

   $insertPost = $mysqli->prepare(
     "INSERT INTO POSTS (owner, channel, message) values (?,?,?)"
   );

   $insertLike = $mysqli->prepare(
     "INSERT IGNORE INTO LIKES values (?,?)"
   );

   $deleteLike = $mysqli->prepare(
     "DELETE FROM LIKES WHERE USERS_id=? AND POSTS_id=?"
   );
?>

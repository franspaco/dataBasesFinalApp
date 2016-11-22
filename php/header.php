<?php
  session_start();
  $_loggedIn = !empty($_SESSION['LoggedIn']) && !empty($_SESSION['username']) && $_SESSION['LoggedIn'];

  $_config = parse_ini_file("../php_files/config.php.ini");
  $mysqli = new mysqli("localhost", $_config['mysqluser'], $_config['mysqlpass'], $_config['mysqlDB']);

  $userId = isset($_SESSION['userID']) ? $_SESSION['userID'] : 0;

  $null = NULL;
  //POST QUERY *****************************************************************
  //usr, post, chann
  $queryPosts = $mysqli->prepare(
    "SELECT USERS.username, POSTS.id, POSTS.owner, POSTS.message, POSTS.timestamp, CHANNELS.name, coalesce(likesCount, 0) AS total, coalesce(usrLikes, 0) AS likes
    FROM CHANNELS INNER JOIN POSTS
      ON POSTS.channel = CHANNELS.id INNER JOIN USERS
        ON USERS.id = POSTS.owner LEFT JOIN
        (
          SELECT POSTS_id, count(*) AS likesCount, count(case USERS_id when (?) then 1 else null end) AS usrLikes
          FROM LIKES
          GROUP BY POSTS_id
        ) AS postLikes
          ON POSTS_id = POSTS.id
    WHERE
    POSTS.id = coalesce(?, POSTS.id)
    AND
    CHANNELS.name = coalesce(?, CHANNELS.name)
    ORDER BY timestamp DESC"
  );

  //FRONT PAGE *****************************************************************
  $queryUserFrontPage = $mysqli->prepare(
    "SELECT USERS.username, POSTS.id, POSTS.message, POSTS.timestamp, CHANNELS.name, coalesce(likesCount, 0) as total, coalesce(usrLikes, 0) as likes
     FROM SUBSCRIBED INNER JOIN CHANNELS ON CHANNELS.id = SUBSCRIBED.CHANNELS_id INNER JOIN POSTS
        ON POSTS.channel = CHANNELS.id INNER JOIN USERS
		      ON USERS.id = POSTS.owner LEFT JOIN
          (
			      SELECT POSTS_id, count(*) as likesCount, count(case USERS_id when 2 then 1 else null end) AS usrLikes
	          FROM LIKES
		        GROUP BY POSTS_id
          ) AS postLikes
			       ON POSTS_id = POSTS.id
     WHERE SUBSCRIBED.USERS_id = ?
     GROUP BY POSTS.id
     ORDER BY POSTS.timestamp DESC"
   );

   //CHANNELS QUERIES **********************************************************
   $queryDefaultChannels = $mysqli->prepare(
     "SELECT *
     FROM CHANNELS
     WHERE is_default = true"
   );

   $queryChannelId = $mysqli->prepare(
     "SELECT id
     FROM CHANNELS
     WHERE name=?"
   );

   //LOGIN CHECKING / CREATION *************************************************
   $queryLoginData = $mysqli->prepare(
     "SELECT *
     FROM USERS
     WHERE username=?
     "
   );

   $insertNewUser = $mysqli->prepare(
     "INSERT INTO USERS (username, password, email) values (?,?,?)"
   );

   //POST INSERTION/DELETION ***************************************************
   $insertPost = $mysqli->prepare(
     "INSERT INTO POSTS (owner, channel, message) values (?,?,?)"
   );

   $deletePost = $mysqli->prepare(
     "DELETE FROM POSTS WHERE owner=? AND id=?"
   );

   //LIKE INSERTION/DELETION ***************************************************
   $insertLike = $mysqli->prepare(
     "INSERT IGNORE INTO LIKES values (?,?)"
   );

   $deleteLike = $mysqli->prepare(
     "DELETE FROM LIKES WHERE USERS_id=? AND POSTS_id=?"
   );

   //SUBSCRIPTION CHECKING / INSERTION / DELETION ******************************
   $queryUserSubscribed = $mysqli->prepare(
     "SELECT CHANNELS_id, name
     FROM SUBSCRIBED INNER JOIN CHANNELS
       ON SUBSCRIBED.CHANNELS_id = CHANNELS.id
     WHERE USERS_id=?
     "
   );

   $querySubscribed = $mysqli->prepare(
     "SELECT count(*) AS is_sub
     FROM SUBSCRIBED INNER JOIN CHANNELS
      ON CHANNELS.id = SUBSCRIBED.CHANNELS_id
     WHERE SUBSCRIBED.USERS_id=? AND CHANNELS.name=?"
   );

   $insertSubscription = $mysqli->prepare(
     "INSERT INTO SUBSCRIBED values(?,?)"
   );

   $deleteSubscription = $mysqli->prepare(
     "DELETE FROM SUBSCRIBED WHERE USERS_id=? AND CHANNELS_id=?"
   );
?>

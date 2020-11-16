<?php
  session_start();
  if(!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {
    header("Location: ../../index.php");
    exit();
  }

if(empty($_POST['content']) || empty($_POST['videoID'])) {
  print(0);
  exit();
}

$content = htmlentities($_POST['content']);
$videoID = htmlentities($_POST['videoID']);

//add limiter for content

require("../modules/db.php");

$db = new Database();
$SQL = "INSERT INTO comments (author_id, video_id, content) VALUES (?, ?, ?)";

$db->query($SQL,$_SESSION['id_user'], $videoID, $content);
$db->close();
print(1);

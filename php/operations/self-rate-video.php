<?php
  session_start();
  if(!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {
    header("Location: ../../index.php");
    exit();
  }

require("../modules/db.php");

$video_id = htmlentities($_POST['videoID']);
$operation = htmlentities($_POST['operation']);
$user_id = $_SESSION['id_user'];


if(!($operation == "like" || $operation == "dislike" || $operation == "unselected") || empty($video_id)) {
  print(0);
  exit();
}

$db = new Database();
$db->query("SELECT type FROM videos_actions WHERE video_id=? AND user_id=?", $video_id, $user_id)->store_result();
$db->setAutocommit(false);

if($db->num_rows() == 1) {
  $row = $db->fetchRow();
  if($row != $operation) {

    $db->query("UPDATE videos_actions SET type=? WHERE video_id=? AND user_id=?", $operation, $video_id, $user_id);

    if($row['type'] == "like") {
      if($operation == "dislike") {
        $db->query("UPDATE videos SET rating = rating - 2 WHERE id_video=?", $video_id);
      } else if($operation == "unselected") {
        $db->query("UPDATE videos SET rating = rating - 1 WHERE id_video=?", $video_id);
      }
    } else if($row['type'] == "dislike") {
      if($operation == "like") {
        $db->query("UPDATE videos SET rating = rating + 2 WHERE id_video=?", $video_id);
      } else if($operation == "unselected") {
        $db->query("UPDATE videos SET rating = rating + 1 WHERE id_video=?", $video_id);
      }
    } else if($row['type'] == "unselected") {
      if($operation == "like") {
        $db->query("UPDATE videos SET rating = rating + 1 WHERE id_video=?", $video_id);
      } else if($operation == "dislike") {
        $db->query("UPDATE videos SET rating = rating - 1 WHERE id_video=?", $video_id);
      }
    }
  }

} else if($db->num_rows() < 1){
  $db->query("INSERT INTO videos_actions VALUES (NULL, ?, ?, ?)", $video_id, $user_id, $operation);
  switch($operation) {
    case "like":
      $db->query("UPDATE videos SET rating = rating + 1 WHERE id_video=?", $video_id);
    break;

    case "dislike":
      $db->query("UPDATE videos SET rating = rating - 1 WHERE id_video=?", $video_id);
    break;
  }
}

$db->commit();
$db->close();
print(1);
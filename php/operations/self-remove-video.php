<?php
  session_start();
  if(!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {
    header("Location: ../../index.php");
    exit();
  }

  $videoID = htmlentities($_POST['videoID']);

  if(empty($videoID)) {
    print(0);
  }
  
  require("../modules/db.php");
  require("../modules/init.php");

  $db = new Database();
  $SQL ='
  SELECT 
    v.id_video as video_id,
    u.id_user as author_id,
    tf.id_thumbnail as thumbnail_id,
    CONCAT(tf.thumbnail_code, ".", tf.extension) as thumbnail_filename,
    vf.id_videoFile as videoFile_id,
    CONCAT(vf.video_code, ".", vf.extension) as video_filename
  FROM
    videos as v
    INNER JOIN users as u ON u.id_user=v.author_id
    INNER JOIN videosFiles as vf ON vf.id_videoFile=v.videoFile_id
    INNER JOIN thumbnailsFiles as tf ON v.thumbnailFile_id=tf.id_thumbnail
  WHERE
    v.id_video=?';

  $db->query($SQL, $videoID)->store_result();
  if($db->num_rows() == 1) {
    $result = $db->fetchRow();

    if($result['author_id'] != $_SESSION['id_user'] && $_SESSION['modifyVideos'] != TRUE) {
      print('Insufficient permissions!');
      exit();
    }

    $allow_delete = TRUE;
    $db->setAutocommit(false);
    if($db->query('DELETE FROM videos WHERE id_video=?', $result['video_id'])) {

    } else
      $allow_delete = FALSE;

    if($db->query('DELETE FROM videosFiles WHERE id_videoFile=?', $result['videoFile_id'])) {

    } else 
      $allow_delete = FALSE;

    if($db->query('DELETE FROM thumbnailsFiles WHERE id_thumbnail=?', $result['thumbnail_id'])) {

    } else 
      $allow_delete = FALSE;

    
    if($allow_delete) {
      $db->commit();
      unlink(THUMBNAILS_FOLDER . $result['thumbnail_filename']);
      unlink(VIDEOS_FOLDER . $result['video_filename']);
    } else {
      $db->rollback();
      $db->close();
    }
    $db->close();
    print(1);
  } else {
    $db->close();
    print(0);
  }
<?php
  session_start();
  if(!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {
    header("Location: ../../index.php");
    exit();
  }

  require('../modules/init.php');

  require('../modules/getid3/getid3.php');
  $getID3 = new getID3;

  $video = $_FILES['video_file'];
  $video['title'] = htmlentities($_POST['videoTitle']);
  $video['description'] = htmlentities($_POST['videoDesc']);
  $video['author_id'] = $_SESSION['id_user'];
  $video['extension'] = pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION);
  $video['proporties'] = $getID3->analyze($_FILES['video_file']['tmp_name']);

  $thumbnail = $_FILES['thumbnail_file'];
  $thumbnail['extension'] = pathinfo($_FILES['thumbnail_file']['name'], PATHINFO_EXTENSION);

  require('../modules/db.php');
  $db = new Database();

  function err($string = 0) {
    global $db;
    global $video;
    global $thumbnail;
    global $send_success;

    //delete if file was placed
    if(isset($video['destination'])) {
      if(file_exists($video['destination']))
      unlink($video['destination']);
    }
    //delete if file was placed
    if(isset($thumbnail['destination'])) {
      if(file_exists($thumbnail['destination']))
      unlink($thumbnail['destination']);
    }

    //detele database items
    if((isset($send_success['video']) && $send_success['video']) || (isset($send_success['thumbnail']) && $send_success['thumbnail'])) {
      $db->setAutocommit(true);
      if((isset($send_success['video']) && $send_success['video']))
        $db->query('DELETE FROM videosFiles WHERE video_code=?', $video['code']);

      if(isset($send_success['thumbnail']) && $send_success['thumbnail'])
        $db->query('DELETE FROM thumbnailsFiles WHERE thumbnail_code=?', $thumbnail['code']);
    }

    print($string);
    $db->close();
    exit();
  }

  function success() {
    print(1);
    $db->close();
    exit();
  }

  //videoFile preperations
  $db->justQuery('SELECT video_code FROM videosFiles ORDER BY id_videoFile DESC LIMIT 1')->store_result();
  $result = $db->fetchRow();

  $i = 1;
  do {
    $video['code'] = intval($result['video_code']) + $i++;
    $video['code'] = strval($video['code']);
    $length = strlen($video['code']);
    for($i = 8; $i > $length; $i--) {
      $video['code'] = '0' . $video['code'];
    }
    $video['destination'] = VIDEOS_FOLDER . $video['code'] . '.' . $video['extension'];

  } while(file_exists($video['destination']));


  //thumbnailFile preperations
  $db->justQuery('SELECT thumbnail_code FROM thumbnailsFiles ORDER BY id_thumbnail DESC LIMIT 1')->store_result();
  $result = $db->fetchRow();

  $i = 1;
  do {
    $thumbnail['code'] = intval($result['thumbnail_code']) + $i++;
    $thumbnail['code'] = strval($thumbnail['code']);
    $length = strlen($thumbnail['code']);
    for($i = 8; $i > $length; $i--) {
      $thumbnail['code'] = '0' . $thumbnail['code'];
    }
    $thumbnail['destination'] = THUMBNAILS_FOLDER . $thumbnail['code'] . '.' . $thumbnail['extension'];

  } while (file_exists($thumbnail['destination']));

  $send_success = ['video' => FALSE, 'thumbnail' => FALSE];

  $db->setAutocommit(false);
  if($db->query('INSERT INTO videosFiles(video_code, extension, duration) VALUES (?, ?, ?)', $video['code'], $video['extension'], $video['proporties']['playtime_seconds'])) {
    move_uploaded_file($_FILES['video_file']['tmp_name'], $video['destination']);
    $send_success['video'] = TRUE;//inform delete function iin case of further error
  } else
    err('Video could not be added to database!');

  if($db->query('INSERT INTO thumbnailsFiles (thumbnail_code, extension) VALUES (?, ?)', $thumbnail['code'], $thumbnail['extension'])) {
    move_uploaded_file($_FILES['thumbnail_file']['tmp_name'], $thumbnail['destination']);
    $send_success['thumbnail'] = TRUE; //inform delete function iin case of further error
  } else
    err('Thumbnail could not be added!');
  
  $db->commit();
  $db->setAutocommit(true);

  $videoFile_idSQL = 'SELECT id_videoFile FROM videosFiles WHERE video_code = ?';
  $thumbnailFile_idSQL = 'SELECT id_thumbnail FROM thumbnailsFiles WHERE thumbnail_code = ?';

  //Get video 
  if($db->query($videoFile_idSQL, $video['code'])) {
    $db->store_result();
    if($db->num_rows() == 1) {
      $result = $db->fetchRow();
      $video['videoFile_id'] = $result['id_videoFile'];
    } else {
      err();
    }
  } else 
    err();
  
  //Get thumbnail 
  if($db->query($thumbnailFile_idSQL, $thumbnail['code'])) {
    $db->store_result();
    if($db->num_rows() == 1) {
      $result = $db->fetchRow();
      $video['thumbnail_id'] = $result['id_thumbnail'];
    } else {
      err();
    }
  } else 
    err();

  $videoInsertSQL ='
  INSERT INTO
    videos (title, description, videoFile_id, thumbnailFile_id, author_id)
  VALUES
    (?, ?, ?, ?, ?);';
  
  if($db->query($videoInsertSQL, $video['title'], $video['description'], $video['videoFile_id'], $video['thumbnail_id'], $video['author_id']))  {
    success();
  } else
    err();

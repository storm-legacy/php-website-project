<?php
  session_start();
  if(empty($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit();
  }
  
  require("../php/modules/db.php");
  $offset = isset($_POST['offset']) ? htmlentities($_POST['offset']) : 0;
  $limit = isset($_POST['limit']) ? htmlentities($_POST['limit']) : 15;
  $string = isset($_POST['pattern']) ? '%'.htmlentities($_POST['pattern']).'%' : null;
  $userSpecified = isset($_POST['username']) ? htmlentities($_POST['username']) : null;

  $db = new Database();

  if(!empty($string)) {
    $SQL ='
    SELECT
      v.id_video as id,
      v.title,
      vf.duration,
      v.views,
      ui.title as "author",
      CONCAT(th.thumbnail_code, ".", th.extension) as "thumbnail_file",
      v.status,
      v.upload_date as date
    FROM
      videos as v,
      videosFiles as vf,
      thumbnailsFiles as th,
      usersInfo as ui,
      users as u
    WHERE
      v.videoFile_id=vf.id_videoFile AND
      v.thumbnailFile_id=th.id_thumbnail AND
      v.author_id=u.id_user AND ui.id_user=u.id_user AND
      v.title LIKE ? AND
      v.status="public" LIMIT ? OFFSET ?;';

      $db->query($SQL, $string, $limit, $offset)->store_result();

  } else if(!empty($userSpecified)) {
    switch($userSpecified) {
      case "%self%":
        $SQL = '
        SELECT
          v.id_video as id,
          v.title,
          vf.duration,
          v.views,
          ui.title as "author",
          CONCAT(th.thumbnail_code, ".", th.extension) as "thumbnail_file",
          v.status,
          v.upload_date as date
        FROM
          videos as v,
          videosFiles as vf,
          thumbnailsFiles as th,
          usersInfo as ui,
          users as u
        WHERE
          v.videoFile_id=vf.id_videoFile AND
          v.thumbnailFile_id=th.id_thumbnail AND
          v.author_id=u.id_user AND ui.id_user=u.id_user AND
          u.id_user=? LIMIT ? OFFSET ?;';

        $db->query($SQL, $_SESSION['id_user'], $limit, $offset)->store_result();
      break;
      }
    } else {

    $SQL ='
    SELECT
      v.id_video as id,
      v.title,
      vf.duration,
      v.views,
      ui.title as "author",
      CONCAT(th.thumbnail_code, ".", th.extension) as "thumbnail_file",
      v.status,
      v.upload_date as date
    FROM
      videos as v,
      videosFiles as vf,
      thumbnailsFiles as th,
      usersInfo as ui,
      users as u
    WHERE
      v.videoFile_id=vf.id_videoFile AND
      v.thumbnailFile_id=th.id_thumbnail AND
      v.author_id=u.id_user AND ui.id_user=u.id_user AND
      v.status="public" LIMIT ? OFFSET ?;';

      $db->query($SQL, $limit, $offset)->store_result();
    }
    
    $result = $db->fetchAll();


  if($result) {
    echo json_encode($result);
  } else {
    echo 'null';
  }
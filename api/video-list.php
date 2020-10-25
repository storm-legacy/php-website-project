<?php
  require("../php/modules/db.php");
  $offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
  $db = new Database();

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
    v.status="public" LIMIT 15 OFFSET ?;';

  $db->query($SQL, $offset)->store_result();
  $result = $db->fetchAll();

  if($result) {
    echo json_encode($result);
  } else {
    echo 'null';
  }
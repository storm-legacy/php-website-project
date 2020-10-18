<?php
  require('php-backend/database-conn.php');

  $thumbnails_folder = "usr_files/thumbnails";
  $SQL ='
  SELECT
    v.title,
    vf.duration,
    v.views,
    ui.title as "author",
    CONCAT(th.thumbnail_code, ".", th.extension) as "thumbnail_file",
    vf.video_code,
    v.status
  FROM
    videos as v,
    videosFiles as vf,
    thumbnailsFiles as th,
    usersInfo as ui,
    users as u
  WHERE
    v.videoFile_id=vf.id_videoFile AND
    v.thumbnailFile_id=th.id_thumbnail AND
    v.author_id=u.id_user AND ui.id_user=u.id_user;';

  $stmt = $connection->stmt_init();
  $stmt->prepare($SQL);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

  function pretty_viewCount($views) {
    if($views < 1000)
      return $views;
    else if($views < 1000000)
      return round($views/1000)."k";
    else if($views < 1000000000)
      return round($views/1000000)."m";
  }

  function pretty_duration($timeInSec) {
    if($timeInSec < 3600)
    {
      $sec = $timeInSec % 60;
      $min = ($timeInSec - $sec) / 60;

      if($min < 10)
        $min = "0".$min;

      if($sec < 10)
        $sec = "0".$sec;
      
      return $min.":".$sec;
    } else {

      $sec = $timeInSec % 60;
      $minutesFromSeconds = ($timeInSec - $sec) / 60;
      $min = $minutesFromSeconds % 60;
      $hour = ($minutesFromSeconds - $min) / 60;

      if($min < 10)
        $min = "0".$min;

      if($sec < 10)
        $sec = "0".$sec;

      if($hour < 10)
        $hour = "0".$hour;

      return $hour.":".$min.":".$sec;
    }
  }
?>
<div class="videosGrid">
  <?php
    foreach($result as $item => $key) {

      if($key['status'] == 'public') {
        echo "<div class=\"video-block\"><a href=\"?page=video&link=".$key['video_code']."\">";
        echo "<div class=\"thumbnail\"><img src=\"".$thumbnails_folder."/".$key['thumbnail_file']."\" alt=\"video-img\">";
        echo "<span>".pretty_duration($key['duration'])."</span></div></a><div class=\"desc\">";
        echo "<a href=\"#\" class=\"title\">".$key['title']."</a><a href=\"#\" class=\"author\">@".$key['author']."</a>";
        echo "<span class=\"viewCount\"> - ".pretty_viewCount($key['views'])." views</span></a></div></div>";
      }
    }
  ?>
</div>
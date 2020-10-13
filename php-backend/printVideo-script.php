<?php
  if(empty($_SESSION['id_user'])) {
    header("Location: ../index.php?page=login");
    exit();
  }
  require('php-backend/database-conn.php');

  $SQL = "SELECT v.title, v.duration, v.views, u.user_username as author, v.file_video, v.file_thumbnail FROM videos as v, users as u WHERE u.id_user=v.author_id ";
  $stmt = $connection -> stmt_init();
  $stmt->prepare($SQL);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

  $thumbnails_folder = "usr_files/thumbnails";
  $videos_folder = "usr_files/videos";
  
  // $key = [
  //   "file_video" => '00000000',
  //   "file_thumbnail" => '00000000',
  //   "duration" => '7650',
  //   "title" => 'template_video',
  //   "author" => 'helloKitty',
  //   "views" => '1000000'
  // ];

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

  function generate_videos() {

    global $result;
    global $thumbnails_folder;
    global $videos_folder;

    foreach($result as $item => $key) {
      echo "<div class=\"video-block\"><a href=\"?page=video&link=".$key['file_video']."\">";
      echo "<div class=\"thumbnail\"><img src=\"".$thumbnails_folder."/".$key['file_thumbnail'].".jpg\" alt=\"video-img\">";
      echo "<span>".pretty_duration($key['duration'])."</span></div></a><div class=\"desc\">";
      echo "<a href=\"#\" class=\"title\">".$key['title']."</a><a href=\"#\" class=\"author\">@".$key['author']."</a>";
      echo "<span class=\"viewCount\"> - ".pretty_viewCount($key['views'])." views</span></a></div></div>";
    }


  }

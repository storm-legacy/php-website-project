<?php
  if(empty($_SESSION['id_user'])) {
    header("Location: ../index.php?page=login");
    exit();
  }
  require('php-backend/database-conn.php');
  $stmt = $connection -> stmt_init();
  $query = "SELECT * FROM videos";
  $stmt->prepare($query);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

  $thumbnails_folder = "../../usr_files/thumbnails";
  
  function generate_videos() {
    global $result;
    global $thumbnails_folder;
    global $videos_folder;

    foreach($result as $item => $key) {
      echo "<div class=\"video-block\"><a href=\"?page=video&link=".$key['video_fileAddr']."\">";
      echo "<div class=\"thumbnail\"><img src=\"".$key['video_thumbnailAddr']."\""
      echo "</a></div>";
    }
    //TODO


    // echo '<img src="img/video_thumbnail.jpg" alt="video_img"><span>00:00</span></div></a><div class="desc"><a href="#" class="title">Video template</a><a href="#" class="author">@Author</a><span class="viewCount"> - 2.5m views</span></div></div>';
  }

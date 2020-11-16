<?php
  //if user doesn't have admin rights inform and return to main
  if($_SESSION['id_user'] != true) {
    header("Location: ../../index.php?page=home&error=insufficientpermissions");
    exit();
  }

  $video_id = 0;
  if(!empty($_GET['link'])) {
    $video_id = (int)htmlentities($_GET['link']);
  } else {
    exit();
  }

  $today = date("y-m-d h:i:s");

  function pretty_date($value, $type = 1) {

    $value = new DateTime($value);
    switch($type) {
      case 1:
        return $value->format("Y-m-d h:i");
        break;
      case 2:
        return $value->format("d M Y");
        break;
    }
  }

  
  $viewSQL = "UPDATE videos SET views = views + 1 WHERE id_video=?";
  require("php/modules/db.php");
  $db = new Database();
  $videoSQL = '
    SELECT
      v.id_video as id,
      v.title,
      v.views,
      v.rating,
      v.description,
      v.upload_date as date,
      v.author_id,
      ui.title as username,
      CONCAT(a.avatar_code, ".", a.file_extension) as avatar_file,
      CONCAT(vf.video_code, ".", vf.extension) as video_file
    FROM
      videos as v,
      videosFiles as vf,
      users as u,
      usersInfo as ui,
      avatarsFiles as a
    WHERE
      v.videoFile_id=vf.id_videoFile AND
      v.author_id=u.id_user AND u.id_user=ui.id_user AND
      ui.avatar_id=a.id_avatar AND v.id_video=?;';
      
  $commentsSQL = '
    SELECT
      c.id_comment as id, c.author_id, ui.title as user_title, u.user_username as username, c.content, c.post_date, CONCAT(a.avatar_code, ".", a.file_extension) as avatar_file
    FROM 
      comments as c, users as u, usersInfo as ui, avatarsFiles as a
    WHERE
      c.video_id=? AND
        c.author_id = u.id_user AND ui.id_user = u.id_user AND a.id_avatar=ui.avatar_id
    ORDER BY
      c.post_date DESC;';

  $usrRatingSQL = 'SELECT type FROM videos_actions WHERE video_id=? AND user_id=?;';

  $db->query($videoSQL, $video_id)->store_result();
  $video = $db->fetchRow();

  $db->query($commentsSQL, $video_id)->store_result();
  $comments = $db->fetchAll();

  $db->query($usrRatingSQL, $video_id, $_SESSION['id_user'])->store_result();
  $usrRating = $db->fetchRow();
  
  $db->setAutocommit(false);
  $db->query($viewSQL, $video_id); //increase view count
  $db->commit();

  if(empty($video)) {
    print("Video doesn't exist");
    exit();
  }
  $db->close();
    

?>
<div class="blackScreen">
  <div class="popup">
    <div class="heading-block">
      <span class="notify">Confirm comment deletion</span>
      <input class="commID" type="text" disabled value="00">
    </div>
    <div class="comment-block slim">
      
    </div>
    <div class="buttonsBlock">
      <button class='confirmVideoDelete'>Confirm</button>
      <button class="confirmCommentDelete">Confirm</button>
      <button class="cancel">Cancel</button>
    </div>
  </div>
</div>


<a href="?page=home" class="backButton">
  <span class="icon back"></span>
</a>
<?php
  if($video['author_id'] == $_SESSION['id_user'] || $_SESSION['modifyVideos'] == TRUE) {
    printf('<div class="deletion-block" id="%d">', $video['id']);
    print('<span class="icon trash1"></span>');
    printf('<span>%s</span>', 'Delete video');
    print('</div>');
  }
?>
<div class="videoWrapper">
  <div class="videoContainer">

    <video class='video' src="usr_files/videos/<?php print($video['video_file']) ?>"></video>

    <div class="bar">
      <div class="controls">
        <div class="buttons">
          <button class="play-pause play"></button>
        </div>
      </div>
      <div class="progressBar">
        <div class="progress"></div>
      </div>
    </div>
  </div>
  <div class="videoInformations">
    <span class="title"><?php print($video['title']) ?></span>
    <span class="uploadDate"><?php print(pretty_date($video['date'], 2))?></span>
    <span class="views"><?php print($video['views']) ?> <i>views</i></span>
    <div class="rating">
      <?php 
        if(!empty($usrRating)) {
          if($usrRating['type'] == "like") {
            print('<span class="icon minus"></span>');
            printf('<span class="value liked">%d</span>', $video['rating']);
            print('<span class="icon plus active"></span>');
          } else if($usrRating['type'] == "dislike"){
            print('<span class="icon minus active"></span>');
            printf('<span class="value disliked">%d</span>', $video['rating']);
            print('<span class="icon plus"></span>');
          } else if ($usrRating['type'] == "unselected") {
            print('<span class="icon minus"></span>');
            printf('<span class="value">%d</span>', $video['rating']);
            print('<span class="icon plus"></span>');
          }
        }else {
          print('<span class="icon minus"></span>');
          printf('<span class="value">%d</span>', $video['rating']);
          print('<span class="icon plus"></span>');
        }
      ?>
    </div>
    
    
    <div class="desc">
      <div class="author">
        <div class="image">
          <img class="avatar" src="usr_files/avatars/<?php print($video['avatar_file']); ?>" alt="avatar">
        </div>
        <span class="author"><?php print($video['username']) ?></span>
      </div>
      <span><?php print($video['description']) ?></span>
    </div>
  </div>

  <div class="commentSection">
    <span>Comments</span>
    <div class="personalComment">
      <div class="avatar">
        <img src="usr_files/avatars/<?php print_avatar(); ?>" alt="user_avatar">
      </div>
      <div class="inputField">
        <div>
          <span class="username"><?php print_title(); print(" <i>@"); print_username(); print("</i>"); ?></span>
          <button class="postCommentButton">Send</button>
        </div>
        <textarea class="commentContent" placeholder="Write a comment..."></textarea>
      </div>
    </div>

    <div class="commentList">
      <?php
        if(!empty($comments)) {
          foreach($comments as $comment) {

            printf("<div class='comment-block comment-block-%d'>", $comment['id'], $comment['id']);

            //check if user has his comments
            if($comment['author_id'] == $_SESSION['id_user'])
              printf('<span id="%d" class="icon trash"></span>', $comment['id']);

            printf("<img class='avatar' alt='avatar' src='usr_files/avatars/%s' />", $comment['avatar_file']);
            printf("<div><div><span class='username'>%s <i>@%s</i></span><span class='post-date'>%s</span></div><span class='content'>%s</span></div></div>", $comment['user_title'], $comment['username'], pretty_date($comment['post_date']), $comment['content']);
          }
        } else {
          printf("<span class='nocomments'>%s</span>", "- No comments for this video -");
        }
      ?>
    </div>
  </div>

</div>
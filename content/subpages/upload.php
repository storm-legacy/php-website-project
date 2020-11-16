<?php
  if($_SESSION['id_user'] != true) {
    header("Location: ../../index.php?page=home&error=insufficientpermissions");
    exit();
  }
  // if(isset($_FILES['video_file'])) {
  //   $target = TMP.$_FILES['video_file']["name"];
  //   move_uploaded_file($_FILES['video_file']["tmp_name"], $target);
  //   print(1);

  // } else {
  //   err();
  // }

?>


<div class="wrapperUpload">
  <div>
    <h2 style='text-align:center;font-family:sans-serif;font-size: 40px;'>Video upload</h2>
  </div>
  <div class="form">
    <span>Title</span>
    <div class='row'>
      <input type="text" class="uploadedVideoTitle" placeholder='Video title'>  
    </div>
    <span>Description</span>
    <div class='row'>
      <textarea type="text" class="uploadedVideoDesc" placeholder='Video description'></textarea>
    </div>
    <span>Thumbnail image</span>
    <div class="imageDrop">
      <span class="thumbnailDropdown icon upload"></span>
    </div>
  </div>
</div>
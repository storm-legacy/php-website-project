<div class="customizationContainer">
  <form action="../php-backend/modifyUser-script.php" method="POST">
    <div class="profileInfo">
      <h3>Customize account</h3>
      <div class="row errorRow">
      </div>
      <div class="row">
        <span class="inputDesc">Title</span>
        <input type="text" name='title' placeholder="<?php print_userTitle(); ?>" disabled>
        <span class="edit"></span>
      </div>

      <div class="row">
        <span class="inputDesc">Username</span>
        <input type="text" placeholder="<?php print_username(); ?>" disabled>
      </div>

      <div class="row editEmail">
        <span class="inputDesc">E-mail</span>
        <input type="text" name="email" placeholder="<?php print_email(); ?>" disabled>
        <span class="edit"></span>
      </div>

      <div class="row confirmEmail">
        <span class="inputDesc">Confirm</span>
        <input type="text" placeholder="<?php print_email(); ?>" name="confirmEmail" value="">
      </div>
    </div>

    <div class="avatarBlock">
      <h3>Customize avatar</h3>
      <div class="avatar">
        <img src="usr_files/avatars/<?php print_avatarName(); ?>" alt="">
      </div>
      <input type="file">
    </div>

    <div class="breakRow"></div>

    <div class="buttonsBlock">
      <button name="send" type="submit" disabled>Save</button>
    </div>

  </form>
</div>
<div class="profileCustomizationWrapper">

  <div class="profileInfo">
    <div class="profileInfo">
      <h3>Customize account</h3>
      <div class="row errorRow">
      </div>
      <div class="imageRow">
        <img class='avatarImg' src="usr_files/avatars/<?php print_avatar(); ?>" alt="user-avatar">
        <span>Drop avatar to update</span>
        <h5>File cannot be larger than 512KB</h5>
      </div>

      <div class="row">
        <label for="title">Title</label>
        <input type="text" name="title" placeholder="<?php print_title(); ?>" disabled>
        <span class="icon edit-item editTitle"></span>
      </div>
      
      <div class="row">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="<?php print_username(); ?>" disabled>
        <span class="icon edit-item editUsername"></span>
      </div>
      
      <div class="row">
        <label for="email">E-mail</label>
        <input type="text" name="email" placeholder="<?php print_email(); ?>" disabled>
        <span class="icon edit-item editEmail"></span>
      </div>

      <div class="row hidden confirmEmailRow">
        <label for="confirmEmail">Confirm E-mail</label>
        <input type="text" name="confirmEmail" placeholder="<?php print_email(); ?>">
      </div>

      <div class="row">
        <label for="passwd">Password</label>
        <input type="password" name="passwd" placeholder="****************" disabled>
        <span class="icon edit-item editPasswd"></span>
      </div>

      <div class="row hidden confirmPasswordRow">
        <label for="confirmPasswd">Confirm Passwd</label>
        <input type="password" name="confirmPasswd" placeholder="****************">
      </div>
      
    </div>
  </div>

</div>

  <div class="mainGrid">

    <header>
      <span class="submenu-button-header fa fa-bars"></span>
      <div class="logo">
        <a href="?page=home"><span><?php echo(get_name(1)."<i>".get_name(2)."</i>"); ?></span></a>
      </div>
      <div class="PLACEHOLDER"></div>
      <div class="PLACEHOLDER"></div>
    </header>

    <div class="flexContainer">
      <div class="submenuContainer">
        <aside>

            <div class="top">
              <span class="submenu-button-submenu fa fa-close"></span>
              <div class="logo">
                <a href="?page=home"><span><?php echo(get_name(1)."<i>".get_name(2)."</i>"); ?></span></a>
              </div>
            </div>

            <div class="profileContainer noselect">
              <div class="profileIcon">
                <img class="noselect" src="usr_files/avatars/<?php print_avatarName(); ?>" alt="avatar">
              </div>

              <div class="text">
                <span class="title"><?php print_userTitle(); ?></span>
                <span class="username">@<?php print_username(); ?></span>
              </div>

              <div class="userPanel">
                <ul>
                  <?php generate_submenu(); ?>
                </ul>
              </div>
            </div>

            <div class="bottom">
              <a href="index.php?logout=true"><i class="fa fa-lock"></i> Logout</a>
            </div>
        </aside>
      </div>

      <div class="content">
        <main>
          <?php
            print_content($_GET['page']);
          ?>
        </main>
      </div>

    </div> <!-- flexContainer div end -->

    <footer>
      <div class="footerGrid">
        <div class="firstOne">
        </div>
        <div class="middle">
          <span>© by <?php echo(get_config('author')); ?></span>
        </div>
        <div class="lastOne">
        </div>
      </div>
    </footer>
  </div>
</body>
</html>


<?php
  //Return from file if user is not signed in
  if(!isset($_SESSION['id_user'])) {
    header("Location: ../../index.php?page=login");
    exit();
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php print_name(); ?> | <?php echo(strtoupper($_GET['page'])); ?></title>
  <link rel="stylesheet" href="../../styles/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../styles/main.css">
  <script src="../../scripts/functions.js"></script>
  <script src="../../scripts/main.js"></script>
  <script src="../../scripts/html5-video-player.js"></script>
</head>
<body>
  <div class="errorBlock noselect">
    <div class="errorMsg">
      <span class="title">Type of notification</span>
      <span class="desc">Sample text</span>
      <button>OK</button>
    </div>
  </div>
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
                <img class="noselect" src="img/template_avatar.jpg" alt="avatar">
              </div>

              <div class="text">
                <span class="title"><?php print_userTitle(); ?></span>
                <span class="username"><?php print_username(); ?></span>
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
          <?php if($_GET['page'] == 'browse') {

            require(".../../php-backend/printVideo-script.php");
            echo '<div class="videosGrid">';
            generate_videos();
            echo '</div>';

          } else if ($_GET['page'] == 'video'){
            echo 'kek';
          } else {
            print_content($_GET['page']); 
          }
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


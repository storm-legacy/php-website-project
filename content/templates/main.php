<?php
  //Return from file if user is not signed in
  if(!isset($_SESSION['id_user'])) {
    header("Location: ../../index.php?page=login");
    exit();
  }

  //if user tries to access register and login page while logged
  if($_GET['page'] == "register" || $_GET['page'] == "login") {
    header("Location: ../../index.php?page=home");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php print_name(); ?> | <?php echo(strtoupper($_GET['page'])); ?></title>
  <link rel="stylesheet" href="../../styles/main.css">
  <script src="./scripts/anime.min.js"></script>
  <script type="module" src="./scripts/main.js"></script>
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
      <nav>
        <ul>
          <li><span class="icon upload uploadButton"></a></li>
        </ul>
        <ul>
          <li><span class="icon menu profileButton"></span></li>
        </ul>
        <div class="uploadBlock">
            <span class="icon upload"></span><span>Drop file to upload</span>
        </div>
        <div class="profileBlock">
          <div class="avatar">
            <img src="usr_files/avatars/<?php print_avatar(); ?>" alt="avatar">
          </div>
          <span class="title"><?php print_title(); ?></span>
          <span class="username">@<?php print_username(); ?></span>
          <div class="bottomNav">
            <a href="?page=profile"><span class="icon edit-profile"></span><span> Profile</span></a>
            <a class="logoutButton" href="?page=logout"><span class="icon logout"></span><span> Logout</span></a>
          </div>
        </div>
      </nav>
      <div class="secondBlock">
        <div class="searchBox">
          <input type="text" name="" id="">
          <span class="icon search"></span>
        </div>
      </div>
    </header>

    <main>
      <?php
        if(!isset($_GET['page']) || $_GET['page'] == "home") {
          print_content('browse');
        }
      ?>
    </main>

    <footer>
      <span>© by <?php echo(get_author()); ?></span>
    </footer>
  </div>


</body>
</html>